<?php

$this->start('css');

echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->Html->css('select2/select2.min');
$this->end();
?>
<h4 class="page-title"> <?= __('Search'); ?></h4>
<div class="box-body">
    <div class="panel-group wrap" id="bs-collapse">
        <div class="panel loop-panel">
            <a class="collapsed fltr" data-toggle="collapse" data-parent="#" href="#one">
                <i class="zmdi zmdi-search-in-page"></i>
            </a>
            <a class="collapsed grp_actions_icon fltr" data-toggle="collapse" data-parent="#" href="#grp_actions">
                <i class="fa fa-toggle-down"></i>
            </a>
            <div id="one" class="panel-collapse">
                <div class="panel-body">
                    <?php echo $this->Form->create('Consumptions', array(
                        'url' => array(
                            'action' => 'search'
                        ),
                        'novalidate' => true
                    )); ?>
                    <div class="filters" id='filters'>
                        <input name="conditions" type="hidden"
                               id="conditions"
                               value="<?php echo base64_encode(serialize($conditions)); ?>">
                        <?php  if (isset($this->params['named']['car']) && !empty($this->params['named']['car'])) { ?>
                        <input name="carId" type="hidden"
                               id="car_id"
                               value="<?php echo $this->params['named']['car'] ?>">
                        <?php }else { ?>
                            <input name="carId" type="hidden"
                                   id="car_id"
                                   value="">
                        <?php } ?>
                        <?php
                        echo $this->Form->input('car_id', array(
                            'label' => __('Car'),
                            'class' => 'form-filter select-search-car',
                            'id'=>'car',
                            'empty' => ''
                        ));
                        echo $this->Form->input('car_type_id', array(
                            'id' => 'car_type',
                            'type' => 'hidden',
                        ));
                        echo $this->Form->input('parc_id', array(
                            'label' => __('Parc'),
                            'class' => 'form-filter select2',
                            'empty' => ''
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('customer_id', array(
                            'label' => __('Conducteur'),
                            'class' => 'form-filter select-search-customer',
                            'id' => 'customer',
                            'empty' => ''
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        $options = array('0' => '');
                        if ($paramConsumption['0'] == 1) {
                            if ($options != null) {
                                $options = array_replace($options, array('1' => __('Coupons')));
                            } else {
                                $options = array('1' => __('Coupons'));
                            }
                        }
                        if ($paramConsumption['1'] == 1) {
                            if ($options != null) {
                                $options = array_replace($options, array('2' => __('Species')));
                            } else {
                                $options = array('2' => __('Species'));
                            }
                        }
                        if ($paramConsumption['2'] == 1) {
                            if ($options != null) {
                                $options = array_replace($options, array('3' => __('Tank')));
                            } else {
                                $options = array('3' => __('Tank'));
                            }
                        }
                        if ($paramConsumption['3'] == 1) {
                            if ($options != null) {
                                $options = array_replace($options, array('4' => __('Cards')));
                            } else {
                                $options = array('4' => __('Cards'));
                            }
                        }

                        echo $this->Form->input('payment_mode', array(
                            'label' => __('Fuel filling mode'),
                            'type' => 'select',
                            'options' => $options,
                            'class' => 'form-filter select2',
                            'id'=>'type_consumption',
                            'onchange' => 'javascript : getInformationConsumptionMethod();',
                            'empty' => ''
                        ));

                        echo "<div id='consumption-method'></div>";

                        echo "<div style='clear:both; padding-top: 10px;'></div>";

                        echo $this->Form->input('consumption_date1', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Date from') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'consumption_date1',
                        ));
                        echo $this->Form->input('consumption_date2', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'consumption_date2',
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

    <div class="row collapse" id="grp_actions">

        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">

                        <div class="header_actions">
                            <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                array('action' => 'Add'),
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                            <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                'javascript:submitDeleteForm("consumptions/deleteConsumptions/");',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                    'disabled' => 'true'),
                                __('Are you sure you want to delete selected consumptions ?')); ?>
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
                                        <?= $this->Html->link(__('State of consumption'), 'javascript:printConsumptionState();') ?>
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

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <?php echo $this->Form->create('Consumptions', array(
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

                <?= $this->Form->input('current_action', array(
                    'id' => 'current_action',
                    'value' => $this->request->params['action'],
                    'type' => 'hidden'
                )); ?>

                <?= $this->Form->input('action', array(
                    'id' => 'action',
                    'value' => 'liste',
                    'type' => 'hidden'
                )); ?>

                <div class="col-sm-6">

                    <div class="dataTables_length" id="datatable-editable_length" style="display: inline-block;">
                        <label>
                            <?php
                            if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                            ?>
                            <select aria-controls="datatable-editable" class="form-control input-sm" name="slctlimit"
                                    id="slctlimit" onchange="slctlimitChanged('consumptions/index');">
                                <option value="20" <?php if ($limit == 20) echo 'selected="selected"' ?>>20</option>
                                <option value="25" <?php if ($limit == 25) echo 'selected="selected"' ?>>25</option>
                                <option value="50" <?php if ($limit == 50) echo 'selected="selected"' ?>>50</option>
                                <option value="100" <?php if ($limit == 100) echo 'selected="selected"' ?>>100</option>
                                <option value="500" <?php if ($limit == 500) echo 'selected="selected"' ?>>500</option>
                            </select>&nbsp; <?= __('records per page') ?>
                        </label>
                    </div>
                </div>
                <table  id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                        cellspacing="0" width="100%">

                    <thead>
                    <tr>
                        <th style="width: 10px">
                            <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i
                                        class="fa fa-square-o"></i></button>
                        </th>
                        <th><?php echo $this->Paginator->sort('sheetRides.reference',__('Reference').' '. __('sheet ride')); ?></th>
						<th><?php echo $this->Paginator->sort('Car.code',__('Car')); ?></th>
                        <th><?php echo $this->Paginator->sort('Customer.first_name',__('Customer')); ?></th>
                        <th><?php echo $this->Paginator->sort('type_consumption_used', __('Consumption type')); ?></th>
                        <th><?php echo $this->Paginator->sort('consumption_date', __('Date')); ?></th>
                        <?php  if ($paramConsumption['0'] == 1) { ?>
                            <th><?php echo $this->Paginator->sort('nb_coupon', __('Nb coupons')); ?></th>
                            <th><?php echo $this->Paginator->sort('first_number_coupon', __('First number coupon')); ?></th>
                            <th><?php echo $this->Paginator->sort('last_number_coupon', __('Last number coupon')); ?></th>
                            <th><?php echo $this->Paginator->sort('', __('Serial numbers')); ?></th>
                        <?php } ?>
                        <?php  if ($paramConsumption['1'] == 1) { ?>
                            <th><?php echo $this->Paginator->sort('species', __('Species')); ?></th>
                        <?php } ?>
                        <?php  if ($paramConsumption['2'] == 1) { ?>
                            <th><?php echo $this->Paginator->sort('tank_id', __('Tank')); ?></th>
                            <th><?php echo $this->Paginator->sort('consumption_liter', __('Consumption liter')); ?></th>
                        <?php } ?>
                        <?php  if ($paramConsumption['3'] == 1) { ?>
                            <th><?php echo $this->Paginator->sort('fuel_card_id', __('Cards')); ?></th>
                            <th><?php echo $this->Paginator->sort('species_card', __('Species card')); ?></th>
                        <?php } ?>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;
                    $coupons = array();
                    foreach ($consumptions as $consumption) {
                        $i++;
                        if ($i < count($consumptions)) {

                            if ($consumptions[$i]['Consumption']['id'] == $consumption['Consumption']['id']) {
                                $coupons[] = $consumption['Coupon']['serial_number'];
                            } else {
                                $coupons[] = $consumption['Coupon']['serial_number'];
                                ?>
                                <tr id="row<?= $consumption['Consumption']['id'] ?>" >
                                    <td>
                                        <input id="idCheck" type="checkbox" class='id'
                                               value=<?php echo $consumption['Consumption']['id'] ?>>
                                    </td>

                                    <td><?php echo $consumption['SheetRide']['reference'] ?> </td>
									<td><?php
                                        if (!empty($consumption['Car']['code'])){
                                            if ($param==1){
                                                echo $consumption['Car']['code']." / ".$consumption['Carmodel']['name'];
                                            } else if ($param==2) {
                                                echo $consumption['Car']['immatr_def']." / ".$consumption['Carmodel']['name'];
                                            }
                                        }else{
                                            if ($param==1){
                                                echo $consumption['SheetRideCar']['code']." / ".$consumption['SheetRideCarmodel']['name'];
                                            } else if ($param==2) {
                                                echo $consumption['SheetRideCar']['immatr_def']." / ".$consumption['SheetRideCarmodel']['name'];
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><?php if (!empty($consumption['Customer']['first_name'])){
                                            echo $consumption['Customer']['first_name'] .' - '.$consumption['Customer']['last_name'];
                                        }else{
                                            echo $consumption['SheetRideCustomer']['first_name'] .' - '.$consumption['SheetRideCustomer']['last_name'];
                                        } ?> </td>

                                    <?php
                                    switch($consumption['Consumption']['type_consumption_used']){
                                        case ConsumptionTypesEnum::coupon : ?>
                                            <?php  if ($paramConsumption['0'] == 1) { ?>
                                                <td> <?php echo __('Coupons'); ?></td>
                                                <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M'));?> </td>
                                                <td><?php echo h($consumption['Consumption']['nb_coupon']);?> </td>
                                                <td><?php echo h($consumption['Consumption']['first_number_coupon']);?></td>
                                                <td><?php echo h($consumption['Consumption']['last_number_coupon']);?></td>
                                                <td>
                                                    <?php
                                                    $nbCoupons = count($coupons);
                                                    $j = 1;
                                                    foreach ($coupons as $coupon) {
                                                        if ($j == $nbCoupons) {
                                                            echo $coupon;
                                                        } else {
                                                            echo $coupon . ' , ';
                                                        }
                                                        $j++;
                                                    } ?>
                                                </td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['1'] == 1) { ?>
                                                <td></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['2'] == 1) { ?>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['3'] == 1) { ?>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <?php break;
                                        case ConsumptionTypesEnum::species: ?>
                                            <td> <?php echo __('Species');?></td>
                                            <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M'));?></td>
                                            <?php  if ($paramConsumption['0'] == 1) { ?>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['1'] == 1) { ?>
                                                <td><?php echo h($consumption['Consumption']['species']);?></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['2'] == 1) { ?>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['3'] == 1) { ?>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <?php break;
                                        case ConsumptionTypesEnum::tank: ?>
                                            <td> <?php echo __('Tank');?></td>
                                            <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M'));?></td>
                                            <?php  if ($paramConsumption['0'] == 1) { ?>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['1'] == 1) { ?>
                                                <td></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['2'] == 1) { ?>
                                                <td><?php echo h($consumption['Tank']['name']);?></td>
                                                <td><?php echo h($consumption['Consumption']['consumption_liter']);?></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['3'] == 1) { ?>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <?php break;
                                        case ConsumptionTypesEnum::card: ?>
                                            <td> <?php echo __('Cards');?></td>
                                            <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M'));?></td>
                                            <?php  if ($paramConsumption['0'] == 1) { ?>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['1'] == 1) { ?>
                                                <td></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['2'] == 1) { ?>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['3'] == 1) { ?>
                                                <td><?php echo h($consumption['FuelCard']['reference']);?></td>
                                                <td><?php echo number_format($consumption['Consumption']['species_card'], 2, ",", ".");?></td>
                                            <?php } ?>
                                            <?php break;
                                    } ?>
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
                                                        array('action' => 'View', $consumption['Consumption']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-success')
                                                    ); ?>
                                                </li>

                                                <li>
                                                    <?= $this->Html->link(
                                                        '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                        array('action' => 'Edit', $consumption['Consumption']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-primary')
                                                    ); ?>
                                                </li>

                                                <li>
                                                    <?php
                                                    echo $this->Form->postLink(
                                                        '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                        array('action' => 'delete', $consumption['Consumption']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-danger'),
                                                        __('Are you sure you want to delete %s?', $consumption['SheetRide']['reference'])); ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>







                                </tr>

                                <?php  $consumptionId = $consumption['Consumption']['id'];
                                $coupons = array();
                            }


                        } else {

                            $coupons[] = $consumption['Coupon']['serial_number'];


                            ?>


                            <tr id="row<?= $consumption['Consumption']['id'] ?>" >
                                <td>

                                    <input id="idCheck" type="checkbox" class='id'
                                           value=<?php echo $consumption['Consumption']['id'] ?>>
                                </td>
                                <td><?php echo $consumption['SheetRide']['reference'] ?> </td>
									<td><?php
                                        if ($param==1){
                                            echo $consumption['Car']['code']." - ".$consumption['Carmodel']['name'];
                                        } else if ($param==2) {
                                            echo $consumption['Car']['immatr_def']." - ".$consumption['Carmodel']['name'];
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $consumption['Customer']['first_name'] .' - '.$consumption['Customer']['last_name'] ?> </td>

                                <?php
                                switch($consumption['Consumption']['type_consumption_used']){
                                    case ConsumptionTypesEnum::coupon : ?>
                                        <td> <?php echo __('Coupons'); ?></td>
                                        <?php  if ($paramConsumption['0'] == 1) { ?>
                                            <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M'));?> </td>
                                            <td><?php echo h($consumption['Consumption']['nb_coupon']);?> </td>
                                            <td><?php echo h($consumption['Consumption']['first_number_coupon']);?></td>
                                            <td><?php echo h($consumption['Consumption']['last_number_coupon']);?></td>
                                            <td>
                                                <?php
                                                $nbCoupons = count($coupons);
                                                $j = 1;
                                                foreach ($coupons as $coupon) {
                                                    if ($j == $nbCoupons) {
                                                        echo $coupon;
                                                    } else {
                                                        echo $coupon . ' , ';
                                                    }
                                                    $j++;
                                                } ?>
                                            </td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['1'] == 1) { ?>
                                            <td></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['2'] == 1) { ?>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['3'] == 1) { ?>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php break;
                                    case ConsumptionTypesEnum::species: ?>
                                        <td> <?php echo __('Species');?></td>
                                        <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M'));?></td>
                                        <?php  if ($paramConsumption['0'] == 1) { ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['1'] == 1) { ?>
                                            <td><?php echo h($consumption['Consumption']['species']);?></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['2'] == 1) { ?>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['3'] == 1) { ?>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php break;
                                    case ConsumptionTypesEnum::tank: ?>
                                        <td> <?php echo __('Tank');?></td>
                                        <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M'));?></td>
                                        <?php  if ($paramConsumption['0'] == 1) { ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['1'] == 1) { ?>
                                            <td></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['2'] == 1) { ?>
                                            <td><?php echo h($consumption['Tank']['name']);?></td>
                                            <td><?php echo h($consumption['Consumption']['consumption_liter']);?></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['3'] == 1) { ?>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php break;
                                    case ConsumptionTypesEnum::card: ?>
                                        <td> <?php echo __('Cards');?></td>
                                        <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M'));?></td>
                                        <?php  if ($paramConsumption['0'] == 1) { ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['1'] == 1) { ?>
                                            <td></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['2'] == 1) { ?>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['3'] == 1) { ?>
                                            <td><?php echo h($consumption['FuelCard']['reference']);?></td>
                                            <td><?php echo number_format($consumption['Consumption']['species_card'], 2, ",", ".");?></td>
                                        <?php } ?>
                                        <?php break;
                                }

                                ?>
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
                                                    array('action' => 'View', $consumption['Consumption']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-success')
                                                ); ?>
                                            </li>

                                            <li>
                                                <?= $this->Html->link(
                                                    '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                    array('action' => 'Edit', $consumption['Consumption']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-primary')
                                                ); ?>
                                            </li>

                                            <li>
                                                <?php
                                                echo $this->Form->postLink(
                                                    '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                    array('action' => 'delete', $consumption['Consumption']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-danger'),
                                                    __('Are you sure you want to delete %s?', $consumption['SheetRide']['reference'])); ?>
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


                <div id="pagination" class="pull-right">
                    <?php
                    if ($this->params['paging']['Consumption']['pageCount'] > 1) {
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
                <br/>
                <br/>

            </div>
        </div>
    </div>
</div>
<div class="card-box">
    <ul class="list-group m-b-15 user-list">
        <?php echo "<div class='total'><span class='col-lg-3 col-xs-6'><b>" . __('Transactions sum :  ') . '</b><span class="badge bg-red">' .
            number_format($sumCost, 2, ",", ".") . " " . $this->Session->read('currency') . "</span> </span>";
        echo "<span class='col-lg-3 col-xs-6'><b>" . __('Consumptions sum :  ') . '</b><span class="badge bg-red">' .
            number_format($sumConsumption, 2, ",", ".");
        if ($sumConsumption > 0) echo " " . __('Liter') . "s</span> </span>";
        else echo " " . __('Liter') . "</span> </span>";
        echo "<span class='col-lg-3 col-xs-6'><b>" . __('Kms sum :  ') . '</b><span class="badge bg-red">' .
            number_format($sumKm, 2, ",", ".") . " " . __('Km') . "</span> </span></div>"; ?>
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
        jQuery("#consumption_date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#consumption_date2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        jQuery("#start_date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#start_date2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        jQuery("#end_date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#end_date2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    });

    function getInformationConsumptionMethod() {
        var typeConsumption = jQuery('#type_consumption').val();
        jQuery("#consumption-method").load('<?php echo $this->Html->url('/consumptions/getInformationConsumptionMethod/')?>' + typeConsumption , function () {
            $('.select3').select2();
        });
    }

    function printConsumptionState() {


        var conditions = jQuery('#conditions').val();

        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });



        var carId = jQuery('#car_id').val();
        var typeConsumption = jQuery('#type_consumption').val();
        var startDate = jQuery('#consumption_date1').val();
        var endDate = jQuery('#consumption_date2').val();

        var url = '<?php echo $this->Html->url(array('action' => 'printConsumptionState', 'ext' => 'pdf'),
            array('target' => '_blank'))?>';
        var form = jQuery('<form action="' + url + '" method="post" target="_Blank" >' +
            '<input type="hidden" name="printConsumptionState" value="' + '' + '" />' +
            '<input type="hidden" name="conditions" value="' + conditions + '" />' +
            '<input type="hidden" name="carId" value="' + carId + '" />' +
            '<input type="hidden" name="typeConsumption" value="' + typeConsumption + '" />' +
            '<input type="hidden" name="startDate" value="' + startDate + '" />' +
            '<input type="hidden" name="endDate" value="' + endDate + '" />' +
            '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
            '</form>');
        jQuery('body').append(form);
        form.submit();
    }
</script>
<?php $this->end(); ?>
