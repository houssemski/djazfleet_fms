<?php
/**
 * BusRouteRotation Fixture
 */
class BusRouteRotationFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'bus_route_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'bus_route_stop_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'time' => array('type' => 'time', 'null' => false, 'default' => null),
		'week_day' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_bin', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'bus_route_id' => 1,
			'bus_route_stop_id' => 1,
			'time' => '11:55:55',
			'week_day' => 1
		),
	);

}
