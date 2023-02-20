
<?php
$i = 1;
?>
<tr id="depart<?php echo $i ?>">
    <td rowspan='2'>Mission N° <?php echo $i ;
    if(isset($orderMission)){
        echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.order_mission', array(
                'class' => 'form-filter',
                'value' => $orderMission+1,
                'label' => '',
            )) . "</div>";
    }else {
        echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.order_mission', array(
                'class' => 'form-filter',
                'value' => $i,
                'label' => '',
            )) . "</div>";
    }

        ?></td>
    <td>Départ <?php echo $i ?></td>
    <td>
        <div class="filters" id='filters'>
            <?php
            if (!empty($transportBillDetailRide)) {
                if ($isReferenceMissionAutomatic == '1') {

                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.reference', array(
                            'label' => __('Reference'),
                            'class' => 'form-filter',
                            'placeholder' => __('Enter reference'),
                        )) . "</div>";

                }

                echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.invoiced_ride', array(
                        'type' => 'hidden',
                        'id' => 'invoiced_ride' . $i,
                        'value' => 1,
                        'class' => 'form-control',
                    )) . "</div>"; ?>


                <div class="input-radio hidden">
                    <p class="p-radio"><?php echo __('Source') ?></p>
                    <input id='source1<?php echo $i ?>'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][source]"
                           value="1" <?php if ($transportBillDetailRide['TransportBillDetailRides']['type_ride'] == 1) { ?> checked='checked'<?php } ?>>
                    <span class="label-radio"><?php echo __('Standard customer order') ?></span>
                    <input id='source2<?php echo $i ?>'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][source]"
                           value="2"  <?php if ($transportBillDetailRide['TransportBillDetailRides']['type_ride'] == 2) { ?> checked='checked'<?php } ?>>
                    <span class="label-radio"> <?php echo __('Personalized customer order') ?></span>

                </div>

                <div class="input-radio">

                    <p class="p-radio"><?php echo __('Truck full') ?></p>

                    <input id='truck_full1<?php echo $i ?>' class="input-radio"
                           type="radio" name="data[SheetRideDetailRides][<?php echo $i ?>][truck_full]"
                           value="1" checked='checked'>
                    <span class="label-radio"><?php echo __('Yes') ?></span>
                    <input id='truck_full2<?php echo $i ?>'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][truck_full]" value="2"
                    >
                    <span class="label-radio"> <?php echo __('No') ?></span>
                </div>





                <div class="input-radio">
                    <p class="p-radio"><?php echo __('Type mission') ?></p>

                    <input id='invoiced_ride1<?php echo $i ?>' class="input-radio"
                           type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][return_mission]"
                           value="1" <?php if ($transportBillDetailRide['TransportBillDetailRides']['delivery_with_return'] == 1) { ?> checked='checked'<?php } ?>>
                    <span class="label-radio"><?php echo __('Simple delivery') ?></span>
                    <input id='invoiced_ride2<?php echo $i ?>'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][return_mission]"
                           value="2"<?php if ($transportBillDetailRide['TransportBillDetailRides']['delivery_with_return'] == 2) { ?> checked='checked'<?php } ?>>
                    <span class="label-radio"> <?php echo __('Simple return') ?></span>
                    <input id='invoiced_ride3<?php echo $i ?>'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][return_mission]"
                           value="3" <?php if ($transportBillDetailRide['TransportBillDetailRides']['delivery_with_return'] == 3) { ?> checked='checked'<?php } ?>>
                    <span class="label-radio"> <?php echo __('Delivery / Return') ?></span>
                </div>
                <?php if ($paramPriceNight == 1) { ?>
                    <div class="input-radio">
                        <p class="p-radio"><?php echo __('Price') ?></p>

                        <input id='invoiced_ride1<?php echo $i ?>' class="input-radio"
                               type="radio"
                               name="data[SheetRideDetailRides][<?php echo $i ?>][type_price]"
                               value="1"
                               <?php if ($transportBillDetailRide['TransportBillDetailRides']['type_price'] == 1) { ?>checked='checked' <?php } ?>>
                        <span class="label-radio"><?php echo __('Day') ?></span>
                        <input id='invoiced_ride2<?php echo $i ?>'
                               class="input-radio" type="radio"
                               name="data[SheetRideDetailRides][<?php echo $i ?>][type_price]" value="2"
                               <?php if ($transportBillDetailRide['TransportBillDetailRides']['type_price'] == 2) { ?>checked='checked' <?php } ?>
                        >
                        <span class="label-radio"> <?php echo __('Night') ?></span>
                    </div>
                <?php } ?>
                <?php
                echo "<div style='clear:both; padding-top: 10px;'></div>";
                echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.transport_bill_detail_ride', array(
                        'type' => 'hidden',
                        'id' => 'transport_bill_detail_ride' . $i,
                        'value' => $transportBillDetailRide['TransportBillDetailRides']['id'],
                        'class' => 'form-control',
                    )) . "</div>";
                echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.observation_id', array(
                        'type' => 'hidden',
                        'id' => 'observation' . $i,
                        'value' => $transportBillDetailRide['Observation']['id'],
                        'class' => 'form-control',
                    )) . "</div>";

                echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.tonnage_id', array(
                        'type' => 'hidden',
                        'id' => 'tonnage' . $i,
                        'value' => $transportBillDetailRide['TransportBillDetailRides']['tonnage_id'],
                        'class' => 'form-control',
                    )) . "</div>";
                echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.type_ride', array(
                        'type' => 'hidden',
                        'id' => 'type_ride' . $i,
                        'value' => $transportBillDetailRide['TransportBillDetailRides']['type_ride'],
                        'class' => 'form-control',
                    )) . "</div>";

                echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.type_pricing', array(
                        'type' => 'hidden',
                        'id' => 'type_pricing' . $i,
                        'value' => $transportBillDetailRide['TransportBillDetailRides']['type_pricing'],
                        'class' => 'form-control',
                    )) . "</div>";
                echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.from_customer_order', array(
                        'type' => 'hidden',
                        'id' => 'from_customer_order' . $i,
                        'value' => 1,
                        'class' => 'form-control',
                    )) . "</div>";
                echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.source', array(
                        'type' => 'hidden',
                        'id' => 'source' . $i,
                        'value' => $transportBillDetailRide['TransportBillDetailRides']['type_ride'],
                        'class' => 'form-control',
                    )) . "</div>";

                if ($transportBillDetailRide['TransportBillDetailRides']['type_ride'] == 2) {

                    echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.detail_ride_id', array(
                            'label' => __('Ride'),
                            'value' => $transportBillDetailRide['TransportBillDetailRides']['id'],
                            'empty' => __('Select ride'),
                            'id' => 'detail_ride' . $i,
                            'type' => 'hidden',
                            'class' => 'form-filter'
                        )) . "</div>";

                    if(!empty($transportBillDetailRide['Departure']['id'])) {
                        echo "<div class='form-group col-sm-2 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.departure_destination_id', array(
                                'label' => __('Departure city'),
                                'disabled' => true,
                                'options' => $departures,
                                'value' => $transportBillDetailRide['Departure']['id'],
                                'class' => 'form-filter'
                            )) . "</div>";

                        echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.departure_destination_id', array(
                                'label' => __('Ride'),
                                'value' => $transportBillDetailRide['Departure']['id'],
                                'id' => 'departure_destination' . $i,
                                'type' => 'hidden',
                                'options' => $departures,
                                'class' => 'form-filter'
                            )) . "</div>";
                    } else {
                        echo "<div class='form-group col-sm-2 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.departure_destination_id', array(
                                'label' => __('Departure city'),
                                'id' => 'departure_destination' . $i,
                                'class' => 'form-filter select-search-destination'
                            )) . "</div>";
                    }

                    if(!empty($transportBillDetailRide['Arrival']['id'])) {
                        echo "<div class='form-group col-sm-2 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.arrival_destination_id', array(
                                'label' => __('Arrival city'),
                                'disabled' => true,
                                'options' => $arrivals,
                                'value' => $transportBillDetailRide['Arrival']['id'],
                                'class' => 'form-filter'
                            )) . "</div>";

                        echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.arrival_destination_id', array(
                                'label' => __('Ride'),
                                'value' => $transportBillDetailRide['Arrival']['id'],
                                'id' => 'arrival_destination' . $i,
                                'type' => 'hidden',
                                'options' => $arrivals,
                                'class' => 'form-filter'
                            )) . "</div>";
                    } else {
                        echo "<div class='form-group col-sm-2 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.arrival_destination_id', array(
                                'label' => __('Arrival city'),
                                'id' => 'arrival_destination' . $i,
                                'class' => 'form-filter select-search-destination'
                            )) . "</div>";
                    }

                } else {
                    echo "<div class='select-inline select-inline2'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.detail_ride_id', array(
                            'label' => __('Ride'),
                            'disabled' => true,
                            'value' => $transportBillDetailRide['TransportBillDetailRides']['detail_ride_id'],
                            'empty' => __('Select ride'),
                            'class' => 'form-filter'
                        )) . "</div>";

                    echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.detail_ride_id', array(
                            'label' => __('Ride'),
                            'value' => $transportBillDetailRide['TransportBillDetailRides']['id'],
                            'empty' => __('Select ride'),
                            'id' => 'detail_ride' . $i,
                            'type' => 'hidden',
                            'class' => 'form-filter'
                        )) . "</div>";
                }

            }



            else {
            if ($isReferenceMissionAutomatic == '1') {
                echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.reference', array(
                        'label' => __('Reference'),
                        'class' => 'form-filter',
                        'placeholder' => __('Enter reference'),
                    )) . "</div>";
            }
            if (isset($this->params['pass']['0']) && ($this->params['pass']['0'] != Null)){
                ?>
                <div class="input-radio">
                    <p class="p-radio"><?php echo __('Source') ?></p>
                    <input id='source1<?php echo $i ?>'
                           onclick='javascript:getRidesFromCustomerOrder(this.id);'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][source]"
                           value="1" checked='checked'>
                    <span class="label-radio"><?php echo __('Standard customer order') ?></span>
                    <input id='source2<?php echo $i ?>'
                           onclick='javascript:getPersonalizedRidesFromCustomerOrder(this.id);'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][source]"
                           value="2">
                    <span class="label-radio"> <?php echo __('Personalized customer order') ?></span>
                    <input id='source3<?php echo $i ?>'
                           onclick='javascript:getRidesByType(this.id);'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][source]"
                           value="3">
                    <span class="label-radio"> <?php echo __('Existing ride') ?></span>
                    <input id='source4<?php echo $i ?>'
                           onclick='javascript:getPersonalizedRide(this.id);'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][source]"
                           value="4">
                    <span class="label-radio"> <?php echo __('Personalized ride') ?></span>
                </div>

                <?php
            } else {
            if (Configure::read("gestion_commercial") == '1') {
                ?>
                <div class="input-radio">
                    <p class="p-radio"><?php echo __('Source') ?></p>
                    <input id='source1<?php echo $i ?>'
                           onclick='javascript:getRidesFromCustomerOrder(this.id);'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][source]"
                           value="1" checked='checked'>
                    <span class="label-radio"><?php echo __('Standard customer order') ?></span>
                    <input id='source2<?php echo $i ?>'
                           onclick='javascript:getPersonalizedRidesFromCustomerOrder(this.id);'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][source]"
                           value="2">
                    <span class="label-radio"> <?php echo __('Personalized customer order') ?></span>
                    <input id='source3<?php echo $i ?>'
                           onclick='javascript:getRidesByType(this.id);'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][source]"
                           value="3">
                    <span class="label-radio"> <?php echo __('Existing ride') ?></span>
                    <input id='source4<?php echo $i ?>'
                           onclick='javascript:getPersonalizedRide(this.id);'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][source]"
                           value="4">
                    <span class="label-radio"> <?php echo __('Personalized ride') ?></span>
                </div>
            <?php } else { ?>
            <div class="input-radio">
                <p class="p-radio"><?php echo __('Source') ?></p>
                <input id='source3<?php echo $i ?>'
                       onclick='javascript:getRidesByType(this.id);'
                       class="input-radio" type="radio"
                       name="data[SheetRideDetailRides][<?php echo $i ?>][source]"
                       value="3">
                <span class="label-radio"> <?php echo __('Existing ride') ?></span>
                <input id='source4<?php echo $i ?>'
                       onclick='javascript:getPersonalizedRide(this.id);'
                       class="input-radio" type="radio"
                       name="data[SheetRideDetailRides][<?php echo $i ?>][source]"
                       value="4" checked='checked'>
                <span class="label-radio"> <?php echo __('Personalized ride') ?></span>

                <?php
                }
                } ?>

                <?php if (Configure::read("gestion_commercial") == '1') { ?>
                    <div class="input-radio">

                        <p class="p-radio"><?php echo __('Invoiced ride') ?></p>

                        <input id='invoiced_ride1<?php echo $i ?>' class="input-radio"
                               type="radio"
                               name="data[SheetRideDetailRides][<?php echo $i ?>][invoiced_ride]"
                               value="1" checked='checked'>
                        <span class="label-radio"><?php echo __('Yes') ?></span>
                        <input id='invoiced_ride2<?php echo $i ?>'
                               class="input-radio" type="radio"
                               name="data[SheetRideDetailRides][<?php echo $i ?>][invoiced_ride]" value="2">
                        <span class="label-radio"> <?php echo __('No') ?></span>
                    </div>
                <?php } else { ?>
                    <input id='invoiced_ride2<?php echo $i ?>'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][invoiced_ride]"
                           value="2" checked='checked'>
                <?php } ?>




                <div class="input-radio" style="margin: 0 20px;">
                    <p class="p-radio"><?php echo __('Truck full') ?></p>

                    <input id='truck_full1<?php echo $i ?>' class="input-radio"
                           type="radio" name="data[SheetRideDetailRides][<?php echo $i ?>][truck_full]"
                           value="1" checked='checked'>
                    <span class="label-radio"><?php echo __('Yes') ?></span>
                    <input id='truck_full2<?php echo $i ?>'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][truck_full]" value="2">
                    <span class="label-radio"> <?php echo __('No') ?></span>
                </div>
                <div class="input-radio">
                    <p class="p-radio"><?php echo __('Type mission') ?></p>

                    <input id='invoiced_ride1<?php echo $i ?>' class="input-radio"
                           type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][return_mission]"
                           value="1" checked='checked'>
                    <span class="label-radio"><?php echo __('Simple delivery') ?></span>
                    <input id='invoiced_ride2<?php echo $i ?>'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][return_mission]" value="2">
                    <span class="label-radio"> <?php echo __('Simple return') ?></span>
                    <input id='invoiced_ride3<?php echo $i ?>'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][return_mission]" value="3">
                    <span class="label-radio"> <?php echo __('Delivery / Return') ?></span>
                </div>
                <?php if ($paramPriceNight == 1) { ?>
                    <div class="input-radio">
                        <p class="p-radio"><?php echo __('Price') ?></p>

                        <input id='invoiced_ride1<?php echo $i ?>' class="input-radio"
                               type="radio"
                               name="data[SheetRideDetailRides][<?php echo $i ?>][type_price]"
                               value="1" checked='checked'>
                        <span class="label-radio"><?php echo __('Day') ?></span>
                        <input id='invoiced_ride2<?php echo $i ?>'
                               class="input-radio" type="radio"
                               name="data[SheetRideDetailRides][<?php echo $i ?>][type_price]"
                               value="2">
                        <span class="label-radio"> <?php echo __('Night') ?></span>
                    </div>
                <?php } ?>
                <?php
                echo "<div style='clear:both; padding-top: 10px;'></div>";

                echo "<div  id='ride-div$i' class='select-inline select-inline2'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.detail_ride_id', array(
                        'label' => __('Ride'),

                        'empty' => __('Select ride'),
                        'id' => 'detail_ride' . $i,


                        'class' => 'form-filter select-search-detail-ride'
                    )) . "</div>";

                echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.transport_bill_detail_ride', array(
                        'type' => 'hidden',
                        'id' => 'transport_bill_detail_ride' . $i,

                        'class' => 'form-control',
                    )) . "</div>";


                echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.observation_id', array(
                        'type' => 'hidden',
                        'id' => 'observation' . $i,
                        'class' => 'form-control',
                    )) . "</div>";

                echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.tonnage_id', array(
                        'type' => 'hidden',
                        'id' => 'tonnage' . $i,
                        'class' => 'form-control',
                    )) . "</div>";
                }

                if (!empty($transportBillDetailRide)) {
                    ?>
                    <div id='distance_duration_ride<?php echo $i ?>'>
                        <?php

                        if ($transportBillDetailRide['TransportBillDetailRides']['type_ride'] == 2) {
                            echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.duration_day', array(
                                    'label' => __('Duration'),
                                    'readonly' => true,
                                    'value' => $transportBillDetailRide['DetailRides']['real_duration_day'],
                                    'id' => 'duration_day' . $i,
                                    'type' => 'hidden',
                                    'class' => 'form-filter'
                                )) . "</div>";

                            echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.duration_hour', array(
                                    'label' => '',
                                    'readonly' => true,
                                    'value' => $transportBillDetailRide['DetailRides']['real_duration_hour'],
                                    'id' => 'duration_hour' . $i,
                                    'type' => 'hidden',
                                    'class' => 'form-filter'
                                )) . "</div>";


                            echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.duration_minute', array(
                                    'label' => __('Duration'),
                                    'readonly' => true,
                                    'value' => $transportBillDetailRide['DetailRides']['real_duration_minute'],
                                    'id' => 'duration_minute' . $i,
                                    'type' => 'hidden',
                                    'class' => 'form-filter'
                                )) . "</div>";
                            $duration = $transportBillDetailRide['DetailRides']['real_duration_day'] . ' ' . __('Day') . ' ' . $transportBillDetailRide['DetailRides']['real_duration_hour'] . ' ' . __('Hour') . ' ' . $transportBillDetailRide['DetailRides']['real_duration_minute'] . ' ' . __('min');
                            echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.duration', array(
                                    'label' => __('Duration'),
                                    'disabled' => true,
                                    'value' => $duration,
                                    'class' => 'form-filter'
                                )) . "</div>";
                            echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.distance', array(
                                    'label' => __('Distance'),
                                    'value' => $transportBillDetailRide['Rides']['distance'],
                                    'disabled' => true,
                                    'id' => 'distance' . $i,
                                    'class' => 'form-filter'
                                )) . "</div>";
                        } else {
                            echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.duration_day', array(
                                    'label' => __('Duration'),
                                    'readonly' => true,
                                    'value' => $transportBillDetailRide['DetailRide']['real_duration_day'],
                                    'id' => 'duration_day' . $i,
                                    'type' => 'hidden',
                                    'class' => 'form-filter'
                                )) . "</div>";

                            echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.duration_hour', array(
                                    'label' => '',
                                    'readonly' => true,
                                    'value' => $transportBillDetailRide['DetailRide']['real_duration_hour'],
                                    'id' => 'duration_hour' . $i,
                                    'type' => 'hidden',
                                    'class' => 'form-filter'
                                )) . "</div>";


                            echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.duration_minute', array(
                                    'label' => __('Duration'),
                                    'readonly' => true,
                                    'value' => $transportBillDetailRide['DetailRide']['real_duration_minute'],
                                    'id' => 'duration_minute' . $i,
                                    'type' => 'hidden',
                                    'class' => 'form-filter'
                                )) . "</div>";
                            $duration = $transportBillDetailRide['DetailRide']['real_duration_day'] . ' ' . __('Day') . ' ' . $transportBillDetailRide['DetailRide']['real_duration_hour'] . ' ' . __('Hour') . ' ' . $transportBillDetailRide['DetailRide']['real_duration_minute'] . ' ' . __('min');
                            echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.duration', array(
                                    'label' => __('Duration'),
                                    'disabled' => true,
                                    'value' => $duration,
                                    'class' => 'form-filter'
                                )) . "</div>";
                            echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.distance', array(
                                    'label' => __('Distance'),
                                    'value' => $transportBillDetailRide['Ride']['distance'],
                                    'disabled' => true,
                                    'id' => 'distance' . $i,
                                    'class' => 'form-filter'
                                )) . "</div>";
                        }





                        ?>

                    </div>
                    <?php
                    echo "<div style='clear:both; padding-top: 10px;'></div>";
                } else {
                    ?>
                    <div id='distance_duration_ride<?php echo $i ?>'>
                    </div>



                    <?php
                    echo "<div style='clear:both; padding-top: 10px;'></div>";
                }


                if (!empty($transportBillDetailRide)) {

                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_id', array(
                            'label' => __('Initial customer'),

                            'empty' => __('Select initial customer'),
                            'id' => 'client' . $i,
                            'value' => $transportBillDetailRide['Supplier']['id'],
                            'disabled' => true,
                            'onchange' => 'javascript:getMarchandisesByClient(this.id), getAttachmentsByClient(this.id);',
                            'class' => 'form-filter'
                        )) . "</div>";

                    echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_id', array(
                            'label' => __('Initial customer'),

                            'empty' => __('Select initial customer'),
                            'id' => 'client' . $i,
                            'value' => $transportBillDetailRide['Supplier']['id'],
                            'type' => 'hidden',
                            'class' => 'form-filter'
                        )) . "</div>";
                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.service_id', array(
                            'label' => __('Service'),

                            'id' => 'service' . $i,
                            'value' => $transportBillDetailRide['Service']['id'],
                            'disabled' => true,
                            'class' => 'form-filter'
                        )) . "</div>";

                    echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.service_id', array(
                            'label' => __('Service'),

                            'id' => 'service' . $i,
                            'value' => $transportBillDetailRide['Service']['id'],
                            'type' => 'hidden',
                            'class' => 'form-filter'
                        )) . "</div>";
                } else

                        echo "<div  class='select-inline' id='client-initial-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_id', array(
                                'label' => __('Initial customer'),
                                'empty' => __('Select initial customer'),
                                'id' => 'client' . $i,
                                'class' => 'form-filter select-search-client-initial',
                                'onchange' => 'javascript:getMarchandisesByClient(this.id), getAttachmentsByClient(this.id), getFinalSupplierByInitialSupplier(this.id);'
                            )) . "</div>";

                        echo "<div  class='select-inline' id='client-initial-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.service_id', array(
                                'label' => __('Service'),
                                'id' => 'service' . $i,
                                'class' => 'form-filter select-search',
                            )) . "</div>";


                echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.km_departure', array(
                        'label' => __('Departure Km'),
                        'onchange' => 'javascript:calculKmArrivalEstimated(this.id), verifyKmEntred(this.id,"departure");',
                        'id' => 'km_departure' . $i,
                        'class' => 'form-filter'
                    )) . "</div>";


                $date = date("Y-m-d", strtotime('+1 day'));
                $date = date($date . ' 02:00');
                echo "<div class='datedep'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.planned_start_date', array(
                        'label' => '',
                        'type' => 'text',
                        'value' => $this->Time->format($date, '%d/%m/%Y %H:%M'),
                        'class' => 'form-control datemask',
                        'placeholder' => _('dd/mm/yyyy hh:mm'),
                        'before' => '<label class="dte">' . __('Planned Departure date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'planned_start_date' . $i,
                        'onchange' => 'javascript:calculPlannedArrivalDate(this.id);',
                    )) . "</div>";
                if(isset($transportBillDetailRide['TransportBillDetailRides']['programming_date'])&&
                    !empty($transportBillDetailRide['TransportBillDetailRides']['programming_date'])

                ){
                    echo "<div class='datedep'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.real_start_date', array(
                            'label' => '',
                            'type' => 'text',
                            'value' => $this->Time->format($transportBillDetailRide['TransportBillDetailRides']['programming_date'], '%d/%m/%Y %H:%M'),
                            'class' => 'form-control datemask',
                            'placeholder' => _('dd/mm/yyyy hh:mm'),
                            'before' => '<label class="dte">' . __('Real Departure date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'real_start_date' . $i,
                            'onchange' => 'javascript:calculPlannedArrivalDate(this.id);',
                        )) . "</div>";

                }
                    else {
                        echo "<div class='datedep'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.real_start_date', array(
                                'label' => '',
                                'type' => 'text',
                                // 'value' => $this->Time->format($date, '%d/%m/%Y %H:%M'),
                                'class' => 'form-control datemask',
                                'placeholder' => _('dd/mm/yyyy hh:mm'),
                                'before' => '<label class="dte">' . __('Real Departure date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'real_start_date' . $i,
                                'onchange' => 'javascript:calculPlannedArrivalDate(this.id);',
                            )) . "</div>";

                }


                echo "<div style='clear:both; padding-top: 10px;'></div>";


                if ($displayMissionCost == 2){
                echo "<div class ='scroll-block'>";
                echo '<div class="lbl2"> <a href="#demoMissionCost" data-toggle="collapse"><i class="fa fa-angle-double-right" style="padding-right: 10px;"></i>' . __("Mission costs") . '</a></div>'; ?>
                <div id="demoMissionCost" class="collapse">
                    <br>

                    <?php      if (!empty($transportBillDetailRide)) {

                        switch ($managementParameterMissionCost) {
                            case '1':
                                if (!empty($missionCost)) {
                                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                            'label' => __('Mission cost'),
                                            'placeholder' => __('Enter mission cost'),
                                            'id' => 'mission_cost' . $i,
                                            'value' => $missionCost['cost_day'],
                                            'readonly' => true,
                                            'class' => 'form-filter'
                                        )) . "</div>";
                                } else {
                                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                            'label' => __('Mission cost'),
                                            'placeholder' => __('Enter mission cost'),
                                            'id' => 'mission_cost' . $i,
                                            'class' => 'form-filter'
                                        )) . "</div>";
                                }

                                break;

                            case '2':
                                if (!empty($missionCost)) {
                                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                            'label' => __('Mission cost'),
                                            'placeholder' => __('Enter mission cost'),
                                            'id' => 'mission_cost' . $i,
                                            'value' => $missionCost['cost_destination'],
                                            'readonly' => true,
                                            'class' => 'form-filter'
                                        )) . "</div>";
                                } else {
                                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                            'label' => __('Mission cost'),
                                            'placeholder' => __('Enter mission cost'),
                                            'id' => 'mission_cost' . $i,
                                            'class' => 'form-filter'
                                        )) . "</div>";
                                }

                                break;

                            case '3':
                                if (!empty($missionCost)) {
                                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                            'label' => __('Mission cost'),
                                            'placeholder' => __('Enter mission cost'),
                                            'id' => 'mission_cost' . $i,
                                            'value' => $missionCost['MissionCost']['cost_truck_full'],
                                            'readonly' => true,
                                            'class' => 'form-filter'
                                        )) . "</div>";
                                } else {
                                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                            'label' => __('Mission cost'),
                                            'placeholder' => __('Enter mission cost'),
                                            'id' => 'mission_cost' . $i,
                                            'class' => 'form-filter'
                                        )) . "</div>";
                                }

                                break;

                        }


                    } else {

                        echo "<div  class='select-inline' id='mission-cost-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                'label' => __('Mission cost'),
                                'placeholder' => __('Enter mission cost'),
                                'id' => 'mission_cost' . $i,
                                'class' => 'form-filter '
                            )) . "</div>";

                    }

                    ?>
                </div>
            </div>

        <?php
        } else {

            if (!empty($transportBillDetailRide)) {
                switch ($managementParameterMissionCost) {
                    case '1':
                        echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                'label' => __('Mission cost'),
                                'type' => 'hidden',
                                'placeholder' => __('Enter mission cost'),
                                'id' => 'mission_cost' . $i,
                                'value' => $missionCost['mission_cost_day'],
                                'readonly' => true,
                                'class' => 'form-filter'
                            )) . "</div>";
                        break;

                    case '2':
                        echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                'label' => __('Mission cost'),
                                'type' => 'hidden',
                                'placeholder' => __('Enter mission cost'),
                                'id' => 'mission_cost' . $i,
                                'value' => $missionCost['mission_cost_mission'],
                                'readonly' => true,
                                'class' => 'form-filter'
                            )) . "</div>";
                        break;

                    case '3':

                        echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                'label' => __('Mission cost'),
                                'type' => 'hidden',
                                'placeholder' => __('Enter mission cost'),
                                'id' => 'mission_cost' . $i,
                                'value' => $missionCost['MissionCost']['cost_truck_full'],
                                'readonly' => true,
                                'class' => 'form-filter'
                            )) . "</div>";
                        break;

                }


            } else {

                echo "<div  class='select-inline' id='mission-cost-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                        'label' => __('Mission cost'),
                        'placeholder' => __('Enter mission cost'),
                        'id' => 'mission_cost' . $i,
                        'type' => 'hidden',
                        'class' => 'form-control '
                    )) . "</div>";

            }

        }


        echo "<div class ='scroll-block'>";
        echo '<div class="lbl2"> <a href="#demoPeage'.$i.'" data-toggle="collapse"><i class="fa fa-angle-double-right" style="padding-right: 10px;"></i>' . __("Tolls") . '</a></div>'; ?>
            <div id="demoPeage<?php echo $i ?>" class="collapse">
                <br>

                <?php
                echo "<div style='clear:both; padding-top: 10px;'></div>";
                echo "<div  class='select-inline' id='toll-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.toll', array(
                        'label' => __('Toll'),
                        'placeholder' => __('Enter toll'),
                        'id' => 'toll' . $i,
                        'class' => 'form-filter '
                    )) . "</div>";
                ?>
            </div>
        </div>
        <?php
        echo "<div class ='scroll-block'>";
        echo "<div class='lbl2'> <a href='#note' data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Observation") . "</a></div>";
        echo "<div id='note' class='collapse'><br>";
        echo "<div class='select-inline' >" . $this->Form->input('SheetRideDetailRides.' . $i . '.note', array(
                'label' => __('Observation'),
                'class' => 'form-control'
            )) . "</div>";
        echo "</div>";
        echo "</div>";
        if (!empty($transportBillDetailRide)) {
            echo  $this->Form->input('SheetRideDetailRides.' . $i . '.unit_price', array(
                    'id' => 'unit_price'.$i,
                    'value' => $transportBillDetailRide['TransportBillDetailRides']['unit_price'],
                    'type' => 'hidden',
                    'class' => 'form-filter'
                )) ;
        }
        echo  $this->Form->input('subcontractor_cost_percentage', array(
            'id' => 'subcontractor_cost_percentage',
            'value' => $subcontractorCostPercentage,
            'type' => 'hidden',
            'class' => 'form-filter'
        )) ;

        ?>
        <div id='cost_contractor_div<?php echo $i; ?>' style='display: block'>

        </div>
        </div>
    </td>
