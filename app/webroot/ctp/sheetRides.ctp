<?php
$this->start('css');

echo $this->Html->css('bootstrap-datetimepicker.min');
echo $this->Html->css('select2/select2.min');
$this->end(); 
 $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('bootstrap-filestyle'); ?>
<?= $this->Html->script('maskedinput'); ?>

<?= $this->Html->script('plugins/datetimepicker/moment-with-locales.min.js'); ?>
<?= $this->Html->script('plugins/datetimepicker/bootstrap-datetimepicker.min.js'); ?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
<script type="text/javascript">

    function couponsToSelect() {
        jQuery('#consump_coupon').load('<?php echo $this->Html->url('/sheetRides/verifyNbCoupon/')?>'+ jQuery('#coupons').val(), function (){

            jQuery('#coupon-div').load('<?php echo $this->Html->url('/sheetRides/getCoupons/')?>', function () {
                var maximumSelection = jQuery('#coupons').val();
                $(".selectCoupon").select2({
                    maximumSelectionLength: maximumSelection
                });
                calculateCost();
            })

        })


    }
	
	function couponsToSelect() {
        jQuery('#consump_coupon').load('<?php echo $this->Html->url('/sheetRides/verifyNbCoupon/')?>' + jQuery('#coupons').val(), function () {

            jQuery('#coupon-div').load('<?php echo $this->Html->url('/sheetRides/getCoupons/')?>', function () {

                var maximumSelection = jQuery('#coupons').val();
                $(".selectCoupon").select2({
                    maximumSelectionLength: maximumSelection
                });
                calculateCost();
            })

        })


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

        jQuery('#customers-div').load('<?php echo $this->Html->url('/sheetRides/getCustomersByCar/')?>' + jQuery('#cars').val(), function () {
                jQuery('.select2').select2();

            }
        );
        jQuery('#remorques-div').load('<?php echo $this->Html->url('/sheetRides/getRemorquesByCar/')?>' + jQuery('#cars').val(), function () {
            jQuery('.select2').select2();
        });
        jQuery('#consumption-bloc').load('<?php echo $this->Html->url('/sheetRides/getConsumptions/')?>' + jQuery('#cars').val(), function () {
            jQuery('#km-tank-departure-div').load('<?php echo $this->Html->url('/sheetRides/getKmAndTank/')?>' + jQuery('#cars').val(), function () {
                calculKmDepartureEstimatedFirstRide();
                calculKmArrivalEstimated('km_departure1');
                estimateCost();
            });

        });


    }
    function addRideSheetRide() {

        var nb_ride = parseFloat(jQuery('#nb_ride').val());
        jQuery("#end_date1").val('');
        jQuery("#km_arr_estimated").val('');
        var i = nb_ride + 1;
        var rowspan = (i * 2) + 2;


        jQuery("#arrive" + '' + nb_ride + '').after("<tr id=depart" + i + "></tr>");

        jQuery("#depart" + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/addDepartRide/')?>' + i, function () {

            jQuery("#planned_start_date" + '' + i + '').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
            jQuery("#real_start_date" + '' + i + '').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
            id = 'from_customer_order1' + i;

            getRidesFromCustomerOrder(id);

        });

        jQuery("#depart" + '' + i + '').after("<tr id=arrive" + i + "></tr>");
        jQuery("#arrive" + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/addArriveRide/')?>' + i, function () {
            jQuery("#planned_end_date" + '' + i + '').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});
            jQuery("#real_end_date" + '' + i + '').inputmask("datetime", {"placeholder": "dd/mm/yyyy hh:mm"});

        });


        jQuery("#travel").attr("rowspan", rowspan);
        jQuery('#nb_ride').val(i);



    }
    function calculPlannedArrivalDate(id) {

        var num = id.substring(id.length - 1, id.length);


        if (jQuery("#real_start_date" + '' + num + '').val()) {

            var s_arr = jQuery("#real_start_date" + '' + num + '').val().split(/\/|\s|:/);
        } else {

            var s_arr = jQuery("#planned_start_date" + '' + num + '').val().split(/\/|\s|:/);
        }
        myDate = new Date(s_arr[1] + "," + s_arr[0] + "," + s_arr[2] + "," + s_arr[3] + ":" + s_arr[4] + ":00");


        nb_day = parseInt(jQuery("#duration_day" + '' + num + '').val());

        nb_hour = parseInt(jQuery("#duration_hour" + '' + num + '').val());
        nb_min = parseInt(jQuery("#duration_minute" + '' + num + '').val());

        var dayOfMonth = myDate.getDate();

        myDate.setDate(dayOfMonth + nb_day);

        var dayOfMonth = myDate.getHours();

        myDate.setHours(dayOfMonth + nb_hour);

        var dayOfMonth = myDate.getMinutes();

        myDate.setMinutes(dayOfMonth + nb_min);

        var dayOfMonth = myDate.getMonth();

        myDate.setMonth(dayOfMonth + 1);

        day = myDate.getDate();
        month = myDate.getMonth();
        year = myDate.getFullYear();
        hour = myDate.getHours();
        min = myDate.getMinutes();
        if (min == '0') {

            min = min + '0';
        }
        end_date = day + "/" + month + "/" + year + " " + hour + ":" + min;

        jQuery("#planned_end_date" + '' + num + '').val(end_date);


    }


    function calculKmArrivalEstimated(id) {
        var num = id.substring(id.length - 1, id.length);
        distance = jQuery('#distance' + '' + num + '').val();
        km_departure = jQuery('#km_departure' + '' + num + '').val();
        if (km_departure > 0 && distance > 0) {
            km_estimated = parseFloat(km_departure) + parseFloat(distance);
            jQuery('#km_arrival_estimated' + '' + num + '').val(km_estimated);


        }

    }

    function getInformationRide(id) {

        var num = id.substring(id.length - 1, id.length);

        ride_id = jQuery("#detail_ride" + '' + num + '').val();
        client_id = jQuery("#client" + '' + num + '').val();
        if (jQuery('#from_customer_order1' + '' + num + '').prop('checked')) {
            transport_bill_detail_ride_id = jQuery('#detail_ride' + '' + num + '').val();

            jQuery('#transport_bill_detail_ride' + '' + num + '').val(transport_bill_detail_ride_id);
            var from_customer_order = 1;
            jQuery('#client-initial-div' + '' + num + '').load('<?php echo $this->Html->url('/sheetRides/getClientInitialFromCustomerOrder/')?>' + ride_id + '/' + num);

            jQuery('#client-final-div' + '' + num + '').load('<?php echo $this->Html->url('/sheetRides/getClientFinalFromCustomerOrder/')?>' + ride_id + '/' + num);
        } else {

            var from_customer_order = 0;
        }
        jQuery('#distance_duration_ride' + '' + num + '').load('<?php echo $this->Html->url('/sheetRides/getInformationRide/')?>' + ride_id + '/' + num + '/' + from_customer_order, function () {
            calculPlannedArrivalDate(id);
            calculKmArrivalEstimated(id);
            estimateCost();

        });


    }


    function addFile(id) {

        var j = jQuery('#nb_attachment' + '' + id + '').val();

        j++;
        jQuery('#nb_attachment' + '' + id + '').val(j);
        if (j < 6) {

            $("#dynamic_field" + '' + id + '').append('<tr id="row' + j + '"><td class="td-input"><div  id="attachment' + '' + id + '' + j + '-file" ><div class="form-group input-button"><div class="input file"><label for ="att' + '' + id + '' + j + '"><?php echo __('Attachments');?></label><input id="att' + '' + id + '' + j + '" class="form-filter" name="data[SheetRideDetailRides][<?php echo $nbMissions?>][attachment][]"  type="file"/></div></div> <span class="popupactions"><button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "  id="attachment' + '' + id + '' + j + '-btn" type="button" onclick="delete_file(\'attachment' + '' + id + '' + j + '\');"><i class="fa fa-repeat m-r-5"></i><?=__('Empty')?></button></span></div></td><td class="td_tab"><button style="margin-left: 40px;" name="remove" id="' + '' + id + '' + j + '" onclick="remove(\'' + '' + id + '' + j + '\');"class="btn btn-danger btn_remove">X</button></td></tr>');
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
                    var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
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

        var i = id.substring(id.length - 1, id.length);
        type_id = jQuery("#car_type").val();
        jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getRidesFromCustomerOrder/')?>' + i + '/' + type_id, function () {
            jQuery('.select2').select2();
        });


    }

    function getRidesByType(id) {
        var i = id.substring(id.length - 1, id.length);
        type_id = jQuery("#car_type").val();
        jQuery('#ride-div' + '' + i + '').load('<?php echo $this->Html->url('/sheetRides/getRidesByType/')?>' + i + '/' + type_id, function () {
            jQuery('.select2').select2();
        });

    }
    function calculateDateArrivalParc(id) {
        var num = id.substring(id.length - 1, id.length);

        var nb_ride = parseFloat(jQuery('#nb_ride').val());

        if (num == nb_ride) {

            detail_ride = jQuery('#detail_ride' + '' + num + '').val();


            if (jQuery('#from_customer_order1' + '' + num + '').prop('checked')) {

                var from_customer_order = 1;

            } else {

                var from_customer_order = 0;
            }

            jQuery("#retour-parc").load('<?php echo $this->Html->url('/sheetRides/getRideToParc/')?>' + detail_ride + '/' + from_customer_order, function () {
                if (jQuery("#real_end_date" + '' + num + '').val()) {

                    var s_arr = jQuery("#real_end_date" + '' + num + '').val().split(/\/|\s|:/);
                }

                myDate = new Date(s_arr[1] + "," + s_arr[0] + "," + s_arr[2] + "," + s_arr[3] + ":" + s_arr[4] + ":00");

                if ((jQuery('#origin').val() != "") && (jQuery('#destination').val() != "")) {


                    var origin = jQuery('#origin').val();
                    var destination = jQuery('#destination').val();
                    var directionsService = new google.maps.DirectionsService();
                    var directionsDisplay = new google.maps.DirectionsRenderer();


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
                        }
                    });


                } else {


                    nb_day = parseInt(jQuery("#duration_day_retour").val());
                    nb_hour = parseInt(jQuery("#duration_hour_retour").val());
                    nb_min = parseInt(jQuery("#duration_minute_retour").val());

                }

                var dayOfMonth = myDate.getDate();

                myDate.setDate(dayOfMonth + nb_day);

                var dayOfMonth = myDate.getHours();

                myDate.setHours(dayOfMonth + nb_hour + 3);

                var dayOfMonth = myDate.getMinutes();

                myDate.setMinutes(dayOfMonth + nb_min);

                var dayOfMonth = myDate.getMonth();

                myDate.setMonth(dayOfMonth + 1);

                day = myDate.getDate();
                month = myDate.getMonth();
                year = myDate.getFullYear();
                hour = myDate.getHours();
                min = myDate.getMinutes();
                if (min == '0') {

                    min = min + '0';
                }
                end_date = day + "/" + month + "/" + year + " " + hour + ":" + min;

                jQuery("#end_date1").val(end_date);


            });
        }
    }

    function calculateKmArrivalParc(id) {
        var num = id.substring(id.length - 1, id.length);

        var nb_ride = parseFloat(jQuery('#nb_ride').val());

        if (num == nb_ride) {

            detail_ride = jQuery('#detail_ride' + '' + num + '').val();
            if (jQuery('#from_customer_order1' + '' + num + '').prop('checked')) {

                var from_customer_order = 1;

            } else {

                var from_customer_order = 0;
            }
            jQuery("#retour-parc").load('<?php echo $this->Html->url('/sheetRides/getRideToParc/')?>' + detail_ride + '/' + from_customer_order, function () {


                if ((jQuery('#origin').val() != "") && (jQuery('#destination').val() != "")) {


                    var origin = jQuery('#origin').val();
                    var destination = jQuery('#destination').val();
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

                            jQuery('#distance_retour').val(distance);

                            km_arrival = jQuery('#km_arrival' + '' + num + '').val();

                            if (km_arrival > 0 && distance > 0) {
                                km_estimated = parseFloat(km_arrival) + parseFloat(distance);
                                jQuery('#km_arr_estimated').val(km_estimated);

                            }


                        }
                    });


                } else {

                    distance = jQuery('#distance_retour').val();
                    km_arrival = jQuery('#km_arrival' + '' + num + '').val();

                    if (km_arrival > 0 && distance > 0) {
                        km_estimated = parseFloat(km_arrival) + parseFloat(distance);
                        jQuery('#km_arr_estimated').val(km_estimated);

                    }
                }


            });

        }


    }
    function getDistance(id) {


        if ((jQuery('#origin').val() != "") && (jQuery('#destination').val() != "")) {

            //calculate();
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
        var distance = parseFloat(jQuery('#distance_first').val());

        for (j = 1; j <= nb_ride; j++) {

            distance = distance + parseFloat(jQuery('#distance' + '' + j + '').val());
        }
        distance = distance + parseFloat(jQuery('#distance_retour').val())

        return distance;
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


    function estimateCost() {

        var distance = 0;




        if (jQuery('#detail_ride1').val() > 0) {
            if ( jQuery('#min_consumption').val() && jQuery('#max_consumption').val()){




                    if (jQuery('#difference_allowed').val()) {
                       var  moyenne_consumption = (parseFloat(jQuery('#min_consumption').val()) + parseFloat(jQuery('#max_consumption').val()) + parseFloat(jQuery('#difference_allowed').val())) / 2;
                    } else {
                       var  moyenne_consumption = (parseFloat(jQuery('#min_consumption').val()) + parseFloat(jQuery('#max_consumption').val())) / 2;
                    }

                    distance = getSumDistance();

                    var liter_destination = (parseFloat(distance) * moyenne_consumption) / 100;

                 if (jQuery('#departureTankEstimatingMethod').val()==2) {
                     var departure_tank = parseFloat(jQuery('#departure_tank').val());
                     liter_destination = liter_destination - departure_tank;
                 }


                    liter_destination = liter_destination.toFixed(2);
                    jQuery('#nb_liter').val(liter_destination);

                calculateConsumptionByPriority(liter_destination);




            }
        }
    }


    function calculateConsumptionByPriority(liter_destination) {


    switch (parseInt(jQuery('#priority1').val())) {

        case  1:

            if (jQuery('#param_tank').val() == 1) {
                liter_destination.toFixed(2);
                jQuery('#liter').val(liter_destination);

                var liter = jQuery('#liter').val();
                var name = jQuery('#fuel_name').val();

                var reservoir = jQuery('#reservoir').val();
                if (jQuery('#departureTankEstimatingMethod').val()==2) {
                    var departure_tank = jQuery('#departure_tank').val();
                    var capacite_reservoir = parseFloat(reservoir) - parseFloat(departure_tank);
                } else {
                    var capacite_reservoir = parseFloat(reservoir);
                }
                jQuery('#consump_liter').load('<?php echo $this->Html->url('/sheetRides/verifyConsumptionLiter/')?>' + liter + '/' + name + '/' + capacite_reservoir, function () {

                    switch (parseInt(jQuery('#priority2').val())) {
                        case  2:

                            if (jQuery('#param_coupons').val() == 1 && parseInt(jQuery('#priority1').val()) == 1) {
                                var diff_liter = liter_destination - jQuery('#liter').val();

                                nb_coupon2 = diff_liter / liter_coupon;

                                nb_coupon2 = Math.ceil(parseFloat(nb_coupon2));

                                jQuery('#coupons').val(nb_coupon2);
                                nb = jQuery('#coupons').val();


                                liter_nb_coupon = nb_coupon2 * liter_coupon;
                                diff_tank = liter_nb_coupon - diff_liter;
                                reservoir = jQuery('#reservoir').val();


                                calculTankArrivalEstimated(diff_tank, reservoir);
                                jQuery('#consump_coupon').load('<?php echo $this->Html->url('/sheetRides/verifyNbCoupon/')?>' + nb, function () {

                                    if(jQuery('#selectingCouponsMethod').val()==1){

                                        couponsToSelect();
                                    }else {
                                        couponsSelectedFromFirstNumber();
                                    }

                                    nb_coupon = jQuery('#coupons').val();
                                    liter_nb_coupon = nb_coupon * liter_coupon;
                                    diff_tank = liter_nb_coupon - diff_liter;
                                    reservoir = jQuery('#reservoir').val();


                                    calculTankArrivalEstimated(diff_tank, reservoir);
                                    if (parseInt(jQuery('#priority3').val()) == 3) {

                                        if (jQuery('#coupons').val()) {
                                            var diff = nb_coupon - jQuery('#coupons').val();
                                            price_total2 = jQuery('#coupon_price').val() * diff;
                                            jQuery('#species').val(parseFloat(price_total2.toFixed(2)));

                                            reservoir = jQuery('#reservoir').val();
                                            if (price_total2 == 0) {
                                                calculTankArrivalEstimated(diff_tank, reservoir);
                                            } else {
                                                calculTankArrivalEstimated(0, reservoir);
                                            }
                                        }

                                    }

                                });


                            }


                            break;
                        case  3:

                            if (jQuery('#param_spacies').val() == 1) {
                                var diff_liter = liter_destination - jQuery('#liter').val();
                                price_total3 = jQuery('#fuel_price').val() * diff_liter;
                                jQuery('#species').val(parseFloat(price_total3.toFixed(2)));

                                reservoir = jQuery('#reservoir').val();
                                if (price_total3 == 0) {
                                    calculTankArrivalEstimated(0, reservoir);
                                } else {
                                    calculTankArrivalEstimated(0, reservoir);
                                }
                            }
                            break;
                    }

                });


            }


            break;
        case  2:

            if (jQuery('#param_coupons').val() == 1) {
                liter_coupon = jQuery('#coupon_price').val() / jQuery('#fuel_price').val();
                nb_coupon = liter_destination / liter_coupon;

                nb_coupon = Math.ceil(parseFloat(nb_coupon));

                price_total = jQuery('#fuel_price').val() * liter_destination;

                jQuery('#coupons').val(nb_coupon);
                nb = jQuery('#coupons').val();

                liter_nb_coupon = nb_coupon * liter_coupon;
                diff_tank = liter_nb_coupon - liter_destination;

                diff_tank = diff_tank.toFixed(2);
                reservoir = jQuery('#reservoir').val()

                calculTankArrivalEstimated(diff_tank, reservoir);

                jQuery('#consump_coupon').load('<?php echo $this->Html->url('/sheetRides/verifyNbCoupon/')?>' + nb, function () {


                    if(jQuery('#selectingCouponsMethod').val()==1){

                        couponsToSelect();
                    }else {
                        couponsSelectedFromFirstNumber();
                    }
                    nb_coupon = jQuery('#coupons').val();
                    liter_nb_coupon = nb_coupon * liter_coupon;
                    diff_tank = liter_nb_coupon - liter_destination;
                    reservoir = jQuery('#reservoir').val();
                    calculTankArrivalEstimated(diff_tank, reservoir);

                    switch (parseInt(jQuery('#priority2').val())) {

                        case  1:

                            if (jQuery('#param_tank').val() == 1 && parseInt(jQuery('#priority1').val()) == 2) {
                                var diff_coupon = nb_coupon - jQuery('#coupons').val();


                                liter_destination2 = diff_coupon * liter_coupon;

                                liter_destination2 = liter_destination2.toFixed(2);

                                jQuery('#liter').val(liter_destination2);

                                var liter = jQuery('#liter').val();
                                var name = jQuery('#fuel_name').val();

                                jQuery('#consump_liter').load('<?php echo $this->Html->url('/sheetRides/verifyConsumptionLiter/')?>' + liter + '/' + name + '/' + capacite_reservoir, function () {

                                    if (parseInt(jQuery('#priority3').val()) == 3) {

                                        if (jQuery('#liter').val()) {
                                            var diff = liter_destination - jQuery('#liter').val();
                                            price_total3 = jQuery('#fuel_price').val() * diff;
                                            jQuery('#species').val(parseFloat(price_total3.toFixed(2)));

                                            reservoir = jQuery('#reservoir').val();
                                            calculTankArrivalEstimated(0, reservoir);
                                        }

                                    }

                                });


                            }


                            break;
                        case  3:

                            if (jQuery('#param_spacies').val() == 1) {

                                var diff = nb_coupon - jQuery('#coupons').val();

                                price_total4 = jQuery('#coupon_price').val() * diff;
                                jQuery('#species').val(parseFloat(price_total4.toFixed(2)));

                                reservoir = jQuery('#reservoir').val();
                                if (price_total4 == 0) {
                                    calculTankArrivalEstimated(diff_tank, reservoir);
                                } else {
                                    calculTankArrivalEstimated(0, reservoir);
                                }
                            }
                            break;


                    }


                });


            }
            break;
        case  3:

            if (jQuery('#param_spacies').val() == 1) {


                jQuery('#species').val(parseFloat(price_total.toFixed(2)));

                reservoir = jQuery('#reservoir').val()
                calculTankArrivalEstimated(0, reservoir);
            }

            break;


    }

    }


    function calculTankArrivalEstimated(tank, reservoir) {

        tank = parseFloat(tank);

        reservoir = parseFloat(reservoir);

        tank_estimated = (tank * 8) / reservoir;
        tank_estimated = Math.ceil(tank_estimated);
        if (tank_estimated == 0) {
            tank_estimated = 1;

        }
        jQuery('#tank_estimated').val(tank_estimated);
        jQuery('#arrival_tank_estimated').val(tank_estimated);

    }


    function calculateDistanceAndDurationCompanyFirstRide() {


        var origin = jQuery('#origin_wilaya').val();
        var destination = jQuery('#destination_departure').val();
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
                jQuery('#distance_first').val(distance);

                // Display the duration:

                tmp = response.routes[0].legs[0].duration.value;
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

        var dayOfMonth = myDate.getDate();

        myDate.setDate(dayOfMonth + nb_day);

        var dayOfMonth = myDate.getHours();

        myDate.setHours(dayOfMonth + nb_hour);

        var dayOfMonth = myDate.getMinutes();

        myDate.setMinutes(dayOfMonth + nb_min);

        var dayOfMonth = myDate.getMonth();

        myDate.setMonth(dayOfMonth + 1);

        day = myDate.getDate();
        month = myDate.getMonth();
        year = myDate.getFullYear();
        hour = myDate.getHours();
        min = myDate.getMinutes();
        if (min == '0') {

            min = min + '0';
        }
        end_date = day + "/" + month + "/" + year + " " + hour + ":" + min;

        jQuery("#planned_start_date1").val(end_date);
        jQuery("#real_start_date1").val(end_date);

    }

    function calculKmDepartureEstimatedFirstRide() {

        distance = jQuery('#distance_first').val();
        km_departure = jQuery('#km_dep').val();
        if (km_departure > 0 && distance > 0) {
            km_estimated = parseFloat(km_departure) + parseFloat(distance);
            jQuery('#km_departure1').val(km_estimated);


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

    function calculateCost(){


        var cost_spacies=0;

        if(jQuery('#liter').val()>0) {
            var cost_liter=jQuery('#liter').val()*jQuery('#fuel_price').val();

        }else {
            var cost_liter=0;
        }
        if(jQuery('#coupons').val()>0 && jQuery('#returned-coupons').val()>0) {

            var cost_coupon= (parseInt(jQuery('#coupons').val())- parseInt(jQuery('#returned-coupons').val()))*parseInt(jQuery('#coupon_price').val());

        }else if(jQuery('#coupons').val()>0){

            var cost_coupon= (parseInt(jQuery('#coupons').val()))*parseInt(jQuery('#coupon_price').val());

        }else {
            var cost_coupon= 0;

        }

        if(jQuery('#species').val()>0){
            cost_spacies= parseFloat(jQuery('#species').val());
        }

       cost= cost_liter+ cost_coupon + cost_spacies;

        jQuery('#cost').val(cost);
    }

    function couponsSelectedFromFirstNumber() {
        jQuery('#consump_coupon').load('<?php echo $this->Html->url('/sheetRides/verifyNbCoupon/')?>' + jQuery('#coupons').val(), function () {


                jQuery('#number_coupon_div').load('<?php echo $this->Html->url('/sheetRides/getCouponsSelectedFromFirstNumber/')?>' + jQuery('#coupons').val(), function () {

                    $(".selectCoupon").select2();

                })


        });
    }
	
		</script>

<?php $this->end(); ?>
