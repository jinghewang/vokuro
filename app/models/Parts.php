<?php

namespace Vokuro\Models;

/**
 * Class Parts
 * @package Vokuro\Models
 *
 * @property RobotsParts $robotsParts
 *
 */

class Parts extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("Parts");
        $this->hasMany('id','Vokuro\Models\RobotsParts','parts_id',['alias'=>'RobotsParts']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'Parts';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Parts[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Parts
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
