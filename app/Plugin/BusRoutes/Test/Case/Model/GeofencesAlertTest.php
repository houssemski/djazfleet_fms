<?php
App::uses('GeofencesAlert', 'BusRoutes.Model');

/**
 * GeofencesAlert Test Case
 */
class GeofencesAlertTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.bus_routes.geofences_alert',
		'plugin.bus_routes.tracker',
		'plugin.bus_routes.geo_fence',
		'plugin.bus_routes.alert'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->GeofencesAlert = ClassRegistry::init('BusRoutes.GeofencesAlert');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->GeofencesAlert);

		parent::tearDown();
	}

}
