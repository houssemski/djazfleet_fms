<?php
App::uses('CarType', 'Model');

/**
 * Car Type Test Case
 *
 * @property CarType $CarType
 */
class CarTypeTestCase extends CakeTestCase
{
    public $fixtures = array('app.car_type');

    public function setUp() {
        parent::setUp();
        $this->CarType = ClassRegistry::init('CarType');
    }

    public function testGetCarTypes() {
        $result = $this->CarType->getCarTypes();
        $this->assertInternalType('array',$result);

    }
}