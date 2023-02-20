<?php
/**
 * @var int $isSheetRideRequiredForConsumption
 * @var array $customers
 */
//include("ctp/datetime.ctp");
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
    <h4 class="page-title"> <?=__('Add consumption'); ?></h4>
    <div class="box">
        <div class="edit form card-box p-b-0">
            <?php echo $this->Form->create('Consumption' , array('onsubmit'=> 'javascript:disable();')); ?>
            <div class="box-body">
                <?php
                if ($isSheetRideRequiredForConsumption == '1'){
                    echo "<div class='col-sm-4' >" . $this->Form->input('sheet_ride_id', array(
                            'label' => __("Sheet ride"),
                            'class' => 'form-control select-search-sheet',
                            'empty' => '',
                            'id' => 'sheetRide',
                        )) . "</div>";
                }else{
                    echo "<div  id='sheet-ride-div' class='col-sm-4' >" . $this->Form->input('sheet_ride_id', array(
                            'label' => __("Sheet ride"),
                            'class' => 'form-control select-search-sheet',
                            'empty' => '',
                            'required' => true,
                            'onchange' => 'javascript :sheetRideChanged();',
                            'id' => 'sheetRide',
                        )) . "</div>";
                }

                echo "<div  id='customers-div' class='col-sm-4' >" . $this->Form->input('customer_id', array(
                        'label' => __("Customer"),
                        'class' => 'form-control select-search-customer',
                        'empty' => '',
                        'id' => 'customers',
                    )) . "</div>";


                echo "<div id='cars-div' class='col-sm-4'>" . $this->Form->input('car_id', array(
                        'label' => __('Car'),
                        'class' => 'form-control select-search-car',
                        'empty' => '',
                        'onchange' => 'javascript: carChanged(jQuery(this).val()) ;',
                        'id' => 'cars',
                    )) . "</div>";


                echo "<div >" . $this->Form->input('param_coupons', array(
                        'label' => __('param_coupons'),
                        'id' => 'param_coupons',
                        'value' => $paramConsumption['0'],
                        'class' => 'form-control',
                        'type' => 'hidden',
                    )) . "</div>";

                echo "<div >" . $this->Form->input('param_spacies', array(
                        'label' => __('param_spacies'),

                        'value' => $paramConsumption['1'],
                        'id' => 'param_spacies',
                        'class' => 'form-control',
                        'type' => 'hidden',
                    )) . "</div>";


                echo "<div >" . $this->Form->input('param_tank', array(
                        'label' => __('param_tank'),
                        'value' => $paramConsumption['2'],
                        'class' => 'form-control',
                        'id' => 'param_tank',
                        'type' => 'hidden',
                    )) . "</div>";


                echo "<div >" . $this->Form->input('param_card', array(
                        'label' => __('param_card'),
                        'value' => $paramConsumption['3'],
                        'class' => 'form-control',
                        'id' => 'param_card',
                        'type' => 'hidden',
                    )) . "</div>";

                echo "<div >" . $this->Form->input('coupon_price', array(
                        'label' => '',
                        'type' => 'hidden',
                        'id' => 'coupon_price'
                    )) . "</div>";

                echo "<div >" . $this->Form->input('difference_allowed', array(
                        'label' => '',
                        'type' => 'hidden',
                        'id' => 'difference_allowed'
                    )) . "</div>";
                echo "<div >" . $this->Form->input('gpl_price', array(
                        'label' => '',
                        'type' => 'hidden',
                        'id' => 'gpl_price'
                    )) . "</div>";
                echo "<div style='clear:both; padding-top: 10px;'></div>";
                ?>

                <div id="fuel-price-info" >

                </div>
                <table id='table-consumptions' class="table table-bordered ">
                        <tr id='tr-consumption'>
                            <td style='width:99%; height: 100px;'>
                                <?php
                                $currentDate = date("Y-m-d H:i");
                                echo "<div class='col-sm-3'>" . $this->Form->input('consumption_date', array(
                                        'label' => '',
                                        'type' => 'text',
                                        'value' => $this->Time->format($currentDate, '%d/%m/%Y %H:%M'),
                                        'class' => 'form-control datemask',
                                        'before' => '<label class="dte">' . __('Date') . '</label><div class="input-group datetime"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                        'after' => '</div>',
                                        'id' => 'consumption_date',
                                    )) . "</div>";

                                $options = array('0' => '',
                                );
                                if ($paramConsumption['0'] == 1) {
                                    if ($options != null) {
                                        $options = array_replace($options, array('1' => __('Coupons')));
                                    } else {
                                        $options = array('1' => __('Coupons'));
                                    }
                                }
                                if ($paramConsumption['1'] == 1) {
                                    if ($options != null) {
                                        $options = array_replace($options, array('2' => __('Species')));
                                    } else {
                                        $options = array('2' => __('Species'));
                                    }
                                }
                                if ($paramConsumption['2'] == 1) {
                                    if ($options != null) {
                                        $options = array_replace($options, array('3' => __('Tank')));
                                    } else {
                                        $options = array('3' => __('Tank'));
                                    }
                                }
                                if ($paramConsumption['3'] == 1) {
                                    if ($options != null) {
                                        $options = array_replace($options, array('4' => __('Cards')));
                                    } else {
                                        $options = array('4' => __('Cards'));
                                    }
                                }
                                echo "<div class='col-sm-3' >" . $this->Form->input('type_consumption_used', array(
                                        'label' => __('Consumption type'),
                                        'empty' => true,
                                        'class' => 'form-control ',
                                        'options' => $options,
                                        'id' => 'type_consumption',
                                        'value'=>$defaultConsumptionMethod,
                                        'onchange' => 'javascript : addConsumptionMethod();'
                                    )) . "</div>"; ?>

                                <div id='consumption-method'></div>
                            </td>

                        </tr>
                    </table>

