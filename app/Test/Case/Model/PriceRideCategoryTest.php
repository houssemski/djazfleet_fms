<?php
App::uses('PriceRideCategory', 'Model');
/**
 * PriceRideCategory Test Case
 *
 * @property PriceRideCategory $PriceRideCategory
 */
class PriceRideCategoryTestCase extends CakeTestCase
{
    public $fixtures = array('app.price_ride_category');

    public function setUp() {
        parent::setUp();
        $this->PriceRideCategory = ClassRegistry::init('PriceRideCategory');
    }

}