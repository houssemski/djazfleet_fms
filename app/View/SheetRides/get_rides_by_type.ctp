<?php

echo "<div  class='select-inline'>".$this->Form->input('SheetRideDetailRides.'.$i.'.detail_ride_id', array(
                'label' => __('Ride'),
                 'empty' =>'',
                 'id'=>'detail_ride'.$i,
                 'options'=>$detailRides,
				 'selected'=>$detail_ride_id,
                 'onchange'=>'javascript:getInformationRide(this.id);',
                'class' => 'form-filter select-search-detail-ride'
                ))."</div>";


if($useRideCategory == 2){
    echo "<div style='clear:both; padding-top: 10px;'></div>";
echo "<div class='select-inline'>".$this->Form->input('SheetRideDetailRides.'.$i.'.ride_category_id', array(
        'label' => __('Ride category'),
        'empty' =>__('Select category'),
        'id'=>'ride_category'.$i,
        'options'=>$rideCategories,
        'value'=>$ride_category_id,
        'onchange'=>'javascript:getMissionCost(this.id);',
        'class' => 'form-filter select2'
    ))."</div>";
}

echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.from_customer_order', array(
        'type' => 'hidden',
        'id' => 'from_customer_order' . $i,
        'value' => 2,
        'class' => 'form-control',
    )) . "</div>";

echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.type_ride', array(
        'type' => 'hidden',
        'id' => 'type_ride' . $i,
        'value' => 1,
        'class' => 'form-control',
    )) . "</div>";
?>