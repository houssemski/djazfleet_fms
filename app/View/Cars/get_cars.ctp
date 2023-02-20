<?php

echo "<div    class='select-inline'>" . $this->Form->input('SheetRides.car_id', array(
        'label' => __('Car'),
        'class' => 'form-filter select-search-car',
        'empty' => '',
        'onchange' => 'javascript: carChanged(this.id) ;',
        'options'=>$cars,
        'value'=>$selectedId,
        'id' => 'cars',
    )) . "</div>";