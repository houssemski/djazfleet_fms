<?php

echo "<div class='form-group' >".$this->Form->input('CarType.average_speed', array(
        'class' => 'form-control',
        'id'=>'average_speed',
        'value'=>$averageSpeed,
        'type'=>'hidden'
    ))."</div>";