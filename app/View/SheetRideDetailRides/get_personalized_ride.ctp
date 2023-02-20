<?php
if (Configure::read("gestion_commercial") == '1') {
    echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.departure_destination_id', array(
            'label' => __('Departure city'),
            'id' => 'departure_destination' ,
            'class' => 'form-control select-search-destination',
            'onchange' => 'javascript:getInformationRide(this.id);',
        )) . "</div>";

    echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.arrival_destination_id', array(
            'label' => __('Arrival city'),
            'id' => 'arrival_destination' ,
            'class' => 'form-control select-search-destination',
            'onchange' => 'javascript:getInformationRide(this.id);',
        )) . "</div>";

    echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.price', array(
            'label' => __('Price'),
            'id' => 'price' ,
            'class' => 'form-filter'
        )) . "</div>";
}else {
    echo "<div class='form-group col-sm-6 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.departure_destination_id', array(
            'label' => __('Departure city'),
            'id' => 'departure_destination' ,
            'class' => 'form-control select-search-destination',
            'onchange' => 'javascript:getInformationRide(this.id);',
        )) . "</div>";

    echo "<div class='form-group col-sm-6 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.arrival_destination_id', array(
            'label' => __('Arrival city'),
            'id' => 'arrival_destination' ,
            'class' => 'form-control select-search-destination',
            'onchange' => 'javascript:getInformationRide(this.id);',
        )) . "</div>";
}
echo "<div >" . $this->Form->input('SheetRideDetailRides.from_customer_order', array(
        'type' => 'hidden',
        'id' => 'from_customer_order',
        'value' => 2,
        'class' => 'form-control',
    )) . "</div>";

echo "<div >" . $this->Form->input('SheetRideDetailRides.type_ride', array(
        'type' => 'hidden',
        'id' => 'type_ride' ,
        'value' => 2,
        'class' => 'form-control',
    )) . "</div>";
?>
<br/>
