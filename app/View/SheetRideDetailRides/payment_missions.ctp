<style>
    .actions {
        width: 70px;
    }
</style>
<?php

$this->start('css');
echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->Html->css('select2/select2.min');
$this->end();

?>
<div id="msg"></div>
<h4 class="page-title"> <?=__('Missions'); ?></h4>
<div class="box-body">



    <div class="panel-group wrap" id="bs-collapse">



        <div class="panel">
            <div class="panel-heading" style="background-color: #435966; color: #fff;">
                <h4 class="panel-title">
                    <a class="collapsed" data-toggle="collapse" data-parent="#" href="#one">
                        <?php echo __('Search') ?>
                    </a>
                </h4>
            </div>
            <div id="one" class="panel-collapse collapse">
                <div class="panel-body">

                    <?php echo $this->Form->create('SheetRideDetailRide', array(
                        'url'=> array(
                            'action' => 'search'
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
                            'class' => 'form-filter select2',
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
                            'class' => 'form-filter select2',
                            'id' => 'supplier',
                            'empty' => ''
                        ));
                        $options=array('1'=>__('Planned'),'2'=>__('In progress'), '3'=>__('Closed'),'4'=>__('Preinvoiced'), '5'=>__('Approved'), '6'=>__('Not approved'), '7'=>__('Invoiced'));

                        echo $this->Form->input('status_id', array(
                            'label' => __('Status'),
                            'class' => 'form-filter select2',
                            'options'=>$options,
                            'id' => 'status',
                            'empty' => ''
                        ));


                        echo "<div style='clear:both; padding-top: 10px;'></div>";

                        echo $this->Form->input('start_date1', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">'.__('Departure date from').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'start_date1',
                        ));
                        echo $this->Form->input('start_date2', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">'.__('to date').'</label><div class="input-group date"><div class="input-group-addon">
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
                            'before' => '<label class="dte">'.__('Arrival date from').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'end_date1',
                        ));
                        echo $this->Form->input('end_date2', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">'.__('to date').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'end_date2',
                        ));



                        echo "<div style='clear:both; padding-top: 40px;'></div>";

                        echo '<div class="lbl"> <a href="#demo" data-toggle="collapse"><i class="fa fa-search"></i>'.__("  Administrative filter").'</a></div>';

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


                            <?php if ($client_i2b == 1) { ?>
                                <?= $this->Html->link('<i class="fa fa-refresh m-r-5"></i>' . __('Synchronize'), array('action' => 'synchronisationMissions'),

                                    array('escape' => false, 'class' => "btn btn-inverse btn-bordred waves-effect waves-light m-b-5")) ?>

                            <?php } else { ?>

                                <?= $this->Html->link('<i class="fa fa-refresh m-r-5"></i><span>' . __('Synchronize').'</span>', array('action' => 'synchronisationMissions'),

                                    array('escape' => false, 'class' => "btn btn-inverse btn-bordred waves-effect waves-light m-b-5", 'disabled' => 'true')) ?>

                            <?php }

                            if ($settleMissions==1) {
                                ?>
                                <?= $this->Html->link('<i class="fa fa-money m-r-5"></i><span>' . __('Payments').'</span>', array('action' => 'paymentMissions'),

                                    array('escape' => false, 'class' => "btn btn-inverse btn-bordred waves-effect waves-light m-b-5"));
                            }
                            ?>

                        </div>
                    </div>

                    <div style='clear:both; padding-top: 10px;'></div>

                </div>
                <div id="dialogModalMissions">
                    <!-- the external content is loaded inside this tag -->

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <?php echo $this->Form->create('SheetRideDetailRide', array(
                    'url'=> array(
                        'action' => 'search'
                    ),
                    'novalidate' => true,
                    'id'=>'searchKeyword'
                )); ?>
                <label style="float: right;">
                    <input  id='keyword' type="text" name="keyword" id="keyword" class="form-control" placeholder= <?= __("Search"); ?>>


                </label>
                <?php echo $this->Form->end(); ?>

                <div class="col-sm-6">
                    <div class="dataTables_length m-r-15" id="datatable-editable_length" style="display: inline-block;">
                        <label>&nbsp; <?= __('Order : ') ?>
                            <?php
                            if (isset($this->params['pass']['1'])) $order = $this->params['pass']['1'];
                            ?>
                            <select  aria-controls="datatable-editable" class="form-control input-sm" name="selectOrder" id="selectOrder" onchange="selectOrderChanged('sheetRideDetailRides/index');">
                                <option value="1" <?php if ($order == 1) echo 'selected="selected"' ?>> <?= __('Reference') ?></option>
                                <option value="2" <?php if ($order == 2) echo 'selected="selected"' ?>><?= __('Id') ?></option>
                                <option value="3" <?php if ($order == 3) echo 'selected="selected"' ?>><?= __('Start date') ?></option>
                                <option value="4" <?php if ($order == 4) echo 'selected="selected"' ?>><?= __('End date') ?></option>

                            </select>
                        </label>
                    </div>
                    <div class="dataTables_length" id="datatable-editable_length" style="display: inline-block;">
                        <label>
                            <?php
                            if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                            ?>
                            <select  aria-controls="datatable-editable" class="form-control input-sm" name="slctlimit" id="slctlimit" onchange="slctlimitChanged('sheetRideDetailRides/index');">
                                <option value="20" <?php if ($limit == 20) echo 'selected="selected"' ?>>20</option>
                                <option value="25" <?php if ($limit == 25) echo 'selected="selected"' ?>>25</option>
                                <option value="50" <?php if ($limit == 50) echo 'selected="selected"' ?>>50</option>
                                <option value="100" <?php if ($limit == 100) echo 'selected="selected"' ?>>100</option>
                                <option value="500" <?php if ($limit == 500) echo 'selected="selected"' ?>>500</option>
                            </select>&nbsp; <?= __('records per page') ?>
                        </label>
                    </div>
                </div>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"                            cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class='case'style="width: 10px">
                            <button type="button" id ='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                        </th>
                        <th><?php echo __('Reference'); ?></th>
                        <th><?php echo  __('Mission'); ?></th>
                        <th><?php echo __('Client'); ?></th>
                        <th><?= __('Unit price') ?></th>
                        <th><?= __('Ristourne') ?></th>
                        <th><?= __('Price HT') ?></th>
                        <th><?= __('TVA') ?></th>
                        <th><?= __('Price TTC') ?></th>

                        <th><?php echo  __('Status'); ?></th>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    </thead>

                    <tbody >
                    <?php foreach($missions as $mission) {
                        $priceTva =  $mission['price_ttc'] - $mission['price_ht'];
                        ?>
                    <tr>
                        <td >

                            <input id="idCheck"type="checkbox" class = 'id' value=<?php echo $mission['id'] ?> >

                        </td>
                        <td><?php echo $mission['reference']?></td>
                        <td><?php echo $mission['DepartureDestination'].'-'.$mission['ArrivalDestination'].'-'.$mission['CarType']?></td>
                        <td><?php echo $mission['Supplier']?></td>
                        <td><?php echo number_format($mission['unit_price'], 2, ",", $separatorAmount)?></td>
                        <td><?php echo number_format($mission['ristourne_val'], 2, ",", $separatorAmount)?></td>
                        <td><?php echo number_format($mission['price_ht'], 2, ",", $separatorAmount)?></td>
                        <td><?php echo number_format($priceTva, 2, ",", $separatorAmount)?></td>
                        <td><?php echo number_format($mission['price_ttc'], 2, ",", $separatorAmount)?></td>
                        <td></td>
                        <td></td>
                     </tr>

                   <?php }?>



                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>
