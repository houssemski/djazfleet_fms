<?php
echo "<div class='select-inline' >" . $this->Form->input('SheetRide.car_type_id', array(
        'label' => __('Transportation'),
        'class' => 'form-filter select3',
        'empty' => '',
        'value'=>$carTypeId,
        'options'=>$carTypes,
        'id' => 'car_type',
    )) . "</div>";