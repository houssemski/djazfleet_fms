<?php
echo "<div class='form-group'>".$this->Form->input('TransportBill.supplier_final_id', array(
        'label' => __('Final customer'),
        'empty'=>'',
        'options'=>$finalSuppliers,
        'id'=>'client_final',
        'class' => 'form-control select-search',
    ))."</div>";