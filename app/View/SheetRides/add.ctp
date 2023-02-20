
<?php


include("ctp/datetime.ctp");
$this->start('css');
echo $this->Html->css('colorpicker/bootstrap-colorpicker.min');
echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->Html->css('select2/select2.min');
$this->end();
?>
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


<?= $this->Form->input('gestion_commercial', array(
    'id' => 'gestion_commercial',
    'value' => Configure::read("gestion_commercial"),
    'type' => 'hidden'
)); ?>

<?= $this->Form->input('transport_personnel', array(
    'id' => 'transport_personnel',
    'value' => Configure::read("transport_personnel"),
    'type' => 'hidden'
)); ?>

<h4 class="page-title"> <?= __('Add sheet ride (travel)'); ?></h4>
<style>
    .filters {
        clear: both;
        width: 1050px;
        margin-bottom: 20px;
    }

    .filters .btn-default {
        margin-top: 15px;
        float: right;
        margin-right: 40px;
    }

    .filters .last {
        margin-right: 0px;
    }

    .filters select, .filters input {
        margin-right: 20px;
        height: 31px;
    }

    .filters .input-group {
        width: 160px;
        float: left;
    }

    .filters .input-group input.datemask {
        margin-right: 20px;
        width: 142px !important;
    }

    .filters .input-group label {
        display: none;
    }

    .filters div.input {
        float: left;
        padding-top: 5px;
        width: 265px;
    }

    .form-sm-6 div.input {
        float: left;
        padding-top: 5px;
        width: 400px;
    }

    .filters label.dte {
        float: left;
        padding-top: 5px;
        width: 286px;
    }

    .filters div.input label {
        width: 150px;
        padding-top: 5px;
    }

    .filters {
        width: 100%;
    }

    .filters select, .filters input {
        margin-right: 0px;
    }

    .form-filter {
        border-radius: 0;
        width: 78.7%;
    }

    .filters div.input, .filters .input-group {
        float: none;
    }

    .input-group {
        width: 80% !important;
    }

    .input.text .input-group input {
        width: 100% !important;
    }

    input[type="file"] {
        display: inline-block;

        margin-top: 10px;
        margin-bottom: 20px;
    }

    #dynamic_field {
        width: 100%;
        display: table-caption;
        position: relative;
    }

    #dynamic_field tbody, #dynamic_field tbody tr, #dynamic_field tbody td {
        width: 100%;
    }

    #dynamic_field .form-groupee {
        width: 100%
    }

    .out-table-caption {
        position: absolute;
        right: 15px;
    }

    .btn.btn-marg {
        margin-top: 0px;
        margin-left: 35px;
    }

    .btn-success {
        width: 100px;
    }

    .btn_remove {
        width: 40px;
    }

    .panel-default > .panel-heading {
        border-bottom: none;
        color: #f5f5f5;
    }

    .input-button {
        float: left;
        width: 80%;
        margin-right: 0px;
    }

    .popupactions {
        float: left;
        margin-left: -20px;
        margin-top: 35px;
        margin-right: 10px;
    }

    .p-radio {
        font-weight: bold;
        float: left;
        margin-right: 20px;
        padding-top: 5px;
    }

    .select-inline2 .input {
        width: 570px !important;
    }

    .td-input .file {
        width: 100% !important;
    }

    .select2-selection--multiple {
        height: 20px;
    }

    .input-radio {
        position: relative;
        top: 5px;
    }

    .label-radio {
        padding-left: 10px;
        top: -6px;
        position: relative;
    }

    .scroll-block {
        width: 37%;
        display: inline-block;
        vertical-align: top;
    }

    .scroll-block100 {
        width: 100%;
        display: inline-block;
        vertical-align: top;
    }



    .file {
        width: 100% important !;
    }

    .select2 {
        font-size: 11px;
    }

    label {
        font-size: 10px;
    }

    .consumption div.input {
        width: 150px;
    !important;
    }
    .small-select .select { width: 100% !important;}
</style>


<div class="box">
    <div class="edit form card-box p-b-0">
        <?php
        $i = 1;
        echo $this->Form->create('SheetRide', array('enctype' => 'multipart/form-data', 'onsubmit' => 'javascript:disable();showRequiredFields();'));
        if(!empty($transportBillDetailedRideId)){
            echo $this->Form->input('transport_bill_detailed_ride_id', array(
                'label' => false,
                'type' => 'hidden',
                'class' => 'form-control',
                'id' => 'nb_ride',
                'value' => $transportBillDetailedRideId
            ));
        }
        ?>
        <div class="box-body" style="max-width: 100%;">
            <table class="table table-bordered " id='table_rides'>
                <tr>
                    <td rowspan=4 id='travel'><?php echo __('Travel'); ?></td>
                    <td colspan=2><?php echo __('At the establishment'); ?></td>
                    <td style="width: 95%;">
                        <div class="nav-tabs-custom pdg_btm">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                                <li><a href="#tab_2" data-toggle="tab"><?= __('Car state') ?></a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <?php
                                    echo "<div >" . $this->Form->input('nb_ride', array(
                                            'label' => '',
                                            'type' => 'hidden',
                                            'class' => 'form-control',
                                            'id' => 'nb_ride',
                                            'value' => $i
                                        )) . "</div>";
                                    if (Configure::read("transport_personnel") == '1') {
                                        echo  $this->element('departure_personal_transport');
                                    } else {
                                        echo  $this->element('departure_utranx',array(
                                                'cars' => $cars
                                        ));
                                     } ?>
                                </div>
                                <div class="tab-pane" id="tab_2">

                                    <?php
                                    if($permissionAddCarState){
                                        if(!empty($carStates)){
                                            $i=1;
                                            foreach ($carStates as $carState){
                                                echo "<div style='min-height: 65px;'>";
                                                echo "<div class=' col-sm-4' style='margin-top: 30px;'>";

                                                echo '<div class="lbl4">' . $carState['CarState']['name'];
                                                echo "</div>";
                                                $options = array('1' => __('Yes'), '2' => __('No'));
                                                $attributes = array('legend' => false);
                                                echo $this->Form->radio('SheetRideDepartureCarState.'.$i.'.car_state_value', $options, $attributes)."</div>" ;
                                                echo "<div class=' col-sm-4'>" . $this->Form->input('SheetRideDepartureCarState.'.$i.'.note', array(
                                                        'label' => __('Note'),
                                                        'class' => 'form-control',
                                                        'id' => 'note'.$i,
                                                        'empty' => '',
                                                    )) . "</div>";
                                                echo "<div class=' input-file col-sm-4'>" . $this->Form->input('SheetRideDepartureCarState.' . $i . '.attachment', array(
                                                        'label' => __('Attachment'),
                                                        'class' => 'form-control filestyle',
                                                        'type' => 'file',
                                                        'empty' => ''
                                                    )) . "</div>";
                                                echo $this->Form->input('SheetRideDepartureCarState.'.$i.'.car_state_id', array(
                                                        'id' => 'car_state_id'.$i,
                                                        'value' => $carState['CarState']['id'],
                                                        'type' => 'hidden',
                                                        'class' => 'form-filter '
                                                    )) ;

                                                echo $this->Form->input('SheetRideDepartureCarState.'.$i.'.departure_arrival', array(
                                                        'id' => 'departure_arrival'.$i,
                                                        'value' => 1,
                                                        'options'=>array(1=>'departure',2=>'arrival'),
                                                        'type' => 'hidden',
                                                        'class' => 'form-filter '
                                                    )) ;

                                                echo "</div>";
                                                $i++;
                                            }
                                             }

                                    }
                                    ?>

                                </div>

                            </div>
                        </div>


                    </td>


                </tr>

                <?php
                if($sheetRideWithMission ==1 ||$sheetRideWithMission ==3) {
                if(Configure::read("transport_personnel") == '1'){
                    echo  $this->element('add_sheet_ride_personal_transport');
                }else {
                    if (Configure::read("gestion_commercial") == '1') {
                        if(($isDestinationRequired==1)){
                            echo  $this->element('add_sheet_ride_utranx');
                        }else {
                            echo  $this->element('add_sheet_ride_fms');
                        }
                    }else {
                        echo  $this->element('add_sheet_ride_fms');
                    }
                    }
                }
                ?>



                <tr>
                    <td colspan=2><?php echo __('Retour au parc') ?></td>
                    <td>
                        <div class="nav-tabs-custom pdg_btm">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_3" data-toggle="tab"><?= __('General information') ?></a></li>

                                <li><a href="#tab_4" data-toggle="tab"><?= __('Car state') ?></a></li>


                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_3">
                                 <?php   if (Configure::read("transport_personnel") == '1') {
                                    echo  $this->element('arrival_personal_transport');
                                    } else {
                                    echo  $this->element('arrival_utranx');
                                    } ?>

                                </div>

                                <div class="tab-pane" id="tab_4">

                                    <?php
                                    if($permissionAddCarState){
                                        if(!empty($carStates)){
                                            $i=1;
                                            foreach ($carStates as $carState){
                                                echo "<div style='min-height: 65px;'>";
                                                echo "<div class=' col-sm-4' style='margin-top: 30px;'>";

                                                echo '<div class="lbl4">' . $carState['CarState']['name'];
                                                echo "</div>";
                                                $options = array('1' => __('Yes'), '2' => __('No'));
                                                $attributes = array('legend' => false);
                                                echo $this->Form->radio('SheetRideArrivalCarState.'.$i.'.car_state_value', $options, $attributes)."</div>" ;


                                                echo "<div class=' col-sm-4'>" . $this->Form->input('SheetRideArrivalCarState.'.$i.'.note', array(
                                                        'label' => __('Note'),
                                                        'class' => 'form-control',
                                                        'id' => 'note'.$i,
                                                        'empty' => '',
                                                    )) . "</div>";
                                                echo "<div class=' input-file col-sm-4'>" . $this->Form->input('SheetRideArrivalCarState.' . $i . '.attachment', array(
                                                        'label' => __('Attachment'),
                                                        'class' => 'form-control filestyle',
                                                        'type' => 'file',
                                                        'empty' => ''
                                                    )) . "</div>";
                                                echo $this->Form->input('SheetRideArrivalCarState.'.$i.'.car_state_id', array(
                                                    'id' => 'car_state_id'.$i,
                                                    'value' => $carState['CarState']['id'],
                                                    'type' => 'hidden',
                                                    'class' => 'form-filter '
                                                ));

                                                echo $this->Form->input('SheetRideArrivalCarState.'.$i.'.departure_arrival', array(
                                                    'id' => 'departure_arrival'.$i,
                                                    'value' => 2,
                                                    'options'=>array(1=>'departure',2=>'arrival'),
                                                    'type' => 'hidden',
                                                    'class' => 'form-filter '
                                                ));

                                                echo "</div>";
                                                $i++;
                                            }
                                        }

                                    }
                                    ?>

                                </div>

                            </div>
                        </div>


                    </td>

                </tr>
            </table>

            <div style='clear:both;'></div>
            <br/><br/>
<?php  if (Configure::read("transport_personnel") == '1') {
    $name = __('Add itinerary');
           }else {
    $name = __('Add ride');
 } ?>
            <?php if($sheetRideWithMission !=3) { ?>
                <div class="btn-group pull-right">
                    <div class="header_actions" style='padding:0px;'>
                        <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . $name,
                            'javascript:addRideSheetRide();',
                            array('escape' => false, 'class' => 'btn btn-primary btn-trans waves-effect waves-primary w-md m-b-5', 'id' => 'add_ride')) ?>

                    </div>
                </div>
            <?php } ?>



        </div>


        <div style='clear:both;'></div>
        <div class="box-footer">
            <?php echo $this->Form->submit(__('Submit'), array(
                'name' => 'ok',
                'class' => 'btn btn-primary btn-bordred  m-b-5',
                'label' => __('Submit'),
                'type' => 'submit',
                'id' => 'submitButton',

                'div' => false
            )); ?>
            <?php echo $this->Form->submit(__('Cancel'), array(
                'name' => 'cancel',
                'class' => 'btn btn-danger btn-bordred  m-b-5 cancelbtn',
                'label' => __('Cancel'),
                'type' => 'submit',
                'div' => false,
                'formnovalidate' => true
            )); ?>
        </div>
    </div>
</div>
<?php $this->start('script'); ?>
<?php if ($calculByMaps == 1) { ?>
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDyG3DG3gkHY1Gk9BPzR6c0FNG4ZM16vDM&libraries=places">
    </script>
<?php  } ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('maskedinput'); ?>

<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('jquery-2.1.1.min.js'); ?>
<?= $this->Html->script('jquery.form.min.js'); ?>

