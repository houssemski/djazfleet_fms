<style>
    .actions {
        width: 90px;
    }

</style>

<?php

?><h4 class="page-title"> <?= __("Employees"); ?></h4>
<?php $this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end(); ?>
<div class="box-body">

    <div class="panel-group wrap" id="bs-collapse">
        <div class="panel loop-panel">
            <a class="collapsed fltr" data-toggle="collapse" data-parent="#" href="#one">
                <i class="zmdi zmdi-search-in-page"></i>
            </a>

            <div id="one" class="panel-collapse collapse">
                <div class="panel-body">

                    <?php echo $this->Form->create('Customers', array(
                        'url' => array(
                            'action' => 'search'
                        ),
                        'novalidate' => true)); ?>

                    <div class="filters" id='filters'>
                        <input name="conditions" type="hidden"
                               value="<?php echo base64_encode(serialize($conditions)); ?>">
                        <?php
                        echo $this->Form->input('customer_category_id', array(
                            'label' => __('Category'),
                            'class' => 'form-filter select2',
                            'id'=>'customer_category',
                            'empty' => ''
                        ));

                        $options = array('1' => __("Category A"), '2' => __("Category B"), '3' => __("Category C"), '4' => __("Category D"), '5' => __("Category E"), '6' => __("Category F"));
                        echo $this->Form->input('driver_license_category', array(
                            'label' => __('Driver license'),
                            'empty' => '',
                            'type' => 'select',
                            'options' => $options,
                            'id'=>'driver_license_category',
                            'class' => 'form-filter'

                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('customer_group_id', array(
                            'label' => __('Group'),
                            'class' => 'form-filter select2',
                            'id' => 'group',
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
                                    'id' => 'startdate',
                                ));
                                echo $this->Form->input('created1', array(
                                    'label' => '',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'enddate',
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


    <div class="row">
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
                                'javascript:submitDeleteForm("customers/deletecustomers/");',
                                array('escape' => false, 'class' => 'btn btn-inverse  btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                    'disabled' => 'true'),
                                __('Are you sure you want to delete selected elements ?')); ?>
                            <div class="btn-group">
                                <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Export'),
                                    'javascript:exportData("customers/export/");',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect w-md waves-light m-b-5', 'id' => 'export', 'disabled' => 'true')) ?>
                                <button type="button" id="export_allmark"
                                        class="btn dropdown-toggle btn-inverse  btn-bordred" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <?= $this->Html->link(__('Export All'), 'javascript:exportAllData("customers/export/all");') ?>
                                    </li>
                                </ul>
                            </div>
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
                                        <?= $this->Html->link(__('Simplified journal'), 'javascript:printSimplifiedJournal();') ?>
                                    </li>

                                </ul>
                            </div>
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
                                            <?php echo $this->Html->link(__('Download file model'), '/attachments/import_xls/conducteurs.csv', array('class' => 'titre')); ?>
                                            <br/>

                                            <form id='CustomerImportForm' action='customers/import' method='post'
                                                  enctype='multipart/form-data' novalidate='novalidate'>
                                                <?php
                                                echo "<div class='form-group'>" . $this->Form->input('Customer.file_csv', array(
                                                        'label' => __('File .csv'),
                                                        'class' => '',
                                                        'type' => 'file',
                                                        'id' => 'file_customers',
                                                        'placeholder' => __('Choose file .csv'),
                                                        'empty' => '',
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



                            <?php
                            if (0){
                            $this->Html->link('<i class="fa fa-print m-r-5 m-r-5"></i>' . __('Print'),
                                'javascript:imprime_bloc("titre", "impression");',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect w-md waves-light m-b-5'));
                            }?>



                            <?= $this->Html->link('<i class="fa fa-code-fork m-r-5"></i>' . __('assign group'),
                                'javascript:assignGroup();',
                                array("class" => "btn btn-inverse btn-bordred waves-effect waves-light m-b-5 ", 'escape' => false,
                                    'id' => 'assign_customer_group', 'disabled' => 'true')); ?>


                            <div id="dialogModalGroupCustomer">
                                <!-- the external content is loaded inside this tag -->

                            </div>


                            <div style='clear:both; padding-top: 10px;'></div>

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
                <?php echo $this->Form->create('Customers', array(
                    'url' => array(
                        'action' => 'search'
                    ),
                    'novalidate' => true,
                    'id' => 'searchKeyword')); ?>
                <label style="float: right;">
                    <input id='keyword' type="text" name="keyword" id="keyword" class="form-control"
                           placeholder= <?= __("Search"); ?>>
                    <input name="conditions" type="hidden"
                           value="<?php echo base64_encode(serialize($conditions)); ?>">
                </label>
                <?php echo $this->Form->end(); ?>
                <div class="dataTables_length m-r-15" id="datatable-editable_length" style="display: inline-block;">
                    <label>&nbsp; <?= __('Order : ') ?>
                        <?php
                        if (isset($this->params['pass']['1'])) $order = $this->params['pass']['1'];
                        ?>
                        <select aria-controls="datatable-editable" class="form-control input-sm" name="selectOrder"
                                id="selectOrder"
                                onchange="selectOrderChanged('customers/index','DESC');">
                            <option value=""></option>
                            <option
                                    value="1" <?php if ($order == 1) echo 'selected="selected"' ?>> <?= __('Reference') ?></option>
                            <option
                                    value="2" <?php if ($order == 2) echo 'selected="selected"' ?>><?= __('Id') ?></option>
                            <option
                                    value="3" <?php if ($order == 3) echo 'selected="selected"' ?>><?= __('Last mission date') ?></option>

                        </select>
                    </label>
                    <span id="asc_desc" >
                        <i class="fa fa-sort-asc" id="asc" onclick="selectOrderChanged('customers/index', 'ASC');"></i>
                        <i class="fa fa-sort-desc" id="desc" onclick="selectOrderChanged('customers/index','DESC');"></i>
                        </span>
                </div>
                <div class="dataTables_length" id="datatable-editable_length" style="display: inline-block;">
                    <label>
                        <?php
                        if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                        ?>
                        <select aria-controls="datatable-editable" class="form-control input-sm" name="slctlimit" id="slctlimit" onchange="slctlimitChanged('customers/index');">
                            <option value="20" <?php if ($limit == 20) echo 'selected="selected"' ?>>20</option>
                            <option value="25" <?php if ($limit == 25) echo 'selected="selected"' ?>>25</option>
                            <option value="50" <?php if ($limit == 50) echo 'selected="selected"' ?>>50</option>
                            <option value="100" <?php if ($limit == 100) echo 'selected="selected"' ?>>100</option>
                        </select>&nbsp; <?= __('records per page') ?>
                    </label>
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
                <!--startprint-->
                <div id="impression">



                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                           cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th style="width: 10px">
                                <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i
                                            class="fa fa-square-o"></i></button>
                            </th>
                            <th><?php echo $this->Paginator->sort('code', __('Code')); ?></th>
                        <th><?php echo $this->Paginator->sort('CustomerCategory.name', __('Category')); ?></th>

                            <th><?php echo $this->Paginator->sort('first_name', __('First name')); ?></th>
                            <th><?php echo $this->Paginator->sort('last_name', __('Last name')); ?></th>
                        <th><?php echo $this->Paginator->sort('company', __('Company')); ?></th>
                        <th><?php echo $this->Paginator->sort('CustomerGroup.name', __('Group')); ?></th>
                        <th><?php echo $this->Paginator->sort('tel', __('Phone')); ?></th>
                        <th class="mob"><?php echo $this->Paginator->sort('mobile', __('Mobile')); ?></th>
                        <th><?php echo $this->Paginator->sort('email1', __('Email')); ?></th>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    </thead>

                    <tbody id="listeDiv">
                    <?php foreach ($customers as $customer): ?>
                            <tr class="alert <?= ($customer['Customer']['alert'] == 1) ? "alert-danger" : "" ?>"
                                id="row<?= $customer['Customer']['id'] ?>">
                            <td>

                                <input id="idCheck" type="checkbox" class='id'
                                       value=<?php echo $customer['Customer']['id'] ?>>
                            </td>
                            <td><?php echo h($customer['Customer']['code']); ?>&nbsp;</td>
                            <td><?php echo h($customer['CustomerCategory']['name']); ?>&nbsp;</td>
                            <td><?php echo h($customer['Customer']['first_name']); ?>&nbsp;</td>
                            <td><?php echo h($customer['Customer']['last_name']); ?>&nbsp;</td>
                            <td><?php echo h($customer['Customer']['company']); ?>&nbsp;</td>
                            <td><?php echo h($customer['CustomerGroup']['name']); ?>&nbsp;</td>
                            <td><?php echo h($customer['Customer']['tel']); ?>&nbsp;</td>
                            <td><?php echo h($customer['Customer']['mobile']); ?>&nbsp;</td>
                            <td><?php echo h($customer['Customer']['email1']); ?>&nbsp;</td>
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
                                                    '<i   class="fa fa-eye"></i>',
                                                    array('action' => 'View', $customer['Customer']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-success')
                                                ); ?>
                                            </li>

                                            <li class='edit-link' title='<?= __('Edit') ?>'>
                                                <?= $this->Html->link(
                                                    '<i class="fa fa-edit"></i>',
                                                    array('action' => 'Edit', $customer['Customer']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-primary')
                                                ); ?>
                                            </li>

                                            <?php if (isset($customer['Customer']['identity_card_scan']) && !empty($customer['Customer']['identity_card_scan']) &&
                                                isset($customer['Customer']['driver_license_scan']) && !empty($customer['Customer']['driver_license_scan']) &&
                                                isset($customer['Customer']['passport_scan']) && !empty($customer['Customer']['passport_scan']) &&
                                                isset($customer['Customer']['image']) && !empty($customer['Customer']['image'])
                                            ) {
                                                echo '<li class = "attachments-link" title="' . __('Attachments') . '">';
                                                echo $this->Html->link(
                                                    '<i class="fa fa-paperclip"></i>',
                                                    array('action' => 'View', $customer['Customer']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-warning')

                                                );
                                            } else {
                                                if (empty($customer['Customer']['identity_card_scan']) && empty($customer['Customer']['driver_license_scan'])
                                                    && empty($customer['Customer']['passport_scan']) && empty($customer['Customer']['image'])
                                                ) {
                                                    echo '<li class = "missing-attachments-link" title="' . __('Missing attachments') . '">';
                                                    echo $this->Html->link(
                                                        '<i class="fa fa-unlink"></i>',
                                                        array('action' => 'Edit', $customer['Customer']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-warning')

                                                    );
                                                } elseif (empty($customer['Customer']['identity_card_scan'])) {
                                                    echo $this->Html->link(
                                                        '<i class="fa fa-unlink" title="' . __('Missing attachments identity card ') . '"></i>',

                                                        array('action' => 'Edit', $customer['Customer']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-warning')

                                                    );
                                                } elseif (empty($customer['Customer']['driver_license_scan'])) {
                                                    echo $this->Html->link(
                                                        '<i class="fa fa-unlink " title="' . __('Missing attachments driver license') . '"></i>',

                                                        array('action' => 'Edit', $customer['Customer']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-warning')

                                                    );
                                                } elseif (empty($customer['Customer']['passport_scan'])) {
                                                    echo $this->Html->link(
                                                        '<i class="fa fa-unlink " title="' . __('Missing attachments passport') . '"></i>',

                                                        array('action' => 'Edit', $customer['Customer']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-warning')

                                                    );
                                                } elseif (empty($customer['Customer']['image'])) {
                                                    echo $this->Html->link(
                                                        '<i class="fa fa-unlink " title="' . __('Missing attachments image') . '"></i>',

                                                        array('action' => 'Edit', $customer['Customer']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-warning')

                                                    );
                                                }


                                            } ?>

                                            </li>
                                            <li>
                                                <?php
                                                if ($customer['Customer']['locked'] == 1) {
                                                    echo $this->Html->link(
                                                        '<i class="fa  fa-lock " title="' . __('Unlock') . '"></i>',
                                                        array('action' => 'unlock', $customer['Customer']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-purple')
                                                    );
                                                } else {
                                                    echo $this->Html->link(
                                                        '<i class="fa  fa-unlock " title="' . __('Lock') . '"></i>',
                                                        array('action' => 'lock', $customer['Customer']['id']),
                                                        array('escape' => false, 'class' => 'btn btn-purple')
                                                    );
                                                }?>
                                            </li>
                                            <li>
                                                <?php
                                                echo $this->Form->postLink(
                                                    '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                    array('action' => 'delete', $customer['Customer']['id']),
                                                    array('escape' => false, 'class' => 'btn btn-danger'),
                                                    __('Are you sure you want to delete %s?', $customer['Customer']['first_name'] . " " . $customer['Customer']['last_name'])); ?>
                                            </li>


                                        </ul>
                                    </div>


                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                    </table>
                    <div id="pagination">
                        <?php if ($this->params['paging']['Customer']['pageCount'] > 1) { ?>
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
    <!--endprint-->


    <div class="card-box">


        <h4 class="header-title m-t-0 m-b-30"><a href="#total" data-toggle="collapse"><i
                    class="zmdi zmdi-notifications-none m-r-5"></i> <?php echo __('Totals') ?></h4>

        <div id="total" class="collapse">
            <ul class="list-group m-b-0 user-list">

                <?php    foreach ($customerCategories as $customerCategory) {
                    $found = false;
                    foreach ($totals as $total) {
                        if ($customerCategory == $total['CustomerCategory']['name']) {


                            echo " <li class='list-group-item'>
            <a href='#' class='user-list-item'>
            <div class='avatar text-center'>
                    <i class='zmdi zmdi-circle text-success'></i>
                </div>
                <div class='user-desc'>
                    <span class='name'><strong> " . $total['CustomerCategory']['name'] . " </strong> : " . $total[0]['total'] . "";

                            if ($total[0]['total'] > 1) echo " " . __('Customers') . "</span>
                </div>
            </a>
        </li>";

                            else echo " " . __('Customer') . "</span>
                </div>
            </a>
        </li>";
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        echo "<li class='list-group-item'>
            <a href='#' class='user-list-item'>
            <div class='avatar text-center'>
                    <i class='zmdi zmdi-circle text-success'></i>
                </div>
                <div class='user-desc'>
                    <span class='name'><strong> " . $customerCategory . " </strong>:  0 " . __('Conductor') . "</span>
                </div>
            </a>
        </li>";
                    }
                } ?>


            </ul>

        </div>

    </div>

    <br>
    <br>

    <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <?php $this->start('script'); ?>
    <?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
    <?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
    <?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
    <?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
    <?= $this->Html->script('bootstrap-filestyle'); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            jQuery("#dialogModalGroupCustomer").dialog({
                autoOpen: false,
                height: 320,
                width: 400,
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

        function assignGroup() {


            var myCheckboxes = new Array();
            jQuery('.id:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });


            jQuery('#dialogModalGroupCustomer').dialog('option', 'title', 'Affecter à un groupe');
            jQuery('#dialogModalGroupCustomer').dialog('open');
            jQuery('#dialogModalGroupCustomer').load('<?php echo $this->Html->url('/customers/assign/')?>' + myCheckboxes);

        }
	
	function exportAllData() {
        <?php
        $url = "";

        if (isset($this->params['named']['mark']) && !empty($this->params['named']['mark'])) {
            $url .= "/mark:" . $this->params['named']['mark'];
        }
        if (isset($this->params['named']['model']) && !empty($this->params['named']['model'])) {
            $url .= "/model:" . $this->params['named']['model'];
        }
        if (isset($this->params['named']['category']) && !empty($this->params['named']['category'])) {
            $url .= "/category:" . $this->params['named']['category'];
        }
        if (isset($this->params['named']['type']) && !empty($this->params['named']['type'])) {
            $url .= "/type:" . $this->params['named']['type'];
        }
        if (isset($this->params['named']['fuel']) && !empty($this->params['named']['fuel'])) {
            $url .= "/fuel:" . $this->params['named']['fuel'];
        }
        if (isset($this->params['named']['status']) && !empty($this->params['named']['status'])) {
            $url .= "/status:" . $this->params['named']['status'];
        }
        if (isset($this->params['named']['parc']) && !empty($this->params['named']['parc'])) {
            $url .= "/parc:" . $this->params['named']['parc'];
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
        window.location = '<?php echo $this->Html->url('/customers/export/')?>' + 'all_search' + '<?php echo $url;?>';

    }
	
        function printSimplifiedJournal() {
            var conditions = new Array();
            conditions[0] = jQuery('#customer_category').val();
            conditions[1] = jQuery('#driver_license_category').val();
            conditions[2] = jQuery('#group').val();
            conditions[3] = jQuery('#parc').val();
            var myCheckboxes = new Array();
            jQuery('.id:checked').each(function () {
                myCheckboxes.push(jQuery(this).val());
            });
            var url = '<?php echo $this->Html->url(array('action' => 'printSimplifiedJournal', 'ext' => 'pdf'),
         array('target' => '_blank' ))?>';
            var form = jQuery('<form action="' + url + '" method="post" target="_Blank" >' +
            '<input type="hidden" name="printSimplifiedJournal" value="' + conditions + '" />' +
            '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();
        }
    </script>
    <?php $this->end(); ?>

