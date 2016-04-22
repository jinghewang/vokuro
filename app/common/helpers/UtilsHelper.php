<?php

namespace Common\Helpers;

/**
 * Created by PhpStorm.
 * User: hbd
 * Date: 16/4/13
 * Time: 下午6:58
 */
class UtilsHelper extends \Phalcon\Di\Injectable
{

    /**
     * 返回时间差
     * @param $date1 开始时间
     * @param $date2 结束时间
     * @return float|int
     */
    public static function getTimeDiff($date1,$date2)
    {
        try{
            $zero1=strtotime ($date1); //当前时间  ,注意H 是24小时 h是12小时
            $zero2=strtotime ($date2);  //过年时间，不能写2014-1-21 24:00:00  这样不对
            $guonian=ceil(($zero2-$zero1)/60); //60s*60min*24h
            return $guonian;
        }
        catch(\Exception $e){
            return -1;
        }
    }


    /**
     * 获取打印配置信息
     * @author wjh
     * @date 20160420
     * @param $key
     * @param null $defaultValue
     * @return null
     */
    public static function getPrinterConfig($key, $defaultValue = null)
    {
        return self::getConfigValue('printer',$key,$defaultValue);
    }

    /**
     * 获取配置信息
     * @author wjh
     * @date 20160420
     * @param $config 配置节
     * @param $key 健
     * @param null $defaultValue 默认值
     * @return null
     */
    public static function getConfigValue($config, $key, $defaultValue = null)
    {
        $di = \Phalcon\DI::getDefault();
        $params = $di->getShared('params');
        if (isset($params) && isset($params[$config]) && isset($params[$config][$key]))
            return $params[$config][$key];
        else
            return $defaultValue;

    }



    public static function print_r_m($models,$pre=true)
    {
        $data = [];
        foreach ($models as $item) {
            if ($item instanceof \Phalcon\Mvc\Model)
                $data[] = $item->toArray();
        }
        if ($pre)
            echo "<pre>";
        print_r($data);
        if ($pre)
            echo "</pre>";
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