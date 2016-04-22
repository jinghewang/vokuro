<?php
namespace Vokuro\Controllers;

use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset;
use Vokuro\Helpers\UtilsHelper;
use Vokuro\Models\Parts;
use Vokuro\Models\Robots;
use Vokuro\Models\RobotsParts;


class RobotsController extends ControllerBase
{

    public function indexAction()
    {
        /**
         * @var RobotsParts $robotsParts
         */

        echo "<pre>";
        $robots =  Robots::findFirst(1);

        //方式1
        foreach ($robots->robotsParts as $robotsParts) {
            print_r($robotsParts->toArray());
            print_r($robotsParts->robots->name);
       }

        //方式2
        foreach ($robots->getRobotsParts() as $robotsParts) {
            print_r($robotsParts->toArray());
            print_r($robotsParts->getRobots()->toArray());
        }


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

    public function queryAction()
    {
        $query = Robots::query()
            ->where("id>0")
            ->execute();

        print_r($query->toArray());
    }

    public function metaDataAction()
    {
        $robot      = new Robots();
        $md = $robot->getModelsMetaData();
        print_r2($md->getStrategy());
    }

}

