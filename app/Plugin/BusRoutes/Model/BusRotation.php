<?php
App::uses('BusRoutesAppModel', 'BusRoutes.Model');
/**
 * BusRotation Model
 *
 * @property BusRotationSchedule $BusRotationSchedule
 */
class BusRotation extends BusRoutesAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'rotation_number' => array(
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
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'BusRotationSchedule' => array(
			'className' => 'BusRotationSchedule',
			'foreignKey' => 'bus_rotation_id',
			'dependent' => false,
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


	public function getRouteRotations($busRouteId){
	    $routeRotations = $this->find('all',array(
	        'conditions' => array(
	            'BusRotation.bus_route_id' => $busRouteId
            ),
            'order' => array(
                'BusRotation.rotation_number' => 'ASC',
                'BusRotationSchedule.schedule_number' => 'ASC'
            ),
            'recursive' => 2,
            'joins' => array(
                array(
                    'table' => 'bus_rotation_schedules',
                    'type' => 'left',
                    'alias' => 'BusRotationSchedule',
                    'conditions' => array('BusRotationSchedule.bus_rotation_id = BusRotation.id'),
                )
            ),
            'group' => array(
                'BusRotation.id',
            )
        ));
	    if (!empty($routeRotations)){
            foreach ($routeRotations as $key => $rotation){
                $routeRotations[$key]['BusRotation']['BusRotationSchedule'] = $rotation['BusRotationSchedule'];
                unset($routeRotations[$key]['BusRotationSchedule']);
            }
        }
	    return $routeRotations;
    }

    public function getTodayRouteRotation($busRouteId){

        $busRouteRotation = $this->find('first', array(
            'conditions' => array(
                'BusRotation.bus_route_id' => $busRouteId,
                'BusRotationsWeekDay.week_day' => date('w')
            ),
            'joins' => array(
                array(
                    'table' => 'bus_rotations_week_days',
                    'type' => 'left',
                    'alias' => 'BusRotationsWeekDay',
                    'conditions' => array('BusRotationsWeekDay.bus_rotation_id = BusRotation.id')
                )
            ),
        ));
        if (!empty($busRouteRotation)){
            return $busRouteRotation['BusRotation']['id'];
        }else{
            return null;
        }

    }

}
