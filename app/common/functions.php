<?php
/**
 * Created by PhpStorm.
 * User: hbd
 * Date: 16/4/20
 * Time: 下午11:08
 */


function print_r2($expression, $return = null){
    echo '<pre>';
    print_r($expression);
    echo '</pre>';
}


function print_r_models($expression, $return = null){
    /**
     * @var \Phalcon\Mvc\Model $v
     */
    echo '<pre>';
    $data = array();
    foreach ($expression as $k => $v) {
        $data[]= $v->toArray();
    }
    print_r($data);
    echo '</pre>';
}