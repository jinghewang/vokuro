<?php
namespace Common\Behaviors;

use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\Model\BehaviorInterface;

/**
 * Created by PhpStorm.
 * User: hbd
 * Date: 16/4/21
 * Time: 下午1:15
 */
class Sluggable extends Behavior implements BehaviorInterface
{
    public function missingMethod(\Phalcon\Mvc\ModelInterface $model, $method, $arguments = null)
    {
        parent::missingMethod($model, $method, $arguments);

        if ($method == 'getSlub'){
            return \Phalcon\Tag::friendlyTitle($method->name);
        }
    }


}