<?php

$this->request->data['Car']['circulation_date'] = $this->Time->format($this->request->data['Car']['circulation_date'], '%d-%m-%Y');
$this->request->data['Car']['date_approval'] = $this->Time->format($this->request->data['Car']['date_approval'], '%d-%m-%Y');
$this->request->data['Car']['purchase_date'] = $this->Time->format($this->request->data['Car']['purchase_date'], '%d-%m-%Y');
$this->request->data['Car']['reception_date'] = $this->Time->format($this->request->data['Car']['reception_date'], '%d-%m-%Y');
$this->request->data['Car']['credit_date'] = $this->Time->format($this->request->data['Car']['credit_date'], '%d-%m-%Y');
$this->request->data['Car']['date_planned_end'] = $this->Time->format($this->request->data['Car']['date_planned_end'], '%d-%m-%Y');
$this->request->data['Car']['date_real_end'] = $this->Time->format($this->request->data['Car']['date_real_end'], '%d-%m-%Y');
$this->request->data['Car']['archived_date'] = $this->Time->format($this->request->data['Car']['archived_date'], '%d-%m-%Y');

$carParc = $this->request->data['Car']['car_parc'];
$currentCarMark = $this->request->data['Car']['mark_id'];


?><h4 class="page-title"> <?= __('Edit car'); ?></h4>
<?php $this->start('css');
echo $this->Html->css('colorpicker/css/colorpicker');
echo $this->Html->css('colorpicker/css/layout');
$this->end(); ?>
<div class="box">
    <div class="edit form card-box p-b-0">

        <?php echo $this->Form->create('Car', array('enctype' => 'multipart/form-data', 'onsubmit' => 'javascript:disable();')); ?>
        <div class="box-body">
            <div class="nav-tabs-custom pdg_btm">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                    <?php if ($carParc != 2) { ?>
                        <li><a href="#tab_2" data-toggle="tab"><?= __('Purchase / Credit') ?></a></li>
                        <li><a href="#tab_3" data-toggle="tab"><?= __('Leasings') . ' ' . __('location') ?></a></li>
                    <?php } ?>
                    <li><a href="#tab_4" data-toggle="tab"><?= __('Performance / Consumption') ?></a></li>
                    <li><a href="#tab_5" data-toggle="tab"><?= __('Km/Month') ?></a></li>
                    <?php if ($carParc != 2) {
                        if (
                            Configure::read("gestion_commercial") == '1'  &&
                            Configure::read("tresorerie") == '1'
                        ) {
                    ?>
                            <li><a href="#tab_6" data-toggle="tab"><?= __('Payment ') ?></a></li>
                    <?php }
                    } ?>
                    <li><a href="#tab_7" data-toggle="tab"><?= __('Attachments') ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">

                        <?php
                        echo $this->Form->input('id');
                        echo "<div class='form-group input-button'>" . $this->Form->input('car_parc', array(
                            'label' => __('Parc'),
                            'value' => $carParc,
                            'class' => 'form-control',
                            'type' => 'hidden'
                        )) . "</div>";
                        if ($autocode == 0) {
                            if (Configure::read("djazfleet") == '1') {
                                echo "<div class='form-group'>" . $this->Form->input('code', array(
                                    'placeholder' => __('Enter code'),
                                    'label' => __('Code'),
                                    'class' => 'form-control',
                                    'onchange' => 'javascript: verifyCode();',
                                    'error' => array(
                                        'attributes' => array('escape' => false),
                                        'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                                            __("The code must be unique") . '</label></div>', true
                                    )
                                )) . "</div>";
                            } else {
                                echo "<div class='form-group'>" . $this->Form->input('code', array(
                                    'placeholder' => __('Enter code'),
                                    'label' => __('Code'),
                                    'class' => 'form-control',
                                    'error' => array(
                                        'attributes' => array('escape' => false),
                                        'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                                            __("The code must be unique") . '</label></div>', true
                                    )
                                )) . "</div>";
                            }
                        } else {
                            echo "<div class='form-group'>" . $this->Form->input('code', array(
                                'placeholder' => __('Enter code'),
                                'label' => __('Code'),
                                'readonly' => true,
                                'class' => 'form-control',
                                'error' => array(
                                    'attributes' => array('escape' => false),
                                    'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                                        __("The code must be unique") . '</label></div>', true
                                )
                            )) . "</div>";
                        }
                        if ($carParc == 2) {
                            echo "<div class='form-group input-button' id='suppliers'>" . $this->Form->input('supplier_id', array(
                                'label' => __('Supplier'),
                                'required' => true,
                                'class' => 'form-control select-search',
                                'id' => 'supplier_offshore',
                                'empty' => ''
                            )) . "</div>";
                        }
                        echo "<div class='form-group input-button' id='parcs'>" . $this->Form->input('parc_id', array(
                            'label' => __('Parc'),
                            'class' => 'form-control select-search',
                            'empty' => ''
                        )) . "</div>"; ?>
                        <!-- overlayed element -->
                        <div id="dialogModalParc">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapParc"></div>
                        </div>
                        <div class="popupactions">

                            <?php echo $this->Html->link(
                                '<i class="fa fa-edit"></i>' . __('Add', true),
                                array("controller" => "cars", "action" => "addParc"),
                                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayParc", 'escape' => false, "title" => __("Add Parc"))
                            ); ?>

                        </div>
                        <div style="clear:both"></div>

                        <?php echo "<div class='form-group input-button' id='marks'>" . $this->Form->input('mark_id', array(
                            'label' => __('Mark'),
                            'class' => 'form-control select-search',
                            'id' => 'mark',
                            'empty' => ''
                        )) . "</div>"; ?>
                        <!-- overlayed element -->
                        <div id="dialogModal">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrap"></div>
                        </div>
                        <div class="popupactions">

                            <?php echo $this->Html->link(
                                '<i class="fa fa-edit"></i>' . __('Add', true),
                                array("controller" => "cars", "action" => "addMark"),
                                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlay", 'escape' => false, "title" => __("Add Mark"))
                            ); ?>

                        </div>
                        <div style="clear:both"></div>
                        <?php
                        echo "<div class='form-group input-button'><span id='model'>" . $this->Form->input('carmodel_id', array(
                            'label' => __('Model'),
                            'default' => $this->request->data['Car']['carmodel_id'],
                            'class' => 'form-control select-search',
                        )) . "</span></div>"; ?>
                        <!-- overlayed element -->
                        <div id="dialogModalModel">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapModel"></div>
                        </div>
                        <div class="popupactions" id="popupactionsModel">
                            <?php
                            echo
                            $this->Html->link(
                                '<i class="fa fa-edit"></i>' . __('Add', true),
                                array("controller" => "cars", "action" => "addModel", $currentCarMark),
                                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayModel", 'escape' => false, "title" => __("Add model"))
                            ); ?>
                        </div>
                        <div style="clear:both"></div>

                        <?php
                        if ($carCategoryId != 3) {
                            echo "<div class='form-group input-button' id='carcategories'>" . $this->Form->input('car_category_id', array(
                                'label' => __('Car category'),
                                'class' => 'form-control select2',
                                'id' => 'category',
                                'empty' => ''
                            )) . "</div>";
                        ?>
                            <!-- overlayed element -->
                            <div id="dialogModalCategory">
                                <!-- the external content is loaded inside this tag -->
                                <div id="contentWrapCategory"></div>
                            </div>
                            <div class="popupactions">

                                <?php echo $this->Html->link(
                                    '<i class="fa fa-edit"></i>' . __('Add', true),
                                    array("controller" => "cars", "action" => "addCategory"),
                                    array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayCategory", 'escape' => false, "title" => __("Add Car Category"))
                                ); ?>

                            </div>
                            <div style="clear:both"></div>
                            <?php
                            echo "<div class='form-group input-button' id='cartypes'>" . $this->Form->input('car_type_id', array(
                                'label' => __('Car type'),
                                'class' => 'form-control select-search',
                                'empty' => ''
                            )) . "</div>"; ?>
                            <!-- overlayed element -->
                            <div id="dialogModalType">
                                <!-- the external content is loaded inside this tag -->
                                <div id="contentWrapType"></div>
                            </div>
                            <div class="popupactions" id="popupactionsType" style="display: none;">

                                <?php echo $this->Html->link(
                                    '<i class="fa fa-edit"></i>' . __('Add', true),
                                    array("controller" => "cars", "action" => "addType"),
                                    array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayType", 'escape' => false, "title" => __("Add Car Type"))
                                ); ?>

                            </div>
                            <div style="clear:both"></div>
                        <?php
                        } else {
                            echo "<div class='hidden' id='carcategories'>" . $this->Form->input('car_category_id', array(
                                'label' => __('Car category'),
                                'class' => 'form-control ',
                                'value' => 3,
                                'type' => 'hidden',
                                'empty' => ''
                            )) . "</div>";

                            echo "<div class='form-group input-button' id='cartypes'>" . $this->Form->input('car_type_id', array(
                                'label' => __('Car type'),
                                'class' => 'form-control select2',
                                'id' => 'car_type',
                                'empty' => ''
                            )) . "</div>"; ?>

                            <!-- overlayed element -->
                            <div id="dialogModalType">
                                <!-- the external content is loaded inside this tag -->
                                <div id="contentWrapType"></div>
                            </div>
                            <div class="popupactions" id="popupactionsType">

                                <?php echo $this->Html->link(
                                    '<i class="fa fa-edit"></i>' . __('Add', true),
                                    array("controller" => "cars", "action" => "addType", 3),
                                    array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayType", 'escape' => false, "title" => __("Add Car Type"))
                                ); ?>

                            </div>
                            <div style="clear:both"></div>
                        <?php }
                        if ($this->request->data['Car']['car_type_id'] == 24 || $this->request->data['Car']['car_type_id'] == 27) {
                            echo "<div class='div-capacity'  >";
                            echo "<div class='form-group input-button' >" . $this->Form->input('capacity1', array(
                                'label' => __('Capacity') . ' ' . __('1'),
                                'class' => 'form-control',
                                'id' => 'capacity1',
                                'empty' => ''
                            )) . "</div>";

                            echo "<div class='form-group input-button' >" . $this->Form->input('capacity2', array(
                                'label' => __('Capacity') . ' ' . __('2'),
                                'class' => 'form-control',
                                'id' => 'capacity2',
                                'empty' => ''
                            )) . "</div>";

                            echo "<div class='form-group input-button' >" . $this->Form->input('capacity3', array(
                                'label' => __('Capacity') . ' ' . __('3'),
                                'class' => 'form-control',
                                'id' => 'capacity3',
                                'empty' => ''
                            )) . "</div>";

                            echo "<div class='form-group input-button' >" . $this->Form->input('capacity4', array(
                                'label' => __('Capacity') . ' ' . __('4'),
                                'class' => 'form-control',
                                'id' => 'capacity4',
                                'empty' => ''
                            )) . "</div>";

                            echo "</div >";
                        } else {
                            echo "<div class='div-capacity'   style ='display: none'>";
                            echo "<div class='form-group input-button' >" . $this->Form->input('capacity1', array(
                                'label' => __('Capacity') . ' ' . __('1'),
                                'class' => 'form-control',
                                'empty' => ''
                            )) . "</div>";

                            echo "<div class='form-group input-button' >" . $this->Form->input('capacity2', array(
                                'label' => __('Capacity') . ' ' . __('2'),
                                'class' => 'form-control',
                                'empty' => ''
                            )) . "</div>";

                            echo "<div class='form-group input-button' >" . $this->Form->input('capacity3', array(
                                'label' => __('Capacity') . ' ' . __('3'),
                                'class' => 'form-control',
                                'empty' => ''
                            )) . "</div>";

                            echo "<div class='form-group input-button' >" . $this->Form->input('capacity4', array(
                                'label' => __('Capacity') . ' ' . __('4'),
                                'class' => 'form-control',
                                'empty' => ''
                            )) . "</div>";

                            echo "</div >";
                        }


                        echo "<div class='form-group'>" . $this->Form->input('car_status_id', array(
                            'label' => __('Status'),
                            'class' => 'form-control select-search',
                            'id' => 'status',
                            'empty' => ''
                        )) . "</div>";
                        ?>
                        <div id='status-date-div'>
                            <?php
                            echo "<div class='form-group'>" . $this->Form->input('status_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Status date') . '</label><div class="input-group date"><label for="CarCirculationDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'status_date',
                            )) . "</div>";

                            ?>
                        </div>
                        <?php
                        if ($carCategoryId != 3) {
                        ?>
                            <div style="clear:both"></div>

                            <?php echo "<div class='form-group audiv1'>" . $this->Form->input('vidange_hour', array(
                                'label' => __('Oil change by hour'),
                                'id' => 'vidange_hour',
                            )) . "</div>"; ?>
                            <div style="clear:both"></div>
                            <?php
                            echo "<div class='form-group input-button' id='fuels'>" . $this->Form->input('fuel_id', array(
                                'label' => __('Fuel'),
                                'class' => 'form-control select-search',
                                'empty' => ''
                            )) . "</div>"; ?>
                            <!-- overlayed element -->
                            <div id="dialogModalFuel">
                                <!-- the external content is loaded inside this tag -->
                                <div id="contentWrapFuel"></div>
                            </div>
                            <div class="popupactions">

                                <?php echo $this->Html->link(
                                    '<i class="fa fa-edit"></i>' . __('Add', true),
                                    array("controller" => "cars", "action" => "addFuel"),
                                    array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayFuel", 'escape' => false, "title" => __("Add Fuel"))
                                ); ?>

                            </div>
                            <div style="clear:both"></div>
                        <?php

                            echo "<div class='form-group audiv1'>" . $this->Form->input('fuel_gpl', array(
                                'label' => __('Fuel GPL'),
                                'id' => 'fuel_gpl',
                            )) . "</div>";
                        }
                        echo "<div class='form-group input-button' id='groups'>" . $this->Form->input('car_group_id', array(
                            'label' => __('Group'),
                            'class' => 'form-control select-search',
                            'empty' => ''
                        )) . "</div>"; ?>
                        <!-- overlayed element -->
                        <div id="dialogModalGroup">
                            <!-- the external content is loaded inside this tag -->
                            <div id="contentWrapGroup"></div>
                        </div>
                        <div class="popupactions">

                            <?php echo $this->Html->link(
                                '<i class="fa fa-edit"></i>' . __('Add', true),
                                array("controller" => "cars", "action" => "addGroup"),
                                array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayGroup", 'escape' => false, "title" => __("Add Group"))
                            ); ?>

                        </div>
                        <div style="clear:both"></div>

                        <?php

                        if ($carCategoryId != 3) {
                            echo "<div class='form-group'>" . $this->Form->input('nbplace', array(
                                'placeholder' => __('Enter place number'),
                                'label' => __('Place number'),
                                'class' => 'form-control',
                            )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('nbdoor', array(
                                'label' => __('Door number'),
                                'placeholder' => __('Enter door number'),
                                'class' => 'form-control',
                            )) . "</div>";
                        }
                        echo "<div class='form-group'>" . $this->Form->input('km_initial', array(
                            'label' => __('Km initial'),
                            'placeholder' => __('Enter km initial'),
                            'class' => 'form-control',
                        )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('immatr_prov', array(
                            'placeholder' => __('Enter provisional registration'),
                            'label' => __('Provisional registration'),
                            'class' => 'form-control',
                        )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('immatr_def', array(
                            'label' => __('Final registration'),
                            'placeholder' => __('Enter final registration'),
                            'class' => 'form-control',
                        )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('chassis', array(
                            'label' => __('Chassis'),
                            'placeholder' => __('Enter chassis'),
                            'class' => 'form-control',
                        )) . "</div>";
                        echo "<div class='form-group color2'>" . $this->Form->input('color2', array(
                            'label' => __('Color'),
                            'placeholder' => __('Enter color'),
                            'class' => 'form-control',
                        )) . "</div>";
                        echo "<div class='form-group my-colorpicker colorpicker-element color'>" . $this->Form->input('color', array(
                            'label' => '',
                            'id' => 'color',
                            'placeholder' => __('Select color'),
                            'class' => 'form-control',
                        )) . "<div id='colorSelector'><div style='background-color: #0000ff'></div></div></div>";
                        echo "<div class='form-group' style='padding-top: 15px; '>" . $this->Form->input('circulation_date', array(
                            'label' => '',
                            'placeholder' => 'dd/mm/yyyy',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label>' . __('Circulation date') . '</label><div class="input-group date"><label for="CarCirculationDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'circulationdate',
                        )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('date_approval', array(
                            'label' => '',
                            'placeholder' => 'dd/mm/yyyy',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label>' . __('Final registration date') . '</label><div class="input-group date"><label for="CarCirculationDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'approvaldate',
                        )) . "</div>";
                        if ($carCategoryId != 3) {
                            echo "<div class='form-group'>" . $this->Form->input('radio_code', array(
                                'label' => __('Radio code'),
                                'placeholder' => __('Enter radio code'),
                                'class' => 'form-control',
                            )) . "</div>";
                        }

                        echo "<div class='form-group'>" . $this->Form->input('company_membership', array(
                            'label' => __('Company membership'),
                            'class' => 'form-control',
                        )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('note', array(
                            'label' => __('Note'),
                            'placeholder' => __('Enter note'),
                            'class' => 'form-control',
                        )) . "</div>";


                        ?>


                    </div>
                    <?php if ($carParc != 2) { ?>
                        <div class="tab-pane" id="tab_2">

                            <?php
                            echo "<div class='form-group input-button' id='acquisitions'>" . $this->Form->input('acquisition_type_id', array(
                                'label' => __('Acquisition type'),
                                'id' => "acquisition",
                                'class' => 'form-control select-search',
                                'empty' => ''
                            )) . "</div>"; ?>
                            <div id="dialogModalAcquisition">
                                <!-- the external content is loaded inside this tag -->
                                <div id="contentWrapAcquisition"></div>
                            </div>
                            <div class="popupactions">

                                <?php echo $this->Html->link(
                                    '<i class="fa fa-edit"></i>' . __('Add', true),
                                    array("controller" => "cars", "action" => "addAcquisitionType"),
                                    array(
                                        "class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayAcquisition",
                                        'escape' => false, "title" => __("Add Acquisition Type")
                                    )
                                ); ?>
                            </div>
                            <div style="clear:both"></div>

                            <?php
                            echo "<div class='form-group input-button' id='suppliers'>" . $this->Form->input('supplier_id', array(
                                'label' => __('Supplier'),
                                'class' => 'form-control select-search',
                                'empty' => ''
                            )) . "</div>"; ?>
                            <div id="dialogModalSupplier">
                                <!-- the external content is loaded inside this tag -->
                                <div id="contentWrapSupplier"></div>
                            </div>
                            <div class="popupactions">

                                <?php echo $this->Html->link(
                                    '<i class="fa fa-edit"></i>' . __('Add', true),
                                    array("controller" => "cars", "action" => "addSupplier", null),
                                    array(
                                        "class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlaySupplier",
                                        'escape' => false, "title" => __("Add supplier")
                                    )
                                ); ?>

                            </div>
                            <div style="clear:both"></div>

                            <?php
                            echo "<div id='interval_achat_leasing'>";

                            echo "<div class='form-group'>" . $this->Form->input('num_contract', array(
                                'label' => __('Number contract'),
                                'placeholder' => __('Enter number contract'),
                                'class' => 'form-control',
                                'id' => 'num_contract',
                            )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('purchase_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Purchase date') .
                                    '</label><div class="input-group date"><label for="CarPurchasingDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                'after' => '</div>',
                                'id' => 'purchase_date',
                            )) . "</div>";


                            echo "<div class='form-group'>" . $this->Form->input('purchasing_price', array(
                                'label' => __('Purchasing price'),
                                'placeholder' => __('Enter purchasing price'),
                                'class' => 'form-control',
                            )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('current_price', array(
                                'label' => __('Current price'),
                                'placeholder' => __('Enter current price'),
                                'class' => 'form-control',
                            )) . "</div>";
                            echo "</div >";

                            echo "<div id='num_cont'>";

                            echo "<div class='form-group'>" . $this->Form->input('reception_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Reception date') .
                                    '</label><div class="input-group date"><label for="CarReceptionDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                'after' => '</div>',
                                'id' => 'reception_date',
                            )) . "</div>";
                            echo "</div>";

                            echo "<div id='interval_location'>";


                            echo "<div class='form-group'>" . $this->Form->input('date_planned_end', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Planned end date') .
                                    '</label><div class="input-group date"><label for="CarPlannedEndDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                'after' => '</div>',
                                'id' => 'planned_end_date',
                            )) . "</div>";

                            echo "<div class='form-group'>" . $this->Form->input('date_real_end', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Real end date') .
                                    '</label><div class="input-group date"><label for="CarRealEndDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                'after' => '</div>',
                                'id' => 'real_end_date',
                            )) . "</div>";


                            echo "</div>";


                            echo "<div id='interval_leasing'>";


                            echo "<div class='form-group'>" . $this->Form->input('credit_date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Credit date') .
                                    '</label><div class="input-group date"><label for="CarCreditDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                'after' => '</div>',
                                'id' => 'credit_date',
                            )) . "</div>";

                            echo "<div class='form-group'>" . $this->Form->input('credit_duration', array(
                                'label' => __('Credit duration'),
                                'placeholder' => __('Enter credit duration in month'),
                                'class' => 'form-control',
                            )) . "</div>";


                            echo "</div>";
                            echo "<div id='interval_leasing_location'>";
                            echo "<div class='form-group'>" . $this->Form->input('monthly_payment', array(
                                'label' => __('Monthly payment'),
                                'placeholder' => __('Enter monthly payment'),
                                'class' => 'form-control',
                            )) . "</div>";
                            echo "</div>";

                            echo "<div class='form-group'>" . $this->Form->input('nb_year_amortization', array(
                                'label' => __('Nb year amortization'),
                                'placeholder' => __('Enter Nb year amortization'),
                                'class' => 'form-control',
                            )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('amortization_amount', array(
                                'label' => __('Amortization amount'),
                                'placeholder' => __('Enter amortization amount'),
                                'class' => 'form-control',
                            )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('amortization_km', array(
                                'label' => __('Amortization km'),
                                'placeholder' => __('Enter amortization km'),
                                'class' => 'form-control',
                            )) . "</div>";


                            ?>
                            <!-- COMPONENT START -->

                            <div id='attachment-file'>

                                <?php
                                echo "<div style='Display:none;'>" . $this->Form->input('purchasing_attachment', array(
                                    'label' => __('Attachment'),
                                    'readonly' => true,
                                    'id' => 'purchasing_attachment',
                                    'type' => 'file',

                                    'class' => 'form-control',


                                )) . '</div>';

                                echo "<div class='input-button4' >" . $this->Form->input('purchasing', array(
                                    'label' => __('Attachment'),
                                    'readonly' => true,
                                    'id' => 'purchasing',
                                    'value' => $this->request->data['Car']['purchasing_attachment'],
                                    'class' => 'form-control',


                                )) . '</div>';
                                $input = 'attachment';
                                echo "<div class='button-file-b'>" . $this->Html->link(
                                    '<i class="fa fa-folder-open  m-r-5"></i>' . __('Browse', true),

                                    'javascript:;',
                                    array(
                                        'escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'uppurchasing',
                                    )
                                ) . '</div>'; ?>
                                <span class="popupactions">
                                    <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg " id='attachment-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
                                </span>
                            </div>

                            <div style="clear:both;"></div>


                            <!-- COMPONENT END -->


                        </div>
                        <div class="tab-pane" id="tab_3">


                            <div class="panel-group" id="accordion">

                                <?php

                                if (!empty($leasings)) {
                                ?>
                                    <div class="panel panel-default" id='leasing'>
                                        <?php $i = 0;

                                        echo "<div class='form-group'>" . $this->Form->input('nb_leasing', array(
                                            'label' => '',
                                            'type' => 'hidden',
                                            'value' => $nb_leasing,
                                            'id' => 'nb_leasing',
                                            'empty' => ''
                                        )) . "</div>";
                                        foreach ($leasings as $leasing) {
                                        ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#leasing<?php echo $i ?>"><?php echo __('Leasing') ?><?php echo $i + 1; ?></a>
                                                    </h4>
                                                </div>
                                                <div id="leasing<?php echo $i ?>" class='panel-collapse collapse in'>
                                                    <div class="panel-body">
                                                        <?php


                                                        echo "<div class='form-group' >" . $this->Form->input('Leasing.' . $i . '.acquisition_type_id', array(
                                                            'label' => __('Acquisition type'),
                                                            'id' => "acquisition_leasing" . $i,
                                                            'onchange' => 'javascript:nameChamps(id);',
                                                            'options' => $acquisitionTypesLeasing,
                                                            'value' => $leasing['Leasing']['acquisition_type_id'],
                                                            'class' => 'form-control select-search',
                                                            'empty' => ''
                                                        )) . "</div>";
                                                        echo "<div class='form-group supplier_location input-button' >" . $this->Form->input('Leasing.' . $i . '.supplier_id', array(
                                                            'label' => __('Supplier'),
                                                            'class' => 'form-control select-search',
                                                            'value' => $leasing['Leasing']['supplier_id'],
                                                            'empty' => ''
                                                        )) . "</div>";


                                                        echo "<div class='form-group'>" . $this->Form->input('Leasing.' . $i . '.num_contract', array(
                                                            'label' => __('Number contract'),
                                                            'placeholder' => __('Enter number contract'),
                                                            'id' => 'num',
                                                            'value' => $leasing['Leasing']['num_contract'],
                                                            'class' => 'form-control',
                                                        )) . "</div>";

                                                        $leasing['Leasing']['reception_date'] = $this->Time->format($leasing['Leasing']['reception_date'], '%d-%m-%Y');
                                                        echo "<div class='form-group'>" . $this->Form->input('Leasing.' . $i . '.reception_date', array(
                                                            'label' => '',
                                                            'value' => $leasing['Leasing']['reception_date'],
                                                            'placeholder' => 'dd/mm/yyyy',
                                                            'type' => 'text',
                                                            'class' => 'form-control datemask',
                                                            'before' => '<label>' . __('Reception date') .
                                                                '</label><div class="input-group date"><label for="CarReceptionDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                                            'after' => '</div>',
                                                            'id' => 'reception_date' . $i,
                                                            'onchange' => 'javascript:champsRequired();'
                                                        )) . "</div>";

                                                        $leasing['Leasing']['end_date'] = $this->Time->format($leasing['Leasing']['end_date'], '%d-%m-%Y');
                                                        echo "<div class='form-group'>" . $this->Form->input('Leasing.' . $i . '.end_date', array(
                                                            'label' => '',
                                                            'value' => $leasing['Leasing']['end_date'],
                                                            'placeholder' => 'dd/mm/yyyy',
                                                            'type' => 'text',
                                                            'class' => 'form-control datemask',
                                                            'before' => '<label>' . __('Planned end date') .
                                                                '</label><div class="input-group date"><label for="CarDateEnd"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                                            'after' => '</div>',
                                                            'id' => 'end_date' . $i,
                                                        )) . "</div>";

                                                        $leasing['Leasing']['end_real_date'] = $this->Time->format($leasing['Leasing']['end_real_date'], '%d-%m-%Y');
                                                        echo "<div class='form-group'>" . $this->Form->input('Leasing.' . $i . '.end_real_date', array(
                                                            'label' => '',
                                                            'value' => $leasing['Leasing']['end_real_date'],
                                                            'placeholder' => 'dd/mm/yyyy',
                                                            'type' => 'text',

                                                            'class' => 'form-control datemask',
                                                            'before' => '<label>' . __('Real end date') .
                                                                '</label><div class="input-group date"><label for="CarEndRealDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                                            'after' => '</div>',
                                                            'id' => 'end_real_date' . $i,
                                                            'onchange' => 'javascript: showBtLeasing();',
                                                        )) . "</div>";


                                                        echo "<div class='form-group'>" . $this->Form->input('Leasing.' . $i . '.reception_km', array(
                                                            'label' => __('Compteur /Km'),
                                                            'value' => $leasing['Leasing']['reception_km'],
                                                            'placeholder' => __('Entrer compteur /Km'),
                                                            'class' => 'form-control',
                                                            'id' => 'reception_km' . $i,
                                                        )) . "</div>";


                                                        echo "<div class='form-group'>" . $this->Form->input('Leasing.' . $i . '.cost_km', array(
                                                            'label' => __('Coût Supp. Au Km HT'),
                                                            'value' => $leasing['Leasing']['cost_km'],
                                                            'placeholder' => __('Entrer coût Supp. Au Km HT'),
                                                            'class' => 'form-control',
                                                            'id' => 'cost_km' . $i,
                                                        )) . "</div>";

                                                        echo "<div class='form-group'>" . $this->Form->input('Leasing.' . $i . '.amont_month', array(
                                                            'label' => __('Monthly payment'),
                                                            'value' => $leasing['Leasing']['amont_month'],
                                                            'placeholder' => __('Enter monthly payment'),
                                                            'id' => 'amont_month' . $i,
                                                            'class' => 'form-control',
                                                        )) . "</div>";

                                                        echo "<div class='form-group'>" . $this->Form->input('Leasing.' . $i . '.km_year', array(
                                                            'label' => __('Km Annuel'),
                                                            'value' => $leasing['Leasing']['km_year'],
                                                            'placeholder' => __('Entrer km Annuel'),
                                                            'id' => 'km_year' . $i,
                                                            'class' => 'form-control',
                                                        )) . "</div>";


                                                        echo "<div class='form-group'>" . $this->Form->input('Leasing.' . $i . '.additional_franchise_km', array(
                                                            'label' => __('Additional franchise km'),
                                                            'placeholder' => __('Entrer additional franchise km'),
                                                            'id' => 'add_km' . $i,
                                                            'class' => 'form-control',
                                                        )) . "</div>";

                                                        echo "<div class='form-group'>" . $this->Form->input('Leasing.' . $i . '.attachment', array(
                                                            'label' => __('Attachment'),
                                                            'value' => $leasing['Leasing']['attachment'],
                                                            'class' => 'form-control filestyle',
                                                            'type' => 'file',
                                                            'empty' => ''
                                                        )) . "</div>";


                                                        ?>

                                                    </div>
                                                </div>
                                            </div>
                                        <?php $i++;
                                        } ?>


                                    </div>
                                <?php } else { ?>

                                    <div class="panel-group" id="accordion">

                                        <?php echo "<div class='form-group'>" . $this->Form->input('nb_leasing', array(
                                            'label' => '',
                                            'type' => 'hidden',
                                            'value' => 0,
                                            'id' => 'nb_leasing',
                                            'empty' => ''
                                        )) . "</div>"; ?>


                                        <div class="panel panel-default" id='leasing'>
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#leasing0"><?php echo __('Contrat ') ?>1</a>
                                                </h4>
                                            </div>
                                            <div id="leasing0" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <?php
                                                    echo "<div class='form-group' >" . $this->Form->input('Leasing.0.acquisition_type_id', array(
                                                        'label' => __('Acquisition type'),
                                                        'id' => "acquisition_leasing0",
                                                        'options' => $acquisitionTypesLeasing,
                                                        'class' => 'form-control select-search',
                                                        'onchange' => 'javascript:nameChamps(id);',
                                                        'empty' => ''
                                                    )) . "</div>";
                                                    echo "<div class='form-group supplier_location input-button' >" . $this->Form->input('Leasing.0.supplier_id', array(
                                                        'label' => __('Supplier'),
                                                        'class' => 'form-control select-search',
                                                        'empty' => ''
                                                    )) . "</div>"; ?>

                                                    <div id="dialogModalSupplier0">
                                                        <!-- the external content is loaded inside this tag -->
                                                        <div id="contentWrapSupplier0"></div>
                                                    </div>
                                                    <div class="popupactions">

                                                        <?php echo $this->Html->link(
                                                            '<i class="fa fa-edit"></i>' . __('Add', true),
                                                            array("controller" => "cars", "action" => "addSupplier", 0),
                                                            array(
                                                                "class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlaySupplier",
                                                                'escape' => false, 'id' => 0, "title" => __("Add Supplier")
                                                            )
                                                        ); ?>

                                                    </div>
                                                    <div style="clear:both"></div>

                                                    <?php

                                                    echo "<div class='form-group'>" . $this->Form->input('Leasing.0.num_contract', array(
                                                        'label' => __('Number contract'),
                                                        'placeholder' => __('Enter number contract'),
                                                        'id' => 'num',
                                                        'class' => 'form-control',
                                                    )) . "</div>";
                                                    echo "<div class='form-group'>" . $this->Form->input('Leasing.0.reception_date', array(
                                                        'label' => '',
                                                        'placeholder' => 'dd/mm/yyyy',
                                                        'type' => 'text',
                                                        'class' => 'form-control datemask',
                                                        'before' => '<label>' . __('Reception date') .
                                                            '</label><div class="input-group date"><label for="CarReceptionDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                                        'after' => '</div>',
                                                        'id' => 'reception_date0',
                                                        'onchange' => 'javascript:champsRequired();'
                                                    )) . "</div>";
                                                    echo "<div class='form-group'>" . $this->Form->input('Leasing.0.end_date', array(
                                                        'label' => '',
                                                        'placeholder' => 'dd/mm/yyyy',
                                                        'type' => 'text',
                                                        'class' => 'form-control datemask',
                                                        'before' => '<label>' . __('Planned end date') .
                                                            '</label><div class="input-group date"><label for="CarDateEnd"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                                        'after' => '</div>',
                                                        'id' => 'end_date0',
                                                    )) . "</div>";
                                                    echo "<div class='form-group'>" . $this->Form->input('Leasing.0.end_real_date', array(
                                                        'label' => '',
                                                        'placeholder' => 'dd/mm/yyyy',
                                                        'type' => 'text',
                                                        'class' => 'form-control datemask',
                                                        'before' => '<label>' . __('Real end date') .
                                                            '</label><div class="input-group date"><label for="CarEndRealDate"></label>
                                    <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                    </div>',
                                                        'after' => '</div>',
                                                        'id' => 'end_real_date0',
                                                        'onchange' => 'javascript: showBtLeasing();',
                                                    )) . "</div>";


                                                    echo "<div class='form-group'>" . $this->Form->input('Leasing.0.reception_km', array(
                                                        'label' => __('Counter / Km'),
                                                        'placeholder' => __('Enter counter / Km'),
                                                        'class' => 'form-control',
                                                        'id' => 'reception_km0',
                                                    )) . "</div>";


                                                    echo "<div class='form-group'>" . $this->Form->input('Leasing.0.cost_km', array(
                                                        'label' => __('Additional cost. At Km HT'),
                                                        'placeholder' => __('Enter additional cost. At Km HT'),
                                                        'class' => 'form-control',
                                                        'id' => 'cost_km0',
                                                    )) . "</div>";


                                                    echo "<div class='form-group'>" . $this->Form->input('Leasing.0.km_year', array(
                                                        'label' => __('Km annual'),
                                                        'placeholder' => __('Enter km annual'),
                                                        'id' => 'km_year0',
                                                        'class' => 'form-control',
                                                    )) . "</div>";
                                                    echo "<div class='form-group'>" . $this->Form->input('Leasing.0.additional_franchise_km', array(
                                                        'label' => __('Additional franchise km'),
                                                        'placeholder' => __('Entrer additional franchise km'),
                                                        'id' => 'add_km0',
                                                        'class' => 'form-control',
                                                    )) . "</div>";

                                                    echo "<div class='form-group'>" . $this->Form->input('Leasing.0.amont_month', array(
                                                        'label' => __('Monthly payment'),
                                                        'placeholder' => __('Enter monthly payment'),
                                                        'id' => 'amont_month0',
                                                        'class' => 'form-control',
                                                    )) . "</div>";
                                                    echo "<div class='form-group'>" . $this->Form->input('Leasing.0.attachment', array(
                                                        'label' => __('Attachment'),
                                                        'class' => 'form-control filestyle',
                                                        'type' => 'file',
                                                        'empty' => ''
                                                    )) . "</div>";

                                                    ?>

                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                <?php } ?>
                            </div>


                            <div id='bt_leasing' class="btn-group pull-left">
                                <div class="header_actions">
                                    <?= $this->Html->link(
                                        '<i class="fa fa-plus m-r-5"></i>' . __('Add leasing'),
                                        'javascript:addLeasing();',
                                        array('escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'add_leasing')
                                    ) ?>

                                </div>
                            </div>
                            <br /></br><br />


                        </div>
                    <?php } ?>

                    <div class="tab-pane" id="tab_4">
                        <?php
                        if ($carCategoryId != 3) {
                            echo "<div class='form-group'>" . $this->Form->input('reservoir', array(
                                'label' => __('Reservoir') . " (L)",
                                'placeholder' => __('Enter capacity reservoir in liter'),
                                'class' => 'form-control',
                            )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('min_consumption', array(
                                'label' => __('Min consumption') . " " . "(L/100Km)",
                                'id' => 'min_consumption',
                                'placeholder' => __('Enter min consumption (L/100Km)'),
                                'class' => 'form-control',
                            )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('max_consumption', array(
                                'label' => __('Max consumption') . " " . "(L/100Km)",
                                'placeholder' => __('Enter max consumption (L/100Km)'),
                                'id' => 'max_consumption',
                                'class' => 'form-control',
                            )) . "</div>";
                            echo "<div id='gpl'><div class='form-group' >" . $this->Form->input('reservoir_gpl', array(
                                'label' => __('Reservoir GPL') . " (L)",
                                'placeholder' => __('Enter capacity reservoir in liter'),
                                'class' => 'form-control',
                            )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('min_consumption_gpl', array(
                                'label' => __('Min consumption') . " " . __('GPL') . " " . "(L/100Km)",
                                'placeholder' => __('Enter min consumption (L/100Km)'),
                                'class' => 'form-control',
                            )) . "</div>";
                            echo "<div class='form-group'>" . $this->Form->input('max_consumption_gpl', array(
                                'label' => __('Max consumption') . " " . __('GPL') . " " . "(L/100Km)",
                                'placeholder' => __('Enter max consumption (L/100Km)'),
                                'class' => 'form-control',
                            )) . "</div></div>";
                        }
                        echo "<div class='form-group'>" . $this->Form->input('max_speed', array(
                            'label' => __('Max Speed') . " (Km/h)",
                            'placeholder' => __('Enter max speed'),
                            'class' => 'form-control',
                        )) . "</div>";

                        echo "<div class='form-group'>" . $this->Form->input('average_speed', array(
                            'label' => __('Average speed') . " (Km/h)",
                            'placeholder' => __('Enter average speed'),
                            'class' => 'form-control',
                        )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('power_car', array(
                            'label' => __('Power car'),
                            'placeholder' => __('Enter power car'),
                            'class' => 'form-control',
                        )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('empty_weight', array(
                            'label' => __('Empty weight') . ' (Kg)',
                            'placeholder' => __('Enter empty weight'),
                            'class' => 'form-control',
                        )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('charge_utile', array(
                            'label' => __('Charge utile') . ' (Kg)',
                            'placeholder' => __('Entrer la charge utile'),
                            'class' => 'form-control',
                        )) . "</div>";

                        echo "<div class='form-group'>" . $this->Form->input('poids_total_charge', array(
                            'label' => __('Poids total en charge') . ' (Kg)',
                            'placeholder' => __('Entrer le poids total en charge'),
                            'class' => 'form-control',
                        )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('nb_palette', array(
                            'label' => __('Units number'),
                            'placeholder' => __('Enter unit number'),
                            'class' => 'form-control',
                        )) . "</div>";
                        if ($carCategoryId != 3) {
                            echo "<div class='form-group'>" . $this->Form->input('limit_consumption', array(
                                'label' => __('Limit consumption') . " " . "(Km)",
                                'id' => 'limit_consumption',
                                'placeholder' => __('Enter limit consumption (Km)'),
                                'class' => 'form-control',
                            )) . "</div>";
                            echo "<div class='form-group'>" .
                                $this->Form->input('coupon_consumption', array(
                                    'label' => __('Monthly consumption of coupons'),
                                    'placeholder' => __('Enter monthly consumption of coupons'),
                                    'class' => 'form-control'
                                )) . "</div>";
                        }
                        ?>

                    </div>

                    <div class="tab-pane" id="tab_5">
                        <?php
                        for ($i = 1; $i <= 12; $i++) {

                            switch ($i) {
                                case 1:
                                    $label = __("January");
                                    break;
                                case 2:
                                    $label = __("February");
                                    break;
                                case 3:
                                    $label = __("March");
                                    break;
                                case 4:
                                    $label = __("April");
                                    break;
                                case 5:
                                    $label = __("May");
                                    break;
                                case 6:
                                    $label = __("June");
                                    break;
                                case 7:
                                    $label = __("July");
                                    break;
                                case 8:
                                    $label = __("August");
                                    break;
                                case 9:
                                    $label = __("September");
                                    break;
                                case 10:
                                    $label = __("October");
                                    break;
                                case 11:
                                    $label = __("November");
                                    break;
                                case 12:
                                    $label = __("December");
                                    break;
                            }


                            if (!empty($monthlykms)) {
                                echo "<div class='form-group'>" . $this->Form->input('Monthlykm.km_' . $i, array(
                                    'label' => __('Km ') . $label,
                                    'placeholder' => __('Enter Km ') . $label,
                                    'value' => $monthlykms['Monthlykm']['km_' . $i],
                                    'class' => 'form-control',
                                )) . "</div>";
                            } else {
                                echo "<div class='form-group'>" . $this->Form->input('Monthlykm.km_' . $i, array(
                                    'label' => __('Km ') . $label,
                                    'placeholder' => __('Enter Km ') . $label,

                                    'class' => 'form-control',
                                )) . "</div>";
                            }
                        }


                        ?>


                    </div>

                    <?php if ($carParc != 2) { ?>
                        <div class="tab-pane" id="tab_6">

                            <?php if (!empty($payments)) { ?>

                                <div class="panel-group" id="accordion">

                                    <?php echo "<div class='form-group'>" . $this->Form->input('nb_payment', array(
                                        'label' => '',
                                        'type' => 'hidden',
                                        'value' => $nb_payment,
                                        'id' => 'nb_payment',
                                        'empty' => ''
                                    )) . "</div>"; ?>
                                    <div class="panel panel-default" id='payment'>
                                        <?php $i = 0;


                                        foreach ($payments as $payment) {
                                        ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#payment<?php echo $i ?>"><?php echo __('Payment ') ?><?php echo $i + 1; ?></a>
                                                    </h4>
                                                </div>
                                                <div id="payment<?php echo $i ?>" class='panel-collapse collapse in'>
                                                    <div class="panel-body">
                                                        <?php

                                                        echo "<div class='form-group'>" . $this->Form->input('Payment.' . $i . '.reference', array(
                                                            'label' => __('Reference'),
                                                            'placeholder' => __('Enter reference'),
                                                            'value' => $payment['Payment']['reference'],
                                                            'class' => 'form-control',
                                                        )) . "</div>";

                                                        $payment['Payment']['receipt_date'] = $this->Time->format($payment['Payment']['receipt_date'], '%d-%m-%Y');
                                                        echo "<div class='form-group'>" . $this->Form->input('Payment.' . $i . '.receipt_date', array(
                                                            'label' => '',
                                                            'placeholder' => 'dd/mm/yyyy',
                                                            'type' => 'text',
                                                            'value' => $payment['Payment']['receipt_date'],
                                                            'class' => 'form-control datemask',
                                                            'before' => '<label>' . __('Payment date') . '</label><div class="input-group date"><label for="CarPaymentDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                                            'after' => '</div>',
                                                            'id' => 'receipt_date' . $i,
                                                        )) . "</div>";
                                                        echo "<div class='form-group'>" . $this->Form->input('Payment.' . $i . '.compte_id', array(
                                                            'label' => __('Compte'),
                                                            'empty' => '',
                                                            'value' => $payment['Payment']['compte_id'],
                                                            'class' => 'form-control',
                                                        )) . "</div>";
                                                        if (Configure::read("cafyb") == '1') {
                                                            $options = $paymentMethods;
                                                        } else {
                                                            $options = array('1' => __('Species'), '2' => __('Transfer'), '3' => __('Bank check'));
                                                        }
                                                        echo "<div class='form-group'>" . $this->Form->input('Payment.' . $i . '.payment_type', array(
                                                            'label' => __('Payment type'),
                                                            'empty' => '',
                                                            'value' => $payment['Payment']['payment_type'],
                                                            'type' => 'select',
                                                            'options' => $options,
                                                            'class' => 'form-control',
                                                        )) . "</div>";
                                                        echo "<div class='form-group'>" . $this->Form->input('Payment.' . $i . '.amount', array(
                                                            'label' => __('Amount'),
                                                            'placeholder' => __('Enter amount'),
                                                            'type' => 'number',
                                                            'value' => $payment['Payment']['amount'],
                                                            'class' => 'form-control',
                                                        )) . "</div>";


                                                        echo "<div class='form-group'>" . $this->Form->input('Payment.' . $i . '.note', array(
                                                            'label' => __('Note'),
                                                            'rows' => '6',
                                                            'cols' => '30',
                                                            'value' => $payment['Payment']['note'],
                                                            'placeholder' => __('Enter note'),
                                                            'class' => 'form-control',
                                                        )) . "</div>";

                                                        ?>

                                                    </div>
                                                </div>
                                            </div>
                                        <?php $i++;
                                        } ?>

                                    </div>


                                </div>
                            <?php
                            } else {
                            ?>

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
                                                <a data-toggle="collapse" data-parent="#accordion" href="#payment0"><?php echo __('Payment ') ?>1</a>
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
                                                $options = array('1' => __('Species'), '2' => __('Transfer'), '3' => __('Bank check'));
                                                echo "<div class='form-group'>" . $this->Form->input('Payment.0.payment_type', array(
                                                    'label' => __('Payment type'),
                                                    'empty' => '',
                                                    'type' => 'select',
                                                    'options' => $options,
                                                    'class' => 'form-control',
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

                            <?php } ?>

                            <div class="btn-group pull-left">
                                <div class="header_actions">
                                    <?= $this->Html->link(
                                        '<i class="fa fa-plus m-r-5"></i>' . __('Add Payment'),
                                        'javascript:addPayment();',
                                        array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'add_payment')
                                    ) ?>

                                </div>
                            </div>
                            <br /></br><br />

                        </div>
                    <?php } ?>


                    <div class="tab-pane" id="tab_7">

                        <?php if ($versionOfApp == 'web') {
                            $Dir_yellowcard = 'yellowcards';
                            $id_dialog = 'dialogModalDir';
                            $id_input = 'yellowcard';

                        ?>
                            <div id="dialogModalDir">
                                <!-- the external content is loaded inside this tag -->
                                <div id="contentWrapDir"></div>
                            </div>

                        <?php


                            echo "<div class='input-button4' id='yellowcard'>" . $this->Form->input('yellow_card_dir', array(
                                'label' => __('Yellow Card'),
                                'readonly' => true,

                                'class' => 'form-control',


                            )) . '</div>';

                            echo "<div class='button-file-b'>" . $this->Html->link(
                                '<i class="fa fa-folder-open m-r-5"></i>' . __('Select', true),
                                array("controller" => "cars", "action" => "openDir", $Dir_yellowcard, $id_dialog, $id_input),
                                array("class" => "btn btn-default btn-trans waves-effect waves-primary w-md m-b-5 overlayDir", 'escape' => false, "title" => __(""))
                            ) . '</div><div style="clear:both;"></div>';
                        }
                        ?>

                        <!-- COMPONENT START -->
                        <div id='yellow-file'>

                            <?php echo "<div  style='Display:none;'>" . $this->Form->input('yellow_card', array(
                                'label' => __('Yellow Card'),
                                'class' => 'form-cont',
                                'id' => 'yellow_card',
                                'type' => 'file',
                                'empty' => ''
                            )) . "</div>";
                            $input = 'yellow';
                            echo "<div class='input-button4 m-t-5' >" . $this->Form->input('file_yellow', array(
                                'label' => __('Yellow Card'),
                                'readonly' => true,
                                'id' => 'file_yellow',
                                'value' => $this->request->data['Car']['yellow_card'],
                                'class' => 'form-control filestyle',


                            )) . '</div>';
                            echo "<div class='button-file-b'>" . $this->Html->link(
                                '<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),

                                'javascript:;',
                                array(
                                    'escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-default w-md m-b-5', 'id' => 'upfile_yellow',
                                )
                            ) . '</div>';
                            ?>
                            <span class="popupactions">
                                <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg " id='yellow-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
                            </span>
                        </div>


                        <div style="clear:both;"></div>
                        <?php

                        if ($versionOfApp == 'web') {
                            $Dir_greycard = 'greycards';
                            $id_dialog = 'dialogModalDirGrey';
                            $id_input = 'greycard';

                        ?>
                            <div id="dialogModalDirGrey">
                                <!-- the external content is loaded inside this tag -->
                                <div id="contentWrapDirGrey"></div>
                            </div>

                        <?php


                            echo "<div class='input-button4' id='greycard'>" . $this->Form->input('grey_card_dir', array(
                                'label' => __('Grey Card'),
                                'readonly' => true,

                                'class' => 'form-control',
                            )) . '</div>';

                            echo "<div class='button-file'>" . $this->Html->link(
                                '<i class="fa fa-folder-open m-r-5"></i>' . __('Select', true),
                                array("controller" => "cars", "action" => "openDir", $Dir_greycard, $id_dialog, $id_input),
                                array("class" => "btn btn-default btn-trans waves-effect waves-primary w-md m-b-5 overlayDirGrey", 'escape' => false, "title" => __(""))
                            ) . '</div><div style="clear:both;"></div>';
                        }
                        ?>

                        <!-- COMPONENT START -->

                        <div id='grey-file'>

                            <?php echo "<div  style='Display:none;'>" . $this->Form->input('grey_card', array(
                                'label' => __('Grey Card'),
                                'class' => 'form-cont',
                                'id' => 'grey_card',
                                'type' => 'file',
                                'empty' => ''
                            )) . "</div>";
                            $input = 'grey';
                            echo "<div class='input-button4 m-t-5' >" . $this->Form->input('file_grey', array(
                                'label' => __('Grey Card'),
                                'readonly' => true,
                                'id' => 'file_grey',
                                'value' => $this->request->data['Car']['grey_card'],
                                'class' => 'form-control',


                            )) . '</div>';
                            echo "<div class='button-file-b'>" . $this->Html->link(
                                '<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),

                                'javascript:;',
                                array(
                                    'escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-default w-md m-b-5', 'id' => 'upfile_grey',
                                )
                            ) . '</div>';
                            ?>
                            <span class="popupactions">
                                <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg " id='grey-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
                            </span>

                            <div class="clear:both"></div>
                        </div>


                        <!-- COMPONENT END -->
                        <!-- COMPONENT START -->

                        <?php $i = 0;
                        if (!empty($this->request->data['Car']['picture1'])) {
                        ?>

                            <div id='picture1-file' style="clear: both;">

                                <?php
                                echo "<div style='Display:none;'>" . $this->Form->input('picture1', array(
                                    'label' => __('Picture'),
                                    'readonly' => true,
                                    'id' => 'picture1',
                                    'type' => 'file',
                                    'onchange' => 'javascript:verif_ext_attachment(1,this.id)',
                                    'class' => 'form-control',


                                )) . '</div>';

                                echo "<div class='input-button4 m-t-5' >" . $this->Form->input('file1', array(
                                    'label' => __('Pictures'),
                                    'readonly' => true,
                                    'id' => 'file1',
                                    'value' => $this->request->data['Car']['picture1'],
                                    'class' => 'form-control',
                                )) . '</div>';
                                $input = 'picture1';
                                echo "<div class='button-file'>" . $this->Html->link(
                                    '<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),

                                    'javascript:;',
                                    array(
                                        'escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-default w-md m-b-5', 'id' => 'upfile1',
                                    )
                                ) . '</div>'; ?>
                                <span class="popupactions popupactions-picture">
                                    <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg " id='picture1-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
                                </span>
                            </div>

                            <div style="clear:both;"></div>
                        <?php $i = 1;
                        } else {

                            echo "<div >" . $this->Form->input('file1', array(
                                'type' => 'hidden',
                                'id' => 'file1',
                                'value' => '',
                                'class' => 'form-control',
                            )) . '</div>';
                        } ?>


                        <!-- COMPONENT END -->
                        <!-- COMPONENT START -->
                        <?php if (!empty($this->request->data['Car']['picture2'])) { ?>

                            <div id='picture2-file'>

                                <?php
                                echo "<div style='Display:none;'>" . $this->Form->input('picture2', array(
                                    'label' => __('Picture2'),
                                    'readonly' => true,
                                    'id' => 'picture2',
                                    'type' => 'file',
                                    'onchange' => 'javascript:verif_ext_attachment(1,this.id)',
                                    'class' => 'form-control',


                                )) . '</div>';

                                echo "<div class='input-button4 m-t-5' >" . $this->Form->input('file2', array(
                                    'label' => '',
                                    'readonly' => true,
                                    'id' => 'file2',
                                    'value' => $this->request->data['Car']['picture2'],
                                    'class' => 'form-control input_label',


                                )) . '</div>';
                                $input = 'picture2';
                                echo "<div class='button-file-b'>" . $this->Html->link(
                                    '<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),

                                    'javascript:;',
                                    array(
                                        'escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-default w-md m-b-5', 'id' => 'upfile2',
                                    )
                                ) . '</div>'; ?>
                                <span class="popupactions">
                                    <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg " id='picture2-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
                                </span>
                            </div>

                            <div style="clear:both;"></div>

                        <?php $i = 2;
                        } else {

                            echo "<div >" . $this->Form->input('file2', array(
                                'type' => 'hidden',
                                'id' => 'file2',
                                'value' => '',
                                'class' => 'form-control',
                            )) . '</div>';
                        } ?>
                        <!-- COMPONENT END -->

                        <!-- COMPONENT START -->
                        <?php if (!empty($this->request->data['Car']['picture3'])) { ?>

                            <div id='picture3-file'>

                                <?php
                                echo "<div style='Display:none;'>" . $this->Form->input('picture3', array(
                                    'label' => __('Picture3'),
                                    'readonly' => true,
                                    'id' => 'picture3',
                                    'type' => 'file',
                                    'onchange' => 'javascript:verif_ext_attachment(1,this.id)',
                                    'class' => 'form-control',


                                )) . '</div>';

                                echo "<div class='input-button4 m-t-5' >" . $this->Form->input('file3', array(
                                    'label' => '',
                                    'readonly' => true,
                                    'id' => 'file3',
                                    'value' => $this->request->data['Car']['picture3'],
                                    'class' => 'form-control input_label',


                                )) . '</div>';
                                $input = 'picture3';
                                echo "<div class='button-file'>" . $this->Html->link(
                                    '<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),

                                    'javascript:;',
                                    array(
                                        'escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-default w-md m-b-5', 'id' => 'upfile3',
                                    )
                                ) . '</div>'; ?>
                                <span class="popupactions">
                                    <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg " id='picture3-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
                                </span>
                            </div>

                            <div style="clear:both;"></div>
                        <?php $i = 3;
                        } else {

                            echo "<div >" . $this->Form->input('file3', array(
                                'type' => 'hidden',
                                'id' => 'file3',
                                'value' => '',
                                'class' => 'form-control',
                            )) . '</div>';
                        } ?>
                        <!-- COMPONENT END -->

                        <!-- COMPONENT START -->
                        <?php if (!empty($this->request->data['Car']['picture4'])) { ?>

                            <div id='picture4-file'>

                                <?php
                                echo "<div style='Display:none;'>" . $this->Form->input('picture4', array(
                                    'label' => __('Picture'),
                                    'readonly' => true,
                                    'id' => 'picture4',
                                    'type' => 'file',
                                    'onchange' => 'javascript:verif_ext_attachment(1,this.id)',
                                    'class' => 'form-control',


                                )) . '</div>';

                                echo "<div class='input-button4 m-t-5' >" . $this->Form->input('file4', array(
                                    'label' => '',
                                    'readonly' => true,
                                    'id' => 'file4',
                                    'value' => $this->request->data['Car']['picture4'],
                                    'class' => 'form-control input_label',


                                )) . '</div>';
                                $input = 'picture4';
                                echo "<div class='button-file'>" . $this->Html->link(
                                    '<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),

                                    'javascript:;',
                                    array(
                                        'escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-default w-md m-b-5', 'id' => 'upfile4',
                                    )
                                ) . '</div>'; ?>
                                <span class="popupactions">
                                    <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg " id='picture4-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
                                </span>
                            </div>

                            <div style="clear:both;"></div>
                        <?php $i = 4;
                        } else {

                            echo "<div >" . $this->Form->input('file4', array(
                                'type' => 'hidden',
                                'id' => 'file4',
                                'value' => '',
                                'class' => 'form-control',
                            )) . '</div>';
                        } ?>
                        <!-- COMPONENT END -->

                        <?php if ($i < 4) {

                            echo "<div >" . $this->Form->input('nb_picture', array(
                                'id' => 'nb_picture',
                                'type' => 'hidden',
                                'value' => $i,
                                'class' => 'form-control',
                            )) . '</div>';

                        ?>
                            <table class='table-input' id='dynamic_field'>

                                <tr>
                                    <td class="td-input">

                                        <div id="picture1-file">
                                            <div class='form-group input-button3'>
                                                <div class="input file">
                                                    <label for="pic1"><?= __('Pictures') ?></label>
                                                    <input id="pic1" class="form-control filestyle" name="data[Car][picture][]" onchange="verif_ext_attachment(1,this.id)" type="file" />
                                                </div>
                                            </div>
                                            <span class="popupactions popupactions-picture">
                                                <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg " id='picture1-btn' type="button" onclick="delete_file('picture1');"><i class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
                                            </span>
                                        </div>

                                    </td>
                                    <td class="td_tab">

                                    </td>
                                </tr>
                            </table>


                        <?php } ?>



                        <?php
                        echo '<div class="lbl3">' . __("Attachments") . '</div>';
                        $i = 0;
                        if (!empty($this->request->data['Car']['attachment1'])) {
                        ?>

                            <!-- COMPONENT START -->

                            <div id='attachment1-file'>

                                <?php
                                echo "<div style='Display:none;'>" . $this->Form->input('attachment1', array(
                                    'label' => __('Attachment 1'),
                                    'readonly' => true,
                                    'id' => 'attach1',
                                    'type' => 'file',

                                    'class' => 'form-control',


                                )) . '</div>';


                                echo "<div class='input-button4 m-t-5' >" . $this->Form->input('att1', array(
                                    'label' => __('Attachment 1'),
                                    'readonly' => true,
                                    'id' => 'att1',
                                    'value' => $this->request->data['Car']['attachment1'],
                                    'class' => 'form-control',


                                )) . '</div>';
                                $input = 'attachment1';
                                echo "<div class='button-file'>" . $this->Html->link(
                                    '<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),

                                    'javascript:;',
                                    array(
                                        'escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-default w-md m-b-5', 'id' => 'upatt1',
                                    )
                                ) . '</div>'; ?>
                                <span class="popupactions popupactions-attachment popupactions-picture ">
                                    <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg " id='attachment1-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
                                </span>
                            </div>

                            <div style="clear:both;"></div>
                        <?php $i = 1;
                        } else {

                            echo "<div >" . $this->Form->input('att1', array(
                                'type' => 'hidden',
                                'id' => 'att1',
                                'value' => '',
                                'class' => 'form-control',
                            )) . '</div>';
                        } ?>
                        <!-- COMPONENT END -->


                        <?php
                        if (!empty($this->request->data['Car']['attachment2'])) {

                            /*  if ($versionOfApp == 'web') {
                                  $Dir_attachment2 = 'cars';
                                  $id_dialog = 'dialogModalAttachment2Dir';
                                  $id_input = 'attachment2';

                                  ?>
                                  <div id="dialogModalAttachment2Dir">
                                      <!-- the external content is loaded inside this tag -->
                                      <div id="contentWrapAttachment2Dir"></div>
                                  </div>

                                  <?php


                                  echo "<div class='input-button5' id='attachment2'>" . $this->Form->input('attachment2_dir', array(
                                          'label' => __('Attachment 2'),
                                          'readonly' => true,

                                          'class' => 'form-control',


                                      )) . '</div>';

                                  echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                          array("controller" => "events", "action" => "openDir", $Dir_attachment2, $id_dialog, $id_input),
                                          array("class" => "btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5 overlayAttachment2Dir", 'escape' => false, "title" => __(""))) . '</div><div style="clear:both;"></div>';
                              }*/
                        ?>
                            <!-- COMPONENT START -->

                            <div id='attachment2-file'>

                                <?php
                                echo "<div style='Display:none;'>" . $this->Form->input('attachment2', array(
                                    'label' => __('Attachment 2'),
                                    'readonly' => true,
                                    'id' => 'attach2',
                                    'type' => 'file',

                                    'class' => 'form-control',


                                )) . '</div>';

                                echo "<div class='input-button4 m-t-5' >" . $this->Form->input('att2', array(
                                    'label' => __('Attachment 2'),
                                    'readonly' => true,
                                    'id' => 'att2',
                                    'value' => $this->request->data['Car']['attachment2'],
                                    'class' => 'form-control',


                                )) . '</div>';
                                $input = 'attachment2';
                                echo "<div class='button-file'>" . $this->Html->link(
                                    '<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),

                                    'javascript:;',
                                    array(
                                        'escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-default w-md m-b-5', 'id' => 'upatt2',
                                    )
                                ) . '</div>'; ?>
                                <span class="popupactions">
                                    <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg " id='attachment2-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
                                </span>
                            </div>

                            <div style="clear:both;"></div>

                            <!-- COMPONENT END -->
                        <?php $i = 2;
                        } else {

                            echo "<div >" . $this->Form->input('att2', array(
                                'type' => 'hidden',
                                'id' => 'att2',
                                'value' => '',
                                'class' => 'form-control',
                            )) . '</div>';
                        } ?>

                        <?php
                        if (!empty($this->request->data['Car']['attachment3'])) {
                            /*  if ($versionOfApp == 'web') {
                                  $Dir_attachment3 = 'cars';
                                  $id_dialog = 'dialogModalAttachment3Dir';
                                  $id_input = 'attachment3';

                                  ?>
                                  <div id="dialogModalAttachment3Dir">
                                      <!-- the external content is loaded inside this tag -->
                                      <div id="contentWrapAttachment3Dir"></div>
                                  </div>

                                  <?php


                                  echo "<div class='input-button5' id='attachment3'>" . $this->Form->input('attachment3_dir', array(
                                          'label' => __('Attachment 3'),
                                          'readonly' => true,

                                          'class' => 'form-control',


                                      )) . '</div>';

                                  echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                          array("controller" => "events", "action" => "openDir", $Dir_attachment3, $id_dialog, $id_input),
                                          array("class" => "btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5 overlayAttachment3Dir", 'escape' => false, "title" => __(""))) . '</div><div style="clear:both;"></div>';
                              }*/
                        ?>


                            <!-- COMPONENT START -->

                            <div id='attachment3-file'>

                                <?php
                                echo "<div style='Display:none;'>" . $this->Form->input('attachment3', array(
                                    'label' => __('Attachment 3'),
                                    'readonly' => true,
                                    'id' => 'attach3',
                                    'type' => 'file',

                                    'class' => 'form-control',


                                )) . '</div>';

                                echo "<div class='input-button4 m-t-5' >" . $this->Form->input('att3', array(
                                    'label' => __('Attachment 3'),
                                    'readonly' => true,
                                    'id' => 'att3',
                                    'value' => $this->request->data['Car']['attachment3'],
                                    'class' => 'form-control',


                                )) . '</div>';
                                $input = 'attachment3';
                                echo "<div class='button-file'>" . $this->Html->link(
                                    '<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),

                                    'javascript:;',
                                    array(
                                        'escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-default w-md m-b-5', 'id' => 'upatt3',
                                    )
                                ) . '</div>'; ?>
                                <span class="popupactions">
                                    <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg " id='attachment3-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
                                </span>
                            </div>

                            <div style="clear:both;"></div>
                        <?php $i = 3;
                        } else {

                            echo "<div >" . $this->Form->input('att3', array(
                                'type' => 'hidden',
                                'id' => 'att3',
                                'value' => '',
                                'class' => 'form-control',
                            )) . '</div>';
                        } ?>
                        <!-- COMPONENT END -->


                        <?php
                        if (!empty($this->request->data['Car']['attachment4'])) {
                            /*  if ($versionOfApp == 'web') {

                                  $Dir_attachment4 = 'cars';
                                  $id_dialog = 'dialogModalAttachment4Dir';
                                  $id_input = 'attachment4';

                                  ?>
                                  <div id="dialogModalAttachment4Dir">
                                      <!-- the external content is loaded inside this tag -->
                                      <div id="contentWrapAttachment4Dir"></div>
                                  </div>
                                  <?php
                                  echo "<div class='input-button5' id='attachment4'>" . $this->Form->input('attachment4_dir', array(
                                          'label' => __('Attachment 4'),
                                          'readonly' => true,

                                          'class' => 'form-control',


                                      )) . '</div>';

                                  echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                          array("controller" => "events", "action" => "openDir", $Dir_attachment4, $id_dialog, $id_input),
                                          array("class" => "btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5 overlayAttachment4Dir", 'escape' => false, "title" => __(""))) . '</div><div style="clear:both;"></div>';
                              }*/
                        ?>


                            <!-- COMPONENT START -->

                            <div id='attachment4-file'>

                                <?php
                                echo "<div style='Display:none;'>" . $this->Form->input('attachment4', array(
                                    'label' => __('Attachment 4'),
                                    'readonly' => true,
                                    'id' => 'attach4',
                                    'type' => 'file',

                                    'class' => 'form-control',


                                )) . '</div>';

                                echo "<div class='input-button4 m-t-5' >" . $this->Form->input('att4', array(
                                    'label' => __('Attachment 4'),
                                    'readonly' => true,
                                    'id' => 'att4',
                                    'value' => $this->request->data['Car']['attachment4'],
                                    'class' => 'form-control',


                                )) . '</div>';
                                $input = 'attachment4';
                                echo "<div class='button-file'>" . $this->Html->link(
                                    '<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),

                                    'javascript:;',
                                    array(
                                        'escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-default w-md m-b-5', 'id' => 'upatt4',
                                    )
                                ) . '</div>'; ?>
                                <span class="popupactions">
                                    <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg " id='attachment4-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
                                </span>
                            </div>

                            <div style="clear:both;"></div>
                        <?php $i = 4;
                        } else {

                            echo "<div >" . $this->Form->input('att4', array(
                                'type' => 'hidden',
                                'id' => 'att4',
                                'value' => '',
                                'class' => 'form-control',
                            )) . '</div>';
                        } ?>
                        <!-- COMPONENT END -->

                        <?php
                        if (!empty($this->request->data['Car']['attachment5'])) {
                            /*  if ($versionOfApp == 'web') {

                                  $Dir_attachment5 = 'cars';
                                  $id_dialog = 'dialogModalAttachment5Dir';
                                  $id_input = 'attachment5';

                                  ?>
                                  <div id="dialogModalAttachment5Dir">
                                      <!-- the external content is loaded inside this tag -->
                                      <div id="contentWrapAttachment5Dir"></div>
                                  </div>

                                  <?php


                                  echo "<div class='input-button5' id='attachment5'>" . $this->Form->input('attachment5_dir', array(
                                          'label' => __('Attachment 5'),
                                          'readonly' => true,

                                          'class' => 'form-control',


                                      )) . '</div>';

                                  echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open"></i>' . __('Browse', true),
                                          array("controller" => "events", "action" => "openDir", $Dir_attachment5, $id_dialog, $id_input),
                                          array("class" => "btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5 overlayAttachment5Dir", 'escape' => false, "title" => __(""))) . '</div><div style="clear:both;"></div>';
                              }*/
                        ?>


                            <!-- COMPONENT START -->

                            <div id='attachment5-file'>

                                <?php
                                echo "<div style='Display:none;'>" . $this->Form->input('attachment5', array(
                                    'label' => __('Attachment 5'),
                                    'readonly' => true,
                                    'id' => 'attach5',
                                    'type' => 'file',

                                    'class' => 'form-control',


                                )) . '</div>';

                                echo "<div class='input-button4 m-t-5' >" . $this->Form->input('att5', array(
                                    'label' => __('Attachment 5'),
                                    'readonly' => true,
                                    'id' => 'att5',
                                    'value' => $this->request->data['Car']['attachment5'],
                                    'class' => 'form-control',


                                )) . '</div>';
                                $input = 'attachment5';
                                echo "<div class='button-file'>" . $this->Html->link(
                                    '<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),

                                    'javascript:;',
                                    array(
                                        'escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-default w-md m-b-5', 'id' => 'upatt5',
                                    )
                                ) . '</div>'; ?>
                                <span class="popupactions">
                                    <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg " id='attachment5-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
                                </span>
                            </div>

                            <div style="clear:both;"></div>
                        <?php $i = 5;
                        } else {

                            echo "<div >" . $this->Form->input('att5', array(
                                'type' => 'hidden',
                                'id' => 'att5',
                                'value' => '',
                                'class' => 'form-control',
                            )) . '</div>';
                        } ?>
                        <!-- COMPONENT END -->
                        <?php if ($i < 5) {
                            $i++;
                            echo "<div >" . $this->Form->input('nb_attachment', array(
                                'id' => 'nb_attachment', 'type' => 'hidden',
                                'value' => $i,
                                'class' => 'form-control',
                            )) . '</div>';

                        ?>
                            <table id='dynamic_field_att' class="table-input">
                                <tr>
                                    <td class="td-input">
                                        <?php


                                        ?>

                                        <div id="attachment1-file">
                                            <div class="input-button4 m-t-5">
                                                <div class="input file">
                                                    <label for="att1"></label>
                                                    <input id="att1" class="form-control " name="data[Car][attachment][]" type="file" />
                                                </div>
                                            </div>

                                            <span class="popupactions popupactions-attachment popupactions-picture ">
                                                <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 h-bn btn-marg " id='attachment1-btn' type="button" onclick="delete_file('attachment1');"><i class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
                                            </span>
                                        </div>

                                    </td>
                                    <td class="td_tab">
                                        <button style="margin-left: 40px;" type='button' name='add' id='add_att' onclick="addMoreAttachments();" class='btn btn-success'><?= __('Add more') ?></button>
                                    </td>
                                </tr>
                            </table>


                        <?php } ?>
                        <div style='clear:both; padding-top: 10px;'></div>

                    </div>


                </div>
            </div>
            <?php if ($versionOfApp == 'web') { ?>
                <div class='progress-div' id="progress-div">
                    <div class='progress-bar1' id="progress-bar">
                        <div id="progress-status1">0 %</div>
                    </div>
                </div>
            <?php } ?>
            <div class="box-footer">
                <?php
                if ($versionOfApp == 'web') {
                    echo $this->Form->submit(__('Submit'), array(
                        'name' => 'ok',
                        'id' => 'ok',
                        'class' => 'btn btn-primary btn-bordred  m-b-5',
                        'label' => __('Submit'),
                        //'type' => 'submit',
                        'onclick' => 'javascript:submitForm();',

                        'div' => false
                    ));
                } else {
                    echo $this->Form->submit(__('Submit'), array(
                        'name' => 'ok',
                        'id' => 'ok',
                        'class' => 'btn btn-primary btn-bordred  m-b-5',
                        'label' => __('Submit'),
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
</div>


<?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('plugins/colorpicker/js/colorpicker'); ?>
<?= $this->Html->script('plugins/colorpicker/js/layout.js?ver=1.0.2'); ?>
<?= $this->Html->script('plugins/colorpicker/js/eye'); ?>
<?= $this->Html->script('plugins/colorpicker/js/utils'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('jquery-2.1.1.min.js'); ?>
<?= $this->Html->script('jquery.form.min.js'); ?>
<script type="text/javascript">
    $(document).ready(function() {

        jQuery('#colorSelector').ColorPicker({
            color: '#0000ff',
            onShow: function(colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function(colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function(hsb, hex, rgb) {
                $('#colorSelector div').css('backgroundColor', '#' + hex);
                $('#color').val('#' + hex);
            }

        });


        jQuery('#supplier_offshore').parent('.input.select').addClass('required');
        jQuery("#circulationdate").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        });
        jQuery("#approvaldate").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        });
        jQuery("#purchase_date").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        });
        jQuery("#credit_date").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        });
        jQuery("#reception_date").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        });
        jQuery("#planned_end_date").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        });
        jQuery("#real_end_date").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        });
        jQuery("#status_date").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        });

        jQuery('#status').change(function() {
            jQuery("#status_date").parent().parent().attr('class', 'input text required');
            jQuery("#status_date").attr('required', true);
        });
        for (i = 0; i <= jQuery("#nb_payment").val(); i++) {
            jQuery("#receipt_date" + '' + i + '').inputmask("dd/mm/yyyy", {
                "placeholder": "dd/mm/yyyy"
            });
        }
        for (i = 0; i <= jQuery("#nb_leasing").val(); i++) {
            jQuery("#reception_date" + '' + i + '').inputmask("dd/mm/yyyy", {
                "placeholder": "dd/mm/yyyy"
            });
            jQuery("#end_date" + '' + i + '').inputmask("dd/mm/yyyy", {
                "placeholder": "dd/mm/yyyy"
            });
            jQuery("#end_real_date" + '' + i + '').inputmask("dd/mm/yyyy", {
                "placeholder": "dd/mm/yyyy"
            });
        }

        if (jQuery('#fuel_gpl').is(':checked')) {

            jQuery('#gpl').css("display", "block");
        } else {

            jQuery('#gpl').css("display", "none");
        }

        jQuery('#fuel_gpl').on('ifClicked', function(event) {

            if (jQuery('#fuel_gpl').prop('checked')) {

                jQuery('#gpl').css("display", "none");
            } else {
                jQuery('#gpl').css("display", "block");
            }

        });

        jQuery('#car_type').change(function() {
            if (jQuery('#car_type').val() == 24 || jQuery('#car_type').val() == 27) {
                jQuery('.div-capacity').css("display", "block");
            } else {
                jQuery('.div-capacity').css("display", "none");
                jQuery('#capacity1').val('');
                jQuery('#capacity2').val('');
                jQuery('#capacity3').val('');
                jQuery('#capacity4').val('');


            }
        })
        if (jQuery('#acquisition').val() > 0) {

            if (jQuery('#acquisition').val() == 2 || jQuery('#acquisition').val() == 3) {
                jQuery('#interval_location').css("display", "block");
                jQuery('#purchase_date').val('');
                jQuery('#purchasing_price').val('');
                jQuery('#current_price').val('');
                jQuery('#interval_achat_leasing').css("display", "none");

                jQuery('#interval_leasing_location').css("display", "block");
                jQuery('#credit_date').val('');
                jQuery('#credit_duration').val('');
                jQuery('#interval_leasing').css("display", "none");
                jQuery("label[for='CarNumContract']").text("Numéro de contrat");
                jQuery('#num_cont').css("display", "block");
            }
            if (jQuery('#acquisition').val() == 1) {
                jQuery('#interval_achat_leasing').css("display", "block");
                jQuery('#planned_end_date').val('');
                jQuery('#real_end_date').val('');
                jQuery('#interval_location').css("display", "none");
                jQuery('#credit_date').val('');
                jQuery('#credit_duration').val('');
                jQuery('#interval_leasing').css("display", "none");
                jQuery('#monthly_payment').val('');
                jQuery('#interval_leasing_location').css("display", "none");
                jQuery("label[for='CarNumContract']").text("Numéro de facture");
                jQuery('#num_cont').css("display", "block");
            }
            if (jQuery('#acquisition').val() == 4) {
                jQuery('#interval_leasing').css("display", "block");
                jQuery('#interval_achat_leasing').css("display", "block");
                jQuery('#planned_end_date').val('');
                jQuery('#real_end_date').val('');
                jQuery('#interval_location').css("display", "none");
                jQuery("label[for='CarNumContract']").text("Numéro de contrat");
                jQuery('#num_cont').css("display", "block");
                jQuery('#interval_leasing_location').css("display", "block");
            }


        } else {
            jQuery('#credit_date').val('');
            jQuery('#credit_duration').val('');
            jQuery('#interval_leasing').css("display", "none");
            jQuery('#purchase_date').val('');
            jQuery('#purchasing_price').val('');
            jQuery('#current_price').val('');
            jQuery('#interval_achat_leasing').css("display", "none");
            jQuery('#planned_end_date').val('');
            jQuery('#real_end_date').val('');
            jQuery('#interval_location').css("display", "none");
            jQuery('#num_contract').val('');
            jQuery('#reception_date').val('');
            jQuery('#num_cont').css("display", "none");
            jQuery('#monthly_payment').val('');
            jQuery('#interval_leasing_location').css("display", "none");

        }


        jQuery('#acquisition').change(function() {
            if (jQuery('#acquisition').val() == 2 || jQuery('#acquisition').val() == 3) {
                jQuery('#interval_location').css("display", "block");
                jQuery('#purchase_date').val('');
                jQuery('#purchasing_price').val('');
                jQuery('#current_price').val('');
                jQuery('#interval_achat_leasing').css("display", "none");

                jQuery('#interval_leasing_location').css("display", "block");
                jQuery('#credit_date').val('');
                jQuery('#credit_duration').val('');
                jQuery('#interval_leasing').css("display", "none");
                jQuery("label[for='num_contract']").text("Numéro de contrat");
                jQuery("#num_contract").attr("placeholder", "Entrer le numéro du contrat");
                jQuery('#num_cont').css("display", "block");
            }
            if (jQuery('#acquisition').val() == 1) {
                jQuery('#interval_achat_leasing').css("display", "block");
                jQuery('#planned_end_date').val('');
                jQuery('#real_end_date').val('');
                jQuery('#interval_location').css("display", "none");
                jQuery('#credit_date').val('');
                jQuery('#credit_duration').val('');
                jQuery('#interval_leasing').css("display", "none");
                jQuery('#monthly_payment').val('');
                jQuery('#interval_leasing_location').css("display", "none");
                jQuery("label[for='num_contract']").text("Numéro de facture");
                jQuery("#num_contract").attr("placeholder", "Entrer le numéro de la facture");
                jQuery('#num_cont').css("display", "block");
            }
            if (jQuery('#acquisition').val() == 4) {
                jQuery('#interval_leasing').css("display", "block");
                jQuery('#interval_achat_leasing').css("display", "block");
                jQuery('#planned_end_date').val('');
                jQuery('#real_end_date').val('');
                jQuery('#interval_location').css("display", "none");
                jQuery("label[for='num_contract']").text("Numéro de contrat");
                jQuery("#num_contract").attr("placeholder", "Entrer le numéro du contrat");
                jQuery('#num_cont').css("display", "block");
                jQuery('#interval_leasing_location').css("display", "block");
            }
        });


        $("#upfile1").click(function() {
            $("#picture1").trigger('click');
        });

        $("#picture1").change(function() {

            $("#file1").val($("#picture1").val());

        });

        $("#upfile2").click(function() {
            $("#picture2").trigger('click');

        });

        $("#picture2").change(function() {

            $("#file2").val($("#picture2").val());

        });

        $("#upfile3").click(function() {
            $("#picture3").trigger('click');

        });

        $("#picture3").change(function() {

            $("#file3").val($("#picture3").val());

        });

        $("#upfile4").click(function() {
            $("#picture4").trigger('click');

        });

        $("#picture4").change(function() {

            $("#file4").val($("#picture4").val());

        });


        $("#upatt1").click(function() {

            $("#attach1").trigger('click');
        });

        $("#attach1").change(function() {

            $("#att1").val($("#attach1").val());

        });

        $("#upatt2").click(function() {
            $("#attach2").trigger('click');
        });

        $("#attach2").change(function() {

            $("#att2").val($("#attach2").val());

        });

        $("#upatt3").click(function() {
            $("#attach3").trigger('click');
        });

        $("#attach3").change(function() {

            $("#att3").val($("#attach3").val());

        });

        $("#upatt4").click(function() {
            $("#attach4").trigger('click');
        });

        $("#attach4").change(function() {

            $("#att4").val($("#attach4").val());

        });

        $("#upatt5").click(function() {
            $("#attach5").trigger('click');
        });

        $("#attach5").change(function() {

            $("#att5").val($("#attach5").val());

        });

        $("#upfile_grey").click(function() {
            $("#grey_card").trigger('click');

        });

        $("#grey_card").change(function() {

            $("#file_grey").val($("#grey_card").val());

        });

        $("#upfile_yellow").click(function() {
            $("#yellow_card").trigger('click');

        });

        $("#yellow_card").change(function() {

            $("#file_yellow").val($("#yellow_card").val());

        });


        $("#uppurchasing").click(function() {
            $("#purchasing_attachment").trigger('click');

        });

        $("#purchasing_attachment").change(function() {

            $("#purchasing").val($("#purchasing_attachment").val());

        });

        jQuery('#mark').change(function() {
            if (jQuery(this).val() > 0) {
                jQuery('.overlayModel').attr("href", "<?php echo $this->Html->url('/cars/addModel/') ?>" + jQuery(this).val());
                jQuery('#popupactionsModel').css("display", "block");
            } else {
                jQuery('.overlayModel').attr("href", "<?php echo $this->Html->url('/cars/addModel/') ?>");
                jQuery('#popupactionsModel').css("display", "none");
            }
            jQuery('#model').load('<?php echo $this->Html->url('/cars/getModels/') ?>' + jQuery(this).val(), function() {
                jQuery('#CarCarmodelId').select2();
            });
        });


        if (jQuery('#mark').val() > 0) {

            jQuery('.overlayModel').attr("href", "<?php echo $this->Html->url('/cars/addModel/') ?>" + jQuery('#mark').val());
            jQuery('#popupactionsModel').css("display", "block");
        } else {
            jQuery('.overlayModel').attr("href", "<?php echo $this->Html->url('/cars/addModel/') ?>");
            jQuery('#popupactionsModel').css("display", "none");
        }

        jQuery("#dialogModal").dialog({
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
        jQuery(".overlay").click(function(event) {
            event.preventDefault();
            jQuery('#contentWrap').load(jQuery(this).attr("href")); //load content from href of link
            jQuery('#dialogModal').dialog('option', 'title', jQuery(this).attr("title")); //make dialog title that of link
            jQuery('#dialogModal').dialog('open'); //open the dialog
        });

        jQuery("#dialogModalModel").dialog({
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
        jQuery(".overlayModel").click(function(event) {
            event.preventDefault();
            jQuery('#contentWrapModel').load(jQuery(this).attr("href")); //load content from href of link
            jQuery('#dialogModalModel').dialog('option', 'title', jQuery(this).attr("title")); //make dialog title that of link
            jQuery('#dialogModalModel').dialog('open'); //open the dialog
        });

        jQuery("#dialogModalCategory").dialog({
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
        jQuery(".overlayCategory").click(function(event) {
            event.preventDefault();
            jQuery('#contentWrapCategory').load(jQuery(this).attr("href"));
            jQuery('#dialogModalCategory').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalCategory').dialog('open');
        });


        jQuery('#category').change(function() {
            if (jQuery(this).val() > 0) {
                jQuery('.overlayType').attr("href", "<?php echo $this->Html->url('/cars/addType/') ?>" + jQuery(this).val());
                jQuery('#popupactionsType').css("display", "block");
            } else {
                jQuery('.overlayType').attr("href", "<?php echo $this->Html->url('/cars/addType/') ?>");
                jQuery('#popupactionsType').css("display", "none");
            }

            jQuery('#cartypes').load('<?php echo $this->Html->url('/cars/getTypesByCategory/') ?>' + jQuery(this).val(), function() {
                jQuery('.select-type').select2();
            });
        });
        jQuery("#dialogModalGroup").dialog({
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
        jQuery(".overlayGroup").click(function(event) {
            event.preventDefault();
            jQuery('#contentWrapGroup').load(jQuery(this).attr("href"));
            jQuery('#dialogModalGroup').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalGroup').dialog('open');
        });
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
        jQuery(".overlayType").click(function(event) {
            event.preventDefault();
            jQuery('#contentWrapType').load(jQuery(this).attr("href"));
            jQuery('#dialogModalType').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalType').dialog('open');
        });

        jQuery("#dialogModalFuel").dialog({
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
        jQuery(".overlayFuel").click(function(event) {
            event.preventDefault();
            jQuery('#contentWrapFuel').load(jQuery(this).attr("href"));
            jQuery('#dialogModalFuel').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalFuel').dialog('open');
        });
        jQuery("#dialogModalParc").dialog({
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
        jQuery(".overlayParc").click(function(event) {
            event.preventDefault();
            jQuery('#contentWrapParc').load(jQuery(this).attr("href"));
            jQuery('#dialogModalParc').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalParc').dialog('open');
        });
        jQuery("#dialogModalSupplier").dialog({
            autoOpen: false,
            height: 480,
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


        jQuery(".overlaySupplier").click(function(event) {
            event.preventDefault();
            jQuery('#contentWrapSupplier').load(jQuery(this).attr("href"));
            jQuery('#dialogModalSupplier').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalSupplier').dialog('open');
        });
        jQuery(".my-colorpicker").colorpicker();

        jQuery("#dialogModalAcquisition").dialog({
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
        jQuery(".overlayAcquisition").click(function(event) {
            event.preventDefault();
            jQuery('#contentWrapAcquisition').load(jQuery(this).attr("href"));
            jQuery('#dialogModalAcquisition').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalAcquisition').dialog('open');
        });


        jQuery("#dialogModalDir").dialog({
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
        jQuery(".overlayDir").click(function(event) {
            event.preventDefault();
            jQuery('#contentWrapDir').load(jQuery(this).attr("href"));
            //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalDir').dialog('open');
        });


        jQuery("#dialogModalDirGrey").dialog({
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
        jQuery(".overlayDirGrey").click(function(event) {
            event.preventDefault();
            jQuery('#contentWrapDirGrey').load(jQuery(this).attr("href"));
            //jQuery('#dialogModalDirGrey').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalDirGrey').dialog('open');
        });

        Array.prototype.inArray = function(value) {
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


        var i = parseInt($('#nb_picture').val()) + 1;

        $('#add').click(function() {

            if (i < 5) {
                $('#dynamic_field').append('<tr id="row' + i + '"><td class="td-input"><div   id="picture' + i + '-file" ><div class="form-group input-button3"><div class="input file"><label for ="pic' + i + '"></label><input id="pic' + i + '" class="form-control" name="data[Car][picture][]" onchange="javascript:verif_ext_attachment(1,this.id)" type="file"/></div></div><span class="popupactions"><button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg"  id="picture' + i + '-btn" type="button" onclick="delete_file(\'picture' + i + '\');"><i class="fa fa-repeat m-r-5"></i><?php echo __('Empty') ?></button></span></div></td><td class="td_tab"><button style="margin-left: 40px;" name="remove" id="' + i + '" onclick="remove(\'' + i + '\');"class="btn btn-danger btn_remove">X</button></td></tr>');
                $('#nb_picture').val(i);
                if (i == 4) $('#add').attr('disabled', true);
            }
            i++;


        });

        jQuery('#vidange_hour').on('ifClicked', function(event) {

            if (jQuery('#vidange_hour').prop('checked')) {
                jQuery("label[for='min_consumption']").text("<?php echo __('Min consumption') . " " . "(L/100Km)" ?>");
                jQuery("#min_consumption").attr("placeholder", "<?php echo __('Enter min consumption (L/100Km)') ?>");

                jQuery("label[for='max_consumption']").text("<?php echo __('Max consumption') . " " . "(L/100Km)" ?>");
                jQuery("#max_consumption").attr("placeholder", "<?php echo __('Enter max consumption (L/100Km)') ?>");

                jQuery("label[for='limit_consumption']").text("<?php echo __('Limit consumption') . " " . "(Km)" ?>");
                jQuery("#limit_consumption").attr("placeholder", "<?php echo __('Enter limit consumption (Km)') ?>");

            } else {
                jQuery("label[for='min_consumption']").text("<?php echo __('Min consumption') . " " . "(L/100H)" ?>");
                jQuery("#min_consumption").attr("placeholder", "<?php echo __('Enter min consumption (L/100H)') ?>");

                jQuery("label[for='max_consumption']").text("<?php echo __('Max consumption') . " " . "(L/100H)" ?>");
                jQuery("#max_consumption").attr("placeholder", "<?php echo __('Enter max consumption (L/100H)') ?>");

                jQuery("label[for='limit_consumption']").text("<?php echo __('Limit consumption') . " " . "(H)" ?>");
                jQuery("#limit_consumption").attr("placeholder", "<?php echo __('Enter limit consumption (H)') ?>");
            }

        });

        if (jQuery('#vidange_hour').is(':checked')) {

            jQuery("label[for='min_consumption']").text("<?php echo __('Min consumption') . " " . "(L/100H)" ?>");
            jQuery("#min_consumption").attr("placeholder", "<?php echo __('Enter min consumption (L/100H)') ?>");

            jQuery("label[for='max_consumption']").text("<?php echo __('Max consumption') . " " . "(L/100H)" ?>");
            jQuery("#max_consumption").attr("placeholder", "<?php echo __('Enter max consumption (L/100H)') ?>");

            jQuery("label[for='limit_consumption']").text("<?php echo __('Limit consumption') . " " . "(H)" ?>");
            jQuery("#limit_consumption").attr("placeholder", "<?php echo __('Enter limit consumption (H)') ?>");


        } else {

            jQuery("label[for='min_consumption']").text("<?php echo __('Min consumption') . " " . "(L/100Km)" ?>");
            jQuery("#min_consumption").attr("placeholder", "<?php echo __('Enter min consumption (L/100Km)') ?>");

            jQuery("label[for='max_consumption']").text("<?php echo __('Max consumption') . " " . "(L/100Km)" ?>");
            jQuery("#max_consumption").attr("placeholder", "<?php echo __('Enter max consumption (L/100Km)') ?>");

            jQuery("label[for='limit_consumption']").text("<?php echo __('Limit consumption') . " " . "(Km)" ?>");
            jQuery("#limit_consumption").attr("placeholder", "<?php echo __('Enter limit consumption (Km)') ?>");


        }
    });


    function delete_file(id) {
        //alert(id);

        $("#" + '' + id + '' + "-file").before(
            function() {
                if (!$(this).prev().hasClass('input-ghost')) {
                    var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                    element.attr("name", $(this).attr("name"));
                    element.change(function() {
                        element.next(element).find('input').val((element.val()).split('\\').pop());
                    });

                    $(this).find("#" + '' + id + '' + "-btn").click(function() {
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


    function verif_ext_attachment(img, id) {

        pic1 = jQuery('#' + id).val();
        pic1 = pic1.split('.');

        if (img == 1) {

            var typeArr = ['jpg', 'jpeg', 'gif', 'png', 'pdf'];
            //use of inArray
            if (!typeArr.inArray(pic1[1])) {
                msg = '<?php echo __('Only gif, png, jpg and jpeg images are allowed!') ?>';
                alert(msg);
                jQuery('#' + id).val('');
            }
        }
    }

    function submitForm() {

        $('#CarEditForm').submit(function(e) {


            e.preventDefault();

            $(this).ajaxSubmit({

                beforeSubmit: function() {

                    $("#progress-bar").width('0%');

                },

                uploadProgress: function(event, position, total, percentComplete) {
                    $("#progress-bar").width(percentComplete + '%');
                    $("#progress-bar").html('<div id="progress-status">' + percentComplete + ' %</div>');

                },

                success: function() {

                    window.location = '<?php echo $this->Html->url('/cars') ?>';
                },
                resetForm: true
            });
            return false;


        });
    };

    function addPayment() {

        var nb_payment = parseFloat(jQuery('#nb_payment').val()) + 1;
        var nb = nb_payment + 1;

        jQuery('#nb_payment').val(nb_payment);

        jQuery("#payment").append("<div class='panel panel-default'><div class='panel-heading'><h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion' href='#payment" + nb_payment + "'><?php echo __('Payment ') ?> " + nb + " </a></h4></div>");
        jQuery("#payment").append("<div id='payment" + nb_payment + "' class='panel-collapse collapse'></div>");


        jQuery("#payment" + '' + nb_payment + '').load('<?php echo $this->Html->url('/cars/addPayment/') ?>' + nb_payment, function() {
            jQuery("#receipt_date" + '' + nb_payment + '').inputmask("dd/mm/yyyy", {
                "placeholder": "dd/mm/yyyy"
            });
            jQuery(".date").datetimepicker({

                format: 'DD/MM/YYYY',
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }


            });
            $('.date').click(function() {
                var popup = $(this).offset();
                var popupTop = popup.left;
                $('.bootstrap-datetimepicker-widget').css({
                    'bottom': 10,
                    'left': 10,
                    'height': 250
                });
            });

        });


    }

    function addLeasing() {

        var nb_leasing = parseFloat(jQuery('#nb_leasing').val()) + 1;

        var nb = nb_leasing;

        jQuery('#nb_leasing').val(nb_leasing);

        jQuery("#leasing").append("<div class='panel panel-default'><div class='panel-heading'><h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion' href='#leasing" + nb_leasing + "'><?php echo __('Leasing') ?> " + nb + " </a></h4></div>");
        jQuery("#leasing").append("<div id='leasing" + nb_leasing + "' class='panel-collapse collapse'></div>");


        jQuery("#leasing" + '' + nb_leasing + '').load('<?php echo $this->Html->url('/cars/addLeasing/') ?>' + nb_leasing, function() {
            jQuery("#reception_date" + '' + nb_leasing + '').inputmask("dd/mm/yyyy", {
                "placeholder": "dd/mm/yyyy"
            });
            jQuery("#end_date" + '' + nb_leasing + '').inputmask("dd/mm/yyyy", {
                "placeholder": "dd/mm/yyyy"
            });
            jQuery("#end_real_date" + '' + nb_leasing + '').inputmask("dd/mm/yyyy", {
                "placeholder": "dd/mm/yyyy"
            });
            jQuery(".date").datetimepicker({

                format: 'DD/MM/YYYY',
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }


            });
            $('.date').click(function() {
                var popup = $(this).offset();
                var popupTop = popup.left;
                $('.bootstrap-datetimepicker-widget').css({
                    'left': popupTop + 10
                });
            });
            jQuery("#dialogModalSupplier").dialog({
                autoOpen: false,
                height: 480,
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


            jQuery(".overlaySupplier").click(function(event) {
                event.preventDefault();
                jQuery('#contentWrapSupplier').load(jQuery(this).attr("href"));
                jQuery('#dialogModalSupplier').dialog('option', 'title', jQuery(this).attr("title"));
                jQuery('#dialogModalSupplier').dialog('open');
            });

        });


    }

    function showBtLeasing() {

        jQuery('#bt_leasing').css("display", "block");
    }

    function remove(id) {


        $('#row' + id + '').remove();
        i--;
        $('#add').css('display', 'block');

    };

    function nameChamps(id) {
        var nb = id.substring(id.length - 1, id.length);
        if (jQuery("#acquisition_leasing" + '' + nb + '').val() == 2) {

            jQuery("label[for='amont_month" + nb + "']").text("Paiment journalier");
            jQuery("#amont_month" + '' + nb + '').attr("placeholder", "Entrer paiement journalier");
            jQuery("label[for='km_year" + nb + "']").text("Km journalier");
            jQuery("#km_year" + '' + nb + '').attr("placeholder", "Entrer km journalier");


        } else {
            jQuery("label[for='amont_month" + nb + "']").text("Paiment mensuel");
            jQuery("#amont_month" + '' + nb + '').attr("placeholder", "Entrer paiement mensuel");
            jQuery("label[for='km_year" + nb + "']").text("Km annuel");
            jQuery("#km_year" + '' + nb + '').attr("placeholder", "Entrer km annuel");


        }

    }

    function champsRequired() {
        var nb_leasing = parseFloat(jQuery('#nb_leasing').val());

        jQuery("#reception_date" + '' + nb_leasing + '').parent().parent().attr('class', 'input text required');
        jQuery("#reception_date" + '' + nb_leasing + '').attr('required', true);
        //jQuery("#end_date"+''+nb_leasing+'').parent().parent().attr('class', 'input text required');
        //jQuery("#end_date"+''+nb_leasing+'').attr('required',true);
        jQuery("#reception_km" + '' + nb_leasing + '').parent().attr('class', 'input number required');
        jQuery("#reception_km" + '' + nb_leasing + '').attr('required', true);
        jQuery("#cost_km" + '' + nb_leasing + '').parent().attr('class', 'input number required');
        jQuery("#cost_km" + '' + nb_leasing + '').attr('required', true);
        jQuery("#amont_month" + '' + nb_leasing + '').parent().attr('class', 'input number required');
        jQuery("#amont_month" + '' + nb_leasing + '').attr('required', true);
        jQuery("#km_year" + '' + nb_leasing + '').parent().attr('class', 'input number required');
        jQuery("#km_year" + '' + nb_leasing + '').attr('required', true);
    }

    function addMoreAttachments() {
        var i = parseInt($('#nb_attachment').val()) + 1;

        if (i < 6) {
            $('#dynamic_field_att').append('<tr id="row' + i + '"><td><?php  /*if($versionOfApp == 'web') { ?><div class="input-button5" id="attachment' + i + '"><div class="input text"><label for="attachment' + i + '_dir"></label><input id="attachment' + i + '_dir" class="form-control" name="data[Car][attachment_dir][]" readonly="readonly" type="text"/ style="margin-top: 5px;"></div></div><div class="button-file"><a class="btn btn-default btn-trans waves-effect waves-primary w-md m-b-5 h-bn overlayAttachment' + i + 'Dir" onclick="open_popup(\'cars\',\'dialogModalAttachment' + i + 'Dir\',\'attachment' + i + '\');"><i class="fa fa-folder-open m-r-5"></i><?php echo __('Select'); ?></a></div><div style="clear:both;"></div><?php } */ ?><div id="attachment' + i + '-file" ><div class="form-group input-button3"><div class="input file"><label for ="att' + i + '"></label><input id="att' + i + '" class="form-control filestyle" name="data[Car][attachment][]"  type="file"/></div></div><span class="popupactions"><button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg"  id="attachment' + i + '-btn" type="button" onclick="delete_file(\'attachment' + i + '\');"><i class="fa fa-repeat m-r-5"></i><?php echo __('Empty') ?></button></span></div></td><td ><button style="margin-left: 40px;" name="remove" id="' + i + '" onclick="remove(\'' + i + '\');"class="btn btn-danger btn_remove">X</button> </td></tr>');

            if (i == 5) {
                $('#add').attr('disabled', true);
            }
        }
        i++;

    }

    function getArchivedDate() {
        var status = jQuery('#status').val();
        if (status == 27) {

            jQuery('#archived-date-div').css('display', 'block');
        } else {
            jQuery('#archived-date-div').css('display', 'none');
        }
    }

    function verifyCode() {

        var link = '<?php echo $this->Html->url('/cars/verifyCode/') ?>';
        var code = jQuery('#code').val();
        jQuery.ajax({
            type: "POST",
            url: link,
            data: {
                code: code
            },
            dataType: "json",
            success: function(json) {
                if (json.response === true) {

                    var immatrDef = json.immatrDef;
                    var initialKm = json.initialKm;
                    jQuery('#CarImmatrDef').val(immatrDef);
                    jQuery('#CarKmInitial').val(initialKm);

                }
            }
        });
    }

</script>

<?php $this->end(); ?>