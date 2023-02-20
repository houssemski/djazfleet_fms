<?php
echo "<div  >" . $this->Form->input('SheetRide.consumption_liter', array(
        'placeholder'=>__('Enter liter'),
        'label' => __('Consumption liter'),
        'class' => 'form-filter',
        'id' => 'liter',
        'value'=>$quantity,
        'onchange' => 'javascript:couponChanged(this);'
    )) . "</div>";

if($liter>$quantity){
    ?>
    <?php    echo "<div style='clear:both; padding-top: 10px;'></div>"; ?>
    <span id='con_liter'> <p style="color: #a94442;">       <?php  echo __('The quantity of fuel in the tank is below'); echo $liter;  echo ' '.__('L');  ?></p></span>
<?php } else {?>
    <span id='con_liter'></span>
<?php }?>