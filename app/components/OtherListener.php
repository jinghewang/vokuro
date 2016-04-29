<?php

namespace Vokuro\Components;

/**
 * Created by PhpStorm.
 * User: hbd
 * Date: 16/4/29
 * Time: 上午9:11
 */
class OtherListener
{

    public function beforeSomeTask($event, $myComponent)
    {
        echo "这里, beforeSomeTask\n";
    }

    public function afterSomeTask($event, $myComponent)
    {
        echo "这里, afterSomeTask\n";
    }

}