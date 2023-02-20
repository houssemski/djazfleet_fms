<?php
App::uses('Car', 'Model');
/**
 * Car Test Case
 *
 * @property Car $Car
 */
class CarTestCase extends CakeTestCase
{
    public $fixtures = array('app.car');

    public function setUp() {
        parent::setUp();
        $this->Car = ClassRegistry::init('Car');
    }

    public function testGetNotNullCodes() {
        $result = $this->Car->getNotNullCodes();

            $this->assertInternalType('array',$result);

    }

}