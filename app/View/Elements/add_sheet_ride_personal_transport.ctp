
<?php
$i = 1;
?>
<tr style="background-color: #f2f2f2;" id="depart<?php echo $i ?>">
    <td rowspan='2'>Itinéraire N° <?php echo $i ;
        echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.order_mission', array(
                'class' => 'form-filter',
                'type' => 'hidden',
                'value' => $i,
                'label' => '',
            )) . "</div>";
        ?></td>
    <td>Départ <?php echo $i ?></td>
    <td>
        <div class="filters" id='filters'>
            <?php

            if ($isReferenceMissionAutomatic == '1') {
                echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.reference', array(
                        'label' => __('Reference'),
                        'class' => 'form-filter',
                        'placeholder' => __('Enter reference'),
                    )) . "</div>";
            } ?>



                <?php
                echo "<div style='clear:both; padding-top: 10px;'></div>";

                echo "<div class='select-inline '>";

                    echo "<div class='form-group col-sm-6 clear-none p-l-0 form-sm-6'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.departure_destination_id', array(
                            'label' => __('Departure point'),
                            'id' => 'departure_destination' . $i,
                            'class' => 'form-control select-search-destination',
                            'onchange' => 'javascript:getInformationRide(this.id);',
                        )) . "</div>";

                    echo "<div class='form-group col-sm-6 clear-none p-l-0 form-sm-6'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.arrival_destination_id', array(
                            'label' => __('Arrival point'),
                            'id' => 'arrival_destination' . $i,
                            'class' => 'form-control select-search-destination',
                            'onchange' => 'javascript:getInformationRide(this.id);',
                        )) . "</div>";


                echo "</div>";

                    ?>
                    <div id='distance_duration_ride<?php echo $i ?>'>


                    </div>



                    <?php
                    echo "<div style='clear:both; padding-top: 10px;'></div>";





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
                echo "<div style='clear:both; padding-top: 10px;'></div>";






        ?>

        </div>
    </td>
</tr>
<tr style="background-color: #f2f2f2;" id="arrive<?php echo $i ?>">
    <td>arrivée<?php echo $i ?></td>
    <td>
        <div class="filters" id='filters'>
            <?php



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


    </td>
</tr>