<?php
namespace Vokuro\Controllers;

use Common\Helpers\UtilsHelper;
use Phalcon\Acl\Resource;
use Phalcon\Crypt;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Mvc\Url;
use Vokuro\Components\MyComponent;
use Vokuro\Components\OtherListener;
use Vokuro\Components\SomeListener;
use Vokuro\Models\Parts;
use Vokuro\Models\Robots;
use Vokuro\Models\RobotsParts;
use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
use Common\Bases\Exception as BaseException;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;


class TestController extends ControllerBase
{

    public function indexAction()
    {
        /**
         * @var RobotsParts $robotsParts
         */


        $crypt = new Crypt();
        // 使用 blowfish
        $crypt->setKey('%31.1e$i86e$f!8jz');

        $text  = 'This is a secret text';

        echo $crypt->encrypt($text);


        $acl = new AclList();
        $acl->setDefaultAction(\Phalcon\Acl::DENY);

        // 创建角色
        // The first parameter is the name, the second parameter is an optional description.
        $roleAdmins = new Role("Administrators", "Super-User role");
        $roleGuests = new Role("Guests");

        $acl->addRole($roleAdmins);
        $acl->addRole($roleGuests);

        $resource = new Resource('Test');
        $acl->addResource($resource,array('index','search'));

        $acl->allow("Guests", "Test", "search");
        $acl->allow("Guests", "Test", "create");
        $acl->deny("Guests", "Test", "update");



            $this->request->getBestLanguage();

//        $acl->isAllowed()




        $this->view->disable();

    }

    public function listAction()
    {
        /**
         * @var RobotsParts $robotsParts
         * @var RobotsParts $item
         * @var Robots $robots
         */

        echo "<pre>";
        $robots =  Robots::findFirst(1);
        $count = $robots->countRobotsParts();

        $robots = Robots::findByName('r1');
        UtilsHelper::print_r_m($robots);

        // Return every robot as an array
        $robots->setHydrateMode(Resultset::HYDRATE_ARRAYS);
        foreach ($robots as $robot) {
            echo $robot['year'], PHP_EOL;
        }

        // Return every robot as a stdClass
        $robots->setHydrateMode(Resultset::HYDRATE_OBJECTS);
        foreach ($robots as $robot) {
            echo $robot->year, PHP_EOL;
        }

        //
        $robots->setHydrateMode(Resultset::HYDRATE_RECORDS);
        foreach ($robots as $robot) {
            echo $robot->name, PHP_EOL;
        }

        die;

        $robotsParts = $robots->getRobotsParts([
            'conditions' => 'created_at=:created_at:',
            'bind' => ['created_at'=>'2016-04-18'],
            'limit' => 1,
        ]);


        UtilsHelper::print_r_m($robotsParts);

        UtilsHelper::print_m($robotsParts[0]->robots);

        $this->view->disable();

    }

    public function createAction()
    {
        //create
        $robots = new Robots();
        $robots->name = 'wjh';
        //$robots->year = date('y');
        $robots->type = 1;
        if ($robots->save()){
            echo '成功';
        }
        else{
            foreach ($robots->getMessages() as $message) {
                echo $message->getMessage();
            }
            echo '失败';
        }

        //count
        $count =Robots::count();
        echo "count:{$count}";
        $data = Robots::find([
            'order'=> 'id desc'
        ]);
        print_r_models($data);
    }

    public function countAction()
    {
        $robots = Robots::count();
        echo "count:{$robots}";
    }

    public function deleteAction()
    {
        $robots = Robots::find();
        $robots->delete(function($item){
           return $item->name == 'wjh';
        });
    }

    public function rewindAction()
    {
        $robots = Robots::find();
        $robots->rewind();
        while ($robots->valid()) {
            $robot = $robots->current();
            echo $robot->name, "\n";
            $robots->next();
        }
    }

    public function serializeAction()
    {
        $parts = Parts::find();
        file_put_contents('cache.txt',serialize($parts));
        //$parts = unserialize(file_get_contents('cache.txt'));

    }

    public function unserializeAction()
    {
        $parts = unserialize(file_get_contents('cache.txt'));
        foreach ($parts as $part) {
            echo $part->name;
        }
    }

    public function filterAction()
    {
        $robots = Robots::find()->filter(
            function ($robot) {
                if ($robot->name == 'r1')
                    return $robot;
            }
        );

        \Common\Helpers\UtilsHelper::print_r_m($robots,true);
    }

