 <?php

        $init = 0;
                $i = 1;
                echo "<div class='select-inline' >" . $this->Form->input('Missions.deleted_id', array(
                        'type' => 'hidden',
                        'id' => 'missions_deleted_id',
                        'value' => ''
                    )) . "</div>";
                foreach ($rides_sheet_rides as $rides_sheet_ride){
                ?>

                <tr  id="depart<?php echo $i ?>" <?php if ($isAgent) {?> class='hidden'<?php } ?>>
                    <td  rowspan='2'>Mission N° <?php echo $i ;
                        echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.order_mission', array(
                                'class' => 'form-filter',
                                'value' => $rides_sheet_ride['SheetRideDetailRides']['order_mission'],
                                'label' => '',
                            )) . "</div>";
                        ?>
                        <?php if ($nb_rides == $i && $nb_rides > 1) { ?>
                            <div id='div-remove<?php echo $i ?>'>
                                <button name="remove" id="remove<?php echo $i ?>"
                                        onclick="removeMission('<?php echo $i ?>');" class="btn btn-danger btn_remove">X
                                </button>
                            </div>
                        <?php } ?>
                    </td>
                    <td>Départ <?php echo $i ?></td>
                    <td>
                        <div class="filters" id='filters'>
                            <?php
                    if($this->request->params['action'] !='duplicate') {
                        echo "<div>" . $this->Form->input('SheetRideDetailRides.' . $i . '.id', array(

                                'type' => 'hidden',
                                'id' => 'sheet_ride_detail_ride' . $i,
                                'value' => $rides_sheet_ride['SheetRideDetailRides']['id'],
                                'class' => 'form-control'
                            )) . "</div>";
                    }
                            if ($referenceMission == '1') {
                                echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.reference', array(
                                        'label' => __('Reference'),
                                        'class' => 'form-filter',
                                        'placeholder' => __('Enter reference'),
                                    )) . "</div>";
                            }
                            echo "<div>" . $this->Form->input('SheetRideDetailRides.' . $i . '.status_id', array(

                                    'type' => 'hidden',
                                    'id' => 'status' . $i,
                                    'value' => $rides_sheet_ride['SheetRideDetailRides']['status_id'],
                                    'class' => 'form-control'
                                )) . "</div>";

                            echo "<div>" . $this->Form->input('SheetRideDetailRides.' . $i . '.from_customer_order', array(
                                    'type' => 'hidden',
                                    'id' => 'from_customer_order' . $i,
                                    'value' => $rides_sheet_ride['SheetRideDetailRides']['from_customer_order'],
                                    'class' => 'form-control'
                                )) . "</div>";

                            echo "<div>" . $this->Form->input('SheetRideDetailRides.' . $i . '.type_ride', array('type' => 'hidden',
                                    'id' => 'type_ride' . $i,
                                    'value' => $rides_sheet_ride['SheetRideDetailRides']['type_ride'],
                                    'class' => 'form-control'
                                )) . "</div>";
                            ?>

                            <?php
                            echo "<div>" . $this->Form->input('SheetRideDetailRides.' . $i . '.gestion_commercial', array(
                                    'type' => 'hidden',
                                    'id' => 'gestion_commercial' . $i,
                                    'value' => Configure::read("gestion_commercial"),
                                    'class' => 'form-control'
                                )) . "</div>";
                            if (Configure::read("gestion_commercial") == '1') { ?>
                                <div class="input-radio">
                                    <p class="p-radio"><?php echo __('Source') ?></p>

                                    <input id='source1<?php echo $i ?>'
                                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] <= StatusEnum::mission_closed) { ?>
                                            onclick='javascript:getRidesFromCustomerOrder(this.id);'
                                        <?php } else { ?> disabled ='disabled'  <?php } ?>
                                           class="input-radio" type="radio"
                                           name="data[SheetRideDetailRides][<?php echo $i ?>][source]"
                                           value="1" <?php if ($rides_sheet_ride['SheetRideDetailRides']['source'] == 1) { ?> checked='checked' <?php } ?>>
                                    <span class="label-radio"><?php echo __('Standard customer order') ?></span>

                                    <input id='source2<?php echo $i ?>'
                                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] <= StatusEnum::mission_closed) { ?>
                                            onclick='javascript:getPersonalizedRidesFromCustomerOrder(this.id);'
                                        <?php } else { ?> disabled ='disabled'  <?php } ?>
                                           class="input-radio" type="radio"
                                           name="data[SheetRideDetailRides][<?php echo $i ?>][source]"
                                           value="2" <?php if ($rides_sheet_ride['SheetRideDetailRides']['source'] == 2) { ?> checked='checked' <?php } ?>>
                                    <span class="label-radio"><?php echo __('Personalized customer order') ?></span>


                                    <input id='source3<?php echo $i ?>'
                                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] <= StatusEnum::mission_closed) { ?>
                                            onclick='javascript:getRidesByType(this.id);'
                                        <?php }  else { ?> disabled ='disabled'  <?php } ?>
                                           class="input-radio" type="radio"
                                           name="data[SheetRideDetailRides][<?php echo $i ?>][source]"
                                           value="3" <?php if ($rides_sheet_ride['SheetRideDetailRides']['source'] == 3) { ?> checked='checked' <?php } ?>>
                                    <span class="label-radio"> <?php echo __('Existing ride') ?></span>
                                    <input id='source4<?php echo $i ?>'
                                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] <= StatusEnum::mission_closed) { ?>
                                            onclick='javascript:getPersonalizedRide(this.id);'
                                        <?php } else { ?> disabled ='disabled'  <?php } ?>
                                           class="input-radio" type="radio"
                                           name="data[SheetRideDetailRides][<?php echo $i ?>][source]"
                                           value="4" <?php if ($rides_sheet_ride['SheetRideDetailRides']['source'] == 4) { ?> checked='checked' <?php } ?>>
                                    <span class="label-radio"> <?php echo __('Personalized ride') ?></span>
                                </div>

                            <?php } else { ?>
                                <div class="input-radio">
                                    <input id='source3<?php echo $i ?>'
                                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] <= StatusEnum::mission_closed) { ?>
                                            onclick='javascript:getRidesByType(this.id);'
                                        <?php }  else { ?> disabled ='disabled'  <?php } ?>
                                           class="input-radio" type="radio"
                                           name="data[SheetRideDetailRides][<?php echo $i ?>][source]"
                                           value="3" <?php if ($rides_sheet_ride['SheetRideDetailRides']['source'] == 3) { ?> checked='checked' <?php } ?>>
                                    <span class="label-radio"> <?php echo __('Existing ride') ?></span>
                                    <input id='source4<?php echo $i ?>'
                                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] <= StatusEnum::mission_closed) { ?>
                                            onclick='javascript:getPersonalizedRide(this.id);'
                                        <?php } else { ?> disabled ='disabled'  <?php } ?>
                                           class="input-radio" type="radio"
                                           name="data[SheetRideDetailRides][<?php echo $i ?>][source]"
                                           value="4" <?php if ($rides_sheet_ride['SheetRideDetailRides']['source'] == 4) { ?> checked='checked' <?php } ?>>
                                    <span class="label-radio"> <?php echo __('Personalized ride') ?></span>
                                </div>


                            <?php } ?>

                            <?php if (Configure::read("gestion_commercial") == '1') { ?>

                                <div class="input-radio">
                                    <p class="p-radio"><?php echo __('Invoiced ride') ?></p>
                                    <input id='invoiced_ride1<?php echo $i ?>' class="input-radio"
                                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) { ?>
                                            disabled ='disabled'
                                        <?php }else { ?> onclick='modifyInvoicedRide(<?php echo $i ?>,1)'<?php } ?>
                                           type="radio" name="data[SheetRideDetailRides][<?php echo $i ?>][invoiced_ride]"
                                           value="1"  <?php if ($rides_sheet_ride['SheetRideDetailRides']['invoiced_ride'] == 1) { ?>
                                           checked='checked' <?php } ?>
                                    <span class="label-radio"><?php echo __('Yes') ?></span>
                                    <input id='invoiced_ride2<?php echo $i ?>'
                                           class="input-radio" type="radio"
                                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) { ?>
                                            disabled ='disabled'
                                        <?php }else { ?> onclick='modifyInvoicedRide(<?php echo $i ?>,2)'<?php } ?>
                                           name="data[SheetRideDetailRides][<?php echo $i ?>][invoiced_ride]"
                                           value="2"  <?php if ($rides_sheet_ride['SheetRideDetailRides']['invoiced_ride'] == 2) { ?> checked='checked' <?php } ?>>
                                    <span class="label-radio"> <?php echo __('No') ?></span>
                                </div>

                            <?php } ?>


                            <div class="input-radio" style="margin: 0 20px;">
                                <p class="p-radio"><?php echo __('Truck full') ?></p>

                                <input id='truck_full1<?php echo $i ?>' class="input-radio"
                                    <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) { ?>
                                        disabled ='disabled'
                                    <?php } ?>
                                       type="radio" name="data[SheetRideDetailRides][<?php echo $i ?>][truck_full]"
                                       value="1" <?php if ($rides_sheet_ride['SheetRideDetailRides']['truck_full'] == 1) { ?> checked='checked' <?php } ?>>
                                <span class="label-radio"><?php echo __('Yes') ?></span>
                                <input id='truck_full2<?php echo $i ?>'
                                       class="input-radio" type="radio"
                                    <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) { ?>
                                        disabled ='disabled'
                                    <?php } ?>
                                       name="data[SheetRideDetailRides][<?php echo $i ?>][truck_full]"
                                       value="2" <?php if ($rides_sheet_ride['SheetRideDetailRides']['truck_full'] == 2) { ?> checked='checked' <?php } ?>>
                                <span class="label-radio"> <?php echo __('No') ?></span>
                            </div>
                            <div class="input-radio">
                                <p class="p-radio"><?php echo __('Type mission') ?></p>

                                <input id='return_mission1<?php echo $i ?>' class="input-radio"
                                    <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) { ?>
                                        disabled ='disabled'
                                    <?php } ?>
                                       type="radio" name="data[SheetRideDetailRides][<?php echo $i ?>][return_mission]"
                                       value="1" <?php if ($rides_sheet_ride['SheetRideDetailRides']['return_mission'] == 1) { ?> checked='checked' <?php } ?>>
                                <span class="label-radio"><?php echo __('Simple delivery') ?></span>
                                <input id='return_mission2<?php echo $i ?>'
                                       class="input-radio" type="radio"
                                    <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) { ?>
                                        disabled ='disabled'
                                    <?php } ?>
                                       name="data[SheetRideDetailRides][<?php echo $i ?>][return_mission]"
                                       value="2" <?php if ($rides_sheet_ride['SheetRideDetailRides']['return_mission'] == 2) { ?> checked='checked' <?php } ?>>
                                <span class="label-radio"> <?php echo __('Simple return') ?></span>
                                <input id='return_mission3<?php echo $i ?>'
                                       class="input-radio" type="radio"
                                    <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) { ?>
                                        disabled ='disabled'
                                    <?php } ?>
                                       name="data[SheetRideDetailRides][<?php echo $i ?>][return_mission]"
                                       value="3" <?php if ($rides_sheet_ride['SheetRideDetailRides']['return_mission'] == 3) { ?> checked='checked' <?php } ?>>
                                <span class="label-radio"> <?php echo __('Delivery / Return') ?></span>
                            </div>
                            <?php if($paramPriceNight == 1) { ?>
                                <div class="input-radio">
                                    <p class="p-radio"><?php echo __('Price') ?></p>

                                    <input id='type_price1<?php echo $i ?>' class="input-radio"
                                           type="radio" name="data[SheetRideDetailRides][<?php echo $i ?>][type_price]"
                                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) { ?>
                                            disabled ='disabled'
                                        <?php } ?>
                                           value="1" <?php if ($rides_sheet_ride['SheetRideDetailRides']['type_price'] == 1) { ?> checked='checked' <?php } ?>>
                                    <span class="label-radio"><?php echo __('Day') ?></span>
                                    <input id='type_price2<?php echo $i ?>'
                                           class="input-radio" type="radio"
                                           name="data[SheetRideDetailRides][<?php echo $i ?>][type_price]"
                                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) { ?>
                                            disabled ='disabled'
                                        <?php } ?>
                                           value="2" <?php if ($rides_sheet_ride['SheetRideDetailRides']['type_price'] == 2) { ?> checked='checked' <?php } ?>>
                                    <span class="label-radio"> <?php echo __('Night') ?></span>
                                </div>
                            <?php }


                            echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.invoiced_ride', array(
                                    'type' => 'hidden',
                                    'id' => 'invoiced_ride' . $i,
                                    'value' => $rides_sheet_ride['SheetRideDetailRides']['invoiced_ride'],
                                    'class' => 'form-control'
                                )) . "</div>";

                            echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.truck_full', array(
                                    'type' => 'hidden',
                                    'id' => 'truck_full' . $i,
                                    'value' => $rides_sheet_ride['SheetRideDetailRides']['truck_full'],
                                    'class' => 'form-control'
                                )) . "</div>";
                            echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.transport_bill_detail_ride', array(
                                    'type' => 'hidden',
                                    'id' => 'transport_bill_detail_ride' . $i,
                                    'value' => $rides_sheet_ride['SheetRideDetailRides']['transport_bill_detail_ride_id'],
                                    'class' => 'form-control'
                                )) . "</div>";

                            echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.observation_id', array(
                                    'type' => 'hidden',
                                    'id' => 'observation' . $i,
                                    'value' => $rides_sheet_ride['SheetRideDetailRides']['observation_id'],
                                    'class' => 'form-control'
                                )) . "</div>";
                            echo "<div class='select-inline ' id='ride-div$i'>";

                            if ($rides_sheet_ride['SheetRideDetailRides']['source'] == 4) {
                                if (Configure::read("gestion_commercial") == '1'){
                                    if( $rides_sheet_ride['SheetRideDetailRides']['status_id']
                                        <= StatusEnum::mission_closed) {

                                        echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.departure_destination_id', array(
                                                'label' => __('Departure city'),
                                                'id' => 'departure_destination' . $i,
                                                'options' => $destinations,
                                                'value' => $rides_sheet_ride['SheetRideDetailRides']['departure_destination_id'],
                                                'class' => 'form-filter select-search-destination',
                                                'onchange' => 'javascript:getInformationRide(this.id);',
                                            )) . "</div>";

                                        echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.arrival_destination_id', array(
                                                'label' => __('Arrival city'),
                                                'id' => 'arrival_destination' . $i,
                                                'options' => $destinations,
                                                'value' => $rides_sheet_ride['SheetRideDetailRides']['arrival_destination_id'],
                                                'class' => 'form-filter select-search-destination',
                                                'onchange' => 'javascript:getInformationRide(this.id);',
                                            )) . "</div>";

                                    }   else {

                                        echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.departure_destination_id', array(
                                                'label' => __('Departure city'),
                                                'id' => 'departure_destination' . $i,
                                                'options' => $destinations,
                                                'disabled'=>true,
                                                'value' => $rides_sheet_ride['SheetRideDetailRides']['departure_destination_id'],
                                                'class' => 'form-filter select-search-destination',
                                                'onchange' => 'javascript:getInformationRide(this.id);',
                                            )) . "</div>";

                                        echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.departure_destination_id', array(
                                                'label' => __('Departure city'),
                                                'id' => 'departure_destination' . $i,
                                                'options' => $destinations,
                                                'type'=>'hidden',
                                                'value' => $rides_sheet_ride['SheetRideDetailRides']['departure_destination_id'],
                                                'class' => 'form-filter',
                                                'onchange' => 'javascript:getInformationRide(this.id);',
                                            )) . "</div>";

                                        echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.arrival_destination_id', array(
                                                'label' => __('Arrival city'),
                                                'id' => 'arrival_destination' . $i,
                                                'options' => $destinations,
                                                'disabled'=>true,
                                                'value' => $rides_sheet_ride['SheetRideDetailRides']['arrival_destination_id'],
                                                'class' => 'form-filter select-search-destination',
                                                'onchange' => 'javascript:getInformationRide(this.id);',
                                            )) . "</div>";

                                        echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.arrival_destination_id', array(
                                                'label' => __('Arrival city'),
                                                'id' => 'arrival_destination' . $i,
                                                'options' => $destinations,
                                                'type'=>'hidden',
                                                'value' => $rides_sheet_ride['SheetRideDetailRides']['arrival_destination_id'],
                                                'class' => 'form-filter ',
                                                'onchange' => 'javascript:getInformationRide(this.id);',
                                            )) . "</div>";




                                    }


                                    echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.price', array(
                                            'label' => __('Price'),
                                            'id' => 'price' . $i,
                                            'class' => 'form-filter',
                                            'value' => $rides_sheet_ride['SheetRideDetailRides']['price'],
                                        )) . "</div>";
                                } else {
                                    echo "<div class='form-group col-sm-6 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.departure_destination_id', array(
                                            'label' => __('Departure city'),
                                            'id' => 'departure_destination' . $i,
                                            'options' => $destinations,
                                            'required' => true,
                                            'value' => $rides_sheet_ride['SheetRideDetailRides']['departure_destination_id'],
                                            'class' => 'form-filter select-search-destination',
                                            'onchange' => 'javascript:getInformationRide(this.id);',
                                        )) . "</div>";

                                    echo "<div class='form-group col-sm-6 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.arrival_destination_id', array(
                                            'label' => __('Arrival city'),
                                            'id' => 'arrival_destination' . $i,
                                            'options' => $destinations,
                                            'required' => true,
                                            'value' => $rides_sheet_ride['SheetRideDetailRides']['arrival_destination_id'],
                                            'class' => 'form-filter select-search-destination',
                                            'onchange' => 'javascript:getInformationRide(this.id);',
                                        )) . "</div>";
                                }
                            } else {

                                if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) {

                                    echo "<div  class='select-inline select-inline2' style='clear: both;'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.detail_ride_id', array(
                                            'label' => __('Ride'),

                                            'empty' => '',
                                            'id' => 'detail_ride' . $i,
                                            'value' => $rides_sheet_ride['DetailRide']['id'],
                                            'disabled' => true,
                                            'onchange' => 'javascript:getInformationRide(this.id);',
                                            'class' => 'form-filter'
                                        )) . "</div>";
                                    echo "<div  class='select-inline select-inline2' style='clear: both;'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.detail_ride_id', array(
                                            'label' => __('Ride'),

                                            'empty' => '',
                                            'id' => 'detail_ride' . $i,
                                            'value' => $rides_sheet_ride['DetailRide']['id'],
                                            'type' => 'hidden',
                                            'onchange' => 'javascript:getInformationRide(this.id);',
                                            'class' => 'form-filter'
                                        )) . "</div>";
                                } else {
                                    echo "<div  class='select-inline select-inline2' style='clear: both;'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.detail_ride_id', array(
                                            'label' => __('Ride'),

                                            'empty' => '',
                                            'id' => 'detail_ride' . $i,
                                            'value' => $rides_sheet_ride['DetailRide']['id'],

                                            'onchange' => 'javascript:getInformationRide(this.id);',
                                            'class' => 'form-filter'
                                        )) . "</div>";
                                }
                            }
                            if ($useRideCategory == 2) {
                                echo "<div  class='select-inline select-inline2' style='clear: both;'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.ride_category_id', array(
                                        'label' => __('Category'),
                                        'id' => 'ride_category' . $i,
                                        'empty' => '',

                                        'value' => $rides_sheet_ride['RideCategory']['id'],

                                        'class' => 'form-filter'
                                    )) . "</div>";
                            }
                            echo "</div>";
                            ?>

                            <?php if ($rides_sheet_ride['SheetRideDetailRides']['type_ride'] = 2) { ?>
                                <div id='distance_duration_ride<?php echo $i ?>'>
                                    <?php
                                    echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.duration_day', array(
                                            'type' => 'hidden',
                                            'id' => 'duration_day' . $i,
                                            'value' => $rides_sheet_ride['DetailRides']['real_duration_day'],
                                            'class' => 'form-control'
                                        )) . "</div>";
                                    echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.duration_hour', array(
                                            'type' => 'hidden',
                                            'id' => 'duration_hour' . $i,
                                            'value' => $rides_sheet_ride['DetailRides']['real_duration_hour'],
                                            'class' => 'form-control'
                                        )) . "</div>";

                                    echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.duration_minute', array(
                                            'type' => 'hidden',
                                            'id' => 'duration_minute' . $i,
                                            'value' => $rides_sheet_ride['DetailRides']['real_duration_minute'],
                                            'class' => 'form-control'
                                        )) . "</div>";
                                    $duration = $rides_sheet_ride['DetailRides']['real_duration_day'] . ' ' . __('Day') . ' ' . $rides_sheet_ride['DetailRides']['real_duration_hour'] . ' ' . __('Hour') . ' ' . $rides_sheet_ride['DetailRides']['real_duration_minute'] . ' ' . __('min');
                                    echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.duration', array(
                                            'label' => __('Duration'),
                                            'disabled' => true,
                                            'value' => $duration,
                                            'class' => 'form-filter'
                                        )) . "</div>";
                                    echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.distance', array(
                                            'readonly' => true,
                                            'id' => 'distance' . $i,
                                            'value' => $rides_sheet_ride['Rides']['distance'],
                                            'class' => 'form-filter'
                                        )) . "</div>"; ?>

                                </div>
                                <?php
                            } else {
                                ?>
                                <div id='distance_duration_ride<?php echo $i ?>'>
                                    <?php
                                    echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.duration_day', array(
                                            'type' => 'hidden',
                                            'id' => 'duration_day' . $i,
                                            'value' => $rides_sheet_ride['DetailRide']['real_duration_day'],
                                            'class' => 'form-control'
                                        )) . "</div>";
                                    echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.duration_hour', array(
                                            'type' => 'hidden',
                                            'id' => 'duration_hour' . $i,
                                            'value' => $rides_sheet_ride['DetailRide']['real_duration_hour'],
                                            'class' => 'form-control'
                                        )) . "</div>";

                                    echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.duration_minute', array(
                                            'type' => 'hidden',
                                            'id' => 'duration_minute' . $i,
                                            'value' => $rides_sheet_ride['DetailRide']['real_duration_minute'],
                                            'class' => 'form-control'
                                        )) . "</div>";
                                    $duration = $rides_sheet_ride['DetailRide']['real_duration_day'] . ' ' . __('Day') . ' ' . $rides_sheet_ride['DetailRide']['real_duration_hour'] . ' ' . __('Hour') . ' ' . $rides_sheet_ride['DetailRide']['real_duration_minute'] . ' ' . __('min');
                                    echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.duration', array(
                                            'label' => __('Duration'),
                                            'disabled' => true,
                                            'value' => $duration,
                                            'class' => 'form-filter'
                                        )) . "</div>";

                                    ?>


                                    <?php   echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.distance', array(
                                            'readonly' => true,
                                            'id' => 'distance' . $i,
                                            'value' => $rides_sheet_ride['Ride']['distance'],
                                            'class' => 'form-filter'
                                        )) . "</div>"; ?>

                                </div>
                                <?php
                            }
                            echo "<div style='clear:both; padding-top: 10px;'></div>";
                            if (Configure::read("gestion_commercial") == '1') {
                                if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) {

                                    echo "<div class='select-inline' id='client-initial-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_id', array(
                                            'label' => __('Initial customer'),
                                            'empty' => '',
                                            'id' => 'client' . $i,
                                            'disabled' => true,
                                            'value' => $rides_sheet_ride['Supplier']['id'],
                                            'onchange' => 'javascript:getMarchandisesByClient(this.id), getAttachmentsByClient(this.id) , getFinalSupplierByInitialSupplier(this.id);',
                                            'class' => 'form-filter select-search-client-initial'
                                        )) . "</div>";

                                    echo "<div class='select-inline' id='client-initial-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_id', array(
                                            'label' => __('Initial customer'),
                                            'empty' => '',
                                            'id' => 'client' . $i,
                                            'type' => 'hidden',
                                            'value' => $rides_sheet_ride['Supplier']['id'],
                                            'onchange' => 'javascript:getMarchandisesByClient(this.id), getAttachmentsByClient(this.id) , getFinalSupplierByInitialSupplier(this.id);',
                                            'class' => 'form-filter'
                                        )) . "</div>";


                                } else {
                                    echo "<div class='select-inline' id='client-initial-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_id', array(
                                            'label' => __('Initial customer'),
                                            'empty' => '',
                                            'id' => 'client' . $i,
                                            'value' => $rides_sheet_ride['Supplier']['id'],
                                            'onchange' => 'javascript:getMarchandisesByClient(this.id), getAttachmentsByClient(this.id) , getFinalSupplierByInitialSupplier(this.id);',
                                            'class' => 'form-filter select-search-client-initial'
                                        )) . "</div>";
                                }
                            }


                            echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.km_departure', array(
                                    'label' => __('Departure Km'),
                                    'onchange' => 'javascript:calculKmArrivalEstimated(this.id), verifyKmEntred(this.id,"departure");',
                                    'value' => $rides_sheet_ride['SheetRideDetailRides']['km_departure'],
                                    'id' => 'km_departure' . $i,
                                    'class' => 'form-filter'
                                )) . "</div>";


                            echo "<div class='datedep'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.planned_start_date', array(
                                    'label' => '',
                                    'type' => 'text',
                                    'value' => $this->Time->format($rides_sheet_ride['SheetRideDetailRides']['planned_start_date'], '%d/%m/%Y %H:%M'),
                                    'class' => 'form-control datemask',
                                    'placeholder' => _('dd/mm/yyyy hh:mm'),
                                    'before' => '<label class="dte">' . __('Planned Departure date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'planned_start_date' . $i,
                                    'onchange' => 'javascript:calculPlannedArrivalDate(this.id);',
                                )) . "</div>";

                            echo "<div class='datedep'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.real_start_date', array(
                                    'label' => '',
                                    'type' => 'text',
                                    'value' => $this->Time->format($rides_sheet_ride['SheetRideDetailRides']['real_start_date'], '%d/%m/%Y %H:%M'),
                                    'class' => 'form-control datemask',
                                    'placeholder' => _('dd/mm/yyyy hh:mm'),
                                    'before' => '<label class="dte">' . __('Real Departure date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'real_start_date' . $i,
                                    'onchange' => 'javascript:calculPlannedArrivalDate(this.id);',
                                )) . "</div>";
                            echo "<div style='clear:both; padding-top: 10px;'></div>";

                            if ($displayMissionCost == 2) {

                                echo "<div class ='scroll-block'>";
                                echo "<div class='lbl2'> <a href='#demo$i' data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Mission costs") . "</a></div>";
                                echo "<div id='demo$i' class='collapse'>";

                                if (!empty($rides_sheet_ride['SheetRideDetailRides']['mission_cost'])) {
                                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                            'label' => __('Mission cost'),
                                            'value' => $rides_sheet_ride['SheetRideDetailRides']['mission_cost'],
                                            'placeholder' => __('Enter mission cost'),
                                            'id' => 'mission_cost' . $i,
                                            'class' => 'form-filter'
                                        )) . "</div>";

                                } else {
                                    switch ($managementParameterMissionCost) {

                                        case '1':
                                            if (!empty($missionCost['mission_cost_day'])) {
                                                echo "<div  class='select-inline' >" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                                        'label' => __('Mission cost'),
                                                        'placeholder' => __('Enter mission cost'),
                                                        'id' => 'mission_cost' . $i,
                                                        'value' => $missionCost[$i]['MissionCost']['cost_day'],
                                                        'class' => 'form-filter'
                                                    )) . "</div>";
                                            } else {
                                                echo "<div  class='select-inline' >" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                                        'label' => __('Mission cost'),
                                                        'placeholder' => __('Enter mission cost'),
                                                        'id' => 'mission_cost' . $i,
                                                        'class' => 'form-filter'
                                                    )) . "</div>";
                                            }
                                            break;

                                        case '2':
                                            if (!empty($missionCost['mission_cost_mission'])) {
                                                echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                                        'label' => __('Mission cost'),
                                                        'placeholder' => __('Enter mission cost'),
                                                        'id' => 'mission_cost' . $i,
                                                        'value' => $missionCost[$i]['MissionCost']['cost_destination'],
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
                                            if (!empty($missionCost[$i]['MissionCost']['cost_truck_full'])) {
                                                echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                                        'label' => __('Mission cost'),
                                                        'placeholder' => __('Enter mission cost'),
                                                        'id' => 'mission_cost' . $i,
                                                        'value' => $missionCost[$i]['MissionCost']['cost_truck_full'],
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
                                }

                                echo '</div>';
                                echo '</div>';

                            } else {

                                if (!empty($rides_sheet_ride['SheetRideDetailRides']['mission_cost'])) {
                                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                            'label' => __('Mission cost'),
                                            'type' => 'hidden',
                                            'placeholder' => __('Enter mission cost'),
                                            'id' => 'mission_cost' . $i,
                                            'class' => 'form-filter'
                                        )) . "</div>";

                                } else {
                                    switch ($managementParameterMissionCost) {
                                        case '1':
                                            echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                                    'label' => __('Mission cost'),
                                                    'type' => 'hidden',
                                                    'placeholder' => __('Enter mission cost'),
                                                    'id' => 'mission_cost' . $i,
                                                    'value' => $missionCost['mission_cost_day'],
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
                                                    'class' => 'form-filter'
                                                )) . "</div>";
                                            break;

                                    }
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
                                        'value'=>$rides_sheet_ride['SheetRideDetailRides']['toll'],
                                        'placeholder' => __('Enter toll'),
                                        'id' => 'toll' . $i,
                                        'class' => 'form-filter '
                                    )) . "</div>";
                                ?>
                            </div>
                        </div>

                        <?php

                        echo "<div class ='scroll-block'>";
                        echo "<div class='lbl2'> <a href='#note$i' data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Observation") . "</a></div>";
                        echo "<div id='note$i' class='collapse'><br>";
                        echo "<div class='select-inline' >" . $this->Form->input('SheetRideDetailRides.' . $i . '.note', array(
                                'label' => __('Observation'),
                                'value' => $rides_sheet_ride['SheetRideDetailRides']['note'],
                                'class' => 'form-control'
                            )) . "</div>";
                        echo "</div>";
                        echo "</div>";

                        ?>
                        <div id='cost_contractor_div<?php echo $i; ?>' style='display: block'>

        </div>

        </td>
        </tr>
        <tr id="arrive<?php echo $i ?>" <?php if ($isAgent) {?> class='hidden'<?php } ?>>
            <td>arrivée<?php echo $i ?></td>
            <td>
                <div class="filters" id='filters'>
                    <?php

                    if (Configure::read("gestion_commercial") == '1') {

                        if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) {
                            echo "<div class='select-inline' id='client-final-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_final_id', array(
                                    'label' => __('Final customer'),
                                    'empty' => '',
                                    'options' => $finalSuppliers,
                                    'value' => $rides_sheet_ride['SupplierFinal']['id'],
                                    'disabled' => true,
                                    'class' => 'form-filter'
                                )) . "</div>";
                            echo "<div class='select-inline' >" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_final_id', array(
                                    'label' => __('Final customer'),
                                    'empty' => '',
                                    'id' => 'client_final',
                                    //'options' => $finalSuppliers,
                                    'value' => $rides_sheet_ride['SupplierFinal']['id'],
                                    'type' => 'hidden',
                                    'class' => 'form-filter'
                                )) . "</div>";

                        } else {
                            echo "<div class='select-inline' id='client-final-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_final_id', array(
                                    'label' => __('Final customer'),
                                    'empty' => '',
                                    'id' => 'client_final' . $i,
                                    'options' => $finalSuppliers,
                                    'value' => $rides_sheet_ride['SupplierFinal']['id'],
                                    // 'disabled'=>true,
                                    'class' => 'form-filter select-search-client-final-i'
                                )) . "</div>";
                        }
                    }

                    echo "<div  class='datedep'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.planned_end_date', array(
                            'label' => '',
                            'type' => 'text',
                            'value' => $this->Time->format($rides_sheet_ride['SheetRideDetailRides']['planned_end_date'], '%d/%m/%Y %H:%M'),
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
                            'value' => $rides_sheet_ride['SheetRideDetailRides']['remaining_time'],
                            'type' => 'hidden'
                        )) . "</div>";

                    echo "<div  class='datedep'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.real_end_date', array(
                            'label' => '',
                            'type' => 'text',
                            'value' => $this->Time->format($rides_sheet_ride['SheetRideDetailRides']['real_end_date'], '%d/%m/%Y %H:%M'),
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
                            'value' => $rides_sheet_ride['SheetRideDetailRides']['km_arrival_estimated'],
                            'class' => 'form-filter'
                        )) . "</div>";

                    echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.km_arrival', array(
                            'label' => __('Arrival Km'),
                            'value' => $rides_sheet_ride['SheetRideDetailRides']['km_arrival'],
                            'id' => 'km_arrival' . $i,
                            'onchange' => 'javascript: calculateKmArrivalParc(this.id), verifyKmEntred(this.id,"arrival");',
                            'class' => 'form-filter'
                        )) . "</div>";

                    ?>
                    <?php
                    echo "<div style='clear:both; padding-top: 10px;'></div>"; ?>

                    <div class="scroll-block100">
                        <?php echo "<div class='lbl2'> <a href='#piece$i' data-toggle='collapse' id='pieceClient$i' onclick='getAttachmentsByClient(this.id)'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Attachments") . "</a></div>";

                        echo "<div id='piece$i' class='collapse'>";

                        echo "<div id = 'piece-div$i'>";

                        echo "</div>";
                        echo "</div>";?>
                    </div>
                    </br>

                    <div class="scroll-block100">
                        <?php
                        echo "<div class='lbl2'> <a href='#march$i' id='marchandiseClient$i' onclick='getSavedMarchandises(this.id)' data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Marchandises") . "</a></div>";
                        echo "<div id='march$i' class='collapse'>";
                        echo "<div id='marchandise-div$i' class='marchandise-input'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.marchandise_id', array(
                                'label' => __(''),
                                'empty' => '',
                                'id' => 'marchandise' . $i,
                                'multiple' => true,
                                'class' => 'form-filter select3'
                            )) . "</div>";
                        echo "</div>";
                        echo "</div>";



                        ?>

                    </div>
                    <?php

                    if($usePurchaseBill == '1'){ ?>
                        <div class="scroll-block100" style="margin-top: 5px;">
                            <?php echo "<div class='lbl2'> <a href='#lot$i' id ='lotClient$i' onclick='getLots(this.id)'  data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Products") . "</a></div>";

                            echo "<div id='lot$i' class='collapse'>";
                            echo "<div id = 'lot-div$i'>";
                            echo "<div>" . $this->Form->input('SheetRideDetailRides.' . $i . '.edit_lot', array(
                                    'type' => 'hidden',
                                    'value' => '0',
                                    'id' => 'edit_lot' . $i,
                                    'multiple' => true,
                                    'class' => 'form-filter '
                                )) . "</div>";
                            echo "</div>";

                            ?>
                        </div>
                    <?php } ?>

                </div>
                <!-- COMPONENT END -->
            </td>
        </tr>

    </div>
    <?php $i++;
    }
    if (!empty($transportBillDetailRide)) {
    ?>

    <tr id="depart<?php echo $i ?>">
        <td rowspan='2'>Missions N° <?php echo $i ;
            echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.order_mission', array(
                    'class' => 'form-filter',
                    'value' => $i,
                    'label' => '',
                )) . "</div>";
            ?></td>
        <td>Depart <?php echo $i ?></td>
        <td>
            <div class="filters" id='filters'>
                <?php

                if (!empty($transportBillDetailRide)) {
                if ($referenceMission == '1') {

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
                <div class="input-radio">

                    <p class="p-radio"><?php echo __('Truck full') ?></p>

                    <input id='truck_full1<?php echo $i ?>' class="input-radio"
                           type="radio" name="data[SheetRideDetailRides][<?php echo $i ?>][truck_full]"
                           value="1">
                    <span class="label-radio"><?php echo __('Yes') ?></span>
                    <input id='truck_full2<?php echo $i ?>'
                           class="input-radio" type="radio" checked='checked'
                           name="data[SheetRideDetailRides][<?php echo $i ?>][truck_full]" value="2">
                    <span class="label-radio"> <?php echo __('No') ?></span>
                </div>
                <div class="input-radio">
                    <p class="p-radio"><?php echo __('Type mission') ?></p>

                    <input id='return_mission1<?php echo $i ?>' class="input-radio"
                           type="radio" name="data[SheetRideDetailRides][<?php echo $i ?>][return_mission]"
                           value="1">
                    <span class="label-radio"><?php echo __('Simple delivery') ?></span>
                    <input id='return_mission2<?php echo $i ?>'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][return_mission]" value="2"
                           checked='checked'>
                    <span class="label-radio"> <?php echo __('Simple return') ?></span>
                </div>
                <?php if ($paramPriceNight == 1) { ?>
                    <div class="input-radio">
                        <p class="p-radio"><?php echo __('Price') ?></p>

                        <input id='type_price1<?php echo $i ?>' class="input-radio"
                               type="radio" name="data[SheetRideDetailRides][<?php echo $i ?>][type_price]"
                               value="1"
                               <?php if ($transportBillDetailRide['TransportBillDetailRides']['type_price'] == 1) { ?>checked='checked' <?php } ?>>
                        <span class="label-radio"><?php echo __('Day') ?></span>
                        <input id='type_price2<?php echo $i ?>'
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
                    echo "<div class='form-group col-sm-2 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.departure_destination_id', array(
                            'label' => __('Departure city'),
                            'disabled' => true,
                            'options' => $departure,
                            'value' => $transportBillDetailRide['Departure']['id'],
                            'class' => 'form-filter'
                        )) . "</div>";

                    echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.departure_destination_id', array(
                            'label' => __('Ride'),
                            'value' => $transportBillDetailRide['Departure']['id'],
                            'id' => 'departure_destination' . $i,
                            'type' => 'hidden',
                            'options' => $departure,
                            'class' => 'form-filter'
                        )) . "</div>";

                    if(!empty($transportBillDetailRide['Arrival']['id'])) {
                        echo "<div class='form-group col-sm-2 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.arrival_destination_id', array(
                                'label' => __('Arrival city'),
                                'disabled' => true,
                                'options' => $arrival,
                                'value' => $transportBillDetailRide['Arrival']['id'],
                                'class' => 'form-filter'
                            )) . "</div>";

                        echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.arrival_destination_id', array(
                                'label' => __('Ride'),
                                'value' => $transportBillDetailRide['Arrival']['id'],
                                'id' => 'arrival_destination' . $i,
                                'type' => 'hidden',
                                'options' => $arrival,
                                'class' => 'form-filter'
                            )) . "</div>";
                    }else {
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
                            'options' => $detailRide,
                            'value' => $transportBillDetailRide['TransportBillDetailRides']['detail_ride_id'],
                            'empty' => __('Select ride'),
                            'class' => 'form-filter'
                        )) . "</div>";

                    echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.detail_ride_id', array(
                            'label' => __('Ride'),
                            'value' => $transportBillDetailRide['TransportBillDetailRides']['id'],
                            'empty' => __('Select ride'),
                            'id' => 'detail_ride' . $i,
                            'options' => $detailRide,
                            'type' => 'hidden',
                            'class' => 'form-filter'
                        )) . "</div>";
                }
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
                echo "<div id='client-initial-div$i'>";
                echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_id', array(
                        'label' => __('Initial customer'),
                        'empty' => '',
                        'id' => 'client' . $i,
                        'options' => $supplier,
                        'value' => $transportBillDetailRide['Supplier']['id'],
                        'disabled' => true,
                        'onchange' => 'javascript:getMarchandisesByClient(this.id), getAttachmentsByClient(this.id);',
                        'class' => 'form-filter'
                    )) . "</div>";

                echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_id', array(
                        'label' => __('Initial customer'),
                        'empty' => '',
                        'id' => 'client' . $i,
                        'options' => $supplier,
                        'value' => $transportBillDetailRide['Supplier']['id'],
                        'type' => 'hidden',
                        'class' => 'form-filter'
                    )) . "</div>";
                echo "</div>";
                echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.km_departure', array(
                        'label' => __('Departure Km'),
                        'onchange' => 'javascript:calculKmArrivalEstimated(this.id);',
                        'id' => 'km_departure' . $i,
                        'class' => 'form-filter'
                    )) . "</div>";

                echo "<div class='datedep'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.planned_start_date', array(
                        'label' => '',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'placeholder' => _('dd/mm/yyyy hh:mm'),
                        'before' => '<label class="dte">' . __('Planned Departure date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'planned_start_date' . $i,
                        'onchange' => 'javascript:calculPlannedArrivalDate(this.id);',
                    )) . "</div>";


                echo "<div class='datedep'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.real_start_date', array(
                        'label' => '',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'placeholder' => _('dd/mm/yyyy hh:mm'),
                        'before' => '<label class="dte">' . __('Real Departure date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'real_start_date' . $i,
                        'onchange' => 'javascript:calculPlannedArrivalDate(this.id);',
                    )) . "</div>";
                echo "<div style='clear:both; padding-top: 10px;'></div>";
                if ($displayMissionCost == 2) {
                    echo "<div class ='scroll-block'>";
                    echo '<div class="lbl2"> <a href="#demoMissionCost" data-toggle="collapse"><i class="fa fa-angle-double-right" style="padding-right: 10px;"></i>' . __("Mission costs") . '</a></div>'; ?>
                    <div id="demoMissionCost" class="collapse">
                        <br>
                        <?php
                        switch ($managementParameterMissionCost) {
                            case '1':
                                echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                        'label' => __('Mission cost'),
                                        'placeholder' => __('Enter mission cost'),
                                        'id' => 'mission_cost' . $i,
                                        'value' => $missionCost['cost_day'],
                                        'class' => 'form-filter'
                                    )) . "</div>";
                                break;

                            case '2':
                                echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                        'label' => __('Mission cost'),
                                        'placeholder' => __('Enter mission cost'),
                                        'id' => 'mission_cost' . $i,
                                        'value' => $missionCost['cost_destination'],
                                        'class' => 'form-filter'
                                    )) . "</div>";
                                break;

                            case '3':

                                echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                        'label' => __('Mission cost'),
                                        'placeholder' => __('Enter mission cost'),
                                        'id' => 'mission_cost' . $i,
                                        'value' => $missionCost['MissionCost']['cost_truck_full'],
                                        'class' => 'form-filter'
                                    )) . "</div>";
                                break;
                        }
                        ?>
                    </div>

                    <?php
                } else {
                    switch ($managementParameterMissionCost) {
                        case '1':
                            echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                    'label' => __('Mission cost'),
                                    'type' => 'hidden',
                                    'placeholder' => __('Enter mission cost'),
                                    'id' => 'mission_cost' . $i,
                                    'value' => $missionCost['mission_cost_day'],
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
                                    'class' => 'form-filter'
                                )) . "</div>";
                            break;

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


            }
            ?>
            <div id='cost_contractor_div<?php echo $i; ?>' style='display: block'>
