<?php
if (isset($price) && !empty($price)) {



        echo "<div class='form-group'>" . $this->Form->input('BillProduct.' . $i . '.unit_price', array(
                'label' => '',
                'class' => 'form-control',
                'value' => $price['ProductPrice']['price_ht'],
                'id' => 'price'.$i,
                'onchange' => 'javascript:calculPrice(this.id);',
            )) . "</div>";


  

} else { 

	 echo "<div class='form-group'>" . $this->Form->input('BillProduct.' . $i . '.unit_price', array(
            'label' => '',
			'value'=> 0,
            'class' => 'form-control',
            'id' => 'price'.$i,
             'onchange' => 'javascript:calculPrice(this.id);',
        )) . "</div>";?>

<?php
   
 } ?>

                