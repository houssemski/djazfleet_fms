
<style type="text/css">
    #map{height:500px;}
    #panel{width:700px;margin:auto;}

</style>
<?php

if(empty($sheetRides)){ ?>
    <div id="flashMessage" class="message">
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo __('There are no trucks back to the park in this zone.'); ?>
        </div>
    </div>
<?php } ?>
<h4 class="page-title"> <?=__('Search'); ?></h4>
<div class="box">
    <div class="edit form card-box p-b-0">

        <div class="box-body">
            <?php echo "<div class='form-group'>".$this->Form->input('latlng', array(
                'type' => 'hidden',
                'id'=>"latlng",
                    'value'=>$departureDestinationLatlng,
                ))."</div>";
            $i = 0;

            if(!empty($sheetRides)){
            foreach( $sheetRides as $sheetRide){
                echo "<div class='form-group'>".$this->Form->input('latlng', array(
                        'type' => 'hidden',
                        'id'=>"latlng".$i,
                        'value'=>$sheetRide['LastArrivalDestination']['latlng'],
                    ))."</div>";
                $i ++;

            }
            }else {

            echo $this->Form->create('SheetRides', array(
                'url'=> array(
                    'action' => 'searchCarMoreNear'
                ),
                'novalidate' => true
            )); ?>
            <div class="filters" id='filters'>

                <?php
                echo $this->Form->input('zone_id', array(
                    'label' => __('Zone'),
                    'class' => 'form-filter select2',
                    'empty' => ''
                ));
                echo $this->Form->input('transport_bill_detail_ride_d', array(
                    'label' => __('id'),
                    'value' => $transportBillDetailRideId,
                    'type'=>'hidden',
                    'empty' => ''
                ));

                ?>
                <div style='clear:both; padding-top: 10px;'></div>

                <button class="btn btn-default" type="submit"><?= __('Search') ?></button>
                <div style='clear:both; padding-top: 10px;'></div>
            </div>
                <?php echo $this->Form->end(); ?>
          <?php  }
            if(!empty($companyLatlng)){
                echo "<div class='form-group'>".$this->Form->input('latlng', array(
                        'type' => 'hidden',
                        'id'=>"latlngCompany",
                        'value'=>$companyLatlng,
                    ))."</div>";
            }elseif(!empty($wilayaLatlng)){
                echo "<div class='form-group'>".$this->Form->input('latlng', array(
                        'type' => 'hidden',
                        'id'=>"latlngCompany",
                        'value'=>$wilayaLatlng,
                    ))."</div>";
            }else {
                echo "<div class='form-group'>".$this->Form->input('latlng', array(
                        'type' => 'hidden',
                        'id'=>"latlngCompany",
                        'value'=>$wilayaName,
                    ))."</div>";
            }

            ?>

            <div id="map">
                <p>Veuillez patienter pendant le chargement de la carte...</p>
            </div>
            <br>
            <br>

            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"                            cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort( __('Car')); ?></th>
                    <th><?php echo $this->Paginator->sort( __('Departure city')); ?></th>
                    <th><?php echo $this->Paginator->sort( __('Arrival city')); ?></th>
                    <th><?php echo $this->Paginator->sort( __('Distance')); ?></th>
                    <th><?php echo $this->Paginator->sort( __('Duration')); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                </thead>
                <tbody  id ='duration'>

                </tbody>
              </table>

        </div>
        <br>

    </div>

</div>
<?php $this->start('script'); ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB33Wa5iG-fztbIhYh60y9YGaZoKuCOPho&libraries=places">
</script>

