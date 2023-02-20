<?php
echo "<div class='form-group' >".$this->Form->input('TankOperation.liter', array(
        'label' => __('Liter'),
        'placeholder' => __('Enter liter'),
        'class' => 'form-control',
        'value'=>$liter,
        'onchange'=>'javascript: verifyCapacity();',
        'id'=>'liter'
    ))."</div>";