<?php
if($typeRide == 2){
    echo "<div >" . $this->Form->input('Simulation.type_ride', array(
            'class' => 'form-control',
            'type'=>'hidden',
            'value'=>$typeRide,
            'id'=>'type_ride'
        )) . "</div>";
    echo "<div class='form-group col-sm-2 clear-none p-l-0'>" . $this->Form->input('Simulation.departure_destination_id', array(
            'label' => __('Departure city'),
            'class' => 'form-control select-search-destination',
            'id'=>'departure_destination'
        )) . "</div>";
    echo "<div class='form-group col-sm-2 clear-none p-l-0'>" . $this->Form->input('Simulation.car_type_id', array(
            'label' => __('Type'),
            'class' => 'form-control select-search',
            'empty' => '',
            'id' => 'car_type',
        )) . "</div>";
    echo "<div class='form-group col-sm-2 clear-none p-l-0'>" . $this->Form->input('Simulation.supplier_final_id', array(
            'label' => __('Final customer'),
            'empty' => '',
            'id' => 'client_final',
            'class' => 'form-control select-search-client-final',
        )) . "</div>";
    echo "<div class='form-group col-sm-2 clear-none p-l-0'>" . $this->Form->input('Simulation.arrival_destination_id', array(
            'label' => __('Arrival city'),
            'class' => 'form-control select-search-destination',
            'empty' => '',
            'id' => 'arrival_destination',
        )) . "</div>";

}else {
    echo "<div >" . $this->Form->input('Simulation.type_ride', array(
            'class' => 'form-control',
            'type'=>'hidden',
            'value'=>$typeRide,
            'id'=>'type_ride'
        )) . "</div>";
    echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('Simulation.detail_ride_id', array(
            'label' => __('Ride'),
            'class' => 'form-control select-search-detail-ride',
            'id'=>'detail_ride'
        )) . "</div>";

    echo "<div class='form-group col-sm-2 clear-none p-l-0'>" . $this->Form->input('Simulation.supplier_final_id', array(
            'label' => __('Final customer'),
            'empty' => '',
            'id' => 'client_final',
            'class' => 'form-control select-search-client-final',
        )) . "</div>";
}