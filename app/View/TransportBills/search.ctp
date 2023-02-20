<style>
    .actions {
        width: 100px;
    }
    .btn-period {
        display: block;
    }
    .label-period {
        width: 52px !important;
    }
</style>

<?php
App::import('Model', 'Observation');
$this->Observation = new Observation();
App::import('Model', 'TransportBillDetailRides');
$this->TransportBillDetailRides = new TransportBillDetailRides();
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->Html->css('select2/select2.min');
echo $this->Html->css('iCheck/flat/red');
echo $this->Html->css('iCheck/all');
$this->end(); ?>
<div id="msg"></div>
<?php
switch ($type) {
    case TransportBillTypesEnum::quote_request :
        ?><h4 class="page-title"> <?= __('Request quotation'); ?></h4>
        <?php     break;
    case TransportBillTypesEnum::quote :
        ?><h4 class="page-title"> <?= __('Quotation'); ?></h4>
        <?php     break;
    case TransportBillTypesEnum::order :
        ?><h4 class="page-title"> <?= __("Customer orders"); ?></h4>
        <?php    break;
    case TransportBillTypesEnum::sheet_ride :
        ?><h4 class="page-title"> <?= __("Sheet ride"); ?></h4>
        <?php    break;
    case TransportBillTypesEnum::pre_invoice :
        ?><h4 class="page-title"> <?= __("Preinvoices"); ?></h4>
        <?php     break;
    case TransportBillTypesEnum::invoice :
        ?><h4 class="page-title"> <?= __("Invoices"); ?></h4>
        <?php  break;
}
?>
<div class="box-body">
    <div class="panel-group wrap" id="bs-collapse">

        <div class="panel loop-panel">
            <a class="collapsed fltr" data-toggle="collapse" data-parent="#" href="#one">
                <i class="zmdi zmdi-search-in-page"></i>
            </a>

            <div id="one" class="panel-collapse collapse">
                <div class="panel-body">

                    <?php echo $this->Form->create('TransportBills', array(
                        'url' => array(
                            'action' => 'search'
                        ),
                        'novalidate' => true
                    )); ?>

                    <div class="filters" id='filters'>

                        <?php

                        if ($type == 0) {
                            echo $this->Form->input('ride_id', array(
                                'label' => __('Ride'),
                                'id' => 'ride',
                                'class' => 'form-filter',
                                'empty' => ''
                            ));

                            echo $this->Form->input('car_type_id', array(
                                'label' => __('Transportation'),
                                'class' => 'form-filter select2',
                                'id' => 'car_type',
                                'empty' => ''
                            ));
                            echo "<div style='clear:both; padding-top: 10px;'></div>";
                        }
                        if ($profileId == ProfilesEnum::client) {
                            echo $this->Form->input('client_id', array(
                                'label' => __('Client'),
                                'type' => 'hidden',
                                'value' => $supplierId,
                                'id' => 'client',
                                'empty' => ''
                            ));
                            echo $this->Form->input('supplier_id', array(
                                'label' => __('Client'),
                                'class' => 'form-filter select-search-client-final',
                                'id' => 'supplier',
                                'empty' => ''
                            ));
                        } else {
                            echo $this->Form->input('supplier_id', array(
                                'label' => __('Client'),
                                'class' => 'form-filter select-search-client-initial',
                                'id' => 'supplier',
                                'empty' => ''
                            ));
                            echo $this->Form->input('service_id', array(
                                'label' => __('Service'),
                                'class' => 'form-filter select2',
                                'id' => 'service',
                                'empty' => ''
                            ));
                        }

                        echo $this->Form->input('type', array(
                            'label' => __('Type'),
                            'class' => 'form-filter',
                            'id' => 'type',
                            'type' => 'hidden',
                            'value' => $type,
                            'empty' => ''
                        ));

                        echo "<div style='clear:both; padding-top: 10px;'></div>"; ?>

                        <div class="btn-group btn-period">
                            <a data-toggle="dropdown" class="btn btn-inverse" style="height: 35px; margin-top: 8px">
                                <i class="fa "
                                   style="padding-top: 4px;font-weight: bold; font-family: 'Roboto', sans-serif;"><?php echo __('Period') ?></i>
                            </a>
                            <button href="#" data-toggle="dropdown" class="btn btn-inverse dropdown-toggle share"
                                    style="height: 35px; margin-top: 8px">
                                <span class="caret"></span>
                            </button>

                            <ul class="dropdown-menu" style="min-width: 70px; margin-top: 45px;margin-left: 50px;">

                                <li>
                                    <?= $this->Html->link(__('Today'), 'javascript:definePeriod("today");',
                                        array('escape' => false, 'id' => 'today')) ?>
                                </li>

                                <li>
                                    <?= $this->Html->link(__('This week'), 'javascript:definePeriod("week");',
                                        array('escape' => false, 'id' => 'week')) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link(__('This month'), 'javascript:definePeriod("month");',
                                        array('escape' => false, 'id' => 'month')) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link(__('This quarter'), 'javascript:definePeriod("quarter");',
                                        array('escape' => false, 'id' => 'quarter')) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link(__('This semester'), 'javascript:definePeriod("semester");',
                                        array('escape' => false, 'id' => 'semester')) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link(__('This year'), 'javascript:definePeriod("year");',
                                        array('escape' => false, 'id' => 'year')) ?>
                                </li>
                            </ul>
                        </div>

                        <?php    echo $this->Form->input('date1', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask ',
                            'before' => '<div class="input-group date from_date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'date1',
                        ));
                        echo $this->Form->input('date2', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'date2',
                        ));


                        if ($isSuperAdmin) {
                            echo "<div style='clear:both; padding-top: 40px;'></div>";

                            echo '<div class="lbl"> <a href="#demo" data-toggle="collapse"><i class="fa fa-search"></i>' . __("  Administrative filter") . '</a></div>';

                            ?>


                            <div id="demo" class="collapse">
                                <div
                                    style="clear:both; padding-top: 0px;padding-left: 20px;  border-bottom: 1px solid rgb(204, 204, 204);margin-bottom: 15px;"></div>


                                <?php
                                echo $this->Form->input('profile_id', array(
                                    'label' => __('Profile'),
                                    'class' => 'form-filter',
                                    'empty' => ''
                                ));
                                echo "<div style='clear:both; padding-top: 10px;'></div>";
                                echo $this->Form->input('user_id', array(
                                    'label' => __('Created by'),
                                    'class' => 'form-filter select2',
                                    'empty' => ''
                                ));
                                echo $this->Form->input('created', array(
                                    'label' => '',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label class="dte">' . __('From date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'startdatecreat',
                                ));
                                echo $this->Form->input('created1', array(
                                    'label' => '',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'enddatecreat',
                                ));
                                echo "<div style='clear:both; padding-top: 10px;'></div>";
                                echo $this->Form->input('modified_id', array(
                                    'options' => $users,
                                    'label' => __('Modified by'),
                                    'class' => 'form-filter select2',
                                    'empty' => ''
                                ));

                                echo $this->Form->input('modified', array(
                                    'label' => '',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label class="dte">' . __('From date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'startdatemodifie',
                                ));
                                echo $this->Form->input('modified1', array(
                                    'label' => '',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'enddatemodifie',
                                ));
                                ?>
                            </div>
                            <div style='clear:both; padding-top: 10px;'></div>
                        <?php } ?>
                        <button class="btn btn-default" type="submit"><?= __('Search') ?></button>
                        <div style='clear:both; padding-top: 10px;'></div>
                    </div>



                    <?php echo $this->Form->end(); ?>


                </div>

            </div>
        </div>
        <!-- end of panel -->


    </div>
    <!-- end of #bs-collapse  -->

