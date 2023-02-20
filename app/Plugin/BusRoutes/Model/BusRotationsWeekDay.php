<?php
App::uses('BusRoutesAppModel', 'BusRoutes.Model');
/**
 * BusRotationsWeekDay Model
 *
 * @property BusRotation $BusRotation
 */
class BusRotationsWeekDay extends BusRoutesAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'bus_rotation_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'week_day' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'BusRotation' => array(
			'className' => 'BusRotation',
			'foreignKey' => 'bus_rotation_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	public function getRotationsWeekDays($data){
	    foreach ($data as $key => $datum){
            $weekDays = $this->getRotationWeekDays($datum['BusRotation']['id']);
            $data[$key]['BusRotation']['WeekDays'] = $weekDays;
        }
	    return $data;
    }

    public function getRotationWeekDays($rotationId){
	    $weekDaysArray = array();
	    $rotationWeekDays = $this->find('all',array(
	        'conditions' => array(
	            'BusRotationsWeekDay.bus_rotation_id' => $rotationId
            ),
            'order' => array(
                'BusRotationsWeekDay.week_day' => 'ASC'
            ),
            'recursive' => -1
        ));
	    foreach ($rotationWeekDays as $rotationWeekDay){
	        array_push($weekDaysArray, $rotationWeekDay['BusRotationsWeekDay']['week_day']);
        }

	    return $weekDaysArray;
    }
}