</tr>
<tr id="arrive<?php echo $i ?>">
    <td>arrivée<?php echo $i ?></td>
    <td>
        <div class="filters" id='filters'>
            <?php
            if (!empty($transportBillDetailRide)) {
                echo "<div class='select-inline' id='client-final-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_final_id', array(
                        'label' => __('Final customer'),
                        'empty' => __('Select client'),
                        'id' => 'client_final',
                        'options' => $finalSuppliers,
                        'value' => $transportBillDetailRide['SupplierFinal']['id'],
                        'disabled' => true,
                        'class' => 'form-filter'
                    )) . "</div>";
                echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_final_id', array(
                        'label' => __('Final customer'),
                        'empty' => __('Select client'),
                        'id' => 'client_final',
                        'options' => $finalSuppliers,
                        'value' => $transportBillDetailRide['SupplierFinal']['id'],
                        'type' => 'hidden',
                        'class' => 'form-filter'
                    )) . "</div>";
            } else {

                    echo "<div class='select-inline'  id='client-final-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_final_id', array(
                            'label' => __('Final customer'),
                            'empty' => __('Select client'),
                            'id' => 'client_final',
                            //'options' => $suppliers,
                            'class' => 'form-filter select-search-client-final-i'
                        )) . "</div>";

            }


            echo "<div class='datedep'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.planned_end_date', array(
                    'label' => '',
                    'type' => 'text',
                    'class' => 'form-control datemask',
                    'placeholder' => _('dd/mm/yyyy hh:mm'),
                    'before' => '<label class="dte">' . __('Planned Arrival date ') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'planned_end_date' . $i,
                    'onchange' => 'javascript: calculateDateArrivalParc(this.id);',
                )) . "</div>";

            echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.remaining_time', array(
                    'label' => '',
                    'class' => 'form-control',
                    'id' => 'tempRestant' . $i,
                    'type' => 'hidden'
                )) . "</div>";

            echo "<div class='datedep'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.real_end_date', array(
                    'label' => '',
                    'type' => 'text',

                    'class' => 'form-control datemask',
                    'placeholder' => _('dd/mm/yyyy hh:mm'),
                    'before' => '<label class="dte">' . __('Real Arrival date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'onchange' => 'javascript: calculateDateArrivalParc(this.id);',
                    'id' => 'real_end_date' . $i,
                )) . "</div>";

            echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.km_arrival_estimated', array(
                    'label' => __('Arrival Km estimated'),
                    'readonly' => true,
                    'id' => 'km_arrival_estimated' . $i,

                    'class' => 'form-filter'
                )) . "</div>";

            echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.km_arrival', array(
                    'label' => __('Arrival Km'),
                    'onchange' => 'javascript: calculateKmArrivalParc(this.id), verifyKmEntred(this.id,"arrival");',
                    'id' => 'km_arrival' . $i,
                    'class' => 'form-filter'
                )) . "</div>";


            echo "<div style='clear:both; padding-top: 10px;'></div>";
            ?>


        </div>
        <div class="scroll-block100">
            <?php echo "<div class='lbl2'> <a href='#piece$i' data-toggle='collapse' id='pieceClient$i' onclick='getAttachmentsByClient(this.id)'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Attachments") . "</a></div>";

            echo "<div id='piece$i' class='collapse'>";
            echo "<div id = 'piece-div$i'>";
            echo "</div>" ?>
        </div>

        </br>
        <div class="scroll-block100">
            <?php


            echo "<div class='lbl2'> <a href='#march$i' id='marchandiseClient$i' onclick='getMarchandisesByClient(this.id)' data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Marchandises") . "</a></div>";



            echo "<div id='march$i' class='collapse'>";


            $nbMarchandise = 1;
            echo "<div class='select-inline'>" . $this->Form->input('nb_marchandise', array(
                    'label' => __(''),
                    'type' => 'hidden',
                    'class' => 'form-filter',
                    'id' => 'nb_marchandise' . $i,
                    'value' => $nbMarchandise
                )) . "</div>";

            echo "<div id='marchandise-div$i' class='scroll-block100'>";
            if($fieldMarchandiseRequired==1){ ?>
                <table   id='dynamic_field<?php echo $i?>' style='width: 100%;'>
                    <tr id="row<?php echo $i?><?php echo $nbMarchandise?>" style="height: 70px;">
                        <td id='marchandise-quantity<?php echo $nbMarchandise ?>'  style="width: 50%;">
                            <?php

                            echo "<div class='select-inline small-select' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.'.$i.'.SheetRideDetailRideMarchandise.'.$nbMarchandise.'.marchandise_id', array(
                                    'label' => __(''),
                                    'empty' => '',
                                    'required'=>true,
                                    'id' => 'marchandise'.$i.$nbMarchandise,
                                    'options' => $marchandises,
                                    'onchange'=>'javascript : getWeightByMarchandise(this.id,'.$i.','.$nbMarchandise.');',
                                    'class' => 'form-filter select3'
                                )) . "</div>";

                            echo "<div class='select-inline' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.'.$i.'.SheetRideDetailRideMarchandise.'.$nbMarchandise.'.quantity', array(
                                    'label' => __(''),
                                    'required'=>true,
                                    'placeholder' => __('Enter quantity'),
                                    'id' => 'quantity'.$i.$nbMarchandise,
                                    //'onchange'=>'javascript : verifyQuantity(this.id,'.$i.','.$nbMarchandise.');',
                                    'class' => 'form-filter'
                                )) . "</div>";

                            ?>
                            <div id='weight-div<?php echo $i?><?php echo $nbMarchandise?>'>
                            </div>
                        </td>
                        <td class="td_tab">
                            <button  style="margin-left: 0px;" type='button' name='add' id='add<?php echo $nbMarchandise?>' onclick="addOtherMarchandises(<?php echo $nbMarchandise?>, <?php echo $i?>)" class='btn btn-success add_marchandise'><?=__('Add more')?></button>
                        </td>

                    </tr>
                </table>

            <?php  }

            echo "</div>";

            echo "</div>";
            echo "</div>";?>
        </div>
        </br>
        </br>
        <?php if ($usePurchaseBill == 1) { ?>
            <div class="scroll-block100" style="margin-top: 5px;">
                <?php echo "<div class='lbl2'> <a href='#lot$i' id ='lotClient$i' onclick='getLots(this.id)'  data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Products") . "</a></div>";

                echo "<div id='lot$i' class='collapse'>";
                echo "<div id = 'lot-div$i'>";
                echo "</div>";

                ?>
            </div>
        <?php } ?>

    </td>
</tr>