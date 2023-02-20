<?php
/**
 * GeofencesAlert Fixture
 */
class GeofencesAlertFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'tracker_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'geo_fence_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8mb4_bin', 'charset' => 'utf8mb4'),
		'created_at' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'lat' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
		'lng' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
		'alert_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
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
			'tracker_id' => 1,
			'geo_fence_id' => 1,
			'type' => 'Lorem ipsum dolor sit amet',
			'created_at' => '2022-12-04 16:32:09',
			'lat' => 1,
			'lng' => 1,
			'alert_id' => 1
		),
	);

}
