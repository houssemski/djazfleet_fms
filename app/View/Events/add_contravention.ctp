
<?php

?><h4 class="page-title"> <?=__('Add event');?></h4>

<div class="box">
    <div class="edit form card-box p-b-0">

        <?php echo $this->Form->create('Event', array('enctype' => 'multipart/form-data', 'onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body-event">
            <?php
            echo "<div class='form-group'>" . $this->Form->input('code', array(
                    'label' => __('Code'),
                    'placeholder' => __('Enter code'),
                    'class' => 'form-control',
                    'error' => array('attributes' => array('escape' => false),
                        'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                            __("The code must be unique") . '</label></div>', true)
                )) . "</div>";
            echo "<div class='form-group input-button' id='eventtype'>" . $this->Form->input('event_type_id', array(
                    'label' => __('Event type'),
                    'class' => 'form-control select2',
                    'id' => 'type',
                    'empty' => ''
                )) . "</div>"; ?>
            <!-- overlayed element -->
            <div id="dialogModal">
                <!-- the external content is loaded inside this tag -->
                <div id="contentWrap"></div>
            </div>
            <div class="popupactions">

                        <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                            array("controller" => "events", "action" => "addEventType"),
                            array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlay", 'escape' => false, "title" => __("Add Type"))); ?>

            </div>
            <div style="clear:both"></div>
            <?php
            echo "<div class='form-group'>" . $this->Form->input('car_id', array(
                    'label' => __('Car'),
                    'class' => 'form-control select2',
                    'empty' => '',
                    'id' => 'cars',
                )) . "</div>";
            echo "<div class='form-group' id='customers-div'>" . $this->Form->input('customer_id', array(
                    'label' => __("Conductor"),
                    'class' => 'form-control select2',
                    'empty' => '',
                    'id' => 'customers',
                )) . "</div>";

              echo "<div id='assurance-div'></div>";
			  
			  echo "<div class='form-group input-button' id='interfering'>" . $this->Form->input('interfering_id', array(
                    'label' => __('Interfering'),
                    'class' => 'form-control select2',
                    'id' => 'interferings',
                    'empty' => ''
                )) . "</div>"; ?>
            <!-- overlayed element -->
            <div id="dialogModalInterfering">
                <!-- the external content is loaded inside this tag -->
                <div id="contentWrapInterfering"></div>
            </div>
            <div class="popupactions">

                        <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                            array("controller" => "events", "action" => "addInterfering"),
                            array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayInterfering", 'escape' => false, "title" => __("Add Interfering"))); ?>

            </div>
            <div style="clear:both"></div>
			  
			  
			  
           
			
			
            
            <?php
            echo "<div id='interval'></div>"; ?>
		<div id='maps'> 

          <?php      echo "<div class='form-group'>" . $this->Form->input('Event.place', array(
                    'label' => __('Address'),
                    'placeholder' => __('Enter address'),
                    
                    'class' => 'form-control',
                    'id'=>"addresspicker",
                    'empty' => ''
                )) . "</div>";
            echo "<div class='form-group'>".$this->Form->input('Event.latlng', array(
             'type' => 'hidden',
             
             'id'=>"latlng"
             ))."</div>";
           
	?>
    
              
           
<div id="map" style="float:left;height:500px;width:50%;margin-bottom:10px;"></div>

<?php echo "<div class='form-group' >" . $this->Form->input('Event.reason', array(
                    'label' => __('Reason'),
                    'class' => 'form-control',
                    'placeholder' => __('Enter reason'),
                    
                    'id' => 'reason',
                )) . "</div>";
                ?>






        </div>
		
           <?php
		   echo "<div id='interval2'>";
            echo '<div class="lbl1">'.__("Pay by the driver");
            echo "</div>";
            $options=array('1'=>__('Yes'),'0'=>__('No'));
            $attributes=array('legend'=>false);
            echo  $this->Form->radio('pay_customer',$options,$attributes) . "</div>";?>
            
            <div style="clear:both"></div>
            <?php echo "<div id='interval3'>";
             echo '<div class="lbl1">'.__("Refund");
             echo "</div>";
            $options=array('1'=>__('Yes'),'0'=>__('No'));
            $attributes=array('legend'=>false);
            echo  $this->Form->radio('refund',$options,$attributes) . "</div>"; ?>
            
            <div style="clear:both"></div>

    
           

           <?php echo "<div class='form-group'>" . $this->Form->input('cost', array(
                    'label' => __('Global cost'),
                    'placeholder' => __('Enter cost'),
                    'id' =>'cost',
                    'class' => 'form-control',
                )) . "</div>";
                echo "<div id='refund_amount_div'><div class='form-group'>" . $this->Form->input('refund_amount', array(
                    'label' => __('Refund amount'),
                    'placeholder' => __('Enter refund amount'),
                    'class' => 'form-control',
					'id' =>'refund_amount'
                )) . "</div></div>";
            echo "<div class='form-group'>" . $this->Form->input('obs', array(
                    'label' => __('Observation'),
                    'placeholder' => __('Enter observation'),
                    'class' => 'form-control',
                )) . "</div>";
				
				
				echo '<div class="lbl3"><a class="a_color " href="#demo" data-toggle="collapse">'.__("Add attachments").'</a></div>';
				
				?>
         

        <div id="demo" class="collapse">  

        <?php               $Dir_attachment1='events';
            $id_dialog= 'dialogModalAttachment1Dir';
            $id_input= 'attachment1';

                ?>
                    <div id="dialogModalAttachment1Dir">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapAttachment1Dir"></div>
                        </div> 

        <?php 
            
           
              echo "<div class='col-sm-3 yellowcarddiv' id='attachment1'>" . $this->Form->input('attachment1_dir', array(
                        'label' => __('Attachment 1'),
                        'readonly' => true,
                        
                        'class' => 'form-control',
                        
                       
                    )) . '</div>';

                    echo "<div class='col-sm-3 browseyellowcard'>" .$this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                        array("controller" => "events", "action" => "openDir",$Dir_attachment1,$id_dialog,$id_input),
                                        array("class" => "btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5 overlayAttachment1Dir", 'escape' => false, "title" => __(""))). '</div><div style="clear:both;"></div>';

?>





      
               <!-- COMPONENT START -->
    <div class="form-group1">
        <div class="input-group "  id='attachment1-file' >
          
             <?php      echo "<div class='form-groupee'>" . $this->Form->input('attachment1', array(
                                'label' => __('Attachment 1'),
                                'class' => 'form-cont',
                                'type' => 'file',
                                'empty' => ''
                            )) . "</div>";
							$input='attachment1';
									?>
            <span >
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='attachment1-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>
    </div>

          <?php               $Dir_attachment2='events';
            $id_dialog= 'dialogModalAttachment2Dir';
            $id_input= 'attachment2';

                ?>
                    <div id="dialogModalAttachment2Dir">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapAttachment2Dir"></div>
                        </div> 

<?php  
              echo "<div class='col-sm-3 yellowcarddiv' id='attachment2'>" . $this->Form->input('attachment2_dir', array(
                        'label' => __('Attachment 2'),
                        'readonly' => true,
                        'class' => 'form-control',
                    )) . '</div>';

                    echo "<div class='col-sm-3 browseyellowcard'>" .$this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                        array("controller" => "events", "action" => "openDir",$Dir_attachment2,$id_dialog,$id_input),
                                        array("class" => "btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5 overlayAttachment2Dir", 'escape' => false, "title" => __(""))). '</div><div style="clear:both;"></div>';

?>
	  <div class="form-group1">

        <div class="input-group "  id='attachment2-file' >
          
             <?php      echo "<div class='form-groupee'>" . $this->Form->input('attachment2', array(
                                'label' => __('Attachment 2'),
                                'class' => 'form-cont',
                                'type' => 'file',
                                'empty' => ''
                            )) . "</div>";
							$input='attachment2';
									?>
            <span >
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='attachment2-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>
    </div>


          <?php               $Dir_attachment3='events';
            $id_dialog= 'dialogModalAttachment3Dir';
            $id_input= 'attachment3';

                ?>
                    <div id="dialogModalAttachment3Dir">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapAttachment3Dir"></div>
                        </div> 

<?php  
              echo "<div class='col-sm-3 yellowcarddiv' id='attachment3'>" . $this->Form->input('attachment3_dir', array(
                        'label' => __('Attachment 3'),
                        'readonly' => true,
                        'class' => 'form-control',
                    )) . '</div>';

                    echo "<div class='col-sm-3 browseyellowcard'>" .$this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                        array("controller" => "events", "action" => "openDir",$Dir_attachment3,$id_dialog,$id_input),
                                        array("class" => "btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5 overlayAttachment3Dir", 'escape' => false, "title" => __(""))). '</div><div style="clear:both;"></div>';

