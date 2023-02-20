



<?php
$i = 1;
?>
<tr id="depart<?php echo $i ?>">
    <td rowspan='2'>Mission N° <?php echo $i ;
        echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.order_mission', array(
                'class' => 'form-filter',
                'value' => $i,
                'label' => '',
            )) . "</div>";
        ?></td>
    <td>Départ <?php echo $i ?></td>
    <td>

        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #435966;;">
                    <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse" href="#collapseDepart<?php echo $i;?>"
                           style="font-weight: 700;"><?php echo __('Départ') ?> </a>

                    </h4>
                </div>
                <div id="collapseDepart<?php echo $i;?>" class="panel-collapse collapse">
                    <div class="panel-body">

        <div class="filters" id='filters'>
            <?php

            if ($isReferenceMissionAutomatic == '1') {
                echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.reference', array(
                        'label' => __('Reference'),
                        'class' => 'form-filter',
                        'placeholder' => __('Enter reference'),
                    )) . "</div>";
            }

            ?>
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

                    <input
                           class="hidden" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][invoiced_ride]"
                           value="2" checked='checked'>

                <input
                           class="hidden" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][truck_full]"
                           value="2" checked='checked'>



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



                    ?>
                    <div id='distance_duration_ride<?php echo $i ?>'>
                    </div>



                    <?php
                    echo "<div style='clear:both; padding-top: 10px;'></div>";





                        echo "<div  class='select-inline' >" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_id', array(
                                'label' => __('Client'),
                                'empty' => __('Select client'),
                                'id' => 'client' . $i,
                                'class' => 'form-filter select-search-client-initial',
                                'onchange' => 'javascript:getMarchandisesByClient(this.id), getAttachmentsByClient(this.id), getFinalSupplierByInitialSupplier(this.id);'
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


                if ($displayMissionCost == 2){
                echo "<div class ='scroll-block'>";
                echo '<div class="lbl2"> <a href="#demoMissionCost" data-toggle="collapse"><i class="fa fa-angle-double-right" style="padding-right: 10px;"></i>' . __("Mission costs") . '</a></div>'; ?>
                <div id="demoMissionCost" class="collapse">
                    <br>

                    <?php

                        echo "<div  class='select-inline' id='mission-cost-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                                'label' => __('Mission cost'),
                                'placeholder' => __('Enter mission cost'),
                                'id' => 'mission_cost' . $i,
                                'class' => 'form-filter '
                            )) . "</div>";



                    ?>
                </div>
            </div>

        <?php
        } else {



                echo "<div  class='select-inline' id='mission-cost-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                        'label' => __('Mission cost'),
                        'placeholder' => __('Enter mission cost'),
                        'id' => 'mission_cost' . $i,
                        'type' => 'hidden',
                        'class' => 'form-control '
                    )) . "</div>";



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
        ?>
        <div id='cost_contractor_div<?php echo $i; ?>' style='display: block'>

        </div>
        </div>
                </div>
            </div>
        </div>


        </div>
    </td>
</tr>
<tr id="arrive<?php echo $i ?>">
    <td>arrivée<?php echo $i ?></td>
    <td>
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #435966;;">
                    <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse" href="#collapseArrive<?php echo $i;?>"
                           style="font-weight: 700;"><?php echo __('Arrivée') ?> </a>

                    </h4>
                </div>
                <div id="collapseArrive<?php echo $i;?>" class="panel-collapse collapse">
                    <div class="panel-body">
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
        <div class="scroll-block100">
            <?php echo "<div class='lbl2'> <a href='#piece$i' data-toggle='collapse' id='pieceClient$i' onclick='getAttachmentsByClient(this.id)'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Attachments") . "</a></div>";

            echo "<div id='piece$i' class='collapse'>";
            echo "<div id = 'piece-div$i'>";
            echo "</div>" ?>
        </div>
                    </div>
                </div>
            </div>


        </div>
        </br>


    </td>
</tr>


