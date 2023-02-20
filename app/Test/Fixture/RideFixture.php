<?php

class RideFixture extends CakeTestFixture
{
    public $import = array('model' => 'Ride', 'records' => false);

    public $records = [
        [
            'id' => '3',
            'wording' => 'test',
            'departure_destination_id' => '1',
            'arrival_destination_id' => '51',
            'distance' => '1455',
            'created' => '2018-09-06 16:13:10',
            'modified' => '2018-09-06 16:13:10',
            'user_id' => '4',
            'last_modifier_id' => '4'
        ]
    ];
}
