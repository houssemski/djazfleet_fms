<?php
$this->request->data['Lot']['production_date'] = $this->Time->format($this->request->data['Lot']['production_date'], '%d-%m-%Y');
$this->request->data['Lot']['expiration_date'] = $this->Time->format($this->request->data['Lot']['expiration_date'], '%d-%m-%Y');

?><h4 class="page-title"> <?= __('Add lot'); ?></h4>
<?php
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end();
?>

<div class="box">
    <div class="edit form card-box p-b-0">

        <?php echo $this->Form->create('Lot', array('type' => 'file', 'onsubmit' => 'javascript:disable();')); ?>
        <div class="box-body">
            <div class="nav-tabs-custom pdg_btm">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>

                    <li><a href="#tab_2" data-toggle="tab"><?= __('Advanced information') ?></a></li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <?php
                        echo $this->Form->input('id');
                        echo "<div class='form-group input-button'>" . $this->Form->input('code', array(
                                'label' => __('Code'),
                                'placeholder' => __('Enter code lot'),
                                'class' => 'form-control',
                            )) . "</div>";

                        echo "<div class='form-group input-button'>" . $this->Form->input('number', array(
                                'label' => __('Number'),
                                'placeholder' => __('Enter number lot'),
                                'class' => 'form-control',
                            )) . "</div>";


                        echo "<div class='form-group input-button'>" . $this->Form->input('label', array(
                                'label' => __('Label'),
                                'placeholder' => __('Enter label'),
                                'class' => 'form-control',
                            )) . "</div>";

                        echo "<div class='form-group input-button'>" . $this->Form->input('production_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',

                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Production date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'production_date',
                            )) . "</div>";

                        echo "<div class='form-group input-button'>" . $this->Form->input('expiration_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',

                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Expiration date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'expiration_date',
                            )) . "</div>";

                        echo "<div class='form-group input-button'>" . $this->Form->input('tva_id', array(
                                'label' => __('TVA'),
                                'class' => 'form-control select3',
                            )) . "</div>";
                        echo "<div class='form-group input-button' id='types'>" . $this->Form->input('lot_type_id', array(
                                'label' => __('Type'),
                                'empty' => '',
                                'class' => 'form-control select3',
                            )) . "</div>";?>
                        <!-- overlayed element -->
                        <div id="dialogModalType">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapType"></div>
                        </div>
                        <div class="popupactions">
                            <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                array("controller" => "lots", "action" => "addType"),
                                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayType", 'escape' => false, "title" => __("Add type"))); ?>
                        </div>
                        <div style="clear:both"></div>

                        <?php
                        echo "<div class='form-group input-button' id='units'>" . $this->Form->input('product_unit_id', array(
                                'label' => __('Unit'),
                                'class' => 'form-control select3',
                                'empty' => ''
                            )) . "</div>"; ?>

                        <!-- overlayed element -->
                        <div id="dialogModalUnit">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapUnit"></div>
                        </div>
                        <div class="popupactions">

                            <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                array("controller" => "lots", "action" => "addUnit"),
                                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayUnit", 'escape' => false, "title" => __("Add unit"))); ?>

                        </div>
                        <div style="clear:both"></div>

                        <?php
                        echo "<div class='form-group input-button' id='products'>" . $this->Form->input('product_id', array(
                                'label' => __('Product'),
                                'class' => 'form-control select3',
                                'empty' => ''
                            )) . "</div>"; ?>

                        <!-- overlayed element -->
                        <div id="dialogModalProduct">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapProduct"></div>
                        </div>
                        <div class="popupactions">

                            <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                array("controller" => "lots", "action" => "addProduct"),
                                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayProduct", 'escape' => false, "title" => __("Add Product"))); ?>

                        </div>
                        <div style="clear:both"></div>

                        <?php
                        echo "<div class='form-group'>" . $this->Form->input('blocked', array(
                                'label' => __('Blocked'),
                                'class' => 'form-control',
                            )) . "</div>";
                        ?>
                    </div>

                    <div class="tab-pane" id="tab_2">

                        <?php
                        echo "<div class='form-group'>" . $this->Form->input('purchase_price', array(
                                'label' => __('Purchase price'),
                                'placeholder' => __('Enter purchase price'),
                                'class' => 'form-control',
                            )) . "</div>";

                        echo "<div class='form-group'>" . $this->Form->input('sale_price', array(
                                'label' => __('Sale price'),
                                'placeholder' => __('Enter sale price'),
                                'class' => 'form-control',
                            )) . "</div>";


                        ?>
                    </div>

                </div>
            </div>


            <div class="box-footer">
                <?php echo $this->Form->submit(__('Submit'), array(
                    'name' => 'ok',
                    'class' => 'btn btn-primary btn-bordred  m-b-5',
                    'label' => __('Submit'),
                    'type' => 'submit',
                    'id' => 'boutonValider',
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
    <?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
    <?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
    <?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
    <?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
    <?= $this->Html->script('bootstrap-filestyle'); ?>
    <script type="text/javascript">

        $(document).ready(function () {

            jQuery("#expiration_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery("#production_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery("#dialogModalType").dialog({
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
            jQuery(".overlayType").click(function (event) {
                event.preventDefault();
                jQuery('#contentWrapType').load(jQuery(this).attr("href"));
                jQuery('#dialogModalType').dialog('option', 'title', jQuery(this).attr("title"));
                jQuery('#dialogModalType').dialog('open');
            });


            jQuery("#dialogModalProduct").dialog({
                autoOpen: false,
                height:450,
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
            jQuery(".overlayProduct").click(function (event) {
                event.preventDefault();
                jQuery('#contentWrapProduct').load(jQuery(this).attr("href"));  //load content from href of link
                jQuery('#dialogModalProduct').dialog('option', 'title', jQuery(this).attr("title"));  //make dialog title that of link
                jQuery('#dialogModalProduct').dialog('open');  //open the dialog
            });


            jQuery("#dialogModalUnit").dialog({
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
            jQuery(".overlayUnit").click(function (event) {
                event.preventDefault();
                jQuery('#contentWrapUnit').load(jQuery(this).attr("href"));  //load content from href of link
                jQuery('#dialogModalUnit').dialog('option', 'title', jQuery(this).attr("title"));  //make dialog title that of link
                jQuery('#dialogModalUnit').dialog('open');  //open the dialog
            });


            jQuery("#dialogModalWarehouse").dialog({
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
            jQuery(".overlayWarehouse").click(function (event) {
                event.preventDefault();
                jQuery('#contentWrapWarehouse').load(jQuery(this).attr("href"));
                jQuery('#dialogModalWarehouse').dialog('option', 'title', jQuery(this).attr("title"));
                jQuery('#dialogModalWarehouse').dialog('open');
            });


        });


    </script>
    <?php $this->end(); ?>

