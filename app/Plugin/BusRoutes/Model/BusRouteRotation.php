<?php
App::uses('BusRoutesAppModel', 'BusRoutes.Model');
/**
 * BusRouteRotation Model
 *
 * @property BusRoute $BusRoute
 * @property BusRouteStop $BusRouteStop
 */
class BusRouteRotation extends BusRoutesAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'bus_route_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'bus_route_stop_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'time' => array(
			'time' => array(
				'rule' => array('time'),
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
		'BusRoute' => array(
			'className' => 'BusRoute',
			'foreignKey' => 'bus_route_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BusRouteStop' => array(
			'className' => 'BusRouteStop',
			'foreignKey' => 'bus_route_stop_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function getBusRouteRotations($busRouteId){
	    $rotations = $this->find('all',array(
	        'conditions' => array(
	            'BusRouteRotation.bus_route_id' => $busRouteId
            ),
            'order' => array(
                'BusRouteRotation.rotation_number' => 'ASC',
                'BusRouteRotation.rotation_schedule_number' => 'ASC',
                'BusRouteRotation.direction' => 'ASC',
                'BusRouteRotation.stop_order' => 'ASC',
            )
        ));
	    return $rotations;
    }

    public function getRotationsSchedules($data){
	    if (!empty($data)){
            foreach($data as $key => $datum){
                foreach ($datum['BusRotation']['BusRotationSchedule'] as $key2 => $schedule){
                    $rotationDeparture = $this->getSchedule( $schedule['id'], 0);
                    $rotationArrival = $this->getSchedule( $schedule['id'], 1);
                    $data[$key]['BusRotation']['BusRotationSchedule'][$key2]['DepartureSchedule'] = $rotationDeparture;
                    $data[$key]['BusRotation']['BusRotationSchedule'][$key2]['ArrivalSchedule'] = $rotationArrival;
                }
            }
        }
        return $data;
    }

    public function getSchedule($scheduleId, $arrival, $order = 'ASC'){
        $schedule = $this->find('all', array(
            'conditions' => array(
                'BusRouteRotation.bus_rotation_schedule_id' => $scheduleId,
                'BusRouteRotation.direction' => $arrival
            ),
            'order' => array(
                'BusRouteRotation.stop_order' => $order
            ),
            'recursive' => 0
        ));
        return $schedule;
    }

    public function getSchedulesRotations($schedules ,$routeType){
        foreach ($schedules as $key => $schedule){
            if ($routeType == '1'){
                $scheduleStops = $this->getSchedule( $schedule['BusRotationSchedule']['id'] , 0);
            }else{
                $departureScheduleStops = $this->getSchedule( $schedule['BusRotationSchedule']['id'] , 0);
                $arrivalScheduleStops = $this->getSchedule( $schedule['BusRotationSchedule']['id'] , 1,'DESC');
                $scheduleStops = array_merge($departureScheduleStops, $arrivalScheduleStops);
            }
            $schedules[$key]['BusRouteRotation'] = $scheduleStops;
        }
        return $schedules;
    }
}
