
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

<input type="hidden" id="rideid" name="rideid">

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
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB33Wa5iG-fztbIhYh60y9YGaZoKuCOPho&libraries=places">
</script>

<?= $this->Html->script('maps/functions.js'); ?>
<script type="text/javascript">

    $(document).ready(function() {

        google.maps.event.addDomListener(window, 'load', initialize(36.75218210858053, 3.0426488148193584, 14, "map"));

        calculDuration();


            //calculate();




       /* alert(arrayRides);
        alert(arrayDurationMin);
        alert(arrayDurationHour);
        alert(arrayDurationDay);
        alert(arrayRealDurationMin);
        alert(arrayRealDurationHour);
        alert(arrayRealDurationDay);
        jQuery.ajax({
            type: "POST",
            url: " echo $this->Html->url('/detailRides/addRide/')?>",
            dataType: "json",
            data: {ids: JSON.stringify(arrayRides), duration_min: JSON.stringify(arrayDurationMin), duration_hour: JSON.stringify(arrayDurationHour),
                duration_day:JSON.stringify(arrayDurationDay), real_duration_day:JSON.stringify(arrayRealDurationMin) ,
                real_duration_hour: JSON.stringify(arrayRealDurationHour) , real_duration_min: JSON.stringify(arrayRealDurationDay) },
            success: function (json) {

                if (json.response == "true") {
                    alert(json.response);

                }
            }
        });*/



    });



function calculDuration (){

    var arrayRides = new Array();
    var arrayDurationMin = new Array() ;
    var arrayDurationHour = new Array();
    var arrayDurationDay = new Array();
    var arrayRealDurationMin = new Array();
    var arrayRealDurationHour = new Array();
    var arrayRealDurationDay = new Array();



    <?php

    foreach ($rides as $ride) {
    $latlongdep = $ride['DepartureDestination']['latlng'];
    $latlongdep = substr($latlongdep,1);
    $latlongdep = substr ($latlongdep,0,strlen($latlongdep)-1);
    $latlongdarri = $ride['ArrivalDestination']['latlng'];
    $latlongdarri = substr($latlongdarri,1);
    $latlongdarri = substr ($latlongdarri,0,strlen($latlongdarri)-1);

    ?>

    var origin = '<?php echo $latlongdep?>';
    var destination = '<?php echo $latlongdarri?>';
    var rideId =<?php  echo $ride['Ride']['id']  ?>;
    arrayRides.push(rideId);

    getDuration(origin,destination,rideId);
    <?php } ?>


}


function getDuration(origin,destination,id)
{
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
            var  distance = parseInt(response.routes[0].legs[0].distance.value)/1000;
            distance= parseInt(distance);
            // Display the duration:
            tmp = response.routes[0].legs[0].duration.value;
            var diff = {}
            diff.sec = tmp % 60;                    // Extraction du nombre de secondes
            tmp = Math.floor((tmp - diff.sec) / 60);    // Nombre de minutes (partie entière)
            diff.min = tmp % 60;                    // Extraction du nombre de minutes

            tmp = Math.floor((tmp - diff.min) / 60);    // Nombre d'heures (entières)
            diff.hour = tmp % 24;                   // Extraction du nombre d'heures

            tmp = Math.floor((tmp - diff.hour) / 24);   // Nombre de jours restants
            diff.day = tmp;


            directionsDisplay.setDirections(response);

            var averageSpeed = 60;

            if(averageSpeed>0) {
                var paramMaximumDrivingTime = 12;

                var paramBreakTime = 8;

                var maximumDrivingTimePerMin = parseFloat(paramMaximumDrivingTime) * 60;

                var breakTimePerMin = parseFloat(paramBreakTime) * 60;

                var averageSpeedPerMin = parseFloat(averageSpeed) / 60;
                var durationPerDistance = parseFloat(distance) / parseFloat(averageSpeedPerMin);

                var totalMinDivMaximumDrivingTimePerMin = (durationPerDistance / maximumDrivingTimePerMin);

                totalMinDivMaximumDrivingTimePerMin = parseInt(totalMinDivMaximumDrivingTimePerMin);
                var totalMinModMaximumDrivingTimePerMin = (durationPerDistance % maximumDrivingTimePerMin);

                var totalDurationPerMin =
                    (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                    (totalMinDivMaximumDrivingTimePerMin * breakTimePerMin) +
                    parseFloat(totalMinModMaximumDrivingTimePerMin);
                var nbHour = totalDurationPerMin / 60;
                nbHour = parseInt(nbHour);
                var nbMin = totalDurationPerMin % 60;
                nbMin = Math.round(nbMin);
                var nbDay = nbHour / 24;
                nbDay = parseInt(nbDay);
                nbHour = nbHour % 24;


                /* alert(origin);
                 alert(destination);
                 alert(diff.min);
                 alert(diff.hour);
                 alert(diff.day);*/
                //idride= $("#rideid").val();

                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo $this->Html->url('/detailRides/addRide/')?>",
                    dataType: "json",
                    data: {id: id, duration_min: diff.min , duration_hour: diff.hour,
                        duration_day:diff.day, real_duration_day: nbDay,
                        real_duration_hour: nbHour , real_duration_min: nbMin },
                    success: function (json) {

                        if (json.response == "true") {


                        }
                    }
                });

            }





        }
    });
}







</script>

<?php $this->end(); ?>


