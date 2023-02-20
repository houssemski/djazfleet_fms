<style>
    .select label {
        display: block;
    }
	#dynamic_field {
    overflow-x: auto;
    overflow-y: auto;
    display: block;
		}
</style>
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
<?php

/** @noinspection PhpIncludeInspection */
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->Html->css('select2/select2.min');
echo $this->Html->css('iCheck/flat/red');
echo $this->Html->css('iCheck/all');
$this->end();
$this->request->data['TransportBill']['date'] = $this->Time->format($this->request->data['TransportBill']['date'], '%d-%m-%Y');
$this->request->data['TransportBill']['total_ht'] = number_format($this->request->data['TransportBill']['total_ht'], 2, '.', '');
$this->request->data['TransportBill']['total_tva'] = number_format($this->request->data['TransportBill']['total_tva'], 2, '.', '');
$this->request->data['TransportBill']['total_ttc'] = number_format($this->request->data['TransportBill']['total_ttc'], 2, '.', '');

switch ($type) {
    case TransportBillTypesEnum::quote :
        ?><h4 class="page-title"> <?= __('Edit quotation'); ?></h4>
        <?php break;
    case TransportBillTypesEnum::order :
        ?><h4 class="page-title"> <?= __("Edit customer order"); ?></h4>
        <?php break;
    case TransportBillTypesEnum::sheet_ride :
        ?><h4 class="page-title"> <?= __("Edit sheet ride"); ?></h4>
        <?php break;
    case TransportBillTypesEnum::pre_invoice :
        ?><h4 class="page-title"> <?= __("Edit preinvoice"); ?></h4>
        <?php break;
    case TransportBillTypesEnum::invoice :
        ?><h4 class="page-title"> <?= __("Edit invoice"); ?></h4>
        <?php break;
    case TransportBillTypesEnum::credit_note :
        ?><h4 class="page-title"> <?= __("Edit sale credit note"); ?></h4>
        <?php break;
}
echo  $this->Form->input('gestion_programmation_sous_traitance',
    array(
        'type' => 'hidden',
        'id' => 'gestion_programmation_sous_traitance',
        'value'=>Configure::read("gestion_programmation_sous_traitance")
    )) ;
?>

<div id="dialogModalDescription">
    <!-- the external content is loaded inside this tag -->
    <div id="contentWrapDescription"></div>
