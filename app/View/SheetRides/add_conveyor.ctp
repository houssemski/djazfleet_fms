<?php
echo "<div   class='select-inline'>" . $this->Form->input('SheetRideConveyor.'.$i.'.conveyor_id', array(
        'label' => __('Conveyor'),
        'empty' => '',
        'class' => 'form-filter select-search-conveyor'
    )) . "</div>";