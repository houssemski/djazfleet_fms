<?php
if(Configure::read("utranx_trm") == '1'){
    echo "<div  class='form-group col-sm-12 ' id ='div-invoice'>" . $this->Form->input('TransportBill.invoice_id', array(
            'label' => __('Invoices'),
            'empty' => '',
            'required'=>true,
            'id'=>'invoice_id',
            'class' => 'form-control select-search',
        )) . "</div>";

}else{
    echo "<div  class='form-group col-sm-12 ' id ='div-invoice'>" . $this->Form->input('TransportBill.invoice_id', array(
            'label' => __('Invoices'),
            'empty' => '',
            'required'=>true,
            'id'=>'invoice_id',
            'onchange' => 'javascript:getInformationInvoice(this.id);',
            'class' => 'form-control select-search',
        )) . "</div>";
}