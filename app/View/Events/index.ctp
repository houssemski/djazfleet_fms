<style>
    .actions {
        width: 80px;
    }
</style>

<?php

App::import('Model', 'Event');
$this->Event = new Event();
 if (Configure::read('logistia') == '1'){
?>
<h4 class="page-title"> <?= __('Repairs'); ?></h4>
<?php }else { ?>
<h4 class="page-title"> <?= __('Events'); ?></h4>
<?php } ?>
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

                    <?php echo $this->Form->create('Events', array(
                        'url' => array(
                            'action' => 'search'
                        ),
                        'novalidate' => true
                    )); ?>

                    <div class="filters" id='filters'>
                        <input name="conditions" type="hidden"
                               value="<?php echo base64_encode(serialize($conditions)); ?>">
                        <input name="conditions_car" type="hidden"
                               value="<?php echo base64_encode(serialize($conditions_car)); ?>">
                        <input name="conditions_customer" type="hidden"
                               value="<?php echo base64_encode(serialize($conditions_customer)); ?>">
                        <?php
                        echo $this->Form->input('event_type_id', array(
                            'label' => __('Type'),
                            'class' => 'form-filter',
                            'id' => 'type',
                            'empty' => ''
                        ));

                        echo $this->Form->input('interfering_id', array(
                            'label' => __('Interfering'),
                            'class' => 'form-filter',
                            'empty' => ''
                        ));
                        echo $this->Form->input('status_id', array(
                            'label' => __('Status'),
                            'class' => 'form-filter',
                            'empty' => '',
                            'id' => 'status',
                            'options' => $statuses,
                        ));

                        $options = array('1' => __('Low'), '2' => __('Medium'), '3' => __('Serious'), '4' => __('Very serious'));
                        echo "<div id='incident'>" . $this->Form->input('severity_incident', array(
                                'label' => __('Severity incident'),
                                'type' => 'select',
                                'options' => $options,
                                'empty' => '',
                                'id' => 'severity',
                                'class' => 'form-filter'
                            )) . "</div>";

                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('car_id', array(
                            'label' => __('Car'),
                            'class' => 'form-filter',
                            'empty' => ''
                        ));
                        echo $this->Form->input('customer_id', array(
                            'label' => __("Conductor"),
                            'class' => 'form-filter',
                            'empty' => ''
                        ));

                        if ($hasParc) {

                            echo $this->Form->input('parc_id', array(
                                'label' => __('Parc'),
                                'class' => 'form-filter',
                                'id' => 'parc',

                                'empty' => ''
                            ));


                        } else {
                            if ($nb_parcs > 0) {
                                echo $this->Form->input('parc_id', array(
                                    'label' => __('Parc'),
                                    'class' => 'form-filter',
                                    'id' => 'parc',
                                    'type' => 'select',
                                    'options' => $parcs,
                                    'empty' => ''
                                ));
                            }


                        }


                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('date', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'startdate',
                        ));
                        echo $this->Form->input('next_date', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Next date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'enddate',
                        ));
                        echo $this->Form->input('date3', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Date 3') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'date3',
                        ));

                        echo "<div style='clear:both; padding-top: 15px;'></div>";
                        echo $this->Form->input('km', array(
                            'label' => __('km'),
                            'type' => 'number',
                            'class' => 'form-filter'
                        ));
                        echo $this->Form->input('km_to', array(
                            'label' => __('To'),
                            'type' => 'number',
                            'class' => 'form-filter'
                        ));
                        echo "<div style='clear:both; padding-top: 15px;'></div>";
                        echo $this->Form->input('next_km', array(
                            'label' => __('Next km'),
                            'type' => 'number',
                            'class' => 'form-filter'
                        ));
                        echo $this->Form->input('next_km_to', array(
                            'label' => __('To'),
                            'type' => 'number',
                            'class' => 'form-filter'
                        ));
                        echo "<div style='clear:both; padding-top: 15px;'></div>";
                        echo $this->Form->input('cost', array(
                            'label' => __('Cost'),
                            'type' => 'number',
                            'class' => 'form-filter'
                        ));
                        echo $this->Form->input('cost_to', array(
                            'label' => __('To'),
                            'type' => 'number',
                            'class' => 'form-filter'
                        ));
                        echo "<div style='clear:both; padding-top: 15px;'></div>";
                        $options = array('1' => __('Yes'), '2' => __('No'));
                        echo $this->Form->input('pay_customer', array(
                            'label' => __('Pay by the driver'),
                            'type' => 'select',
                            'options' => $options,
                            'class' => 'form-filter',
                            'empty' => ''
                        ));
                        echo $this->Form->input('refund', array(
                            'label' => __("Refund"),
                            'class' => 'form-filter',
                            'type' => 'select',
                            'options' => $options,
                            'empty' => ''
                        ));

                        echo $this->Form->input('validated', array(
                            'value' => '1',
                            'type' => 'hidden',

                        ));
                        echo $this->Form->input('request', array(

                            'type' => 'hidden',

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
                                    'class' => 'form-filter',
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
                                    'class' => 'form-filter',
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
                                <div style='clear:both; padding-top: 10px;'></div>
                            </div>

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
                            <div class="btn-group">
                                <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                    array('action' => 'Add'),
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                                <button type="button" id="export_allmark"
                                        class="btn dropdown-toggle btn-inverse  btn-bordred" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <?= $this->Html->link(__('For all cars'), array('action' => 'AddAllCars')) ?>
                                    </li>
                                    <li>
                                        <?= $this->Html->link(__('Add multiple events'), array('action' => 'addMultipleEvents')) ?>
                                    </li>
                                </ul>
                            </div>
                            <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                'javascript:submitDeleteForm("events/deleteevents/");',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                    'disabled' => 'true'),
                                __('Are you sure you want to delete selected events ?')); ?>


                           <?php

                           if($printInterventionRequest == 1) {
                            echo $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Print request'),
                            'javascript:printRequests();',
                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'print_requests'));
                            } ?>

                            <div class="btn-group">
                                <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Export'),
                                    'javascript:exportData("events/export/");',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'export', 'disabled' => 'true')) ?>
                                <button type="button" id="export_allmark"
                                        class="btn dropdown-toggle btn-inverse  btn-bordred" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <?= $this->Html->link(__('Export All'), 'javascript:exportAllData("events/export/all");') ?>
                                    </li>
                                </ul>
                            </div>

                            <div class="btn-group ">

                                <button type="button" id="export_allmark"

                                        class="btn btn-inverse btn-bordred waves-effect waves-light m-b-5"
                                        data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-download-alt"></i>
                                    <?= __('Import');

                                    ?>

                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu imp" role="menu">
                                    <li>
                                        <div class="timeline-body">
                                            <?php echo $this->Html->link(__('Download file model'), '/attachments/import_xls/evenements.csv', array('class' => 'titre')); ?>
                                            <br/>

                                            <form id='EventImportForm' action='events/import' method='post'
                                                  enctype='multipart/form-data' novalidate='novalidate'>
                                                <?php
                                                echo "<div class='form-group'>" . $this->Form->input('Event.file_csv', array(
                                                        'label' => __('File .csv'),
                                                        'class' => '',
                                                        'type' => 'file',
                                                        'id' => 'file_events',
                                                        'placeholder' => __('Choose file .csv'),
                                                        'empty' => ''
                                                    )) . "</div>"; ?>

                                                <div class='timeline-footer'>

                                                    <?php



                                                    echo $this->Form->submit(__('Import'), array(
                                                        'name' => 'ok',
                                                        'class' => 'btn btn-primary btn-xs',
                                                        'label' => __('Import'),
                                                        'type' => 'submit',
                                                        'div' => false
                                                    ))?>
                                                </div>
                                            </form>
                                        </div>


                                    </li>
                                </ul>

                            </div>

                            <?= $this->Html->link('<i class="fa fa-print m-r-5 m-r-5"></i>' . __('Print'),
                                'javascript:imprime_bloc("titre", "impression");',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')); ?>


                        </div>
                    </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                </div>
            </div>
        </div>
    </div>
    <!--startprint-->
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <?php echo $this->Form->create('Events', array(
                    'url' => array(
                        'action' => 'search'
                    ),
                    'novalidate' => true,
                    'id' => 'searchKeyword'
                )); ?>
                <label style="float: right;">
                    <input id='keyword' type="text" name="keyword" id="keyword" class="form-control"
                           placeholder= <?= __("Search"); ?>>
                    <input name="conditions" type="hidden" value="<?php echo base64_encode(serialize($conditions)); ?>">
                    <input name="conditions_car" type="hidden"
                           value="<?php echo base64_encode(serialize($conditions_car)); ?>">
                    <input name="conditions_customer" type="hidden"
                           value="<?php echo base64_encode(serialize($conditions_customer)); ?>">
                    <?php
                    echo $this->Form->input('validated', array(
                        'value' => '1',
                        'type' => 'hidden',

                    ));
                    echo $this->Form->input('request', array(

                        'type' => 'hidden',

                    ));
                    ?>

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
                <div id="impression">
                    <div class="bloc-limit btn-group pull-left">
                        <div>
                            <label>
                                <?php
                                if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                                ?>
                                <select name="slctlimit" id="slctlimit" onchange="slctlimitChanged('events/index');">
                                    <option value="20" <?php if ($limit == 20) echo 'selected="selected"' ?>>20</option>
                                    <option value="25" <?php if ($limit == 25) echo 'selected="selected"' ?>>25</option>
                                    <option value="50" <?php if ($limit == 50) echo 'selected="selected"' ?>>50</option>
                                    <option value="100" <?php if ($limit == 100) echo 'selected="selected"' ?>>100
                                    </option>
                                </select>&nbsp; <?= __('records per page') ?>
                            </label>
                        </div>
                    </div>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap custom-table"
                           cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th style="width: 10px">
                                <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i
                                            class="fa fa-square-o"></i></button>
                            </th>
                            <th><?php echo $this->Paginator->sort('Event.code', __('Reference')); ?></th>
                            <th><?php echo $this->Paginator->sort('EventType.name', __('Type')); ?></th>
                            <th><?php echo $this->Paginator->sort('Carmodel.name', __('Car')); ?></th>
                            <th><?php echo $this->Paginator->sort('Customer.first_name', __("Conductor")); ?></th>
                            <th class="dtm"><?php echo $this->Paginator->sort('date', __('Date')); ?></th>
                            <th class="dtm"><?php echo $this->Paginator->sort('next_date', __('Next date')); ?></th>
                            <th><?php echo $this->Paginator->sort('km', __('Km')); ?></th>
                            <th><?php echo $this->Paginator->sort('next_km', __('Next km')); ?></th>
                            <th><?php echo $this->Paginator->sort('cost', __('Cost')); ?></th>
                            <th><?php echo $this->Paginator->sort('status_id', __('Status')); ?></th>
                            <th class="actions"><?php echo __('Actions'); ?></th>
                        </tr>
                        </thead>


                        <tbody id="listeDiv">
                        <?php
                        $event_types = array();
                        $i = 0;

                        foreach ($events as $event) {


                            if ($i < count($events)) {
                                if ($events[$i]['Event']['id'] == $event['Event']['id']) {
                                    $event_types[] = $event['EventType']['name'];
                                } else {
                                    $event_types[] = $event['EventType']['name'];
                                }
                                    ?>

                                    <tr class="alert <?= ($event['Event']['alert'] == 1) ? "alert-danger" : "" ?>"
                                        id="row<?= $event['Event']['id'] ?>">
                                        <td class='case'>

                    <input id="idCheck"type="checkbox" class = 'id' value=<?php echo $event['Event']['id'] ?> >
                </td>
                                        <td><?=$event['Event']['code']?> </td>
                <td>
                    <?php
                    $nbEvent= count($event_types);

                                            $j = 1;
                                            foreach ($event_types as $event_type) {
                                                if ($j == $nbEvent) {
                                                    echo $event_type;
                                                } else {
                                                    echo $event_type . ' - ';
                                                }
                                                $j++;
                                            } ?>
                                        </td>
                                        <td> <?php if ($param == 1) {
                                                echo $event['Car']['code'] . " - " . $event['Carmodel']['name'];
                                            } else if ($param == 2) {
                                                echo $event['Car']['immatr_def'] . " - " . $event['Carmodel']['name'];
                                            } ?>
                                        </td>
                                        <td>


                                            <?php

                                            echo $event['Customer']['first_name'] . " " . $event['Customer']['last_name'];
                                            ?>
                                        </td>
                                        <td>


                                            <?php
                                            if ($event['Event']['date'] != NULL) {
                                                echo h($this->Time->format($event['Event']['date'], '%d-%m-%Y'));
                                            } ?>


                                        </td>
                                        <td>

                                            <?php
                                            if ($event['Event']['next_date'] != NULL) {
                                                echo h($this->Time->format($event['Event']['next_date'], '%d-%m-%Y'));
                                            } ?>


                                        </td>
                                        <td class="right">

                                            <?php
                                            if ($event['Event']['km'] != NULL) {
                                                echo h(number_format($event['Event']['km'], 0, ",", "."));
                                            } ?>


                                        </td>
                                        <td class="right">
                                            <?php
                                            if ($event['Event']['next_km'] != NULL) {
                                                echo h(number_format($event['Event']['next_km'], 0, ",", "."));
                                            } ?>
                                        </td>
                                        <td class="right">

                                            <?php echo h(number_format($event['Event']['cost'], 2, ",", ".")); ?>

                                        </td>
                                        <td>
                                            <?php
                                            switch ($event['Event']['status_id']) {
                                                /*
                                                1: intervention_planned
                                                2: intervention_ongoing
                                                3: intervention_finished
                                                4: intervention_canceled
                                                */
                                                case StatusEnum::intervention_planned:
                                                    echo '<span class="label label-info position-status">';
                                                    echo __('Planned') . "</span>";
                                                    break;
                                                case StatusEnum::intervention_ongoing:
                                                    echo '<span class="label label-danger position-status">';
                                                    echo __('Ongoing') . "</span>";
                                                    break;
                                                case StatusEnum::intervention_finished:
                                                    echo '<span class="label label-success position-status">';
                                                    echo __('Finished') . "</span>";
                                                    break;
                                                case StatusEnum::intervention_canceled:
                                                    echo '<span class="label label-inverse position-status">';
                                                    echo __('Canceled') . "</span>";
                                                    break;
                                                default :
                                                    break;
                                            }
                                            ?>
                                        </td>

                                        <td class="actions">
                                            <div class="btn-group ">
                                                <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                                    <i class="fa fa-list fa-inverse"></i>
                                                </a>
                                                <button href="#" data-toggle="dropdown"
                                                        class="btn btn-info btn-custom-2 dropdown-toggle share">
                                                    <span class="caret"></span>
                                                </button>

                                                <ul class="dropdown-menu" style="min-width: 70px;">

                                                    <li>
                                                        <?= $this->Html->link(
                                                            '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                                                            array('action' => 'View', $event['Event']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-success')
                                                        ); ?>
                                                    </li>

                                                    <li>
                                                        <?php  if ($event['Event']['multiple_event'] == 0) {

                                                            echo $this->Html->link(
                                                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                                array('action' => 'edit', $event['Event']['id']),
                                                                array('escape' => false, 'class' => 'btn btn-primary')
                                                            );

                                                        } else {

                                                            echo $this->Html->link(
                                                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                                array('action' => 'EditMultipleEvents', $event['Event']['id']),
                                                                array('escape' => false, 'class' => 'btn btn-primary')
                                                            );

                                                        } ?>

                                                    </li>
						      <li class='edit-link' title="<?= __('Print simplified bill') ?>">
                                                        <?= $this->Html->link(
                                                            '<i class=" fa fa-print"></i>',
                                                            array('action' => 'view_event', 'ext' => 'pdf', $event['Event']['id']),
                                                            array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                                        ); ?>
                                                    </li>

                                                    <?php
                                                    if($printInterventionRequest == '1') { ?>
                                                        <li>
                                                            <?php

                                                            echo $this->Html->link(
                                                                '<i class="fa fa-print " title="' . __('Print') . '"></i>',
                                                                array('action' => 'printRequest', $event['Event']['id'], 'ext'=>'pdf'),
                                                                array('target' => '_blank',  'escape' => false, 'class' => 'btn btn-inverse' )
                                                            );
                                                            ?>
                                                        </li>
                                                    <?php } ?>
                                                    <li>
                                                        <?php
                                                        if ((isset($event['Event']['attachment1']) && !empty($event['Event']['attachment1'])) || (isset($event['Event']['attachment2']) && !empty($event['Event']['attachment2'])) ||
                                                            (isset($event['Event']['attachment3']) && !empty($event['Event']['attachment3'])) || (isset($event['Event']['attachment4']) && !empty($event['Event']['attachment4']))
                                                            || (isset($event['Event']['attachment5']) && !empty($event['Event']['attachment5']))
                                                        ) {
                                                            echo $this->Html->link(
                                                                '<i class="fa fa-paperclip " title="' . __('Attachments') . '"></i>',
                                                                array('action' => 'View', $event['Event']['id']),
                                                                array('escape' => false, 'class' => 'btn btn-warning')

                                                            );
                                                        } else {
                                                            if (empty($event['Event']['attachment1']) && empty($event['Event']['attachment2']) && empty($event['Event']['attachment3']) && empty($event['Event']['attachment4']) && empty($event['Event']['attachment5'])) {
                                                                if ($event['Event']['multiple_event'] == 0) {
                                                                    echo $this->Html->link(
                                                                        '<i class="fa fa-unlink " title="' . __('Missing attachments') . '"></i>',
                                                                        array('action' => 'edit', $event['Event']['id']),
                                                                        array('escape' => false, 'class' => 'btn btn-warning')
                                                                    );
                                                                } else {

                                                                    echo $this->Html->link(
                                                                        '<i class="fa fa-unlink " title="' . __('Missing attachments') . '"></i>',
                                                                        array('action' => 'EditMultipleEvents', $event['Event']['id']),
                                                                        array('escape' => false, 'class' => 'btn btn-warning')
                                                                    );
                                                                }
                                                            }
                                                        } ?>

                                                    </li>
                                                    <li>
                                                        <?php
                                                        if ($event['Event']['locked'] == 1) {
                                                            echo $this->Html->link(
                                                                '<i class="fa  fa-lock " title="' . __('Unlock') . '"></i>',
                                                                array('action' => 'unlock', $event['Event']['id']),
                                                                array('escape' => false, 'class' => 'btn btn-purple')
                                                            );
                                                        } else {
                                                            echo $this->Html->link(
                                                                '<i class="fa  fa-unlock " title="' . __('Lock') . '"></i>',
                                                                array('action' => 'lock', $event['Event']['id']),
                                                                array('escape' => false, 'class' => 'btn btn-purple')
                                                            );
                                                        }?>
                                                    </li>
                                                    <li>
                                                        <?php
                                                        echo $this->Form->postLink(
                                                            '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                            array('action' => 'delete', $event['Event']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-danger'),
                                                            __('Are you sure you want to delete this event?')); ?>
                                                    </li>

                                                </ul>
                                            </div>


                                        </td>
                                    </tr>

                                    <?php  $event_id = $event['Event']['id'];
                                    $event_types = array();


                            } else {
                                $event_types[] = $event['EventType']['name'];

                                ?>


             <tr class="alert <?= ($event['Event']['alert'] == 1) ? "alert-danger" : "" ?>" id="row<?= $event['Event']['id'] ?>">
                <td class='case'>

                    <input id="idCheck"type="checkbox" class = 'id' value=<?php echo $event['Event']['id'] ?> >
                </td>
                 <td><?=$event['Event']['code']?> </td>
                 <td>
                    <?php
                    $nbEvent= count($event_types);

                    $j=1;
                    foreach ($event_types as $event_type) {
                        if($j==$nbEvent){
                            echo $event_type;
                        }else {
                            echo $event_type.' - ';
                        }
                        $j++;
                    }
                    ?>
                </td>
                <td> <?php if ($param==1){
                         echo $event['Car']['code']." - ".$event['Carmodel']['name']; 
                         } else if ($param==2) {
                         echo $event['Car']['immatr_def']." - ".$event['Carmodel']['name']; 
                            } ?>
                </td>
                <td>
                    
                        
                            <?php
                           
                            echo $event['Customer']['first_name'] . " " . $event['Customer']['last_name']; 
                             ?>
                </td>
                <td>
                   
                       
                            <?php
                            if ($event['Event']['date'] != NULL) {
                                echo h($this->Time->format($event['Event']['date'], '%d-%m-%Y'));
                            } ?>
                       
                      
                   
                </td>
                <td>
                    
                            <?php
                            if ($event['Event']['next_date'] != NULL) {
                                echo h($this->Time->format($event['Event']['next_date'], '%d-%m-%Y'));
                            } ?>
                        
                        
                  
                </td>
                <td class="right">
                            <?php
                            if ($event['Event']['km'] != NULL) {
                                echo h(number_format($event['Event']['km'], 0, ",", "."));
                            } ?>
                </td>
                <td class="right">
                    
                            <?php
                            if ($event['Event']['next_km'] != NULL) {
                                echo h(number_format($event['Event']['next_km'], 0, ",", "."));
                            } ?>
                        
                      
                </td>
                <td class="right">
                    
                            <?php echo h(number_format($event['Event']['cost'], 2, ",", ".")); ?>
                       
                </td>
                 <td>
                     <?php
                     switch ($event['Event']['status_id']) {
                         /*
                         1: intervention_planned
                         2: intervention_ongoing
                         3: intervention_finished
                         4: intervention_canceled
                         */
                         case StatusEnum::intervention_planned:
                             echo '<span class="label label-info position-status">';
                             echo __('Planned') . "</span>";
                             break;
                         case StatusEnum::intervention_ongoing:
                             echo '<span class="label label-danger position-status">';
                             echo __('Ongoing') . "</span>";
                             break;
                         case StatusEnum::intervention_finished:
                             echo '<span class="label label-success position-status">';
                             echo __('Finished') . "</span>";
                             break;
                         case StatusEnum::intervention_canceled:
                             echo '<span class="label label-inverse position-status">';
                             echo __('Canceled') . "</span>";
                             break;
                         default :

                             break;
                     }
                     ?>
                 </td>
                 <td class="actions">
                     <div  class="btn-group ">
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
                                                        array('action' => 'View', $event['Event']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-success')
                                                    ); ?>
                                                </li>

                                                <li>
                                                    <?php  if ($event['Event']['multiple_event'] == 0) {

                                                        echo $this->Html->link(
                                                            '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                            array('action' => 'edit', $event['Event']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-primary')
                                                        );

                                                    } else {

                                                        echo $this->Html->link(
                                                            '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                            array('action' => 'EditMultipleEvents', $event['Event']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-primary')
                                                        );

                                                    } ?>

                                                </li>
						 </li>
                                                <li class='edit-link' title="<?= __('Print simplified bill') ?>">
                                                    <?= $this->Html->link(
                                                        '<i class=" fa fa-print"></i>',
                                                        array('action' => 'view_event', 'ext' => 'pdf', $event['Event']['id']),
                                                        array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                                    ); ?>
                                                </li>
                                                <?php
                                                if($printInterventionRequest == '1') { ?>
                                                    <li>
                                                        <?php

                                                        echo $this->Html->link(
                                                            '<i class="fa fa-print " title="' . __('Print') . '"></i>',
                                                            array('action' => 'printRequest', $event['Event']['id'], 'ext'=>'pdf'),
                                                            array('target' => '_blank',  'escape' => false, 'class' => 'btn btn-inverse' )
                                                        );
                                                        ?>
                                                    </li>
                                                <?php } ?>
                                                <li>
                                                    <?php
                                                    if ((isset($event['Event']['attachment1']) && !empty($event['Event']['attachment1'])) || (isset($event['Event']['attachment2']) && !empty($event['Event']['attachment2'])) ||
                                                        (isset($event['Event']['attachment3']) && !empty($event['Event']['attachment3'])) || (isset($event['Event']['attachment4']) && !empty($event['Event']['attachment4']))
                                                        || (isset($event['Event']['attachment5']) && !empty($event['Event']['attachment5']))
                                                    ) {
                                                        echo $this->Html->link(
                                                            '<i class="fa fa-paperclip " title="' . __('Attachments') . '"></i>',
                                                            array('action' => 'View', $event['Event']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-warning')

                                                        );
                                                    } else {
                                                        if (empty($event['Event']['attachment1']) && empty($event['Event']['attachment2']) && empty($event['Event']['attachment3']) && empty($event['Event']['attachment4']) && empty($event['Event']['attachment5'])) {
                                                            if ($event['Event']['multiple_event'] == 0) {
                                                                echo $this->Html->link(
                                                                    '<i class="fa fa-unlink " title="' . __('Missing attachments') . '"></i>',
                                                                    array('action' => 'edit', $event['Event']['id']),
                                                                    array('escape' => false, 'class' => 'btn btn-warning')
                                                                );
                                                            } else {

                                                                echo $this->Html->link(
                                                                    '<i class="fa fa-unlink " title="' . __('Missing attachments') . '"></i>',
                                                                    array('action' => 'EditMultipleEvents', $event['Event']['id']),
                                                                    array('escape' => false, 'class' => 'btn btn-warning')
                                                                );
                                                            }
                                                        }
                                                    } ?>

                                                </li>
                                                <li>
                                                    <?php
                                                    if ($event['Event']['locked'] == 1) {
                                                        echo $this->Html->link(
                                                            '<i class="fa  fa-lock " title="' . __('Unlock') . '"></i>',
                                                            array('action' => 'unlock', $event['Event']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-purple')
                                                        );
                                                    } else {
                                                        echo $this->Html->link(
                                                            '<i class="fa  fa-unlock " title="' . __('Lock') . '"></i>',
                                                            array('action' => 'lock', $event['Event']['id']),
                                                            array('escape' => false, 'class' => 'btn btn-purple')
                                                        );
                                                    }?>
                                                </li>
                                                <li>
                                                    <?php
                                                    echo $this->Form->postLink(
                                                        '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                        array('action' => 'delete', $event['Event']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-danger'),
                                                        __('Are you sure you want to delete this event?')); ?>
                                                </li>

                                            </ul>
                                        </div>
                                    </td>
                                </tr>






                            <?php
                            }$i++;
                        }
                        ?>
                        </tbody>
                    </table>
                    <div id="pagination">
                        <?php $nb_row = $this->params['paging']['EventEventType']['pageCount'];
                        if ($nb_row > 1) {
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
</div>

<div class="card-box">
    <ul class="list-group m-b-0 user-list">
        <?php
        echo "<div class='total'><b>" . __('Transactions sum :  ') . '</b><span class="btn btn-danger btn-rounded w-md waves-effect waves-light m-b-5 height-btn-rounded">' .
            number_format($sumCost, 2, ",", ".") . " " . $this->Session->read("currency") . "</span></div>";
        ?>
    </ul>
</div>
<?php $this->start('script'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('jquery.number.min.js'); ?>
<script type="text/javascript">

    $(document).ready(function () {
        jQuery("#date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#nextdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery('#incident').css('display', 'none');


        jQuery('#type').change(function () {
            if (jQuery('#type').val() == 11) {
                jQuery('#incident').css('display', 'block');
            } else  jQuery('#incident').css('display', 'none');

        })


        jQuery('#link_search_advanced').click(function () {
            if (jQuery('#filters').is(':visible')) {
                jQuery('#filters').slideUp("slow", function () {
                });
            } else {
                jQuery('#filters').slideDown("slow", function () {
                });
            }
        });
        jQuery("#startdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#date3").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        jQuery('#file_events').change(function () {

            var $form = jQuery('#EventImportForm');
            var formdata = (window.FormData) ? new FormData($form[0]) : null;
            var data = (formdata !== null) ? formdata : $form.serialize();


            jQuery.ajax({//FormID - id of the form.
                type: "POST",
                url: "<?php echo $this->Html->url('/events/import')?>",
                contentType: false, // obligatoire pour de l'upload
                processData: false, // obligatoire pour de l'upload
                dataType: 'json', // selon le retour attendu

                data: data,
                success: function (json) {

                    //window.location = '<?php echo $this->Html->url('/cars')?>' ;
                }

            });
        });

        function toggleIcon(e) {
            $(e.target)
                .prev('.panel-heading')
                .find(".more-less")
                .toggleClass(' glyphicon-chevron-down  glyphicon-chevron-up');
        }

        $('.panel-group').on('hidden.bs.collapse', toggleIcon);
        $('.panel-group').on('shown.bs.collapse', toggleIcon);
    });

	function exportAllData() {
    <?php
     $url = "";

        if (isset($this->params['named']['car']) && !empty($this->params['named']['car'])) {
                 $url .= "/car:".$this->params['named']['car'];
            }
            if (isset($this->params['named']['customer']) && !empty($this->params['named']['customer'])) {
                $url .= "/customer:".$this->params['named']['customer'];
            }
            if (isset($this->params['named']['group']) && !empty($this->params['named']['group'])) {
                $url .= "/group:".$this->params['named']['group'];
            }
            if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
                $url .= "/user:".$this->params['named']['user'];
            }
            if (isset($this->params['named']['modified_id']) && !empty($this->params['named']['modified_id'])) {
                $url .= "/modified_id:".$this->params['named']['modified_id'];
            }
             if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
                $url .= "/created:".$this->params['named']['created'];
            }
             if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
                $url .= "/created1:".$this->params['named']['created1'];
            }

            if (isset($this->params['named']['modified']) && !empty($this->params['named']['modified'])) {
                $url .= "/modified:".$this->params['named']['modified'];
            }
             if (isset($this->params['named']['modified1']) && !empty($this->params['named']['modified1'])) {
                $url .= "/modified1:".$this->params['named']['modified1'];
            }
            if (isset($this->params['named']['type']) && !empty($this->params['named']['type'])) {
                $url .= "/type:".$this->params['named']['type'];
            }
            if (isset($this->params['named']['interfering']) && !empty($this->params['named']['interfering'])) {
                $url .= "/interfering:".$this->params['named']['interfering'];
            }
            if (isset($this->params['named']['date']) && !empty($this->params['named']['date'])) {
                $url .= "/date:".$this->params['named']['date'];
            }
            if (isset($this->params['named']['nextdate']) && !empty($this->params['named']['nextdate'])) {
                $url .= "/nextdate:".$this->params['named']['nextdate'];
            }
               if (isset($this->params['named']['pay_customer']) && !empty($this->params['named']['pay_customer'])) {
               $url .= "/pay_customer:".$this->params['named']['pay_customer'];
           }
              if (isset($this->params['named']['refund']) && !empty($this->params['named']['refund'])) {
               $url .= "/refund:".$this->params['named']['refund'];
           }
             if (isset($this->params['named']['validated']) && !empty($this->params['named']['validated'])) {
               $url .= "/validated:".$this->params['named']['validated'];
           }
            if (isset($this->params['named']['request']) && !empty($this->params['named']['request'])) {
               $url .= "/request:".$this->params['named']['request'];
           }
        ?>

        window.location = '<?php echo $this->Html->url('/events/export/')?>' + 'all_search' + '<?php echo $url;?>';


        
    }
	
	function slctlimitChanged() {
        <?php
        $url = "";

        if (isset($this->params['named']['car']) && !empty($this->params['named']['car'])) {
                 $url .= "/car:".$this->params['named']['car'];
            }
            if (isset($this->params['named']['customer']) && !empty($this->params['named']['customer'])) {
                $url .= "/customer:".$this->params['named']['customer'];
            }
            if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
                $url .= "/user:".$this->params['named']['user'];
            }
            if (isset($this->params['named']['type']) && !empty($this->params['named']['type'])) {
                $url .= "/type:".$this->params['named']['type'];
            }
            if (isset($this->params['named']['interfering']) && !empty($this->params['named']['interfering'])) {
                $url .= "/interfering:".$this->params['named']['interfering'];
            }
            if (isset($this->params['named']['date']) && !empty($this->params['named']['date'])) {
                $url .= "/date:".$this->params['named']['date'];
            }
            if (isset($this->params['named']['nextdate']) && !empty($this->params['named']['nextdate'])) {
                $url .= "/nextdate:".$this->params['named']['nextdate'];
            }
        ?>

        window.location = '<?php echo $this->Html->url('/events/search/')?>' + jQuery('#slctlimit').val() + '<?php echo $url;?>';
    }

    function printRequests(){
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        jQuery.ajax({
            type: "GET",
            url: "<?php echo $this->Html->url('/events/checkIfRequestWithSameDate/')?>",
            data: {requestIds: JSON.stringify(myCheckboxes)},
            dataType: "json",
            success: function (json) {

                if (json.response == false) {

                    alert('<?= __("The date or car of the requests is not the same.") ?>');

                }else {
                    if(myCheckboxes.length>0) {

                        var url = '<?php echo $this->Html->url (array('controller'=>'events','action' => 'printRequests', 'ext' => 'pdf'),
                            array('target' => '_blank' ))?>';
                        var form = jQuery('<form action="' + url + '" method="post">' +
                            '<input type="text" name="chkids" value="' + myCheckboxes + '" />' +
                            '</form>');
                        jQuery('body').append(form);
                        form.submit();
                    }

                }
            }
        });
    }




</script>
<?php
if ($this->Session->read('Auth.User.role_id') == 3) {
    ?>
    <script type="text/javascript">

        $(document).ready(function () { 
            // Show the text box on click
            $('body').delegate('.editable', 'click', function () {
                var ThisElement = $(this);
                ThisElement.find('span').hide();
                ThisElement.find('.table-input').show().focus();
            });

            // Pass and save the textbox values on blur function
            $('body').delegate('.table-input', 'blur', function () {
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
                    url: "<?php echo $this->Html->url('/events/update/')?>",
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
                        url: "<?php echo $this->Html->url('/events/update/')?>",
                        data: UrlToPass,
                        dataType: "json",
                        success: function (json) {

                    }
                });
            }
        });

        function toggleIcon(e) {
            $(e.target)
                .prev('.panel-heading')
                .find(".more-less")
                .toggleClass(' glyphicon-chevron-down  glyphicon-chevron-up');
        }
        $('.panel-group').on('hidden.bs.collapse', toggleIcon);
        $('.panel-group').on('shown.bs.collapse', toggleIcon);
    });
    // Show the text box on click
    </script>
<?php } ?>
<?php $this->end(); ?>
