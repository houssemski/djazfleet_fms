<?php
App::uses('Price', 'Model');
/**
 * Price Test Case
 *
 * @property Price $Price
 * @property PriceRideCategory $PriceRideCategory
 */
class PriceTestCase extends CakeTestCase
{
    public $fixtures = array('app.price_ride_category', 'app.price');

    public function setUp() {
        parent::setUp();
        $this->Price = ClassRegistry::init('Price');
    }

    public function testGetPriceByParams() {
        $result = $this->Price->getPriceByParams(10, 255, null);
        $this->assertInternalType('array',$result);

        $result = $this->Price->getPriceByParams(10, null, null);
        $this->assertInternalType('array',$result);

        $result = $this->Price->getPriceByParams(11, 255, null);
        $this->assertEmpty($result);

    }

}