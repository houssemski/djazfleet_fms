<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB33Wa5iG-fztbIhYh60y9YGaZoKuCOPho&libraries=places">
</script>


<?php

?><h4 class="page-title"> <?=__('Add Parc'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('Parc'  , array('onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
	<?php
        echo "<div class='form-group'>".$this->Form->input('code', array(
                    'label' => __('Code'),
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                                     'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>'. 
                                                     __("The code must be unique") . '</label></div>', true)
                    ))."</div>";
		echo "<div class='form-group'>".$this->Form->input('name', array(
                    'label' => __('Name'),
                    'class' => 'form-control',
					'onchange' => 'javascript:maPosition(this);'
					
                    ))."</div>";

                    echo "<div class='form-group'>" . $this->Form->input('adress', array(
                    'label' => __('Address'),
                    'placeholder' => __('Enter address'),
                    'class' => 'form-control',
                    'id'=>"addresspicker",
                    'empty' => ''
					)) . "</div>";
					echo "<div class='form-group'>".$this->Form->input('latlng', array(
					'type' => 'hidden',
					'id'=>"latlng"
					))."</div>";
					
					echo "<div class='form-group'>" . $this->Form->input('latitude', array(
                    'label' => __(''),
                    'placeholder' => __(''),
                    'class' => 'form-control',
                   'id'=>'latitude',
                    'empty' => ''
                )) . "</div>";
				echo "<div class='form-group'>" . $this->Form->input('longitude', array(
                    'label' => __(''),
                    'placeholder' => __(''),
                    'class' => 'form-control',
                   'id'=>'longitude',
                    'empty' => ''
                )) . "</div>";
           
	?>
    
              
           
            <div id="map" style="float:right;height:500px;width:100%;margin-bottom:10px;"></div>
             </div>
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
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<script type="text/javascript">

    $(document).ready(function() {

        google.maps.event.addDomListener(window, 'load', initialize(36.75218210858053, 3.0426488148193584, 14, "map"));
    });


//fonction appelé plus bas, ouvre un marqueur et recadre la carte aux coordonnées indiquées pour la cartes donnée
    function traiteAdresse(marker, latLng, infowindow, map) {
        //recadre et zomme sur les coordonnées latLng
        map.setCenter(latLng);
        map.setZoom(14);
        //on stocke nos nouvelles coordonée dans le champs correspondant
		var latlongdef=latLng.toString();
		latlongdef = latlongdef.substring(1);
        latlongdef = latlongdef.substring(0,latlongdef.length-1) ;
        latlongdef=latlongdef.split(",");
        var latlng = new google.maps.LatLng(latlongdef[0],latlongdef[1]);
		lat=parseFloat(latlongdef[0]);
		lng=parseFloat(latlongdef[1]);
		jQuery('#latitude').val(lat);
		jQuery('#longitude').val(lng);
        document.getElementById('latlng').value = latLng;
        //on va rechercher les information sur l'adresse correspondant à ces coordonnées
        geocoder.geocode({
            'latLng': latLng
        }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    infowindow.setContent(results[0].formatted_address);
                    //on stocke l'adresse complète
					
                    document.getElementById("addresspicker").value = results[0].formatted_address;

                    var nb_el = results[0].address_components.length;
                    //et ses différentes composantes séparément

                    infowindow.open(map, marker);
                } else {
                    alert("No results found");

                }
            } else {
                alert("Geocoder failed due to: " + status);
            }
        });
    }
    //fonction initialisant la carte    
    function initialize(lat, lng, zoom, carte) {
		 
		jQuery('#latitude').val(lat);
		jQuery('#longitude').val(lng);
        geocoder = new google.maps.Geocoder();
        //par défaut on prend les coordonnées entré dans notre champs latlng
        var latlng = new google.maps.LatLng(lat, lng);
        //on initialise notre carte
        var options = {
            center: new google.maps.LatLng(lat, lng),
            zoom: zoom,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById(carte), options);
        //on indique que notre champ addresspicker doit proposer les adresses existantes
        var input = document.getElementById('addresspicker');
		
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);
        //mise en place du marqueur
        var infowindow = new google.maps.InfoWindow();
		
		      var icoParc = {
                    //path: "M-20,0a20,20 0 1,0 40,0a20,20 0 1,0 -40,0",
                    //url:'http://image.flaticon.com/icons/svg/190/190290.svg',
                    url:'http://image.flaticon.com/icons/svg/266/266715.svg',
                    fillColor: '#FF0000',
                    //fillOpacity: .3,
                    //  anchor: new google.maps.Point(0,0),
                    strokeWeight: 0,
                    scale: 0.1,
                    scaledSize: new google.maps.Size(32,32)
                }
        var marker = new google.maps.Marker({
            map: map,
			icon: icoParc
        });
        //déplacable
        marker.setDraggable(true);
        marker.setPosition(latlng);
		 
		var lat=jQuery('#latitude').val();
		var lng=jQuery('#longitude').val();
		var latlng = new google.maps.LatLng(lat, lng);
		//  document.getElementById('latlng').value = latlng;
		 geocoder.geocode({
            'latLng': latlng
        }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    infowindow.setContent(results[0].formatted_address);
                    //on stocke l'adresse complète
					
                    document.getElementById("addresspicker").value = results[0].formatted_address;

                    var nb_el = results[0].address_components.length;
                    //et ses différentes composantes séparément

                    infowindow.open(map, marker);
                } else {
                    alert("No results found");

                }
            } else {
                alert("Geocoder failed due to: " + status);
            }
        });
		 
        //quand on relache notre marqueur on réinitialise la carte avec les nouvelle coordonnées
        google.maps.event.addListener(marker, 'dragend', function (event) {
			
            traiteAdresse(marker, event.latLng, infowindow, map);
        });

        //quand on choisie une adresse proposée on réinitialise la carte avec les nouvelles coordonnées
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
			
            infowindow.close();
            var place = autocomplete.getPlace();
            marker.setPosition(place.geometry.location);
            traiteAdresse(marker, place.geometry.location, infowindow, map);
        });
    }

	

	
    </script>
<?php $this->end(); ?>