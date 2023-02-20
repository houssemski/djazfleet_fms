<?php


$this->start('css');
echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->Html->css('select2/select2.min');
$this->end();
?>
<div id="msg"></div>
<h4 class="page-title"> <?= __('Mission cost payments'); ?></h4>
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
                            'action' => 'searchMissionCosts'
                        ),
                        'novalidate' => true
                    )); ?>

                    <div class="filters" id='filters'>

                        <?php
                        echo $this->Form->input('car_id', array(
                            'label' => __('Car'),
                            'class' => 'form-filter select2',
                            'empty' => ''
                        ));
                        echo $this->Form->input('customer_id', array(
                            'label' => __('Conducteur'),
                            'class' => 'form-filter select2',
                            'id' => 'customer',
                            'empty' => ''
                        ));

                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('ride_id', array(
                            'label' => __('Ride'),
                            'id' => 'ride',
                            'class' => 'form-filter select-search',
                            'empty' => ''
                        ));
                        echo $this->Form->input('car_type_id', array(
                            'label' => __('Transportation'),
                            'class' => 'form-filter select2',
                            'empty' => ''
                        ));

                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('supplier_id', array(
                            'label' => __('Client'),
                            'class' => 'form-filter select-search-client-initial',
                            'id' => 'supplier',
                            'empty' => ''
                        ));
                        $options = array('1' => __('Yes'), '2' => __('No'));

                        echo $this->Form->input('paid_id', array(
                            'label' => __('Mission paid'),
                            'class' => 'form-filter select2',
                            'options' => $options,
                            'id' => 'paid',
                            'empty' => ''
                        ));


                        echo "<div style='clear:both; padding-top: 10px;'></div>";

                        echo $this->Form->input('date_from', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Date from') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'date_from',
                        ));

                        echo $this->Form->input('date_to', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Date from') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'date_to',
                        ));



                        ?>

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
                            <?php if ( $permissionPayment==1) { ?>
                            <?= $this->Html->link('<i class="fa fa-money m-r-5"></i>' . __('Pay mission costs'),
                                'javascript:verifyIdCustomers("3","addPayment");',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'payment',
                                    'disabled' => 'true')); ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">

                <div class="bloc-limit btn-group pull-left">
                    <div>
                        <label>
                            <?php
                            if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                            ?>
                            <select name="slctlimit" id="slctlimit"
                                    onchange="slctlimitChanged('payments/searchMissionCosts');">
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
                        <th class='case' style="width: 10px">
                            <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i
                                    class="fa fa-square-o"></i></button>
                        </th>
                        <th><?php echo $this->Paginator->sort('reference', __('Reference')); ?></th>
                        <th><?php echo $this->Paginator->sort('detail_ride_id', __('Mission')); ?></th>

                        <th><?php echo $this->Paginator->sort('car_id', __('Car')); ?></th>
                        <th><?php echo $this->Paginator->sort('customer_id', __("Customer")); ?></th>
                        <th><?php echo $this->Paginator->sort('sheetRideDetailRides.supplier_id', __('Initial customer')); ?></th>

                        <th><?php echo $this->Paginator->sort('real_start_date', __('Real Departure date')); ?></th>

                        <th><?php echo $this->Paginator->sort('sheetRideDetailRides.supplier_final_id', __('Final customer')); ?></th>

                        <th><?php echo $this->Paginator->sort('real_end_date', __('Real Arrival date')); ?></th>
                        <th><?php echo $this->Paginator->sort('mission_cost', __('Mission cost')); ?></th>
                        <th><?php echo $this->Paginator->sort('amount_remaining', __('Amount remaining')); ?></th>
                        <th><?php echo $this->Paginator->sort('status_id', __('Status')); ?></th>
                        <th class="actions"><?php echo __('Actions'); ?></th>

                    </tr>
                    </thead>

                    <tbody>

                    <?php


                    foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
                        ?>
                        <tr>
                            <td>
                                <?php if ($sheetRideDetailRide['SheetRideDetailRides']['amount_remaining'] > 0) { ?>
                                    <input id="idCheck" type="checkbox" class='id'
                                           value=<?php echo $sheetRideDetailRide['SheetRideDetailRides']['id'] ?>>
                                <?php } ?>
                            </td>
                            <td><?php echo $sheetRideDetailRide['SheetRideDetailRides']['reference'] ?></td>
                            <?php if($sheetRideDetailRide['SheetRideDetailRides']['type_ride']==1) {?>
                            <td><?= $sheetRideDetailRide['DepartureDestination']['name'] . '-' . $sheetRideDetailRide['ArrivalDestination']['name'] . '-' . $sheetRideDetailRide['CarType']['name']; ?></td>

                            <?php } else { ?>
                                <td><?= $sheetRideDetailRide['Departure']['name'] . '-' . $sheetRideDetailRide['Arrival']['name'] . '-' . $sheetRideDetailRide['CarType']['name']; ?></td>


                            <?php } ?>
                            <td> <?php if ($param == 1) {
                                    echo $sheetRideDetailRide['Car']['code'] . " - " . $sheetRideDetailRide['Carmodel']['name'];
                                } else if ($param == 2) {
                                    echo $sheetRideDetailRide['Car']['immatr_def'] . " - " . $sheetRideDetailRide['Carmodel']['name'];
                                } ?>

                            </td>
                            <td>
                                <?php

                                echo $sheetRideDetailRide['Customer']['first_name'] . " " . $sheetRideDetailRide['Customer']['last_name']; ?>
                                &nbsp;
                            </td>
                            <td><?= $sheetRideDetailRide['Supplier']['name'] ?></td>

                            <td><?php echo h($this->Time->format($sheetRideDetailRide['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y %H:%M')); ?>
                                &nbsp;</td>

                            <td><?= $sheetRideDetailRide['SupplierFinal']['name'] ?></td>

                            <td><?php echo h($this->Time->format($sheetRideDetailRide['SheetRideDetailRides']['real_end_date'], '%d-%m-%Y %H:%M')); ?>
                                &nbsp;</td>

                            <td><?php echo number_format($sheetRideDetailRide['SheetRideDetailRides']['mission_cost'], 2, ",", $separatorAmount) . ' ' . $this->Session->read("currency"); ?>
                                &nbsp;</td>

                            <td><?php echo number_format($sheetRideDetailRide['SheetRideDetailRides']['amount_remaining'], 2, ",", $separatorAmount) . ' ' . $this->Session->read("currency"); ?>
                                &nbsp;</td>

                            <td>
                                <?php switch ($sheetRideDetailRide['SheetRideDetailRides']['status_id']) {

                                    /*
                                    1: mission planifi�e
                                    2: mission en cours
                                    3: mission clotur�e
                                    4: mission pr�factur�e
                                    5: mission approuv�e
                                    6: mission non approuv�e
                                    7: mission factur�e
                                    */
                                    case 1:
                                        echo '<span class="label label-warning">';
                                        echo __('Planned') . "</span>";
                                        break;
                                    case 2:
                                        echo '<span class="label label-danger">';
                                        echo __('In progress') . "</span>";
                                        break;
                                    case 3:
                                        echo '<span class="label label-success">';
                                        echo h(__('Closed')) . "</span>";
                                        break;
                                        break;
                                    case 4:
                                        echo '<span class="label label-primary">';
                                        echo h(__('Preinvoiced')) . "</span>";
                                        break;
                                    case 5:
                                        echo '<span class="label label-pink">';
                                        echo h(__('Approved')) . "</span>";
                                        break;
                                    case 6:
                                        echo '<span class="label label-purple">';
                                        echo h(__('Not approved')) . "</span>";
                                        break;
                                    case 7:
                                        echo '<span class="label btn-inverse">';
                                        echo h(__('Invoiced')) . "</span>";
                                        break;

                                } ?>


                            </td>
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
                                                array('action' => 'viewDetailPaymentsMissionCost', $sheetRideDetailRide['SheetRideDetailRides']['id']),
                                                array('escape' => false, 'class' => 'btn btn-success')
                                            ); ?>
                                        </li>
                                    </ul>
                                </div>

                            </td>

                        </tr>
                    <?php } ?>

                    </tbody>

                </table>


                <div id="pagination">
                    <?php
                    if ($this->params['paging']['SheetRideDetailRides']['pageCount'] > 1) {
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
        <?php
        $sumPayrollAmount = $sumMissionCost - $sumAmountRemaining;
        echo "<div class='total'><span class='col-lg-3 col-xs-6'><b>" . __('Cost mission sum : ') . '</b><span class="badge bg-red">' .
            number_format($sumMissionCost, 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span>";
        echo "<div class='total'><span class='col-lg-3 col-xs-6'><b>" . __('Payroll amount : ') . '</b><span class="badge bg-red">' .
            number_format($sumPayrollAmount, 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span>";
        echo "<div class='total'><span class='col-lg-3 col-xs-6'><b>" . __('Left to pay : ') . '</b><span class="badge bg-red">' .
            number_format($sumAmountRemaining, 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span>";?>
    </ul>
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

        jQuery("#date_from").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#date_to").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});


    });


</script>
<?php $this->end(); ?>