<?php
echo "<div style='clear:both; padding-top: 10px;'></div>";
echo "<div class='col-sm-4' >" . $this->Form->input('cost', array(
                    'label' => __('Cost') . ' (' . $this->Session->read("currency") . ')',
                    'class' => 'form-control',
                    'readonly' => true,
                    'id' => 'cost'
                    )) . "</div>"; ?>
            </div>
           <div style='clear:both; padding-top: 10px;'></div>
            <div class="box-footer">
                <?php echo $this->Form->submit(__('Submit'), array(
                    'name' => 'ok',
                    'class' => 'btn btn-primary btn-bordred  m-b-5',
                    'label' => __('Submit'),
                    'type' => 'submit',
                    'id'=>'boutonValider',
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
    <!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('jquery-2.1.1.min.js'); ?>
<?= $this->Html->script('jquery.form.min.js'); ?>

    <script type="text/javascript">
        $(document).ready(function () {
            jQuery("#consumption_date").inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"})
            addConsumptionMethod();

        });
        function addConsumptionMethod() {
            var typeConsumption = jQuery('#type_consumption').val();
            jQuery("#consumption-method").load('<?php echo $this->Html->url('/consumptions/addConsumptionMethod/')?>' + typeConsumption , function () {


                 $('.select3').select2();
            });
        }

        function couponsToSelect() {

            jQuery('#consump_coupon').load('<?php echo $this->Html->url('/consumptions/verifyNbCoupon/')?>' + jQuery('#coupons').val(), function () {

                if (jQuery('#coupons').val() > 0) {

                    jQuery('#coupon-div').load('<?php echo $this->Html->url('/consumptions/getCoupons/')?>' , function () {
                        $(".select2").css({"width": "100% !important"});
                        var maximumSelection = jQuery('#coupons').val();
                        $(".selectCoupon").select2({
                            maximumSelectionLength: maximumSelection
                        });
                        calculateCost();
                    })
                }

            })


        }

        function couponsSelectedFromFirstNumber() {
            if (jQuery('#coupons').val() > 0){
                jQuery('#consump_coupon').load('<?php echo $this->Html->url('/consumptions/verifyNbCoupon/')?>' + jQuery('#coupons').val() , function () {

                    if (jQuery('#coupons').val() > 0) {

                        var firstNumberCoupon = jQuery('#first_number_coupon').val().trim();

                        jQuery('#number_coupon_div').load('<?php echo $this->Html->url('/consumptions/getCouponsSelectedFromFirstNumber/')?>' + jQuery('#coupons').val() + '/' + '0' +  '/' + firstNumberCoupon , function () {
                            $(".selectCoupon").select2();
                            if(jQuery('#coupons').val()  != jQuery('#nb_coupon').val() ){
                                jQuery('#coupons').val(jQuery('#nb_coupon').val());

                                calculateCost();
                            }else {
                                calculateCost();
                            }

                        });
                    }
                });
            }
        }


        function verifySpecieComptes() {

            var species = jQuery('#species').val();
            if(jQuery('#negative_account').val()==1){
                jQuery('#consump_compte').load('<?php echo $this->Html->url('/consumptions/verifySpecieComptes/')?>' + species, function () {

                    if(jQuery('#species').val()>0){

                        jQuery('#compte').parent().addClass('required');
                        jQuery('#compte').attr('required', 'required');
                    }else {
                        jQuery('#compte').parent().removeClass('required');
                        jQuery('#compte').removeAttr('required');
                    }
                    $(".select3").select2();
                    calculateCost();
                });
            } else {
                if(jQuery('#species').val()>0){
                    jQuery('#compte').parent().addClass('required');
                    jQuery('#compte').attr('required', 'required');
                }else {
                    jQuery('#compte').parent().removeClass('required');
                    jQuery('#compte').removeAttr('required');
                }
                calculateCost();
            }
        }


        function verifyLiterTanks() {
            var carId = jQuery('#cars').val();
            if (carId > 0) {
                var liter = jQuery('#consumption_liter').val();

                jQuery('#consump_tank').load('<?php echo $this->Html->url('/consumptions/verifyLiterTanks/')?>' + liter + '/' + carId, function () {
                    $('.select3').select2({});
                    if(liter>0){
                        jQuery('#tank').parent().addClass('required');
                        jQuery('#tank').attr('required', 'required');
                    } else {
                        jQuery('#tank').parent().removeClass('required');
                        jQuery('#tank').removeAttr('required');
                    }
                    calculateCost();

                });
            } else {
                alert("<?php echo __('First Select car') ?>");
            }
        }

        function verifyAmountCards() {

            var totalPrice = jQuery('#species_card').val();

            jQuery('#consump_card').load('<?php echo $this->Html->url('/consumptions/verifyAmountCards/')?>' + totalPrice , function () {
                if(jQuery('#species_card').val()>0){
                    jQuery('#card').parent().addClass('required');
                }
                $(".select3").select2();
                calculateCost();
            });
        }

        function calculateCost() {

            var consumptionLiter = 0;
            var speciesCard = 0;
            var species = 0;
            var nbCoupon = 0;
            var fuelPrice = jQuery('#fuel_price').val();
            var couponPrice = jQuery('#coupon_price').val();
            console.log('fuel price : ' + fuelPrice);

                if (jQuery('#consumption_liter').val()) {

                    var costI = parseFloat(jQuery('#consumption_liter').val()) * parseFloat(fuelPrice);
                    jQuery('#cost').val(costI);
                    consumptionLiter =  parseFloat(jQuery('#consumption_liter').val());
                }
                if (jQuery('#species_card').val()) {
                    var costI = parseFloat(jQuery('#species_card').val());
                    jQuery('#cost').val(costI);
                    speciesCard =  parseFloat(jQuery('#species_card').val());
                }

                if (jQuery('#species').val()) {
                    var costI = parseFloat(jQuery('#species').val());
                    jQuery('#cost').val(costI);
                    species =   parseFloat(jQuery('#species').val());
                }

                if (jQuery('#coupons').val()) {
                    var costI = parseFloat(jQuery('#coupons' ).val()) * couponPrice;
                    jQuery('#cost').val(costI);
                    nbCoupon =nbCoupon + parseFloat(jQuery('#coupons').val());
                }

            if (consumptionLiter > 0) {
                var costLiter = consumptionLiter * fuelPrice;
            } else {
                costLiter = 0;
            }
            if (nbCoupon > 0) {
                var costCoupon = (nbCoupon * parseFloat(couponPrice));
            } else {
                var costCoupon = 0;
            }
            var cost = costLiter + costCoupon + speciesCard + species;

            cost = cost.toFixed(2);
            jQuery('#cost').val(cost);

        }



        function sheetRideChanged(){
            var sheetRideId = jQuery('#sheetRide').val();


            jQuery('#cars-div').load('<?php echo $this->Html->url('/consumptions/getCarsBySheetRide/')?>' + sheetRideId, function () {

                $(".select-search").select2({
                    sorter: function (data) {
                        /* Sort data using lowercase comparison */
                        return data.sort(function (a, b) {
                            a = a.text.toLowerCase();
                            b = b.text.toLowerCase();
                            if (a > b) {
                                return 1;
                            } else if (a < b) {
                                return -1;
                            }
                            return 0;
                        });
                    },
                    allowDuplicates: true

                });



                if (jQuery('#cars').val()) {
                        var carId = jQuery('#cars').val();
                    } else {
                        var carId = '';
                    }

                    if(jQuery('#car_type').val()){
                        var carTypeId = jQuery('#car_type').val();
                    }else {
                        var carTypeId='';
                    }

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
                                    carId : carId,
                                    carTypeId : carTypeId
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

            jQuery('#customers-div').load('<?php echo $this->Html->url('/consumptions/getCustomersBySheetRide/')?>' + sheetRideId, function () {

                    $(".select-search").select2({
                        sorter: function (data) {
                            /* Sort data using lowercase comparison */
                            return data.sort(function (a, b) {
                                a = a.text.toLowerCase();
                                b = b.text.toLowerCase();
                                if (a > b) {
                                    return 1;
                                } else if (a < b) {
                                    return -1;
                                }
                                return 0;
                            });
                        },
                        allowDuplicates: true

                    });


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
                                console.log(data)
                                return {results: data};
                            },
                            cache: true
                        },
                        minimumInputLength: 2
                    });



                }


                );


        }

        function carChanged(Id) {
            console.log(Id);
            let url = '<?= $this->Html->url('/consumptions/getFuelPriceByCarId/')?>'+Id;
            jQuery('#fuel-price-info').load(url);

        }



    </script>

<?php $this->end(); ?>