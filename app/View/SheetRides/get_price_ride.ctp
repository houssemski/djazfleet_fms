<?php 

	
if(isset($price)){
echo "<div  class='form-group '>" . $this->Form->input('SheetRideDetailRides.'.$i.'.unit_price', array(
                    'label' => __('Unit price'),
                    'class' => 'form-control',
					'value'=>$price,
                    'readonly'=>true,
                    'id'=>'unit_price',
				    'onchange'=>'javascript:calculPriceRide(this.id);',
                    
                )) . "</div>";
} else { ?>

<?php
echo "<div  class='form-group  '>" . $this->Form->input('SheetRideDetailRides.'.$i.'.unit_price', array(
                   'label' => __('Unit price'),
                    'class' => 'form-control',
					'readonly'=>true,
                    'id'=>'unit_price',
				    'onchange'=>'javascript:calculPriceRide(this.id);',
                    
            
                )) . "
<div style='color: #a94442; float'>".__('The price is empty')."</div>
</div>";?>




<?php } ?>