<?php
if($productId == 1){
    $options = array('1' => __('Simple delivery'), '2' => __('Simple return'), '3' => __('Delivery / Return'));
    echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.delivery_with_return', array(
            'label' => '',
            'id' => 'delivery_with_return'.$i,
            'onchange' => 'javascript:getPriceRide(this.id);',
            'value' => $deliveryWithReturn,
            'options' => $options,
            'class' => 'form-control select-search',
        )) . "</div>";
}