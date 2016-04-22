<?php
/**
 * Created by PhpStorm.
 * User: hbd
 * Date: 16/4/21
 * Time: 下午2:27
 */

namespace Common\traits;


trait MyTimestampable
{
    public function beforeValidationOnCreate()
    {
        $this->year = date('y');
    }

    public function beforeValidationOnUpdate()
    {
        $this->year = date('y');
    }

}