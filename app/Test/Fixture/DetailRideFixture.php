<?php

class DetailRideFixture extends CakeTestFixture
{
    public $import = array('model' => 'DetailRide', 'records' => false);

    public $records = [
        [
            'id' => '3',
            'wording' => 'test',
            'ride_id' => '10',
            'car_type_id' => '10',
            'duration_hour' => '17',
            'duration_day' => '0',
            'duration_minute' => '41',
            'real_duration_day' => '1',
            'real_duration_hour' => '16',
            'real_duration_minute ' => '14',
            'distance' => '0',
            'created' => '2018-09-06 16:13:10',
            'modified' => '2018-09-06 16:13:10',
            'user_id' => '4',
            'last_modifier_id' => '4'
        ]
    ];
}
