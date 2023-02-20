<?php
if($response ==1){
    echo "<div class='form-group col-sm-4' >" . $this->Form->input('TransportBill.supplier_various', array(
            'label' => __('Client'),
            'id'=>'supplier_various',
            //'type'=>'hidden',
            'class' => 'form-control',
        )) . "</div>";
}