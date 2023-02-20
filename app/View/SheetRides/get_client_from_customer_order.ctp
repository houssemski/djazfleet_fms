<?php 
$i=$i+1;

echo "<div class='form-group' >".$this->Form->input('SheetRideDetailRides.'.$i.'.supplier_id', array(
                'label' => __('Initial customer').' '.$i,
                 'empty' =>'',
                 'id'=>'client',
				 'options'=>$suppliers,
                'onchange'=>'javascript:getInformationRide(this.id);',
                 'selected'=>$supplier_initials['Supplier']['id'],
                'class' => 'form-control',
                ))."</div>"; 
				if(!empty($supplier_finals)){
				echo "<div class='form-group '  >".$this->Form->input('SheetRideDetailRides.'.$i.'.supplier_final_id', array(
                'label' => __('Final customer').' '.$i,
                 'empty' =>'',
                 'id'=>'client_final',
				 'selected'=>$supplier_finals['Supplier']['id'],
                 'options'=>$suppliers,
                'class' => 'form-control',
                ))."</div>";
				}else {
				echo "<div class='form-group '  >".$this->Form->input('SheetRideDetailRides.'.$i.'.supplier_final_id', array(
                'label' => __('Final customer').' '.$i,
                 'empty' =>__('Select client'),
                 'id'=>'client_final',
                 'options'=>$suppliers,
                'class' => 'form-control',
                ))."</div>";
				}
?>