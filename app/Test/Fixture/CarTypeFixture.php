<?php

class CarTypeFixture extends CakeTestFixture
{
    public $import = array('model' => 'CarType', 'records' => false);

    public $records = [
        [
            'id' => '10',
            'name' => 'Camion semi-remorque',
            'average_speed' => '60',
            'created' => '2018-09-06 16:13:10',
            'modified' => '2018-09-06 16:13:10',
            'user_id' => '4',
            'last_modifier_id' => '4'
        ]
    ];
}