<script type="text/javascript">

    jQuery(function () {
        $('#submitButton').on('click', function (e) {

            //e.preventDefault();
            var submit = true;
            var fieldMarchandiseRequired = jQuery('#fieldMarchandiseRequired').val();
            if(fieldMarchandiseRequired==1){
                var nbRide = jQuery('#nb_ride').val();
                for (var i = 1 ; i<=nbRide ; i++){
                    var nbMarchandise = jQuery('#nb_marchandise'+i).val();
                    if(!$("#marchandise-div"+i).is(':empty')){
                        for(var j = 1 ; j<=nbMarchandise ; j++){
                        jQuery('#marchandise' + '' + i + j+'').parent().addClass('required');
                        jQuery('#quantity' + '' + i + j+'').parent().addClass('required');
                        }
                        jQuery('#march' + '' + i + '').addClass('in');
                    }
                }
                $(':input[required]').each(function () {

                    if ($(this).val() == '') {
                        submit = false;
                    }
                });
                if (submit) {
                    $('form#SheetRideAddForm').submit();
                }


            }else {
                $(':input[required]').each(function () {

                    if ($(this).val() == '') {
                        submit = false;
                    }
                });
                if (submit) {
                    $('form#SheetRideAddForm').submit();
                }
            }


        });
        jQuery("#start_date1").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
        jQuery("#start_date2").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
        jQuery("#end_date1").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
        jQuery("#end_date2").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
        jQuery("#planned_start_date1").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
        jQuery("#real_start_date1").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
        jQuery("#planned_end_date1").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
        jQuery("#real_end_date1").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});

        if (jQuery('#car_subcontracting1').prop('checked')){

            getInformationCarBySubcontracting('car_subcontracting1');
        }
        i = jQuery('#nb_ride').val();


        jQuery("#dialogModalCustomer").dialog({
            autoOpen: false,
            height: 400,
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
        jQuery(".overlayCustomer").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapCustomer').load(jQuery(this).attr("href"));
            jQuery('#dialogModalCustomer').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalCustomer').dialog('open');
        });

        jQuery("#dialogModalCar").dialog({
            autoOpen: false,
            height: 600,
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
        jQuery(".overlayCar").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapCar').load(jQuery(this).attr("href"));
            jQuery('#dialogModalCar').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalCar').dialog('open');
        });

        jQuery("#dialogModalRemorque").dialog({
            autoOpen: false,
            height: 530,
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
        jQuery(".overlayRemorque").click(function (event) {
            event.preventDefault();
            jQuery('#contentWrapRemorque').load(jQuery(this).attr("href"));
            jQuery('#dialogModalRemorque').dialog('option', 'title', jQuery(this).attr("title"));
            jQuery('#dialogModalRemorque').dialog('open');
        });

        if (jQuery('#source1' + '' + i + '').is(':checked')) {

            var typeId = jQuery("#car").val();
            jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getRidesFromCustomerOrder/')?>' + i + '/' + typeId, function () {
                jQuery('.select3').select2();
            });
        } else {
            if (jQuery('#source3' + '' + i + '').is(':checked')) {
                typeId = jQuery("#car_type").val();
                if (typeId == '') typeId = 0;
                jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getRidesByType/')?>' + i + '/' + typeId, function () {
                    $('.select-search-detail-ride').select2({
                        ajax: {
                            url: "<?php echo $this->Html->url('/detailRides/getDetailRidesByKeyWord')?>",
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    q: $.trim(params.term),
                                    carTypeId: jQuery('#car_type').val()
                                };
                            },
                            processResults: function (data, page) {
                                return {results: data};
                            },
                            cache: true
                        },
                        minimumInputLength: 3

                    });
                });
            } else {

                jQuery('#ride-div' + '' + i + '').removeClass('select-inline2');
                jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getPersonalizedRide/')?>' + i, function () {
                    $('.select-search-destination').select2({
                        ajax: {
                            url: "<?php echo $this->Html->url('/destinations/getDestinationsByKeyWord')?>",
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    q: $.trim(params.term)
                                };
                            },
                            processResults: function (data, page) {
                                return {results: data};
                            },
                            cache: true
                        },
                        minimumInputLength: 3

                    });

                });
            }


        }

        if (jQuery("#detail_ride1").val() > 0) {
            if (jQuery("#origin_wilaya").val() != "" && jQuery("#destination_departure").val() != "") {
                var calculByMaps = jQuery('#calcul_maps').val();
                if (calculByMaps == 1) {
                    calculateDistanceAndDurationCompanyFirstRide(jQuery("#origin_wilaya").val(), jQuery("#destination_departure").val());
                    calculateKmArrivalParc('km_arrival1');
                }


            } else {

                if (jQuery("#duration_day_first").val() > 0 || jQuery("#duration_day_first").val() > 0 || jQuery("#duration_minute_first").val() > 0 || jQuery("#distance_first").val() > 0) {

                    calculPlannedDepartureDateFirstRide();
                    calculKmDepartureEstimatedFirstRide();
                    // calculKmArrivalEstimated('km_departure1');
                    //calculateKmArrivalParc('km_departure1');
                }
            }
        }

        if (jQuery('#cars').val() > 0) {

            jQuery('#customers-div').load('<?php echo $this->Html->url('/sheetRides/getCustomersByCar/')?>' + jQuery('#cars').val(), function () {
                    if (jQuery('#customers').val()) {
                        var customerId = jQuery('#customers').val();
                    } else {
                        var customerId = '';
                    }
                    $('.select-search-customer').select2({
                        ajax: {
                            url: "<?php echo $this->Html->url('/customers/getCustomersByKeyWord')?>",
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    q: $.trim(params.term),
                                    controller: jQuery('#controller').val(),
                                    action: jQuery('#current_action').val(),
                                    customerId: customerId
                                };
                            },
                            processResults: function (data, page) {
                                return {results: data};
                            },
                            cache: true
                        },
                        minimumInputLength: 2
                    });

                }
            );
            jQuery('#remorques-div').load('<?php echo $this->Html->url('/sheetRides/getRemorquesByCar/')?>' + jQuery('#cars').val(), function () {

                if (jQuery('#remorques').val()) {
                    var remorqueId = jQuery('#remorques').val();
                } else {
                    var remorqueId = '';
                }
                $('.select-search-remorque').select2({
                    ajax: {
                        url: "<?php echo $this->Html->url('/cars/getRemorquesByKeyWord')?>",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: $.trim(params.term),
                                controller: jQuery('#controller').val(),
                                action: jQuery('#current_action').val(),
                                remorqueId: remorqueId
                            };
                        },
                        processResults: function (data, page) {
                            return {results: data};
                        },
                        cache: true
                    },
                    minimumInputLength: 2

                });
            });
            jQuery('#consumption-bloc').load('<?php echo $this->Html->url('/sheetRides/getConsumptions/')?>' + jQuery('#cars').val(), function () {
                jQuery('#km-tank-departure-div').load('<?php echo $this->Html->url('/sheetRides/getKmAndTank/')?>' + jQuery('#cars').val(), function () {
                    if (jQuery('#car_subcontracting1').prop('checked')){
                        var nbRide = jQuery('#nb_ride').val();
                        for (var i = 1; i <= nbRide; i++) {
                            jQuery('#cost_contractor_div' + '' + i + '').css('display', 'block');
                        }
                    }
                    calculKmDepartureEstimatedFirstRide();
                    calculKmArrivalEstimated('km_departure1');
                    //estimateCost();
                    calculateKmArrivalParc('km_departure1');
                    calculateAuthorizedWeight();
                });
            });



            jQuery('#mission-car-bloc').load('<?php echo $this->Html->url('/sheetRides/verifyMissionCar/')?>' + jQuery('#cars').val(), function () {

            });


            getMaintenances();
        }


        jQuery('#car_type').change(function () {


            var i = jQuery('#nb_ride').val();

            if (jQuery('#source1' + '' + i + '').is(':checked')) {
                type_id = jQuery("#car_type").val();
                jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getRidesFromCustomerOrder/')?>' + i + '/' + type_id, function () {
                    jQuery('.select3').select2();
                });
            } else {
                if (jQuery('#source2' + '' + i + '').is(':checked')) {
                    var typeId = jQuery("#car_type").val();
                    jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getPersonalizedRidesFromCustomerOrder/')?>' + i + '/' + typeId, function () {
                        jQuery('.select3').select2();
                    });
                } else {
                    if (jQuery('#source3' + '' + i + '').is(':checked')) {
                        type_id = jQuery("#car_type").val();
                        if (type_id == '') type_id = 0;
                        jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getRidesByType/')?>' + i + '/' + type_id, function () {

                            $('.select-search-detail-ride').select2({
                                ajax: {
                                    url: "<?php echo $this->Html->url('/detailRides/getDetailRidesByKeyWord')?>",
                                    dataType: 'json',
                                    delay: 250,
                                    data: function (params) {
                                        return {
                                            q: $.trim(params.term),
                                            carTypeId: jQuery('#car_type').val()
                                        };
                                    },
                                    processResults: function (data, page) {
                                        return {results: data};
                                    },
                                    cache: true
                                },
                                minimumInputLength: 3

                            });
                        });
                    } else {
                        jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getPersonalizedRide/')?>' + i, function () {
                            $('.select-search-destination').select2({
                                ajax: {
                                    url: "<?php echo $this->Html->url('/destinations/getDestinationsByKeyWord')?>",
                                    dataType: 'json',
                                    delay: 250,
                                    data: function (params) {
                                        return {
                                            q: $.trim(params.term)
                                        };
                                    },
                                    processResults: function (data, page) {
                                        return {results: data};
                                    },
                                    cache: true
                                },
                                minimumInputLength: 3

                            });

                        });
                    }
                }

            }
        });
        if (jQuery('#car_type').val() > 0) {


            var i = jQuery('#nb_ride').val();
            if (jQuery('#source1' + '' + i + '').is(':checked')) {
                type_id = jQuery("#car_type").val();
                jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getRidesFromCustomerOrder/')?>' + i + '/' + type_id, function () {
                    jQuery('.select3').select2();
                });
            } else {
                if (jQuery('#source2' + '' + i + '').is(':checked')) {
                    var typeId = jQuery("#car_type").val();
                    jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getPersonalizedRidesFromCustomerOrder/')?>' + i + '/' + typeId, function () {
                        jQuery('.select3').select2();
                    });
                } else {
                    if (jQuery('#source3' + '' + i + '').is(':checked')) {
                        type_id = jQuery("#car_type").val();
                        if (type_id == '') type_id = 0;
                        jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getRidesByType/')?>' + i + '/' + type_id, function () {

                            $('.select-search-detail-ride').select2({
                                ajax: {
                                    url: "<?php echo $this->Html->url('/detailRides/getDetailRidesByKeyWord')?>",
                                    dataType: 'json',
                                    delay: 250,
                                    data: function (params) {
                                        return {
                                            q: $.trim(params.term),
                                            carTypeId: jQuery('#car_type').val()
                                        };
                                    },
                                    processResults: function (data, page) {
                                        return {results: data};
                                    },
                                    cache: true
                                },
                                minimumInputLength: 3

                            });
                        });
                    } else {
                        jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getPersonalizedRide/')?>' + i, function () {
                            $('.select-search-destination').select2({
                                ajax: {
                                    url: "<?php echo $this->Html->url('/destinations/getDestinationsByKeyWord')?>",
                                    dataType: 'json',
                                    delay: 250,
                                    data: function (params) {
                                        return {
                                            q: $.trim(params.term)
                                        };
                                    },
                                    processResults: function (data, page) {
                                        return {results: data};
                                    },
                                    cache: true
                                },
                                minimumInputLength: 3

                            });

                        });
                    }
                }


            }
        }


        var i = jQuery('#nb_ride').val();

        if (jQuery('#source1' + '' + i + '').is(':checked')) {

            type_id = jQuery("#car_type").val();
            jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getRidesFromCustomerOrder/')?>' + i + '/' + type_id, function () {

                jQuery('.select3').select2();
            });
        }

        jQuery('#source3' + '' + i + '').on('ifChecked', function (event) {
            var type_id = jQuery("#car_type").val();
            if (type_id == '') type_id = 0;
            jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getRidesByType/')?>' + i + '/' + type_id, function () {
                $('.select-search-detail-ride').select2({
                    ajax: {
                        url: "<?php echo $this->Html->url('/detailRides/getDetailRidesByKeyWord')?>",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: $.trim(params.term),
                                carTypeId: jQuery('#car_type').val()
                            };
                        },
                        processResults: function (data, page) {
                            return {results: data};
                        },
                        cache: true
                    },
                    minimumInputLength: 3

                });
            });

        });


        jQuery('#source1' + '' + i + '').on('ifChecked', function (event) {
            type_id = jQuery("#car_type").val();

            jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getRidesFromCustomerOrder/')?>' + i + '/' + type_id, function () {

                jQuery('.select3').select2();
            });
        });
        jQuery('#start_date1').change(function () {


            calculPlannedDepartureDateFirstRide();
            //calculPlannedArrivalDate('planned_start_date1');
        });
        jQuery('#start_date2').change(function () {

            calculPlannedDepartureDateFirstRide();
            //calculPlannedArrivalDate('planned_start_date1');
        });
        jQuery('#km_dep').change(function () {
            calculKmDepartureEstimatedFirstRide();
            calculKmArrivalEstimated('km_departure1');
        });
    });