<div class="card-box">
    <ul class="list-group m-b-15 user-list">
        <?php
        $sumPayrollAmount = $sumMissionCost - $sumAmountRemaining;
        echo "<div class='total'><span class='col-lg-3 col-xs-6'><b>" . __('Cost mission sum : ') . '</b><span class="badge bg-red">' .
            number_format($sumMissionCost,2,",",".") . " " . $this->Session->read("currency") .  "</span> </span>";
        echo "<div class='total'><span class='col-lg-3 col-xs-6'><b>" . __('Payroll amount : ') . '</b><span class="badge bg-red">' .
            number_format($sumPayrollAmount,2,",",".") . " " . $this->Session->read("currency") .  "</span> </span>";
        echo "<div class='total'><span class='col-lg-3 col-xs-6'><b>" . __('Left to pay : ') . '</b><span class="badge bg-red">' .
            number_format($sumAmountRemaining,2,",",".") . " " . $this->Session->read("currency") .  "</span> </span>";?>
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





    $(document).ready(function() {

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
            } else
            {
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






    function payMissionCosts () {
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function(){
            myCheckboxes.push(jQuery(this).val());
        });

        jQuery('#dialogModalMissions').dialog('option', 'title', 'Payments');
        jQuery('#dialogModalMissions').dialog('open');
        jQuery('#dialogModalMissions').load('<?php echo $this->Html->url('/sheetRideDetailRides/payMissionCosts/')?>' + myCheckboxes);


    }

    function verifyIdCustomers() {
        link= '<?php echo $this->Html->url('/sheetRideDetailRides/verifyIdCustomers/')?>' ;

        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function(){
            myCheckboxes.push(jQuery(this).val());
        });



        jQuery.ajax({
            type: "POST",
            url: link,
            data: "ids=" + myCheckboxes,
            dataType: "json",
            success: function (json) {
                if (json.response === true) {

                    payMissionCosts();
                }else {

                    $("#msg").html('<div id="flashMessage" class="message"><div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?php echo __('Select a driver to pay mission costs'); ?></div></div>');

                    scrollToAnchor('container-fluid');
                }
            }
        });


    }










</script>
<?php $this->end(); ?>
