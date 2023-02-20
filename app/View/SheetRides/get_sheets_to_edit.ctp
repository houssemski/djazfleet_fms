

<?php
$this->start('css');
echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->Html->css('select2/select2.min');
$this->end();
?>
<h4 class="page-title"> <?= __('Edit').' '.__('Sheet rides (travels)'); ?></h4>
<div class="box-body">
    <div class="panel-group wrap" id="bs-collapse">

        <div class="panel loop-panel">
            <a class="collapsed fltr" data-toggle="collapse" data-parent="#" href="#one">
                <i class="zmdi zmdi-search-in-page"></i>
            </a>

            <div id="one" class="panel-collapse collapse">
                <div class="panel-body">

                    <?php echo $this->Form->create('SheetRides', array(
                        'url' => array(
                            'action' => 'getSheetsToEdit', $transportBillDetailRideId, $observationId
                        ),
                        'novalidate' => true
                    )); ?>

                    <div class="filters" id='filters'>
                     <?php
                        echo $this->Form->input('car_id', array(
                            'label' => __('Car'),
                            'class' => 'form-filter select-search-car',
                            'empty' => ''
                        ));
                        echo $this->Form->input('car_type_id', array(
                            'id' => 'car_type',
                            'type' => 'hidden',
                        ));
                        echo $this->Form->input('customer_id', array(
                            'label' => __('Conducteur'),
                            'class' => 'form-filter select-search-customer',
                            'id' => 'customer',
                            'empty' => ''
                        ));

                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('detail_ride_id', array(
                            'label' => __('Ride'),
                            'class' => 'form-filter select-search-detail-ride',
                            'empty' => ''
                        ));

                        echo $this->Form->input('parc_id', array(
                            'label' => __('Parc'),
                            'class' => 'form-filter select2',
                            'empty' => ''
                        ));
                        if ($useRideCategory == 2) {
                            echo "<div style='clear:both; padding-top: 10px;'></div>";
                            echo $this->Form->input('ride_category_id', array(
                                'label' => __('Category'),
                                'class' => 'form-filter select2',
                                'empty' => ''
                            ));
                        }
                        echo "<div style='clear:both; padding-top: 10px;'></div>";

                        echo $this->Form->input('supplier_id', array(
                            'label' => __('Client'),
                            'class' => 'form-filter select-search-client-initial',
                            'empty' => ''
                        ));
                        $options = array('1' => __('Planned'), '2' => __('In progress'));

                        echo $this->Form->input('status_id', array(
                            'label' => __('Status'),
                            'class' => 'form-filter select2',
                            'options' => $options,
                            'id' => 'status',
                            'empty' => ''
                        ));

                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('start_date1', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Departure date from') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'start_date1',
                        ));
                        echo $this->Form->input('start_date2', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'start_date2',
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('end_date1', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Arrival date from') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'end_date1',
                        ));
                        echo $this->Form->input('end_date2', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('to date') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'end_date2',
                        )); ?>

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

    <?= $this->Form->input('controller', array(
        'id' => 'controller',
        'value' => $this->request->params['controller'],
        'type' => 'hidden'
    )); ?>

    <?= $this->Form->input('current_action', array(
        'id' => 'current_action',
        'value' => $this->request->params['action'],
        'type' => 'hidden'
    )); ?>
    <?= $this->Form->input('transportBillDetailRideId', array(
        'id' => 'transportBillDetailRideId',
        'value' => $transportBillDetailRideId,
        'type' => 'hidden'
    )); ?> <?= $this->Form->input('observationId', array(
        'id' => 'observationId',
        'value' => $observationId,
        'type' => 'hidden'
    )); ?>

    <?= $this->Form->input('action', array(
        'id' => 'action',
        'value' => 'liste',
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
        $page = 1;
    }
    $uriParts = explode('?', $_SERVER['REQUEST_URI'], 2);

    $url =  base64_encode(serialize($uriParts[0]));
    $controller = $this->request->params['controller'];

    ?>
    <?= $this->Form->input('url', array(
        'id' => 'url',
        'value' => base64_encode(serialize($uriParts[0])),
        'type' => 'hidden'
    )); ?>

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <?php
                $query = $this->Session->read('query');

                extract($query);
                /*$transportBillDetailRideId = $this->Session->read('transportBillDetailRideId');
                $observationId = $this->Session->read('observationId');*/

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
                    "type" => 'Sheet',
                    "transportBillDetailRideId" => $transportBillDetailRideId,
                    "observationId" => $observationId
                ));
                ?>
                <!--    End dataTables Script    -->

                <br/>
                <br/>

                <div id='missions' name="missions">

                </div>
                <br/>
                <br/>

            </div>
        </div>
    </div>
</div>


<?php $this->start('script'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('plugins/datetimepicker/moment-with-locales.min.js'); ?>
<?= $this->Html->script('plugins/datetimepicker/bootstrap-datetimepicker.min.js'); ?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
<script type="text/javascript">


    $(document).ready(function () {

        var currentURL = window.location.href;
        var parts = currentURL.split("/");
        var lastPart = parts[parts.length - 1];

        if (lastPart == 'barcode_departure:barcode_departure') {

            $("#barcode_departure").focus();
        }
        if (lastPart == 'barcode_arrival:barcode_arrival') {
            $("#barcode_arrival").focus();
        }


        jQuery("#start_date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#start_date2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#end_date1").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#end_date2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatecreat").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#startdatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddatemodifie").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        $("#barcode_departure").keypress(function (e) {
            if (e.which == 13) {
                $('#verifyBarCodeDeparture').submit();
            }
        });

        $("#barcode_arrival").keypress(function (e) {
            if (e.which == 13) {
                $('#verifyBarCodeDeparture').submit();
            }
        });

    });


    function updateDateKmDepartureSheetRide() {

        var barcode = jQuery('#barcode').val();


        jQuery.ajax({
            type: "POST",
            url: "<?php echo $this->Html->url('/sheetRides/verifyBarCode/')?>",
            dataType: "json",
            data: {barcode: barcode},
            success: function (json) {
                if (json.exist == "true") {
                    if (json.response == "true") {
                        msg = "<?php echo __("Date and km have been updated")?>";
                        alert(msg);

                    } else {
                        msg = "<?php echo __("Date and km have not been updated")?>";
                        alert(msg);
                    }

                } else {
                    msg = "<?php echo __("Reference does not exist")?>";
                    alert(msg);
                }

            }
        });

    }

    function viewDetail(id) {
        $("html").css("cursor", "pointer");
        scrollToAnchor('missions');
        jQuery('tr').removeClass('btn-info  btn-trans');
        jQuery('#row' + id).addClass('btn-info  btn-trans');
        jQuery('#missions').load('<?php echo $this->Html->url('/sheetRides/viewDetail/')?>' + id, function () {

        });
    }


</script>
<?php $this->end(); ?>
