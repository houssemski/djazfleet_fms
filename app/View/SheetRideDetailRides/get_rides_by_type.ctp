<?php

echo "<div  class='select-inline'>".$this->Form->input('SheetRideDetailRides.detail_ride_id', array(
        'label' => __('Ride'),
        'empty' =>'',
        'id'=>'detail_ride',
        'options'=>$detailRides,
        'selected'=>$detail_ride_id,
        'onchange'=>'javascript:getInformationRide(this.id);',
        'class' => 'form-filter select-search-detail-ride'
    ))."</div>";


if($useRideCategory == 2){
    echo "<div style='clear:both; padding-top: 10px;'></div>";
    echo "<div class='select-inline'>".$this->Form->input('SheetRideDetailRides.ride_category_id', array(
            'label' => __('Ride category'),
            'empty' =>__('Select category'),
            'id'=>'ride_category',
            'options'=>$rideCategories,
            'value'=>$ride_category_id,
            'onchange'=>'javascript:getMissionCost(this.id);',
            'class' => 'form-filter select2'
        ))."</div>";
}

echo "<div >" . $this->Form->input('SheetRideDetailRides.from_customer_order', array(
        'type' => 'hidden',
        'id' => 'from_customer_order' ,
        'value' => 2,
        'class' => 'form-control',
    )) . "</div>";

echo "<div >" . $this->Form->input('SheetRideDetailRides.type_ride', array(
        'type' => 'hidden',
        'id' => 'type_ride' ,
        'value' => 1,
        'class' => 'form-control',
    )) . "</div>";
?>