<?php


echo "<div  >".$this->Form->input('SheetRideDetailRides.supplier_id', array(
        'label' => __('Initial customer'),
        'empty' =>__('Select client'),
        'id'=>'client',
        'options'=>$suppliers,
        'disabled'=>true,
        'onchange'=>'javascript:getInformationRide(), getMarchandisesByClient(), getAttachmentsByClient();',
        'selected'=>$supplier_initials['Supplier']['id'],
        'class' => 'form-filter'
    ))."</div>";

echo "<div  >".$this->Form->input('SheetRideDetailRides.supplier_id', array(
        'label' => __('Initial customer'),
        'empty' =>__('Select client'),
        'id'=>'client',
        'type'=>'hidden',
        'options'=>$suppliers,
        'onchange'=>'javascript:getInformationRide(this.id);',
        'value'=>$supplier_initials['Supplier']['id'],
        'class' => 'form-filter'
    ))."</div>";
?>