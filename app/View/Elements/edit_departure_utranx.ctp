<div class="filters" id='filters'>

    <?php
    echo "<div>" . $this->Form->input('calcul_maps', array(
            'label' => '',
            'type' => 'hidden',
            'class' => 'form-control',
            'id' => 'calcul_maps',
            'value' => $calculByMaps
        )) . "</div>";
    echo "<div >" . $this->Form->input('negative_account', array(
            'label' => '',
            'type' => 'hidden',
            'class' => 'form-control',
            'id' => 'negative_account',
            'value' => $negativeAccount
        )) . "</div>";
    ?>
    <div >
        <?php

        if($this->request->params['action'] !='duplicate') {
            echo $this->Form->input('id');
        }
        $currentDateAdd = date('Y-m-d H:i');
        echo "<div if ($isAgent)  class='hidden' else  style='clear:both; padding-top: 10px;'></div>";

        echo "<div >" . $this->Form->input('currentDateAdd', array(
                'label' => '',
                'type' => 'text',
                'value' => date('Y-m-d H:i'),
                'class' => 'form-control datemask',
                'type' => 'hidden',
                'before' => '<label class="dte">' . __('Planned Departure date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                'after' => '</div>',

            )) . "</div>";
        if(isset($nb_rides)){
            echo "<div >" . $this->Form->input('nb_ride', array(
                    'label' => '',
                    'type' => 'hidden',
                    'class' => 'form-control',
                    'id' => 'nb_ride',
                    'value' => $nb_rides
                )) . "</div>";
        }


        if ($reference != '0') {
            if ($isAgent) {
                echo "<div   class='hidden' >" . $this->Form->input('reference', array(
                        'label' => __('Reference'),
                        'class' => 'form-filter',

                        'readonly' => true,
                        'placeholder' => __('Enter reference'),
                    )) . "</div>";
            }else {
                if($this->request->params['action'] =='duplicate'){
                    echo "<div  >" . $this->Form->input('reference', array(
                            'label' => __('Reference'),
                            'class' => 'form-filter',
                            'value'=>$reference,
                            'readonly' => true,
                            'placeholder' => __('Enter reference'),
                        )) . "</div>";
                }else {
                    echo "<div  >" . $this->Form->input('reference', array(
                            'label' => __('Reference'),
                            'class' => 'form-filter',

                            'readonly' => true,
                            'placeholder' => __('Enter reference'),
                        )) . "</div>";
                }
            }

        } else {
            if ($isAgent) {
                echo "<div  class='hidden' >" . $this->Form->input('reference', array(
                        'label' => __('Reference'),
                        'class' => 'form-filter',
                        'placeholder' => __('Enter reference'),
                        'error' => array('attributes' => array('escape' => false),
                            'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                                __("The reference must be unique") . '</label></div>', true)
                    )) . "</div>";
            }else {
                echo "<div >" . $this->Form->input('reference', array(
                        'label' => __('Reference'),
                        'class' => 'form-filter',
                        'placeholder' => __('Enter reference'),
                        'error' => array('attributes' => array('escape' => false),
                            'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                                __("The reference must be unique") . '</label></div>', true)
                    )) . "</div>";
            }
        }

        echo "<div >" . $this->Form->input('car_type_id', array(
                'label' => __('Transportation'),
                'class' => 'form-filter ',
                'empty' => '',
                'id' => 'car_type', 'type' => 'hidden',
            )) . "</div>";
        if ($isAgent) {
            echo "<div class='hidden'>";
        } else {
            echo "<div >";
        }
        if ($addCarSubcontracting == 2) { ?>
            <p class="p-radio" style="display: inline-block; width: 190px; font-weight: bold;"><?php echo __('Car') .' '.__('Subcontracting') ?></p>
            <input id='car_subcontracting1'
                   onclick='javascript:getInformationCarBySubcontracting(this.id);'
                   class="input-radio" type="radio"
                   name="data[SheetRide][car_subcontracting]"
                   value="1" <?php if($this->request->data['SheetRide']['car_subcontracting'] == 1) {?> checked='checked' <?php } ?>>
            <span class="label-radio"><?php echo __('Yes') ?></span>
            <input id='car_subcontracting2'
                   onclick='javascript:getInformationCarBySubcontracting(this.id);'
                   class="input-radio" type="radio"
                   name="data[SheetRide][car_subcontracting]"
                   value="2" <?php if($this->request->data['SheetRide']['car_subcontracting'] == 2) {?> checked='checked' <?php } ?>>
            <span class="label-radio"> <?php echo __('No') ?></span>
            <?php
            echo "<div  style='clear:both; padding-top: 0px;'></div>";
        }
        echo "<div id='subcontracting-div' >" ;
        if($this->request->data['SheetRide']['car_subcontracting'] == 1){
            echo "<div  class='select-inline'>" . $this->Form->input('supplier_id', array(
                    'label' => __('Supplier'),
                    'class' => 'form-filter select-search-subcontractor',
                    'options'=>$subcontractor,
                    'empty' => '',
                    'id' => 'supplier',
                )) . "</div>";

            echo "<div  class='select-inline'>" . $this->Form->input('car_name', array(
                    'label' => __('Car'),
                    'class' => 'form-filter ',
                )) . "</div>";

            echo "<div  class='select-inline'>" . $this->Form->input('remorque_name', array(
                    'label' => __('Remorque'),
                    'class' => 'form-filter ',
                )) . "</div>";

            echo "<div  class='select-inline'>" . $this->Form->input('customer_name', array(
                    'label' => __('Customer'),
                    'class' => 'form-filter ',
                )) . "</div>";

        }else {

            echo "<div  id='cars-div'   class='select-inline'>" . $this->Form->input('car_id', array(
                    'label' => __('Car'),
                    'class' => 'form-filter select-search-car',

                    'value' =>$this->request->data['SheetRide']['car_id'],
                    'onchange' => 'javascript: carChanged(this.id);',
                    'id' => 'cars',
                )) . "</div>"; ?>
            <!-- overlayed element -->
            <div id="dialogModalCar">
                <!-- the external content is loaded inside this tag -->
                <div id="contentWrapCar"></div>
            </div>
            <div class="popupactions">
                <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>',
                    array("controller" => "cars", "action" => "addCar"),
                    array("class" => "btn btn-danger btn-trans waves-effect waves-danger m-b-5 overlayCar", 'escape' => false, "title" => __("Add car"))); ?>
            </div>
            <?php


            echo "<div  id='remorques-div' class='select-inline'>" . $this->Form->input('remorque_id', array(
                    'label' => __('Remorque'),
                    'options' => $remorques,
                    'class' => 'form-filter select-search-remorque',

                    'id' => 'remorques',
                )) . "</div>";
            ?>
            <!-- overlayed element -->
            <div id="dialogModalRemorque">
                <!-- the external content is loaded inside this tag -->
                <div id="contentWrapRemorque"></div>
            </div>
            <div class="popupactions">
                <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>',
                    array("controller" => "cars", "action" => "addRemorque"),
                    array("class" => "btn btn-danger btn-trans waves-effect waves-danger m-b-5 overlayRemorque", 'escape' => false, "title" => __("Add remorque"))); ?>
            </div>
            <?php

            echo "<div  id='customers-div'  class='select-inline'>" . $this->Form->input('customer_id', array(
                    'label' => __("Customer"),
                    'class' => 'form-filter select-search-customer',

                    'id' => 'customers',
                    'onchange' => 'javascript : verifyDriverLicenseExpirationDate(), verifyMissionCustomer();'
                )) . "</div>"; ?>


            <!-- overlayed element -->
            <div id="dialogModalCustomer">
                <!-- the external content is loaded inside this tag -->
                <div id="contentWrapCustomer"></div>
            </div>
            <div class="popupactions">

                <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' ,
                    array("controller" => "sheetRides", "action" => "addCustomer"),
                    array("class" => "btn btn-danger btn-trans waves-effect waves-danger m-b-5 overlayCustomer",'escape' => false, "title" => __("Add Customer"))); ?>

            </div>
            <div style="clear:both"></div>

            <?php    echo "<div  style='clear:both; padding-top: 10px;'></div>";

            echo '<div   class="lbl"> <a href="#demo" data-toggle="collapse"><i class="fa fa-arrow-right"></i>' . __("Customer help") . '</a></div>';
            ?>
            <div id="demo" class="collapse">
                <div id="conveyor-div">
                    <?php
                    $i =1;
                    if(!empty($sheetRideConveyors)){

                        foreach($sheetRideConveyors as $sheetRideConveyor){
                            echo '<div id="conveyor'.$i.'">';
                            echo "<div >" . $this->Form->input('SheetRideConveyor.'.$i.'.id', array(
                                    'type' => 'hidden',
                                    'value'=>$sheetRideConveyor['SheetRideConveyor']['id']
                                )) . "</div>";
                            echo "<div   class='select-inline'>" . $this->Form->input('SheetRideConveyor.'.$i.'.conveyor_id', array(
                                    'label' => __('Conveyor'),
                                    'empty' => '',
                                    'value'=>$sheetRideConveyor['SheetRideConveyor']['conveyor_id'],
                                    'options'=>$conveyors,
                                    'class' => 'form-filter select-search-conveyor'
                                )) . "</div>";
                            echo '</div>';
                            $i ++;
                        }
                    }else {
                        echo '<div id="conveyor1">';
                        echo "<div   class='select-inline'>" . $this->Form->input('SheetRideConveyor.1.conveyor_id', array(
                                'label' => __('Conveyor'),
                                'empty' => '',
                                'class' => 'form-filter select-search-conveyor'
                            )) . "</div>";
                        echo '</div>';
                    }

                    ?>

                </div>
                <div id ='add_conveyor' class='view-link select-inline' style='margin-top: 16px;'  title='<?= __("add") ?>'>
                    <?= $this->Html->link(
                        '<i   class="fa fa-plus"></i>',
                        'javascript:addConveyor('.$i.');',
                        array('escape' => false, 'class' => 'btn btn-default' , 'style'=>'width: 40px;')
                    ); ?>
                </div>
            </div>
        <?php  }
        echo "</div >";
        echo "</div>";
        echo "<div id='consumption-bloc'>";
        echo "</div>";
        echo "<div id='maintenance-bloc'>";
        echo "</div>";
        echo "<div id='mission-car-bloc'>";
        echo "</div>";
        echo "<div id='mission-customer-bloc'>";
        echo "</div>";
        echo "<div id='driver-bloc'>";
        echo "</div>";
        if (isset($priority['0'])) {
            $priority1 = $priority['0'];
        } else $priority1 = 0;

        echo "<div >" . $this->Form->input('priority1', array(
                'label' => __('priority1'),
                'id' => 'priority1',
                'value' => $priority1,
                'class' => 'form-control',
                'type' => 'hidden',
            )) . "</div>";

        if (isset($priority['1'])) {
            $priority2 = $priority['1'];
        } else $priority2 = 0;
        echo "<div >" . $this->Form->input('priority2', array(
                'label' => __('priority2'),
                'id' => 'priority2',
                'value' => $priority2,
                'class' => 'form-control',
                'type' => 'hidden',
            )) . "</div>";
        if (isset($priority['2'])) {
            $priority3 = $priority['2'];
        } else $priority3 = 0;
        echo "<div >" . $this->Form->input('priority3', array(
                'label' => __('priority3'),
                'id' => 'priority3',
                'value' => $priority3,
                'class' => 'form-control',
                'type' => 'hidden',
            )) . "</div>";

        if (isset($priority['3'])) {
            $priority4 = $priority['3'];
        } else $priority4 = 0;
        echo "<div >" . $this->Form->input('priority4', array(
                'label' => __('priority4'),
                'id' => 'priority4',
                'value' => $priority4,
                'class' => 'form-control',
                'type' => 'hidden',
            )) . "</div>";


        echo "<div >" . $this->Form->input('param_coupons', array(
                'label' => __('param_coupons'),
                'placeholder' => __('Enter coupons number'),
                'id' => 'param_coupons',
                'value' => $paramConsumption['0'],
                'class' => 'form-control',
                'type' => 'hidden',
            )) . "</div>";

        echo "<div >" . $this->Form->input('param_spacies', array(
                'label' => __('param_spacies'),
                'placeholder' => __('Enter coupons number'),
                'value' => $paramConsumption['1'],
                'id' => 'param_spacies',
                'class' => 'form-control',
                'type' => 'hidden',
            )) . "</div>";


        echo "<div >" . $this->Form->input('param_tank', array(
                'label' => __('param_tank'),
                'placeholder' => __('Enter coupons number'),
                'value' => $paramConsumption['2'],
                'class' => 'form-control',
                'id' => 'param_tank',
                'type' => 'hidden',
            )) . "</div>";


        echo "<div >" . $this->Form->input('param_card', array(
                'label' => __('param_card'),
                'value' => $paramConsumption['3'],
                'class' => 'form-control',
                'id' => 'param_card',
                'type' => 'hidden',
            )) . "</div>";

        echo "<div >" . $this->Form->input('coupon_price', array(
                'label' => '',
                'type' => 'hidden',
                'id' => 'coupon_price'
            )) . "</div>";

        echo "<div >" . $this->Form->input('difference_allowed', array(
                'label' => '',
                'type' => 'hidden',
                'id' => 'difference_allowed'
            )) . "</div>";
        echo "<div >" . $this->Form->input('gpl_price', array(
                'label' => '',
                'type' => 'hidden',
                'id' => 'gpl_price'
            )) . "</div>";

        echo "<div >" . $this->Form->input('tempRestant', array(
                'label' => '',
                'class' => 'form-control',
                'id' => 'tempRestant0',
                'value' => 0,
                'type' => 'hidden'
            )) . "</div>";

        if (!empty($firstRide)) {

            if (!empty($firstRide['detailRide'])) {
                echo "<div  >" . $this->Form->input('departure', array(
                        'label' => __('Departure'),
                        'class' => 'form-control',
                        'type' => 'hidden',
                        'id' => "origin_wilaya",
                        'empty' => ''
                    )) . "</div>";


                echo "<div  >" . $this->Form->input('arrival', array(
                        'label' => __('Arrival'),
                        'class' => 'form-control',
                        'id' => "destination_departure",
                        'type' => 'hidden',
                        'empty' => ''
                    )) . "</div>";


                echo "<div >" . $this->Form->input('duration_day', array(
                        'label' => __('Duration'),
                        'readonly' => true,
                        'id' => 'duration_day_first',
                        'value' => $firstRide['detailRide']['DetailRide']['real_duration_day'],

                        'type' => 'hidden',
                        'class' => 'form-filter'
                    )) . "</div>";
                echo "<div >" . $this->Form->input('duration_hour', array(
                        'label' => '',
                        'readonly' => true,
                        'id' => 'duration_hour_first',
                        'value' => $firstRide['detailRide']['DetailRide']['real_duration_hour'],

                        'type' => 'hidden',
                        'class' => 'form-filter'
                    )) . "</div>";
                echo "<div >" . $this->Form->input('duration_minute', array(
                        'label' => '',
                        'value' => $firstRide['detailRide']['DetailRide']['real_duration_minute'],
                        'readonly' => true,
                        'id' => 'duration_minute_first',

                        'type' => 'hidden',
                        'class' => 'form-filter'
                    )) . "</div>";

                echo "<div >" . $this->Form->input('distance', array(
                        'label' => __('Distance'),
                        'readonly' => true,
                        'type' => 'hidden',
                        'value' => $firstRide['detailRide']['Ride']['distance'],
                        'id' => 'distance_first',
                        'class' => 'form-filter'
                    )) . "</div>";

            } else {

                if (!empty($firstRide ["wilayaLatlng"])) {
                    $latlongdef = $firstRide ["wilayaLatlng"];
                    $latlongdef = substr($latlongdef, 1);
                    $latlongdef = substr($latlongdef, 0, strlen($latlongdef) - 1);
                    echo "<div >" . $this->Form->input('departure', array(
                            'label' => __('Departure'),
                            'value' => $latlongdef,
                            'class' => 'form-control',
                            'type' => 'hidden',
                            'id' => "origin_wilaya",
                            'empty' => ''
                        )) . "</div>";
                } else {
                    echo "<div >" . $this->Form->input('departure', array(
                            'label' => __('Departure'),
                            'value' => $firstRide ["wilayaName"],
                            'class' => 'form-control',
                            'type' => 'hidden',
                            'id' => "origin_wilaya",
                            'empty' => ''
                        )) . "</div>";
                }

                if (!empty($firstRide ["departureDestinationLatlng"])) {
                    $latlongdef = $firstRide ["departureDestinationLatlng"];
                    $latlongdef = substr($latlongdef, 1);
                    $latlongdef = substr($latlongdef, 0, strlen($latlongdef) - 1);
                    echo "<div  >" . $this->Form->input('arrival', array(
                            'label' => __('Arrival'),
                            'value' => $latlongdef,
                            'class' => 'form-control',
                            'id' => "destination_departure",
                            'type' => 'hidden',
                            'empty' => ''
                        )) . "</div>";
                } else {
                    echo "<div  >" . $this->Form->input('arrival', array(
                            'label' => __('Arrival'),
                            'value' => $firstRide ["departureDestinationName"],
                            'class' => 'form-control',
                            'id' => "destination_departure",
                            'type' => 'hidden',
                            'empty' => ''
                        )) . "</div>";

                }


                echo "<div >" . $this->Form->input('duration_day', array(
                        'label' => __('Duration'),
                        'readonly' => true,
                        'id' => 'duration_day_first',
                        'type' => 'hidden',

                        'class' => 'form-filter'
                    )) . "</div>";
                echo "<div >" . $this->Form->input('duration_hour', array(
                        'label' => '',
                        'readonly' => true,
                        'id' => 'duration_hour_first',
                        'type' => 'hidden',

                        'class' => 'form-filter'
                    )) . "</div>";
                echo "<div >" . $this->Form->input('duration_minute', array(
                        'label' => '',
                        'type' => 'hidden',
                        'readonly' => true,
                        'id' => 'duration_minute_first',

                        'class' => 'form-filter'
                    )) . "</div>";

                echo "<div >" . $this->Form->input('distance', array(
                        'label' => __('Distance'),
                        'readonly' => true,
                        'type' => 'hidden',
                        'id' => 'distance_first',
                        'class' => 'form-filter'
                    )) . "</div>";

            }

        } else {

            if (!empty($wilaya["wilayaLatlng"])) {
                $latlongdef = $wilaya["wilayaLatlng"];
                $latlongdef = substr($latlongdef, 1);
                $latlongdef = substr($latlongdef, 0, strlen($latlongdef) - 1);
                echo "<div >" . $this->Form->input('departure', array(
                        'label' => __('Departure'),
                        'value' => $latlongdef,
                        'class' => 'form-control',
                        'type' => 'hidden',
                        'id' => "origin_wilaya",
                        'empty' => ''
                    )) . "</div>";

            } else {
                if(isset($wilaya)){
                    echo "<div >" . $this->Form->input('departure', array(
                            'label' => __('Departure'),
                            'value' => $wilaya['wilayaName'],
                            'class' => 'form-control',
                            'type' => 'hidden',
                            'id' => "origin_wilaya",
                            'empty' => ''
                        )) . "</div>";
                }else {
                    echo "<div >" . $this->Form->input('departure', array(
                            'label' => __('Departure'),
                            'class' => 'form-control',
                            'type' => 'hidden',
                            'id' => "origin_wilaya",
                            'empty' => ''
                        )) . "</div>";
                }

            }


            /*  echo "<div class='form-group' id='departureName'>" . $this->Form->input('arrival', array(
                      'label' => __('Arrival'),

                      'class' => 'form-control',
                      'id' => "destination_departure",
                      //'type' => 'hidden',
                      'empty' => ''
                  )) . "</div>";*/


            echo "<div >" . $this->Form->input('duration_day', array(
                    'label' => __('Duration'),
                    'readonly' => true,
                    'id' => 'duration_day_first',
                    'type' => 'hidden',

                    'class' => 'form-filter'
                )) . "</div>";
            echo "<div >" . $this->Form->input('duration_hour', array(
                    'label' => '',
                    'readonly' => true,
                    'id' => 'duration_hour_first',
                    'type' => 'hidden',

                    'class' => 'form-filter'
                )) . "</div>";
            echo "<div >" . $this->Form->input('duration_minute', array(
                    'label' => '',
                    'type' => 'hidden',
                    'readonly' => true,
                    'id' => 'duration_minute_first',

                    'class' => 'form-filter'
                )) . "</div>";

            echo "<div >" . $this->Form->input('distance', array(
                    'label' => __('Distance'),
                    'readonly' => true,
                    'type' => 'hidden',
                    'id' => 'distance_first',
                    'class' => 'form-filter'
                )) . "</div>";


        }

        if( isset($sheetRideWithMission) &&  $sheetRideWithMission == 2){
            echo "<div id='cars-div' class='select-inline'>" . $this->Form->input('travel_reason_id', array(
                    'label' => __('Travel reason'),
                    'class' => 'form-filter ',
                    'empty' => '',
                    'id' => 'cars',
                )) . "</div>";
            echo "<div id='cars-div' class='select-inline'>" . $this->Form->input('destination_id', array(
                    'label' => __('Destination'),
                    'class' => 'form-filter select-search-destination',
                    'empty' => '',
                    'id' => 'cars',
                )) . "</div>";
            echo "<div style='clear:both; padding-top: 10px;'></div>";
        }
        if($isAgent){
            echo "<div   class='hidden'  class='datedep'>" . $this->Form->input('start_date', array(
                    'label' => '',
                    'type' => 'text',
                    'class' => 'form-control datemask',
                    'placeholder' => _('dd/mm/yyyy hh:mm'),
                    'before' => '<label class="dte">' . __('Planned Departure date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'start_date1',
                    'onchange' => 'javascript : calculPlannedDepartureDateFirstRide()',
                )) . "</div>";
        }else {
            echo "<div  style='clear:both; padding-top: 0px;'></div>";

            if($this->request->params['action'] =='duplicate'){
                $date = date("Y-m-d", strtotime('+1 day'));
                $date = date($date . ' 02:00');
                //var_dump($this->Time->format($date, '%d/%m/%Y %H:%M'));
                echo "<div   else class='datedep'>" . $this->Form->input('start_date', array(
                        'label' => '',
                        'type' => 'text',
                        'value' => $this->Time->format($date, '%d/%m/%Y %H:%M'),
                        'class' => 'form-control datemask',
                        'placeholder' => _('dd/mm/yyyy hh:mm'),
                        'before' => '<label class="dte">' . __('Planned Departure date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'start_date1',
                        'onchange' => 'javascript : calculPlannedDepartureDateFirstRide()',
                    )) . "</div>";
            }else {
                echo "<div   else class='datedep'>" . $this->Form->input('start_date', array(
                        'label' => '',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'placeholder' => _('dd/mm/yyyy hh:mm'),
                        'before' => '<label class="dte">' . __('Planned Departure date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'start_date1',
                        'onchange' => 'javascript : calculPlannedDepartureDateFirstRide()',
                    )) . "</div>";
            }

        }
        if($this->request->params['action'] =='duplicate'){
            echo "<div class='datedep'>" . $this->Form->input('real_start_date', array(
                    'label' => '',
                    'type' => 'text',
                    'value' => $this->Time->format($date, '%d/%m/%Y %H:%M'),
                    'class' => 'form-control datemask',
                    'placeholder' => _('dd/mm/yyyy hh:mm'),
                    'before' => '<label class="dte">' . __('Real Departure date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'start_date2',
                    'onchange' => 'javascript : calculPlannedDepartureDateFirstRide()',
                )) . "</div>";
        }else {
            echo "<div class='datedep'>" . $this->Form->input('real_start_date', array(
                    'label' => '',
                    'type' => 'text',

                    'class' => 'form-control datemask',
                    'placeholder' => _('dd/mm/yyyy hh:mm'),
                    'before' => '<label class="dte">' . __('Real Departure date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'start_date2',
                    'onchange' => 'javascript : calculPlannedDepartureDateFirstRide()',
                )) . "</div>";
        }



        echo "<div id='km-tank-departure-div'>";
        echo "<div class='select-inline'>" . $this->Form->input('km_departure', array(
                'label' => __('Departure Km'),
                'placeholder' => __('Enter departure Km'),
                'onchange' => 'javascript: calculKmDepartureEstimatedFirstRide(this);',
                'class' => 'form-filter',
                'id' => 'km_dep',

            )) . "</div>";

if(isset($fieldMarchandiseRequired)){
    echo "<div >" . $this->Form->input('fieldMarchandiseRequired', array(
            'value' => $fieldMarchandiseRequired,
            'class' => 'form-filter',
            'id' => 'fieldMarchandiseRequired',
            'type' => 'hidden',
        )) . "</div>";
}



        echo "<div >" . $this->Form->input('selectingCouponsMethod', array(
                'value' => $selectingCouponsMethod,
                'class' => 'form-filter',
                'id' => 'selectingCouponsMethod',
                'type' => 'hidden',
            )) . "</div>";

        echo "<div >" . $this->Form->input('departureTankStateMethod', array(
                'value' => $departureTankStateMethod,
                'class' => 'form-filter',
                'id' => 'departureTankStateMethod',
                'type' => 'hidden',

            )) . "</div>";


        switch ($departureTankStateMethod) {
            case 1:
                echo "<div >" . $this->Form->input('tank_departure', array(
                        'label' => __('Departure tank'),
                        'type' => 'hidden',
                        'class' => 'form-filter',
                        'id' => 'departure_tank',
                        'empty' => '',
                        'onchange' => 'javascript:estimateCost() ;'
                    )) . "</div>";
                break;
            case 2:
                echo "<div class='select-inline'>" . $this->Form->input('tank_departure', array(
                        'label' => __('Departure tank'),
                        //'type' => 'hidden',
                        'class' => 'form-filter',
                        'id' => 'departure_tank',
                        'empty' => '',
                        'onchange' => 'javascript:estimateCost() ;'
                    )) . "</div>";
                break;
            case 3:
                echo "<div class='select-inline'>" . $this->Form->input('tank_departure', array(
                        'label' => __('Departure tank'),
                        'class' => 'form-filter',
                        'id' => 'departure_tank',
                        'empty' => '',
                        'onchange' => 'javascript:estimateCost() ;'
                    )) . "</div>";
                break;

        }
        echo "</div>";
        echo "<div style='clear:both; padding-top: 10px;'></div>"; ?>
        <br>
    </div>
    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #435966;;">
                <h4 class="panel-title">
                    <a class="collapsed" data-toggle="collapse" href="#collapse1"
                       style="font-weight: 700;"><?php echo __('Consumption') . __(' de carburant') ?> </a>

                </h4>
            </div>
            <?php if($isAgent) {?>
            <div id="collapse1" class="panel-collapse collapse in">
                <?php } else { ?>
                <div id="collapse1" class="panel-collapse collapse ">
                    <?php } ?>

                    <div class="panel-body">
                        <?php echo "<div  >" . $this->Form->input('Consumption.deleted_id', array(
                                'type' => 'hidden',
                                'id' => 'deleted_id',
                                'value' => ''
                            )) . "</div>"; ?>

                        <table id='table-consumptions' class="table table-bordered ">

                            <?php
                            $i = 1;
                            $options = array('0' => '');
                            if ($paramConsumption['0'] == 1) {
                                if ($options != null) {
                                    $options = array_replace($options, array('1' => __('Coupons')));
                                } else {
                                    $options = array('1' => __('Coupons'));
                                }
                            }
                            if ($paramConsumption['1'] == 1) {
                                if ($options != null) {
                                    $options = array_replace($options, array('2' => __('Species')));
                                } else {
                                    $options = array('2' => __('Species'));
                                }
                            }
                            if ($paramConsumption['2'] == 1) {
                                if ($options != null) {
                                    $options = array_replace($options, array('3' => __('Tank')));
                                } else {
                                    $options = array('3' => __('Tank'));
                                }
                            }
                            if ($paramConsumption['3'] == 1) {
                                if ($options != null) {
                                    $options = array_replace($options, array('4' => __('Cards')));
                                } else {
                                    $options = array('4' => __('Cards'));
                                }
                            }
                            if(isset($consumptions)){
                                $nbConsumption = count($consumptions);
                            }else {
                                $nbConsumption =0;
                            }

                            if ($nbConsumption > 0) {
                                foreach ($consumptions as $consumption) {
                                    ?>
                                    <tr id='tr-consumption<?php echo $i; ?>' <?php if ($isAgent) {?> class='hidden'<?php } ?>>
                                        <td style='width:99%; height: 100px;'>
                                            <?php


                                            if($this->request->params['action'] !='duplicate') {
                                                echo $this->Form->input('Consumption.' . $i . '.id', array(
                                                    'value' => $consumption['Consumption']['id'],
                                                    'type' => 'hidden',
                                                    'id' => 'consumptionId' . $i
                                                ));
                                            }
                                            echo $this->Form->input('Consumption.' . $i . '.cost', array(
                                                'value' => $consumption['Consumption']['cost'],
                                                'type'=>'hidden',
                                                'id' => 'cost' . $i
                                            ));

                                            echo "<div class='select-inline'>" . $this->Form->input('Consumption.' . $i . '.consumption_date', array(
                                                    'label' => '',
                                                    'type' => 'text',
                                                    'value' => $this->Time->format($consumption['Consumption']['consumption_date'], '%d/%m/%Y %H:%M'),
                                                    'class' => 'form-control datemask',
                                                    'before' => '<label class="dte">' . __('Date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                                    'after' => '</div>',
                                                    'id' => 'consumption_date' . $i,
                                                )) . "</div>";


                                            echo "<div class='select-inline' >" . $this->Form->input('Consumption.' . $i . '.type_consumption_used', array(
                                                    'label' => __('Consumption type'),
                                                    'class' => 'form-filter select2',
                                                    'options' => $options,
                                                    'id' => 'type_consumption' . $i,
                                                    'value' => $consumption['Consumption']['type_consumption_used'],
                                                    'onchange' => 'javascript : addConsumptionMethod(this.id);'
                                                )) . "</div>"; ?>

                                            <div id='consumption-method<?php echo $i; ?>'>
                                                <?php

                                                switch ($consumption['Consumption']['type_consumption_used']) {
                                                    case ConsumptionTypesEnum::coupon :
                                                        ?>
                                                        <div id='coupon_div<?php echo $i ?>'>
                                                            <?php if ($selectingCouponsMethod == 1) { ?>
                                                                <div
                                                                        id='consump_coupon<?php echo $i ?>'
                                                                        class="select-inline consumption">
                                                                    <?php    echo "<div class='select-inline'>" . $this->Form->input('Consumption.' . $i . '.nb_coupon', array(
                                                                            'label' => __('Nb coupons'),
                                                                            'type' => 'number',
                                                                            'class' => 'form-filter',
                                                                            'id' => 'coupons' . $i,
                                                                            'value' => $consumption['Consumption']['nb_coupon'],
                                                                            'onchange' => 'javascript:couponsToSelect(this.id) ;'

                                                                        )) . "</div>"; ?>
                                                                    <span
                                                                            id='con_coupon<?php echo $i ?>'> </span>
                                                                    <?php "<div  id='coupon-div' >" . $this->Form->input('Consumption.' . $i . '.serial_numbers', array(
                                                                        'label' => __('Serial numbers'),
                                                                        'type' => 'select',
                                                                        'options' => $coupons,
                                                                        'multiple' => 'multiple',
                                                                        'selected' => $couponsSelected,
                                                                        'class' => 'form-filter select3',
                                                                        'empty' => '',
                                                                        'id' => 'serial_number' . $i,
                                                                    )) . "</div>"; ?>
                                                                </div>
                                                                <?php
                                                                echo "<div  id='coupon-div$i'></div>";
                                                            } else {
                                                                ?>
                                                                <div
                                                                        id='consump_coupon<?php echo $i ?>'
                                                                        class="select-inline consumption">
                                                                    <?php    echo "<div class='select-inline'>" . $this->Form->input('Consumption.' . $i . '.nb_coupon', array(
                                                                            'label' => __('Nb coupons'),
                                                                            'type' => 'number',
                                                                            'class' => 'form-filter',
                                                                            'id' => 'coupons' . $i,
                                                                            'value' => $consumption['Consumption']['nb_coupon'],
                                                                            'onchange' => 'javascript:couponsSelectedFromFirstNumber(this.id);'

                                                                        )) . "</div>"; ?>
                                                                    <span
                                                                            id='con_coupon<?php echo $i ?>'> </span>
                                                                </div>
                                                                <?php
                                                                echo "<div id='number_coupon_div$i' style='padding-left: 35px;' class='consumption'>";
                                                                echo "<div class='select-inline'>" . $this->Form->input('Consumption.' . $i . '.first_number_coupon', array(
                                                                        'label' => __('From'),
                                                                        'class' => 'form-filter',
                                                                        'value' => $consumption['Consumption']['first_number_coupon'],
                                                                        'id' => 'first_number_coupon' . $i,
                                                                        'onchange' => 'javascript:couponsSelectedFromFirstNumber(this.id);'
                                                                    )) . "</div>";

                                                                echo "<div class='select-inline consumption'>" . $this->Form->input('Consumption.' . $i . '.last_number_coupon', array(
                                                                        'label' => __('To'),
                                                                        'readonly' => true,
                                                                        'class' => 'form-filter',
                                                                        'value' => $consumption['Consumption']['last_number_coupon'],
                                                                        'id' => 'last_number_coupon' . $i,
                                                                    )) . "</div>";
                                                                echo "</div>"; ?>
                                                                <div class="select-inline "
                                                                     style='width: 65%;'>
                                                                    <div
                                                                            class="input select hidden">
                                                                        <label
                                                                                for="serial_number"><?= __('Nb Serial') ?></label>
                                                                        <select
                                                                                name="data[Consumption][<?php echo $i; ?>][serial_numbers][]"
                                                                                class="form-filter select3"
                                                                                id="serial_number"
                                                                                multiple="multiple">
                                                                            <option
                                                                                    value=""><?= __('Select coupons') ?></option>

                                                                            <?php
                                                                            foreach ($coupons as $qsKey => $qsData) {
                                                                                $selected = 0;

                                                                                foreach ($couponsSelected as $csKey => $csData) {

                                                                                    if ($selected == 0) {
                                                                                        if ((int)$qsKey == $csData) {

                                                                                            $selected = 1;
                                                                                        }
                                                                                    }

                                                                                }
                                                                                if ($selected == 1) {
                                                                                    echo '<option selected="selected" value="' . $qsKey . '">' . $qsData . '</option>' . "\n";
                                                                                } else {
                                                                                    echo '<option value="' . $qsKey . '">' . $qsData . '</option>' . "\n";
                                                                                }
                                                                            }
                                                                            ?>

                                                                        </select>
                                                                    </div>
                                                                </div>


                                                            <?php } ?>

                                                        </div>
                                                        <?php
                                                        break;

                                                    case ConsumptionTypesEnum::species :
                                                        ?>


                                                        <div id='consump_compte<?php echo $i ?>'>
                                                            <div
                                                                    id='consump_compte_div<?php echo $i ?>'
                                                                    class='select-inline consumption'>
                                                                <?php
                                                                echo "<div class='select-inline'>" . $this->Form->input('Consumption.' . $i . '.species', array(
                                                                        'value' => $consumption['Consumption']['species'],
                                                                        'label' => __('Species'),
                                                                        'class' => 'form-filter',
                                                                        'id' => 'species' . $i,
                                                                        'onchange' => 'javascript:verifySpecieComptes(this.id);'
                                                                    )) . "</div>";
                                                                ?>
                                                            </div>
                                                            <?php
                                                            if (Configure::read("gestion_commercial") == '1'  &&
                                                            Configure::read("tresorerie") == '1') {
                                                                echo "<div   class='select-inline consumption' id='reference_compte_div$i '>" . $this->Form->input('Consumption.' . $i . '.compte_id', array(
                                                                        'label' => __('Comptes'),
                                                                        'type' => 'select',
                                                                        'options' => $comptes,
                                                                        'value' => $consumption['Consumption']['compte_id'],
                                                                        'class' => 'form-filter select3',
                                                                        'empty' => '',
                                                                        'id' => 'compte' . $i,
                                                                    )) . "</div>";
                                                            }
                                                            ?>

                                                        </div>

                                                        <?php      break;

                                                    case ConsumptionTypesEnum::tank :

                                                        ?>
                                                        <div id='consump_tank<?php echo $i ?>'>
                                                            <div
                                                                    id='consump_tank_div<?php echo $i ?>'
                                                                    class='select-inline consumption'>
                                                                <?php
                                                                echo "<div class='select-inline' >" . $this->Form->input('Consumption.' . $i . '.consumption_liter', array(
                                                                        'value' => $consumption['Consumption']['consumption_liter'],
                                                                        'label' => __('Consumption liter'),
                                                                        'class' => 'form-filter',
                                                                        'id' => 'consumption_liter' . $i,
                                                                        'onchange' => 'javascript:verifyLiterTanks(this.id);'
                                                                    )) . "</div>"; ?>
                                                            </div>
                                                            <?php   echo "<div   class='select-inline consumption' id='code_tank_div$i '>" . $this->Form->input('Consumption.' . $i . '.tank_id', array(
                                                                    'label' => __('Tanks'),
                                                                    'type' => 'select',
                                                                    'options' => $tanks,
                                                                    'value' => $consumption['Consumption']['tank_id'],
                                                                    'class' => 'form-filter select3',
                                                                    'empty' => '',
                                                                    'id' => 'tank' . $i,


                                                                )) . "</div>"; ?>

                                                        </div>

                                                        <?php

                                                        break;

                                                    case ConsumptionTypesEnum::card:
                                                        ?>
                                                        <div id='consump_card<?php echo $i ?>'>
                                                            <div
                                                                    id='consump_card_div<?php echo $i ?>'
                                                                    class='select-inline consumption'>
                                                                <?php

                                                                if($cardAmountVerification== 1){
                                                                    echo "<div class='select-inline' >" . $this->Form->input('Consumption.' . $i . '.species_card', array(
                                                                            'value' => $consumption['Consumption']['species_card'],
                                                                            'label' => __('Species card'),
                                                                            'class' => 'form-filter',
                                                                            'id' => 'species_card' . $i
                                                                        )) . "</div>";
                                                                }else {
                                                                    echo "<div class='select-inline' >" . $this->Form->input('Consumption.' . $i . '.species_card', array(
                                                                            'value' => $consumption['Consumption']['species_card'],
                                                                            'label' => __('Species card'),
                                                                            'class' => 'form-filter',
                                                                            'id' => 'species_card' . $i,
                                                                            'onchange' => 'javascript:verifyAmountCards(this.id);'
                                                                        )) . "</div>";
                                                                }

                                                                ?>
                                                            </div>
                                                            <?php   echo "<div   class='select-inline consumption' id='reference_card_div$i'>" . $this->Form->input('Consumption.' . $i . '.fuel_card_id', array(
                                                                    'label' => __('Cards'),
                                                                    'type' => 'select',
                                                                    'options' => $cards,
                                                                    'class' => 'form-filter select3',
                                                                    'empty' => '',
                                                                    'value' => $consumption['Consumption']['fuel_card_id'],
                                                                    'id' => 'card' . $i,


                                                                )) . "</div>"; ?>

                                                        </div>

                                                        <?php
                                                        break;
                                                } ?>


                                            </div>
                                        </td>
                                        <td class="td_tab" id='td-button<?php echo $i; ?>'>

                                            <button style="margin-top: 25px;" name="remove"
                                                    id="remove_consumption<?php echo $i; ?>"
                                                    onclick="removeConsumption(this.id);"
                                                    class="btn btn-danger btn_remove">X
                                            </button>

                                        </td>

                                    </tr>

                                    <?php
                                    $i++;
                                }
                                ?>
                                <tr id='tr-consumption<?php echo $i; ?>'>
                                    <td style='width:99%; height: 100px;'>
                                        <?php
                                        $currentDate = date("Y-m-d H:i");


                                        echo "<div class='select-inline'>" . $this->Form->input('Consumption.' . $i . '.consumption_date', array(
                                                'label' => '',
                                                'type' => 'text',
                                                'value' => $this->Time->format($currentDate, '%d/%m/%Y %H:%M'),
                                                'class' => 'form-control datemask',
                                                'before' => '<label class="dte">' . __('Date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                                'after' => '</div>',
                                                'id' => 'consumption_date'.$i,
                                            )) . "</div>";


                                        echo "<div class='select-inline' >" . $this->Form->input('Consumption.' . $i . '.type_consumption_used', array(
                                                'label' => __('Consumption type'),
                                                'class' => 'form-filter select2',
                                                'options' => $options,
                                                'id' => 'type_consumption'.$i,
                                                'value'=>$defaultConsumptionMethod,
                                                'onchange' => 'javascript : addConsumptionMethod(this.id);'
                                            )) . "</div>"; ?>

                                        <div id='consumption-method<?php echo $i; ?>'></div>
                                    </td>
                                    <td class="td_tab" id='td-button1'>
                                        <button style="margin-top: 25px;" name="remove"
                                                id="remove_consumption<?php echo $i; ?>"
                                                onclick="removeConsumption(this.id);"
                                                class="btn btn-danger btn_remove">X
                                        </button>

                                    </td>

                                </tr>
                            <?php } else { ?>

                                <tr id='tr-consumption1'>
                                <td style='width:99%; height: 100px;'>
                                    <?php
                                    $currentDate = date("Y-m-d H:i");


                                    echo "<div class='select-inline'>" . $this->Form->input('Consumption.1.consumption_date', array(
                                            'label' => '',
                                            'type' => 'text',
                                            'value' => $this->Time->format($currentDate, '%d/%m/%Y %H:%M'),
                                            'class' => 'form-control datemask',
                                            'before' => '<label class="dte">' . __('Date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                            'after' => '</div>',
                                            'id' => 'consumption_date1',
                                        )) . "</div>";

                                    $options = array('0' => '');
                                    if ($paramConsumption['0'] == 1) {
                                        if ($options != null) {
                                            $options = array_replace($options, array('1' => __('Coupons')));
                                        } else {
                                            $options = array('1' => __('Coupons'));
                                        }
                                    }
                                    if ($paramConsumption['1'] == 1) {
                                        if ($options != null) {
                                            $options = array_replace($options, array('2' => __('Species')));
                                        } else {
                                            $options = array('2' => __('Species'));
                                        }
                                    }
                                    if ($paramConsumption['2'] == 1) {
                                        if ($options != null) {
                                            $options = array_replace($options, array('3' => __('Tank')));
                                        } else {
                                            $options = array('3' => __('Tank'));
                                        }
                                    }
                                    if ($paramConsumption['3'] == 1) {
                                        if ($options != null) {
                                            $options = array_replace($options, array('4' => __('Cards')));
                                        } else {
                                            $options = array('4' => __('Cards'));
                                        }
                                    }
                                    echo "<div class='select-inline' >" . $this->Form->input('Consumption.1.type_consumption_used', array(
                                            'label' => __('Consumption type'),
                                            'class' => 'form-filter select2',
                                            'options' => $options,
                                            'id' => 'type_consumption1',

                                            'value'=>$defaultConsumptionMethod,
                                            'onchange' => 'javascript : addConsumptionMethod(this.id);'
                                        )) . "</div>"; ?>

                                    <div id='consumption-method1'></div>
                                </td>
                                <td <?php if ($isAgent) {?> class='hidden' <?php } else ?> class="td_tab" id='td-button1'>
                                    <button style="margin-top: 25px;" name="remove"
                                            id="remove_consumption1"
                                            onclick="removeConsumption(this.id);"
                                            class="btn btn-danger btn_remove">X
                                    </button>

                                    </td>

                                    </tr>



                                <?php } ?>


                        </table>



                        <?php
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        if($isAgent) {
                            echo "<div class='hidden'>";
                        }else {
                            echo "<div>";
                        }
                        echo "<div class='select-inline' >" . $this->Form->input('estimated_cost', array(
                                'label' => __('Estimated cost') . ' (' . $this->Session->read("currency") . ')',
                                'class' => 'form-filter',
                                'readonly' => true,
                                'id' => 'estimated_cost'
                            )) . "</div>";
                        echo "<div  class='select-inline' >" . $this->Form->input('cost', array(
                                'label' => __('Cost') . ' (' . $this->Session->read("currency") . ')',
                                'class' => 'form-filter',
                                'readonly' => true,
                                'id' => 'cost'
                            )) . "</div>";
                        echo "<div   class='select-inline' >" . $this->Form->input('forecast', array(
                                'label' => __('Forecast') . ' (' . $this->Session->read("currency") . ')',
                                'class' => 'form-filter',
                                'readonly' => true,
                                'id' => 'forecast'
                            )) . "</div>";
                        echo "<div  class='select-inline' >" . $this->Form->input('difference_estimated', array(
                                'label' => __('Balance estimated'),
                                'class' => 'form-filter',
                                'id' => 'difference_estimated',
                                'readonly' => true,
                            )) . "</div>";

                        echo "<div class='select-inline' >" . $this->Form->input('difference_real', array(
                                'label' => __('Balance real'),
                                'class' => 'form-filter',
                                'id' => 'difference_real'

                            )) . "</div>";
                        echo "</div>";
                        ?>


                        <div id='div-button' style="float: right;margin-right: 10px;">
                            <button style="margin-top: 25px; width: 40px" type='button' name='add'
                                    id='<?php echo $nbConsumption+1; ?>'
                                    onclick='addConsumptionDiv(this.id)'
                                    class='btn btn-success'>+
                            </button>

                        </div>
                        <?php

                        if($nbConsumption>0){
                            echo "<div  >" . $this->Form->input('nb_consumption', array(
                                    'type' => 'hidden',
                                    'class' => 'form-filter',
                                    'value' => $nbConsumption+1,
                                    'id' => 'nb_consumption'

                                )) . "</div>";
                        }else {
                            echo "<div  >" . $this->Form->input('nb_consumption', array(
                                    'type' => 'hidden',
                                    'class' => 'form-filter',
                                    'value' => 1,
                                    'id' => 'nb_consumption'

                                )) . "</div>";
                        }
                        ?>

                    </div>


                </div>
            </div>

        </div>

        <?php
        echo "<div  >" . $this->Form->input('SheetRide.loading_time', array(
                'id' => 'param_loading_time',
                'value' => $timeParameters['loading_time'],
                'type' => 'hidden',
                'class' => 'form-filter '
            )) . "</div>";

        echo "<div   >" . $this->Form->input('SheetRide.unloading_time', array(
                'id' => 'param_unloading_time',
                'value' => $timeParameters['unloading_time'],
                'type' => 'hidden',
                'class' => 'form-filter '
            )) . "</div>";

        echo "<div   >" . $this->Form->input('SheetRide.maximum_driving_time', array(
                'id' => 'param_maximum_driving_time',
                'value' => $timeParameters['maximum_driving_time'],
                'type' => 'hidden',
                'class' => 'form-filter '
            )) . "</div>";

        echo "<div >" . $this->Form->input('SheetRide.break_time', array(
                'id' => 'param_break_time',
                'value' => $timeParameters['break_time'],
                'type' => 'hidden',
                'class' => 'form-filter '
            )) . "</div>";

        echo "<div>" . $this->Form->input('SheetRide.additional_time_allowed', array(
                'id' => 'param_additional_time_allowed',
                'value' => $timeParameters['additional_time_allowed'],
                'type' => 'hidden',
                'class' => 'form-filter '
            )) . "</div>";
        ?>



    </div>
</div>
