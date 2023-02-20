<?php

?><h4 class="page-title"> <?=__('Add event');?></h4>

<div class="box">
    <div class="edit form card-box p-b-0">

        <?php echo $this->Form->create('Event', array('enctype' => 'multipart/form-data', 'onsubmit'=> 'javascript:disable();')); ?>
        <div class="box-body">
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
                            array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlay", 'escape' => false, "title" => "Add Type")); ?>

            </div>
            <div style="clear:both"></div>
            <?php
            echo '<div id="interfering">';
            echo "<div class='form-group interferingGroup input-button' id='interfering0'>" . $this->Form->input('EventCategoryInterfering.0.interfering_id', array(
                    'label' => __('Interfering'),
                    'class' => 'form-control select2',
                    'empty' => ''
                )) . "</div>";
            echo '</div>';
            ?>
            <!-- overlayed element -->
            <div id="dialogModalInterfering">
                <!-- the external content is loaded inside this tag -->
                <div id="contentWrapInterfering"></div>
            </div>
            
            <div style="clear:both"></div>
            <?php
            echo "<div id='interval'></div>";
            echo "<div class='form-group'>" . $this->Form->input('cost', array(
                    'label' => __('Cost'),
                    'placeholder' => __('Enter cost'),
                    'class' => 'form-control',
                )) . "</div>";
            echo "<div class='form-group'>" . $this->Form->input('obs', array(
                    'label' => __('Observation'),
                    'placeholder' => __('Enter observation'),
                    'class' => 'form-control',
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
<script type="text/javascript">

    $(document).ready(function() {
        jQuery('#type').change(function () {
            jQuery('#interval').load('<?php echo $this->Html->url('/events/getIntervals/')?>' + jQuery(this).val());
            jQuery('#interfering').load('<?php echo $this->Html->url('/events/getInterferingsByType/')?>' + jQuery(this).val()+'/'+0, function() {
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

</script>

<?php $this->end(); ?>
