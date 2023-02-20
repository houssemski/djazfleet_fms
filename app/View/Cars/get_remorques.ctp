<?php

echo "<div    class='select-inline'>" . $this->Form->input('SheetRides.remorque_id', array(
        'label' => __('Car'),
        'class' => 'form-filter select-search-remorque',
        'empty' => '',
        'options'=>$cars,
        'value'=>$selectedId,
        'id' => 'remorques',
    )) . "</div>";