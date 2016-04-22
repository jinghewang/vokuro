<?php
namespace Vokuro\Models;


use Common\Behaviors\Blameable;
use Common\Behaviors\Sluggable;
use Common\traits\MyTimestampable;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Model\Validator\Inclusionin;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Class Robots
 * @package Vokuro\Models
 *
 * @property RobotsParts $robotsParts
 * @property Parts $parts
 */

class Robots extends \Phalcon\Mvc\Model
{

    use MyTimestampable;

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
     * @var integer
     */
    public $year;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("Robots");

        //behaviors
        $this->addBehavior(new Blameable());


        //$this->keepSnapshots(true);

        //event
        $eventsManager = new EventsManager();
        $eventsManager->attach('model',function($event,$robot){
            /**
             * @var \Phalcon\Events\Manager $event
             * @var \Vokuro\Models\Robots $robot
             */
            if ($event->getType() == 'beforeSave'){
                if ($robot->name == 'Scooby Doo') {
                    echo "Scooby Doo isn't a robot!";
                    return false;
                }
            }
            return true;
        });
        // Attach the events manager to the event
        $this->setEventsManager($eventsManager);

        //relations
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

    public function validation()
    {
//        $this->validate(new InclusionIn([
//            'field'=>'type',
//            'domain'=>["Mechanical", "Virtual"],
//        ]));

//        $this->validate(new Uniqueness([
//            'field'=>'name',
//            'message' => 'name is unique',
//        ]));

        return !$this->validationHasFailed();
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

    public function beforeSave()
    {

    }

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'name' => 'name',
            'type' => 'type',
            'year' => 'year'
        );
    }

}
