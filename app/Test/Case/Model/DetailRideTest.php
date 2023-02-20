<?php
App::uses('DetailRide', 'Model');
/**
 * DetailRide Test Case
 *
 * @property DetailRide $DetailRide
 */
class DetailRideTestCase extends CakeTestCase
{
    public $fixtures = array('app.detail_ride');

    public function setUp() {
        parent::setUp();
        $this->DetailRide = ClassRegistry::init('DetailRide');
    }



}