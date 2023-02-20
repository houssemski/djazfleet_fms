
<td rowspan='2'>Missions N° <?php echo $i ;
    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.order_mission', array(
            'class' => 'form-filter',
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
        <?php   if (Configure::read("gestion_commercial") == '1') {
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
                   value="4">
            <span class="label-radio"> <?php echo __('Personalized ride') ?></span>

            <?php
            } ?>

            <?php if (Configure::read("gestion_commercial") == '1') { ?>
                <div class="input-radio">
                    <p class="p-radio"><?php echo __('Invoiced ride')?></p>

                    <input id='invoiced_ride1<?php echo $i?>' class="input-radio" type="radio" name="data[SheetRideDetailRides][<?php echo $i?>][invoiced_ride]" value="1" checked='checked'>
                    <span class="label-radio"><?php echo __('Yes')?></span>
                    <input id='invoiced_ride2<?php echo $i?>' class="input-radio" type="radio" name="data[SheetRideDetailRides][<?php echo $i?>][invoiced_ride]" value="2">
                    <span class="label-radio"> <?php echo __('No')?></span>
                </div>

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

                <input id='return_mission1<?php echo $i ?>' class="input-radio"
                       type="radio" name="data[SheetRideDetailRides][<?php echo $i ?>][return_mission]"
                       value="1" checked='checked'>
                <span class="label-radio"><?php echo __('Simple delivery') ?></span>
                <input id='return_mission2<?php echo $i ?>'
                       class="input-radio" type="radio"
                       name="data[SheetRideDetailRides][<?php echo $i ?>][return_mission]" value="2" >
                <span class="label-radio"> <?php echo __('Simple return') ?></span>
                <input id='return_mission3<?php echo $i ?>'
                       class="input-radio" type="radio"
                       name="data[SheetRideDetailRides][<?php echo $i ?>][return_mission]" value="3" >
                <span class="label-radio"> <?php echo __('Delivery / Return') ?></span>
            </div>
            <?php if($paramPriceNight == 1) { ?>
                <div class="input-radio">
                    <p class="p-radio"><?php echo __('Price') ?></p>

                    <input id='type_price1<?php echo $i ?>' class="input-radio"
                           type="radio" name="data[SheetRideDetailRides][<?php echo $i ?>][type_price]"
                           value="1" checked='checked'>
                    <span class="label-radio"><?php echo __('Day') ?></span>
                    <input id='type_price2<?php echo $i ?>'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][<?php echo $i ?>][type_price]" value="2">
                    <span class="label-radio"> <?php echo __('Night') ?></span>
                </div>
            <?php } ?>


            <?php
            echo "<div style='clear:both; padding-top: 10px;'></div>";

            if (Configure::read("gestion_commercial") == '1') {
                echo "<div  id='ride-div$i' class='select-inline select-inline2 '>" . $this->Form->input('SheetRideDetailRides.' . $i . '.detail_ride_id', array(
                        'label' => __('Ride'),

                        'empty' => __('Select ride'),
                        'id' => 'detail_ride' . $i,


                        'class' => 'form-filter select2'
                    )) . "</div>";
            } else {
                echo "<div   class='select-inline '>";
                echo "<div class='form-group col-sm-6 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.departure_destination_id', array(
                        'label' => __('Departure city'),
                        'required'=>true,
                        'id' => 'departure_destination' . $i,
                        'class' => 'form-control select-search-destination',
                        'onchange' => 'javascript:getInformationRide(this.id);',
                    )) . "</div>";

                echo "<div class='form-group col-sm-6 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.arrival_destination_id', array(
                        'label' => __('Arrival city'),
                        'required'=>true,
                        'id' => 'arrival_destination' . $i,
                        'class' => 'form-control select-search-destination',
                        'onchange' => 'javascript:getInformationRide(this.id);',
                    )) . "</div>";
                echo "</div>";
            }
            ?>
            <div  id='distance_duration_ride<?php echo $i ?>'>
            </div>
            <div id='ride_between_two_ride<?php echo $i ?>'>
            </div>

            <?php
            echo "<div style='clear:both; padding-top: 10px;'></div>";
            if (Configure::read("gestion_commercial") == '1') {
                echo "<div class='select-inline' id='client-initial-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_id', array(
                        'label' => __('Initial customer'),
                        'onchange' => 'javascript:getMarchandisesByClient(this.id), getAttachmentsByClient(this.id), getFinalSupplierByInitialSupplier(this.id);',
                        'empty' => __('Select initial customer'),
                        'id' => 'client' . $i,
                        'class' => 'form-filter select-search-client-initial'
                    )) . "</div>";
            }else {
                echo "<div class='select-inline' id='client-initial-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_id', array(
                        'label' => __('Client'),
                        'onchange' => 'javascript:getMarchandisesByClient(this.id), getAttachmentsByClient(this.id), getFinalSupplierByInitialSupplier(this.id);',
                        'empty' => __('Select client'),
                        'id' => 'client' . $i,
                        'class' => 'form-filter select-search-client-initial'
                    )) . "</div>";
            }

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
            if ($displayMissionCost==2) {
            echo "<div class ='scroll-block'>";
            echo "<div class='lbl2'> <a href='#demo$i' data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Mission costs") . "</a></div>";

            echo  "<div id='demo$i' class='collapse'>";
            echo "<div class='select-inline' id='mission-cost-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                    'label' => __('Mission cost'),
                    'placeholder' => __('Enter mission cost'),
                    'id' => 'mission_cost' . $i,
                    'readonly' => true,
                    'class' => 'form-filter '
                )) . "</div>"; ?>
        </div>
    </div>
    <?php   }else {

        echo "<div class='select-inline' id='mission-cost-div$i'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.mission_cost', array(
                'label' => __('Mission cost'),
                'placeholder' => __('Enter mission cost'),
                'id' => 'mission_cost' . $i,
                'readonly' => true,
                'type'=>'hidden',
                'class' => 'form-filter '
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
    echo "<div class='lbl2'> <a href='#note$i' data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Observation") . "</a></div>";
    echo  "<div id='note$i' class='collapse'><br>";
    echo "<div class='select-inline' >" . $this->Form->input('SheetRideDetailRides.' . $i . '.note', array(
            'label' => __('Observation'),
            'class' => 'form-control'
        )) . "</div>";
    echo "</div>";
    echo "</div>";

    ?>
    <div id ='cost_contractor_div<?php echo $i; ?>' style="display: block">

    </div>
    </div>



</td>