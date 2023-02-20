
    <h4 class="page-title"> <?=__("Closed missions");?></h4>

<?php

App::import('Model', 'SheetRideDetailRides');
$this->SheetRideDetailRides = new SheetRideDetailRides();
$this->start('css');
//echo $this->Html->css('select2/select2.min');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
$this->end();
?>
<?= $this->Form->input('controller', array(
    'id' => 'controller',
    'value' => $this->request->params['controller'],
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
    $page = null;
}
$uriParts = explode('?', $_SERVER['REQUEST_URI'], 2);
$url = base64_encode(serialize($uriParts[0]));
$controller = $this->request->params['controller'];
?>
<?= $this->Form->input('url', array(
    'id' => 'url',
    'value' => base64_encode(serialize($uriParts[0])),
    'type' => 'hidden'
)); ?>
<div class="panel-group wrap" id="bs-collapse">
    <div class="panel">
        <div class="panel-heading" style="background-color: #435966; color: #fff;">
            <h4 class="panel-title">
                <a class="" data-toggle="collapse" data-parent="#" aria-expanded="true" href="#one">
                    <?php echo __('Search') ?>
                </a>
            </h4>
        </div>
        <div id="one" class="panel-collapse collapse-in collapse in">
            <div class="panel-body">

                <div class="filters" id='filters'>

                    <?php
                    echo $this->Form->create('sheet_ride_detail_rides', array(
                        'url'=> array(
                            'action' => 'closedMissions'
                        ),
                        'novalidate' => true ,
                        'onsubmit'=> 'javascript:disable();'
                    ));
                    echo $this->Form->input('detail_ride_id', array(
                        'label' => __('Ride'),
                        'class' => 'form-filter select2',
                        'id' => 'detail_ride',
                        'empty' => '',
                    ));
                    echo $this->Form->input('supplier_id', array(
                        'label' => __('Client'),
                        'class' => 'form-filter select2',
                        'id' => 'client',
                        'empty' => '',
                        'options' => $suppliers,
                    ));
                    echo $this->Form->input('supplier', array(
                        'type' => 'hidden',
                        'id' => 'supplier',
                        'value' => $supplier
                    ));

                    echo "<div style='clear:both; padding-top: 10px;'></div>";
                    echo $this->Form->input('subcontractor_id', array(
                        'label' => __('Subcontractor'),
                        'class' => 'form-filter select2',
                        'id' => 'subcontractor',
                        'empty' => '',
                        'options' => $subcontractors,
                    ));
                    $options = array('1'=>__('Order with invoice'), '2'=>__('Order payment cash'));
                    echo $this->Form->input('order_type', array(
                        'label' => __('Order type'),
                        'class' => 'form-filter select2',
                        'id' => 'order_type',
                        'options'=>$options,
                        'empty' => ''
                    ));


                    echo "<div style='clear:both; padding-top: 10px;'></div>";
                    ?>
                    <button class="btn btn-default" type="submit"><?= __('Search') ?></button>
                    <div style='clear:both; padding-top: 10px;'></div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>

        </div>
    </div>
    <!-- end of panel -->


</div>
<div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
        <div class="card-box p-b-0">
            <div class="row" style="clear:both">

                <div class="btn-group pull-left">

                    <div class="header_actions">
                        <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Generate dispatch slip'),
                            'javascript:generateDispatchSlip();',
                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>


                    </div>
                </div>

                <div style='clear:both; padding-top: 10px;'></div>

            </div>
            <div id="dialogModalClient">
                <!-- the external content is loaded inside this tag -->

            </div>
        </div>
    </div>
</div>
<div class="box-body">

    <?php

    echo $this->Form->input('conditions', array(
        'class' => 'form-filter',
        'id' => 'conditions',
        'type' => 'hidden',
        'value' => base64_encode(serialize($conditions)),
        'empty' => ''
    ));
    echo $this->Form->input('all_ids', array(
        'id' => 'all_ids',
        'type' => 'hidden',
        'value' => '',
        'empty' => ''
    ));
    ?>
    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
           cellspacing="0" width="100%">
        <thead>
        <tr>
            <th style="width: 10px">
                <button type="button" id='checkbox' class="btn btn-default btn-sm checkbox-toggle"><i
                            class="fa fa-square-o"></i></button>
            </th>
            <th><?php echo $this->Paginator->sort('SheetRideDetailRides.real_start_date', __('Date')); ?></th>
            <th><?php echo $this->Paginator->sort('Car.code', __('Car')); ?></th>
            <th><?php echo $this->Paginator->sort('Customer.first_name', __("Customer")); ?></th>
            <th><?php echo $this->Paginator->sort('DepartureDestination.name', __('Ride')); ?></th>
            <th><?php echo $this->Paginator->sort('Subcontractor.name', __('Subcontractor')); ?></th>
            <th><?php echo $this->Paginator->sort('Supplier.name', __('Initial customer')); ?></th>
            <th><?php echo $this->Paginator->sort('SheetRideDetailRides.final_customer', __('Final customer')); ?></th>
            <th><?php echo $this->Paginator->sort('SheetRideDetailRides.number_delivery_note', __('N° BL')); ?></th>
            <th><?php echo $this->Paginator->sort('SheetRideDetailRides.number_invoice', __('N°').' '.__('invoice')); ?></th>
            <th><?php echo $this->Paginator->sort('SheetRideDetailRides.note', __('Observation')); ?></th>
        </tr>
        </thead>
        <tbody id="listeDiv">
        <?php foreach ($closedMissions as $mission): ?>
            <tr id="row<?= $mission['SheetRideDetailRides']['id'] ?>">
                <td>
                    <input id="idCheck" type="checkbox" class='id' value=<?php echo $mission['SheetRideDetailRides']['id'] ?>>
                </td>
                <td><?php
                    if(!empty($mission['SheetRideDetailRides']['real_start_date'])){
                          echo h($this->Time->format($mission['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y %H:%M'));
                    }else {
                        echo h($this->Time->format($mission['SheetRideDetailRides']['planned_start_date'], '%d-%m-%Y %H:%M'));
                    } ?>&nbsp;</td>
                <?php if ($mission['SheetRide']['car_subcontracting'] == 2) {
                    if($param == 1){ ?>
                <td><?php echo $mission['Car']['code'] .' - '.$mission['Carmodel']['name'] ?></td>
                 <?php } else { ?>
                 <td><?php echo $mission['Car']['immatr_def'] .' - '.$mission['Carmodel']['name'] ?></td>
                    <?php }
                } else { ?>
                <td><?php echo $mission['SheetRide']['car_name']; ?></td>
                <?php  } ?>
                 <?php if ($mission['SheetRide']['car_subcontracting'] == 2) { ?>
                <td><?php echo $mission ['Customer']['first_name'] .' - '.$mission ['Customer']['last_name'] ?> </td>
                 <?php } else { ?>
                <td><?php echo $mission['SheetRide']['customer_name'] ?> </td>
                <?php } ?>
                <?php if ($mission['SheetRideDetailRides']['type_ride'] == 1) { ?>
                <td><?php echo $mission['DepartureDestination']['name'] . ' - ' . $mission['ArrivalDestination']['name']?> </td>
                 <?php } else { ?>
                <td><?php echo $mission['Departure']['name'] . ' - ' . $mission['Arrival']['name']?> </td>
                 <?php } ?>
                <td><?php echo $mission['Subcontractor']['name']?></td>
                <td><?php echo $mission['Supplier']['name']?></td>
                <td><?php
                    if(empty($mission['SheetRideDetailRides']['final_customer'])
                    ){ ?>
                        <div class="table-content editable">
                                        <span>
                                        </span>
                                        <input
                                            name="<?= $this->SheetRideDetailRides->encrypt("final_customer|" . $mission['SheetRideDetailRides']['id']); ?>"
                                            placeholder="<?= __('Enter final customer') ?>"
                                            value="<?= $mission['SheetRideDetailRides']['final_customer'] ?>"
                                            class="form-control table-input1" type="text" id="final_customer_<?= $mission['SheetRideDetailRides']['id'] ?>">
                                    </div>
                    <?php } else {
                       echo  $mission['SheetRideDetailRides']['final_customer'];
                    }
                    ?></td>

                <td><?php
                    if(empty($mission['SheetRideDetailRides']['number_delivery_note'])
                    ){ ?>
                        <div class="table-content editable">
                                        <span>
                                        </span>
                            <input
                                    name="<?= $this->SheetRideDetailRides->encrypt("number_delivery_note|" . $mission['SheetRideDetailRides']['id']); ?>"
                                    placeholder="<?= __('Enter number delivery note') ?>"
                                    value="<?= $mission['SheetRideDetailRides']['number_delivery_note'] ?>"
                                    class="form-control table-input2" type="text" id="number_delivery_note<?= $mission['SheetRideDetailRides']['id'] ?>">
                        </div>
                    <?php } else {
                        echo  $mission['SheetRideDetailRides']['number_delivery_note'];
                    }
                    ?></td>
                <td><?php
                    if(empty($mission['SheetRideDetailRides']['number_invoice'])
                    ){ ?>
                        <div class="table-content editable">
                                        <span>
                                        </span>
                            <input
                                    name="<?= $this->SheetRideDetailRides->encrypt("number_invoice|" . $mission['SheetRideDetailRides']['id']); ?>"
                                    placeholder="<?= __('Enter number invoice') ?>"
                                    value="<?= $mission['SheetRideDetailRides']['number_invoice'] ?>"
                                    class="form-control table-input3" type="text" id="number_invoice<?= $mission['SheetRideDetailRides']['id'] ?>">
                        </div>
                    <?php } else {
                        echo  $mission['SheetRideDetailRides']['number_invoice'];
                    }
                    ?></td>
                <td><?php
                    if(empty($mission['SheetRideDetailRides']['note'])
                    ){ ?>
                        <div class="table-content editable">
                                        <span>
                                        </span>
                            <input
                                    name="<?= $this->SheetRideDetailRides->encrypt("note|" . $mission['SheetRideDetailRides']['id']); ?>"
                                    placeholder="<?= __('Enter note') ?>"
                                    value="<?= $mission['SheetRideDetailRides']['note'] ?>"
                                    class="form-control table-input4" type="text" id="note<?= $mission['SheetRideDetailRides']['id'] ?>">
                        </div>
                    <?php } else {
                        echo  $mission['SheetRideDetailRides']['note'];
                    }

                    ?></td>



            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div id="pagination" class="pull-right">
        <?php if ($this->params['paging']['SheetRideDetailRides']['pageCount'] > 1) { ?>
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


    <?php $this->start('script'); ?>
    <?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
    <?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
    <?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
    <?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>

    <script type="text/javascript">
        $(document).ready(function() {
            jQuery("#date_to").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery("#date_from").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery('input.checkall').on('ifClicked', function (event) {
                var cases = jQuery(":checkbox.id");
                if (jQuery('#checkall').prop('checked')) {
                    cases.iCheck('uncheck');
                    jQuery("#add_prefacture").attr("disabled", "true");
                } else
                {
                    cases.iCheck('check');
                    jQuery("#add_prefacture").removeAttr("disabled");
                }
            });
            jQuery('input.id').on('ifUnchecked', function (event) {
                var ischecked = false;
                jQuery(":checkbox.id").each(function () {
                    if (jQuery(this).prop('checked'))
                        ischecked = true;
                });
                if (!ischecked) {
                    jQuery("#add_prefacture").attr("disabled", "true");
                }
            });
            jQuery('input.id').on('ifChecked', function (event) {
                jQuery("#add_prefacture").removeAttr("disabled");
            });
            jQuery("#dialogModalClient").dialog({
                autoOpen: false,
                height: 550,
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
            $('body').delegate('.table-input1', 'change', function () {
                var ThisElement = $(this);
                ThisElement.find('.table-input1').show();
                var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo $this->Html->url('/sheetRideDetailRides/updateFinalCustomer/')?>",
                    data: UrlToPass,
                    dataType: "json",
                    success: function (json) {
                        if (json.response == true) {
                            ThisElement.find('.table-input1').show();

                            var idInput = ThisElement.attr('id');
                            $("#"+idInput).attr('readonly', false);
                            $("#"+idInput).blur();
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
                    url: "<?php echo $this->Html->url('/sheetRideDetailRides/updateNumberDeliveryNote/')?>",
                    data: UrlToPass,
                    dataType: "json",
                    success: function (json) {
                        if (json.response == true) {
                            ThisElement.find('.table-input2').show();
                            var idInput = ThisElement.attr('id');
                            $("#"+idInput).attr('readonly', false);
                            $("#"+idInput).blur();
                        }else {
                            $("#msg").html("<div id='flashMessage' class='message'><div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><?php echo __('You don\'t have permission to edit.'); ?></div></div>");
                            scrollToAnchor('container-fluid');
                        }
                    }
                });
            });
            $('body').delegate('.table-input3', 'change', function () {
                var ThisElement = $(this);
                ThisElement.find('.table-input3').show();
                var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo $this->Html->url('/sheetRideDetailRides/updateNumberInvoice/')?>",
                    data: UrlToPass,
                    dataType: "json",
                    success: function (json) {
                        if (json.response == true) {
                            ThisElement.find('.table-input3').show();
                            var idInput = ThisElement.attr('id');
                            $("#"+idInput).attr('readonly', false);
                            $("#"+idInput).blur();
                        }else {
                            $("#msg").html("<div id='flashMessage' class='message'><div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><?php echo __('You don\'t have permission to edit.'); ?></div></div>");
                            scrollToAnchor('container-fluid');
                        }
                    }
                });
            });
            $('body').delegate('.table-input4', 'change', function () {
                var ThisElement = $(this);
                ThisElement.find('.table-input4').show();
                var UrlToPass = 'id=update&value=' + ThisElement.val() + '&crypto=' + ThisElement.prop('name');
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo $this->Html->url('/sheetRideDetailRides/updateNote/')?>",
                    data: UrlToPass,
                    dataType: "json",
                    success: function (json) {
                        if (json.response == true) {
                            ThisElement.find('.table-input4').show();
                            var idInput = ThisElement.attr('id');
                            $("#"+idInput).attr('readonly', false);
                            $("#"+idInput).blur();
                        }else {
                            $("#msg").html("<div id='flashMessage' class='message'><div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><?php echo __('You don\'t have permission to edit.'); ?></div></div>");
                            scrollToAnchor('container-fluid');
                        }
                    }
                });
            });
        });

        function printDispatchSlip() {
            var conditions = new Array();
            conditions[0] = jQuery('#detail_ride').val();
            conditions[1] = jQuery('#client').val();
            conditions[2] = jQuery('#subcontractor').val();
            conditions[3] = jQuery('#order_type').val();
            if(jQuery('#client').val().length==0){
                alert("<?php echo __('Select customer, please.') ?>");
            } else {
                var myCheckboxes = new Array();
                jQuery('.id:checked').each(function () {
                    myCheckboxes.push(jQuery(this).val());
                });
                var url = '<?php echo $this->Html->url(array('action' => 'printDispatchSlip', 'ext' => 'pdf'),
                    array('target' => '_blank'))?>';
                var form = jQuery('<form action="' + url + '" method="post" target="_Blank" >' +
                    '<input type="hidden" name="printDispatchSlip" value="' + conditions + '" />' +
                    '<input type="hidden" name="chkids" value="' + myCheckboxes + '" />' +
                    '</form>');
                jQuery('body').append(form);
                form.submit();
            }
        }

        function generateDispatchSlip() {

            if(jQuery('#supplier').val().length==0){
                alert("<?php echo __('Select customer, please.') ?>");
            }else {
                var myCheckboxes = new Array();
                jQuery('.id:checked').each(function () {
                    myCheckboxes.push(jQuery(this).val());
                });
                var supplierId = jQuery('#supplier').val();

                if(myCheckboxes.length>0) {
                    var url = '<?php echo $this->Html->url('/slips/generateDispatchSlip')?>';
                    var form = jQuery('<form action="' + url + '" method="post">' +
                        '<input type="text" name="chkids" value="' + myCheckboxes + '" />' +
                        '<input type="text" name="supplier_id" value="' + supplierId + '" />' +
                        '</form>');
                    jQuery('body').append(form);
                    form.submit();
                }
            }
        }

    </script>
    <?php $this->end(); ?>
</div>


