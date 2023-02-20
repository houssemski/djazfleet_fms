<?php
//die();
//echo $this->element('sql_dump'); die();
include("ctp/datetime.ctp");

$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->Html->css('select2/select2.min');

$this->end();
$rides_sheet_ride['SheetRideDetailRides']['planned_start_date'] = $this->Time->format($rides_sheet_ride['SheetRideDetailRides']['planned_start_date'], '%d-%m-%Y %H:%M');
$rides_sheet_ride['SheetRideDetailRides']['real_start_date'] = $this->Time->format($rides_sheet_ride['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y %H:%M');
$rides_sheet_ride['SheetRideDetailRides']['planned_end_date'] = $this->Time->format($rides_sheet_ride['SheetRideDetailRides']['planned_end_date'], '%d-%m-%Y %H:%M');
$rides_sheet_ride['SheetRideDetailRides']['real_end_date'] = $this->Time->format($rides_sheet_ride['SheetRideDetailRides']['real_end_date'], '%d-%m-%Y %H:%M');
$this->assign('title', __('Edit sheet ride (travel)')); ?>


<?= $this->Form->input('controller', array(
    'id' => 'controller',
    'value' => $this->request->params['controller'],
    'type' => 'hidden'
)); ?>
<?= $this->Form->input('current_action', array(
    'id' => 'current_action',
    'value' => $this->request->params['action'],
    'type' => 'hidden'
)); ?>
<?= $this->Form->input('gestion_commercial', array(
    'id' => 'gestion_commercial',
    'value' => Configure::read("gestion_commercial"),
    'type' => 'hidden'
)); ?>
<?= $this->Form->input('transport_personnel', array(
    'id' => 'transport_personnel',
    'value' => Configure::read("transport_personnel"),
    'type' => 'hidden'
)); ?>

<h4 class="page-title"> <?= __('Edit mission'); ?></h4>
<style>
    .filters {
        clear: both;
        width: 1050px;
        margin-bottom: 20px;
    }

    .filters .btn-default {
        margin-top: 15px;
        float: right;
        margin-right: 10px !important;
    }

    .filters .last {
        margin-right: 0px;
    }

    .filters select, .filters input {
        margin-right: 20px;
        height: 31px;
    }

    .filters .input-group {
        width: 160px;
        float: left;
    }

    .filters .input-group input.datemask {
        margin-right: 20px;
        width: 142px !important;
    }

    .filters .input-group label {
        display: none;
    }

    .filters div.input {
        float: left;
        padding-top: 5px;
        width: 265px;
    }

    .filters label.dte {
        float: left;
        padding-top: 5px;
        width: 286px;
    }

    .filters div.input label {
        width: 150px;
        padding-top: 5px;
    }

    .filters {
        width: 100%;
    }

    .filters select, .filters input {

        margin-right: 0px;
    }

    .form-filter {
        border-radius: 0;
        width: 78.7%;
    }

    .filters div.input, .filters .input-group {
        float: none;
    }

    .input-group {
        width: 80% !important;
    }

    .input.text .input-group input {
        width: 100% !important;
    }

    input[type="file"] {
        display: inline-block;

        margin-top: 10px;
        margin-bottom: 20px;
    }

    #dynamic_field {
        width: 100%;
        display: table-caption;
        position: relative;
    }

    #dynamic_field tbody, #dynamic_field tbody tr, #dynamic_field tbody td {
        width: 100%;
    }

    #dynamic_field .form-groupee {
        width: 100%
    }

    .out-table-caption {
        position: absolute;
        right: 15px;
    }

    .btn.btn-marg {
        margin-top: 0px;
        margin-left: 35px;
    }

    .btn_remove, .btn-success {
        width: 100px;
    }

    .panel-default > .panel-heading {
        border-bottom: none;
        color: #f5f5f5;
    }

    .input-button {
        float: left;
        width: 80%;
        margin-right: 0px;
    }

    .popupactions {
        float: left;
        margin-left: -20px;
        margin-top: 35px;
        margin-right: 10px;
    }

    .p-radio {
        font-weight: bold;
        float: left;
        margin-right: 20px;
        padding-top: 5px;
    }

    .select-inline2 .input {
        width: 570px !important;
    }

    .td-input .file {
        width: 100% !important;
    }

    .select2-selection--multiple {
        height: 20px;
    }

    .input-radio {
        position: relative;
        top: 5px;
    }

    .label-radio {
        padding-left: 10px;
        top: -6px;
        position: relative;
    }

    .scroll-block {
        width: 37%;
        display: inline-block;
        vertical-align: top;
    }

    .input-file div.input {

        width: 100%;
    }

    .button-file {
        margin-top: 20px;
    }

    .select3 {
        font-size: 11px;
    }

    label {
        font-size: 10px;
    }

    .btn_remove {
        width: 40px;
    }

    .consumption div.input {
        width: 150px;
    !important;
    }
    .small-select .select { width: 100% !important;}
</style>


<div class="box">
  <?php  echo $this->Form->create('SheetRideDetailRides', array('enctype' => 'multipart/form-data', 'onsubmit' => 'javascript:disable();'));
    echo $this->Form->input('id'); ?>
    <div class="edit form card-box p-b-0">
<table class="table table-bordered ">

