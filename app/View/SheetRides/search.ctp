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

                    <?php echo $this->Form->create('SheetRides', array(
                        'url' => array(
                            'action' => 'search'
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
                        echo $this->Form->input('car_type_id', array(
                            'id' => 'car_type',
                            'type' => 'hidden',
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
                        if ($useRideCategory == 2) {
                            echo "<div style='clear:both; padding-top: 10px;'></div>";
                            echo $this->Form->input('ride_category_id', array(
                                'label' => __('Category'),
                                'class' => 'form-filter select2',
                                'empty' => ''
                            ));
                        }
                        echo "<div style='clear:both; padding-top: 10px;'></div>";

                        echo $this->Form->input('supplier_id', array(
                            'label' => __('Client'),
                            'class' => 'form-filter select-search-client-initial',
                            'empty' => ''
                        ));
                        $options = array('1' => __('Planned'), '2' => __('In progress'), '3' => __('Return to park'), '4' => __('Closed'));

                        echo $this->Form->input('status_id', array(
                            'label' => __('Status'),
                            'class' => 'form-filter select2',
                            'options' => $options,
                            'id' => 'status',
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


    <div class="row" id="grp_actions">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <?php if (!$isAgent) { ?>
                            <div class="header_actions">
                                <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                    array('action' => 'Add'),
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                                <?php if (Configure::read("gestion_commercial") == '1') { ?>
                                    <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add from customers orders'),
                                        array('controller' => 'transportBills', 'action' => 'AddFromCustomerOrder'),
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                                <?php } ?>
                                <?= $this->Html->link('<i class=" fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                    'javascript:submitDeleteForm("sheetRides/deleteSheetRides/");',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                        'disabled' => 'true'),
                                    __('Are you sure you want to delete selected sheet rides ?')); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($isAgent) { ?>
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">

                    <?php echo $this->Form->create('SheetRides', array(
                        'url' => array(
                            'action' => 'verifyBarCodeDeparture'
                        ),
                        'novalidate' => true,
                        'id' => 'verifyBarCodeDeparture'
                    )); ?>
                    <div class="input-filter">
                        <?php
                        echo $this->Form->input('SheetRide.barcode_departure',
                            array(
                                'label' => __('Departure from the park'),
                                'id' => 'barcode_departure',
                                'class' => 'form-control',
                                'placeholder' => __("Enter reference")

                            ));
                        ?>
                    </div>
                    <?php echo $this->Form->end(); ?>
                    <div style='clear:both; padding-top: 10px;'></div>
                    <?php echo $this->Form->create('SheetRides', array(
                        'url' => array(
                            'action' => 'verifyBarCodeArrival'
                        ),
                        'novalidate' => true,
                        'id' => 'verifyBarCodeArrival'
                    )); ?>
                    <div class="input-filter">
                        <?php
                        echo $this->Form->input('SheetRide.barcode_arrival',
                            array(
                                'label' => __('Arrival at the park'),
                                'id' => 'barcode_arrival',
                                'class' => 'form-control',
                                'placeholder' => __("Enter reference")

                            ));
                        ?>


                    </div>
                    <?php echo $this->Form->end(); ?>
                    <div style='clear:both; padding-top: 10px;'></div>

                </div>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <?php echo $this->Form->create('SheetRides', array(
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

                <?php if (isset($_GET['page'])) { ?>
                    <?= $this->Form->input('page', array(
                        'id' => 'page',
                        'value' =>  $_GET['page'],
                        'type' => 'hidden'
                    )); ?>
                    <?php
                    $page = $_GET['page'];
                } else { ?>
                    <?= $this->Form->input('page', array(
                        'id' => 'page',
                        'type' => 'hidden'
                    )); ?>
                    <?php
                    $page = 1;
                }
                $uriParts = explode('?', $_SERVER['REQUEST_URI'], 2);
                $url =  base64_encode(serialize($uriParts[0]));
                $controller = $this->request->params['controller'];
                ?>
                <?= $this->Form->input('url', array(
                    'id' => 'url',
                    'value' => base64_encode(serialize($uriParts[0])),
                    'type' => 'hidden'
                )); ?>

                <div class="col-sm-6">
                    <div class="dataTables_length m-r-15" id="datatable-editable_length" style="display: inline-block;">
                        <label>&nbsp; <?= __('Order : ') ?>
                            <?php
                            if (isset($this->params['pass']['1'])) $order = $this->params['pass']['1'];
                            ?>
                            <select aria-controls="datatable-editable" class="form-control input-sm" name="selectOrder"
                                    id="selectOrder" onchange="selectOrderChangedSearch('sheetRides/index','DESC');">
                                <option
                                    value="2" <?php if ($order == 2) echo 'selected="selected"' ?>><?= __('Id') ?></option>
                                <option
                                    value="1" <?php if ($order == 1) echo 'selected="selected"' ?>> <?= __('Reference') ?></option>

                                <option
                                    value="3" <?php if ($order == 3) echo 'selected="selected"' ?>><?= __('Start date') ?></option>
                                <option
                                    value="4" <?php if ($order == 4) echo 'selected="selected"' ?>><?= __('End date') ?></option>

                            </select>
                        </label>
                        <span id="asc_desc" >
                        <i class="fa fa-sort-asc" id="asc" onclick="selectOrderChanged('sheetRides/index', 'ASC');"></i>
                        <i class="fa fa-sort-desc" id="desc" onclick="selectOrderChanged('sheetRides/index','DESC');"></i>
                        </span>
                    </div>
                    <div class="dataTables_length" id="datatable-editable_length" style="display: inline-block;">
                        <label>
                            <?php
                            if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                            ?>
                            <select aria-controls="datatable-editable" class="form-control input-sm" name="slctlimit"
                                    id="slctlimit" onchange="slctlimitChangedSearch('sheetRides/index');">
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
                        <th><?php echo $this->Paginator->sort('reference', __('Number sheet')); ?></th>


                        <th><?php echo $this->Paginator->sort('car_id', __('Car')); ?></th>
                        <th><?php echo $this->Paginator->sort('customer_id', __("Customer")); ?></th>


                        <th class="dtm"><?php echo $this->Paginator->sort('start_date', __('Planned Departure date')); ?></th>
                        <th class="dtm"><?php echo $this->Paginator->sort('real_start_date', __('Real Departure date')); ?></th>

                        <th><?php echo $this->Paginator->sort('real_end_date', __('Real Arrival date')); ?></th>
                        <th><?php echo $this->Paginator->sort('status', __('Status')); ?></th>

                        <th class="actions"><?php echo __('Actions'); ?></th>

                    </tr>
                    </thead>

                    <tbody id="listeDiv">
                    <?php

                    foreach ($sheetRides as $sheetRide): ?>
                        <tr id="row<?= $sheetRide['SheetRide']['id'] ?>">
                            <td onclick='viewDetail(<?php echo $sheetRide['SheetRide']['id'] ?>)'>
                                <input id="idCheck" type="checkbox" class='id'
                                       value=<?php echo $sheetRide['SheetRide']['id'] ?>>
                            </td>
                            <td
                                onclick='viewDetail(<?php echo $sheetRide['SheetRide']['id'] ?>)'
                                ><?php echo h($sheetRide['SheetRide']['reference']); ?>&nbsp;</td>
                            <td
                                onclick='viewDetail(<?php echo $sheetRide['SheetRide']['id'] ?>)'

                                > <?php
                                if($sheetRide['SheetRide']['car_subcontracting']==2){
                                    if ($param == 1) {
                                        echo $sheetRide['Car']['code'] . " - " . $sheetRide['Carmodel']['name'];
                                    } else if ($param == 2) {
                                        echo $sheetRide['Car']['immatr_def'] . " - " . $sheetRide['Carmodel']['name'];
                                    }
                                }else {
                                   echo $sheetRide['SheetRide']['car_name'];
                                }
                                ?>

                            </td>
                            <td
                                onclick='viewDetail(<?php echo $sheetRide['SheetRide']['id'] ?>)'

                                ><?php
                                if($sheetRide['SheetRide']['car_subcontracting']==2){
                                    echo h($sheetRide['Customer']['first_name'] . ' - ' . $sheetRide['Customer']['last_name']);
                                }else {
                                    echo $sheetRide['SheetRide']['customer_name'];
                                }
                                 ?>
                                &nbsp;</td>


                            <td
                                onclick='viewDetail(<?php echo $sheetRide['SheetRide']['id'] ?>)'

                                ><?php echo h($this->Time->format($sheetRide['SheetRide']['start_date'], '%d-%m-%Y %H:%M')); ?>
                                &nbsp;</td>

                            <td
                                onclick='viewDetail(<?php echo $sheetRide['SheetRide']['id'] ?>)'

                                ><?php echo h($this->Time->format($sheetRide['SheetRide']['real_start_date'], '%d-%m-%Y %H:%M')); ?>
                                &nbsp;</td>

                            <td
                                onclick='viewDetail(<?php echo $sheetRide['SheetRide']['id'] ?>)'

                                ><?php echo h($this->Time->format($sheetRide['SheetRide']['real_end_date'], '%d-%m-%Y %H:%M')); ?>
                                &nbsp;</td>

                            <td
                                onclick='viewDetail(<?php echo $sheetRide['SheetRide']['id'] ?>)'

                                >
                                <?php
                                switch ($sheetRide['SheetRide']['status_id']) {
                                    /*
                                    1: feuille de route planifié
                                    2: feuille de route en cours
                                    3: feuille de route cloturée
                                    4: feuille de route facturée
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
                                        echo '<span class="label label-primary">';
                                        echo (__('Return to park')) . "</span>";
                                        break;
                                    case 4:
                                        echo '<span class="label label-success">';
                                        echo __('Closed') . "</span>";
                                        break;

                                    case 9:
                                        echo '<span class="label label-inverse">';
                                        echo __('Canceled') . "</span>"  ." ( ". $sheetRide['CancelCause']['name'] ." )";
                                        break;

                                } ?>

                            </td>
                            <?php if ($isAgent) { ?>
                                <td class="actions">
                                    <div class='edit-link' title=<?= __('Edit') ?>>
                                        <?= $this->Html->link(
                                            '<i class="fa fa-edit"></i>',
                                            array('action' => 'Edit', $sheetRide['SheetRide']['id'], $controller, $url, $page),
                                            array('escape' => false, 'class' => 'btn btn-primary')
                                        ); ?>
                                    </div>

                                    <div class='edit-link' title=<?= __('Print') ?>>
                                        <?php switch ($reportingChoosed) {
                                            case 1:
                                                ?>
                                                <?= $this->Html->link(
                                                '<i class="fa fa-print"></i>',
                                                array('action' => 'view_pdf', 'ext' => 'pdf', $sheetRide['SheetRide']['id']),
                                                array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                            ); ?>
                                                <?php
                                                break;

                                            case 2:
                                                ?>
                                                <?= $this->Html->link(
                                                '<i class="fa fa-print"></i>',
                                                array('action' => 'pdfReports', $sheetRide['SheetRide']['id']),
                                                array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                            ); ?>
                                                <?php
                                                break;
                                            case 3:
                                                $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];
                                                if($sheetRide['SheetRide']['car_subcontracting']==1){
                                                    $link = $reportsPathJasper . '/subcontracting_sheet_rides.pdf?j_username=' . $usernameJasper . '&j_password=' . $passwordJasper . '&id=' . $sheetRide['SheetRide']['id'];

                                                }else {
                                                    $link = $reportsPathJasper . '/sheet_rides.pdf?j_username=' . $usernameJasper . '&j_password=' . $passwordJasper . '&id=' . $sheetRide['SheetRide']['id'];

                                                }
                                                ?>
                                                <a href="<?php echo $link ?>" target="_blank"
                                                   class="btn btn-warning"><i class="fa fa-print"></i></a>
                                                <?php    break;
                                                ?>
                                            <?php
                                        } ?>


                                    </div>
                                </td>
                            <?php } else { ?>
                                <td class="actions">
                                    <div class="btn-group ">
                                        <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                            <i class="fa fa-list fa-inverse"></i>
                                        </a>
                                        <button href="#" data-toggle="dropdown"
                                                class="btn btn-info dropdown-toggle share">
                                            <span class="caret"></span>
                                        </button>

                                        <ul class="dropdown-menu" style="min-width: 70px;">

                                            <li class='view-link' title=<?= __('View') ?>>
                                                <?= $this->Html->link(
                                                    '<i   class="fa fa-eye"></i>',
                                                    array('action' => 'View', $sheetRide['SheetRide']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-success')
                                                ); ?>
                                            </li>
                                            <li>
                                                <?php if ($client_i2b == 1) {
                                                    echo '<li class = "localisation-link" title="' . __('Localisation') . '">';
                                                    ?>
                                                    <?= $this->Html->link(
                                                        '<i class="fa fa-map-marker"></i>',
                                                        array('controller' => 'cars', 'action' => 'ViewPosition', $sheetRide['SheetRide']['car_id']),
                                                        array('escape' => false, 'class' => 'btn btn-inverse')
                                                    ); ?>
                                                    <?php
                                                    echo '</li>';
                                                } ?>

                                            <li class='edit-link' title=<?= __('Edit') ?>>
                                                <?= $this->Html->link(
                                                    '<i class="fa fa-edit"></i>',
                                                    array('action' => 'Edit', $sheetRide['SheetRide']['id'], $controller, $url, $page ),
                                                    array('escape' => false, 'class' => 'btn btn-primary')
                                                ); ?>
                                            </li>
                                            <li class='edit-link' title=<?= __('Print') ?>>
                                                <?php switch ($reportingChoosed) {
                                                    case 1:
                                                        ?>
                                                        <?= $this->Html->link(
                                                        '<i class="fa fa-print"></i>',
                                                        array('action' => 'view_pdf', 'ext' => 'pdf', $sheetRide['SheetRide']['id']),
                                                        array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                                    ); ?>
                                                        <?php
                                                        break;

                                                    case 2:
                                                        ?>
                                                        <?= $this->Html->link(
                                                        '<i class="fa fa-print"></i>',
                                                        array('action' => 'pdfReports', $sheetRide['SheetRide']['id']),
                                                        array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                                    ); ?>
                                                        <?php
                                                        break;
                                                    case 3:
                                                        $reportsPathJasper = $informationJasperReport['Parameter']['reports_path_jasper'];
                                                        $usernameJasper = $informationJasperReport['Parameter']['username_jasper'];
                                                        $passwordJasper = $informationJasperReport['Parameter']['password_jasper'];

                                                        if($sheetRide['SheetRide']['car_subcontracting']==1){
                                                            $link = $reportsPathJasper . '/subcontracting_sheet_rides.pdf?j_username=' . $usernameJasper . '&j_password=' . $passwordJasper . '&id=' . $sheetRide['SheetRide']['id'];

                                                        }else {
                                                            $link = $reportsPathJasper . '/sheet_rides.pdf?j_username=' . $usernameJasper . '&j_password=' . $passwordJasper . '&id=' . $sheetRide['SheetRide']['id'];

                                                        }
                                                        ?>
                                                        <a href="<?php echo $link ?>" target="_blank"
                                                           class="btn btn-warning"><i class="fa fa-print"></i></a>
                                                        <?php    break;
                                                        ?>
                                                    <?php
                                                } ?>


                                            </li>

                                            <li class='delete-link' title=<?= __('Delete') ?>>
                                                <?php
                                                echo $this->Form->postLink(
                                                    '<i class="fa fa-trash-o"></i>',
                                                    array('action' => 'delete', $sheetRide['SheetRide']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-danger'),
                                                    __('Are you sure you want to delete %s?', $sheetRide['SheetRide']['reference'])); ?>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            <?php } ?>

                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <div id="pagination" class="pull-right">
                    <?php
                    if ($this->params['paging']['SheetRide']['pageCount'] > 1) {
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

                <div id='missions' name="missions">

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

        var currentURL = window.location.href;
        var parts = currentURL.split("/");
        var lastPart = parts[parts.length - 1];

        if (lastPart == 'barcode_departure:barcode_departure') {

            $("#barcode_departure").focus();
        }
        if (lastPart == 'barcode_arrival:barcode_arrival') {
            $("#barcode_arrival").focus();
        }


        jQuery("#start_date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#start_date2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#end_date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#end_date2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        $("#barcode_departure").keypress(function (e) {
            if (e.which == 13) {
                $('#verifyBarCodeDeparture').submit();
            }
        });

        $("#barcode_arrival").keypress(function (e) {
            if (e.which == 13) {
                $('#verifyBarCodeDeparture').submit();
            }
        });

    });


    function updateDateKmDepartureSheetRide() {

        var barcode = jQuery('#barcode').val();


        jQuery.ajax({
            type: "POST",
            url: "<?php echo $this->Html->url('/sheetRides/verifyBarCode/')?>",
            dataType: "json",
            data: {barcode: barcode},
            success: function (json) {
                if (json.exist == "true") {
                    if (json.response == "true") {
                        msg = "<?php echo __("Date and km have been updated")?>";
                        alert(msg);

                    } else {
                        msg = "<?php echo __("Date and km have not been updated")?>";
                        alert(msg);
                    }

                } else {
                    msg = "<?php echo __("Reference does not exist")?>";
                    alert(msg);
                }

            }
        });

    }

    function viewDetail(id) {
        $("html").css("cursor", "pointer");
        scrollToAnchor('missions');
        jQuery('tr').removeClass('btn-info  btn-trans');
        jQuery('#row' + id).addClass('btn-info  btn-trans');
        jQuery('#missions').load('<?php echo $this->Html->url('/sheetRides/viewDetail/')?>' + id, function () {

        });
    }

    function slctlimitChangedSearch() {
        <?php
        $url = "";


        if (isset($this->params['named']['keyword']) && !empty($this->params['named']['keyword'])) {
            $url .= "/keyword:" . $this->params['named']['keyword'];
        }
        if (isset($this->params['named']['ride']) && !empty($this->params['named']['ride'])) {
            $url .= "/ride:" . $this->params['named']['ride'];
        }
        if (isset($this->params['named']['customer']) && !empty($this->params['named']['customer'])) {
            $url .= "/customer:" . $this->params['named']['customer'];
        }
        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            $url .= "/category:" . $this->params['named']['category'];
        }
        if (isset($this->params['named']['car']) && !empty($this->params['named']['car'])) {
            $url .= "/car:" . $this->params['named']['car'];
        }
        if (isset($this->params['named']['parc']) && !empty($this->params['named']['parc'])) {
            $url .= "/parc:" . $this->params['named']['parc'];
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
        if (isset($this->params['named']['status']) && !empty($this->params['named']['status'])) {
            $url .= "/status:" . $this->params['named']['status'];
        }

        if (isset($this->params['named']['start_date1']) && !empty($this->params['named']['start_date1'])) {
            $url .= "/start_date1:" . $this->params['named']['start_date1'];
        }
        if (isset($this->params['named']['start_date2']) && !empty($this->params['named']['start_date2'])) {
            $url .= "/start_date2:" . $this->params['named']['start_date2'];
        }
        if (isset($this->params['named']['end_date1']) && !empty($this->params['named']['end_date1'])) {
            $url .= "/end_date1:" . $this->params['named']['end_date1'];
        }
        if (isset($this->params['named']['end_date2']) && !empty($this->params['named']['end_date2'])) {
            $url .= "/end_date2:" . $this->params['named']['end_date2'];
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
        window.location = '<?php echo $this->Html->url('/sheetRides/search/')?>' + jQuery('#slctlimit').val() + '<?php echo $url;?>';
    }


    function selectOrderChangedSearch(url= null, orderType= null) {
        <?php
        $url = "";


        if (isset($this->params['named']['keyword']) && !empty($this->params['named']['keyword'])) {
            $url .= "/keyword:" . $this->params['named']['keyword'];
        }
        if (isset($this->params['named']['ride']) && !empty($this->params['named']['ride'])) {
            $url .= "/ride:" . $this->params['named']['ride'];
        }
        if (isset($this->params['named']['customer']) && !empty($this->params['named']['customer'])) {
            $url .= "/customer:" . $this->params['named']['customer'];
        }
        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            $url .= "/category:" . $this->params['named']['category'];
        }
        if (isset($this->params['named']['car']) && !empty($this->params['named']['car'])) {
            $url .= "/car:" . $this->params['named']['car'];
        }
        if (isset($this->params['named']['parc']) && !empty($this->params['named']['parc'])) {
            $url .= "/parc:" . $this->params['named']['parc'];
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
        if (isset($this->params['named']['status']) && !empty($this->params['named']['status'])) {
            $url .= "/status:" . $this->params['named']['status'];
        }

        if (isset($this->params['named']['start_date1']) && !empty($this->params['named']['start_date1'])) {
            $url .= "/start_date1:" . $this->params['named']['start_date1'];
        }
        if (isset($this->params['named']['start_date2']) && !empty($this->params['named']['start_date2'])) {
            $url .= "/start_date2:" . $this->params['named']['start_date2'];
        }
        if (isset($this->params['named']['end_date1']) && !empty($this->params['named']['end_date1'])) {
            $url .= "/end_date1:" . $this->params['named']['end_date1'];
        }
        if (isset($this->params['named']['end_date2']) && !empty($this->params['named']['end_date2'])) {
            $url .= "/end_date2:" . $this->params['named']['end_date2'];
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
        window.location = '<?php echo $this->Html->url('/sheetRides/search/')?>' +limit+'/'+ order +'/'+ orderType+ '<?php echo $url;?>';
    }




</script>
<?php $this->end(); ?>
