<?php
/**
 * BusRoute Fixture
 */
class BusRouteFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'route_title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250, 'collate' => 'utf8mb4_bin', 'charset' => 'utf8mb4'),
		'car_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'customer_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
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
			'route_title' => 'Lorem ipsum dolor sit amet',
			'car_id' => 1,
			'customer_id' => 1
		),
	);

}