</div>
<div class="box">
    <div class="edit form card-box p-b-0">
        <?php echo $this->Form->create('TransportBill', array('onsubmit' => 'javascript:disable();')); ?>
        <div class="box-body">
            <div class="nav-tabs-custom pdg_btm">
                <ul class="nav nav-tabs">
                    <?php switch ($type) {
                        case TransportBillTypesEnum::quote :
                            ?>
                            <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('Quotation') ?></a></li>
                            <?php
                            if ($profileId != ProfilesEnum::client) {
                                ?>
                                <li><a href="#tab_2" data-toggle="tab"><?= __('Advanced information') ?></a></li>

                                <li><a href="#tab_3" data-toggle="tab"><?= __('Previous / Next reference') ?></a></li>
                            <?php } ?>
                            <?php break;
                        case TransportBillTypesEnum::order :
                            ?>
                            <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('Customer order') ?></a></li>
                            <?php
                            if ($profileId != ProfilesEnum::client) {
                                ?>
                                <li><a href="#tab_2" data-toggle="tab"><?= __('Advanced information') ?></a></li>

                                <li><a href="#tab_3" data-toggle="tab"><?= __('Previous / Next reference') ?></a></li>
                            <?php } ?>
                            <?php break;

                        case TransportBillTypesEnum::pre_invoice :
                            ?>
                            <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('Preinvoice') ?></a></li>
                            <?php
                            if ($profileId != ProfilesEnum::client) {
                                ?>
                                <li><a href="#tab_2" data-toggle="tab"><?= __('Advanced information') ?></a></li>

                                <li><a href="#tab_3" data-toggle="tab"><?= __('Previous / Next reference') ?></a></li>
                            <?php } ?>
                            <?php break;
                        case TransportBillTypesEnum::invoice :
                            ?>
                            <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('Invoice') ?></a></li>
                            <?php
                            if ($profileId != ProfilesEnum::client) {
                                ?>
                                <li><a href="#tab_2" data-toggle="tab"><?= __('Advanced information') ?></a></li>
                                <li><a href="#tab_3" data-toggle="tab"><?= __('Previous / Next reference') ?></a></li>
                            <?php } ?>
                            <?php break;
                    } ?>

                    <?php if ($type == TransportBillTypesEnum::invoice) { ?>
                        <li><a href="#tab_4" data-toggle="tab"><?= __('Règlement') ?></a></li>
                        <li><a href="#tab_5" data-toggle="tab"><?= __('Deadline') ?></a></li>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">

                        <?php
                        echo $this->Form->input('id');
                        if ($reference != '0') {
                            echo "<div class='form-group col-sm-4'>" . $this->Form->input('reference', array(
                                    'label' => __('Reference'),
                                    'class' => 'form-control',
                                    //'readonly' => true,
                                    'placeholder' => __('Enter reference'),
                                )) . "</div>";
                        } else {
                            echo "<div classupplier_final_divs='form-group col-sm-4'>" . $this->Form->input('reference', array(
                                    'label' => __('Reference'),
                                    'class' => 'form-control',
                                    'id'=>'reference',

                                    'required'=>true,
                                    'placeholder' => __('Enter reference'),
                                    'error' => array('attributes' => array('escape' => false),
                                        'unique' => '<div class="form-group has-error">
                                                    <label class="control-label" for="inputError">
                                                    <i class="fa fa-times-circle-o"></i>' .
                                            __("The reference must be unique") . '</label></div>', true)
                                )) . "</div>";
                        }
                        echo "<div class='form-group col-sm-4 clear-none'>" . $this->Form->input('date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Date') . '</label><div class="input-group date"><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'date',
                            )) . "</div>";

                        if (($type == TransportBillTypesEnum::order) && ($profileId == ProfilesEnum::client)) {

                            echo "<div class='form-group col-sm-4 form-clear'>" . $this->Form->input('supplier_id', array(
                                    'label' => __('Initial customer'),
                                    'empty' => '',
                                    'id' => 'client',
                                    'value' => $supplierId,
                                    'type' => 'hidden',
                                    //'class' => 'form-control select-search-client-initial',
                                )) . "</div>";

                            echo "<div class='form-group col-sm-3 form-clear'>" . $this->Form->input('service_id', array(
                                    'empty' => '',
                                    'id' => 'service',
                                    'value' => $serviceId,
                                    'type' => 'hidden',
                                    //'class' => 'form-control select-search-client-initial',
                                )) . "</div>";
                        } else {
                            if (($this->request->data['TransportBill']['status'] == TransportBillDetailRideStatusesEnum:: partially_validated) ||
                                ($this->request->data['TransportBill']['status'] == TransportBillDetailRideStatusesEnum:: validated)
                            ) {
                                if($permissionEditInputLocked==0){
                                    echo "<div class='form-group col-sm-4 form-none'>" . $this->Form->input('supplier_id', array(
                                            'label' => '',
                                            'empty' => '',
                                            'id' => 'client',
                                            'disabled' => true,
                                            'value' => $this->request->data['TransportBill']['supplier_id'],
                                            'class' => 'form-control ',
                                        )) . "</div>";

                                    echo "<div class='form-group col-sm-4 form-none'>" . $this->Form->input('supplier_id', array(
                                            'label' => '',
                                            'empty' => '',
                                            'id' => 'client',
                                            'type' => 'hidden',
                                            'value' => $this->request->data['TransportBill']['supplier_id'],
                                            'onchange' => 'javascript:getPriceAllRide();getThirdPartyContact(jQuery(this));',
                                            'class' => 'form-control',
                                        )) . "</div>";

                                    if($isVariousSupplier==true){
                                        echo "<div id='div-various'>";
                                        echo "<div class='form-group col-sm-4' >" . $this->Form->input('TransportBill.supplier_various', array(
                                                'label' => __('Client'),
                                                'id'=>'supplier_various',
                                                'readonly'=>true,
                                                'class' => 'form-control',
                                            )) . "</div>";

                                        echo "</div>";
                                    }else {
                                        echo "<div id='div-various'>";

                                        echo "</div>";
                                    }
                                    echo "<div class='form-group col-sm-4 form-none'>" . $this->Form->input('service_id', array(
                                            'label' => '',
                                            'empty' => '',
                                            'id' => 'service',
                                            'disabled' => true,
                                            'value' => $this->request->data['TransportBill']['service_id'],

                                            'class' => 'form-control ',
                                        )) . "</div>";

                                    echo "<div class='form-group col-sm-4 form-none'>" . $this->Form->input('service_id', array(
                                            'label' => '',
                                            'empty' => '',
                                            'id' => 'service',
                                            'type' => 'hidden',
                                            'value' => $this->request->data['TransportBill']['service_id'],
                                            'class' => 'form-control',
                                        )) . "</div>";
                                }else {

                                    if($type == TransportBillTypesEnum::credit_note){
                                        echo "<div class='form-group col-sm-10 form-none'>" . $this->Form->input('supplier_id', array(
                                                'label' => __('Initial customer'),
                                                'empty' => '',
                                                'id' => 'client',
                                                'onchange' => 'javascript:getPriceAllRide();getCustomerInvoices()',
                                                'class' => 'form-control select-search-client-initial',
                                            )) . "</div>";
                                    }else {
                                        echo "<div class='form-group col-sm-10 form-none'>" . $this->Form->input('supplier_id', array(
                                                'label' => __('Initial customer'),
                                                'empty' => '',
                                                'id' => 'client',
                                                'onchange' => 'javascript:getPriceAllRide();getThirdPartyContact(jQuery(this));',
                                                'class' => 'form-control select-search-client-initial',
                                            )) . "</div>";
                                    }

                                    if($isVariousSupplier==true){
                                        echo "<div id='div-various'>";
                                        echo "<div class='form-group col-sm-4' >" . $this->Form->input('TransportBill.supplier_various', array(
                                                'label' => __('Client'),
                                                'id'=>'supplier_various',
                                                //'type'=>'hidden',
                                                'class' => 'form-control',
                                            )) . "</div>";

                                        echo "</div>";
                                    }else {
                                        echo "<div id='div-various'>";

                                        echo "</div>";
                                    }

                                    $options = array('1'=>__('Order with invoice'), '2'=>__('Order payment cash'));

                                    if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                        && $type !=TransportBillTypesEnum::quote
                                    ){
                                        echo "<div  class='form-group col-sm-4'>" . $this->Form->input('order_type', array(
                                                'label' => __('Order type'),
                                                'empty' => '',
                                                'required'=>true,
                                                'id'=>'order_type',
                                                'options'=>$options,
                                                'class' => 'form-control select-search',
                                            )) . "</div>";
                                    }else {
                                        echo "<div  class='form-group col-sm-4'>" . $this->Form->input('order_type', array(
                                                'label' => __('Order type'),
                                                'empty' => '',
                                                'options'=>$options,
                                                'class' => 'form-control select-search',
                                            )) . "</div>";
                                    }





                                    echo "<div id='service-div' class='form-group col-sm-4 form-none'>" . $this->Form->input('service_id', array(
                                            'label' => __('Service'),
                                            'empty' => '',
                                            'id' => 'service',
                                            'class' => 'form-control select-search',
                                        )) . "</div>";

                                    if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                        && $type ==TransportBillTypesEnum::order
                                    ){

                                        echo "<div  class='form-group col-sm-4 form-none'>" . $this->Form->input('client_contact', array(
                                                'label' => __('Contact client'),
                                                'empty' => '',
                                                'required'=>true,
                                                'id'=>'client_contact',
                                                'class' => 'form-control',
                                            )) . "</div>";
                                    }else {
                                        echo "<div  class='form-group col-sm-4 form-none'>" . $this->Form->input('client_contact', array(
                                                'label' => __('Contact client'),
                                                'empty' => '',
                                                'class' => 'form-control',
                                            )) . "</div>";
                                    }
                                }


                            } else {

                                if($type == TransportBillTypesEnum::credit_note){
                                    echo "<div class='form-group col-sm-4 form-none'>" . $this->Form->input('supplier_id', array(
                                            'label' => __('Initial customer'),
                                            'empty' => '',
                                            'id' => 'client',
                                            'onchange' => 'javascript:getPriceAllRide();getCustomerInvoices()',
                                            'class' => 'form-control select-search-client-initial',
                                        )) . "</div>";
                                }else {
                                    echo "<div class='form-group col-sm-4 form-none'>" . $this->Form->input('supplier_id', array(
                                            'label' => __('Initial customer'),
                                            'empty' => '',
                                            'id' => 'client',
                                            'onchange' => 'javascript:getPriceAllRide();',
                                            'class' => 'form-control select-search-client-initial',
                                        )) . "</div>";
                                }
                                if($isVariousSupplier==true){
                                    echo "<div id='div-various'>";
                                    echo "<div class='form-group col-sm-4' >" . $this->Form->input('TransportBill.supplier_various', array(
                                            'label' => __('Client'),
                                            'id'=>'supplier_various',
                                            //'type'=>'hidden',
                                            'class' => 'form-control',
                                        )) . "</div>";

                                    echo "</div>";
                                }else {
                                    echo "<div id='div-various'>";

                                    echo "</div>";
                                }

                                $options = array('1'=>__('Order with invoice'), '2'=>__('Order payment cash'));

                                if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                    && $type !=TransportBillTypesEnum::quote && $type !=TransportBillTypesEnum::credit_note
                                ){
                                    echo "<div  class='form-group col-sm-4'>" . $this->Form->input('order_type', array(
                                            'label' => __('Order type'),
                                            'empty' => '',
                                            'required'=>true,
                                            'id'=>'order_type',
                                            'options'=>$options,
                                            'class' => 'form-control select-search',
                                        )) . "</div>";
                                }else {
                                    echo "<div  class='form-group col-sm-4'>" . $this->Form->input('order_type', array(
                                            'label' => __('Order type'),
                                            'empty' => '',
                                            'options'=>$options,
                                            'class' => 'form-control select-search',
                                        )) . "</div>";
                                }
                                echo "<div id='service-div' class='form-group col-sm-4 form-none'>" . $this->Form->input('service_id', array(
                                        'label' => __('Service'),
                                        'empty' => '',
                                        'id' => 'service',
                                        'class' => 'form-control select-search',
                                    )) . "</div>";

                                if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                    && $type ==TransportBillTypesEnum::order
                                ){

                                    echo "<div  class='form-group col-sm-4 form-none'>" . $this->Form->input('client_contact', array(
                                            'label' => __('Contact client'),
                                            'empty' => '',
                                            'required'=>true,
                                            'id'=>'client_contact',
                                            'class' => 'form-control',
                                        )) . "</div>";
                                }else {
                                    echo "<div  class='form-group col-sm-4 form-none'>" . $this->Form->input('client_contact', array(
                                            'label' => __('Contact client'),
                                            'empty' => '',
                                            'class' => 'form-control',
                                        )) . "</div>";
                                }
                            }
                        }
                        if($type == TransportBillTypesEnum::credit_note){
                            echo "<div  class='form-group col-sm-4 ' id ='div-invoice'>" . $this->Form->input('invoice_id', array(
                                    'label' => __('Invoices'),
                                    'empty' => '',
                                    'required'=>true,
                                    'options'=>$invoices,
                                    'id'=>'invoice_id',
                                    'onchange' => 'javascript:getInformationInvoice(this.id);',
                                    'class' => 'form-control select-search',
                                )) . "</div>";
                        }
                        echo "<div class='form-group  '>" . $this->Form->input('nb_ride', array(
                                'label' => '',
                                'type' => 'hidden',
                                'class' => 'form-control',
                                'id' => 'nb_ride',
                                'value' => $nbRides,
                            )) . "</div>";


                        echo "<div class='form-group'>" . $this->Form->input('type', array(
                                'label' => '',
                                'type' => 'hidden',
                                'class' => 'form-control',
                                'id' => 'type',
                                'value' => $type
                            )) . "</div>";


                        ?>
                        <div id='div-simulation'>
                        <table class="table table-bordered" id='dynamic_field'>
                            <thead>
                            <tr>
                                <?php if ($reference == '0') { ?>
                                    <th><?= __('Reference') ?></th>
                                <?php } ?>
                                <th><?= __('Products') ?></th>
                                <th><?= __('Rides') ?></th>
                                <th><?= __('Final customer') ?></th>
                                <th><?= __('Date / Time') ?></th>
                                <?php if ($profileId != ProfilesEnum::client) { ?>
                                    <th><?= __('Designation') ?></th>
                                <?php } ?>
                                <?php if ($useRideCategory == 2) { ?>
                                    <th><?= __('Ride category') ?></th>
                                <?php } ?>
                                <th><?= __('Simple delivery / return') ?></th>
                                <?php if ($profileId == ProfilesEnum::client && $type == TransportBillTypesEnum::order){ ?>
                                    <th><?= __('Quantity') ?></th>
                                    <th></th>
                                <?php } else { ?>
                                <?php if ($paramPriceNight == 1) { ?>
                                    <th><?= __('Price') ?></th>
                                <?php } ?>
                                <th><?= __('Unit price') ?></th>
                                <th><?= __('Ristourne') . __('%') ?></th>
                                <th><?= __('Quantity') ?></th>
                                <th><?= __('Price HT') ?></th>
                                <th><?= __('TVA') ?></th>
                                <th><?= __('Price TTC') ?></th>
                                <th><?= __('Observation') ?></th>
                                <th><?= __('Status') ?></th>
                                <?php if ($type == TransportBillTypesEnum::pre_invoice) { ?>
                                <th><?= __('Approved') ?>
                                    <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle">
                                        <i class="fa fa-square-o"></i></button>
                                    <?php } ?>
                                    <?php } ?>
                            </tr>
                            </thead>
                            <tbody id='rides-tbody'>
                            <?php if (!empty($transportBillRides)) {
                                $i = 1;
                                foreach ($transportBillRides as $transportBillRide) {
                                    ?>
                                    <tr id='row<?php echo $i; ?>'>
                                        <?php
                                        echo  $this->Form->input('TransportBillDetailRides.' . $i . '.id', array(
                                            'label' => '',
                                            'value' => $transportBillRide['TransportBillDetailRides']['id'],
                                            'type' => 'hidden',
                                        )) ;
                                        ?>
                                        <?php if ($reference == '0') { ?>
                                            <td>
                                                <?php
                                                echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.reference', array(
                                                        'label' => '',
                                                        'value' => $transportBillRide['TransportBillDetailRides']['reference'],
                                                        'class' => 'form-control',
                                                    )) . "</div>"; ?>
                                            </td>
                                        <?php } ?>

                                        <?php if ($profileId == ProfilesEnum::client
                                            && $type == TransportBillTypesEnum::order
                                        ) {
                                            ?>
                                            <td class="col-sm-3">
                                                <?php

                                                if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                                    || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                                                ) {
                                                    if($permissionEditInputLocked==0){
                                                        if ($usePurchaseBill == 1) {
                                                            echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                                                    'label' => '',
                                                                    'class' => 'form-control select-search',
                                                                    'id' => 'product' . $i,
                                                                    'disabled' => true,
                                                                    'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                    'value' => $usedProductIds[$i]['id'],
                                                                )) . "</div>";

                                                            echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                                                    'label' => '',
                                                                    'class' => 'form-control select-search',
                                                                    'id' => 'product' . $i,
                                                                    'type' => 'hidden',
                                                                    'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                    'value' => $usedProductIds[$i]['id'],
                                                                )) . "</div>";
                                                        } else {
                                                            echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                                                    'label' => '',
                                                                    'class' => 'form-control select-search',
                                                                    'id' => 'product' . $i,
                                                                    'disabled' => true,
                                                                    'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                    'value' => $transportBillRide['TransportBillDetailRides']['lot_id'],
                                                                )) . "</div>";

                                                            echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                                                    'label' => '',
                                                                    'class' => 'form-control select-search',
                                                                    'id' => 'product' . $i,
                                                                    'type' => 'hidden',
                                                                    'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                    'value' => $transportBillRide['TransportBillDetailRides']['lot_id'],
                                                                )) . "</div>";
                                                        }
                                                    }else {
                                                        if ($usePurchaseBill == 1) {
                                                            echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                                                    'label' => '',
                                                                    'class' => 'form-control select-search',
                                                                    'id' => 'product' . $i,
                                                                    'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                    'value' => $usedProductIds[$i]['id'],
                                                                )) . "</div>";
                                                        } else {
                                                            echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                                                    'label' => '',
                                                                    'class' => 'form-control select-search',
                                                                    'id' => 'product' . $i,

                                                                    'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                    'value' => $transportBillRide['TransportBillDetailRides']['lot_id'],
                                                                )) . "</div>";
                                                        }
                                                    }

                                                } else {
                                                    if ($usePurchaseBill == 1) {
                                                        echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                                                'label' => '',
                                                                'class' => 'form-control select-search',
                                                                'id' => 'product' . $i,
                                                                'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                'value' => $usedProductIds[$i]['id'],
                                                            )) . "</div>";
                                                    } else {
                                                        echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                                                'label' => '',
                                                                'class' => 'form-control select-search',
                                                                'id' => 'product' . $i,

                                                                'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                'value' => $transportBillRide['TransportBillDetailRides']['lot_id'],
                                                            )) . "</div>";
                                                    }

                                                }
                                                echo "<div id='type-ride-div$i'>";
                                                if ($typeRide == 3) {
                                                    if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                                        || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                                                    ) {
                                                        if($permissionEditInputLocked==0){
                                                            $options = array('1' => __('Existing ride'), '2' => __('Personalized ride'));
                                                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                                                                    'id' => 'type_ride' . $i,
                                                                    'options' => $options,
                                                                    'label' => false,
                                                                    'disabled' => true,
                                                                    'class' => 'form-control select3',
                                                                    'value' => $transportBillRide['TransportBillDetailRides']['type_ride'],
                                                                    'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                )) . "</div>";
                                                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                                                                    'id' => 'type_ride' . $i,
                                                                    'options' => $options,
                                                                    'label' => false,
                                                                    'class' => 'form-control select3',
                                                                    'value' => $transportBillRide['TransportBillDetailRides']['type_ride'],
                                                                    'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                )) . "</div>";
                                                        }else {
                                                            $options = array('1' => __('Existing ride'), '2' => __('Personalized ride'));
                                                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                                                                    'id' => 'type_ride' . $i,
                                                                    'options' => $options,
                                                                    'label' => false,
                                                                    'class' => 'form-control select3',
                                                                    'value' => $transportBillRide['TransportBillDetailRides']['type_ride'],
                                                                    'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                )) . "</div>";
                                                        }


                                                    } else {
                                                        $options = array('1' => __('Existing ride'), '2' => __('Personalized ride'));
                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                                                                'id' => 'type_ride' . $i,
                                                                'options' => $options,
                                                                'label' => false,
                                                                'class' => 'form-control select3',
                                                                'value' => $transportBillRide['TransportBillDetailRides']['type_ride'],
                                                                'onchange' => 'javascript:getInformationProduct(this.id);',
                                                            )) . "</div>";
                                                    }

                                                } else {
                                                    echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                                                            'id' => 'type_ride' . $i,
                                                            'type' => 'hidden',
                                                            'value' => $transportBillRide['TransportBillDetailRides']['type_ride'],
                                                        )) . "</div>";
                                                }

                                                echo "</div>";

                                                echo "<div id='type-pricing-div$i'>";
                                                if ($typePricing == 3) {
                                                    $options = array('1' => __('Pricing by ride'), '2' => __('Pricing by distance'));
                                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_pricing', array(
                                                            'id' => 'type_pricing' . $i,
                                                            'options' => $options,
                                                            'label' => false,
                                                            'class' => 'form-control select2',
                                                            'onchange' => 'javascript:getInformationPricing(this.id);',
                                                            'value' => $transportBillRide['TransportBillDetailRides']['type_pricing'],
                                                        )) . "</div>";

                                                } else {
                                                    echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_pricing', array(
                                                            'id' => 'type_pricing' . $i,
                                                            'type' => 'hidden',
                                                            'value' => $transportBillRide['TransportBillDetailRides']['type_pricing'],
                                                        )) . "</div>";
                                                }
                                                echo "</div>";
                                                ?>
                                            </td>
                                        <?php } else { ?>

                                            <td style="min-width: 200px;">
                                                <?php

                                                if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                                    || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                                                ) {
                                                    if($permissionEditInputLocked==0){
                                                        if ($usePurchaseBill == 1) {
                                                            echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                                                    'label' => '',
                                                                    'class' => 'form-control select-search',
                                                                    'id' => 'product' . $i,
                                                                    'disabled' => true,
                                                                    'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                    'value' => $usedProductIds[$i]['id'],
                                                                )) . "</div>";

                                                            echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                                                    'label' => '',
                                                                    'class' => 'form-control select-search',
                                                                    'id' => 'product' . $i,
                                                                    'type' => 'hidden',
                                                                    'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                    'value' => $usedProductIds[$i]['id'],
                                                                )) . "</div>";
                                                        } else {
                                                            echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                                                    'label' => '',
                                                                    'class' => 'form-control select-search',
                                                                    'id' => 'product' . $i,
                                                                    'disabled' => true,
                                                                    'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                    'value' => $transportBillRide['TransportBillDetailRides']['lot_id'],
                                                                )) . "</div>";

                                                            echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                                                    'label' => '',
                                                                    'class' => 'form-control select-search',
                                                                    'id' => 'product' . $i,
                                                                    'type' => 'hidden',
                                                                    'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                    'value' => $transportBillRide['TransportBillDetailRides']['lot_id'],
                                                                )) . "</div>";
                                                        }

                                                    }else {
                                                        if ($usePurchaseBill == 1) {
                                                            echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                                                    'label' => '',
                                                                    'class' => 'form-control select-search',
                                                                    'id' => 'product' . $i,

                                                                    'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                    'value' => $usedProductIds[$i]['id'],
                                                                )) . "</div>";
                                                        } else {
                                                            echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                                                    'label' => '',
                                                                    'class' => 'form-control select-search',
                                                                    'id' => 'product' . $i,

                                                                    'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                    'value' => $transportBillRide['TransportBillDetailRides']['lot_id'],
                                                                )) . "</div>";
                                                        }
                                                    }



                                                } else {
                                                    if ($usePurchaseBill == 1) {
                                                        echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                                                'label' => '',
                                                                'class' => 'form-control select-search',
                                                                'id' => 'product' . $i,

                                                                'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                'value' => $usedProductIds[$i]['id'],
                                                            )) . "</div>";
                                                    } else {
                                                        echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.product_id', array(
                                                                'label' => '',
                                                                'class' => 'form-control select-search',
                                                                'id' => 'product' . $i,

                                                                'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                'value' => $transportBillRide['TransportBillDetailRides']['lot_id'],
                                                            )) . "</div>";
                                                    }

                                                }
                                                echo "<div id='type-ride-div$i'>";
                                                if ($transportBillRide['TransportBillDetailRides']['lot_id'] == 1) {
                                                    if ($typeRide == 3) {
                                                        $options = array('1' => __('Existing ride'), '2' => __('Personalized ride'));
                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                                                                'id' => 'type_ride' . $i,
                                                                'options' => $options,
                                                                'label' => false,
                                                                'class' => 'form-control select-search',
                                                                'onchange' => 'javascript:getInformationProduct(this.id);',
                                                                'value' => $transportBillRide['TransportBillDetailRides']['type_ride'],
                                                            )) . "</div>";

                                                    } else {
                                                        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_ride', array(
                                                                'id' => 'type_ride' . $i,
                                                                'type' => 'hidden',
                                                                'value' => $transportBillRide['TransportBillDetailRides']['type_ride'],
                                                            )) . "</div>";
                                                    }
                                                }
                                                echo "</div >";
                                                if ($transportBillRide['TransportBillDetailRides']['lot_id'] == 1) {
                                                    echo "<div id='type-pricing-div$i'>";
                                                    if ($typePricing == 3) {
                                                        $options = array('1' => __('Pricing by ride'), '2' => __('Pricing by distance'));
                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_pricing', array(
                                                                'id' => 'type_pricing' . $i,
                                                                'options' => $options,
                                                                'label' => false,
                                                                'class' => 'form-control select3',
                                                                'onchange' => 'javascript:getInformationPricing(this.id);',
                                                                'value' => $transportBillRide['TransportBillDetailRides']['type_pricing'],
                                                            )) . "</div>";

                                                    } else {
                                                        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_pricing', array(
                                                                'id' => 'type_pricing' . $i,
                                                                'type' => 'hidden',
                                                                'value' => $transportBillRide['TransportBillDetailRides']['type_pricing'],
                                                            )) . "</div>";
                                                    }
                                                    echo "</div>";
                                                }
                                                ?>

                                            </td>

                                        <?php } ?>

                                        <?php if ($profileId == ProfilesEnum::client
                                            && $type == TransportBillTypesEnum::order
                                        ) {
                                            ?>
                                            <td class="col-sm-3">
                                                <?php
                                                if ($reference != '0') {
                                                    echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.reference', array(
                                                            'type' => 'hidden',
                                                            'value' => $transportBillRide['TransportBillDetailRides']['reference'],
                                                            'class' => 'form-control',
                                                        )) . "</div>";
                                                }
                                                echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.id', array(
                                                        'type' => 'hidden',
                                                        'id' => 'transport_bill_detail_ride' . $i,
                                                        'value' => $transportBillRide['TransportBillDetailRides']['id'],
                                                        'class' => 'form-control',
                                                    )) . "</div>";

                                                echo "<div id='div-product$i'>";
                                                switch($transportBillRide['ProductType']['id']){


                                                    case 1 :


                                                        if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                                            || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                                                        ) {

                                                            if($permissionEditInputLocked==0){
                                                                if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {

                                                                    echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                                            'label' => '',
                                                                            'empty' => '',
                                                                            'id' => 'detail_ride' . $i,
                                                                            'disabled' => true,
                                                                            'value' => $transportBillRide['DetailRide']['id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'class' => 'form-control',
                                                                        )) . "</div>";

                                                                    echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                                            'label' => '',
                                                                            'empty' => '',
                                                                            'id' => 'detail_ride' . $i,
                                                                            'type' => 'hidden',
                                                                            'value' => $transportBillRide['DetailRide']['id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'class' => 'form-control',
                                                                        )) . "</div>";

                                                                } else {

                                                                    if ($transportBillRide['Departure']['id'] > 0) {
                                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                                                'empty' => __('Departure city'),
                                                                                'class' => 'form-control select-search-destination',
                                                                                'label' => '',
                                                                                'disabled' => true,
                                                                                'options' => $departures,
                                                                                'value' => $transportBillRide['Departure']['id'],
                                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                'id' => 'departure_destination' . $i,
                                                                            )) . "</div>";

                                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                                                'empty' => __('Departure city'),
                                                                                'class' => 'form-control',
                                                                                'label' => '',
                                                                                'type' => 'hidden',
                                                                                'options' => $departures,
                                                                                'value' => $transportBillRide['Departure']['id'],
                                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                'id' => 'departure_destination' . $i,
                                                                            )) . "</div>";

                                                                    } else {
                                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                                                'empty' => __('Departure city'),
                                                                                'class' => 'form-control select-search-destination',
                                                                                'label' => '',
                                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                'id' => 'departure_destination' . $i,
                                                                            )) . "</div>";
                                                                    }

                                                                    if ($transportBillRide['Type']['id'] > 0) {
                                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                                'empty' => __('Type'),
                                                                                'class' => 'form-control select-search',
                                                                                'label' => '',
                                                                                'disabled' => true,
                                                                                'value' => $transportBillRide['Type']['id'],
                                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                'id' => 'car_type' . $i,
                                                                            )) . "</div>";

                                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                                'empty' => __('Type'),
                                                                                'class' => 'form-control ',
                                                                                'label' => '',
                                                                                'type' => 'hidden',
                                                                                'value' => $transportBillRide['Type']['id'],
                                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                'id' => 'car_type' . $i,
                                                                            )) . "</div>";
                                                                    } else {
                                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                                'empty' => __('Type'),
                                                                                'class' => 'form-control select-search',
                                                                                'label' => '',
                                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                'id' => 'car_type' . $i,
                                                                            )) . "</div>";
                                                                    }


                                                                }

                                                            }else {
                                                                if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                                                    echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                                            'label' => '',
                                                                            'empty' => '',
                                                                            'id' => 'detail_ride' . $i,
                                                                            'value' => $transportBillRide['DetailRide']['id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'class' => 'form-control select-search-detail-ride',
                                                                        )) . "</div>";
                                                                } else {
                                                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                                            'empty' => __('Departure city'),
                                                                            'class' => 'form-control select-search-destination',
                                                                            'label' => '',
                                                                            'options' => $departures,
                                                                            'value' => $transportBillRide['Departure']['id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'id' => 'departure_destination' . $i,
                                                                        )) . "</div>";
                                                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                            'empty' => __('Type'),
                                                                            'class' => 'form-control select-search',
                                                                            'label' => '',
                                                                            'value' => $transportBillRide['Type']['id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'id' => 'car_type' . $i,
                                                                        )) . "</div>";
                                                                }

                                                            }


                                                        } else {


                                                            if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                                                echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                                        'label' => '',
                                                                        'empty' => '',
                                                                        'id' => 'detail_ride' . $i,
                                                                        'value' => $transportBillRide['DetailRide']['id'],
                                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                                        'class' => 'form-control select-search-detail-ride',
                                                                    )) . "</div>";
                                                            } else {
                                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                                        'empty' => __('Departure city'),
                                                                        'class' => 'form-control select-search-destination',
                                                                        'label' => '',
                                                                        'options' => $departures,
                                                                        'value' => $transportBillRide['Departure']['id'],
                                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                                        'id' => 'departure_destination' . $i,
                                                                    )) . "</div>";
                                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                        'empty' => __('Type'),
                                                                        'class' => 'form-control select-search',
                                                                        'label' => '',
                                                                        'value' => $transportBillRide['Type']['id'],
                                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                                        'id' => 'car_type' . $i,
                                                                    )) . "</div>";
                                                            }


                                                        }


                                                        break;
                                                    case 2 :

                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                'empty' => __('Type'),
                                                                'class' => 'form-control select-search',
                                                                'label' => '',
                                                                'value' => $transportBillRide['Type']['id'],
                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                'id' => 'car_type' . $i,
                                                            )) . "</div>";

                                                        echo $this->Form->input('TransportBillDetailRides.'.$i.'.car_required', array(
                                                            'type'=>'hidden',
                                                            'value'=>$transportBillRide['Product']['car_required'],
                                                            'id'=>'car_required'.$i,
                                                        ));
                                                        if( $transportBillRide['Product']['car_required']==1){
                                                            echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.car_id', array(
                                                                    'class' => 'form-control select-search-car',
                                                                    'required'=>true,
                                                                    'label'=>'',
                                                                    'options'=>$cars,
                                                                    'value' => $transportBillRide['TransportBillDetailRides']['car_id'],
                                                                    'id'=>'car'.$i,
                                                                    'empty' =>__('Car'),
                                                                ))."</div>";
                                                        }




                                                        break;
                                                    case 3 :

                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.start_date', array(
                                                                'label' => false,
                                                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                                                'type' => 'text',

                                                                'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['start_date'], '%d-%m-%Y %H:%M'),
                                                                'class' => 'form-control datemask',
                                                                'before' => '<label>' . __('Start date') . '</label><div class="input-group datetime">
																<label for="StartDate"></label><div class="input-group-addon">
																							<i class="fa fa-calendar"></i>
																						</div>',
                                                                'after' => '</div>',
                                                                'onchange' => 'javascript:calculateEndDate(this.id);',
                                                                'id' => 'start_date'.$i,
                                                                'required'=>true,
                                                                'allowEmpty' => true,
                                                            )) . "</div>";
                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                'empty' => __('Type'),
                                                                'class' => 'form-control select-search',
                                                                'label' => '',
                                                                'value' => $transportBillRide['Type']['id'],
                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                'id' => 'car_type' . $i,
                                                            )) . "</div>";

                                                        echo $this->Form->input('TransportBillDetailRides.'.$i.'.car_required', array(
                                                            'type'=>'hidden',
                                                            'value'=>$transportBillRide['Product']['car_required'],
                                                            'id'=>'car_required'.$i,
                                                        ));
                                                        if( $transportBillRide['Product']['car_required']==1){
                                                            echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.car_id', array(
                                                                    'class' => 'form-control select-search-car',
                                                                    'required'=>true,
                                                                    'label'=>'',
                                                                    'options'=>$cars,
                                                                    'value' => $transportBillRide['TransportBillDetailRides']['car_id'],
                                                                    'id'=>'car'.$i,
                                                                    'empty' =>__('Car'),
                                                                ))."</div>";
                                                        }

                                                        echo $this->Form->input('TransportBillDetailRides.'.$i.'.nb_hours_required', array(
                                                            'type'=>'hidden',
                                                            'value'=>$transportBillRide['Product']['nb_hours_required'],
                                                            'id'=>'nb_hours_required'.$i,
                                                        ));
                                                        if( $transportBillRide['Product']['nb_hours_required']==1){
                                                            echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.nb_hours', array(
                                                                    'placeholder' =>__('Nb hours'),
                                                                    'class' => 'form-control',
                                                                    'label'=>'',
                                                                    'value'=>$transportBillRide['TransportBillDetailRides']['nb_hours'],
                                                                    'readonly'=>true,
                                                                    'id'=>'nb_hours'.$i,
                                                                ))."</div>";
                                                        }else {
                                                            echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.nb_hours', array(
                                                                    'placeholder' =>__('Nb hours'),
                                                                    'class' => 'form-control',
                                                                    'label'=>'',
                                                                    'value'=>$transportBillRide['TransportBillDetailRides']['nb_hours'],
                                                                    'id'=>'nb_hours'.$i,
                                                                    'onchange' => 'javascript:calculateEndDate(this.id);',
                                                                ))."</div>";
                                                        }


                                                        break;




                                                        default :
                                                        if ($usePurchaseBill == 1) {

                                                            if ($usedProductIds[$i]['with_lot'] == 1) { ?>


                                                                <div class="form-group ">
                                                                    <div class="input select required">
                                                                        <label for="lot<?= $i ?>"></label>
                                                                        <select name="data[TransportBillDetailRides][<?= $i ?>][lot_id]"
                                                                                class="form-control select3"
                                                                                id="lot<?= $i ?>"
                                                                                required="required">
                                                                            <option value=""></option>

                                                                            <?php

                                                                            foreach ($lots as $qsKey => $qsData) {
                                                                                if ($qsKey == $billProduct['BillProduct']['lot_id']) {
                                                                                    echo '<option value="' . $qsKey . '" selected>' . $qsData . '</option>' . "\n";
                                                                                } else {
                                                                                    echo '<option value="' . $qsKey . '">' . $qsData . '</option>' . "\n";
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            <?php }
                                                        }
                                                        break;



                                                }
                                                if ($transportBillRide['TransportBillDetailRides']['lot_id'] == 1) {

                                                    if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                                        || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                                                    ) {

                                                        if($permissionEditInputLocked==0){
                                                            if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {

                                                                echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                                        'label' => '',
                                                                        'empty' => '',
                                                                        'id' => 'detail_ride' . $i,
                                                                        'disabled' => true,
                                                                        'value' => $transportBillRide['DetailRide']['id'],
                                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                                        'class' => 'form-control',
                                                                    )) . "</div>";

                                                                echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                                        'label' => '',
                                                                        'empty' => '',
                                                                        'id' => 'detail_ride' . $i,
                                                                        'type' => 'hidden',
                                                                        'value' => $transportBillRide['DetailRide']['id'],
                                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                                        'class' => 'form-control',
                                                                    )) . "</div>";

                                                            } else {

                                                                if ($transportBillRide['Departure']['id'] > 0) {
                                                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                                            'empty' => __('Departure city'),
                                                                            'class' => 'form-control select-search-destination',
                                                                            'label' => '',
                                                                            'disabled' => true,
                                                                            'options' => $departures,
                                                                            'value' => $transportBillRide['Departure']['id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'id' => 'departure_destination' . $i,
                                                                        )) . "</div>";

                                                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                                            'empty' => __('Departure city'),
                                                                            'class' => 'form-control',
                                                                            'label' => '',
                                                                            'type' => 'hidden',
                                                                            'options' => $departures,
                                                                            'value' => $transportBillRide['Departure']['id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'id' => 'departure_destination' . $i,
                                                                        )) . "</div>";

                                                                } else {
                                                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                                            'empty' => __('Departure city'),
                                                                            'class' => 'form-control select-search-destination',
                                                                            'label' => '',
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'id' => 'departure_destination' . $i,
                                                                        )) . "</div>";
                                                                }

                                                                if ($transportBillRide['Type']['id'] > 0) {
                                                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                            'empty' => __('Type'),
                                                                            'class' => 'form-control select-search',
                                                                            'label' => '',
                                                                            'disabled' => true,
                                                                            'value' => $transportBillRide['Type']['id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'id' => 'car_type' . $i,
                                                                        )) . "</div>";

                                                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                            'empty' => __('Type'),
                                                                            'class' => 'form-control ',
                                                                            'label' => '',
                                                                            'type' => 'hidden',
                                                                            'value' => $transportBillRide['Type']['id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'id' => 'car_type' . $i,
                                                                        )) . "</div>";
                                                                } else {
                                                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                            'empty' => __('Type'),
                                                                            'class' => 'form-control select-search',
                                                                            'label' => '',
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'id' => 'car_type' . $i,
                                                                        )) . "</div>";
                                                                }


                                                            }

                                                        }else {
                                                            if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                                                echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                                        'label' => '',
                                                                        'empty' => '',
                                                                        'id' => 'detail_ride' . $i,
                                                                        'value' => $transportBillRide['DetailRide']['id'],
                                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                                        'class' => 'form-control select-search-detail-ride',
                                                                    )) . "</div>";
                                                            } else {
                                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                                        'empty' => __('Departure city'),
                                                                        'class' => 'form-control select-search-destination',
                                                                        'label' => '',
                                                                        'options' => $departures,
                                                                        'value' => $transportBillRide['Departure']['id'],
                                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                                        'id' => 'departure_destination' . $i,
                                                                    )) . "</div>";
                                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                        'empty' => __('Type'),
                                                                        'class' => 'form-control select-search',
                                                                        'label' => '',
                                                                        'value' => $transportBillRide['Type']['id'],
                                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                                        'id' => 'car_type' . $i,
                                                                    )) . "</div>";
                                                            }

                                                        }


                                                    } else {


                                                        if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                                            echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                                    'label' => '',
                                                                    'empty' => '',
                                                                    'id' => 'detail_ride' . $i,
                                                                    'value' => $transportBillRide['DetailRide']['id'],
                                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                                    'class' => 'form-control select-search-detail-ride',
                                                                )) . "</div>";
                                                        } else {
                                                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                                    'empty' => __('Departure city'),
                                                                    'class' => 'form-control select-search-destination',
                                                                    'label' => '',
                                                                    'options' => $departures,
                                                                    'value' => $transportBillRide['Departure']['id'],
                                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                                    'id' => 'departure_destination' . $i,
                                                                )) . "</div>";
                                                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                    'empty' => __('Type'),
                                                                    'class' => 'form-control select-search',
                                                                    'label' => '',
                                                                    'value' => $transportBillRide['Type']['id'],
                                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                                    'id' => 'car_type' . $i,
                                                                )) . "</div>";
                                                        }


                                                    }

                                                } else {
                                                    if ($usePurchaseBill == 1) {

                                                        if ($usedProductIds[$i]['with_lot'] == 1) { ?>


                                                            <div class="form-group ">
                                                                <div class="input select required">
                                                                    <label for="lot<?= $i ?>"></label>
                                                                    <select name="data[TransportBillDetailRides][<?= $i ?>][lot_id]"
                                                                            class="form-control select3"
                                                                            id="lot<?= $i ?>"
                                                                            required="required">
                                                                        <option value=""></option>

                                                                        <?php

                                                                        foreach ($lots as $qsKey => $qsData) {
                                                                            if ($qsKey == $billProduct['BillProduct']['lot_id']) {
                                                                                echo '<option value="' . $qsKey . '" selected>' . $qsData . '</option>' . "\n";
                                                                            } else {
                                                                                echo '<option value="' . $qsKey . '">' . $qsData . '</option>' . "\n";
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                    }
                                                }



                                                $j =0 ;
                                                $nbFactor= 0;
                                                $countTransportBillDetailRideFactors = count($transportBillDetailRideInputFactors);
                                                if(!empty($transportBillDetailRideInputFactors )){
                                                    $transportBillDetailRideFactors = $transportBillDetailRideInputFactors;

                                                    for ( $j =1 ;$j<$countTransportBillDetailRideFactors; ){
                                                        if($transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['transport_bill_detail_ride_id']==
                                                            $transportBillRide['TransportBillDetailRides']['id']){
                                                            $nbFactor ++;
                                                            echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor . '.factor_id', array(
                                                                    'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['factor_id'],
                                                                    'class' => 'form-control',
                                                                    'type'=>'hidden'
                                                                )) . "</div>";
                                                            echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor. '.factor_value', array(
                                                                    'label' => $transportBillDetailRideFactors[$j]['Factor']['name'],
                                                                    'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['factor_value'],
                                                                    'class' => 'form-control',
                                                                    'id'=>'factor'.$i.$nbFactor,
                                                                    'onchange' => 'javascript: calculatePriceRide(this.id);',
                                                                    'type'=>'integer'
                                                                )) . "</div>";


                                                        }
                                                    }
                                                }

                                                $countTransportBillDetailRideFactors = count($transportBillDetailRideSelectFactors);
                                                if(!empty($transportBillDetailRideSelectFactors )){
                                                    $transportBillDetailRideFactors = $transportBillDetailRideSelectFactors;

                                                    for ( $j =1 ;$j<$countTransportBillDetailRideFactors; ){
                                                        if($transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['transport_bill_detail_ride_id']==
                                                            $transportBillRide['TransportBillDetailRides']['id']){
                                                            $nbFactor ++;
                                                            echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor . '.factor_id', array(
                                                                    'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['factor_id'],
                                                                    'class' => 'form-control',
                                                                    'type'=>'hidden'
                                                                )) . "</div>";
                                                            echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor. '.factor_value', array(
                                                                    'label' => $transportBillDetailRideFactors[$j]['Factor']['name'],
                                                                    'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['factor_value'],
                                                                    'class' => 'form-control select-search',
                                                                    'id'=>'factor'.$i.$nbFactor,
                                                                    'onchange' => 'javascript: calculatePriceRide(this.id);',
                                                                    'type'=>'select',
                                                                    'options'=>$transportBillDetailRideFactors[$j]['Factor']['options'],
                                                                )) . "</div>";


                                                        }
                                                    }
                                                }




                                                echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_factor', array(
                                                        'type' => 'hidden',
                                                        'value' => $nbFactor,
                                                        'id' => 'nb_factor' . $i,
                                                    )) . "</div>";
                                                echo "</div>";

                                                ?>
                                            </td>


                                        <?php } else { ?>
                                            <td style="min-width: 200px;">
                                                <?php
                                                if ($reference != '0') {
                                                    echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.reference', array(
                                                            'type' => 'hidden',
                                                            'value' => $transportBillRide['TransportBillDetailRides']['reference'],
                                                            'class' => 'form-control',
                                                        )) . "</div>";
                                                }
                                                echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.id', array(
                                                        'type' => 'hidden',
                                                        'id' => 'transport_bill_detail_ride' . $i,
                                                        'value' => $transportBillRide['TransportBillDetailRides']['id'],
                                                        'class' => 'form-control',
                                                    )) . "</div>";

                                                echo "<div id='div-product$i'>";
                                                switch($transportBillRide['ProductType']['id']){
                                                    case 1:
                                                        if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                                            || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                                                        ) {
                                                            if($permissionEditInputLocked== 0){
                                                                if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                                                    echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                                            'label' => '',
                                                                            'empty' => '',
                                                                            'id' => 'detail_ride' . $i,
                                                                            'disabled' => true,
                                                                            'value' => $transportBillRide['DetailRide']['id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'class' => 'form-control',
                                                                        )) . "</div>";

                                                                    echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                                            'label' => '',
                                                                            'empty' => '',
                                                                            'id' => 'detail_ride' . $i,
                                                                            'type' => 'hidden',
                                                                            'value' => $transportBillRide['DetailRide']['id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'class' => 'form-control',
                                                                        )) . "</div>";
                                                                } else {
                                                                    if ($transportBillRide['Departure']['id'] > 0) {
                                                                        echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                                                'empty' => __('Departure city'),
                                                                                'class' => 'form-control select-search-destination',
                                                                                'label' => '',
                                                                                'disabled' => true,
                                                                                'options' => $departures,
                                                                                'value' => $transportBillRide['Departure']['id'],
                                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                'id' => 'departure_destination' . $i,
                                                                            )) . "</div>";

                                                                        echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                                                'empty' => __('Departure city'),
                                                                                'class' => 'form-control ',
                                                                                'label' => '',
                                                                                'type' => 'hidden',
                                                                                'options' => $departures,
                                                                                'value' => $transportBillRide['Departure']['id'],
                                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                'id' => 'departure_destination' . $i,
                                                                            )) . "</div>";
                                                                    } else {
                                                                        echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                                                'empty' => __('Departure city'),
                                                                                'class' => 'form-control select-search-destination',
                                                                                'label' => '',
                                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                'id' => 'departure_destination' . $i,
                                                                            )) . "</div>";

                                                                    }
                                                                    if ($transportBillRide['Type']['id'] > 0) {
                                                                        echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                                'empty' => __('Type'),
                                                                                'class' => 'form-control select-search',
                                                                                'label' => '',
                                                                                'disabled' => true,
                                                                                'value' => $transportBillRide['Type']['id'],
                                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                'id' => 'car_type' . $i,
                                                                            )) . "</div>";

                                                                        echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                                'empty' => __('Type'),
                                                                                'class' => 'form-control',
                                                                                'label' => '',
                                                                                'type' => 'hidden',
                                                                                'value' => $transportBillRide['Type']['id'],
                                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                'id' => 'car_type' . $i,
                                                                            )) . "</div>";

                                                                    } else {
                                                                        echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                                'empty' => __('Type'),
                                                                                'class' => 'form-control select-search',
                                                                                'label' => '',
                                                                                'value' => '',
                                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                'id' => 'car_type' . $i,
                                                                            )) . "</div>";
                                                                    }

                                                                }

                                                            }else {
                                                                if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                                                    echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                                            'label' => '',
                                                                            'empty' => '',
                                                                            'id' => 'detail_ride' . $i,
                                                                            'value' => $transportBillRide['DetailRide']['id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'class' => 'form-control select-search-detail-ride',
                                                                        )) . "</div>";
                                                                } else {
                                                                    echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                                            'empty' => __('Departure city'),
                                                                            'class' => 'form-control select-search-destination',
                                                                            'label' => '',
                                                                            'options' => $departures,
                                                                            'value' => $transportBillRide['Departure']['id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'id' => 'departure_destination' . $i,
                                                                        )) . "</div>";
                                                                    echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                            'empty' => __('Type'),
                                                                            'class' => 'form-control select-search',
                                                                            'label' => '',
                                                                            'value' => $transportBillRide['Type']['id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'id' => 'car_type' . $i,
                                                                        )) . "</div>";
                                                                }
                                                            }


                                                        } else {
                                                            if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                                                echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
                                                                        'label' => '',
                                                                        'empty' => '',
                                                                        'id' => 'detail_ride' . $i,
                                                                        'value' => $transportBillRide['DetailRide']['id'],
                                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                                        'class' => 'form-control select-search-detail-ride',
                                                                    )) . "</div>";
                                                            } else {
                                                                echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.departure_destination_id', array(
                                                                        'empty' => __('Departure city'),
                                                                        'class' => 'form-control select-search-destination',
                                                                        'label' => '',
                                                                        'options' => $departures,
                                                                        'value' => $transportBillRide['Departure']['id'],
                                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                                        'id' => 'departure_destination' . $i,
                                                                    )) . "</div>";
                                                                echo "<div class='form-group from-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                        'empty' => __('Type'),
                                                                        'class' => 'form-control select-search',
                                                                        'label' => '',
                                                                        'value' => $transportBillRide['Type']['id'],
                                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                                        'id' => 'car_type' . $i,
                                                                    )) . "</div>";
                                                            }
                                                        }


                                                        break;
                                                    case 2:


                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                'empty' => __('Type'),
                                                                'class' => 'form-control select-search',
                                                                'label' => '',
                                                                'value' => $transportBillRide['Type']['id'],
                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                'id' => 'car_type' . $i,
                                                            )) . "</div>";

                                                        echo $this->Form->input('TransportBillDetailRides.'.$i.'.car_required', array(
                                                            'type'=>'hidden',
                                                            'value'=>$transportBillRide['Product']['car_required'],
                                                            'id'=>'car_required'.$i,
                                                        ));

                                                        if( $transportBillRide['Product']['car_required']==1){

                                                            echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.car_id', array(

                                                                    'class' => 'form-control select-search-car',
                                                                    'required'=>true,
                                                                    'label'=>'',
                                                                    'options'=>$cars,
                                                                    'value' => $transportBillRide['TransportBillDetailRides']['car_id'],
                                                                    'id'=>'car'.$i,
                                                                    'empty' =>__('Car'),
                                                                ))."</div>";
                                                        }


                                                        break;
                                                    case 3:

                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.start_date', array(
                                                                'label' => false,
                                                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                                                'type' => 'text',

                                                                'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['start_date'], '%d-%m-%Y %H:%M'),
                                                                'class' => 'form-control datemask',
                                                                'before' => '<label>' . __('Start date') . '</label><div class="input-group datetime">
																<label for="StartDate"></label><div class="input-group-addon">
																							<i class="fa fa-calendar"></i>
																						</div>',
                                                                'after' => '</div>',
                                                                'id' => 'start_date'.$i,
                                                                'required'=>true,
                                                                'allowEmpty' => true,
                                                            )) . "</div>";
                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.car_type_id', array(
                                                                'empty' => __('Type'),
                                                                'class' => 'form-control select-search',
                                                                'label' => '',
                                                                'value' => $transportBillRide['Type']['id'],
                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                'id' => 'car_type' . $i,
                                                            )) . "</div>";

                                                        echo $this->Form->input('TransportBillDetailRides.'.$i.'.car_required', array(
                                                            'type'=>'hidden',
                                                            'value'=>$transportBillRide['Product']['car_required'],
                                                            'id'=>'car_required'.$i,
                                                        ));

                                                        if( $transportBillRide['Product']['car_required']==1){

                                                            echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.car_id', array(

                                                                    'class' => 'form-control select-search-car',
                                                                    'required'=>true,
                                                                    'label'=>'',
                                                                    'options'=>$cars,
                                                                    'value' => $transportBillRide['TransportBillDetailRides']['car_id'],
                                                                    'id'=>'car'.$i,
                                                                    'empty' =>__('Car'),
                                                                ))."</div>";
                                                        }

                                                        echo $this->Form->input('TransportBillDetailRides.'.$i.'.nb_hours_required', array(
                                                            'type'=>'hidden',
                                                            'value'=>$transportBillRide['Product']['nb_hours_required'],
                                                            'id'=>'nb_hours_required'.$i,
                                                        ));

                                                        if($transportBillRide['Product']['nb_hours_required']==1){
                                                            echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.nb_hours', array(
                                                                    'placeholder' =>__('Nb hours'),
                                                                    'class' => 'form-control',
                                                                    'label'=>'',
                                                                    'value'=>$transportBillRide['TransportBillDetailRides']['nb_hours'],
                                                                    'readonly'=>true,
                                                                    'id'=>'nb_hours'.$i,
                                                                ))."</div>";
                                                        }else {
                                                            echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.nb_hours', array(
                                                                    'placeholder' =>__('Nb hours'),
                                                                    'class' => 'form-control',
                                                                    'label'=>'',
                                                                    'value'=>$transportBillRide['TransportBillDetailRides']['nb_hours'],
                                                                    'id'=>'nb_hours'.$i,
                                                                    'onchange' => 'javascript:calculateEndDate(this.id);',
                                                                ))."</div>";
                                                        }




                                                        break;


                                                    default :
                                                        if ($usePurchaseBill == 1) {

                                                            if ($usedProductIds[$i]['with_lot'] == 1) { ?>


                                                                <div class="form-group ">
                                                                    <div class="input select required">
                                                                        <label for="lot<?= $i ?>"></label>
                                                                        <select name="data[TransportBillDetailRides][<?= $i ?>][lot_id]"
                                                                                class="form-control select3"
                                                                                id="lot<?= $i ?>"
                                                                                required="required">
                                                                            <option value=""></option>

                                                                            <?php

                                                                            foreach ($lots as $qsKey => $qsData) {
                                                                                if ($qsKey == $transportBillRide['TransportBillDetailRides']['lot_id']) {
                                                                                    echo '<option value="' . $qsKey . '" selected>' . $qsData . '</option>' . "\n";
                                                                                } else {
                                                                                    echo '<option value="' . $qsKey . '">' . $qsData . '</option>' . "\n";
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>


                                                            <?php }
                                                        }
                                                        break;

                                                }






                                                $nbFactor =0 ;
                                                $j =0 ;
                                                $nb = 0;
                                                $countTransportBillDetailRideFactors = count($transportBillDetailRideInputFactors);
                                                if(!empty($transportBillDetailRideInputFactors)){
                                                    $transportBillDetailRideFactors = $transportBillDetailRideInputFactors;

                                                    for ( $j =$nb ;$j<$countTransportBillDetailRideFactors; $j++ ){
                                                        if($transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['transport_bill_detail_ride_id']==
                                                            $transportBillRide['TransportBillDetailRides']['id']){
                                                            $nbFactor++;
                                                            echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor . '.id', array(
                                                                    'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['id'],
                                                                    'class' => 'form-control',
                                                                    'type'=>'hidden'
                                                                )) . "</div>";
                                                            echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor . '.factor_id', array(
                                                                    'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['factor_id'],
                                                                    'class' => 'form-control',
                                                                    'type'=>'hidden'
                                                                )) . "</div>";
                                                            echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor. '.factor_value', array(
                                                                    'label' => $transportBillDetailRideFactors[$j]['Factor']['name'],
                                                                    'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['factor_value'],
                                                                    'class' => 'form-control',
                                                                    'id'=>'factor'.$i.$nbFactor,
                                                                    'onchange' => 'javascript: calculatePriceRide(this.id);',
                                                                    'type'=>'integer'
                                                                )) . "</div>";

                                                            $nb++;

                                                        }
                                                    }
                                                }
                                                $nb = 0;
                                                $countTransportBillDetailRideFactors = count($transportBillDetailRideSelectFactors);

                                                if(!empty($transportBillDetailRideSelectFactors)){
                                                    $transportBillDetailRideFactors = $transportBillDetailRideSelectFactors;



                                                    for ( $j =$nb ;$j<$countTransportBillDetailRideFactors; $j++ ){
                                                        if($transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['transport_bill_detail_ride_id']==
                                                            $transportBillRide['TransportBillDetailRides']['id']){
                                                            $nbFactor++;
                                                            echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor . '.id', array(
                                                                    'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['id'],
                                                                    'class' => 'form-control',
                                                                    'type'=>'hidden'
                                                                )) . "</div>";
                                                            echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor . '.factor_id', array(
                                                                    'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['factor_id'],
                                                                    'class' => 'form-control',
                                                                    'type'=>'hidden'
                                                                )) . "</div>";
                                                            echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.'.$i.'.TransportBillDetailRideFactor.' . $nbFactor. '.factor_value', array(
                                                                    'label' => $transportBillDetailRideFactors[$j]['Factor']['name'],
                                                                    'value' => $transportBillDetailRideFactors[$j]['TransportBillDetailRideFactor']['factor_value'],
                                                                    'class' => 'form-control select-search',
                                                                    'id'=>'factor'.$i.$nbFactor,
                                                                    'onchange' => 'javascript: calculatePriceRide(this.id);',
                                                                    'type'=>'select',
                                                                    'options'=>$transportBillDetailRideFactors[$j]['Factor']['options'],
                                                                )) . "</div>";

                                                            $nb++;

                                                        }
                                                    }
                                                }



                                                echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_factor', array(
                                                        'type' => 'hidden',
                                                        'value' => $nbFactor,
                                                        'id' => 'nb_factor' . $i,
                                                    )) . "</div>";
                                                echo "</div >";


                                                ?>
                                            </td>


                                        <?php } ?>

                                        <?php if ($profileId == ProfilesEnum::client
                                            && $type == TransportBillTypesEnum::order
                                        ) {
                                            ?>
                                            <td class="col-sm-3">
                                                <?php
                                                switch($transportBillRide['ProductType']['id']){
                                                    case 1 :
                                                        if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                                            || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                                                        ) {
                                                            if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                                                echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                        'label' => '',
                                                                        'empty' => '',
                                                                        'id' => 'client_final' . $i,
                                                                        'disabled' => true,
                                                                        'options' => $finalSuppliers,
                                                                        'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                                        'class' => 'form-control',
                                                                    )) . "</div>";

                                                                echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                        'label' => '',
                                                                        'empty' => '',
                                                                        'id' => 'client_final' . $i,
                                                                        'type' => 'hidden',
                                                                        'options' => $finalSuppliers,
                                                                        'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                                        'class' => 'form-control',
                                                                    )) . "</div>";
                                                            } else {
                                                                echo "<div id='div-arrival$i'>";
                                                                if ($transportBillRide['TransportBillDetailRides']['lot_id'] == 1) {
                                                                    if ($transportBillRide['Arrival']['id'] > 0) {
                                                                        echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                                                'empty' => __('Arrival city'),
                                                                                'class' => 'form-control select-search-destination',
                                                                                'label' => '',
                                                                                'disabled' => true,
                                                                                'options' => $arrivals,
                                                                                'value' => $transportBillRide['Arrival']['id'],
                                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                'id' => 'arrival_destination' . $i,
                                                                            )) . "</div>";
                                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                                                'empty' => __('Arrival city'),
                                                                                'class' => 'form-control ',
                                                                                'label' => '',
                                                                                'type' => 'hidden',
                                                                                'options' => $arrivals,
                                                                                'value' => $transportBillRide['Arrival']['id'],
                                                                                'id' => 'arrival_destination' . $i,
                                                                            )) . "</div>";
                                                                    } else {
                                                                        if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                                                            && $type !=TransportBillTypesEnum::quote
                                                                        ){
                                                                            echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                                                    'empty' => __('Arrival city'),
                                                                                    'class' => 'form-control select-search-destination',
                                                                                    'label' => '',
                                                                                    'required'=>true,
                                                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                    'id' => 'arrival_destination' . $i,
                                                                                )) . "</div>";
                                                                        }else {
                                                                            echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                                                    'empty' => __('Arrival city'),
                                                                                    'class' => 'form-control select-search-destination',
                                                                                    'label' => '',
                                                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                    'id' => 'arrival_destination' . $i,
                                                                                )) . "</div>";
                                                                        }

                                                                    }
                                                                }
                                                                echo "</div>";

                                                                if ($transportBillRide['TransportBillDetailRides']['supplier_final_id'] > 0) {
                                                                    echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                            'empty' => __('Final customer'),
                                                                            'label' => '',
                                                                            'id' => 'client_final' . $i,
                                                                            'disabled' => true,
                                                                            'options' => $finalSuppliers,
                                                                            'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'class' => 'form-control',
                                                                        )) . "</div>";

                                                                    echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                            'empty' => __('Final customer'),
                                                                            'label' => '',
                                                                            'id' => 'client_final' . $i,
                                                                            'type' => 'hidden',
                                                                            'options' => $finalSuppliers,
                                                                            'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'class' => 'form-control',
                                                                        )) . "</div>";
                                                                } else {
                                                                    echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                            'empty' => __('Final customer'),
                                                                            'label' => '',
                                                                            'id' => 'client_final' . $i,
                                                                            'class' => 'form-control select-search-client-final',
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'class' => 'form-control',
                                                                        )) . "</div>";
                                                                }
                                                            }

                                                        } else {
                                                            if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                                                echo "<div class='form-group' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                        'label' => '',
                                                                        'empty' => __('Final customer'),
                                                                        'id' => 'client_final' . $i,
                                                                        'class' => 'form-control select-search-client-final',
                                                                        'options' => $finalSuppliers,
                                                                        'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                                    )) . "</div>";
                                                            } else {
                                                                echo "<div id='div-arrival$i'>";
                                                                if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                                                    && $type !=TransportBillTypesEnum::quote
                                                                ){
                                                                    echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                                            'empty' => __('Arrival city'),
                                                                            'class' => 'form-control select-search-destination',
                                                                            'label' => '',
                                                                            'required'=>true,
                                                                            'options' => $arrivals,
                                                                            'value' => $transportBillRide['Arrival']['id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'id' => 'arrival_destination' . $i,
                                                                        )) . "</div>";
                                                                }else {
                                                                    echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                                            'empty' => __('Arrival city'),
                                                                            'class' => 'form-control select-search-destination',
                                                                            'label' => '',
                                                                            'options' => $arrivals,
                                                                            'value' => $transportBillRide['Arrival']['id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'id' => 'arrival_destination' . $i,
                                                                        )) . "</div>";
                                                                }


                                                                echo "</div>";
                                                                echo "<div class='form-group' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                        'empty' => __('Final customer'),
                                                                        'label' => '',
                                                                        'id' => 'client_final' . $i,
                                                                        'class' => 'form-control select-search-client-final',
                                                                        'options' => $finalSuppliers,
                                                                        'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                                    )) . "</div>";
                                                            }
                                                        }
                                                        break;

                                                    case 2 :

                                                        echo "<div class='form-group' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                'empty' => __('Final customer'),
                                                                'label' => '',
                                                                'id' => 'client_final' . $i,
                                                                'class' => 'form-control select-search-client-final',
                                                                'options' => $finalSuppliers,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                            )) . "</div>";
                                                        break ;
                                                    case 3 :
                                                        echo "<div id='div-arrival$i'>";
                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.end_date', array(
                                                                'label' => false,
                                                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                                                'type' => 'text',
                                                                'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['end_date'], '%d-%m-%Y %H:%M'),
                                                                'class' => 'form-control datemask',
                                                                'before' => '<label>' . __('End date') . '</label><div class="input-group datetime">
																<label for="EndDate"></label><div class="input-group-addon">
																							<i class="fa fa-calendar"></i>
																						</div>',
                                                                'after' => '</div>',
                                                                'id' => 'end_date'.$i,
                                                                'required'=>true,
                                                                'allowEmpty' => true,
                                                            )) . "</div>";
                                                        echo "</div>";
                                                        echo "<div class='form-group' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                'empty' => __('Final customer'),
                                                                'label' => '',
                                                                'id' => 'client_final' . $i,
                                                                'class' => 'form-control select-search-client-final',
                                                                'options' => $finalSuppliers,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                            )) . "</div>";
                                                        break ;

                                                    default	:

                                                        echo "<div class='form-group' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                'empty' => __('Final customer'),
                                                                'label' => '',
                                                                'id' => 'client_final' . $i,
                                                                'class' => 'form-control select-search-client-final',
                                                                'options' => $finalSuppliers,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                            )) . "</div>";

                                                        break;

                                                }



                                                ?>
                                            </td>
                                        <?php } else { ?>
                                            <td style="min-width: 200px;">
                                                <?php

                                                switch($transportBillRide['ProductType']['id']){
                                                    case 1 :
                                                        if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                                            || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                                                        ) {

                                                            if($permissionEditInputLocked==0){
                                                                if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                                                    echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                            'label' => '',
                                                                            'empty' => __('Final customer'),
                                                                            'id' => 'client_final' . $i,
                                                                            'disabled' => true,
                                                                            'options' => $finalSuppliers,
                                                                            'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'class' => 'form-control',
                                                                        )) . "</div>";

                                                                    echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                            'label' => '',
                                                                            'empty' => __('Final customer'),
                                                                            'id' => 'client_final' . $i,
                                                                            'type' => 'hidden',
                                                                            'options' => $finalSuppliers,
                                                                            'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            'class' => 'form-control',
                                                                        )) . "</div>";
                                                                } else {
                                                                    echo "<div id='div-arrival$i'>";
                                                                    if ($transportBillRide['TransportBillDetailRides']['lot_id'] == 1) {

                                                                        if ($transportBillRide['Arrival']['id'] > 0) {
                                                                            echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                                                    'empty' => __('Arrival city'),
                                                                                    'class' => 'form-control select-search-destination',
                                                                                    'label' => '',
                                                                                    'disabled' => true,
                                                                                    'options' => $arrivals,
                                                                                    'value' => $transportBillRide['Arrival']['id'],
                                                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                    'id' => 'arrival_destination' . $i,
                                                                                )) . "</div>";


                                                                            echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                                                    'empty' => __('Arrival city'),
                                                                                    'class' => 'form-control ',
                                                                                    'label' => '',
                                                                                    'type' => 'hidden',
                                                                                    'options' => $arrivals,
                                                                                    'value' => $transportBillRide['Arrival']['id'],
                                                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                    'id' => 'arrival_destination' . $i,
                                                                                )) . "</div>";


                                                                        } else {
                                                                            if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                                                                && $type !=TransportBillTypesEnum::quote
                                                                            ){
                                                                                echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                                                        'empty' => __('Arrival city'),
                                                                                        'class' => 'form-control select-search-destination',
                                                                                        'label' => '',
                                                                                        'required'=>true,
                                                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                        'id' => 'arrival_destination' . $i,
                                                                                    )) . "</div>";
                                                                            }else {
                                                                                echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                                                        'empty' => __('Arrival city'),
                                                                                        'class' => 'form-control select-search-destination',
                                                                                        'label' => '',
                                                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                        'id' => 'arrival_destination' . $i,
                                                                                    )) . "</div>";
                                                                            }

                                                                        }
                                                                    }
                                                                    echo "</div>";


                                                                    if ($transportBillRide['TransportBillDetailRides']['supplier_final_id'] > 0) {
                                                                        echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                                'empty' => __('Final customer'),
                                                                                'label' => '',
                                                                                'id' => 'client_final' . $i,
                                                                                'disabled' => true,
                                                                                'options' => $finalSuppliers,
                                                                                'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                'class' => 'form-control',
                                                                            )) . "</div>";

                                                                        echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                                'label' => '',
                                                                                'empty' => __('Final customer'),
                                                                                'id' => 'client_final' . $i,
                                                                                'type' => 'hidden',
                                                                                'options' => $finalSuppliers,
                                                                                'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                'class' => 'form-control',
                                                                            )) . "</div>";
                                                                    } else {
                                                                        echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                                'empty' => __('Final customer'),
                                                                                'label' => '',
                                                                                'id' => 'client_final' . $i,
                                                                                'class' => 'form-control select-search-client-final',
                                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                            )) . "</div>";

                                                                    }


                                                                }

                                                            }else {
                                                                if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                                                    echo "<div class='form-group form-tab' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                            'label' => '',
                                                                            'empty' => __('Final customer'),
                                                                            'id' => 'client_final' . $i,
                                                                            'class' => 'form-control select-search-client-final',
                                                                            'options' => $finalSuppliers,
                                                                            'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                                        )) . "</div>";
                                                                } else {
                                                                    echo "<div id='div-arrival$i'>";
                                                                    if ($transportBillRide['TransportBillDetailRides']['lot_id'] == 1) {
                                                                        if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                                                            && $type !=TransportBillTypesEnum::quote
                                                                        ){
                                                                            echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                                                    'empty' => __('Arrival city'),
                                                                                    'class' => 'form-control select-search-destination',
                                                                                    'label' => '',
                                                                                    'required'=>true,
                                                                                    'options' => $arrivals,
                                                                                    'value' => $transportBillRide['Arrival']['id'],
                                                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                    'id' => 'arrival_destination' . $i,
                                                                                )) . "</div>";
                                                                        }else {
                                                                            echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                                                    'empty' => __('Arrival city'),
                                                                                    'class' => 'form-control select-search-destination',
                                                                                    'label' => '',
                                                                                    'options' => $arrivals,
                                                                                    'value' => $transportBillRide['Arrival']['id'],
                                                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                    'id' => 'arrival_destination' . $i,
                                                                                )) . "</div>";
                                                                        }


                                                                    }
                                                                    echo "</div>";
                                                                    echo "<div class='form-group form-tab' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                            'empty' => __('Final customer'),
                                                                            'label' => '',
                                                                            'id' => 'client_final' . $i,
                                                                            'class' => 'form-control select-search-client-final',
                                                                            'options' => $finalSuppliers,
                                                                            'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                                        )) . "</div>";
                                                                }
                                                            }

                                                        } else {
                                                            if ($transportBillRide['TransportBillDetailRides']['type_ride'] == 1) {
                                                                echo "<div class='form-group form-tab' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                        'label' => '',
                                                                        'empty' => __('Final customer'),
                                                                        'id' => 'client_final' . $i,
                                                                        'class' => 'form-control select-search-client-final',
                                                                        'options' => $finalSuppliers,
                                                                        'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                                    )) . "</div>";
                                                            } else {


                                                                echo "<div id='div-arrival$i'>";
                                                                if ($transportBillRide['TransportBillDetailRides']['lot_id'] == 1) {
                                                                    if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                                                        && $type !=TransportBillTypesEnum::quote
                                                                    ) {
                                                                        echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                                                'empty' => __('Arrival city'),
                                                                                'class' => 'form-control select-search-destination',
                                                                                'label' => '',
                                                                                'required'=>true,
                                                                                'options' => $arrivals,
                                                                                'value' => $transportBillRide['Arrival']['id'],
                                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                'id' => 'arrival_destination' . $i,
                                                                            )) . "</div>";

                                                                    }else {
                                                                        echo "<div class='form-group form-tab' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.arrival_destination_id', array(
                                                                                'empty' => __('Arrival city'),
                                                                                'class' => 'form-control select-search-destination',
                                                                                'label' => '',
                                                                                'options' => $arrivals,
                                                                                'value' => $transportBillRide['Arrival']['id'],
                                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                                'id' => 'arrival_destination' . $i,
                                                                            )) . "</div>";
                                                                    }

                                                                }
                                                                echo "</div>";
                                                                echo "<div class='form-group form-tab' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                        'empty' => __('Final customer'),
                                                                        'label' => '',
                                                                        'id' => 'client_final' . $i,
                                                                        'class' => 'form-control select-search-client-final',
                                                                        'options' => $finalSuppliers,
                                                                        'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                                    )) . "</div>";
                                                            }
                                                        }


                                                        break;

                                                    case 2:

                                                        echo "<div class='form-group form-tab' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                'empty' => __('Final customer'),
                                                                'label' => '',
                                                                'id' => 'client_final' . $i,
                                                                'class' => 'form-control select-search-client-final',
                                                                'options' => $finalSuppliers,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                            )) . "</div>";
                                                        break ;
                                                    case 3:
                                                        echo "<div id='div-arrival$i'>";
                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.end_date', array(
                                                                'label' => false,
                                                                'placeholder' => 'dd/mm/yyyy hh:mm',
                                                                'type' => 'text',
                                                                'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['end_date'], '%d-%m-%Y %H:%M'),
                                                                'class' => 'form-control datemask',
                                                                'before' => '<label>' . __('End date') . '</label><div class="input-group datetime">
																<label for="EndDate"></label><div class="input-group-addon">
																							<i class="fa fa-calendar"></i>
																						</div>',
                                                                'after' => '</div>',
                                                                'id' => 'end_date'.$i,
                                                                'required'=>true,
                                                                'allowEmpty' => true,
                                                            )) . "</div>";
                                                        echo "</div>";
                                                        echo "<div class='form-group form-tab' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                'empty' => __('Final customer'),
                                                                'label' => '',
                                                                'id' => 'client_final' . $i,
                                                                'class' => 'form-control select-search-client-final',
                                                                'options' => $finalSuppliers,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                            )) . "</div>";
                                                        break ;

                                                        default :
                                                        echo "<div class='form-group form-tab' id='supplier_final_div$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.supplier_final_id', array(
                                                                'empty' => __('Final customer'),
                                                                'label' => '',
                                                                'id' => 'client_final' . $i,
                                                                'class' => 'form-control select-search-client-final',
                                                                'options' => $finalSuppliers,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['supplier_final_id'],
                                                            )) . "</div>";
                                                        break;

                                                }




                                                ?>
                                            </td>

                                        <?php } ?>


                                        <td style="min-width: 200px;">
                                            <?php
                                    if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                        && $type !=TransportBillTypesEnum::quote
                                    ){
                                        echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.programming_date', array(
                                                'label' => '',
                                                'placeholder' => 'dd/mm/yyyy',
                                                'type' => 'text',
                                                'required'=>true,
                                                'class' => 'form-control datemask',
                                                'id' => 'programming_date'.$i,
                                                'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['programming_date'], '%d/%m/%Y'),
                                                'before' => '<div class="input-group date "><label for="programmingDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                                'after' => '</div>',
                                            )) . "</div>";

                                        echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.charging_time', array(
                                                'label' => '',
                                                'placeholder' => __('Charging hour'),
                                                'type' => 'text',
                                                'class' => 'form-control datemask',
                                                'id' => 'charging_time'.$i,
                                                'required'=>true,
                                                'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['charging_time'], '%H:%M'),
                                                'before' => '<div class="input-group "><label for="chargingTime"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                                'after' => '</div>',
                                            )) . "</div>";

                                        echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.unloading_date', array(
                                                'label' => '',
                                                'placeholder' => __('Unloading date'),
                                                'type' => 'text',
                                                'required'=>true,
                                                'class' => 'form-control datemask',
                                                'id' => 'unloading_date'.$i,
                                                'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['unloading_date'], '%d/%m/%Y %H:%M'),
                                                'before' => '<div class="input-group "><label for="unloadingDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                                'after' => '</div>',
                                            )) . "</div>";
                                    }else {
                                        echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.programming_date', array(
                                                'label' => '',
                                                'placeholder' => 'dd/mm/yyyy',
                                                'type' => 'text',
                                                'class' => 'form-control datemask',
                                                'id' => 'programming_date'.$i,
                                                'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['programming_date'], '%d/%m/%Y'),
                                                'before' => '<div class="input-group date "><label for="programmingDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                                'after' => '</div>',
                                            )) . "</div>";

                                        echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.charging_time', array(
                                                'label' => '',
                                                'placeholder' => __('Charging hour'),
                                                'type' => 'text',
                                                'class' => 'form-control datemask',
                                                'id' => 'charging_time'.$i,
                                                'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['charging_time'], '%H:%M'),
                                                'before' => '<div class="input-group "><label for="chargingTime"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                                'after' => '</div>',
                                            )) . "</div>";

                                        echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.unloading_date', array(
                                                'label' => '',
                                                'placeholder' => __('Unloading date'),
                                                'type' => 'text',
                                                'class' => 'form-control datemask',
                                                'id' => 'unloading_date'.$i,
                                                'value' => $this->Time->format($transportBillRide['TransportBillDetailRides']['unloading_date'], '%d/%m/%Y %H:%M'),
                                                'before' => '<div class="input-group "><label for="unloadingDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                                'after' => '</div>',
                                            )) . "</div>";


                                    }




                                            ?>


                                        </td>



                                        <?php if ($profileId != ProfilesEnum::client) { ?>
                                            <td style="min-width: 200px;">
                                                <?php
                                                echo "<div id='div-designation$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.designation', array(
                                                        'label' => '',
                                                        'empty' => '',
                                                        'id' => 'designation' . $i,
                                                        'value' => $transportBillRide['TransportBillDetailRides']['designation'],
                                                        'class' => 'form-control',
                                                    )) . "</div>";
                                                ?>
                                            </td>
                                        <?php } ?>

                                        <?php if ($useRideCategory == 2) { ?>
                                            <td>
                                                <?php

                                                if (isset($transportBillRide['TransportBillDetailRides']['ride_category_id'])
                                                    && !empty($transportBillRide['TransportBillDetailRides']['ride_category_id'])
                                                ) {
                                                    $ride_category_id = $transportBillRide['TransportBillDetailRides']['ride_category_id'];

                                                    echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.ride_category_id', array(
                                                            'label' => '',
                                                            'empty' => '',
                                                            'id' => 'ride_category' . $i,
                                                            'value' => $ride_category_id,
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'class' => 'form-control',
                                                        )) . "</div>";

                                                } else {
                                                    echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.ride_category_id', array(
                                                            'label' => '',
                                                            'empty' => '',
                                                            'id' => 'ride_category' . $i,

                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'class' => 'form-control',
                                                        )) . "</div>";

                                                }
                                                ?>

                                            </td>
                                        <?php } ?>

                                        <td>
                                            <?php
                                            echo "<div id='delivery-return-div$i'>";
                                            if ($transportBillRide['TransportBillDetailRides']['lot_id'] == 1) {
                                                $options = array('1' => __('Simple delivery'), '2' => __('Simple return'), '3' => __('Delivery / Return'));
                                                echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.delivery_with_return', array(
                                                        'label' => '',
                                                        'id' => 'delivery_with_return' . $i,
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'value' => $transportBillRide['TransportBillDetailRides']['delivery_with_return'],
                                                        'options' => $options,
                                                        'class' => 'form-control select-search',
                                                    )) . "</div>";
                                            }
                                            echo "</div>";

                                            echo "<div id='tonnage-div$i'>";
                                            if ($transportBillRide['TransportBillDetailRides']['lot_id'] == 1) {
                                                if ($transportBillRide['TransportBillDetailRides']['type_pricing'] == 2) {
                                                    echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.tonnage_id', array(
                                                            'label' => '',
                                                            'empty' => __('Tonnage'),
                                                            'id' => 'tonnage' . $i,
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'value' => $transportBillRide['TransportBillDetailRides']['tonnage_id'],
                                                            'class' => 'form-control select-search',
                                                        )) . "</div>";
                                                }
                                            }
                                            echo "</div>";

                                            ?>
                                        </td>

                                        <?php if ($profileId == ProfilesEnum::client
                                            && $type == TransportBillTypesEnum::order
                                        ) {
                                            ?>

                                            <td style="min-width: 70px;">
                                                <?php if ($paramPriceNight == 1) { ?>

                                                    <?php $options = array('1' => __('Day'), '2' => __('Night'));
                                                    echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_price', array(
                                                            'label' => '',
                                                            'type' => 'hidden',
                                                            'id' => 'type_price' . $i,
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'value' => $transportBillRide['TransportBillDetailRides']['type_price'],
                                                            'options' => $options,
                                                            'class' => 'form-control select-search',
                                                        )) . "</div>"; ?>

                                                <?php } ?>

                                                <?php


                                                echo "<div id='div_unit_price$i'  >" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
                                                        'label' => '',
                                                        'type' => 'hidden',
                                                        //'readonly' => true,
                                                        'id' => 'unit_price' . $i,
                                                        'value' => $transportBillRide['TransportBillDetailRides']['unit_price'],
                                                        'onchange' => 'javascript:calculatePriceRide(this.id);',
                                                        'class' => 'form-control',
                                                    )) . "</div>";


                                                echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_%', array(
                                                        'label' => '',
                                                        'type' => 'hidden',
                                                        //'readonly' => true,
                                                        'id' => 'ristourne' . $i,
                                                        'value' => $transportBillRide['TransportBillDetailRides']['ristourne_%'],
                                                        'onchange' => 'javascript:calculRistourneVal(this.id);',
                                                        'class' => 'form-control',
                                                    )) . "</div>";

                                                echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_val', array(
                                                        'label' => '',
                                                        //'readonly' => true,
                                                        'type' => 'hidden',
                                                        'id' => 'ristourne_val' . $i,
                                                        'value' => $transportBillRide['TransportBillDetailRides']['ristourne_val'],
                                                        'onchange' => 'javascript:calculRistourne(this.id);',
                                                        'class' => 'form-control',
                                                    )) . "</div>";


                                                if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                                    || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                                                ) {
                                                    ?>

                                                    <?php
                                                    if($permissionEditInputLocked==0){
                                                        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                                                'placeholder' => __('Enter quantity'),
                                                                'id' => 'nb_trucks' . $i,
                                                                'label' => '',
                                                                'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                                                'readonly' => true,
                                                                'onchange' => 'javascript:calculatePriceRide(this.id);',
                                                                'class' => 'form-control',
                                                            )) . "</div>";
                                                    }else {
                                                        if ($nbTrucksModifiable == 2) {
                                                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                                                    'label' => '',
                                                                    'placeholder' => __('Enter quantity'),
                                                                    'onchange' => 'javascript: calculatePriceRide(this.id);',
                                                                    'readonly' => true,
                                                                    'id' => 'nb_trucks' . $i,
                                                                    'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                                                    'class' => 'form-control',
                                                                )) . "</div>";
                                                        } else {
                                                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                                                    'label' => '',
                                                                    'placeholder' => __('Enter quantity'),
                                                                    'onchange' => 'javascript: calculatePriceRide(this.id);',
                                                                    'id' => 'nb_trucks' . $i,
                                                                    'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                                                    'class' => 'form-control',
                                                                )) . "</div>";
                                                        }
                                                    }


                                                    ?>


                                                <?php } else { ?>

                                                    <?php

                                                    if ($nbTrucksModifiable == 2) {
                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                                                'label' => '',
                                                                'placeholder' => __('Enter quantity'),
                                                                'onchange' => 'javascript: calculatePriceRide(this.id);',
                                                                'readonly' => true,
                                                                'id' => 'nb_trucks' . $i,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                                                'class' => 'form-control',
                                                            )) . "</div>";
                                                    } else {
                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                                                'label' => '',
                                                                'placeholder' => __('Enter quantity'),
                                                                'onchange' => 'javascript: calculatePriceRide(this.id);',
                                                                'id' => 'nb_trucks' . $i,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                                                'class' => 'form-control',
                                                            )) . "</div>";
                                                    }

                                                }



                                                echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ht', array(
                                                        'type' => 'hidden',
                                                        'readonly' => true,
                                                        'id' => 'price_ht' . $i,
                                                        'label' => '',
                                                        'value' => $transportBillRide['TransportBillDetailRides']['price_ht'],
                                                        'class' => 'form-control',
                                                    )) . "</div>";


                                                echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.tva_id', array(
                                                        'label' => '',
                                                        'empty' => '',
                                                        'id' => 'tva' . $i,
                                                        'type' => 'hidden',
                                                        'value' => 1,
                                                        'options' => $tvas,
                                                        'value' => $transportBillRide['TransportBillDetailRides']['tva_id'],
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'class' => 'form-control',
                                                    )) . "</div>";


                                                echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ttc', array(
                                                        'readonly' => true,
                                                        'type' => 'hidden',
                                                        'label' => '',
                                                        'id' => 'price_ttc' . $i,
                                                        'value' => $transportBillRide['TransportBillDetailRides']['price_ttc'],
                                                        'class' => 'form-control',
                                                    )) . "</div>";

                                                ?>
                                            </td>
                                            <td>

                                                <?php

                                                if (($transportBillRide['TransportBillDetailRides']['status_id'] != TransportBillDetailRideStatusesEnum::validated
                                                    && $transportBillRide['TransportBillDetailRides']['status_id'] = TransportBillDetailRideStatusesEnum:: partially_validated

                                                )
                                                ) {
                                                    ?>
                                                    <button name="remove" id="<?php echo $i ?>"
                                                            onclick="removeRide('<?php echo $i ?>');"
                                                            class="btn btn-danger btn_remove" style="margin-top: 10px;">
                                                        X
                                                    </button>
                                                <?php } ?>

                                            </td>
                                            <?php if ($type == TransportBillTypesEnum::pre_invoice) { ?>
                                                <td>
                                                    <?php
                                                    echo "<div class='appro'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.approved', array(
                                                            'type' => 'checkbox',
                                                            'label' => false,
                                                            'class' => 'id approve'
                                                        )) . "</div>";
                                                    ?>

                                                </td>

                                            <?php } ?>

                                        <?php } else { ?>

                                            <?php if ($paramPriceNight == 1) { ?>
                                                <td>
                                                    <?php $options = array('1' => __('Day'), '2' => __('Night'));
                                                    echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_price', array(
                                                            'label' => '',

                                                            'id' => 'type_price' . $i,
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'value' => $transportBillRide['TransportBillDetailRides']['type_price'],
                                                            'options' => $options,
                                                            'class' => 'form-control select-search',
                                                        )) . "</div>"; ?>
                                                </td>
                                            <?php } ?>
                                            <td style="min-width: 130px;">
                                                <?php

                                                if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                                    || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                                                ) {

                                                    if($permissionEditInputLocked==0){
                                                        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
                                                                'label' => '',
                                                                'readonly' => true,
                                                                'id' => 'unit_price' . $i,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['unit_price'],
                                                                'onchange' => 'javascript:calculatePriceRide(this.id);',
                                                                'class' => 'form-control',
                                                            )) . "</div>";
                                                    }else {
                                                        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
                                                                'label' => '',
                                                                'id' => 'unit_price' . $i,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['unit_price'],
                                                                'onchange' => 'javascript:calculatePriceRide(this.id);',
                                                                'class' => 'form-control',
                                                            )) . "</div>";
                                                    }


                                                } else {
                                                    echo "<div id='div_unit_price$i'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
                                                            'label' => '',
                                                            //'readonly' => true,
                                                            'id' => 'unit_price' . $i,
                                                            'value' => $transportBillRide['TransportBillDetailRides']['unit_price'],
                                                            'onchange' => 'javascript:calculatePriceRide(this.id);',
                                                            'class' => 'form-control',
                                                        )) . "</div>";
                                                    $pricePmp = array('0' => 'PMP');
                                                    if (!empty($priceCategories)) {
                                                        $options = array_merge($pricePmp, $priceCategories);
                                                    } else {
                                                        $options = $priceCategories;
                                                    }

                                                    echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_category_id', array(
                                                            'label' => '',
                                                            'class' => 'form-control select3',
                                                            'id' => 'price_category' . $i,
                                                            'onchange' => 'javascript:getPriceProduct(this.id);',
                                                            'options' => $options,
                                                            'empty' => ''
                                                        )) . "</div>";
                                                }
                                                ?>
                                            </td>
                                            <td style="min-width: 100px;">
                                                <?php

                                                if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                                    || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                                                ) {

                                                    if($permissionEditInputLocked==0){
                                                        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_%', array(
                                                                'label' => '',
                                                                'readonly' => true,
                                                                'id' => 'ristourne' . $i,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['ristourne_%'],
                                                                'onchange' => 'javascript:calculRistourneVal(this.id);',
                                                                'class' => 'form-control',
                                                            )) . "</div>";

                                                        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_val', array(
                                                                'label' => '',
                                                                'readonly' => true,
                                                                //'type' => 'hidden',
                                                                'id' => 'ristourne_val' . $i,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['ristourne_val'],
                                                                'onchange' => 'javascript:calculRistourne(this.id);',
                                                                'class' => 'form-control',
                                                            )) . "</div>";
                                                    }else {
                                                        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_%', array(
                                                                'label' => '',
                                                                'id' => 'ristourne' . $i,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['ristourne_%'],
                                                                'onchange' => 'javascript:calculRistourneVal(this.id);',
                                                                'class' => 'form-control',
                                                            )) . "</div>";

                                                        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_val', array(
                                                                'label' => '',
                                                                'id' => 'ristourne_val' . $i,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['ristourne_val'],
                                                                'onchange' => 'javascript:calculRistourne(this.id);',
                                                                'class' => 'form-control',
                                                            )) . "</div>";
                                                    }


                                                } else {
                                                    echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_%', array(
                                                            'label' => '',
                                                            //'readonly' => true,
                                                            'id' => 'ristourne' . $i,
                                                            'value' => $transportBillRide['TransportBillDetailRides']['ristourne_%'],
                                                            'onchange' => 'javascript:calculRistourneVal(this.id);',
                                                            'class' => 'form-control',
                                                        )) . "</div>";

                                                    echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_val', array(
                                                            'label' => '',
                                                            //'readonly' => true,
                                                            //'type' => 'hidden',
                                                            'id' => 'ristourne_val' . $i,
                                                            'value' => $transportBillRide['TransportBillDetailRides']['ristourne_val'],
                                                            'onchange' => 'javascript:calculRistourne(this.id);',
                                                            'class' => 'form-control',
                                                        )) . "</div>";
                                                }

                                                ?>
                                            </td>
                                            <?php


                                            if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                                || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                                            ) {
                                                ?>
                                                <td style="min-width: 130px;">
                                                    <?php
                                                if($permissionEditInputLocked==0){
                                                    echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                                            'placeholder' => __('Enter quantity'),
                                                            'id' => 'nb_trucks' . $i,
                                                            'label' => '',
                                                            'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                                            'readonly' => true,
                                                            'onchange' => 'javascript:calculatePriceRide(this.id);',
                                                            'class' => 'form-control',
                                                        )) . "</div>";
                                                }else {
                                                    if ($nbTrucksModifiable == 2) {
                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                                                'label' => '',
                                                                'placeholder' => __('Enter quantity'),
                                                                'onchange' => 'javascript: calculatePriceRide(this.id);',

                                                                'readonly' => true,
                                                                'id' => 'nb_trucks' . $i,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                                                'class' => 'form-control',
                                                            )) . "</div>";
                                                    } else {
                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                                                'label' => '',
                                                                'placeholder' => __('Enter quantity'),
                                                                'onchange' => 'javascript: calculatePriceRide(this.id);',
                                                                'id' => 'nb_trucks' . $i,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                                                'class' => 'form-control',
                                                            )) . "</div>";
                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.marchandise_unit_id',
                                                                array(
                                                                    'label' => '',
                                                                    'empty' => true,
                                                                    'placeholder' => __('Enter unit'),
                                                                    'id' => 'nb_trucks_units_1',
                                                                    'options' => $marchandiseUnits,
                                                                    'value' => $transportBillRide['TransportBillDetailRides']['marchandise_unit_id'],
                                                                    'class' => 'form-control',
                                                                )) . "</div>";
                                                    }
                                                }


                                                    ?>
                                                </td>

                                            <?php } else { ?>
                                                <td style="min-width: 130px;">
                                                    <?php
                                                    if ($nbTrucksModifiable == 2) {
                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                                                'label' => '',
                                                                'placeholder' => __('Enter quantity'),
                                                                'onchange' => 'javascript: calculatePriceRide(this.id);',

                                                                'readonly' => true,
                                                                'id' => 'nb_trucks' . $i,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                                                'class' => 'form-control',
                                                            )) . "</div>";
                                                    } else {
                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
                                                                'label' => '',
                                                                'placeholder' => __('Enter quantity'),
                                                                'onchange' => 'javascript: calculatePriceRide(this.id);',
                                                                'id' => 'nb_trucks' . $i,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['nb_trucks'],
                                                                'class' => 'form-control',
                                                            )) . "</div>";
                                                        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.marchandise_unit_id',
                                                                array(
                                                                    'label' => '',
                                                                    'empty' => true,
                                                                    'placeholder' => __('Enter unit'),
                                                                    'id' => 'nb_trucks_units_1',
                                                                    'options' => $marchandiseUnits,
                                                                    'value' => $transportBillRide['TransportBillDetailRides']['marchandise_unit_id'],
                                                                    'class' => 'form-control',
                                                                )) . "</div>";
                                                    }

                                                    ?>


                                                </td>

                                            <?php } ?>


                                            <td style="min-width: 130px;">
                                                <?php

                                        if($permissionEditInputLocked==0){
                                            echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ht', array(

                                                    'readonly' => true,
                                                    'id' => 'price_ht' . $i,
                                                    'label' => '',
                                                    'value' => $transportBillRide['TransportBillDetailRides']['price_ht'],
                                                    'class' => 'form-control',
                                                )) . "</div>";
                                        }else {
                                            echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ht', array(

                                                    'id' => 'price_ht' . $i,
                                                    'label' => '',
                                                    'value' => $transportBillRide['TransportBillDetailRides']['price_ht'],
                                                    'class' => 'form-control',
                                                )) . "</div>";
                                        }


                                                ?>
                                            </td>
                                            <td style="min-width: 50px;">
                                                <?php
                                                if ($transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: partially_validated
                                                    || $transportBillRide['TransportBillDetailRides']['status_id'] == TransportBillDetailRideStatusesEnum:: validated
                                                ) {

                                                    if($permissionEditInputLocked==0){
                                                        echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.tva_id', array(
                                                                'label' => '',
                                                                'empty' => '',
                                                                'id' => 'tva' . $i,
                                                                'disabled' => true,
                                                                'options' => $tvas,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['tva_id'],
                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                'class' => 'form-control',
                                                            )) . "</div>";

                                                        echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.tva_id', array(
                                                                'label' => '',
                                                                'empty' => '',
                                                                'id' => 'tva' . $i,
                                                                'type' => 'hidden',
                                                                'options' => $tvas,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['tva_id'],
                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                'class' => 'form-control',
                                                            )) . "</div>";

                                                    }else {
                                                        echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.tva_id', array(
                                                                'label' => '',
                                                                'options' => $tvas,
                                                                'id' => 'tva' . $i,
                                                                'onchange' => 'javascript:calculatePriceRide(this.id);',
                                                                'value' => $transportBillRide['TransportBillDetailRides']['tva_id'],
                                                                'class' => 'form-control ',
                                                            )) . "</div>";
                                                    }


                                                } else {
                                                    echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.tva_id', array(
                                                            'label' => '',
                                                            'options' => $tvas,
                                                            'id' => 'tva' . $i,
                                                            'onchange' => 'javascript:calculatePriceRide(this.id);',
                                                            'value' => $transportBillRide['TransportBillDetailRides']['tva_id'],
                                                            'class' => 'form-control ',
                                                        )) . "</div>";
                                                }
                                                ?>
                                            </td>
                                            <td style="min-width: 130px;">
                                                <?php

                                        if($permissionEditInputLocked==0){
                                            echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ttc', array(
                                                    'readonly' => true,
                                                    'label' => '',
                                                    'id' => 'price_ttc' . $i,
                                                    'value' => $transportBillRide['TransportBillDetailRides']['price_ttc'],
                                                    'class' => 'form-control',
                                                )) . "</div>";
                                        }else {
                                            echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ttc', array(

                                                    'label' => '',
                                                    'id' => 'price_ttc' . $i,
                                                    'value' => $transportBillRide['TransportBillDetailRides']['price_ttc'],
                                                    'class' => 'form-control',
                                                )) . "</div>";
                                        }



                                                ?>
                                            </td>

                                            <td style="min-width: 150px;">
                                                <?php
                                                echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.observation_order',
                                                        array(
                                                            'label' => '',
                                                            'id' => 'observation'. $i,
                                                            'value' => $transportBillRide['TransportBillDetailRides']['observation_order'],
                                                            'class' => 'form-control',
                                                        )) . "</div>";
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo "<div id='status-div$i' >";
                                                if($transportBillRide['ProductType']['relation_with_park']==1
                                                ||$type !=TransportBillTypesEnum:: order){
                                                    echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.status_id',
                                                            array(
                                                                'id' => 'status'.$i,
                                                                'type' => 'hidden',
                                                                'value' => $transportBillRide['TransportBillDetailRides']['status_id'],
                                                            )) . "</div>";
                                                    switch ($transportBillRide['TransportBillDetailRides']['status_id']) {

                                                        /*
                                                        1: commandes non validées
                                                        2: commandes partiellement validées
                                                        3: commandes validées
                                                        4: commandes préfacturées.
                                                        7: commandes facturées.
                                                        */
                                                        case StatusEnum::quotation:
                                                            echo '<span class="label label-info position-status">';
                                                            echo __('Quotation') . "</span>";
                                                            break;
                                                        case StatusEnum::not_validated:
                                                            echo '<span class="label label-danger position-status">';
                                                            echo __('Not validated') . "</span>";
                                                            break;
                                                        case StatusEnum::partially_validated:
                                                            echo '<span class="label label-warning position-status">';
                                                            echo __('Partially validated') . "</span>";
                                                            break;
                                                        case StatusEnum::validated:
                                                            echo '<span class="label label-success position-status">';
                                                            echo __('Validated') . "</span>";
                                                            break;
                                                        case StatusEnum::mission_pre_invoiced:
                                                            echo '<span class="label label-primary position-status">';
                                                            echo __('Preinvoiced') . "</span>";
                                                            break;
                                                        case StatusEnum::mission_invoiced:
                                                            echo '<span class="label btn-inverse position-status">';
                                                            echo __('Invoiced') . "</span>";
                                                            break;
                                                        case StatusEnum::not_transmitted:
                                                            echo '<span class="label btn-primary position-status">';
                                                            echo __('Not transmitted') . "</span>";
                                                            break;

                                                        case StatusEnum::canceled:
                                                            echo '<span class="label btn-inverse position-status">';
                                                            echo __('Canceled') . "</span>";
                                                            break;
                                                        case StatusEnum::credit_note:
                                                            echo '<span class="label btn-inverse position-status">';
                                                            echo __('Credit note') . "</span>";
                                                            break;



                                                    }

                                                }else {

                                                    $statuses = array('1'=>__('Not validated'),'3'=>__('Validated'));
                                                    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.status_id',
                                                            array(
                                                                'options'=>$statuses,
                                                                'class' => 'form-control select-search',
                                                                'id' => 'status'.$i,
                                                                'value' => $transportBillRide['TransportBillDetailRides']['status_id'],
                                                            )) . "</div>";

                                                }


                                                echo "</div>";

                                                if (($transportBillRide['TransportBillDetailRides']['status_id'] != TransportBillDetailRideStatusesEnum::validated
                                                    && $transportBillRide['TransportBillDetailRides']['status_id'] = TransportBillDetailRideStatusesEnum:: partially_validated

                                                )
                                                ) {
                                                    ?>


                                                    <?php

                                                    echo "<div class='hidden' id ='description-div$i'>" . $this->Tinymce->input('TransportBillDetailRides.'.$i.'.description',
                                                            array(
                                                                //'id' => 'description'.$i,
                                                                'value'=> $transportBillRide['TransportBillDetailRides']['description']
                                                            )) . "</div>";
                                                    ?>&nbsp;
                                                    <div class="btn-group quick-actions">
                                                        <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="#" class="btn editDescription"  id="editDescription<?php echo $i;?>" onclick="editDescription(this.id);" title="Edit description">
                                                                    <i class="fa fa-edit m-r-5"></i><?= __("Edit description") ?>
                                                                </a>
                                                            </li>

                                                            <li>
                                                                <a href="#" class="btn" title="Delete" id="<?php echo $i ?>" onclick="removeRide('<?php echo $i ?>');"">
                                                                <i class="fa fa-trash-o m-r-5"></i><?= __("Delete") ?>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                <?php } ?>

                                            </td>
                                            <?php if ($type == TransportBillTypesEnum::pre_invoice) { ?>
                                                <td>
                                                    <?php
                                                    echo "<div class='appro'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.approved', array(
                                                            'type' => 'checkbox',
                                                            'label' => false,
                                                            'class' => 'id approve'
                                                        )) . "</div>";
                                                    ?>

                                                </td>

                                            <?php } ?>


                                        <?php } ?>


                                    </tr>


                                    <?php $i++;
                                }
                            } ?>

                            </tbody>

                        </table>
                        </div>


                        <?php if (!isset($this->params['pass']['2'])) {?>
                        <button style="float: right;margin-left: 10px;" type='button' name='add' id='add'
                                class='btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5'
                                onclick='addProduct()'><?= __('Add Product') ?></button>

                                <?php }?>
                        <div style='clear:both; padding-bottom: 20px;'></div>

                        <?php if (($type == TransportBillTypesEnum::invoice || $type == TransportBillTypesEnum::order )
                            && ($profileId != ProfilesEnum::client)) {
                        echo "<div id='interval2' style='margin-left: 20px;'>";
                        echo '<div class="lbl1" style="display: inline-block; width: 150px;">' . __("Penalty");
                        echo "</div>";
                        $options = array('1' => __('Yes'), '2' => __('No'));
                        $attributes = array('legend' => false , 'value' => $this->request->data['TransportBill']['with_penalty']);
                        echo $this->Form->radio('with_penalty', $options, $attributes) . "</div>";?>


                        <div style='clear:both; padding-bottom: 20px;'></div>
                        <div id='penalty-div'>
                            <?php
                            $countPenalties = count($penalties);
                            echo "<div >" . $this->Form->input('TransportBill.nb_penalty', array(
                                    'class' => 'form-control',
                                    'id' => 'nb_penalty',
                                    'value' => $countPenalties,
                                    'type' => 'hidden',
                                )) . "</div>";



                            ?>
                            <table  id='table_penalty'>
                                <?php
                                $i =1;
                                echo "<div>" . $this->Form->input('TransportBill.penalty_deleted_id', array(

                                        'type'=>'hidden',
                                        'id' => 'penalty_deleted_id',
                                    )) . "</div>";
                                if(!empty($penalties)){
                                foreach ($penalties as $penalty){ ?>
                                <tr id='penalty<?php  echo $i ?>'>
                                    <td style="width: 100%;">

                                        <?php

                                        echo "<div>" . $this->Form->input('TransportBillPenalty.'.$i.'.id', array(
                                                'value'=>$penalty['TransportBillPenalty']['id'],
                                                'type'=>'hidden',
                                                'id' => 'penalty_id'.$i,
                                            )) . "</div>";

                                            echo "<div  class='  col-sm-4' style='margin-top: 20px;'>" . $this->Form->input('TransportBillPenalty.'.$i.'.penalty_value', array(
                                                    'label' => __('Value'),
                                                    'class' => 'form-control ',
                                                    'value'=>$penalty['TransportBillPenalty']['penalty_value'],
                                                    'id' => 'penalty_value'.$i,
                                                    'empty'=>'',
                                                )) . "</div>";

                                            echo "<div  class='col-sm-4' style='margin-left:32px; margin-top: 20px;'>" . $this->Form->input('TransportBillPenalty.'.$i.'.penalty_amount', array(
                                                    'label' => __('Amount'),
                                                    'class' => 'form-control',
                                                    'id' => 'penalty_amount'.$i,
                                                    'value'=>$penalty['TransportBillPenalty']['penalty_amount'],
                                                    'onchange' => 'javascript : calculTotalPrice();'
                                                )) . "</div>";


                                        ?>

                                    </td>
                                    <?php if($i==1){ ?>
                                     <td class="td_tab">
                                        <button  type='button' name='add'
                                                 onclick='addRowPenalty()'
                                                 class='btn btn-success'><?= __('Add more') ?>
                                        </button>
                                    </td>
                                    <?php }else{ ?>
                                        <td class="td_tab">
                                            <button style="margin-top: 25px;" name="remove"
                                                    id="remove_penalty<?php echo $i ?>"
                                                    onclick="removePenalty(this.id);"
                                                    class="btn btn-danger btn_remove">X
                                            </button>
                                        </td>

                                    <?php }  ?>


                                    <?php
                                    $i++;
                                     } } ?>

                                </tr>
                            </table>
                            <div style='clear:both; padding-bottom: 20px;'></div>


                        </div>

                            <?php
                            $options = array('1' => __('A terme'), '2' => __('Chèque'), '3' => __('Chèque-banque'), '4' => __('Virement'), '5' => __('Avoir'), '6' => __('Espèce'), '7' => __('Traite'), '8' => __('Fictif'));


                            echo "<div  class='  col-sm-4' style='padding-bottom: 10px;'>" . $this->Form->input('payment_method', array(
                                    'label' => __('Payment method'),
                                    'class' => 'form-control select-search',
                                    'options' => $options,
                                    'empty'=>'',
                                    'id' => 'payment_method',
                                    'onchange' => 'javascript : calculateStampValue();'
                                )) . "</div>";

                            echo "<div  class='col-sm-4' style='padding-bottom: 10px;'>" . $this->Form->input('stamp', array(
                                    'label' => __('Stamp'),
                                    'class' => 'form-control',
                                    'id' => 'stamp',
                                    'readonly' => true,
                                )) . "</div>";
                        } ?>
                        <div style='clear:both;'></div>
                        <div id="total-price">
                            <?php if (($type == TransportBillTypesEnum::order)
                                && ($profileId == ProfilesEnum::client)
                            ) {

                                echo "<div  class='m-t-20 col-sm-4' >" . $this->Form->input('total_ht', array(
                                        'label' => __('Total HT'),
                                        'readonly' => true,
                                        'class' => 'form-control',
                                        'id' => 'total_ht',
                                        'type' => 'hidden',
                                    )) . "</div>";
                                echo "<div  class='m-t-20 col-sm-4'>" . $this->Form->input('total_tva', array(
                                        'label' => __('Total TVA'),
                                        'readonly' => true,
                                        'class' => 'form-control',
                                        'id' => 'total_tva',
                                        'type' => 'hidden',
                                    )) . "</div>";

                                echo "<div  class='m-t-20 col-sm-4'>" . $this->Form->input('total_ttc', array(
                                        'label' => __('Total TTC'),
                                        'readonly' => true,
                                        'class' => 'form-control',
                                        'id' => 'total_ttc',
                                        'type' => 'hidden',
                                    )) . "</div>";

                            } else {
                                echo "<div  class='m-t-20 col-sm-4'>" . $this->Form->input('total_ht', array(
                                        'label' => __('Total HT'),
                                        'readonly' => true,
                                        'class' => 'form-control',
                                        'id' => 'total_ht',
                                    )) . "</div>";

                                echo "<div  class='m-t-20  col-sm-4'>" . $this->Form->input('ristourne_val', array(
                                        'label' => __('Ristourne'),
                                        'class' => 'form-control',
                                        'id' => 'ristourne_val',
                                        'onchange' => 'javascript : calculateGlobalRistourne();',
                                        'type' => 'text',
                                    )) . "</div>";

                                echo "<div  class='m-t-20  col-sm-4'>" . $this->Form->input('ristourne_percentage', array(
                                        'label' => __('Ristourne') . ' ' . ('%'),
                                        'class' => 'form-control',
                                        'id' => 'ristourne_percentage',
                                        'onchange' => 'javascript : calculateGlobalRistourneVal();',
                                        'type' => 'text',
                                    )) . "</div>";
                                echo "<div  class='form-group m-t-20  col-sm-4'>" . $this->Form->input('total_tva', array(
                                        'label' => __('Total TVA'),
                                        'readonly' => true,
                                        'class' => 'form-control',
                                        'id' => 'total_tva',
                                    )) . "</div>";


                                echo "<div  class='m-t-20  col-sm-4'>" . $this->Form->input('total_ttc', array(
                                        'label' => __('Total TTC'),
                                        'readonly' => true,
                                        'class' => 'form-control',
                                        'id' => 'total_ttc',

                                    )) . "</div>";

                            }
                            ?>
                        </div>
                            <div style='clear:both;'></div>
                            <div style='clear:both; padding-bottom: 20px;'></div>
                            <?php echo "<div  class='form-group'>" . $this->Form->input('note', array(
                                    'label' => __('Note'),

                                    'class' => 'form-control',


                                )) . "</div>";
                            ?>




                        <div style="clear:both;"></div>

                    </div>
                    <?php
                    if ($profileId != ProfilesEnum::client) {
                        ?>
                        <div class="tab-pane" id="tab_2">

                            <?php
                            if ($profileId != ProfilesEnum::client) {

                                echo "<div class='form-group col-sm-4 clear-none'>" . $this->Form->input('transport_bill_category_id', array(
                                        'label' => __('Category'),
                                        'empty' => '',
                                        'id' => 'category',
                                        'class' => 'form-control select-search',
                                    )) . "</div>"; ?>
                                <!-- overlayed element -->
                                <div id="dialogModalCategory">
                                    <!-- the external content is loaded inside this tag -->
                                    <div id="contentWrapCategory"></div>
                                </div>
                                <div class="popupactions">

                                    <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                        array("controller" => "transportBills", "action" => "addCategory"),
                                        array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayCategory", 'escape' => false, "title" => __("Add Category"))); ?>

                                </div>
                                <div style="clear:both"></div>

                                <?php

                                echo "<div class='form-group col-sm-4 clear-none' >" . $this->Form->input('customer_id', array(
                                        'label' => __('Commercial'),
                                        'empty' => '',
                                        'id' => 'commercial',
                                        'class' => 'form-control select-search-customer',
                                    )) . "</div>";
                            }
                            ?>
                            <div style="clear:both"></div>
                        </div>
                        <div class="tab-pane" id="tab_3">
                            <?php
                            echo "<div class='form-group col-sm-4'>" . $this->Form->input('previous_reference', array(
                                    'label' => __('Previous reference'),
                                    'class' => 'form-control',
                                    'placeholder' => __('Enter reference'),
                                )) . "</div>";

                            echo "<div class='form-group col-sm-4'>" . $this->Form->input('next_reference', array(
                                    'label' => __('Next reference'),
                                    'class' => 'form-control',
                                    'placeholder' => __('Enter reference'),
                                )) . "</div>";
                            ?>
                            <div style="clear:both;"></div>

                        </div>
                    <?php } ?>
                    <?php if ($type == TransportBillTypesEnum::invoice) { ?>
                        <div class="tab-pane" id="tab_4">
                            <div id='reglement'>
                                <p style='font-weight: bold'><?php echo __('Non-associated financial transactions') ?></p>
                                <?= $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Associate'),
                                    'javascript:associateAdvancedPaymentToTransportBill(' . $this->request->data['TransportBill']['id'] . ',' . 4 . ');',
                                    array('escape' => false, 'class' => 'btn btn-primary btn-bordred waves-effect waves-light m-b-5',
                                        'disabled' => 'true', 'id' => 'associate'));
                                ?>
                                <table id="datatable-responsive2"
                                       class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">
                                            <button type="button" id='checkbox'
                                                    class="btn btn-default btn-sm checkbox-toggle">
                                                <i class="fa fa-square-o"></i></button>
                                        </th>
                                        <th><?php echo __('Date'); ?></th>
                                        <th><?php echo __('Amount'); ?></th>
                                        <th><?php echo __('Payment type'); ?></th>
                                        <th><?php echo __('Rest'); ?></th>
                                        <th><?php echo __('Wording'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    echo "<div class='form-group'>" . $this->Form->input('ids', array(
                                            'type' => 'hidden',
                                            'id' => 'ids',
                                            'class' => 'form-control',
                                        )) . "</div>";


                                    foreach ($advancedPayments as $advancedPayment) {
                                        ?>
                                        <tr>
                                            <td>
                                                <input id="idCheck" type="checkbox" class='id2'
                                                       value=<?php echo $advancedPayment['Payment']['id'] ?>>
                                            </td>
                                            <td><?php echo h($this->Time->format($advancedPayment['Payment']['receipt_date'], '%d-%m-%Y')); ?></td>
                                            <td><?php echo number_format($advancedPayment['Payment']['amount'], 2, ",", $separatorAmount); ?></td>
                                            <td><?php switch ($advancedPayment['Payment']['payment_type']) {
                                                    case 1:
                                                        echo __('Species');
                                                        break;
                                                    case 2:
                                                        echo __('Transfer');
                                                        break;
                                                    case 3:
                                                        echo __('Bank check');
                                                        break;

                                                } ?></td>
                                            <td>   <?php echo number_format($advancedPayment['Payment']['amount'], 2, ",", $separatorAmount); ?></td>
                                            <td><?php echo h($advancedPayment['Payment']['wording']); ?></td>

                                        </tr>
                                        <?php
                                    }
                                    foreach ($remainingPayments as $remainingPayment) {
                                        ?>
                                        <tr>
                                            <td>
                                                <input id="idCheck" type="checkbox" class='id2'
                                                       value=<?php echo $remainingPayment['Payment']['id'] ?>>
                                            </td>
                                            <td><?php echo h($this->Time->format($remainingPayment['Payment']['receipt_date'], '%d-%m-%Y')); ?></td>
                                            <td><?php echo number_format($remainingPayment['Payment']['amount'], 2, ",", $separatorAmount); ?></td>
                                            <td><?php switch ($remainingPayment['Payment']['payment_type']) {
                                                    case 1:
                                                        echo __('Species');
                                                        break;
                                                    case 2:
                                                        echo __('Transfer');
                                                        break;
                                                    case 3:
                                                        echo __('Bank check');
                                                        break;

                                                } ?></td>
                                            <td> <?php $amountRemaining = $remainingPayment['Payment']['amount'] - $remainingPayment[0]['sum_payroll_amount'];
                                                echo number_format($amountRemaining, 2, ",", $separatorAmount); ?>
                                            </td>
                                            <td><?php echo h($remainingPayment['Payment']['wording']); ?></td>

                                        </tr>
                                    <?php } ?>

                                    </tbody>
                                </table>
                                <br><br>

                                <p style='font-weight: bold'><?php echo __('Financial transactions associated with the current bill') ?></p>

                                <?= $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Dissociate'),
                                    'javascript:dissociatePaymentsToTransportBill(' . $this->request->data['TransportBill']['id'].');',
                                    array('escape' => false, 'class' => 'btn btn-primary btn-bordred waves-effect waves-light m-b-5',
                                        'disabled' => 'true', 'id' => 'dissociate'));
                                ?>
                                <br><br>

                                <table id="datatable-responsive3" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">
                                            <button type="button" id='checkbox'
                                                    class="btn btn-default btn-sm checkbox-toggle">
                                                <i class="fa fa-square-o"></i></button>
                                        </th>
                                        <th><?php echo __('Date'); ?></th>
                                        <th><?php echo __('Amount'); ?></th>
                                        <th><?php echo __('Tranche'); ?></th>
                                        <th><?php echo __('Payment type'); ?></th>
                                        <th><?php echo __('Wording'); ?></th>
                                        <th><?php echo __('Actions'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($paymentParts as $paymentPart) {
                                        ?>
                                        <tr>
                                            <td>
                                                <input id="idCheck" type="checkbox" class='id3'
                                                       value=<?php echo $paymentPart['Payment']['id'] ?>>
                                            </td>
                                            <td><?php echo h($this->Time->format($paymentPart['Payment']['receipt_date'], '%d-%m-%Y')); ?></td>
                                            <td><?php echo number_format($paymentPart['Payment']['amount'], 2, ",", $separatorAmount); ?></td>
                                            <td><?php echo number_format($paymentPart['DetailPayment']['payroll_amount'], 2, ",", $separatorAmount); ?></td>
                                            <td><?php switch ($paymentPart['Payment']['payment_type']) {
                                                    case 1:
                                                        echo __('Species');
                                                        break;
                                                    case 2:
                                                        echo __('Transfer');
                                                        break;
                                                    case 3:
                                                        echo __('Bank check');
                                                        break;

                                                } ?></td>
                                            <td><?php echo h($paymentPart['Payment']['wording']); ?></td>
                                            <td> <?= $this->Html->link(
                                                    '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                    'javascript:editPayment(' . $paymentPart['Payment']['id'] . ',' . $paymentPart['Payment']['payment_association_id'] . ');',
                                                    array('escape' => false, 'class' => 'btn btn-primary')
                                                ); ?></td>

                                        </tr>
                                    <?php } ?>

                                    </tbody>
                                </table>

                                <br><br>
                            </div>
                            <?php if ($type == TransportBillTypesEnum::invoice) { ?>
                                <br>
                                <br>
                                <div class="total" id='total'>
                                    <?php
                                    $totalAmount = $this->request->data['TransportBill']['total_ttc'];
                                    $totalAmountRemaining = $this->request->data['TransportBill']['amount_remaining'];
                                    $reglement = $totalAmount - $totalAmountRemaining; ?>
                                    <span><strong><?php echo __('Règlement : '); ?></strong></span>
                                    <span> <?= number_format($reglement, 2, ",", $separatorAmount) . ' ' . $this->Session->read("currency"); ?></span><br>
                                    <br>
                                    <span><strong><?php echo __('Left to pay : '); ?></strong></span>
                                    <span> <?= number_format($totalAmountRemaining, 2, ",", $separatorAmount) . ' ' . $this->Session->read("currency"); ?></span><br>

                                </div>
                            <?php } ?>
                        </div>
                        <div class="tab-pane" id="tab_5">

                            <table id='table-deadlines' class="table table-bordered " style='width:50%;'>
                                <?php

                                echo "<div class='select-inline'>" . $this->Form->input('Deadlines.deleted_id', array(
                                        'type' => 'hidden',
                                        'id' => 'deleted_id',
                                        'value' => ''
                                    )) . "</div>";
                                $i = 1;
                                $nbDeadline = count($deadlines);
                                if (!empty($deadlines)) {
                                    foreach ($deadlines as $deadline) {
                                        ?>

                                        <tr id='tr-deadline<?php echo $i ?>'>
                                            <td style='width:90%; height: 100px;'>
                                                <?php

                                                echo "<div class='select-inline' >" . $this->Form->input('Deadline.' . $i . '.id', array(
                                                        'type' => 'hidden',
                                                        'value' => $deadline['Deadline']['id'],
                                                        'id' => 'deadlineId' . $i,
                                                    )) . "</div>";
                                                $currentDate = date("Y-m-d");
                                                echo "<div class='select-inline' style='width: 350px;'>" . $this->Form->input('Deadline.' . $i . '.deadline_date', array(
                                                        'label' => '',
                                                        'type' => 'text',
                                                        'value' => $this->Time->format($deadline['Deadline']['deadline_date'], '%d/%m/%Y'),
                                                        'class' => 'form-control datemask',
                                                        'before' => '<label class="dte">' . __('Date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                                        'after' => '</div>',
                                                        'id' => 'deadline_date' . $i,
                                                    )) . "</div>";

                                                echo "<div style='clear:both; padding-top: 10px;'></div>";
                                                echo "<div class='select-inline' >" . $this->Form->input('Deadline.' . $i . '.percentage', array(
                                                        'label' => __('Percentage'),
                                                        'class' => 'form-filter ',
                                                        'id' => 'percentage' . $i,
                                                        'value' => $deadline['Deadline']['percentage'],
                                                        'onchange' => 'javascript : calculateValueDeadline(this.id);'
                                                    )) . "</div>";


                                                echo "<div class='select-inline' >" . $this->Form->input('Deadline.' . $i . '.value', array(
                                                        'label' => __('Value'),
                                                        'class' => 'form-filter ',
                                                        'id' => 'value' . $i,
                                                        'value' => $deadline['Deadline']['value'],
                                                        'onchange' => 'javascript : calculatePercentageDeadline(this.id);'
                                                    )) . "</div>";

                                                ?>
                                            </td>
                                            <td class="td_tab" id='td-button1'>
                                                <button style="margin-top: 40px; margin-left: 10px;" name="remove"
                                                        id="remove_deadline<?php echo $i ?>"
                                                        onclick="removeDeadline(this.id);"
                                                        class="btn btn-danger btn_remove">X
                                                </button>

                                            </td>
                                        </tr>

                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr id='tr-deadline1'>
                                        <td style='width:90%; height: 100px;'>
                                            <?php
                                            echo "<div class='select-inline' style='width: 350px;'>" . $this->Form->input('Deadline.1.deadline_date', array(
                                                    'label' => '',
                                                    'type' => 'text',
                                                    'class' => 'form-control datemask',
                                                    'before' => '<label class="dte">' . __('Date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                                    'after' => '</div>',
                                                    'id' => 'deadline_date1',
                                                )) . "</div>";

                                            echo "<div style='clear:both; padding-top: 10px;'></div>";
                                            echo "<div class='select-inline' >" . $this->Form->input('Deadline.1.percentage', array(
                                                    'label' => __('Percentage'),
                                                    'class' => 'form-filter ',
                                                    'id' => 'percentage1',
                                                    'onchange' => 'javascript : calculateValueDeadline(this.id);'
                                                )) . "</div>";


                                            echo "<div class='select-inline' >" . $this->Form->input('Deadline.1.value', array(
                                                    'label' => __('Value'),
                                                    'class' => 'form-filter ',
                                                    'id' => 'value1',
                                                    'onchange' => 'javascript : calculatePercentageDeadline(this.id);'
                                                )) . "</div>";

                                            ?>
                                        </td>
                                        <td class="td_tab" id='td-button1'>
                                            <button style="margin-top: 40px; margin-left: 10px;" name="remove"
                                                    id="remove_deadline1"
                                                    onclick="removeDeadline(this.id);"
                                                    class="btn btn-danger btn_remove">X
                                            </button>

                                        </td>
                                    </tr>

                                <?php } ?>


                            </table>
                            <div id='div-button' style="float: left;">
                                <button style="margin-top: 25px; width: 40px" type='button' name='add'
                                        id='<?php echo $nbDeadline + 1; ?>'
                                        onclick='addDeadlineDiv(this.id)'
                                        class='btn btn-success'>+
                                </button>

                            </div>
                            <div style="clear:both;"></div>

                        </div>
                    <?php } ?>


                </div>


            </div>

        </div>

        <div class="box-footer">
            <?php echo $this->Form->submit(__('Save'), array(
                'name' => 'ok',
                'class' => 'btn btn-primary btn-bordred  m-b-5',
                'label' => __('Submit'),
                'type' => 'submit',
                'id' => 'submitButton',
                'div' => false
            )); ?>
            <?php echo $this->Form->submit(__('Duplicate'), array(
                'name' => 'duplicate',
                'class' => 'btn btn-primary btn-bordred  m-b-5',
                'label' => __('Submit'),
                'type' => 'submit',
                'div' => false
            )); ?>
            <?php echo $this->Form->submit(__('Duplicate & revive'), array(
                'name' => 'duplicate_revive',
                'class' => 'btn btn-primary btn-bordred  m-b-5',
                'label' => __('Submit'),
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
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('maskedinput'); ?>
<?= $this->Html->script('plugins/datetimepicker/moment-with-locales.min.js'); ?>
<?= $this->Html->script('plugins/datetimepicker/bootstrap-datetimepicker.min.js'); ?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
<?= $this->Html->script('plugins/iCheck/icheck.min'); ?>
<?= $this->Html->script('tinymce/tinymce.min.js'); ?>
<script type="text/javascript">

    $(document).ready(function () {
        $('#submitButton').on('click', function (e) {
            //e.preventDefault();
            var submit = true;
            $(':input[required]').each(function () {
                if ($(this).val() == '') {
                    submit = false;
                }
            });
            if (submit) {
                $('form#TransportBillAddForm').submit();
            }
        });

        jQuery("#date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
        jQuery("#receipt_date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
        jQuery("#deadline_date1").inputmask("date", {"placeholder": "dd/mm/yyyy"});
        jQuery('#reference').parent('.input').addClass('required');
        if (jQuery('#commercial').val()) {
            var customerId = jQuery('#commercial').val();
        } else {
            var customerId = '';
        }

        jQuery('.select-search-customer').select2({
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
        jQuery("#dialogModalDescription").dialog({
            autoOpen: false,
            height: 400,
            width: 600,
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
        jQuery(".overlayCategory").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapCategory').load(jQuery(this).attr("href"));
            jQuery('#dialogModalCategory').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalCategory').dialog('open');
        });

        var nbRide = jQuery("#nb_ride").val();

        for (var i = 1; i <= nbRide; i++) {
            jQuery("#start_date" + '' + i + '').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
            jQuery("#end_date" + '' + i + '').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
            jQuery("#start_date" + '' + i + '').parent().parent().addClass('required');

            jQuery("#programming_date" + '' + i + '').inputmask("date", {"placeholder": "dd/mm/yyyy"});
            jQuery("#charging_time" + '' + i + '').inputmask("hh:mm", {"placeholder": "HH:MM"});
            jQuery("#unloading_date" + '' + i + '').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});

            jQuery('#ride_category' + '' + i + '').parent('.input.select').css('margin-top', '13px');
            jQuery('#delivery_with_return' + '' + i + '').parent('.input.select').css('margin-top', '13px');
            if (jQuery("#type_price" + '' + i + '').val()) {
                jQuery('#type_price' + '' + i + '').parent('.input.select').css('margin-top', '13px');
            }
            jQuery('#client_final' + '' + i + '').parent('.input.select').css('margin-top', '13px');
            jQuery('#designation' + '' + i + '').css('margin-top', '8px');
            jQuery('#ristourne' + '' + i + '').css('margin-top', '8px');

            if(jQuery('#car_required' + '' + i +'').val()==1){
                jQuery('#car' + '' + i +'').parent().addClass('required');
            }
            /* if(jQuery('#detail_ride' + '' + i + '').val()>0){
             var id = 'detail_ride' + i ;

             getPriceRide(id);
             }*/
        }
        if(jQuery('#gestion_programmation_sous_traitance').val()=='1'
            && jQuery('#type').val()!=1
        ){
            jQuery('#programming_date' + '' + i + '').parent().parent().attr('class', 'input text required');
            jQuery('#charging_time' + '' + i + '').parent().parent().attr('class', 'input text required');
            jQuery('#unloading_date' + '' + i + '').parent().parent().attr('class', 'input text required');
            jQuery('#arrival_destination' + '' + i + '').parent('.input.select').addClass('required');
            jQuery('#order_type').parent('.input.select').addClass('required');
        }


        if(jQuery('#gestion_programmation_sous_traitance').val()=='1'
            && jQuery('#type').val() ==2
        ){
            jQuery('#client_contact').parent('.input').addClass('required');
        }
        if(jQuery('#type').val() == 10){
            jQuery('#credit_note_type').parent('.input.select').addClass('required');
            jQuery('#invoice_id').parent('.input.select').addClass('required');
            jQuery('#order_type').parent('.input.select').removeClass('required');
        }

        jQuery('input.checkall').on('ifClicked', function (event) {
            var cases = jQuery(":checkbox.id");
            if (jQuery('#checkall').prop('checked')) {
                cases.iCheck('uncheck');
            } else {
                cases.iCheck('check');
            }
        });

        jQuery('input.id').on('ifUnchecked', function (event) {
            var ischecked = false;
            jQuery(":checkbox.id").each(function () {
                if (jQuery(this).prop('checked'))
                    ischecked = true;
            });

        });
        $(' input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });

        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {

            var clicks = $(this).data('clicks');
            if (clicks) {
                //Uncheck all checkboxes
                $(" input[type='checkbox']").iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
            } else {
                //Check all checkboxes
                $(" input[type='checkbox']").iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

            }
            $(this).data("clicks", !clicks);
        });


        var table2 = $('#datatable-responsive2').DataTable({
                'drawCallback': function (settings) {
                    $('input[type="checkbox"]').iCheck(
                        {
                            handle: 'checkbox',
                            checkboxClass: 'icheckbox_flat-red'
                        });
                },
                "bPaginate": false,
                ordering: false,
                fixedHeader: true

            }
        );
        var table3 = $('#datatable-responsive3').DataTable({
                'drawCallback': function (settings) {
                    $('input[type="checkbox"]').iCheck(
                        {
                            handle: 'checkbox',
                            checkboxClass: 'icheckbox_flat-red'
                        });
                },
                "bPaginate": false,
                ordering: false,
                fixedHeader: true

            }
        );

//Enable iCheck plugin for checkboxes
//iCheck for checkbox and radio inputs
        $('#datatable-responsive2 input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });

        $(".checkbox-toggle").click(function () {

            var clicks = $(this).data('clicks');
            if (clicks) {
                //Uncheck all checkboxes
                $("#datatable-responsive2 input[type='checkbox']").iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                jQuery("#associate").attr("disabled", "true");
                var myCheckboxes = new Array();
                jQuery('.id2:checked').each(function () {
                    myCheckboxes.push(jQuery(this).val());
                });
                jQuery('#ids').val(myCheckboxes);


            } else {
                //Check all checkboxes
                $("#datatable-responsive2 input[type='checkbox']").iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
                jQuery("#associate").removeAttr("disabled");
                var myCheckboxes = new Array();
                jQuery('.id2:checked').each(function () {
                    myCheckboxes.push(jQuery(this).val());
                });
                jQuery('#ids').val(myCheckboxes);

            }
            $(this).data("clicks", !clicks);
        });


        $('#datatable-responsive2').on('ifChecked', 'input', function () {
            jQuery("#associate").removeAttr("disabled");
            var myCheckboxes = new Array();
            jQuery('.id2:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
            jQuery('#ids').val(myCheckboxes);
        });

        $('#datatable-responsive2').on('ifUnchecked', 'input', function () {
            var myCheckboxes = new Array();
            jQuery('.id2:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
            jQuery('#ids').val(myCheckboxes);
            var ischecked = false;
            jQuery(":checkbox.id2").each(function () {
                if (jQuery(this).prop('checked'))
                    ischecked = true;
            });
            if (!ischecked) {
                jQuery("#associate").attr("disabled", "true");
            }
        });




        $('#datatable-responsive3 input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });

        $(".checkbox-toggle").click(function () {

            var clicks = $(this).data('clicks');
            if (clicks) {
                //Uncheck all checkboxes
                $("#datatable-responsive3 input[type='checkbox']").iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                jQuery("#associate").attr("disabled", "true");
                var myCheckboxes = new Array();
                jQuery('.id3:checked').each(function () {
                    myCheckboxes.push(jQuery(this).val());
                });
                jQuery('#ids').val(myCheckboxes);


            } else {
                //Check all checkboxes
                $("#datatable-responsive3 input[type='checkbox']").iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
                jQuery("#dissociate").removeAttr("disabled");
                var myCheckboxes = new Array();
                jQuery('.id3:checked').each(function () {
                    myCheckboxes.push(jQuery(this).val());
                });
                jQuery('#ids').val(myCheckboxes);

            }
            $(this).data("clicks", !clicks);
        });


        $('#datatable-responsive3').on('ifChecked', 'input', function () {
            jQuery("#dissociate").removeAttr("disabled");
            var myCheckboxes = new Array();
            jQuery('.id3:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
            jQuery('#ids').val(myCheckboxes);
        });

        $('#datatable-responsive3').on('ifUnchecked', 'input', function () {
            var myCheckboxes = new Array();
            jQuery('.id3:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
            jQuery('#ids').val(myCheckboxes);
            var ischecked = false;
            jQuery(":checkbox.id3").each(function () {
                if (jQuery(this).prop('checked'))
                    ischecked = true;
            });
            if (!ischecked) {
                jQuery("#dissociate").attr("disabled", "true");
            }
        });

        jQuery('input.id2').on('ifUnchecked', function (event) {

            var myCheckboxes = new Array();
            jQuery('.id2:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
            jQuery('#ids').val(myCheckboxes);
            var ischecked = false;
            jQuery(":checkbox.id2").each(function () {
                if (jQuery(this).prop('checked'))
                    ischecked = true;
            });

            if (!ischecked) {
                jQuery("#associate").attr("disabled", "true");


            }
        });
        $('input.id2').on('ifChecked', function (event) {

            jQuery("#associate").removeAttr("disabled");
            var myCheckboxes = new Array();
            jQuery('.id2:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
            jQuery('#ids').val(myCheckboxes);

        });

        jQuery('input.id3').on('ifUnchecked', function (event) {

            var myCheckboxes = new Array();
            jQuery('.id3:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
            jQuery('#ids').val(myCheckboxes);
            var ischecked = false;
            jQuery(":checkbox.id3").each(function () {
                if (jQuery(this).prop('checked'))
                    ischecked = true;
            });

            if (!ischecked) {
                jQuery("#dissociate").attr("disabled", "true");


            }
        });
        $('input.id3').on('ifChecked', function (event) {

            jQuery("#dissociate").removeAttr("disabled");
            var myCheckboxes = new Array();
            jQuery('.id3:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
            jQuery('#ids').val(myCheckboxes);

        });






        jQuery('#TransportBillWithPenalty1').change(function () {

            jQuery("#penalty-div").load('<?php echo $this->Html->url('/transportBills/getPenalties/')?>' + 1, function () {

            });
        });
        jQuery('#TransportBillWithPenalty2').change(function () {

            jQuery("#penalty-div").load('<?php echo $this->Html->url('/transportBills/getPenalties/')?>' + 2, function () {
                calculTotalPrice();
            });
        });


        jQuery('#client').change(function () {

            jQuery('#service-div').load('<?php echo $this->Html->url('/services/getServicesBySupplier/')?>' + $(this).val(), function () {
                $(".select3").select2({
                    sorter: function (data) {
                        /* Sort data using lowercase comparison */
                        return data.sort(function (a, b) {
                            a = a.text.toLowerCase();
                            b = b.text.toLowerCase();
                            if (a > b) {
                                return 1;
                            } else if (a < b) {
                                return -1;
                            }
                            return 0;
                        });
                    },
                    allowDuplicates: true

                });
            });
        });



    });

    function addDeadlineDiv(id) {
        var i = parseInt(id) + 1;
        jQuery("#table-deadlines").append("<tr id=tr-deadline" + i + "></tr>");
        jQuery("#tr-deadline" + '' + i + '').load('<?php echo $this->Html->url('/transportBills/addDeadlineDiv/')?>' + i, function () {
            jQuery("#deadline_date" + '' + i + '').inputmask("date", {"placeholder": "dd/mm/yyyy"});
        });
        $('#div-button').html('<button  style="margin-top: 25px; width: 40px" name="add" id="' + i + '" onclick="addDeadlineDiv(' + i + ');" class="btn btn-success">+</button>');
    }

    function removeDeadline(id) {
        var i = id.substring(id.length - 1, id.length);

        if (jQuery('#deadlineId' + '' + i + '').val()) {
            var deadlineId = jQuery('#deadlineId' + '' + i + '').val();
            var deadlineDeletedId = jQuery('#deleted_id').val();

            if (deadlineDeletedId != '') {
                deadlineDeletedId = deadlineDeletedId + ',' + deadlineId;
            } else {
                deadlineDeletedId = deadlineId;
            }

            jQuery('#deleted_id').val(deadlineDeletedId);
        }
        $('#tr-deadline' + '' + i + '').remove();
    }


    function getPriceRide(id) {

        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(3, trId.length);
        getDesignationProduct(num);
        var client_id = jQuery("#client").val();
        if (client_id == '') {
            client_id = null;
        }
        var rideId = jQuery("#detail_ride" + '' + num + '').val();

        if (jQuery("#ride_category" + '' + num + '').val()) {
            var ride_category_id = jQuery("#ride_category" + '' + num + '').val();
        } else {
            var ride_category_id = 0;
        }

        if (jQuery("#type_pricing" + '' + num + '').val()) {
            var typePricing = jQuery("#type_pricing" + '' + num + '').val();
        } else {
            var typePricing = 0;
        }
        if (typePricing == 2) {
            var tonnageId = jQuery("#tonnage" + '' + num + '').val();
        } else {
            var tonnageId = 0;
        }

        var delivery_with_return = jQuery("#delivery_with_return" + '' + num + '').val();
        if (jQuery("#type_price" + '' + num + '').val()) {
            var typePrice = jQuery("#type_price" + '' + num + '').val();
        } else {
            var typePrice = 1;
        }
        var typeRide = jQuery("#type_ride" + '' + num + '').val();
        if (typeRide == '1') {
            var departureId = 0;
            var arrivalId = 0;
            var carTypeId = 0;
            jQuery("#div_unit_price" + '' + num + '').load('<?php echo $this->Html->url('/transportBills/getPriceRide/')?>' + rideId + '/' + num + '/' + client_id + '/' + delivery_with_return + '/' + typePrice + '/' + ride_category_id + '/' + typeRide + '/' + departureId + '/' + arrivalId + '/' + carTypeId + '/' + typePricing + '/' + tonnageId, function () {
                calculatePriceRide(id);
            });
        } else {
            var departureId = jQuery('#departure_destination' + '' + num + '').val();
            var arrivalId = jQuery('#arrival_destination' + '' + num + '').val();
            var carTypeId = jQuery('#car_type' + '' + num + '').val();
            if (departureId == '') {
                departureId = 0;
            }
            if (arrivalId == '') {
                arrivalId = 0;
            }
            if (carTypeId == '') {
                carTypeId = 0;
            }
            rideId = 0;
            jQuery("#div_unit_price" + '' + num + '').load('<?php echo $this->Html->url('/transportBills/getPriceRide/')?>' + rideId + '/' + num + '/' + client_id + '/' + delivery_with_return + '/' + typePrice + '/' + ride_category_id + '/' + typeRide + '/' + departureId + '/' + arrivalId + '/' + carTypeId + '/' + typePricing + '/' + tonnageId, function () {

                calculatePriceRide(id);
            });
        }

    }

    function getPriceAllRide() {

        var link = '<?php echo $this->Html->url('/suppliers/getSupplierCategoryBySupplierId/')?>' ;

        var supplierId = jQuery('#client').val();

        jQuery.ajax({
            type: "POST",
            url: link,
            data: "supplierId=" + supplierId,
            dataType: "json",
            success: function (json) {

                if (json.response === "true") {
                    jQuery("#div-various").load('<?php echo $this->Html->url('/transportBills/getInputSupplierVarious/')?>' +   1, function () {

                    });
                }else {
                    jQuery("#div-various").load('<?php echo $this->Html->url('/transportBills/getInputSupplierVarious/')?>' +   0, function () {

                    });
                }
            }
        });
        var nbRide = parseFloat(jQuery('#nb_ride').val());
        for (var i = 1; i <= nbRide; i++) {

            var id = 'departure_destination' + i;
            if (jQuery("#" + '' + id + '').parents('tr:first').attr('id')) {
                getPriceRide(id);
            }
        }
    }


    function getPriceProduct(id) {
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(3, trId.length);
        var priceCategoryId = jQuery("#price_category" + '' + num + '').val();

        if(priceCategoryId == ''){
            priceCategoryId = null;
        }

        var productId = jQuery("#product" + '' + num + '').val();
        var clientId = jQuery("#client").val();

        if (productId > 1) {

            jQuery("#div_unit_price" + '' + num + '').load('<?php echo $this->Html->url('/transportBills/getPriceProduct/')?>' + productId + '/' + num + '/' + priceCategoryId + '/' +clientId, function () {

                calculatePriceRide(id);
            });
        }
    }

    function calculateGlobalRistourne(){
        if (jQuery("#ristourne_val" ).val() == '' || jQuery("#ristourne_val" ).val() == 0) {
            jQuery("#ristourne_val" ).val(0);
            jQuery("#ristourne_percentage" ).val(0);
            calculTotalPrice();
        }


        if (jQuery("#ristourne_val" ).val() >= 0) {
            var totalHt = parseFloat(jQuery("#total_ht").val());
            var totalTva = parseFloat(jQuery("#total_tva").val());
            var totalTtc = parseFloat(jQuery("#total_ttc").val());
            var ristourneVal = parseFloat(jQuery("#ristourne_val").val());
            if (ristourneVal > totalHt) {
                ristourneVal = totalHt;
                jQuery("#ristourne_val" ).val(ristourneVal);
            }
            var ristourne = ( ristourneVal / totalHt) * 100;
            ristourne = ristourne.toFixed(2);
            jQuery("#ristourne_percentage").val(ristourne);
            totalHt = totalHt - parseFloat(ristourneVal);
            totalHt = totalHt.toFixed(2);
            jQuery("#total_ht" ).val(totalHt);

            if(parseFloat(ristourne)>0 ){

                var ristourneTva = parseFloat(parseFloat(ristourne) * totalTva) / 100;
                ristourneTva = ristourneTva.toFixed(2);
                totalTva = totalTva - parseFloat(ristourneTva);
                totalTva = totalTva.toFixed(2);
                jQuery("#total_tva" ).val(totalTva);

                totalTtc = parseFloat(totalHt) +  parseFloat(totalTva);
                totalTtc = totalTtc.toFixed(2);

                jQuery("#total_ttc" ).val(totalTtc);
                calculateStampValue();


            }
        }
    }

    function calculateGlobalRistourneVal(){

        if (jQuery("#ristourne_percentage" ).val() == '' || jQuery("#ristourne_percentage" ).val() == 0) {
            jQuery("#ristourne_percentage" ).val(0);
            jQuery("#ristourne_val" ).val(0);
            calculTotalPrice();
        }
        
        if (parseFloat(jQuery("#ristourne_percentage" ).val()) > 0) {
            var totalHt = parseFloat(jQuery("#total_ht").val());
            var totalTva = parseFloat(jQuery("#total_tva").val());
            var totalTtc = parseFloat(jQuery("#total_ttc").val());
            var ristourne = parseFloat(jQuery("#ristourne_percentage").val());

            if (parseFloat(ristourne) > 100) {
                ristourne = 100;
                jQuery("#ristourne" ).val(ristourne);
            }

            if(parseFloat(ristourne)==0 || ristourne==''){
                var ristourneVal = 0;
                ristourneVal = ristourneVal.toFixed(2);
                jQuery("#ristourne_val" ).val(ristourneVal);

            } else {
                var ristourneVal = parseFloat(parseFloat(ristourne) * totalHt) / 100;
                ristourneVal = ristourneVal.toFixed(2);
                jQuery("#ristourne_val" ).val(ristourneVal);
                totalHt = totalHt - parseFloat(ristourneVal);
                totalHt = totalHt.toFixed(2);
                jQuery("#total_ht" ).val(totalHt);
            }

            if(parseFloat(ristourne)>0 ){

                var ristourneTva = parseFloat(parseFloat(ristourne) * totalTva) / 100;
                ristourneTva = ristourneTva.toFixed(2);
                totalTva = totalTva - parseFloat(ristourneTva);
                totalTva = totalTva.toFixed(2);

                jQuery("#total_tva" ).val(totalTva);

                totalTtc = parseFloat(totalHt) +  parseFloat(totalTva);
                totalTtc = totalTtc.toFixed(2);

                jQuery("#total_ttc" ).val(totalTtc);
                calculateStampValue();


            }



        }
    }

    function calculRistourne(id) {
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(3, trId.length);
        if (jQuery("#ristourne_val" + '' + num + '').val() > 0) {
            var unit_price = parseFloat(jQuery("#unit_price" + '' + num + '').val());
            var ristourne_val = parseFloat(jQuery("#ristourne_val" + '' + num + '').val());
            if (ristourne_val > unit_price) {
                ristourne_val = unit_price;
                jQuery("#ristourne_val" + '' + num + '').val(ristourne_val);
            }
            var ristourne = (ristourne_val / unit_price) * 100;
            ristourne = ristourne.toFixed(2);
            jQuery("#ristourne" + '' + num + '').val(ristourne);
        }
        calculatePriceRide(id);
    }

    function calculRistourneVal(id) {
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(3, trId.length);

        if (jQuery("#ristourne" + '' + num + '').val() > 0) {
            var unit_price = parseFloat(jQuery("#unit_price" + '' + num + '').val());
            var ristourne = parseFloat(jQuery("#ristourne" + '' + num + '').val());
            if (parseFloat(ristourne) > 100) {
                ristourne = 100;
                jQuery("#ristourne" + '' + num + '').val(ristourne);
            }
            var ristourne_val = parseFloat(parseFloat(ristourne) * unit_price) / 100;
            ristourne_val = ristourne_val.toFixed(2);
            jQuery("#ristourne_val" + '' + num + '').val(ristourne_val);
        }
        calculatePriceRide(id);
    }

    function calculatePriceRide(id) {

        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(3, trId.length);
        var nb_trucks = jQuery("#nb_trucks" + '' + num + '').val();
        var unit_price = jQuery("#unit_price" + '' + num + '').val();
        if (unit_price >= 0 && nb_trucks > 0) {
            var price_ht = nb_trucks * unit_price;
            var nbFactor = jQuery("#nb_factor" + '' + num + '').val();
            for (var j = 1; j <= nbFactor; j++) {
                if (jQuery('#factor' + '' + num + ''+ '' + j + '').val()&&
                    jQuery('#factor' + '' + num + ''+ '' + j + '').val()>0) {

                    price_ht = price_ht * jQuery('#factor' + '' + num + ''+ '' + j + '').val();
                }
            }
            if (jQuery("#ristourne_val" + '' + num + '').val() > 0) {
                price_ht = price_ht - jQuery("#ristourne_val" + '' + num + '').val();
            }
            price_ht = price_ht.toFixed(2);
            jQuery("#price_ht" + '' + num + '').val(price_ht);
            var tva = jQuery("#tva" + '' + num + '').val();
            switch (tva) {
                case '1':
                    tva = 0.19;
                    break;
                case '2':
                    tva = 0.09;
                    break;
                case '3':
                    tva = 0.00;
                    break;
                case '4':
                    tva = 0.00;
                    break;

            }

            var price_ttc = parseFloat(price_ht) + (parseFloat(price_ht) * parseFloat(tva));
            price_ttc = price_ttc.toFixed(2);
            jQuery("#price_ttc" + '' + num + '').val(price_ttc);

            calculTotalPrice();
        }


    }


    function addRideTransportBill() {

        var nb_ride = parseFloat(jQuery('#nb_ride').val());
        var type = parseFloat(jQuery('#type').val());

        jQuery("#rides-tbody").append("<tr id=ride" + nb_ride + "></tr>");
        jQuery('#contentWrapRide').load('<?php echo $this->Html->url('/transportBills/addRideTransportBill/')?>' + nb_ride + '/' + type, function () {

            jQuery(".select-search").select2();
        });
        jQuery('#dialogModalRide').dialog('option', 'title', 'add Ride');
        jQuery('#dialogModalRide').dialog('open');


    }

    function editRideTransportBill(id) {
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');

        var num = trId.substring(3, trId.length);
        var array_ride = jQuery("#array_ride" + '' + num + '').val();
        var nb_ride = parseFloat(jQuery('#nb_ride').val());
        jQuery('#contentWrapRide').load('<?php echo $this->Html->url('/transportBills/editRideTransportBill/')?>' + array_ride + '/' + num, function () {
            jQuery(".select-search").select2();
        });
        jQuery('#dialogModalRide').dialog('option', 'title', 'edit Ride');
        jQuery('#dialogModalRide').dialog('open');
    }


    function deleteRideTransportBill(id) {
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');

        var num = trId.substring(3, trId.length);
        var nb_ride = parseInt(jQuery('#nb_ride').val());
        jQuery('#ride' + num).remove();
        jQuery('#nb_ride').val(nb_ride - 1);
        calculTotalPrice();
    }

    function calculTotalPrice() {

        var totalHt = 0;
        var totalTtc = 0;
        var nb_ride = parseInt(jQuery('#nb_ride').val());
        for (var i = 0; i <= parseInt(nb_ride); i++) {
            if (jQuery("#price_ht" + '' + i + '').val()) {
                if (jQuery("#price_ht" + '' + i + '').val() != 0) {
                    totalHt = totalHt + parseFloat(jQuery("#price_ht" + '' + i + '').val());
                    totalTtc = totalTtc + parseFloat(jQuery("#price_ttc" + '' + i + '').val());
                }
            }
        }
        if(jQuery('#nb_penalty').val()){
            var nbPenalties =  parseInt(jQuery('#nb_penalty').val());
        }else {
            var nbPenalties =0;
        }

        var totalPenalties = 0;
        for (var i = 1; i <= parseInt(nbPenalties); i++) {
            if (jQuery("#penalty_amount" + '' + i + '').val()) {
                if (jQuery("#penalty_amount" + '' + i + '').val() != 0) {
                    totalPenalties = totalPenalties + parseFloat(jQuery("#penalty_amount" + '' + i + '').val());
                }
            }
        }
        totalHt = totalHt - totalPenalties;
        totalTtc = totalTtc - totalPenalties;
        var totalTva = totalTtc - totalHt;
        totalHt = totalHt.toFixed(2);
        totalTva = totalTva.toFixed(2);
        totalTtc = totalTtc.toFixed(2);
        if (jQuery("#ristourne_val").val()>0) {
            var ristourneVal = jQuery("#ristourne_val").val();
            totalTtc = parseFloat(totalTtc) - parseFloat(ristourneVal);
        }
        jQuery("#total_ht").val(totalHt);
        jQuery("#total_tva").val(totalTva);
        jQuery("#total_ttc").val(totalTtc);
        calculateStampValue();
//jQuery('#nb_ride').val(nb_ride+1) ;

    }


    function calculateStampValue() {
        var paymentMethod = jQuery("#payment_method").val();
        if (paymentMethod == 6) {
            var totalTtc = jQuery('#total_ttc').val();
            var stamp = parseFloat(totalTtc) / 100;
            if (parseFloat(stamp) >= 2500) {
                stamp = 2500;
            }
            totalTtc = parseFloat(totalTtc) + parseFloat(stamp);
            totalTtc = totalTtc.toFixed(2);
            jQuery('#stamp').val(stamp);
            jQuery('#total_ttc').val(totalTtc);
        } else {
            var totalHt = jQuery('#total_ht').val();
            var totalTva = jQuery('#total_tva').val();
            var totalTtc = parseFloat(totalHt) + parseFloat(totalTva);
            totalTtc = totalTtc.toFixed(2);
            jQuery('#stamp').val('');
            jQuery('#total_ttc').val(totalTtc);
        }
    }


    function getFinalSupplierByInitialSupplier() {
        var supplierId = jQuery('#client').val();
        jQuery("#supplier_final_div").load('<?php echo $this->Html->url('/transportBills/getFinalSupplierByInitialSupplier/')?>' + supplierId, function () {
            jQuery('.select-search').select2();
        });
    }

    function addDetailRide() {

        var i = jQuery("#nb_ride").val();
        i++;
        var type = jQuery('#type').val();
        $('#dynamic_field').append('<tr id="row' + i + '"><td ></td></tr>');
        jQuery("#nb_ride").val(i);

        jQuery("#row" + '' + i + '').load('<?php echo $this->Html->url('/transportBills/addDetailRide/')?>' + i + '/' + type, function () {
            $('.select-search').select2();

            $('.select-search-detail-ride').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/detailRides/getDetailRidesByKeyWord')?>",
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
            $('.select-search-client-final').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/suppliers/getFinalSuppliersByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            supplierId: jQuery('#client').val()
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2

            });
            jQuery("#reference" + '' + i + '').css('margin-top', 8);
            jQuery("#ristourne" + '' + i + '').css('margin-top', 8);
            jQuery('#ride_category' + '' + i + '').parent('.input.select').css('margin-top', '13px');
            jQuery('#delivery_with_return' + '' + i + '').parent('.input.select').css('margin-top', '13px');
            if (jQuery("#type_price" + '' + i + '').val()) {
                jQuery('#type_price' + '' + i + '').parent('.input.select').css('margin-top', '13px');
            }
            jQuery('#client_final' + '' + i + '').parent('.input.select').css('margin-top', '13px');
        });

    }

    function addPersonalizedRide() {

        var i = jQuery("#nb_ride").val();
        i++;
        var type = jQuery('#type').val();
        $('#dynamic_field').append('<tr id="row' + i + '"><td ></td></tr>');
        jQuery("#nb_ride").val(i);

        jQuery("#row" + '' + i + '').load('<?php echo $this->Html->url('/transportBills/addPersonalizedRide/')?>' + i + '/' + type, function () {
            $('.select-search').select2();

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
            $('.select-search-client-final').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/suppliers/getFinalSuppliersByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            supplierId: jQuery('#client').val()
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2

            });
            jQuery("#reference" + '' + i + '').css('margin-top', 8);
            jQuery("#ristourne" + '' + i + '').css('margin-top', 8);
            jQuery('#ride_category' + '' + i + '').parent('.input.select').css('margin-top', '13px');
            jQuery('#delivery_with_return' + '' + i + '').parent('.input.select').css('margin-top', '13px');
            if (jQuery("#type_price" + '' + i + '').val()) {
                jQuery('#type_price' + '' + i + '').parent('.input.select').css('margin-top', '13px');
            }
        });

    }

    function addProduct() {

        var i = jQuery("#nb_ride").val();
        i++;
        var type = jQuery('#type').val();
        $('#dynamic_field').append('<tr id="row' + i + '"><td ></td></tr>');
        jQuery("#nb_ride").val(i);
        jQuery("#row" + '' + i + '').load('<?php echo $this->Html->url('/transportBills/addProduct/')?>' + i + '/' + type, function () {

            $('.select3').select2();
            $('.select-search').select2({
                sorter: function (data) {
                    /* Sort data using lowercase comparison */
                    return data.sort(function (a, b) {
                        a = a.text.toLowerCase();
                        b = b.text.toLowerCase();
                        if (a > b) {
                            return 1;
                        } else if (a < b) {
                            return -1;
                        }
                        return 0;
                    });
                },
                allowDuplicates: true

            });


            $('.select-search-detail-ride').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/detailRides/getDetailRidesByKeyWord')?>",
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
            $('.select-search-client-final').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/suppliers/getFinalSuppliersByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            supplierId: jQuery('#client').val()
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2

            });

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
            jQuery("#reference" + '' + i + '').css('margin-top', 8);
            jQuery("#ristourne" + '' + i + '').css('margin-top', 8);
            jQuery('#ride_category' + '' + i + '').parent('.input.select').css('margin-top', '13px');
            jQuery('#delivery_with_return' + '' + i + '').parent('.input.select').css('margin-top', '13px');
            if (jQuery("#type_price" + '' + i + '').val()) {
                jQuery('#type_price' + '' + i + '').parent('.input.select').css('margin-top', '13px');
            }
            jQuery('#client_final' + '' + i + '').parent('.input.select').css('margin-top', '13px');

        });

        setTvaValue();

    }

    function removeRide(id) {
        $('#row' + id + '').remove();
        calculTotalPrice();
    }

    function simulate() {
        var typeRide = jQuery('#type_ride').val();
        var nbTrucks = jQuery('#nb_trucks').val();
        var departureDestination = jQuery('#departure_destination').val();
        var carType = jQuery('#car_type').val();
        var type = jQuery('#type').val();
        if (nbTrucks == '' || departureDestination == '' || carType == '') {
            if (nbTrucks == '') {
                alert("<?php echo __('Please enter the number of cars')?>");
            }
            if (departureDestination == '') {
                alert("<?php echo __('Please enter departure destination')?>");
            }
            if (carType == '') {
                alert("<?php echo __('Please enter car type')?>");
            }

        } else {
            if (typeRide == '2') {
                var departureId = jQuery('#departure_destination').val();
                var arrivalId = jQuery('#arrival_destination').val();
                var carTypeId = jQuery('#car_type').val();
                var clientFinalId = jQuery('#client_final').val();

                if (departureId == '') {
                    departureId = 0;
                }
                if (arrivalId == '') {
                    arrivalId = 0;
                }
                if (carTypeId == '') {
                    carTypeId = 0;
                }
                if (clientFinalId == '') {
                    clientFinalId = 0;
                }
                jQuery("#div-simulation").load('<?php echo $this->Html->url('/transportBills/getSimulation/')?>' + typeRide + '/' + departureId + '/' + arrivalId + '/' + carTypeId + '/' + clientFinalId + '/' + nbTrucks + '/' + type, function () {
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

                    $('.select-search-client-final').select2({
                        ajax: {
                            url: "<?php echo $this->Html->url('/suppliers/getFinalSuppliersByKeyWord')?>",
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    q: $.trim(params.term),
                                    supplierId: jQuery('#client').val()
                                };
                            },
                            processResults: function (data, page) {
                                return {results: data};
                            },
                            cache: true
                        },
                        minimumInputLength: 2

                    });

                    $(".select-search").select2({
                        sorter: function (data) {
                            /* Sort data using lowercase comparison */
                            return data.sort(function (a, b) {
                                a = a.text.toLowerCase();
                                b = b.text.toLowerCase();
                                if (a > b) {
                                    return 1;
                                } else if (a < b) {
                                    return -1;
                                }
                                return 0;
                            });
                        },
                        allowDuplicates: true

                    });

                    for (var i = 1; i <= nbTrucks; i++) {
                        var id = 'departure_destination' + i;

                        getPriceRide(id);
                    }
                });
            } else {
                departureId = 0;
                arrivalId = 0;
                carTypeId = 0;
                var clientFinalId = jQuery('#client_final').val();
                if (clientFinalId == '') {
                    clientFinalId = 0;
                }
                var detailRideId = jQuery('#detail_ride').val();
                jQuery("#div-simulation").load('<?php echo $this->Html->url('/transportBills/getSimulation/')?>' + typeRide + '/' + departureId + '/' + arrivalId + '/' + carTypeId + '/' + clientFinalId + '/' + nbTrucks + '/' + type + '/' + detailRideId, function () {
                    $('.select-search-detail-ride').select2({
                        ajax: {
                            url: "<?php echo $this->Html->url('/detailRides/getDetailRidesByKeyWord')?>",
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
                    $('.select-search-client-final').select2({
                        ajax: {
                            url: "<?php echo $this->Html->url('/suppliers/getFinalSuppliersByKeyWord')?>",
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    q: $.trim(params.term),
                                    supplierId: jQuery('#client').val()
                                };
                            },
                            processResults: function (data, page) {
                                return {results: data};
                            },
                            cache: true
                        },
                        minimumInputLength: 2

                    });
                    $(".select-search").select2({
                        sorter: function (data) {
                            /* Sort data using lowercase comparison */
                            return data.sort(function (a, b) {
                                a = a.text.toLowerCase();
                                b = b.text.toLowerCase();
                                if (a > b) {
                                    return 1;
                                } else if (a < b) {
                                    return -1;
                                }
                                return 0;
                            });
                        },
                        allowDuplicates: true

                    });


                    for (var i = 1; i <= nbTrucks; i++) {
                        var id = 'detail_ride' + i;

                        getPriceRide(id);
                    }
                });
            }
        }

    }

    function getSimulationByTypeRide(id) {

        jQuery("#div-trajet").load('<?php echo $this->Html->url('/transportBills/getSimulationByTypeRide/')?>' + id, function () {
            jQuery('#car_type').parent('.input.select').addClass('required');
            jQuery('#departure_destination').parent('.input.select').addClass('required');
            jQuery('#detail_ride').parent('.input.select').addClass('required');
            $('.select-search-detail-ride').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/detailRides/getDetailRidesByKeyWord')?>",
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

            $('.select-search-client-final').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/suppliers/getFinalSuppliersByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            supplierId: jQuery('#client').val()
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2

            });

            $(".select-search").select2({
                sorter: function (data) {
                    /* Sort data using lowercase comparison */
                    return data.sort(function (a, b) {
                        a = a.text.toLowerCase();
                        b = b.text.toLowerCase();
                        if (a > b) {
                            return 1;
                        } else if (a < b) {
                            return -1;
                        }
                        return 0;
                    });
                },
                allowDuplicates: true

            });


        });
    }

    function getInformationProduct(id) {
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(3, trId.length);
        if (jQuery("#type_ride" + '' + num + '').val()) {
            var typeRide = jQuery("#type_ride" + '' + num + '').val();
        } else {
            var typeRide = null;
        }
        if (jQuery("#type_pricing" + '' + num + '').val()) {
            var typePricing = jQuery("#type_pricing" + '' + num + '').val();
        } else {
            var typePricing = null;
        }

        var productId = jQuery("#product" + '' + num + '').val();
        var type = jQuery('#type').val();
        var deliveryWithReturn = jQuery("#delivery_with_return" + '' + num + '').val();

        jQuery("#type-ride-div" + '' + num + '').load('<?php echo $this->Html->url('/transportBills/getTypeRide/')?>' + num + '/' + productId + '/' + typeRide, function () {
            $('.select-search').select2();
            var typeRide = jQuery("#type_ride" + '' + num + '').val();
            jQuery("#div-product" + '' + num + '').load('<?php echo $this->Html->url('/transportBills/getInformationProduct/')?>' + num + '/' + type + '/' + typeRide + '/' + productId, function () {
                jQuery("#start_date" + '' + num + '').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});

                getDesignationProduct(num);

                if(type ==2){
                    var status = jQuery("#status" + '' + num + '').val();
                    jQuery("#status-div" + '' + num + '').load('<?php echo $this->Html->url('/transportBills/getStatusDiv/')?>' + productId + '/'+ num + '/' + status , function () {
                        jQuery(".select-search").select2();
                    });
                }

                if( jQuery("#product_type" + '' + num + '').val()!=1){
                    getPriceProduct(id);
                }
                $('.select3').select2({});
                $('.select-search-detail-ride').select2({
                    ajax: {
                        url: "<?php echo $this->Html->url('/detailRides/getDetailRidesByKeyWord')?>",
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
                $(".select-search").select2();
            });
            jQuery("#div-arrival" + '' + num + '').load('<?php echo $this->Html->url('/transportBills/getArrivalDestination/')?>' + num + '/' + typeRide + '/' + productId, function () {

                jQuery("#end_date" + '' + num + '').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});

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


        });
        jQuery("#delivery-return-div" + '' + num + '').load('<?php echo $this->Html->url('/transportBills/getDeliveryReturn/')?>' + num + '/' + productId + '/' + deliveryWithReturn, function () {
            $('.select-search').select2();
        });
        jQuery("#type-pricing-div" + '' + num + '').load('<?php echo $this->Html->url('/transportBills/getTypePricing/')?>' + num + '/' + productId, function () {
            $('.select-search').select2();
        });
        jQuery("#tonnage-div" + '' + num + '').load('<?php echo $this->Html->url('/transportBills/getInformationPricing/')?>' + num + '/' + typePricing + '/' + productId, function () {
            $('.select-search').select2();

        });
    }

    function getDesignationProduct(num) {
        var productId = jQuery("#product" + '' + num + '').val();

        if (jQuery("#type_ride" + '' + num + '').val()) {
            var typeRide = jQuery("#type_ride" + '' + num + '').val();
        } else {
            var typeRide = null;
        }
        if (jQuery("#detail_ride" + '' + num + '').val()) {
            var detailRideId = jQuery("#detail_ride" + '' + num + '').val();
        } else {
            var detailRideId = null;
        }

        if (jQuery("#departure_destination" + '' + num + '').val()) {
            var departureDestinationId = jQuery("#departure_destination" + '' + num + '').val();
        } else {
            var departureDestinationId = null;
        }

        if (jQuery("#arrival_destination" + '' + num + '').val()) {
            var arrivalDestinationId = jQuery("#arrival_destination" + '' + num + '').val();
        } else {
            var arrivalDestinationId = null;
        }

        if (jQuery("#car_type" + '' + num + '').val()) {
            var carTypeId = jQuery("#car_type" + '' + num + '').val();
        } else {
            var carTypeId = null;
        }
        jQuery("#div-designation" + '' + num + '').load('<?php echo $this->Html->url('/transportBills/getDesignationProduct/')?>' + num + '/' + productId + '/' + typeRide + '/' + detailRideId + '/' + departureDestinationId + '/' + arrivalDestinationId + '/' + carTypeId, function () {
            jQuery("#designation" + '' + num + '').css('margin-top', 8);
        });
    }

    function getInformationInvoice() {

        var invoiceId = jQuery("#invoice_id").val();

        jQuery("#div-simulation" ).load('<?php echo $this->Html->url('/transportBills/getInformationInvoice/')?>' + invoiceId , function () {
            $('.select-search').select2();

        });
        jQuery("#total-price" ).load('<?php echo $this->Html->url('/transportBills/getTotalPriceInvoice/')?>' + invoiceId , function () {
            $('.select-search').select2();

        });
    }

    function getCustomerInvoices(){

        var supplierId = jQuery("#client").val();

        jQuery("#div-invoice" ).load('<?php echo $this->Html->url('/transportBills/getCustomerInvoices/')?>' + supplierId , function () {
            $('.select-search').select2();
            jQuery('#invoice_id').parent('.input.select').addClass('required');
        });
    }

    function getInformationPricing(id) {
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(3, trId.length);
        if (jQuery("#type_pricing" + '' + num + '').val()) {
            var typePricing = jQuery("#type_pricing" + '' + num + '').val();
        } else {
            var typePricing = null;
        }
        var productId = jQuery("#product" + '' + num + '').val();
        jQuery("#tonnage-div" + '' + num + '').load('<?php echo $this->Html->url('/transportBills/getInformationPricing/')?>' + num + '/' + productId + '/' + typePricing, function () {
            $('.select-search').select2();
            getPriceRide(id);
        });
    }

    function editDescription(id) {
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(3, trId.length);
        var productId = jQuery("#product" + '' + num + '').val();
        var description = jQuery("#description" + '' + num + '').val();
        

        if (productId > 1) {
            var descriptionDiv = jQuery('#dialogModalDescription');
            descriptionDiv.dialog('option', 'title', jQuery(this).attr("title"));
            descriptionDiv.dialog('open');
            jQuery('#contentWrapDescription').load("<?php echo $this->Html->url('/transportBills/editDescription/')?>" + productId +'/'+ num +'/'+ description, function () {
                tinyMCE.init(
                    {"theme":"silver","plugins":"print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern","theme_advanced_buttons1":"save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect","theme_advanced_buttons2":"cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor","theme_advanced_buttons3":"tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen","theme_advanced_buttons4":"insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak","theme_advanced_toolbar_location":"top","theme_advanced_toolbar_align":"left","theme_advanced_statusbar_location":"bottom","theme_advanced_resizing":true,"theme_advanced_resize_horizontal":false,"convert_fonts_to_spans":true,"file_browser_callback":"ckfinder_for_tiny_mce","language":"fr_FR","mode":"exact","elements":"TransportBillDetailRidesDescription"}
                );

            });
        }


    }

    function addRowPenalty() {
        var item = jQuery('#nb_penalty').val();
        item++;
        jQuery('#table_penalty').append('<tr id="penalty' + item + '"><td></td></tr>');
        jQuery("#penalty" + '' + item + '').load('<?php echo $this->Html->url('/transportBills/addRowPenalty/')?>' + item, function () {
        });
        jQuery('#nb_penalty').val(item);
    }

    function removePenalty(id) {
        event.preventDefault();

        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var i = trId.substring(7, trId.length);

        if(jQuery('#penalty_id' + '' + i + '').val()){
            var penaltyId = jQuery('#penalty_id' + '' + i + '').val();

            var penaltyDeletedId = jQuery('#penalty_deleted_id').val();

            if (penaltyDeletedId != '') {
                penaltyDeletedId = penaltyDeletedId + ',' + penaltyId;
            } else {
                penaltyDeletedId = penaltyId;
            }
            jQuery('#penalty_deleted_id').val(penaltyDeletedId);
        }
        $('#penalty' + '' + i + '').remove();
        calculTotalPrice();
    }

    function calculateEndDate(id){
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var i = trId.substring(3, trId.length);
        var nbHours = parseInt(jQuery('#nb_hours' + '' + i + '').val());
        var s_arr = jQuery("#start_date" + '' + i + '').val().split(/\/|\s|:/);
        var myDate = new Date(s_arr[1] + "," + s_arr[0] + "," + s_arr[2] + "," + s_arr[3] + ":" + s_arr[4] + ":00");
        myDate.setHours(myDate.getHours() + nbHours);
        var day = myDate.getDate();
        day = parseInt(day);
        if (day >= 0 && day < 10) {

            day = '0' + day;
        }
        var month = myDate.getMonth();
        var year = myDate.getFullYear();
        var hour = myDate.getHours();
        var hour = parseInt(hour);
        if (hour >= 0 && hour <= 10) {
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
        jQuery("#end_date" + '' + i + '').val(end_date);
    }
    function calculateStartDate(id){
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var i = trId.substring(3, trId.length);
        var nbHours = parseInt(jQuery('#nb_hours' + '' + i + '').val());
        var s_arr = jQuery("#end_date" + '' + i + '').val().split(/\/|\s|:/);
        var myDate = new Date(s_arr[1] + "," + s_arr[0] + "," + s_arr[2] + "," + s_arr[3] + ":" + s_arr[4] + ":00");
        myDate.setHours(myDate.getHours() - nbHours);
        var day = myDate.getDate();
        day = parseInt(day);
        if (day >= 0 && day < 10) {

            day = '0' + day;
        }
        var month = myDate.getMonth();
        var year = myDate.getFullYear();
        var hour = myDate.getHours();
        var hour = parseInt(hour);
        if (hour >= 0 && hour <= 10) {
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
        var start_date = day + "/" + valMonth + "/" + year + " " + hour + ":" + min;
        jQuery("#start_date" + '' + i + '').val(start_date);

    }

    function setTvaValue()
    {
        let orderType = jQuery("#order_type").val();
        let nbRide = parseInt(jQuery('#nb_ride').val());
        let tvaInput = 'tva';
        let tvaInputId = '';
        if (orderType === '2'){
            for (let i = 1; i <= nbRide; i++ ){
                tvaInputId = tvaInput+''+i;
                jQuery('#'+tvaInputId).val("3");
                jQuery('#'+tvaInputId).trigger('change');
            }
        }else{
            for (let i = 1; i <= nbRide; i++ ){
                tvaInputId = tvaInput+''+i;
                jQuery('#'+tvaInputId).val("1");
                calculatePriceRide(tvaInputId);
            }
        }
    }

    function getThirdPartyContact(elem) {
        let supplierId = elem.val();
        let url = '<?= $this->Html->url('/transportBills/getThirdPartyNumberAjax/') ?>'
        jQuery.ajax({
            type: "POST",
            url: url,
            data: "supplierId=" + supplierId,
            dataType: "json",
            success: function (json) {
                jQuery('#client_contact').val(json['SupplierContact'][0]['tel']);
            }
        });
    }

</script>

<?php $this->end(); ?>

