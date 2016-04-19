<?php
namespace Vokuro\Models;

/**
 * Class Robots
 * @package Vokuro\Models
 *
 * @property RobotsParts $robotsParts
 * @property Parts $parts
 */

class Robots extends \Phalcon\Mvc\Model
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
     *
     * @var string
     */
    public $type;

    /**
     *
     * @var integer
     */
    public $year;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("Robots");
        $this->hasMany('id','Vokuro\Models\RobotsParts','robots_id',[
            'alias'=>'RobotsParts',
            'foreignKey' => array(
                //'action' => Relation::ACTION_CASCADE
                //"allowNulls" => true,
                //"message"    => "The part_id does not exist on the Parts model"
            )
        ]);
        $this->hasManyToMany('id', 'Vokuro\Models\RobotsParts', 'robots_id', 'parts_id', 'Parts', 'id',['alias'=>'Parts']);
    }

    public function getCount($parameterss = null)
    {
        return self::count([
            "distinct" => "area",
            "group" => "area",
            "order" => "rowcount",
            //"type > ?0",
            //"bind" => array($type),
        ]);
    }



    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'Robots';
    }


    /**
     * @param $arguments
     * @return \Vokuro\Models\Parts[]
     */
    public function getParts($arguments)
    {
        return $this->getRelated('Parts',$arguments);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Robots[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Robots
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
