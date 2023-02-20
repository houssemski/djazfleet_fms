<?php
App::uses('BusRotation', 'BusRoutes.Model');

/**
 * BusRotation Test Case
 */
class BusRotationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.bus_routes.bus_rotation',
		'plugin.bus_routes.bus_rotation_schedule'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BusRotation = ClassRegistry::init('BusRoutes.BusRotation');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BusRotation);

		parent::tearDown();
	}

}