?>
	  <div class="form-group1">
        <div class="input-group "  id='attachment3-file' >
          
             <?php      echo "<div class='form-groupee'>" . $this->Form->input('attachment3', array(
                                'label' => __('Attachment 3'),
                                'class' => 'form-cont',
                                'type' => 'file',
                                'empty' => ''
                            )) . "</div>";
							$input='attachment3';
									?>
            <span >
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='attachment3-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>
	</div>

      <?php               $Dir_attachment4='events';
            $id_dialog= 'dialogModalAttachment4Dir';
            $id_input= 'attachment4';

                ?>
                    <div id="dialogModalAttachment4Dir">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapAttachment4Dir"></div>
                        </div> 

<?php  
              echo "<div class='col-sm-3 yellowcarddiv' id='attachment4'>" . $this->Form->input('attachment4_dir', array(
                        'label' => __('Attachment 2'),
                        'readonly' => true,
                        'class' => 'form-control',
                    )) . '</div>';

                    echo "<div class='col-sm-3 browseyellowcard'>" .$this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                        array("controller" => "events", "action" => "openDir",$Dir_attachment4,$id_dialog,$id_input),
                                        array("class" => "btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5 overlayAttachment4Dir", 'escape' => false, "title" => __(""))). '</div><div style="clear:both;"></div>';