    public function titleAction()
    {

        $robots = Robots::findFirst();
        $slug = $robots->getSlug();
        //$robots->getChangedFields();
        var_dump($slug);
        die;
    }

    public function AnnoAction()
    {
        $reader = new MemoryAdapter();

        // 反射在Example类的注释
        $reflector = $reader->get('Vokuro\Models\Robots');

        // 读取类中注释块中的注释
        $annotations = $reflector->getPropertiesAnnotations();

        // 遍历注释
        foreach ($annotations as $annotation) {
            print_r2($annotation);
        }
    }

    public function txAction()
    {
        try {

            // Create a transaction manager
            $manager     = new TxManager();

            // Request a transaction
            $transaction = $manager->get();

            $robot              = new Robots();
            $robot->setTransaction($transaction);
            $robot->name        = "WALL·E";
            $robot->created_at  = date("Y-m-d");
            if ($robot->save() == false) {
                throw new BaseException('Cannot save robot',0,null,$robot);
                //$transaction->rollback("Cannot save robot");
            }

            $robotPart              = new RobotParts();
            $robotPart->setTransaction($transaction);
            $robotPart->robots_id   = $robot->id;
            $robotPart->type        = "head";
            if ($robotPart->save() == false) {
                throw new BaseException('Cannot save robot part',0,null,$robotPart);
                //$transaction->rollback("Cannot save robot part");
            }

            // Everything's gone fine, let's commit the transaction
            $transaction->commit();

        }
        catch(BaseException $be){
            foreach ($be->getModel()->getMessages() as $mesage) {
                echo $mesage->getMessage().PHP_EOL;
            }

        }
        catch (TxFailed $e) {
            echo "Failed, reason: ", $e->getMessage();
        }
    }

    public function queryAction()
    {
        $query = Robots::query()
            ->where("id>0")
            ->execute();

        print_r($query->toArray());
    }


    public function query2Action()
    {
        $query = new Model\Query("select * from Vokuro\Models\Robots where name=:name:", $this->getDI());
        $data = $query->execute(['name' => 'wjh']);
        UtilsHelper::print_r_m($data, true);

        $query = $this->modelsManager->createQuery("select * from Vokuro\Models\Robots where name=:name:");
        $data = $query->execute(['name' => 'wjh']);
        UtilsHelper::print_r_m($data,true);

        $data = $this->modelsManager->executeQuery("select * from Vokuro\Models\Robots where name=:name:",['name'=>'wjh']);
        UtilsHelper::print_r_m($data,true);

        $robots = $this->modelsManager->createBuilder()
            ->from('Vokuro\Models\Robots')
            ->join('Vokuro\Models\RobotsParts')
            ->orderBy('Vokuro\Models\Robots.name')
            ->getQuery()
            ->execute();
        UtilsHelper::print_r_m($robots);


    }

    public function query3Action()
    {
        $conditions='1=1';
        $params = null;
        // A raw SQL statement
        $sql   = "SELECT * FROM robots WHERE $conditions";

        // Base model
        $robot = new Robots();

        // Execute the query
        $result = $robot->getReadConnection()->query($sql, $params);
        $data = $result->fetchAll();
        print_r2($data);

        //apc_store()
    }

    public function metaDataAction()
    {
        $robot      = new Robots();
        $md = $robot->getModelsMetaData();
        print_r2($md->getStrategy());
    }


    //http://vokuro/robot-param/123/456?name=wjh
    public function paramAction($param1,$param2)
    {
        print_r2($this->request->get());
        print_r2($param1);
        print_r2($param2);
    }

    //http://vokuro/robot-param2/123/456?name=wjh
    public function param2Action($param1,$param2)
    {
        print_r2($this->dispatcher->getParams());
    }

    public function ComponentAction()
    {
        $eventManager = new EventsManager();
        $eventManager->attach('my-component',new SomeListener());
        $eventManager->attach('my-component',new OtherListener());
        //--
        $myComponet = new MyComponent();
        $myComponet->setEventsManager($eventManager);
        $myComponet->someTask();

        //$eventManager->fire('my-component',null);
    }

    public function urlAction(){
        $url = new Url();
        //echo $url->getBaseUri();

        echo $url->get('robots/param2');
    }

}

