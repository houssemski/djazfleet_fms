<?php
if($selectingCouponsMethod==1) {
    echo "<div  class='select-inline'>" . $this->Form->input('Consumption.'.$i.'.nb_coupon', array(
            'label' => __('Nb coupons'),
            'placeholder' => __('Enter coupons number'),
            'class' => 'form-filter',
            'id' => 'coupons'.$i,
            'type'=>'number',
            'value' => $nbCouponExist,
            'onchange' => 'javascript:couponsToSelect(this.id);',

        )) . "</div>";
}else {
    echo "<div  class='select-inline '>" . $this->Form->input('Consumption.'.$i.'.nb_coupon', array(
            'label' => __('Nb coupons'),
            'placeholder' => __('Enter coupons number'),
            'class' => 'form-filter',
            'id' => 'coupons'.$i,
            'type'=>'number',
            'value' => $nbCouponExist,
            'onchange' => 'javascript: couponsSelectedFromFirstNumber(this.id);',
        )) . "</div>";

}

if($nbCoupon>$nbCouponExist){
    ?>
    <?php    echo "<div style='clear:both; padding-top: 10px;'></div>"; ?>
    <span id='con_coupon<?php echo $i ?>'> <p style="color: #a94442; padding-left:35px ;">       <?php  echo __('The number of coupon is below'); echo $nbCoupon;  echo ' '.__('coupons');  ?></p></span>
<?php } else {?>
    <span id='con_coupon<?php echo $i ?>'></span>
<?php }?>