?>






	  <div class="form-group1">
        <div class="input-group "  id='attachment4-file' >
          
             <?php      echo "<div class='form-groupee'>" . $this->Form->input('attachment4', array(
                                'label' => __('Attachment 4'),
                                'class' => 'form-cont',
                                'type' => 'file',
                                'empty' => ''
                            )) . "</div>";
							$input='attachment4';
									?>
            <span >
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='attachment4-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>
    </div>

          <?php               $Dir_attachment5='events';
            $id_dialog= 'dialogModalAttachment5Dir';
            $id_input= 'attachment5';

                ?>
                    <div id="dialogModalAttachment5Dir">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapAttachment5Dir"></div>
                        </div> 

<?php  
              echo "<div class='col-sm-3 yellowcarddiv' id='attachment5'>" . $this->Form->input('attachment5_dir', array(
                        'label' => __('Attachment 5'),
                        'readonly' => true,
                        'class' => 'form-control',
                    )) . '</div>';

                    echo "<div class='col-sm-3 browseyellowcard'>" .$this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                        array("controller" => "events", "action" => "openDir",$Dir_attachment5,$id_dialog,$id_input),
                                        array("class" => "btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5 overlayAttachment5Dir", 'escape' => false, "title" => __(""))). '</div><div style="clear:both;"></div>';

