

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB33Wa5iG-fztbIhYh60y9YGaZoKuCOPho&libraries=places">
</script>

<?php

if(!empty($position)){
    $latlng='('.$position['Latitude'].','.$position['Longitude'].')';
}else {
    $latlng= null;
}
?><h4 class="page-title"> <?=__('Position'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0" style="height: 780px;">

        <div class="box-body">
            <?php




            echo "<div class='form-group'>" . $this->Form->input('latlng', array(
                    'type' => 'hidden',
                    'value' => $latlng,
                    'id'=>"latlng"
                )) . "</div>";

            echo "<div class='form-group'>" . $this->Form->input('code', array(
                    'type' => 'hidden',
                    'value' => $code,
                    'id'=>"code"
                )) . "</div>";

            ?>
            <div id="map" style="float:right;height:700px;width:100%;margin-bottom:10px;"></div>

        </div>

    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {
        google.maps.event.addDomListener(window, 'load', initialize( 14,"map"));


    });

    //fonction appel� plus bas, ouvre un marqueur et recadre la carte aux coordonn�es indiqu�es pour la cartes donn�e
    /* function traiteAdresse(marker, latLng, infowindow, map){
     //recadre et zomme sur les coordonn�es latLng

     map.setCenter(latLng);
     map.setZoom(14);
     var latlongdef=latLng.toString();
     latlongdef = latlongdef.substring(1);
     latlongdef = latlongdef.substring(0,latlongdef.length-1) ;
     latlongdef=latlongdef.split(",");
     var latlng = new google.maps.LatLng(latlongdef[0],latlongdef[1]);
     lat=parseFloat(latlongdef[0]);
     lng=parseFloat(latlongdef[1]);
     jQuery('#latitude').val(lat);
     jQuery('#longitude').val(lng);
     //on stocke nos nouvelles coordon�e dans le champs correspondant
     document.getElementById('latlng').value=latLng;
     //on va rechercher les information sur l'adresse correspondant � ces coordonn�es
     geocoder.geocode({
     'latLng': latLng
     }, function(results, status) {
     if (status == google.maps.GeocoderStatus.OK) {
     if (results[1]) {
     infowindow.setContent(results[0].formatted_address);
     //on stocke l'adresse compl�te
     document.getElementById("addresspicker").value=results[0].formatted_address;

     var nb_el=results[0].address_components.length;
     //et ses diff�rentes composantes s�par�ment

     infowindow.open(map, marker);
     } else {
     alert("No results found");
     }
     } else {
     alert("Geocoder failed due to: " + status);
     }
     });
     }*/


    //fonction initialisant la carte


    function initialize( zoom, carte) {
        geocoder = new google.maps.Geocoder();
        //par d�faut on prend les coordonn�es entr� dans notre champs latlng
        var latlongdef = document.getElementById('latlng').value;
        if (latlongdef=='') { var latlng = new google.maps.LatLng(36.75218210858053, 3.0426488148193584); }
        else {
            latlongdef = latlongdef.substring(1);

            latlongdef = latlongdef.substring(0,latlongdef.length-1) ;

            latlongdef=latlongdef.split(",");
            var latlng = new google.maps.LatLng(latlongdef[0],latlongdef[1]);
        }


        //on initialise notre carte
        var options = {
            center: latlng,
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

        /* var infowindow = new google.maps.InfoWindow({
         content: contentString
         });




         var marker = new google.maps.Marker({
         map: map,


         title: 'Uluru (Ayers Rock)'


         });
         marker.addListener('click', function() {
         infowindow.open(map, marker);
         });*/
        var code= jQuery('#code').val();
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+code+
            '</div>'+

            '<div id="bodyContent">'+

            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });



        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: code
        });
        marker.addListener('mouseover', function() {
            infowindow.open(map, marker);
        });


        /*map.addOverlay(marker);
         GEvent.addListener(marker, 'mouseover', function() {marker.openInfoWindowHtml("Showroom <br\> Cite 100 log mohamed el kourd du lotissement 19 mai 1956 ANNABA.");});*/

        //d�placable
        marker.setDraggable(true);
        marker.setPosition(latlng);
        //quand on relache notre marqueur on r�initialise la carte avec les nouvelle coordonn�es
        /*  google.maps.event.addListener(marker, 'dragend', function(event) {
         traiteAdresse(marker, event.latLng, infowindow, map);
         });

         //quand on choisie une adresse propos�e on r�initialise la carte avec les nouvelles coordonn�es
         google.maps.event.addListener(autocomplete, 'place_changed', function() {
         infowindow.close();
         var place = autocomplete.getPlace();
         marker.setPosition(place.geometry.location);
         traiteAdresse(marker, place.geometry.location, infowindow, map);
         });*/
    }


</script>
