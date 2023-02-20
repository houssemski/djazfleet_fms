<?php
if (!isset($wilaya['wilayaName'])){
    $wilaya['wilayaName'] = '';
}

?>

<div class="filters" id='filters'>

    <?php echo "<div >" . $this->Form->input('fieldMarchandiseRequired', array(
            'value' => $fieldMarchandiseRequired,
            'class' => 'form-filter',
            'id' => 'fieldMarchandiseRequired',
            'type' => 'hidden',
        )) . "</div>";
    echo "<div >" . $this->Form->input('selectingCouponsMethod', array(
            'value' => $selectingCouponsMethod,
            'class' => 'form-filter',
            'id' => 'selectingCouponsMethod',
            'type' => 'hidden',
        )) . "</div>";
    echo "<div >" . $this->Form->input('calcul_maps', array(
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
    $currentDateAdd = date('Y-m-d H:i');
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


    if ($reference != '0') {
        echo "<div  class='select-inline'>" . $this->Form->input('reference', array(
                'label' => __('Reference'),
                'class' => 'form-filter',
                'value' => $reference,
                'readonly' => true,
                'placeholder' => __('Enter reference'),
            )) . "</div>";
    } else {
        echo "<div  class='select-inline'>" . $this->Form->input('reference', array(
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
    if (isset($transportBillDetailRide['TransportBillDetailRides']['type_ride']) &&
        ($transportBillDetailRide['TransportBillDetailRides']['type_ride'] == 2)
    ) {
        if (!empty($transportBillDetailRide['Type']['id'])) {
            echo "<div  >" . $this->Form->input('car_type_id', array(
                    'label' => __('Transportation'),
                    'class' => 'form-filter ',
                    'value' => $transportBillDetailRide['Type']['id'],
                    'empty' => '',
                    'id' => 'car_type',
                    'type' => 'hidden',
                )) . "</div>";

            echo "<div style='clear:both; padding-top: 10px;'></div>";
        } else {
            echo "<div class='select-inline' id ='car_type_div'>" . $this->Form->input('car_type_id', array(
                    'label' => __('Transportation'),
                    'class' => 'form-filter select3',
                    'empty' => '',
                    'id' => 'car_type',
                )) . "</div>";

            echo "<div style='clear:both; padding-top: 5px;'></div>";
        }
    } else {
        if (!empty($transportBillDetailRide['CarType']['id'])) {
            echo "<div  >" . $this->Form->input('car_type_id', array(
                    'label' => __('Transportation'),
                    'class' => 'form-filter ',
                    'value' => $transportBillDetailRide['CarType']['id'],
                    'empty' => '',
                    'id' => 'car_type',
                    'type' => 'hidden',
                )) . "</div>";

            echo "<div style='clear:both; padding-top: 0px;'></div>";
        } else {


            echo "<div class='select-inline' id ='car_type_div'>" . $this->Form->input('car_type_id', array(
                    'label' => __('Transportation'),
                    'class' => 'form-filter select3',
                    'empty' => '',
                    'id' => 'car_type',
                )) . "</div>";

            echo "<div style='clear:both; padding-top: 5px;'></div>";
        }
    }

    if ($addCarSubcontracting == 2) { ?>

        <p class="p-radio" style="display: inline-block; width: 190px; font-weight: bold;"><?php echo __('Car') .' '.__('Subcontracting') ?></p>
        <input id='car_subcontracting1'
               onclick='javascript:getInformationCarBySubcontracting(this.id);'
               class="input-radio" type="radio"
               name="data[SheetRide][car_subcontracting]"
               value="1" <?php if(Configure::read('car_sous_traitance')=='1') { ?>
                        checked='checked'
              <?php }?>>
        <span class="label-radio"><?php echo __('Yes') ?></span>
        <input id='car_subcontracting2'
               onclick='javascript:getInformationCarBySubcontracting(this.id);'
               class="input-radio" type="radio"
               name="data[SheetRide][car_subcontracting]"
               value="2"  <?php if(Configure::read('car_sous_traitance')=='0') { ?>
            checked='checked'
        <?php }?>>
        <span class="label-radio"> <?php echo __('No') ?></span>
    <?php }
    echo "<div style='clear:both; padding-top: -15px;'></div>";

    echo "<div id='subcontracting-div' >" ;

    if(!empty($transportBillDetailRide['TransportBillDetailRides']['car_id'])){
        echo "<div id='cars-div' class='select-inline'>" . $this->Form->input('car_id', array(
                'label' => __('Car'),
                'class' => 'form-filter select-search-car',

                'value' => $transportBillDetailRide['TransportBillDetailRides']['car_id'],
                'options'=>$cars,
                'onchange' => 'javascript: carChanged(this.id) ;',
                'id' => 'cars',
            )) . "</div>";
    }else {
        echo "<div id='cars-div' class='select-inline'>" . $this->Form->input('car_id', array(
                'label' => __('Car'),
                'class' => 'form-filter select-search-car',
                'empty' => '',
                'options'=>$cars,
                'onchange' => 'javascript: carChanged(this.id) ;',
                'id' => 'cars',
            )) . "</div>";
    }
    ?>
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
            'class' => 'form-filter select-search-remorque',
            'empty' => '',
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
            'empty' => '',
            'id' => 'customers',
            'onchange' => 'javascript : verifyDriverLicenseExpirationDate(), verifyMissionCustomer();'
        )) . "</div>"; ?>

    <!-- overlayed element -->
    <div id="dialogModalCustomer">
        <!-- the external content is loaded inside this tag -->
        <div id="contentWrapCustomer"></div>
    </div>
    <div class="popupactions">
        <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>',
            array("controller" => "sheetRides", "action" => "addCustomer"),
            array("class" => "btn btn-danger btn-trans waves-effect waves-danger m-b-5 overlayCustomer", 'escape' => false, "title" => __("Add customer"))); ?>
    </div>
    <div style="clear:both"></div>

    <?php    echo "<div style='clear:both; padding-top: 10px;'></div>";
    echo '<div class="lbl"> <a href="#demo" data-toggle="collapse"><i class="fa fa-arrow-right"></i>' . __("Customer help") . '</a></div>';
    ?>
    <div id="demo" class="collapse">
        <?php
        echo "<div   class='select-inline'>" . $this->Form->input('SheetRideConveyor.1.conveyor_id', array(
                'label' => __('Conveyor'),
                'empty' => '',
                'class' => 'form-filter select-search-conveyor'
            )) . "</div>";
        ?>
        <div id="conveyor-div">

        </div>
        <div id='add_conveyor' class='view-link select-inline' style='margin-top: 16px;'
             title='<?= __("add") ?>'>
            <?= $this->Html->link(
                '<i   class="fa fa-plus"></i>',
                'javascript:addConveyor(1);',
                array('escape' => false, 'class' => 'btn btn-default', 'style' => 'width: 40px;')
            ); ?>
        </div>
    </div>


    <?php
    echo "</div>" ;

    echo "<div style='clear:both; padding-top: 0px;'></div>";
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
            'id' => 'param_coupons',
            'value' => $paramConsumption['0'],
            'class' => 'form-control',
            'type' => 'hidden',
        )) . "</div>";

    echo "<div >" . $this->Form->input('param_spacies', array(
            'label' => __('param_spacies'),

            'value' => $paramConsumption['1'],
            'id' => 'param_spacies',
            'class' => 'form-control',
            'type' => 'hidden',
        )) . "</div>";


    echo "<div >" . $this->Form->input('param_tank', array(
            'label' => __('param_tank'),
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

            if (!empty($firstRide["departureDestinationLatlng"])) {
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

            echo "<div >" . $this->Form->input('departure', array(
                    'label' => __('Departure'),
                    'value' => $wilaya['wilayaName'],
                    'class' => 'form-control',
                    'type' => 'hidden',
                    'id' => "origin_wilaya",
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
    if(   $sheetRideWithMission == 2){
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


    $date = date("Y-m-d", strtotime('+1 day'));
    $date = date($date . ' 02:00');

    echo "<div class='datedep'>" . $this->Form->input('start_date', array(
            'label' => false,

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

    echo "<div class='datedep hidden'>" . $this->Form->input('start_date2', array(
            'label' => false,

            'type' => 'text',
            'value' => $this->Time->format($date, '%d/%m/%Y %H:%M'),
            'class' => 'form-control datemask',
            'placeholder' => _('dd/mm/yyyy hh:mm'),
            'before' => '<label class="dte">' . __('Planned Departure date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
            'after' => '</div>',
            'id' => 'start',

        )) . "</div>";

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



    echo "<div id='km-tank-departure-div'>";
    echo "<div class='select-inline' >" . $this->Form->input('km_departure', array(
            'label' => __('Departure Km'),
            'onchange' => 'javascript: calculKmDepartureEstimatedFirstRide(this),calculateForecast(this);',
            'class' => 'form-filter',
            'id' => 'km_dep',
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

    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #435966;;">
                <h4 class="panel-title">
                    <a class="collapsed" data-toggle="collapse" href="#collapse1"
                       style="font-weight: 700;"><?php echo __('Consumption') . __(' de carburant') ?> </a>

                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body">
                    <table id='table-consumptions' class="table table-bordered ">
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
                            <td class="td_tab" id='td-button1'>
                                <button style="margin-top: 25px;" name="remove"
                                        id="remove_consumption1"
                                        onclick="removeConsumption(this.id);"
                                        class="btn btn-danger btn_remove">X
                                </button>
                            </td>
                        </tr>
                    </table>


                    <?php
                    echo "<div style='clear:both; padding-top: 10px;'></div>";
                    echo "<div class='select-inline' >" . $this->Form->input('estimated_cost', array(
                            'label' => __('Estimated cost') . ' (' . $this->Session->read("currency") . ')',
                            'class' => 'form-filter',
                            'readonly' => true,
                            'id' => 'estimated_cost'
                        )) . "</div>";
                    echo "<div class='select-inline' >" . $this->Form->input('cost', array(
                            'label' => __('Cost') . ' (' . $this->Session->read("currency") . ')',
                            'class' => 'form-filter',
                            'readonly' => true,
                            'id' => 'cost'
                        )) . "</div>";
                    echo "<div class='select-inline' >" . $this->Form->input('forecast', array(
                            'label' => __('Forecast') . ' (' . $this->Session->read("currency") . ')',
                            'class' => 'form-filter',
                            'readonly' => true,
                            'id' => 'forecast'
                        )) . "</div>";
                    echo "<div class='select-inline' >" . $this->Form->input('difference_estimated', array(
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

                    ?>
                    <div id='div-button' style="float: right;margin-right: 10px;">
                        <button style="margin-top: 25px; width: 40px" type='button' name='add'
                                id='1'
                                onclick='addConsumptionDiv(this.id)'
                                class='btn btn-success'>+
                        </button>

                    </div>
                    <?php echo "<div  >" . $this->Form->input('nb_consumption', array(
                            'type' => 'hidden',
                            'class' => 'form-filter',
                            'value' => 1,
                            'id' => 'nb_consumption'
                        )) . "</div>";?>
                </div>
            </div>
        </div>


    </div>




    <?php
    echo "<div   >" . $this->Form->input('SheetRide.loading_time', array(
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

    echo "<div  >" . $this->Form->input('SheetRide.break_time', array(
            'id' => 'param_break_time',
            'value' => $timeParameters['break_time'],
            'type' => 'hidden',
            'class' => 'form-filter '
        )) . "</div>";

    echo "<div   >" . $this->Form->input('SheetRide.additional_time_allowed', array(
            'id' => 'param_additional_time_allowed',
            'value' => $timeParameters['additional_time_allowed'],
            'type' => 'hidden',
            'class' => 'form-filter '
        )) . "</div>";
    ?>




</div>