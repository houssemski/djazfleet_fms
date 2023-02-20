<?php

switch ($initialCustomer){
    case 1:
	
        echo "<div class='form-group'>".$this->Form->input('FinalSupplierInitialSupplier.initial_supplier_id', array(
                'label' => __('Initial customer'),
                'empty'=>__('Select initial customer'),
                'options'=>$initialSuppliers,
                'multiple'=>'multiple',
                'required'=>true,
                'id'=>'initial_supplier_id',
                'class' => 'form-control select2',
            ))."</div>";
        break;
    case 2 :
	echo "<div class='form-group'>".$this->Form->input('Supplier.automatic_order_validation', array(
                    'label' => __('Automatic order validation'),
                    'class' => 'form-control',
                    ))."</div>";
        break;
    case 3 :
	echo "<div class='form-group'>".$this->Form->input('Supplier.automatic_order_validation', array(
                    'label' => __('Automatic order validation'),
                    'class' => 'form-control',
                    ))."</div>";
        echo "<div class='form-group'>".$this->Form->input('FinalSupplierInitialSupplier.initial_supplier_id', array(
                'label' => __('Initial customer'),
                'empty'=>__('Select initial customer'),
                'options'=>$initialSuppliers,
                'multiple'=>'multiple',
                //'required'=>true,
                'id'=>'initial_supplier_id',
                'class' => 'form-control select2',
            ))."</div>";
        break;
}
if($initialCustomer == 1){

}else{

}