<?php

namespace Common\Helpers;
use Phalcon\Mvc\Model\Resultset;
use Vokuro\Models\Robots;

/**
 * Created by PhpStorm.
 * User: hbd
 * Date: 16/4/13
 * Time: 上午9:47
 */
class SQLHelper
{

    public static function test()
    {
        $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => "192.168.11.44",
            "username" => "root",
            "password" => "root",
            "dbname" => "hbd"
        ));

        //print_r(get_class_methods($connection)); //从支持的方法上看，只不过是在PDO上扩展了一些功能
        $connection->query('set names utf8');
        print_r2($connection);

        $t = $connection->fetchAll('select * from rp_debug', 1);
        print_r($t);
    }

    public static function findByRawSql($conditions, $params = null)
    {
        // A raw SQL statement
        $sql   = "SELECT * FROM robots WHERE $conditions";

        // Base model
        $robot = new Robots();

        // Execute the query
        return $robot->getReadConnection()->query($sql, $params);
    }

}