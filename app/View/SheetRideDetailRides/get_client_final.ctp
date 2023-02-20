<?php
echo "<div class='select-inline'  id='client-final-div'>" . $this->Form->input('SheetRideDetailRides.supplier_final_id', array(
        'label' => __('Final customer'),
        'empty' => __('Select client'),
        'id' => 'client_final',
        //'options' => $suppliers,
        'class' => 'form-filter select-search-client-final-i'
    )) . "</div>";