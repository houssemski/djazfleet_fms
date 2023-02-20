
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPU8m0oRFFtHxx05pczOcj05_JaBLpKNk&libraries=places&sensor=true">
</script>

<div id="map" style="float:right;height:100%;width:100%;margin-bottom:10px;"></div>
<?php

?>
<?php ?>
<?php $this->start('script'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        google.maps.event.addDomListener(window, 'load', initialize(36.75218210858053, 3.0426488148193584, 14, "map"));
        $('#addresspicker').focus(function(){
            $(this).val("");
        });
    });
    //fonction initialisant la carte
    function initialize(lat, lng, zoom, carte) {


        /*jQuery('#latitude' + '' + i + '').val(lat);
         jQuery('#longitude'+ '' + i + '').val(lng);*/
        geocoder = new google.maps.Geocoder();
        //par défaut on prend les coordonnées entré dans notre champs latlng
        if ("geolocation" in navigator){
            navigator.geolocation.getCurrentPosition(function(position){
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                var latlng = new google.maps.LatLng(lat, lng);

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


                var marker = new google.maps.Marker({
                    map: map
                });
                //déplacable
                marker.setDraggable(true);
                marker.setPosition(latlng);
                jQuery('#latitude').val(lat);
                jQuery('#longitude').val(lng);
                document.getElementById('latlng').value = latlng;
                var origin=latlng.toString();
                origin = origin.substring(1);
                origin = origin.substring(0,origin.length-1) ;
                jQuery('#origin').val(origin);
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
            });
        }else {
            var latlng = new google.maps.LatLng(lat, lng);
            var options = {
                center: new google.maps.LatLng(lat, lng),
                zoom: zoom,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById(carte), options);
            //on indique que notre champ addresspicker doit proposer les adresses existantes
            var input = document.getElementById('addresspicker' );

            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);
            //mise en place du marqueur
            var infowindow = new google.maps.InfoWindow();


            var marker = new google.maps.Marker({
                map: map
            });
            //déplacable
            marker.setDraggable(true);
            marker.setPosition(latlng);
            jQuery('#latitude').val(lat);
            jQuery('#longitude').val(lng);
            document.getElementById('latlng').value = latlng;
            var origin=latlng.toString();
            origin = origin.substring(1);
            origin = origin.substring(0,origin.length-1) ;
            jQuery('#origin').val(origin);
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

            var marker, i;

            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map
                });

                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }
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





    }


    //fonction appelé plus bas, ouvre un marqueur et recadre la carte aux coordonnées indiquées pour la cartes donnée
    function traiteAdresse(marker, latLng, infowindow, map) {

        //recadre et zomme sur les coordonnées latLng
        map.setCenter(latLng);
        map.setZoom(14);
        //on stocke nos nouvelles coordonée dans le champs correspondant
        var latlongdef = latLng.toString();
        latlongdef = latlongdef.substring(1);
        latlongdef = latlongdef.substring(0, latlongdef.length - 1);
        latlongdef = latlongdef.split(",");
        var latlng = new google.maps.LatLng(latlongdef[0], latlongdef[1]);
        var lat = parseFloat(latlongdef[0]);
        var lng = parseFloat(latlongdef[1]);
        jQuery('#latitude').val(lat);
        jQuery('#longitude').val(lng);
        document.getElementById('latlng').value = latLng;
        var origin=latlng.toString();
        origin = origin.substring(1);
        origin = origin.substring(0,origin.length-1) ;
        jQuery('#origin').val(origin);
        //on va rechercher les information sur l'adresse correspondant à ces coordonnées
        geocoder.geocode({
            'latLng': latLng
        }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    infowindow.setContent(results[0].formatted_address);
                    //on stocke l'adresse complète

                    document.getElementById("addresspicker").value = results[0].formatted_address;
                    jQuery('#latitude').val(lat);
                    jQuery('#longitude').val(lng);
                    document.getElementById('latlng').value = latLng;


                    find_closest_marker(lat, lng);
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

    function rad(x) {return x*Math.PI/180;}
    function find_closest_marker( lat,lng) {
        var destinationId = jQuery('#arrival_destination').val();
        if (destinationId != '') {

        jQuery.ajax({
            type: "POST",
            url: "<?php echo $this->Html->url('/rides/breakpointByArrivalId/')?>",
            data: {
                destinationId: destinationId
            },
            dataType: "json",
            success: function (json) {
                if (json.response === true) {

                    var locations = json.destinations;

                    var R = 6371; // radius of earth in km
                    var distances = [];
                    var closest = -1;

                    for (var i = 0; i < locations.length; i++) {
                        var mlat = locations[i][1];
                        var mlng = locations[i][2];
                        var dLat = rad(mlat - lat);
                        var dLong = rad(mlng - lng);
                        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                            Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong / 2) * Math.sin(dLong / 2);
                        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                        var d = R * c;
                        distances[i] = d;
                        if (closest == -1 || d < distances[closest]) {
                            closest = i;
                        }
                    }
                    var closest_marker = locations[closest][1] + ',' + locations[closest][2];
                    var options = {
                        center: new google.maps.LatLng(lat, lng),
                        zoom: 14,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    jQuery('#closest_marker').val(closest_marker);
                    jQuery('#closest_marker_id').val(locations[closest][3]);
                    var map = new google.maps.Map(document.getElementById('map'), options);
                    var panel = document.getElementById('panel');



                    var origin = document.getElementById('origin').value; // Le point départ
                    var destination = document.getElementById('closest_marker').value; // Le point d'arrivé
                    var originName = document.getElementById('addresspicker').value;

                    window.open('https://www.google.dz/maps/dir/"+origin+"/"+destination+"/@36.7685654,3.0297377,17z/data=!3m1!4b1!4m13!4m12!1m5!1m1!1s0x128fb23d11b3d111:0xa87c4eabe6d1acd4!2m2!1d3.0309897!2d36.7694847!1m5!1m1!1s0x128fb23e7d8bb541:0x640ac90906549cda!2m2!1d3.0330939!2d36.7676216', '_blank');
                    $( "#panel" ).html("<a  target='_blank' title='Itinéraire' href='https://www.google.dz/maps/dir/"+origin+"/"+destination+"/@36.7685654,3.0297377,17z/data=!3m1!4b1!4m13!4m12!1m5!1m1!1s0x128fb23d11b3d111:0xa87c4eabe6d1acd4!2m2!1d3.0309897!2d36.7694847!1m5!1m1!1s0x128fb23e7d8bb541:0x640ac90906549cda!2m2!1d3.0330939!2d36.7676216'><span style ='font-size: 15px; color: rgba(0, 0, 0, 0.87);'> ouvrir l'tinéraire sur la map<span></a>");


                    /* direction = new google.maps.DirectionsRenderer({
                        map: map,
                        panel: panel // Dom element pour afficher les instructions d'itinéraire
                    });
                    if (origin && destination) {
                        var request = {
                            origin: origin,
                            destination: destination,
                            travelMode: google.maps.DirectionsTravelMode.WALKING  // Mode de conduite
                        }
                        var directionsService = new google.maps.DirectionsService(); // Service de calcul d'itinéraire
                        directionsService.route(request, function (response, status) { // Envoie de la requête pour calculer le parcours
                            if (status == google.maps.DirectionsStatus.OK) {
                                direction.setDirections(response); // Trace l'itinéraire sur la carte et les différentes étapes du parcours
                            }
                        });
                    }*/






                      var panel2    = document.getElementById('panel2');
                       direction = new google.maps.DirectionsRenderer({
                           map   : map,
                           });
                       var origin      = document.getElementById('closest_marker').value; // Le point départ
                       var destination = document.getElementById('destination').value; // Le point d'arrivé

                          if(origin && destination){
                           var request = {
                               origin      : origin,
                               destination : destination,
                               travelMode  : google.maps.DirectionsTravelMode.DRIVING // Mode de conduite
                           }
                           var directionsService = new google.maps.DirectionsService(); // Service de calcul d'itinéraire
                           directionsService.route(request, function(response, status){ // Envoie de la requête pour calculer le parcours
                               if(status == google.maps.DirectionsStatus.OK){
                                //   direction.setDirections(response); // Trace l'itinéraire sur la carte et les différentes étapes du parcours
                               }
                           });


                              var marker, i;

                              var locations2 = [];
                              locations2.push(locations[closest]);
                              locations2.push(locations[locations.length-1]);
                              for (i = 0; i < locations2.length; i++) {
                                  marker = new google.maps.Marker({
                                      position: new google.maps.LatLng(locations2[i][1], locations2[i][2]),
                                      map: map
                                  });

                                  google.maps.event.addListener(marker, 'click', (function(marker, i) {
                                      return function() {
                                          infowindow.setContent(locations2[i][0]);
                                          infowindow.open(map, marker);
                                      }
                                  })(marker, i));
                              }

                              var closestMarkerId = jQuery('#closest_marker_id').val();





                              jQuery('#panel2').load('<?php echo $this->Html->url('/rides/getSheetRidesByClosestMarkerIdAndArrivalId/')?>' +destinationId+'/'+ closestMarkerId, function() {
                              });

                              /* jQuery.ajax({
                                  type: "POST",
                                  url: " echo $this->Html->url('/rides/getBreakpointByBetweenClosestMarkerIdAndArrivalId/')?>",
                                  data: {
                                      destinationId: destinationId,
                                      closestMarkerId: closestMarkerId
                                  },
                                  dataType: "json",
                                  success: function (json) {
                                      if (json.response === true) {
                                          var locations = json.destinations;




                                         /* for (var i = 0; i < locations.length; i++) {
                                              $("#panel2").append("<p style ='border-bottom: 1px solid #e6e6e6;'> " + locations[i][0] + "</p>");

                                          }*/
                                     /* }
                                  }
                              });*/



                       }
                } else {

                }
            }
        });

    }









    }
    function getSheetRideDetails(id) {

        var closestMarkerId = jQuery('#closest_marker_id').val();
        var destinationId = jQuery('#arrival_destination').val();
        jQuery('#panel2').load('<?php echo $this->Html->url('/rides/getBreakpointByBetweenClosestMarkerIdAndArrivalId/')?>' +destinationId+'/'+ closestMarkerId+'/'+id, function() {
        });
    }

</script>
<?php $this->end(); ?>