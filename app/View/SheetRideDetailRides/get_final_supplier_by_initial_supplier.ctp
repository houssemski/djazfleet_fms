<?php
echo "<div class='form-group'>".$this->Form->input('SheetRideDetailRides.supplier_final_id', array(
        'label' => __('Final customer'),
        'empty'=>__('Select final customer'),
        'options'=>$finalSuppliers,
        'id'=>'client_final',
        'value'=>$supplierFinalId,
        'class' => 'form-control select-search-client-final-i',
    ))."</div>";