<tr  id="depart" <?php if ($isAgent) {?> class='hidden'<?php } ?>>

    <td>Départ</td>
    <td>
        <div class="filters" id='filters'>
            <?php
            echo "<div >" . $this->Form->input('currentDateAdd', array(
                    'label' => '',
                    'type' => 'text',
                    'value' => date('Y-m-d H:i'),
                    'class' => 'form-control datemask',
                    'type' => 'hidden',


                )) . "</div>";

            echo  $this->Form->input('order_mission', array(
                    'class' => 'form-filter ',
                    'value' => $rides_sheet_ride['SheetRideDetailRides']['order_mission'],
                    'empty' => '',
                    'id' => 'order_mission',
                    'type' => 'hidden',
                )) ;
            echo  $this->Form->input('car_type_id', array(
                    'class' => 'form-filter ',
                    'value' => $rides_sheet_ride['CarType']['id'],
                    'empty' => '',
                    'id' => 'car_type',
                    'type' => 'hidden',
                )) ;
            echo  $this->Form->input('sheet_ride_id', array(
                    'class' => 'form-filter ',
                    'value' => $rides_sheet_ride['SheetRide']['id'],
                    'empty' => '',
                    'id' => 'sheet_ride',
                    'type' => 'hidden',
                )) ;
            echo  $this->Form->input('reference_sheet_ride', array(
                    'class' => 'form-filter ',
                    'value' => $rides_sheet_ride['SheetRide']['reference'],
                    'empty' => '',
                    'id' => 'reference_sheet_ride',
                    'type' => 'hidden',
                )) ;
            if($this->request->params['action'] !='duplicate') {
                echo "<div>" . $this->Form->input('SheetRideDetailRides.id', array(

                        'type' => 'hidden',
                        'id' => 'sheet_ride_detail_ride',
                        'value' => $rides_sheet_ride['SheetRideDetailRides']['id'],
                        'class' => 'form-control'
                    )) . "</div>";
            }
            if ($referenceMission == '1') {
                echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.reference', array(
                        'label' => __('Reference'),
                        'class' => 'form-filter',
                        'placeholder' => __('Enter reference'),
                    )) . "</div>";
            }
            echo "<div>" . $this->Form->input('SheetRideDetailRides.status_id', array(

                    'type' => 'hidden',
                    'id' => 'status',
                    'value' => $rides_sheet_ride['SheetRideDetailRides']['status_id'],
                    'class' => 'form-control'
                )) . "</div>";

            echo "<div>" . $this->Form->input('SheetRideDetailRides.from_customer_order', array(
                    'type' => 'hidden',
                    'id' => 'from_customer_order',
                    'value' => $rides_sheet_ride['SheetRideDetailRides']['from_customer_order'],
                    'class' => 'form-control'
                )) . "</div>";

            echo "<div>" . $this->Form->input('SheetRideDetailRides.type_ride', array('type' => 'hidden',
                    'id' => 'type_ride' ,
                    'value' => $rides_sheet_ride['SheetRideDetailRides']['type_ride'],
                    'class' => 'form-control'
                )) . "</div>";
            ?>

            <?php
            echo "<div>" . $this->Form->input('SheetRideDetailRides.gestion_commercial', array(
                    'type' => 'hidden',
                    'id' => 'gestion_commercial' ,
                    'value' => Configure::read("gestion_commercial"),
                    'class' => 'form-control'
                )) . "</div>";
            if (Configure::read("gestion_commercial") == '1') { ?>
                <div class="input-radio">
                    <p class="p-radio"><?php echo __('Source') ?></p>

                    <input id='source1'
                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] <= StatusEnum::mission_closed) { ?>
                            onclick='javascript:getRidesFromCustomerOrder();'
                        <?php } else { ?> disabled ='disabled'  <?php } ?>
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][source]"
                           value="1" <?php if ($rides_sheet_ride['SheetRideDetailRides']['source'] == 1) { ?> checked='checked' <?php } ?>>
                    <span class="label-radio"><?php echo __('Standard customer order') ?></span>

                    <input id='source2'
                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] <= StatusEnum::mission_closed) { ?>
                            onclick='javascript:getPersonalizedRidesFromCustomerOrder();'
                        <?php } else { ?> disabled ='disabled'  <?php } ?>
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][source]"
                           value="2" <?php if ($rides_sheet_ride['SheetRideDetailRides']['source'] == 2) { ?> checked='checked' <?php } ?>>
                    <span class="label-radio"><?php echo __('Personalized customer order') ?></span>


                    <input id='source3'
                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] <= StatusEnum::mission_closed) { ?>
                            onclick='javascript:getRidesByType(this.id);'
                        <?php }  else { ?> disabled ='disabled'  <?php } ?>
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][source]"
                           value="3" <?php if ($rides_sheet_ride['SheetRideDetailRides']['source'] == 3) { ?> checked='checked' <?php } ?>>
                    <span class="label-radio"> <?php echo __('Existing ride') ?></span>
                    <input id='source4'
                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] <= StatusEnum::mission_closed) { ?>
                            onclick='javascript:getPersonalizedRide();'
                        <?php } else { ?> disabled ='disabled'  <?php } ?>
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][source]"
                           value="4" <?php if ($rides_sheet_ride['SheetRideDetailRides']['source'] == 4) { ?> checked='checked' <?php } ?>>
                    <span class="label-radio"> <?php echo __('Personalized ride') ?></span>
                </div>

            <?php } else { ?>
                <div class="input-radio">
                    <input id='source3'
                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] <= StatusEnum::mission_closed) { ?>
                            onclick='javascript:getRidesByType();'
                        <?php }  else { ?> disabled ='disabled'  <?php } ?>
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][source]"
                           value="3" <?php if ($rides_sheet_ride['SheetRideDetailRides']['source'] == 3) { ?> checked='checked' <?php } ?>>
                    <span class="label-radio"> <?php echo __('Existing ride') ?></span>
                    <input id='source4'
                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] <= StatusEnum::mission_closed) { ?>
                            onclick='javascript:getPersonalizedRide();'
                        <?php } else { ?> disabled ='disabled'  <?php } ?>
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][source]"
                           value="4" <?php if ($rides_sheet_ride['SheetRideDetailRides']['source'] == 4) { ?> checked='checked' <?php } ?>>
                    <span class="label-radio"> <?php echo __('Personalized ride') ?></span>
                </div>


            <?php } ?>

            <?php if (Configure::read("gestion_commercial") == '1') { ?>

                <div class="input-radio">
                    <p class="p-radio"><?php echo __('Invoiced ride') ?></p>
                    <input id='invoiced_ride1' class="input-radio"
                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) { ?>
                            disabled ='disabled'
                        <?php }else { ?> onclick='modifyInvoicedRide(1)'<?php } ?>
                           type="radio" name="data[SheetRideDetailRides][invoiced_ride]"
                           value="1"  <?php if ($rides_sheet_ride['SheetRideDetailRides']['invoiced_ride'] == 1) { ?>
                           checked='checked' <?php } ?>
                    <span class="label-radio"><?php echo __('Yes') ?></span>
                    <input id='invoiced_ride2'
                           class="input-radio" type="radio"
                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) { ?>
                            disabled ='disabled'
                        <?php }else { ?> onclick='modifyInvoicedRide(2)'<?php } ?>
                           name="data[SheetRideDetailRides][invoiced_ride]"
                           value="2"  <?php if ($rides_sheet_ride['SheetRideDetailRides']['invoiced_ride'] == 2) { ?> checked='checked' <?php } ?>>
                    <span class="label-radio"> <?php echo __('No') ?></span>
                </div>

            <?php } ?>


            <div class="input-radio" style="margin: 0 20px;">
                <p class="p-radio"><?php echo __('Truck full') ?></p>

                <input id='truck_full1' class="input-radio"
                    <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) { ?>
                        disabled ='disabled'
                    <?php } ?>
                       type="radio" name="data[SheetRideDetailRides][truck_full]"
                       value="1" <?php if ($rides_sheet_ride['SheetRideDetailRides']['truck_full'] == 1) { ?> checked='checked' <?php } ?>>
                <span class="label-radio"><?php echo __('Yes') ?></span>
                <input id='truck_full2'
                       class="input-radio" type="radio"
                    <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) { ?>
                        disabled ='disabled'
                    <?php } ?>
                       name="data[SheetRideDetailRides][truck_full]"
                       value="2" <?php if ($rides_sheet_ride['SheetRideDetailRides']['truck_full'] == 2) { ?> checked='checked' <?php } ?>>
                <span class="label-radio"> <?php echo __('No') ?></span>
            </div>
            <div class="input-radio">
                <p class="p-radio"><?php echo __('Type mission') ?></p>

                <input id='return_mission1' class="input-radio"
                    <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) { ?>
                        disabled ='disabled'
                    <?php } ?>
                       type="radio" name="data[SheetRideDetailRides][return_mission]"
                       value="1" <?php if ($rides_sheet_ride['SheetRideDetailRides']['return_mission'] == 1) { ?> checked='checked' <?php } ?>>
                <span class="label-radio"><?php echo __('Simple delivery') ?></span>
                <input id='return_mission2'
                       class="input-radio" type="radio"
                    <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) { ?>
                        disabled ='disabled'
                    <?php } ?>
                       name="data[SheetRideDetailRides][return_mission]"
                       value="2" <?php if ($rides_sheet_ride['SheetRideDetailRides']['return_mission'] == 2) { ?> checked='checked' <?php } ?>>
                <span class="label-radio"> <?php echo __('Simple return') ?></span>
            </div>
            <?php if($paramPriceNight == 1) { ?>
                <div class="input-radio">
                    <p class="p-radio"><?php echo __('Price') ?></p>

                    <input id='type_price1' class="input-radio"
                           type="radio" name="data[SheetRideDetailRides][type_price]"
                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) { ?>
                            disabled ='disabled'
                        <?php } ?>
                           value="1" <?php if ($rides_sheet_ride['SheetRideDetailRides']['type_price'] == 1) { ?> checked='checked' <?php } ?>>
                    <span class="label-radio"><?php echo __('Day') ?></span>
                    <input id='type_price2'
                           class="input-radio" type="radio"
                           name="data[SheetRideDetailRides][type_price]"
                        <?php if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) { ?>
                            disabled ='disabled'
                        <?php } ?>
                           value="2" <?php if ($rides_sheet_ride['SheetRideDetailRides']['type_price'] == 2) { ?> checked='checked' <?php } ?>>
                    <span class="label-radio"> <?php echo __('Night') ?></span>
                </div>
            <?php }


            echo "<div >" . $this->Form->input('SheetRideDetailRides.invoiced_ride', array(
                    'type' => 'hidden',
                    'id' => 'invoiced_ride',
                    'value' => $rides_sheet_ride['SheetRideDetailRides']['invoiced_ride'],
                    'class' => 'form-control'
                )) . "</div>";

            echo "<div >" . $this->Form->input('SheetRideDetailRides.truck_full', array(
                    'type' => 'hidden',
                    'id' => 'truck_full',
                    'value' => $rides_sheet_ride['SheetRideDetailRides']['truck_full'],
                    'class' => 'form-control'
                )) . "</div>";
            echo "<div >" . $this->Form->input('SheetRideDetailRides.transport_bill_detail_ride', array(
                    'type' => 'hidden',
                    'id' => 'transport_bill_detail_ride',
                    'value' => $rides_sheet_ride['SheetRideDetailRides']['transport_bill_detail_ride_id'],
                    'class' => 'form-control'
                )) . "</div>";

            echo "<div >" . $this->Form->input('SheetRideDetailRides.observation_id', array(
                    'type' => 'hidden',
                    'id' => 'observation',
                    'value' => $rides_sheet_ride['SheetRideDetailRides']['observation_id'],
                    'class' => 'form-control'
                )) . "</div>";
            echo "<div class='select-inline ' id='ride-div'>";

            if ($rides_sheet_ride['SheetRideDetailRides']['source'] == 4) {
                if (Configure::read("gestion_commercial") == '1'){
                    if( $rides_sheet_ride['SheetRideDetailRides']['status_id']
                        <= StatusEnum::mission_closed) {

                        echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.departure_destination_id', array(
                                'label' => __('Departure city'),
                                'id' => 'departure_destination',
                                'options' => $destinations,
                                'value' => $rides_sheet_ride['SheetRideDetailRides']['departure_destination_id'],
                                'class' => 'form-filter select-search-destination',
                                'onchange' => 'javascript:getInformationRide();',
                            )) . "</div>";

                        echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.arrival_destination_id', array(
                                'label' => __('Arrival city'),
                                'id' => 'arrival_destination',
                                'options' => $destinations,
                                'value' => $rides_sheet_ride['SheetRideDetailRides']['arrival_destination_id'],
                                'class' => 'form-filter select-search-destination',
                                'onchange' => 'javascript:getInformationRide();',
                            )) . "</div>";

                    }   else {

                        echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.departure_destination_id', array(
                                'label' => __('Departure city'),
                                'id' => 'departure_destination',
                                'options' => $destinations,
                                'disabled'=>true,
                                'value' => $rides_sheet_ride['SheetRideDetailRides']['departure_destination_id'],
                                'class' => 'form-filter select-search-destination',
                                'onchange' => 'javascript:getInformationRide();',
                            )) . "</div>";

                        echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.departure_destination_id', array(
                                'label' => __('Departure city'),
                                'id' => 'departure_destination' ,
                                'options' => $destinations,
                                'type'=>'hidden',
                                'value' => $rides_sheet_ride['SheetRideDetailRides']['departure_destination_id'],
                                'class' => 'form-filter',
                                'onchange' => 'javascript:getInformationRide();',
                            )) . "</div>";

                        echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.arrival_destination_id', array(
                                'label' => __('Arrival city'),
                                'id' => 'arrival_destination' ,
                                'options' => $destinations,
                                'disabled'=>true,
                                'value' => $rides_sheet_ride['SheetRideDetailRides']['arrival_destination_id'],
                                'class' => 'form-filter select-search-destination',
                                'onchange' => 'javascript:getInformationRide();',
                            )) . "</div>";

                        echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.arrival_destination_id', array(
                                'label' => __('Arrival city'),
                                'id' => 'arrival_destination',
                                'options' => $destinations,
                                'type'=>'hidden',
                                'value' => $rides_sheet_ride['SheetRideDetailRides']['arrival_destination_id'],
                                'class' => 'form-filter ',
                                'onchange' => 'javascript:getInformationRide();',
                            )) . "</div>";




                    }


                    echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.price', array(
                            'label' => __('Price'),
                            'id' => 'price' ,
                            'class' => 'form-filter',
                            'value' => $rides_sheet_ride['SheetRideDetailRides']['price'],
                        )) . "</div>";
                } else {
                    echo "<div class='form-group col-sm-6 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.departure_destination_id', array(
                            'label' => __('Departure city'),
                            'id' => 'departure_destination' ,
                            'options' => $destinations,
                            'required' => true,
                            'value' => $rides_sheet_ride['SheetRideDetailRides']['departure_destination_id'],
                            'class' => 'form-filter select-search-destination',
                            'onchange' => 'javascript:getInformationRide();',
                        )) . "</div>";

                    echo "<div class='form-group col-sm-6 clear-none p-l-0'>" . $this->Form->input('SheetRideDetailRides.arrival_destination_id', array(
                            'label' => __('Arrival city'),
                            'id' => 'arrival_destination' ,
                            'options' => $destinations,
                            'required' => true,
                            'value' => $rides_sheet_ride['SheetRideDetailRides']['arrival_destination_id'],
                            'class' => 'form-filter select-search-destination',
                            'onchange' => 'javascript:getInformationRide();',
                        )) . "</div>";
                }
            } else {

                if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) {

                    echo "<div  class='select-inline select-inline2' style='clear: both;'>" . $this->Form->input('SheetRideDetailRides.detail_ride_id', array(
                            'label' => __('Ride'),

                            'empty' => '',
                            'id' => 'detail_ride',
                            'value' => $rides_sheet_ride['DetailRide']['id'],
                            'disabled' => true,
                            'onchange' => 'javascript:getInformationRide();',
                            'class' => 'form-filter'
                        )) . "</div>";
                    echo "<div  class='select-inline select-inline2' style='clear: both;'>" . $this->Form->input('SheetRideDetailRides.detail_ride_id', array(
                            'label' => __('Ride'),

                            'empty' => '',
                            'id' => 'detail_ride',
                            'value' => $rides_sheet_ride['DetailRide']['id'],
                            'type' => 'hidden',
                            'onchange' => 'javascript:getInformationRide();',
                            'class' => 'form-filter'
                        )) . "</div>";
                } else {
                    echo "<div  class='select-inline select-inline2' style='clear: both;'>" . $this->Form->input('SheetRideDetailRides.detail_ride_id', array(
                            'label' => __('Ride'),

                            'empty' => '',
                            'id' => 'detail_ride',
                            'value' => $rides_sheet_ride['DetailRide']['id'],

                            'onchange' => 'javascript:getInformationRide();',
                            'class' => 'form-filter'
                        )) . "</div>";
                }
            }
            if ($useRideCategory == 2) {
                echo "<div  class='select-inline select-inline2' style='clear: both;'>" . $this->Form->input('SheetRideDetailRides.ride_category_id', array(
                        'label' => __('Category'),
                        'id' => 'ride_category' ,
                        'empty' => '',

                        'value' => $rides_sheet_ride['RideCategory']['id'],

                        'class' => 'form-filter'
                    )) . "</div>";
            }
            echo "</div>";
            ?>

            <?php if ($rides_sheet_ride['SheetRideDetailRides']['type_ride'] = 2) { ?>
                <div id='distance_duration_ride'>
                    <?php
                    echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_day', array(
                            'type' => 'hidden',
                            'id' => 'duration_day',
                            'value' => $rides_sheet_ride['DetailRides']['real_duration_day'],
                            'class' => 'form-control'
                        )) . "</div>";
                    echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_hour', array(
                            'type' => 'hidden',
                            'id' => 'duration_hour',
                            'value' => $rides_sheet_ride['DetailRides']['real_duration_hour'],
                            'class' => 'form-control'
                        )) . "</div>";

                    echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_minute', array(
                            'type' => 'hidden',
                            'id' => 'duration_minute',
                            'value' => $rides_sheet_ride['DetailRides']['real_duration_minute'],
                            'class' => 'form-control'
                        )) . "</div>";
                    $duration = $rides_sheet_ride['DetailRides']['real_duration_day'] . ' ' . __('Day') . ' ' . $rides_sheet_ride['DetailRides']['real_duration_hour'] . ' ' . __('Hour') . ' ' . $rides_sheet_ride['DetailRides']['real_duration_minute'] . ' ' . __('min');
                    echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.duration', array(
                            'label' => __('Duration'),
                            'disabled' => true,
                            'value' => $duration,
                            'class' => 'form-filter'
                        )) . "</div>";
                    echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.distance', array(
                            'readonly' => true,
                            'id' => 'distance',
                            'value' => $rides_sheet_ride['Rides']['distance'],
                            'class' => 'form-filter'
                        )) . "</div>"; ?>

                </div>
                <?php
            } else {
                ?>
                <div id='distance_duration_ride'>
                    <?php
                    echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_day', array(
                            'type' => 'hidden',
                            'id' => 'duration_day' ,
                            'value' => $rides_sheet_ride['DetailRide']['real_duration_day'],
                            'class' => 'form-control'
                        )) . "</div>";
                    echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_hour', array(
                            'type' => 'hidden',
                            'id' => 'duration_hour' ,
                            'value' => $rides_sheet_ride['DetailRide']['real_duration_hour'],
                            'class' => 'form-control'
                        )) . "</div>";

                    echo "<div >" . $this->Form->input('SheetRideDetailRides.duration_minute', array(
                            'type' => 'hidden',
                            'id' => 'duration_minute',
                            'value' => $rides_sheet_ride['DetailRide']['real_duration_minute'],
                            'class' => 'form-control'
                        )) . "</div>";
                    $duration = $rides_sheet_ride['DetailRide']['real_duration_day'] . ' ' . __('Day') . ' ' . $rides_sheet_ride['DetailRide']['real_duration_hour'] . ' ' . __('Hour') . ' ' . $rides_sheet_ride['DetailRide']['real_duration_minute'] . ' ' . __('min');
                    echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.duration', array(
                            'label' => __('Duration'),
                            'disabled' => true,
                            'value' => $duration,
                            'class' => 'form-filter'
                        )) . "</div>";

                    ?>


                    <?php   echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.distance', array(
                            'readonly' => true,
                            'id' => 'distance',
                            'value' => $rides_sheet_ride['Ride']['distance'],
                            'class' => 'form-filter'
                        )) . "</div>"; ?>

                </div>
                <?php
            }
            echo "<div style='clear:both; padding-top: 10px;'></div>";
            if (Configure::read("gestion_commercial") == '1') {
                if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) {

                    echo "<div class='select-inline' id='client-initial-div'>" . $this->Form->input('SheetRideDetailRides.supplier_id', array(
                            'label' => __('Initial customer'),
                            'empty' => '',
                            'id' => 'client' ,
                            'disabled' => true,
                            'value' => $rides_sheet_ride['Supplier']['id'],
                            'onchange' => 'javascript:getMarchandisesByClient(this.id), getAttachmentsByClient(this.id) , getFinalSupplierByInitialSupplier(this.id);',
                            'class' => 'form-filter select-search-client-initial'
                        )) . "</div>";

                    echo "<div class='select-inline' id='client-initial-div'>" . $this->Form->input('SheetRideDetailRides.supplier_id', array(
                            'label' => __('Initial customer'),
                            'empty' => '',
                            'id' => 'client' ,
                            'type' => 'hidden',
                            'value' => $rides_sheet_ride['Supplier']['id'],
                            'onchange' => 'javascript:getMarchandisesByClient(this.id), getAttachmentsByClient(this.id) , getFinalSupplierByInitialSupplier(this.id);',
                            'class' => 'form-filter'
                        )) . "</div>";


                } else {
                    echo "<div class='select-inline' id='client-initial-div'>" . $this->Form->input('SheetRideDetailRides.supplier_id', array(
                            'label' => __('Initial customer'),
                            'empty' => '',
                            'id' => 'client' ,
                            'value' => $rides_sheet_ride['Supplier']['id'],
                            'onchange' => 'javascript:getMarchandisesByClient(this.id), getAttachmentsByClient(this.id) , getFinalSupplierByInitialSupplier(this.id);',
                            'class' => 'form-filter select-search-client-initial'
                        )) . "</div>";
                }
            }


            echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.km_departure', array(
                    'label' => __('Departure Km'),
                    'onchange' => 'javascript:calculKmArrivalEstimated(this.id), verifyKmEntred(this.id,"departure");',
                    'value' => $rides_sheet_ride['SheetRideDetailRides']['km_departure'],
                    'id' => 'km_departure' ,
                    'class' => 'form-filter'
                )) . "</div>";


            echo "<div class='datedep'>" . $this->Form->input('SheetRideDetailRides.planned_start_date', array(
                    'label' => '',
                    'type' => 'text',
                    'value' => $this->Time->format($rides_sheet_ride['SheetRideDetailRides']['planned_start_date'], '%d/%m/%Y %H:%M'),
                    'class' => 'form-control datemask',
                    'placeholder' => _('dd/mm/yyyy hh:mm'),
                    'before' => '<label class="dte">' . __('Planned Departure date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'planned_start_date' ,
                    'onchange' => 'javascript:calculPlannedArrivalDate(this.id);',
                )) . "</div>";

            echo "<div class='datedep'>" . $this->Form->input('SheetRideDetailRides.real_start_date', array(
                    'label' => '',
                    'type' => 'text',
                    'value' => $this->Time->format($rides_sheet_ride['SheetRideDetailRides']['real_start_date'], '%d/%m/%Y %H:%M'),
                    'class' => 'form-control datemask',
                    'placeholder' => _('dd/mm/yyyy hh:mm'),
                    'before' => '<label class="dte">' . __('Real Departure date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'real_start_date' ,
                    'onchange' => 'javascript:calculPlannedArrivalDate(this.id);',
                )) . "</div>";
            echo "<div style='clear:both; padding-top: 10px;'></div>";

            if ($displayMissionCost == 2) {

                echo "<div class ='scroll-block'>";
                echo "<div class='lbl2'> <a href='#demo' data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Mission costs") . "</a></div>";
                echo "<div id='demo' class='collapse'>";

                if (!empty($rides_sheet_ride['SheetRideDetailRides']['mission_cost'])) {
                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                            'label' => __('Mission cost'),
                            'value' => $rides_sheet_ride['SheetRideDetailRides']['mission_cost'],
                            'placeholder' => __('Enter mission cost'),
                            'id' => 'mission_cost' ,
                            'class' => 'form-filter'
                        )) . "</div>";

                } else {
                    switch ($managementParameterMissionCost) {

                        case '1':
                            if (!empty($missionCost['mission_cost_day'])) {
                                echo "<div  class='select-inline' >" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                                        'label' => __('Mission cost'),
                                        'placeholder' => __('Enter mission cost'),
                                        'id' => 'mission_cost',
                                        'value' => $missionCost['MissionCost']['cost_day'],
                                        'class' => 'form-filter'
                                    )) . "</div>";
                            } else {
                                echo "<div  class='select-inline' >" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                                        'label' => __('Mission cost'),
                                        'placeholder' => __('Enter mission cost'),
                                        'id' => 'mission_cost',
                                        'class' => 'form-filter'
                                    )) . "</div>";
                            }
                            break;

                        case '2':
                            if (!empty($missionCost['mission_cost_mission'])) {
                                echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                                        'label' => __('Mission cost'),
                                        'placeholder' => __('Enter mission cost'),
                                        'id' => 'mission_cost',
                                        'value' => $missionCost['MissionCost']['cost_destination'],
                                        'class' => 'form-filter'
                                    )) . "</div>";
                            } else {
                                echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                                        'label' => __('Mission cost'),

                                        'placeholder' => __('Enter mission cost'),
                                        'id' => 'mission_cost' ,

                                        'class' => 'form-filter'
                                    )) . "</div>";
                            }

                            break;

                        case '3':
                            if (!empty($missionCost['MissionCost']['cost_truck_full'])) {
                                echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                                        'label' => __('Mission cost'),
                                        'placeholder' => __('Enter mission cost'),
                                        'id' => 'mission_cost' ,
                                        'value' => $missionCost['MissionCost']['cost_truck_full'],
                                        'class' => 'form-filter'
                                    )) . "</div>";
                            } else {

                                echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                                        'label' => __('Mission cost'),
                                        'placeholder' => __('Enter mission cost'),
                                        'id' => 'mission_cost' ,
                                        'class' => 'form-filter'
                                    )) . "</div>";
                            }

                            break;

                    }
                }

                echo '</div>';
                echo '</div>';

            } else {

                if (!empty($rides_sheet_ride['SheetRideDetailRides']['mission_cost'])) {
                    echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                            'label' => __('Mission cost'),
                            'type' => 'hidden',
                            'placeholder' => __('Enter mission cost'),
                            'id' => 'mission_cost',
                            'class' => 'form-filter'
                        )) . "</div>";

                } else {
                    switch ($managementParameterMissionCost) {
                        case '1':
                            echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                                    'label' => __('Mission cost'),
                                    'type' => 'hidden',
                                    'placeholder' => __('Enter mission cost'),
                                    'id' => 'mission_cost' ,
                                    'value' => $missionCost['mission_cost_day'],
                                    'class' => 'form-filter'
                                )) . "</div>";
                            break;

                        case '2':
                            echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                                    'label' => __('Mission cost'),
                                    'type' => 'hidden',
                                    'placeholder' => __('Enter mission cost'),
                                    'id' => 'mission_cost' ,
                                    'value' => $missionCost['mission_cost_mission'],
                                    'class' => 'form-filter'
                                )) . "</div>";
                            break;

                        case '3':

                            echo "<div  class='select-inline'>" . $this->Form->input('SheetRideDetailRides.mission_cost', array(
                                    'label' => __('Mission cost'),
                                    'type' => 'hidden',
                                    'placeholder' => __('Enter mission cost'),
                                    'id' => 'mission_cost' ,
                                    'value' => $missionCost['MissionCost']['cost_truck_full'],
                                    'class' => 'form-filter'
                                )) . "</div>";
                            break;

                    }
                }

            }

            echo "<div class ='scroll-block'>";
            echo '<div class="lbl2"> <a href="#demoPeage" data-toggle="collapse"><i class="fa fa-angle-double-right" style="padding-right: 10px;"></i>' . __("Tolls") . '</a></div>'; ?>
            <div id="demoPeage" class="collapse">
                <br>

                <?php
                echo "<div style='clear:both; padding-top: 10px;'></div>";
                echo "<div  class='select-inline' id='toll-div'>" . $this->Form->input('SheetRideDetailRides.toll', array(
                        'label' => __('Toll'),
                        'value'=>$rides_sheet_ride['SheetRideDetailRides']['toll'],
                        'placeholder' => __('Enter toll'),
                        'id' => 'toll' ,
                        'class' => 'form-filter '
                    )) . "</div>";
                ?>
            </div>
        </div>

        <?php

        echo "<div class ='scroll-block'>";
        echo "<div class='lbl2'> <a href='#note' data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Observation") . "</a></div>";
        echo "<div id='note' class='collapse'><br>";
        echo "<div class='select-inline' >" . $this->Form->input('SheetRideDetailRides.note', array(
                'label' => __('Observation'),
                'value' => $rides_sheet_ride['SheetRideDetailRides']['note'],
                'class' => 'form-control'
            )) . "</div>";
        echo "</div>";
        echo "</div>";

        ?>



    </td>
