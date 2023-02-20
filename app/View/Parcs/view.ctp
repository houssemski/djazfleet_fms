
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?&sensor=false&libraries=places">
</script>

<div class="box-body">
<?php
?><h4 class="page-title"> <?=$parc['Parc']['name']; ?></h4>
	<dl class="card-box">
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($parc['Parc']['code']); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($parc['Parc']['name']); ?>
			&nbsp;
		</dd>
       <?php if (!empty($parc['Parc']['adress'])) { ?>
                        <br/>
                        <dt><?php echo __('Address'); ?></dt>
                        <dd>
                            <?php echo h($parc['Parc']['adress']);
                                  if (!empty($parc['Parc']['latlng'])) { 
                                      $chaine = substr($parc['Parc']['latlng'],1); // pour enlever la ( de la chaine de caract�re.
                                      
                                      $chaine1 =substr($chaine,0,-1); // pour enlever la ) de la chaine de caract�re.
                                      
                                      
                                      $latlng = explode(", ", $chaine1);// pour enlever la , qui separe la lattitude de la langitude 
                                      
                                      
                                      $v1= $latlng[0];
                                      $v2=$latlng[1];   
                                  } ?>
                            &nbsp;
                        
                        </dd>
                         <div id="map" style="float:right;height:500px;width:100%;margin-bottom:10px;"></div>
                        <?php } ?>
                       
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($parc['Parc']['created'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($this->Time->format($parc['Parc']['modified'], '%d-%m-%Y %H:%M')); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<script type="text/javascript">

    $(document).ready(function() {

        google.maps.event.addDomListener(window, 'load', initialize(<?php echo $v1 ?>,<?php echo $v2 ?>, 12, "map"));

    });

    //fonction initialisant la carte    
    function initialize(lat, lng, zoom, carte) {
        geocoder = new google.maps.Geocoder();
        //par d�faut on prend les coordonn�es entr� dans notre champs latlng
       
        var latlng = new google.maps.LatLng(lat, lng)
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