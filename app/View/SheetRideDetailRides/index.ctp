<style>
    .actions {
        width: 70px;
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
echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->Html->css('select2/select2.min');
$this->end();
?>
<div id="msg"></div>
<h4 class="page-title"> <?= __('Missions'); ?></h4>
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

                    <?php echo $this->Form->create('SheetRideDetailRide', array(
                        'url' => array(
                            'action' => 'index'
                        ),
                        'novalidate' => true
                    )); ?>

                    <div class="filters" id='filters'>

                        <?php
                        echo $this->Form->input('car_id', array(
                            'label' => __('Car'),
                            'class' => 'form-filter select-search-car',
                            'empty' => ''
                        ));
                        echo $this->Form->input('customer_id', array(
                            'label' => __('Conducteur'),
                            'class' => 'form-filter select-search-customer',
                            'id' => 'customer',
                            'empty' => ''
                        ));

                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('detail_ride_id', array(
                            'label' => __('Ride'),
                            'class' => 'form-filter select-search-detail-ride',
                            'empty' => ''
                        ));
                        echo $this->Form->input('parc_id', array(
                            'label' => __('Parc'),
                            'class' => 'form-filter select2',
                            'empty' => ''
                        ));

                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('supplier_initial_id', array(
                            'label' => __('Client'),
                            'class' => 'form-filter select2',
                            'id' => 'supplier',
                            'options'=>$suppliers,
                            'empty' => ''
                        ));
                        $options = array('1' => __('Planned'), '2' => __('In progress'), '3' => __('Closed'), '4' => __('Preinvoiced'), '5' => __('Approved'), '6' => __('Not approved'), '7' => __('Invoiced'));
                        echo $this->Form->input('status_id', array(
                            'label' => __('Status'),
                            'class' => 'form-filter select2',
                            'options' => $options,
                            'id' => 'status',
                            'empty' => ''
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('supplier_id', array(
                            'label' => __('Subcontractor'),
                            'class' => 'form-filter select2',
                            'id' => 'subcontractor',
                            'options'=>$subcontractors,
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
                        echo $this->Form->input('start_date1', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Departure date from') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'start_date1',
                        ));
                        echo $this->Form->input('start_date2', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'start_date2',
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('end_date1', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Arrival date from') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'end_date1',
                        ));
                        echo $this->Form->input('end_date2', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'end_date2',
                        ));


                        if ($isSuperAdmin) {
                            echo "<div style='clear:both; padding-top: 40px;'></div>";

                            echo '<div class="lbl"> <a href="#demo" data-toggle="collapse"><i class="fa fa-search"></i>' . __("  Administrative filter") . '</a></div>';

                            ?>


                            <div id="demo" class="collapse">
                                <div
                                    style="clear:both; padding-top: 0px;padding-left: 20px;  border-bottom: 1px solid rgb(204, 204, 204);margin-bottom: 15px;"></div>


                                <?php
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
    /** @var array $entityName */
    /** @var string $tableName */
    $query = $this->Session->read('query');
    extract($query);

    ?>
    <div class="row collapse" id="grp_actions">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <?php if (!$isAgent) { ?>
                            <div class="header_actions">

                                <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                    array('controller'=>'sheetRides','action' => 'Add'),
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>

                                <?= $this->Html->link('<i class=" fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                    'javascript:;',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                        /*'disabled' => 'true'*/)
                                ); ?>
                            </div>
                        <?php } ?>
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

                <?php
                $tableId = strtolower($tableName) . '-grid';
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

                <!--    DataTables Script    -->
                <?= $this->element('data-tables-script', array(
                    "tableId" => $tableId,
                    "tableName" => $tableName,
                    "columns" => $columns,
                    "defaultLimit" => $defaultLimit,
                ));
                ?>
                <!--    End dataTables Script    -->
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

        jQuery("#start_date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#start_date2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#end_date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#end_date2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        jQuery('input.checkall').on('ifClicked', function (event) {
            var cases = jQuery(":checkbox.id");
            if (jQuery('#checkall').prop('checked')) {
                cases.iCheck('uncheck');
                jQuery("#add_pay").attr("disabled", "true");
            } else {
                cases.iCheck('check');
                jQuery("#add_pay").removeAttr("disabled");
            }

        });

        jQuery('input.id').on('ifUnchecked', function (event) {
            var ischecked = false;
            jQuery(":checkbox.id").each(function () {
                if (jQuery(this).prop('checked'))
                    ischecked = true;
            });
            if (!ischecked) {
                jQuery("#add_pay").attr("disabled", "true");
            }
        });

        jQuery('input.id').on('ifChecked', function (event) {
            jQuery("#add_pay").removeAttr("disabled");
        });

        jQuery("#dialogModalMissions").dialog({
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

    });

</script>
<?php $this->end(); ?>