</tr>
<tr id="arrive" <?php if ($isAgent) {?> class='hidden'<?php } ?>>
    <td>arrivée</td>
    <td>
        <div class="filters" id='filters'>
            <?php

            if (Configure::read("gestion_commercial") == '1') {

                if ($rides_sheet_ride['SheetRideDetailRides']['status_id'] > StatusEnum::mission_closed) {
                    echo "<div class='select-inline' id='client-final-div'>" . $this->Form->input('SheetRideDetailRides.supplier_final_id', array(
                            'label' => __('Final customer'),
                            'empty' => '',
                            'options' => $finalSuppliers,
                            'value' => $rides_sheet_ride['SupplierFinal']['id'],
                            'disabled' => true,
                            'class' => 'form-filter'
                        )) . "</div>";
                    echo "<div class='select-inline' >" . $this->Form->input('SheetRideDetailRides.supplier_final_id', array(
                            'label' => __('Final customer'),
                            'empty' => '',
                            'id' => 'client_final',
                            //'options' => $finalSuppliers,
                            'value' => $rides_sheet_ride['SupplierFinal']['id'],
                            'type' => 'hidden',
                            'class' => 'form-filter'
                        )) . "</div>";

                } else {
                    echo "<div class='select-inline' id='client-final-div'>" . $this->Form->input('SheetRideDetailRides.supplier_final_id', array(
                            'label' => __('Final customer'),
                            'empty' => '',
                            'id' => 'client_final' ,
                            'options' => $finalSuppliers,
                            'value' => $rides_sheet_ride['SupplierFinal']['id'],
                            // 'disabled'=>true,
                            'class' => 'form-filter select-search-client-final-i'
                        )) . "</div>";
                }
            }

            echo "<div  class='datedep'>" . $this->Form->input('SheetRideDetailRides.planned_end_date', array(
                    'label' => '',
                    'type' => 'text',
                    'value' => $this->Time->format($rides_sheet_ride['SheetRideDetailRides']['planned_end_date'], '%d/%m/%Y %H:%M'),
                    'class' => 'form-control datemask',
                    'placeholder' => _('dd/mm/yyyy hh:mm'),
                    'before' => '<label class="dte">' . __('Planned Arrival date ') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'planned_end_date' ,

                )) . "</div>";

            echo "<div >" . $this->Form->input('SheetRideDetailRides.remaining_time', array(
                    'label' => '',
                    'class' => 'form-control',
                    'id' => 'tempRestant',
                    'value' => $rides_sheet_ride['SheetRideDetailRides']['remaining_time'],
                    'type' => 'hidden'
                )) . "</div>";

            echo "<div  class='datedep'>" . $this->Form->input('SheetRideDetailRides.real_end_date', array(
                    'label' => '',
                    'type' => 'text',
                    'value' => $this->Time->format($rides_sheet_ride['SheetRideDetailRides']['real_end_date'], '%d/%m/%Y %H:%M'),
                    'class' => 'form-control datemask',
                    'placeholder' => _('dd/mm/yyyy hh:mm'),
                    'before' => '<label class="dte">' . __('Real Arrival date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                    'after' => '</div>',
                    'id' => 'real_end_date',
                )) . "</div>";

            echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.km_arrival_estimated', array(
                    'label' => __('Arrival Km estimated'),
                    'readonly' => true,
                    'id' => 'km_arrival_estimated' ,
                    'value' => $rides_sheet_ride['SheetRideDetailRides']['km_arrival_estimated'],
                    'class' => 'form-filter'
                )) . "</div>";

            echo "<div class='select-inline'>" . $this->Form->input('SheetRideDetailRides.km_arrival', array(
                    'label' => __('Arrival Km'),
                    'value' => $rides_sheet_ride['SheetRideDetailRides']['km_arrival'],
                    'id' => 'km_arrival',
                    'class' => 'form-filter'
                )) . "</div>";

            ?>
            <?php
            echo "<div style='clear:both; padding-top: 10px;'></div>"; ?>

            <div class="scroll-block100">
                <?php echo "<div class='lbl2'> <a href='#piece' data-toggle='collapse' id='pieceClient' onclick='getAttachmentsByClient(this.id)'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Attachments") . "</a></div>";

                echo "<div id='piece' class='collapse'>";

                echo "<div id = 'piece-div'>";

                echo "</div>";
                echo "</div>";?>
            </div>
            </br>

            <div class="scroll-block100">
                <?php
                echo "<div class='lbl2'> <a href='#march' id='marchandiseClient' onclick='getSavedMarchandises()' data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Marchandises") . "</a></div>";
                echo "<div id='march' class='collapse'>";
                echo "<div id='marchandise-div' class='marchandise-input'>" . $this->Form->input('SheetRideDetailRides.marchandise_id', array(
                        'label' => __(''),
                        'empty' => '',
                        'id' => 'marchandise',
                        'multiple' => true,
                        'class' => 'form-filter select3'
                    )) . "</div>";
                echo "</div>";
                echo "</div>";



                ?>

            </div>
            <?php

            if($usePurchaseBill == '1'){ ?>
                <div class="scroll-block100" style="margin-top: 5px;">
                    <?php echo "<div class='lbl2'> <a href='#lot' id ='lotClient' onclick='getLots(this.id)'  data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Products") . "</a></div>";

                    echo "<div id='lot' class='collapse'>";
                    echo "<div id = 'lot-div'>";
                    echo "<div>" . $this->Form->input('SheetRideDetailRides.edit_lot', array(
                            'type' => 'hidden',
                            'value' => '0',
                            'id' => 'edit_lot' ,
                            'multiple' => true,
                            'class' => 'form-filter '
                        )) . "</div>";
                    echo "</div>";

                    ?>
                </div>
            <?php } ?>

        </div>
        <!-- COMPONENT END -->
    </td>
