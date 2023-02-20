<?php

if(!empty($supplier_finals)){
				echo "<div   >".$this->Form->input('SheetRideDetailRides.'.$i.'.supplier_final_id', array(
                'label' => __('Final customer'),
                 'empty' =>__('Select client'),
                 'id'=>'client_final',
				 'selected'=>$supplier_finals['Supplier']['id'],
                 'options'=>$suppliers,
				 'disabled'=>true,
                'class' => 'form-filter '
                ))."</div>";
				
					echo "<div   >".$this->Form->input('SheetRideDetailRides.'.$i.'.supplier_final_id', array(
                'label' => __('Final customer'),
                 'empty' =>__('Select client'),
                 'id'=>'client_final',
				 'type'=>'hidden',
				 'value'=>$supplier_finals['Supplier']['id'],
                 'options'=>$suppliers,
                'class' => 'form-filter'
                ))."</div>";
				}else {
    echo "<div   >".$this->Form->input('SheetRideDetailRides.'.$i.'.supplier_final_id', array(
            'label' => __('Final customer'),
            'empty' =>__('Select client'),
            'id'=>'client_final',
            'options'=>$suppliers,
            'disabled'=>true,
            'class' => 'form-filter '
        ))."</div>";

    echo "<div   >".$this->Form->input('SheetRideDetailRides.'.$i.'.supplier_final_id', array(
            'label' => __('Final customer'),
            'empty' =>__('Select client'),
            'id'=>'client_final',
            'type'=>'hidden',

            'options'=>$suppliers,
            'class' => 'form-filter'
        ))."</div>";
				}