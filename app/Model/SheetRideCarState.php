<?php

App::uses('AppModel', 'Model');

/**
 * CarStatus Model
 *
 * @property Car $Car
 */
class SheetRideCarState extends AppModel {

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

        'sheet_ride_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'car_state_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'car_state_value' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
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
          'CarState' => array(
              'className' => 'CarState',
              'foreignKey' => 'car_state_id',
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
            'SheetRide' => array(
              'className' => 'SheetRide',
              'foreignKey' => 'sheet_ride_id',
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


    /** get sheet ride car states by sheet ride id
     * @param $sheetRideId
     * @param $departure_arrival
     * @return array|null
     */
    public function getSheetRideCarStatesBySheetRideId($sheetRideId = null, $departure_arrival = null){
        $sheetRideCarStates = $this->find('all',
            array(
                    'conditions'=>array('SheetRideCarState.sheet_ride_id'=>$sheetRideId,
                                        'SheetRideCarState.departure_arrival  '=>$departure_arrival),
                    'order'=>array('SheetRideCarState.car_state_id ASC'),
                    'recursive'=>-1,
                    'fields'=>array(
                        'SheetRideCarState.id',
                        'SheetRideCarState.car_state_id',
                        'SheetRideCarState.car_state_value','SheetRideCarState.note',
                        'SheetRideCarState.attachment','CarState.name'),
                    'joins'=>array(
                        array(
                            'table' => 'car_states',
                            'type' => 'left',
                            'alias' => 'CarState',
                            'conditions' => array('CarState.id = SheetRideCarState.car_state_id')
                        ),
                    )
                )
        );
        return $sheetRideCarStates;
    }
}