</tr>
</table>
        <div style="clear:both;"></div>
        <div class="box-footer">
            <?php echo $this->Form->submit(__('Submit'), array(
                'name' => 'ok',
                'class' => 'btn btn-primary btn-bordred  m-b-5',
                'label' => __('Submit'),
                'id' => 'submitButton',
                'type' => 'submit',
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
<?php if($calculByMaps == 1){ ?>
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB33Wa5iG-fztbIhYh60y9YGaZoKuCOPho&libraries=places">
    </script>

<?php } ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('maskedinput'); ?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>

<script type="text/javascript">


    $(document).ready(function () {
        //jQuery('.selectCoupon').select2();

        $('#submitButton').on('click', function (e) {

            var submit = true;

            $(':input[required]').each(function () {

                if ($(this).val() == '') {
                    submit = false;
                }
            });
            if (submit) {
                $('form#SheetRideDetailRidesAddForm').submit();
            }





        });


        jQuery("#planned_start_date").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
        jQuery("#real_start_date").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
        jQuery("#planned_end_date").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
        jQuery("#real_end_date").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});


        if(jQuery('#transport_personnel').val()==1){
            $('.select-search-destination').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/destinations/getDestinationsByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 3
            });
            var carId = jQuery('#cars').val();
            $('.select-search-car').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/cars/getCarsByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            controller: jQuery('#controller').val(),
                            action: jQuery('#current_action').val(),
                            carId: carId
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2
            });
            var customerId = jQuery('#customers').val();
            $('.select-search-customer').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/customers/getCustomersByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            controller: jQuery('#controller').val(),
                            action: jQuery('#current_action').val(),
                            customerId: customerId
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2
            });

        }


            if (jQuery('#source1').is(':checked')) {

                jQuery('#ride-div').addClass('select-inline2');
                var detail_ride_id = jQuery('#detail_ride').val();

                var type_id = jQuery("#car_type").val();

                if (type_id == '') type_id = 0;
                var transport_bill_detail_ride_id = jQuery('#transport_bill_detail_ride').val();
                var status = jQuery('#status').val();
                jQuery('#ride-div').load('<?php echo $this->Html->url('/sheetRideDetailRides/getRidesFromCustomerOrder/')?>'  + type_id + '/' + transport_bill_detail_ride_id + '/' + detail_ride_id+ '/' +status, function () {

                    jQuery('.select3').select2();

                });
            }
            if (jQuery('#source2').is(':checked')) {

                jQuery('#ride-div').addClass('select-inline2');

                var type_id = jQuery("#car_type").val();

                if (type_id == '') type_id = 0;
                var transport_bill_detail_ride_id = jQuery('#transport_bill_detail_ride').val();
                var status = jQuery('#status').val();

                jQuery('#ride-div').load('<?php echo $this->Html->url('/sheetRideDetailRides/getPersonalizedRidesFromCustomerOrder/')?>'  + type_id + '/' + transport_bill_detail_ride_id +  '/' +status, function () {

                    jQuery('.select3').select2();
                    $('.select-search-destination').select2({
                        ajax: {
                            url: "<?php echo $this->Html->url('/destinations/getDestinationsByKeyWord')?>",
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    q: $.trim(params.term)
                                };
                            },
                            processResults: function (data, page) {
                                return {results: data};
                            },
                            cache: true
                        },
                        minimumInputLength: 3

                    });

                });
            }



            var fieldMarchandiseRequired = jQuery('#fieldMarchandiseRequired').val();
            if(fieldMarchandiseRequired==1){
                var id = 'marchandiseClient';

                if (jQuery('#sheet_ride_detail_ride').length > 0) {
                    if (!$("#marchandise-div" ).is(':empty')) {
                        getSavedMarchandises();

                        jQuery('#march').addClass('in');
                    }
                } else {
                    if ($("#marchandise-div").is(':empty')) {
                        getMarchandisesByClient();

                        jQuery('#march').addClass('in');
                    }
                }

            }

            if (jQuery('#status').val() < 4) {
                var id = 'client';
                if(jQuery('#gestion_commercial' ).val()==1){
                    getFinalSupplierByInitialSupplier();
                }
            }
    });
    function calculPlannedArrivalDate(id) {

        if (jQuery('#source4').prop('checked')) {
            var detail_ride = 0;
        } else {
            var detail_ride = parseInt(jQuery("#detail_ride").val());
        }

        if (detail_ride >= 0) {

            if (jQuery("#real_start_date").val()) {

                var s_arr = jQuery("#real_start_date").val().split(/\/|\s|:/);
            } else {

                var s_arr = jQuery("#planned_start_date").val().split(/\/|\s|:/);
            }
            var myDate = new Date(s_arr[1] + "," + s_arr[0] + "," + s_arr[2] + "," + s_arr[3] + ":" + s_arr[4] + ":00");

            var averageSpeed = jQuery('#average_speed').val();
            if (averageSpeed > 0) {
                var averageSpeedPerMin = parseFloat(averageSpeed) / 60;
                var distance = jQuery('#distance').val();
                var totalMin = parseFloat(distance) / parseFloat(averageSpeedPerMin);
            } else {
                var nb_day = parseInt(jQuery("#duration_day").val());
                var nb_hour = parseInt(jQuery("#duration_hour").val());
                var nb_min = parseInt(jQuery("#duration_minute").val());
                var totalMin = (24 * 60 * nb_day) + (60 * nb_hour) + nb_min;

            }


            var maximumDrivingTimePerMin = parseFloat(jQuery('#param_maximum_driving_time').val()) * 60;
            var breakTimePerMin = parseFloat(jQuery('#param_break_time').val()) * 60;
            var additionalTimeAllowedPerMin = parseFloat(jQuery('#param_additional_time_allowed').val()) * 60;

                var precedentTempsRestant = jQuery('#tempRestant0').val();

                if (parseFloat(totalMin) > parseFloat(precedentTempsRestant)) {
                    totalMin = totalMin - precedentTempsRestant;
                    var totalMinDivMaximumDrivingTimePerMin = (totalMin / maximumDrivingTimePerMin);
                    totalMinDivMaximumDrivingTimePerMin = parseInt(totalMinDivMaximumDrivingTimePerMin);
                    var totalMinModMaximumDrivingTimePerMin = (totalMin % maximumDrivingTimePerMin);

                    var tempRestant = maximumDrivingTimePerMin - totalMinModMaximumDrivingTimePerMin;
                    jQuery("#tempRestant" ).val(tempRestant);

                    if (parseFloat(totalMinDivMaximumDrivingTimePerMin) > 0) {
                        if (parseFloat(precedentTempsRestant) > 0) {
                            if (parseFloat(totalMinModMaximumDrivingTimePerMin) < parseFloat(additionalTimeAllowedPerMin)) {
                                var totalDurationPerMin = parseFloat(precedentTempsRestant) + parseFloat(breakTimePerMin) +
                                    (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                                    ((totalMinDivMaximumDrivingTimePerMin - 1) * breakTimePerMin) +
                                    parseFloat(totalMinModMaximumDrivingTimePerMin);

                            } else {
                                var totalDurationPerMin = parseFloat(precedentTempsRestant) + parseFloat(breakTimePerMin) +
                                    (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                                    (totalMinDivMaximumDrivingTimePerMin * breakTimePerMin) +
                                    parseFloat(totalMinModMaximumDrivingTimePerMin);
                            }
                        } else {

                            if (parseFloat(totalMinModMaximumDrivingTimePerMin) < parseFloat(additionalTimeAllowedPerMin)) {
                                var totalDurationPerMin =
                                    (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                                    ((totalMinDivMaximumDrivingTimePerMin - 1) * breakTimePerMin) +
                                    parseFloat(totalMinModMaximumDrivingTimePerMin);
                            } else {
                                var totalDurationPerMin =
                                    (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                                    (totalMinDivMaximumDrivingTimePerMin * breakTimePerMin) +
                                    parseFloat(totalMinModMaximumDrivingTimePerMin);
                            }

                        }

                    } else {

                        var totalDurationPerMin = parseFloat(precedentTempsRestant) +
                            parseFloat(breakTimePerMin) + parseFloat(totalMin);


                    }
                } else {
                    var tempRestant = parseFloat(precedentTempsRestant) - parseFloat(totalMin);
                    jQuery("#tempRestant" + '' + num + '').val(tempRestant);
                    var totalDurationPerMin = parseFloat(totalMin);
                }


            var nbHour = totalDurationPerMin / 60;
            nbHour = parseInt(nbHour);
            var nbMin = totalDurationPerMin % 60;
            var nbDay = nbHour / 24;
            nbDay = parseInt(nbDay);
            nbHour = nbHour % 24;
            nb_day = nbDay;
            nb_hour = nbHour;
            nb_min = nbMin;
            var dayOfMonth = myDate.getDate();
            myDate.setDate(dayOfMonth + nb_day);
            var dayOfMonth = myDate.getHours();
            myDate.setHours(dayOfMonth + nb_hour);
            var dayOfMonth = myDate.getMinutes();
            myDate.setMinutes(dayOfMonth + nb_min);
            var dayOfMonth = myDate.getMonth();
            var day = myDate.getDate();
            day = parseInt(day);
            if (day >= 0 && day < 10) {

                day = '0' + day;
            }
            var month = myDate.getMonth();
            var year = myDate.getFullYear();
            var hour = myDate.getHours();
            hour = parseInt(hour);
            if (hour >= 0 || hour <= 10) {
                hour = '0' + hour;
            }
            var min = myDate.getMinutes();
            min = parseInt(min);
            if (min >= 0 && min <= 10) {
                min = '0' + min;
            }
            switch (month) {
                case 0:
                    var valMonth = '01';
                    break;
                case 1:
                    var valMonth = '02';
                    break;
                case 2:
                    var valMonth = '03';
                    break;
                case 3:
                    var valMonth = '04';
                    break;
                case 4:
                    var valMonth = '05';
                    break;
                case 5:
                    var valMonth = '06';
                    break;
                case 6:
                    var valMonth = '07';
                    break;
                case 7:
                    var valMonth = '08';
                    break;
                case 8:
                    var valMonth = '09';
                    break;
                case 9:
                    var valMonth = '10';
                    break;
                case 10:
                    var valMonth = '11';
                    break;
                case 11:
                    var valMonth = '12';
                    break;
            }
            var end_date = day + "/" + valMonth + "/" + year + " " + hour + ":" + min;
            jQuery("#planned_end_date" ).val(end_date);

        }
    }


    function calculKmArrivalEstimated(id) {
        var distance = jQuery('#distance').val();
        var km_departure = jQuery('#km_departure').val();
        if (km_departure >= 0 && distance >= 0) {
            var km_estimated = parseFloat(km_departure) + parseFloat(distance);
            jQuery('#km_arrival_estimated').val(km_estimated);

        }

    }



    function getInformationRide() {
        var ride_id = jQuery("#detail_ride").val();
        if (ride_id != '') {

            if (jQuery('#source1').prop('checked') || jQuery('#source2').prop('checked')) {

                var transport_bill_detail_ride_id = jQuery('#detail_ride').val();

                jQuery('#transport_bill_detail_ride').val(transport_bill_detail_ride_id);
                var from_customer_order = 1;
                var arrival_from_customer_order = 1;
                jQuery('#client-initial-div').load('<?php echo $this->Html->url('/sheetRideDetailRides/getClientInitialFromCustomerOrder/')?>' + ride_id, function () {

                    getMarchandisesByClient();
                    getAttachmentsByClient();
                });


                jQuery('#client-final-div').load('<?php echo $this->Html->url('/sheetRideDetailRides/getClientFinalFromCustomerOrder/')?>' + ride_id, function () { ;
                });
            } else {

                jQuery('#client-initial-div').load('<?php echo $this->Html->url('/sheetRideDetailRides/getClientInitial/')?>', function () {
                    $('.select-search-client-initial').select2({
                        ajax: {
                            url: "<?php echo $this->Html->url('/suppliers/getInitialSuppliersByKeyWord')?>",
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    q: $.trim(params.term)
                                };
                            },
                            processResults: function (data, page) {
                                return {results: data};
                            },
                            cache: true
                        },
                        minimumInputLength: 2
                    });
                });
                jQuery('#client-final-div').load('<?php echo $this->Html->url('/sheetRideDetailRides/getClientFinal/')?>');
                /*  si le trajet personnalisé a été choisi*/
                if (jQuery('#source4' + '' + num + '').prop('checked')) {
                    var from_customer_order = 4;
                    var arrival_from_customer_order = 4;
                    var ride_id = 0;
                } else {
                    var from_customer_order = 0;
                    var arrival_from_customer_order = 0;
                }
            }
            if (jQuery("#ride_category").val()) {
                var ride_category_id = jQuery("#ride_category").val();
            } else {
                var ride_category_id = 0;
            }

            jQuery('#mission-cost-div').load('<?php echo $this->Html->url('/sheetRideDetailRides/getMissionCost/')?>' + ride_id + '/'  + from_customer_order + '/' + ride_category_id);

            if (jQuery('#truck_full1').prop('checked')) {
                var truck_full = 1;
            } else {
                var truck_full = 2;
            }
            if (ride_id == 0) {
                var departure_destination_id = jQuery("#departure_destination").val();
                var arrival_destination_id = jQuery("#arrival_destination").val();
                var carTypeId = jQuery('#car_type').val();
            } else {
                var departure_destination_id = 0;
                var arrival_destination_id = 0;
            }
            jQuery('#distance_duration_ride' + '' + num + '').load(
                '<?php echo $this->Html->url('/sheetRideDetailRides/getInformationRide/')?>' + ride_id + '/' + from_customer_order + '/' + truck_full + '/' + ride_category_id + '/' + departure_destination_id + '/' + arrival_destination_id+'/'+carTypeId,
                function () {

                    // estimateCost();
                });

        }else {
            jQuery('#client-initial-div' ).load('<?php echo $this->Html->url('/sheetRideDetailRides/getClientInitial/')?>' , function () {
                $('.select-search-client-initial').select2({
                    ajax: {
                        url: "<?php echo $this->Html->url('/suppliers/getInitialSuppliersByKeyWord')?>",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: $.trim(params.term)
                            };
                        },
                        processResults: function (data, page) {
                            return {results: data};
                        },
                        cache: true
                    },
                    minimumInputLength: 2

                });
            });
            jQuery('#client-final-div').load('<?php echo $this->Html->url('/sheetRideDetailRides/getClientFinal/')?>');

            jQuery('#distance_duration_ride').load(
                '<?php echo $this->Html->url('/sheetRideDetailRides/getInformationRide/')?>' + 0 + '/' + from_customer_order + '/' + truck_full + '/' + 0 + '/' + 0 + '/' + 0,
                function () {});
        }
    }


    function getMissionCost() {
        var rideId = jQuery("#detail_ride").val();

        if (jQuery("#ride_category").val()) {

            var rideCategoryId = jQuery("#ride_category").val();
        } else {

            var rideCategoryId = '';
        }
        if (jQuery('#source1').prop('checked')) {
            var fromCustomerOrder = 1;

        } else {
            var fromCustomerOrder = 0;
        }

        jQuery('#mission-cost-div').load('<?php echo $this->Html->url('/sheetRideDetailRides/getMissionCost/')?>' + rideId + '/' + fromCustomerOrder + '/' + rideCategoryId);
    }
    function getRidesFromCustomerOrder() {



        var type_id = jQuery("#car_type").val();
        if (type_id == '') type_id = 0;
        jQuery('#ride-div').load('<?php echo $this->Html->url('/sheetRideDetailRides/getRidesFromCustomerOrder/')?>'+ type_id, function () {
            jQuery('.select3').select2();
        });

    }


    function getPersonalizedRidesFromCustomerOrder() {
        jQuery('#ride-div').addClass('select-inline2');
        var typeId = jQuery("#car_type").val();
        jQuery('#ride-div').load('<?php echo $this->Html->url('/sheetRideDetailRides/getPersonalizedRidesFromCustomerOrder/')?>'  + typeId, function () {
            jQuery('.select3').select2();
        });
    }

    function getRidesByType() {
        var type_id = jQuery("#car_type").val();
        if (type_id == '') type_id = 0;
        jQuery('#ride-div').load('<?php echo $this->Html->url('/sheetRideDetailRides/getRidesByType/')?>'  + type_id, function () {
            $('.select-search-detail-ride').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/detailRides/getDetailRidesByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            carTypeId: jQuery('#car_type').val()
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 3

            });
        });
        jQuery('#client-initial-div').load('<?php echo $this->Html->url('/sheetRideDetailRides/getClientInitial/')?>' , function () {
            $('.select-search-client-initial').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/suppliers/getInitialSuppliersByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2

            });
        });
        jQuery('#client-final-div').load('<?php echo $this->Html->url('/sheetRideDetailRides/getClientFinal/')?>');

    }


    function getPersonalizedRide() {
        jQuery('#ride-div' ).removeClass('select-inline2');
        jQuery('#ride-div').load('<?php echo $this->Html->url('/sheetRideDetailRides/getPersonalizedRide/')?>', function () {
            $('.select-search-destination').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/destinations/getDestinationsByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 3

            });

        });
        jQuery('#client-initial-div' ).load('<?php echo $this->Html->url('/sheetRideDetailRides/getClientInitial/')?>' , function () {
            $('.select-search-client-initial').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/suppliers/getInitialSuppliersByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2

            });
        });

        jQuery('#client-final-div').load('<?php echo $this->Html->url('/sheetRideDetailRides/getClientFinal/')?>' );
    }

    function getMarchandisesByClient(id) {
        var clientId = jQuery('#client').val();
        var nb_marchandise = 1;
        var fieldMarchandiseRequired = jQuery('#fieldMarchandiseRequired').val();
        jQuery('#marchandise-div').load('<?php echo $this->Html->url('/sheetRideDetailRides/getMarchandisesByClient/')?>' + clientId + '/' + nb_marchandise, function () {
            $(".select3").select2();
            if(fieldMarchandiseRequired==1){
                jQuery('#marchandise' + nb_marchandise+'').parent().addClass('required');
                jQuery('#quantity' + nb_marchandise+'').parent().addClass('required');
            }
        });
    }

    function getSavedMarchandises() {

        var sheetRideDetailRideId = jQuery('#sheet_ride_detail_ride').val();
        var clientId = jQuery('#client').val();
        var fieldMarchandiseRequired = jQuery('#fieldMarchandiseRequired').val();
        jQuery('#marchandise-div').load('<?php echo $this->Html->url('/sheetRideDetailRides/getSavedMarchandises/')?>' + clientId + '/' + sheetRideDetailRideId, function () {
            $(".select3").select2();
            var nbMarchandise = jQuery('#nb_marchandise').val();

            if(fieldMarchandiseRequired==1){
                for(var i =1; i<= nbMarchandise; i++){
                    jQuery('#marchandise' + '' +  i+'').parent().addClass('required');
                    jQuery('#quantity' + '' +  i+'').parent().addClass('required');
                }

            }
        });

    }

    function getAttachmentsByClient() {

        var clientId = jQuery('#client').val();
        var sheetRideDetailRideId = jQuery('#sheet_ride_detail_ride').val();
        if (clientId > 0) {
            jQuery('#piece-div' ).load('<?php echo $this->Html->url('/sheetRideDetailRides/getAttachmentsByClient/')?>' + clientId +  '/' + sheetRideDetailRideId, function () {
                $(".select3").select2();
            });
        }
    }



    function getLots(id) {
        var sheetRideDetailRideId = jQuery('#sheet_ride_detail_ride').val();
        jQuery('#lot-div' + '' + num + '').load('<?php echo $this->Html->url('/sheetRideDetailRides/getLots/')?>' + + sheetRideDetailRideId, function () {
            $(".select3").select2();
        });
    }
    function addOtherMarchandises(i) {

        var nb_marchandise = jQuery('#nb_marchandise').val();
        var i = parseInt(nb_marchandise) + 1;

        jQuery('#nb_marchandise' ).val(i);
        var clientId = jQuery('#client').val();
        var fieldMarchandiseRequired = jQuery('#fieldMarchandiseRequired').val();
        $('#dynamic_field').append('<tr id="row' + '' + i + '" style="height: 70px;"><td ></td></tr>');
        jQuery("#row"  + '' + i + '').load('<?php echo $this->Html->url('/sheetRideDetailRides/addOtherMarchandises/')?>' + clientId +  '/' + i, function () {

            $(".select3").select2();

            if(fieldMarchandiseRequired==1){
                jQuery('#marchandise' + '' + i+'').parent().addClass('required');
                jQuery('#quantity' + '' + i+'').parent().addClass('required');
            }
        });
    }

    function getWeightByMarchandise(id, i) {
        var marchandiseId = jQuery('#' + '' + id + '').val();
        if(marchandiseId >0) {
            jQuery('#quantity' + '' + i + '').attr('required', 'required');
            jQuery('#quantity' + ''  + i+'').parent().addClass('required');
            jQuery('#weight-div' +  '' + '' + i + '').load('<?php echo $this->Html->url('/sheetRideDetailRides/getWeightByMarchandise/')?>' + marchandiseId +  '/' + i, function () {
            });
        }else {
            jQuery('#quantity'+  '' + '' + i + '').removeAttr('required');
            jQuery('#quantity' + '' +  i+'').parent().removeClass('required');
        }
    }

    function verifyQuantity(id, i) {
        var nbMarchandise = jQuery('#nb_marchandise').val();
        var quantity = 0;
        for (var i = 1; i <= nbMarchandise; i++) {
            quantity = quantity + parseFloat(jQuery('#quantity'  + '' + i + '').val());
        }
        var nbPalette = parseFloat(jQuery('#nb_palette').val());

        if (parseInt(quantity) > parseInt(nbPalette)) {
            var msg = '<?php echo __('The maximum quantity is : ')?>';
            var diffQuantity = nbPalette;
            for (var i = 1; i <= nbMarchandise; i++) {

                if (parseFloat(jQuery('#quantity'  + '' + i + '').val()) <= diffQuantity) {
                    diffQuantity = parseFloat(diffQuantity) - parseFloat(jQuery('#quantity' + '' + i + '').val());
                } else {
                    jQuery('#quantity'+ '' + i + '').val(diffQuantity);
                    diffQuantity = parseFloat(diffQuantity) - parseFloat(jQuery('#quantity'  + '' + i + '').val());
                }
            }
            alert(msg + nbPalette);
            jQuery('#truck_full2').removeAttr('checked');
            jQuery('#truck_full1').prop('checked', true);

            calculateAuthorizedWeight();
            jQuery('.add_marchandise').css('display','none');
        } else if (parseInt(quantity) == parseInt(nbPalette)) {
            jQuery('#truck_full2').removeAttr('checked');
            jQuery('#truck_full1').prop('checked', true);


            jQuery('.add_marchandise').css('display','none');
        } else {
            jQuery('#truck_full1').removeAttr('checked');
            jQuery('#truck_full2').prop('checked', true);
        }
    }






    function getFinalSupplierByInitialSupplier() {
        var supplierId = jQuery('#client').val();
        var supplierFinalId = jQuery('#client_final').val();
        jQuery("#client-final-div").load('<?php echo $this->Html->url('/sheetRideDetailRides/getFinalSupplierByInitialSupplier/')?>' + supplierId +'/'+supplierFinalId, function () {
            $('.select-search-client-final-i').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/suppliers/getFinalSuppliersByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            supplierId: supplierId
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2

            });
        });

    }






    function modifyInvoicedRide( value){
        jQuery('#invoiced_ride').val(value);
    }
</script>

<?= $this->Html->script('plugins/datetimepicker/moment-with-locales.min.js'); ?>
<?= $this->Html->script('plugins/datetimepicker/bootstrap-datetimepicker.min.js'); ?>
<?php $this->end(); ?>


