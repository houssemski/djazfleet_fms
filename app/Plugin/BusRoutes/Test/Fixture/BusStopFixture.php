<?php
/**
 * BusStop Fixture
 */
class BusStopFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'bus_route_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'destination_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'lng' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
		'lat' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
		'stop_order' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
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
			'destination_id' => 1,
			'lng' => 1,
			'lat' => 1,
			'stop_order' => 1
		),
	);

}
