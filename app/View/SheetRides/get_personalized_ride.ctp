<?php
if (Configure::read("gestion_commercial") == '1') {
echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.departure_destination_id', array(
        'label' => __('Departure city'),
        'id' => 'departure_destination' . $i,
        'class' => 'form-control select-search-destination',
        'onchange' => 'javascript:getInformationRide(this.id);',
    )) . "</div>";

echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.arrival_destination_id', array(
        'label' => __('Arrival city'),
        'id' => 'arrival_destination' . $i,
        'class' => 'form-control select-search-destination',
        'onchange' => 'javascript:getInformationRide(this.id);',
    )) . "</div>";

    echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.price', array(
            'label' => __('Price'),
            'id' => 'price' . $i,
            'class' => 'form-filter'
        )) . "</div>";
}else {
    echo "<div class='form-group col-sm-6 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.departure_destination_id', array(
            'label' => __('Departure city'),
            'id' => 'departure_destination' . $i,
            'class' => 'form-control select-search-destination',
            'onchange' => 'javascript:getInformationRide(this.id);',
        )) . "</div>";

    echo "<div class='form-group col-sm-6 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.arrival_destination_id', array(
            'label' => __('Arrival city'),
            'id' => 'arrival_destination' . $i,
            'class' => 'form-control select-search-destination',
            'onchange' => 'javascript:getInformationRide(this.id);',
        )) . "</div>";
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
        'value' => 2,
        'class' => 'form-control',
    )) . "</div>";
?>
<br/>
