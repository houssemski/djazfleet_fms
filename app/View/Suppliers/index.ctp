<?php

if ($this->params['pass']['0'] == 0) {
    $client = false;
    $supplier = true;
    ?>
    <h4 class="page-title"> <?= __('Suppliers'); ?></h4>
<?php } else {
    $client = true;
    $supplier = false;
    ?>
    <h4 class="page-title"> <?= __('Clients'); ?></h4>

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
                    <?php echo $this->Form->create('Suppliers', array(
                        'url' => array(
                            'action' => 'search'
                        ),
                        'novalidate' => true
                    )); ?>
                    <div class="filters" id='filters'>
                        <?php
                        echo $this->Form->input('supplier_category_id', array(
                            'label' => __('Category'),
                            'class' => 'form-filter select2',
                            'empty' => ''
                        ));
                        $options = array('2' => __('No'), '1' => __('Yes'));
                        echo $this->Form->input('active', array(
                            'label' => __('Actif'),
                            'class' => 'form-filter select2',
                            'options' => $options,
                            'empty' => ''
                        ));
                        echo $this->Form->input('type', array(
                            'type' => 'hidden',
                            'class' => 'form-filter',
                           // 'id'=>'type',
                            'value' => $this->params['pass']['0'],
                            'empty' => ''
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        if($profileId == ProfilesEnum::client) {
                            echo $this->Form->input('client_id', array(
                                'label' => __('Client'),
                                'type'=>'hidden',
                                'value'=>$supplierId,
                                'id' => 'client',
                                'empty' => ''
                            ));
                            echo $this->Form->input('supplier_id', array(
                                'label' => __('Client'),
                                'class' => 'form-filter select-search-client-final',
                                'id' => 'supplier',
                                'empty' => ''
                            ));
                        } else {
                            if($type ==1){
                            echo $this->Form->input('supplier_id', array(
                                'label' => __('Final suppliers'),
                                'class' => 'form-filter select-search-client-initial',
                                'id' => 'supplier',
                                'empty' => ''
                            ));
                            }
                        }
                        if ($isSuperAdmin) {
                            echo "<div style='clear:both; padding-top: 10px;'></div>";

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
    <!-- end of #bs-collapse  -->
    <div class="row collapse" id="grp_actions">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
                            <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                array('action' => 'Add', $this->params['pass']['0']),
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
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
                            <?php
                                echo $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                    'javascript:submitDeleteForm("suppliers/deletesuppliers/");',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                        'disabled' => 'true'),
                                    __('Are you sure you want to delete selected thirds ?'));

                            ?>

                            <?php if ($this->params['pass']['0'] == 1) { ?>
                                <div class="btn-group buttonradi">

                                    <button type="button" id="export_allmark"

                                            class="btn btn-inverse btn-bordred waves-effect w-md waves-light m-b-5"
                                            data-toggle="dropdown">
                                        <i class="glyphicon glyphicon-download-alt m-r-5"></i>
                                        <?= __('Import') . ' ' . __('clients');

                                        ?>

                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu imp" role="menu">
                                        <li>
                                            <div class="timeline-body">
                                                <?php echo $this->Html->link(__('Download file model'), '/attachments/import_xls/clients.csv', array('class' => 'titre')); ?>
                                                <br/>

                                                <form id='CustomerImportForm' action='../import' method='post'
                                                      enctype='multipart/form-data' novalidate='novalidate'>
                                                    <?php
                                                    echo "<div class='form-group'>" . $this->Form->input('Supplier.file_csv', array(
                                                            'label' => __('File .csv'),
                                                            'class' => '',
                                                            'type' => 'file',
                                                            'id' => 'file_customers',
                                                            'placeholder' => __('Choose file .csv'),
                                                            'empty' => ''
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

                                <div class="btn-group buttonradi">

                                    <button type="button" id="export_allmark"

                                            class="btn btn-inverse btn-bordred waves-effect w-md waves-light m-b-5"
                                            data-toggle="dropdown">
                                        <i class="glyphicon glyphicon-download-alt m-r-5"></i>
                                        <?= __('Import') . ' ' . __('addresses');

                                        ?>

                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu imp" role="menu">
                                        <li>
                                            <div class="timeline-body">
                                                <?php echo $this->Html->link(__('Download file model'), '/attachments/import_xls/client_adresses.csv', array('class' => 'titre')); ?>
                                                <br/>

                                                <form id='CustomerImportForm' action='../importAddresses' method='post'
                                                      enctype='multipart/form-data' novalidate='novalidate'>
                                                    <?php
                                                    echo "<div class='form-group'>" . $this->Form->input('Supplier.file_address_csv', array(
                                                            'label' => __('File .csv'),
                                                            'class' => '',
                                                            'type' => 'file',
                                                            'id' => 'file_customers',
                                                            'placeholder' => __('Choose file .csv'),
                                                            'empty' => ''
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

                                <div class="btn-group buttonradi">

                                    <button type="button" id="export_allmark"

                                            class="btn btn-inverse btn-bordred waves-effect w-md waves-light m-b-5"
                                            data-toggle="dropdown">
                                        <i class="glyphicon glyphicon-download-alt m-r-5"></i>
                                        <?= __('Import') . ' ' . __('contacts');

                                        ?>

                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu imp" role="menu">
                                        <li>
                                            <div class="timeline-body">
                                                <?php echo $this->Html->link(__('Download file model'), '/attachments/import_xls/client_contacts.csv', array('class' => 'titre')); ?>
                                                <br/>

                                                <form id='CustomerImportForm' action='../importContacts' method='post'
                                                      enctype='multipart/form-data' novalidate='novalidate'>
                                                    <?php
                                                    echo "<div class='form-group'>" . $this->Form->input('Supplier.file_contact_csv', array(
                                                            'label' => __('File .csv'),
                                                            'class' => '',
                                                            'type' => 'file',
                                                            'id' => 'file_customers',
                                                            'placeholder' => __('Choose file .csv'),
                                                            'empty' =>''
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


                            <?php } ?>

                            <div id="dialogModalMerge">
                                <!-- the external content is loaded inside this tag -->

                            </div>

                            <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Merge'),
                                'javascript:mergeSuppliers();',
                                array('escape' => false, 'id' => 'merge', 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true')) ?>


                        </div>
                    </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                </div>
            </div>
        </div>
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

    <?= $this->Form->input('action', array(
        'id' => 'typePiece',
        'value' => $this->params['pass']['0'],
        'type' => 'hidden'
    )); ?>


    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <?php echo $this->Form->create('Suppliers', array(
                    'url' => array(
                        'action' => 'search'
                    ),
                    'novalidate' => true,
                    'id' => 'searchKeyword'
                )); ?>
                <label style="float: right;">
                    <input id='keyword' type="text" name="keyword" id="keyword" class="form-control"
                           placeholder= <?= __("Search"); ?>>
                    <?php
                    echo $this->Form->input('type', array(
                        'label' => __('Type'),
                        'class' => 'form-filter',
                        'id' => 'type',
                        'type' => 'hidden',
                        'value' => $this->params['pass']['0'],
                        'empty' => ''
                    ));
                    ?>
                </label>
                <?php echo $this->Form->end(); ?>
                <div class="col-sm-6">
                    <div class="dataTables_length m-r-15" id="datatable-editable_length" style="display: inline-block;">
                        <label>&nbsp; <?= __('Order : ') ?>
                            <?php
                            if (isset($this->params['pass']['2'])) $order = $this->params['pass']['2'];
                            ?>
                            <select aria-controls="datatable-editable" class="form-control input-sm" name="selectOrder"
                                    id="selectOrder"
                                    onchange="selectOrderChanged('suppliers/index/<?php echo $type ?>','DESC');">
                                <option value=""></option>
                                <option
                                    value="1" <?php if ($order == 1) echo 'selected="selected"' ?>> <?= __('Code') ?></option>
                                <option
                                    value="2" <?php if ($order == 2) echo 'selected="selected"' ?>><?= __('Id') ?></option>
                                <option
                                    value="3" <?php if ($order == 3) echo 'selected="selected"' ?>><?= __('Name') ?></option>

                            </select>
                        </label>
                        <span id="asc_desc" >
                        <i class="fa fa-sort-asc" id="asc" onclick="selectOrderChanged('suppliers/index/<?php echo $type ?>', 'ASC');"></i>
                        <i class="fa fa-sort-desc" id="desc" onclick="selectOrderChanged('suppliers/index/<?php echo $type ?>','DESC');"></i>
                        </span>
                    </div>

                    <div class="dataTables_length" id="datatable-editable_length" style="display: inline-block;">
                        <label>
                            <?php
                            if (isset($this->params['pass']['1'])) $limit = $this->params['pass']['1'];
                            ?>
                            <select aria-controls="datatable-editable" class="form-control input-sm" name="slctlimit"
                                    id="slctlimit" onchange="slctlimitChanged('suppliers/index/<?php echo $type ?>');">
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
                        <th><?php echo $this->Paginator->sort('code', __('Code')); ?></th>
                        <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
                        <th><?php echo $this->Paginator->sort('adress', __('Address')); ?></th>
                        <th><?php echo $this->Paginator->sort('SupplierCategory.name', __('Category')); ?></th>
                        <?php
                        if ($profileId != ProfilesEnum::client) { ?>
                        <th><?php echo $this->Paginator->sort('Supplier.balance', __('Balance')); ?></th>
                        <?php } ?>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    </thead>


                    <tbody id="listeDiv">
                    <?php 
		    foreach ($suppliers as $supplier): ?>
                        <tr id="row<?= $supplier['Supplier']['id'] ?>"

                            >
                            <td  <?php if ($supplier['Supplier']['type'] == 1) { ?>
                                onclick='viewFinalSuppliers(<?php echo $supplier['Supplier']['id'] ?>)'
                            <?php } ?>>

                                <input id="idCheck" type="checkbox" class='id'
                                       value=<?php echo $supplier['Supplier']['id'] ?>>
                            </td>
                            <td     <?php if ($supplier['Supplier']['type'] == 1) { ?>
                                onclick='viewFinalSuppliers(<?php echo $supplier['Supplier']['id'] ?>)'
                            <?php } ?>><?php echo h($supplier['Supplier']['code']); ?>&nbsp;</td>
                            <td     <?php if ($supplier['Supplier']['type'] == 1) { ?>
                                onclick='viewFinalSuppliers(<?php echo $supplier['Supplier']['id'] ?>)'
                            <?php } ?>><?php echo h($supplier['Supplier']['name']); ?>&nbsp;</td>
                            <td     <?php if ($supplier['Supplier']['type'] == 1) { ?>
                                onclick='viewFinalSuppliers(<?php echo $supplier['Supplier']['id'] ?>)'
                            <?php } ?>><?php echo h($supplier['Supplier']['adress']); ?>&nbsp;</td>
                            <td     <?php if ($supplier['Supplier']['type'] == 1) { ?>
                                onclick='viewFinalSuppliers(<?php echo $supplier['Supplier']['id'] ?>)'
                            <?php } ?>><?php echo h($supplier['SupplierCategory']['name']); ?>&nbsp;</td>
                            <?php
                            if ($profileId != ProfilesEnum::client) { ?>
                            <td     <?php if ($supplier['Supplier']['type'] == 1) { ?>
                                onclick='viewFinalSuppliers(<?php echo $supplier['Supplier']['id'] ?>)'
                            <?php } ?>><?php echo h(number_format($supplier['Supplier']['balance'], 2, ",", $separatorAmount)); ?>
                                &nbsp;</td>
                            <?php } ?>

                            <td class="actions">
                                <div class="btn-group ">
                                    <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                        <i class="fa fa-list fa-inverse"></i>
                                    </a>
                                    <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" style="min-width: 70px;">
                                        <li class='View-link' title="<?= __('View') ?>">
                                            <?= $this->Html->link(
                                                '<i class=" fa fa-eye"></i>',
                                                array('action' => 'View', $supplier['Supplier']['id']),
                                                array('escape' => false, 'class' => 'btn btn-success')
                                            ); ?>
                                        </li>
                                        <li class='edit-link' title="<?= __('Edit') ?>">
                                            <?= $this->Html->link(
                                                '<i class=" fa fa-edit"></i>',
                                                array('action' => 'Edit', $supplier['Supplier']['id'], $supplier['Supplier']['type']),
                                                array('escape' => false, 'class' => 'btn btn-primary')
                                            ); ?>
                                            <?php
                                            if ($supplier['Supplier']['active'] == 1) { ?>
                                                  <li class='edit-link' title="<?= __('Deactivate') ?>">
                                            <?php    echo $this->Html->link(
                                                    '<i class=" fa  fa-check"></i>',
                                                    array('action' => 'inactif', $supplier['Supplier']['id'], $this->params['pass']['0']),
                                                    array('escape' => false, 'class' => 'btn btn-warding')
                                                ); ?>
                                                  </li>
                                            <?php } else { ?>
                                              <li class='edit-link' title="<?= __('Actif') ?>">
                                           <?php     echo $this->Html->link(
                                                    '<i class=" fa  fa-check"></i>',
                                                    array('action' => 'actif', $supplier['Supplier']['id'], $this->params['pass']['0']),
                                                    array('escape' => false, 'class' => 'btn btn-warding')
                                                ); ?>
                                                  <li>
                                         <?php  } ?>
                                        <li class='edit-link' title="<?= $client ? __('Client card') : __('Supplier card') ?>">
                                            <?php  echo $this->Html->link(
                                                '<i class=" fa fa-print m-r-5"></i>',
                                                array('action' => 'supplierCard', $supplier['Supplier']['id'], $this->params['pass']['0']),
                                                array('escape' => false, 'class' => 'btn btn-inverse')); ?>
                                        </li>
                                        <li  class='edit-link' title="<?= __('Delete') ?>">
                                            <?php
                                            echo $this->Form->postLink(
                                                '<i class="fa fa-trash-o"></i>',
                                                array('action' => 'Delete', $supplier['Supplier']['id'], $this->params['pass']['0']),
                                                array('escape' => false, 'class' => 'btn btn-danger'),
                                                __('Are you sure you want to delete %s?', $supplier['Supplier']['name'])); ?>
                                        </li>
                                    </ul>
                                </div>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="pagination" class="pull-right">
                    <?php
                    if ($this->params['paging']['Supplier']['pageCount'] > 1) {
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
                <div id='final-suppliers' name="final-suppliers">

                </div>
                <br>
                <br>

            </div>
        </div>
    </div>
</div>


<?php $this->start('script'); ?>

<script type="text/javascript">
    $(document).ready(function () {
        jQuery("#dialogModalMerge").dialog({
            autoOpen: false,
            height: 300,
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

    function viewFinalSuppliers(id) {
        $("html").css("cursor", "pointer");
        scrollToAnchor('final-suppliers');
        jQuery('tr').removeClass('btn-info  btn-trans');
        jQuery('#row' + id).addClass('btn-info  btn-trans');
        jQuery('#final-suppliers').load('<?php echo $this->Html->url('/suppliers/viewFinalSuppliers/')?>' + id, function () {

        });
    }

    function scrollToAnchor(aid) {
        var aTag = jQuery("div[name='" + aid + "']");
        jQuery('html,body').animate({scrollTop: aTag.offset().top}, 'slow');
    }

    function printSimplifiedJournal() {
        var conditions = new Array();
        conditions[0] = jQuery('#SuppliersSupplierCategoryId').val();
        conditions[1] = jQuery('#SuppliersActive').val();
        conditions[2] = jQuery('#type').val();
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        var type = jQuery("#type").val();
        var url = '<?php echo $this->Html->url(array('action' => 'printSimplifiedJournal', 'ext' => 'pdf'),
         array('target' => '_blank' ))?>';
        var form = jQuery('<form action="' + url + '" method="post" target="_Blank" >' +
        '<input type="hidden" name="printSimplifiedJournal" value="' + conditions + '" />' +
        '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
        '<input type="hidden" name="typePiece" value="' + type + '" />' +
        '</form>');
        jQuery('body').append(form);
        form.submit();
    }

    function mergeSuppliers(){
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        var type = jQuery("#type").val();
        jQuery('#dialogModalMerge').dialog('option', 'title', 'Fusion');
        jQuery('#dialogModalMerge').dialog('open');
        jQuery('#dialogModalMerge').load('<?php echo $this->Html->url('/suppliers/mergeSuppliers/')?>' + myCheckboxes +'/'+type);

    }

</script>
<?php $this->end(); ?>