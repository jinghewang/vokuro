<?php

namespace Vokuro\Components;

/**
 * Created by PhpStorm.
 * User: hbd
 * Date: 16/4/29
 * Time: 上午9:11
 */
class SomeListener
{

    public function beforeSomeTask($event, $myComponent)
    {
        echo "那里, beforeSomeTask\n";
    }

    public function afterSomeTask($event, $myComponent)
    {
        echo "那里, afterSomeTask\n";
    }

}