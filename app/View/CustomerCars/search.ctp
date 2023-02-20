<?php

?><h4 class="page-title"> <?= __('Search'); ?></h4>
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

                    <?php echo $this->Form->create('CustomerCars', array(
                        'url' => array(
                            'action' => 'search'
                        ),
                        'novalidate' => true
                    )); ?>

                    <div class="filters" id='filters'>
                        <input name="conditions" type="hidden"
                               value="<?php echo base64_encode(serialize($conditions_index)); ?>">
                        <input name="conditions_car" type="hidden"
                               value="<?php echo base64_encode(serialize($conditions_car)); ?>">
                        <input name="conditions_customer" type="hidden"
                               value="<?php echo base64_encode(serialize($conditions_customer)); ?>">
                        <?php
                        echo $this->Form->input('temporary', array(
                            'value' => $temporary,
                            'type' => 'hidden',
                        ));
                        echo $this->Form->input('car_id', array(
                            'label' => __('Car'),
                            'class' => 'form-filter select2',
                            'empty' => ''
                        ));
                        echo "<span id='model'>" . $this->Form->input('customer_id', array(
                                'label' => __("Conductor"),
                                'class' => 'form-filter select2',
                                'empty' => ''
                            )) . "</span>";
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('zone_id', array(
                            'label' => __('Zone'),
                            'class' => 'form-filter select2',
                            'empty' => ''
                        ));
                        echo $this->Form->input('customer_group_id', array(
                            'label' => __('Group'),
                            'class' => 'form-filter select2',
                            'empty' => ''
                        ));


                        echo $this->Form->input('parc_id', array(
                            'label' => __('Parc'),
                            'class' => 'form-filter select2',
                            'id' => 'parc',
                            'type' => 'select',
                            'options' => $parcs,
                            'empty' => ''
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";

                        echo $this->Form->input('start1', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Start date from') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'startdate1',
                        ));
                        echo $this->Form->input('start2', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'startdate2',
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('end_planned1', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Planned end date from') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'enddate1',
                        ));
                        echo $this->Form->input('end_planned2', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'enddate2',
                        ));


                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('end_real1', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Real end date from') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'realenddate1',
                        ));
                        echo $this->Form->input('end_real2', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'realenddate2',
                        ));


                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        $options = array('1' => __('Yes'), '2' => __('No'));
                        echo $this->Form->input('state', array(
                            'label' => __("Affectation") . ' ' . __('Current'),
                            'options' => $options,
                            'class' => 'form-filter',
                            'empty' => ''
                        ));

                        echo "<div style='clear:both; padding-top: 10px;'></div>";
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
                            <?php if ($request == 0) { ?>
                                <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                    array('action' => 'Add'),
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                            <?php } ?>
                            <?php if ($request == 1) { ?>
                                <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                    array('action' => 'add_request'),
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                            <?php } ?>
                            <?php if ($temporary == 1) { ?>
                                <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                    array('action' => 'add_temporary'),
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                            <?php } ?>
                            <?php if ($temporary == 0) { ?>
                                <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                    array('action' => 'addAffectation'),
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                            <?php } ?>
                            <?= $this->Html->link('<i class=" fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                'javascript:submitDeleteForm();',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete_customercar',
                                    'disabled' => 'true'),
                                __('Are you sure you want to delete selected elements ?')); ?>
                            <div class="btn-group">
                                <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Export'),
                                    'javascript:exportData();',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'export_customercar', 'disabled' => 'true')) ?>
                                <button type="button" id="export_allmark"
                                        class="btn dropdown-toggle btn-inverse  btn-bordred" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <?= $this->Html->link(__('Export All'), 'javascript:exportAllData();') ?>
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
                <?php echo $this->Form->create('CustomerCars', array(
                    'url' => array(
                        'action' => 'search'
                    ),
                    'novalidate' => true,
                    'id' => 'searchKeyword'
                )); ?>
                <label style="float: right;">
                    <input id='keyword' type="text" name="keyword" id="keyword" class="form-control"
                           placeholder= <?= __("Search"); ?>>
                    <input name="conditions" type="hidden"
                           value="<?php echo base64_encode(serialize($conditions_index)); ?>">
                    <input name="conditions_car" type="hidden"
                           value="<?php echo base64_encode(serialize($conditions_car)); ?>">
                    <input name="conditions_customer" type="hidden"
                           value="<?php echo base64_encode(serialize($conditions_customer)); ?>">
                </label>
                <?php echo $this->Form->end(); ?>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                       cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th style="width: 10px">
                            <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i
                                        class="fa fa-square-o"></i></button>
                        </th>
                        <th><?php echo $this->Paginator->sort('Carmodel.name', __('Car')); ?></th>
                        <th class="imd"><?php echo $this->Paginator->sort('Car.immatr_prov', __('IM.P')); ?></th>
                        <th class="imd"><?php echo $this->Paginator->sort('Car.immatr_def', __('IM.D')); ?></th>
                        <th><?php echo $this->Paginator->sort('Customer.first_name', __("Conductor")); ?></th>
                        <th><?php echo $this->Paginator->sort('Customer.mobile', __('Mobile')); ?></th>
                        <th><?php echo $this->Paginator->sort('start', __('Starting date')); ?></th>
                        <th><?php echo $this->Paginator->sort('end', __('Planned Arrival date ')); ?></th>
                        <th><?php echo $this->Paginator->sort('end_real', __('Real Arrival date')); ?></th>

                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    </thead>




                    <tbody id="listeDiv">
                    <?php foreach ($customercars as $customercar): ?>
                        <tr id="row<?= $customercar['CustomerCar']['id'] ?>">
                            <td>

                                <input id="idCheck" type="checkbox" class='id'
                                       value=<?php echo $customercar['CustomerCar']['id'] ?>>
                            </td>
                            <td>
                                <?php if ($param == 1) {
                                    echo $customercar['Car']['code'] . " - " . $customercar['Carmodel']['name'];
                                } else if ($param == 2) {
                                    echo $customercar['Car']['immatr_def'] . " - " . $customercar['Carmodel']['name'];
                                } ?>
                            </td>
                            <td>
                                <?php echo $customercar['Car']['immatr_prov']; ?>&nbsp;
                            </td>
                            <td>
                                <?php echo $customercar['Car']['immatr_def']; ?>&nbsp;
                            </td>
                            <td>
                                <?php

                                echo $customercar['Customer']['first_name'] . " " . $customercar['Customer']['last_name']; ?>
                                &nbsp;
                            </td>
                            <td>
                                <?php echo $customercar['Customer']['mobile']; ?>&nbsp;
                            </td>

                            <td><?php echo h($this->Time->format($customercar['CustomerCar']['start'], '%d-%m-%Y %H:%M')); ?>
                                &nbsp;</td>
                            <td><?php echo h($this->Time->format($customercar['CustomerCar']['end'], '%d-%m-%Y %H:%M')); ?>
                                &nbsp;</td>
                            <td><?php echo h($this->Time->format($customercar['CustomerCar']['end_real'], '%d-%m-%Y %H:%M')); ?>
                                &nbsp;</td>

                            <td class="actions">
                                <div class="btn-group ">
                                    <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                        <i class="fa fa-list fa-inverse"></i>
                                    </a>
                                    <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                                        <span class="caret"></span>
                                    </button>

                                    <ul class="dropdown-menu" style="min-width: 70px;">

                                        <li class='view-link' title='<?= __('View') ?>'>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-eye"></i>',
                                                array('action' => 'View', $customercar['CustomerCar']['id']),
                                                array('escape' => false, 'class' => 'btn btn-success')
                                            ); ?>
                                        </li>

                                        <li class='edit-link' title='<?= __('Edit') ?>'>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-edit"></i>',
                                                array('action' => 'Edit', $customercar['CustomerCar']['id']),
                                                array('escape' => false, 'class' => 'btn btn-primary')
                                            ); ?>
                                        </li>

                                        <li class='pv-reception-link' title='<?= __('PV de reception') ?>'>
                                            <?php echo $this->Html->link('<i class="fa fa-Print "></i>',
                                                array('action' => 'affectation_pv', 'ext' => 'pdf', $customercar['CustomerCar']['id'], 0),
                                                array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning'));?>
                                        </li>
                                        <li class='pv-restitution-link' title='<?= __('PV de restitution') ?>'>
                                            <?php echo $this->Html->link('<i class="fa fa-Print "></i>',
                                                array('action' => 'affectation_pv', 'ext' => 'pdf', $customercar['CustomerCar']['id'], 1),
                                                array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning'));?>
                                        </li>

                                        <li class='decharge-link' title='<?= __('Discharge') ?>'>
                                            <?php echo $this->Html->link('<i class="fa fa-Print "></i>',
                                                array('action' => 'dechargePdf', 'ext' => 'pdf', $customercar['CustomerCar']['id']),
                                                array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning'));?>
                                        </li>
                                        <li class='decharge-link' title='<?= __('Mission order') ?>'>
                                            <?php echo $this->Html->link('<i class="fa fa-Print "></i>',
                                                array('action' => 'view_mission', 'ext' => 'pdf', $customercar['CustomerCar']['id']),
                                                array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning'));?>
                                        </li>
                                        <?php
                                        if ($customercar['CustomerCar']['locked'] == 1) {
                                            echo '<li class = "unlock-link" title="' . __('Unlock') . '">';
                                            echo $this->Html->link(
                                                '<i class="fa  fa-lock"></i>',
                                                array('action' => 'unlock', $customercar['CustomerCar']['id']),
                                                array('escape' => false, 'class' => 'btn btn-purple')
                                            );
                                        } else {
                                            echo '<li class = "lock-link" title="' . __('Lock') . '">';
                                            echo $this->Html->link(
                                                '<i class="fa  fa-unlock"></i>',
                                                array('action' => 'lock', $customercar['CustomerCar']['id']),
                                                array('escape' => false, 'class' => 'btn btn-purple')
                                            );
                                        }
                                        ?>
                                        </li>
                                        <li class='mail-link' title='<?= __('Send the mission order by email') ?>'>
                                            <?php
                                            echo $this->Html->link(
                                                '<i class="fa fa-envelope"></i>',
                                                array('action' => 'Send_mail', $customercar['CustomerCar']['id']),
                                                array('escape' => false, 'class' => 'btn btn-inverse'));
                                            ?>
                                        </li>


                                        <li class='delete-link' title='<?= __('Delete') ?>'>
                                            <?php
                                            echo $this->Form->postLink(
                                                '<i class="fa fa-trash-o"></i>',
                                                array('action' => 'delete', $customercar['CustomerCar']['id']),
                                                array('escape' => false, 'class' => 'btn btn-danger'),
                                                __('Are you sure you want to delete this element ?')); ?>
                                        </li>


                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <div id="pagination" class="pull-right">
                    <?php if ($this->params['paging']['CustomerCar']['pageCount'] > 1) { ?>
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
<script type="text/javascript">     $(document).ready(function () {

        jQuery("#startdate1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdate2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddate1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddate2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#realenddate1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#realenddate2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});


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
              if (isset($this->params['named']['zone']) && !empty($this->params['named']['zone'])) {
                  $url .= "/zone:".$this->params['named']['zone'];
              }
              if (isset($this->params['named']['parc']) && !empty($this->params['named']['parc'])) {
                  $url .= "/parc:".$this->params['named']['parc'];
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
              if (isset($this->params['named']['start1']) && !empty($this->params['named']['start1'])) {
                  $url .= "/start1:".$this->params['named']['start1'];
              }
               if (isset($this->params['named']['start2']) && !empty($this->params['named']['start2'])) {
                  $url .= "/start2:".$this->params['named']['start2'];
              }
              if (isset($this->params['named']['end1']) && !empty($this->params['named']['end1'])) {
                  $url .= "/end1:".$this->params['named']['end1'];
              }
              if (isset($this->params['named']['end2']) && !empty($this->params['named']['end2'])) {
                  $url .= "/end2:".$this->params['named']['end2'];
              }
              if (isset($this->params['named']['end_real1']) && !empty($this->params['named']['end_real1'])) {
                  $url .= "/end_real1:".$this->params['named']['end_real1'];
              }
              if (isset($this->params['named']['end_real2']) && !empty($this->params['named']['end_real2'])) {
                  $url .= "/end_real2:".$this->params['named']['end_real2'];
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
               if (isset($this->params['named']['paid']) && !empty($this->params['named']['paid'])) {
                  $url .= "/paid:".$this->params['named']['paid'];
              }
              if (isset($this->params['named']['state']) && !empty($this->params['named']['state'])) {
                  $url .= "/state:".$this->params['named']['state'];
              }
               if (isset($this->params['named']['validated']) && !empty($this->params['named']['validated'])) {
                  $url .= "/validated:".$this->params['named']['validated'];
              }
               if (isset($this->params['named']['request']) && !empty($this->params['named']['request'])) {
                  $url .= "/request:".$this->params['named']['request'];
              }
          ?>
        window.location = '<?php echo $this->Html->url('/customerCars/export/')?>' + 'all_search' + '<?php echo $url;?>';

    }
    function exportData() {
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        var url = '<?php echo $this->Html->url('/customerCars/export/')?>';
        var form = jQuery('<form action="' + url + '" method="post">' +
        '<input type="text" name="chkids" value="' + myCheckboxes + '" />' +
        '</form>');
        jQuery('body').append(form);
        form.submit();
    }
    function submitDeleteForm() {
        jQuery('.id:checked').each(function () {
            var id = jQuery(this).val();
            jQuery.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url('/customerCars/deletecustomercars/')?>",
                data: "id=" + jQuery(this).val(),
                dataType: "json",
                success: function (json) {
                    if (json.response === "true") {
                        jQuery('#row' + id).remove();
                    }
                }
            });
        });
        // window.location = '<?php echo $this->Html->url('/customerCars/search/')?>' + jQuery('#slctlimit').val();
    }
    function slctlimitChanged() {
        <?php
       $url = "";

        if (isset($this->params['named']['request'])) {
            $url .= "/request:" . $this->params['named']['request'];
        }
       
        if (isset($this->params['named']['temporary'])) {
            $url .= "/temporary:" . $this->params['named']['temporary'];
        }
       if (isset($this->params['named']['car']) && !empty($this->params['named']['car'])) {
                $url .= "/car:".$this->params['named']['car'];
           }
           if (isset($this->params['named']['customer']) && !empty($this->params['named']['customer'])) {
               $url .= "/customer:".$this->params['named']['customer'];
           }
           if (isset($this->params['named']['user']) && !empty($this->params['named']['user'])) {
               $url .= "/user:".$this->params['named']['user'];
           }
           if (isset($this->params['named']['start']) && !empty($this->params['named']['start'])) {
               $url .= "/start:".$this->params['named']['start'];
           }
           if (isset($this->params['named']['end']) && !empty($this->params['named']['end'])) {
               $url .= "/end:".$this->params['named']['end'];
           }

           if (isset($this->params['named']['created']) && !empty($this->params['named']['created'])) {
               $url .= "/created:".$this->params['named']['created'];
           }
           if (isset($this->params['named']['created1']) && !empty($this->params['named']['created1'])) {
               $url .= "/created1:".$this->params['named']['created1'];
        }
        if (isset($this->params['named']['conditions']) && !empty($this->params['named']['conditions'])) {
            $url .= "/conditions:" . $this->params['named']['conditions'];
        }
        if (isset($this->params['named']['conditions_car']) && !empty($this->params['named']['conditions_car'])) {
            $url .= "/conditions_car:" . $this->params['named']['conditions_car'];
        }
        if (isset($this->params['named']['conditions_customer']) && !empty($this->params['named']['conditions_customer'])) {
            $url .= "/conditions_customer:" . $this->params['named']['conditions_customer'];
           }
       ?>
        window.location = '<?php echo $this->Html->url('/customerCars/search/')?>' + jQuery('#slctlimit').val() + '<?php echo $url;?>';
    }

    jQuery('input.checkall').on('ifClicked', function (event) {
        var cases = jQuery(":checkbox.id");
        if (jQuery('#checkall').prop('checked')) {
            cases.iCheck('uncheck');
            jQuery("#delete_customercar").attr("disabled", "true");
            jQuery("#export_customercar").attr("disabled", "true");
        } else {
            cases.iCheck('check');
            jQuery("#delete_customercar").removeAttr("disabled");
            jQuery("#export_customercar").removeAttr("disabled");
        }

    });

    jQuery('input.id').on('ifUnchecked', function (event) {
        var ischecked = false;
        jQuery(":checkbox.id").each(function () {
            if (jQuery(this).prop('checked')) ischecked = true;
        });
        if (!ischecked) {
            jQuery("#delete_customercar").attr("disabled", "true");
            jQuery("#export_customercar").attr("disabled", "true");
        }
    });

    jQuery('input.id').on('ifChecked', function (event) {
        jQuery("#delete_customercar").removeAttr("disabled");
        jQuery("#export_customercar").removeAttr("disabled");
    });

    jQuery('#link_search_advanced').click(function () {
        if (jQuery('#filters').is(':visible')) {
            jQuery('#filters').slideUp("slow", function () {
            });
        } else {
            jQuery('#filters').slideDown("slow", function () {
            });
        }
    });
    jQuery("#startdate1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    jQuery("#enddate1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    jQuery("#startdate2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    jQuery("#enddate2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    jQuery("#realenddate1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    jQuery("#realenddate2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    jQuery("#startdatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    jQuery("#enddatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    jQuery("#startdatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    jQuery("#enddatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

    function toggleIcon(e) {
        $(e.target)
            .prev('.panel-heading')
            .find(".more-less")
            .toggleClass(' glyphicon-chevron-down  glyphicon-chevron-up');
    }
    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);
</script>
<?php $this->end(); ?>
