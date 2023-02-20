<?php
/**
 * BusRouteStop Fixture
 */
class BusRouteStopFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250, 'collate' => 'utf8mb4_bin', 'charset' => 'utf8mb4'),
		'lat' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
		'lng' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
		'department_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
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
			'name' => 'Lorem ipsum dolor sit amet',
			'lat' => 1,
			'lng' => 1,
			'department_id' => 1
		),
	);

}
