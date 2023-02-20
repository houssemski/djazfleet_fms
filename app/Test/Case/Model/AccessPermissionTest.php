<?php
App::uses('AccessPermission', 'Model');
/**
 * Ride Test Case
 *
 * @property Ride $Ride
 */
class RideTestCase extends CakeTestCase
{
    public $fixtures = array('app.access_permission');

    public function setUp() {
        parent::setUp();
        $this->AccessPermission = ClassRegistry::init('AccessPermission');
    }

    public function testGetPermissionWithParams() {
        $result = $this->AccessPermission->getPermissionWithParams(78,1,11);
        $this->assertContains($result, [0, 1]);


    }
}