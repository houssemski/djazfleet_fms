<?php
App::uses('Supplier', 'Model');
/**
 * Ride Test Case
 *
 * @property Ride $Ride
 */
class RideTestCase extends CakeTestCase
{
    public $fixtures = array('app.supplier');

    public function setUp() {
        parent::setUp();
        $this->Supplier = ClassRegistry::init('Supplier');
    }

    public function testcustomerOrderValidationMethod() {
        $result = $this->Supplier->customerOrderValidationMethod(289);
        $this->assertContains($result, [0, 1]);


    }
}