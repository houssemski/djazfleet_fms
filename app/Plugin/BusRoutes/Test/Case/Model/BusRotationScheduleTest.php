<?php
App::uses('BusRotationSchedule', 'BusRoutes.Model');

/**
 * BusRotationSchedule Test Case
 */
class BusRotationScheduleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.bus_routes.bus_rotation_schedule',
		'plugin.bus_routes.bus_rotation',
		'plugin.bus_routes.bus_route_rotation'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BusRotationSchedule = ClassRegistry::init('BusRoutes.BusRotationSchedule');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BusRotationSchedule);

		parent::tearDown();
	}

}
