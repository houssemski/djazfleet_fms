<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB33Wa5iG-fztbIhYh60y9YGaZoKuCOPho&libraries=places">
</script>

<?php

    ?><h4 class="page-title"> <?=__('Edit Supplier');?></h4>


<div class="box">
    <div class="edit form card-box p-b-0">
        <?php echo $this->Form->create('Supplier', array('onsubmit'=> 'javascript:disable();')); ?>

        <div class="box-body">

            <div class="nav-tabs-custom pdg_btm">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                    <li ><a href="#tab_2" data-toggle="tab"><?= __('Information fiscale') ?></a></li>


                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <?php
                        echo $this->Form->input('id');
                      if ($code != '0') {
                            echo "<div class='form-group'>" . $this->Form->input('code', array(
                                    'label' => __('Code'),
                                    'class' => 'form-control',
                                    'readonly' => true,
                                    'placeholder' => __('Enter code'),
                                )) . "</div>";
                        } else {
                            echo "<div class='form-group'>" . $this->Form->input('code', array(
                                    'label' => __('Code'),
                                    'placeholder' => __('Enter code'),
                                    'class' => 'form-control',
                                    'id' => 'ref',
                                    'error' => array('attributes' => array('escape' => false),
                                        'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                                            __("The code must be unique") . '</label></div>', true)
                                )) . "</div>";
                        }

                        echo "<div class='form-group'>".$this->Form->input('type', array(
                                'label' => __('type'),
                                'type'=>'hidden',
                                'class' => 'form-control',
                            ))."</div>";
                        echo "<div class='form-group'>" . $this->Form->input('name', array(
                                'label' => __('Name'),
                                'class' => 'form-control',
                            )) . "</div>";

                        echo "<div class='form-group'>".$this->Form->input('social_reason', array(
                                'label' => __('Social reason'),
                                'class' => 'form-control',
                            ))."</div>";
                        echo "<div class='form-group'>".$this->Form->input('supplier_category_id', array(
                                'label' => __('Category'),
                                'value'=>1,
                                'type'=>'hidden',
                                'class' => 'form-control',
                            ))."</div>";


                        echo "<div class='form-group'>" . $this->Form->input('adress', array(
                                'label' => __('Address'),
                                'class' => 'form-control',
                                'id'=>"addresspicker"
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('latlng', array(
                                'type' => 'hidden',
                                'id'=>"latlng"
                            )) . "</div>";

                        echo "<div class='form-group'>" . $this->Form->input('latitude', array(
                                'label' => __(''),
                                'placeholder' => __(''),
                                'class' => 'form-control',
                                'id'=>'latitude',
                                'type' =>'hidden',
                                'empty' => ''
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('longitude', array(
                                'label' => __(''),
                                'placeholder' => __(''),
                                'class' => 'form-control',
                                'id'=>'longitude',
                                'type' =>'hidden',
                                'empty' => ''
                            )) . "</div>";
                        ?>
                        <div id="map" style="float:right;height:500px;width:100%;margin-bottom:10px;"></div>
                        <?php

                        echo "<div class='form-group'>".$this->Form->input('town', array(
                                'label' => __('Town'),
                                'class' => 'form-control',
                            ))."</div>";
                        echo "<div class='form-group'>".$this->Form->input('state', array(
                                'label' => __('Wilaya'),
                                'class' => 'form-control',
                            ))."</div>";
                        echo "<div class='form-group'>".$this->Form->input('contact', array(
                                'label' => __('Contact person'),
                                'class' => 'form-control',
                            ))."</div>";
                        echo "<div class='form-group'>".$this->Form->input('email', array(
                                'label' => __('Email'),
                                'class' => 'form-control',
                            ))."</div>";


                        echo "<div class='form-group'>" . $this->Form->input('tel', array(
                                'label' => __('Phone'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>".$this->Form->input('nb_cars', array(
                                'label' => __('Cars number'),
                                'class' => 'form-control',
                                'id'=>'nb_cars',
                            ))."</div>";
                        echo "<div class='form-group'>" . $this->Form->input('note', array(
                                'label' => __('Note'),
                                'class' => 'form-control',
                            )) . "</div>";
                        ?>
                    </div>
                    <div class="tab-pane " id="tab_2">
                        <?php echo "<div class='form-group'>".$this->Form->input('rc', array(
                                'label' => __('RC'),
                                'class' => 'form-control',
                            ))."</div>";
                        echo "<div class='form-group'>".$this->Form->input('if', array(
                                'label' => __('IF'),
                                'class' => 'form-control',
                            ))."</div>";
                        echo "<div class='form-group'>".$this->Form->input('ai', array(
                                'label' => __('AI'),
                                'class' => 'form-control',
                            ))."</div>";
                        echo "<div class='form-group'>".$this->Form->input('nis', array(
                                'label' => __('NIS'),
                                'class' => 'form-control',
                            ))."</div>";
                        echo "<div class='form-group'>".$this->Form->input('cb', array(
                                'label' => __('CB'),
                                'class' => 'form-control',
                            ))."</div>";

                        ?>
                    </div>

                </div>

            </div>

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

        google.maps.event.addDomListener(window, 'load', initialize( 14,"map"));
    });


    //fonction appel� plus bas, ouvre un marqueur et recadre la carte aux coordonn�es indiqu�es pour la cartes donn�e
    function traiteAdresse(marker, latLng, infowindow, map){
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
    }
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
            map: map,
            icon: icoParc
        });
        //d�placable
        marker.setDraggable(true);
        marker.setPosition(latlng);
        //quand on relache notre marqueur on r�initialise la carte avec les nouvelle coordonn�es
        google.maps.event.addListener(marker, 'dragend', function(event) {
            traiteAdresse(marker, event.latLng, infowindow, map);
        });

        //quand on choisie une adresse propos�e on r�initialise la carte avec les nouvelles coordonn�es
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            infowindow.close();
            var place = autocomplete.getPlace();
            marker.setPosition(place.geometry.location);
            traiteAdresse(marker, place.geometry.location, infowindow, map);
        });
    }

</script>
<?php $this->end(); ?>


