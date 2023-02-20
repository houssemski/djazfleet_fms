
<style type="text/css">
    

 #map{height:500px;}
 #panel{width:700px;margin:auto;}

</style>
<?php
if(Configure::read("transport_personnel") == '1'){
    ?>
    <h4 class="page-title"> <?=__('Edit itinerary'); ?></h4>

<?php }else { ?>
    <h4 class="page-title"> <?=__('Edit ride'); ?></h4>

<?php } ?>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('Ride' , array('onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
            <?php

             echo $this->Form->input('id');
              echo "<div class='form-group' id='code-div'>".$this->Form->input('wording', array(
                    'label' => __('Code') .' '.__('Ride'),
                    'class' => 'form-control',
                    'placeholder' =>__('Enter code'),
                      'error' => array('attributes' => array('escape' => false),
                          'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>'.
                              __("The code must be unique") . '</label></div>', true)
                    ))."</div>";


		            echo "<div class='form-group'>".$this->Form->input('departure_destination_id', array(
                    'label' => __('Departure city'),
                    'empty' =>__('Select departure city'),
                    'options'=>$destinations,
					'id'=>'departure_destination',
					'onchange'=>'javascript: getNameDestination(id), getCodeByDestination();',
                    'class' => 'form-control select2',
                    ))."</div>";
					 echo "<div class='form-group' id='departure_destination_id'>" . $this->Form->input('departure', array(
                    'label' => __('Departure'),
                    'placeholder' => __('Enter departure'),
                    'class' => 'form-control',
					'type'=>'hidden',
                    'id'=>"origin",
                    'empty' => ''
                )) . "</div>";

                    echo "<div class='form-group'>".$this->Form->input('arrival_destination_id', array(
                    'label' => __('Arrival city'),
                    'empty' =>__("Select arrival city"),
                    'options'=>$destinations,
					'onchange'=>'javascript: getNameDestination(id), getCodeByDestination();',
					'id'=>'arrival_destination',
                    'class' => 'form-control select2',
                    ))."</div>";

					echo "<div class='form-group' id='arrival_destination_id'>" . $this->Form->input('arrival', array(
                    'label' => __('Arrival'),
                    'placeholder' => __('Enter arrival'),
                    'class' => 'form-control',
                    'id'=>"destination",
					'type'=>'hidden',
                    'empty' => ''
                )) . "</div>";
            
                    echo "<div class='form-group'>".$this->Form->input('distance', array(
                    'label' => __('Distance'),
                    'placeholder' =>__('Enter distance'),
                    'class' => 'form-control',
                    ))."</div>";
                  
                    echo "<div class='form-group'>".$this->Form->input('description', array(
                    'label' => __('Description'),
                    'placeholder' =>__('Enter description'),
                    'class' => 'form-control',
                    ))."</div>";
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
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB33Wa5iG-fztbIhYh60y9YGaZoKuCOPho&libraries=places">
</script>

<?= $this->Html->script('maps/functions.js'); ?>
<script type="text/javascript">

    $(document).ready(function() {
        if (jQuery('#departure_destination').val()>0){
            var id='departure_destination';
            getNameDestination(id);

        }

        if (jQuery('#arrival_destination').val()>0){
            var id='arrival_destination';
            getNameDestination(id);

        }
    });


    function getCodeByDestination(){

        var departureDestination = jQuery('#departure_destination').val();
        var arrivalDestination = jQuery('#arrival_destination').val();

        if(departureDestination >0 && arrivalDestination >0 ){
            jQuery('#code-div').load('<?php echo $this->Html->url('/rides/getCodeByDestination/')?>' + departureDestination + '/' + arrivalDestination);
        }

    }

function getNameDestination(id) {
	destinationId=jQuery('#'+id).val();
	
	
	jQuery('#'+id+'_id').load('<?php echo $this->Html->url('/rides/getNameDestination/')?>' +destinationId+'/'+ id, function() {
		
		if((jQuery('#origin').val()!="") && (jQuery('#destination').val()!="")) {
			
			//calculate();
			var origin= jQuery('#origin').val();
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

         directionsDisplay.setDirections(response);
      }
   });
		}
	});
	
	
}

    function getDairaAndWilayaByDestination (id){
        var destinationId=jQuery('#'+id).val();

        jQuery('#'+id+'_daira_wilaya').load('<?php echo $this->Html->url('/rides/getDairaAndWilayaByDestination/')?>' +destinationId+'/'+ id, function() {
            $(".select2").select2({
                sorter: function (data) {
                    /* Sort data using lowercase comparison */
                    return data.sort(function (a, b) {
                        a = a.text.toLowerCase();
                        b = b.text.toLowerCase();
                        if (a > b) {
                            return 1;
                        } else if (a < b) {
                            return -1;
                        }
                        return 0;
                    });
                },
                allowDuplicates: true

            });
        });

    }


</script>

<?php $this->end(); ?>


