<?php
echo "<div class='form-group'>".$this->Form->input('SheetRideDetailRides.'.$i.'.supplier_final_id', array(
        'label' => __('Final customer'),
        'empty'=>__('Select final customer'),
        'options'=>$finalSuppliers,
        'id'=>'client_final'.$i,
        'value'=>$supplierFinalId,
        'class' => 'form-control select-search-client-final-i',
    ))."</div>";