<?php
if($productId == 1){
    if($typePricing ==3){
        $options = array('1'=>__('Pricing by ride'),'2'=>__('Pricing by distance') );
        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_pricing', array(
                'id' => 'type_pricing'.$i,
                'options'=>$options,
                'label'=>false,
                'class'=>'form-control select-search',
                'onchange' => 'javascript:getInformationPricing(this.id);',
                'value' => 1,
            )) . "</div>";

    }else {
        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_pricing', array(
                'id' => 'type_pricing'.$i,
                'type' => 'hidden',
                'value' => $typePricing,
            )) . "</div>";
    }
}