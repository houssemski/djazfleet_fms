<style>
    .actions {
        width: 80px;
    }
</style>
<?php

App::import('Model', 'Event');
$this->Event = new Event();

?><h4 class="page-title"> <?= __('Intervention requests'); ?></h4>
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
                            'action' => 'searchRequest'
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
                            'empty' => ''
                        ));

                        echo $this->Form->input('interfering_id', array(
                            'label' => __('Interfering'),
                            'class' => 'form-filter',
                            'empty' => ''
                        ));

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

                        echo $this->Form->input('request', array(
                            'value' => '1',
                            'type' => 'hidden',

                        ));
                        echo $this->Form->input('validated', array(

                            'type' => 'hidden',

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
                                    array('action' => 'Add_request'),
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>

                             <?php
                                if ($permissionValidate == 1) {
                                    echo $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Validate'),
                                        'javascript:validateRequest();',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'validate'));
                                }
                                if ($permissionCancel == 1) {
                                    echo $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Cancel'),
                                        'javascript:cancelRequest();',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'cancel'));
                                }
                                if ($permissionTransfer == 1) {
                                    echo $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transfer'),
                                        'javascript:transferRequest();',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'transfer'));
                                }
                                if ($permissionMakeEvent == 1) {
                                    echo $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Make event'),
                                        'javascript:makeEvent();',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'make_event'));
                                }

                                if($printInterventionRequest == 1) {
                                    echo $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Print request'),
                                        'javascript:printRequests();',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'print_requests'));
                                }


                             ?>
                            </div>

                            <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                'javascript:submitDeleteForm("events/deleteevents/");',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                    'disabled' => 'true'),
                                __('Are you sure you want to delete selected events ?')); ?>
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
                                        <?= $this->Html->link(__('Export All'), 'javascript:exportAllData("events/export/all_request");') ?>
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
                <?php echo $this->Form->create('Events', array(
                    'url' => array(
                        'action' => 'searchRequest'
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
                    echo $this->Form->input('request', array(
                        'value' => '1',
                        'type' => 'hidden',

                    ));
                    echo $this->Form->input('validated', array(

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
                    'value' => 'liste_request',
                    'type' => 'hidden'
                )); ?>
                <div class="bloc-limit btn-group pull-left">
                    <div>
                        <label>
                            <?php
                            if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                            ?>
                            <select name="slctlimit" id="slctlimit"
                                    onchange="slctlimitChanged('events/index_request');">
                                <option value="20" <?php if ($limit == 20) echo 'selected="selected"' ?>>20</option>
                                <option value="25" <?php if ($limit == 25) echo 'selected="selected"' ?>>25</option>
                                <option value="50" <?php if ($limit == 50) echo 'selected="selected"' ?>>50</option>
                                <option value="100" <?php if ($limit == 100) echo 'selected="selected"' ?>>100</option>
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
                        <th><?php echo $this->Paginator->sort('Event.km', __('Km')); ?></th>
                        <th class="dtm"><?php echo $this->Paginator->sort('validated', __('Validated')); ?></th>
                        <th><?php echo $this->Paginator->sort('canceled', __('Canceled')); ?></th>
                        <th><?php echo $this->Paginator->sort('transferred', __('Transferred')); ?></th>
                        <th><?php echo $this->Paginator->sort('made_event', __('Made')); ?></th>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    </thead>


                    <tbody id="listeDiv">
                    <?php
                    $event_types = array();
                    $i = 0;

                    foreach ($events as $event) {
                        $i++;

                        if ($i < count($events)) {
                            if ($events[$i]['Event']['id'] == $event['Event']['id']) {
                                $event_types[] = $event['EventType']['name'];


                            } else {
                                $event_types[] = $event['EventType']['name'];

                                ?>

                                <tr class="alert <?= ($event['Event']['alert'] == 1) ? "alert-danger" : "" ?>"
                                    id="row<?= $event['Event']['id'] ?>">
                                    <td class='case'>

                                        <input id="idCheck" type="checkbox" class='id'
                                               value=<?php echo $event['Event']['id'] ?>>
                                    </td>
                                    <td><?=$event['Event']['code']?> </td>
                                    <td>
                                        <?php
                                        $nbEvent = count($event_types);

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
                                        if(!$editKmDate) {
                                            if ($event['Event']['date'] != NULL) {
                                                echo h($this->Time->format($event['Event']['date'], '%d-%m-%Y'));
                                            }
                                        } else { ?>
                                            <div class="table-content editable">
                                                <input
                                                        name="<?= $this->Event->encrypt("event|" . $event['Event']['id']); ?>"
                                                        value="<?= $this->Time->format($event['Event']['date'], '%d/%m/%Y') ?>"
                                                        class="form-control table-input2 date_to_change" type="text"  placeholder=''
                                                >
                                                <span style="color: #fff0; display: none;"> <?php echo $this->Time->format($event['Event']['date'], '%d/%m/%Y'); ?></span>

                                            </div>

                                        <?php }       ?>


                                    </td>
                                    <td class="right">
                                        <?php
                                        if(!$editKmDate){
                                            if ($event['Event']['km'] != NULL) {
                                                echo h(number_format($event['Event']['km'], 0, ",", "."));
                                            }
                                        }else { ?>
                                            <div class="table-content editable">
                                                <input
                                                        name="<?= $this->Event->encrypt("event|" . $event['Event']['id']); ?>"
                                                        value="<?= $event['Event']['km'] ?>" id="input3<?= $event['Event']['id'] ?>"
                                                        class="form-control table-input1 km" type="number" step ="0.01"
                                                >
                                                <span style="color: #fff0; display: none;"> <?php echo $event['Event']['km']; ?></span>
                                            </div>
                                        <?php  }

                                        ?>


                                    </td>


                                    <td class="center">

                                        <?php
                                        if ($event['Event']['validated'] == 1) {
                                            echo '<i class="fa fa-check green" ></i>';
                                        } else {

                                             echo   '<i class="fa  fa-times red" ></i>';

                                        } ?>


                                    </td>
                                    <td  class="center">

                                        <?php
                                        if ($event['Event']['canceled'] == 1) {
                                            echo '<i class="fa fa-check green" ></i>';
                                        } else {

                                            echo   '<i class="fa  fa-times red" ></i>';

                                        } ?>


                                    </td>
                                    <td class="center">

                                        <?php
                                        if ($event['Event']['transferred'] == 1) {
                                            echo '<i class="fa fa-check green" ></i>';
                                        } else {

                                            echo   '<i class="fa  fa-times red" ></i>';

                                        } ?>


                                    </td>
                                    <td class="center">

                                        <?php
                                        if ($event['Event']['made_event'] == 1) {
                                            echo '<i class="fa fa-check green" ></i>';
                                        } else {

                                            echo   '<i class="fa  fa-times red" ></i>';

                                        } ?>


                                    </td>

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

                                                <li>
                                                    <?= $this->Html->link(
                                                        '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                                                        array('action' => 'View', $event['Event']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-success')
                                                    ); ?>
                                                </li>

                                                <li>
                                                    <?php

                                                    echo $this->Html->link(
                                                        '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                        array('action' => 'edit_request', $event['Event']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-primary')
                                                    );
                                                    ?>
                                                </li>
                                                <?php
                                                if (Configure::read('logistia') == '1'){
                                                ?>
                                                <li class='edit-link' title="<?= __('Print simplified bill') ?>">
                                                    <?= $this->Html->link(
                                                        '<i class=" fa fa-print"></i>',
                                                        array('action' => 'view_request', 'ext' => 'pdf', $event['Event']['id']),
                                                        array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                                    ); ?>
                                                </li>
                                                <?php
                                                }
                                                ?>
                                                <?php if($printInterventionRequest == 1 && $event['Event']['transferred'] == 1) { ?>
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

                                                            echo $this->Html->link(
                                                                '<i class="fa fa-unlink " title="' . __('Missing attachments') . '"></i>',
                                                                array('action' => 'edit_request', $event['Event']['id']),
                                                                array('escape' => false, 'class' => 'btn btn-warning')
                                                            );

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
                            }


                        } else {
                            $event_types[] = $event['EventType']['name'];

                            ?>


                            <tr class="alert <?= ($event['Event']['alert'] == 1) ? "alert-danger" : "" ?>"
                                id="row<?= $event['Event']['id'] ?>">
                                <td class='case'>

                                    <input id="idCheck" type="checkbox" class='id'
                                           value=<?php echo $event['Event']['id'] ?>>
                                </td>
                                <td><?=$event['Event']['code']?> </td>
                                <td><?php
                                    $nbEvent = count($event_types);

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
                                    if(!$editKmDate) {
                                        if ($event['Event']['date'] != NULL) {
                                            echo h($this->Time->format($event['Event']['date'], '%d-%m-%Y'));
                                        }
                                    } else { ?>
                                        <div class="table-content editable">
                                            <input
                                                    name="<?= $this->Event->encrypt("event|" . $event['Event']['id']); ?>"
                                                    value="<?= $this->Time->format($event['Event']['date'], '%d/%m/%Y') ?>"
                                                    class="form-control table-input2 date_to_change" type="text"  placeholder=''
                                            >
                                            <span style="color: #fff0; display: none;"> <?php echo $this->Time->format($event['Event']['date'], '%d/%m/%Y'); ?></span>

                                        </div>

                                    <?php }       ?>


                                </td>
                                <td class="right">
                                    <?php
                                    if(!$editKmDate){
                                        if ($event['Event']['km'] != NULL) {
                                            echo h(number_format($event['Event']['km'], 0, ",", "."));
                                        }
                                    }else { ?>
                                        <div class="table-content editable">
                                            <input
                                                    name="<?= $this->Event->encrypt("event|" . $event['Event']['id']); ?>"
                                                    value="<?= $event['Event']['km'] ?>" id="input3<?= $event['Event']['id'] ?>"
                                                    class="form-control table-input1 km" type="number" step ="0.01"
                                            >
                                            <span style="color: #fff0; display: none;"> <?php echo $event['Event']['km']; ?></span>
                                        </div>
                                    <?php  }

                                    ?>


                                </td>


                                <td class="center">

                                    <?php
                                    if ($event['Event']['validated'] == 1) {
                                        echo '<i class="fa fa-check green" ></i>';
                                    } else {

                                        echo   '<i class="fa  fa-times red" ></i>';

                                    } ?>


                                </td>
                                <td class="center">

                                    <?php
                                    if ($event['Event']['canceled'] == 1) {
                                        echo '<i class="fa fa-check green" ></i>';
                                    } else {

                                        echo   '<i class="fa  fa-times red" ></i>';

                                    } ?>


                                </td>
                                <td class="center">

                                    <?php
                                    if ($event['Event']['transferred'] == 1) {
                                        echo '<i class="fa fa-check green" ></i>';
                                    } else {

                                        echo   '<i class="fa  fa-times red" ></i>';

                                    } ?>
                                </td>
                                <td class="center">

                                    <?php
                                    if ($event['Event']['made_event'] == 1) {
                                        echo '<i class="fa fa-check green" ></i>';
                                    } else {

                                        echo   '<i class="fa  fa-times red" ></i>';

                                    } ?>
                                </td>
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
                                                        array('action' => 'edit_request', $event['Event']['id']),
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
                                            <?php
                                            if (Configure::read('logistia') == '1'){
                                                ?>
                                                <li class='edit-link' title="<?= __('Print simplified bill') ?>">
                                                    <?= $this->Html->link(
                                                        '<i class=" fa fa-print"></i>',
                                                        array('action' => 'view_request', 'ext' => 'pdf', $event['Event']['id']),
                                                        array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                                                    ); ?>
                                                </li>
                                                <?php
                                            }
                                            ?>
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
                                                                array('action' => 'edit_request', $event['Event']['id']),
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
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <div id="pagination">
                    <?php if ($this->params['paging']['EventEventType']['pageCount'] > 1) {
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



<?php $this->start('script'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('jquery.number.min.js'); ?>
<script type="text/javascript">

    $(document).ready(function () {
        jQuery("#date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#nextdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});


        jQuery("#startdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#date3").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery(".date_to_change").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        $('body').delegate('.table-input1', 'change', function () {

            var ThisElement = $(this);
            ThisElement.find('.table-input1').show();
            var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');
            jQuery.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url('/events/updateKm/')?>",
                data: UrlToPass,
                dataType: "json",
                success: function (json) {
                    if (json.response == true) {
                        //ThisElement.find('.table-input1').show();
                       // $(".km").attr('readonly', true);
                        $(".km").blur();
                    }else {
                        $("#msg").html("<div id='flashMessage' class='message'><div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><?php echo __('You don\'t have permission to edit.'); ?></div></div>");
                        scrollToAnchor('container-fluid');
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
                url: "<?php echo $this->Html->url('/events/updateDate/')?>",
                data: UrlToPass,
                dataType: "json",
                success: function (json) {
                    if (json.response == true) {
                        ThisElement.find('.table-input2').show();
                       // $(".date_to_change").attr('readonly', true);
                        $(".date_to_change").blur();
                    }else {
                        $("#msg").html("<div id='flashMessage' class='message'><div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><?php echo __('You don\'t have permission to edit.'); ?></div></div>");
                        scrollToAnchor('container-fluid');
                    }
                }
            });
        });


    });

    function validateRequest() {

            var myCheckboxes = new Array();
            jQuery('.id:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });


        if(myCheckboxes.length>0) {
            var url = '<?php echo $this->Html->url('/events/validateRequest')?>';
            var form = jQuery('<form action="' + url + '" method="post">' +
                '<input type="text" name="chkids" value="' + myCheckboxes + '" />' +
                '</form>');
            jQuery('body').append(form);
            form.submit();
        }

    }
    function cancelRequest() {
            var myCheckboxes = new Array();
            jQuery('.id:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
        if(myCheckboxes.length>0) {
            var url = '<?php echo $this->Html->url('/events/cancelRequest')?>';
            var form = jQuery('<form action="' + url + '" method="post">' +
                '<input type="text" name="chkids" value="' + myCheckboxes + '" />' +
                '</form>');
            jQuery('body').append(form);
            form.submit();
        }
    }

    function transferRequest() {
            var myCheckboxes = new Array();
            jQuery('.id:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
        if(myCheckboxes.length>0) {
            var url = '<?php echo $this->Html->url('/events/transferRequest')?>';
            var form = jQuery('<form action="' + url + '" method="post">' +
                '<input type="text" name="chkids" value="' + myCheckboxes + '" />' +
                '</form>');
            jQuery('body').append(form);
            form.submit();
        }
    }
    function makeEvent() {
            var myCheckboxes = new Array();
            jQuery('.id:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
        if(myCheckboxes.length>0) {
            var url = '<?php echo $this->Html->url('/events/makeEvent')?>';
            var form = jQuery('<form action="' + url + '" method="post">' +
                '<input type="text" name="chkids" value="' + myCheckboxes + '" />' +
                '</form>');
            jQuery('body').append(form);
            form.submit();
        }
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

    </script>
<?php } ?>
<?php $this->end(); ?>
