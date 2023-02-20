<?php
App::uses('SheetRideDetailRides', 'Model');
/**
 * SheetRideDetailRides Test Case
 *
 * @property SheetRideDetailRides $SheetRideDetailRides
 */
class SheetRideDetailRidesTestCase extends CakeTestCase
{
    public $fixtures = array('app.sheet_ride_detail_rides');

    public function setUp() {
        parent::setUp();
        $this->SheetRideDetailRides = ClassRegistry::init('SheetRideDetailRides');
    }

    public function testGetLastMissionStatus() {
        $result = $this->SheetRideDetailRides->getLastMissionStatus(2);
        $expected = 4 ;

        $this->assertEquals($expected, $result);
    }

}