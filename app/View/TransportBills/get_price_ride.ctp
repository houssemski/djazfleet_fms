<?php

if (isset($price) && !empty($price)) {
	if($profileId == ProfilesEnum::client) {
		  if ($deliveryWithReturn == 1) {
        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
                'label' => '',
				'type'=> 'hidden',
                'class' => 'form-control',
                'value' => $price[0],
                'id' => 'unit_price'.$i,
                'onchange' => 'javascript:calculatePriceRide(this.id); ',
            )) . "</div>";
    } else {
        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
                'label' => '',
				'type'=> 'hidden',
                'class' => 'form-control',
                'value' => $price[1],
                'id' => 'unit_price'.$i,
                'onchange' => 'javascript:calculatePriceRide(this.id);',
            )) . "</div>";
    }
	} else {
		  if ($deliveryWithReturn == 1) {
        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
                'label' => '',
                'class' => 'form-control',
                'value' => $price[0],
                'id' => 'unit_price'.$i,
                'onchange' => 'javascript:calculatePriceRide(this.id); ',
            )) . "</div>";
    } else {
        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
                'label' => '',
                'class' => 'form-control',
                'value' => $price[1],
                'id' => 'unit_price'.$i,
                'onchange' => 'javascript:calculatePriceRide(this.id);',
            )) . "</div>";
    }
	}
} else { 

if($profileId == ProfilesEnum::client) {
	 echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
            'label' => '',
			'type'=> 'hidden',
			'value'=> 0,
            'class' => 'form-control',
            'id' => 'unit_price'.$i,
            'onchange' => 'javascript:calculatePriceRide(this.id);',
        )) . "</div>";
	
}else {
	 echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
            'label' => '',
			'value'=> 0,
            'class' => 'form-control',
            'id' => 'unit_price'.$i,
            'onchange' => 'javascript:calculatePriceRide(this.id);',
        )) . "</div>";?>

<?php }
   
 } ?>

                