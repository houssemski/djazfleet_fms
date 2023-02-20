<?php
App::uses('BusRoutesAppModel', 'BusRoutes.Model');
/**
 * BusStop Model
 *
 * @property BusRoute $BusRoute
 * @property Destination $Destination
 */
class BusStop extends BusRoutesAppModel {

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
		'destination_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lng' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lat' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'stop_order' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'geo_fence_id' => array(
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
			'order' => '',
            'dependent' => true
		),
		'BusRouteStop' => array(
			'className' => 'BusRouteStops',
			'foreignKey' => 'bus_route_stop_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	public function getRouteBusStops($busRouteId, $routeType){
	    if ($routeType == '1'){
            $busStops = $this->find('all', array(
                'conditions' => array('BusStop.bus_route_id' => $busRouteId ),
                'fields' => array(
                    'BusStop.id',
                    'BusStop.geo_fence_id',
                    'BusRouteStop.name',
                    'BusRouteStop.lat',
                    'BusRouteStop.lng',
                    'BusRouteStop.geo_fence_id',
                ),
                'recursive' => 2,
                'order' => array(
                    'BusStop.stop_order' => 'ASC'
                )
            ));
        }else{
            $busStopsDeparture = $this->find('all', array(
                'conditions' => array('BusStop.bus_route_id' => $busRouteId ),
                'fields' => array(
                    'BusStop.id',
                    'BusStop.geo_fence_id',
                    'BusRouteStop.name',
                    'BusRouteStop.lat',
                    'BusRouteStop.lng',
                    'BusRouteStop.geo_fence_id',
                ),
                'recursive' => 2,
                'order' => array(
                    'BusStop.stop_order' => 'ASC'
                )
            ));
            $busStopsArrival = $this->find('all', array(
                'conditions' => array('BusStop.bus_route_id' => $busRouteId ),
                'fields' => array(
                    'BusStop.id',
                    'BusStop.geo_fence_id',
                    'BusRouteStop.name',
                    'BusRouteStop.lat',
                    'BusRouteStop.lng',
                    'BusRouteStop.geo_fence_id',
                ),
                'recursive' => 2,
                'order' => array(
                    'BusStop.stop_order' => 'DESC'
                )
            ));
            $busStops = array_merge($busStopsDeparture, $busStopsArrival);
        }
        return $busStops;
    }
}
