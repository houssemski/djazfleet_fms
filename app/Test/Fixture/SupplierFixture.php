<?php

class SupplierFixture extends CakeTestFixture
{
    public $import = array('model' => 'Supplier', 'records' => false);

    public $records = [
        [
            'id' => '289',
            'code' => '001',
            'name' => 'intellix',
            'adress' => 'Autoroute Douera, Douera, Algérie',
            'code_address' => NULL,
            'latlng' => '(36.6490943, 2.9275835999999344)',
            'latitude' => '36.6490943',
            'longitude' => '2.9275835999999344',
            'tel' => NULL,
            'nb_cars' => NULL,
            'note' => '',
            'created' => '2018-09-04 17:35:46',
            'modified' => '2018-09-16 17:00:21',
            'user_id' => '4',
            'last_modifier_id' => '1',
            'type' => '1',
            'if' => '',
            'ai' => '',
            'rc' => '',
            'nis' => '',
            'cb' => '',
            'social_reason' => 'eurl',
            'supplier_category_id' => '3',
            'town' => NULL,'state' => NULL,
            'email' => NULL,
            'contact' => NULL,
            'active' => '1',
            'balance' => '0',
            'final_customer' => '2',
            'automatic_order_validation' => '1'
        ]
    ];
}