<?php
    if (($profileId != ProfilesEnum::client)) { ?>
        <div class="row" id="grp_actions">
            <!-- BASIC WIZARD -->
            <div class="col-lg-12">
                <div class="card-box p-b-0">
                    <div class="row" style="clear:both">
                        <div class="btn-group pull-left">
                            <div class="header_actions">
                                <?php
                                switch ($type) {
                                    case TransportBillTypesEnum::quote_request :
                                        echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                            array('action' => 'addRequestQuotation'),
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')); ?>
                                        <?php if ($permissionQuoteRequest == 1) { ?>
                                        <div class="btn-group">
                                            <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transform to'),
                                                'javascript:',
                                                array('escape' => false,
                                                    'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',
                                                    'id' => 'transform',
                                                    'disabled' => 'true')) ?>
                                            <button type="button" id="export_allmark"
                                                    class="btn dropdown-toggle btn-inverse  btn-bordred"
                                                    data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>


                                                    <?= $this->Html->link(__('Quotation'), 'javascript:transformFromQuotationRequestToOrder(1);',
                                                        array('escape' => false, 'id' => 'commande', 'class' => 'btn btn-act ', 'disabled' => 'true')) ?>

                                                    <?php
                                                    echo $this->Form->input('type', array(
                                                        'label' => '',
                                                        'type' => 'text',
                                                        'value' => $type,
                                                        'type' => 'hidden'

                                                    ));
                                                    ?>
                                                </li>
                                            </ul>

                                        </div>
                                    <?php
                                    }
                                        break;


                                    case TransportBillTypesEnum::quote :
                                        echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                            array('action' => 'Add', $type),
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')); ?>
                                        <?php if ($permissionQuote == 1) { ?>
                                        <div class="btn-group">
                                            <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transform to'),
                                                'javascript:',
                                                array('escape' => false,
                                                    'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',
                                                    'id' => 'transform',
                                                    'disabled' => 'true')) ?>
                                            <button type="button" id="export_allmark"
                                                    class="btn dropdown-toggle btn-inverse  btn-bordred"
                                                    data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <?= $this->Html->link(__('Customer order'), 'javascript:transformFromQuotationRequestToOrder(2);',
                                                        array('escape' => false, 'id' => 'commande', 'class' => 'btn btn-act ', 'disabled' => 'true')) ?>

                                                    <?php
                                                    echo $this->Form->input('type', array(
                                                        'label' => '',
                                                        'type' => 'text',
                                                        'value' => $type,
                                                        'type' => 'hidden'

                                                    ));
                                                    ?>
                                                </li>
                                            </ul>

                                        </div>
                                        <?php    break;
                                    }

                                    case TransportBillTypesEnum::order :
                                        echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                            array('action' => 'Add', $type),
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));

                                        if ($permissionOrder == 1) {
                                            echo $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transmit'),
                                                'javascript:validateCustomerOrder();',
                                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'validate'));

                                        }
                                        if ($permissionCancel == 1) {
                                            echo $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Cancel'),
                                                'javascript:cancelCustomerOrder();',
                                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'cancel'));
                                        }
                                        break;
                                    case TransportBillTypesEnum::sheet_ride :
                                        echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                            array('action' => 'Add', $type),
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));
                                        break;
                                    case TransportBillTypesEnum::pre_invoice :
                                        ?>

                                        <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add from sheet rides'),
                                        array('controller' => 'transportBills', 'action' => 'AddFromSheetRide'),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>

                                        <div class="btn-group">
                                            <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transform to'),
                                                'javascript:',
                                                array('escape' => false,
                                                    'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',
                                                    'id' => 'transform',
                                                    'disabled' => 'true')) ?>
                                            <button type="button" id="export_allmark"
                                                    class="btn dropdown-toggle btn-inverse  btn-bordred"
                                                    data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>


                                                    <?= $this->Html->link(__('Invoice'), 'javascript:transformPreinvoiceToInvoice(7);',
                                                        array('escape' => false, 'id' => 'commande', 'class' => 'btn btn-act ', 'disabled' => 'true')) ?>
                                                    <?php

                                                    echo $this->Form->input('type', array(
                                                        'label' => '',
                                                        'type' => 'text',
                                                        'value' => $type,
                                                        'type' => 'hidden'

                                                    ));
                                                    ?>
                                                </li>
                                            </ul>

                                        </div>

                                        <?php if ($hasTreasuryModule == 1 && $settleMissions == 1) {

                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Payment'),
                                            'javascript:verifyIdCustomers("4","addPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'payment'));


                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Advanced payment'),
                                            'javascript:verifyIdCustomers("4","advancedPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'advanced_payment'));

                                    }
                                        break;

                                    case TransportBillTypesEnum::invoice :
                                        ?>
                                        <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                        array('action' => 'add', $type),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')); ?>
                                        <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add from preinvoices'),

                                        array('controller' => 'transportBills', 'action' => 'AddFromPreinvoice'),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>

                                        <?php if ($hasTreasuryModule == 1) {

                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Payment'),
                                            'javascript:verifyIdCustomers("4","addPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'payment'));

                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Advanced payment'),
                                            'javascript:verifyIdCustomers("4","advancedPayment");',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'advanced_payment'));
                                    }
                                        break;
                                }
                                ?>
                                <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                    'javascript:submitDeleteForm("transportBills/deleteTransportBills/' . $type . '/");',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                        'disabled' => 'true'),
                                    __('Are you sure you want to delete selected bills ?')); ?>

                                <div class="btn-group">
                                    <?= $this->Html->link('<i class="fa fa-print m-r-5"></i>' . __('Print'),
                                        'javascript:;',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                                    <button type="button" id="export_allmark"
                                            class="btn dropdown-toggle btn-inverse  btn-bordred" data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <?= $this->Html->link(__('Simplified journal'), 'javascript:printSimplifiedJournal();') ?>
                                        </li>
                                        <li>
                                            <?= $this->Html->link(__('Detailed journal'), 'javascript:printDetailedJournal();') ?>
                                        </li>

                                        <li>
                                            <?= $this->Html->link(__('Detailed journal per mission'), 'javascript:printDetailedJournalPerMission();') ?>
                                        </li>
                                    </ul>
                                </div>

                                <div id="dialogModalConditionTransformation">
                                    <!-- the external content is loaded inside this tag -->

                                </div>


                                <div id="dialogModalAdvencedPayments">
                                    <!-- the external content is loaded inside this tag -->

                                </div>


                            </div>


                        </div>
                        <div style='clear:both; padding-top: 10px;'></div>
                    </div>

                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="row" id="grp_actions">
            <!-- BASIC WIZARD -->
            <div class="col-lg-12">
                <div class="card-box p-b-0">
                    <div class="row" style="clear:both">

                        <div class="btn-group pull-left">
                            <div class="header_actions">
                                <?php
                                switch ($type) {
                                    case TransportBillTypesEnum::quote_request :
                                        echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                            array('action' => 'addRequestQuotation'),
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')); ?>
                                        <?php if ($permissionQuoteRequest == 1) { ?>
                                        <div class="btn-group">
                                            <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transform to'),
                                                'javascript:',
                                                array('escape' => false,
                                                    'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',
                                                    'id' => 'transform',
                                                    'disabled' => 'true')) ?>
                                            <button type="button" id="export_allmark"
                                                    class="btn dropdown-toggle btn-inverse  btn-bordred"
                                                    data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <?= $this->Html->link(__('Quotation'), 'javascript:transformFromQuotationRequestToOrder(1);',
                                                        array('escape' => false, 'id' => 'commande', 'class' => 'btn btn-act ', 'disabled' => 'true')) ?>
                                                    <?php
                                                    echo $this->Form->input('type', array(
                                                        'label' => '',
                                                        'type' => 'text',
                                                        'value' => $type,
                                                        'type' => 'hidden'
                                                    ));
                                                    ?>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                        <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                        'javascript:submitDeleteForm("transportBills/deleteTransportBills/' . $type . '/");',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                            'disabled' => 'true'),
                                        __('Are you sure you want to delete selected bills ?')); ?>

                                        <?php     break;
                                    case TransportBillTypesEnum::quote :
                                     if ($permissionQuote == 1) { ?>
                                        <div class="btn-group">
                                            <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transform to'),
                                                'javascript:',
                                                array('escape' => false,
                                                    'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',
                                                    'id' => 'transform',
                                                    'disabled' => 'true')) ?>
                                            <button type="button" id="export_allmark"
                                                    class="btn dropdown-toggle btn-inverse  btn-bordred"
                                                    data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <?= $this->Html->link(__('Customer order'), 'javascript:transformFromQuotationRequestToOrder(2);',
                                                        array('escape' => false, 'id' => 'commande', 'class' => 'btn btn-act ', 'disabled' => 'true')) ?>

                                                        <?php
                                                        echo $this->Form->input('type', array(
                                                            'label' => '',
                                                            'type' => 'text',
                                                            'value' => $type,
                                                            'type' => 'hidden'

                                                        ));
                                                        ?>
                                                    </li>
                                                </ul>

                                            </div>
                                            <?php    break;
                                        }
                                    case TransportBillTypesEnum::order :
                                        echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                            array('action' => 'Add',$type),
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));
                                        if ($permissionCancel == 1) {
                                            echo $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Cancel'),
                                                'javascript:cancelCustomerOrder();',
                                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'cancel'));

                                            break; } ?>
                                        <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                        'javascript:submitDeleteForm("transportBills/deleteTransportBills/' . $type . '/");',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                            'disabled' => 'true'),
                                        __('Are you sure you want to delete selected bills ?')); ?>
                                        <?php    break;

                                    case TransportBillTypesEnum::pre_invoice :
                                        break;

                                    case TransportBillTypesEnum::invoice :
                                        break;
                                }
                                ?>
                                <div id="dialogModalConditionTransformation">
                                    <!-- the external content is loaded inside this tag -->

                                </div>
                                <div id="dialogModalAdvencedPayments">
                                    <!-- the external content is loaded inside this tag -->

                                </div>
                            </div>
                        </div>
                        <div style='clear:both; padding-top: 10px;'></div>
                    </div>

                </div>
            </div>
        </div>
    <?php } ?>


    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <?php echo $this->Form->create('TransportBills', array(
                    'url' => array(
                        'action' => 'search'
                    ),
                    'novalidate' => true,
                    'id' => 'searchKeyword'
                )); ?>
                <label style="float: right;">
                    <input id='keyword' type="text" name="keyword" id="keyword" class="form-control"
                           placeholder= <?= __("Search"); ?>>
                    <?php
                    echo $this->Form->input('type', array(
                        'label' => __('Type'),
                        'class' => 'form-filter',
                        'id' => 'type',
                        'type' => 'hidden',
                        'value' => $type,
                        'empty' => ''
                    ));
                    ?>
                </label>
                <?php echo $this->Form->end(); ?>
                <?= $this->Form->input('controller', array(
                    'id' => 'controller',
                    'value' => $this->request->params['controller'],
                    'type' => 'hidden'
                )); ?>
                <?= $this->Form->input('action', array(
                    'id' => 'action',
                    'value' => 'liste',
                    'type' => 'hidden'
                )); ?>
                <div class="col-sm-6">
                    <div class="dataTables_length m-r-15" id="datatable-editable_length" style="display: inline-block;">
                        <label>&nbsp; <?= __('Order : ') ?>
                            <?php
                            if (isset($this->params['pass']['2'])) $order = $this->params['pass']['2'];
                            ?>
                            <select aria-controls="datatable-editable" class="form-control input-sm" name="selectOrder"
                                    id="selectOrder"
                                    onchange="selectOrderChanged('transportBills/index/<?php echo $type ?>');">
                                <option
                                    value="1" <?php if ($order == 1) echo 'selected="selected"' ?>> <?= __('Reference') ?></option>
                                <option
                                    value="2" <?php if ($order == 2) echo 'selected="selected"' ?>><?= __('Id') ?></option>
                                <option
                                    value="3" <?php if ($order == 3) echo 'selected="selected"' ?>><?= __('Date') ?></option>

                            </select>
                        </label>
                    </div>
                    <div class="dataTables_length" id="datatable-editable_length" style="display: inline-block;">
                        <label>
                            <?php
                            if (isset($this->params['pass']['1'])) $limit = $this->params['pass']['1'];
                            ?>
                            <select aria-controls="datatable-editable" class="form-control input-sm" name="slctlimit"
                                    id="slctlimit"
                                    onchange="slctlimitChanged('transportBills/index/<?php echo $type ?>');">
                                <option value="20" <?php if ($limit == 20) echo 'selected="selected"' ?>>20</option>
                                <option value="25" <?php if ($limit == 25) echo 'selected="selected"' ?>>25</option>
                                <option value="50" <?php if ($limit == 50) echo 'selected="selected"' ?>>50</option>
                                <option value="100" <?php if ($limit == 100) echo 'selected="selected"' ?>>100</option>
                                <option value="500" <?php if ($limit == 500) echo 'selected="selected"' ?>>500</option>
                            </select>&nbsp; <?= __('records per page') ?>
                        </label>
                    </div>
                </div>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                       cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th style="width: 10px">
                            <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i
                                    class="fa fa-square-o"></i></button>
                        </th>
                        <th><?php echo $this->Paginator->sort('reference', __('Reference')); ?></th>
                        <th><?php echo $this->Paginator->sort('date', __('Date')); ?></th>
                        <?php if ($profileId != ProfilesEnum::client) { ?>
                            <th><?php echo $this->Paginator->sort('supplier_id', __('Initial customer')); ?></th>
                            <th><?php echo $this->Paginator->sort('service_id', __('Service')); ?></th>
                        <?php } ?>

                        <?php if (($type == TransportBillTypesEnum::quote_request)
                        ) {
                            ?>
                            <th><?php echo $this->Paginator->sort('supplier_final_id', __('Final customer')); ?></th>
                            <th><?php echo $this->Paginator->sort('ride_id', __('Ride')); ?></th>
                            <th><?php echo $this->Paginator->sort('car_type_id', __('Transportation')); ?></th>
                            <th><?php echo $this->Paginator->sort('nb_trancks', __('Number of trucks')); ?></th>
                        <?php } else {
                            if (($profileId != ProfilesEnum::client)) {
                                ?>
                                <th><?php echo $this->Paginator->sort('price_ht', __('Total HT')); ?></th>
                                <th><?php echo $this->Paginator->sort('price_tva', __('Total TVA')); ?></th>
                                <th><?php echo $this->Paginator->sort('price_ttc', __('Total TTC')); ?></th>
                            <?php } } ?>

                        <?php
                        if (($type == TransportBillTypesEnum::invoice) || ($type == TransportBillTypesEnum::quote_request) ||
                            ($type == TransportBillTypesEnum::quote) ||
                            ($type == TransportBillTypesEnum::pre_invoice && $settleMissions == 1)
                        ) {
                            if (($type == TransportBillTypesEnum::invoice) ||
                                ($type == TransportBillTypesEnum::pre_invoice && $settleMissions == 1)
                            ) {
                                ?>
                                <th><?php echo $this->Paginator->sort('amount_remaining', __('Amount remaining')); ?></th>
                            <?php
                            }
                            ?>

                        <?php
                        }
                        if (($type == TransportBillTypesEnum::invoice) || ($type == TransportBillTypesEnum::quote_request) ||
                            ($type == TransportBillTypesEnum::quote) || ($type == TransportBillTypesEnum::order) ||
                            ($type == TransportBillTypesEnum::pre_invoice && $settleMissions == 1)
                        ) {
                            ?>
                            <th><?php echo $this->Paginator->sort('status', __('Status')); ?></th>
                        <?php } ?>

                        <?php if (($profileId != ProfilesEnum::client)) { ?>
                            <th class="actions"><?php echo __('Actions'); ?></th>
                        <?php
                        } else {
                            switch ($type) {
                                case TransportBillTypesEnum::quote_request :
                                    ?>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                    <?php
                                    break;
                                case TransportBillTypesEnum::quote:
                                    break;
                                case TransportBillTypesEnum::order:
                                    ?>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                    <?php
                                    break;
                                case TransportBillTypesEnum::pre_invoice:
                                    break;
                                case TransportBillTypesEnum::invoice:
                                    break;
                            }
                        } ?>

                    </tr>
                    </thead>
                    <tbody id="listeDiv">
                    <?php foreach ($transportBills as $transportBill): ?>
                        <tr id="row<?= $transportBill['TransportBill']['id'] ?>">
                            <td
                                onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                                <?php echo $transportBill['TransportBill']['type'] ?> )'
                                >

                                <input id="idCheck" type="checkbox" class='id'
                                       value=<?php echo $transportBill['TransportBill']['id'] ?>>


                            </td>

                            <td
                                onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                                <?php echo $transportBill['TransportBill']['type'] ?> )'
                                ><?php echo h($transportBill['TransportBill']['reference']); ?>&nbsp;</td>
                            <td
                                onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                                <?php echo $transportBill['TransportBill']['type'] ?> )'

                                ><?php echo h($this->Time->format($transportBill['TransportBill']['date'], '%d-%m-%Y')); ?>
                                &nbsp;</td>
                            <?php if ($profileId != ProfilesEnum::client) { ?>
                                <td
                                    onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                                    <?php echo $transportBill['TransportBill']['type'] ?> )'

                                    ><?php echo h($transportBill['Supplier']['name']); ?>&nbsp;</td>
                                <td
                                        onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                                        <?php echo $transportBill['TransportBill']['type'] ?> )'

                                ><?php echo h($transportBill['Service']['name']); ?>&nbsp;
                                </td>
                            <?php } ?>
                            <?php if (($type == TransportBillTypesEnum::quote_request)
                            ) {
                                ?>
                                <td
                                    onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                                    <?php echo $transportBill['TransportBill']['type'] ?> )'
                                    ><?php echo h($transportBill['SupplierFinal']['name']); ?>&nbsp;</td>
                                <td
                                    onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                                    <?php echo $transportBill['TransportBill']['type'] ?> )'
                                    ><?php echo h($transportBill['DepartureDestination']['name'] . '-' . $transportBill['ArrivalDestination']['name']); ?>
                                    &nbsp;</td>
                                <td
                                    onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                                    <?php echo $transportBill['TransportBill']['type'] ?> )'
                                    ><?php echo h($transportBill['CarType']['name']); ?>&nbsp;</td>
                                <td
                                    onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                                    <?php echo $transportBill['TransportBill']['type'] ?> )'
                                    ><?php echo h($transportBill['transportBillDetailRides']['nb_trucks']); ?>
                                    &nbsp;</td>
                            <?php } else {

                                if (($profileId != ProfilesEnum::client)) {

                                    ?>
                                    <td
                                        onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                                        <?php echo $transportBill['TransportBill']['type'] ?> )'
                                        ><?php echo number_format($transportBill['TransportBill']['total_ht'], 2, ",", $separatorAmount) . ' ' . $this->Session->read("currency"); ?>
                                        &nbsp;</td>
                                    <td
                                        onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                                        <?php echo $transportBill['TransportBill']['type'] ?> )'
                                        ><?php echo number_format($transportBill['TransportBill']['total_tva'], 2, ",", $separatorAmount) . ' ' . $this->Session->read("currency"); ?>
                                        &nbsp;</td>
                                    <td
                                        onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                                        <?php echo $transportBill['TransportBill']['type'] ?> )'
                                        ><?php echo number_format($transportBill['TransportBill']['total_ttc'], 2, ",", $separatorAmount) . ' ' . $this->Session->read("currency"); ?>
                                        &nbsp;</td>
                                <?php } } ?>
                            <?php

                            if (($type == TransportBillTypesEnum::invoice) || ($type == TransportBillTypesEnum::quote_request) ||
                                ($type == TransportBillTypesEnum::quote) || ($type == TransportBillTypesEnum::order) ||
                                ($type == TransportBillTypesEnum::pre_invoice && $settleMissions == 1)
                            ) {

                                if (($type == TransportBillTypesEnum::invoice) ||
                                    ($type == TransportBillTypesEnum::pre_invoice && $settleMissions == 1)
                                ) {

                                    ?>
                                    <td
                                        onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                                        <?php echo $transportBill['TransportBill']['type'] ?> )'
                                        >
                                        <?php echo number_format(
                                                $transportBill['TransportBill']['amount_remaining'], 2, ",", $separatorAmount
                                            ) . ' ' . $this->Session->read("currency"); ?>&nbsp;</td>
                                    <td  <?php if ($type == TransportBillTypesEnum::order && $profileId == ProfilesEnum::client) { ?>
                                        onclick='viewDetailCustomerOrder(<?php echo $transportBill['TransportBill']['id'] ?>,
                                        <?php echo $transportBill['TransportBill']['nb_trucks'] ?> )'
                                    <?php } else { ?>
                                        onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                                        <?php echo $transportBill['TransportBill']['type'] ?> )'
                                    <?php } ?>><?php switch ($transportBill['TransportBill']['status_payment']) {
                                            case 1:
                                                echo '<span class="label label-danger">';
                                                echo __('Not paid') . "</span>";
                                                break;
                                            case 2:
                                                echo '<span class="label label-success">';
                                                echo __('Paid') . "</span>";
                                                break;

                                            case 3:
                                                echo '<span class="label label-warning">';
                                                echo __('Partially paid') . "</span>";
                                                break;

                                        } ?>&nbsp;</td>
                                <?php
                                } elseif ($type == TransportBillTypesEnum::quote_request || $type == TransportBillTypesEnum::quote) {
                                    ?>

                                    <td><?php switch ($transportBill['TransportBill']['status']) {
                                            case 1:
                                                echo '<span class="label label-danger">';
                                                echo __('Not transformed') . "</span>";
                                                break;
                                            case 2:
                                                echo '<span class="label label-success">';
                                                echo __('Transformed') . "</span>";
                                                break;

                                        } ?>&nbsp;</td>

                                <?php } else { ?>

                                    <td
                                        onclick='viewDetail(<?php echo $transportBill['TransportBill']['id'] ?>,
                                        <?php echo $transportBill['TransportBill']['type'] ?> )'
                                        >

                                        <?php switch ($transportBill['TransportBill']['status']) {
                                            /*
                                            1: commandes non validée
                                            2: commandes partiellement validees
                                            3: commandes validees
                                            */
                                            case 1:
                                                echo '<span class="label label-danger">';
                                                echo __('Not validated') . "</span>";
                                                break;
                                            case 2:
                                                echo '<span class="label label-warning">';
                                                echo __('Partially validated') . "</span>";
                                                break;
                                            case 3:
                                                echo '<span class="label label-success">';
                                                echo __('Validated') . "</span>";
                                                break;

                                            case 8:
                                                echo '<span class="label label-primary">';
                                                echo __('Not transmitted') . "</span>";
                                                break;

                                            case 9:
                                                echo '<span class="label label-inverse">';
                                                echo __('Canceled') . "</span>";
                                                break;

                                        } ?>&nbsp;
                                    </td>
                                <?php
                                }
                            }
                            ?>

                            <?php if (($profileId != ProfilesEnum::client)) { ?>
                                <td class="actions transport-bil-actions">
                                    <div class="btn-group ">
                                        <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                            <i class="fa fa-list fa-inverse"></i>
                                        </a>
                                        <button href="#" data-toggle="dropdown"
                                                class="btn btn-info dropdown-toggle share">
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" style="min-width: 70px;">
                                            <?php switch ($type) {
                                                case TransportBillTypesEnum::quote_request :
                                                    ?>
                                                    <li class='view-link' title='<?= __('View') ?>'>
                                                        <?php
                                                        echo $this->Html->link(
                                                            '<i class="  fa fa-eye m-r-5"></i>',
                                                            array('action' => 'View', $type, $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-success')
                                                        );
                                                        ?>
                                                    </li>
                                                    <li class='edit-link' title='<?= __('Edit') ?>'>
                                                        <?php  echo $this->Html->link(
                                                            '<i class="fa fa-edit m-r-5"></i>',
                                                            array('action' => 'editRequestQuotation', $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-primary')
                                                        ); ?>
                                                    </li>
                                                    <li class='edit-link' title='<?= __('Dissociate') ?>'>
                                                        <?php  echo $this->Html->link(
                                                            '<i class="fa  fa-unlink m-r-5"></i>',

                                                            array('action' => 'dissociate', $type,$transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-warning')
                                                        ); ?>
                                                    </li>
                                                    <li class='delete-link' title='<?= __('Delete') ?>'>
                                                        <?php   echo $this->Form->postLink(
                                                            '<i class="fa fa-trash-o m-r-5"></i>',
                                                            array('action' => 'Delete', $type, $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-danger'),
                                                            __('Are you sure you want to delete %s?', $transportBill['TransportBill']['reference'])); ?>
                                                    </li>

                                                    <?php    break;
                                                case TransportBillTypesEnum::quote :
                                                    ?>
                                                    <li class='view-link' title='<?= __('View') ?>'>
                                                        <?php  echo $this->Html->link(
                                                            '<i class="fa fa-eye m-r-5"></i>',
                                                            array('action' => 'View', $type, $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-success')
                                                        ); ?>
                                                    </li>
                                                    <?php if (($transportBill['TransportBill']['status'] != TransportBillDetailRideStatusesEnum:: validated)
                                                ) {
                                                    ?>
                                                    <li class='edit-link' title='<?= __('Edit') ?>'>
                                                        <?php  echo $this->Html->link(
                                                            '<i class="fa fa-edit m-r-5"></i>',
                                                            array('action' => 'Edit', $type, $transportBill['TransportBill']['id'],$this->request->params['controller'], base64_encode(serialize($_SERVER['REQUEST_URI']))),
                                                            array('escape' => false, 'class' => 'btn btn-primary')
                                                        ); ?>
                                                    </li>
                                                <?php } ?>
                                                    <li class='edit-link' title='<?= __('Dissociate') ?>'>
                                                        <?php  echo $this->Html->link(
                                                            '<i class="fa  fa-unlink m-r-5"></i>',

                                                            array('action' => 'dissociate', $type, $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-warning')
                                                        ); ?>
                                                    </li>
                                                    <li class='delete-link' title='<?= __('Delete') ?>'>
                                                        <?php  echo $this->Form->postLink(
                                                            '<i class="fa fa-trash-o m-r-5"></i>',
                                                            array('action' => 'Delete', $type, $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-danger'),
                                                            __('Are you sure you want to delete %s?', $transportBill['TransportBill']['reference']));
                                                        ?>
                                                    </li>
                                                    <li class='duplicate-link' title=<?= __('Duplicate') ?>>
                                                        <?php echo $this->Html->link(
                                                            '<i class="fa fa-copy m-r-5"></i>',
                                                            array('action' => 'duplicate_relance', 3, $type, $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-warning')
                                                        ); ?>
                                                    </li>
                                                    <li class='revive-link' title=<?= __('Revive') ?>>
                                                        <?php echo $this->Html->link(
                                                            '<i class="fa fa-refresh m-r-5"></i>',
                                                            array('action' => 'Send_mail', $type, $transportBill['TransportBill']['id'], 1),
                                                            array('escape' => false, 'class' => 'btn btn-info')
                                                        ); ?>
                                                    </li>

                                                    <li class='mail-link' title="<?= __('Send email') ?>">
                                                        <?php echo $this->Html->link(
                                                            '<i class="fa fa-envelope m-r-5"></i>',
                                                            array('action' => 'Send_mail', $type, $transportBill['TransportBill']['id'], 0),
                                                            array('escape' => false, 'class' => 'btn btn-purple'));
                                                        ?>
                                                    </li>
                                                    <li class='parameter-mail-link' title="<?= __('Parameter mail') ?>">
                                                        <?php
                                                        $msg = 'Bonjour, ';
                                                        if (!empty($transportBill['Supplier']['contact'])) {
                                                            $msg = $msg . $transportBill['Supplier']['contact'];
                                                        }
                                                        $msg .= "%0D%0A";
                                                        $msg .= 'Ci-joint votre devis numero ' . $transportBill['TransportBill']['reference'];

                                                        if (!empty($transportBill['Supplier']['email'])) {
                                                            $mail = $transportBill['Supplier']['email']; ?>
                                                            <a class="btn btn-pink"
                                                               href="mailto:<?php echo $mail ?> &body=<?php echo $msg; ?>"
                                                               onclick='piece_pdf();'>
                                                                <i class="fa  fa-envelope-o m-r-5"> </i>
                                                            </a>
                                                        <?php } else { ?>

                                                            <a class="btn btn-pink "
                                                               href="mailto: &body= <?php echo $msg; ?>"
                                                               onclick='piece_pdf();'>
                                                                <i class="fa  fa-envelope-o m-r-5"
                                                                   title="Parametre mail"> </i>
                                                            </a>
                                                        <?php } ?>
                                                    </li>

                                                    <li class='edit-link' title="<?= __('Print simplified bill') ?>">
                                                        <?php switch ($reportingChoosed) {
                                                            case 1: ?>
                                                                <?= $this->Html->link(
                                                                    '<i class="fa fa-print"></i>',
                                                                    array('action' => 'print_facture', 'ext' => 'pdf', $transportBill['TransportBill']['id'],$type),
                                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-inverse')
                                                                ); ?>

                                                                <?php
                                                                break;

                                                            case 2: ?>

                                                                <?php
                                                                break;
                                                            case 3:
                                                                $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                                $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                                $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                                                $link = $reportsPathJasper.'/transport_bills.pdf?j_username='.$usernameJasper.'&j_password='.$passwordJasper.'&id='.$transportBill['TransportBill']['id'];

                                                                ?>
                                                                <a href="<?php echo $link ?>" target="_blank" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                                                <?php    break;
                                                                ?>
                                                            <?php  }?>
                                                    </li>
                                                    <li class='edit-link' title="<?= __('Print detailed bill') ?>">
                                                        <?php switch ($reportingChoosed) {
                                                            case 1: ?>
                                                                <?= $this->Html->link(
                                                                    '<i class="fa fa-print"></i>',
                                                                    array('action' => 'print_detailed_facture', 'ext' => 'pdf', $transportBill['TransportBill']['id'],$type),
                                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-inverse')
                                                                ); ?>

                                                                <?php
                                                                break;

                                                            case 2: ?>

                                                                <?php
                                                                break;
                                                            case 3:
                                                                $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                                $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                                $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                                                $link = $reportsPathJasper.'/transport_bills.pdf?j_username='.$usernameJasper.'&j_password='.$passwordJasper.'&id='.$transportBill['TransportBill']['id'];

                                                                ?>
                                                                <a href="<?php echo $link ?>" target="_blank" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                                                <?php    break;
                                                                ?>
                                                            <?php  }?>
                                                    </li>


                                                    <?php
                                                    break;
                                                case TransportBillTypesEnum::order :
                                                    ?>
                                                    <li class='view-link' title='<?= __('View') ?>'>
                                                        <?php
                                                        echo $this->Html->link(
                                                            '<i class="  fa fa-eye m-r-5"></i>',
                                                            array('action' => 'View', $type, $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-success')); ?>
                                                    </li>

                                                    <li class='edit-link' title='<?= __('Edit') ?>'>
                                                        <?php
                                                        echo $this->Html->link(
                                                            '<i class="  fa fa-edit m-r-5"></i>',
                                                            array('action' => 'Edit', $type, $transportBill['TransportBill']['id'],$this->request->params['controller'], base64_encode(serialize($_SERVER['REQUEST_URI']))),
                                                            array('escape' => false, 'class' => 'btn btn-primary')); ?>
                                                    </li>
                                                    <li class='edit-link' title='<?= __('Dissociate') ?>'>
                                                        <?php  echo $this->Html->link(
                                                            '<i class="fa  fa-unlink m-r-5"></i>',

                                                            array('action' => 'dissociate', $type, $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-warning')
                                                        ); ?>
                                                    </li>
                                                    <li class='edit-link' title=<?= __('Print') ?>>
                                                        <?php switch ($reportingChoosed) {
                                                            case 1: ?>
                                                                <?= $this->Html->link(
                                                                    '<i class="fa fa-print"></i>',
                                                                    array('action' => 'print_facture', 'ext' => 'pdf', $transportBill['TransportBill']['id'],$type),
                                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-inverse')
                                                                ); ?>
                                                                <?php
                                                                break;

                                                            case 2: ?>

                                                                <?php
                                                                break;
                                                            case 3:
                                                                $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                                $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                                $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                                                $link = $reportsPathJasper.'/transport_bills.pdf?j_username='.$usernameJasper.'&j_password='.$passwordJasper.'&id='.$transportBill['TransportBill']['id'];

                                                                ?>
                                                                <a href="<?php echo $link ?>" target="_blank" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                                                <?php    break;
                                                                ?>
                                                            <?php  }?>


                                                    </li>
                                                    <li class='delete-link' title='<?= __('Delete') ?>'>
                                                        <?php echo $this->Form->postLink(
                                                            '<i class=" fa fa-trash-o m-r-5"></i>',
                                                            array('action' => 'Delete', $type, $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-danger'),
                                                            __('Are you sure you want to delete %s?', $transportBill['TransportBill']['reference'])); ?>
                                                    </li>
                                                    <?php
                                                    break;
                                                case TransportBillTypesEnum::pre_invoice :
                                                    ?>
                                                    <li class='view-link' title='<?= __('View') ?>'>
                                                        <?php
                                                        echo $this->Html->link(
                                                            '<i class="  fa fa-eye m-r-5"></i>',
                                                            array('action' => 'view', $type, $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-success')); ?>
                                                    </li>

                                                    <li class='edit-link' title='<?= __('Edit') ?>'>
                                                        <?php
                                                        echo $this->Html->link(
                                                            '<i class="  fa fa-edit m-r-5"></i>',
                                                            array('action' => 'edit', $type, $transportBill['TransportBill']['id'],$this->request->params['controller'], base64_encode(serialize($_SERVER['REQUEST_URI']))),
                                                            array('escape' => false, 'class' => 'btn btn-primary')); ?>
                                                    </li>
                                                    <li class='edit-link' title='<?= __('Dissociate') ?>'>
                                                        <?php  echo $this->Html->link(
                                                            '<i class="fa  fa-unlink m-r-5"></i>',

                                                            array('action' => 'dissociate', $type,$transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-warning')
                                                        ); ?>
                                                    </li>
                                                    <li class='edit-link' title="<?= __('Print simplified bill') ?>">
                                                        <?php switch ($reportingChoosed) {
                                                            case 1: ?>
                                                                <?= $this->Html->link(
                                                                    '<i class="fa fa-print"></i>',
                                                                    array('action' => 'print_facture', 'ext' => 'pdf', $transportBill['TransportBill']['id'],$type),
                                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-inverse')
                                                                ); ?>

                                                                <?php
                                                                break;

                                                            case 2: ?>

                                                                <?php
                                                                break;
                                                            case 3:
                                                                $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                                $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                                $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                                                $link = $reportsPathJasper.'/transport_bills.pdf?j_username='.$usernameJasper.'&j_password='.$passwordJasper.'&id='.$transportBill['TransportBill']['id'];

                                                                ?>
                                                                <a href="<?php echo $link ?>" target="_blank" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                                                <?php    break;
                                                                ?>
                                                            <?php  }?>
                                                    </li>
                                                    <li class='edit-link' title="<?= __('Print detailed bill') ?>">
                                                        <?php switch ($reportingChoosed) {
                                                            case 1: ?>
                                                                <?= $this->Html->link(
                                                                    '<i class="fa fa-print"></i>',
                                                                    array('action' => 'print_detailed_facture', 'ext' => 'pdf', $transportBill['TransportBill']['id'],$type),
                                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-inverse')
                                                                ); ?>

                                                                <?php
                                                                break;

                                                            case 2: ?>

                                                                <?php
                                                                break;
                                                            case 3:
                                                                $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                                $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                                $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                                                $link = $reportsPathJasper.'/transport_bills.pdf?j_username='.$usernameJasper.'&j_password='.$passwordJasper.'&id='.$transportBill['TransportBill']['id'];

                                                                ?>
                                                                <a href="<?php echo $link ?>" target="_blank" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                                                <?php    break;
                                                                ?>
                                                            <?php  }?>
                                                    </li>

                                                    <li class='delete-link' title='<?= __('Delete') ?>'>
                                                        <?php
                                                        echo $this->Form->postLink(
                                                            '<i class="fa fa-trash-o m-r-5"></i>',
                                                            array('action' => 'Delete', $type, $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-danger'),
                                                            __('Are you sure you want to delete %s?', $transportBill['TransportBill']['reference'])); ?>
                                                    </li>
                                                    <?php
                                                    break;
                                                case TransportBillTypesEnum::invoice :
                                                    ?>
                                                    <li class='view-link' title='<?= __('View') ?>'>
                                                        <?php
                                                        echo $this->Html->link(
                                                            '<i class="  fa fa-eye m-r-5"></i>',
                                                            array('action' => 'view', $type, $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-success')); ?>
                                                    </li>
                                                    <li class='edit-link' title='<?= __('Edit') ?>'>
                                                        <?php
                                                        echo $this->Html->link(
                                                            '<i class="  fa fa-edit m-r-5"></i>',
                                                            array('action' => 'edit', $type, $transportBill['TransportBill']['id'],$this->request->params['controller'], base64_encode(serialize($_SERVER['REQUEST_URI']))),
                                                            array('escape' => false, 'class' => 'btn btn-primary')); ?>
                                                    </li>

                                                    <li class='edit-link' title="<?= __('Print simplified bill') ?>">
                                                        <?php switch ($reportingChoosed) {
                                                            case 1: ?>
                                                                <?= $this->Html->link(
                                                                    '<i class="fa fa-print"></i>',
                                                                    array('action' => 'print_facture', 'ext' => 'pdf', $transportBill['TransportBill']['id'],$type),
                                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-inverse')
                                                                ); ?>

                                                                <?php
                                                                break;

                                                            case 2: ?>

                                                                <?php
                                                                break;
                                                            case 3:
                                                                $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                                $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                                $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                                                $link = $reportsPathJasper.'/transport_bills.pdf?j_username='.$usernameJasper.'&j_password='.$passwordJasper.'&id='.$transportBill['TransportBill']['id'];

                                                                ?>
                                                                <a href="<?php echo $link ?>" target="_blank" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                                                <?php    break;
                                                                ?>
                                                            <?php  }?>
                                                    </li>
                                                    <li class='edit-link' title="<?= __('Print detailed bill') ?>">
                                                        <?php switch ($reportingChoosed) {
                                                            case 1: ?>
                                                                <?= $this->Html->link(
                                                                    '<i class="fa fa-print"></i>',
                                                                    array('action' => 'print_detailed_facture', 'ext' => 'pdf', $transportBill['TransportBill']['id'],$type),
                                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-inverse')
                                                                ); ?>

                                                                <?php
                                                                break;

                                                            case 2: ?>

                                                                <?php
                                                                break;
                                                            case 3:
                                                                $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                                $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                                $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                                                $link = $reportsPathJasper.'/transport_bills.pdf?j_username='.$usernameJasper.'&j_password='.$passwordJasper.'&id='.$transportBill['TransportBill']['id'];

                                                                ?>
                                                                <a href="<?php echo $link ?>" target="_blank" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                                                <?php    break;
                                                                ?>
                                                            <?php  }?>
                                                    </li>


                                                    <li class='delete-link' title='<?= __('Delete') ?>'>
                                                        <?php
                                                        echo $this->Form->postLink(
                                                            '<i class="fa fa-trash-o m-r-5"></i>',
                                                            array('action' => 'Delete', $type, $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-danger'),
                                                            __('Are you sure you want to delete %s?', $transportBill['TransportBill']['reference'])); ?>
                                                    </li>
                                                    <?php break;

                                                    ?>

                                                <?php
                                            } ?>
                                        </ul>
                                    </div>
                                </td>
                            <?php
                            } else {
                                switch ($type) {
                                    case TransportBillTypesEnum::quote_request:
                                        ?>
                                        <td class="actions transport-bil-actions">
                                            <div class="btn-group ">
                                                <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                                    <i class="fa fa-list fa-inverse"></i>
                                                </a>
                                                <button href="#" data-toggle="dropdown"
                                                        class="btn btn-info dropdown-toggle share">
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" style="min-width: 70px;">


                                                    <li class='view-link' title='<?= __('View') ?>'>
                                                        <?php
                                                        echo $this->Html->link(
                                                            '<i class="  fa fa-eye m-r-5"></i>',
                                                            array('action' => 'View', $type, $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-success')
                                                        );
                                                        ?>
                                                    </li>

                                                    <li class='edit-link' title='<?= __('Edit') ?>'>
                                                        <?php  echo $this->Html->link(
                                                            '<i class="fa fa-edit m-r-5"></i>',

                                                            array('action' => 'editRequestQuotation', $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-primary')
                                                        ); ?>
                                                    </li>

                                                    <li class='delete-link' title='<?= __('Delete') ?>'>
                                                        <?php   echo $this->Form->postLink(
                                                            '<i class="fa fa-trash-o m-r-5"></i>',
                                                            array('action' => 'Delete', $type, $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-danger'),
                                                            __('Are you sure you want to delete %s?', $transportBill['TransportBill']['reference'])); ?>
                                                    </li>


                                                </ul>
                                            </div>
                                        </td>
                                        <?php
                                        break;
                                    case TransportBillTypesEnum:: quote :
                                        break;
                                    case TransportBillTypesEnum::order:
                                        ?>
                                        <td class="actions transport-bil-actions">
                                            <div class="btn-group ">
                                                <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                                    <i class="fa fa-list fa-inverse"></i>
                                                </a>
                                                <button href="#" data-toggle="dropdown"
                                                        class="btn btn-info dropdown-toggle share">
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" style="min-width: 70px;">


                                                    <li class='view-link' title='<?= __('View') ?>'>
                                                        <?php
                                                        echo $this->Html->link(
                                                            '<i class="  fa fa-eye m-r-5"></i>',
                                                            array('action' => 'View', $type, $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-success')
                                                        );
                                                        ?>
                                                    </li>
                                                    <?php if ($transportBill['TransportBill']['status'] == TransportBillDetailRideStatusesEnum:: not_validated ||
                                                        $transportBill['TransportBill']['status'] == TransportBillDetailRideStatusesEnum:: not_transmitted
                                                    ) {
                                                        ?>
                                                        <li class='edit-link' title='<?= __('Edit') ?>'>
                                                            <?php  echo $this->Html->link(
                                                                '<i class="fa fa-edit m-r-5"></i>',

                                                                array('action' => 'edit', $transportBill['TransportBill']['type'], $transportBill['TransportBill']['id'],$this->request->params['controller'], base64_encode(serialize($_SERVER['REQUEST_URI']))),
                                                                array('escape' => false, 'class' => 'btn btn-primary')
                                                            ); ?>
                                                        </li>
                                                    <?php } ?>

                                                    <li class='delete-link' title='<?= __('Delete') ?>'>
                                                        <?php   echo $this->Form->postLink(
                                                            '<i class="fa fa-trash-o m-r-5"></i>',
                                                            array('action' => 'Delete', $type, $transportBill['TransportBill']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-danger'),
                                                            __('Are you sure you want to delete %s?', $transportBill['TransportBill']['reference'])); ?>
                                                    </li>


                                                </ul>
                                            </div>
                                        </td>
                                        <?php        break;
                                    case TransportBillTypesEnum::pre_invoice:
                                        break;
                                    case TransportBillTypesEnum::invoice :
                                        break;
                                }

                                ?>

                            <?php } ?>


                        </tr>
                    <?php endforeach; ?>
                    </tbody>


                </table>

                <div id="pagination">
                    <?php
                    if ($this->params['paging']['TransportBill']['pageCount'] > 1) {
                        ?>
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>    </p>
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php
                                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                echo $this->Paginator->numbers(array(
                                    'tag' => 'li',
                                    'first' => false,
                                    'last' => false,
                                    'separator' => '',
                                    'currentTag' => 'a'));
                                echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
                <br>
                <br>
                <br>

                <div id='rides' name="rides">

                </div>
                <br>
                <br>

                <div id='planifications' name="planifications">

                </div>
                <br>
                <br>

            </div>
        </div>
    </div>
</div>
<?php if (($type != 0) && ($profileId != ProfilesEnum::client)) { ?>
    <div class="card-box">
        <ul class="list-group m-b-15 user-list">
            <?php echo "<div class='total'><span class='col-lg-3 col-xs-6'><b>" . __('Total HT :  ') . '</b><span class="badge bg-red">' .
                number_format($totals['total_ht'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span>";
            echo "<span class='col-lg-3 col-xs-6'><b>" . __('Total TTC :  ') . '</b><span class="badge bg-red">' .
                number_format($totals['total_ttc'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span>";
            echo "<span class='col-lg-3 col-xs-6'><b>" . __('Total TVA :  ') . '</b><span class="badge bg-red">' .
                number_format($totals['total_tva'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div>"; ?>
        </ul>
    </div>
<?php } ?>
<?php $this->start('script'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
<?= $this->Html->script('plugins/datetimepicker/moment-with-locales.min.js'); ?>
<?= $this->Html->script('plugins/datetimepicker/bootstrap-datetimepicker.min.js'); ?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
<?= $this->Html->script('plugins/iCheck/icheck.min'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        setInterval(function() {
            jQuery('#nb_notification_div').load('<?php echo $this->Html->url('/notifications/getNbNotificationsByUser')?>', function() {
                var nbNotification = jQuery('#nb_notification').val();

                jQuery('#pulse-green').html('<span class="count-notif">'+nbNotification+'</span>');

            });

        }, 50000);

        jQuery("#date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#date2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        jQuery("#startdatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        jQuery("#startdatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        function toggleIcon(e) {
            $(e.target)
                .prev('.panel-heading')
                .find(".more-less")
                .toggleClass(' glyphicon-chevron-down  glyphicon-chevron-up');
        }

        $('.panel-group').on('hidden.bs.collapse', toggleIcon);
        $('.panel-group').on('shown.bs.collapse', toggleIcon);

        jQuery("#dialogModalConditionTransformation").dialog({
            autoOpen: false,
            height: 450,
            width: 450,
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
		
	 // Show the text box on click
        $('body').delegate('.editable', 'click', function () {

            var ThisElement = $(this);
            ThisElement.find('span').hide();
            ThisElement.find('.table-input').show().focus();
        });

        // Pass and save the textbox values on blur function
        $('body').delegate('.table-input', 'blur', function () {

            var ThisElement = $(this);
            if ($(this).val() == "") {
                ThisElement.val('');
            }else {
                ThisElement.hide();
            }
                ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());

            var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');
            jQuery.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url('/transportBills/update/')?>",
                data: UrlToPass,
                dataType: "json",
                success: function (json) {

                }
            });
        });

        // Same as the above blur() when user hits the 'Enter' key
        $('body').delegate('.table-input', 'keypress', function (e) {

            if (e.keyCode == '13') {
                var ThisElement = $(this);

                if ($(this).val() == "") {
                    ThisElement.val('');
                }else {
                    ThisElement.hide();
                }

                ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
                var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');

                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo $this->Html->url('/transportBills/update/')?>",
                    data: UrlToPass,
                    dataType: "json",
                    success: function (json) {

                    }
                });
            }
        });// Show the text box on click






        // Pass and save the textbox values on blur function
        $('body').delegate('.table-input1', 'change', function () {

            var ThisElement = $(this);
            ThisElement.find('.table-input1').show();

            var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');
            jQuery.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url('/transportBills/updateDeparture/')?>",
                data: UrlToPass,
                dataType: "json",
                success: function (json) {
                    ThisElement.find('span').hide();
                    ThisElement.find('.table-input1').show();
                }
            });
        });



        // Pass and save the textbox values on blur function
        $('body').delegate('.table-input2', 'change', function () {

            var ThisElement = $(this);
            ThisElement.find('.table-input2').show();

            var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');
            jQuery.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url('/transportBills/updateArrival/')?>",
                data: UrlToPass,
                dataType: "json",
                success: function (json) {

                }
            });
        });


        // Pass and save the textbox values on blur function
        $('body').delegate('.table-input3', 'change', function () {

            var ThisElement = $(this);
            ThisElement.find('.table-input3').show();

            var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');
            jQuery.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url('/transportBills/updateCarType/')?>",
                data: UrlToPass,
                dataType: "json",
                success: function (json) {

                }
            });
        });


		
    });
    function piece_pdf() {

        window.location = "<?php echo $this->Html->url('/transportBills/piece_pdf/'.$type.'/'.$transportBill['TransportBill']['id'])?>";

    }


    function transformFromQuotationRequestToOrder(type_transform) {
        var type_doc = jQuery('#type').val();
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        jQuery('#dialogModalConditionTransformation').dialog('option', 'title', 'Option de la transformation');
        jQuery('#dialogModalConditionTransformation').dialog('open');
        jQuery('#dialogModalConditionTransformation').load('<?php echo $this->Html->url('/transportBills/transformFromQuotationRequestToOrder/')?>' + myCheckboxes + '/' + type_transform + '/' + type_doc);

    }

    function transformPreinvoiceToInvoice(type_transform) {
        type_doc = jQuery('#type').val();
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        jQuery('#dialogModalConditionTransformation').dialog('option', 'title', 'Option de la transformation');
        jQuery('#dialogModalConditionTransformation').dialog('open');
        jQuery('#dialogModalConditionTransformation').load('<?php echo $this->Html->url('/transportBills/transformPreinvoiceToInvoice/')?>' + myCheckboxes + '/' + type_transform + '/' + type_doc);

    }

    function validateCustomerOrder() {

        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        var url = '<?php echo $this->Html->url('/transportBills/validateCustomerOrder')?>';
        var form = jQuery('<form action="' + url + '" method="post">' +
        '<input type="text" name="chkids" value="' + myCheckboxes + '" />' +
        '</form>');
        jQuery('body').append(form);
        form.submit();

    }

    function cancelCustomerOrder() {

        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        var url = '<?php echo $this->Html->url('/transportBills/cancelCustomerOrder')?>';
        var form = jQuery('<form action="' + url + '" method="post">' +
        '<input type="text" name="chkids" value="' + myCheckboxes + '" />' +
        '</form>');
        jQuery('body').append(form);
        form.submit();

    }

    function definePeriod(id) {
        switch (id) {
            case 'today':
                var now = new Date();
                var currentDate = getDay(now);

                jQuery("#date1").val(currentDate);
                jQuery("#date2").val(currentDate);
                break;
            case 'week':

                getWeek();

                break;
            case 'month':
                getMonth();
                break;
            case 'quarter':
                getQuarter();
                break;
            case 'semester':
                getSemester();
                break;
            case 'year':
                getYear();
                break;


        }
    }
    function getDay(now) {
        var day = now.getDate();
        day = parseInt(day);
        if (day >= 0 && day < 10) {
            day = '0' + day;
        }

        var month = now.getMonth();
        var year = now.getFullYear();
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
        var currentDate = day + "/" + valMonth + "/" + year;
        return currentDate;
    }
    function getWeek() {
        var d1 = new Date();
        numOfdaysPastSinceLastSaturday = eval(d1.getDay());
        d1.setDate(d1.getDate() - numOfdaysPastSinceLastSaturday);
        var rangeIsFrom = getDay(d1);
        jQuery("#date1").val(rangeIsFrom);
        d1.setDate(d1.getDate() + 6);
        var rangeIsTo = getDay(d1);
        jQuery("#date2").val(rangeIsTo);

    }
    function getMonth() {
        var now = new Date();
        var month = now.getMonth();
        switch (month) {
            case 0:
                var startDay = '01';
                var endDay = '31';
                break;
            case 1:
                var startDay = '01';
                var year = now.getFullYear();
                var endDay = new Date(year, 1, 1).getMonth() == new Date(year, 1, 29).getMonth() ? 29 : 28;
                break;
            case 2:
                var startDay = '01';
                var endDay = '31';
                break;
            case 3:
                var startDay = '01';
                var endDay = '30';
                break;
            case 4:
                var startDay = '01';
                var endDay = '31';
                break;
            case 5:
                var startDay = '01';
                var endDay = '30';
                break;
            case 6:
                var startDay = '01';
                var endDay = '31';
                break;
            case 7:
                var startDay = '01';
                var endDay = '31';
                break;
            case 8:
                var startDay = '01';
                var endDay = '30';
                break;
            case 9:
                var startDay = '01';
                var endDay = '31';
                break;
            case 10:
                var startDay = '01';
                var endDay = '30';
                break;
            case 11:
                var startDay = '01';
                var endDay = '31';
                break;
        }
        var startMonth = new Date();
        startMonth.setDate(startDay);
        var startDate = getDay(startMonth);
        jQuery("#date1").val(startDate);
        var endMonth = new Date();
        endMonth.setDate(endDay);
        var endDate = getDay(endMonth);
        jQuery("#date2").val(endDate);
    }
    function getQuarter() {
        var now = new Date();
        var month = now.getMonth();
        switch (month) {
            case 0:
                var startDay = '01';
                var startMonth = 0;
                var endDay = '31';
                var endMonth = 2;
                break;
            case 1:
                var startDay = '01';
                var startMonth = 0;
                var endDay = '31';
                var endMonth = 2;
                break;
            case 2:
                var startDay = '01';
                var startMonth = 0;
                var endDay = '31';
                var endMonth = 2;
                break;
            case 3:
                var startDay = '01';
                var startMonth = 3;
                var endDay = '30';
                var endMonth = 5;
                break;
            case 4:
                var startDay = '01';
                var startMonth = 3;
                var endDay = '30';
                var endMonth = 5;
                break;
            case 5:
                var startDay = '01';
                var startMonth = 3;
                var endDay = '30';
                var endMonth = 5;
                break;
            case 6:
                var startDay = '01';
                var startMonth = 6;
                var endDay = '30';
                var endMonth = 8;
                break;
            case 7:
                var startDay = '01';
                var startMonth = 6;
                var endDay = '30';
                var endMonth = 8;
                break;
            case 8:
                var startDay = '01';
                var startMonth = 6;
                var endDay = '30';
                var endMonth = 8;
                break;
            case 9:
                var startDay = '01';
                var startMonth = 9;
                var endDay = '31';
                var endMonth = 11;
                break;
            case 10:
                var startDay = '01';
                var startMonth = 9;
                var endDay = '31';
                var endMonth = 11;
                break;
            case 11:
                var startDay = '01';
                var startMonth = 9;
                var endDay = '31';
                var endMonth = 11;
                break;
        }
        var startQuarter = new Date();
        startQuarter.setMonth(startMonth);
        startQuarter.setDate(startDay);
        var startDate = getDay(startQuarter);
        jQuery("#date1").val(startDate);
        var endQuarter = new Date();
        endQuarter.setMonth(endMonth);
        endQuarter.setDate(endDay);
        var endDate = getDay(endQuarter);
        jQuery("#date2").val(endDate);
    }
    function getSemester() {
        var now = new Date();
        var month = now.getMonth();
        switch (month) {
            case 0:
                var startDay = '01';
                var startMonth = 0;
                var endDay = '30';
                var endMonth = 5;
                break;
            case 1:
                var startDay = '01';
                var startMonth = 0;
                var endDay = '30';
                var endMonth = 5;
                break;
            case 2:
                var startDay = '01';
                var startMonth = 0;
                var endDay = '30';
                var endMonth = 5;
                break;
            case 3:
                var startDay = '01';
                var startMonth = 0;
                var endDay = '30';
                var endMonth = 5;
                break;
            case 4:
                var startDay = '01';
                var startMonth = 0;
                var endDay = '30';
                var endMonth = 5;
                break;
            case 5:
                var startDay = '01';
                var startMonth = 0;
                var endDay = '30';
                var endMonth = 5;
                break;
            case 6:
                var startDay = '01';
                var startMonth = 6;
                var endDay = '31';
                var endMonth = 11;
                break;
            case 7:
                var startDay = '01';
                var startMonth = 6;
                var endDay = '31';
                var endMonth = 11;
                break;
            case 8:
                var startDay = '01';
                var startMonth = 6;
                var endDay = '31';
                var endMonth = 11;
                break;
            case 9:
                var startDay = '01';
                var startMonth = 6;
                var endDay = '31';
                var endMonth = 11;
                break;
            case 10:
                var startDay = '01';
                var startMonth = 6;
                var endDay = '31';
                var endMonth = 11;
                break;
            case 11:
                var startDay = '01';
                var startMonth = 6;
                var endDay = '31';
                var endMonth = 11;
                break;
        }
        var startSemester = new Date();
        startSemester.setMonth(startMonth);
        startSemester.setDate(startDay);
        var startDate = getDay(startSemester);
        jQuery("#date1").val(startDate);
        var endSemester = new Date();
        endSemester.setMonth(endMonth);
        endSemester.setDate(endDay);
        var endDate = getDay(endSemester);
        jQuery("#date2").val(endDate);
    }
    function getYear() {

        var startDay = '01';
        var startMonth = 0;
        var endDay = '31';
        var endMonth = 11;
        var startYear = new Date();
        startYear.setMonth(startMonth);
        startYear.setDate(startDay);
        var startDate = getDay(startYear);
        jQuery("#date1").val(startDate);
        var endYear = new Date();
        endYear.setMonth(endMonth);
        endYear.setDate(endDay);
        var endDate = getDay(endYear);
        jQuery("#date2").val(endDate);

    }

    function printSimplifiedJournal() {
        var conditions = new Array();
        conditions[0] = jQuery('#supplier').val();
        conditions[1] = jQuery('#date1').val();
        conditions[2] = jQuery('#date2').val();
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        var type = jQuery("#type").val();
        var url = '<?php echo $this->Html->url(array('action' => 'printSimplifiedJournal', 'ext' => 'pdf'),
         array('target' => '_blank' ))?>';
        var form = jQuery('<form action="' + url + '" method="post" target="_Blank" >' +
        '<input type="hidden" name="printSimplifiedJournal" value="' + conditions + '" />' +
        '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
        '<input type="hidden" name="typePiece" value="' + type + '" />' +
        '</form>');
        jQuery('body').append(form);
        form.submit();
    }

    function printDetailedJournal() {
        var conditions = new Array();
        conditions[0] = jQuery('#supplier').val();
        conditions[1] = jQuery('#date1').val();
        conditions[2] = jQuery('#date2').val();
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        var type = jQuery("#type").val();
        var url = '<?php echo $this->Html->url(array('action' => 'printDetailedJournal', 'ext' => 'pdf'), array('target' => '_blank' ))?>';
        var form = jQuery('<form action="' + url + '" method="post"  target="_Blank" >' +
        '<input type="hidden" name="printDetailedJournal" value="' + conditions + '" />' +
        '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
        '<input type="hidden" name="typePiece" value="' + type + '" />' +
        '</form>');
        jQuery('body').append(form);
        form.submit();
    }
    function printDetailedJournalPerMission() {
        var conditions = new Array();
        conditions[0] = jQuery('#supplier').val();
        conditions[1] = jQuery('#date1').val();
        conditions[2] = jQuery('#date2').val();
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        var type = jQuery("#type").val();
        var url = '<?php echo $this->Html->url(array('action' => 'printDetailedJournalPerMission', 'ext' => 'pdf'), array('target' => '_blank' ))?>';
        var form = jQuery('<form action="' + url + '" method="post"  target="_Blank" >' +
        '<input type="hidden" name="printDetailedJournalPerMission" value="' + conditions + '" />' +
        '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
        '<input type="hidden" name="typePiece" value="' + type + '" />' +
        '</form>');
        jQuery('body').append(form);
        form.submit();
    }

    function viewDetail(id, type) {
        $("html").css("cursor", "pointer");
        scrollToAnchor('rides');
        jQuery('tr').removeClass('btn-info  btn-trans');
        jQuery('#row' + id).addClass('btn-info  btn-trans');
        jQuery('#planifications').html("<div></div>");
        jQuery('#rides').load('<?php echo $this->Html->url('/transportBills/viewDetail/')?>' + id + '/' + type, function () {
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
            $('.select-search').select2();
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
            $('.approve').iCheck({
                checkboxClass: 'icheckbox_flat-red',
                radioClass: 'iradio_flat-red'
            });

            //Enable check and uncheck all functionality
            $(".approvAll").click(function () {

                var clicks = $(this).data('clicks');
                if (clicks) {
                    //Uncheck all checkboxes
                    $(".approve").iCheck("uncheck");
                    $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                } else {
                    //Check all checkboxes
                    $(".approve").iCheck("check");
                    $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

                }
                $(this).data("clicks", !clicks);
            });

        });
    }

    function viewDetailCustomerOrder(id, nbTrucks, transportBillDetailRides) {

        $("html").css("cursor", "pointer");
        scrollToAnchor('planifications');
        jQuery('tr').removeClass('btn-info  btn-trans');
        jQuery('#row' + id).addClass('btn-info  btn-trans');
        jQuery('#planifications').load('<?php echo $this->Html->url('/transportBills/viewDetailCustomerOrder/')?>' + id + '/' + nbTrucks + '/' + transportBillDetailRides, function () {
        });
    }
    function approveMissions() {

       var nbMission = jQuery('.nbMission').val();
        var missionIds = new Array();
        for(var i = 1; i <= parseInt(nbMission); i++) {
            missionIds.push(jQuery('#missionId' + '' + i + '').val());
        }

        var approvedMissions = new Array();
        jQuery('.approve:checked').each(function() {
        approvedMissions.push(jQuery(this).val());
            });

        jQuery.ajax({
            type: "POST",
            url: "<?php echo $this->Html->url('/transportBills/approveMissions/')?>",
            dataType: "json",
            data: {missionIds: JSON.stringify(missionIds), approvedMissions: JSON.stringify(approvedMissions)},
            success: function (json) {

                if (json.response == "true") {
                    $("#msg").html('<div id="flashMessage" class="message"><div class="alert alert-success alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?php echo __('Missions has been approved'); ?></div></div>');

                    scrollToAnchor('container-fluid');
                }
            }
        });
    }



</script>
<?php $this->end(); ?>
