<?php
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset;
use Vokuro\Helpers\UtilsHelper;
use Vokuro\Models\Robots;
use Vokuro\Models\RobotsParts;


class DebugController extends ControllerBase
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

    public function phpAction()
    {
        phpinfo();
        $this->view->disable();
    }

    public function createAction()
    {

    }

}

