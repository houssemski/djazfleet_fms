<?php if($type == TransportBillTypesEnum::invoice ) { ?>
    <h4 class="page-title"> <?=__("Add invoice");?></h4>
<?php } else { ?>
   <h4 class="page-title"> <?=__("Add preinvoice");?></h4>
<?php } ?>
<?php

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
<?= $this->Form->input('action', array(
    'id' => 'action',
    'value' => 'listeAddFromSheet',
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
                <a class="collapsed" data-toggle="collapse" data-parent="#" href="#one">
                    <?php echo __('Search') ?>
                </a>
            </h4>
        </div>
        <div id="one" class="panel-collapse collapse">
            <div class="panel-body">

                <div class="filters" id='filters'>

                    <?php
                    echo $this->Form->create('transportBills', array(
                        'url'=> array(
                            'action' => 'addFromSheetRide',
                            $type
                        ),
                        'novalidate' => true ,
                        'onsubmit'=> 'javascript:disable();'
                    ));
                    echo $this->Form->input('detail_ride_id', array(
                        'label' => __('Ride'),
                        'class' => 'form-filter select-search-detail-ride',
                        'id' => 'detail_ride',
                        'empty' => ''
                    ));
                    echo $this->Form->input('supplier_id', array(
                        'label' => __('Client'),
                        'class' => 'form-filter select-search-client-initial',
                        'id' => 'client',
                        'empty' => ''
                    ));
                    echo $this->Form->input('service_id', array(
                        'label' => __('Service'),
                        'class' => 'form-filter select2',
                        'id' => 'service',
                        'empty' => ''
                    ));
                    echo "<div style='clear:both; padding-top: 10px;'></div>";
                    echo $this->Form->input('subcontractor_id', array(
                        'label' => __('Subcontractor'),
                        'class' => 'form-filter select-search-subcontractor',
                        'id' => 'subcontractor',
                        'empty' => ''
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
                    echo $this->Form->input('date_from_mission', array(
                        'label' => '',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'before' => '<label class="dte">'.__('Mission date').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'date_from',
                    ));

                    echo $this->Form->input('date_to_mission', array(
                        'label' => '',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'before' => '<label class="dte">'.__('To').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'date_to',
                    ));
                    echo "<div style='clear:both; padding-top: 10px;'></div>";
                    echo $this->Form->input('date_from_sheet', array(
                        'label' => '',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'before' => '<label class="dte">'.__('SheetRide date').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'date_from',
                    ));

                    echo $this->Form->input('date_to_sheet', array(
                        'label' => '',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'before' => '<label class="dte">'.__('To').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'date_to',
                    ));
                    echo "<div style='clear:both; padding-top: 10px;'></div>";
                    echo $this->Form->input('date_from_order', array(
                        'label' => '',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'before' => '<label class="dte">'.__('Order date').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'date_from',
                    ));
                    echo $this->Form->input('date_to_order', array(
                        'label' => '',
                        'type' => 'text',
                        'class' => 'form-control datemask',
                        'before' => '<label class="dte">'.__('To').'</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                        'after' => '</div>',
                        'id' => 'date_to',
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

                        <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>'.__('Add'),
                            'javascript:addPreinvoice();',
                            array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'add_prefacture',
                                )
                        ); ?>


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
echo $this->Form->input('type', array(
    'label' => __('Type'),
    'class' => 'form-filter',
    'id' => 'type_doc',
    'type' => 'hidden',
    'value' => $type,
    'empty' => ''
));

echo $this->Form->input('select_with_pagination', array(
    'class' => 'form-filter',
    'id' => 'select_with_pagination',
    'type' => 'hidden',
    'value' => 0,
    'empty' => ''
));

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


    <?php
    $query = $this->Session->read('query');
    extract($query);
    $tableId = strtolower($tableName) . '-grid';
    /** @var array $columns */
    /** @var string $tableName */
    ?>
    <!--    Content section    -->
    <?= $this->element('index-body-content', array(
        "tableId" => $tableId,
        "tableName" => $tableName,
        "columns" => $columns,
    ));
    ?>
    <!--    End content section    -->


    <!--    DataTables Script    -->
    <?= $this->element('data-tables-script', array(
        "tableId" => $tableId,
        "tableName" => $tableName,
        "columns" => $columns,
        "defaultLimit" => $defaultLimit,
    ));
    ?>
    <!--    End dataTables Script    -->




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

    });

   function addPreinvoice() {
        var type_doc=jQuery('#type_doc').val();

        var orderType=jQuery('#order_type').val();
        var selectWithPagination = $('#select_with_pagination').val();
        if($('#select_with_pagination').val()==1){

                jQuery('#dialogModalClient').dialog('option', 'title', 'Choisir le client');
                jQuery('#dialogModalClient').dialog('open');
                jQuery('#dialogModalClient').load('<?php echo $this->Html->url('/transportBills/addPreinvoice/')?>'
                    + type_doc+ '/'+selectWithPagination+'/'+orderType);
        }else {
            var dataTable = jQuery('#<?= $tableId ?>').DataTable();
            var myCheckboxes = new Array();
            jQuery.each(dataTable.rows('.selected').data(), function (key, item) {
                myCheckboxes.push(item[<?= count($columns) + 1 ?>]);
            });
            if(myCheckboxes.length>0){
                jQuery('#dialogModalClient').dialog('option', 'title', 'Choisir le client');
                jQuery('#dialogModalClient').dialog('open');
                jQuery('#dialogModalClient').load('<?php echo $this->Html->url('/transportBills/addPreinvoice/')?>'
                    + type_doc+ '/'+selectWithPagination+ '/'+myCheckboxes+'/'+orderType);

            }
        }

       }
 </script>
<?php $this->end(); ?>
</div>
     
            
