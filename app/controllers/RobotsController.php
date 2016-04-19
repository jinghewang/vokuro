<?php
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset;
use Vokuro\Helpers\UtilsHelper;
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
        $robots->year = date('y');
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
    }

    public function countAction()
    {
        $robots = Robots::count();
        echo "count:{$robots}";
    }

}

