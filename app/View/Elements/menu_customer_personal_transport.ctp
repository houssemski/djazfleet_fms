
<?php
echo $this->Form->create('Ride', array());
echo "<div class ='dep-arr' style ='border-bottom: 1px solid #e6e6e6; height: 105px'>";
echo "<div class='form-group col-sm-12 form-none' >" . $this->Form->input('departure', array(
        'label' => __('Departure point'),
        'class' => 'form-control',
        'id' => 'addresspicker',
        'placeholder' => __('Enter departure'),
    )) . "</div>";
echo "<div class='form-group'>" . $this->Form->input('locations', array(
        'type' => 'hidden',
        'id' => "locations"
    )) . "</div>";
echo "<div class='form-group'>" . $this->Form->input('latlng', array(
        'type' => 'hidden',
        'id' => "latlng"
    )) . "</div>";
echo "<div class='form-group'>" . $this->Form->input('origin', array(
        'type' => 'hidden',
        'id' => "origin"
    )) . "</div>";
echo "<div class='form-group'>" . $this->Form->input('closest_marker', array(
        'type' => 'hidden',
        'id' => "closest_marker"
    )) . "</div>";
echo "<div class='form-group'>" . $this->Form->input('closest_marker_id', array(
        'type' => 'hidden',
        'id' => "closest_marker_id"
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('latitude', array(
        'label' => __(''),
        'placeholder' => __(''),
        'class' => 'form-control',
        'type' => 'hidden',
        'id' => 'latitude',
        'empty' => ''
    )) . "</div>";
echo "<div class='form-group'>" . $this->Form->input('longitude', array(
        'label' => __(''),
        'placeholder' => __(''),
        'class' => 'form-control',
        'id' => 'longitude',
        'type' => 'hidden',
        'empty' => ''
    )) . "</div>";

echo "<div class='form-group col-sm-12 form-none '>" . $this->Form->input('arrival_id', array(
        'label' => __('Arrival point'),
        'id' => 'arrival_destination',
        'onchange'=>'javascript: getNameDestination(id)',
        'class' => 'form-control select-search-destination',
    )) . "</div>";

echo "<div  id='breakpoint-div'></div>";
echo "<div  id='arrival_destination_id'></div>";
echo "</div >";
?>
<div id ='panel-info' style="width:400px;margin:auto; height: 60px; padding: 10px 24px;border-bottom: 1px solid #e6e6e6;">
    <p class="p-info">Des campagnes de sensibilisation et des opérations quotidiennes de désinfection faite par Etusa pour faire face au covid-19</p>
</div>
<div id ='panel' style="width:400px;margin:auto; padding: 10px 24px;border-bottom: 1px solid #e6e6e6;">
</div>
<div id ='panel2' style="width:400px;margin:auto; padding: 15px 24px">
</div>
<script type="text/javascript">
    function getNameDestination(id) {
        var destinationId = jQuery('#'+id).val();
        jQuery('#'+id+'_id').load('<?php echo $this->Html->url('/rides/getNameDestination/')?>' +destinationId+'/'+ id, function() {

            if ((jQuery('#origin').val() != "") && (jQuery('#destination').val() != "")) {

                //calculate();
                /*  var origin= jQuery('#origin').val();
                  var destination = jQuery('#destination').val();
                  var directionsService = new google.maps.DirectionsService();
                  var directionsDisplay = new google.maps.DirectionsRenderer();

                  var myOptions = {
                      zoom:7,
                      mapTypeId: google.maps.MapTypeId.ROADMAP
                  }

                  var map = new google.maps.Map(document.getElementById("map"), myOptions);
                  directionsDisplay.setMap(map);

                  var request = {
                      origin: origin,
                      destination: destination,
                      travelMode: google.maps.DirectionsTravelMode.DRIVING
                  };

                  directionsService.route(request, function(response, status) {
                      if (status == google.maps.DirectionsStatus.OK) {

                          // Display the distance:

                          distance = parseInt(response.routes[0].legs[0].distance.value)/1000;
                          distance= parseInt(distance);
                          jQuery('#RideDistance').val(distance);

                          // Display the duration:
                          /*document.getElementById('duration').innerHTML +=
                             response.routes[0].legs[0].duration.value + " seconds";*/
               // directionsDisplay.setDirections(response);
            //}
                var lat = jQuery('#latitude').val();
                var lng = jQuery('#longitude').val();

                find_closest_marker(lat, lng);
        }
        });



            }




</script>