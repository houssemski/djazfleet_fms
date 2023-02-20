<?php

App::uses('AppModel', 'Model');

/**
 *
 *
 * @property DetailRide $DetailRide
 */
class DetailRide extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */


    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(


        'ride_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'car_type_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),


    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $belongsTo = array(

        'Ride' => array(
            'className' => 'Ride',
            'foreignKey' => 'ride_id'
        ),
        'CarType' => array(
            'className' => 'CarType',
            'foreignKey' => 'car_type_id'
        ),
    );

    public $hasMany = array(
        'Price' => array(
            'className' => 'Price',
            'foreignKey' => 'detail_ride_id',
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
            'foreignKey' => 'detail_ride_id',
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
        'SheetRideDetailRides' => array(
            'className' => 'SheetRideDetailRides',
            'foreignKey' => 'detail_ride_id',
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
        'TransportBillDetailRides' => array(
            'className' => 'TransportBillDetailRides',
            'foreignKey' => 'detail_ride_id',
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
        'MissionCost' => array(
            'className' => 'MissionCost',
            'foreignKey' => 'detail_ride_id',
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

    /**
     * Get detail rides
     *
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $detailRides
     */
    public function getDetailRides($typeSelect = null, $recursive = null)
    {
        $this->virtualFields = array('cnames' => "CONCAT(DetailRide.wording,' - ',DepartureDestination.name, ' - ', ArrivalDestination.name, ' - ',CarType.name)");
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $wilayas = $this->find(
            $typeSelect,
            array(
                'order' => array('DepartureDestination.name ASC', 'ArrivalDestination.name ASC'),
                'recursive' => $recursive,
                'fields' => 'cnames',
                'joins' => array(
                    array(
                        'table' => 'rides',
                        'type' => 'left',
                        'alias' => 'Ride',
                        'conditions' => array('DetailRide.ride_id = Ride.id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'CarType',
                        'conditions' => array('DetailRide.car_type_id = CarType.id')
                    ),
                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'DepartureDestination',
                        'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                    ),
                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'ArrivalDestination',
                        'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                    )
                )
            )
        );
        return $wilayas;
    }

    public function getDetailRideByConditions($conditions = null, $typeSelect = null, $virtualFields = null)
    {

        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($virtualFields)) {
            $virtualFields = array('cnames' => "CONCAT(DetailRide.wording,' - ',DepartureDestination.name, ' - ', ArrivalDestination.name, ' - ',CarType.name)");
        }
        $this->virtualFields = $virtualFields;

        $detailRide = $this->find(
            $typeSelect,
            array(
                'order' => array(
                    'DetailRide.wording ASC',
                     'DepartureDestination.name ASC',
                    'ArrivalDestination.name ASC'
                ),
                'conditions' => $conditions,
                'recursive' => -1,
                'fields' => array('DetailRide.id', 'cnames','Ride.distance'),
                'joins' => array(
                    array(
                        'table' => 'rides',
                        'type' => 'left',
                        'alias' => 'Ride',
                        'conditions' => array('DetailRide.ride_id = Ride.id')
                    ),
                    array(
                        'table' => 'car_types',
                        'type' => 'left',
                        'alias' => 'CarType',
                        'conditions' => array('DetailRide.car_type_id = CarType.id')
                    ),
                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'DepartureDestination',
                        'conditions' => array('DepartureDestination.id = Ride.departure_destination_id')
                    ),
                    array(
                        'table' => 'destinations',
                        'type' => 'left',
                        'alias' => 'ArrivalDestination',
                        'conditions' => array('ArrivalDestination.id = Ride.arrival_destination_id')
                    )
                )
            )
        );
        return $detailRide;
    }

}
