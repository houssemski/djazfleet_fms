<?php
if(isset($statusMission) && ($statusMission>7)){
    echo "<div >".$this->Form->input('SheetRideDetailRides.'.$i.'.detail_ride_id', array(
            'label' => __('Ride'),
            'empty' =>'',
            'disabled' => true,
            'id'=>'detail_ride'.$i,
            'options'=>$detailRides,
            'selected'=>$transport_bill_detail_ride_id,
            'class' => 'form-filter select3'
        ))."</div>";

    echo "<div >".$this->Form->input('SheetRideDetailRides.'.$i.'.detail_ride_id', array(
            'label' => __('Ride'),
            'empty' =>'',
            'id'=>'detail_ride'.$i,
            'options'=>$detailRides,
            'type' => 'hidden',
            'selected'=>$transport_bill_detail_ride_id,
            'class' => 'form-filter'
        ))."</div>";
} else {
  if(isset($transport_bill_detail_ride_id)){
      echo "<div >".$this->Form->input('SheetRideDetailRides.'.$i.'.detail_ride_id', array(
              'label' => __('Ride'),
              'id'=>'detail_ride'.$i,
              'type'=>'hidden',
              'value'=>$transport_bill_detail_ride_id,
              'class' => 'form-filter'
          ))."</div>";
      if(isset($statusMission) && ($statusMission<= StatusEnum::mission_closed)) {

          echo "<div class='form-group col-sm-6 clear-none p-l-20'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.departure_destination_id', array(
                  'label' => __('Departure city'),
                  'id' => 'departure_destination' . $i,
                  'value' =>$transportBillDetailRide['TransportBillDetailRides']['departure_destination_id'],
                  'options'=>$departures,
                  'class' => 'form-filter select-search-destination'
              )) . "</div>";

          echo "<div class='form-group col-sm-6 clear-none p-l-20'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.arrival_destination_id', array(
                  'label' => __('Arrival city'),
                  'id' => 'arrival_destination' . $i,
                  'value' =>$transportBillDetailRide['TransportBillDetailRides']['arrival_destination_id'],
                  'options'=>$arrivals,
                  'class' => 'form-filter select-search-destination'
              )) . "</div>";

      }else {

          echo "<div class='form-group col-sm-6 clear-none p-l-20'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.departure_destination_id', array(
                  'label' => __('Departure city'),
                  'id' => 'departure_destination' . $i,
                  'disabled' => true,
                  'value' =>$transportBillDetailRide['TransportBillDetailRides']['departure_destination_id'],
                  'options'=>$departures,
                  'class' => 'form-filter select-search-destination'
              )) . "</div>";
          echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.departure_destination_id', array(
                  'label' => __('Departure city'),
                  'id' => 'departure_destination' . $i,
                  'value' =>$transportBillDetailRide['TransportBillDetailRides']['departure_destination_id'],
                  'options'=>$departures,
                  'type'=>'hidden',
                  'class' => 'form-filter'
              )) . "</div>";

          echo "<div class='form-group col-sm-6 clear-none p-l-20'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.arrival_destination_id', array(
                  'label' => __('Arrival city'),
                  'id' => 'arrival_destination' . $i,
                  'value' =>$transportBillDetailRide['TransportBillDetailRides']['arrival_destination_id'],
                  'options'=>$arrivals,
                  'disabled' => true,
                  'class' => 'form-filter select-search-destination'
              )) . "</div>";
          echo "<div class='form-group col-sm-6 clear-none p-l-20'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.arrival_destination_id', array(
                  'label' => __('Arrival city'),
                  'id' => 'arrival_destination' . $i,
                  'type'=>'hidden',
                  'value' =>$transportBillDetailRide['TransportBillDetailRides']['arrival_destination_id'],
                  'options'=>$arrivals,
                  'class' => 'form-filter'
              )) . "</div>";


      }


  }else {
      echo "<div >".$this->Form->input('SheetRideDetailRides.'.$i.'.detail_ride_id', array(
              'label' => __('Ride'),
              'empty' =>'',
              'id'=>'detail_ride'.$i,
              'options'=>$detailRides,
			   'onchange'=>'javascript:getInformationRide(this.id);',
              'class' => 'form-filter select3'
          ))."</div>";
  }



}

echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.from_customer_order', array(
        'type' => 'hidden',
        'id' => 'from_customer_order' . $i,
        'value' => 1,
        'class' => 'form-control',
    )) . "</div>";

echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.type_ride', array(
        'type' => 'hidden',
        'id' => 'type_ride' . $i,
        'value' => 2,
        'class' => 'form-control',
    )) . "</div>";



?>