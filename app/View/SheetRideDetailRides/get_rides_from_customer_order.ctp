<?php
if(isset($statusMission) && ($statusMission>7)){
    echo "<div >".$this->Form->input('SheetRideDetailRides.detail_ride_id', array(
            'label' => __('Ride'),
            'empty' =>'',
            'disabled' => true,
            'id'=>'detail_ride',
            'options'=>$detailRides,
            'selected'=>$transport_bill_detail_ride_id,
            'class' => 'form-filter select3'
        ))."</div>";


    echo "<div >".$this->Form->input('SheetRideDetailRides.detail_ride_id', array(
            'label' => __('Ride'),
            'empty' =>'',
            'id'=>'detail_ride',
            'options'=>$detailRides,
            'type' => 'hidden',
            'selected'=>$transport_bill_detail_ride_id,
            'class' => 'form-filter'
        ))."</div>";
}else {
    echo "<div >".$this->Form->input('SheetRideDetailRides.detail_ride_id', array(
            'label' => __('Ride'),
            'empty' =>'',
            'id'=>'detail_ride',
            'options'=>$detailRides,
            'onchange'=>'javascript:getInformationRide(this.id);',
            'selected'=>$transport_bill_detail_ride_id,
            'class' => 'form-filter select3'
        ))."</div>";
}

echo "<div >" . $this->Form->input('SheetRideDetailRides.from_customer_order', array(
        'type' => 'hidden',
        'id' => 'from_customer_order',
        'value' => 1,
        'class' => 'form-control',
    )) . "</div>";

echo "<div >" . $this->Form->input('SheetRideDetailRides.type_ride', array(
        'type' => 'hidden',
        'id' => 'type_ride',
        'value' => 1,
        'class' => 'form-control',
    )) . "</div>";

?>