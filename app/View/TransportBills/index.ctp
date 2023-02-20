<style>
    .actions-th {
        width: 100px;
    }
    .btn-period {
        display: block;
    }
    .label-period {
        width: 52px !important;
    }
    .form-date div.input {
        width : 300px;
    }
    .form-date .input-group{
        width : 85% !important;
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
echo $this->Html->css('jquery-ui');
$this->end(); ?>

<div id="msg" name="msg"></div>
<?php
switch ($type) {
    case TransportBillTypesEnum::quote_request :
        ?><h4 class="page-title"> <?= __('Request quotation'); ?></h4>
        <?php break;
    case TransportBillTypesEnum::quote :
        ?><h4 class="page-title"> <?= __('Quotation'); ?></h4>
        <?php break;
    case TransportBillTypesEnum::order :
        ?><h4 class="page-title"> <?= __("Customer orders"); ?></h4>
        <?php break;
    case TransportBillTypesEnum::sheet_ride :
        ?><h4 class="page-title"> <?= __("Sheet ride"); ?></h4>
        <?php break;
    case TransportBillTypesEnum::pre_invoice :
        ?><h4 class="page-title"> <?= __("Preinvoices"); ?></h4>
        <?php break;
    case TransportBillTypesEnum::invoice :
        ?><h4 class="page-title"> <?= __("Invoices"); ?></h4>
        <?php break;
    case TransportBillTypesEnum::credit_note :
        ?><h4 class="page-title"> <?= __("Sale credit notes"); ?></h4>
        <?php break;
}


$query = $this->Session->read('query');
extract($query);

$tableId = strtolower($tableName) . '-grid';

$countColumns = count($columns);

?>


<div class="box-body">
    <div class="panel-group wrap" id="bs-collapse">
        <div class="panel loop-panel">
            <a class="collapsed fltr" data-toggle="collapse" data-parent="#" href="#one">
                <i class="zmdi zmdi-search-in-page"></i>
            </a>

            <div id="one" class="panel-collapse collapse">
                <div class="panel-body">
                    <?php echo $this->Form->create('transportBills', array(
                        'url' => array(
                            'action' => 'index', $this->params['pass']['0']
                        ),
                        'novalidate' => true
                    )); ?>

                    <div class="filters" id='filters'>
                        <?php
                        if ($this->params['pass']['0'] == 0) {
                            echo $this->Form->input('ride_id', array(
                                'label' => __('Ride'),
                                'id' => 'ride',
                                'class' => 'form-filter',
                                'empty' => ''
                            ));
                            echo $this->Form->input('car_type_id', array(
                                'label' => __('Transportation'),
                                'class' => 'form-filter select3',
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
                                'class' => 'form-filter select2',
                                'id' => 'supplier-filter',
                                'empty' => ''
                            ));

                            echo "<span id='service-div'>". $this->Form->input('service_id', array(
                                'label' => __('Service'),
                                'class' => 'form-filter select3',
                                'id' => 'service',
                                'empty' => ''
                            )). "</span>";
                        }

                        echo $this->Form->input('type', array(
                            'label' => __('Type'),
                            'class' => 'form-filter',
                            'id' => 'type',
                            'type' => 'hidden',
                            'value' => $this->params['pass']['0'],
                            'empty' => ''
                        ));


                        echo "<div style='clear:both; padding-top: 10px;'></div>";


                        switch ($type){
                            case TransportBillTypesEnum::quote_request:
                            case TransportBillTypesEnum::quote:
                                $options = array(
                                    '1' => __('Not transformed'),
                                    '2' => __('Transformed')
                                );
                                break;
                            case TransportBillTypesEnum::order:
                                $options = array(
                                    '1' => __('Not validated'),
                                    '2' => __('Partially validated'),
                                    '3' => __('Validated'),
                                    '8' => __('Not transmitted'),
                                    '9' => __('Canceled'),
                                );
                                break;
                            case TransportBillTypesEnum::pre_invoice:
                            case TransportBillTypesEnum::invoice:
                            case TransportBillTypesEnum::credit_note:
                                $options = array(
                                    '1' => __('Not paid'),
                                    '2' => __('Paid'),
                                    '3' => __('Partially paid'),
                                );
                                break;
                        }


                        echo "<span >". $this->Form->input('status_id', array(
                                'label' => __('Status'),
                                'class' => 'form-filter select2',
                                'options'=>$options,
                                'id' => 'status',
                                'empty' => ''
                            )). "</span>";

                        $options = array('1'=>__('Order with invoice'), '2'=>__('Order payment cash'));
                        echo $this->Form->input('order_type', array(
                            'label' => __('Order type'),
                            'class' => 'form-filter select2',
                            'options' => $options,
                            'id' => 'order_type',
                            'empty' => ''
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        ?>

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

                        <?php echo "<div class='form-date'>" .$this->Form->input('date1', array(
                                'label' => '',
                                'type' => 'text',
                                'class' => 'form-control datemask ',
                                'before' => '<div class="input-group date from_date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                'after' => '</div>',
                                'id' => 'date1',
                            )). "</div>";
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

                                echo "<div style='clear:both; padding-top: 10px;'></div>";
                                echo $this->Form->input('user_id', array(
                                    'label' => __('Created by'),
                                    'class' => 'form-filter select3',
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
                                    'class' => 'form-filter select3',
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
                                                    )) ?>
                                            <button type="button" id="export_allmark"
                                                    class="btn dropdown-toggle btn-inverse  btn-bordred"
                                                    data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>


                                                    <?= $this->Html->link(__('Quotation'), 'javascript:transformFromQuotationRequestToOrder(1);',
                                                        array('escape' => false, 'id' => 'commande', 'class' => 'btn btn-act ')) ?>

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
                                                    )) ?>
                                            <button type="button" id="export_allmark"
                                                    class="btn dropdown-toggle btn-inverse  btn-bordred"
                                                    data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <?= $this->Html->link(__('Customer order'), 'javascript:transformFromQuotationRequestToOrder(2);',
                                                        array('escape' => false, 'id' => 'commande', 'class' => 'btn btn-act ')) ?>
													<?= $this->Html->link(__('Invoice'), 'javascript:transformFromQuotationRequestToOrder(7);',
                                                        array('escape' => false, 'id' => 'facture', 'class' => 'btn btn-act ')) ?>

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
                                        
										
										<?php break;
                                    }

                                    case TransportBillTypesEnum::order :
                                        echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                            array('action' => 'Add', $type),
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));

                                        if ($permissionOrder == 1) {
                                            echo $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transmit'),
                                                'javascript:validateCustomerOrder("TransportBill");',
                                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'validate'));
                                            ?>
                                            <div class="btn-group">
                                            <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transform to'),
                                                'javascript:',
                                                array('escape' => false,
                                                    'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',
                                                    'id' => 'transform',
                                                    )) ?>
                                <button type="button" id="export_allmark"
                                        class="btn dropdown-toggle btn-inverse  btn-bordred"
                                        data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>

                                        <?= $this->Html->link(__('Invoice'), 'javascript:transformFromOrderToInvoice(7);',
                                            array('escape' => false, 'id' => 'facture', 'class' => 'btn btn-act ')) ?>

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

                                        <?php   }
                                        if ($permissionCancel == 1) { ?>
                                               <div class="btn-group">
                                    <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Cancel'),
                                        'javascript:;',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                                    <button type="button" id="export_allmark"
                                            class="btn dropdown-toggle btn-inverse  btn-bordred" data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <?= $this->Html->link( __('Cancel'),
                                                'javascript:cancelCustomerOrders("TransportBill");',
                                                array(  'id' => 'cancel')); ?>
                                        </li>
                                        <li>
                                            <?= $this->Html->link(__('Remove cancellation'), 'javascript:removeCancellation("TransportBill");') ?>
                                        </li>


                                    </ul>
                                </div>

                                     <?php   }

                                         break;
                                    case TransportBillTypesEnum::sheet_ride :
                                        echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                            array('action' => 'Add', $type),
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));
                                        break;
                                    case TransportBillTypesEnum::pre_invoice : ?>
                                        <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add from missions'),
                                        array('controller' => 'transportBills', 'action' => 'AddFromSheetRide',$type),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                                        <div class="btn-group">
                                            <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transform to'),
                                                'javascript:',
                                                array('escape' => false,
                                                    'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',
                                                    'id' => 'transform'
                                                    )) ?>
                                            <button type="button" id="export_allmark"
                                                    class="btn dropdown-toggle btn-inverse  btn-bordred"
                                                    data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <?= $this->Html->link(__('Invoice'), 'javascript:transformPreinvoiceToInvoice(7);',
                                                        array('escape' => false, 'id' => 'commande', 'class' => 'btn btn-act ')) ?>
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
                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Regulation'),
                                            'javascript:verifyIdCustomers("4","addPayment", '."'$tableId'".','.$countColumns.');',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',  'id' => 'payment'));
                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Advanced payment'),
                                            'javascript:verifyIdCustomers("4","advancedPayment", '."'$tableId'".','.$countColumns.');',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'advanced_payment'));
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
                                        <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add from missions'),
                                        array('controller' => 'transportBills', 'action' => 'AddFromSheetRide',$type),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                                        <?php if ($hasTreasuryModule == 1 && $permissionPayment==1) {
                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Regulation'),
                                            'javascript:verifyIdCustomers("4","addPayment", '."'$tableId'".','.$countColumns.');',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',  'id' => 'payment'));
                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Advanced payment'),
                                            'javascript:verifyIdCustomers("4","advancedPayment", '."'$tableId'".','.$countColumns.');',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',  'id' => 'advanced_payment'));
                                    }
                                        break;

                                    case TransportBillTypesEnum::credit_note :
                                        ?>
                                        <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                        array('action' => 'add', $type),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')); ?>
                                        <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add from missions invoiced'),

                                        array('controller' => 'transportBills', 'action' => 'addFromMissionsInvoiced'),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>

                                        <?php if ($hasTreasuryModule == 1 && $permissionPayment==1) {
                                        echo $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Regulation'),
                                            'javascript:verifyIdCustomers("12","addPayment", '."'$tableId'".','.$countColumns.');',
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',  'id' => 'payment'));

                                    }

                                        break;

                                }
                                ?>
                                <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                    'javascript:;',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete')); ?>

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
                                        <li>
                                            <?= $this->Html->link(__('Simplified journal per client'), 'javascript:printJournalPerClient();') ?>
                                        </li>
                                    </ul>
                                </div>

                                <div id="dialogModalConditionTransformation">
                                    <!-- the external content is loaded inside this tag -->

                                </div>


                                <div id="dialogModalAdvencedPayments">
                                    <!-- the external content is loaded inside this tag -->

                                </div>

                                <div id="dialogModalCancelCauses">
                                    <!-- the external content is loaded inside this tag -->

                                </div>
                                <div id="dialogModalComplaints">
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
                                                    )) ?>
                                            <button type="button" id="export_allmark"
                                                    class="btn dropdown-toggle btn-inverse  btn-bordred"
                                                    data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <?= $this->Html->link(__('Quotation'), 'javascript:transformFromQuotationRequestToOrder(1);',
                                                        array('escape' => false, 'id' => 'commande', 'class' => 'btn btn-act ')) ?>
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
                                        'javascript:;',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete')); ?>

                                        <?php break;
                                    case TransportBillTypesEnum::quote :
                                        if ($permissionQuote == 1) { ?>
                                            <div class="btn-group">
                                                <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transform to'),
                                                    'javascript:',
                                                    array('escape' => false,
                                                        'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',
                                                        'id' => 'transform')) ?>
                                                <button type="button" id="export_allmark"
                                                        class="btn dropdown-toggle btn-inverse  btn-bordred"
                                                        data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <?= $this->Html->link(__('Customer order'), 'javascript:transformFromQuotationRequestToOrder(2);',
                                                            array('escape' => false, 'id' => 'commande', 'class' => 'btn btn-act ')) ?>

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
                                        } ?>
                                        <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                        'javascript:;',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete')); ?>
                                     <?php   break; ?>

                                 <?php   case TransportBillTypesEnum::order :
                                        echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                            array('action' => 'Add', $type),
                                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));
                                        if ($permissionCancel == 1) {
                                            echo $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Cancel'),
                                                'javascript:cancelCustomerOrders("TransportBill");',
                                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'cancel'));

                                        } ?>
                                        <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                        'javascript:;',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete')); ?>
                                        <?php break;

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
                                <div id="dialogModalCancelCauses">
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

