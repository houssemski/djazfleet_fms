<?php

class PriceRideCategoryFixture extends CakeTestFixture
{
    public $import = array('model' => 'PriceRideCategory', 'records' => false);

    public $records = [
        [
            'id' => '6',
            'price_id' => '10',
            'ride_category_id' => '0',
            'price_ht' => '3000000',
            'price_ht_night' => null,
            'price_return' => '0',
            'pourcentage_price_return' => null
        ]
    ];

}