?>





	  <div class="form-group1">
        <div class="input-group "  id='attachment5-file' >
          
             <?php      echo "<div class='form-groupee'>" . $this->Form->input('attachment5', array(
                                'label' => __('Attachment 5'),
                                'class' => 'form-cont',
                                'type' => 'file',
                                'empty' => ''
                            )) . "</div>";
							$input='attachment5';
									?>
            <span >
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='attachment5-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>
    </div>
	
        <div style='clear:both; padding-top: 10px;'></div>
        </div>
    <!-- COMPONENT END -->
            <div class="row">
            <div id="panel-prod" class="col-md-6">
              
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
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?&sensor=false&libraries=places">
</script>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<script type="text/javascript">

    $(document).ready(function() {
        jQuery("#interval2").css( "display", "none" );
        jQuery("#interval3").css( "display", "none" );
        jQuery("#refund_amount_div").css( "display", "none" );

        google.maps.event.addDomListener(window, 'load', initialize(36.75218210858053, 3.0426488148193584, 10, "map"));


        jQuery('#type').change(function () {

            jQuery('#interval').load('<?php echo $this->Html->url('/events/getIntervals/')?>' + jQuery(this).val());
            jQuery('#interfering').load('<?php echo $this->Html->url('/events/getInterferingsByType/')?>' + jQuery(this).val()+'/'+0);
            jQuery('#panel-prod').load('<?php echo $this->Html->url('/events/getCategoryEvent/')?>' + jQuery(this).val());

            // jQuery('#interval2').load('<?php echo $this->Html->url('/events/getIntervals/')?>' + jQuery(this).val());
            var typeArr= [1,6,7,8,15,19];
//use of inArray
            if(typeArr.inArray(jQuery('#type').val()))
                jQuery("#interval2").css( "display", "block" );

            else
                jQuery("#interval2").css( "display", "none" );
            if (jQuery('#type').val()==11) {

                jQuery('#assurance-div').load('<?php echo $this->Html->url('/events/getNumAssurance/')?>' + jQuery('#cars').val());
                jQuery("#refund_amount_div").css( "display", "block" );
            }




            jQuery('#num_assurance').val('');
            jQuery('#refund_amount').val('');
            jQuery('#assurance-div').css( "display", "none" );
            jQuery("#refund_amount_div").css( "display", "none" );

        }

    })
    if (jQuery('#type-category').val()!=8) jQuery("#panel-prod").css( "display", "block" );
    else jQuery("#panel-prod").css( "display", "none" );

    Array.prototype.inArray = function (value)
    {
        // Returns true if the passed value is found in the
        // array. Returns false if it is not.
        var i;
        for (i=0; i < this.length; i++)
        {
            if (this[i] == value)
            {
                return true;
            }
        }
        return false;
    };




    jQuery('input#EventPayCustomer1').on('ifChecked', function (event) {

        jQuery("#interval3").css( "display", "block" );
    });

    jQuery('input#EventPayCustomer0').on('ifChecked', function (event) {



        jQuery("#interval3").css( "display", "none" );




        /* FONCTIONS KAHINA
         $('#EventRefund1').removeAttr('checked');
         $('#EventRefund0').removeAttr('checked');
         jQuery("#EventRefund1").prop("checked",'false');
         jQuery("#EventRefund0").prop("checked",'false');
         var  cases = jQuery("#EventRefund1");
         if (jQuery('#EventPayCustomer0').prop('checked')) {
         alert('ddddddddddd');
         if (jQuery('#EventRefund1').prop('checked')) {
         $('#EventRefund1').attr("checked" , false );
         }
         //cases.iCheck('uncheck');
         } else
         {
         alert('aaaaaaaa');
         //cases.iCheck('check');
         }
         //jQuery("#interval3").css( "display", "none" );

         */
    });


    if(jQuery('#cars').val() > 0){
        jQuery('#customers-div').load('<?php echo $this->Html->url('/events/getCustomersByCar/')?>' + jQuery('#cars').val());

    }
    jQuery('#cars').change(function () {
        jQuery('#customers-div').load('<?php echo $this->Html->url('/events/getCustomersByCar/')?>' + jQuery(this).val());
        if (jQuery('#type').val()==11) {
            jQuery('#assurance-div').css( "display", "block" );
            jQuery('#assurance-div').load('<?php echo $this->Html->url('/events/getNumAssurance/')?>' + jQuery('#cars').val());

        } else {

            jQuery('#num_assurance').val('');

            jQuery('#assurance-div').css( "display", "none" );


        }

    });
    jQuery("#dialogModal").dialog({
        autoOpen: false,
        height: 470,
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
    jQuery(".overlay").click(function (event) {
        event.preventDefault();
        jQuery('#contentWrap').load(jQuery(this).attr("href"));  //load content from href of link
        jQuery('#dialogModal').dialog('option', 'title', jQuery(this).attr("title"));  //make dialog title that of link
        jQuery('#dialogModal').dialog('open');  //open the dialog
    });

    jQuery("#dialogModalInterfering").dialog({
        autoOpen: false,
        height: 590,
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
    jQuery(".overlayInterfering").click(function (event) {
        event.preventDefault();
        jQuery('#contentWrapInterfering').load(jQuery(this).attr("href"));  //load content from href of link
        jQuery('#dialogModalInterfering').dialog('option', 'title', jQuery(this).attr("title"));  //make dialog title that of link
        jQuery('#dialogModalInterfering').dialog('open');  //open the dialog
    });

    var products_id = new Array();
    jQuery("#delete_product0").css( "display", "none" );


    jQuery("#dialogModalAttachment1Dir").dialog({
        autoOpen: false,
        height: 500,
        width: 700,
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
    jQuery(".overlayAttachment1Dir").click(function (event) {
        event.preventDefault();
        jQuery('#contentWrapAttachment1Dir').load(jQuery(this).attr("href"));
        //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
        jQuery('#dialogModalAttachment1Dir').dialog('open');
    });


    jQuery("#dialogModalAttachment2Dir").dialog({
        autoOpen: false,
        height: 500,
        width: 700,
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
    jQuery(".overlayAttachment2Dir").click(function (event) {
        event.preventDefault();
        jQuery('#contentWrapAttachment2Dir').load(jQuery(this).attr("href"));
        //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
        jQuery('#dialogModalAttachment2Dir').dialog('open');
    });

    jQuery("#dialogModalAttachment3Dir").dialog({
        autoOpen: false,
        height: 500,
        width: 700,
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
    jQuery(".overlayAttachment3Dir").click(function (event) {
        event.preventDefault();
        jQuery('#contentWrapAttachment3Dir').load(jQuery(this).attr("href"));
        //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
        jQuery('#dialogModalAttachment3Dir').dialog('open');
    });

    jQuery("#dialogModalAttachment4Dir").dialog({
        autoOpen: false,
        height: 500,
        width: 700,
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
    jQuery(".overlayAttachment4Dir").click(function (event) {
        event.preventDefault();
        jQuery('#contentWrapAttachment4Dir').load(jQuery(this).attr("href"));
        //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
        jQuery('#dialogModalAttachment4Dir').dialog('open');
    });


    jQuery("#dialogModalAttachment5Dir").dialog({
        autoOpen: false,
        height: 500,
        width: 700,
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
    jQuery(".overlayAttachment5Dir").click(function (event) {
        event.preventDefault();
        jQuery('#contentWrapAttachment5Dir').load(jQuery(this).attr("href"));
        //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
        jQuery('#dialogModalAttachment5Dir').dialog('open');
    });

    });

    function traiteAdresse(marker, latLng, infowindow, map) {
        //recadre et zomme sur les coordonn�es latLng
		
        map.setCenter(latLng);
        map.setZoom(14);
        //on stocke nos nouvelles coordon�e dans le champs correspondant
        document.getElementById('latlng').value = latLng;
        //on va rechercher les information sur l'adresse correspondant � ces coordonn�es
        geocoder.geocode({
            'latLng': latLng
        }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    infowindow.setContent(results[0].formatted_address);
                    //on stocke l'adresse compl�te
					
                    document.getElementById("addresspicker").value = results[0].formatted_address;

                    var nb_el = results[0].address_components.length;
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
		 
		 
		  document.getElementById('latlng').value = latlng;
		 geocoder.geocode({
            'latLng': latlng
        }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    infowindow.setContent(results[0].formatted_address);
                    //on stocke l'adresse compl�te
					
                    document.getElementById("addresspicker").value = results[0].formatted_address;

                    var nb_el = results[0].address_components.length;
                    //et ses diff�rentes composantes s�par�ment

                    infowindow.open(map, marker);
                } else {
                    alert("No results found");

                }
            } else {
                alert("Geocoder failed due to: " + status);
            }
        });
		 
        //quand on relache notre marqueur on r�initialise la carte avec les nouvelle coordonn�es
        google.maps.event.addListener(marker, 'dragend', function (event) {
			
            traiteAdresse(marker, event.latLng, infowindow, map);
        });

        //quand on choisie une adresse propos�e on r�initialise la carte avec les nouvelles coordonn�es
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
			
            infowindow.close();
            var place = autocomplete.getPlace();
            marker.setPosition(place.geometry.location);
            traiteAdresse(marker, place.geometry.location, infowindow, map);
        });
    }


   
  function addProductBill () {
  var nb_product=parseFloat(jQuery('#nb_product').val())+1;
     jQuery('#nb_product').val(nb_product) ;
     jQuery("#table_products").append("<tr id=product"+nb_product+"></tr>");
	  jQuery("#total0").append("<div ></div>");
	 var product=nb_product-1;
	//products_id=jQuery("#Bill"+''+product+''+"Product").val();
	products_id.push(jQuery("#product_name"+''+product+''+"").val());
    jQuery("#product"+''+nb_product+'').load("<?php echo $this->Html->url('/events/addProductBill/')?>"+ nb_product+'|'+products_id);
    jQuery("#delete_product0").css( "display", "block" ); 
  }
  
  
    function calculPrice (id){
	  var num = id.substring(id.length-1,id.length) ;
	  
	  
		  
         var quantity=jQuery("#quantity"+''+num+'').val();
		 var max= jQuery("#max"+''+num+'').val();
		 
		 if (quantity>max) {
			jQuery("#quantity"+''+num+'').val(max);
			msg = '<?php echo __('Not enough stock, maximum value is')?>';
                
			jQuery("#msg"+''+num+'').html("<p style='color: #a94442;'>"+msg+' '+max+"</p>"); 
		 }  
	  
	  
	  if (jQuery("#price"+''+num+''+"").val()>0) {
		  
		  if (jQuery("#ristourne_val"+''+num+''+"").val()>0) {
		 var ristourne = ( jQuery("#ristourne_val"+''+num+''+"").val() / jQuery("#price"+''+num+''+"").val())*100;
         ristourne=ristourne.toFixed(2); 
		 jQuery("#ristourne"+''+num+''+"").val(ristourne);
		  }
		  if (jQuery("#ristourne"+''+num+''+"").val()>0) {
		 var ristourne_val = ( jQuery("#ristourne"+''+num+''+"").val() * jQuery("#price"+''+num+''+"").val())/100;
		 
		 jQuery("#ristourne_val"+''+num+''+"").val(ristourne_val);
		 
		  }
		 if (jQuery("#quantity"+''+num+''+"").val()>0){

		 if (jQuery("#ristourne_val"+''+num+''+"").val()>0) {
			   total_ht =  jQuery("#quantity"+''+num+''+"").val() * (parseFloat(jQuery("#price"+''+num+''+"").val())-parseFloat(jQuery("#ristourne_val"+''+num+''+"").val()));
			  var total_ttc =  jQuery("#quantity"+''+num+''+"").val() * (parseFloat(jQuery("#price"+''+num+''+"").val())-parseFloat(jQuery("#ristourne_val"+''+num+''+"").val()))*(parseFloat(jQuery("#tva_prod"+''+num+''+"").val())+1);
  
		  }
		  else {
			var total_ht =  jQuery("#quantity"+''+num+''+"").val() * jQuery("#price"+''+num+''+"").val();
		  var total_ttc =  jQuery("#quantity"+''+num+''+"").val() * jQuery("#price"+''+num+''+"").val()*(parseFloat(jQuery("#tva_prod"+''+num+''+"").val())+1);  
			  
		  }
		  var total_tva=total_ttc-total_ht;
		  total_ht=total_ht.toFixed(2); 
		  total_ttc=total_ttc.toFixed(2); 
		  total_tva=total_tva.toFixed(2); 
		  
		 jQuery("#ht"+''+num+''+"").val(total_ht);
		 jQuery("#ttc"+''+num+''+"").val(total_ttc);
		 jQuery("#tva"+''+num+''+"").val(total_tva);
		 jQuery("#total"+''+num+''+"").html("<span style='float: right;'>"+total_ttc+"</span>");
		 }
		 var total_price_ht=0.00;
		var total_price_ttc=0.00;
		var total_price_tva=0.00;
		 var nb=jQuery("#nb_product").val();
		
		 if (nb==0) { total_price_ht=jQuery("#ht0").val();
				      total_price_ttc=jQuery("#ttc0").val();
					  total_price_tva=jQuery("#tva0").val();
					}
		 else {
			 
		 for (var i=0; i<=nb; i++) {
			
			   total_price_ht= total_price_ht+parseFloat(jQuery("#ht"+''+i+''+"").val());
			   total_price_ttc= total_price_ttc+parseFloat(jQuery("#ttc"+''+i+''+"").val());
			   total_price_tva= total_price_tva+parseFloat(jQuery("#tva"+''+i+''+"").val());
			  
		 }
		 total_price_ht=total_price_ht.toFixed(2);
		 total_price_ttc=total_price_ttc.toFixed(2);
		 total_price_tva=total_price_tva.toFixed(2);
		 }

		 jQuery("#price_ht").val(total_price_ht);
		 jQuery("#price_ttc").val(total_price_ttc);
		 jQuery("#price_tva").val(total_price_tva);
		 jQuery("#total_ht").html("<span style='float: right;'>"+total_price_ht+"</span>");
		 jQuery("#total_ttc").html("<span style='float: right;'>"+total_price_ttc+"</span>");
		 jQuery("#total_tva").html("<span style='float: right;'>"+total_price_tva+"</span>");
		  
	  }
	 
  }
  
  
   function quantityMax (id) {
   
	 var num = id.substring(id.length-1,id.length) ; 
     var product_id = jQuery("#product_name"+''+num+''+"").val();	
   
     jQuery("#quantity_max"+''+num+'').load("<?php echo $this->Html->url('/events/quantityProduct/')?>"+ num+'|'+product_id);
	// jQuery("#quantity"+''+num+'').val('');  
    // jQuery("#price"+''+num+'').val(''); 
    // jQuery("#ristoune"+''+num+'').val('');  
    // jQuery("#ristoune_val"+''+num+'').val(''); 
    // jQuery("#quantity"+''+num+'').val('');    
	 jQuery("#total"+''+num+'').html("<span style='float: right;'>0.00</span>");
   }
   
   function DeleteProduct (id){
		
	  var num = id.substring(id.length-1,id.length) ;
	  
	 jQuery("#product"+''+num+''+"").css( "display", "none" );
	 
	  jQuery("#quantity"+''+num+''+"").val(0);
	  jQuery("#price"+''+num+''+"").val(0);
	  
	  	 jQuery("#ht"+''+num+''+"").val(0);
		 jQuery("#ttc"+''+num+''+"").val(0);
		 jQuery("#tva"+''+num+''+"").val(0);
		// jQuery("#total"+''+num+''+"").html("<span style='float: right;'>"0.00"</span>");
	  
	   	 var total_price_ht=0.00;
		var total_price_ttc=0.00;
		var total_price_tva=0.00;
		 var nb=jQuery("#nb_product").val();
		 if (nb==0) { total_price_ht=jQuery("#ht0").val();
				      total_price_ttc=jQuery("#ttc0").val();
					  total_price_tva=jQuery("#tva0").val();
					}
		 else {
			 
		 for (var i=0; i<=nb; i++) {
			
			   total_price_ht= total_price_ht+parseFloat(jQuery("#ht"+''+i+''+"").val());
			   total_price_ttc= total_price_ttc+parseFloat(jQuery("#ttc"+''+i+''+"").val());
			   total_price_tva= total_price_tva+parseFloat(jQuery("#tva"+''+i+''+"").val()); 
		 }
		 total_price_ht=total_price_ht.toFixed(2);
		 total_price_ttc=total_price_ttc.toFixed(2);
		 total_price_tva=total_price_tva.toFixed(2);
		 }
		 jQuery("#price_ht").val(total_price_ht);
		 jQuery("#price_ttc").val(total_price_ttc);
		 jQuery("#price_tva").val(total_price_tva);
		 jQuery("#total_ht").html("<span style='float: right;'>"+total_price_ht+"</span>");
		 jQuery("#total_ttc").html("<span style='float: right;'>"+total_price_ttc+"</span>");
		 jQuery("#total_tva").html("<span style='float: right;'>"+total_price_tva+"</span>");
	  
	}
   
   
   
   	function delete_file(id) {
		
		
    $("#"+''+id+''+"-file").before(
        function() {
            if ( ! $(this).prev().hasClass('input-ghost') ) {
                var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                element.attr("name",$(this).attr("name"));
                element.change(function(){
                    element.next(element).find('input').val((element.val()).split('\\').pop());
                });
                
                $(this).find("#"+''+id+''+"-btn").click(function(){
                    element.val(null);
                    $(this).parents("#"+''+id+''+"-file").find('input').val('');
                });
                $(this).find('input').css("cursor","pointer");
                $(this).find('input').mousedown(function() {
                    $(this).parents("#"+''+id+''+"-file").prev().click();
                    return false;
                });
                return element;
            }
        }
    );
}   
   
   function calculate_cost() {
	   
	   var global_cost=0;
	    var tabVals=new Array();
		$('.cost_interfering').each(function(){
		tabVals.push($(this).val());
		
		
		});
		for(var i= 0; i < tabVals.length; i++)
		{
			
			global_cost=parseFloat(global_cost)+parseFloat(tabVals[i]);
			
		}

	   jQuery("#cost").val(global_cost);
	   
   }
   
   
   function OpenDir(id) {

  
       
           

        
        jQuery('#dialogModalOpenDir').dialog('open');
        jQuery('#dialogModalOpenDir').load('<?php echo $this->Html->url('/cars/openDir/')?>'+id);

       

    }
   


   
  
 
	
	
	
	
    
	

  
  
  
  
	
	
	
	
</script>
<?php $this->end(); ?>