</div>

<?php


/** @var array $columns */
/** @var string $tableName */
?>

<!--    Content section    -->
<?= $this->element('index-body-content', array(
    "tableId" => $tableId,
    "tableName" => $tableName,
    "columns" => $columns,
));
?>
<!--    End content section    -->

<?= $this->element('data-tables-script', array(
    "tableId" => $tableId,
    "tableName" => $tableName,
    "columns" => $columns,
    "defaultLimit" => $defaultLimit,
    "type" => $this->params['pass']['0'],
));
?>
<!--    End dataTables Script    -->

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



<?php if (($type != 0) && ($profileId != ProfilesEnum::client)) { ?>
    <div class="card-box" >
        <ul class="list-group m-b-15 user-list">
            <?php echo "<div class='total'><span class='col-lg-3 col-xs-6'><b>" . __('Total HT :  ') . '</b><span class="badge bg-red"><span id ="total_ht">' . " </span>" ." ". $this->Session->read("currency") . "</span> </span>";
            echo "<span class='col-lg-3 col-xs-6'><b>" . __('Total TTC :  ') . '</b><span class="badge bg-red"><span id ="total_ttc">' . " </span>" ." ". $this->Session->read("currency") . "</span> </span>";
            echo "<span class='col-lg-3 col-xs-6'><b>" . __('Total TVA :  ') . '</b><span class="badge bg-red"><span id ="total_tva">' . " </span>" . " ".$this->Session->read("currency") . "</span> </span></div>"; ?>
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


        setInterval(function () {
            jQuery('#nb_notification_div').load('<?php echo $this->Html->url('/notifications/getNbNotificationsByUser')?>', function () {
                var nbNotification = jQuery('#nb_notification').val();

                jQuery('#pulse-green').html('<span class="count-notif">' + nbNotification + '</span>');

            });

        }, 50000);
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
            } else {
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
                } else {
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




        jQuery('#supplier-filter').change(function () {

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

        jQuery("#dialogModalCancelCauses").dialog({
            autoOpen: false,
            height: 350,
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


        jQuery("#dialogModalComplaints").dialog({
            autoOpen: false,
            height: 600,
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

        jQuery("#date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#date2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        jQuery("#startdatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        jQuery("#startdatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

    });


    function cancelCustomerOrders(model) {


        if(model=='Observation'){
            var myCheckboxes = new Array();
            jQuery('.id:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
        }else {
            var dataTable = jQuery('#<?= $tableId ?>').DataTable();
            var myCheckboxes = new Array();
            jQuery.each(dataTable.rows('.selected').data(), function (key, item) {
                myCheckboxes.push(item[<?= count($columns) + 1 ?>]);
            });
        }

        if(myCheckboxes.length>0){
            jQuery('#dialogModalCancelCauses').dialog('option', 'title', "<?php echo __("Cancel causes") ?>");
            jQuery('#dialogModalCancelCauses').dialog('open');
            jQuery('#dialogModalCancelCauses').load('<?php echo $this->Html->url('/transportBills/cancelCustomerOrders/')?>' + myCheckboxes +'/'+model);

        }
        }


    function addComplaint() {

        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        if(myCheckboxes.length>0) {
            jQuery('#dialogModalComplaints').dialog('option', 'title', "<?php echo __("Complaints") ?>");
            jQuery('#dialogModalComplaints').dialog('open');
            jQuery('#dialogModalComplaints').load('<?php echo $this->Html->url('/transportBills/addComplaint/')?>' + myCheckboxes );

        }
    }

        function removeCancellation(model) {

        if(model=='Observation'){
            var myCheckboxes = new Array();
            jQuery('.id:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
        }else {
            var dataTable = jQuery('#<?= $tableId ?>').DataTable();
            var myCheckboxes = new Array();
            jQuery.each(dataTable.rows('.selected').data(), function (key, item) {
                myCheckboxes.push(item[<?= count($columns) + 1 ?>]);
            });
        }

            if(myCheckboxes.length>0) {
                var url = '<?php echo $this->Html->url('/transportBills/removeCancellation')?>';
                var form = jQuery('<form action="' + url + '" method="post">' +
                    '<input type="text" name="chkids" value="' + myCheckboxes + '" />' +
                    '<input type="text" name="model" value="' + model + '" />' +
                    '</form>');
                jQuery('body').append(form);
                form.submit();
            }
        }

    function transformFromQuotationRequestToOrder(type_transform) {
        var type_doc = jQuery('#type').val();
        var dataTable = jQuery('#<?= $tableId ?>').DataTable();
        var myCheckboxes = new Array();
        jQuery.each(dataTable.rows('.selected').data(), function (key, item) {
            myCheckboxes.push(item[<?= count($columns) + 1 ?>]);
        });
        if(myCheckboxes.length>0) {
            jQuery('#dialogModalConditionTransformation').dialog('option', 'title', 'Option de la transformation');
            jQuery('#dialogModalConditionTransformation').dialog('open');
            jQuery('#dialogModalConditionTransformation').load('<?php echo $this->Html->url('/transportBills/transformFromQuotationRequestToOrder/')?>' + myCheckboxes + '/' + type_transform + '/' + type_doc);
        }
    }

    function transformFromOrderToInvoice(type_transform) {
        var type_doc = jQuery('#type').val();
        var dataTable = jQuery('#<?= $tableId ?>').DataTable();
        var myCheckboxes = new Array();
        jQuery.each(dataTable.rows('.selected').data(), function (key, item) {
            myCheckboxes.push(item[<?= count($columns) + 1 ?>]);
        });
        if(myCheckboxes.length>0) {
            jQuery('#dialogModalConditionTransformation').dialog('option', 'title', 'Option de la transformation');
            jQuery('#dialogModalConditionTransformation').dialog('open');
            jQuery('#dialogModalConditionTransformation').load('<?php echo $this->Html->url('/transportBills/transformFromOrderToInvoice/')?>' + myCheckboxes + '/' + type_transform + '/' + type_doc);
        }
    }

    function transformPreinvoiceToInvoice(type_transform) {
        var type_doc = jQuery('#type').val();
        var dataTable = jQuery('#<?= $tableId ?>').DataTable();
        var myCheckboxes = new Array();
        jQuery.each(dataTable.rows('.selected').data(), function (key, item) {
            myCheckboxes.push(item[<?= count($columns) + 1 ?>]);
        });
        if(myCheckboxes.length>0) {
            jQuery('#dialogModalConditionTransformation').dialog('option', 'title', 'Option de la transformation');
            jQuery('#dialogModalConditionTransformation').dialog('open');
            jQuery('#dialogModalConditionTransformation').load('<?php echo $this->Html->url('/transportBills/transformPreinvoiceToInvoice/')?>' + myCheckboxes + '/' + type_transform + '/' + type_doc);
        }
    }

    function validateCustomerOrder(model) {
        if(model=='Observation'){
            var myCheckboxes = new Array();
            jQuery('.id:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
        }else {
            var dataTable = jQuery('#<?= $tableId ?>').DataTable();
            var myCheckboxes = new Array();
            jQuery.each(dataTable.rows('.selected').data(), function (key, item) {
                myCheckboxes.push(item[<?= count($columns) + 1 ?>]);
            });
        }

        if(myCheckboxes.length>0) {
            var url = '<?php echo $this->Html->url('/transportBills/validateCustomerOrder')?>';
            var form = jQuery('<form action="' + url + '" method="post">' +
                '<input type="text" name="chkids" value="' + myCheckboxes + '" />' +
                '<input type="text" name="model" value="' + model + '" />' +
                '</form>');
            jQuery('body').append(form);
            form.submit();
        }

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
        var numOfdaysPastSinceLastSaturday = eval(d1.getDay());
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
        var dataTable = jQuery('#<?= $tableId ?>').DataTable();
        var myCheckboxes = new Array();
        jQuery.each(dataTable.rows('.selected').data(), function (key, item) {
            myCheckboxes.push(item[<?= count($columns) + 1 ?>]);
        });
        if(myCheckboxes.length>0) {
            var type = jQuery("#type").val();
            var url = '<?php echo $this->Html->url(array('action' => 'printSimplifiedJournal', 'ext' => 'pdf'),
                array('target' => '_blank'))?>';
            var form = jQuery('<form action="' + url + '" method="post" target="_Blank" >' +
                '<input type="hidden" name="printSimplifiedJournal" value="' + conditions + '" />' +
                '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
                '<input type="hidden" name="typePiece" value="' + type + '" />' +
                '</form>');
            jQuery('body').append(form);
            form.submit();
        }else {
            alert("<?php echo __('Select lines to print, please.') ?>");
        }
    }


    function printDetailedJournal() {
        var conditions = new Array();
        conditions[0] = jQuery('#supplier').val();
        conditions[1] = jQuery('#date1').val();
        conditions[2] = jQuery('#date2').val();
        var dataTable = jQuery('#<?= $tableId ?>').DataTable();
        var myCheckboxes = new Array();
        jQuery.each(dataTable.rows('.selected').data(), function (key, item) {
            myCheckboxes.push(item[<?= count($columns) + 1 ?>]);
        });
        if(myCheckboxes.length>0) {
            var type = jQuery("#type").val();
            var url = '<?php echo $this->Html->url(array('action' => 'printDetailedJournal', 'ext' => 'pdf'), array('target' => '_blank'))?>';
            var form = jQuery('<form action="' + url + '" method="post"  target="_Blank" >' +
                '<input type="hidden" name="printDetailedJournal" value="' + conditions + '" />' +
                '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
                '<input type="hidden" name="typePiece" value="' + type + '" />' +
                '</form>');
            jQuery('body').append(form);
            form.submit();
        }
    }

    function printDetailedJournalPerMission() {
        var conditions = new Array();
        conditions[0] = jQuery('#supplier').val();
        conditions[1] = jQuery('#date1').val();
        conditions[2] = jQuery('#date2').val();
        var dataTable = jQuery('#<?= $tableId ?>').DataTable();
        var myCheckboxes = new Array();
        jQuery.each(dataTable.rows('.selected').data(), function (key, item) {
            myCheckboxes.push(item[<?= count($columns) + 1 ?>]);
        });
        if(myCheckboxes.length>0) {
            var type = jQuery("#type").val();
            var url = '<?php echo $this->Html->url(array('action' => 'printDetailedJournalPerMission', 'ext' => 'pdf'), array('target' => '_blank'))?>';
            var form = jQuery('<form action="' + url + '" method="post"  target="_Blank" >' +
                '<input type="hidden" name="printDetailedJournalPerMission" value="' + conditions + '" />' +
                '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
                '<input type="hidden" name="typePiece" value="' + type + '" />' +
                '</form>');
            jQuery('body').append(form);
            form.submit();
        }
    }
    function printJournalPerClient() {
        var conditions = new Array();
        conditions[0] = jQuery('#supplier').val();
        conditions[1] = jQuery('#date1').val();
        conditions[2] = jQuery('#date2').val();
        var dataTable = jQuery('#<?= $tableId ?>').DataTable();
        var myCheckboxes = new Array();
        jQuery.each(dataTable.rows('.selected').data(), function (key, item) {
            myCheckboxes.push(item[<?= count($columns) + 1 ?>]);
        });
        if(myCheckboxes.length>0) {
            var type = jQuery("#type").val();
            var url = '<?php echo $this->Html->url(array('action' => 'printTransportBillsJournalPerClient', 'ext' => 'pdf'), array('target' => '_blank'))?>';
            var form = jQuery('<form action="' + url + '" method="post"  target="_Blank" >' +
                '<input type="hidden" name="printJournalPerClient" value="' + conditions + '" />' +
                '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
                '<input type="hidden" name="typePiece" value="' + type + '" />' +
                '</form>');
            jQuery('body').append(form);
            form.submit();
        }
    }

    function viewDetail(id, type) {
        $("html").css("cursor", "pointer");
        scrollToAnchor('rides');
        jQuery('tr').removeClass('btn-info  btn-trans');
        jQuery('#row' + id).addClass('btn-info  btn-trans');
        jQuery('#planifications').html("<div></div>");
        jQuery('#rides').load('<?php echo $this->Html->url('/transportBills/viewDetail/')?>' + id + '/' + type, function () {
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
                    jQuery("#cancel_observation").attr("disabled", "true");
                    $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                } else {
                    //Check all checkboxes
                    $(".approve").iCheck("check");
                    jQuery("#cancel_observation").removeAttr("disabled");
                    $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

                }
                $(this).data("clicks", !clicks);
            });
            $('#table-detail').on('ifChecked', 'input', function()
            {

                jQuery("#cancel_observation").removeAttr("disabled");

            });

            $('#table-detail').on('ifUnchecked', 'input', function()
            {

                var ischecked = false;
                jQuery(":checkbox.id").each(function () {
                    if (jQuery(this).prop('checked'))
                        ischecked = true;
                });
                if(!ischecked){

                    jQuery("#cancel_observation").attr("disabled", "true");
                }
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
                    jQuery("#cancel_observation").attr("disabled", "true");
                    $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                } else {
                    //Check all checkboxes
                    $(".approve").iCheck("check");
                    jQuery("#cancel_observation").removeAttr("disabled");
                    $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');

                }
                $(this).data("clicks", !clicks);
            });

            $('#table-detail').on('ifChecked', 'input', function()
            {

                jQuery("#cancel_observation").removeAttr("disabled");

            });

            $('#table-detail').on('ifUnchecked', 'input', function()
            {

                var ischecked = false;
                jQuery(":checkbox.id").each(function () {
                    if (jQuery(this).prop('checked'))
                        ischecked = true;
                });
                if(!ischecked){

                    jQuery("#cancel_observation").attr("disabled", "true");
                }
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

        var transportBillId = jQuery('#transport_bill_id').val();
        var approvedMissions = new Array();
        jQuery('.approve:checked').each(function () {
            approvedMissions.push(jQuery(this).val());
        });

        jQuery.ajax({
            type: "POST",
            url: "<?php echo $this->Html->url('/transportBills/approveMissions/')?>",
            dataType: "json",
            data: { approvedMissions: JSON.stringify(approvedMissions), transportBillId : transportBillId},
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
