<?php
/**
 * @var array $interventionsTypes
 */
include("ctp/script.ctp");
?><h4 class="page-title"> <?=__('Add intervention request');?></h4>

<div class="box">
    <div class="edit form card-box p-b-0">
        <?php echo $this->Form->create('Event', array('enctype' => 'multipart/form-data', 'onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
            <?php
            if ($reference != null) {
                echo "<div class='form-group'>" . $this->Form->input('code', array(
                        'label' => __('Reference'),
                        'class' => 'form-control',
                        'value' => $reference,
                        'readonly' => true,
                        'placeholder' => __('Enter reference'),
                    )) . "</div>";
            } else {
                echo "<div class='form-group'>" . $this->Form->input('code', array(
                        'label' => __('Reference'),
                        'placeholder' => __('Enter reference'),
                        'class' => 'form-control',
                        'id' => 'ref',
                        'error' => array('attributes' => array('escape' => false),
                            'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                                __("The reference must be unique") . '</label></div>', true)
                    )) . "</div>";

            }
	    if (Configure::read('logistia') == '1'){
	    echo "<div class='form-group input-button' >" . $this->Form->input('event_type_id', array(
                    'label' => __('Intervention type'),
                    'class' => 'form-control select2',
                    'multiple'=>true,
                    'empty' => __('Select type')
                )) . "</div>";
	    }else {
	    echo "<div class='form-group input-button' id='eventtype'>" . $this->Form->input('event_type_id', array(
                    'label' => __('Event type'),
                    'class' => 'form-control select2',
                    'multiple'=>true,
                    'id' => 'type',
                    'empty' => __('Select type')
                )) . "</div>";
	    }
	    
             ?>
            <!-- overlayed element -->
            <div id="dialogModal">
                <!-- the external content is loaded inside this tag -->
                <div id="contentWrap"></div>
            </div>
            <div class="popupactions">

                <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                    array("controller" => "events", "action" => "addEventType",'addRequest'),
                    array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlay", 'escape' => false, "title" => __("Add Type"))); ?>

            </div>
            <div style="clear:both"></div>
          

            <div style="clear:both"></div>
            <?php
 if (Configure::read('logistia') == '1'){
  $interventionOptions = array( 1 => 'Vehicule', 2 => 'Autre');
            echo "<div class='form-group' >" . $this->Form->input('intervention_for', array(
                    'label' => __("Intervention pour"),
                    'class' => 'form-control',
                    'options' => $interventionOptions,
                    'id' => 'intervention-type',
                )) . "</div>";

            ?>
            <?php
            echo "<div class='form-group' id='cars-select'>" . $this->Form->input('car_id', array(
                    'label' => __('Car'),
                    'class' => 'form-control select2',
                    'empty' => '',
                    'id' => 'cars',
                )) . "</div>";
            echo "<div class='form-group' id='pieces' style='display: none'>" . $this->Form->input('other', array(
                    'label' => __("Nom de l' intervention"),
                    'class' => 'form-control',
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('customer_id', array(
                    'label' => __("Applicant"),
                    'class' => 'form-control select2',
                    'empty' => '',
                    'id' => 'customers',
                )) . "</div>";
            echo "<div class='form-group' >" . $this->Form->input('structure_id', array(
                    'label' => __("Structure"),
                    'class' => 'form-control select2',
                    'empty' => '',
                    'id' => 'structure',
                )) . "</div>";
            echo "</div>";
            echo "<div class='form-group'>" . $this->Form->input('boss_id', array(
                    'label' => __("Service"),
                    'class' => 'form-control select2',
                    'options' => $customers,
                    'empty' => '',
                    'id' => 'customers',
                )) . "</div>";

                echo "</div>";

            echo "<div class='form-group'>" . $this->Form->input('intervention_request_date', array(
                    'label' => '',
                    'placeholder' => 'dd/mm/yyyy',
                    'type' => 'text',
                    'class' => 'form-control datemask',
                    'before' => '<label>' . __('Intervention date') . '</label><div class="input-group date"><label for="birthday"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'birthday',
                )) . "</div>";

            echo "<div class='form-group'>" . $this->Form->input('wished_intervention_date', array(
                    'label' => '',
                    'placeholder' => 'dd/mm/yyyy',
                    'type' => 'text',
                    'class' => 'form-control datemask',
                    'before' => '<label>' . __('Wished intervention date') . '</label><div class="input-group date"><label for="birthday"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'birthday',
                )) . "</div>";
 }else {
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
               
           echo "<div id='interfering'> ";
			  echo "<div class='form-group' >" . $this->Form->input('interfering_id', array(
                    'label' => __('Interfering'),
                    'class' => 'form-control select2',
                    'id' => 'interferings',
                    'empty' => ''
                )) . "</div>"; 

                echo "</div>"; ?>

                   <!-- overlayed element -->
            <div style="clear:both"></div>

            <?php
            echo "<div id='interval'></div>";


		echo "<div class='form-group'>" . $this->Form->input('cost', array(
                    'label' => __('Global cost'),
                    'placeholder' => __('Enter cost'),
					'id'=>'cost',
                    'class' => 'form-control',
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('obs', array(
                    'label' => __('Observation'),
                    'placeholder' => __('Enter observation'),
                    'class' => 'form-control',
                )) . "</div>"; ?>


                  <div class="form-group1">
        <div class="input-group "  id='attachment-file' >
          
             <?php      echo "<div class='form-groupee'>" . $this->Form->input('attachment1', array(
                                'label' => __('Attachment'),
                                'class' => 'form-cont',
                                'type' => 'file',
                                'empty' => ''
                            )) . "</div>";
							$input='attachment';
									?>
            <span >
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id='attachment-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button>
            </span>
        </div>
    </div>
<?php
 }     
            ?>



          
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
        var now = new Date();

        jQuery('#type').change(function () {

            var carId = jQuery('#cars').val() ;
            jQuery('#interval').load('<?php echo $this->Html->url('/events/getIntervalsRequest/')?>' + carId, function (){
                jQuery(".date").datetimepicker({
                    format:'DD/MM/YYYY',
                    icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    }
                });
                $('.date').click(function(){
                    var popup =$(this).offset();
                    var popupTop = popup.left;
                    $('.bootstrap-datetimepicker-widget').css({
                        'left' : popupTop+10
                    });
                });
            });

            /* jQuery('#interfering').load(' echo $this->Html->url('/events/getInterferingsByType/')?>' + jQuery(this).val()+'/'+1, function() {

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

             });*/
        });
        if(jQuery('#cars').val() > 0){
            jQuery('#customers-div').load('<?php echo $this->Html->url('/events/getCustomersByCar/')?>' + jQuery('#cars').val());
        }
        jQuery('#cars').change(function () {
            jQuery('#customers-div').load('<?php echo $this->Html->url('/events/getCustomersByCar/')?>' + jQuery(this).val());

            var link= '<?php echo $this->Html->url('/events/getKmCar/')?>' ;
            var carId = jQuery('#cars').val();

            jQuery.ajax({
                type: "POST",
                url: link,
                data: { carId: carId},
                dataType: "json",
                success: function (json) {
                
                    if (json.response === true) {
                        var km = json.km;
                        jQuery('#EventKm').val(km);

                    }
                }
            });


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

        jQuery('#intervention-type').change(function () {
            if(jQuery(this).val() === '2'){
                jQuery('#cars-select').hide();
                jQuery('#pieces').show();
            }else{
                jQuery('#cars-select').show();
                jQuery('#pieces').hide();
            }
        });

    });




       
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

</script>
<?php $this->end(); ?>
