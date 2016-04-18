<?php
namespace Vokuro\Controllers;

use Vokuro\Models\Robots;
use Vokuro\Models\RobotsParts;


class RobotsController extends ControllerBase
{

    public function indexAction()
    {

        $rp = RobotsParts::find(1);

        echo "<pre>";
        $robots =  Robots::findFirst(1);
        foreach ($robots->robotsParts as $robotsParts) {
            /**
             * @var RobotsParts $robotsParts
             */
            print_r($robotsParts->toArray());

            print_r($robotsParts->robots->toArray());
       }



        $this->view->disable();

    }

}

