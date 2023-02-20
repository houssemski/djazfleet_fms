<?php
if($productId == 1){
    if($typeRideParameter ==3){

        $options = array('1'=>__('Existing ride'),'2'=>__('Personalized ride') );

        if(($typeRide=='null')){
            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                    'id' => 'type_ride'.$i,
                    'options'=>$options,
                    'label'=>false,
                    'class'=>'form-control select-search',
                    'onchange' => 'javascript:getInformationProduct(this.id);',
                    'value' => $typeRideUsedFirst,
                )) . "</div>";
        }else {
            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                    'id' => 'type_ride'.$i,
                    'options'=>$options,
                    'label'=>false,
                    'class'=>'form-control select-search',
                    'onchange' => 'javascript:getInformationProduct(this.id);',
                    'value' => $typeRide,
                )) . "</div>";
        }


    } else {
        if(($typeRide=='null')){
            echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                    'id' => 'type_ride'.$i,
                    'type' => 'hidden',
                    'value' => $typeRideUsedFirst,
                    'empty'=>'',
                )) . "</div>";
        }else {
            echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                    'id' => 'type_ride'.$i,
                    'type' => 'hidden',
                    'value' => $typeRide,
                    'empty'=>'',
                )) . "</div>";
        }

    }
}