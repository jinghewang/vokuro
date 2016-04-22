<?php

/**
 * Created by PhpStorm.
 * User: hbd
 * Date: 16/4/6
 * Time: 下午3:35
 */
namespace Common\Bases;

class Exception extends \Exception
{

    protected $model;

    public function __construct($message = "", $code = 0, \Exception $previous = null,$model = null)
    {
        \Exception::__construct($message, $code, $previous);

        //参数处理
        if ($model)
            $this->model = $model;
    }


    /**
     * @return \Phalcon\Mvc\Model
     */
    public function getModel() {
        return $this->model;
    }

}