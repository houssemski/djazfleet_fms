
<td rowspan='2'>Itinéraire N° <?php echo $i ;
    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.order_mission', array(
            'class' => 'form-filter',
            'type' => 'hidden',
            'value' => $i,
            'label' => '',
        )) . "</div>";
    ?>
    <div id ='div-remove<?php echo $i ?>'>
        <button  name="remove" id="remove<?php echo $i ?>" onclick="removeMission('<?php echo $i ?>');" class="btn btn-danger btn_remove">X</button>
    </div>
</td>
<td>Depart <?php echo $i ?></td>
<td>
    <div class="filters" id='filters'>
        <?php    if ($referenceMission == '1') {
            echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.reference', array(
                    'label' => __('Reference'),
                    'class' => 'form-filter',
                    'placeholder' => __('Enter reference'),
                )) . "</div>";
        } ?>



            <?php



                echo "<div id='ride-div$i'  class='select-inline '>";
                echo "<div class='form-group col-sm-6 clear-none p-l-0 form-sm-6'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.departure_destination_id', array(
                        'label' => __('Departure point'),
                        'required'=>true,
                        'id' => 'departure_destination' . $i,
                        'class' => 'form-control select-search-destination',
                        'onchange' => 'javascript:getInformationRide(this.id);',
                    )) . "</div>";

                echo "<div class='form-group col-sm-6 clear-none p-l-0 form-sm-6'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.arrival_destination_id', array(
                        'label' => __('Arrival point'),
                        'required'=>true,
                        'id' => 'arrival_destination' . $i,
                        'class' => 'form-control select-search-destination',
                        'onchange' => 'javascript:getInformationRide(this.id);',
                    )) . "</div>";
                echo "</div>";

            ?>
            <div  id='distance_duration_ride<?php echo $i ?>'>
            </div>
            <div id='ride_between_two_ride<?php echo $i ?>'>
            </div>

            <?php
            echo "<div style='clear:both; padding-top: 10px;'></div>";

            echo "<div class='select-inline'>".$this->Form->input('SheetRideDetailRides.'.$i.'.km_departure', array(
                    'label' => __('Departure Km'),
                    'onchange'=>'javascript:calculKmArrivalEstimated(this.id), verifyKmEntred(this.id,"departure");',
                    'id'=>'km_departure'.$i,
                    'class' => 'form-filter'
                ))."</div>";


            echo "<div class='datedep'>".$this->Form->input('SheetRideDetailRides.'.$i.'.planned_start_date', array(
                    'label' => '',
                    'type' => 'text',
                    'onchange'=>'javascript:calculPlannedArrivalDate(this.id);',
                    'class' => 'form-control datemask',
                    'placeholder'=>_('dd/mm/yyyy hh:mm'),
                    'before' => '<label class="dte">' . __('Planned Departure date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'planned_start_date'.$i,
                ))."</div>";

            echo "<div class='datedep'>".$this->Form->input('SheetRideDetailRides.'.$i.'.real_start_date', array(
                    'label' => '',
                    'type' => 'text',
                    'onchange'=>'javascript:calculPlannedArrivalDate(this.id);',
                    'class' => 'form-control datemask',
                    'placeholder'=>_('dd/mm/yyyy hh:mm'),
                    'before' => '<label class="dte">' . __('Real Departure date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'real_start_date'.$i,
                ))."</div>";
            echo "<div style='clear:both; padding-top: 10px;'></div>";


    ?>

    </div>



</td>