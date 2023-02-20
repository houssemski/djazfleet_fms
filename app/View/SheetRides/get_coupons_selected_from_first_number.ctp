<style>
    .select2 {
        width: 84% !important;
    }

    </style>

<?php

echo $this->Form->input('nb_coupon', array(
    'type' =>  'hidden',
    'value'=>$nbCoupon,
    'id' => 'nb_coupon'.$i,
)) ;
if($nbCoupon>0){




if(isset($firstCoupon) && isset($lastCoupon)) {
echo "<div class='select-inline'>" . $this->Form->input('Consumption.'.$i.'.first_number_coupon', array(
    'label' => __('From'),
    'placeholder' => __(''),
    'class' => 'form-filter',
     'value'=>$firstCoupon,
    'id' => 'first_number_coupon'.$i,
        'onchange' => 'javascript:couponsSelectedFromFirstNumber(this.id);'
    )) . "</div>";

echo "<div class='select-inline'>" . $this->Form->input('Consumption.'.$i.'.last_number_coupon', array(
    'label' => __('To'),
    'readonly' =>  true,
     'value'=>$lastCoupon,
    'class' => 'form-filter',
    'id' => 'last_number_coupon'.$i,
    )) . "</div>";

    if(!empty($firstNumber)&& empty($couponId)){
        ?>
        <?php    echo "<div style='clear:both; padding-top: 10px;'></div>"; ?>
        <span id='condition-first-number<?php echo $i ?>'> <p style="color: #a94442;">       <?php  echo __('The serial number you entered does not exist or already used.');  ?></p></span>
    <?php } else {?>
        <span id='condition-first-number<?php echo $i ?>'></span>
    <?php }

    $couponsToSelect= array();
    foreach ($couponsSelected as $coupon ) {
        $couponsToSelect[]= $coupon['Coupon']['id'];

    } ?>




<div  class="select-inline-3 hidden" style ='width: 65%;'>
        <div class="input select "  >
            <label for="serial_number<?php echo $i ?>"><?=__('Nb Serial')?></label>
<select name="data[Consumption][<?php echo $i ?>][serial_numbers][]" class="form-filter selectCoupon"  id="serial_number<?php echo $i ?>"  multiple="multiple">
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
echo "<div class='select-inline-3'>" . $this->Form->input('Consumption.'.$i.'.first_number_coupon', array(
        'label' => __('From'),
        'placeholder' => __(''),
        'class' => 'form-filter',
        'id' => 'first_number_coupon'.$i,
        'onchange' => 'javascript:couponsSelectedFromFirstNumber(this.id);'
    )) . "</div>";

echo "<div class='select-inline-3'>" . $this->Form->input('Consumption.'.$i.'.last_number_coupon', array(
        'label' => __('To'),
        'readonly' =>  true,

        'class' => 'form-filter',
        'id' => 'last_number_coupon'.$i,
    )) . "</div>";

    if(!empty($firstNumber)&& empty($couponId)){
        ?>
        <?php    echo "<div style='clear:both; padding-top: 10px;'></div>"; ?>
        <span id='condition-first-number<?php echo $i ?>'> <p style="color: #a94442;">       <?php  echo __('The serial number you entered does not exist');  ?></p></span>
    <?php } else {?>
        <span id='condition-first-number<?php echo $i ?>'></span>
    <?php }

 ?>
<div  class="select-inline-3 hidden" style ='width: 65%;'>
    <div class="input select "  >
        <label for="serial_number<?php echo $i ?>"><?=__('Nb Serial')?></label>
        <select name="data[Consumption][<?php echo $i ?>][serial_numbers][]" class="form-filter selectCoupon"  id="serial_number<?php echo $i ?>"  multiple="multiple">
            <option value=""><?=__('Select coupons')?></option>



        </select>
    </div>
</div>

<?php } ?>