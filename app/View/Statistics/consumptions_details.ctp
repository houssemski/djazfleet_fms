<?php

?><h4 class="page-title"> <?= __('Consumptions details'); ?></h4>
    <div class="box-body">
        <div class="row">
            <!-- BASIC WIZARD -->
            <div class="col-lg-12">
                <div class="card-box p-b-20">
                    <?php echo $this->Form->create('Statistic', array(
                        'url' => array(
                            'action' => 'consumptionsDetails'
                        ),
                        'novalidate' => true
                    )); ?>
                    <div class="filters" id='filters' style='display: block;'>
                        <?php
                        echo $this->Form->input('car_id', array(
                            'label' => __('Car'),
                            'class' => 'form-filter select2',
                            'id' => 'car',
                            'empty' => ''
                        ));
                        echo "<div style='clear:both; padding-top: 10px;'></div>";
                        echo $this->Form->input('date', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('Start') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'startdate',
                        ));
                        echo $this->Form->input('next_date', array(
                            'label' => '',
                            'type' => 'text',
                            'class' => 'form-control datemask',
                            'before' => '<label class="dte">' . __('End') . '</label><div class="input-group date"><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                            'after' => '</div>',
                            'id' => 'enddate',
                        ));
                        ?>
                        <div style='clear:both; padding-top: 5px;'></div>
                        <button style="float: right;" class="btn btn-success btn-trans waves-effect w-md waves-success"
                                type="submit"><?= __('Search') ?></button>
                        <div style='clear:both; padding-top: 10px;'></div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                    <div class="row" style="clear: both">
                        <div class="btn-group pull-left">
                            <div class="header_actions">
                                <div class="btn-group">
                                    <?= $this->Html->link('<i class="glyphicon glyphicon-export"></i>' . __('Export Excel'),

                                        'javascript:exportDataExcel();',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'export_excel')) ?>


                                </div>
                                <div class="btn-group">
                                    <?= $this->Html->link('<i class="glyphicon glyphicon-export"></i>' . __('Export Pdf'),
                                        /* array('action' => 'listcarparcsupplier_pdf', 'ext'=>'pdf'),*/
                                        'javascript:exportDataPdf();',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'export')) ?>


                                </div>

                                <div class="btn-group">
                                    <?= $this->Html->link('<i class="glyphicon glyphicon-export"></i>' . __('Synthesis'),

                                        'javascript:exportSynExcel();',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'export_syn')) ?>


                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- BASIC WIZARD -->
            <div class="col-lg-12">
                <div class="card-box p-b-20">
                    <table class="table table-striped table-bordered" style="table-layout: fixed;"
                           id='table_consumption_detail'>
                        <thead style="width: auto">
                        <th><?= __('N°') ?></th>
                        <th><?= __('RELEASE DATE') ?></th>
                        <th><?= __('Departure km') ?></th>
                        <th><?= __('Arrival km') ?></th>
                        <th><?= __('Km traveled') ?></th>
                        <th><?= __('INDICATION KM') ?></th>
                        <th><?= __('DRIVER') ?></th>
                        <th><?= __('COUPONS NUMBER') ?></th>
                        <th><?= __('SERIAL N°') ?></th>
                        <th><?= __('Species') ?></th>
                        <th><?= __('Species card') ?></th>
                        <th><?= __('Cards') ?></th>
                        <th><?= __('Consumption liter') ?></th>
                        <th><?= __('Tank') ?></th>
                        <th><?= __('Nb Km/Coupon') ?></th>
                        <th><?= __('Liter/Coupon') ?></th>
                        <th><?= __('Nb Liter/100 km') ?></th>
                        </thead>
                        <tbody>
                        <?php

                        if (!empty($results)) {
                            $indKm = 0;
                            $couponNbr = 0;
                            $species = 0;
                            $speciesCard = 0;
                            $literTank = 0;
                            $serialNumbers = array();
                            $cards = array();
                            $tanks = array();
                            $releaseDates = array();
                            $kmDepartures = array();
                            $kmArrivals = array();
                            $kmTraveleds = array();
                            $customers = array();
                            $num_coupon = '';
                            $reference_card = '';
                            $reference_tank = '';
                            $date = '';
                            $km1 = '';
                            $km2 = '';
                            $km3 = '';
                            $km_coupon = 0;
                            $liter_coupon = 0;
                            $liter_km = 0;
                            $i = 0;
                            $j = 0;
                            $currentCar = $results[0]['car']['id'];
                            $currentConsumption = $results[0]['sheet_rides']['id'];

                            foreach ($results as $result) {
                                $i++;
                                if ($result['car']['id'] == $currentCar) {
                                    if ($param == 1) {
                                        $car_name = $result['car']['code'] . " - " . $result['carmodels']['name'];
                                    } else if ($param == 2) {
                                        $car_name = $result['car']['immatr_def'] . " - " . $result['carmodels']['name'];
                                    }
                                    if ($currentConsumption == $result['sheet_rides']['id']) {

                                        $liter_coupon = ($result['fuels']['price'] > 0) ? ((float)$coupon_price / (float)$result['fuels']['price']) : 0;
                                        $date = $result['sheet_rides']['real_start_date'];
                                        $km1 = $result['sheet_rides']['km_departure'];
                                        $km2 = $result['sheet_rides']['km_arrival'];
                                        if ($result['sheet_rides']['km_departure'] > 0 && $result['sheet_rides']['km_arrival'] > 0) {
                                            $km3 = $result['sheet_rides']['km_arrival'] - $result['sheet_rides']['km_departure'];
                                        } else $km3 = 0;

                                        if ($num_coupon == '') {
                                            $num_coupon = $result['coupons']['serial_number'];
                                        } else {
                                            $num_coupon = $num_coupon . ' , ' . $result['coupons']['serial_number'];
                                        }

                                        if ($reference_card == '') {
                                            $reference_card = $result['fuel_cards']['reference'];
                                        } else {
                                            $reference_card = $reference_card . ' , ' . $result['fuel_cards']['reference'];
                                        }

                                        if ($reference_tank == '') {
                                            $reference_tank = $result['tanks']['name'];
                                        } else {
                                            $reference_tank = $reference_tank . ' , ' . $result['tanks']['name'];
                                        }
                                        $date_departure = $result['sheet_rides']['real_start_date'];
                                        $km_departure = $result['sheet_rides']['km_departure'];
                                        $km_arrival = $result['sheet_rides']['km_arrival'];
                                        if ($result['sheet_rides']['km_departure'] > 0 && $result['sheet_rides']['km_arrival'] > 0) {
                                            $km_traveled = $result['sheet_rides']['km_arrival'] - $result['sheet_rides']['km_departure'];
                                        } else $km_traveled = 0;
                                        if ($couponNbr == 0) {
                                            $couponNbr = $result['consumptions']['nb_coupon'];
                                        }
                                        if ($species == 0) {
                                            $species = $result['consumptions']['species'];
                                        }

                                        if ($speciesCard == 0) {
                                            $speciesCard = $result['consumptions']['species_card'];
                                        }
                                        if ($literTank == 0) {
                                            $literTank = $result['consumptions']['consumption_liter'];
                                        }
                                    } else {
                                        if ($result['sheet_rides']['km_departure'] > 0 && $result['sheet_rides']['km_arrival'] > 0) {

                                            $indKm += $result['sheet_rides']['km_arrival'] - $result['sheet_rides']['km_departure'];
                                        }
                                        $couponNbr += $result['consumptions']['nb_coupon'];
                                        $species += $result['consumptions']['species'];
                                        $speciesCard += $result['consumptions']['species_card'];
                                        $literTank += $result['consumptions']['consumption_liter'];
                                        $serialNumbers[] = $num_coupon;
                                        $cards[] = $reference_card;
                                        $tanks[] = $reference_tank;
                                        $releaseDates[] = $date;
                                        $kmDepartures[] = $km1;
                                        $kmArrivals[] = $km2;
                                        $kmTraveleds[] = $km3;
                                        $num_coupon = $result['coupons']['serial_number'];
                                        $reference_card = $result['fuel_cards']['reference'];
                                        $reference_tank = $result['tanks']['name'];
                                        $date = $result['sheet_rides']['real_start_date'];
                                        $km1 = $result['sheet_rides']['km_departure'];
                                        $km2 = $result['sheet_rides']['km_arrival'];
                                        if ($result['sheet_rides']['km_departure'] > 0 && $result['sheet_rides']['km_arrival'] > 0) {
                                            $km3 = $result['sheet_rides']['km_arrival'] - $result['sheet_rides']['km_departure'];
                                        } else $km3 = 0;
                                        $currentConsumption = $result['sheet_rides']['id'];

                                    }


                                    $customers[] = $result['customers']['first_name'] . " " . $result['customers']['last_name'];
                                } else {
                                    $j++;

                                    $serialNumbers[] = $num_coupon;
                                    $cards[] = $reference_card;
                                    $tanks[] = $reference_tank;
                                    $releaseDates[] = $date;
                                    $kmDepartures[] = $km1;
                                    $kmArrivals[] = $km2;
                                    $kmTraveleds[] = $km3;
                                    $num_coupon = '';
                                    $reference_card = '';
                                    $reference_tank = '';
                                    $date = '';
                                    $km1 = '';
                                    $km2 = '';
                                    $km3 = '';
                                    $currentConsumption = $result['sheet_rides']['id'];
                                    echo "<tr style='width: auto;'>" .
                                        "<td colspan='17' style='border: 1px solid rgba(16, 196, 105, 0.1) !important; background-color: rgba(16, 196, 105, 0.15) !important; color: #10c469 !important;font-weight:bold;'>"
                                        . $car_name . "</td></tr>";
                                    echo "<tr style='font-size: 11px;'><td class='right'>" . $j . "</td>";

                                    echo "<td><table>";
                                    foreach ($releaseDates as $releaseDate) {
                                        /* echo "<tr><td style='overflow-x: scroll; display: block; width: auto;'>".$this->Time->format($releaseDate, '%d-%m-%Y %H:%M')."</td></tr>";*/
                                        echo "<tr style='font-size: 11px;'><td >" . $this->Time->format($releaseDate, '%d-%m-%Y %H:%M') . "</td></tr>";
                                    }
                                    echo "</table></td>";

                                    echo "<td><table>";
                                    foreach ($kmDepartures as $kmDeparture) {
                                        /* echo "<tr><td style='overflow-x: scroll; display: block; width: auto;'>".$this->Time->format($releaseDate, '%d-%m-%Y %H:%M')."</td></tr>";*/
                                        echo "<tr style='font-size: 11px;'><td >" . number_format($kmDeparture, 0, ",", ".") . "</td></tr>";
                                    }
                                    echo "</table></td>";

                                    echo "<td><table>";
                                    foreach ($kmArrivals as $kmArrival) {
                                        /* echo "<tr><td style='overflow-x: scroll; display: block; width: auto;'>".$this->Time->format($releaseDate, '%d-%m-%Y %H:%M')."</td></tr>";*/
                                        echo "<tr style='font-size: 11px;'><td >" . number_format($kmArrival, 0, ",", ".") . "</td></tr>";
                                    }
                                    echo "</table></td>";
                                    echo "<td><table>";
                                    foreach ($kmTraveleds as $kmTraveled) {
                                        /* echo "<tr><td style='overflow-x: scroll; display: block; width: auto;'>".$this->Time->format($releaseDate, '%d-%m-%Y %H:%M')."</td></tr>";*/
                                        echo "<tr style='font-size: 11px;'><td >" . number_format($kmTraveled, 0, ",", ".") . "</td></tr>";
                                    }
                                    echo "</table></td>";
                                    echo "<td class='right'>" . number_format($indKm, 0, ",", ".") . "</td>";
                                    echo "<td><table>";
                                    $currentCustomer = null;
                                    foreach ($customers as $customer) {
                                        if ($customer != $currentCustomer) {
                                            echo "<tr style='font-size: 11px;'><td>" . $customer . "</td></tr>";
                                        }
                                        $currentCustomer = $customer;
                                    }
                                    echo "</table></td>";

                                    echo "<td class='right'>" . number_format($couponNbr, 0, ",", ".") . "</td>";
                                    echo "<td><table>";
                                    foreach ($serialNumbers as $serialNumber) {
                                        echo "<tr style='font-size: 11px;'><td >" . $serialNumber . "</td></tr>";
                                    }
                                    echo "</table></td>";
                                    echo "<td class='right'>" . number_format($species, 0, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($speciesCard, 0, ",", ".") . "</td>";
                                    echo "<td><table>";
                                    foreach ($cards as $card) {
                                        echo "<tr style='font-size: 11px;'><td >" . $card . "</td></tr>";
                                    }
                                    echo "</table></td>";
                                    echo "<td class='right'>" . number_format($literTank, 0, ",", ".") . "</td>";
                                    echo "<td><table>";
                                    foreach ($tanks as $tank) {
                                        echo "<tr style='font-size: 11px;'><td >" . $tank . "</td></tr>";
                                    }
                                    echo "</table></td>";
                                    if ($indKm > 0) {
                                        if ($couponNbr > 0) {
                                            $km_coupon = $indKm / $couponNbr;
                                        } else {
                                            $km_coupon = 0;
                                        }

                                        $liter_km = ($liter_coupon * 100) / $indKm;
                                    } else {
                                        $km_coupon = 0;
                                        $liter_km = 0;
                                    }
                                    echo "<td class='right'>" . number_format($km_coupon, 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($liter_coupon, 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($liter_km, 2, ",", ".") . "</td></tr>";
                                    // Next item
                                    $couponNbr = 0;
                                    $species = 0;
                                    $speciesCard = 0;
                                    $literTank = 0;
                                    $indKm = 0;
                                    $km_coupon = 0;
                                    $liter_coupon = 0;
                                    $liter_km = 0;
                                    $serialNumbers = array();
                                    $cards = array();
                                    $releaseDates = array();
                                    $kmDepartures = array();
                                    $kmArrivals = array();
                                    $kmTraveleds = array();
                                    $customers = array();
                                    if ($param == 1) {
                                        $car_name = $result['car']['code'] . " - " . $result['carmodels']['name'];
                                    } else if ($param == 2) {
                                        $car_name = $result['car']['immatr_def'] . " - " . $result['carmodels']['name'];
                                    }
                                    $liter_coupon = $coupon_price / (float)$result['fuels']['price'];
                                    if ($result['sheet_rides']['km_departure'] > 0 && $result['sheet_rides']['km_arrival'] > 0) {
                                        $indKm += $result['sheet_rides']['km_arrival'] - $result['sheet_rides']['km_departure'];
                                    }

                                    $couponNbr += $result['consumptions']['nb_coupon'];
                                    $species += $result['consumptions']['species'];
                                    $speciesCard += $result['consumptions']['species_card'];
                                    $literTank += $result['consumptions']['consumption_liter'];

                                    if ($currentConsumption == $result['sheet_rides']['id']) {
                                        $date = $result['sheet_rides']['real_start_date'];
                                        $km1 = $result['sheet_rides']['km_departure'];
                                        $km2 = $result['sheet_rides']['km_arrival'];
                                        if ($result['sheet_rides']['km_arrival'] > 0 && $result['sheet_rides']['km_departure'] > 0) {
                                            $km3 = $result['sheet_rides']['km_arrival'] - $result['sheet_rides']['km_departure'];
                                        } else $km3 = 0;
                                        if ($num_coupon == '') {
                                            $num_coupon = $result['coupons']['serial_number'];
                                        } else {
                                            $num_coupon = $num_coupon . ' , ' . $result['coupons']['serial_number'];
                                        }

                                        if ($reference_card == '') {
                                            $reference_card = $result['fuel_cards']['reference'];
                                        } else {
                                            $reference_card = $reference_card . ' , ' . $result['fuel_cards']['reference'];
                                        }

                                        if ($reference_tank == '') {
                                            $reference_tank = $result['tanks']['name'];
                                        } else {
                                            $reference_tank = $reference_tank . ' , ' . $result['tanks']['name'];
                                        }
                                        $date_departure = $result['sheet_rides']['real_start_date'];
                                        $km_departure = $result['sheet_rides']['km_departure'];
                                        $km_arrival = $result['sheet_rides']['km_arrival'];

                                        if ($result['sheet_rides']['km_arrival'] > 0 && $result['sheet_rides']['km_departure'] > 0) {
                                            $km_traveled = $result['sheet_rides']['km_arrival'] - $result['sheet_rides']['km_departure'];
                                        } else $km_traveled = 0;
                                    } else {
                                        $serialNumbers[] = $num_coupon;
                                        $num_coupon = '';
                                        $cards[] = $reference_card;
                                        $reference_card = '';
                                        $tanks[] = $reference_tank;
                                        $reference_tank = '';
                                        $releaseDates[] = $date;
                                        $kmDepartures[] = $km1;
                                        $kmArrivals[] = $km2;
                                        $kmTraveleds[] = $km3;
                                        $date = '';
                                        $km1 = '';
                                        $km2 = '';
                                        $km3 = '';
                                        $currentConsumption = $result['sheet_rides']['id'];

                                    }

                                    $customers[] = $result['customers']['first_name'] . " " . $result['customers']['last_name'];
                                    $currentCar = $result['car']['id'];
                                }


                                if ($i == count($results)) {
                                    $serialNumbers[] = $num_coupon;
                                    $cards[] = $reference_card;
                                    $tanks[] = $reference_tank;
                                    $releaseDates[] = $result['sheet_rides']['real_start_date'];
                                    $kmDepartures[] = $result['sheet_rides']['km_departure'];
                                    $kmArrivals[] = $result['sheet_rides']['km_arrival'];
                                    if ($result['sheet_rides']['km_arrival'] > 0 && $result['sheet_rides']['km_departure'] > 0) {
                                        $kmTraveleds[] = $result['sheet_rides']['km_arrival'] - $result['sheet_rides']['km_departure'];
                                    } else $kmTraveleds[] = 0;
                                    $num_coupon = $result['coupons']['serial_number'];
                                    $reference_card = $result['fuel_cards']['reference'];
                                    $reference_tank = $result['tanks']['name'];
                                    $currentConsumption = $result['sheet_rides']['id'];

                                    $j++;

                                    if ($param == 1) {
                                        echo "<tr style='width: auto;'>" .
                                            "<td colspan='17' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
background-color: rgba(16, 196, 105, 0.15) !important;
color: #10c469 !important;font-weight: bold;'>" . $car_name = $result['car']['code'] . " - " . $result['carmodels']['name'] . "</td></tr>";
                                    } else if ($param == 2) {
                                        echo "<tr style='width: auto;'>" .
                                            "<td colspan='17' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
background-color: rgba(16, 196, 105, 0.15) !important;
color: #10c469 !important;font-weight: bold;'>" . $result['car']['immatr_def'] . " - " . $result['carmodels']['name'] . "</td></tr>";
                                    }
                                    echo "<tr style='font-size: 11px;'><td class='right'>" . $j . "</td>";

                                    echo "<td><table>";
                                    foreach ($releaseDates as $releaseDate) {
                                        echo "<tr style='font-size: 11px;'><td >" . $this->Time->format($releaseDate, '%d-%m-%Y %H:%M') . "</td></tr>";
                                    }
                                    echo "</table></td>";
                                    echo "<td><table>";
                                    foreach ($kmDepartures as $kmDeparture) {
                                        echo "<tr style='font-size: 11px;'><td >" . number_format($kmDeparture, 0, ",", ".") . "</td></tr>";
                                    }
                                    echo "</table></td>";
                                    echo "<td><table>";
                                    foreach ($kmArrivals as $kmArrival) {
                                        echo "<tr style='font-size: 11px;'><td >" . number_format($kmArrival, 0, ",", ".") . "</td></tr>";
                                    }
                                    echo "</table></td>";

                                    echo "<td><table>";
                                    foreach ($kmTraveleds as $kmTraveled) {
                                        echo "<tr style='font-size: 11px;'><td >" . number_format($kmTraveled, 0, ",", ".") . "</td></tr>";
                                    }
                                    echo "</table></td>";

                                    echo "<td class='right'>" . number_format($indKm, 0, ",", ".") . "</td>";
                                    echo "<td><table>";
                                    $currentCustomer = "";
                                    foreach ($customers as $customer) {
                                        if ($customer != $currentCustomer) {
                                            echo "<tr  style='font-size: 11px;'><td>" . $customer . "</td></tr>";
                                        }
                                        $currentCustomer = $customer;
                                    }
                                    echo "</table></td>";
                                    echo "<td class='right'>" . number_format($couponNbr, 0, ",", ".") . "</td>";
                                    echo "<td><table>";
                                    foreach ($serialNumbers as $serialNumber) {
                                        echo "<tr style='font-size: 11px;'><td >" . $serialNumber . "</td></tr>";
                                    }
                                    echo "</table></td>";
                                    echo "<td class='right'>" . number_format($species, 0, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($speciesCard, 0, ",", ".") . "</td>";
                                    echo "<td><table>";
                                    foreach ($cards as $card) {
                                        echo "<tr style='font-size: 11px;'><td >" . $card . "</td></tr>";
                                    }
                                    echo "</table></td>";
                                    echo "<td class='right'>" . number_format($literTank, 0, ",", ".") . "</td>";
                                    echo "<td><table>";
                                    foreach ($tanks as $tank) {
                                        echo "<tr style='font-size: 11px;'><td >" . $tank . "</td></tr>";
                                    }
                                    echo "</table></td>";
                                    if ($indKm > 0) {
                                        if ($couponNbr > 0) {
                                            $km_coupon = $indKm / $couponNbr;
                                        } else {
                                            $km_coupon = 0;
                                        }

                                        $liter_km = ($liter_coupon * 100) / $indKm;
                                    } else {
                                        $km_coupon = 0;
                                        $liter_km = 0;
                                    }
                                    echo "<td class='right'>" . number_format($km_coupon, 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($liter_coupon, 2, ",", ".") . "</td>";
                                    echo "<td class='right'>" . number_format($liter_km, 2, ",", ".") . "</td></tr>";
                                }


                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
<?php $this->start('script'); ?>
    <!-- InputMask -->
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('tableExport/tableExport'); ?>
<?= $this->Html->script('tableExport/jquery.base64'); ?>
<?= $this->Html->script('tableExport/html2canvas'); ?>
<?= $this->Html->script('tableExport/jspdf/jspdf'); ?>
<?= $this->Html->script('tableExport/jspdf/libs/sprintf'); ?>
<?= $this->Html->script('tableExport/jspdf/libs/base64'); ?>
    <!-- Page script -->
    <script type="text/javascript">

        $(document).ready(function () {
            jQuery("#startdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            jQuery("#enddate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});


        });

        function exportDataPdf() {
            var car_consumption = new Array();
            car_consumption[0] = jQuery('#car').val();
            car_consumption[1] = jQuery('#startdate').val();
            car_consumption[2] = jQuery('#enddate').val();
            var url = '<?php echo $this->Html->url(array('action' => 'consumptionsdetails_pdf', 'ext' => 'pdf'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="carconsumption" value="' + car_consumption + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();


        }

        function exportDataExcel() {
            var car_consumption = new Array();
            car_consumption[0] = jQuery('#car').val();
            car_consumption[1] = jQuery('#startdate').val();
            car_consumption[2] = jQuery('#enddate').val();
            var url = '<?php echo $this->Html->url(array('action' => 'export_consumptionsdetails'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="carconsumption" value="' + car_consumption + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();
        }

        function exportSynExcel() {
            var car_consumption = new Array();
            car_consumption[0] = jQuery('#car').val();
            car_consumption[1] = jQuery('#startdate').val();
            car_consumption[2] = jQuery('#enddate').val();
            var url = '<?php echo $this->Html->url(array('action' => 'export_synthese'))?>';
            var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="carconsumption" value="' + car_consumption + '" />' +
            '</form>');
            jQuery('body').append(form);
            form.submit();
        }
    </script>
<?php $this->end(); ?>