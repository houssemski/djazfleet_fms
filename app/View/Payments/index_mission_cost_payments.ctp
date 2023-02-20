<?php

include("ctp/script.ctp");
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->Html->css('select2/select2.min');
$this->end();

?><h4 class="page-title"> <?= __('Mission cost payments'); ?></h4>

<?php
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end();
?>
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

                    <?php echo $this->Form->create('Payments', array(
                        'url' => array(
                            'action' => 'search'
                        ),
                        'novalidate' => true
                    )); ?>

                    <div class="filters" id='filters'>

                        <?php


                        echo $this->Form->input('customer_id', array(
                            'label' => __('Conductor'),
                            'class' => 'form-filter select2',
                            'id' => 'customer',
                            'empty' => ''
                        ));

                        echo $this->Form->input('compte_id', array(
                            'label' => __('Compte'),
                            'class' => 'form-filter select2',
                            'id' => 'compte',
                            'empty' => ''
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        $options = array('1' => __('Species'), '2' => __('Transfer'), '3' => __('Bank check'));
                        echo $this->Form->input('payment_type', array(
                            'label' => __('Payment type'),
                            'class' => 'form-filter select2',
                            'options' => $options,
                            'id' => 'payment_type',
                            'empty' => ''
                        ));

                        echo $this->Form->input('amount', array(
                            'label' => __('Amount'),
                            'class' => 'form-filter',
                            'id' => 'amount',
                            'type' => 'number',

                            'empty' => ''
                        ));

                        echo "<div style='clear:both; padding-top: 10px;'></div>";

                        echo $this->Form->input('date1', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Date de') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'date1',
                        ));
                        echo $this->Form->input('date2', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'date2',
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
    <!-- end of #bs-collapse  -->


    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
                            <?php


                            echo $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Add'),
                                array('action' => 'searchMissionCosts'),
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5'));




                            ?>

                            <div id="dialogModalPayments">
                                <!-- the external content is loaded inside this tag -->

                            </div>


                            <?= $this->Html->link('<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __('Delete'),
                                'javascript:submitDeleteForm("payments/deleteMissionCostPayments/");',
                                array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'delete',
                                    'disabled' => 'true'),
                                __('Are you sure you want to delete selected payments ?')); ?>


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
                <?php echo $this->Form->create('Payments', array(
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
                <div class="bloc-limit btn-group pull-left">
                    <div>
                        <label>
                            <?php
                            if (isset($this->params['pass']['1'])) $limit = $this->params['pass']['1'];
                            ?>
                            <select name="slctlimit" id="slctlimit"
                                    onchange="slctlimitChanged('transportBills/index/<?php echo $type ?>');">
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

                        <th><?php echo $this->Paginator->sort('wording', __('Wording')); ?></th>
                        <th><?php echo $this->Paginator->sort('receipt_date', __('Date')); ?></th>
                        <th><?php echo $this->Paginator->sort('payment_type', __('Payment type')); ?></th>
                        <th><?php echo $this->Paginator->sort('Customer.first_name', __('Conductor')); ?></th>
                        <th><?php echo $this->Paginator->sort('amount', __('Amount')); ?></th>

                        <th><?php echo $this->Paginator->sort('num_compte', __('Compte')); ?></th>

                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($payments as $payment): ?>
                        <tr id="row<?= $payment['Payment']['id'] ?>">
                            <td>
                                <input id="idCheck" type="checkbox" class='id'
                                       value=<?php echo $payment['Payment']['id'] ?>>

                            </td>

                            <td><?php echo h($payment['Payment']['wording']); ?>&nbsp;</td>
                            <td><?php echo h($this->Time->format($payment['Payment']['receipt_date'], '%d-%m-%Y')); ?>
                                &nbsp;</td>
                            <td><?php switch ($payment['Payment']['payment_type']) {
                                    case 1:
                                        echo __('Species');
                                        break;
                                    case 2:
                                        echo __('Transfer');
                                        break;
                                    case 3:
                                        echo __('Bank check');
                                        break;

                                } ?>&nbsp;</td>
                            <td><?php echo h($payment['Customer']['first_name'] . ' ' . $payment['Customer']['last_name']); ?>
                                &nbsp;</td>
                            <td><?php echo number_format($payment['Payment']['amount'], 2, ",", $separatorAmount) . ' ' . $this->Session->read("currency"); ?>
                                &nbsp;</td>

                            <td><?php echo h($payment['Compte']['num_compte']); ?>&nbsp;</td>


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
                                                array('action' => 'viewPaymentMissionCosts', $payment['Payment']['id']),
                                                array('escape' => false, 'class' => 'btn btn-success')
                                            ); ?>
                                        </li>

                                        <li>
                                            <?php $paymentAssociationId = 3; ?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-edit " title="' . __('Edit') . '"></i>',
                                                'javascript:editPayment(' . $payment['Payment']['id'] . ',' . $paymentAssociationId . ');',
                                                array('escape' => false, 'class' => 'btn btn-primary')
                                            ); ?>
                                        </li>

                                        <li>
                                            <?php
                                            echo $this->Form->postLink(
                                                '<i class="fa fa-trash-o " title="' . __('Delete') . '"></i>',
                                                array('action' => 'deleteMissionCostPayment', $payment['Payment']['id']),
                                                array('escape' => false, 'class' => 'btn btn-danger'),
                                                __('Are you sure you want to delete %s?', $payment['Payment']['wording'])); ?>
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
                    if ($this->params['paging']['Payment']['pageCount'] > 1) {
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
<div class="card-box">
    <ul class="list-group m-b-15 user-list">
        <?php

        echo "<div class='total'><span class='col-lg-3 col-xs-6'><b>" . __('Payments sum : ') . '</b><span class="badge bg-red">' .
            number_format($sumPayments, 2, ",", ".") . " " . $this->Session->read("currency") . "</span> </span>";
        ?>
    </ul>
</div>


<?php $this->start('script'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
<?= $this->Html->script('plugins/datetimepicker/moment-with-locales.min.js'); ?>
<?= $this->Html->script('plugins/datetimepicker/bootstrap-datetimepicker.min.js'); ?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
<script type="text/javascript">


    $(document).ready(function () {

        jQuery("#date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#date2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

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


    });


    function deleteData() {
        link = '<?php echo $this->Html->url('/payments/deleteMissionCostPayments/')?>';


        var myCheckboxes = new Array();
        jQuery('.id:checked').each(function () {
            myCheckboxes.push(jQuery(this).val());

        });


        jQuery.ajax({
            type: "POST",
            url: link,
            data: "ids=" + myCheckboxes,
            dataType: "json",
            success: function (json) {
                if (json.response === "true") {

                    jQuery('#row' + id).remove();
                }
            }
        });


    }


</script>
<?php $this->end(); ?>
