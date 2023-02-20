<?php
$this->start('css');
echo $this->Html->css('jquery-ui-1.8.12.custom');
$this->end();

?><h4 class="page-title"> <?=__('Route calculation'); ?></h4>
<style type="text/css">
    
    #container{position:relative;width:990px;margin:auto;background:#FFFFFF;padding:20px 0px 20px 0px;}
    #container h1{margin:0px 0px 10px 20px;}
    #container #map{width:700px;height:500px;margin:auto;}
    #container #panel{width:700px;margin:auto;}
    #container #destinationForm{margin:0px 0px 20px 0px;background:#EEEEEE;padding:10px 20px;border:solid 1px #C0C0C0;}
    #container #destinationForm input[type=text]{border:solid 1px #C0C0C0;}
  </style>

   <div id="container">
        
        <div id="destinationForm">
            <form action="" method="get" name="direction" id="direction">
               <?php    echo "<div class='form-group'>" . $this->Form->input('departure', array(
                    'label' => __('Departure'),
                    'placeholder' => __('Enter departure'),
                    'class' => 'form-control',
                    'id'=>"origin",
                       'onchange'=>'calculate()',
                    'empty' => ''
                )) . "</div>";
            echo "<div class='form-group'>".$this->Form->input('latlng', array(
             'type' => 'hidden',
             'id'=>"latlng"
             ))."</div>";
           

                echo "<div class='form-group'>" . $this->Form->input('arrival', array(
                    'label' => __('Arrival'),
                    'placeholder' => __('Enter arrival'),
                    'class' => 'form-control',
                    'id'=>"destination",
                        'onchange'=>'calculate()',
                    'empty' => ''
                )) . "</div>"; ?>
                
                
				<div class="box-footer">
         <?php echo $this->Form->submit(__('Route calculation'), array(
                    'name' => 'ok',
					'type'=>'button',
                    'class' => 'btn btn-primary', 
                    'label' => __('Route calculation'),
                    'onclick' => 'javascript: calculate();',
                    'div' => false
                    )); ?>
				</div>
            </form>
			<br>
			
        <div id="map">
            <p>Veuillez patienter pendant le chargement de la carte...</p>
        </div>
        <div id="panel"></div>
        </div>
        
    </div>




<?php $this->start('script'); ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB33Wa5iG-fztbIhYh60y9YGaZoKuCOPho&libraries=places">
</script>

<script type="text/javascript">
    $(document).ready(function() {

google.maps.event.addDomListener(window, 'load', initial(36.75218210858053, 3.0426488148193584, 14, "map", 'origin'));
google.maps.event.addDomListener(window, 'load', initial(36.75218210858053, 3.0426488148193584, 14, "map", 'destination'));

});

    //fonction initialisant la carte
    function initial(lat, lng, zoom, carte ,id) {

        /*jQuery('#latitude' + '' + i + '').val(lat);
         jQuery('#longitude'+ '' + i + '').val(lng);*/
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
        var input = document.getElementById(id);

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);
        //mise en place du marqueur
        var infowindow = new google.maps.InfoWindow();

        var icoParc = {
            //path: "M-20,0a20,20 0 1,0 40,0a20,20 0 1,0 -40,0",
            //url:'http://image.flaticon.com/icons/svg/190/190290.svg',
            url:'http://image.flaticon.com/icons/svg/204/204314.svg',
            fillColor: '#FF0000',
            //fillOpacity: .3,
            //  anchor: new google.maps.Point(0,0),
            strokeWeight: 0,
            scale: 0.1,
            scaledSize: new google.maps.Size(32,32)
        }
        var marker = new google.maps.Marker({
            map: map
            //icon: icoParc
        });
        //déplacable
        marker.setDraggable(true);
        marker.setPosition(latlng);

        var latlng = new google.maps.LatLng(lat, lng);
        //  document.getElementById('latlng').value = latlng;
        geocoder.geocode({
            'latLng': latlng
        }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    infowindow.setContent(results[0].formatted_address);
                    //on stocke l'adresse complète

                    //document.getElementById("addresspicker"+ '' + i + '').value = results[0].formatted_address;

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

           // traiteAdresse(marker, event.latLng, infowindow, map, i);
        });

        //quand on choisie une adresse proposée on réinitialise la carte avec les nouvelles coordonnées
        google.maps.event.addListener(autocomplete, 'place_changed', function () {

            infowindow.close();
            var place = autocomplete.getPlace();
            marker.setPosition(place.geometry.location);
           // traiteAdresse(marker, place.geometry.location, infowindow, map, i);
        });
    }

    function calculate(){
        var latLng = new google.maps.LatLng(36.77223169574896, 3.0556584332518923); // Correspond au coordonnées de Alger
        var myOptions = {
            zoom      : 14, // Zoom par défaut
            center    : latLng, // Coordonnées de départ de la carte de type latLng
            mapTypeId : google.maps.MapTypeId.TERRAIN, // Type de carte, différentes valeurs possible HYBRID, ROADMAP, SATELLITE, TERRAIN
            maxZoom   : 20
        };
        map      = new google.maps.Map(document.getElementById('map'), myOptions);
        panel    = document.getElementById('panel');

        direction = new google.maps.DirectionsRenderer({
            map   : map,
            panel : panel // Dom element pour afficher les instructions d'itinéraire
        });
        origin      = document.getElementById('origin').value; // Le point départ
        destination = document.getElementById('destination').value; // Le point d'arrivé
        if(origin && destination){
            var request = {
                origin      : origin,
                destination : destination,
                travelMode  : google.maps.DirectionsTravelMode.DRIVING // Mode de conduite
            }
            var directionsService = new google.maps.DirectionsService(); // Service de calcul d'itinéraire
            directionsService.route(request, function(response, status){ // Envoie de la requête pour calculer le parcours
                if(status == google.maps.DirectionsStatus.OK){
                    direction.setDirections(response); // Trace l'itinéraire sur la carte et les différentes étapes du parcours
                }
            });
        }
    }
    </script>

<?php $this->end(); ?>