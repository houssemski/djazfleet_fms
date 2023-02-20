
<style>
    .icheckbox_minimal {
        position: relative;
        margin: 0 auto;
        display: block;
    }

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
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->Html->css('select2/select2.min');
echo $this->Html->css('iCheck/flat/red');
echo $this->Html->css('iCheck/all');
$this->end();
echo "<div class='form-group'>" . $this->Form->input('type', array(
        'label' => '',
        'type' => 'hidden',
        'class' => 'form-control',
        'id' => 'type',
        'value' => $type
    )) . "</div>";
switch ($type) {
    case TransportBillTypesEnum::quote :

        ?><h4 class="page-title"> <?= __('Add quotation'); ?></h4>
        <?php break;
    case TransportBillTypesEnum::order :

        ?><h4 class="page-title"> <?= __("Add customer order"); ?></h4>
        <?php break;

    case TransportBillTypesEnum::sheet_ride :

        ?><h4 class="page-title"> <?= __("Add sheet ride"); ?></h4>

        <?php break;
    case TransportBillTypesEnum::pre_invoice :

        ?><h4 class="page-title"> <?= __("Add preinvoice"); ?></h4>

        <?php break;

    case TransportBillTypesEnum::invoice :

        ?><h4 class="page-title"> <?= __("Add invoice"); ?></h4>

        <?php break;

    case TransportBillTypesEnum::credit_note :

        ?><h4 class="page-title"> <?= __("Add sale credit note"); ?></h4>

        <?php break;
}
?>
<div id="dialogModalDescription">
    <!-- the external content is loaded inside this tag -->
    <div id="contentWrapDescription"></div>
