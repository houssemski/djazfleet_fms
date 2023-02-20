<?php
App::uses('BusRotationsWeekDay', 'BusRoutes.Model');

/**
 * BusRotationsWeekDay Test Case
 */
class BusRotationsWeekDayTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.bus_routes.bus_rotations_week_day',
		'plugin.bus_routes.bus_rotation'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BusRotationsWeekDay = ClassRegistry::init('BusRoutes.BusRotationsWeekDay');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BusRotationsWeekDay);

		parent::tearDown();
	}

}
