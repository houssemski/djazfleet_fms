<?php
include("ctp/script.ctp");
?><h4 class="page-title"> <?=__('Edit intervention request');?></h4>

<div class="box">
    <div class="edit form card-box p-b-0">

        <?php echo $this->Form->create('Event', array('enctype' => 'multipart/form-data', 'onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
            <?php
            echo $this->Form->input('id');
            if ($reference != null) {
                echo "<div class='form-group'>" . $this->Form->input('code', array(
                        'label' => __('Reference'),
                        'class' => 'form-control',
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
	     echo "<div class='form-group input-button' id='eventtype'>" . $this->Form->input('event_type_id', array(
                    'label' => __('Intervention type'),
                    'class' => 'form-control select2',
                    'empty' => ''
                )) . "</div>";
	     }else {
	     
	      echo "<div class='form-group input-button' id='eventtype'>" . $this->Form->input('event_type_id', array(
                    'label' => __('Event type'),
                    'class' => 'form-control select2',
                    'id' => 'type',
                    'empty' => ''
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
                            array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlay", 'escape' => false, "title" => "Add Type")); ?>

            </div>
            <div style="clear:both"></div>
            <?php
	     if (Configure::read('logistia') == '1'){
	     
	         if($this->request->data['Event']['intervention_for'] == '1'){
                echo "<div class='form-group'><span id='model'>" . $this->Form->input('car_id', array(
                        'label' => __('Car'),
                        'class' => 'form-control select2',
                        'empty' => '',
                        'id' => 'cars',
                    )) . "</span></div>";
            }else{
                echo "<div class='form-group' id='pieces'>" . $this->Form->input('other', array(
                        'label' => __("Nom de l' intervention"),
                        'class' => 'form-control',
                    )) . "</div>";
            }
            echo "<div class='form-group' id='customers-div'>" . $this->Form->input('customer_id', array(
                    'label' => __("Applicant"),
                    'class' => 'form-control select2',
                    'empty' => ''
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
                )) . "</div>";

            $this->request->data['Event']['intervention_request_date'] =
                $this->Time->format($this->request->data['Event']['intervention_request_date'], '%d-%m-%Y');
            $this->request->data['Event']['wished_intervention_date'] =
                $this->Time->format($this->request->data['Event']['wished_intervention_date'], '%d-%m-%Y');
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
	     
	     
	     
	     } else {
	          echo "<div class='form-group'><span id='model'>" . $this->Form->input('car_id', array(
                    'label' => __('Car'),
                    'class' => 'form-control select2',
                    'empty' => '',
                    'id' => 'cars',
                )) . "</span></div>";
            echo "<div class='form-group' id='customers-div'>" . $this->Form->input('customer_id', array(
                    'label' => __("Conductor"),
                    'class' => 'form-control select2',
                    'empty' => ''
                )) . "</div>";

            echo "<div id='interfering'> ";
            echo "<div class='form-group' >" . $this->Form->input('interfering_id', array(
                    'label' => __('Interfering'),
                    'class' => 'form-control select2',
                    'id' => 'interferings',
                    'empty' => ''
                )) . "</div>";

            echo "</div>";
             $this->request->data['Event']['date'] = $this->Time->format($this->request->data['Event']['date'], '%d-%m-%Y');

             echo "<div id='interval'><div class='form-group'>" . $this->Form->input('date', array(
                     'label' => '',
                     'placeholder' => 'dd/mm/yyyy',
                     'type' => 'text',
                     'class' => 'form-control datemask',
                     'before' => '<label>' . __('Date') . '</label><div class="input-group date"><label for="Date"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                     'after' => '</div>',
                     'id' => 'date',
                 )) . "</div>";
             echo "<div class='form-group'>" . $this->Form->input('cost', array(
                     'label' => __('Global cost'),
                     'placeholder' => __('Enter cost'),
                     'id'=>'cost',
                     'class' => 'form-control',
                 )) . "</div>";
	     }
       



/*

     
              echo "<div id='interfering'>";
            
                    $i=1;
               if (!empty($eventcategoryinterferings))  {
            foreach ($eventcategoryinterferings as $eventcategoryinterfering){
            if  ($eventcategoryinterfering['EventTypeCategory']['name']=='Autre') $name=''; else $name=$eventcategoryinterfering['EventTypeCategory']['name'] ;
            echo "<div class='form-group'>" . $this->Form->input('EventCategoryInterfering.' . $i . '.event_type_category', array(
                    'type' => 'hidden',
                    'value'=>$eventcategoryinterfering['EventTypeCategory']['id'],
                    'class' => 'form-control',
                )) . "</div>";

             echo "<div class='form-group interferingGroup' id='interfering".$i."'>" . $this->Form->input('EventCategoryInterfering.' . $i . '.interfering_id', array(
                   // 'type' => 'hidden',
                   'label'=> __('Interfering').' '.$name ,
                    'selected'=> $eventcategoryinterfering['Interfering']['id'],
                    'empty'=>__('Select interfering'),
                    'class' => 'form-control',
                )) . "</div>"; ?>


                  <div class="popupactionsInterfering">
                <ul>
                    <li>
                        <?php echo $this->Html->link('<i class=" fa fa-edit m-r-5"></i>' . __('Add', true),
                            array("controller" => "events", "action" => "addInterfering",$i),
                            array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayInterfering", 'escape' => false, "title" => __("Add Interfering"))); ?>
                    </li>
                </ul>
            </div>
            <div style="clear:both"></div>
			<?php	echo "<div class='form-group'>" . $this->Form->input('EventCategoryInterfering.' . $i . '.cost', array(
                   // 'type' => 'hidden',
                    'id'=>'cost'.$i ,
                    'placeholder' => __('Enter cost'),
                    'onchange' => 'javascript:calculate_cost();',
                    'class' => 'form-control cost_interfering'
                )) . "</div>";
                $i++;
                }
                }  else {

                
if (!empty($EventTypeCategories)) {

$i=1;
foreach ($EventTypeCategories as $EventTypeCategory) {
echo  $this->Form->input('EventCategoryInterfering.' . $i . '.event_type_category', array(
                    'type' => 'hidden',
                    'value'=>$EventTypeCategory['EventTypeCategory']['id'],
                    'class' => 'form-control',
                )) ;
  


echo "<div class='form-group' id='interferings'>" . $this->Form->input('EventCategoryInterfering.' . $i . '.interfering_id', array(
                   // 'type' => 'hidden',
                   'label'=> __('Interfering').' '.$EventTypeCategory['EventTypeCategory']['name'] ,
                    'empty'=>__('Select interfering'),
                    'class' => 'form-control',
                )) . "</div>";
echo "<div class='form-group'>" . $this->Form->input('EventCategoryInterfering.' . $i . '.cost', array(
                   // 'type' => 'hidden',
                    'id'=>'cost'.$i ,
                    'value'=>'0',
                    'placeholder' => __('Enter cost'),
                    'onchange' => 'javascript:calculate_cost();',
                    'class' => 'form-control cost_interfering'
                )) . "</div>";
$i++;
}
}







                }
                
                
                echo "</div>";
            ?>
            <!-- overlayed element -->
            <div id="dialogModalInterfering">
                <!-- the external content is loaded inside this tag -->
                <div id="contentWrapInterfering"></div>
            </div>
          
            */
         

 if (Configure::read('logistia') == '0'){

                $this->request->data['Event']['date'] = $this->Time->format($this->request->data['Event']['date'], '%d-%m-%Y');
              
                echo "<div id='interval'><div class='form-group'>" . $this->Form->input('date', array(
                        'label' => '',
                        'placeholder' => 'dd/mm/yyyy',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'before' => '<label>' . __('Date') . '</label><div class="input-group date"><label for="Date"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'date',
                    )) . "</div>";
               
               
                echo "<div class='form-group'>" . $this->Form->input('km', array(
                        'label' => __('Km'),
                        'placeholder' => __('Enter Km'),
                        'id' => 'EventKm',
                        'class' => 'form-control',
                    )) . "</div>";
                echo "<div class='form-group'>" . $this->Form->input('next_km', array(
                        'label' => __('Next km'),
                        'placeholder' => __('Enter next km'),
                        'id' => 'EventNextKm',
                        'class' => 'form-control',
                    )) . "</div></div>";

            


            echo "<div class='form-group'>" . $this->Form->input('cost', array(
                    'label' => __('Cost'),
                     'id'=>'cost',
                    'placeholder' => __('Enter cost'),
                    'class' => 'form-control',
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('obs', array(
                    'label' => __('Observation'),
                    'placeholder' => __('Enter observation'),
                    'class' => 'form-control',
                )) . "</div>";
           
           
            ?>
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
    <?php } ?>
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

        jQuery("#date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#date_refund").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery('#type').change(function () {

            if($(this).val()){
                jQuery('#interval').load('<?php echo $this->Html->url('/events/getIntervals/')?>' + $(this).val(),function(){
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

                jQuery('#interfering').load('<?php echo $this->Html->url('/events/getInterferingsByType/')?>' + jQuery(this).val()+'/'+1, function() {
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

                });
            }

        });
        jQuery('#cars').change(function () {
            jQuery('#customers-div').load('<?php echo $this->Html->url('/events/getCustomersByCar/')?>' + jQuery(this).val());
        });
        <?php
        if($this->request->data['EventType']['with_date'] == 1){ ?>
        jQuery("#date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#nextdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#date3").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        <?php }
        ?>

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