</div>
<div class="box">
    <div class="edit form card-box p-b-0">
        <?php echo $this->Form->create('TransportBill'); ?>
        <div class="box-body" style="max-width: 100%;">

            <div class="nav-tabs-custom pdg_btm">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                    <?php
                    if ($profileId != ProfilesEnum::client) {
                        ?>
                        <li><a href="#tab_2" data-toggle="tab"><?= __('Advanced information') ?></a></li>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <?php if ($reference != '0') {
                            echo "<div class='form-group col-sm-4' >" . $this->Form->input('reference', array(
                                    'label' => __('Reference'),
                                    'class' => 'form-control',
                                    'value' => $reference,
                                    'readonly' => true,
                                    'placeholder' => __('Enter reference'),
                                )) . "</div>";
                        } else {
                            echo "<div class='form-group col-sm-4'>" . $this->Form->input('reference', array(
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
                        $current_date = date("Y-m-d");
                        echo "<div class='form-group col-sm-4 clear-none'>" . $this->Form->input('date', array(
                                'label' => '',
                                'placeholder' => 'dd/mm/yyyy',
                                'type' => 'text',
                                'value' => $this->Time->format($current_date, '%d/%m/%Y'),
                                'class' => 'form-control datemask',
                                'before' => '<label>' . __('Date') . '</label><div class="input-group date "><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'date',
                            )) . "</div>";
                        if (($type == TransportBillTypesEnum::order) && ($profileId == ProfilesEnum::client)) {
                            echo "<div class='form-group col-sm-3 form-clear'>" . $this->Form->input('supplier_id', array(
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
                                )) . "</div>";
                        } else {
                            echo "<div class=' col-sm-4'>";
                            if($type == TransportBillTypesEnum::credit_note){
                                echo "<div class='form-group col-sm-10 form-none'>" . $this->Form->input('supplier_id', array(
                                        'label' => __('Initial customer'),
                                        'empty' => '',
                                        'id' => 'client',
                                        'onchange' => 'javascript:getPriceAllRide();getCustomerInvoices();getThirdPartyContact(jQuery(this));',
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
                            ?>

                            <div class="btn-group quick-actions">
                                <div id="dialogModalClient">
                                    <!-- the external content is loaded inside this tag -->
                                    <div id="contentWrapClient"></div>
                                </div>
                                <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <?php echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add', true),
                                            array("controller" => "Suppliers", "action" => "addClient", 'client'),
                                            array(
                                                "class" => "btn overlayClient",
                                                'escape' => false,
                                                "title" => __("Add client")
                                            )); ?>
                                    </li>
                                    <li>
                                        <a href="#" class="btn overlayEditClient" title="Ajouter">
                                            <i class="fa fa-edit m-r-5"></i><?= __("Edit") ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <?php echo "</div>";
                            echo "<div id='div-various'>";
                            echo "</div>";

                         $options = array('1'=>__('Order with invoice'), '2'=>__('Order payment cash'));
                            if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                && $type !=TransportBillTypesEnum::quote && $type !=TransportBillTypesEnum::credit_note){
                                echo "<div  class='form-group col-sm-4'>" . $this->Form->input('order_type', array(
                                        'label' => __('Order type'),
                                        'empty' => '',
                                        'required'=>true,
                                        'id'=>'order_type',
                                        'options'=>$options,
                                        'class' => 'form-control select-search',
                                        'onchange' => 'javascript:setTvaValue();',
                                    )) . "</div>";
                            }else {
                                echo "<div  class='form-group col-sm-4'>" . $this->Form->input('order_type', array(
                                        'label' => __('Order type'),
                                        'empty' => '',
                                        'id'=>'order_type',
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
                        if($type == TransportBillTypesEnum::credit_note &&
                            Configure::read("utranx_trm") == '1'){
                            echo "<div  class='form-group col-sm-4 ' id ='div-invoice'>" . $this->Form->input('invoice_id', array(
                                    'label' => __('Invoices'),
                                    'empty' => '',
                                    'required'=>true,
                                    'id'=>'invoice_id',
                                    'class' => 'form-control select-search',
                                )) . "</div>";

                        }elseif ($type == TransportBillTypesEnum::credit_note){
                            echo "<div  class='form-group col-sm-4 ' id ='div-invoice'>" . $this->Form->input('invoice_id', array(
                                    'label' => __('Invoices'),
                                    'empty' => '',
                                    'required'=>true,
                                    'id'=>'invoice_id',
                                    'onchange' => 'javascript:getInformationInvoice(this.id);',
                                    'class' => 'form-control select-search',
                                )) . "</div>";
                        }
                        ?>
                        <?php
                        echo "<div style='clear:both; padding-top: 10px;'></div>"; ?>

                        <?php if ($type == TransportBillTypesEnum::order) { ?>
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #435966;;">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" href="#collapse1"
                                               style="font-weight: 700; color: #fff;"><?php echo __('Saisie en masse') ?> </a>

                                        </h4>
                                    </div>
                                         <div id="collapse1" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="input-radio">
                                                <?php switch ($typeRide) {
                                                    case 1:
                                                        ?>
                                                        <span class="label-radio"
                                                              style="font-weight: bold;"><?php echo __('Existing ride') ?></span>
                                                        <input id='1'
                                                               onclick='javascript:getSimulationByTypeRide(this.id);'
                                                               class="input-radio" type="radio"
                                                               name="data[Simulation][type_ride]"
                                                               value="1" <?php if ($typeRideUsedFirst == 1) { ?> checked='checked' <?php } ?>>
                                                        <?php break;
                                                    case 2:
                                                        ?>
                                                        <span class="label-radio"
                                                              style="font-weight: bold;"> <?php echo __('Personalized ride') ?></span>
                                                        <input id='2'
                                                               onclick='javascript:getSimulationByTypeRide(this.id);'
                                                               class="input-radio" type="radio"
                                                               name="data[Simulation][type_ride]"
                                                               value="2" <?php if ($typeRideUsedFirst == 2) { ?> checked='checked' <?php } ?>>
                                                        <?php break;
                                                    case 3:
                                                        ?>
                                                        <span class="label-radio"
                                                              style="font-weight: bold;"><?php echo __('Existing ride') ?></span>
                                                        <input id='1'
                                                               onclick='javascript:getSimulationByTypeRide(this.id);'
                                                               class="input-radio" type="radio"
                                                               name="data[Simulation][type_ride]"
                                                               value="1" <?php if ($typeRideUsedFirst == 1) { ?> checked='checked' <?php } ?>>
                                                        <span class="label-radio"
                                                              style="font-weight: bold;"> <?php echo __('Personalized ride') ?></span>
                                                        <input id='2'
                                                               onclick='javascript:getSimulationByTypeRide(this.id);'
                                                               class="input-radio" type="radio"
                                                               name="data[Simulation][type_ride]"
                                                               value="2" <?php if ($typeRideUsedFirst == 2) { ?> checked='checked' <?php } ?>>
                                                        <?php break;
                                                } ?>


                                            </div>

                                            <br/><br/><br/>
                                            <?php
                                            echo "<div id='div-trajet'>";
                                            if ($typeRideUsedFirst == 2) {
                                                echo "<div >" . $this->Form->input('Simulation.type_ride', array(
                                                        'class' => 'form-control',
                                                        'type' => 'hidden',
                                                        'value' => $typeRideUsedFirst,
                                                        'id' => 'type_ride'
                                                    )) . "</div>";
                                                echo "<div class='form-group col-sm-2 clear-none p-l-0'>" . $this->Form->input('Simulation.departure_destination_id',
                                                        array(
                                                            'label' => __('Departure city'),
                                                            'class' => 'form-control select-search-destination',
                                                            'id' => 'departure_destination'
                                                        )) . "</div>";
                                                echo "<div class='form-group col-sm-2 clear-none p-l-0'>" . $this->Form->input('Simulation.car_type_id',
                                                        array(
                                                            'label' => __('Type'),
                                                            'class' => 'form-control select-search',
                                                            'empty' => '',
                                                            'id' => 'car_type',
                                                        )) . "</div>";
                                                echo "<div class='form-group col-sm-2 clear-none p-l-0'>" . $this->Form->input('Simulation.supplier_final_id',
                                                        array(
                                                            'label' => __('Final customer'),
                                                            'empty' => '',
                                                            'id' => 'client_final',
                                                            'class' => 'form-control select-search-client-final',
                                                        )) . "</div>";
                                                echo "<div class='form-group col-sm-2 clear-none p-l-0'>" . $this->Form->input('Simulation.arrival_destination_id',
                                                        array(
                                                            'label' => __('Arrival city'),
                                                            'class' => 'form-control select-search-destination',
                                                            'empty' => '',
                                                            'id' => 'arrival_destination',
                                                        )) . "</div>";

                                            } else {
                                                echo "<div >" . $this->Form->input('Simulation.type_ride', array(
                                                        'class' => 'form-control',
                                                        'type' => 'hidden',
                                                        'value' => $typeRideUsedFirst,
                                                        'id' => 'type_ride'
                                                    )) . "</div>";
                                                echo "<div class='form-group col-sm-4 clear-none p-l-0'>" . $this->Form->input('Simulation.detail_ride_id',
                                                        array(
                                                            'label' => __('Ride'),
                                                            'class' => 'form-control select-search-detail-ride',
                                                            'id' => 'detail_ride'
                                                        )) . "</div>";


                                            }
                                            echo "</div>";
                                            echo "<div class='form-group col-sm-2 clear-none p-l-0'>" . $this->Form->input('Simulation.nb_trucks',
                                                    array(
                                                        'label' => __('Number of lines'),
                                                        'placeholder' => __('Enter quantity'),
                                                        'id' => 'nb_trucks',
                                                        'class' => 'form-control',
                                                    )) . "</div>";
                                            echo "<div class='form-group col-sm-2 clear-none p-l-50'>";
                                            echo $this->Html->link(__('Simulate'),
                                                'javascript: simulate()',
                                                array(
                                                    'escape' => false,
                                                    'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5 m-t-25 '
                                                ));
                                            echo "</div>"

                                            ?>


                                        </div>
                                    </div>
                                </div>


                            </div>

                        <?php } ?>

                        <div id='div-simulation'>
                            <table class="table table-bordered" id='dynamic_field'>
                                <?php echo "<div class='form-group'>" . $this->Form->input('nb_ride', array(
                                        'value' => 1,
                                        'type' => 'hidden',
                                        'id' => 'nb_ride',
                                    )) . "</div>";
                                ?>
                                <thead>
                                <tr>
                                    <?php if ($reference == '0') { ?>
                                        <th><?= __('Reference') ?></th>
                                    <?php } ?>

                                    <th><?= __('Product') ?></th>
                                    <th><?= __('Rides') ?></th>

                                    <th><?= __('Final customer') ?></th>
                                    <th><?= __('Date / Time') ?></th>
                                    <?php if ($profileId != ProfilesEnum::client ) { ?>
                                    <th><?= __('Designation') ?></th>
                                    <?php } ?>
                                    <?php if ($useRideCategory == TransportBillTypesEnum::order) { ?>
                                        <th><?= __('Ride category') ?></th>
                                    <?php } ?>
                                    <th><?= __('Simple delivery / return') ?></th>
                                    <?php if ($profileId == ProfilesEnum::client && $type == TransportBillTypesEnum::order) { ?>

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
                                    <?php } ?>

                                </tr>
                                </thead>
                                <tbody id='rides-tbody'>
                                <tr id="row1">
                                    <?php if ($reference == '0') { ?>
                                        <td> <?php
                                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.1.reference',
                                                    array(
                                                        'label' => '',
                                                        'class' => 'form-control ',
                                                        'id' => 'reference1',
                                                    )) . "</div>";

                                            ?></td>
                                    <?php } ?>

                                    <td style="min-width: 200px;"><?php
                                        echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.1.product_id',
                                                array(
                                                    'label' => '',
                                                    'class' => 'form-control select-search',
                                                    'onchange' => 'javascript:getInformationProduct(this.id);',
                                                    'id' => 'product1',
                                                    'value' => 1
                                                )) . "</div>";

                                        echo "<div id='type-ride-div1'>";
                                        if ($typeRide == 3) {
                                            $options = array(
                                                '1' => __('Existing ride'),
                                                '2' => __('Personalized ride')
                                            );
                                            echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.1.type_ride',
                                                    array(
                                                        'id' => 'type_ride1',
                                                        'options' => $options,
                                                        'label' => false,
                                                        'class' => 'form-control  select-search ',
                                                        'onchange' => 'javascript:getInformationProduct(this.id);',
                                                        'value' => $typeRideUsedFirst,
                                                    )) . "</div>";

                                        } else {
                                            echo "<div >" . $this->Form->input('TransportBillDetailRides.1.type_ride',
                                                    array(
                                                        'id' => 'type_ride1',
                                                        'type' => 'hidden',
                                                        'value' => $typeRideUsedFirst,
                                                    )) . "</div>";
                                        }
                                        echo "</div>";
                                        echo "<div id='type-pricing-div1'>";
                                        if ($typePricing == 3) {
                                            $options = array(
                                                '1' => __('Pricing by ride'),
                                                '2' => __('Pricing by distance')
                                            );
                                            echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.1.type_pricing',
                                                    array(
                                                        'id' => 'type_pricing1',
                                                        'options' => $options,
                                                        'label' => false,
                                                        'class' => 'form-control',
                                                        'onchange' => 'javascript:getInformationPricing(this.id);',
                                                        'empty' => '',
                                                    )) . "</div>";

                                        } else {
                                            echo "<div >" . $this->Form->input('TransportBillDetailRides.1.type_pricing',
                                                    array(
                                                        'id' => 'type_pricing1',
                                                        'type' => 'hidden',
                                                        'value' => $typePricing,
                                                    )) . "</div>";
                                        }
                                        echo "</div>";
                                        ?>
                                    </td>
                                    <?php
                                    if ($profileId == ProfilesEnum::client
                                        && $type == TransportBillTypesEnum::order
                                    ) {

                                        if ($typeRideUsedFirst == 1) {
                                            ?>
                                            <td class="col-sm-3">
                                                <?php
                                                echo "<div id='div-product1'>";
                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.1.detail_ride_id',
                                                        array(
                                                            'label' => '',
                                                            'class' => 'form-control select-search-detail-ride',
                                                            'empty' => '',
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'id' => 'detail_ride1',
                                                        )) . "</div>";
                                                echo "</div>";
                                                ?>
                                            </td>

                                        <?php } else { ?>

                                            <td class="col-sm-3"><?php
                                                echo "<div id='div-product1'>";
                                                echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.1.departure_destination_id',
                                                        array(
                                                            'label' => '',
                                                            'empty' => __('Departure city'),
                                                            'class' => 'form-control select-search-destination ',
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'id' => 'departure_destination1',
                                                        )) . "</div>";
                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.1.car_type_id',
                                                        array(
                                                            'empty' => __('Type'),
                                                            'class' => 'form-control select-search',
                                                            'label' => '',
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'id' => 'car_type1',
                                                        )) . "</div>";
                                                echo "</div>";
                                                ?>
                                            </td>
                                        <?php } ?>

                                        <?php
                                    } else {

                                        if ($typeRideUsedFirst == 1) {
                                            ?>
                                            <td style="min-width: 200px;">
                                                <?php
                                                echo "<div id='div-product1'>";
                                                echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.1.detail_ride_id',
                                                        array(
                                                            'label' => '',
                                                            'class' => 'form-control select-search-detail-ride',
                                                            'empty' => '',
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'id' => 'detail_ride1',
                                                        )) . "</div>";
                                                echo "</div>";
                                                ?></td>

                                        <?php } else { ?>

                                            <td style="min-width: 200px;">
                                                <?php
                                                echo "<div id='div-product1'>";
                                                echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.1.departure_destination_id',
                                                        array(
                                                            'label' => '',
                                                            'empty' => __('Departure city'),
                                                            'class' => 'form-control select-search-destination',
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'id' => 'departure_destination1',
                                                        )) . "</div>";


                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.1.car_type_id',
                                                        array(
                                                            'empty' => __('Type'),
                                                            'class' => 'form-control select-search',
                                                            'label' => '',
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'id' => 'car_type1',
                                                        )) . "</div>";
                                                echo "</div>";
                                                ?></td>


                                        <?php } ?>


                                    <?php } ?>
                                    <?php if ($profileId == ProfilesEnum::client
                                        && $type == TransportBillTypesEnum::order
                                    ) {
                                        if ($typeRideUsedFirst == 1) {
                                            ?>
                                            <td class="col-sm-3">
                                                <?php
                                                echo "<div class='form-group' id='supplier_final_div1'>" . $this->Form->input('TransportBillDetailRides.1.supplier_final_id',
                                                        array(
                                                            'empty' => __('Final customer'),
                                                            'label' => '',
                                                            'id' => 'client_final1',
                                                            'class' => 'form-control select-search-client-final ',
                                                        )) . "</div>";
                                                ?>
                                            </td>
                                        <?php } else { ?>

                                            <td class="col-sm-3">
                                                <?php

                                                if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                                    &&  $type !=TransportBillTypesEnum::credit_note
                                                ){
                                                    echo "<div class='form-group' id='div-arrival1'>" . $this->Form->input('TransportBillDetailRides.1.arrival_destination_id',
                                                            array(
                                                                'empty' => __('Arrival city'),
                                                                'class' => 'form-control select-search-destination',
                                                                'label' => '',
                                                                'required'=>true,
                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                'id' => 'arrival_destination1',
                                                            )) . "</div>";
                                                }else {
                                                    echo "<div class='form-group' id='div-arrival1'>" . $this->Form->input('TransportBillDetailRides.1.arrival_destination_id',
                                                            array(
                                                                'empty' => __('Arrival city'),
                                                                'class' => 'form-control select-search-destination',
                                                                'label' => '',
                                                                'required'=>true,
                                                                'onchange' => 'javascript:getPriceRide(this.id);',
                                                                'id' => 'arrival_destination1',
                                                            )) . "</div>";
                                                }


                                                echo "<div class='form-group' id='supplier_final_div1'>" . $this->Form->input('TransportBillDetailRides.1.supplier_final_id',
                                                        array(
                                                            'empty' => __('Final customer'),
                                                            'label' => '',
                                                            'id' => 'client_final1',
                                                            'class' => 'form-control select-search-client-final ',
                                                        )) . "</div>";
                                                ?>
                                            </td>

                                        <?php } ?>

                                        <?php
                                    } else {
                                        if ($typeRideUsedFirst == 1) {
                                            ?>
                                            <td style="min-width: 200px;">
                                                <?php
                                                echo "<div class='form-group form-tab' id='supplier_final_div1'>" . $this->Form->input('TransportBillDetailRides.1.supplier_final_id',
                                                        array(
                                                            'empty' => __('Final customer'),
                                                            'label' => '',
                                                            'id' => 'client_final1',
                                                            'class' => 'form-control select-search-client-final ',
                                                        )) . "</div>";
                                                ?>
                                            </td>

                                        <?php } else { ?>
                                            <td style="min-width: 200px;">
                                                <?php

                                            if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                                 && $type !=TransportBillTypesEnum::credit_note
                                            ){
                                                echo "<div class='form-group form-tab' id='div-arrival1'>" . $this->Form->input('TransportBillDetailRides.1.arrival_destination_id',
                                                        array(
                                                            'empty' => __('Arrival city'),
                                                            'class' => 'form-control select-search-destination',
                                                            'label' => '',
                                                            'required'=>true,
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'id' => 'arrival_destination1',
                                                        )) . "</div>";
                                            }else {
                                                echo "<div class='form-group form-tab' id='div-arrival1'>" . $this->Form->input('TransportBillDetailRides.1.arrival_destination_id',
                                                        array(
                                                            'empty' => __('Arrival city'),
                                                            'class' => 'form-control select-search-destination',
                                                            'label' => '',
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'id' => 'arrival_destination1',
                                                        )) . "</div>";
                                            }


                                                echo "<div class='form-group form-tab' id='supplier_final_div1'>" . $this->Form->input('TransportBillDetailRides.1.supplier_final_id',
                                                        array(
                                                            'empty' => __('Final customer'),
                                                            'label' => '',
                                                            'id' => 'client_final1',
                                                            'class' => 'form-control select-search-client-final ',
                                                        )) . "</div>";
                                                ?>
                                            </td>

                                        <?php } ?>

                                        <?php
                                    } ?>
                                    <td style="min-width: 200px;">
                                        <?php
                                        echo  $this->Form->input('gestion_programmation_sous_traitance',
                                                array(
                                                    'type' => 'hidden',
                                                    'id' => 'gestion_programmation_sous_traitance',
                                                    'value'=>Configure::read("gestion_programmation_sous_traitance")
                                                )) ;


                                        if(Configure::read("gestion_programmation_sous_traitance") == '1'
                                            && $type !=TransportBillTypesEnum::quote && $type !=TransportBillTypesEnum::credit_note
                                        ){
                                            echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.1.programming_date', array(
                                                    'label' => '',
                                                    'placeholder' => __('Programming date'),
                                                    'required'=>true,
                                                    'type' => 'text',
                                                    'class' => 'form-control datemask',
                                                    'id' => 'programming_date1',
                                                    'before' => '<div class="input-group date "><label for="programmingDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                                    'after' => '</div>',
                                                )) . "</div>";

                                            echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.1.charging_time', array(
                                                    'label' => '',
                                                    'placeholder' => __('Charging hour'),
                                                    'type' => 'text',
                                                    'required'=>true,
                                                    'class' => 'form-control ',
                                                    'id' => 'charging_time1',
                                                    'before' => '<div class="input-group "><label for="chargingTime"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                                    'after' => '</div>',
                                                )) . "</div>";

                                            echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.1.unloading_date', array(
                                                    'label' => '',
                                                    'placeholder' => __('Unloading date'),
                                                    'type' => 'text',
                                                    'required'=>true,
                                                    'class' => 'form-control ',
                                                    'id' => 'unloading_date1',
                                                    'before' => '<div class="input-group "><label for="unloadingDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                                    'after' => '</div>',
                                                )) . "</div>";
                                        }else {
                                            echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.1.programming_date', array(
                                                    'label' => '',
                                                    'placeholder' => __('Programming date'),
                                                    'placeholder' => 'dd/mm/yyyy',
                                                    'type' => 'text',
                                                    'class' => 'form-control datemask',
                                                    'id' => 'programming_date1',
                                                    'before' => '<div class="input-group date "><label for="programmingDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                                    'after' => '</div>',
                                                )) . "</div>";

                                            echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.1.charging_time', array(
                                                    'label' => '',
                                                    'placeholder' => __('Charging hour'),
                                                    'type' => 'text',
                                                    'class' => 'form-control ',
                                                    'id' => 'charging_time1',
                                                    'before' => '<div class="input-group "><label for="chargingTime"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                                    'after' => '</div>',
                                                )) . "</div>";

                                            echo "<div class='form-group form-tab'>" . $this->Form->input('TransportBillDetailRides.1.unloading_date', array(
                                                    'label' => '',
                                                    'placeholder' => __('Unloading date'),
                                                    'type' => 'text',
                                                    'class' => 'form-control ',
                                                    'id' => 'unloading_date1',
                                                    'before' => '<div class="input-group "><label for="unloadingDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i></div>',
                                                    'after' => '</div>',
                                                )) . "</div>";
                                        }
                                        ?>
                                    </td>
                                    <?php if ($profileId != ProfilesEnum::client ) { ?>
                                    <td style="min-width: 200px;">
                                        <?php
                                        echo "<div id ='div-designation1'>" . $this->Form->input('TransportBillDetailRides.1.designation',
                                                array(
                                                    'label' => '',
                                                    'empty' => '',
                                                    'id' => 'designation1',
                                                    'class' => 'form-control',
                                                )) . "</div>";
                                        ?>
                                    </td>
                                    <?php } ?>
                                    <?php if ($useRideCategory == 2) { ?>
                                        <td>
                                            <?php
                                            echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.1.ride_category_id',
                                                    array(
                                                        'label' => '',
                                                        'class' => 'form-control select-search ',
                                                        'empty' => '',
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'id' => 'ride_category1',
                                                    )) . "</div>";
                                            ?>
                                        </td>
                                    <?php } ?>
                                    <td>
                                        <?php
                                        echo "<div id='delivery-return-div1'>";
                                        $options = array('1' => __('Simple delivery'), '2' => __('Simple return'), '3' => __('Delivery / Return'));
                                        echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.1.delivery_with_return',
                                                array(
                                                    'label' => '',
                                                    'id' => 'delivery_with_return1',
                                                    'onchange' => 'javascript:getPriceRide(this.id);',
                                                    'value' => 1,
                                                    'options' => $options,
                                                    'class' => 'form-control select-search ',
                                                )) . "</div>";
                                        echo "</div>";

                                        echo "<div id='tonnage-div1'>";
                                        if ($typePricing == 2) {
                                            echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.1.tonnage_id',
                                                    array(
                                                        'label' => '',
                                                        'id' => 'tonnage1',
                                                        'onchange' => 'javascript:getPriceRide(this.id);',
                                                        'class' => 'form-control select-search ',
                                                        'empty' => __('Tonnage')
                                                    )) . "</div>";
                                        }
                                        echo "</div>";
                                        ?>
                                    </td>

                                    <?php if ($profileId == ProfilesEnum::client
                                        && $type == TransportBillTypesEnum::order
                                    ) {
                                        ?>

                                        <td><?php
                                            if ($nbTrucksModifiable == 2) {
                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.1.nb_trucks',
                                                        array(
                                                            'label' => '',
                                                            'placeholder' => __('Enter quantity'),
                                                            'onchange' => 'javascript: calculatePriceRide(this.id);',
                                                            'id' => 'nb_trucks1',
                                                            'readonly' => true,
                                                            'value' => $defaultNbTrucks,
                                                            'class' => 'form-control',
                                                        )) . "</div>";
                                            } else {
                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.1.nb_trucks',
                                                        array(
                                                            'label' => '',
                                                            'placeholder' => __('Enter quantity'),
                                                            'onchange' => 'javascript: calculatePriceRide(this.id);',
                                                            'id' => 'nb_trucks1',
                                                            'class' => 'form-control',
                                                        )) . "</div>";
                                            }
                                            echo "<div id='div_unit_price1'>" . $this->Form->input('TransportBillDetailRides.1.unit_price',
                                                    array(
                                                        'label' => '',
                                                        'id' => 'unit_price1',
                                                        'type' => 'hidden',
                                                        'onchange' => 'javascript:calculatePriceRide(this.id);',
                                                        'class' => 'form-control',
                                                    )) . "</div>";

                                            echo "<div >" . $this->Form->input('TransportBillDetailRides.1.ristourne_%',
                                                    array(
                                                        'label' => '',
                                                        'id' => 'ristourne1',
                                                        'type' => 'hidden',
                                                        'onchange' => 'javascript:calculRistourneVal(this.id);',
                                                        'class' => 'form-control',
                                                    )) . "</div>";

                                            echo "<div >" . $this->Form->input('TransportBillDetailRides.1.ristourne_val',
                                                    array(
                                                        'label' => '',
                                                        'type' => 'hidden',
                                                        'id' => 'ristourne_val1',
                                                        'onchange' => 'javascript:calculRistourne(this.id);',
                                                        'class' => 'form-control',
                                                    )) . "</div>";


                                            echo "<div >" . $this->Form->input('TransportBillDetailRides.1.price_ht',
                                                    array(
                                                        'label' => '',
                                                        'type' => 'hidden',
                                                        'id' => 'price_ht1',
                                                        'readonly' => true,
                                                        'class' => 'form-control',
                                                    )) . "</div>";


                                            echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.1.tva_id',
                                                    array(
                                                        'label' => '',
                                                        'type' => 'hidden',
                                                        'options' => $tvas,
                                                        'value' => 1,
                                                        'id' => 'tva1',
                                                        'onchange' => 'javascript:calculatePriceRide(this.id);',
                                                        'class' => 'form-control ',
                                                    )) . "</div>";


                                            echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.1.price_ttc',
                                                    array(
                                                        'label' => '',
                                                        'readonly' => true,
                                                        'id' => 'price_ttc1',
                                                        'type' => 'hidden',
                                                        'class' => 'form-control',
                                                    )) . "</div>";



                                            echo "<div >" . $this->Form->input('TransportBillDetailRides.1.type', array(
                                                    'id' => 'type1',
                                                    'type' => 'hidden',
                                                    'value' => $type,
                                                )) . "</div>";


                                            switch ($type) {
                                                case TransportBillTypesEnum::quote :
                                                    $statusId = 0;
                                                    break;
                                                case TransportBillTypesEnum::order :
                                                    $statusId = 1;
                                                    break;

                                                case TransportBillTypesEnum::pre_invoice :
                                                    $statusId = 4;
                                                    break;

                                                case TransportBillTypesEnum::invoice :
                                                    $statusId = 7;
                                                    break;

                                                case TransportBillTypesEnum::credit_note :
                                                    $statusId = 10;
                                                    break;
                                            }

                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo "<div  >" . $this->Form->input('TransportBillDetailRides.1.status_id',
                                                array(
                                                'id' => 'status1',
                                                'type' => 'hidden',
                                                'value' => $statusId,
                                                )) . "</div>";
                                            ?>
                                            <button name="remove" id="1" onclick="removeRide('1');"
                                                    class="btn btn-danger btn_remove" style="margin-top: 10px;">X
                                            </button>
                                        </td>
                                    <?php } else { ?>
                                        <?php if ($paramPriceNight == 1) { ?>
                                            <td>
                                                <?php $options = array('1' => __('Day'), '2' => __('Night'));
                                                echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.1.type_price',
                                                        array(
                                                            'label' => '',

                                                            'id' => 'type_price1',
                                                            'onchange' => 'javascript:getPriceRide(this.id);',
                                                            'value' => 1,
                                                            'options' => $options,
                                                            'class' => 'form-control select-search ',
                                                        )) . "</div>"; ?>
                                            </td>
                                        <?php } ?>
                                        <td style="min-width: 130px;">
                                            <?php


                                            echo "<div id='div_unit_price1'>" . $this->Form->input('TransportBillDetailRides.1.unit_price',
                                                    array(
                                                        'label' => '',
                                                        'id' => 'unit_price1',
                                                        'onchange' => 'javascript:calculatePriceRide(this.id);',
                                                        'class' => 'form-control',
                                                    )) . "</div>";


                                            $pricePmp = array('0' => 'PMP');
                                            if (!empty($priceCategories)) {
                                                $options = array_merge($pricePmp, $priceCategories);
                                            } else {
                                                $options = $priceCategories;
                                            }

                                            echo "<div class='form-group' >" . $this->Form->input('TransportBillDetailRides.1.price_category_id',
                                                    array(
                                                        'label' => '',
                                                        'class' => 'form-control select3',
                                                        'id' => 'price_category1',
                                                        'onchange' => 'javascript:getPriceProduct(this.id);',
                                                        'options' => $options,
                                                        'empty' => ''
                                                    )) . "</div>";
                                            ?>

                                        </td>
                                        <td style="min-width: 100px;">
                                            <?php


                                            echo "<div >" . $this->Form->input('TransportBillDetailRides.1.ristourne_%',
                                                    array(
                                                        'label' => '',
                                                        'id' => 'ristourne1',
                                                        'onchange' => 'javascript:calculRistourneVal(this.id);',
                                                        'class' => 'form-control',
                                                    )) . "</div>";

                                            echo "<div >" . $this->Form->input('TransportBillDetailRides.1.ristourne_val',
                                                    array(
                                                        'label' => '',
                                                        //'type' => 'hidden',
                                                        'id' => 'ristourne_val1',
                                                        'onchange' => 'javascript:calculRistourne(this.id);',
                                                        'class' => 'form-control',
                                                    )) . "</div>";


                                            ?>
                                        </td>

                                        <td style="min-width: 130px;"><?php
                                            if ($nbTrucksModifiable == 2) {
                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.1.nb_trucks',
                                                        array(
                                                            'label' => '',
                                                            'placeholder' => __('Enter quantity'),
                                                            'onchange' => 'javascript: calculatePriceRide(this.id);',
                                                            'id' => 'nb_trucks1',
                                                            'readonly' => true,
                                                            'value' => $defaultNbTrucks,
                                                            'class' => 'form-control',
                                                        )) . "</div>";
                                            } else {
                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.1.nb_trucks',
                                                        array(
                                                            'label' => '',
                                                            'placeholder' => __('Enter quantity'),
                                                            'onchange' => 'javascript: calculatePriceRide(this.id);',
                                                            'id' => 'nb_trucks1',
                                                            'class' => 'form-control',
                                                        )) . "</div>";
                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.1.marchandise_unit_id',
                                                        array(
                                                            'label' => '',
                                                            'empty' => true,
                                                            'placeholder' => __('Enter unit'),
                                                            'id' => 'nb_trucks_units_1',
                                                            'options' => $marchandiseUnits,
                                                            'class' => 'form-control',
                                                        )) . "</div>";
                                            }

                                            ?></td>


                                        <td style="min-width: 130px;">
                                            <?php
                                            echo "<div >" . $this->Form->input('TransportBillDetailRides.1.price_ht',
                                                    array(
                                                        'label' => '',
                                                        'id' => 'price_ht1',
                                                        'readonly' => true,
                                                        'class' => 'form-control',
                                                    )) . "</div>"; ?>
                                        </td>
                                        <td style="min-width: 50px;">
                                            <?php


                                            echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.1.tva_id',
                                                    array(
                                                        'label' => '',
                                                        'options' => $tvas,
                                                        'id' => 'tva1',
                                                        'value' => 1,
                                                        'onchange' => 'javascript:calculatePriceRide(this.id);',
                                                        'class' => 'form-control ',
                                                    )) . "</div>"; ?>
                                        </td>
                                        <td style="min-width: 130px;">
                                            <?php

                                            echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.1.price_ttc',
                                                    array(
                                                        'label' => '',
                                                        'readonly' => true,
                                                        'id' => 'price_ttc1',
                                                        'class' => 'form-control',
                                                    )) . "</div>";


                                            echo "<div >" . $this->Form->input('TransportBillDetailRides.1.type', array(
                                                    'id' => 'type1',
                                                    'type' => 'hidden',
                                                    'value' => $type,
                                                )) . "</div>";


                                            switch ($type) {
                                                case TransportBillTypesEnum::quote :
                                                    $statusId = 0;
                                                    break;
                                                case TransportBillTypesEnum::order :
                                                    $statusId = 1;
                                                    break;

                                                case TransportBillTypesEnum::pre_invoice :
                                                    $statusId = 4;
                                                    break;

                                                case TransportBillTypesEnum::invoice :
                                                    $statusId = 7;
                                                    break;

                                                case TransportBillTypesEnum::credit_note :
                                                    $statusId = 10;
                                                    break;
                                            }


                                            ?>
                                        </td>
                                        <td style="min-width: 150px;">
                                            <?php
                                            echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.1.observation_order',
                                                array(
                                                'label' => '',
                                                'id' => 'observation1',
                                                'class' => 'form-control',
                                                )) . "</div>";
                                            ?>
                                        </td>

                                        <td>

                                            <?php
                                            echo "<div id='status-div1' >";

                                            if($relationWithPark == 1) {
                                                echo "<div >" . $this->Form->input('TransportBillDetailRides.1.status_id',
                                                        array(
                                                            'id' => 'status1',
                                                            'type' => 'hidden',
                                                            'value' => $statusId,
                                                        )) . "</div>";

                                                switch ($statusId) {
                                                    /*
                                                    1: commandes en cours
                                                    2: commandes partiellement valid�es
                                                    3: commandes valid�es
                                                    4: commandes pr�factur�es.
                                                    7: commandes factur�es.
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
                                            } else {

                                                $statuses = array('1'=>__('Not validated'),'3'=>__('Validated'));
                                                echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.1.status_id',
                                                        array(
                                                            'options'=>$statuses,
                                                            'class' => 'form-control select-search',
                                                            'id' => 'status1',
                                                            'value' => $statusId,
                                                        )) . "</div>";

                                            }


                                            echo "</div>";

                                            echo "<div class='hidden' id ='description-div1'>" . $this->Form->input('TransportBillDetailRides.1.description',
                                                    array(
                                                        'id' => 'description1',
                                                    )) . "</div>";
                                            ?>&nbsp;



                                            <div class="btn-group quick-actions">

                                                <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="#" class="btn editDescription"  id="editDescription1" onclick="editDescription(this.id);" title="Edit description">
                                                            <i class="fa fa-edit m-r-5"></i><?= __("Edit description") ?>
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="#" class="btn" title="Delete" id="1" onclick="removeRide('1');">
                                                            <i class="fa fa-trash-o m-r-5"></i><?= __("Delete") ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>


                                        </td>
                                    <?php } ?>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php if (!isset($this->params['pass']['1'])) {?>
                        <button style="float: right;margin-left: 10px;" type='button' name='add' id='add'
                                class='btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5'
                                onclick='addProduct()'><?= __('Add Product') ?></button>

                        <?php } ?>
                        <div style='clear:both; padding-bottom: 20px;'></div>
                        <?php if (($type == TransportBillTypesEnum::invoice || $type == TransportBillTypesEnum::order )
                            && ($profileId != ProfilesEnum::client)) {
                            echo "<div id='interval2' style='margin-left: 20px;'>";
                            echo '<div class="lbl1" style="display: inline-block; width: 150px;">' . __("Penalty");
                            echo "</div>";
                            $options = array('1' => __('Yes'), '2' => __('No'));
                            $attributes = array('legend' => false , 'value' => 2);
                            echo $this->Form->radio('with_penalty', $options, $attributes) . "</div>";?>


                            <div style='clear:both; padding-bottom: 20px;'></div>
                            <div id='penalty-div'></div>
                            <?php   $options = array('1' => __('A terme'), '2' => __('Chèque'), '3' => __('Chèque-banque'), '4' => __('Virement'), '5' => __('Avoir'), '6' => __('Espèce'), '7' => __('Traite'), '8' => __('Fictif'));

                            echo "<div  class='  col-sm-4'>" . $this->Form->input('payment_method', array(
                                    'label' => __('Payment method'),
                                    'class' => 'form-control select-search ',
                                    'options' => $options,
                                    'id' => 'payment_method',
                                    'empty'=>'',
                                    'onchange' => 'javascript : calculateStampValue();'
                                )) . "</div>";

                            echo "<div  class='  col-sm-4'>" . $this->Form->input('stamp', array(
                                    'label' => __('Stamp'),
                                    'class' => 'form-control',
                                    'readonly' => true,
                                    'id' => 'stamp',
                                )) . "</div>";
                        } ?>
                        <div style='clear:both;'></div>

                        <div id="total-price">
                            <?php if (($type == TransportBillTypesEnum::order)
                                && ($profileId == ProfilesEnum::client)
                            ) {
                                echo "<div  class='  col-sm-4'>" . $this->Form->input('total_ht', array(
                                        'label' => __('Total HT'),
                                        'readonly' => true,
                                        'class' => 'form-control',
                                        'type' => 'hidden',
                                        'id' => 'total_ht',

                                    )) . "</div>";

                                echo "<div  class='  col-sm-4'>" . $this->Form->input('total_tva', array(
                                        'label' => __('Total TVA'),
                                        'readonly' => true,
                                        'class' => 'form-control',
                                        'type' => 'hidden',
                                        'id' => 'total_tva',
                                    )) . "</div>";

                                echo "<div  class='col-sm-4'>" . $this->Form->input('total_ttc', array(
                                        'label' => __('Total TTC'),
                                        'readonly' => true,
                                        'class' => 'form-control',
                                        'type' => 'hidden',
                                        'id' => 'total_ttc',
                                    )) . "</div>";

                            } else {
                                echo "<div  class='m-t-20  col-sm-4'>" . $this->Form->input('total_ht', array(
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
                                        'type' => 'text'
                                    )) . "</div>";

                                echo "<div  class='m-t-20  col-sm-4'>" . $this->Form->input('ristourne_percentage', array(
                                        'label' => __('Ristourne') . ' ' . ('%'),
                                        'class' => 'form-control',
                                        'id' => 'ristourne_percentage',
                                        'onchange' => 'javascript : calculateGlobalRistourneVal();',
                                        'type' => 'text'
                                    )) . "</div>";
                                echo "<div  class='form-group m-t-20  col-sm-4'>" . $this->Form->input('total_tva', array(
                                        'label' => __('Total TVA'),
                                        'readonly' => true,
                                        'class' => 'form-control',
                                        'id' => 'total_tva',
                                    )) . "</div>";

                                echo "<div  class='m-t-20 col-sm-4'>" . $this->Form->input('total_ttc', array(
                                        'label' => __('Total TTC'),
                                        'readonly' => true,
                                        'class' => 'form-control',
                                        'id' => 'total_ttc',
                                    )) . "</div>";
                            } ?>
                        </div>
                            <div style='clear:both;'></div>
                            <div style='clear:both; padding-bottom: 20px;'></div>
                            <?php echo "<div  class='form-group'>" . $this->Form->input('note', array(
                                    'label' => __('Note'),

                                    'class' => 'form-control',


                                )) . "</div>";
                            ?>




                    </div>
                    <?php
                    if ($profileId != ProfilesEnum::client) { ?>
                        <div class="tab-pane " id="tab_2">

                            <?php
                            if ($profileId != ProfilesEnum::client) {
                                echo "<div class='form-group col-sm-4 clear-none' id='categories'>" . $this->Form->input('transport_bill_category_id', array(
                                        'label' => __('Category'),
                                        'empty' => '',
                                        'id' => 'category',
                                        'class' => 'form-control select-search ',
                                    )) . "</div>";
                                ?>
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

                                <?php echo "<div class='form-group col-sm-4 clear-none' id='customers' >" . $this->Form->input('customer_id', array(
                                        'label' => __('Commercial'),
                                        'empty' => '',
                                        'id' => 'commercial',
                                        'class' => 'form-control select-search-customer ',
                                    )) . "</div>";

                                ?>

                                <!-- overlayed element -->
                                <div id="dialogModalCustomer">
                                    <!-- the external content is loaded inside this tag -->
                                    <div id="contentWrapCustomer"></div>
                                </div>
                                <div class="popupactions">

                                    <?php echo $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Add', true),
                                        array("controller" => "transportBills", "action" => "addCustomer"),
                                        array("class" => "btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 overlayCustomer", 'escape' => false, "title" => __("Add Customer"))); ?>

                                </div>
                                <div style="clear:both"></div>
                            <?php } ?>

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

<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div><!-- /.modal -->
<?php
if($type == TransportBillTypesEnum::order){
    echo  $this->element('Script/TransportBills/order-type-script');
}
 ?>
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
                    $('#TransportBillAddForm').submit();
                }



        });

        jQuery("#date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
        jQuery("#end_date").inputmask("date", {"placeholder": "dd/mm/yyyy"});
        jQuery("#programming_date1").inputmask("date", {"placeholder": "dd/mm/yyyy"});
        jQuery("#charging_time1").inputmask("h:s", {"placeholder": "hh:mm"});
        jQuery("#unloading_date1").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
        jQuery('#ride_category1').parent('.input.select').css('margin-top', '13px');
        jQuery('#delivery_with_return1').parent('.input.select').css('margin-top', '13px');
        jQuery('#reference').parent('.input').addClass('required');
        if (jQuery('#type_price1').val()) {
            jQuery('#type_price1').parent('.input.select').css('margin-top', '13px');
        }

        if(jQuery('#gestion_programmation_sous_traitance').val()=='1'
            && (jQuery('#type').val() !=1 )
        ){
            jQuery('#programming_date1').parent().parent().attr('class', 'input text required');
            jQuery('#charging_time1').parent().parent().attr('class', 'input text required');
            jQuery('#unloading_date1').parent().parent().attr('class', 'input text required');
            jQuery('#arrival_destination1').parent('.input.select').addClass('required');
            jQuery('#order_type').parent('.input.select').addClass('required');

        }
        if(jQuery('#gestion_programmation_sous_traitance').val()=='1'
            && jQuery('#type').val() == 2
        ){
            jQuery('#client_contact').parent('.input').addClass('required');
        }
        if(jQuery('#type').val() == 10){
            jQuery('#credit_note_type').parent('.input.select').addClass('required');
            jQuery('#invoice_id').parent('.input.select').addClass('required');
            jQuery('#order_type').parent('.input.select').removeClass('required');
        }

        if (jQuery('#commercial').val()) {
            var customerId = jQuery('#commercial').val();
        } else {
            var customerId = '';
        }

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




        /* $('.select-search-customer').select2({
             ajax: {
                 url: " echo $this->Html->url('/customers/getCustomersByKeyWord')?>",
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
         });*/
		
	
      
		
		
        jQuery('#client_final1').parent('.input.select').css('margin-top', '13px');


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
        jQuery(".overlayCategory").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapCategory').load(jQuery(this).attr("href"));
            jQuery('#dialogModalCategory').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalCategory').dialog('open');
        });

        jQuery("#dialogModalCustomer").dialog({
            autoOpen: false,
            height: 420,
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
        jQuery(".overlayCustomer").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapCustomer').load(jQuery(this).attr("href"));
            jQuery('#dialogModalCustomer').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalCustomer').dialog('open');
        });

        jQuery("#dialogModalClient").dialog({
            autoOpen: false,
            height: 610,
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
        
		
		jQuery(".overlayClient").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapClient').load(jQuery(this).attr("href"));
            var clientDiv = jQuery('#dialogModalClient');
            clientDiv.dialog('option', 'title', jQuery(this).attr("title"));
            clientDiv.dialog('open');
        });

        jQuery(".overlayEditClient").click(function (event) {
            event.preventDefault();
            var clientId = jQuery("#client").val();
            if (clientId > 0) {

                var clientDiv = jQuery('#dialogModalClient');
                clientDiv.dialog('option', 'title', jQuery(this).attr("title"));
                clientDiv.dialog('open');
                jQuery('#contentWrapClient').load("<?php echo $this->Html->url('/Suppliers/editClient/')?>" + clientId + '/client');
            }
        });


    });

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
        console.log('calculatePriceRide');
        console.log(id);
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
                price_ht = price_ht - (parseFloat(jQuery("#ristourne_val" + '' + num + '').val())*parseFloat(nb_trucks));
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
            if(parseFloat(jQuery("#ristourne_percentage" ).val()) > 0){
                calculateGlobalRistourneVal();
            }else if(parseFloat(jQuery("#ristourne_val" ).val()) > 0){
                calculateGlobalRistourne();
            }
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
        console.log('calculateTotalPrice');
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
            jQuery('#stamp').val(stamp);
            jQuery('#total_ttc').val(totalTtc);
        } else {
            var totalHt = jQuery('#total_ht').val();
            var totalTva = jQuery('#total_tva').val();
            var totalTtc = parseFloat(totalHt) + parseFloat(totalTva);
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

            jQuery("#programming_date" + '' + i + '').inputmask("date", {"placeholder": "dd/mm/yyyy"});
            jQuery("#charging_time" + '' + i + '').inputmask("hh:mm", {"placeholder": "HH:MM"});
            jQuery("#unloading_date" + '' + i + '').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});

            if(jQuery('#gestion_programmation_sous_traitance').val()=='1' &&
                jQuery('#type').val()!=1
            ){
                jQuery('#programming_date' + '' + i + '').parent().parent().attr('class', 'input text required');
                jQuery('#charging_time' + '' + i + '').parent().parent().attr('class', 'input text required');
                jQuery('#unloading_date' + '' + i + '').parent().parent().attr('class', 'input text required');
                jQuery('#arrival_destination' + '' + i + '').parent('.input.select').addClass('required');
            }




            setTvaValue();
        });

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
                $('.select3').select2({});
                jQuery("#start_date" + '' + num + '').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
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
                $('.select-search-car').select2({
                    ajax: {
                        url: "<?php echo $this->Html->url('/cars/getCarsByKeyWord')?>",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: $.trim(params.term),
                                controller :jQuery('#controller').val(),
                                action :jQuery('#current_action').val(),
                                carId : '',
                                carTypeId : jQuery('#car_type'+ '' + num + '').val()
                            };
                        },
                        processResults: function (data, page) {
                            return {results: data};
                        },
                        cache: true
                    },
                    minimumInputLength: 2
                });
                if(jQuery('#car_required' + '' + num +'').val()==1){
                    jQuery('#car' + '' + num +'').parent().addClass('required');
                }
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
        });
        jQuery("#delivery-return-div" + '' + num + '').load('<?php echo $this->Html->url('/transportBills/getDeliveryReturn/')?>' + num + '/' + productId + '/' + deliveryWithReturn, function () {
            $('.select-search').select2();
        });
        jQuery("#type-pricing-div" + '' + num + '').load('<?php echo $this->Html->url('/transportBills/getTypePricing/')?>' + num + '/' + productId, function () {
            $('.select-search').select2();
        });
        jQuery("#tonnage-div" + '' + num + '').load('<?php echo $this->Html->url('/transportBills/getInformationPricing/')?>' + num + '/' + productId + '/' + typePricing, function () {
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

    function addRowPenalty() {
        var item = jQuery('#nb_penalty').val();
        item++;
        jQuery('#table_penalty').append('<tr id="penalty' + item + '"><td></td></tr>');
        jQuery("#penalty" + '' + item + '').load('<?php echo $this->Html->url('/transportBills/addRowPenalty/')?>' + item, function () {
           });
        jQuery('#nb_penalty').val(item);
    }

    function removePenalty(id) {
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var i = trId.substring(7, trId.length);
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
                jQuery('#'+tvaInputId).val('3');
                calculatePriceRide(tvaInputId);
            }
        }else{
            for (let i = 1; i <= nbRide; i++ ){
                tvaInputId = tvaInput+''+i;
                jQuery('#'+tvaInputId).val('1');
                calculatePriceRide(tvaInputId);
            }
        }
    }

    function getThirdPartyContact(elem) {
        let supplierId = elem.val();
        let url = '<?= $this->Html->url('/transportBills/getThirdPartyNumberAjax/') ?>';
        jQuery.ajax({
            type: "POST",
            url: url,
            data: "supplierId=" + supplierId,
            dataType: "json",
            success: function (json) {
                let tel = '';
                if(json['SupplierContact'].length > 0){
                    tel = json['SupplierContact'][0]['tel'];
                }else{
                    tel = json['Supplier']['tel'];
                }
                jQuery('#client_contact').val(tel);
            }
        });
    }
</script>

<?php $this->end(); ?>