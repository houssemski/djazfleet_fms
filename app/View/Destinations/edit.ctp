<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB33Wa5iG-fztbIhYh60y9YGaZoKuCOPho&libraries=places">
</script>

<?php

?><h4 class="page-title"> <?=__('Edit city');?></h4>
<?php
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end();
?>
<div class="box">
    <div class="edit form card-box p-b-0">
<?php echo $this->Form->create('Destination', array('onsubmit'=> 'javascript:disable();')); ?>
	<div class="box-body">
            <?php

            if(Configure::read("transport_personnel") == '1'){
                $name =    __('breakpoint');
            } else {
                $name =   __('city');
            }
		echo $this->Form->input('id');
                echo "<div class='form-group'>".$this->Form->input('code', array(
                    'label' => __('Code').' '.$name,
                     'placeholder'=>__('Enter code'),
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                                     'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>'. 
                                                     __("The code must be unique") . '</label></div>', true)
                    ))."</div>";
                echo "<div class='form-group'>".$this->Form->input('name', array(
                    'label' => __('Name').' '.$name,
                    'placeholder'=>__('Enter name'),
                    'class' => 'form-control',
                    'id'=>"addresspicker"
                    ))."</div>";
            echo "<div class='form-group'>" . $this->Form->input('latlng', array(
                    'type' => 'hidden',
                    'id'=>"latlng"
                )) . "</div>";
            echo "<div class='form-group input-button' id='wilayas'>".$this->Form->input('wilaya_id', array(
                    'label' => __('Name').' '.__('Wilaya'),
                    'empty'=>__('Select wilaya'),
                    'class' => 'form-control select2',
                    'onchange' => 'javascript:getDairasByWilaya();',
                    'id'=>'wilaya'
                ))."</div>"; ?>

        <!-- overlayed element -->
        <div id="dialogModalWilaya">
            <!-- the external content is loaded inside this tag -->
            <div id="contentWrapWilaya"></div>
        </div>
        <div class="popupactions">

            <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                array("controller" => "destinations", "action" => "addWilaya"),
                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayWilaya",'escape' => false, "title" => __("Add wilaya"))); ?>
        </div>
        <div style="clear:both"></div>
        <?php  echo "<div class='form-group input-button' id='daira-div'>".$this->Form->input('daira_id', array(
                'label' => __('Name').' '.__('Daira'),
                'empty'=>__('Select daira'),
                'class' => 'form-control select2',
            ))."</div>";
        ?>
        <!-- overlayed element -->
        <div id="dialogModalDaira">
            <!-- the external content is loaded inside this tag -->
            <div id="contentWrapDaira"></div>
        </div>
        <div id="popupactionsDaira">

            <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                array("controller" => "destinations", "action" => "addDaira"),
                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayDaira",'escape' => false, "title" => __("Add daira"))); ?>

        </div>
        <div style="clear:both"></div>
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
<?= $this->Html->script('maskedinput'); ?>
<script type="text/javascript">

    $(document).ready(function() {
        google.maps.event.addDomListener(window, 'load', initialize( 14,"map"));

        jQuery("#dialogModalWilaya").dialog({
            autoOpen: false,
            height: 320,
            width: 400,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlayWilaya").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapWilaya').load(jQuery(this).attr("href"));
            jQuery('#dialogModalWilaya').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalWilaya').dialog('open');
        });

        jQuery("#dialogModalDaira").dialog({
            autoOpen: false,
            height: 320,
            width: 400,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });
        jQuery(".overlayDaira").click(function (event) {
            if (jQuery('#wilaya').val() > 0) {
                event.preventDefault();
                jQuery('#contentWrapDaira').load(jQuery(this).attr("href"));
                jQuery('#dialogModalDaira').dialog('option', 'title', jQuery(this).attr("title"));
                jQuery('#dialogModalDaira').dialog('open');

            } else {
                msg = '<?php echo __('Select wilaya')?>';
                alert(msg);
                event.preventDefault();
            }
        });

        jQuery('#wilaya').change(function () {
            if (jQuery(this).val() > 0) {
                jQuery('.overlayDaira').attr("href", "<?php echo $this->Html->url('/destinations/addDaira/')?>" + jQuery('#wilaya').val());
                jQuery('#popupactionsDaira').css("display", "block");
            }
            else {
                jQuery('.overlayDaira').attr("href", "<?php echo $this->Html->url('/destinations/addDaira/')?>");
                jQuery('#popupactionsDaira').css("display", "none");
            }
            jQuery('#daira-div').load('<?php echo $this->Html->url('/destinations/getDairas/')?>' + jQuery('#wilaya').val(), function(){
                jQuery('.select2').select2();
            });
        });


        if (jQuery('#wilaya').val() > 0) {

           /* jQuery('#daira-div').load('<?php echo $this->Html->url('/destinations/getDairas/')?>' + jQuery('#wilaya').val(), function(){
                jQuery('.select2').select2();
            });
            jQuery('.overlayDaira').attr("href", "<?php echo $this->Html->url('/destinations/addDaira/')?>" + jQuery('#wilaya').val());
            jQuery('#popupactionsDaira').css("display", "block");
            jQuery('.select2').select2();*/

        }
        else {
            jQuery('.overlayDaira').attr("href", "<?php echo $this->Html->url('/destinations/addDaira/')?>");
            jQuery('#popupactionsDaira').css("display", "none");
        }





    });
    function getDairasByWilaya(){
        var wilayaId = jQuery('#wilaya').val();

        jQuery('#daira-div').load('<?php echo $this->Html->url('/destinations/getDairasByWilaya/')?>' + wilayaId, function(){
            jQuery('.select2').select2();
            jQuery('.select').addClass('required');

        });

    }

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


        var marker = new google.maps.Marker({
            map: map

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
