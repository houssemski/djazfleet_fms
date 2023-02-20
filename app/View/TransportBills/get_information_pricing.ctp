<?php
if($productId ==1) {
    if($typePricing == 2){
        echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.tonnage_id', array(
                'label' => '',
                'id' => 'tonnage'.$i,
                'onchange' => 'javascript:getPriceRide(this.id);',
                'class' => 'form-control select-search',
                'empty'=>__('Tonnage')
            )) . "</div>";
    }
}

