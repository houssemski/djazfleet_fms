<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB33Wa5iG-fztbIhYh60y9YGaZoKuCOPho&libraries=places">
</script>

<?php
 if (Configure::read('logistia') == '1'){
?><h4 class="page-title"> <?= __('Ajouter une réparation'); ?></h4>
<?php
} else {
?><h4 class="page-title"> <?= __('Add event'); ?></h4>
<?php
}
include("ctp/datetime.ctp");
 if (Configure::read('logistia') == '1'){
 $addRequestBol = $this->Session->read('addRequestBol');
if ($addRequestBol){
    $addRequest = $this->Session->read('addRequest');
    $this->request->data = $addRequest;
}
 }

?>
<div class="box">
    <div class="edit form card-box p-b-0">

        <?php echo $this->Form->create('Event', array('enctype' => 'multipart/form-data', 'onsubmit' => 'javascript:disable();')); ?>
        <div class="box-body-event">
            <div class="nav-tabs-custom pdg_btm">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                   <?php  if (Configure::read("gestion_commercial") == '1'  &&
                    Configure::read("tresorerie") == '1') { ?>
                    <li><a href="#tab_2" data-toggle="tab"><?= __('Payment ') ?></a></li>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <?php
                        echo "<div class='form-group'>" . $this->Form->input('stock', array(
                                'class' => 'form-control',
                                'value' => $stock,
                                'id'=>'stock',
                                'type' => 'hidden',
                            )) . "</div>";
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
			 	  echo "<div class='form-group input-button' id='eventtype'>" . $this->Form->input('event_types', array(
                                'label' => __('Repair type'),
                                'class' => 'form-control',
                                'id' => 'event-type',
                                'empty' => true
                            )) . "</div>";
			 } else {
			   echo "<div class='form-group input-button' id='eventtype'>" . $this->Form->input('event_types', array(
                                'label' => __('Event type'),
                                'class' => 'form-control',

                                'id' => 'type',
                                'empty' => true
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
                                array("controller" => "events", "action" => "addEventType",'addEvent'),
                                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlay", 'escape' => false, "title" => __("Add Type"))); ?>

                        </div>
                        <div style="clear:both"></div>
                        <?php
                        echo "<div class='form-group'>" . $this->Form->input('car_id', array(
                                'label' => __('Car'),
                                'class' => 'form-control select2',
                                'empty' => true,
                                'id' => 'cars',
                            )) . "</div>";
			   
			    if (Configure::read('logistia') == '1'){
			    
			    	        echo "<div id='customers-div'>";
                        echo "<div class='form-group' >" . $this->Form->input('customer_id', array(
                                'label' => __("Applicant"),
                                'class' => 'form-control select2',
                                'empty' => '',
                                'id' => 'customers',
                            )) . "</div>";
                        echo "</div>";
                        echo "<div class='form-group' >" . $this->Form->input('structure_id', array(
                                'label' => __("Structure"),
                                'class' => 'form-control select2',
                                'empty' => '',
                                'id' => 'structure',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('boss_id', array(
                                'label' => __("Service"),
                                'class' => 'form-control select2',
                                'options' => $customers,
                                'empty' => '',
                                'id' => 'customers',
                            )) . "</div>";
			    
			    }else {
			    
			    	    echo "<div id='customers-div'>";
		                        echo "<div class='form-group' >" . $this->Form->input('customer_id', array(
		                                'label' => __("Conductor"),
		                                'class' => 'form-control select2',
		                                'empty' => '',
		                                'id' => 'customers',
		                            )) . "</div>";
		                        echo "</div>";
			    
			    } 
			    


                        echo "<div id='interval_type' style='padding-top: 20px;'>";
                        echo '<div class="lbl_type required"><label>' . __("Type");
                        echo "</label></div>";
                        $options = array('1' => __('Internal'), '2' => __('External'));

                        $attributes = array('legend' => false,'onclick' =>'javascript:getInterferingByCategory(this.id);');
                        echo $this->Form->radio('internal_external', $options, $attributes) . "</div><br/>";

                        echo "<div id='assurance-div'></div>";

                        echo "<div id='interfering'></div> ";
			
			  if (Configure::read('logistia') == '1'){


                        echo "<div class='form-group'>" . $this->Form->input('reception_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Reception date') . '</label><div class="input-group date"><label for="birthday"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'birthday',
                            )) . "</div>";

                        echo "<div class='form-group'>" . $this->Form->input('intervention_date', array(
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
			  
			  }
		
			?>

                        <div style="clear:both"></div>

                        <?php
                        echo "<div id='interval'></div>";
                        echo "<div id='refund_amount_div'><div class='form-group'>" . $this->Form->input('refund_amount', array(
                                'label' => __('Refund amount'),
                                'placeholder' => __('Enter refund amount'),
                                'class' => 'form-control',
                                'id' => 'refund_amount'
                            )) . "</div>";

                        $options = array('1' => __('Low'), '2' => __('Medium'), '3' => __('Serious'), '4' => __('Very serious'));
                        echo "<div class='form-group'>" . $this->Form->input('severity_incident', array(
                                'label' => __('Severity incident'),
                                'type' => 'select',
                                'options' => $options,
                                'empty' => '',
                                'id' => 'severity',
                                'class' => 'form-control',
                            )) . "</div>";


                        $options = array('1' => __('Car accident'), '2' => __('Ice break'), '3' => __('Natural disaster'), '4' => __('Fire'), '5' => __('Parking'), '6' => __('Vandalism'), '7' => __('Robbery'), '8' => __('Other'));
                        echo "<div class='form-group'>" . $this->Form->input('sinistre_type', array(
                                'label' => __('Type of sinister'),
                                'type' => 'select',
                                'options' => $options,
                                'empty' => '',
                                'id' => 'severity',
                                'class' => 'form-control',
                            )) . "</div>"; ?>
                        <div style="clear:both"></div>
                        <br/>
                        <?php   echo "<div id='interval4'>";

                        echo "<div class='form-group audiv1'>" . $this->Form->input('dommages_corporels', array(
                                'label' => __('Dommages corporels'),
                                'id' => 'dommages_corporels',
                            )) . "</div>";

                        echo "</div></div>"; ?>

                        <div id='maps'></div>

                        <?php
                        echo "<div id='interval2'>";
                        echo '<div class="lbl1" style="display: inline-block; width: 150px;">' . __("Pay by the driver");
                        echo "</div>";
                        $options = array('1' => __('Yes'), '0' => __('No'));
                        $attributes = array('legend' => false);
                        echo $this->Form->radio('pay_customer', $options, $attributes) . "</div>";?>
                        <div style="clear:both"></div>
                        <?php echo "<div id='interval3'>";
                        echo '<div class="lbl1" style="display: inline-block;margin-top: 15px; width: 150px;">' . __("Refund");
                        echo "</div>";
                        $options = array('1' => __('Yes'), '0' => __('No'));
                        $attributes = array('legend' => false);
                        echo $this->Form->radio('refund', $options, $attributes);
                        echo '</br>';
                        echo '</br>';
                        echo '</div>';
                        echo "<div id='interval_date_refund'>";
                        echo "<div class='form-group'>" . $this->Form->input('date_refund', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',

                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Refund date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'date_refund',
                            )) . "</div>";
                        echo "</div>";


                        ?>
                        <div style="clear:both"></div>
                        <br/>
			<?php 
			
			if (Configure::read('logistia') == '1'){
						echo "<div class='form-group'>" . $this->Form->input('diagnostic', array(
                                'label' => __('Diagnostic'),
                                'placeholder' => __('Enter diagnostic'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('event_time', array(
                                'label' => __('Durré de la réparation'),
                                'placeholder' => __('Enter diagnostic'),
                                'class' => 'form-control',
                            )) . "</div>";
			  
			  }else {
			  
			  	echo "<div class='form-group'>" . $this->Form->input('cost', array(
                                'label' => __('Global cost'),
                                'placeholder' => __('Enter cost'),
                                'id' => 'cost',
                                'class' => 'form-control',
                            )) . "</div>";
			  
			  }	
			  
		

                        echo "<div class='form-group'>" . $this->Form->input('obs', array(
                                'label' => __('Observation'),
                                'placeholder' => __('Enter observation'),
                                'class' => 'form-control',
                            )) . "</div>";

            if (Configure::read('logistia') == '1') {
                echo "<div id='interval_type' style='padding-top: 20px;'>";
                echo '<div class="lbl_type"><label>' . __("Alerte");
                echo "</label></div>";
                echo "<div class='form-group'>" . $this->Form->input('alert_activate', array(
                        'label' => __('Alert activate'),
                        'class' => 'form-control'
                    )) . "</div>";
                echo "<div class='form-group'>" . $this->Form->input('renew_after_expiration', array(
                        'label' => __('Renouvler aprés expiration'),
                        'class' => 'form-control'
                    )) . "</div>";

                echo "<div id='interval_type' style='padding-top: 20px;'>";
                echo '<div class="lbl_type"><label>' . __("Alerte par");
                echo "</label></div>";
                $options = array('1' => __('km'), '0' => __('date'));
                $attributes = array('legend' => false, 'id' => 'alert-type');
                echo $this->Form->radio('alert_type', $options, $attributes);


                echo "<div id='alert-type-iputs'></div>";
                echo '<br>';

            }
			    
			    
			    


                        echo '<div class="lbl3">' . __("Attachments") . '</div>';

                        ?>








                        <!-- COMPONENT START -->


                        <table id='dynamic_field' class="table-input">
                            <tr>
                                <td class="td-input">
                                    <?php

                                    if ($version_of_app == 'web') {
                                    $Dir_attachment1 = 'events';
                                    $id_dialog = 'dialogModalAttachment1Dir';
                                    $id_input = 'attachment1';

                                    ?>
                                    <div id="dialogModalAttachment1Dir">
                                        <!-- the external content is loaded inside this tag -->
                                        <div id="contentWrapAttachment1Dir"></div>
                                    </div>
                                    <div id="dialogModalAttachment2Dir">
                                        <!-- the external content is loaded inside this tag -->
                                        <div id="contentWrapAttachment2Dir"></div>
                                    </div>
                                    <div id="dialogModalAttachment3Dir">
                                        <!-- the external content is loaded inside this tag -->
                                        <div id="contentWrapAttachment3Dir"></div>
                                    </div>
                                    <div id="dialogModalAttachment4Dir">
                                        <!-- the external content is loaded inside this tag -->
                                        <div id="contentWrapAttachment4Dir"></div>
                                    </div>
                                    <div id="dialogModalAttachment5Dir">
                                        <!-- the external content is loaded inside this tag -->
                                        <div id="contentWrapAttachment5Dir"></div>
                                    </div>


                                    <div class="input-button4" id="attachment1">
                                        <div class="input text">
                                            <label for="attachment1_dir"></label>
                                            <input id="attachment1_dir" class="form-control"
                                                   name="data[Event][attachment_dir][]" readonly="readonly" type="text"
                                                   style="margin-top: 5px;"/>
                                        </div>
                                    </div>

                                    <div class="button-file">
                                        <a class="btn btn-default btn-trans waves-effect waves-primary w-md m-b-5 h-bn overlayAttachment1Dir"
                                           href="../events/openDir/events/dialogModalAttachment1Dir/attachment1">
                                            <i class="fa fa-folder-open m-r-5"></i>
                                            <?php echo __('Select'); ?>
                                        </a>
                                    </div>
                    </div>
                    <div style="clear:both;"></div>

                    <?php
                    }
                    ?>




                    <div id="attachment1-file">
                        <div class="input-button">
                            <div class="input file">
                                <label for="att1"></label>
                                <input id="att1" class="form-control " name="data[Event][attachment][]" type="file"/>
                            </div>
                        </div>

						<span class="popupactions popupactions-c">
							<button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 h-bn btn-marg "
                                    id='attachment1-btn' type="button" onclick="delete_file('attachment1');"><i
                                    class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
						</span>
                    </div>

                    </td>
                    <td class="td_tab">
                        <button style="margin-left: 40px;" type='button' name='add' id='add'
                                class='btn btn-success'><?= __('Add more') ?></button>
                    </td>
                    </tr>
                    </table>
                    <!-- COMPONENT END -->
                    <div class="row">
                        <div id="panel-prod" class="col-md-12">

                        </div>
                    </div>

                </div>
                <div class="tab-pane" id="tab_2">

                    <div class="panel-group" id="accordion">

                        <?php echo "<div class='form-group'>" . $this->Form->input('nb_payment', array(
                                'label' => '',
                                'type' => 'hidden',
                                'value' => 0,
                                'id' => 'nb_payment',
                                'empty' => ''
                            )) . "</div>"; ?>


                        <div class="panel panel-default" id='payment'>
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion"
                                       href="#payment0"><?php echo __('Payment ') ?>1</a>
                                </h4>
                            </div>
                            <div id="payment0" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <?php

                                    echo "<div class='form-group'>" . $this->Form->input('Payment.0.reference', array(
                                            'label' => __('Reference'),
                                            'placeholder' => __('Enter reference'),
                                            'class' => 'form-control',
                                        )) . "</div>";
                                    $current_date = date("Y-m-d");
                                    echo "<div class='form-group'>" . $this->Form->input('Payment.0.receipt_date', array(
                                            'label' => '',
                                            'placeholder' => 'dd/mm/yyyy',
                                            'type' => 'text',
                                            'value' => $this->Time->format($current_date, '%d-%m-%Y'),
                                            'class' => 'form-control datemask',
                                            'before' => '<label>' . __('Payment date') . '</label><div class="input-group date"><label for="CarPaymentDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                            'after' => '</div>',
                                            'id' => 'receipt_date0',
                                        )) . "</div>";

                                    echo "<div class='form-group'>" . $this->Form->input('Payment.0.compte_id', array(
                                            'label' => __('Compte'),
                                            'empty' => '',
                                            'class' => 'form-control',
                                        )) . "</div>";
                                    if (Configure::read("cafyb") == '1') {
                                        $options = $paymentMethods ;
                                    }else {
                                        $options = array('1' => __('Species'), '2' => __('Transfer'), '3' => __('Bank check'));
                                    }

                                    echo "<div class='form-group'>" . $this->Form->input('Payment.0.payment_type', array(
                                            'label' => __('Payment type'),
                                            'empty' => '',
                                            'type' => 'select',
                                            'options' => $options,
                                            'class' => 'form-control',
                                        )) . "</div>";
                                    echo "<div class='form-group'>" . $this->Form->input('Payment.0.interfering_id', array(
                                            'label' => __('Interfering'),
                                            'empty' => '',
                                            'class' => 'form-control select2',
                                        )) . "</div>";
                                    echo "<div class='form-group'>" . $this->Form->input('Payment.0.amount', array(
                                            'label' => __('Amount'),
                                            'placeholder' => __('Enter amount'),
                                            'type' => 'number',
                                            'class' => 'form-control',
                                        )) . "</div>";


                                    echo "<div class='form-group'>" . $this->Form->input('Payment.0.note', array(
                                            'label' => __('Note'),
                                            'rows' => '6',
                                            'cols' => '30',
                                            'placeholder' => __('Enter note'),
                                            'class' => 'form-control',
                                        )) . "</div>";

                                    ?>

                                </div>


                            </div>
                        </div>


                    </div>


                    <div class="btn-group pull-left">
                        <div class="header_actions">
                            <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add Payment'),
                                'javascript:addPayment();',
                                array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'add_payment')) ?>

                        </div>
                    </div>
                    <br/></br><br/>
                </div>

            </div>
            <?php
            if ($version_of_app == 'web') {
                ?>
                <div class='progress-div' id="progress-div">
                    <div class='progress-bar1' id="progress-bar">
                        <div id="progress-status1">0 %</div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
    <div class="box-footer">
        <?php
        if ($version_of_app == 'web') {
            echo $this->Form->submit(__('Submit'), array(
                'name' => 'ok',
                'class' => 'btn btn-primary btn-bordred  m-b-5',
                'label' => __('Submit'),
                'type' => 'submit',
                // 'onclick' =>'javascript:submitForm();',
                'div' => false
            ));
        } else {
            echo $this->Form->submit(__('Submit'), array(
                'name' => 'ok',
                'class' => 'btn btn-primary btn-bordred  m-b-5',
                'label' => __('Submit'),
                'id' => 'ok',
                'type' => 'submit',
                'id' => 'boutonValider',
                'div' => false
            ));
        }

        ?>
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
<?= $this->Html->script('jquery-2.1.1.min.js'); ?>
<?= $this->Html->script('jquery.form.min.js'); ?>
<script type="text/javascript">

    var selectedProducts = [];
    $(document).ready(function () {

        jQuery(".datetime-workshop").datetimepicker({
            format:'DD/MM/YYYY HH:mm',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            }
        });

        $('.datetime-workshop').click(function(){
            var popup =$(this).offset();
            var popupTop = popup.left;
            $('.bootstrap-datetimepicker-widget').css({
                'bottom' : 10,
                'left' : 10,
                'height' : 300,
                'top' :38,
                'z-index': 99999,
                'background-color' : '#fff',
                'font-size':11
            });
            checkIfMechanicIsAvailable();
        });
        jQuery('#boutonValider').on('click',function (e) {
            console.log('valider');
            jQuery('[id^=prod-price]').each(function () {
                if (jQuery(this).val() === "" || parseInt(jQuery(this).val()) === 0 ){
                    e.preventDefault();
                    alert('Le prix des piéces doit étre supérieur a zéro');
                }
            });
            jQuery('[id^=prod-quantity]').each(function () {
                if (jQuery(this).val() === "" || parseInt(jQuery(this).val()) === 0 ){
                    e.preventDefault();
                    alert('Le quantité des piéces doit étre supérieur a zéro');
                }
            });
        });
        jQuery("#interval2").css("display", "none");
        jQuery("#interval3").css("display", "none");
        jQuery("#interval_date_refund").css("display", "none");
        jQuery("#refund_amount_div").css("display", "none");
        jQuery("#receipt_date0").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#date_refund").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        <?php
        $addRequestBol = $this->Session->read('addRequestBol');
        if ($addRequestBol){
            ?>
        var eventTypeId = jQuery("#event-type").val();
        jQuery('#panel-prod').load('<?php echo $this->Html->url('/events/getEventProducts/')?>' + eventTypeId,function () {
            selectedProducts = [];
            var k = 0;
            jQuery('[id^=product_name]').each(function () {
                getProduct(jQuery(this).val(),k);
                k++;
            });
            jQuery('#nb_product').val(k+1);
        });
        <?php
        }
        ?>
        jQuery("#event-type").change(function () {
            jQuery('#panel-prod').load('<?php echo $this->Html->url('/events/getEventProducts/')?>' + jQuery(this).val(),function () {
                selectedProducts = [];
                var k = 0;
                jQuery('[id^=product_name]').each(function () {
                    getProduct(jQuery(this).val(),k);
                    k++;
                });
                jQuery('#nb_product').val(k+1);
            });

        });
        jQuery(document).on('change','[id^=product_name]',function () {
            var productOrder = jQuery(this).attr('rel');
            var productId = jQuery(this).val();
            getProduct(productId,productOrder)
        });
        jQuery('#type').change(function () {
            if (jQuery('#type').val() > 0) {

                jQuery('#interval').load('<?php echo $this->Html->url('/events/getIntervals/')?>' + jQuery(this).val()+'/'+jQuery('#cars').val(), function () {

                    jQuery(".date").datetimepicker({

                        format: 'DD/MM/YYYY',
                        icons: {
                            time: "fa fa-clock-o",
                            date: "fa fa-calendar",
                            up: "fa fa-arrow-up",
                            down: "fa fa-arrow-down"
                        }


                    });
                    $('.date').click(function () {
                        var popup = $(this).offset();
                        var popupTop = popup.left;
                        $('.bootstrap-datetimepicker-widget').css({
                            'bottom': 10,
                            'left': 10,
                            'height': 250
                        });
                    });
                    if (jQuery('#vidange_hour').val() == 1 && jQuery('#type').val() == 10) {
                        jQuery("label[for='EventKm']").text("<?php echo __('Hours consumed') ?>");
                        jQuery("#EventKm").attr("placeholder", "<?php echo __('Enter hours consumed') ?>");

                        jQuery("label[for='EventNextKm']").text("<?php echo __('Next oil change') ?>");
                        jQuery("#EventNextKm").attr("placeholder", "<?php echo __('Enter next oil change') ?>");

                    } else {
                        jQuery("label[for='EventKm']").text("<?php echo __('Km') ?>");
                        jQuery("#EventKm").attr("placeholder", "<?php echo __('Enter km') ?>");

                        jQuery("label[for='EventNextKm']").text("<?php echo __('Next km') ?>");
                        jQuery("#EventNextKm").attr("placeholder", "<?php echo __('Enter next km') ?>");

                    }
                });
                var stock = jQuery('#stock').val();
                if(stock == 1){
                    jQuery('#panel-prod').load('<?php echo $this->Html->url('/events/getCategoryEvent/')?>' + jQuery(this).val());
                }


                // jQuery('#interval2').load('<?php echo $this->Html->url('/events/getIntervals/')?>' + jQuery(this).val());
                var typeArr = [1, 6, 7, 8, 15, 19];
//use of inArray
                if (typeArr.inArray(jQuery('#type').val())) {

                    jQuery("#interval2").css("display", "block");
                } else {

                    jQuery("#interval2").css("display", "none");
                }

                if (jQuery('#type').val() == 11) {

                    jQuery('#assurance-div').load('<?php echo $this->Html->url('/events/getNumAssurance/')?>' + jQuery('#cars').val());
                    jQuery("#assurance-div").css("display", "block");
                    jQuery("#refund_amount_div").css("display", "block");
                    jQuery('#reason').val('');
                    jQuery('#addresspicker').val('');
                    jQuery('#latlng').val('');
                    jQuery("#maps").css("display", "none");
                    jQuery('#maps').load('<?php echo $this->Html->url('/events/getLocalisation')?>', function () {
                        jQuery("#reason-payed").css("display", "none");
                        var geolocationAPI = navigator.geolocation;
                        navigator.geolocation.getCurrentPosition(successfunction, errorfunction);

                        function errorfunction(error) {
                            console.log(error);
                        }

                        function successfunction(position) {
                            myLatitude = position.coords.latitude;
                            myLongitude = position.coords.longitude;

                            google.maps.event.addDomListener(window, 'load', initialize(myLatitude, myLongitude, 15, "map"));
                        }


                        function traiteAdresse(marker, latLng, infowindow, map) {
                            //recadre et zomme sur les coordonnées latLng

                            map.setCenter(latLng);
                            map.setZoom(14);
                            //on stocke nos nouvelles coordonée dans le champs correspondant
                            document.getElementById('latlng').value = latLng;
                            //on va rechercher les information sur l'adresse correspondant à ces coordonnées
                            geocoder.geocode({
                                'latLng': latLng
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
                        }

                        //fonction initialisant la carte
                        function initialize(lat, lng, zoom, carte) {

                            geocoder = new google.maps.Geocoder();
                            //par défaut on prend les coordonnées entré dans notre champs latlng

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
                            //déplacable
                            marker.setDraggable(true);
                            marker.setPosition(latlng);


                            document.getElementById('latlng').value = latlng;
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
                        }
                    });
                    jQuery("#maps").css("display", "block");
                } else {
                    if (jQuery('#type').val() == 12) {
                        jQuery('#maps').load('<?php echo $this->Html->url('/events/getLocalisation')?>', function () {
                            var geolocationAPI = navigator.geolocation;
                            navigator.geolocation.getCurrentPosition(successfunction, errorfunction);

                            function errorfunction(error) {
                                console.log(error);
                            }

                            function successfunction(position) {
                                myLatitude = position.coords.latitude;
                                myLongitude = position.coords.longitude;

                                google.maps.event.addDomListener(window, 'load', initialize(myLatitude, myLongitude, 15, "map"));
                            }


                            function traiteAdresse(marker, latLng, infowindow, map) {
                                //recadre et zomme sur les coordonnées latLng

                                map.setCenter(latLng);
                                map.setZoom(14);
                                //on stocke nos nouvelles coordonée dans le champs correspondant
                                document.getElementById('latlng').value = latLng;
                                //on va rechercher les information sur l'adresse correspondant à ces coordonnées
                                geocoder.geocode({
                                    'latLng': latLng
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
                            }

                            //fonction initialisant la carte
                            function initialize(lat, lng, zoom, carte) {

                                geocoder = new google.maps.Geocoder();
                                //par défaut on prend les coordonnées entré dans notre champs latlng

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
                                //déplacable
                                marker.setDraggable(true);
                                marker.setPosition(latlng);


                                document.getElementById('latlng').value = latlng;
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
                            }
                        });
                        jQuery("#maps").css("display", "block");
                    }
                    else {

                        jQuery('#reason').val('');
                        jQuery('#addresspicker').val('');
                        jQuery('#latlng').val('');
                        jQuery("#maps").css("display", "none");
                    }


                    jQuery('#num_assurance').val('');
                    jQuery('#refund_amount').val('');
                    jQuery('#assurance-div').css("display", "none");
                    jQuery("#refund_amount_div").css("display", "none");

                }

            }
        });
        if (jQuery('#type-category').val() != 8) jQuery("#panel-prod").css("display", "block");
        else jQuery("#panel-prod").css("display", "none");

        Array.prototype.inArray = function (value) {
            // Returns true if the passed value is found in the
            // array. Returns false if it is not.
            var i;
            for (i = 0; i < this.length; i++) {
                if (this[i] == value) {
                    return true;
                }
            }
            return false;
        };
        jQuery('#EventPayCustomer1').change(function () {

            jQuery("#interval3").css("display", "block");
        });
        jQuery('#EventPayCustomer0').change(function () {

            jQuery("#interval3").css("display", "none");
        });

        jQuery('#EventRefund1').change(function () {

            jQuery("#interval_date_refund").css("display", "block");
        });
        jQuery('#EventRefund0').change(function () {

            jQuery("#interval_date_refund").css("display", "none");
        });


        if (jQuery('#cars').val() > 0) {


            jQuery('#customers-div').load('<?php echo $this->Html->url('/events/getCustomersByCar/')?>' + jQuery('#cars').val(), function () {
                jQuery('.select2').select2();
                if (jQuery('#vidange_hour').val() == 1 && jQuery('#type').val() == 10) {
                    jQuery("label[for='EventKm']").text("<?php echo __('Hours consumed') ?>");
                    jQuery("#EventKm").attr("placeholder", "<?php echo __('Enter hours consumed') ?>");

                    jQuery("label[for='EventNextKm']").text("<?php echo __('Next oil change') ?>");
                    jQuery("#EventNextKm").attr("placeholder", "<?php echo __('Enter next oil change') ?>");

                } else {
                    jQuery("label[for='EventKm']").text("<?php echo __('Km') ?>");
                    jQuery("#EventKm").attr("placeholder", "<?php echo __('Enter km') ?>");

                    jQuery("label[for='EventNextKm']").text("<?php echo __('Next km') ?>");
                    jQuery("#EventNextKm").attr("placeholder", "<?php echo __('Enter next km') ?>");

                }


            });
            getKmCar();


        }
        jQuery('#cars').change(function () {


            jQuery('#customers-div').load('<?php echo $this->Html->url('/events/getCustomersByCar/')?>' + jQuery('#cars').val(), function () {
                jQuery('.select2').select2();
                if (jQuery('#vidange_hour').val() == 1 && jQuery('#type').val() == 10) {

                    jQuery("label[for='EventKm']").text("<?php echo __('Hours consumed') ?>");
                    jQuery("#EventKm").attr("placeholder", "<?php echo __('Enter hours consumed') ?>");

                    jQuery("label[for='EventNextKm']").text("<?php echo __('Next oil change') ?>");
                    jQuery("#EventNextKm").attr("placeholder", "<?php echo __('Enter next oil change') ?>");


                } else {

                    jQuery("label[for='EventKm']").text("<?php echo __('Km') ?>");
                    jQuery("#EventKm").attr("placeholder", "<?php echo __('Enter km') ?>");

                    jQuery("label[for='EventNextKm']").text("<?php echo __('Next km') ?>");
                    jQuery("#EventNextKm").attr("placeholder", "<?php echo __('Enter next km') ?>");
                }


            });
            getKmCar();
            if (jQuery('#type').val() == 11) {
                jQuery('#assurance-div').css("display", "block");

                jQuery('#assurance-div').load('<?php echo $this->Html->url('/events/getNumAssurance/')?>' + jQuery('#cars').val());

            } else {

                jQuery('#num_assurance').val('');

                jQuery('#assurance-div').css("display", "none");


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


        var products_id = new Array();
        jQuery("#delete_product0").css("display", "none");


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
        var i = 1;
        $('#add').click(function () {
            i++;
            if (i < 6) {


                $('#dynamic_field').append('<tr id="row' + i + '"><td><?php  if($version_of_app == 'web') { ?><div class="input-button4" id="attachment' + i + '"><div class="input text"><label for="attachment' + i + '_dir"></label><input id="attachment' + i + '_dir" class="form-control" name="data[Event][attachment_dir][]" readonly="readonly" type="text"/ style="margin-top: 5px;"></div></div><div class="button-file"><a class="btn btn-default btn-trans waves-effect waves-primary w-md m-b-5 h-bn overlayAttachment' + i + 'Dir" onclick="open_popup(\'events\',\'dialogModalAttachment' + i + 'Dir\',\'attachment' + i + '\');"><i class="fa fa-folder-open m-r-5"></i><?php echo __('Select'); ?></a></div><div style="clear:both;"></div><?php } ?><div id="attachment' + i + '-file" ><div class="input-button"><div class="input file"><label for ="att' + i + '"></label><input id="att' + i + '" class="form-control filestyle" name="data[Event][attachment][]"  type="file"/></div></div><span class="popupactions"><button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg"  id="attachment' + i + '-btn" type="button" onclick="delete_file(\'attachment' + i + '\');"><i class="fa fa-repeat m-r-5"></i><?php echo __('Empty')?></button></span></div></td><td ><button style="margin-left: 40px;" name="remove" id="' + i + '" onclick="remove(\'' + i + '\');"class="btn btn-danger btn_remove">X</button> </td></tr>');

                if (i == 5) {
                    $('#add').attr('disabled', true);
                }
            }

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

        jQuery('#alert-type0').on('click',function () {
            jQuery('#alert-type-iputs').load('<?php echo $this->Html->url('/events/getDateInputs/')?>',function () {
                jQuery("#last_revision_date").datetimepicker({

                    format: 'DD/MM/YYYY',
                    icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    }


                });
            });
        });

        jQuery('#alert-type1').on('click',function () {
            jQuery('#alert-type-iputs').load('<?php echo $this->Html->url('/events/getKmInputs/')?>');
        });
    });

function getKmCar(){
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
}
    function addProductBill() {
        var nb_product = parseFloat(jQuery('#nb_product').val()) + 1;
        jQuery('#nb_product').val(nb_product);
        jQuery("#table_products").append("<tr id=product" + nb_product + "></tr>");
        jQuery("#total0").append("<div ></div>");
        var product = nb_product - 1;

        jQuery("#product" + '' + nb_product + '').load("<?php echo $this->Html->url('/events/addProductBill/')?>" + nb_product);
        jQuery("#delete_product0").css("display", "block");
    }

    function getInterferingByCategory(id){

        if(id=='EventInternalExternal2'){

            <?php
                if(Configure::read('logistia') == '1' ){
            ?>
            console.log('here');
            jQuery('#interfering').load('<?php echo $this->Html->url('/events/getExternalEventFields')?>');
            <?php
            }else{
            ?>

            jQuery('#interfering').load('<?php echo $this->Html->url('/events/getInterferingsByType/')?>' + jQuery('#type').val() + '/' + 0, function () {
                jQuery('.select2').select2();
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


                jQuery('#EventCategoryInterfering1').change(function () {

                    jQuery('#Payment0InterferingId').val(jQuery('#EventCategoryInterfering1').val());
                });

            });
            <?php
            }
            ?>

        }else{
            if (id=='EventInternalExternal1') {
            jQuery('#interfering').load('<?php echo $this->Html->url('/events/getMechaniciansAndWorkshops/')?>' , function () {
                jQuery('.select2').select2();
                jQuery("#workshop_entry_date").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
                jQuery("#workshop_exit_date").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
                jQuery(".datetime-workshop").datetimepicker({
                    format:'DD/MM/YYYY HH:mm',
                    icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    }
                });

                $('.datetime-workshop').click(function(){
                    var popup =$(this).offset();
                    var popupTop = popup.left;
                    $('.bootstrap-datetimepicker-widget').css({
                        'bottom' : 10,
                        'left' : 10,
                        'height' : 300,
                        'top' :38,
                        'z-index': 99999,
                        'background-color' : '#fff',
                        'font-size':11
                    });
                    checkIfMechanicIsAvailable();
                });





            });

        }
        }

    }



    function calculPrice(id) {

        var num = id.substring(id.length - 1, id.length);

        var quantity = jQuery("#quantity" + '' + num + '').val();
        quantity = parseInt(quantity);
        var max = jQuery("#max" + '' + num + '').val();

        max = parseInt(max);


        if (quantity > max) {
            jQuery("#quantity" + '' + num + '').val(max);
            msg = '<?php echo __('Not enough stock, maximum value is')?>';

            jQuery("#msg" + '' + num + '').html("<p style='color: #a94442;'>" + msg + ' ' + max + "</p>");
        }


        if (jQuery("#price" + '' + num + '' + "").val() > 0) {


            if (jQuery("#quantity" + '' + num + '' + "").val() > 0) {


                var total_ht = jQuery("#quantity" + '' + num + '' + "").val() * jQuery("#price" + '' + num + '' + "").val();
                var total_ttc = jQuery("#quantity" + '' + num + '' + "").val() * jQuery("#price" + '' + num + '' + "").val() * (parseFloat(jQuery("#tva_prod" + '' + num + '' + "").val()) + 1);

                var total_tva = total_ttc - total_ht;
                total_ht = total_ht.toFixed(2);
                total_ttc = total_ttc.toFixed(2);
                total_tva = total_tva.toFixed(2);

                jQuery("#ht" + '' + num + '' + "").val(total_ht);
                jQuery("#ttc" + '' + num + '' + "").val(total_ttc);
                jQuery("#tva" + '' + num + '' + "").val(total_tva);
                jQuery("#total" + '' + num + '' + "").html("<span style='float: right;'>" + total_ttc + "</span>");
            }
            var total_price_ht = 0.00;
            var total_price_ttc = 0.00;
            var total_price_tva = 0.00;
            var nb = jQuery("#nb_product").val();

            if (nb == 0) {
                total_price_ht = jQuery("#ht0").val();
                total_price_ttc = jQuery("#ttc0").val();
                total_price_tva = jQuery("#tva0").val();
            }
            else {

                for (var i = 0; i <= nb; i++) {

                    total_price_ht = total_price_ht + parseFloat(jQuery("#ht" + '' + i + '' + "").val());
                    total_price_ttc = total_price_ttc + parseFloat(jQuery("#ttc" + '' + i + '' + "").val());
                    total_price_tva = total_price_tva + parseFloat(jQuery("#tva" + '' + i + '' + "").val());

                }
                total_price_ht = total_price_ht.toFixed(2);
                total_price_ttc = total_price_ttc.toFixed(2);
                total_price_tva = total_price_tva.toFixed(2);
            }

            jQuery("#price_ht").val(total_price_ht);
            jQuery("#price_ttc").val(total_price_ttc);
            jQuery("#price_tva").val(total_price_tva);
            jQuery("#total_ht").html("<span style='float: right;'>" + total_price_ht + "</span>");
            jQuery("#total_ttc").html("<span style='float: right;'>" + total_price_ttc + "</span>");
            jQuery("#total_tva").html("<span style='float: right;'>" + total_price_tva + "</span>");

        }

    }

    function addOtherInterfering(id_int) {
        i = jQuery("#nb_interfering" + id_int).val();
        i++;
        if (i < 4) {
            $('#dynamic_field' + id_int).append('<tr id="row' + i + '' + id_int + '"><td ></td></tr>');
            if (i == 3) $('#add' + id_int).css('display', 'none');
        }
        jQuery("#nb_interfering" + id_int).val(i);


        category_id = jQuery("#EventCategoryInterfering" + id_int + "EventTypeCategory").val();
        jQuery("#row" + '' + i + '' + '' + id_int + '').load('<?php echo $this->Html->url('/events/getInterferingsByCategory/')?>' + jQuery('#type').val() + '/' + i + '/' + id_int, function () {
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
            jQuery('#EventCategoryInterfering1').change(function () {
                jQuery('#Payment0InterferingId').val(jQuery('#EventCategoryInterfering1').val());
            });
        });
    }
    function quantityMax(id) {

        var num = id.substring(id.length - 1, id.length);
        var product_id = jQuery("#product_name" + '' + num + '' + "").val();

        jQuery("#quantity_max" + '' + num + '').load("<?php echo $this->Html->url('/events/quantityProduct/')?>" + num + '/' + product_id);
        // jQuery("#quantity"+''+num+'').val('');
        // jQuery("#price"+''+num+'').val('');
        // jQuery("#ristoune"+''+num+'').val('');
        // jQuery("#ristoune_val"+''+num+'').val('');
        // jQuery("#quantity"+''+num+'').val('');
        jQuery("#total" + '' + num + '').html("<span style='float: right;'>0.00</span>");
    }

    function DeleteProduct(id) {

        var num = id.substring(id.length - 1, id.length);

        jQuery("#product" + '' + num + '' + "").css("display", "none");

        jQuery("#quantity" + '' + num + '' + "").val(0);
        jQuery("#price" + '' + num + '' + "").val(0);

        jQuery("#ht" + '' + num + '' + "").val(0);
        jQuery("#ttc" + '' + num + '' + "").val(0);
        jQuery("#tva" + '' + num + '' + "").val(0);
        // jQuery("#total"+''+num+''+"").html("<span style='float: right;'>"0.00"</span>");

        var total_price_ht = 0.00;
        var total_price_ttc = 0.00;
        var total_price_tva = 0.00;
        var nb = jQuery("#nb_product").val();
        if (nb == 0) {
            total_price_ht = jQuery("#ht0").val();
            total_price_ttc = jQuery("#ttc0").val();
            total_price_tva = jQuery("#tva0").val();
        }
        else {

            for (var i = 0; i <= nb; i++) {

                total_price_ht = total_price_ht + parseFloat(jQuery("#ht" + '' + i + '' + "").val());
                total_price_ttc = total_price_ttc + parseFloat(jQuery("#ttc" + '' + i + '' + "").val());
                total_price_tva = total_price_tva + parseFloat(jQuery("#tva" + '' + i + '' + "").val());
            }
            total_price_ht = total_price_ht.toFixed(2);
            total_price_ttc = total_price_ttc.toFixed(2);
            total_price_tva = total_price_tva.toFixed(2);
        }
        jQuery("#price_ht").val(total_price_ht);
        jQuery("#price_ttc").val(total_price_ttc);
        jQuery("#price_tva").val(total_price_tva);
        jQuery("#total_ht").html("<span style='float: right;'>" + total_price_ht + "</span>");
        jQuery("#total_ttc").html("<span style='float: right;'>" + total_price_ttc + "</span>");
        jQuery("#total_tva").html("<span style='float: right;'>" + total_price_tva + "</span>");

    }


    function delete_file(id) {


        $("#" + '' + id + '' + "-file").before(
            function () {
                if (!$(this).prev().hasClass('input-ghost')) {
                    var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                    element.attr("name", $(this).attr("name"));
                    element.change(function () {
                        element.next(element).find('input').val((element.val()).split('\\').pop());
                    });

                    $(this).find("#" + '' + id + '' + "-btn").click(function () {
                        element.val(null);
                        $(this).parents("#" + '' + id + '' + "-file").find('input').val('');
                    });
                    $(this).find('input').css("cursor", "pointer");
                    /*$(this).find('input').mousedown(function() {
                     $(this).parents("#"+''+id+''+"-file").prev().click();
                     return false;
                     });*/
                    return element;
                }
            }
        );
    }

    function calculate_cost() {

        var global_cost = 0;
        var tabVals = new Array();
        $('.cost_interfering').each(function () {
            if (parseFloat($(this).val()) > 0) global_cost = parseFloat(global_cost) + parseFloat($(this).val());


        });


        jQuery("#cost").val(global_cost);

    }


    function OpenDir(id) {
        jQuery('#dialogModalOpenDir').dialog('open');
        jQuery('#dialogModalOpenDir').load('<?php echo $this->Html->url('/cars/openDir/')?>' + id);

    }


    function submitForm() {
        $('#EventAddForm').submit(function (e) {


            e.preventDefault();

            $(this).ajaxSubmit({

                beforeSubmit: function () {

                    $("#progress-bar").width('0%');

                },

                uploadProgress: function (event, position, total, percentComplete) {
                    $("#progress-bar").width(percentComplete + '%');
                    $("#progress-bar").html('<div id="progress-status">' + percentComplete + ' %</div>');

                },

                success: function () {

                    window.location = '<?php echo $this->Html->url('/events')?>';
                },
                resetForm: true
            });
            return false;


        });
    }
    ;

    function addPayment() {

        var nb_payment = parseFloat(jQuery('#nb_payment').val()) + 1;
        var nb = nb_payment + 1;

        jQuery('#nb_payment').val(nb_payment);

        jQuery("#payment").append("<div class='panel panel-default'><div class='panel-heading'><h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion' href='#payment" + nb_payment + "'><?php echo __('Payment ')?> " + nb + " </a></h4></div>");
        jQuery("#payment").append("<div id='payment" + nb_payment + "' class='panel-collapse collapse'></div>");


        jQuery("#payment" + '' + nb_payment + '').load('<?php echo $this->Html->url('/events/addPayment/')?>' + nb_payment, function () {
                jQuery("#receipt_date" + '' + nb_payment + '').inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            }
        );


    }

    function remove(id) {


        $('#row' + id + '').remove();
        i--;
        $('#add').css('display', 'block');

    }
    ;


    function open_popup(dir, id_dialog, id_input) {

        var i = id_input.substring(id_input.length - 1, id_input.length);

        jQuery('#contentWrapAttachment' + i + 'Dir').load('<?php echo $this->Html->url('/events/openDir/')?>' + dir + '/' + id_dialog + '/' + id_input);
        //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
        jQuery('#dialogModalAttachment' + i + 'Dir').dialog('open');
    }

    function getProduct(productId , productOrder){

        jQuery.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url('/events/getProduct/')?>" + productId,
                data: {productId: productId},
                dataType: "json",
                success: function (data) {
                    selectedProducts[productOrder] = data;
                    console.log(selectedProducts);
                }
            });
    }

    function setProductPrice(elem){
        var price;
        var supplier;
        var radioValue = elem.attr('value');
        var lineOrder = elem.attr('data');
        var productNameElem = jQuery('#product_name'+lineOrder);
        var productQuantityElem = jQuery('#prod-quantity'+lineOrder);
        var productPriceElem = jQuery('#prod-price'+lineOrder);
        var productSupplierElem = jQuery('#supplier'+lineOrder);
        var prodPrice;
        if (radioValue === '1'){
            price = 'original_price';
            supplier = 'supplier_id';
        }else{
            price = 'copy_price';
            supplier = 'copy_supplier_id';
        }
        if (productNameElem.val() !== ''){

            if (productQuantityElem.val() !== ''){
                prodPrice = parseFloat(productQuantityElem.val())
                    * parseFloat(selectedProducts[parseInt(lineOrder)][price]);
                productPriceElem.val(parseInt(prodPrice));
            }else{
                prodPrice = parseFloat(selectedProducts[parseInt(lineOrder)][price]);
                productPriceElem.val(parseInt(prodPrice, 10));
            }
            productSupplierElem.val(selectedProducts[parseInt(lineOrder)][supplier]);
        }
    }

    function checkIfMechanicIsAvailable(){

        var link= '<?php echo $this->Html->url('/events/checkIfMechanicIsAvailable/')?>' ;
        var mechanicId = jQuery('#mechanic').val();
        var workshopEntryDate = jQuery('#workshop_entry_date').val();
        var workshopExitDate = jQuery('#workshop_exit_date').val();

        jQuery.ajax({
            type: "GET",
            url: link,
            data: {
                mechanicId: mechanicId,
                workshopEntryDate : workshopEntryDate,
                workshopExitDate : workshopExitDate
            },
            dataType: "json",
            success: function (json) {


                if (json.response === false) {
                    alert('<?= __('The mechanic is not available during this period.') ?>');

                }
            }
        });
    }
</script>
<?php $this->end(); ?>
