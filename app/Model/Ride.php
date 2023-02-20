<?php
App::uses('AppModel', 'Model');

/**
 * Ride Model
 *
 *
 */
class Ride extends AppModel
{

    public $displayField = 'wording';
    public $validate = array(

        'departure_destination_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'arrival_destination_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),

            ),
        ),
        'distance' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),

            ),
        ),

    );

    public $hasMany = array(

        'DetailRide' => array(
            'className' => 'DetailRide',
            'foreignKey' => 'ride_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'TransportBill' => array(
            'className' => 'TransportBill',
            'foreignKey' => 'ride_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),

    );

    public $belongsTo = array(

        'DepartureDestination' => array(
            'className' => 'Destination',
            'foreignKey' => 'departure_destination_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ArrivalDestination' => array(
            'className' => 'Destination',
            'foreignKey' => 'arrival_destination_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

    );

    /**
     * Get ride by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array $ride
     */
    public function getRideByForeignKey($id, $modelField)
    {
        $ride = $this->find(
            'first',
            array(
                'conditions'=>array($modelField => $id),
                'fields' => array('Ride.id'),
                'recursive'=>-1
            ));
        return $ride;
    }

}
