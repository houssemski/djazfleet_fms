<?php

App::import('Model', 'Reservation');
$this->Reservation = new Reservation();
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->Html->css('select2/select2.min');
$this->end(); ?>
<div id="msg"></div>
<h4 class="page-title"> <?= __('Réservations'); ?></h4>
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

                    <?php echo $this->Form->create('Reservations', array(
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
                        echo $this->Form->input('car_id', array(
                            'label' => __('Car'),
                            'class' => 'form-filter select2',
                            'id' => 'car',
                            'empty' => ''
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        $options = array('1' => __('Order with invoice'), '2' => __('Order payment cash'));
                        echo $this->Form->input('order_type', array(
                            'label' => __('Order type'),
                            'class' => 'form-filter',
                            'id' => 'order_type',
                            'empty' => '',
                            'options' => $options
                        ));
                        $options = array('1' => __('Not paid'), '2' => __('Paid'), '3' => __('Partially paid'));

                        echo $this->Form->input('status', array(
                            'label' => __('Status'),
                            'class' => 'form-filter',
                            'id' => 'status',
                            'empty' => '',
                            'options' => $options
                        ));
                        echo $this->Form->input('cost', array(
                            'label' => __('Cost'),
                            'class' => 'form-filter',
                            'id' => 'cost',
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
                                <div style="clear:both; padding-top: 0px;padding-left: 20px;  border-bottom: 1px solid rgb(204, 204, 204);margin-bottom: 15px;"></div>


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
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
                            <?= $this->Html->link(
                                '<i class="fa fa-money m-r-5"></i>' . __('Payment'),
                                'javascript:verifyIdCustomers("5","addPayment");',
                                array(
                                    'escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'payment',
                                    'disabled' => 'true'
                                )
                            ); ?>
                        </div>
                    </div>
                    <div class="btn-group">
                        <?= $this->Html->link(
                            '<i class="fa fa-print m-r-5"></i>' . __('Print'),
                            'javascript:;',
                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')
                        ) ?>
                        <button type="button" id="export_allmark" class="btn dropdown-toggle btn-inverse  btn-bordred" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <?= $this->Html->link(__('Reservation per supplier'), 'javascript:printReservationPerSupplier();') ?>
                            </li>
                            <li>
                                <?= $this->Html->link(__('Reservation per car'), 'javascript:printReservationPerCar();') ?>
                            </li>
                            <li>
                                <?= $this->Html->link(__('Subcontractor state'), 'javascript:printSubcontractorState();') ?>
                            </li>

                        </ul>
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
                <?php echo $this->Form->create('Reservations', array(
                    'url' => array(
                        'action' => 'search'
                    ),
                    'novalidate' => true,
                    'id' => 'searchKeyword'
                )); ?>
                <label style="float: right;">
                    <input id='keyword' type="text" name="keyword" id="keyword" class="form-control" placeholder=<?= __("Search"); ?>>
                </label>
                <?php echo $this->Form->end(); ?>
                <div class="col-sm-6">
                    <div class="dataTables_length m-r-15" id="datatable-editable_length" style="display: inline-block;">
                        <label>&nbsp; <?= __('Order : ') ?>
                            <?php
                            if (isset($this->params['pass']['1'])) $order = $this->params['pass']['1'];
                            ?>
                            <select aria-controls="datatable-editable" class="form-control input-sm" name="selectOrder" id="selectOrder" onchange="selectOrderChanged('reservations/index');">
                                <option value="1" <?php if ($order == 1) echo 'selected="selected"' ?>> <?= __('Code') ?></option>
                                <option value="2" <?php if ($order == 2) echo 'selected="selected"' ?>><?= __('Name') ?></option>
                                <option value="3" <?php if ($order == 3) echo 'selected="selected"' ?>><?= __('Id') ?></option>

                            </select>
                        </label>
                    </div>
                    <div class="dataTables_length" id="datatable-editable_length" style="display: inline-block;">
                        <label>
                            <?php
                            if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                            ?>
                            <select aria-controls="datatable-editable" class="form-control input-sm" name="slctlimit" id="slctlimit" onchange="slctlimitChanged('marchandises/index');">
                                <option value="20" <?php if ($limit == 20) echo 'selected="selected"' ?>>20</option>
                                <option value="25" <?php if ($limit == 25) echo 'selected="selected"' ?>>25</option>
                                <option value="50" <?php if ($limit == 50) echo 'selected="selected"' ?>>50</option>
                                <option value="100" <?php if ($limit == 100) echo 'selected="selected"' ?>>100</option>
                                <option value="500" <?php if ($limit == 500) echo 'selected="selected"' ?>>500</option>
                            </select>&nbsp; <?= __('records per page') ?>
                        </label>
                    </div>
                </div>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 10px">
                                <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                            </th>
                            <th><?php echo $this->Paginator->sort('SheetRideDetailRides.reference', __('Reference')); ?></th>
                            <th><?php echo $this->Paginator->sort('Reservation.car_id', __('Car')); ?></th>
                            <th><?php echo $this->Paginator->sort('Car.supplier_id', __('Supplier')); ?></th>
                            <th><?php echo $this->Paginator->sort('Reservation.cost', __('Cost')); ?></th>
                            <th><?php echo $this->Paginator->sort('TransportBillDetailRides.price_ht', __('Price')); ?></th>
                            <th><?php echo $this->Paginator->sort('Reservation.amount_remaining', __('Amount remaining')); ?></th>
                            <th><?php echo $this->Paginator->sort('Reservation.advanced_amount', __('Advanced amount')); ?></th>
                            <th><?php echo $this->Paginator->sort('SheetRideDetailRides.price_recovered', __('Price recovered')); ?></th>
                            <th><?php echo $this->Paginator->sort('SheetRideDetailRides.start_date', __('Start date')); ?></th>
                            <th><?php echo $this->Paginator->sort('SheetRideDetailRides.end_date', __('End date')); ?></th>
                            <th><?php echo $this->Paginator->sort('Reservation.status', __('Status')); ?></th>
                            <th><?php echo $this->Paginator->sort('Payments.receipt_date', __('Payment date')); ?></th>


                        </tr>
                    </thead>
                    <tbody id="listeDiv">
                        <?php foreach ($reservations as $reservation) : ?>
                            <tr id="row<?= $reservation['Reservation']['id'] ?>">
                                <td>
                                    <input id="idCheck" type="checkbox" class='id' value=<?php echo $reservation['Reservation']['id'] ?>>
                                </td>
                                <td><?php echo h($reservation['SheetRideDetailRides']['reference']); ?></td>
                                <td><?php if ($param == 1) {
                                        echo $reservation['Car']['code'] . " - " . $reservation['Carmodel']['name'];
                                    } else if ($param == 2) {
                                        echo $reservation['Car']['immatr_def'] . " - " . $reservation['Carmodel']['name'];
                                    } ?></td>
                                <td>
                                    <input id="supplier-<?php echo $reservation['Reservation']['id'] ?>" type="hidden" class='supplier-id' value=<?php echo $reservation['Supplier']['id'] ?>>
                                    <?php echo h($reservation['Supplier']['name']); ?>&nbsp;
                                </td>
                                <td class="right">
                                    <?php if ($reservation['Reservation']['cost'] == 0) { ?>
                                        <div class="table-content editable">
                                            <span>
                                            </span>
                                            <input name="<?= $this->Reservation->encrypt("cost|" . $reservation['Reservation']['id']); ?>" placeholder="<?= __('Enter cost') ?>" value="<?= $reservation['Reservation']['cost'] ?>" class="form-control table-input cost" type="number">
                                        </div>
                                    <?php
                                    } else {
                                        echo h(number_format($reservation['Reservation']['cost'], 2, ",", $separatorAmount));
                                    } ?>
                                </td>
                                <td><?php
                                    if (!empty($reservation['TransportBillDetailRides']['nb_trucks']) && $reservation['TransportBillDetailRides']['nb_trucks'] > 0) {
                                        echo h(number_format($reservation['TransportBillDetailRides']['price_ht']
                                            / $reservation['TransportBillDetailRides']['nb_trucks'], 2, ",", $separatorAmount));
                                    }
                                    ?></td>
                                <td><?php echo h(number_format($reservation['Reservation']['amount_remaining'], 2, ",", $separatorAmount)) ?></td>
                                <td><?php echo h(number_format($reservation['Reservation']['advanced_amount'], 2, ",", $separatorAmount)) ?></td>
                                <td style='text-align: center;'>
                                    <?php
                                    switch ($reservation['SheetRideDetailRides']['price_recovered']) {
                                        case '1':
                                            echo '<span><i class="fa fa-check-circle-o fa-2x" style="color:green"></i></span>';
                                            break;
                                        case '2':
                                            echo '<span><i class="fa fa-times-circle-o fa-2x" style="color:red"></i></span>';
                                            break;
                                    } ?>
                                </td>
                                <td><?php if (!empty($reservation['SheetRideDetailRides']['real_start_date'])) {
                                        echo h($this->Time->format($reservation['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y %H:%M'));
                                    } else {
                                        echo h($this->Time->format($reservation['SheetRideDetailRides']['planned_start_date'], '%d-%m-%Y %H:%M'));
                                    } ?>&nbsp;
                                </td>
                                <td><?php if (!empty($reservation['SheetRideDetailRides']['real_end_date'])) {
                                        echo h($this->Time->format($reservation['SheetRideDetailRides']['real_end_date'], '%d-%m-%Y %H:%M'));
                                    } else {
                                        echo h($this->Time->format($reservation['SheetRideDetailRides']['planned_end_date'], '%d-%m-%Y %H:%M'));
                                    } ?>&nbsp;
                                </td>
                                <td><?php switch ($reservation['Reservation']['status']) {
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
                                <td><?php if (!empty($reservation['Payments']['receipt_date'])) {
                                        echo h($this->Time->format($reservation['Payments']['receipt_date'], '%d-%m-%Y %H:%M'));
                                    } ?>&nbsp;
                                </td>



                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="pagination" class="pull-right">
                    <?php
                    if ($this->params['paging']['Reservation']['pageCount'] > 1) {
                    ?>
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?> </p>
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php
                                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                echo $this->Paginator->numbers(array(
                                    'tag' => 'li',
                                    'first' => false,
                                    'last' => false,
                                    'separator' => '',
                                    'currentTag' => 'a'
                                ));
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


<?php $this->start('script'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
<?= $this->Html->script('plugins/datetimepicker/moment-with-locales.min.js'); ?>
<?= $this->Html->script('plugins/datetimepicker/bootstrap-datetimepicker.min.js'); ?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
<?= $this->Html->script('jquery.number.min.js'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        jQuery('#link-print').mouseover(function() {
            //e.preventDefault();
            jQuery('#ul-print').slideToggle();
        }).mouseout(function() {
            jQuery('#ul-print').slideToggle();
        });

        jQuery("#date1").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        });
        jQuery("#date2").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        });

        jQuery("#startdatecreat").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        });
        jQuery("#enddatecreat").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        });

        jQuery("#startdatemodifie").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        });
        jQuery("#enddatemodifie").inputmask("dd/mm/yyyy", {
            "placeholder": "dd/mm/yyyy"
        });
        // Show the text box on click
        $('body').delegate('.editable', 'click', function() {
            var ThisElement = $(this);
            ThisElement.find('span').hide();
            ThisElement.find('.table-input').show().focus();
        });

        // Pass and save the textbox values on blur function
        $('body').delegate('.table-input', 'blur', function() {
            var ThisElement = $(this);
            ThisElement.hide();
            if ($(this).val() == "") {
                ThisElement.val('');
            }
            if (ThisElement.hasClass('number')) {
                if ($(this).val() == "") ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
                else
                    ThisElement.prev('span').show().html($.number($(this).val(), 0, ',', '.')).prop('title', $(this).val());

            } else if (ThisElement.hasClass('cost')) {
                if ($(this).val() == "") ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
                else
                    ThisElement.prev('span').show().html($.number($(this).val(), 2, ',', '.')).prop('title', $(this).val());
            } else if (ThisElement.hasClass('date')) {
                ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
            } else if (ThisElement.hasClass('select')) {
                ThisElement.prev('span').show().html($(this).find("option:selected").text());
            } else {
                ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
            }

            var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');

            jQuery.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url('/reservations/update/') ?>",
                data: UrlToPass,
                dataType: "json",
                success: function(json) {

                }
            });
        });

        // Same as the above blur() when user hits the 'Enter' key
        $('body').delegate('.table-input', 'keypress', function(e) {
            if (e.keyCode == '13') {
                var ThisElement = $(this);
                ThisElement.hide();
                if ($(this).val() == "") {
                    ThisElement.val('');
                }
                if (ThisElement.hasClass('number')) {
                    if ($(this).val() == "") ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
                    else
                        ThisElement.prev('span').show().html($.number($(this).val(), 0, ',', '.')).prop('title', $(this).val());

                } else if (ThisElement.hasClass('cost')) {
                    if ($(this).val() == "") ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
                    else
                        ThisElement.prev('span').show().html($.number($(this).val(), 2, ',', '.')).prop('title', $(this).val());
                } else if (ThisElement.hasClass('date')) {
                    ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
                } else if (ThisElement.hasClass('select')) {
                    ThisElement.prev('span').show().html($(this).find("option:selected").text());
                } else {
                    ThisElement.prev('span').show().html($(this).val()).prop('title', $(this).val());
                }

                var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');

                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo $this->Html->url('/reservations/update/') ?>",
                    data: UrlToPass,
                    dataType: "json",
                    success: function(json) {

                    }
                });
            }
        });
    });

    function printReservationPerSupplier() {
        var conditions = new Array();
        conditions[0] = jQuery('#car').val();
        conditions[1] = jQuery('#supplier').val();
        conditions[2] = jQuery('#date1').val();
        conditions[3] = jQuery('#date2').val();
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function() {
            myCheckboxes.push(jQuery(this).val());
        });
        var url = '<?php echo $this->Html->url(array('action' => 'printReservationPerSupplier', 'ext' => 'pdf')) ?>';
        var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="printReservationPerSupplier" value="' + conditions + '" />' +
            '<input type="text" name="chkids" value="' + myCheckboxes + '" />' +
            '</form>');
        jQuery('body').append(form);
        form.submit();
    }

    function printReservationPerCar() {
        var conditions = new Array();
        conditions[0] = jQuery('#car').val();
        conditions[1] = jQuery('#supplier').val();
        conditions[2] = jQuery('#date1').val();
        conditions[3] = jQuery('#date2').val();
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function() {
            myCheckboxes.push(jQuery(this).val());
        });
        var url = '<?php echo $this->Html->url(array('action' => 'printReservationPerCar', 'ext' => 'pdf')) ?>';
        var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="printReservationPerCar" value="' + conditions + '" />' +
            '<input type="text" name="chkids" value="' + myCheckboxes + '" />' +
            '</form>');
        jQuery('body').append(form);
        form.submit();
    }

    function printSubcontractorState() {

        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function() {
            myCheckboxes.push(jQuery(this).val());
        });
        if (myCheckboxes.length > 0) {

            var suppliers = new Array();
            for (var i = 0; i < myCheckboxes.length; i++) {
                if (suppliers.includes(jQuery('#supplier-' + '' + myCheckboxes[i] + '').val()) == false) {
                    suppliers.push(jQuery('#supplier-' + '' + myCheckboxes[i] + '').val());
                }
            }
        }

        if (suppliers.length == 0) {
            alert("<?php echo __('Select atleast one subcontractor, please.') ?>");
        } else {
            var myCheckboxes = new Array();
            jQuery('.id:checked').each(function() {
                myCheckboxes.push(jQuery(this).val());
            });

            var conditions = new Array();
            conditions[0] = suppliers.join("**");
            conditions[1] = jQuery('#car').val();
            conditions[2] = jQuery('#order_type').val();
            conditions[3] = jQuery('#cost').val();
            conditions[4] = jQuery('#date1').val();
            conditions[5] = jQuery('#date2').val();
            var url = '<?php echo $this->Html->url(
                            array('action' => 'printSubcontractorState', 'ext' => 'pdf'),
                            array('target' => '_blank')
                        ) ?>';
            var form = jQuery('<form action="' + url + '" method="post" target="_Blank" >' +
                '<input type="hidden" name="printSubcontractorState" value="' + conditions + '" />' +
                '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
                '</form>');
            jQuery('body').append(form);
            form.submit();
        }
    }
</script>
<?php $this->end(); ?>