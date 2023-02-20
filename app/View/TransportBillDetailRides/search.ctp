<style>

    #table-commande {
        height: 300px;
        overflow: auto;
        overflow-x: hidden;
        display: block;
        width: 100%;

    }

    .actions {
        width: 60px;
    }


</style>
<?php

$this->start('css');

echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->Html->css('select2/select2.min');
$this->end();
?><h4 class="page-title"> <?= __('Search'); ?></h4>
<div class="box-body">
    <div class="panel-group wrap" id="bs-collapse">

        <div class="panel loop-panel">
            <a class="collapsed fltr" data-toggle="collapse" data-parent="#" href="#one">
                <i class="zmdi zmdi-search-in-page"></i>
            </a>
            <div id="one" class="panel-collapse collapse">
                <div class="panel-body">

                    <?php echo $this->Form->create('TransportBillDetailRides', array(
                        'url' => array(
                            'action' => 'search'
                        ),
                        'novalidate' => true
                    ));

                    echo "<div style='clear:both; padding-top: 10px;'></div>";
                    ?>
                    <div class="filters" id='filters'>

                        <?php

                        echo $this->Form->input('ride_id', array(
                            'label' => __('Ride'),
                            'class' => 'form-filter select2',
                            'empty' => ''
                        ));

                        echo $this->Form->input('car_type_id', array(
                            'label' => __('Transportation'),
                            'class' => 'form-filter select2',
                            'id' => 'car_type',
                            'empty' => ''
                        ));

                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('supplier_id', array(
                            'label' => __('Client'),
                            'class' => 'form-filter select2',
                            'id' => 'supplier',
                            'empty' => ''
                        ));
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
                                echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                    array('controller'=>'TransportBills','action' => 'Add', TransportBillTypesEnum::order,'TransportBillDetailRides'),
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));

                                ?>
                                <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                    'javascript:submitDeleteForm("transportBills/deleteTransportBills/2");',
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
                                            <?= $this->Html->link(__('Simplified journal per client'), 'javascript:printJournalPerClient();') ?>
                                        </li>
                                    </ul>
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

                                echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                    array('controller'=>'TransportBills','action' => 'Add', TransportBillTypesEnum::order),
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));

                                echo $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                    'javascript:;',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete')); ?>






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
            <div class="card-box p-b-20">
                <?php echo $this->Form->create('TransportBillDetailRide', array(
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
                            if (isset($this->params['pass']['1'])) $order = $this->params['pass']['1'];
                            ?>
                            <select aria-controls="datatable-editable" class="form-control input-sm" name="selectOrder"
                                    id="selectOrder" onchange="selectOrderChanged('transportBillDetailRides/index');">
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
                            if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                            ?>
                            <select aria-controls="datatable-editable" class="form-control input-sm" name="slctlimit"
                                    id="slctlimit" onchange="slctlimitChanged('transportBillDetailRides/index');">
                                <option value="20" <?php if ($limit == 20) echo 'selected="selected"' ?>>20</option>
                                <option value="25" <?php if ($limit == 25) echo 'selected="selected"' ?>>25</option>
                                <option value="50" <?php if ($limit == 50) echo 'selected="selected"' ?>>50</option>
                                <option value="100" <?php if ($limit == 100) echo 'selected="selected"' ?>>100</option>
                                <option value="500" <?php if ($limit == 500) echo 'selected="selected"' ?>>500</option>
                            </select>&nbsp; <?= __('records per page') ?>
                        </label>
                    </div>
                </div>


                <div>
                    <table id='datatable-responsive' class="table table-striped table-bordered dt-responsive nowrap "
                           cellspacing="0" width="100%">
                        <thead>

                        <tr>
                            <th style="width: 10px">
                                <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i
                                            class="fa fa-square-o"></i></button>
                            </th>
                            <th><?= $this->Paginator->sort('User.first_name', __('Creator')) ?></th>
                            <th><?= $this->Paginator->sort('date', __('Date')) ?></th>
                            <th><?= $this->Paginator->sort('Supplier.name',  __('Initial customer')) ?></th>
                            <th><?= $this->Paginator->sort('TransportBill.order_type',  __('Order type')) ?></th>
                            <th><?= $this->Paginator->sort('DepartureDestination.name', __('Rides')) ?></th>
                            <th><?= $this->Paginator->sort('delivery_with_return', __('Type mission')) ?></th>
                            <th><?= $this->Paginator->sort('designation', __('Designation')) ?></th>
                            <th><?= $this->Paginator->sort('unit_price', __('Unit price')) ?></th>
                            <th><?= $this->Paginator->sort('nb_trucks', __('Quantity')) ?></th>
                            <th><?= $this->Paginator->sort('programming_date',__('Charging date').' / '.__('Unloading date')) ?></th>
                            <th><?= $this->Paginator->sort('observation', __('Observation')) ?></th>

                            <th><?= $this->Paginator->sort('Subcontractor.name', __('Subcontractor')) ?></th>
                            <th class="actions"><?php echo __('Actions'); ?></th>
                        </tr>
                        </thead>
                        <tbody id="listeDiv">
                        <?php
                        if (!empty($transportBillDetailRides)) {
                            foreach ($transportBillDetailRides as $transportBillDetailRide) { 
                                ?>
                                <tr id="row<?= $transportBillDetailRide['TransportBill']['id'] ?>">
                                    <td>
                                        <input id="idCheck"type="checkbox" class = 'id' value=<?php echo $transportBillDetailRide['TransportBillDetailedRides']['id'] ?> >
                                    </td>
                                    <td><?= $transportBillDetailRide['User']['first_name'].' '.$transportBillDetailRide['User']['last_name'] ?></td>

                                    <td><?php echo h($this->Time->format($transportBillDetailRide['TransportBill']['date'], '%d-%m-%Y')); ?>&nbsp;</td>
                                    <td><?= $transportBillDetailRide['Supplier']['name'] ?></td>
                                    <td><?php
                                        $options = array('1'=>__('Order with invoice'), '2'=>__('Order payment cash'));
                                        switch ($transportBillDetailRide['TransportBill']['order_type']){
                                            case 1:
                                                echo __('Order with invoice');
                                                break;
                                            case 2:
                                                echo __('Order payment cash');
                                                break;
                                            default;

                                        } ?>   </td>
                                    <?php if($transportBillDetailRide['TransportBillDetailedRides']['type_ride'] ==1){ ?>
                                        <td><?= $transportBillDetailRide['DepartureDestination']['name'] .'-'.$transportBillDetailRide['ArrivalDestination']['name'].'-'.$transportBillDetailRide['CarType']['name']
                                            ?></td>
                                    <?php } else { ?>
                                        <td><?= $transportBillDetailRide['Departure']['name'].'-'.$transportBillDetailRide['Arrival']['name'].'-'.$transportBillDetailRide['Type']['name'] ?></td>
                                    <?php } ?>
                                    <td><?php
                                        $options = array('1' => __('Simple delivery'), '2' => __('Simple return'), '3' => __('Delivery / Return'));
                                        switch ($transportBillDetailRide['TransportBillDetailedRides']['delivery_with_return']){
                                            case 1:
                                                echo __('Simple delivery');
                                                break;
                                            case 2:
                                                echo __('Simple return');
                                                break;
                                            case 3:
                                                echo __('Delivery / Return');
                                                break;
                                            default;

                                        } ?>   </td>
                                    <td><?= $transportBillDetailRide['TransportBillDetailedRides']['designation'] ?></td>
                                    <td><?= $transportBillDetailRide['TransportBillDetailedRides']['price_ht'] ?></td>
                                    <td><?= $transportBillDetailRide['TransportBillDetailedRides']['nb_trucks'] ?></td>
                                    <td><?php echo h($this->Time->format($transportBillDetailRide['TransportBillDetailedRides']['programming_date'], '%d-%m-%Y') .' '
                                                .$this->Time->format($transportBillDetailRide['TransportBillDetailedRides']['charging_time'], '%H:%M')).'</br>';
                                        echo h($this->Time->format($transportBillDetailRide['TransportBillDetailedRides']['unloading_date'], '%d-%m-%Y %H:%M'));
                                        ?>
                                    </td>

                                    <td><?= $transportBillDetailRide['TransportBillDetailedRides']['observation_order'] ?></td>
                                    <td><?= $transportBillDetailRide['Subcontractor']['name']?></td>
                                    <td class="actions">
                                        <div class="btn-group ">
                                            <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                                <i class="fa fa-list fa-inverse"></i>
                                            </a>
                                            <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                                                <span class="caret"></span>
                                            </button>

                                            <ul class="dropdown-menu" style="min-width: 70px;">
                                                <li>
                                                    <?= $this->Html->link(
                                                        '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                                                        array('controller'=>'transportBills','action' => 'View', $transportBillDetailRide['TransportBill']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-success')
                                                    ); ?>
                                                </li>
                                                <li>
                                                    <?= $this->Html->link(
                                                        '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                        array('controller'=>'transportBills','action' => 'Edit',TransportBillTypesEnum::order, $transportBillDetailRide['TransportBill']['id'],'TransportBillDetailRides'),
                                                        array('escape' => false, 'class' => 'btn btn-primary')
                                                    ); ?>
                                                </li>
                                                <li>
                                                    <?= $this->Html->link(
                                                        '<i class="fa fa-print " title="' . __('Print') . '"></i>',
                                                        array('controller'=>'transportBills','action' => 'print_facture', $transportBillDetailRide['TransportBill']['id'],
                                                            TransportBillTypesEnum::order, 'ext' => 'pdf'),
                                                        array('escape' => false, 'class' => 'btn btn-warning' ,'target'=>'blank')
                                                    ); ?>
                                                </li>
                                                <li>
                                                    <?= $this->Html->link(
                                                        '<i class="fa fa-envelope " title="' . __('Send mail') . '"></i>',
                                                        array('controller'=>'transportBills','action' => 'sendMail',TransportBillTypesEnum::order, $transportBillDetailRide['TransportBill']['id'],0,'TransportBillDetailRides'),
                                                        array('escape' => false, 'class' => 'btn btn-primary')
                                                    ); ?>
                                                </li>

                                                <li  class='edit-link' title="<?= __('Delete') ?>">
                                                    <?php
                                                    echo $this->Form->postLink(
                                                        '<i class="fa fa-trash-o"></i>',
                                                        array('controller'=>'transportBills','action' => 'delete',TransportBillTypesEnum::order, $transportBillDetailRide['TransportBill']['id'],'TransportBillDetailRides'),

                                                        array('escape' => false, 'class' => 'btn btn-danger'),
                                                        __('Are you sure you want to delete %s?', $transportBillDetailRide['TransportBillDetailedRides']['reference'])); ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>

                                </tr>

                                <?php
                            }
                        } 
                        ?>

                        </tbody>

                    </table>

                    <div id="pagination">
                        <?php
                        if ($this->params['paging']['TransportBillDetailedRides']['pageCount'] > 1) {
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
                <br>
                <br>
                <br>
                <br>

                <div id='missions'>

                </div>
                <br>
                <br>

                <div id='prices'>

                </div>

            </div>
        </div>
    </div>
</div>



<?php $this->start('script'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('plugins/datetimepicker/moment-with-locales.min.js'); ?>
<?= $this->Html->script('plugins/datetimepicker/bootstrap-datetimepicker.min.js'); ?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>


<script type="text/javascript">


    $(document).ready(function () {

        jQuery("#date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#date2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#start_date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#start_date2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#end_date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#end_date2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        $("#keyword").keypress(function (e) {
            if (e.which == 13) {

                $('#searchKeyword').submit();
            }
        });


    });
    function slctlimitChanged(urlLimit) {
        window.location = '<?php echo $this->Html->url('/')?>' + urlLimit + '/' + jQuery('#slctlimit').val();
    }

    function viewDetail(id, nbTrucks) {

        jQuery('tr').removeClass('  btn-info  btn-trans    ');
        jQuery('#' + id).addClass('  btn-info  btn-trans    ');
        jQuery('#missions').load('<?php echo $this->Html->url('/transportBillDetailRides/viewDetail/')?>' + id + '/' + nbTrucks);

    }

    function viewPrice(id) {
        jQuery('tr').removeClass('  btn-info  btn-trans    ');
        jQuery('#' + id).addClass('  btn-info  btn-trans    ');
        jQuery('#prices').load('<?php echo $this->Html->url('/transportBillDetailRides/viewPrice/')?>' + id);

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
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        if(myCheckboxes.length>0) {
            var type = jQuery("#type").val();
            var url = '<?php echo $this->Html->url(array('action' => 'printSimplifiedJournal', 'ext' => 'pdf'),
                array('target' => '_blank'))?>';
            var form = jQuery('<form action="' + url + '" method="post" target="_Blank" >' +
                '<input type="hidden" name="printSimplifiedJournal" value="' + conditions + '" />' +
                '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
                '<input type="hidden" name="typePiece" value="' + 2 + '" />' +
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
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        if(myCheckboxes.length>0) {
            var type = jQuery("#type").val();
            var url = '<?php echo $this->Html->url(array('controller'=>'TransportBills','action' => 'printDetailedJournal', 'ext' => 'pdf'), array('target' => '_blank'))?>';
            var form = jQuery('<form action="' + url + '" method="post"  target="_Blank" >' +
                '<input type="hidden" name="printDetailedJournal" value="' + conditions + '" />' +
                '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
                '<input type="hidden" name="typePiece" value="' + 2 + '" />' +
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
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });

        if(myCheckboxes.length>0) {
            var type = jQuery("#type").val();
            var url = '<?php echo $this->Html->url(array('controller'=>'TransportBills','action' => 'printJournalPerClient', 'ext' => 'pdf'), array('target' => '_blank'))?>';
            var form = jQuery('<form action="' + url + '" method="post"  target="_Blank" >' +
                '<input type="hidden" name="printJournalPerClient" value="' + conditions + '" />' +
                '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
                '<input type="hidden" name="typePiece" value="' + 2 + '" />' +
                '</form>');
            jQuery('body').append(form);
            form.submit();
        }
    }





</script>
<?php $this->end(); ?>
