<?php
include("ctp/script.ctp");
?>
<style type="text/css">
    #map {
        height: 500px;
    }
    #panel {
        width: 700px;
        margin: auto;
    }
    .form-group {
        clear: none;
    }
    .form-inline4 {
        width: 20%;
        float: left;
        margin-right: 60px;
    }
</style>
<?php

?><h4 class="page-title"> <?=__('Add detail ride'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">
        <?php echo $this->Form->create('DetailRide' , array('onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
            <?php


            echo "<div  class='select-inline' >" . $this->Form->input('maximum_driving_time', array(
                    'id' => 'param_maximum_driving_time',
                    'value'=>$timeParameters['maximum_driving_time'],
                    'type'=>'hidden',
                    'class' => 'form-filter '
                )) . "</div>";

            echo "<div  class='select-inline' >" . $this->Form->input('break_time', array(
                    'id' => 'param_break_time' ,
                    'value'=>$timeParameters['break_time'],
                    'type'=>'hidden',
                    'class' => 'form-filter '
                )) . "</div>";

            echo "<div class='form-group' id='code-div'>" . $this->Form->input('wording', array(
                    'label' => __('Code'),
                    'class' => 'form-control',
                    'placeholder' => __('Enter code'),
                    'error' => array('attributes' => array('escape' => false),
                        'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>'.
                            __("The code must be unique") . '</label></div>', true)
                )) . "</div>";


            echo "<div class='form-group'>" . $this->Form->input('ride_id', array(
                    'label' => __('Ride'),
                    'empty' => '',
                    'id' => 'ride',
                    'onchange' => 'javascript: getNameRide(), getCodeByRideAndCarType();',
                    'class' => 'form-control select2',
                )) . "</div>"; ?>

            <div id='ride-div'></div>

            <div id='speed-div'></div>

            <?php
            $i=0;
            echo "<div class='form-group'>" . $this->Form->input('managementParameterMissionCost', array(
                    'value'=>$managementParameterMissionCost,
                    'id' => 'managementParameterMissionCost',
                    'class' => 'form-control',
                    'type' =>'hidden',
                )) . "</div>";

            switch ($managementParameterMissionCost) {
            case '1':
                echo "<div class='form-group'>" . $this->Form->input('car_type_id', array(
                        'label' => __('Transportation'),
                        'onchange' => 'javascript:calculateMissionCostByDuration(), getCodeByRideAndCarType();',
                        'empty' => '',
                        'id' => 'car_type',
                        'class' => 'form-control select2',
                    )) . "</div>";


                echo "<div class='form-group' id ='mission_cost_day_div'>" . $this->Form->input('parameter_mission_cost_day', array(
                        'label' => __('Mission cost per day'),
                        'placeholder' => __('Enter cost'),
                        'class' => 'form-control',
                        'readonly' => true,
                        'id' => 'parameter_mission_cost_day'
                    )) . "</div>";
                echo "<div class='form-group'>" . $this->Form->input('MissionCost.0.cost_day', array(
                        'label' => __('Mission costs'),
                        'placeholder' => __('Enter cost'),
                        'class' => 'form-control',
                        'id' => 'cost_day'
                    )) . "</div>";
                echo "<div class='form-group'>" . $this->Form->input('distance', array(
                        'label' => __('Distance'),
                        'placeholder' => __('Enter distance'),
                        'class' => 'form-control',
                        'onchange' => 'javascript:calculateDurationReal();',
                        'id' => 'distance'
                    )) . "</div>";
                break;
            case '2':
                echo "<div class='form-group'>" . $this->Form->input('car_type_id', array(
                        'label' => __('Transportation'),
                        'onchange' => 'javascript:calculateDurationAndDistance(), getCodeByRideAndCarType();',
                        'empty' => '',
                        'id' => 'car_type',
                        'class' => 'form-control select2',
                    )) . "</div>";

                echo "<div class='form-group'>" . $this->Form->input('MissionCost.0.cost_destination', array(
                        'label' => __('Mission costs'),
                        'placeholder' => __('Enter cost'),
                        'class' => 'form-control',
                        'id' => 'cost_destination'
                    )) . "</div>";
                echo "<div class='form-group'>" . $this->Form->input('distance', array(
                        'label' => __('Distance'),
                        'placeholder' => __('Enter distance'),
                        'class' => 'form-control',
                        'onchange' => 'javascript:calculateDurationReal();',
                        'id' => 'distance'
                    )) . "</div>";
                break;
            case '3':
                echo "<div class='form-group'>" . $this->Form->input('car_type_id', array(
                        'label' => __('Transportation'),
                        'onchange' => 'javascript:calculateMissionCostByDistance(), getCodeByRideAndCarType();',
                        'empty' => '',
                        'id' => 'car_type',
                        'class' => 'form-control select2',
                    )) . "</div>";

                ?>
            <table style="width: 83%;" id='dynamic_field'>
                <tr>
                    <td>
                        <?php
                        if ($useRideCategory ==2) {

                        echo "<div class='form-group'>" . $this->Form->input('MissionCost.' . $i . '.ride_category_id', array(
                                'label' => __('Ride category'),

                                'empty' => '',
                                'id' => 'car_type',
                                'class' => 'form-control select2',
                            )) . "</div>";

                        }
                                echo "<div class='form-group'>" . $this->Form->input('MissionCost.' . $i . '.cost_truck_full', array(
                                        'label' => __('Mission costs truck full'),
                                        'placeholder' => __('Enter cost'),
                                        'class' => 'form-control',
                                        'id'=>'cost_truck_full'
                                    )) . "</div>";
                                echo "<div class='form-group'>" . $this->Form->input('MissionCost.' . $i . '.cost_truck_empty', array(
                                        'label' => __('Mission costs truck empty'),
                                        'placeholder' => __('Enter cost'),
                                        'class' => 'form-control',
                                        'id'=>'cost_truck_empty'
                                    )) . "</div>"; ?>
                            </td>
                    <?php if ($useRideCategory ==2) {?>
                            <td class="td_tab">
                                <button style="margin-left: 40px;" type='button' name='add' onclick='addOtherMissionCost()'
                                        class='btn btn-success'><?= __('Add more') ?></button>
                            </td>
                    <?php } ?>
                        </tr>
                    </table>
                    <?php
                echo "<div id ='mission_cost_distance_div'>";
                echo "<div class='form-group'>" . $this->Form->input('parameter_mission_cost_truck_full', array(
                            'label' => __('Mission costs truck full'),
                            'placeholder' => __('Enter cost'),
                            'class' => 'form-control',
                            'type'=>'hidden',
                            'id'=>'parameter_mission_cost_truck_full'
                        )) . "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('parameter_mission_cost_truck_empty', array(
                            'label' => __('Mission costs truck empty'),
                            'placeholder' => __('Enter cost'),
                            'class' => 'form-control',
                            'type'=>'hidden',
                            'id'=>'parameter_mission_cost_truck_empty'
                        )) . "</div>";
                echo "</div>";
                    echo "<div class='form-group'>" . $this->Form->input('distance', array(
                            'label' => __('Distance'),
                            'placeholder' => __('Enter distance'),
                            'class' => 'form-control',
                            'onchange' => 'javascript: calculateDurationReal(), calculateMissionCost();',
                            'id'=>'distance'
                        )) . "</div>";
                    break;
            } ?>
            <?php
            echo "<div class='form-group form-inline4' >" . $this->Form->input('duration_day', array(
                    'label' => __('Duration').' '.__('theoretical').' ('. __('Days') . ')',
                    'placeholder' => __('Day'),
                    'id' => 'duration_day',
                    'onchange'=>'calculateMissionCostByDurationDay();',
                    'class' => 'form-control',
                )) . "</div>";
            echo "<div class='form-group form-inline4' style='margin-top: 5px;'>" . $this->Form->input('duration_hour', array(
                    'label' => __('Duration').' '.__('theoretical').' ('. __('Hour') . ')',
                    'placeholder' => __('Hour'),
                    'id' => 'duration_hour',
                    'class' => 'form-control',
                )) . "</div>";
            echo "<div class='form-group form-inline4' style='margin-top: 5px;'>" . $this->Form->input('duration_minute', array(
                    'label' =>__('Duration').' '.__('theoretical').' ('. __('Min') . ')',
                    'id' => 'duration_min',
                    'placeholder' => __('Min'),
                    'class' => 'form-control',
                )) . "</div>"; ?>

            <div style="clear:both;"></div>
           <?php echo "<div class='form-group form-inline4' >" . $this->Form->input('real_duration_day', array(
                    'label' => __('Duration').' '.__('real').' ('. __('Days') . ')',
                    'placeholder' => __('Day'),
                    'id' => 'real_duration_day',
                    'class' => 'form-control',
                )) . "</div>";
            echo "<div class='form-group form-inline4' style='margin-top: 5px;'>" . $this->Form->input('real_duration_hour', array(
                    'label' => __('Duration').' '.__('real').' ('. __('Hour') . ')',
                    'placeholder' => __('Hour'),
                    'id' => 'real_duration_hour',
                    'class' => 'form-control',
                )) . "</div>";
            echo "<div class='form-group form-inline4' style='margin-top: 5px;'>" . $this->Form->input('real_duration_minute', array(
                    'label' =>__('Duration').' '.__('real').' ('. __('Min') . ')',
                    'id' => 'real_duration_min',
                    'placeholder' => __('Min'),
                    'class' => 'form-control',
                )) . "</div>";

            ?>


            <div style="clear:both;"></div>
            <?php  echo "<div class='form-group'>" . $this->Form->input('description', array(
                    'label' => __('Description'),
                    'placeholder' => __('Enter description'),
                    'class' => 'form-control',
                )) . "</div>";
            ?>
            <div id="map">
                <p>Veuillez patienter pendant le chargement de la carte...</p>
            </div>
        </div>
        <br>
        <div class="box-footer">
            <?php echo $this->Form->submit(__('Submit'), array(
                'name' => 'ok',
                'class' => 'btn btn-primary btn-bordred  m-b-5',
                'label' => __('Submit'),
                'type' => 'submit',
                'id'=>'boutonValider',
                'div' => false
            )); ?>
            <?php echo $this->Form->submit(__('Cancel'), array(
                'name' => 'cancel',
                'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                'label' => __('Cancel'),
                'type' => 'submit',
                'div' => false,
                'formnovalidate' => true
            )); ?>
        </div>
    </div>
</div>
<?php $this->start('script'); ?>
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPU8m0oRFFtHxx05pczOcj05_JaBLpKNk&libraries=places">
</script>

<?= $this->Html->script('maps/functions.js'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        item=0;
        google.maps.event.addDomListener(window, 'load', initialize(36.75218210858053, 3.0426488148193584, 14, "map"));
    });


    function getNameRide() {

        var ride_id = jQuery('#ride').val();

        jQuery('#ride-div').load('<?php echo $this->Html->url('/detailRides/getNameRide/')?>' + ride_id, function () {

            var managementParameterMissionCost = jQuery('#managementParameterMissionCost').val();

            switch (managementParameterMissionCost){

                case '1':
                    calculateMissionCostByDuration();
                    break;
                case '2':
                    calculateDurationAndDistance();
                    break;
                case '3':

                    calculateMissionCostByDistance();
                    break;
            }
        });

    }
    function calculateMissionCostByDistance() {


        if ((jQuery('#origin').val() != "") && (jQuery('#destination').val() != "") && (jQuery('#car_type').val() > 0)) {
            jQuery('#mission_cost_distance_div').load('<?php echo $this->Html->url('/detailRides/getMissionCostParameterByCarType/')?>' +3+'/'+ jQuery('#car_type').val(), function () {

            });

            //calculate();
            var origin = jQuery('#origin').val();
            var destination = jQuery('#destination').val();
            var directionsService = new google.maps.DirectionsService();
            var directionsDisplay = new google.maps.DirectionsRenderer();
            var trafficLayer = new google.maps.TrafficLayer();


            var myOptions = {
                zoom: 7,
                center: {lat: 34.04924594193164, lng: -118.24104309082031}

            }

            var map = new google.maps.Map(document.getElementById("map"), myOptions);
            directionsDisplay.setMap(map);



            var request = {
                origin: origin,
                destination: destination,
                travelMode: google.maps.DirectionsTravelMode.DRIVING,
                drivingOptions: {
                    departureTime: new Date(Date.now()),  // for the time N milliseconds from now.
                    trafficModel: 'optimistic'
                }


            };

            directionsService.route(request, function (response, status) {
                if (status == google.maps.DirectionsStatus.OK) {

                    // Display the distance:

                    distance = parseInt(response.routes[0].legs[0].distance.value)/1000;
                    distance= parseInt(distance);
                    jQuery('#distance').val(distance);
                    calculateDurationReal();
                    var  costTruckFull = parseFloat(distance)*parseFloat(jQuery('#parameter_mission_cost_truck_full').val());
                    var  costTruckEmpty = parseFloat(distance)*parseFloat(jQuery('#parameter_mission_cost_truck_empty').val());
                    jQuery('#cost_truck_full').val(costTruckFull);
                    jQuery('#cost_truck_empty').val(costTruckEmpty);

                    // Display the duration:
                    tmp = response.routes[0].legs[0].duration.value;
                    var diff = {}
                    diff.sec = tmp % 60;                    // Extraction du nombre de secondes
                    tmp = Math.floor((tmp - diff.sec) / 60);    // Nombre de minutes (partie entière)
                    diff.min = tmp % 60;                    // Extraction du nombre de minutes

                    jQuery('#duration_min').val(diff.min);
                    tmp = Math.floor((tmp - diff.min) / 60);    // Nombre d'heures (entières)
                    diff.hour = tmp % 24;                   // Extraction du nombre d'heures

                    jQuery('#duration_hour').val(diff.hour);
                    tmp = Math.floor((tmp - diff.hour) / 24);   // Nombre de jours restants
                    diff.day = tmp;
                    jQuery('#duration_day').val(diff.day);


                    directionsDisplay.setDirections(response);
                }
            });
        }


    }

    function calculateMissionCostByDuration() {

        if ((jQuery('#origin').val() != "") && (jQuery('#destination').val() != "") && (jQuery('#car_type').val() > 0)) {

            jQuery('#mission_cost_day_div').load('<?php echo $this->Html->url('/detailRides/getMissionCostParameterByCarType/')?>' +1+'/'+ jQuery('#car_type').val(), function () {

                //calculate();
                var origin = jQuery('#origin').val();
                var destination = jQuery('#destination').val();
                var directionsService = new google.maps.DirectionsService();
                var directionsDisplay = new google.maps.DirectionsRenderer();

                var myOptions = {
                    zoom: 7,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }

                var map = new google.maps.Map(document.getElementById("map"), myOptions);
                directionsDisplay.setMap(map);

                var request = {
                    origin: origin,
                    destination: destination,
                    travelMode: google.maps.DirectionsTravelMode.DRIVING
                };

                directionsService.route(request, function (response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        // Display the distance:
                        distance = parseInt(response.routes[0].legs[0].distance.value)/1000;
                        distance= parseInt(distance);
                        jQuery('#distance').val(distance);
                        calculateDurationReal();

                        // Display the duration:

                        tmp = response.routes[0].legs[0].duration.value;
                        var diff = {}
                        diff.sec = tmp % 60;                    // Extraction du nombre de secondes
                        tmp = Math.floor((tmp - diff.sec) / 60);    // Nombre de minutes (partie entière)
                        diff.min = tmp % 60;                    // Extraction du nombre de minutes

                        jQuery('#duration_min').val(diff.min);
                        tmp = Math.floor((tmp - diff.min) / 60);    // Nombre d'heures (entières)
                        diff.hour = tmp % 24;                   // Extraction du nombre d'heures

                        jQuery('#duration_hour').val(diff.hour);
                        tmp = Math.floor((tmp - diff.hour) / 24);   // Nombre de jours restants
                        diff.day = tmp;
                        jQuery('#duration_day').val(diff.day);
                        duration = parseInt(diff.day)+1;
                        var  costDay = parseFloat(duration)*parseFloat(jQuery('#parameter_mission_cost_day').val());

                        jQuery('#cost_day').val(costDay);



                        directionsDisplay.setDirections(response);
                    }
                });

            });

        }
    }

    function calculateDurationAndDistance() {
        if ((jQuery('#origin').val() != "") && (jQuery('#destination').val() != "") && (jQuery('#car_type').val() > 0)) {
            //calculate();
            var origin = jQuery('#origin').val();
            var destination = jQuery('#destination').val();
            var directionsService = new google.maps.DirectionsService();
            var directionsDisplay = new google.maps.DirectionsRenderer();
            var myOptions = {
                zoom: 7,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            var map = new google.maps.Map(document.getElementById("map"), myOptions);
            directionsDisplay.setMap(map);
            var request = {
                origin: origin,
                destination: destination,
                travelMode: google.maps.DirectionsTravelMode.DRIVING

            };
            directionsService.route(request, function (response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    // Display the distance:
                    distance = parseInt(response.routes[0].legs[0].distance.value)/1000;
                    distance= parseInt(distance);
                    jQuery('#distance').val(distance);
                    calculateDurationReal();
                    // Display the duration:
                    tmp = response.routes[0].legs[0].duration.value;
                    var diff = {}
                    diff.sec = tmp % 60;                    // Extraction du nombre de secondes
                    tmp = Math.floor((tmp - diff.sec) / 60);    // Nombre de minutes (partie entière)
                    diff.min = tmp % 60;                    // Extraction du nombre de minutes
                    jQuery('#duration_min').val(diff.min);
                    tmp = Math.floor((tmp - diff.min) / 60);    // Nombre d'heures (entières)
                    diff.hour = tmp % 24;                   // Extraction du nombre d'heures
                    jQuery('#duration_hour').val(diff.hour);
                    tmp = Math.floor((tmp - diff.hour) / 24);   // Nombre de jours restants
                    diff.day = tmp;
                    jQuery('#duration_day').val(diff.day);
                    directionsDisplay.setDirections(response);


                }
            });
        }


    }
    function calculateMissionCostByDurationDay(){
        var  costDay = parseFloat(jQuery('#duration_day').val())*parseFloat(jQuery('#parameter_mission_cost_day').val());
        jQuery('#cost_day').val(costDay);
    }

    function getCodeByRideAndCarType(){
        var ride = jQuery('#ride').val();
        var carType = jQuery('#car_type').val();

        if(ride >0 && carType >0 ){
            jQuery('#code-div').load('<?php echo $this->Html->url('/detailRides/getCodeByRideAndCarType/')?>' + ride + '/' + carType);
            jQuery('#speed-div').load('<?php echo $this->Html->url('/detailRides/getAverageSpeedByCarType/')?>' + carType,function(){
                    calculateDurationReal();
            });
        }
    }
    function calculateMissionCost() {
        var distance= jQuery('#distance').val();
        var  costTruckFull = parseFloat(distance)*parseFloat(jQuery('#parameter_mission_cost_truck_full').val());
        var  costTruckEmpty = parseFloat(distance)*parseFloat(jQuery('#parameter_mission_cost_truck_empty').val());
        jQuery('#cost_truck_full').val(costTruckFull);
        jQuery('#cost_truck_empty').val(costTruckEmpty);
    }

    function addOtherMissionCost(){

        jQuery('#dynamic_field').append('<tr id="row'+item+'"><td ></td></tr>');

        jQuery("#row"+''+item+'').load('<?php echo $this->Html->url('/detailRides/getMissionCost/')?>' +item, function() {

        });
        item++;
    }


    function calculateDurationReal(){
        var averageSpeed = jQuery('#average_speed').val();
        if(averageSpeed>0){
        var paramMaximumDrivingTime = jQuery('#param_maximum_driving_time').val();

        var paramBreakTime = jQuery('#param_break_time').val();

        var distance = jQuery('#distance').val();

        var maximumDrivingTimePerMin= parseFloat(paramMaximumDrivingTime)*60;

        var breakTimePerMin= parseFloat(paramBreakTime)*60;

        var averageSpeedPerMin = parseFloat(averageSpeed)/60;
        var durationPerDistance = parseFloat(distance)/parseFloat(averageSpeedPerMin);

        var totalMinDivMaximumDrivingTimePerMin = (durationPerDistance /  maximumDrivingTimePerMin);

        totalMinDivMaximumDrivingTimePerMin = parseInt(totalMinDivMaximumDrivingTimePerMin);
        var totalMinModMaximumDrivingTimePerMin = (durationPerDistance % maximumDrivingTimePerMin);

        var totalDurationPerMin =
            (totalMinDivMaximumDrivingTimePerMin*maximumDrivingTimePerMin) +
            (totalMinDivMaximumDrivingTimePerMin * breakTimePerMin) +
            parseFloat(totalMinModMaximumDrivingTimePerMin)  ;
        var nbHour = totalDurationPerMin/60;
        nbHour = parseInt(nbHour);
        var nbMin = totalDurationPerMin % 60;
        nbMin = Math.round(nbMin);
        var nbDay = nbHour / 24;
        nbDay = parseInt(nbDay);
        nbHour =  nbHour % 24;
        jQuery('#real_duration_day').val(nbDay);
        jQuery('#real_duration_hour').val(nbHour);
        jQuery('#real_duration_min').val(nbMin);
        }


    }

    function remove(id) {


        $('#row' + id + '').remove();


    };


</script>

<?php $this->end(); ?>


