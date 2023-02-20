<?php
App::uses('BusRouteRotation', 'BusRoutes.Model');

/**
 * BusRouteRotation Test Case
 */
class BusRouteRotationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.bus_routes.bus_route_rotation',
		'plugin.bus_routes.bus_route',
		'plugin.bus_routes.bus_route_stop'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BusRouteRotation = ClassRegistry::init('BusRoutes.BusRouteRotation');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BusRouteRotation);

		parent::tearDown();
	}

}