function verifyInputRequired(){
    var submit = true;
    $(':input[required]').each(function () {

        if ($(this).val() == '') {
            submit = false;
        }
    });
    return submit;
}

    function returnedCouponsToSelect() {
        var couponSelected = jQuery('#serial_number').val();
        if (parseInt(jQuery('#returned-coupons').val()) <= parseInt(jQuery('#coupons').val())) {
            jQuery('#returned_coupon_div').load('<?php echo $this->Html->url('/sheetRides/getReturnedCoupons/')?>' + couponSelected, function () {

                var maximumSelection = jQuery('#returned-coupons').val();
                $(".selectReturnedCoupon").select2({
                    maximumSelectionLength: maximumSelection
                });
            })
            calculateCost();
        } else {

            jQuery('#returned-coupons').val('');
        }
    }
    function carChanged() {

        var carId = jQuery('#cars').val();
        verifyStatusCar(carId);

        jQuery('#car_type_div').load('<?php echo $this->Html->url('/sheetRides/getCarTypeByCar/')?>' + jQuery('#cars').val(), function () {
            jQuery('.select3').select2();
            var nb_ride = jQuery('#nb_ride').val();
            for (var i = 1; i <= nb_ride; i++) {
                if (jQuery('#source1' + '' + i + '').is(':checked')) {
                    type_id = jQuery("#car_type").val();
                    jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getRidesFromCustomerOrder/')?>' + i + '/' + type_id, function () {
                        jQuery('.select3').select2();
                    });
                } else {
                    if (jQuery('#source2' + '' + i + '').is(':checked')) {
                        var typeId = jQuery("#car_type").val();
                        jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getPersonalizedRidesFromCustomerOrder/')?>' + i + '/' + typeId, function () {
                            jQuery('.select3').select2();
                        });
                    } else {
                        if (jQuery('#source3' + '' + i + '').is(':checked')) {
                            type_id = jQuery("#car_type").val();
                            if (type_id == '') type_id = 0;
                            jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getRidesByType/')?>' + i + '/' + type_id, function () {

                                $('.select-search-detail-ride').select2({
                                    ajax: {
                                        url: "<?php echo $this->Html->url('/detailRides/getDetailRidesByKeyWord')?>",
                                        dataType: 'json',
                                        delay: 250,
                                        data: function (params) {
                                            return {
                                                q: $.trim(params.term),
                                                carTypeId: jQuery('#car_type').val()
                                            };
                                        },
                                        processResults: function (data, page) {
                                            return {results: data};
                                        },
                                        cache: true
                                    },
                                    minimumInputLength: 3

                                });
                            });
                        } else {
                            jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getPersonalizedRide/')?>' + i, function () {
                                $('.select-search-destination').select2({
                                    ajax: {
                                        url: "<?php echo $this->Html->url('/destinations/getDestinationsByKeyWord')?>",
                                        dataType: 'json',
                                        delay: 250,
                                        data: function (params) {
                                            return {
                                                q: $.trim(params.term)
                                            };
                                        },
                                        processResults: function (data, page) {
                                            return {results: data};
                                        },
                                        cache: true
                                    },
                                    minimumInputLength: 3

                                });

                            });
                        }
                    }


                }
            }
        });


        jQuery('#customers-div').load('<?php echo $this->Html->url('/sheetRides/getCustomersByCar/')?>' + jQuery('#cars').val(), function () {
                if (jQuery('#customers').val()) {
                    var customerId = jQuery('#customers').val();
                } else {
                    var customerId = '';
                }
                $('.select-search-customer').select2({
                    ajax: {
                        url: "<?php echo $this->Html->url('/customers/getCustomersByKeyWord')?>",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: $.trim(params.term),
                                controller: jQuery('#controller').val(),
                                action: jQuery('#current_action').val(),
                                customerId: customerId
                            };
                        },
                        processResults: function (data, page) {
                            return {results: data};
                        },
                        cache: true
                    },
                    minimumInputLength: 2

                });
                if (jQuery('#customers').val() > 0) {
                    verifyDriverLicenseExpirationDate();

                }
            }
        );
        jQuery('#remorques-div').load('<?php echo $this->Html->url('/sheetRides/getRemorquesByCar/')?>' + jQuery('#cars').val(), function () {

            if (jQuery('#remorques').val()) {
                var remorqueId = jQuery('#remorques').val();
            } else {
                var remorqueId = '';
            }
            $('.select-search-remorque').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/cars/getRemorquesByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            controller: jQuery('#controller').val(),
                            action: jQuery('#current_action').val(),
                            remorqueId: remorqueId
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2

            });
        });
        jQuery('#consumption-bloc').load('<?php echo $this->Html->url('/sheetRides/getConsumptions/')?>' + jQuery('#cars').val(), function () {
            jQuery('#km-tank-departure-div').load('<?php echo $this->Html->url('/sheetRides/getKmAndTank/')?>' + jQuery('#cars').val(), function () {
                if (jQuery('#car_subcontracting1').prop('checked')){
                    var nbRide = jQuery('#nb_ride').val();
                    for (var i = 1; i <= nbRide; i++) {
                        jQuery('#cost_contractor_div' + '' + i + '').css('display', 'block');
                    }
                }
                calculKmDepartureEstimatedFirstRide();
                calculKmArrivalEstimated('km_departure1');
                //estimateCost();
                calculateKmArrivalParc('km_departure1');
                calculateAuthorizedWeight();
            });
        });
        jQuery('#mission-car-bloc').load('<?php echo $this->Html->url('/sheetRides/verifyMissionCar/')?>' + jQuery('#cars').val(), function () {


        });
        var typeConsumption = jQuery('#type_consumption1').val();
        jQuery("#consumption-method1").load('<?php echo $this->Html->url('/sheetRides/addConsumptionMethod/')?>' + typeConsumption + '/' + 1+'/'+carId, function () {
            $('.select3').select2({});
        });

        if(typeConsumption>0){
            jQuery('#consumption-method1').load('<?php echo $this->Html->url('/sheetRides/getConsumptionMethodByCar/')?>' + carId+'/'+typeConsumption, function () {
            });
        }

        getMaintenances();


    }


    /* cette fonction si pour verifier le statut du véhicule si le véhicule est en panne on alerte l'utilisateur*/
    function verifyStatusCar(carId) {

        if (carId != '') {
            jQuery.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url('/sheetRides/verifyStatusCar/')?>",
                data: {carId: carId},
                dataType: "json",
                success: function (json) {
                    if (json.response === "true") {
                        alert('Le vehicule est en panne');
                    }
                }
            });

        }
    }
    function addRideSheetRide() {

        var nb_ride = parseFloat(jQuery('#nb_ride').val());
        $('#remove' + nb_ride + '').remove();
        jQuery("#end_date1").val('');
        jQuery("#km_arr_estimated").val('');
        var i = nb_ride + 1;
        var rowspan = (i * 2) + 2;

        if(i%2 == 1){
            jQuery("#table_rides tbody tr:last").prev().after("<tr style ='background-color: #f2f2f2;' id=depart" + i + "></tr>");
            jQuery("#table_rides tbody tr:last").prev().after("<tr  style ='background-color: #f2f2f2;' id=arrive" + i + "></tr>");

        }else {

            jQuery("#table_rides tbody tr:last").prev().after("<tr  id=depart" + i + "></tr>");
            jQuery("#table_rides tbody tr:last").prev().after("<tr   id=arrive" + i + "></tr>");

        }

        jQuery("#depart" + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/addDepartRide/')?>' + i, function () {
            jQuery("#planned_start_date" + '' + i + '').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
            jQuery("#real_start_date" + '' + i + '').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
            //jQuery('#departure_destination' + '' + i + '').parent().addClass('required');
           // jQuery('#arrival_destination' + '' + i + '').parent().addClass('required');
            jQuery(".datetime").datetimepicker({

                format: 'DD/MM/YYYY HH:mm',
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }

            });
            var id = 'source1' + i;
            $('.select-search-destination').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/destinations/getDestinationsByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 3

            });
            jQuery('#client-initial-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getClientInitial/')?>' + i, function () {
                $('.select-search-client-initial').select2({
                    ajax: {
                        url: "<?php echo $this->Html->url('/suppliers/getInitialSuppliersByKeyWord')?>",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: $.trim(params.term)
                            };
                        },
                        processResults: function (data, page) {
                            return {results: data};
                        },
                        cache: true
                    },
                    minimumInputLength: 2

                });
            });
            if(jQuery('#gestion_commercial' ).val() == 1){
                getRidesFromCustomerOrder(id);

            }

            calculPlannedDepartureDate(id);
            //getFinalSupplierByInitialSupplier(id);

        });

        jQuery("#arrive" + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/addArriveRide/')?>' + i, function () {
            jQuery("#planned_end_date" + '' + i + '').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
            jQuery("#real_end_date" + '' + i + '').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
            jQuery(".datetime").datetimepicker({

                format: 'DD/MM/YYYY HH:mm',
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }

            });

        });


        jQuery("#travel").attr("rowspan", rowspan);
        jQuery('#nb_ride').val(i);


    }

    function calculPlannedArrivalDate(id) {

        //var num = id.substring(id.length - 1, id.length);

        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(6, trId.length);
        if (jQuery('#source4' + '' + num + '').prop('checked')) {
            var detail_ride = 0;
        } else {
            var detail_ride = parseInt(jQuery("#detail_ride" + '' + num + '').val());
        }

        if (detail_ride >= 0) {

            if (jQuery("#real_start_date" + '' + num + '').val()) {

                var s_arr = jQuery("#real_start_date" + '' + num + '').val().split(/\/|\s|:/);
            } else {

                var s_arr = jQuery("#planned_start_date" + '' + num + '').val().split(/\/|\s|:/);
            }
            var myDate = new Date(s_arr[1] + "," + s_arr[0] + "," + s_arr[2] + "," + s_arr[3] + ":" + s_arr[4] + ":00");

            var averageSpeed = jQuery('#average_speed').val();
            if (averageSpeed > 0) {
                var averageSpeedPerMin = parseFloat(averageSpeed) / 60;
                var distance = jQuery('#distance' + '' + num + '').val();
                var totalMin = parseFloat(distance) / parseFloat(averageSpeedPerMin);
            } else {
                nb_day = parseInt(jQuery("#duration_day" + '' + num + '').val());
                nb_hour = parseInt(jQuery("#duration_hour" + '' + num + '').val());
                nb_min = parseInt(jQuery("#duration_minute" + '' + num + '').val());
                var totalMin = (24 * 60 * nb_day) + (60 * nb_hour) + nb_min;

            }


            var maximumDrivingTimePerMin = parseFloat(jQuery('#param_maximum_driving_time').val()) * 60;
            var breakTimePerMin = parseFloat(jQuery('#param_break_time').val()) * 60;
            var additionalTimeAllowedPerMin = parseFloat(jQuery('#param_additional_time_allowed').val()) * 60;
            if (num == 1) {
                var precedentTempsRestant = jQuery('#tempRestant0').val();

                if (parseFloat(totalMin) > parseFloat(precedentTempsRestant)) {
                    totalMin = totalMin - precedentTempsRestant;
                    var totalMinDivMaximumDrivingTimePerMin = (totalMin / maximumDrivingTimePerMin);
                    totalMinDivMaximumDrivingTimePerMin = parseInt(totalMinDivMaximumDrivingTimePerMin);


                    var totalMinModMaximumDrivingTimePerMin = (totalMin % maximumDrivingTimePerMin);

                    var tempRestant = maximumDrivingTimePerMin - totalMinModMaximumDrivingTimePerMin;
                    jQuery("#tempRestant" + '' + num + '').val(tempRestant);

                    if (parseFloat(totalMinDivMaximumDrivingTimePerMin) > 0) {
                        if (parseFloat(precedentTempsRestant) > 0) {
                            if (parseFloat(totalMinModMaximumDrivingTimePerMin) < parseFloat(additionalTimeAllowedPerMin)) {
                                var totalDurationPerMin = parseFloat(precedentTempsRestant) + parseFloat(breakTimePerMin) +
                                    (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                                    ((totalMinDivMaximumDrivingTimePerMin - 1) * breakTimePerMin) +
                                    parseFloat(totalMinModMaximumDrivingTimePerMin);

                            } else {
                                var totalDurationPerMin = parseFloat(precedentTempsRestant) + parseFloat(breakTimePerMin) +
                                    (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                                    (totalMinDivMaximumDrivingTimePerMin * breakTimePerMin) +
                                    parseFloat(totalMinModMaximumDrivingTimePerMin);

                            }


                        } else {

                            if (parseFloat(totalMinModMaximumDrivingTimePerMin) < parseFloat(additionalTimeAllowedPerMin)) {
                                var totalDurationPerMin =
                                    (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                                    ((totalMinDivMaximumDrivingTimePerMin - 1) * breakTimePerMin) +
                                    parseFloat(totalMinModMaximumDrivingTimePerMin);
                            } else {
                                var totalDurationPerMin =
                                    (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                                    (totalMinDivMaximumDrivingTimePerMin * breakTimePerMin) +
                                    parseFloat(totalMinModMaximumDrivingTimePerMin);
                            }

                        }

                    } else {

                        var totalDurationPerMin = parseFloat(precedentTempsRestant) +
                            parseFloat(breakTimePerMin) + parseFloat(totalMin);


                    }
                } else {
                    var tempRestant = parseFloat(precedentTempsRestant) - parseFloat(totalMin);
                    jQuery("#tempRestant" + '' + num + '').val(tempRestant);
                    var totalDurationPerMin = parseFloat(totalMin);
                }
            } else {
                var numPrecedent = num - 1;
                var precedentTempsRestant = jQuery('#tempRestant' + '' + numPrecedent + '').val();

                if (parseFloat(totalMin) > parseFloat(precedentTempsRestant)) {
                    totalMin = totalMin - precedentTempsRestant;
                    var totalMinDivMaximumDrivingTimePerMin = (totalMin / maximumDrivingTimePerMin);
                    totalMinDivMaximumDrivingTimePerMin = parseInt(totalMinDivMaximumDrivingTimePerMin);
                    var totalMinModMaximumDrivingTimePerMin = (totalMin % maximumDrivingTimePerMin);
                    var tempRestant = maximumDrivingTimePerMin - totalMinModMaximumDrivingTimePerMin;
                    jQuery("#tempRestant" + '' + num + '').val(tempRestant);

                    if (parseFloat(totalMinDivMaximumDrivingTimePerMin) > 0) {
                        if (parseFloat(totalMinModMaximumDrivingTimePerMin) < parseFloat(additionalTimeAllowedPerMin)) {
                            var totalDurationPerMin = parseFloat(precedentTempsRestant) + parseFloat(breakTimePerMin) +
                                (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                                ((totalMinDivMaximumDrivingTimePerMin - 1) * breakTimePerMin) +
                                parseFloat(totalMinModMaximumDrivingTimePerMin);
                        } else {
                            var totalDurationPerMin = parseFloat(precedentTempsRestant) + parseFloat(breakTimePerMin) +
                                (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                                (totalMinDivMaximumDrivingTimePerMin * breakTimePerMin) +
                                parseFloat(totalMinModMaximumDrivingTimePerMin);
                        }

                    } else {

                        var totalDurationPerMin = parseFloat(precedentTempsRestant) + parseFloat(breakTimePerMin) + parseFloat(totalMin);

                    }
                } else {
                    var tempRestant = parseFloat(precedentTempsRestant) - parseFloat(totalMin);
                    jQuery("#tempRestant" + '' + num + '').val(tempRestant);
                    var totalDurationPerMin = parseFloat(totalMin);
                }
            }

            var nbHour = totalDurationPerMin / 60;
            nbHour = parseInt(nbHour);
            var nbMin = totalDurationPerMin % 60;
            var nbDay = nbHour / 24;
            nbDay = parseInt(nbDay);
            nbHour = nbHour % 24;
            nb_day = nbDay;
            nb_hour = nbHour;
            nb_min = nbMin;
            var dayOfMonth = myDate.getDate();
            myDate.setDate(dayOfMonth + nb_day);
            var dayOfMonth = myDate.getHours();
            myDate.setHours(dayOfMonth + nb_hour);
            var dayOfMonth = myDate.getMinutes();
            myDate.setMinutes(dayOfMonth + nb_min);
            var dayOfMonth = myDate.getMonth();
            day = myDate.getDate();
            day = parseInt(day);
            if (day >= 0 && day < 10) {

                day = '0' + day;
            }
            month = myDate.getMonth();
            year = myDate.getFullYear();
            hour = myDate.getHours();
            hour = parseInt(hour);
            if (hour >= 0 || hour <= 10) {
                hour = '0' + hour;
            }
            min = myDate.getMinutes();
            min = parseInt(min);
            if (min >= 0 && min <= 10) {
                min = '0' + min;
            }
            switch (month) {
                case 0:
                    var valMonth = '01';
                    break;
                case 1:
                    var valMonth = '02';
                    break;
                case 2:
                    var valMonth = '03';
                    break;
                case 3:
                    var valMonth = '04';
                    break;
                case 4:
                    var valMonth = '05';
                    break;
                case 5:
                    var valMonth = '06';
                    break;
                case 6:
                    var valMonth = '07';
                    break;
                case 7:
                    var valMonth = '08';
                    break;
                case 8:
                    var valMonth = '09';
                    break;
                case 9:
                    var valMonth = '10';
                    break;
                case 10:
                    var valMonth = '11';
                    break;
                case 11:
                    var valMonth = '12';
                    break;
            }
            end_date = day + "/" + valMonth + "/" + year + " " + hour + ":" + min;
            jQuery("#planned_end_date" + '' + num + '').val(end_date);
            calculateDateArrivalParc(id);
        }
    }

    function calculPlannedDepartureDate(id) {

        //var num = id.substring(id.length - 1, id.length);

        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(6, trId.length);

        var detail_ride = parseInt(jQuery("#detail_ride" + '' + num + '').val());

        if (detail_ride > 0) {
            var numPrecedent = num - 1;
            if (jQuery("#real_end_date" + '' + numPrecedent + '').val()) {
                var s_arr = jQuery("#real_end_date" + '' + numPrecedent + '').val().split(/\/|\s|:/);
            } else {
                var s_arr = jQuery("#planned_end_date" + '' + numPrecedent + '').val().split(/\/|\s|:/);
            }
            var myDate = new Date(s_arr[1] + "," + s_arr[0] + "," + s_arr[2] + "," + s_arr[3] + ":" + s_arr[4] + ":00");

            var averageSpeed = jQuery('#average_speed').val();
            if (parseFloat(averageSpeed) > 0) {
                var averageSpeedPerMin = parseFloat(averageSpeed) / 60;
                var distance = jQuery('#distance_between' + '' + num + '').val();
                var totalMin = parseFloat(distance) / parseFloat(averageSpeedPerMin);
            } else {

                var nb_day = parseInt(jQuery("#duration_day_between" + '' + num + '').val());
                var nb_hour = parseInt(jQuery("#duration_hour_between" + '' + num + '').val());
                var nb_min = parseInt(jQuery("#duration_minute_between" + '' + num + '').val());
                var totalMin = (24 * 60 * nb_day) + (60 * nb_hour) + nb_min;

            }
            var loadingTimePerMin = parseFloat(jQuery('#param_loading_time').val()) * 60;
            var unloadingTimePerMin = parseFloat(jQuery('#param_unloading_time').val()) * 60;
            var maximumDrivingTimePerMin = parseFloat(jQuery('#param_maximum_driving_time').val()) * 60;
            var breakTimePerMin = parseFloat(jQuery('#param_break_time').val()) * 60;
            var additionalTimeAllowedPerMin = parseFloat(jQuery('#param_additional_time_allowed').val()) * 60;
            var precedentTempsRestant = jQuery('#tempRestant' + '' + numPrecedent + '').val();

            if (parseFloat(totalMin) > parseFloat(precedentTempsRestant)) {
                totalMin = totalMin - precedentTempsRestant;
                var totalMinDivMaximumDrivingTimePerMin = (totalMin / maximumDrivingTimePerMin);
                totalMinDivMaximumDrivingTimePerMin = parseInt(totalMinDivMaximumDrivingTimePerMin);
                var totalMinModMaximumDrivingTimePerMin = (totalMin % maximumDrivingTimePerMin);
                var tempRestant = maximumDrivingTimePerMin - totalMinModMaximumDrivingTimePerMin;
                jQuery("#tempRestant" + '' + num + '').val(tempRestant);

                if (parseFloat(totalMinDivMaximumDrivingTimePerMin) > 0) {

                    if (parseFloat(totalMinModMaximumDrivingTimePerMin) < parseFloat(additionalTimeAllowedPerMin)) {
                        var totalDurationPerMin = parseFloat(precedentTempsRestant) + parseFloat(breakTimePerMin) + parseFloat(loadingTimePerMin) +
                            (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                            ((totalMinDivMaximumDrivingTimePerMin - 1) * breakTimePerMin) +
                            parseFloat(totalMinModMaximumDrivingTimePerMin) + parseFloat(unloadingTimePerMin);
                    } else {
                        var totalDurationPerMin = parseFloat(precedentTempsRestant) + parseFloat(breakTimePerMin) + parseFloat(loadingTimePerMin) +
                            (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                            (totalMinDivMaximumDrivingTimePerMin * breakTimePerMin) +
                            parseFloat(totalMinModMaximumDrivingTimePerMin) + parseFloat(unloadingTimePerMin);
                    }

                } else {
                    var totalDurationPerMin = parseFloat(precedentTempsRestant) + parseFloat(loadingTimePerMin) + parseFloat(totalMin) + parseFloat(unloadingTimePerMin);
                }
            } else {
                var tempRestant = parseFloat(precedentTempsRestant) - parseFloat(totalMin);
                jQuery("#tempRestant" + '' + num + '').val(tempRestant);
                var totalDurationPerMin = parseFloat(loadingTimePerMin) + parseFloat(totalMin) + parseFloat(unloadingTimePerMin);
            }


            var nbHour = totalDurationPerMin / 60;
            nbHour = parseInt(nbHour);
            var nbMin = totalDurationPerMin % 60;
            var nbDay = nbHour / 24;
            nbDay = parseInt(nbDay);
            nbHour = nbHour % 24;
            nb_day = nbDay;
            nb_hour = nbHour;
            nb_min = nbMin;
            var dayOfMonth = myDate.getDate();
            myDate.setDate(dayOfMonth + nb_day);
            var dayOfMonth = myDate.getHours();
            myDate.setHours(dayOfMonth + nb_hour);
            var dayOfMonth = myDate.getMinutes();
            myDate.setMinutes(dayOfMonth + nb_min);
            var dayOfMonth = myDate.getMonth();
            day = myDate.getDate();
            day = parseInt(day);
            if (day >= 0 && day < 10) {

                day = '0' + day;
            }
            month = myDate.getMonth();
            year = myDate.getFullYear();
            hour = myDate.getHours();
            hour = parseInt(hour);
            if (hour >= 0 && hour <= 10) {
                hour = '0' + hour;
            }
            min = myDate.getMinutes();
            min = parseInt(min);
            if (min >= 0 && min <= 10) {
                min = '0' + min;
            }
            switch (month) {
                case 0:
                    var valMonth = '01';
                    break;
                case 1:
                    var valMonth = '02';
                    break;
                case 2:
                    var valMonth = '03';
                    break;
                case 3:
                    var valMonth = '04';
                    break;
                case 4:
                    var valMonth = '05';
                    break;
                case 5:
                    var valMonth = '06';
                    break;
                case 6:
                    var valMonth = '07';
                    break;
                case 7:
                    var valMonth = '08';
                    break;
                case 8:
                    var valMonth = '09';
                    break;
                case 9:
                    var valMonth = '10';
                    break;
                case 10:
                    var valMonth = '11';
                    break;
                case 11:
                    var valMonth = '12';
                    break;
            }
            var start_date = day + "/" + valMonth + "/" + year + " " + hour + ":" + min;
            jQuery("#planned_start_date" + '' + num + '').val(start_date);
            calculPlannedArrivalDate(id);

        }
    }


    function calculKmArrivalEstimated(id) {
       // var num = id.substring(id.length - 1, id.length);

        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(6, trId.length);

        var distance = jQuery('#distance' + '' + num + '').val();
        var km_departure = jQuery('#km_departure' + '' + num + '').val();
        if (km_departure >= 0 && distance >= 0) {
            var km_estimated = parseFloat(km_departure) + parseFloat(distance);
            jQuery('#km_arrival_estimated' + '' + num + '').val(km_estimated);
            calculateKmArrivalParc(id);
        }
    }

    function calculKmDeparture(id) {

        //var num = id.substring(id.length - 1, id.length);
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(6, trId.length);
        var distance = jQuery('#distance_between' + '' + num + '').val();
        var numPrecedent = num - 1;
        if (jQuery('#km_arrival' + '' + num + '').val() > 0) {
            var km_arrival = jQuery('#km_arrival' + '' + numPrecedent + '').val();
        } else {
           var  km_arrival = jQuery('#km_arrival_estimated' + '' + numPrecedent + '').val();
        }

        if (km_arrival >= 0 && distance >= 0) {
            var km_departure = parseFloat(km_arrival) + parseFloat(distance);
            jQuery('#km_departure' + '' + num + '').val(km_departure);
            calculKmArrivalEstimated(id);
        }
    }

    function getInformationRide(id) {
        //var num = id.substring(id.length - 1, id.length);
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(6, trId.length);
        console.log(num);
        var ride_id = jQuery("#detail_ride" + '' + num + '').val();

        if (ride_id != '') {

        if (jQuery('#source1' + '' + num + '').prop('checked') || jQuery('#source2' + '' + num + '').prop('checked')) {

            var transport_bill_detail_ride_id = jQuery('#detail_ride' + '' + num + '').val();

            jQuery('#transport_bill_detail_ride' + '' + num + '').val(transport_bill_detail_ride_id);
            var from_customer_order = 1;
            var arrival_from_customer_order = 1;
            jQuery('#client-initial-div' + '' + num + '').load('<?php echo $this->Html->url('/sheetRides/getClientInitialFromCustomerOrder/')?>' + ride_id + '/' + num, function () {

                getMarchandisesByClient(id);
                getAttachmentsByClient(id);
            });

            jQuery('#client-final-div' + '' + num + '').load('<?php echo $this->Html->url('/sheetRides/getClientFinalFromCustomerOrder/')?>' + ride_id + '/' + num);

        } else {

            /*   jQuery('#client-initial-div' + '' + num + '').load('php echo $this->Html->url('/sheetRides/getClientInitial/')?>' + num, function () {
                $('.select-search-client-initial').select2({
                    ajax: {
                        url: "php echo $this->Html->url('/suppliers/getInitialSuppliersByKeyWord')?>",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: $.trim(params.term)
                            };
                        },
                        processResults: function (data, page) {
                            return {results: data};
                        },
                        cache: true
                    },
                    minimumInputLength: 2

                });
            });
            jQuery('#client-final-div' + '' + num + '').load('php echo $this->Html->url('/sheetRides/getClientFinal/')?>' + num); */
            /*  si le trajet personnalisé a été choisi*/
            if (jQuery('#source4' + '' + num + '').prop('checked')) {
                var from_customer_order = 4;
                var arrival_from_customer_order = 4;
                var ride_id = 0;
            } else {
                var from_customer_order = 0;
                var arrival_from_customer_order = 0;
            }
        }
        if (jQuery("#ride_category" + '' + num + '').val()) {
            var ride_category_id = jQuery("#ride_category" + '' + num + '').val();
        } else {
            var ride_category_id = 0;
        }

        jQuery('#mission-cost-div' + '' + num + '').load('<?php echo $this->Html->url('/sheetRides/getMissionCost/')?>' + ride_id + '/' + num + '/' + from_customer_order + '/' + ride_category_id);

        if (jQuery('#truck_full1' + '' + num + '').prop('checked')) {
            var truck_full = 1;
        } else {
            var truck_full = 2;
        }

        if (ride_id == 0 || ride_id =='' || typeof ride_id === 'undefined') {
            var departure_destination_id = jQuery("#departure_destination" + '' + num + '').val();
            var arrival_destination_id = jQuery("#arrival_destination" + '' + num + '').val();
            var carTypeId = jQuery('#car_type').val();

        } else {
            var departure_destination_id = 0;
            var arrival_destination_id = 0;
        }
        jQuery('#distance_duration_ride' + '' + num + '').load(
            '<?php echo $this->Html->url('/sheetRides/getInformationRide/')?>' + ride_id + '/' + num + '/' + from_customer_order + '/' + truck_full + '/' + ride_category_id + '/' + departure_destination_id + '/' + arrival_destination_id+'/'+carTypeId,
            function () {
                if (num == 1) {

                    if (ride_id == 0) {
                        if (jQuery("#origin_wilaya").val() != "" && jQuery("#destinationName1").val() != "") {

                            var calculByMaps = jQuery('#calcul_maps').val();
                            if (calculByMaps == 1) {
                                calculateDistanceAndDurationCompanyFirstRide(jQuery("#origin_wilaya").val(), jQuery("#destinationName1").val());
                                calculateKmArrivalParc('km_arrival1');
                            }
                        }
                    } else {
                        if (jQuery("#origin_wilaya").val() != "" && jQuery("#destinationName").val() != "") {
                            var calculByMaps = jQuery('#calcul_maps').val();
                            if (calculByMaps == 1) {
                                calculateDistanceAndDurationCompanyFirstRide(jQuery("#origin_wilaya").val(), jQuery("#destinationName").val());
                                calculateKmArrivalParc('km_arrival1');
                            }
                        }
                    }

                }
                if (ride_id == 0) {
                    var calculByMaps = jQuery('#calcul_maps').val();
                    if (calculByMaps == 1) {
                        calculateDistanceAndDurationBetweenTwoDestination(num);
                    }
                }
                var num_dep = num - 1;
                if (jQuery('#source1' + '' + num_dep + '').prop('checked') || jQuery('#source2' + '' + num_dep + '').prop('checked')) {
                    var departure_from_customer_order = 1;

                } else {
                    var departure_from_customer_order = 0;
                }
                var detail_ride_departure = jQuery('#detail_ride' + '' + num_dep + '').val();
                var detail_ride_arrival = jQuery('#detail_ride' + '' + num + '').val();

                jQuery('#ride_between_two_ride' + '' + num + '').load('<?php echo $this->Html->url('/sheetRides/getDetailRideBetweenTwoRide/')?>' + num + '/' + detail_ride_departure + '/' + detail_ride_arrival + '/' + departure_from_customer_order + '/' + arrival_from_customer_order, function () {

                    if ((jQuery('#departure' + '' + num + '').val() != "") && (jQuery('#arrival' + '' + num + '').val() != "")) {
                        var calculByMaps = jQuery('#calcul_maps').val();
                        if (calculByMaps == 1) {
                            var origin = jQuery('#departure' + '' + num + '').val();
                            var destination = jQuery('#arrival' + '' + num + '').val();
                            var directionsService = new google.maps.DirectionsService();
                            var directionsDisplay = new google.maps.DirectionsRenderer();
                            var request = {
                                origin: origin,
                                destination: destination,
                                travelMode: google.maps.DirectionsTravelMode.DRIVING
                            };
                            directionsService.route(request, function (response, status) {
                                if (status == google.maps.DirectionsStatus.OK) {
                                    // Display the distance:
                                    distance = parseInt(response.routes[0].legs[0].distance.value) / 1000;
                                    distance = parseInt(distance);
                                    jQuery('#distance_between' + '' + num + '').val(distance);
                                    // Display the duration:
                                    tmp = response.routes[0].legs[0].duration.value;
                                    var diff = {}
                                    diff.sec = tmp % 60;                    // Extraction du nombre de secondes
                                    tmp = Math.floor((tmp - diff.sec) / 60);    // Nombre de minutes (partie entière)
                                    diff.min = tmp % 60;                    // Extraction du nombre de minutes
                                    diff.min = parseInt(diff.min);
                                    tmp = Math.floor((tmp - diff.min) / 60);    // Nombre d'heures (entières)
                                    diff.hour = tmp % 24;                   // Extraction du nombre d'heures
                                    diff.hour = parseInt(diff.hour);
                                    tmp = Math.floor((tmp - diff.hour) / 24);   // Nombre de jours restants
                                    diff.day = tmp;
                                    diff.day = parseInt(diff.day);
                                    nb_day = diff.day;
                                    nb_hour = diff.hour;
                                    nb_min = diff.min;

                                    jQuery('#duration_day_between' + '' + num + '').val(nb_day);
                                    jQuery('#duration_hour_between' + '' + num + '').val(nb_hour);
                                    jQuery('#duration_minute_between' + '' + num + '').val(nb_min);

                                    calculPlannedDepartureDate(id);
                                    //calculKmDeparture(id);
                                    //calculPlannedArrivalDate(id);
                                    //calculKmArrivalEstimated(id);
                                }
                            });
                        }
                    } else {
                        calculPlannedDepartureDate(id);
                        //calculKmDeparture(id);
                        //calculPlannedArrivalDate(id);
                        //calculKmArrivalEstimated(id);
                    }
                });
                calculateKmArrivalParc(id);
                // estimateCost();
            });

            if (jQuery('#car_subcontracting1').prop('checked')){

            var carId = jQuery('#cars').val();

            jQuery('#cost_contractor_div' + '' + num + '').load('<?php echo $this->Html->url('/sheetRides/getContractCostByDetailRide/')?>' + ride_id + '/' + num + '/' + from_customer_order + '/' + carId, function () {
                jQuery('#reservation_cost' + '' + num + '').parent().attr('class', 'input number required');
                }
            );


            }
    }else {
            jQuery('#client-initial-div' + '' + num + '').load('<?php echo $this->Html->url('/sheetRides/getClientInitial/')?>' + num, function () {
                $('.select-search-client-initial').select2({
                    ajax: {
                        url: "<?php echo $this->Html->url('/suppliers/getInitialSuppliersByKeyWord')?>",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: $.trim(params.term)
                            };
                        },
                        processResults: function (data, page) {
                            return {results: data};
                        },
                        cache: true
                    },
                    minimumInputLength: 2

                });
            });
            jQuery('#client-final-div' + '' + num + '').load('<?php echo $this->Html->url('/sheetRides/getClientFinal/')?>' + num);

            jQuery('#distance_duration_ride' + '' + num + '').load(
                '<?php echo $this->Html->url('/sheetRides/getInformationRide/')?>' + 0 + '/' + num + '/' + from_customer_order + '/' + truck_full + '/' + 0 + '/' + 0 + '/' + 0,
                function () {});
        }
    }

    function getMissionCost(id) {
        //var num = id.substring(id.length - 1, id.length);
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(6, trId.length);
        var rideId = jQuery("#detail_ride" + '' + num + '').val();

        if (jQuery("#ride_category" + '' + num + '').val()) {

            var rideCategoryId = jQuery("#ride_category" + '' + num + '').val();
        } else {

            var rideCategoryId = '';
        }
        if (jQuery('#source1' + '' + num + '').prop('checked')) {
            var fromCustomerOrder = 1;

        } else {
            var fromCustomerOrder = 0;
        }
        jQuery('#mission-cost-div' + '' + num + '').load('<?php echo $this->Html->url('/sheetRides/getMissionCost/')?>' + rideId + '/' + num + '/' + fromCustomerOrder + '/' + rideCategoryId);
    }

    function addFile(id) {

        var j = jQuery('#nb_attachment' + '' + id + '').val();

        j++;
        jQuery('#nb_attachment' + '' + id + '').val(j);
        if (j < 6) {

            $("#dynamic_field" + '' + id + '').append('<tr id="row' + j + '"><td class="td-input"><div  id="attachment' + '' + id + '' + j + '-file" ><div class="form-group input-button"><div class="input file"><label for ="att' + '' + id + '' + j + '"><?php echo __('Attachments');?></label><input id="att' + '' + id + '' + j + '" class="form-filter" name="data[SheetRideDetailRides][<?php echo $i?>][attachment][]"  type="file"/></div></div> <span class="popupactions"><button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id="attachment' + '' + id + '' + j + '-btn" type="button" onclick="delete_file(\'attachment' + '' + id + '' + j + '\');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button></span></div></td><td class="td_tab"><button style="margin-left: 40px;" name="remove" id="' + '' + id + '' + j + '" onclick="remove(\'' + '' + id + '' + j + '\');"class="btn btn-danger btn_remove">X</button></td></tr>');
            if (j == 5) $('#add').css('display', 'none');
        }
    }


    function remove(id) {


        $('#row' + id + '').remove();
        j--;
        $('#add').css('display', 'inline-block');

    }


    function delete_file(id) {


        $("#" + '' + id + '' + "-file").before(
            function () {
                if (!$(this).prev().hasClass('input-ghost')) {
                    var element = $("<input type='file' class='input-ghost' style='display: none; visibility:hidden; height:0'>");
                    element.attr("name", $(this).attr("name"));
                    element.change(function () {
                        element.next(element).find('input').val((element.val()).split('\\').pop());
                    });

                    $(this).find("#" + '' + id + '' + "-btn").click(function () {
                        element.val(null);
                        $(this).parents("#" + '' + id + '' + "-file").find('input').val('');
                    });
                    $(this).find('input').css("cursor", "pointer");
                    /*$(this).find('input').mousedown(function() {
                     $(this).parents("#"+''+id+''+"-file").prev().click();
                     return false;
                     });*/
                    return element;
                }
            }
        );
    }

    function getRidesFromCustomerOrder(id) {
       // var i = id.substring(id.length - 1, id.length);
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var i = trId.substring(6, trId.length);

        jQuery('#ride-div' + '' + i + '').addClass('select-inline2');
        var type_id = jQuery("#car_type").val();
        jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getRidesFromCustomerOrder/')?>' + i + '/' + type_id, function () {
            jQuery('.select3').select2();
        });
    }

    function getPersonalizedRidesFromCustomerOrder(id) {
        //var i = id.substring(id.length - 1, id.length);
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var i = trId.substring(6, trId.length);

        jQuery('#ride-div' + '' + i + '').addClass('select-inline2');
        var typeId = jQuery("#car_type").val();
        jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getPersonalizedRidesFromCustomerOrder/')?>' + i + '/' + typeId, function () {

            jQuery('.select3').select2();
        });
    }

    function getRidesByType(id) {

        //var i = id.substring(id.length - 1, id.length);
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var i = trId.substring(6, trId.length);

        jQuery('#ride-div' + '' + i + '').addClass('select-inline2');
        var type_id = jQuery("#car_type").val();
        if (type_id == '') type_id = 0;
        jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getRidesByType/')?>' + i + '/' + type_id, function () {
            $('.select-search-detail-ride').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/detailRides/getDetailRidesByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            carTypeId: jQuery('#car_type').val()
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 3
            });

        });
        jQuery('#client-initial-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getClientInitial/')?>' + i, function () {
            $('.select-search-client-initial').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/suppliers/getInitialSuppliersByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2

            });
        });

        jQuery('#client-final-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getClientFinal/')?>' + i);
    }

    function getPersonalizedRide(id) {
        //var i = id.substring(id.length - 1, id.length);
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var i = trId.substring(6, trId.length);
        jQuery('#ride-div' + '' + i + '').removeClass('select-inline2');
        jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getPersonalizedRide/')?>' + i, function () {
            $('.select-search-destination').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/destinations/getDestinationsByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 3

            });

        });
        jQuery('#client-initial-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getClientInitial/')?>' + i, function () {
            $('.select-search-client-initial').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/suppliers/getInitialSuppliersByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2

            });
        });

        jQuery('#client-final-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getClientFinal/')?>' + i);
    }


    function calculateDateArrivalParc(id) {

        //var num = id.substring(id.length - 1, id.length);
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(6, trId.length);

        var nb_ride = parseFloat(jQuery('#nb_ride').val());

        // Verify if is the last ride
        if (num == nb_ride) {
            // get ride detail's ID
            // know if sheetride is from order or direct add
            if (jQuery('#source1' + '' + num + '').prop('checked') || jQuery('#source2' + '' + num + '').prop('checked')) {

                var from_customer_order = 1;
                var detail_ride = jQuery('#detail_ride' + '' + num + '').val();
                if (detail_ride == '') {
                    detail_ride = 0;
                }
                var arrivalDestinationId = 0;
            } else {
                if (jQuery('#source4' + '' + num + '').prop('checked')) {
                    var from_customer_order = 3;
                    var detail_ride = 0;
                    var arrivalDestinationId = jQuery('#arrival_destination' + '' + num + '').val();
                } else {
                    var from_customer_order = 0;
                    var detail_ride = jQuery('#detail_ride' + '' + num + '').val();
                    if (detail_ride == '') {
                        detail_ride = 0;
                    }
                    var arrivalDestinationId = 0;
                }
            }
            jQuery("#duration-retour-parc").load('<?php echo $this->Html->url('/sheetRides/getDurationReturnToParc/')?>' + detail_ride + '/' + from_customer_order + '/' + arrivalDestinationId, function () {


                // get last mission's arrival date


                if (jQuery("#real_end_date" + '' + num + '').val()) {

                    var s_arr = jQuery("#real_end_date" + '' + num + '').val().split(/\/|\s|:/);
                } else {

                    var s_arr = jQuery("#planned_end_date" + '' + num + '').val().split(/\/|\s|:/);
                }
                myDate = new Date(s_arr[1] + "," + s_arr[0] + "," + s_arr[2] + "," + s_arr[3] + ":" + s_arr[4] + ":00");
                // ze have not duration informations for this ride detail storeed in database
                if ((jQuery('#origin_duration_retour').val() != "") && (jQuery('#destination_duration_retour').val() != "")) {
                    var calculByMaps = jQuery('#calcul_maps').val();
                    if (calculByMaps == 1) {
                        var origin = jQuery('#origin_duration_retour').val();
                        var destination = jQuery('#destination_duration_retour').val();
                        var directionsService = new google.maps.DirectionsService();
                        //var directionsDisplay = new google.maps.DirectionsRenderer();
                        var request = {
                            origin: origin,
                            destination: destination,
                            travelMode: google.maps.DirectionsTravelMode.DRIVING
                        };

                        directionsService.route(request, function (response, status) {
                            if (status == google.maps.DirectionsStatus.OK) {

                                // Display the duration:

                                tmp = response.routes[0].legs[0].duration.value;
                                var diff = {}
                                diff.sec = tmp % 60;                    // Extraction du nombre de secondes
                                tmp = Math.floor((tmp - diff.sec) / 60);    // Nombre de minutes (partie entière)
                                diff.min = tmp % 60;                    // Extraction du nombre de minutes
                                diff.min = parseInt(diff.min);
                                jQuery('#duration_minute_retour').val(diff.min);
                                tmp = Math.floor((tmp - diff.min) / 60);    // Nombre d'heures (entières)
                                diff.hour = tmp % 24;                   // Extraction du nombre d'heures
                                diff.hour = parseInt(diff.hour);
                                jQuery('#duration_hour_retour').val(diff.hour);
                                tmp = Math.floor((tmp - diff.hour) / 24);   // Nombre de jours restants
                                diff.day = tmp;
                                diff.day = parseInt(diff.day);
                                jQuery('#duration_day_retour').val(diff.day);
                                nb_day = diff.day;
                                nb_hour = diff.hour;
                                nb_min = diff.min;
                                var totalMin = (24 * 60 * nb_day) + (60 * nb_hour) + nb_min;

                                var maximumDrivingTimePerMin = parseFloat(jQuery('#param_maximum_driving_time').val()) * 60;
                                var breakTimePerMin = parseFloat(jQuery('#param_break_time').val()) * 60;
                                var additionalTimeAllowedPerMin = parseFloat(jQuery('#param_additional_time_allowed').val()) * 60;
                                var unloadingTimePerMin = parseFloat(jQuery('#param_unloading_time').val()) * 60;
                                //var numPrecedent = num - 1;
                                var precedentTempsRestant = jQuery('#tempRestant' + '' + num + '').val();

                                if (parseFloat(totalMin) > parseFloat(precedentTempsRestant)) {
                                    totalMin = totalMin - precedentTempsRestant;
                                    var totalMinDivMaximumDrivingTimePerMin = (totalMin / maximumDrivingTimePerMin);
                                    totalMinDivMaximumDrivingTimePerMin = parseInt(totalMinDivMaximumDrivingTimePerMin);
                                    var totalMinModMaximumDrivingTimePerMin = (totalMin % maximumDrivingTimePerMin);


                                    if (parseFloat(totalMinDivMaximumDrivingTimePerMin) > 0) {
                                        if (parseFloat(totalMinModMaximumDrivingTimePerMin) < parseFloat(additionalTimeAllowedPerMin)) {
                                            var totalDurationPerMin = parseFloat(precedentTempsRestant) + parseFloat(breakTimePerMin) +
                                                (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                                                ((totalMinDivMaximumDrivingTimePerMin - 1) * breakTimePerMin) +
                                                parseFloat(totalMinModMaximumDrivingTimePerMin) + parseFloat(unloadingTimePerMin);
                                        } else {
                                            var totalDurationPerMin = parseFloat(precedentTempsRestant) + parseFloat(breakTimePerMin) +
                                                (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                                                (totalMinDivMaximumDrivingTimePerMin * breakTimePerMin) +
                                                parseFloat(totalMinModMaximumDrivingTimePerMin) + parseFloat(unloadingTimePerMin);
                                        }

                                    } else {

                                        var totalDurationPerMin = parseFloat(precedentTempsRestant) +
                                            parseFloat(breakTimePerMin) +
                                            parseFloat(totalMin) + parseFloat(unloadingTimePerMin);

                                    }
                                } else {

                                    var totalDurationPerMin = parseFloat(totalMin) + parseFloat(unloadingTimePerMin);

                                }

                                var nbHour = totalDurationPerMin / 60;
                                nbHour = parseInt(nbHour);
                                var nbMin = totalDurationPerMin % 60;
                                var nbDay = nbHour / 24;
                                nbDay = parseInt(nbDay);
                                nbHour = nbHour % 24;
                                nb_day = nbDay;
                                nb_hour = nbHour;
                                nb_min = nbMin;


                                var dayOfMonth = myDate.getDate();

                                myDate.setDate(dayOfMonth + nb_day);

                                var dayOfMonth = myDate.getHours();

                                myDate.setHours(dayOfMonth + nb_hour);

                                var dayOfMonth = myDate.getMinutes();

                                myDate.setMinutes(dayOfMonth + nb_min);

                                var dayOfMonth = myDate.getMonth();

                                //myDate.setMonth(dayOfMonth + 1);

                                day = myDate.getDate();
                                day = parseInt(day);
                                month = myDate.getMonth();
                                month = parseInt(month);
                                year = myDate.getFullYear();
                                year = parseInt(year);
                                hour = myDate.getHours();

                                hour = parseInt(hour);
                                if (hour >= 0 && hour <= 10) {
                                    hour = '0' + hour;
                                }
                                min = myDate.getMinutes();
                                min = parseInt(min);
                                if (min >= 0 && min < 10) {

                                    min = '0' + min;
                                }
                                if (day >= 0 && day < 10) {

                                    day = '0' + day;
                                }

                                switch (month) {
                                    case 0:
                                        var valMonth = '01';
                                        break;
                                    case 1:
                                        var valMonth = '02';
                                        break;
                                    case 2:
                                        var valMonth = '03';
                                        break;
                                    case 3:
                                        var valMonth = '04';
                                        break;
                                    case 4:
                                        var valMonth = '05';
                                        break;
                                    case 5:
                                        var valMonth = '06';
                                        break;
                                    case 6:
                                        var valMonth = '07';
                                        break;
                                    case 7:
                                        var valMonth = '08';
                                        break;
                                    case 8:
                                        var valMonth = '09';
                                        break;
                                    case 9:
                                        var valMonth = '10';
                                        break;
                                    case 10:
                                        var valMonth = '11';
                                        break;
                                    case 11:
                                        var valMonth = '12';
                                        break;

                                }
                                end_date = day + "/" + valMonth + "/" + year + " " + hour + ":" + min;

                                jQuery("#end_date1").val(end_date);
                            }
                        });

                    }
                } else {
                    var averageSpeed = jQuery('#average_speed').val();
                    if (averageSpeed > 0) {
                        var averageSpeedPerMin = parseFloat(averageSpeed) / 60;
                        var distance = jQuery('#distance_retour').val();
                        var totalMin = parseFloat(distance) / parseFloat(averageSpeedPerMin);
                    } else {

                        nb_day = parseInt(jQuery('#duration_day_retour').val());
                        nb_hour = parseInt(jQuery('#duration_hour_retour').val());
                        nb_min = parseInt(jQuery('#duration_minute_retour').val());
                        var totalMin = (24 * 60 * nb_day) + (60 * nb_hour) + nb_min;

                    }
                    var maximumDrivingTimePerMin = parseFloat(jQuery('#param_maximum_driving_time').val()) * 60;
                    var breakTimePerMin = parseFloat(jQuery('#param_break_time').val()) * 60;
                    var additionalTimeAllowedPerMin = parseFloat(jQuery('#param_additional_time_allowed').val()) * 60;
                    var unloadingTimePerMin = parseFloat(jQuery('#param_unloading_time').val()) * 60;
                    // var numPrecedent = num - 1;
                    var precedentTempsRestant = jQuery('#tempRestant' + '' + num + '').val();

                    if (parseFloat(totalMin) > parseFloat(precedentTempsRestant)) {
                        totalMin = totalMin - precedentTempsRestant;

                        var totalMinDivMaximumDrivingTimePerMin = (totalMin / maximumDrivingTimePerMin);

                        totalMinDivMaximumDrivingTimePerMin = parseInt(totalMinDivMaximumDrivingTimePerMin);
                        var totalMinModMaximumDrivingTimePerMin = (totalMin % maximumDrivingTimePerMin);

                        if (totalMinDivMaximumDrivingTimePerMin > 0) {
                            if (parseFloat(totalMinModMaximumDrivingTimePerMin) < parseFloat(additionalTimeAllowedPerMin)) {
                                var totalDurationPerMin = parseFloat(precedentTempsRestant) + parseFloat(breakTimePerMin) +
                                    (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                                    ((totalMinDivMaximumDrivingTimePerMin - 1) * breakTimePerMin) +
                                    parseFloat(totalMinModMaximumDrivingTimePerMin) + parseFloat(unloadingTimePerMin);

                            } else {
                                var totalDurationPerMin = parseFloat(precedentTempsRestant) + parseFloat(breakTimePerMin) +
                                    (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                                    (totalMinDivMaximumDrivingTimePerMin * breakTimePerMin) +
                                    parseFloat(totalMinModMaximumDrivingTimePerMin) + parseFloat(unloadingTimePerMin);
                            }

                        } else {

                            var totalDurationPerMin = parseFloat(precedentTempsRestant) +
                                parseFloat(breakTimePerMin) + parseFloat(totalMin) + parseFloat(unloadingTimePerMin);


                        }
                    } else {
                        var totalDurationPerMin = parseFloat(totalMin) + parseFloat(unloadingTimePerMin);
                    }

                    var nbHour = totalDurationPerMin / 60;
                    nbHour = parseInt(nbHour);
                    var nbMin = totalDurationPerMin % 60;
                    var nbDay = nbHour / 24;
                    nbDay = parseInt(nbDay);
                    nbHour = nbHour % 24;
                    nb_day = nbDay;
                    nb_hour = nbHour;
                    nb_min = nbMin;

                    var dayOfMonth = myDate.getDate();

                    myDate.setDate(dayOfMonth + nb_day);

                    var dayOfMonth = myDate.getHours();

                    myDate.setHours(dayOfMonth + nb_hour);
                    var dayOfMonth = myDate.getMinutes();

                    myDate.setMinutes(dayOfMonth + nb_min);

                    var dayOfMonth = myDate.getMonth();

                    //myDate.setMonth(dayOfMonth + 1);

                    day = myDate.getDate();
                    day = parseInt(day);
                    month = myDate.getMonth();
                    month = parseInt(month);
                    year = myDate.getFullYear();
                    year = parseInt(year);
                    hour = myDate.getHours();

                    hour = parseInt(hour);
                    if (hour >= 0 && hour <= 10) {
                        hour = '0' + hour;
                    }
                    min = myDate.getMinutes();
                    min = parseInt(min);
                    if (min >= 0 && min < 10) {

                        min = '0' + min;
                    }
                    if (day >= 0 && day < 10) {

                        day = '0' + day;
                    }

                    switch (month) {
                        case 0:
                            var valMonth = '01';
                            break;
                        case 1:
                            var valMonth = '02';
                            break;
                        case 2:
                            var valMonth = '03';
                            break;
                        case 3:
                            var valMonth = '04';
                            break;
                        case 4:
                            var valMonth = '05';
                            break;
                        case 5:
                            var valMonth = '06';
                            break;
                        case 6:
                            var valMonth = '07';
                            break;
                        case 7:
                            var valMonth = '08';
                            break;
                        case 8:
                            var valMonth = '09';
                            break;
                        case 9:
                            var valMonth = '10';
                            break;
                        case 10:
                            var valMonth = '11';
                            break;
                        case 11:
                            var valMonth = '12';
                            break;

                    }
                    end_date = day + "/" + valMonth + "/" + year + " " + hour + ":" + min;
                    jQuery("#end_date1").val(end_date);

                }
            });
        } else {

            num = parseFloat(num) + 1;
            id = 'planned_end_date' + num;
            calculPlannedDepartureDate(id);
        }
    }

    function calculateKmArrivalParc(id) {

       // var num = id.substring(id.length - 1, id.length);
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(6, trId.length);

        var nb_ride = parseFloat(jQuery('#nb_ride').val());


        if (num == nb_ride) {


            if (jQuery('#detail_ride' + '' + num + '').val()) {
                var detail_ride = jQuery('#detail_ride' + '' + num + '').val();

            }else {
                var detail_ride = 0;
            }
            if (jQuery('#source1' + '' + num + '').prop('checked') || jQuery('#source2' + '' + num + '').prop('checked')) {

                var from_customer_order = 1;

            } else {

                var from_customer_order = 0;
            }
            if (jQuery('#source4' + '' + num + '').prop('checked')){
                var arrivalDestinationId = jQuery('#arrival_destination'+ '' + num + '').val();
                var carTypeId = jQuery('#car_type').val();
            }else {
                var arrivalDestinationId = 0;
                var carTypeId = 0;


            }
            jQuery("#distance-retour-parc").load('<?php echo $this->Html->url('/sheetRides/getDistanceReturnToParc/')?>' + detail_ride + '/' + from_customer_order+'/'+ arrivalDestinationId+'/'+carTypeId,function () {


                if ((jQuery('#origin_distance_retour').val() != "") &&
                    (jQuery('#destination_distance_retour').val() != "")) {
                    var calculByMaps = jQuery('#calcul_maps').val();
                    if (calculByMaps == 1) {
                        var origin = jQuery('#origin_distance_retour').val();
                        var destination = jQuery('#destination_distance_retour').val();
                        var directionsService = new google.maps.DirectionsService();
                        var directionsDisplay = new google.maps.DirectionsRenderer();

                        var request = {
                            origin: origin,
                            destination: destination,
                            travelMode: google.maps.DirectionsTravelMode.DRIVING
                        };

                        directionsService.route(request, function (response, status) {
                            if (status == google.maps.DirectionsStatus.OK) {

                                // Display the distance:

                                var distance = parseInt(response.routes[0].legs[0].distance.value) / 1000;
                                distance = parseInt(distance);


                                jQuery('#distance_retour').val(distance);

                                if (jQuery('#km_arrival' + '' + num + '').val() > 0) {
                                    var km_arrival = jQuery('#km_arrival' + '' + num + '').val();
                                } else {
                                    var km_arrival = jQuery('#km_arrival_estimated' + '' + num + '').val();
                                }


                                if (!isNaN(km_arrival) && !isNaN(distance)) {
                                    var km_estimated = parseFloat(km_arrival) + parseFloat(distance);
                                    jQuery('#km_arr_estimated').val(km_estimated);

                                }

                                if (!isNaN(distance)) {
                                    estimateCost();
                                    getMaintenances();
                                }

                            }
                        });

                    }
                } else {
                    var distance = jQuery('#distance_retour').val();

                    if (jQuery('#km_arrival' + '' + num + '').val() > 0) {
                        var km_arrival = jQuery('#km_arrival' + '' + num + '').val();
                    } else {
                        var km_arrival = jQuery('#km_arrival_estimated' + '' + num + '').val();
                    }


                    if (!isNaN(km_arrival) && !isNaN(distance)) {
                        var km_estimated = parseFloat(km_arrival) + parseFloat(distance);

                        jQuery('#km_arr_estimated').val(km_estimated);

                    }

                    if (!isNaN(distance)) {

                        estimateCost();
                        getMaintenances();
                    }
                }


            });

        } else {
            num = parseFloat(num) + 1;
            id = 'km_arrival' + num;
            //calculKmDeparture(id);
        }


    }

    function getDistance(id) {


        if ((jQuery('#origin').val() != "") && (jQuery('#destination').val() != "")) {

            //calculate();
            var calculByMaps = jQuery('#calcul_maps').val();
            if (calculByMaps == 1) {
                var origin = jQuery('#origin').val();
                var destination = jQuery('#destination').val();
                var directionsService = new google.maps.DirectionsService();
                var directionsDisplay = new google.maps.DirectionsRenderer();

                var myOptions = {
                    zoom: 7,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }

                var map = new google.maps.Map(document.getElementById("map"), myOptions);
                directionsDisplay.setMap(map);

                var request = {
                    origin: origin,
                    destination: destination,
                    travelMode: google.maps.DirectionsTravelMode.DRIVING
                };

                directionsService.route(request, function (response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {

                        // Display the distance:

                        distance = parseInt(response.routes[0].legs[0].distance.value) / 1000;
                        distance = parseInt(distance);
                        jQuery('#distance_retour').val(distance);

                        // Display the duration:
                        /*document.getElementById('duration').innerHTML +=
                         response.routes[0].legs[0].duration.value + " seconds";*/

                        directionsDisplay.setDirections(response);
                    }
                });

            }
        }


    }


    function valTank(tank) {
        var val_tank = 0;
        switch (parseInt(tank)) {

            case  1:
                val_tank = 0;
                break;
            case  2:
                val_tank = 0.125;
                break;
            case  3:
                val_tank = 0.25;
                break;
            case  4:
                val_tank = 0.375;
                break;
            case  5:
                val_tank = 0.5;
                break;
            case  6:
                val_tank = 0.625;
                break;
            case  7:
                val_tank = 0.75;
                break;
            case  8:
                val_tank = 0.875;
                break;
            case  9:
                val_tank = 1;
                break;

        }

        return val_tank;

    }

    function getSumDistance() {
        var nb_ride = jQuery('#nb_ride').val();

        var distance = 0;
        if (jQuery('#distance_first').val()&& jQuery('#distance_first').val()>0) {
            distance = parseFloat(jQuery('#distance_first').val());
        }else {
            distance = 0;
        }

        for (j = 1; j <= nb_ride; j++) {

            distance = distance + parseFloat(jQuery('#distance' + '' + j + '').val());
            if (jQuery('#distance_between' + '' + j + '').val()&&
                jQuery('#distance_between' + '' + j + '').val()>0) {
                distance = distance + parseFloat(jQuery('#distance_between' + '' + j + '').val());
            }
        }
        if (jQuery('#distance_retour').val()&& jQuery('#distance_retour').val()>0) {
            distance = distance + parseFloat(jQuery('#distance_retour').val());
        }
        return distance;
    }

    function getSumDuration() {


        if (jQuery("#start_date2").val()) {

            var s_arr = jQuery("#start_date2").val().split(/\/|\s|:/);
        } else {

            var s_arr = jQuery("#start_date1").val().split(/\/|\s|:/);
        }

        if (jQuery("#end_date2").val()) {

            var e_arr = jQuery("#end_date2").val().split(/\/|\s|:/);
        } else {

            var e_arr = jQuery("#end_date1").val().split(/\/|\s|:/);
        }
        var start = new Date(s_arr[2] + '-' + s_arr[1] + '-' + s_arr[0] + '00:00:00');
        s_arr[1] = s_arr[1] - 1;
        var start = new Date(s_arr[2], s_arr[1], s_arr[0]);
        var end = new Date(e_arr[2] + '-' + e_arr[1] + '-' + e_arr[0] + '00:00:00');
        e_arr[1] = e_arr[1] - 1;
        var end = new Date(e_arr[2], e_arr[1], e_arr[0]);

        var diff = {};

        var tmp = end - start;
        // Initialisation du retour

        tmp = Math.floor(tmp / 1000);             // Nombre de secondes entre les 2 dates
        diff.sec = tmp % 60;                    // Extraction du nombre de secondes

        tmp = Math.floor((tmp - diff.sec) / 60);    // Nombre de minutes (partie entière)
        diff.min = tmp % 60;                    // Extraction du nombre de minutes

        tmp = Math.floor((tmp - diff.min) / 60);    // Nombre d'heures (entières)
        diff.hour = tmp % 24;                   // Extraction du nombre d'heures

        tmp = Math.floor((tmp - diff.hour) / 24);   // Nombre de jours restants
        diff.day = tmp;

        return diff.day;
    }

    function getMaintenances() {
        var distance = getSumDistance();
        var duration = getSumDuration();
        var carId = jQuery('#cars').val();
        if (carId > 0) {

            if (distance != '' && duration != '') {
                jQuery('#maintenance-bloc').load('<?php echo $this->Html->url('/sheetRides/getPossibleAlertsDuringSheetRide/')?>' + carId + '/' + distance + '/' + duration, function () {

                });
            }
        }
    }

    function verifyDriverLicenseExpirationDate() {
        verifyDriverLicenseCategory();
        var customerId = jQuery('#customers').val();
        if (customerId > 0) {
            jQuery('#driver-bloc').load('<?php echo $this->Html->url('/sheetRides/verifyDriverLicenseExpirationDate/')?>' + customerId, function () {
            });
        }
    }
    /* verifier si le conducteur en deja en mission */
    function verifyMissionCustomer() {

        var customerId = jQuery('#customers').val();
        if (customerId > 0) {
            jQuery('#mission-customer-bloc').load('<?php echo $this->Html->url('/sheetRides/verifyMissionCustomer/')?>' + customerId, function () {
            });
        }
    }

    function significationTankSelect(tank) {
        switch (parseInt(tank)) {

            case  1:
                valTank = 0;
                break;
            case  2:
                valTank = 0.125;
                break;
            case  3:
                valTank = 0.25;
                break;
            case  4:
                valTank = 0.375;
                break;
            case  5:
                valTank = 0.5;
                break;
            case  6:
                valTank = 0.625;
                break;
            case  7:
                valTank = 0.75;
                break;
            case  8:
                valTank = 0.875;
                break;
            case  9:
                valTank = 1;
                break;

        }
        return valTank;

    }


    function calculateTotalLiterDestination() {
        var literDestination = 0;
        if (jQuery('#detail_ride1').val() > 0 ||
                (jQuery('#departure_destination1').val() > 0 && jQuery('#arrival_destination1').val() > 0)) {

            if (jQuery('#min_consumption').val() && jQuery('#max_consumption').val()) {
                if (jQuery('#difference_allowed').val()) {
                    var moyenne_consumption = (parseFloat(jQuery('#min_consumption').val()) + parseFloat(jQuery('#max_consumption').val()) + parseFloat(jQuery('#difference_allowed').val())) / 2;
                } else {
                    var moyenne_consumption = (parseFloat(jQuery('#min_consumption').val()) + parseFloat(jQuery('#max_consumption').val())) / 2;
                }
                var distance = getSumDistance();

                literDestination = (parseFloat(distance) * moyenne_consumption) / 100;


                if (jQuery('#departureTankStateMethod').val() == 1) {
                    literDestination = literDestination - parseFloat(jQuery('#reservoir').val());

                } else {
                    var departure_tank = parseFloat(jQuery('#departure_tank').val());
                    literDestination = literDestination - departure_tank;
                }


                if (jQuery('#arrivalTankStateMethod').val() == 1) {
                    literDestination = literDestination + parseFloat(jQuery('#reservoir').val());
                }

                literDestination = literDestination.toFixed(2);


                if (literDestination < 0) {
                    literDestination = 0;
                }
                if (jQuery('#km_liter').length) {
                    jQuery('#km_liter').val(literDestination);
                }

            }
        }

        return literDestination;
    }

    function calculateTotalLiterExisted() {
        var fuelPrice = jQuery('#fuel_price').val();
        var cost = 0;
        var nbConsumption = jQuery('#nb_consumption').val();
        for (var i = 1; i <= nbConsumption; i++) {
            if (jQuery('#cost' + '' + i + '').val()) {
                cost = cost + jQuery('#cost' + '' + i + '').val();
            }
        }
        var totalLiterExisted = parseFloat(cost) / parseFloat(fuelPrice);
        totalLiterExisted = totalLiterExisted.toFixed(2);
        return totalLiterExisted;
    }

    function estimateCost(id) {
        var totalLiter = calculateTotalLiterDestination();
        var literExisted = calculateTotalLiterExisted();
        var differenceLiter = parseFloat(totalLiter) - parseFloat(literExisted);
        var priceTotal = parseFloat(jQuery('#fuel_price').val()) * parseFloat(differenceLiter);
        jQuery('#estimated_cost' ).val(parseFloat(priceTotal.toFixed(2)));
        if(id!=''){
            calculateConsumption(totalLiter, literExisted, id);
        }
    }


    function calculTankArrivalEstimated(tank, reservoir) {

        tank = parseFloat(tank);

        reservoir = parseFloat(reservoir);

        var tank_estimated = (tank * 8) / reservoir;
        tank_estimated = Math.ceil(tank_estimated);
        if (tank_estimated == 0) {
            tank_estimated = 1;

        }
        jQuery('#tank_estimated').val(tank_estimated);
        jQuery('#arrival_tank_estimated').val(tank_estimated);

    }


    function calculateDistanceAndDurationCompanyFirstRide(origin, destination) {


        /* var origin = jQuery('#origin_wilaya').val();
         var destination = jQuery('#destination_departure').val();*/
        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay = new google.maps.DirectionsRenderer();

        var request = {
            origin: origin,
            destination: destination,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };

        directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {

                // Display the distance:

                var distance = parseInt(response.routes[0].legs[0].distance.value) / 1000;
                distance = parseInt(distance);

                jQuery('#distance_first').val(distance);

                // Display the duration:

                var tmp = response.routes[0].legs[0].duration.value;
                var diff = {}
                diff.sec = tmp % 60;                    // Extraction du nombre de secondes
                tmp = Math.floor((tmp - diff.sec) / 60);    // Nombre de minutes (partie entière)
                diff.min = tmp % 60;                    // Extraction du nombre de minutes
                diff.min = parseInt(diff.min);
                jQuery('#duration_minute_first').val(diff.min);
                tmp = Math.floor((tmp - diff.min) / 60);    // Nombre d'heures (entières)
                diff.hour = tmp % 24;                   // Extraction du nombre d'heures
                diff.hour = parseInt(diff.hour);
                jQuery('#duration_hour_first').val(diff.hour);
                tmp = Math.floor((tmp - diff.hour) / 24);   // Nombre de jours restants
                diff.day = tmp;
                diff.day = parseInt(diff.day);
                jQuery('#duration_day_first').val(diff.day);

                calculPlannedDepartureDateFirstRide();
                calculKmDepartureEstimatedFirstRide();
            }
        });
    }

    function calculateDistanceAndDurationBetweenTwoDestination(num) {

        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay = new google.maps.DirectionsRenderer();

        var origin = jQuery('#destinationName' + '' + num + '').val();
        var destination = jQuery('#arrivalName' + '' + num + '').val();
        var request = {
            origin: origin,
            destination: destination,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };

        directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {

                // Display the distance:

                distance = parseInt(response.routes[0].legs[0].distance.value) / 1000;
                distance = parseInt(distance);
                jQuery('#distance' + '' + num + '').val(distance);

                // Display the duration:

                tmp = response.routes[0].legs[0].duration.value;
                var diff = {}
                diff.sec = tmp % 60;                    // Extraction du nombre de secondes
                tmp = Math.floor((tmp - diff.sec) / 60);    // Nombre de minutes (partie entière)
                diff.min = tmp % 60;                    // Extraction du nombre de minutes
                diff.min = parseInt(diff.min);
                jQuery('#duration_minute' + '' + num + '').val(diff.min);
                tmp = Math.floor((tmp - diff.min) / 60);    // Nombre d'heures (entières)
                diff.hour = tmp % 24;                   // Extraction du nombre d'heures
                diff.hour = parseInt(diff.hour);
                jQuery('#duration_hour' + '' + num + '').val(diff.hour);
                tmp = Math.floor((tmp - diff.hour) / 24);   // Nombre de jours restants
                diff.day = tmp;
                diff.day = parseInt(diff.day);
                jQuery('#duration_day' + '' + num + '').val(diff.day);
                var duration = jQuery('#duration_day' + '' + num + '').val() + ' ' + "<?php echo  __('Day') ?>" + ' ' + jQuery('#duration_hour' + '' + num + '').val() + "<?php echo __('Hour') ?>" + ' ' + jQuery('#duration_minute' + '' + num + '').val() + ' ' + "<?php echo __('min') ?>";
                jQuery('#duration' + '' + num + '').val(duration);
                var id = 'duration_day' + '' + num + '';
                calculPlannedArrivalDate(id);
                calculKmArrivalEstimated(id);

            }
        });


    }

    function calculPlannedDepartureDateFirstRide() {

        if (jQuery("#start_date2").val()) {
            var s_arr = jQuery("#start_date2").val().split(/\/|\s|:/);
        } else {
            var s_arr = jQuery("#start_date1").val().split(/\/|\s|:/);
        }
        myDate = new Date(s_arr[1] + "," + s_arr[0] + "," + s_arr[2] + "," + s_arr[3] + ":" + s_arr[4] + ":00");
        nb_day = parseInt(jQuery("#duration_day_first").val());
        nb_hour = parseInt(jQuery("#duration_hour_first").val());
        nb_min = parseInt(jQuery("#duration_minute_first").val());
        var averageSpeed = jQuery('#average_speed').val();

        if (parseFloat(averageSpeed) > 0) {
            var averageSpeedPerMin = parseFloat(averageSpeed) / 60;
            var distance = jQuery('#distance_first').val();
            var totalMin = parseFloat(distance) / parseFloat(averageSpeedPerMin);
        } else {
            var totalMin = (24 * 60 * nb_day) + (60 * nb_hour) + nb_min;
        }

        if (nb_day > 0 || nb_hour > 0 || nb_min > 0) {
            var maximumDrivingTimePerMin = parseFloat(jQuery('#param_maximum_driving_time').val()) * 60;
            var breakTimePerMin = parseFloat(jQuery('#param_break_time').val()) * 60;
            var additionalTimeAllowedPerMin = parseFloat(jQuery('#param_additional_time_allowed').val()) * 60;

            var totalMinDivMaximumDrivingTimePerMin = (totalMin / maximumDrivingTimePerMin);
            totalMinDivMaximumDrivingTimePerMin = parseInt(totalMinDivMaximumDrivingTimePerMin);
            var totalMinModMaximumDrivingTimePerMin = (totalMin % maximumDrivingTimePerMin);

            var tempRestant = maximumDrivingTimePerMin - totalMinModMaximumDrivingTimePerMin;

            jQuery("#tempRestant0").val(tempRestant);
            if (parseFloat(totalMinDivMaximumDrivingTimePerMin) > 0) {
                if (parseFloat(totalMinModMaximumDrivingTimePerMin) < parseFloat(additionalTimeAllowedPerMin)) {
                    var totalDurationPerMin =
                        (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                        ((totalMinDivMaximumDrivingTimePerMin - 1) * breakTimePerMin) +
                        totalMinModMaximumDrivingTimePerMin;
                } else {
                    var totalDurationPerMin =
                        (totalMinDivMaximumDrivingTimePerMin * maximumDrivingTimePerMin) +
                        (totalMinDivMaximumDrivingTimePerMin * breakTimePerMin) +
                        totalMinModMaximumDrivingTimePerMin;
                }

            } else {
                var totalDurationPerMin = totalMin;
            }

            var nbHour = totalDurationPerMin / 60;
            nbHour = parseInt(nbHour);
            var nbMin = totalDurationPerMin % 60;
            var nbDay = nbHour / 24;
            nbDay = parseInt(nbDay);
            nbHour = nbHour % 24;
            nb_day = nbDay;
            nb_hour = nbHour;
            nb_min = nbMin;
        }

        var dayOfMonth = myDate.getDate();

        myDate.setDate(dayOfMonth + nb_day);

        var dayOfMonth = myDate.getHours();

        myDate.setHours(dayOfMonth + nb_hour);

        var dayOfMonth = myDate.getMinutes();

        myDate.setMinutes(dayOfMonth + nb_min);

        var dayOfMonth = myDate.getMonth();

        //myDate.setMonth(dayOfMonth + 1);

        day = myDate.getDate();
        day = parseInt(day);
        if (day >= 0 && day < 10) {

            day = '0' + day;
        }
        month = myDate.getMonth();
        year = myDate.getFullYear();
        hour = myDate.getHours();

        hour = parseInt(hour);
        if (hour >= 0 && hour <= 10) {
            hour = '0' + hour;
        }
        min = myDate.getMinutes();
        min = parseInt(min);
        if (min >= 0 && min <= 10) {

            min = '0' + min;
        }
        switch (month) {
            case 0:
                var valMonth = '01';
                break;
            case 1:
                var valMonth = '02';
                break;
            case 2:
                var valMonth = '03';
                break;
            case 3:
                var valMonth = '04';
                break;
            case 4:
                var valMonth = '05';
                break;
            case 5:
                var valMonth = '06';
                break;
            case 6:
                var valMonth = '07';
                break;
            case 7:
                var valMonth = '08';
                break;
            case 8:
                var valMonth = '09';
                break;
            case 9:
                var valMonth = '10';
                break;
            case 10:
                var valMonth = '11';
                break;
            case 11:
                var valMonth = '12';
                break;

        }
        end_date = day + "/" + valMonth + "/" + year + " " + hour + ":" + min;
        jQuery("#planned_start_date1").val(end_date);
        //jQuery("#real_start_date1").val(end_date);
        calculPlannedArrivalDate('planned_start_date1');

    }

    function calculKmDepartureEstimatedFirstRide() {

        var distance = jQuery('#distance_first').val();

        var km_departure = jQuery('#km_dep').val();

        if (km_departure > 0 && distance >= 0) {

            var km_estimated = parseFloat(km_departure) + parseFloat(distance);

            jQuery('#km_departure1').val(km_estimated);
            calculKmArrivalEstimated('km_departure1');


        }

    }

    function verifyConsumptionLiter() {

        var liter = jQuery('#liter').val();
        var name = jQuery('#fuel_name').val();

        var reservoir = jQuery('#reservoir').val();
        var departure_tank = valTank(jQuery('#departure_tank').val());
        departure_tank = parseFloat(jQuery('#reservoir').val()) * parseFloat(departure_tank);
        var capacite_reservoir = parseFloat(reservoir) - parseFloat(departure_tank);
        jQuery('#consump_liter').load('<?php echo $this->Html->url('/consumptions/verifyConsumptionLiter/')?>' + liter + '/' + name + '/' + capacite_reservoir, function () {

            }
        );
    }


    function couponsSelectedFromFirstNumber(id) {

        //var i = id.substring(id.length - 1, id.length);
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');

        var i = trId.substring(14, trId.length);

        if (jQuery('#coupons' + '' + i + '').val() > 0){
            jQuery('#consump_coupon' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/verifyNbCoupon/')?>' + jQuery('#coupons' + '' + i + '').val() + '/' + i, function () {

                if (jQuery('#coupons' + '' + i + '').val() > 0) {

                    var firstNumberCoupon = jQuery('#first_number_coupon' + '' + i + '').val().trim();

                    jQuery('#number_coupon_div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getCouponsSelectedFromFirstNumber/')?>' + jQuery('#coupons' + '' + i + '').val() + '/' + '0' + '/' + i + '/' + firstNumberCoupon , function () {
                        $(".selectCoupon").select2();
                        if(jQuery('#coupons' + '' + i + '').val()  != jQuery('#nb_coupon' + '' + i + '').val() ){
                            jQuery('#coupons' + '' + i + '').val(jQuery('#nb_coupon' + '' + i + '').val());

                            calculateCost();
                        }else {
                            calculateCost();
                        }

                    });
                }
            });
        }
        }


    function calculateConsumption(totalLiter, literExisted, i) {
        var differenceLiter = parseFloat(totalLiter) - parseFloat(literExisted);


        var typeConsumption = jQuery('#type_consumption' + '' + i + '').val();

        switch (typeConsumption) {
            case '1' :
                var liter_coupon = parseFloat(jQuery('#coupon_price').val()) / parseFloat(jQuery('#fuel_price').val());
                var nb_coupon = parseFloat(differenceLiter) / parseFloat(liter_coupon);
                nb_coupon = Math.ceil(parseFloat(nb_coupon));
                jQuery('#coupons' + '' + i + '').val(nb_coupon);
                jQuery('#consump_coupon' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/verifyNbCoupon/')?>' + nb_coupon + '/' + i, function () {
                    if (jQuery('#coupons' + '' + i + '').val() > 0) {
                        
                        if (jQuery('#selectingCouponsMethod').val() == 1) {
                            jQuery('#coupon-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getCoupons/')?>' + i, function () {

                                var maximumSelection = jQuery('#coupons' + '' + i + '').val();
                                $(".selectCoupon").select2({
                                    maximumSelectionLength: maximumSelection
                                });
                            });

                            if (nb_coupon > jQuery('#coupons' + '' + i + '').val()) {

                            }

                        } else {


                            jQuery('#number_coupon_div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getCouponsSelectedFromFirstNumber/')?>' + jQuery('#coupons' + '' + i + '').val() + '/' + '0' + '/' + i, function () {
                                $(".selectCoupon").select2();
                                if (nb_coupon > jQuery('#coupons' + '' + i + '').val()) {
                                }

                            });
                        }
                        calculateCost();
                    }

                });

                break;

            case '2' :

                var priceTotal = parseFloat(jQuery('#fuel_price').val()) * parseFloat(differenceLiter);

                jQuery('#species' + '' + i + '').val(parseFloat(priceTotal.toFixed(2)));

                calculateCost();
                break;

            case '3' :

                jQuery('#consumption_liter' + '' + i + '').val(differenceLiter);
                var carId = jQuery('#cars').val();
                jQuery('#consump_tank' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/verifyLiterTanks/')?>' + differenceLiter + '/' + i + '/' + carId, function () {
                    $('.select3').select2({});
                    calculateCost();

                });


                break;

            case '4' :
                var priceTotal = parseFloat(jQuery('#fuel_price').val()) * parseFloat(differenceLiter);

                jQuery('#species_card' + '' + i + '').val(parseFloat(priceTotal.toFixed(2)));
                var carId = jQuery('#cars').val();
                jQuery('#consump_card' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/verifyAmountCards/')?>' + priceTotal + '/' + i + '/' + carId, function () {
                    $(".select3").select2();
                    if(jQuery('#species_card' + '' + i + '').val()>0){
                        jQuery('#card' + '' + i +'').parent().addClass('required');
                    }
                        calculateCost();

                });
                break;


        }

    }


    function couponsToSelect(id) {
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var i = trId.substring(14, trId.length);

        jQuery('#consump_coupon' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/verifyNbCoupon/')?>' + jQuery('#coupons' + '' + i + '').val() + '/' + i, function () {

            if (jQuery('#coupons' + '' + i + '').val() > 0) {

                jQuery('#coupon-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getCoupons/')?>' + i, function () {
                    var maximumSelection = jQuery('#coupons' + '' + i + '').val();
                    $(".selectCoupon").select2({
                        maximumSelectionLength: maximumSelection
                    });
                    calculateCost();
                })
            }

        })


    }


    function verifyAmountCards(id) {
        //var i = id.substring(id.length - 1, id.length);
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var i = trId.substring(14, trId.length);

        var price_total = jQuery('#species_card' + '' + i + '').val();
        jQuery('#consump_card' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/verifyAmountCards/')?>' + price_total + '/' + i, function () {
            if(jQuery('#species_card' + '' + i + '').val()>0){
                jQuery('#card' + '' + i +'').parent().addClass('required');
            }
            $(".select3").select2();
            calculateCost();
        });
    }

    function verifySpecieComptes(id) {

        //var i = id.substring(id.length - 1, id.length);

        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var i = trId.substring(14, trId.length);
        var species = jQuery('#species' + '' + i + '').val();
        if(jQuery('#negative_account').val()==1){
            jQuery('#consump_compte' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/verifySpecieComptes/')?>' + species + '/' + i, function () {
                if(jQuery('#species' + '' + i + '').val()>0){

                    jQuery('#compte' + '' + i + '').parent().addClass('required');
                    jQuery('#compte' + '' + i + '').attr('required', 'required');
                }else {
                    jQuery('#compte' + '' + i + '').parent().removeClass('required');
                    jQuery('#compte' + '' + i + '').removeAttr('required');
                }
                $(".select3").select2();
                calculateCost();
            });
        }else {
            if(jQuery('#species' + '' + i + '').val()>0){
                jQuery('#compte' + '' + i + '').parent().addClass('required');
                jQuery('#compte' + '' + i + '').attr('required', 'required');
            }else {
                jQuery('#compte' + '' + i + '').parent().removeClass('required');
                jQuery('#compte' + '' + i + '').removeAttr('required');
            }
            calculateCost();
        }
    }


    function verifyLiterTanks(id) {
        //var i = id.substring(id.length - 1, id.length);
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var i = trId.substring(14, trId.length);
        var carId = jQuery('#cars').val();
        if (carId > 0) {
            var liter = jQuery('#consumption_liter' + '' + i + '').val();

            jQuery('#consump_tank' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/verifyLiterTanks/')?>' + liter + '/' + i + '/' + carId, function () {

                $('.select3').select2({});
                calculateCost();

            });
        } else {
            alert("<?php echo __('First Select car') ?>");
        }
    }


    function addConsumptionDiv(id) {
        var i = parseInt(id) + 1;
        jQuery("#table-consumptions").append("<tr id=tr-consumption" + i + "></tr>");
        jQuery("#tr-consumption" + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/addConsumptionDiv/')?>' + i, function () {
            jQuery('.select3').select2();
            jQuery("#consumption_date" + '' + i + '').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
        });
        $('#div-button').html('<button  style="margin-top: 25px; width: 40px;" name="add" id="' + i + '" onclick="addConsumptionDiv(' + i + ');" class="btn btn-success">+</button>');

        $('#nb_consumption').val(i);
    }


    function removeConsumption(id) {
        //var i = id.substring(id.length - 1, id.length);
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var i = trId.substring(14, trId.length);
        $('#tr-consumption' + '' + i + '').remove();
        calculateCost();
    }

    function calculateCost() {
        var nbConsumption = jQuery('#nb_consumption').val();
        var consumptionLiter = 0;
        var speciesCard = 0;
        var species = 0;
        var nbCoupon = 0;
        var fuelPrice = jQuery('#fuel_price').val();
        var couponPrice = jQuery('#coupon_price').val();
        for (var i = 1; i <= nbConsumption; i++) {
            if (jQuery('#consumption_liter' + '' + i + '').val()) {

                var costI = parseFloat(jQuery('#consumption_liter' + '' + i + '').val()) * parseFloat(fuelPrice);
                jQuery('#cost' + '' + i + '').val(costI);
                consumptionLiter = parseFloat(consumptionLiter) + parseFloat(jQuery('#consumption_liter' + '' + i + '').val());
            }
            if (jQuery('#species_card' + '' + i + '').val()) {
                var costI = parseFloat(jQuery('#species_card' + '' + i + '').val());
                alert(costI);
                jQuery('#cost' + '' + i + '').val(costI);
                speciesCard = parseFloat(speciesCard) + parseFloat(jQuery('#species_card' + '' + i + '').val());
            }
            if (jQuery('#species' + '' + i + '').val()) {
                var costI = parseFloat(jQuery('#species' + '' + i + '').val());
                jQuery('#cost' + '' + i + '').val(costI);
                species = parseFloat(species) + parseFloat(jQuery('#species' + '' + i + '').val());
            }
            if (jQuery('#coupons' + '' + i + '').val()) {
                var costI = parseFloat(jQuery('#coupons' + '' + i + '').val()) * parseFloat(couponPrice);
                jQuery('#cost' + '' + i + '').val(costI);
                nbCoupon = parseFloat(nbCoupon) + parseFloat(jQuery('#coupons' + '' + i + '').val());
            }
        }
        if (consumptionLiter > 0) {
            var costLiter = parseFloat(consumptionLiter) * parseFloat(fuelPrice);
        } else {
            costLiter = 0;
        }
        if (nbCoupon > 0) {
            var costCoupon = (parseInt(nbCoupon) * parseFloat(couponPrice));
        } else {
            var costCoupon = 0;
        }
        var cost = costLiter + costCoupon + speciesCard + species;
        cost = cost.toFixed(2);
        jQuery('#cost').val(cost);

        calculateForecast();
    }



    /*function verifyStatusCar() {
     if ((jQuery("#cars").val())>0 &&  (jQuery("#start_date2").val().length>0) &&  (jQuery("#end_date2").val().length>0) ){
     jQuery.ajax({
     type:"POST",
     url:"?php echo $this->Html->url('/sheetRides/verifyStatusCar/')?>",
     data: {
     car_id:jQuery("#cars").val(),
     real_start_date:jQuery("#start_date2").val(),
     real_end_date:jQuery("#end_date2").val()
     },
     dataType: "json",
     success:function(json){
     if (json.response === "true") {
     alert('Le vehicule est disponible');
     }else {
     alert('Le vehicule est sorti et n\'est pas revenu');
     }
     }
     });
     }
     }*/
    function getMarchandisesByClient(id) {

       // var num = id.substring(id.length - 1, id.length);
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var num = trId.substring(6, trId.length);

        var clientId = jQuery('#client' + '' + num + '').val();
        var nb_marchandise = 1;
         var fieldMarchandiseRequired = jQuery('#fieldMarchandiseRequired').val();

        jQuery('#marchandise-div' + '' + num + '').load('<?php echo $this->Html->url('/sheetRides/getMarchandisesByClient/')?>' + clientId + '/' + num + '/' + nb_marchandise, function () {
            $(".select3").select2();
            if(fieldMarchandiseRequired==1){
                jQuery('#marchandise' + '' + num + nb_marchandise+'').parent().addClass('required');
                jQuery('#quantity' + '' + num + nb_marchandise+'').parent().addClass('required');


            }


        });
    }
    function getAttachmentsByClient(id) {
        //var num = id.substring(id.length - 1, id.length);

        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');

        var num = trId.substring(6, trId.length);

        var clientId = jQuery('#client' + '' + num + '').val();
        if (clientId > 0) {
            jQuery('#piece-div' + '' + num + '').load('<?php echo $this->Html->url('/sheetRides/getAttachmentsByClient/')?>' + clientId + '/' + num, function () {
                $(".select3").select2();
            });
        }
    }

    function getLots(id) {
        var num = id.substring(id.length - 1, id.length);
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');

        var num = trId.substring(6, trId.length);

        jQuery('#lot-div' + '' + num + '').load('<?php echo $this->Html->url('/sheetRides/getLots/')?>' + num, function () {
            $(".select3").select2();
        });

    }

    function addOtherMarchandises(i, num) {
        var nb_marchandise = jQuery('#nb_marchandise' + '' + num + '').val();
        var i = parseInt(nb_marchandise) + 1;
        jQuery('#nb_marchandise' + '' + num + '').val(i);
        var clientId = jQuery('#client' + '' + num + '').val();
        var fieldMarchandiseRequired = jQuery('#fieldMarchandiseRequired').val();
        $('#dynamic_field' + num).append('<tr id="row' + num + '' + i + '" style="height: 70px;"><td ></td></tr>');
        jQuery("#row" + '' + num + '' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/addOtherMarchandises/')?>' + clientId + '/' + num + '/' + i, function () {

            $(".select3").select2();
            if(fieldMarchandiseRequired==1){
                jQuery('#marchandise' + '' + num + i+'').parent().addClass('required');
                jQuery('#quantity' + '' + num + i+'').parent().addClass('required');
            }
        });
    }

    function getWeightByMarchandise(id, num, i) {
        var marchandiseId = jQuery('#' + '' + id + '').val();
        if(marchandiseId >0) {
            jQuery('#quantity'+ '' + num + '' + '' + i + '').attr('required', 'required');
            jQuery('#quantity' + '' + num + i+'').parent().addClass('required');
            jQuery('#weight-div' + '' + num + '' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getWeightByMarchandise/')?>' + marchandiseId + '/' + num + '/' + i, function () {
            });
        }else {
            jQuery('#quantity'+ '' + num + '' + '' + i + '').removeAttr('required');
            jQuery('#quantity' + '' + num + i+'').parent().removeClass('required');
        }

    }

    function verifyQuantity(id, num, i) {
        var nbMarchandise = jQuery('#nb_marchandise' + '' + num + '').val();
        var quantity = 0;
        for (var i = 1; i <= nbMarchandise; i++) {
            quantity = quantity + parseFloat(jQuery('#quantity' + '' + num + '' + '' + i + '').val());
        }
        var nbPalette = parseFloat(jQuery('#nb_palette').val());

        if (parseInt(quantity) > parseInt(nbPalette)) {
            var msg = '<?php echo __('The maximum quantity is : ')?>';
            var diffQuantity = nbPalette;
            for (var i = 1; i <= nbMarchandise; i++) {

                if (parseFloat(jQuery('#quantity' + '' + num + '' + '' + i + '').val()) <= diffQuantity) {
                    diffQuantity = parseFloat(diffQuantity) - parseFloat(jQuery('#quantity' + '' + num + '' + '' + i + '').val());
                } else {
                    jQuery('#quantity' + '' + num + '' + '' + i + '').val(diffQuantity);
                    diffQuantity = parseFloat(diffQuantity) - parseFloat(jQuery('#quantity' + '' + num + '' + '' + i + '').val());
                }
            }
            alert(msg + nbPalette);
            jQuery('#truck_full2' + '' + num + '').removeAttr('checked');
            jQuery('#truck_full1' + '' + num + '').prop('checked', true);
            calculateAuthorizedWeight();
            jQuery('.add_marchandise').css('display', 'none');
        } else if (parseInt(quantity) == parseInt(nbPalette)) {
            jQuery('#truck_full2' + '' + num + '').removeAttr('checked');
            jQuery('#truck_full1' + '' + num + '').prop('checked', true);
            calculateAuthorizedWeight();
            jQuery('.add_marchandise').css('display', 'none');
        } else {
            jQuery('#truck_full1' + '' + num + '').removeAttr('checked');
            jQuery('#truck_full2' + '' + num + '').prop('checked', true);
            calculateAuthorizedWeight();
        }
    }

    function calculateAuthorizedWeight() {
        var chargeUtile = jQuery('#charge_utile').val();
        var nbRide = jQuery('#nb_ride').val();
        for (var i = 1; i <= nbRide; i++) {
            var nbMarchandise = jQuery('#nb_marchandise' + '' + i + '').val();
            var weightMarchandise = 0;
            for (var j = 1; j <= nbMarchandise; j++) {
                weightMarchandise = weightMarchandise + (parseFloat(jQuery('#quantity' + '' + i + '' + '' + j + '').val()) * parseFloat(jQuery('#weight_palette' + '' + i + '' + '' + j + '').val()));
            }
            if (weightMarchandise > chargeUtile) {
                var msg = '<?php echo __('The weight of marchandises is higher than the payload of car.')?>';
                alert(msg);
            }
        }
    }


    function calculateForecast() {

        var diff_tank = 0;
        var diff_km = 0;
        var max_consumption = 0;
        var min_consumption = 0;
        var difference = 0;
        var km_tank = 0;
        var departure_tank_value = 0;
        var arrival_tank_value = 0;
        var average_consumption = 0;
        var global_consumption = 0;
        var global_allowed_liter = 0;
        var estimated_cost = 0;
        var cost = 0;
        var liter_given = 0;
        var liter_solde = 0;

        if (
            jQuery('#km_dep').val() && jQuery('#km_arr').val()
            && jQuery('#max_consumption').val() && jQuery('#min_consumption').val()
            && jQuery('#fuel_price').val()) {
            diff_km = jQuery('#km_arr').val() - jQuery('#km_dep').val();
            //calculate consumption average per 100 km
            average_consumption = (parseFloat(jQuery('#min_consumption').val()) + parseFloat(jQuery('#max_consumption').val())) / 2;
            // calculate global consumption
            global_consumption = (diff_km * average_consumption) / 100;
            global_consumption = global_consumption.toFixed(2);
            global_allowed_liter = (parseFloat(diff_km) * parseFloat(jQuery('#difference_allowed').val())) / 100;

            // get departure tank value per liter

            if ((jQuery('#departureTankStateMethod').val() == 1) || (jQuery('#departureTankStateMethod').val() == 2)) {
                departure_tank_value = parseFloat(jQuery('#reservoir').val());
                ;
            } else {
                if (jQuery('#departure_tank').val()) {
                    departure_tank_value = parseFloat(jQuery('#departure_tank').val());
                }
            }
            // get arrival tank value per liter
            switch (jQuery('#arrivalTankStateMethod').val()) {
                case 1 :
                    arrival_tank_value = parseFloat(jQuery('#reservoir').val());
                    diff_tank = 0;
                    global_consumption = global_consumption - diff_tank;
                    break;
                case 2:
                    arrival_tank_value = parseFloat(jQuery('#reservoir').val());
                    diff_tank = 0;
                    global_consumption = global_consumption - diff_tank;
                    break;
                case 3 :
                    arrival_tank_value = parseFloat(jQuery('#arrival_tank').val());
                    diff_tank = +parseFloat(arrival_tank_value) - parseFloat(departure_tank_value);
                    global_consumption = global_consumption - diff_tank;
                    break;
            }
            liter_solde = parseFloat(jQuery('#balance').val()) / jQuery('#fuel_price').val();
            global_consumption = global_consumption - liter_solde;
            global_consumption = global_consumption.toFixed(2);
            //get estimated cost
            estimated_cost = jQuery('#fuel_price').val() * global_consumption;

            estimated_cost = estimated_cost.toFixed(2);
            jQuery('#forecast').val(estimated_cost);

            cost = jQuery('#cost').val();
            //get liter given to conductor
            liter_given = cost / jQuery('#fuel_price').val();
            liter_given = liter_given.toFixed(2);
            // get nb coupon given to conductor
            difference = cost - estimated_cost;
            jQuery('#difference_estimated').val(difference.toFixed(2));

            if (liter_given > parseFloat(global_consumption) + parseFloat(global_allowed_liter)) {
                msg = '<?php echo __('Reported consumption : ')?>';
                msg2 = '<?php echo __(' is higher than estimated consumption: ') ?>';
                msg3 = '<?php echo __(' which corresponds ') ?>';
                msg5 = '<?php echo $this->Session->read("currency") ?>';
                alert(msg + ' ' + liter_given + 'L ' + msg3 + ' ' + ' = ' + cost + msg5 + msg2 + global_consumption + 'L ' + msg3 + ' ' + ' = ' + estimated_cost + msg5);
                jQuery('#forecast_state').val(1);

            } else if (liter_given < parseFloat(global_consumption) - parseFloat(global_allowed_liter)) {
                msg = '<?php echo __('Reported consumption : ')?>';
                msg2 = '<?php echo __(' is lower than estimated consumption: ') ?>';
                msg3 = '<?php echo __(' which corresponds ') ?>';
                msg5 = '<?php echo $this->Session->read("currency") ?>';
                alert(msg + ' ' + liter_given + 'L ' + msg3 + ' ' + ' = ' + cost + msg5 + msg2 + global_consumption + 'L ' + msg3 + ' ' + ' = ' + estimated_cost + msg5);


                jQuery('#forecast_state').val(2);

            }


        } else if
        (jQuery('#km_dep').val() && jQuery('#km_arr').val() && !jQuery('#max_consumption').val() && !jQuery('#min_consumption').val()
            && jQuery('#consumption_model').val() && jQuery('#fuel_price').val() && jQuery('#coupon_price').val()) {

            diff_km += jQuery('#arrival_km').val();
            diff_km -= jQuery('#departure_km').val();

            // get departure tank value per liter
            if (jQuery('#departureTankEstimatingMethod').val() == 2) {
                if (jQuery('#tankStateMethod').val() == 1) {
                    departure_tank_value = parseFloat(jQuery('#reservoir').val());
                    ;
                } else {
                    if (jQuery('#departure_tank').val()) {
                        departure_tank_value = parseFloat(jQuery('#departure_tank').val());
                    }
                }
            }
            // get arrival tank value per liter
            if (jQuery('#tankStateMethod').val() == 1) {
                arrival_tank_value = parseFloat(jQuery('#reservoir').val()) - parseFloat(jQuery('#consumption_liter').val());
            } else {
                if (jQuery('#arrival_tank').val()) {
                    arrival_tank_value = parseFloat(jQuery('#arrival_tank').val());
                }
            }

            diff_tank += parseFloat(arrival_tank_value);
            diff_tank -= parseFloat(departure_tank_value);
            // get how much a coupon contain liters
            liter_coupon = jQuery('#coupon_price').val() / jQuery('#fuel_price').val();
            // donner la valeur du kilometrage corresponde à la difference carburant
            km_tank = (jQuery('#consumption_model').val() * diff_tank) / liter_coupon;

            diff_km -= km_tank;

            global_consumption = global_coupon_estimated * liter_coupon;
            global_consumption = global_consumption.toFixed(2);
            global_allowed_liter = (parseFloat(diff_km) * parseFloat(jQuery('#difference_allowed').val())) / 100;
            estimated_cost = global_consumption * jQuery('#fuel_price').val();
            estimated_cost = estimated_cost.toFixed(2);
            jQuery('#forecast').val(estimated_cost);


            cost = jQuery('#cost').val();
            //get liter given to conductor
            liter_given = cost / jQuery('#fuel_price').val();
            liter_given = liter_given.toFixed(2);


            difference = cost - estimated_cost;
            jQuery('#difference_estimated').val(difference.toFixed(2));


            if (liter_given > parseFloat(global_consumption) + parseFloat(global_allowed_liter)) {
                msg = '<?php echo __('Reported consumption : ')?>';
                msg2 = '<?php echo __(' is higher than estimated consumption: ') ?>';
                msg3 = '<?php echo __(' which corresponds ') ?>';

                msg5 = '<?php echo $this->Session->read("currency") ?>';
                alert(msg + ' ' + liter_given + 'L ' + msg3 + ' ' + ' = ' + cost + msg5 + msg2 + global_consumption + 'L ' + msg3 + ' ' + ' = ' + estimated_cost + msg5);

                jQuery('#forecast_state').val(1);

            } else if (liter_given < parseFloat(global_consumption) - parseFloat(global_allowed_liter)) {


                msg = '<?php echo __('Reported consumption : ')?>';
                msg2 = '<?php echo __(' is lower than estimated consumption: ') ?>';
                msg3 = '<?php echo __(' which corresponds ') ?>';

                msg5 = '<?php echo $this->Session->read("currency") ?>';
                alert(msg + ' ' + liter_given + 'L ' + msg3 + ' ' + ' = ' + cost + msg5 + msg2 + global_consumption + 'L ' + msg3 + ' ' + ' = ' + estimated_cost + msg5);


                jQuery('#forecast_state').val(2);

            }
        }
    }

    function removeMission(id) {
        $('#depart' + id + '').remove();
        $('#arrive' + id + '').remove();

        var nb_ride = parseFloat(jQuery('#nb_ride').val());
        nb_ride--;
        if (nb_ride > 1) {
            $('#div-remove' + nb_ride).append('<button  name="remove" id="remove' + nb_ride + '" onclick="removeMission(' + nb_ride + ');" class="btn btn-danger btn_remove">X</button>');


        }
        jQuery('#nb_ride').val(nb_ride);
        id = 'depart' + nb_ride;

        calculateDateArrivalParc(id);

    }

    function getFinalSupplierByInitialSupplier(id) {
       // var i = id.substring(id.length - 1, id.length);
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var i = trId.substring(6, trId.length);

        var supplierId = jQuery('#client' + '' + i + '').val();

        jQuery("#client-final-div" + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getFinalSupplierByInitialSupplier/')?>' + supplierId + '/' + i, function () {

            $('.select-search-client-final-i').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/suppliers/getFinalSuppliersByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            supplierId: supplierId
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2

            });
        });

    }

    function addConsumptionMethod(id) {
        //var i = id.substring(id.length - 1, id.length);
        var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
        var i = trId.substring(14, trId.length);

        var typeConsumption = jQuery('#type_consumption' + '' + i + '').val();
        var carId = jQuery('#cars').val();
        jQuery("#consumption-method" + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/addConsumptionMethod/')?>' + typeConsumption + '/' + i+'/'+carId, function () {
            $('.select3').select2({});
        });
    }
    function addConveyor(id) {
        id = parseInt(id) + 1;
        jQuery("#conveyor-div").append("<div id=conveyor" + id + "></div>");
        jQuery("#conveyor" + '' + id + '').load('<?php echo $this->Html->url('/sheetRides/addConveyor/')?>' + id, function () {
            $('.select-search-conveyor').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/customers/getConveyorsByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            controller: jQuery('#controller').val(),
                            action: jQuery('#current_action').val()
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2
            });
        });

        $('#add_conveyor').html('<div class="view-link select-inline" style="margin-top: 2px;" title=""> <a href="javascript:addConveyor(' + id + ');" class="btn btn-default" style="width: 40px;"><i class="fa fa-plus"></i></a></div>');

    }

    function getInformationCarBySubcontracting(id){
        jQuery("#subcontracting-div").load('<?php echo $this->Html->url('/sheetRides/getInformationCarBySubcontracting/')?>' + id , function () {
            $('.select-search-subcontractor').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/suppliers/getSubcontractorsByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2
            });
            $('.select-search-remorque').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/cars/getRemorquesByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            controller: jQuery('#controller').val(),
                            action: jQuery('#current_action').val(),
                            remorqueId: ''
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2
            });
            $('.select-search-car').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/cars/getCarsByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            controller :jQuery('#controller').val(),
                            action :jQuery('#current_action').val(),
                            carId : '',
                            carTypeId : jQuery('#car_type').val()
                        };
                    },
                    processResults: function (data, page) {
                        console.log(data);
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2
            });
            $('.select-search-customer').select2({
                ajax: {
                    url: "<?php echo $this->Html->url('/customers/getCustomersByKeyWord')?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: $.trim(params.term),
                            controller: jQuery('#controller').val(),
                            action: jQuery('#current_action').val(),
                            customerId: ''
                        };
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    },
                    cache: true
                },
                minimumInputLength: 2
            });
            if (id=='car_subcontracting1'){
                var nbRide = jQuery('#nb_ride').val();
                for (var i = 1; i <= nbRide; i++) {
                    var carId = jQuery('#cars').val();
                    var rideId = jQuery("#detail_ride" + '' + i + '').val();
                    if (jQuery('#source1' + '' + i + '').prop('checked') || jQuery('#source2' + '' + i + '').prop('checked')) {
                        var fromCustomerOrder = 1;
                    }
                    jQuery('#cost_contractor_div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getContractCostByDetailRide/')?>' + rideId + '/' + i + '/' + fromCustomerOrder + '/' + carId, function () {
                        jQuery('#reservation_cost' + '' + i + '').parent().addClass( 'required');
                    });
                }
            }
        });
    }

    function verifyKmEntred(id, kmType){
        if(id == 'km_arr' && kmType=='arrival'){
            var kmArrival = jQuery('#km_arr').val();
            var kmDeparture = jQuery('#km_dep').val();
        }else {
            if(kmType=='arrival'){
                //var i = id.substring(id.length - 1, id.length);
                var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
                var i = trId.substring(6, trId.length);
                var kmArrival = jQuery('#km_arrival' + '' + i + '').val();
                var kmDeparture = jQuery('#km_departure' + '' + i + '').val();
            }else {
                if(kmType=='departure' && id =='km_departure1'){
                    var kmDeparture = jQuery('#km_dep').val();
                    var kmArrival = jQuery('#km_departure1').val();
                } else {
                    //var i = id.substring(id.length - 1, id.length);
                    var trId = jQuery("#" + '' + id + '').parents('tr:first').attr('id');
                    var i = trId.substring(6, trId.length);
                    var precedetentI = parseInt(i)-1;
                    var kmDeparture = jQuery('#km_arrival' + '' + precedetentI + '').val();
                    var kmArrival = jQuery('#km_departure' + '' + i + '').val();
                }
            }
        }

        if(kmDeparture!='' && kmType=='arrival'){
            if(kmArrival < kmDeparture){
                alert("<?php echo __('Km arrival must be heigher than km departure.') ?>");
            }
        }else {
            if(kmType=='departure'){
                if(kmArrival < kmDeparture){
                    alert("<?php echo __('Km departure must be heigher than precedent km arrival.') ?>");
                }
            }
        }
    }
    
    function showRequiredFields() {
        let requiredFields =  jQuery(':input[required]');
        requiredFields.each(function () {
            console.log(jQuery(this).attr('name'));
        });
    }

</script>
<?= $this->Html->script('plugins/datetimepicker/moment-with-locales.min.js'); ?>
<?= $this->Html->script('plugins/datetimepicker/bootstrap-datetimepicker.min.js'); ?>


<?php $this->end(); ?>
