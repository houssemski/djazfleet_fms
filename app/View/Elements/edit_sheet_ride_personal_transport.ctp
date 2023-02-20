<?php
$init = 0;
$i = 1;
echo "<div class='select-inline' >" . $this->Form->input('Missions.deleted_id', array(
        'type' => 'hidden',
        'id' => 'missions_deleted_id',
        'value' => ''
    )) . "</div>";
foreach ($rides_sheet_rides as $rides_sheet_ride){
    if($i%2 == 1){
        $style = 'background-color: #f2f2f2;';
    }else {
        $style ='';
    }
    ?>

    <tr style ="<?php echo $style ?>" id="depart<?php echo $i ?>" <?php if ($isAgent) {?> class='hidden'<?php } ?>>
        <td  rowspan='2'>Itinéraire N° <?php echo $i ;
            echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.order_mission', array(
                    'class' => 'form-filter',
                    'type' => 'hidden',
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
                echo "<div>" . $this->Form->input('SheetRideDetailRides.' . $i . '.id', array(

                        'type' => 'hidden',
                        'id' => 'sheet_ride_detail_ride' . $i,
                        'value' => $rides_sheet_ride['SheetRideDetailRides']['id'],

                        'class' => 'form-control'
                    )) . "</div>";
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


                echo "<div class='select-inline ' id='ride-div$i'>";

                echo "<div class='form-group col-sm-6 clear-none p-l-0 form-sm-6'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.departure_destination_id', array(
                        'label' => __('Departure point'),
                        'id' => 'departure_destination' . $i,
                        'options' => $destinations,
                        'required' => true,
                        'value' => $rides_sheet_ride['SheetRideDetailRides']['departure_destination_id'],
                        'class' => 'form-filter select-search-destination',
                        'onchange' => 'javascript:getInformationRide(this.id);',
                    )) . "</div>";

                echo "<div class='form-group col-sm-6 clear-none p-l-0 form-sm-6'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.arrival_destination_id', array(
                        'label' => __('Arrival point'),
                        'id' => 'arrival_destination' . $i,
                        'options' => $destinations,
                        'required' => true,
                        'value' => $rides_sheet_ride['SheetRideDetailRides']['arrival_destination_id'],
                        'class' => 'form-filter select-search-destination',
                        'onchange' => 'javascript:getInformationRide(this.id);',
                    )) . "</div>";

                echo "</div>";
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

                echo "<div style='clear:both; padding-top: 10px;'></div>";



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

                ?>


            </div>


            </div>

        </td>
    </tr>
    <tr style ="<?php echo $style ?>" id="arrive<?php echo $i ?>" <?php if ($isAgent) {?> class='hidden'<?php } ?>>
        <td>arrivée<?php echo $i ?></td>
        <td>
            <div class="filters" id='filters'>
                <?php



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








            </div>
            <!-- COMPONENT END -->
        </td>
    </tr>

    </div>
    <?php $i++;
}