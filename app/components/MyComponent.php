<?php
namespace Vokuro\Components;

use Phalcon\Events\EventsAwareInterface;
use Phalcon\Events\ManagerInterface;

/**
 * Created by PhpStorm.
 * User: hbd
 * Date: 16/4/29
 * Time: 上午9:06
 */
class MyComponent implements EventsAwareInterface
{

    protected $_eventsManager;

    public function setEventsManager(ManagerInterface $eventsManager)
    {
        $this->_eventsManager = $eventsManager;
    }

    public function getEventsManager()
    {
        return $this->_eventsManager;
    }


    public function someTask()
    {
        $this->_eventsManager->fire("my-component:beforeSomeTask", $this);

        // 做一些你想做的事情
        echo "这里, someTask\n";

        $this->_eventsManager->fire("my-component:afterSomeTask", $this);
    }

}