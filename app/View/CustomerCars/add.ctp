<style>
    .audiv5 > div > label {
        margin-left: -15px;
        font-weight: bold;
        float: left;
        width: 360px;
        display: inline-block;
    }
</style>
<?php
include("ctp/datetime.ctp");


?><h4 class="page-title"> <?= __('Add') . " " . lcfirst(__('Affectation')); ?></h4>
<?php
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
echo $this->Html->css('bootstrap-datetimepicker.min.css');
$this->end();
if (empty($cars)) {
    ?>
    <div id="flashMessage" class="message">
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?= __('All cars are reserved.') ?>
        </div>
    </div>
<?php
}
?>
<div class="box">
    <div class="edit form card-box p-b-0">

        <?php echo $this->Form->create('CustomerCar', array(
            'url' => array(
                'action' => 'add'
            ),
            'enctype' => 'multipart/form-data',
            'onsubmit' => 'javascript:disable();'
        )); ?>
        <div class="box-body">
            <div class="nav-tabs-custom pdg_btm">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                    <li><a href="#tab_2" data-toggle="tab"><?= __('Departure') ?></a></li>
                    <li><a href="#tab_3" data-toggle="tab"><?= __('Arrival') ?></a></li>

                    <li><a href="#tab_5" data-toggle="tab"><?= __('Etat véhicule') ?></a></li>
                    <li><a href="#tab_6" data-toggle="tab"><?= __('Passation de consigne') ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <?php
                        if ($reference != '0') {
                            echo "<div class='form-group'>" . $this->Form->input('reference', array(
                                    'label' => __('Reference'),
                                    'class' => 'form-control',
                                    'value' => $reference,
                                    'readonly' => true,
                                    'placeholder' => __('Enter reference'),
                                )) . "</div>";
                        } else {
                            echo "<div class='form-group'>" . $this->Form->input('reference', array(
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
                        echo "<div class='form-group'>" . $this->Form->input('car_id', array(
                                'label' => __('Car'),
                                'class' => 'form-control select2',
                                'id' => 'cars',
                                'onchange' => 'javascript:verifyDriverLicenseCategory(this);',
                                'empty' => ''
                            )) . "</div>";

                        echo "<div class='form-group'>" . $this->Form->input('remorque_id', array(
                                'label' => __('Remorque'),
                                'class' => 'form-control select2',
                                'options' => $remorques,
                                'id' => 'remorques',
                                'empty' => ''
                            )) . "</div>"; ?>
                        <div class='form-group'>
                            <div class="input select required">
                                <label for="conductorGroup"><?= __(__("Conductor") . __('-Group')) ?></label>
                                <select name="data[CustomerCar][conductor_group]" class="form-control"
                                        id="conductorGroup" required="true" onchange="getConductorsOrGroups();">
                                    <option value="1"><?= __('Select ') . " " . __("Conductor") ?></option>
                                    <option value="2"><?= __('Select group') ?></option>
                                </select>
                            </div>
                        </div>
                        <?php echo "<div id='interval1'></div>";/* echo "<div id='interval1'><div class='form-group'>" . $this->Form->input('customer_id', array(
                    'label' => __("Conductor"),
                    'class' => 'form-control select2',
					'id'=>'customer',
                    'onchange' =>'javascript:VerifyDriverLicenseCategory(this);',
                    'empty' => ''
                )) . "</div></div>";

           echo "<div id='interval2'> <div class='form-group' id='groups'>" . $this->Form->input('customer_group_id', array(
                    'label' => __('Group'),
                    'class' => 'form-control select2',
                    'empty' => ''
                )) . "</div></div>";*/

                        echo "<div class='form-group input-button' id='zones'>" . $this->Form->input('zone_id', array(
                                'label' => __('Zone'),
                                'class' => 'form-control select2',
                                'empty' => '',
                                'id' => 'zone',
                            )) . "</div>";
                        ?>
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

                        if ($affectation_mode == 1) {
                            echo "<div class='form-group'>" . $this->Form->input('accompanist', array(
                                    'label' => __('Accompanist'),
                                    'placeholder' => __('Enter accompanist'),
                                    'class' => 'form-control',
                                )) . "</div>";
                        }


                        echo "<div class='form-group'>" . $this->Form->input('options', array(
                                'label' => __('Options'),
                                'placeholder' => __('Enter options'),
                                'class' => 'form-control',
                                'type' => 'select',
                                'multiple' => true,
                                'id' => 'option',
                                'empty' => true,
                            )) . "</div>";





                        if ($affectation_mode == 1) {
                            echo "<div class='form-group' >" . $this->Form->input('date_payment', array(
                                    'label' => false,
                                    'placeholder' => 'dd/mm/yyyy hh:mm',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label>' . __('Payment date') . '</label><div class="input-group datetime"><label for="PaymentDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'paymentdate',
                                )) . "</div>";

                        }
                        ?>
                        <div style="clear:both"></div>
                        <?php
                        echo "<div class='form-group audiv5'>" . $this->Form->input('authorized', array(
                                'label' => __('Allowed the conductor to take the car outside working hours'),
                                'id' => 'authorized',
                                'type' => "checkbox",
                                'checked' => false,
                            )) . "</div>";?>
                        <div style="clear:both"></div>
                        <br/>
                        <?php
                        $date = date("Y-m-d");
                        $date = date($date . ' 08:00'); ?>




                        <?php

                        echo "<div style ='font-weight: bold;'>" . __('Authorization date') . "</div>";
                        echo "<div class='form-group' >" . $this->Form->input('Autorisation.authorization_from', array(
                                'label' => false,
                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('From date') . '</label>
                    <div class="input-group datetime"><label for="AuthorizationFrom"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'value' => $this->Time->format($date, '%d/%m/%Y %H:%M'),
                                'id' => 'authorization_from',
                                'allowEmpty' => true,

                            )) . "</div>";
                        $date = date("Y-m-d");
                        $date = date($date . ' 23:59');
                        echo "<div class='form-group'>" . $this->Form->input('Autorisation.authorization_to', array(
                                'label' => false,
                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('to date') . '</label><div class="input-group datetime"><label for="AuthorizationTo"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'authorization_to',
                                'value' => $this->Time->format($date, '%d/%m/%Y %H:%M'),
                                'allowEmpty' => true,
                            )) . "</div>";


                        echo "<div class='form-group'>" . $this->Form->input('obs', array(
                                'label' => __('Observation'),
                                'placeholder' => __('Enter observation'),
                                'class' => 'form-control',
                                'empty' => ''
                            )) . "</div>";
                        ?>
                    </div>

                    <div class="tab-pane" id="tab_2">
                        <?php  echo "<div class='form-group'>" . $this->Form->input('departure_location', array(
                                'label' => __('Departure location'),
                                'placeholder' => __('Enter departure location'),
                                'class' => 'form-control',
                                'empty' => ''
                            )) . "</div>";


                        echo "<div class='form-group'>" . $this->Form->input('start', array(
                                'label' => false,
                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Departure date') . '</label><div class="input-group datetime">
                    <label for="StartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'start_date',
                                'allowEmpty' => true,
                            )) . "</div>";

                        echo "<div class='form-group'>" . $this->Form->input('km', array(
                                'label' => __('Starting Km'),
                                'placeholder' => __('Enter starting Km'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('initiale_state', array(
                                'label' => __('Initiale state'),
                                'placeholder' => __('Enter initiale state'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo '<div class="lbl3">' . __("Add initiale state pictures") . '</div>'; ?>

                        <div>
                            <?php

                            if ($version_of_app == 'web') {
                                $Dir_pictureinit1 = 'initialetat';
                                $id_dialog = 'dialogModalPictureinit1Dir';
                                $id_input = 'pictureinit1';

                                ?>
                                <div id="dialogModalPictureinit1Dir">
                                    <!-- the external content is loaded inside this tag -->
                                    <div id="contentWrapPictureinit1Dir"></div>
                                </div>

                                <?php


                                echo "<div class='input-button4' id='pictureinit1'>" . $this->Form->input('pictureinit1_dir', array(
                                        'label' => __('Initiale picture 1'),
                                        'readonly' => true,

                                        'class' => 'form-control',


                                    )) . '</div>';

                                echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),
                                        array("controller" => "CustomerCars", "action" => "openDir", $Dir_pictureinit1, $id_dialog, $id_input),
                                        array("class" => "btn btn-default btn-trans waves-effect waves-primary w-md m-b-5 h-bn overlayPictureinit1Dir", 'escape' => false, "title" => __(""))) . '</div><div style="clear:both;"></div>';
                            }
                            ?>


                            <!-- COMPONENT START -->

                            <div id='pictureinit1-file'>

                                <?php      echo "<div class='form-group input-button'>" . $this->Form->input('pictureinit1', array(
                                        'label' => '',
                                        'class' => 'form-control filestyle',
                                        'type' => 'file',
                                        'id' => 'picinit1',
                                        'onchange' => 'javascript:verif_ext_attachment(1,this.id)',
                                        'empty' => ''
                                    )) . "</div>";
                                $input = 'pictureinit1';
                                ?>
                                <span class="popupactions popupactions-c">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "
                         id='pictureinit1-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i
                         class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
            </span>
                            </div>

                            <!-- COMPONENT END -->

                            <?php
                            if ($version_of_app == 'web') {

                                $Dir_pictureinit2 = 'initialetat';
                                $id_dialog = 'dialogModalPictureinit2Dir';
                                $id_input = 'pictureinit2';

                                ?>
                                <div id="dialogModalPictureinit2Dir">
                                    <!-- the external content is loaded inside this tag -->
                                    <div id="contentWrapPictureinit2Dir"></div>
                                </div>

                                <?php


                                echo "<div class='input-button4' id='pictureinit2'>" . $this->Form->input('pictureinit2_dir', array(
                                        'label' => __('Initiale picture 2'),
                                        'readonly' => true,

                                        'class' => 'form-control',


                                    )) . '</div>';

                                echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),
                                        array("controller" => "CustomerCars", "action" => "openDir", $Dir_pictureinit2, $id_dialog, $id_input),
                                        array("class" => "btn btn-default btn-trans waves-effect waves-primary w-md m-b-5 h-bn overlayPictureinit2Dir", 'escape' => false, "title" => __(""))) . '</div><div style="clear:both;"></div>';
                            }
                            ?>







                            <!-- COMPONENT START -->

                            <div id='pictureinit2-file'>

                                <?php      echo "<div class='form-group input-button'>" . $this->Form->input('pictureinit2', array(
                                        'label' => '',
                                        'class' => 'form-control filestyle',
                                        'type' => 'file',
                                        'id' => 'picinit2',
                                        'onchange' => 'javascript:verif_ext_attachment(1,this.id)',
                                        'empty' => ''
                                    )) . "</div>";
                                $input = 'pictureinit2';
                                ?>
                                <span class="popupactions popupactions-c">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "
                         id='pictureinit2-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i
                         class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
            </span>
                            </div>

                            <!-- COMPONENT END -->

                            <?php
                            if ($version_of_app == 'web') {

                                $Dir_pictureinit3 = 'initialetat';
                                $id_dialog = 'dialogModalPictureinit3Dir';
                                $id_input = 'pictureinit3';

                                ?>
                                <div id="dialogModalPictureinit3Dir">
                                    <!-- the external content is loaded inside this tag -->
                                    <div id="contentWrapPictureinit3Dir"></div>
                                </div>

                                <?php


                                echo "<div class='input-button4' id='pictureinit3'>" . $this->Form->input('pictureinit3_dir', array(
                                        'label' => __('Initiale picture 3'),
                                        'readonly' => true,

                                        'class' => 'form-control',


                                    )) . '</div>';

                                echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),
                                        array("controller" => "CustomerCars", "action" => "openDir", $Dir_pictureinit3, $id_dialog, $id_input),
                                        array("class" => "btn btn-default btn-trans waves-effect waves-primary w-md m-b-5 h-bn overlayPictureinit3Dir", 'escape' => false, "title" => __(""))) . '</div><div style="clear:both;"></div>';
                            }
                            ?>




                            <!-- COMPONENT START -->

                            <div id='pictureinit3-file'>

                                <?php      echo "<div class='form-group input-button'>" . $this->Form->input('pictureinit3', array(
                                        'label' => '',
                                        'class' => 'form-control filestyle',
                                        'type' => 'file',
                                        'id' => 'picinit3',
                                        'onchange' => 'javascript:verif_ext_attachment(1,this.id)',
                                        'empty' => ''
                                    )) . "</div>";
                                $input = 'pictureinit3';
                                ?>
                                <span class="popupactions popupactions-c">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "
                         id='pictureinit3-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i
                         class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
            </span>
                            </div>

                            <!-- COMPONENT END -->

                            <?php

                            if ($version_of_app == 'web') {

                                $Dir_pictureinit4 = 'initialetat';
                                $id_dialog = 'dialogModalPictureinit4Dir';
                                $id_input = 'pictureinit4';

                                ?>
                                <div id="dialogModalPictureinit4Dir">
                                    <!-- the external content is loaded inside this tag -->
                                    <div id="contentWrapPictureinit4Dir"></div>
                                </div>

                                <?php


                                echo "<div class='input-button4' id='pictureinit4'>" . $this->Form->input('pictureinit4_dir', array(
                                        'label' => __('Initiale picture 4'),
                                        'readonly' => true,

                                        'class' => 'form-control',


                                    )) . '</div>';

                                echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),
                                        array("controller" => "CustomerCars", "action" => "openDir", $Dir_pictureinit4, $id_dialog, $id_input),
                                        array("class" => "btn btn-default btn-trans waves-effect waves-primary w-md m-b-5 h-bn overlayPictureinit4Dir", 'escape' => false, "title" => __(""))) . '</div><div style="clear:both;"></div>';
                            }
                            ?>









                            <!-- COMPONENT START -->

                            <div id='pictureinit4-file'>

                                <?php      echo "<div class='form-group input-button'>" . $this->Form->input('pictureinit4', array(
                                        'label' => '',
                                        'class' => 'form-control filestyle',
                                        'type' => 'file',
                                        'id' => 'picinit4',
                                        'onchange' => 'javascript:verif_ext_attachment(1,this.id)',
                                        'empty' => ''
                                    )) . "</div>";
                                $input = 'pictureinit4';
                                ?>
                                <span class="popupactions popupactions-c">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "
                         id='pictureinit4-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i
                         class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
            </span>
                            </div>

                            <!-- COMPONENT END -->


                            <div style="clear:both;"></div>


                        </div>
                    </div>
                    <div class="tab-pane" id="tab_3">
                        <?php echo "<div class='form-group'>" . $this->Form->input('return_location', array(
                                'label' => __('Return location'),
                                'placeholder' => __('Enter return location'),
                                'class' => 'form-control',
                                'empty' => ''
                            )) . "</div>";

                        echo "<div class='form-group'>" . $this->Form->input('end', array(
                                'label' => false,
                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Planned Arrival date ') . '</label><div class="input-group datetime"><label for="EndDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'end_date',
                                'allowEmpty' => true,
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('end_real', array(
                                'label' => false,
                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Real Arrival date') . '</label><div class="input-group datetime"><label for="EndDateReal"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'enddatereal',
                            )) . "</div>";

                        echo "<div class='form-group'>" . $this->Form->input('next_km', array(
                                'label' => __('Arrival Km'),
                                'placeholder' => __('Enter arrival Km'),
                                'class' => 'form-control',
                            )) . "</div>";
                        echo "<div class='form-group'>" . $this->Form->input('finale_state', array(
                                'label' => __('Finale state'),
                                'placeholder' => __('Enter finale state'),
                                'class' => 'form-control',
                            )) . "</div>";

                        echo '<div class="lbl3">' . __("Add finale state pictures") . '</div>'; ?>

                        <div>


                            <?php
                            if ($version_of_app == 'web') {
                                $Dir_picturefinal1 = 'finaletat';
                                $id_dialog = 'dialogModalPicturefinal1Dir';
                                $id_input = 'picturefinal1';

                                ?>
                                <div id="dialogModalPicturefinal1Dir">
                                    <!-- the external content is loaded inside this tag -->
                                    <div id="contentWrapPicturefinal1Dir"></div>
                                </div>

                                <?php


                                echo "<div class='input-button4' id='picturefinal1'>" . $this->Form->input('picturefinal1_dir', array(
                                        'label' => __('Final picture 1'),
                                        'readonly' => true,

                                        'class' => 'form-control',


                                    )) . '</div>';

                                echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),
                                        array("controller" => "CustomerCars", "action" => "openDir", $Dir_picturefinal1, $id_dialog, $id_input),
                                        array("class" => "btn btn-default btn-trans waves-effect waves-primary w-md m-b-5 h-bn overlayPicturefinal1Dir", 'escape' => false, "title" => __(""))) . '</div><div style="clear:both;"></div>';
                            }
                            ?>




                            <!-- COMPONENT START -->

                            <div id='picturefinal1-file'>

                                <?php      echo "<div class='form-group input-button'>" . $this->Form->input('picturefinal1', array(
                                        'label' => '',
                                        'class' => 'form-control filestyle',
                                        'type' => 'file',
                                        'id' => 'picfinal1',
                                        'onchange' => 'javascript:verif_ext_attachment(1,this.id)',
                                        'empty' => ''
                                    )) . "</div>";
                                $input = 'picturefinal1';
                                ?>
                                <span class="popupactions popupactions-c">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "
                         id='picturefinal1-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i
                         class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
            </span>
                            </div>

                            <!-- COMPONENT END -->



                            <?php
                            if ($version_of_app == 'web') {

                                $Dir_picturefinal2 = 'finaletat';
                                $id_dialog = 'dialogModalPicturefinal2Dir';
                                $id_input = 'picturefinal2';

                                ?>
                                <div id="dialogModalPicturefinal2Dir">
                                    <!-- the external content is loaded inside this tag -->
                                    <div id="contentWrapPicturefinal2Dir"></div>
                                </div>

                                <?php


                                echo "<div class='input-button4' id='picturefinal2'>" . $this->Form->input('picturefinal2_dir', array(
                                        'label' => __('Final picture 2'),
                                        'readonly' => true,

                                        'class' => 'form-control',


                                    )) . '</div>';

                                echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-openm-r-5 "></i>' . __('Browse', true),
                                        array("controller" => "CustomerCars", "action" => "openDir", $Dir_picturefinal2, $id_dialog, $id_input),
                                        array("class" => "btn btn-default btn-trans waves-effect waves-primary w-md m-b-5 h-bn overlayPicturefinal2Dir", 'escape' => false, "title" => __(""))) . '</div><div style="clear:both;"></div>';
                            }
                            ?>



                            <!-- COMPONENT START -->

                            <div id='picturefinal2-file'>

                                <?php      echo "<div class='form-group input-button'>" . $this->Form->input('picturefinal2', array(
                                        'label' => '',
                                        'class' => 'form-control filestyle',
                                        'type' => 'file',
                                        'id' => 'picfinal2',
                                        'onchange' => 'javascript:verif_ext_attachment(1,this.id)',
                                        'empty' => ''
                                    )) . "</div>";
                                $input = 'picturefinal2';
                                ?>
                                <span class="popupactions popupactions-c">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "
                         id='picturefinal2-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i
                         class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
            </span>
                            </div>

                            <!-- COMPONENT END -->


                            <?php

                            if ($version_of_app == 'web') {
                                $Dir_picturefinal3 = 'finaletat';
                                $id_dialog = 'dialogModalPicturefinal3Dir';
                                $id_input = 'picturefinal3';

                                ?>
                                <div id="dialogModalPicturefinal3Dir">
                                    <!-- the external content is loaded inside this tag -->
                                    <div id="contentWrapPicturefinal3Dir"></div>
                                </div>

                                <?php


                                echo "<div class='input-button4' id='picturefinal3'>" . $this->Form->input('picturefinal3_dir', array(
                                        'label' => __('Final picture 3'),
                                        'readonly' => true,

                                        'class' => 'form-control',


                                    )) . '</div>';

                                echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),
                                        array("controller" => "CustomerCars", "action" => "openDir", $Dir_picturefinal3, $id_dialog, $id_input),
                                        array("class" => "btn btn-default btn-trans waves-effect waves-primary w-md m-b-5 h-bn overlayPicturefinal3Dir", 'escape' => false, "title" => __(""))) . '</div><div style="clear:both;"></div>';
                            }
                            ?>

                            <!-- COMPONENT START -->

                            <div id='picturefinal3-file'>

                                <?php      echo "<div class='form-group input-button'>" . $this->Form->input('picturefinal3', array(
                                        'label' => '',
                                        'class' => 'form-control filestyle',
                                        'type' => 'file',
                                        'id' => 'picfinal3',
                                        'onchange' => 'javascript:verif_ext_attachment(1,this.id)',
                                        'empty' => ''
                                    )) . "</div>";
                                $input = 'picturefinal3';
                                ?>
                                <span class="popupactions popupactions-c">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "
                         id='picturefinal3-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i
                         class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
            </span>
                            </div>

                            <!-- COMPONENT END -->


                            <?php
                            if ($version_of_app == 'web') {
                                $Dir_picturefinal4 = 'finaletat';
                                $id_dialog = 'dialogModalPicturefinal4Dir';
                                $id_input = 'picturefinal4';

                                ?>
                                <div id="dialogModalPicturefinal4Dir">
                                    <!-- the external content is loaded inside this tag -->
                                    <div id="contentWrapPicturefinal4Dir"></div>
                                </div>

                                <?php


                                echo "<div class='input-button4' id='picturefinal4'>" . $this->Form->input('picturefinal4_dir', array(
                                        'label' => __('Final picture 4'),
                                        'readonly' => true,

                                        'class' => 'form-control',


                                    )) . '</div>';

                                echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),
                                        array("controller" => "CustomerCars", "action" => "openDir", $Dir_picturefinal4, $id_dialog, $id_input),
                                        array("class" => "btn btn-default btn-trans waves-effect waves-primary w-md m-b-5 h-bn overlayPicturefinal4Dir", 'escape' => false, "title" => __(""))) . '</div><div style="clear:both;"></div>';
                            }
                            ?>





                            <!-- COMPONENT START -->

                            <div id='picturefinal4-file'>

                                <?php      echo "<div class='form-group input-button'>" . $this->Form->input('picturefinal4', array(
                                        'label' => '',
                                        'class' => 'form-control filestyle',
                                        'type' => 'file',
                                        'id' => 'picfinal4',
                                        'onchange' => 'javascript:verif_ext_attachment(1,this.id)',
                                        'empty' => ''
                                    )) . "</div>";
                                $input = 'picturefinal4';
                                ?>
                                <span class="popupactions popupactions-c">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "
                         id='picturefinal4-btn' type="button" onclick="delete_file('<?php echo $input ?>');"><i
                         class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
            </span>
                            </div>

                            <!-- COMPONENT END -->
                            <div style="clear:both;"></div>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_5">

                        <div class="panel-group" id="accordion">
                            <?php
                            if (Configure::read('logistia') != '1'){
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"
                                           class='a_accordion'><?= __('Documents du véhicule') ?></a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in">
                                    <div class="panel-body">

                                        <table class="table table-bordered cars">
                                            <thead>
                                            <tr>
                                                <th><?php echo __('Réception'); ?></th>
                                                <th><?php echo __('Restitution'); ?></th>

                                            </tr>
                                            </thead>

                                            <tbody>
                                            <tr>
                                                <td>
                                                    <?php


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Carte grise");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.grey_card', $options, $attributes) . "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Assurance");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.assurance', $options, $attributes) . "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Controle technique");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.controle_technique', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Carnet entretien");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.carnet_entretien', $options, $attributes) . "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Carnet de bord");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.carnet_bord', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("vignette");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.vignette', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("vignette ct");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.vignette_ct', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Procuration");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.procuration', $options, $attributes) . "</div><br/>";

                                                    ?>
                                                </td>

                                                <td>
                                                    <?php


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Carte grise");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.grey_card', $options, $attributes) . "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Assurance");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.assurance', $options, $attributes) . "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Controle technique");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.controle_technique', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Carnet entretien");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.carnet_entretien', $options, $attributes) . "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Carnet de bord");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.carnet_bord', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Vignette");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.vignette', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Vignette ct");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.vignette_ct', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Procuration");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.procuration', $options, $attributes) . "</div><br/>";
                                                    ?>
                                                </td>
                                            </tr>
                                            </tbody>


                                        </table>

                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"
                                           class='a_accordion'><?= __('Lot de bord') ?></a>
                                    </h4>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <table class="table table-bordered cars">
                                            <thead>
                                            <tr>
                                                <th><?php echo __('Reception'); ?></th>
                                                <th><?php echo __('Restitution'); ?></th>

                                            </tr>
                                            </thead>

                                            <tbody>
                                            <tr>
                                                <td>
                                                    <?php
                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Roue de secours");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.roue_secours', $options, $attributes) . "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Cric");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.cric', $options, $attributes) . "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Tapis");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.tapis', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Manivelle");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.manivelle', $options, $attributes) . "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Boite a pharmacie");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.boite_pharmacie', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Triangle");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.triangle', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Gilet");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.gilet', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Double clé");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.double_cle', $options, $attributes) . "</div><br/>";

                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Roue de secours");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.roue_secours', $options, $attributes) . "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Cric");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.cric', $options, $attributes) . "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Tapis");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.tapis', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Manivelle");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.manivelle', $options, $attributes) . "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Boite a pharmacie");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.boite_pharmacie', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Triangle");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.triangle', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Gilet");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.gilet', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Double clé");
                                                    echo "</div>";
                                                    $options = array('1' => __('Yes'), '2' => __('No'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.double_cle', $options, $attributes) . "</div><br/>";

                                                    ?>
                                                </td>
                                            </tr>
                                            </tbody>


                                        </table>

                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"
                                           class='a_accordion'><?= __('State') ?></a>
                                    </h4>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse">
                                    <div class="panel-body">

                                        <p>Abreviation</p>

                                        <p> O : Ok </p>

                                        <p>M: Moyen</p>

                                        <p>TMR : Très mauvais état</p><br/>

                                        <table class="table table-bordered cars">
                                            <thead>
                                            <tr>
                                                <th><?php echo __('Reception'); ?></th>
                                                <th><?php echo __('Restitution'); ?></th>

                                            </tr>
                                            </thead>

                                            <tbody>
                                            <tr>
                                                <td>
                                                    <?php
                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Sièges");
                                                    echo "</div>";
                                                    $options = array('3' => __('O'), '1' => __('M'), '2' => __('TMR'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.sieges', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Tableau de bord");
                                                    echo "</div>";
                                                    $options = array('3' => __('O'), '1' => __('M'), '2' => __('TMR'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.dashboard', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Moquette");
                                                    echo "</div>";
                                                    $options = array('3' => __('O'), '1' => __('M'), '2' => __('TMR'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.moquette', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Tapis intérieur");
                                                    echo "</div>";
                                                    $options = array('3' => __('O'), '1' => __('M'), '2' => __('TMR'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.0.tapis_interieur', $options, $attributes) . "</div><br/>";




                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Sièges");
                                                    echo "</div>";
                                                    $options = array('3' => __('O'), '1' => __('M'), '2' => __('TMR'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.sieges', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Tableau de bord");
                                                    echo "</div>";
                                                    $options = array('3' => __('O'), '1' => __('M'), '2' => __('TMR'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.dashboard', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Moquette");
                                                    echo "</div>";
                                                    $options = array('3' => __('O'), '1' => __('M'), '2' => __('TMR'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.moquette', $options, $attributes) . "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Tapis intérieur");
                                                    echo "</div>";
                                                    $options = array('3' => __('O'), '1' => __('M'), '2' => __('TMR'));
                                                    $attributes = array('legend' => false);
                                                    echo $this->Form->radio('Affectationpv.1.tapis_interieur', $options, $attributes) . "</div><br/>";




                                                    ?>
                                                </td>
                                            </tr>
                                            </tbody>


                                        </table>

                                    </div>
                                </div>
                            </div>
                            <?php
                            }else{
                            ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"
                                               class='a_accordion'><?= __('Documents du véhicule') ?></a>
                                        </h4>
                                    </div>
                                    <div id="collapse1" class="panel-collapse collapse in">
                                        <div class="panel-body">

                                            <table class="table table-bordered cars">
                                                <thead>
                                                <tr>
                                                    <th><?php echo __('Réception'); ?></th>
                                                    <th><?php echo __('Restitution'); ?></th>

                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <?php


                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Carte grise , assurance, C.tch, carnet de bord, carnet d'entretien");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.0.grey_card', $options, $attributes) . "</div><br/>";


                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php


                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Carte grise , assurance, C.tch, carnet de bord, carnet d'entretien");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.1.grey_card', $options, $attributes) . "</div><br/>";

                                                        ?>
                                                    </td>
                                                </tr>
                                                </tbody>


                                            </table>

                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"
                                               class='a_accordion'><?= __('Etat du moteur') ?></a>
                                        </h4>
                                    </div>
                                    <div id="collapse2" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered cars">
                                                <thead>
                                                <tr>
                                                    <th><?php echo __('Reception'); ?></th>
                                                    <th><?php echo __('Restitution'); ?></th>

                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Niveau d'huile et liquides");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.0.oil_level', $options, $attributes) . "</div><br/>";


                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Bruit du moteur");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.0.engin_noise', $options, $attributes) . "</div><br/>";


                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Niveau d'huile et liquides");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.1.oil_level', $options, $attributes) . "</div><br/>";

                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Bruit du moteur");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.1.engin_noise', $options, $attributes) . "</div><br/>";

                                                        ?>
                                                    </td>
                                                </tr>
                                                </tbody>


                                            </table>

                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"
                                               class='a_accordion'><?= __('Aspet intérieur') ?></a>
                                        </h4>
                                    </div>
                                    <div id="collapse3" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered cars">
                                                <thead>
                                                <tr>
                                                    <th><?php echo __('Reception'); ?></th>
                                                    <th><?php echo __('Restitution'); ?></th>

                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <?php

                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Freins (à pied et à main)");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.0.breaks', $options, $attributes) . "</div><br/>";


                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Pédales");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.0.pedals', $options, $attributes) . "</div><br/>";

                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Rétroviseurs");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.0.wing_mirrors', $options, $attributes) . "</div><br/>";

                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Compteur kilométrique");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.0.odometer', $options, $attributes) . "</div><br/>";

                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Aspets des portières");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.0.doors_state', $options, $attributes) . "</div><br/>";

                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Fonctionnements des portiéres");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.0.doors_operation', $options, $attributes) . "</div><br/>";

                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Siéges");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.0.seats', $options, $attributes) . "</div><br/>";


                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Freins (à pied et à main)");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.1.breaks', $options, $attributes) . "</div><br/>";


                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Pédales");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.1.pedals', $options, $attributes) . "</div><br/>";

                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Rétroviseurs");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.1.wing_mirrors', $options, $attributes) . "</div><br/>";

                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Compteur kilométrique");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.1.odometer', $options, $attributes) . "</div><br/>";

                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Aspets des portières");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.1.doors_state', $options, $attributes) . "</div><br/>";

                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Fonctionnements des portiéres");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.1.doors_operation', $options, $attributes) . "</div><br/>";

                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Siéges");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.1.seats', $options, $attributes) . "</div><br/>";

                                                        ?>
                                                    </td>
                                                </tr>
                                                </tbody>


                                            </table>

                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4"
                                               class='a_accordion'><?= __('Feux et essuie-glace') ?></a>
                                        </h4>
                                    </div>
                                    <div id="collapse4" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered cars">
                                                <thead>
                                                <tr>
                                                    <th><?php echo __('Reception'); ?></th>
                                                    <th><?php echo __('Restitution'); ?></th>

                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Feux (avant - arrière)");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.0.front_lights', $options, $attributes) . "</div><br/>";


                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Essuie-glace");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.0.wipper', $options, $attributes) . "</div><br/>";


                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Feux (avant - arrière)");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.1.front_lights', $options, $attributes) . "</div><br/>";


                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Essuie-glace");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.1.wipper', $options, $attributes) . "</div><br/>";

                                                        ?>
                                                    </td>
                                                </tr>
                                                </tbody>


                                            </table>

                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse5"
                                               class='a_accordion'><?= __('Aspects des pneumatique') ?></a>
                                        </h4>
                                    </div>
                                    <div id="collapse5" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered cars">
                                                <thead>
                                                <tr>
                                                    <th><?php echo __('Reception'); ?></th>
                                                    <th><?php echo __('Restitution'); ?></th>

                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Pneus (avant - arrière)");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.0.front_tires', $options, $attributes) . "</div><br/>";

                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Etat de roue de secours");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.0.spare_wheel', $options, $attributes) . "</div><br/>";


                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Pneus (avant - arrière)");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.1.front_tires', $options, $attributes) . "</div><br/>";

                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Etat de roue de secours");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.1.spare_wheel', $options, $attributes) . "</div><br/>";

                                                        ?>
                                                    </td>
                                                </tr>
                                                </tbody>


                                            </table>

                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse11"
                                               class='a_accordion'><?= __('Etat de propreté') ?></a>
                                        </h4>
                                    </div>
                                    <div id="collapse11" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered cars">
                                                <thead>
                                                <tr>
                                                    <th><?php echo __('Reception'); ?></th>
                                                    <th><?php echo __('Restitution'); ?></th>

                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Propreté externe");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.0.external_cleanliness', $options, $attributes) . "</div><br/>";

                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Propreté interne");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.0.internal_cleanliness', $options, $attributes) . "</div><br/>";


                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Propreté externe");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.1.external_cleanliness', $options, $attributes) . "</div><br/>";

                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Propreté interne");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.1.internal_cleanliness', $options, $attributes) . "</div><br/>";

                                                        ?>
                                                    </td>
                                                </tr>
                                                </tbody>


                                            </table>

                                        </div>
                                    </div>
                                </div>



                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse6"
                                               class='a_accordion'><?= __('Accessoires') ?></a>
                                        </h4>
                                    </div>
                                    <div id="collapse6" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered cars">
                                                <thead>
                                                <tr>
                                                    <th><?php echo __('Reception'); ?></th>
                                                    <th><?php echo __('Restitution'); ?></th>

                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <?php


                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Poste auto, baffes, cric, clés de roue, enjoliveurs
                                                        , extincteurs, triangle, boite pharmacie, gilet, cable remorquage");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.0.accessories', $options, $attributes) . "</div><br/>";


                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        echo "<div id='interval2'>";
                                                        echo '<div class="lbl4">' . __("Poste auto, baffes, cric, clés de roue, enjoliveurs
                                                        , extincteurs, triangle");
                                                        echo "</div>";
                                                        $options = array('1' => __('Yes'), '2' => __('No'));
                                                        $attributes = array('legend' => false);
                                                        echo $this->Form->radio('Affectationpv.1.accessories', $options, $attributes) . "</div><br/>";

                                                        ?>
                                                    </td>
                                                </tr>
                                                </tbody>


                                            </table>

                                        </div>
                                    </div>
                                </div>


                            <?php
                            }
                            ?>
                        </div>

                        <?php
                        echo "<div class='form-group'>" . $this->Form->input('Affectationpv.obs_customer', array(
                                'label' => __('Observation conductor'),
                                'placeholder' => __('Enter observation'),
                                'class' => 'form-control',
                                'empty' => ''
                            )) . "</div>";

                        echo "<div class='form-group'>" . $this->Form->input('Affectationpv.obs_chef', array(
                                'label' => __('Observation park chief'),
                                'placeholder' => __('Enter observation'),
                                'class' => 'form-control',
                                'empty' => ''
                            )) . "</div>";

                        echo "<div class='form-group'>" . $this->Form->input('Affectationpv.obs_hse', array(
                                'label' => __('Observation HSE chief'),
                                'placeholder' => __('Enter observation'),
                                'class' => 'form-control',
                                'empty' => ''
                            )) . "</div>";

                        ?>



                    </div>


                    <div class="tab-pane" id="tab_6">
                        <div class="panel-group" id="accordion">
                            <?php
                            echo "<div class='form-group' >" . $this->Form->input('Affectationpv.2.transfering_customer_id', array(
                                    'label' => __("L' élément cedant"),
                                    'class' => 'form-control select2',
                                    'options' => $customers,
                                    'empty' => '',
                                    'id' => 'customers',
                                )) . "</div>";
                            echo "<div class='form-group' >" . $this->Form->input('Affectationpv.2.receiving_customer_id', array(
                                    'label' => __("L' élément receptionnant"),
                                    'class' => 'form-control select2',
                                    'options' => $customers,
                                    'empty' => '',
                                    'id' => 'customers',
                                )) . "</div>";
                            ?>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse7"
                                       class='a_accordion'><?= __('Véhicule') ?></a>
                                </h4>
                            </div>
                            <div id="collapse7" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table table-bordered cars">

                                        <tbody>
                                        <tr>
                                            <td>
                                                <?php


                                                echo "<div id='interval2'>";
                                                echo '<div class="lbl4">' . __("Etat mécanique");
                                                echo "</div>";
                                                $options = array('1' => __('Yes'), '2' => __('No'));
                                                $attributes = array('legend' => false);
                                                echo $this->Form->radio('Affectationpv.2.mechanic_state', $options, $attributes) . "</div><br/>";


                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo "<div class='form-group'>" . $this->Form->input('Affectationpv.2.obs_mechanic_state', array(
                                                        'label' => __('Observation état méchanique'),
                                                        'placeholder' => __('Enter observation'),
                                                        'class' => 'form-control',
                                                        'empty' => ''
                                                    )) . "</div>";
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php


                                                echo "<div id='interval2'>";
                                                echo '<div class="lbl4">' . __("Etat éléctrique");
                                                echo "</div>";
                                                $options = array('1' => __('Yes'), '2' => __('No'));
                                                $attributes = array('legend' => false);
                                                echo $this->Form->radio('Affectationpv.2.electric_state', $options, $attributes) . "</div><br/>";


                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo "<div class='form-group'>" . $this->Form->input('Affectationpv.2.obs_electric_state', array(
                                                        'label' => __('Observation état éléctrique'),
                                                        'placeholder' => __('Enter observation'),
                                                        'class' => 'form-control',
                                                        'empty' => ''
                                                    )) . "</div>";
                                                ?>
                                            </td>
                                        </tr>
                                        </tbody>


                                    </table>

                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse8"
                                       class='a_accordion'><?= __('Papiers du véhicule') ?></a>
                                </h4>
                            </div>
                            <div id="collapse8" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table table-bordered cars">

                                        <tbody>
                                        <tr>
                                            <td>
                                                <?php
                                                echo "<div id='interval2'>";
                                                echo '<div class="lbl4">' . __("Carte grise");
                                                echo "</div>";
                                                $options = array('1' => __('Yes'), '2' => __('No'));
                                                $attributes = array('legend' => false);
                                                echo $this->Form->radio('Affectationpv.2.grey_card_2', $options, $attributes) . "</div><br/>";


                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo "<div id='interval2'>";
                                                echo '<div class="lbl4">' . __("Attestation d'assurance");
                                                echo "</div>";
                                                $options = array('1' => __('Yes'), '2' => __('No'));
                                                $attributes = array('legend' => false);
                                                echo $this->Form->radio('Affectationpv.2.inssurance', $options, $attributes) . "</div><br/>";


                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php
                                                echo "<div id='interval2'>";
                                                echo '<div class="lbl4">' . __("Carnet d'entretien");
                                                echo "</div>";
                                                $options = array('1' => __('Yes'), '2' => __('No'));
                                                $attributes = array('legend' => false);
                                                echo $this->Form->radio('Affectationpv.2.interview_notebook', $options, $attributes) . "</div><br/>";


                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo "<div id='interval2'>";
                                                echo '<div class="lbl4">' . __("Carnet de bord");
                                                echo "</div>";
                                                $options = array('1' => __('Yes'), '2' => __('No'));
                                                $attributes = array('legend' => false);
                                                echo $this->Form->radio('Affectationpv.2.dashboard_notebook', $options, $attributes) . "</div><br/>";


                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php
                                                echo "<div id='interval2'>";
                                                echo '<div class="lbl4">' . __("Vignette");
                                                echo "</div>";
                                                $options = array('1' => __('Yes'), '2' => __('No'));
                                                $attributes = array('legend' => false);
                                                echo $this->Form->radio('Affectationpv.2.thumbnail', $options, $attributes) . "</div><br/>";


                                                ?>
                                            </td>
                                            <td></td>

                                        </tr>
                                        </tbody>


                                    </table>

                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse10"
                                       class='a_accordion'><?= __('Lot de bord') ?></a>
                                </h4>
                            </div>
                            <div id="collapse10" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table table-bordered cars">

                                        <tbody>
                                        <tr>
                                            <td>
                                                <?php
                                                echo "<div id='interval2'>";
                                                echo '<div class="lbl4">' . __("Poste auto");
                                                echo "</div>";
                                                $options = array('1' => __('Yes'), '2' => __('No'));
                                                $attributes = array('legend' => false);
                                                echo $this->Form->radio('Affectationpv.2.post_auto', $options, $attributes) . "</div><br/>";


                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo "<div id='interval2'>";
                                                echo '<div class="lbl4">' . __("Baffes");
                                                echo "</div>";
                                                $options = array('1' => __('Yes'), '2' => __('No'));
                                                $attributes = array('legend' => false);
                                                echo $this->Form->radio('Affectationpv.2.slaps', $options, $attributes) . "</div><br/>";


                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php
                                                echo "<div id='interval2'>";
                                                echo '<div class="lbl4">' . __("Cric");
                                                echo "</div>";
                                                $options = array('1' => __('Yes'), '2' => __('No'));
                                                $attributes = array('legend' => false);
                                                echo $this->Form->radio('Affectationpv.2.jack', $options, $attributes) . "</div><br/>";


                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo "<div id='interval2'>";
                                                echo '<div class="lbl4">' . __("Clés de roues");
                                                echo "</div>";
                                                $options = array('1' => __('Yes'), '2' => __('No'));
                                                $attributes = array('legend' => false);
                                                echo $this->Form->radio('Affectationpv.2.wheel_wrench', $options, $attributes) . "</div><br/>";


                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php
                                                echo "<div id='interval2'>";
                                                echo '<div class="lbl4">' . __("Enjoliveurs");
                                                echo "</div>";
                                                $options = array('1' => __('Yes'), '2' => __('No'));
                                                $attributes = array('legend' => false);
                                                echo $this->Form->radio('Affectationpv.2.hubcaps', $options, $attributes) . "</div><br/>";


                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo "<div id='interval2'>";
                                                echo '<div class="lbl4">' . __("Extincteurs");
                                                echo "</div>";
                                                $options = array('1' => __('Yes'), '2' => __('No'));
                                                $attributes = array('legend' => false);
                                                echo $this->Form->radio('Affectationpv.2.fire_extinguisher', $options, $attributes) . "</div><br/>";


                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <?php
                                                echo "<div id='interval2'>";
                                                echo '<div class="lbl4">' . __("Triangle");
                                                echo "</div>";
                                                $options = array('1' => __('Yes'), '2' => __('No'));
                                                $attributes = array('legend' => false);
                                                echo $this->Form->radio('Affectationpv.2.triangle2', $options, $attributes) . "</div><br/>";


                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo "<div id='interval2'>";
                                                echo '<div class="lbl4">' . __("Gilet");
                                                echo "</div>";
                                                $options = array('1' => __('Yes'), '2' => __('No'));
                                                $attributes = array('legend' => false);
                                                echo $this->Form->radio('Affectationpv.2.vest', $options, $attributes) . "</div><br/>";


                                                ?>
                                            </td>
                                        </tr>
                                        </tbody>


                                    </table>

                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse9"
                                       class='a_accordion'><?= __('Carburant') ?></a>
                                </h4>
                            </div>
                            <div id="collapse9" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table table-bordered cars">

                                        <tbody>
                                        <tr id="carnet" >
                                            <td>
                                                <?php
                                                echo "<div class='form-group' >" . $this->Form->input('Affectationpv.2.notebook_number', array(
                                                        'label' => __("Carnet N°"),
                                                        'class' => 'form-control',
                                                        'id' => 'customers',
                                                    )) . "</div>";

                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo "<div class='form-group' >" . $this->Form->input('Affectationpv.2.strain', array(
                                                        'label' => __("Souche N°"),
                                                        'class' => 'form-control',
                                                        'id' => 'customers',
                                                    )) . "</div>";


                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo "<div class='form-group' >" . $this->Form->input('Affectationpv.2.notebook_to', array(
                                                        'label' => __("AU N°"),
                                                        'class' => 'form-control',
                                                        'id' => 'customers',
                                                    )) . "</div>";


                                                ?>
                                            </td>
                                        </tr>
                                        <tr id="carte">
                                            <td>
                                                <?php
                                                echo "<div class='form-group' >" . $this->Form->input('Affectationpv.2.card_number', array(
                                                        'label' => __("Carte N°"),
                                                        'class' => 'form-control',
                                                        'id' => 'customers',
                                                    )) . "</div>";

                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo "<div class='form-group' >" . $this->Form->input('Affectationpv.2.card_amount', array(
                                                        'label' => __("Montant°"),
                                                        'class' => 'form-control',
                                                        'id' => 'customers',
                                                    )) . "</div>";


                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php
                                                echo "<div class='form-group' >" . $this->Form->input('Affectationpv.2.convention_notebook', array(
                                                        'label' => __("Carnet convontionné N°"),
                                                        'class' => 'form-control',
                                                    )) . "</div>";

                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo "<div class='form-group' >" . $this->Form->input('Affectationpv.2.convention_strain', array(
                                                        'label' => __("Souche N°"),
                                                        'class' => 'form-control',
                                                    )) . "</div>";

                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo "<div class='form-group' >" . $this->Form->input('Affectationpv.2.convention_notebook_to', array(
                                                        'label' => __("Au N°"),
                                                        'class' => 'form-control',
                                                        'id' => 'customers',
                                                    )) . "</div>";

                                                ?>
                                            </td>
                                        </tr>
                                        </tbody>


                                    </table>

                                </div>
                            </div>
                        </div>
                            <br>
                            <?php
                            echo "<div class='form-group' >" . $this->Form->input('Affectationpv.2.other_consignes', array(
                                    'label' => __("Autres Consignes"),
                                    'class' => 'form-control',
                                    'id' => 'customers',
                                )) . "</div>";
                            ?>
                        </div>
                    </div>
                    </div>


                    <?php if ($version_of_app == 'web') { ?>
                        <div class='progress-div' id="progress-div">
                            <div class='progress-bar1' id="progress-bar">
                                <div id="progress-status1">0 %</div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="box-footer">
                    <?php    if ($version_of_app == 'web') {
                        echo $this->Form->submit(__('Submit'), array(
                            'name' => 'ok',
                            'id' => 'ok',
                            'class' => 'btn btn-primary btn-bordred  m-b-5',
                            'label' => __('Submit'),
                            'type' => 'submit',
                            //'onclick' =>'javascript:submitForm();',
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
                    } ?>
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
        <?= $this->Html->script('plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js'); ?>
        <?= $this->Html->script('plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js'); ?>
        <?= $this->Html->script('ExpandSelect_1.00'); ?>
        <?= $this->Html->script('jquery-2.1.1.min.js'); ?>
        <?= $this->Html->script('jquery.form.min.js'); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                jQuery("#start_date").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
                jQuery("#end_date").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
                jQuery("#enddatereal").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
                jQuery("#paymentdate").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
                jQuery("#authorization_from").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
                jQuery("#authorization_to").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});

                jQuery("#delivery").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

                jQuery('#interval1').css("display", "block");
                jQuery('#type').change(function () {
                    var val = jQuery(this).val();
                    //alert(jQuery(this).val());
                    if (val == 0) {

                        jQuery('#interval1').css("display", "block");
                    } else {
                        jQuery('#interval1').css("display", "none");

                    }

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

                jQuery("#dialogModalPictureinit1Dir").dialog({
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
                jQuery(".overlayPictureinit1Dir").click(function (event) {
                    event.preventDefault();
                    jQuery('#contentWrapPictureinit1Dir').load(jQuery(this).attr("href"));
                    //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
                    jQuery('#dialogModalPictureinit1Dir').dialog('open');
                });


                jQuery("#dialogModalPictureinit2Dir").dialog({
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
                jQuery(".overlayPictureinit2Dir").click(function (event) {
                    event.preventDefault();
                    jQuery('#contentWrapPictureinit2Dir').load(jQuery(this).attr("href"));
                    //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
                    jQuery('#dialogModalPictureinit2Dir').dialog('open');
                });

                jQuery("#dialogModalPictureinit3Dir").dialog({
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
                jQuery(".overlayPictureinit3Dir").click(function (event) {
                    event.preventDefault();
                    jQuery('#contentWrapPictureinit3Dir').load(jQuery(this).attr("href"));
                    //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
                    jQuery('#dialogModalPictureinit3Dir').dialog('open');
                });

                jQuery("#dialogModalPictureinit4Dir").dialog({
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
                jQuery(".overlayPicturefinal1Dir").click(function (event) {
                    event.preventDefault();
                    jQuery('#contentWrapPictureinit4Dir').load(jQuery(this).attr("href"));
                    //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
                    jQuery('#dialogModalPictureinit4Dir').dialog('open');
                });

                jQuery("#dialogModalPicturefinal1Dir").dialog({
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
                jQuery(".overlayPicturefinal1Dir").click(function (event) {
                    event.preventDefault();
                    jQuery('#contentWrapPicturefinal1Dir').load(jQuery(this).attr("href"));
                    //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
                    jQuery('#dialogModalPicturefinal1Dir').dialog('open');
                });


                jQuery("#dialogModalPicturefinal2Dir").dialog({
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
                jQuery(".overlayPicturefinal2Dir").click(function (event) {
                    event.preventDefault();
                    jQuery('#contentWrapPicturefinal2Dir').load(jQuery(this).attr("href"));
                    //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
                    jQuery('#dialogModalPicturefinal2Dir').dialog('open');
                });

                jQuery("#dialogModalPicturefinal3Dir").dialog({
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
                jQuery(".overlayPicturefinal3Dir").click(function (event) {
                    event.preventDefault();
                    jQuery('#contentWrapPicturefinal3Dir').load(jQuery(this).attr("href"));
                    //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
                    jQuery('#dialogModalPicturefinal3Dir').dialog('open');
                });

                jQuery("#dialogModalPicturefinal4Dir").dialog({
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
                jQuery(".overlayPicturefinal4Dir").click(function (event) {
                    event.preventDefault();
                    jQuery('#contentWrapPicturefinal4Dir').load(jQuery(this).attr("href"));
                    //jQuery('#dialogModalDir').dialog('option', 'title', jQuery(this).attr("title"));
                    jQuery('#dialogModalPicturefinal4Dir').dialog('open');
                });

                if (jQuery('#conductorGroup').val() > 0) {
                    getConductorsOrGroups();
                }

            });

            function delete_file(id) {
                //alert(id);

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


            function verif_ext_attachment(img, id) {

                pic1 = jQuery('#' + id).val();
                pic1 = pic1.split('.');

                if (img == 1) {

                    var typeArr = ['jpg', 'jpeg', 'gif', 'png', 'pdf'];
//use of inArray
                    if (!typeArr.inArray(pic1[1])) {
                        msg = '<?php echo __('Only gif, png, jpg and jpeg images are allowed!')?>';
                        alert(msg);
                        jQuery('#' + id).val('');
                    }
                }
            }


            function getConductorsOrGroups() {
                var conductorGroup = jQuery('#conductorGroup').val();
                jQuery('#interval1').load('<?php echo $this->Html->url('/customerCars/getConductorsOrGroups/')?>' + conductorGroup, function () {
                    $(".select2").select2();
                });
            }

            function addFuelNotebookRow(){

            }

            function addFuelCardRow(){

            }

            function addConventionNotebookRow(){

            }


        </script>

        <?php $this->end(); ?>
