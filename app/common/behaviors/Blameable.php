<?php
/**
 * Created by PhpStorm.
 * User: hbd
 * Date: 16/4/21
 * Time: 下午1:24
 */

namespace Common\Behaviors;


use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\Model\BehaviorInterface;

class Blameable extends Behavior implements BehaviorInterface
{
    public function notify($type, \Phalcon\Mvc\ModelInterface $model)
    {
        parent::notify($type, $model);

        switch($type){
            case 'afterCreate':
            case 'afterDelete':
            case 'afterUpdate':

                $userName = 'wjh';

                // Store in a log the username, event type and primary key
                file_put_contents(__DIR__ . '/blamable-log.txt',
                    $userName . ' ' . $type . ' ' . $model->id
                );

                break;


            default:
                break;
        }
    }


}