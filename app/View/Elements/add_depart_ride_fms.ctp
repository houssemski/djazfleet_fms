
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
        <?php    if ($referenceMission == '1') {
            echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.reference', array(
                    'label' => __('Reference'),
                    'class' => 'form-filter',
                    'placeholder' => __('Enter reference'),
                )) . "</div>";
        } ?>

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
            <span class="label-radio" checked='checked'> <?php echo __('Personalized ride') ?></span>





            <?php
            echo "<div style='clear:both; padding-top: 10px;'></div>";


                echo "<div id='ride-div$i'  class='select-inline '>";
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

            ?>
            <div  id='distance_duration_ride<?php echo $i ?>'>
            </div>
            <div id='ride_between_two_ride<?php echo $i ?>'>
            </div>

            <?php
            echo "<div style='clear:both; padding-top: 10px;'></div>";

                echo "<div   id='client-initial-div$i' class='select-inline'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.supplier_id', array(
                        'label' => __('Client'),
                        'onchange' => 'javascript:getMarchandisesByClient(this.id), getAttachmentsByClient(this.id), getFinalSupplierByInitialSupplier(this.id);',
                        'empty' => __('Select client'),
                        'id' => 'client' . $i,
                        'class' => 'form-filter select-search-client-initial'
                    )) . "</div>";


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

        </div>
    </div>


</td>