<?php

?><h4 class="page-title"> <?=__('Add event');?></h4>

<div class="box">
    <div class="edit form card-box p-b-0">

        <?php echo $this->Form->create('Event', array('enctype' => 'multipart/form-data', 'onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
            <?php
           
            echo "<div class='form-group' id='eventtype'>" . $this->Form->input('event_type_id', array(
                    'label' => __('Event type'),
                    'class' => 'form-control select2',
                    
                     'multiple'=>true,
                    'id' => 'type',
                    //'empty' => __('Select type')
                )) . "</div>";
            echo $this->Form->input('event_type_id', array(
                'label' => false,
                'type' => 'hidden',
                'id' => 'carId',
                'value' => $carId

                //'empty' => __('Select type')
            ))
            
         /*   echo "<div class='form-group'>" . $this->Form->input('car_id', array(
                    'label' => __('Car'),
                    'class' => 'form-control select2',
                    'empty' => ''
                    'id' => 'cars',
                )) . "</div>";*/

               
           /*echo "<div id='interfering'> ";
			  echo "<div class='form-group' >" . $this->Form->input('interfering_id', array(
                    'label' => __('Interfering'),
                    'class' => 'form-control',
                    'id' => 'interferings',
                    'empty' => ''
                )) . "</div>"; 

                echo "</div>"*/
            ?>
            <!-- overlayed element -->
            
          
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


            jQuery('#interval').load('<?php echo $this->Html->url('/events/getIntervalsRequest/')?>' + jQuery('#carId').val());

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
