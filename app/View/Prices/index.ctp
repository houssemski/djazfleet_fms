<?php

$this->start('css');

echo $this->Html->css('select2/select2.min');
$this->end()
?><h4 class="page-title"> <?= __('Prices'); ?></h4>
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
                    <?php echo $this->Form->create('Prices', array(
                        'url' => array(
							'action' => 'search'
                        ),
                        'novalidate' => true
                    )); ?>
                    <div class="filters" id='filters'>
                        <?php
                        echo $this->Form->input('departure_destination_id', array(
                            'label' => __('Departure place'),
                            'class' => 'form-filter select2',
                            'options' => $destinations,
                            'id' => 'departure_destination',
                            'empty' => ''
                        ));
                        echo $this->Form->input('arrival_destination_id', array(
                            'label' => __('Arrival place'),
                            'class' => 'form-filter select2',
                            'options' => $destinations,
                            'id' => 'arrival_destination',
                            'empty' => ''
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('car_type_id', array(
                            'label' => __('Transportation'),
                            'class' => 'form-filter select2',
                            'options' => $carTypes,
                            'id' => 'car_type',
                            'empty' => ''
                        ));
                        if ($useRideCategory == 2) {
                            echo $this->Form->input('ride_category_id', array(
                                'label' => __('Ride category'),
                                'class' => 'form-filter select2',
                                'options' => $rideCategories,
                                'id' => 'ride_category',
                                'empty' => ''
                            ));
                        }
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('supplier_category_id', array(
                            'label' => __('Category'),
                            'class' => 'form-filter select2',
                            //'options'=>$carTypes,
                            'id' => 'supplier_category',
                            'empty' => ''
                        ));

                        echo $this->Form->input('supplier_id', array(
                            'label' => __('Client'),
                            'class' => 'form-filter select-search-client-initial',
                            //'options'=>$rideCategories,
                            'id' => 'supplier',
                            'empty' => ''
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('price_min', array(
                            'label' => __('Price min'),
                            'class' => 'form-filter ',

                            'id' => 'price_min',
                            'empty' => ''
                        ));

                        echo $this->Form->input('price_max', array(
                            'label' => __('Price max'),
                            'class' => 'form-filter ',

                            'id' => 'price_max',
                            'empty' => ''
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

    <!-- end of #bs-collapse  -->


    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-10">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
                            <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                array('action' => 'Add'),
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                            <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                'javascript:submitDeleteForm("/prices/deleteprices/");',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                    'disabled' => 'true'),
                                __('Are you sure you want to delete selected Prices ?')); ?>

                            <div class="btn-group buttonradi">

                                <button type="button" id="export_allmark"

                                        class="btn btn-inverse btn-bordred waves-effect w-md waves-light m-b-5"
                                        data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-download-alt m-r-5"></i>
                                    <?= __('Import');

                                    ?>

                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu imp" role="menu">
                                    <li>
                                        <div class="timeline-body">
                                            <?php echo $this->Html->link(__('Download file model'), '/attachments/import_xls/tarifs.csv', array('class' => 'titre')); ?>
                                            <br/>

                                            <form id='CustomerImportForm' action='prices/import' method='post'
                                                  enctype='multipart/form-data' novalidate='novalidate'>
                                                <?php
                                                echo "<div class='form-group'>" . $this->Form->input('Price.file_csv', array(
                                                        'label' => __('File .csv'),
                                                        'class' => '',
                                                        'type' => 'file',
                                                        'id' => 'file_customers',
                                                        'placeholder' => __('Choose file .csv'),
                                                        'empty' => __('Choose file .csv'),
                                                    )) . "</div>"; ?>


                                                <div class='timeline-footer'>

                                                    <?php


                                                    echo $this->Form->submit(__('Import'), array(
                                                        'name' => 'ok',
                                                        'class' => 'btn btn-inverse btn-xs',
                                                        'label' => __('Import'),
                                                        'type' => 'submit',
                                                        'div' => false
                                                    )) ?>
                                                </div>
                                            </form>
                                        </div>


                                    </li>
                                </ul>

                            </div>


                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="col-sm-6">
                    <div class="dataTables_length m-r-15" id="datatable-editable_length" style="display: inline-block;">
                        <label>&nbsp; <?= __('Order : ') ?>
                            <?php
                            if (isset($this->params['pass']['1'])) $order = $this->params['pass']['1'];
                            ?>
                            <select aria-controls="datatable-editable" class="form-control input-sm" name="selectOrder"
                                    id="selectOrder" onchange="selectOrderChanged('prices/index');">
                                <option
                                    value="1" <?php if ($order == 1) echo 'selected="selected"' ?>> <?= __('Code') ?></option>
                                <option
                                    value="2" <?php if ($order == 2) echo 'selected="selected"' ?>><?= __('Departure city') ?></option>
                                <option
                                    value="3" <?php if ($order == 3) echo 'selected="selected"' ?>><?= __('Arrival city') ?></option>
                                <option
                                    value="4" <?php if ($order == 4) echo 'selected="selected"' ?>><?= __('Transportation') ?></option>
                                <option
                                    value="5" <?php if ($order == 5) echo 'selected="selected"' ?>><?= __('Id') ?></option>

                            </select>
                        </label>
                    </div>
                    <div class="dataTables_length" id="datatable-editable_length" style="display: inline-block;">
                        <label>
                            <?php
                            if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                            ?>
                            <select aria-controls="datatable-editable" class="form-control input-sm" name="slctlimit"
                                    id="slctlimit" onchange="slctlimitChanged('prices/index');">
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
                        <th><?php echo $this->Paginator->sort('wording', __('Code')); ?></th>
                        <th><?php echo $this->Paginator->sort('ride_id', __('Ride')); ?></th>
                        <th><?php echo $this->Paginator->sort('car_type_id', __('Transportation')); ?></th>
                        <th><?php echo $this->Paginator->sort('supplier_category_id', __('Customer Category')); ?></th>
                        <th><?php echo $this->Paginator->sort('supplier_id', __('Client')); ?></th>
                        <?php if ($useRideCategory == 2) { ?>
                            <th><?php echo $this->Paginator->sort('ride_category_id', __('Ride category')); ?></th>
                        <?php } ?>
                        <th><?php echo $this->Paginator->sort('price_ht', __('Price HT') . ' ' . __('Day')); ?></th>
                        <?php if($paramPriceNight == 1){ ?>
                        <th><?php echo $this->Paginator->sort('price_ht_night', __('Price HT') . ' ' . __('Night')); ?></th>
                        <?php } ?>
                        <th><?php echo $this->Paginator->sort('price_return', __('Price return')); ?></th>
                        <th><?php echo $this->Paginator->sort('start_date', __('Start date')); ?></th>
                        <th><?php echo $this->Paginator->sort('end_date', __('End date')); ?></th>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    </thead>




                    <tbody id="listeDiv">
                    <?php foreach ($prices as $price): ?>
                        <tr id="row<?= $price['Price']['id'] ?>"

                            >
                            <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'>

                                <input id="idCheck" type="checkbox" class='id'
                                       value=<?php echo $price['Price']['id'] ?>>
                            </td>
                            <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo h($price['Price']['wording']); ?>
                                &nbsp;</td>
                            <?php if ($price['Price']['type_pricing'] == 3) { ?>
                                <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo h($price['Product']['name'] ); ?>
                                    &nbsp;</td>
                            <?php   } else { ?>
                                <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo h($price['DepartureDestination']['name'] . '-' . $price['ArrivalDestination']['name']); ?>
                                    &nbsp;</td>

                             <?php }?>

                            <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo($price['CarType']['name']); ?></td>
                            <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo h($price['SupplierCategory']['name']); ?>
                                &nbsp;</td>
                            <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo h($price['Supplier']['name']); ?>
                                &nbsp;</td>
                            <?php if ($useRideCategory == 2) { ?>
                                <td><?php echo h($price['RideCategory']['name']); ?>&nbsp;</td>
                            <?php } ?>
                            <?php if ($price['Price']['type_pricing'] == 3) { ?>
                                <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo number_format($price['ProductPrice']['price_ht'], 2, ",", $separatorAmount) . ' ' . $this->Session->read("currency"); ?>
                                    &nbsp;</td>
                                <?php  if($paramPriceNight == 1){ ?>
                                    <td></td>
                                <?php } ?>
                                <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'>
                                    &nbsp;</td>
                                <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo h($this->Time->format($price['ProductPrice']['start_date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>
                                <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo h($this->Time->format($price['ProductPrice']['end_date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>
                            <?php } else { ?>
                                <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo number_format($price['PriceRideCategory']['price_ht'], 2, ",", $separatorAmount) . ' ' . $this->Session->read("currency"); ?>
                                    &nbsp;</td>
                                <?php  if($paramPriceNight == 1){ ?>
                                    <td><?php echo number_format($price['PriceRideCategory']['price_ht_night'], 2, ",", $separatorAmount) . ' ' . $this->Session->read("currency"); ?>
                                        &nbsp;</td>
                                <?php } ?>
                                <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo number_format($price['PriceRideCategory']['price_return'], 2, ",", $separatorAmount) . ' ' . $this->Session->read("currency"); ?>
                                    &nbsp;</td>
                                <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo h($this->Time->format($price['PriceRideCategory']['start_date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>
                                <td onclick='viewPromotions(<?php echo $price['Price']['id'] ?> )'><?php echo h($this->Time->format($price['PriceRideCategory']['end_date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>
                            <?php  } ?>


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
                                                array('action' => 'View', $price['Price']['id']),
                                                array('escape' => false, 'class' => 'btn btn-success')
                                            ); ?>
                                        </li>

                                        <li>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                array('action' => 'Edit', $price['Price']['id']),
                                                array('escape' => false, 'class' => 'btn btn-primary')
                                            ); ?>
                                        </li>

                                        <li>
                                            <?php
                                            echo $this->Form->postLink(
                                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                array('action' => 'delete', $price['Price']['id']),
                                                array('escape' => false, 'class' => 'btn btn-danger'),
                                                __('Are you sure you want to delete %s?', $price['Price']['wording'])); ?>
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
                    if ($this->params['paging']['Price']['pageCount'] > 1) {
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

                <div id='promotions' name="promotions">

                </div>
                <br>
                <br>
            </div>
        </div>
    </div>
</div>



<?php $this->start('script'); ?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
<script type="text/javascript">


    $(document).ready(function () {


    });

    function viewPromotions(id) {

        $("html").css("cursor", "pointer");
        scrollToAnchor('promotions');
        jQuery('tr').removeClass('btn-info  btn-trans');
        jQuery('#row' + id).addClass('btn-info  btn-trans');
        jQuery('#promotions').load('<?php echo $this->Html->url('/prices/viewPromotions/')?>' + id, function () {


        });
    }


</script>
<?php $this->end(); ?>
