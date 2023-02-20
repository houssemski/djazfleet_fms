<?php 


echo "<div  >".$this->Form->input('SheetRideDetailRides.'.$i.'.supplier_id', array(
                'label' => __('Initial customer'),
                 'empty' =>__('Select client'),
                 'id'=>'client'.$i,
				 'options'=>$suppliers,
				 'disabled'=>true,
                'onchange'=>'javascript:getInformationRide(this.id), getMarchandisesByClient(this.id), getAttachmentsByClient(this.id);',
                 'selected'=>$supplier_initials['Supplier']['id'],
                'class' => 'form-filter'
                ))."</div>"; 
				
echo "<div  >".$this->Form->input('SheetRideDetailRides.'.$i.'.supplier_id', array(
                'label' => __('Initial customer'),
                 'empty' =>__('Select client'),
                 'id'=>'client'.$i,
				 'type'=>'hidden',
				 'options'=>$suppliers,
                'onchange'=>'javascript:getInformationRide(this.id);',
                 'value'=>$supplier_initials['Supplier']['id'],
                'class' => 'form-filter'
                ))."</div>"; 
?>