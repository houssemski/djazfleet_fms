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
} else {
    if(isset($transport_bill_detail_ride_id)){
        echo "<div >".$this->Form->input('SheetRideDetailRides.detail_ride_id', array(
                'label' => __('Ride'),
                'id'=>'detail_ride',
                'type'=>'hidden',
                'value'=>$transport_bill_detail_ride_id,
                'class' => 'form-filter'
            ))."</div>";
        if(isset($statusMission) && ($statusMission<= StatusEnum::mission_closed)) {

            echo "<div class='form-group col-sm-6 clear-none p-l-20'>" . $this->Form->input('SheetRideDetailRides.departure_destination_id', array(
                    'label' => __('Departure city'),
                    'id' => 'departure_destination' ,
                    'value' =>$transportBillDetailRide['TransportBillDetailRides']['departure_destination_id'],
                    'options'=>$departures,
                    'class' => 'form-filter select-search-destination'
                )) . "</div>";

            echo "<div class='form-group col-sm-6 clear-none p-l-20'>" . $this->Form->input('SheetRideDetailRides.arrival_destination_id', array(
                    'label' => __('Arrival city'),
                    'id' => 'arrival_destination' ,
                    'value' =>$transportBillDetailRide['TransportBillDetailRides']['arrival_destination_id'],
                    'options'=>$arrivals,
                    'class' => 'form-filter select-search-destination'
                )) . "</div>";

        }else {

            echo "<div class='form-group col-sm-6 clear-none p-l-20'>" . $this->Form->input('SheetRideDetailRides.departure_destination_id', array(
                    'label' => __('Departure city'),
                    'id' => 'departure_destination' ,
                    'disabled' => true,
                    'value' =>$transportBillDetailRide['TransportBillDetailRides']['departure_destination_id'],
                    'options'=>$departures,
                    'class' => 'form-filter select-search-destination'
                )) . "</div>";
            echo "<div >" . $this->Form->input('SheetRideDetailRides.departure_destination_id', array(
                    'label' => __('Departure city'),
                    'id' => 'departure_destination',
                    'value' =>$transportBillDetailRide['TransportBillDetailRides']['departure_destination_id'],
                    'options'=>$departures,
                    'type'=>'hidden',
                    'class' => 'form-filter'
                )) . "</div>";

            echo "<div class='form-group col-sm-6 clear-none p-l-20'>" . $this->Form->input('SheetRideDetailRides.arrival_destination_id', array(
                    'label' => __('Arrival city'),
                    'id' => 'arrival_destination' ,
                    'value' =>$transportBillDetailRide['TransportBillDetailRides']['arrival_destination_id'],
                    'options'=>$arrivals,
                    'disabled' => true,
                    'class' => 'form-filter select-search-destination'
                )) . "</div>";
            echo "<div class='form-group col-sm-6 clear-none p-l-20'>" . $this->Form->input('SheetRideDetailRides.arrival_destination_id', array(
                    'label' => __('Arrival city'),
                    'id' => 'arrival_destination',
                    'type'=>'hidden',
                    'value' =>$transportBillDetailRide['TransportBillDetailRides']['arrival_destination_id'],
                    'options'=>$arrivals,
                    'class' => 'form-filter'
                )) . "</div>";


        }


    }else {
        echo "<div >".$this->Form->input('SheetRideDetailRides.detail_ride_id', array(
                'label' => __('Ride'),
                'empty' =>'',
                'id'=>'detail_ride',
                'options'=>$detailRides,
                'onchange'=>'javascript:getInformationRide(this.id);',
                'class' => 'form-filter select3'
            ))."</div>";
    }



}

echo "<div >" . $this->Form->input('SheetRideDetailRides.from_customer_order', array(
        'type' => 'hidden',
        'id' => 'from_customer_order' ,
        'value' => 1,
        'class' => 'form-control',
    )) . "</div>";

echo "<div >" . $this->Form->input('SheetRideDetailRides.type_ride', array(
        'type' => 'hidden',
        'id' => 'type_ride' ,
        'value' => 2,
        'class' => 'form-control',
    )) . "</div>";



?>