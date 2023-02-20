<?php
App::uses('Ride', 'Model');
/**
 * Ride Test Case
 *
 * @property Ride $Ride
 */
class RideTestCase extends CakeTestCase
{
    public $fixtures = array('app.ride');

    public function setUp() {
        parent::setUp();
        $this->Ride = ClassRegistry::init('Ride');
    }



}