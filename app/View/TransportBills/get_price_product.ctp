<?php
if (isset($price) && !empty($price)) {
	if($profileId == ProfilesEnum::client) {


        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
                'label' => '',
				'type'=> 'hidden',
                'class' => 'form-control',
                'value' => $price['ProductPrice']['price_ht'],
                'id' => 'unit_price'.$i,
                'onchange' => 'javascript:calculatePriceRide(this.id);',
            )) . "</div>";

	} else {


        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
                'label' => '',
                'class' => 'form-control',
                'value' => $price['ProductPrice']['price_ht'],
                'id' => 'unit_price'.$i,
                'onchange' => 'javascript:calculatePriceRide(this.id);',
            )) . "</div>";

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

                