<script type="text/javascript">

    $(document).ready(function() {
        google.maps.event.addDomListener(window, 'load', initialize( 14,"map"));
    });
    function initialize( zoom, carte) {
        geocoder = new google.maps.Geocoder();
        //par défaut on prend les coordonnées entré dans notre champs latlng


        //mise en place du marqueur
        var infowindow = new google.maps.InfoWindow();
        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay = new google.maps.DirectionsRenderer();
        var icoTruck = {
            //path: "M-20,0a20,20 0 1,0 40,0a20,20 0 1,0 -40,0",
            //url:'http://image.flaticon.com/icons/svg/190/190290.svg',
            url: 'https://www.shareicon.net/download/2015/11/22/676178_wheels.svg',
            fillColor: '#FF0000',
            //fillOpacity: .3,
            //  anchor: new google.maps.Point(0,0),
            strokeWeight: 0,
            scale: 0.1,
            scaledSize: new google.maps.Size(32, 32)
        }
        var icoParc = {
            url:'http://image.flaticon.com/icons/svg/266/266715.svg',
            fillColor: '#FF0000',
            strokeWeight: 0,
            scale: 0.1,
            scaledSize: new google.maps.Size(32, 32)
        }

        function addMarker(cible, icone, titre='') {

            var marker = new google.maps.Marker({
                position: cible,
                title: titre,
                draggable: true,
                animation: google.maps.Animation.DROP,
                map: map,
                icon: icone
            });
            marker.addListener('click', function () {
                if (marker.getAnimation() !== null) {
                    marker.setAnimation(null);
                } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                }
            });
            //  markers.push(marker);
        }

        function getDurationFromPark(origin,destination, directionsService,directionsDisplay, transportBillDetailRideId){


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

                    var route = response.routes[0];
                    var summaryPanel = document.getElementById('duration');
                    // summaryPanel.innerHTML = '';
                    for (var i = 0; i < route.legs.length; i++) {
                        //var routeSegment = i + 1;
                        //summaryPanel.innerHTML += '<b>Itinéraire ' + routeSegment + '</b><br>';
                        summaryPanel.innerHTML += '<tr><td></td><td>'+route.legs[i].start_address + '</td><td>'+route.legs[i].end_address + '</td><td> ' + route.legs[i].distance.text + '</td><td>' + route.legs[i].duration.text + '</td><td class="actions"><a href=../Add/'+transportBillDetailRideId +'><i class="  fa fa-edit m-r-5"></i></a></td></tr>';
                        var directionsDisplay = new google.maps.DirectionsRenderer({map:map, preserveViewport: true});
                        directionsDisplay.setDirections(response);
                    }
                }
            });
        }



        function getDuration(origin,destination, directionsService,directionsDisplay, sheetRideId, transportBillDetailRideId, car){


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

                    var route = response.routes[0];
                    var summaryPanel = document.getElementById('duration');
                   // summaryPanel.innerHTML = '';
                    for (var i = 0; i < route.legs.length; i++) {
                        //var routeSegment = i + 1;
                        //summaryPanel.innerHTML += '<b>Itinéraire ' + routeSegment + '</b><br>';
                        summaryPanel.innerHTML += '<tr><td>'+car+'</td><td>'+route.legs[i].start_address + '</td><td>'+route.legs[i].end_address + '</td><td> ' + route.legs[i].distance.text + '</td><td>' + route.legs[i].duration.text + '</td><td class="actions"><a href=../Edit/'+sheetRideId +'/'+transportBillDetailRideId +'><i class="  fa fa-edit m-r-5"></i></a></td></tr>';
                        var directionsDisplay = new google.maps.DirectionsRenderer({map:map, preserveViewport: true});
                        directionsDisplay.setDirections(response);
                    }
                }
            });
        }
        var latlongdef = '';
        var ville = '';
        var latlng = '';
        var transportBillDetailRideId = <?php echo "'".$transportBillDetailRideId."'";?>;

        <?php if (!empty($departureDestinationLatlng)) { ?>
        latlongdef = document.getElementById('latlng').value;
        latlongdef = latlongdef.substring(1);
        latlongdef = latlongdef.substring(0, latlongdef.length - 1);
        var latLngBeforeSplitDestination = latlongdef;
        var ville = <?php echo "'".$departureDestinationName."'";?>;
        latlongdef = latlongdef.split(",");
        var latlng = new google.maps.LatLng(latlongdef[0], latlongdef[1]);
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 9,
            center: latlng
        });
        directionsDisplay.setMap(map);
        var marker = new google.maps.Marker({
            map: map,
            // icon: icoParc
            title: ville,
            draggable: true,
            animation: google.maps.Animation.DROP
        });
        //déplacable

        marker.setDraggable(true);
        marker.setPosition(latlng);

        var latlongdef = document.getElementById('latlngCompany').value;

        if(latlongdef != ''){
            latlongdef = latlongdef.substring(1);
            latlongdef = latlongdef.substring(0, latlongdef.length - 1);

            var latLngBeforeSplit = latlongdef;
            latlongdef = latlongdef.split(",");

            var latitude = parseFloat(latlongdef[0]);
            var longitude = parseFloat(latlongdef[1]);

            var ul = {lat: latitude, lng: longitude};
            z = "<?php echo $companyAdress; ?>";

            addMarker(ul, icoParc, z);
            getDurationFromPark(latLngBeforeSplit, latLngBeforeSplitDestination, directionsService, directionsDisplay, transportBillDetailRideId);
        }else {
            var ville = <?php echo "'".$wilayaName ."'";?>;

            geocoder.geocode({'address': ville}, function (results, status) {

                if (status == google.maps.GeocoderStatus.OK) {
                    var latitude = results[0].geometry.location.lat();
                    var longitude = results[0].geometry.location.lng();
                    var latLngBeforeSplit = latitude + ',' + longitude;
                    var ul = {lat: latitude, lng: longitude};

                    z = "<?php echo $companyAdress;?>";

                    addMarker(ul, icoParc, z);
                    getDurationFromPark(latLngBeforeSplit, latLngBeforeSplitDestination, directionsService, directionsDisplay, transportBillDetailRideId);

                }
            });

        }

        var i = 0;
        <?php

       if(!empty($sheetRides)){
        foreach ($sheetRides as $sheetRide){
      if(!empty($sheetRide['LastArrivalDestination']['latlng'])){ ?>
        var latlongdef = document.getElementById('latlng' + '' + i + '').value;
        latlongdef = latlongdef.substring(1);
        latlongdef = latlongdef.substring(0, latlongdef.length - 1);

        var latLngBeforeSplit = latlongdef;
        latlongdef = latlongdef.split(",");

        var latitude = parseFloat(latlongdef[0]);
        var longitude = parseFloat(latlongdef[1]);
        var ul = {lat: latitude, lng: longitude};
        z = "<?php echo $sheetRide['Car']['immatr_def'] .' - '.$sheetRide['Carmodel']['name']; ?>";
        var sheetRideId = "<?php echo $sheetRide['SheetRide']['id']; ?>";
        addMarker(ul, icoTruck, z);
        getDuration(latLngBeforeSplit, latLngBeforeSplitDestination, directionsService, directionsDisplay, sheetRideId, transportBillDetailRideId,z);
        <?php }else {?>

        var ville = <?php echo "'".$sheetRide['LastArrivalDestination']['name'] ."'";?>;

        geocoder.geocode({'address': ville}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
                var latLngBeforeSplit = latitude + ',' + longitude;
                var ul = {lat: latitude, lng: longitude};

                z = "<?php echo $sheetRide['Car']['immatr_def'] .' - '.$sheetRide['Carmodel']['name'];?>";
                var sheetRideId = "<?php echo $sheetRide['SheetRide']['id']; ?>";
                addMarker(ul, icoTruck, z);

                getDuration(latLngBeforeSplit, latLngBeforeSplitDestination, directionsService, directionsDisplay, sheetRideId, transportBillDetailRideId,z);
            }
        });
        <?php } ?>
        i++;
        <?php }
               }
               ?>
        <?php }else { ?>
        var ville = <?php echo "'".$departureDestinationName."'";?>;

        geocoder.geocode({'address': ville}, function (results, status) {


            if (status == google.maps.GeocoderStatus.OK) {


                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
                var latLngBeforeSplitDestination = latitude+','+longitude;
                var ul = {lat: latitude, lng: longitude};
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 9,
                    center:ul
                });
                var marker1 = new google.maps.Marker({
                    map: map,
                    // icon: icoParc,
                     title: ville,
                    draggable: true,
                    animation: google.maps.Animation.DROP
                });
                marker1.setDraggable(true);
                marker1.setPosition(ul);

                var latlongdef = document.getElementById('latlngCompany').value;
                if(latlongdef != '') {

                    latlongdef = latlongdef.substring(1);
                    latlongdef = latlongdef.substring(0, latlongdef.length - 1);

                    var latLngBeforeSplit = latlongdef;
                    latlongdef = latlongdef.split(",");

                    var latitude = parseFloat(latlongdef[0]);
                    var longitude = parseFloat(latlongdef[1]);

                    var uluru = new google.maps.LatLng(latitude, longitude);
                    z = "<?php echo $companyAdress; ?>";
                    var marker = new google.maps.Marker({
                        map: map,
                         icon: icoParc,
                         title: z,
                        draggable: true,
                        animation: google.maps.Animation.DROP
                    });
                    marker.setDraggable(true);
                    marker.setPosition(uluru);
                    getDurationFromPark(latLngBeforeSplit, latLngBeforeSplitDestination, directionsService, directionsDisplay, transportBillDetailRideId);

                }else {

                    var ville = <?php echo "'".$wilayaName ."'";?>;

                    geocoder.geocode({'address': ville}, function (results, status) {

                        if (status == google.maps.GeocoderStatus.OK) {
                            var latitude = results[0].geometry.location.lat();
                            var longitude = results[0].geometry.location.lng();
                            var latLngBeforeSplit = latitude + ',' + longitude;
                            var uluru = {lat: latitude, lng: longitude};

                            z = "<?php echo $companyAdress;?>";
                            var marker = new google.maps.Marker({
                                map: map,
                                icon: icoParc,
                                title: z,
                                draggable: true,
                                animation: google.maps.Animation.DROP
                            });
                            marker.setDraggable(true);
                            marker.setPosition(uluru);
                            getDurationFromPark(latLngBeforeSplit, latLngBeforeSplitDestination, directionsService, directionsDisplay, transportBillDetailRideId);

                        }
                    });

                }


                var i = 0;
                var j = 2;
                <?php

               if(!empty($sheetRides)){
                foreach ($sheetRides as $sheetRide){
              if(!empty($sheetRide['LastArrivalDestination']['latlng'])){ ?>
                var latlongdef = document.getElementById('latlng' + '' + i + '').value;
                latlongdef = latlongdef.substring(1);
                latlongdef = latlongdef.substring(0, latlongdef.length - 1);

                var latLngBeforeSplit = latlongdef;
                latlongdef = latlongdef.split(",");

                var latitude = parseFloat(latlongdef[0]);
                var longitude = parseFloat(latlongdef[1]);
                var ul = {lat: latitude, lng: longitude};
                z = "<?php echo $sheetRide['Car']['immatr_def'] .' - '.$sheetRide['Carmodel']['name']; ?>";
                var sheetRideId = "<?php echo $sheetRide['SheetRide']['id']; ?>";

                var markerMission = 'marker'+i;
                markerMission = new google.maps.Marker({
                    position: ul,
                    title: z,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    map: map,
                    icon: icoTruck
                });
                markerMission.addListener('click', function () {
                    if (markerMission.getAnimation() !== null) {
                        markerMission.setAnimation(null);
                    } else {
                        markerMission.setAnimation(google.maps.Animation.BOUNCE);
                    }
                });

                getDuration(latLngBeforeSplit, latLngBeforeSplitDestination, directionsService, directionsDisplay, sheetRideId, transportBillDetailRideId,z);
                <?php }else {?>

                var ville = <?php echo "'".$sheetRide['LastArrivalDestination']['name'] ."'";?>;

                geocoder.geocode({'address': ville}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        var latitude = results[0].geometry.location.lat();
                        var longitude = results[0].geometry.location.lng();
                        var latLngBeforeSplit = latitude + ',' + longitude;
                        var ul = {lat: latitude, lng: longitude};

                        z = "<?php echo $sheetRide['Car']['immatr_def'] .' - '.$sheetRide['Carmodel']['name'];?>";
                        var sheetRideId = "<?php echo $sheetRide['SheetRide']['id']; ?>";

                        var markerMission = 'marker'+j;
                        markerMission = new google.maps.Marker({
                            position: ul,
                            title: z,
                            draggable: true,
                            animation: google.maps.Animation.DROP,
                            map: map,
                            icon: icoTruck
                        });
                        markerMission.addListener('click', function () {
                            if (markerMission.getAnimation() !== null) {
                                markerMission.setAnimation(null);
                            } else {
                                markerMission.setAnimation(google.maps.Animation.BOUNCE);
                            }
                        });


                        getDuration(latLngBeforeSplit, latLngBeforeSplitDestination, directionsService, directionsDisplay, sheetRideId, transportBillDetailRideId,z);
                    }
                });
                <?php } ?>
                i++;
                <?php }
                       }
                       ?>


            }
        });


       <?php } ?>




    }


</script>

<?php $this->end(); ?>


