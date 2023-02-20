<style>
    .select2 {
        width: 84% !important;
    }

    </style>

<?php

echo $this->Form->input('nb_coupon', array(
    'type' =>  'hidden',
    'value'=>$nbCoupon,
    'id' => 'nb_coupon',
)) ;
if($nbCoupon>0){




if(isset($firstCoupon) && isset($lastCoupon)) {
echo "<div class='col-sm-2'>" . $this->Form->input('Consumption.first_number_coupon', array(
    'label' => __('From'),
    'placeholder' => __(''),
    'class' => 'form-control',
     'value'=>$firstCoupon,
    'id' => 'first_number_coupon',
        'onchange' => 'javascript:couponsSelectedFromFirstNumber(this.id);'
    )) . "</div>";

echo "<div class='col-sm-2'>" . $this->Form->input('Consumption.last_number_coupon', array(
    'label' => __('To'),
    'readonly' =>  true,
     'value'=>$lastCoupon,
    'class' => 'form-control',
    'id' => 'last_number_coupon',
    )) . "</div>";

    if(!empty($firstNumber)&& empty($couponId)){
        ?>
        <?php    echo "<div style='clear:both; padding-top: 10px;'></div>"; ?>
        <span id='condition-first-number'> <p style="color: #a94442;">       <?php  echo __('The serial number you entered does not exist or already used.');  ?></p></span>
    <?php } else {?>
        <span id='condition-first-number'></span>
    <?php }

    $couponsToSelect= array();
    foreach ($couponsSelected as $coupon ) {
        $couponsToSelect[]= $coupon['Coupon']['id'];

    } ?>




<div  class="select-inline-3 hidden" style ='width: 65%;'>
        <div class="input select "  >
            <label for="serial_number"><?=__('Nb Serial')?></label>
<select name="data[Consumption][serial_numbers][]" class="form-filter selectCoupon"  id="serial_number"  multiple="multiple">
    <option value=""><?=__('Select coupons')?></option>

    <?php
    foreach ($coupons as $qsKey => $qsData) {
        $selected=0;

        foreach ($couponsToSelect as $csKey => $csData){

            if($selected==0){
                if((int)$qsKey==$csData){

                    $selected=1;
                }
            }

        }
        if($selected==1){
            echo '<option selected="selected" value="'.$qsKey.'">'.$qsData.'</option>'."\n";
        } else {
            echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
        }
    }
    ?>

</select>
</div>
</div>
<?php }

}else {
echo "<div class='col-sm-2'>" . $this->Form->input('Consumption.first_number_coupon', array(
        'label' => __('From'),
        'placeholder' => __(''),
        'class' => 'form-control',
        'id' => 'first_number_coupon',
        'onchange' => 'javascript:couponsSelectedFromFirstNumber(this.id);'
    )) . "</div>";

echo "<div class='col-sm-2'>" . $this->Form->input('Consumption.last_number_coupon', array(
        'label' => __('To'),
        'readonly' =>  true,

        'class' => 'form-control',
        'id' => 'last_number_coupon',
    )) . "</div>";

    if(!empty($firstNumber)&& empty($couponId)){
        ?>
        <?php    echo "<div style='clear:both; padding-top: 10px;'></div>"; ?>
        <span id='condition-first-number'> <p style="color: #a94442;">       <?php  echo __('The serial number you entered does not exist');  ?></p></span>
    <?php } else {?>
        <span id='condition-first-number'></span>
    <?php }

 ?>
<div  class=" hidden" style ='width: 65%;'>
    <div class="input select "  >
        <label for="serial_number"><?=__('Nb Serial')?></label>
        <select name="data[Consumption][serial_numbers][]" class="form-filter selectCoupon"  id="serial_number"  multiple="multiple">
            <option value=""><?=__('Select coupons')?></option>



        </select>
    </div>
</div>

<?php } ?>