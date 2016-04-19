<?php

namespace Vokuro\Helpers;
use Phalcon\Paginator\Adapter\Model;

/**
 * Created by PhpStorm.
 * User: hbd
 * Date: 16/4/18
 * Time: 上午9:25
 */
class UtilsHelper
{

    public static function print_r_m($robotsParts)
    {
        $data = [];
        foreach ($robotsParts as $item) {
            if ($item instanceof \Phalcon\Mvc\Model)
                $data[] = $item->toArray();
        }
        print_r($data);
    }


    public static function print_m($model)
    {
        $data = [];
        if ($model instanceof \Phalcon\Mvc\Model)
            $data = $model->toArray();

        print_r($data);
    }

    public static function isModelArray($models)
    {
        foreach ($models as $item) {
            if (!($item instanceof \Phalcon\Mvc\Model))
                return false;
        }
        return true;
    }


}