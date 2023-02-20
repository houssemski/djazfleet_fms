<?php

class PriceFixture extends CakeTestFixture
{
    public $import = array('model' => 'Price', 'records' => false);

    public $records = [
        [
            'id' => '10',
            'wording' => 'test',
            'detail_ride_id' => '10',
            'supplier_id' => NULL,
            'supplier_category_id' => NULL,
            'created' => '2018-09-06 16:13:10',
            'modified' => '2018-09-06 16:13:10',
            'user_id' => '4',
            'last_modifier_id' => '4'
        ]
    ];
}
