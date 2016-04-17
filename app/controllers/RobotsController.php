<?php
namespace Vokuro\Controllers;



use Vokuro\Models\Robots;
use Vokuro\Models\RobotsParts;

class RobotsController extends ControllerBase
{

    public function indexAction()
    {
        echo "<pre>";
        $robots = Robots::findFirst(1);
        foreach ($robots->RobotsParts as $parts) {
            print_r($parts->toArray());
       }


        $this->view->disable();

    }

}

