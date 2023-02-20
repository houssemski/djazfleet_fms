<h4 class="page-title"> <?= __('Products'); ?></h4>
<?php
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end();

?>
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
                    <?php echo $this->Form->create('Products', array(
                        'url' => array(
                            'action' => 'search'
                        ),
                        'novalidate' => true
                    )); ?>
                    <div class="filters" id='filters'>
                        <?php
                            echo $this->Form->input('product_family_id', array(
                                'label' => __('Family'),
                                'id' => 'family',
                                'class' => 'form-filter select2',
                                'empty' => ''
                            ));
                            echo $this->Form->input('product_category_id', array(
                                'label' => __('Category'),
                                'class' => 'form-filter select2',
                                'id' => 'category',
                                'empty' => ''
                            ));
                            echo "<div style='clear:both; padding-top: 10px;'></div>";
                            echo $this->Form->input('product_mark_id', array(
                                'label' => __('Mark'),
                                'id' => 'mark',
                                'class' => 'form-filter select2',
                                'empty' => ''
                            ));

                        echo "<div style='clear:both; padding-top: 10px;'></div>";
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
                                    'class' => 'form-filter select2',
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
                                array('action' => 'Add'),
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                            <div class="btn-group">
                                <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Export'),
                                    'javascript:exportData("products/export/");',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect w-md waves-light m-b-5', 'id' => 'export', 'disabled' => 'true')) ?>
                                <button type="button" id="export_allmark"
                                        class="btn dropdown-toggle btn-inverse  btn-bordred" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <?= $this->Html->link(__('Export All'), 'javascript:exportAllData("products/export/all");') ?>
                                    </li>
                                </ul>

                            </div>
                            <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                'javascript:submitDeleteForm("products/deleteproducts/");',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                    'disabled' => 'true'),
                                __('Are you sure you want to delete selected products ?')); ?>

                            <div id="dialogModalMerge">
                                <!-- the external content is loaded inside this tag -->

                            </div>

                            <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Merge'),
                                'javascript:mergeProducts();',
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

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <?php echo $this->Form->create('Products', array(
                    'url' => array(
                        'action' => 'search'
                    ),
                    'novalidate' => true,
                    'id' => 'searchKeyword'
                )); ?>
                <label style="float: right;">
                    <input id='keyword' type="text" name="keyword" class="form-control"
                           placeholder= <?= __("Search"); ?>>


                </label>
                <?php echo $this->Form->end(); ?>
                <div class="bloc-limit btn-group pull-left">
                    <div>
                        <label>
                            <?php
                            if (isset($this->params['pass']['0'])) $limit = $this->params['pass']['0'];
                            ?>
                            <select name="slctlimit" id="slctlimit" onchange="slctlimitChanged('products/index');">
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

                        <th><?php echo $this->Paginator->sort('code', __('Code')); ?></th>
                        <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
                        <th><?php echo $this->Paginator->sort('product_family_id', __('Family')); ?></th>
                        <th><?php echo $this->Paginator->sort('tva_id', __('TVA')); ?></th>
                        <th><?php echo $this->Paginator->sort('quantity', __('Quantity')); ?></th>
                        <th><?php echo $this->Paginator->sort('quantity_min', __('Quantity min')); ?></th>
                        <th><?php echo $this->Paginator->sort('quantity_max', __('Quantity max')); ?></th>
                        <th><?php echo $this->Paginator->sort('pmp', __('PMP')); ?></th>

                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    </thead>

                    <tbody id="listeDiv">
                    <?php foreach ($products as $product):

                        ?>

                        <tr id="row<?= $product['Product']['id'] ?>">
                            <td>

                                <input id="idCheck" type="checkbox" class='id'
                                       value=<?php echo $product['Product']['id'] ?>>
                            </td>

                            <td><?php echo h($product['Product']['code']); ?>&nbsp;</td>
                            <td><?php echo h($product['Product']['name']); ?>&nbsp;</td>
                            <td><?php echo h($product['ProductFamily']['name']); ?>&nbsp;</td>
                            <td><?php echo h($product['Tva']['name']); ?>&nbsp;</td>
                            <td><?php echo h($product['Product']['quantity']); ?>&nbsp;</td>
                            <td><?php echo h($product['Product']['quantity_min']); ?>&nbsp;</td>
                            <td><?php echo h($product['Product']['quantity_max']); ?>&nbsp;</td>
                            <td><?php echo h($product['Product']['pmp']); ?>&nbsp;</td>

                            <td class="actions">
                                <div class="btn-group ">
                                    <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                                        <i class="fa fa-list fa-inverse"></i>
                                    </a>
                                    <button href="#" data-toggle="dropdown" class="btn btn-info btn-custom-2 dropdown-toggle share">
                                        <span class="caret"></span>
                                    </button>

                                    <ul class="dropdown-menu" style="min-width: 70px;">

                                        <li>
                                            <?= $this->Html->link(
                                                '<i   class="fa fa-eye" title="' . __('View') . '"></i>',
                                                array('action' => 'View', $product['Product']['id']),
                                                array('escape' => false, 'class' => 'btn btn-success')
                                            ); ?>
                                        </li>

                                        <li>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                array('action' => 'Edit', $product['Product']['id']),
                                                array('escape' => false, 'class' => 'btn btn-primary')
                                            ); ?>
                                        </li>
                                        <li class='edit-link' title="<?= __('Product card') ?>">
                                            <?php  echo $this->Html->link(
                                                '<i class=" fa fa-print m-r-5"></i>',
                                                array('action' => 'productCard', $product['Product']['id']),
                                                array('escape' => false, 'class' => 'btn btn-inverse')); ?>
                                        </li>

                                        <li>
                                            <?php
                                            echo $this->Form->postLink(
                                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                array('action' => 'delete', $product['Product']['id']),
                                                array('escape' => false, 'class' => 'btn btn-danger'),
                                                __('Are you sure you want to delete %s?', $product['Product']['name'])); ?>
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
                    if ($this->params['paging']['Product']['pageCount'] > 1) {
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

<script type="text/javascript">

    $(document).ready(function () {

        jQuery('#link_search_advanced').click(function () {
            if (jQuery('#filters').is(':visible')) {
                jQuery('#filters').slideUp("slow", function () {
                });
            } else {
                jQuery('#filters').slideDown("slow", function () {
                });
            }
        });

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


    function exportData() {
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        var url = '<?php echo $this->Html->url('/products/export/')?>';
        var form = jQuery('<form action="' + url + '" method="post">' +
        '<input type="text" name="chkids" value="' + myCheckboxes + '" />' +
        '</form>');
        jQuery('body').append(form);
        form.submit();
    }

    function mergeProducts(){
        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());
        });
        jQuery('#dialogModalMerge').dialog('option', 'title', 'Fusion');
        jQuery('#dialogModalMerge').dialog('open');
        jQuery('#dialogModalMerge').load('<?php echo $this->Html->url('/products/mergeProducts/')?>' + myCheckboxes);

    }


</script>
<?php $this->end(); ?>
