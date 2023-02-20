<?php

?><h4 class="page-title"> <?=__('Add request') . " " . lcfirst(__('Affectation'));?></h4>
    <?php
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end();
if (empty($cars)) {
    ?>
    <div id="flashMessage" class="message">
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>
            <?= __('All cars are reserved.') ?>
        </div>
    </div>
<?php }
?>
<div class="box">
    <div class="edit form card-box p-b-0">

        <?php echo $this->Form->create('CustomerCar', array(
            'url'=> array(
                'action' => 'add_request'
            ),
            'enctype' => 'multipart/form-data',
            'onsubmit'=> 'javascript:disable();'
        )); ?>
        <div class="box-body">
            <?php
            echo "<div class='form-group'>" . $this->Form->input('car_type_id', array(
                    'label' => __('Type'),
                    'class' => 'form-control select2',
                    'empty' => ''
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('car_id', array(
                    'label' => __('Car'),
                    'class' => 'form-control select2',

                    'empty' => ''
                )) . "</div>";


                echo "<div class='form-group'>" . $this->Form->input('conductor_group', array(
                        'type' => 'select',
                        'label' => __(__("Conductor") . __('-Group')),
                        'class' => 'form-control',
                        'id' => 'type',
                        'options' => array(__('Select ') . " " . __("Conductor"), __('Select group')),
                    )) . "</div>";
                echo "<div id='interval1'><div class='form-group'>" . $this->Form->input('customer_id', array(
                        'label' => __("Conductor"),
                        'class' => 'form-control select2',
                        'empty' => ''
                    )) . "</div></div>";

                echo "<div id='interval2'> <div class='form-group' id='groups'>" . $this->Form->input('customer_group_id', array(
                        'label' => __('Group'),
                        'class' => 'form-control select2',
                        'empty' => ''
                    )) . "</div></div>";



                echo "<div class='form-group input-button' id='zones'>" . $this->Form->input('zone_id', array(
                        'label' => __('Zone'),
                        'class' => 'form-control select2',

                        'empty' => ''
                    )) . "</div>"; ?>
                <!-- overlayed element -->
                <div id="dialogModal">
                    <!-- the external content is loaded inside this tag -->
                    <div id="contentWrap"></div>
                </div>
                <div class="popupactions">
                            <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                array("controller" => "CustomerCars", "action" => "addZone"),
                                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlay", 'escape' => false, "title" => "Add Zone")); ?>

                </div>
                <div style="clear:both"></div>
                <?php



            echo "<div class='form-group'>" . $this->Form->input('accompanist', array(
                    'label' => __('Accompanist'),
                    'placeholder' => __('Enter accompanist'),
                    'class' => 'form-control',
                )) . "</div>";

            echo "<div class='form-group'>" . $this->Form->input('departure_location', array(
                    'label' => __('Departure location'),
                    'placeholder' => __('Enter departure location'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('return_location', array(
                    'label' => __('Return location'),
                    'placeholder' => __('Enter return location'),
                    'class' => 'form-control',

                    'empty' => ''
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('start', array(
                    'label' => '',
                    'placeholder' => 'dd/mm/yyyy',
                    'type' => 'text',
                    'class' => 'form-control datemask',
                    'before' => '<label>' . __('Starting date') . '</label><div class="input-group date"><label for="StartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'start_date',
                )) . "</div>";

            echo "<div class='form-group'>" . $this->Form->input('end', array(
                    'label' => '',
                    'placeholder' => 'dd/mm/yyyy',
                    'type' => 'text',
                    'class' => 'form-control datemask',
                    'before' => '<label>' . __('Arrival date') . '</label><div class="input-group date"><label for="EndDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',

                    'id' => 'end_date',
                )) . "</div>";


                echo "<div class='form-group'>" . $this->Form->input('options', array(
                        'label' => __('Options'),
                        'placeholder' => __('Enter options'),
                        'class' => 'form-control',
                        'type' => 'select',
                        'multiple' => true,
                        'id' => 'option',
                        'empty' => true,
                    )) . "</div>";







            echo "<div class='form-group'>" . $this->Form->input('obs', array(
                    'label' => __('Observation'),
                    'placeholder' => __('Enter observation'),
                    'class' => 'form-control',
                    'empty' => ''
                )) . "</div>";
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
<script type="text/javascript">     $(document).ready(function() {
        jQuery("#start_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#end_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatereal").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy hh:mm"});
        jQuery("#paymentdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy "});
        jQuery('#interval2').css("display", "none");
        jQuery('#interval1').css("display", "block");
        jQuery('#type').change(function () {
            var val = jQuery(this).val();
            //alert(jQuery(this).val());
            if (val == 0) {
                jQuery('#interval2').css("display", "none");
                jQuery('#interval1').css("display", "block");
            } else {
                jQuery('#interval1').css("display", "none");
                jQuery('#interval2').css("display", "block");
            }

        });




    });

    jQuery("#dialogModal").dialog({
        autoOpen: false,
        height: 300,
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

    function submitForm2() {
        jQuery("#ok").prop('disabled', true);
    }
</script>

<?php $this->end(); ?>