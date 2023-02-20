<?php
App::uses('BusRoutesAppModel', 'BusRoutes.Model');
/**
 * BusRotationSchedule Model
 *
 * @property BusRotation $BusRotation
 * @property BusRouteRotation $BusRouteRotation
 */
class BusRotationSchedule extends BusRoutesAppModel {

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
		'schedule_number' => array(
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

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'BusRouteRotation' => array(
			'className' => 'BusRouteRotation',
			'foreignKey' => 'bus_rotation_schedule_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

    public function getRotationSchedules($busRotationId){
        $rotationSchedules = $this->find('all',array(
            'conditions' => array(
                'BusRotationSchedule.bus_rotation_id' => $busRotationId,
            ),
            'recursive' => 0
        ));
        return $rotationSchedules;
    }

}
