<?php
App::uses('BusRouteStop', 'BusRoutes.Model');

/**
 * BusRouteStop Test Case
 */
class BusRouteStopTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.bus_routes.bus_route_stop',
		'plugin.bus_routes.department',
		'plugin.bus_routes.car',
		'plugin.bus_routes.car_status',
		'plugin.bus_routes.mark',
		'plugin.bus_routes.carmodel',
		'plugin.bus_routes.acquisition_type',
		'plugin.bus_routes.car_type',
		'plugin.bus_routes.car_type_car_category',
		'plugin.bus_routes.car_category',
		'plugin.bus_routes.user',
		'plugin.bus_routes.profile',
		'plugin.bus_routes.customer',
		'plugin.bus_routes.customer_category',
		'plugin.bus_routes.customer_group',
		'plugin.bus_routes.customer_car',
		'plugin.bus_routes.zone',
		'plugin.bus_routes.wilaya',
		'plugin.bus_routes.daira',
		'plugin.bus_routes.destination',
		'plugin.bus_routes.ride',
		'plugin.bus_routes.detail_ride',
		'plugin.bus_routes.price',
		'plugin.bus_routes.supplier',
		'plugin.bus_routes.service',
		'plugin.bus_routes.supplier_category',
		'plugin.bus_routes.tire',
		'plugin.bus_routes.tire_mark',
		'plugin.bus_routes.shifting',
		'plugin.bus_routes.location',
		'plugin.bus_routes.extinguisher',
		'plugin.bus_routes.moving',
		'plugin.bus_routes.recharge',
		'plugin.bus_routes.position',
		'plugin.bus_routes.verification',
		'plugin.bus_routes.bill',
		'plugin.bus_routes.bill_product',
		'plugin.bus_routes.lot',
		'plugin.bus_routes.product_unit',
		'plugin.bus_routes.product',
		'plugin.bus_routes.product_category',
		'plugin.bus_routes.product_family',
		'plugin.bus_routes.product_mark',
		'plugin.bus_routes.tva',
		'plugin.bus_routes.lot_type',
		'plugin.bus_routes.sheet_ride_detail_rides',
		'plugin.bus_routes.sheet_ride',
		'plugin.bus_routes.sheet_ride_detail_ride',
		'plugin.bus_routes.transport_bill',
		'plugin.bus_routes.ride_category',
		'plugin.bus_routes.transport_bill_category',
		'plugin.bus_routes.transport_bill_detail_rides',
		'plugin.bus_routes.transport_bill_detailed_rides',
		'plugin.bus_routes.marchandise',
		'plugin.bus_routes.marchandise_type',
		'plugin.bus_routes.marchandise_unit',
		'plugin.bus_routes.supplier_attachment_type',
		'plugin.bus_routes.attachment_type',
		'plugin.bus_routes.section',
		'plugin.bus_routes.section_action',
		'plugin.bus_routes.attachment',
		'plugin.bus_routes.contract',
		'plugin.bus_routes.contract_car_type',
		'plugin.bus_routes.supplier_contact',
		'plugin.bus_routes.supplier_address',
		'plugin.bus_routes.price_ride_category',
		'plugin.bus_routes.mission_cost',
		'plugin.bus_routes.car_option',
		'plugin.bus_routes.car_options_customer_car',
		'plugin.bus_routes.nationality',
		'plugin.bus_routes.parc',
		'plugin.bus_routes.affiliate',
		'plugin.bus_routes.audit',
		'plugin.bus_routes.rubric',
		'plugin.bus_routes.user_parc',
		'plugin.bus_routes.car_group',
		'plugin.bus_routes.fuel'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BusRouteStop = ClassRegistry::init('BusRoutes.BusRouteStop');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BusRouteStop);

		parent::tearDown();
	}

}
