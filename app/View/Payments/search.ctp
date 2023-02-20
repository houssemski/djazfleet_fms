<style>
    .table-input3, .table-input4, .table-input5, .table-input6 {
        max-width: 90px;
    }
    .form-inline .form-control {
        background-color: transparent;     border: none;
    }
</style>

<?php

App::import('Model', 'Payment');
$this->Payment = new Payment();
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->Html->css('select2/select2.min');
$this->end();

?><h4 class="page-title"> <?= __('Search'); ?></h4>


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

<?php if (isset($_GET['page'])) { ?>
    <?= $this->Form->input('page', array(
        'id' => 'page',
        'value' =>  $_GET['page'],
        'type' => 'hidden'
    )); ?>
<?php } else { ?>
    <?= $this->Form->input('page', array(
        'id' => 'page',
        'type' => 'hidden'
    )); ?>
<?php }
$uriParts = explode('?', $_SERVER['REQUEST_URI'], 2);
?>
<?= $this->Form->input('url', array(
    'id' => 'url',
    'value' => base64_encode(serialize($uriParts[0])),
    'type' => 'hidden'
)); ?>

<div class="box-body">
    <div class="panel-group wrap" id="bs-collapse">
        <div class="panel loop-panel">
            <a class="collapsed fltr" data-toggle="collapse" data-parent="#" href="#one">
                <i class="zmdi zmdi-search-in-page"></i>
            </a>
            <a class="collapsed grp_actions_icon fltr" data-toggle="collapse" data-parent="#" href="#grp_actions">
                <i class="fa fa-toggle-down"></i>
            </a>

            <div id="one" class="panel-collapse collapse">
                <div class="panel-body">

                    <?php echo $this->Form->create('Payments', array(
                        'url' => array(
                            'action' => 'search'
                        ),
                        'novalidate' => true
                    )); ?>

                    <div class="filters" id='filters'>

                        <?php
                        echo $this->Form->input('supplier_id', array(
                            'label' => __('Supplier'),
                            'class' => 'form-filter select2',
                            'id' => 'supplier',
                            'empty' => ''
                        ));

                        echo $this->Form->input('client_id', array(
                            'label' => __('Client'),
                            'class' => 'form-filter select2',
                            'id' => 'client',
                            'empty' => ''
                        ));



                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        $options=array('4'=>'Chèque' , '1'=>'Espèce', '3'=>'Chèque de banque', '2'=>'Virement', '5'=>'Traite', '6'=>'Fictif');



                        echo $this->Form->input('payment_type', array(
                            'label' => __('Payment mode'),
                            'class' => 'form-filter select2',
                            'options' => $options,
                            'id' => 'payment_type',
                            'empty' => ''
                        ));

                        $options=array('1'=>__('Cashing') , '2'=>__('Disbursement'));

                        echo $this->Form->input('transact_type_id', array(
                            'label' => __('Payment type'),
                            'class' => 'form-filter select2',
                            'options' => $options,
                            'id' => 'transact_type',
                            'empty' => ''
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";

                        $options=array('1'=>'Non défini' , '2'=>'Chez nous', '3'=>'En circulation', '4'=>'Payé', '5'=>'Impayé', '6'=>'Annulé');
                        echo $this->Form->input('payment_etat', array(
                            'label' => __('Payment etat'),
                            'class' => 'form-filter select2',
                            'options' => $options,
                            'id' => 'etat',
                            'empty' => ''
                        ));

                        echo  $this->Form->input('payment_category_id', array(
                            'label' => __('Category'),
                            'empty' => '',
                            'id'=>'category',
                            'class' => 'form-control select2',
                        )) ;

                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('compte_id', array(
                            'label' => __('Compte'),
                            'class' => 'form-filter select2',
                            'id' => 'compte',
                            'empty' => ''
                        ));

                        echo $this->Form->input('amount', array(
                            'label' => __('Amount'),
                            'class' => 'form-filter',
                            'id' => 'amount_payment',
                            'type' => 'number',

                            'empty' => ''
                        ));

                        echo "<div style='clear:both; padding-top: 10px;'></div>";

                        echo $this->Form->input('date1', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Date de') . '</label><div class="input-group date"><div class="input-group-addon">
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


    <div class="row collapse" id="grp_actions">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">


                            <div id="dialogModalPayments">
                                <!-- the external content is loaded inside this tag -->
                            </div>
                            <div id="dialogModalEdit">
                                <!-- the external content is loaded inside this tag -->
                            </div>

                            <div id="dialogModalDuplicatePayments">
                                <!-- the external content is loaded inside this tag -->

                            </div>

                            <div class="btn-group">
                                <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'), 'javascript:;',

                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                                <button type="button" id="export_allmark"
                                        class="btn dropdown-toggle btn-inverse btn-bordred"
                                        data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">

                                    <li>
                                        <?= $this->Html->link(__('Add cashing'), 'javascript:addCashing();', array('escape' => false)) ?>
                                    </li>

                                    <li>
                                        <?= $this->Html->link(__('Add disbursement'), 'javascript:addDisbursement();', array('escape' => false)) ?>
                                    </li>


                                </ul>


                            </div>


                            <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                'javascript:submitDeleteForm("payments/deletePayments/");',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                    'disabled' => 'true'),
                                __('Are you sure you want to delete selected payments ?')); ?>

                            <!-- Reports button -->
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


                                </ul>
                            </div>

                            <div class="btn-group">
                                <?= $this->Html->link('<i class="fa fa-edit m-r-5"></i>' . __('Quick modification'),
                                    'javascript:;',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                                <button type="button" id="export_allmark"
                                        class="btn dropdown-toggle btn-inverse  btn-bordred" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <?= $this->Html->link(__('Edit etat'), 'javascript:editPaymentEtat();') ?>
                                    </li>
                                    <li>
                                        <?= $this->Html->link(__('Edit category'), 'javascript:editPaymentCategory();') ?>
                                    </li>


                                </ul>
                            </div>
                            <!-- End Reports button -->

                        </div>
                    </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                </div>

            </div>
        </div>
    </div>

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


    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <?php echo $this->Form->create('Payments', array(
                    'url' => array(
                        'action' => 'search'
                    ),
                    'novalidate' => true,
                    'id' => 'searchKeyword'
                )); ?>
                <label style="float: right;">
                    <input id='keyword' type="text" name="keyword" id="keyword" class="form-control"
                           placeholder= <?= __("Search"); ?>>

                </label>
                <?php echo $this->Form->end(); ?>
                <div class="dataTables_length m-r-15" id="datatable-editable_length" style="display: inline-block;">
                    <label>&nbsp; <?= __('Order : ') ?>
                        <?php
                        if (isset($this->params['pass']['1'])) $order = $this->params['pass']['1'];
                        ?>
                        <select aria-controls="datatable-editable" class="form-control input-sm" name="selectOrder"
                                id="selectOrder"
                                onchange="selectOrderChangedSearch('payments/index','DESC');">
                            <option value=""></option>
                            <option
                                    value="1" <?php if ($order == 1) echo 'selected="selected"' ?>> <?= __('Wording') ?></option>
                            <option
                                    value="2" <?php if ($order == 2) echo 'selected="selected"' ?>><?= __('Id') ?></option>
                            <option
                                    value="3" <?php if ($order == 3) echo 'selected="selected"' ?>><?= __('Date') ?></option>

                        </select>
                    </label>
                    <span id="asc_desc" >
                        <i class="fa fa-sort-asc" id="asc" onclick="selectOrderChanged('payments/index', 'ASC');"></i>
                        <i class="fa fa-sort-desc" id="desc" onclick="selectOrderChanged('payments/index','DESC');"></i>
                        </span>
                </div>
                <div class="dataTables_length" id="datatable-editable_length" style="display: inline-block;">
                    <label>
                        <?php
                        if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                        ?>
                        <select aria-controls="datatable-editable" class="form-control input-sm" name="slctlimit"
                                id="slctlimit"
                                onchange="slctlimitChangedSearch('payments/index');">
                            <option value="20" <?php if ($limit == 20) echo 'selected="selected"' ?>>20</option>
                            <option value="25" <?php if ($limit == 25) echo 'selected="selected"' ?>>25</option>
                            <option value="50" <?php if ($limit == 50) echo 'selected="selected"' ?>>50</option>
                            <option value="100" <?php if ($limit == 100) echo 'selected="selected"' ?>>100</option>
                            <option value="500" <?php if ($limit == 500) echo 'selected="selected"' ?>>500</option>
                        </select>&nbsp; <?= __('records per page') ?>
                    </label>
                </div>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                       cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th style="width: 10px">
                            <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i
                                        class="fa fa-square-o"></i></button>
                        </th>
                        <th><?php echo $this->Paginator->sort('receipt_date', __('Date')); ?></th>
                        <th><?php echo $this->Paginator->sort('num_compte', __('Compte')); ?></th>
                        <th><?php echo $this->Paginator->sort('wording', __('Wording')); ?></th>
                        <th><?php echo $this->Paginator->sort('', __('Tiers')); ?></th>
                        <th><?php echo $this->Paginator->sort('payment_type', __('Mode')); ?></th>
                        <th><?php echo $this->Paginator->sort('payment_etat', __('Etat')); ?></th>
                        <th><?php echo $this->Paginator->sort('payment_category_id', __('Category')); ?></th>
                        <th><?php echo $this->Paginator->sort('amount', __('Amount')); ?></th>
                        <th><?php echo $this->Paginator->sort('operation_date', __('Operation')); ?></th>
                        <th><?php echo $this->Paginator->sort('value_date', __('Value')); ?></th>
                        <th><?php echo $this->Paginator->sort('deadline_date', __('Deadline')); ?></th>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    </thead>



                    <tbody id="listeDiv">
                    <?php

                    foreach ($payments as $payment): ?>
                        <tr id="row<?= $payment['Payment']['id'] ?>"
                            <?php if($payment['Payment']['transact_type_id']== 1) {?> style="background-color: rgba(95, 190, 170, 0.16); !important;"
                            <?php } else { ?>
                                style="background-color: rgba(240, 80, 80, 0.16); !important;"
                            <?php } ?> >
                            <td style="width: 40px">
                                <input id="idCheck" type="checkbox" class='id'
                                       tabindex="-1" value=<?php echo $payment['Payment']['id'] ?>>
                                <?php if($payment['Payment']['transact_type_id']== 1) { ?>
                                    <i style="position: relative;left: 15px;top: 2px; font-size: 12px; color:#0eac5c " class="fa fa-plus-square" aria-hidden="true"></i>
                                <?php } else { ?>
                                    <i style="position: relative;left: 15px;top: 2px; font-size: 12px; color: #ff4242 " class="fa fa-minus-square" aria-hidden="true"></i>
                                <?php } ?>

                            </td>
                            <td>
                                <div class="table-content editable">

                                    <input
                                            name="<?= $this->Payment->encrypt("payment|" . $payment['Payment']['id']); ?>"
                                            value="<?= $this->Time->format($payment['Payment']['receipt_date'], '%d/%m/%Y') ?>"
                                            class="form-control table-input3 receipt_date" type="text"
                                            placeholder='' readonly="readonly" >
                                    <span style="color: #fff0; display: none;"><?php echo $this->Time->format($payment['Payment']['receipt_date'], '%d/%m/%Y') ?></span>

                                </div>

                            </td>
                            <td><?php echo h($payment['Compte']['num_compte']); ?>
                                &nbsp;

                            </td>
                            <td>

                                <div class="table-content editable">

                                    <input
                                            name="<?= $this->Payment->encrypt("payment|" . $payment['Payment']['id']); ?>"
                                            value="<?= $payment['Payment']['wording'] ?>"
                                            class="form-control table-input1 wording" type="text" readonly="readonly" >
                                    <span style="color: #fff0; display: none;"> <?php echo $payment['Payment']['wording']; ?></span>
                                </div>

                            </td>
                            <td><?php switch ($payment['PaymentAssociation']['id']) {
                                    case 1:
                                        $name = $payment['Supplier']['name'];
                                        echo __("$name");
                                        break;
                                    case 2:
                                        $name = $payment['Interfering']['name'];
                                        echo __("$name");
                                        break;
                                    case 3:
                                        $name = $payment['Customer']['first_name'] . ' ' . $payment['Customer']['last_name'];
                                        echo __("$name");
                                        break;
                                    case 4:
                                        $name = $payment['Supplier']['name'];
                                        echo __("$name");
                                        break;
                                    case 5:
                                        $name = $payment['Supplier']['name'];
                                        echo __("$name");
                                        break;
                                    case 6:
                                        $name = $payment['Supplier']['name'];
                                        echo __("$name");
                                        break;
                                    default :
                                        $name = $payment['Supplier']['name'];
                                        echo __("$name");
                                }
                                ?>&nbsp;

                            </td>
                            <td><?php switch ($payment['Payment']['payment_type']) {

                                    case 1:
                                        echo __('Espèce');
                                        break;
                                    case 2:
                                        echo __('Virement');
                                        break;
                                    case 3:
                                        echo __('Chèque de banque');
                                        break;

                                    case 4:
                                        echo __('Chèque');
                                        break;

                                    case 5:
                                        echo __('Traite');
                                        break;

                                    case 6:
                                        echo __('Fictif');
                                        break;

                                } ?>&nbsp;

                            </td>
                            <td><?php switch ($payment['Payment']['payment_etat']) {

                                    case 1:
                                        echo __('Non défini');
                                        break;
                                    case 2:
                                        echo __('Chez nous');
                                        break;
                                    case 3:
                                        echo __('En circulation');
                                        break;

                                    case 4:
                                        echo __('Payé');
                                        break;

                                    case 5:
                                        echo __('Impayé');
                                        break;

                                    case 6:
                                        echo __('Annulé');
                                        break;

                                } ?>&nbsp;

                            </td>
                            <td>
                                <?php echo  $payment['PaymentCategory']['name'] ?>

                            </td>
                            <td>
                                <div class="table-content editable">
                                    <input
                                            name="<?= $this->Payment->encrypt("payment|" . $payment['Payment']['id']); ?>"
                                            value="<?= $payment['Payment']['amount'] ?>" id="input3<?= $payment['Payment']['id'] ?>"
                                            class="form-control table-input2 amount" type="number" step ="0.01"
                                            readonly="readonly">
                                    <span style="color: #fff0; display: none;"> <?php echo $payment['Payment']['amount']; ?></span>
                                </div>

                            </td>

                            <td>
                                <div class="table-content editable">
                                    <input
                                            name="<?= $this->Payment->encrypt("payment|" . $payment['Payment']['id']); ?>"
                                            value="<?= $this->Time->format($payment['Payment']['operation_date'], '%d/%m/%Y') ?>"
                                            class="form-control table-input4 operation_date" type="text"  placeholder=''
                                            readonly="readonly">
                                    <span style="color: #fff0; display: none;"> <?php echo $this->Time->format($payment['Payment']['operation_date'], '%d/%m/%Y'); ?></span>

                                </div>
                            </td>
                            <td>
                                <div class="table-content editable">
                                    <input
                                            name="<?= $this->Payment->encrypt("payment|" . $payment['Payment']['id']); ?>"
                                            value="<?= $this->Time->format($payment['Payment']['value_date'], '%d/%m/%Y') ?>"
                                            class="form-control table-input5 value_date" type="text"  placeholder=''
                                            readonly="readonly" >
                                    <span style="color: #fff0; display: none;"> <?php echo $this->Time->format($payment['Payment']['value_date'], '%d/%m/%Y'); ?></span>

                                </div>

                            </td>
                            <td>
                                <div class="table-content editable">
                                    <input
                                            name="<?= $this->Payment->encrypt("payment|" . $payment['Payment']['id']); ?>"
                                            value="<?= $this->Time->format($payment['Payment']['deadline_date'], '%d/%m/%Y') ?>"
                                            class="form-control table-input6 deadline_date" type="text"  placeholder=''
                                            readonly="readonly" >
                                    <span style="color: #fff0; display: none;"> <?php echo $this->Time->format($payment['Payment']['deadline_date'], '%d/%m/%Y'); ?></span>

                                </div>

                            </td>






                            <td class="actions">
                                <div class="btn-group ">
                                    <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                        <i class="fa fa-list fa-inverse"></i>
                                    </a>
                                    <button tabindex="-1" href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                                        <span class="caret"></span>
                                    </button>

                                    <ul class="dropdown-menu" style="min-width: 70px;">

                                        <li>
                                            <?= $this->Html->link(
                                                '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                                                array('action' => 'viewPayment', $payment['Payment']['id']),
                                                array('escape' => false, 'class' => 'btn btn-success')
                                            ); ?>
                                        </li>

                                        <li>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                'javascript:editPayment(' . $payment['Payment']['id'] . ',' . $payment['PaymentAssociation']['id'] . ');',
                                                array('escape' => false, 'class' => 'btn btn-primary')
                                            ); ?>
                                        </li>

                                        <?php if($payment['PaymentAssociation']['id']== PaymentAssociationsEnum::cashing ||
                                            $payment['PaymentAssociation']['id']== PaymentAssociationsEnum::disbursement
                                        ) { ?>
                                            <li>
                                                <?= $this->Html->link(
                                                    '<i class="fa fa-copy " title="' . __('Duplicate') . '"></i>',
                                                    'javascript:duplicatePayment(' . $payment['Payment']['id'] . ',' . $payment['PaymentAssociation']['id'] . ');',
                                                    array('escape' => false, 'class' => 'btn btn-warning')
                                                ); ?>
                                            </li>
                                        <?php	} ?>

                                        <li>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-print " title="' . __('Print') . '"></i>',
                                                array('action' => 'printRecuPayment', 'ext' => 'pdf', $payment['Payment']['id']),
                                                array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-inverse')
                                            ); ?>
                                        </li>

                                        <li>
                                            <?php
                                            echo $this->Form->postLink(
                                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                array('action' => 'delete', $payment['Payment']['id'], $payment['PaymentAssociation']['id']),
                                                array('escape' => false, 'class' => 'btn btn-danger'),
                                                __('Are you sure you want to delete %s?', $payment['Payment']['wording'])); ?>
                                        </li>
                                    </ul>
                                </div>


                            </td>


                        </tr>
                    <?php endforeach; ?>
                    </tbody>


                </table>


                <div id="pagination">
                    <?php
                    if ($this->params['paging']['Payment']['pageCount'] > 1) {
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
            </div>
        </div>



    </div>
</div>
<div class="card-box">
    <ul class="list-group m-b-15 user-list">
        <div class="nav-tabs-custom pdg_btm">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General') ?></a></li>
                <li><a href="#tab_2" data-toggle="tab"><?= __('Due date') ?></a></li>
                <li><a href="#tab_3" data-toggle="tab"><?= __('Paid transactions') ?></a></li>
                <li><a href="#tab_4" data-toggle="tab"><?= __('In circulation / At home') ?></a></li>
            </ul>

            <div class="tab-content" style="height: 110px;">
                <div class="tab-pane active" id="tab_1">
                    <?php
                    echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Debit : ') . '</b><span >' .
                        number_format($totalArray['debitGeneral'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div></br> ";
                    echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Credit : ') . '</b><span >' .
                        number_format($totalArray['creditGeneral'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div> </br>";
                    echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Balance : ') . '</b><span >' .
                        number_format($totalArray['soldeGeneral'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div></br></br> ";
                    ?>

                </div>

                <div class="tab-pane " id="tab_2">
                    <?php
                    echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Debit : ') . '</b><span >' .
                        number_format($totalArray['debitDeadline'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div></br> ";
                    echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Credit : ') . '</b><span >' .
                        number_format($totalArray['creditDeadline'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div> </br>";
                    echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Balance : ') . '</b><span >' .
                        number_format($totalArray['soldeDeadline'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div></br></br> ";
                    ?>
                </div>
                <div class="tab-pane " id="tab_3">
                    <?php
                    echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Debit : ') . '</b><span >' .
                        number_format($totalArray['debitTransaction'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div></br> ";
                    echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Credit : ') . '</b><span >' .
                        number_format($totalArray['creditTransaction'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div> </br>";
                    echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Balance : ') . '</b><span >' .
                        number_format($totalArray['soldeTransaction'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div></br></br>";

                    ?>
                </div>
                <div class="tab-pane " id="tab_4">
                    <?php
                    echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Debit : ') . '</b><span >' .
                        number_format($totalArray['debitCirculation'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div></br> ";
                    echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Credit : ') . '</b><span >' .
                        number_format($totalArray['creditCirculation'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div> </br>";
                    echo "<div class='total'><span class='col-lg-12 col-xs-12'><b class= 'b-total'>" . __('Balance : ') . '</b><span >' .
                        number_format($totalArray['soldeCirculation'], 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span></div></br></br> ";

                    ?>
                </div>
            </div>



        </div>
    </ul>
</div>





<?php $this->start('script'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
<?= $this->Html->script('plugins/datetimepicker/moment-with-locales.min.js'); ?>
<?= $this->Html->script('plugins/datetimepicker/bootstrap-datetimepicker.min.js'); ?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
<script type="text/javascript">


    $(document).ready(function () {

        jQuery("#date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#date2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        jQuery("#startdatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        jQuery("#startdatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery(".receipt_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery(".operation_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery(".value_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery(".deadline_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        function toggleIcon(e) {
            $(e.target)
                .prev('.panel-heading')
                .find(".more-less")
                .toggleClass(' glyphicon-chevron-down  glyphicon-chevron-up');
        }

        $('.panel-group').on('hidden.bs.collapse', toggleIcon);
        $('.panel-group').on('shown.bs.collapse', toggleIcon);

        jQuery("#dialogModalEdit").dialog({
            autoOpen: false,
            height: 300,
            width: 450,
            position : 'absolute',
            top : 80 ,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true,
            _allowInteraction: function (event) {
                return !!$(event.target).is(".select2-input") || this._super(event);
            }
        });
        jQuery("#dialogModalPayments").dialog({
            autoOpen: false,
            height: 630,
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

        jQuery("#dialogModalDuplicatePayments").dialog({
            autoOpen: false,
            height: 200,
            width: 400,
            position : 'absolute',
            top : 80 ,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true,
            _allowInteraction: function (event) {
                return !!$(event.target).is(".select2-input") || this._super(event);
            }
        });

        $('input[readonly]').click(function () {
            $(this).removeAttr('readonly');
        })
        $('body').delegate('.table-input1', 'change', function () {

            var ThisElement = $(this);
            ThisElement.find('.table-input1').show();

            var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');
            jQuery.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url('/payments/updateWording/')?>",
                data: UrlToPass,
                dataType: "json",
                success: function (json) {
                    if (json.response == true) {
                        ThisElement.find('.table-input1').show();
                        $(".wording").attr('readonly', true);
                        $(".wording").blur();
                    }
                }
            });
        });

        $('body').delegate('.table-input2', 'change', function () {

            var ThisElement = $(this);
            ThisElement.find('.table-input2').show();

            var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');
            jQuery.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url('/payments/updateAmount/')?>",
                data: UrlToPass,
                dataType: "json",
                success: function (json) {
                    if (json.response == true) {
                        //ThisElement.find('.table-input2').show();
                        $(".amount").attr('readonly', true);
                        $(".amount").blur();
                    }

                }
            });
        });

        $('body').delegate('.table-input3', 'change', function () {

            var ThisElement = $(this);
            ThisElement.find('.table-input3').show();

            var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');
            jQuery.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url('/payments/updateReceiptDate/')?>",
                data: UrlToPass,
                dataType: "json",
                success: function (json) {
                    if (json.response == true) {
                        ThisElement.find('.table-input3').show();
                        $(".receipt_date").attr('readonly', true);
                        $(".receipt_date").blur();
                    }
                }
            });
        });

        $('body').delegate('.table-input4', 'change', function () {

            var ThisElement = $(this);
            ThisElement.find('.table-input4').show();

            var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');
            jQuery.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url('/payments/updateOperationDate/')?>",
                data: UrlToPass,
                dataType: "json",
                success: function (json) {
                    if (json.response == true) {
                        ThisElement.find('.table-input4').show();
                        $(".operation_date").attr('readonly', true);
                        $(".operation_date").blur();
                    }
                }
            });
        });

        $('body').delegate('.table-input5', 'change', function () {

            var ThisElement = $(this);
            ThisElement.find('.table-input5').show();

            var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');
            jQuery.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url('/payments/updateValueDate/')?>",
                data: UrlToPass,
                dataType: "json",
                success: function (json) {
                    if (json.response == true) {
                        ThisElement.find('.table-input5').show();
                        $(".value_date").attr('readonly', true);
                        $(".value_date").blur();
                    }
                }
            });
        });
        $('body').delegate('.table-input6', 'change', function () {

            var ThisElement = $(this);
            ThisElement.find('.table-input6').show();

            var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');
            jQuery.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url('/payments/updateDeadlineDate/')?>",
                data: UrlToPass,
                dataType: "json",
                success: function (json) {
                    if (json.response == true) {
                        ThisElement.find('.table-input6').show();
                        $(".deadline_date").attr('readonly', true);
                        $(".deadline_date").blur();
                    }
                }
            });
        });



    });


    function editMissionCostPayment(id) {


        jQuery('#dialogModalPayments').dialog('option', 'title', 'Paiement');
        jQuery('#dialogModalPayments').dialog('open');
        jQuery('#dialogModalPayments').load('<?php echo $this->Html->url('/payments/editMissionCostPayment/')?>' + id);


    }

    function deleteData() {
        var link = '<?php echo $this->Html->url('/payments/deletePayments/')?>';


        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());

        });


        jQuery.ajax({
            type: "POST",
            url: link,
            data: "ids=" + myCheckboxes,
            dataType: "json",
            success: function (json) {
                if (json.response === "true") {

                    jQuery('#row' + id).remove();
                }
            }
        });


    }

    // Reports functions
    function printSimplifiedJournal() {
        var conditions = new Array();
        conditions[0] = jQuery('#supplier').val();
        conditions[1] = jQuery('#date1').val();
        conditions[2] = jQuery('#date2').val();
        conditions[3] = jQuery('#client').val();
        conditions[4] = jQuery('#interfering').val();
        conditions[5] = jQuery('#customer').val();
        conditions[6] = jQuery('#compte').val();
        conditions[7] = jQuery('#payment_type').val();
        conditions[8] = jQuery('#amount_payment').val();
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        var url = '<?php echo $this->Html->url(array('action' => 'printSimplifiedJournal', 'ext' => 'pdf'), array('target' => '_blank'))?>';
        var form = jQuery('<form action="' + url + '" method="post" target="_Blank" >' +
            '<input type="hidden" name="printSimplifiedJournal" value="' + conditions + '" />' +
            '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
            '</form>');
        jQuery('body').append(form);
        form.submit();
    }

    function printDetailedJournal() {
        var conditions = new Array();
        conditions[0] = jQuery('#supplier').val();
        conditions[1] = jQuery('#date1').val();
        conditions[2] = jQuery('#date2').val();
        conditions[3] = jQuery('#client').val();
        conditions[4] = jQuery('#interfering').val();
        conditions[5] = jQuery('#customer').val();
        conditions[6] = jQuery('#compte').val();
        conditions[7] = jQuery('#payment_type').val();
        conditions[8] = jQuery('#amount_payment').val();
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
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

    function editPaymentEtat(){
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });

        jQuery('#dialogModalEdit').dialog('option', 'title', "<?php echo __('Edit etat') ?>");
        jQuery('#dialogModalEdit').dialog('open');
        jQuery('#dialogModalEdit').load('<?php echo $this->Html->url('/payments/editPaymentEtat/')?>' + myCheckboxes);

    }

    function editPaymentCategory(){
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });

        jQuery('#dialogModalEdit').dialog('option', 'title',"<?php echo __('Edit category')?>");
        jQuery('#dialogModalEdit').dialog('open');
        jQuery('#dialogModalEdit').load('<?php echo $this->Html->url('/payments/editPaymentCategory/')?>' + myCheckboxes);

    }

    function slctlimitChangedSearch() {
        <?php
        $url = "";

        if (isset($this->params['named']['keyword']) && !empty($this->params['named']['keyword'])) {
            $url .= "/keyword:" . $this->params['named']['keyword'];
        }
        if (isset($this->params['named']['compte']) && !empty($this->params['named']['compte'])) {
            $url .= "/compte:" . $this->params['named']['compte'];
        }
        if (isset($this->params['named']['customer']) && !empty($this->params['named']['customer'])) {
            $url .= "/customer:" . $this->params['named']['customer'];
        }
        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            $url .= "/category:" . $this->params['named']['category'];
        }
        if (isset($this->params['named']['payment_type']) && !empty($this->params['named']['payment_type'])) {
            $url .= "/payment_type:" . $this->params['named']['payment_type'];
        }
        if (isset($this->params['named']['payment_etat']) && !empty($this->params['named']['payment_etat'])) {
            $url .= "/payment_etat:" . $this->params['named']['payment_etat'];
        }
        if (isset($this->params['named']['amount']) && !empty($this->params['named']['amount'])) {
            $url .= "/amount:" . $this->params['named']['amount'];
        }
        if (isset($this->params['named']['supplier']) && !empty($this->params['named']['supplier'])) {
            $url .= "/supplier:" . $this->params['named']['supplier'];
        }
        if (isset($this->params['named']['client']) && !empty($this->params['named']['client'])) {
            $url .= "/client:" . $this->params['named']['client'];
        }
        if (isset($this->params['named']['interfering']) && !empty($this->params['named']['interfering'])) {
            $url .= "/interfering:" . $this->params['named']['interfering'];
        }
        if (isset($this->params['named']['transact_type']) && !empty($this->params['named']['transact_type'])) {
            $url .= "/transact_type:" . $this->params['named']['transact_type'];
        }
        if (isset($this->params['named']['date1']) && !empty($this->params['named']['date1'])) {
            $url .= "/date1:" . $this->params['named']['date1'];
        }
        if (isset($this->params['named']['date2']) && !empty($this->params['named']['date2'])) {
            $url .= "/date2:" . $this->params['named']['date2'];
        }
        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $url .= "/user:" . $this->params['named']['user'];
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $url .= "/modified_id:" . $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $url .= "/created:" . $this->params['named']['created'];
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $url .= "/created1:" . $this->params['named']['created1'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $url .= "/modified:" . $this->params['named']['modified'];
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $url .= "/modified1:" . $this->params['named']['modified1'];
        }
        ?>
        window.location = '<?php echo $this->Html->url('/payments/search/')?>' + jQuery('#slctlimit').val() + '<?php echo $url;?>';
    }


    function selectOrderChangedSearch(url = null , orderType = null) {
        <?php
        $url = "";


        if (isset($this->params['named']['keyword']) && !empty($this->params['named']['keyword'])) {
            $url .= "/keyword:" . $this->params['named']['keyword'];
        }
        if (isset($this->params['named']['compte']) && !empty($this->params['named']['compte'])) {
            $url .= "/compte:" . $this->params['named']['compte'];
        }
        if (isset($this->params['named']['customer']) && !empty($this->params['named']['customer'])) {
            $url .= "/customer:" . $this->params['named']['customer'];
        }
        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            $url .= "/category:" . $this->params['named']['category'];
        }
        if (isset($this->params['named']['payment_type']) && !empty($this->params['named']['payment_type'])) {
            $url .= "/payment_type:" . $this->params['named']['payment_type'];
        }
        if (isset($this->params['named']['payment_etat']) && !empty($this->params['named']['payment_etat'])) {
            $url .= "/payment_etat:" . $this->params['named']['payment_etat'];
        }
        if (isset($this->params['named']['amount']) && !empty($this->params['named']['amount'])) {
            $url .= "/amount:" . $this->params['named']['amount'];
        }
        if (isset($this->params['named']['supplier']) && !empty($this->params['named']['supplier'])) {
            $url .= "/supplier:" . $this->params['named']['supplier'];
        }
        if (isset($this->params['named']['client']) && !empty($this->params['named']['client'])) {
            $url .= "/client:" . $this->params['named']['client'];
        }
        if (isset($this->params['named']['interfering']) && !empty($this->params['named']['interfering'])) {
            $url .= "/interfering:" . $this->params['named']['interfering'];
        }
        if (isset($this->params['named']['transact_type']) && !empty($this->params['named']['transact_type'])) {
            $url .= "/transact_type:" . $this->params['named']['transact_type'];
        }
        if (isset($this->params['named']['date1']) && !empty($this->params['named']['date1'])) {
            $url .= "/date1:" . $this->params['named']['date1'];
        }
        if (isset($this->params['named']['date2']) && !empty($this->params['named']['date2'])) {
            $url .= "/date2:" . $this->params['named']['date2'];
        }
        if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
            $url .= "/user:" . $this->params['named']['user'];
        }
        if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
            $url .= "/modified_id:" . $this->params['named']['modified_id'];
        }
        if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
            $url .= "/created:" . $this->params['named']['created'];
        }
        if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
            $url .= "/created1:" . $this->params['named']['created1'];
        }
        if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
            $url .= "/modified:" . $this->params['named']['modified'];
        }
        if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
            $url .= "/modified1:" . $this->params['named']['modified1'];
        }
        ?>

        var limit = jQuery('#slctlimit').val();
        var order = jQuery('#selectOrder').val();
        window.location = '<?php echo $this->Html->url('/payments/search/')?>' +limit+'/'+ order +'/'+ orderType+'<?php echo $url;?>';
    }


    // End reports functions

</script>
<?php $this->end(); ?>
