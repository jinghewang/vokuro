<?php
namespace Vokuro\Models;

/**
 * Class RobotsParts
 * @package Vokuro\Models
 *
 * @property Robots $robots
 * @property Parts $parts
 */

class RobotsParts extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $robots_id;

    /**
     *
     * @var integer
     */
    public $parts_id;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("Robots_Parts");
        $this->belongsTo('robots_id','Vokuro\Models\Robots','id',['alias'=>'Robots']);
        $this->belongsTo('parts_id','Vokuro\Models\Parts','id',['alias'=>'Parts']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'Robots_Parts';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RobotsParts[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RobotsParts
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
