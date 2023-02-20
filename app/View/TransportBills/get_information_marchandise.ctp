<?php 
if(isset($quantity_min)){
echo "<div class='form-group  '>" . $this->Form->input('Price.'.$i.'.quantity_min', array(
                    'label' => '',
                    'class' => 'form-control',
					'value'=>$quantity_min,
                    'id'=>'price_qty_min'.$i,
                    'type'=>'hidden',
                )) . "</div>";
} else {
echo "<div class='form-group  '>" . $this->Form->input('Price.'.$i.'.quantity_min', array(
                    'label' => '',
                    'class' => 'form-control',
					
                    'id'=>'price_qty_min'.$i,
                    'type'=>'hidden',
                )) . "</div>";



}
if(isset($price_ht)){
echo "<div class='form-group  '>" . $this->Form->input('Price.'.$i.'.price_ht', array(
                    'label' => '',
                    'class' => 'form-control',
					'value'=>$price_ht,
                    'id'=>'price_price_ht'.$i,
                    'type'=>'hidden',
                )) . "</div>";
}else { ?>
<p style='color: #a94442;'><?= __('The price of this merchandise for this ride is empty');?></p>
<?php
echo "<div class='form-group  '>" . $this->Form->input('Price.'.$i.'.price_ht', array(
                    'label' => '',
                    'class' => 'form-control',
					
                    'id'=>'price_price_ht'.$i,
                    'type'=>'hidden',
                )) . "</div>";




}

                ?>