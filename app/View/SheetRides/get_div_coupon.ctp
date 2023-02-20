<?php if($selectingCouponsMethod==1) {
?>
<div id='consump_coupon' class="select-inline">
    <?php    echo "<div class='select-inline'>" . $this->Form->input('SheetRide.coupons_number', array(
            'label' => __('Nb coupons'),
            'type'=>'number',

            'class' => 'form-filter',
            'id' => 'coupons',

            'onchange' => 'javascript:couponsToSelect(),addRadioBoxChecked(this.id);'

        )) . "</div>"; ?>
    <span id='con_coupon'> </span>
</div>

<?php
echo "<div  id='coupon-div'  ></div>";

}else { ?>

    <div id='consump_coupon' class="select-inline">
        <?php    echo "<div class='select-inline'>" . $this->Form->input('SheetRide.coupons_number', array(
                'label' => __('Nb coupons'),
                'type'=>'number',

                'class' => 'form-filter',
                'id' => 'coupons',

                'onchange' => 'javascript:couponsSelectedFromFirstNumber(),addRadioBoxChecked(this.id);'

            )) . "</div>"; ?>
        <span id='con_coupon'> </span>
    </div>


    <?php
    echo "<div id='number_coupon_div'>";
    echo "<div class='select-inline'>" . $this->Form->input('SheetRide.first_number_coupon', array(
            'label' => __('From'),

            'class' => 'form-filter',
           // 'readonly' =>  true,
            'onchange' => 'javascript:couponsSelectedFromFirstNumber();',
            'id' => 'first_number_coupon',
        )) . "</div>";

    echo "<div class='select-inline'>" . $this->Form->input('SheetRide.last_number_coupon', array(
            'label' => __('To'),
            'readonly' =>  true,
            'class' => 'form-filter',
            'id' => 'last_number_coupon',
        )) . "</div>";
    echo "</div>";


}