</div>


    </td>
    </tr>
    <tr id="arrive<?php echo $i ?>">
        <td>arrivée<?php echo $i ?></td>
        <td>
            <div class="filters" id='filters'>
                <?php
                if (!empty($transportBillDetailRide)) {
                    echo "<div id='client-final-div$i'>";
                    echo "<div class='select-inline' >" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_final_id', array(
                            'label' => __('Final customer'),
                            'empty' => '',
                            'id' => 'client_final',
                            'options' => $finalSupplier,
                            'value' => $transportBillDetailRide['SupplierFinal']['id'],
                            'disabled' => true,
                            'class' => 'form-filter'
                        )) . "</div>";
                    echo "<div >" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_final_id', array(
                            'label' => __('Final customer'),
                            'empty' => '',
                            'id' => 'client_final',
                            'options' => $finalSupplier,
                            'value' => $transportBillDetailRide['SupplierFinal']['id'],
                            'type' => 'hidden',
                            'class' => 'form-filter'
                        )) . "</div>";

                    echo "</div>";
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
                }
                ?>
                <div class="scroll-block100">
                    <?php echo "<div class='lbl2'> <a href='#piece$i' data-toggle='collapse' id='pieceClient$i' onclick='getAttachmentsByClient(this.id)'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Attachments") . "</a></div>";

                    echo "<div id='piece$i' class='collapse'>";
                    echo "<div id = 'piece-div$i'>";
                    echo "</div>" ?>
                </div>
                </br>
                <div class="scroll-block100">
                    <?php echo "<div class='lbl2'> <a href='#march$i' id='marchandiseClient$i' onclick='getMarchandisesByClient(this.id)' data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Marchandises") . "</a></div>";
                    echo "<div id='march$i' class='collapse'>";
                    echo "<div id='marchandise-div$i'></div>";
                    echo "</div>";
                    echo "</div>";

                    ?>
                </div>
                </br>
                </br>
                <?php

                if($usePurchaseBill == '1'){ ?>
                    <div class="scroll-block100" style="margin-top: 5px;">
                        <?php echo "<div class='lbl2'> <a href='#lot$i' id ='lotClient$i' onclick='getLots(this.id)'  data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Products") . "</a></div>";

                        echo "<div id='lot$i' class='collapse'>";
                        echo "<div id = 'lot-div$i'>";
                        echo "</div>";

                        ?>
                    </div>
                <?php } ?>

            </div>


        </td>

    </tr>



<?php }