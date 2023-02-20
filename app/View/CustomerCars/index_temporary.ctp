<?php


?><h4 class="page-title"> <?= __('Temporary affectation'); ?></h4>
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

                        <?php echo $this->Form->create('CustomerCars', array(
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
                            echo $this->Form->input('affectation', array(
                                'label' => __('affectation'),
                                'type' => 'hidden',
                                'class' => 'form-filter',
                                'value' => 1,
                                'empty' => ''
                            ));
                            echo $this->Form->input('request', array(
                                'value' => '0',
                                'type' => 'hidden',
                            ));
                            echo $this->Form->input('temporary', array(
                                'label' => __('temporary'),
                                'type' => 'hidden',
                                'class' => 'form-filter',
                                'value' => 1,
                                'empty' => ''
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
                            if ($hasParc) {
                                echo $this->Form->input('parc_id', array(
                                    'label' => __('Parc'),
                                    'class' => 'form-filter select2',
                                    'id' => 'parc',
                                    'empty' => ''
                                ));
                            } else {
                                if ($nb_parcs > 0) {
                                    echo $this->Form->input('parc_id', array(
                                        'label' => __('Parc'),
                                        'class' => 'form-filter select2',
                                        'id' => 'parc',
                                        'type' => 'select',
                                        'options' => $parcs,
                                        'empty' => ''
                                    ));
                                }
                            }
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
                            echo $this->Form->input('temporary', array(
                                'value' => '1',
                                'type' => 'hidden',
                            ));
                            if ($isSuperAdmin) {
                                echo "<div style='clear:both; padding-top: 40px;'></div>";
                                echo '<div class="lbl"> <a href="#demo" data-toggle="collapse"><i class="fa fa-search"></i>' . __("  Administrative filter") . '</a></div>';
                                ?>
                                <div id="demo" class="collapse">
                                    <div
                                        style="clear:both; padding-top: 0;padding-left: 20px;  border-bottom: 1px solid rgb(204, 204, 204);margin-bottom: 15px;"></div>
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
                                <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                    array('action' => 'add_temporary'),
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                                <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                    'javascript:submitDeleteForm("customerCars/deletecustomercars");',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                        'disabled' => 'true'),
                                    __('Are you sure you want to delete selected elements ?')); ?>
                                <div class="btn-group">
                                    <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Export'),
                                        'javascript:exportData("customerCars/export/");',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect w-md waves-light m-b-5', 'id' => 'export', 'disabled' => 'true')) ?>
                                    <button type="button" id="export_allmark"
                                            class="btn dropdown-toggle btn-inverse btn-bordred" data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <?= $this->Html->link(__('Export All'), 'javascript:exportAllData("customerCars/export/all");') ?>
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
                               value="<?php echo base64_encode(serialize($conditions)); ?>">
                        <input name="conditions_car" type="hidden"
                               value="<?php echo base64_encode(serialize($conditions_car)); ?>">
                        <input name="conditions_customer" type="hidden"
                               value="<?php echo base64_encode(serialize($conditions_customer)); ?>">
                        <?php  echo $this->Form->input('affectation', array(
                            'label' => __('affectation'),
                            'type' => 'hidden',
                            'class' => 'form-filter',
                            'value' => 1,
                            'empty' => ''
                        ));
                        echo $this->Form->input('request', array(
                            'value' => '0',
                            'type' => 'hidden',
                        ));
                        echo $this->Form->input('temporary', array(
                            'label' => __('temporary'),
                            'type' => 'hidden',
                            'class' => 'form-filter',
                            'value' => 1,
                            'empty' => ''
                        )); ?>
                    </label>
                    <?php echo $this->Form->end(); ?>
                    <?= $this->Form->input('controller', array(
                        'id' => 'controller',
                        'value' => $this->request->params['controller'],
                        'type' => 'hidden'
                    )); ?>

                    <?= $this->Form->input('action', array(
                        'id' => 'action',
                        'value' => 'liste_temporary',
                        'type' => 'hidden'
                    )); ?>
                    <div class="bloc-limit btn-group pull-left">
                        <div>
                            <label>
                                <?php
                                if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                                ?>
                                <select name="slctlimit" id="slctlimit"
                                        onchange="slctlimitChanged('customerCars/index_temporary');">
                                    <option value="20" <?php if ($limit == 20) echo 'selected="selected"' ?>>20</option>
                                    <option value="25" <?php if ($limit == 25) echo 'selected="selected"' ?>>25</option>
                                    <option value="50" <?php if ($limit == 50) echo 'selected="selected"' ?>>50</option>
                                    <option value="100" <?php if ($limit == 100) echo 'selected="selected"' ?>>100
                                    </option>
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
                            <th><?php echo $this->Paginator->sort('Carmodel.name', __('Car')); ?></th>
                            <th class="imd"><?php echo $this->Paginator->sort('Car.immatr_prov', __('IM.P')); ?></th>
                            <th class="imd"><?php echo $this->Paginator->sort('Car.immatr_def', __('IM.D')); ?></th>
                            <th><?php echo $this->Paginator->sort('Customer.first_name', __("Conductor")); ?></th>
                            <th><?php echo $this->Paginator->sort('CustomerGroup.name', __('Group')); ?></th>
                            <th><?php echo $this->Paginator->sort('Customer.mobile', __('Mobile')); ?></th>
                            <th><?php echo __('Starting date'); ?></th>
                            <th><?php echo __('Planned Arrival date '); ?></th>
                            <th><?php echo __('Real Arrival date'); ?></th>

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
                                    <?php echo $customercar['CustomerGroup']['name']; ?>&nbsp;
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

                                    <div class="btn-group " style="width: 70px;">
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
                                                    array('action' => 'View', $customercar['CustomerCar']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-success')
                                                ); ?>
                                            </li>

                                            <li>
                                                <?= $this->Html->link(
                                                    '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                    array('action' => 'Edit_temporary', $customercar['CustomerCar']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-primary')
                                                ); ?>
                                            </li>
                                            <?php if($printAffectation == 1) {?>
                                            <li class='decharge-link' title='<?= __('Mission order') ?>'>
                                                <?php echo $this->Html->link('<i class="fa fa-Print "></i>',
                                                    array('action' => 'view_mission', 'ext' => 'pdf', $customercar['CustomerCar']['id']),
                                                    array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning'));?>
                                            </li>
                                            <?php } ?>
                                            <li>
                                                <?php
                                                if ($customercar['CustomerCar']['locked'] == 1) {
                                                    echo $this->Html->link(
                                                        '<i class="fa  fa-lock " title="' . __('Unlock') . '"></i>',
                                                        array('action' => 'unlock', $customercar['CustomerCar']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-purple')
                                                    );
                                                } else {
                                                    echo $this->Html->link(
                                                        '<i class="fa  fa-unlock " title="' . __('Lock') . '"></i>',
                                                        array('action' => 'lock', $customercar['CustomerCar']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-purple')
                                                    );
                                                }?>
                                            </li>
                                            <li>
                                                <?php
                                                echo $this->Form->postLink(
                                                    '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
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
    <script type="text/javascript">
        $(document).ready(function () {

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

    </script>
<?php $this->end(); ?>