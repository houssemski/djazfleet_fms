<style>
    .flot-x-axis div {
        max-width: 100% !important;
        width: auto !important;
        transform: rotate(-90deg) !important;
        top: 340px !important;
    }

    .content {
        overflow: hidden;
    }
</style>
<?php

$this->start('css');
echo $this->Html->css('select2/select2.min');
$this->end();
?>

<h4 class="page-title"> <?= __('Supplier card') . ' ' . $supplier['Supplier']['name']; ?></h4>
<div class="box-body">
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <?php if (Configure::read("gestion_commercial") == '1') { ?>
                    <div class="nav-tabs-custom pdg_btm">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('Missions') ?></a></li>
                            <li><a href="#tab_2" data-toggle="tab"><?= __('Preinvoices') ?></a></li>
                            <li><a href="#tab_3" data-toggle="tab"><?= __('Invoices') ?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">

                                <table class="table table-striped table-bordered dt-responsive nowrap"
                                       cellspacing="0" width="100%" id='table_consumption'>
                                    <thead style="width: auto">
                                    <th><?= __('Ride') ?></th>
                                    <th
                                    =><?= __('Real Departure date'); ?></th>
                                    <th><?= __('Real Arrival date'); ?></th>
                                    <th><?= __('Price') ?></th>

                                    </thead>
                                    <tbody>
                                    <?php
                                    $previousMonth = null;

                                    $sumPriceMonth = 0;
                                    $sumPrice = 0;
                                    foreach ($results as $result) {
                                        $date = date_parse($result['SheetRideDetailRides']['real_start_date']);
                                        $currentMonth = $date['month'];
                                        for ($i = 1; $i <= 12; $i++) {
                                            switch ($i) {
                                                case 1 :
                                                    $label = __("January");
                                                    break;
                                                case 2 :
                                                    $label = __("February");
                                                    break;
                                                case 3 :
                                                    $label = __("March");
                                                    break;
                                                case 4 :
                                                    $label = __("April");
                                                    break;
                                                case 5 :
                                                    $label = __("May");
                                                    break;
                                                case 6 :
                                                    $label = __("June");
                                                    break;
                                                case 7 :
                                                    $label = __("July");
                                                    break;
                                                case 8 :
                                                    $label = __("August");
                                                    break;
                                                case 9 :
                                                    $label = __("September");
                                                    break;
                                                case 10 :
                                                    $label = __("October");
                                                    break;
                                                case 11 :
                                                    $label = __("November");
                                                    break;
                                                case 12 :
                                                    $label = __("December");
                                                    break;
                                            }
                                            $date = date_parse($result['SheetRideDetailRides']['real_start_date']);

                                            if ($date['month'] == $i) {
                                                if ($currentMonth != $previousMonth) {
                                                    if ($previousMonth != null) { ?>

                                                        <tr style='width: auto;'>
                                                            <td colspan='14'
                                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                                        </tr>
                                                        <?php
                                                        $sumPriceMonth = 0;
                                                        $sumAmountRemainingMonth = 0;
                                                    }
                                                    echo "<tr style='width: auto;'>" .
                                                        "<td colspan='14' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
background-color: rgba(16, 196, 105, 0.15) !important;
color: #10c469 !important;font-weight:bold;'>"
                                                        . $label . "</td></tr>";

                                                    echo "<td>" . $result['DepartureDestination']['name'] . '-' . $result['ArrivalDestination']['name'] . '-' . $result['CarType']['name'] . "</td>";

                                                    echo "<td>" . $this->Time->format($result['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y %H:%M') . "</td>";

                                                    echo "<td>" . $this->Time->format($result['SheetRideDetailRides']['real_end_date'], '%d-%m-%Y %H:%M') . "</td>";

                                                    echo "<td class='right'>" . number_format($result['SheetRideDetailRides']['price_ttc'], 2, ",", ".") . "</td></tr>";
                                                    $sumPriceMonth = $sumPriceMonth + $result['SheetRideDetailRides']['price_ttc'];
                                                    $sumPrice = $sumPrice + $result['SheetRideDetailRides']['price_ttc'];
                                                } else {

                                                    echo "<td>" . $result['DepartureDestination']['name'] . '-' . $result['ArrivalDestination']['name'] . '-' . $result['CarType']['name'] . "</td>";

                                                    echo "<td>" . $this->Time->format($result['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y %H:%M') . "</td>";

                                                    echo "<td>" . $this->Time->format($result['SheetRideDetailRides']['real_end_date'], '%d-%m-%Y %H:%M') . "</td>";

                                                    echo "<td class='right'>" . number_format($result['SheetRideDetailRides']['price_ttc'], 2, ",", ".") . "</td></tr>";
                                                    $sumPriceMonth = $sumPriceMonth + $result['SheetRideDetailRides']['price_ttc'];
                                                    $sumPrice = $sumPrice + $result['SheetRideDetailRides']['price_ttc'];

                                                }
                                                $previousMonth = $currentMonth;
                                            }
                                        }
                                    } ?>
                                    <tr style='width: auto;'>
                                        <td colspan='14'
                                            style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                    </tr>
                                    <tr style='width: auto;'>
                                        <td colspan='14'
                                            style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total Missions') . "</span>" . number_format($sumPrice, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                    </tr>


                                    </tbody>
                                </table>


                            </div>
                            <div class="tab-pane " id="tab_2">

                                <table class="table table-striped table-bordered dt-responsive nowrap"
                                       cellspacing="0" width="100%" id='table_consumption'>
                                    <thead style="width: auto">


                                    <th><?= __('Reference') ?></th>

                                    <th
                                    =><?= __('Date'); ?></th>

                                    <th><?= __('Total TTC') ?></th>
                                    <th><?= __('Amount remaining') ?></th>

                                    </thead>
                                    <tbody>
                                    <?php
                                    $previousMonth = null;

                                    $sumPriceMonth = 0;
                                    $sumAmountRemainingMonth = 0;
                                    $sumPrice = 0;
                                    $sumAmountRemaining = 0;
                                    foreach ($preinvoices as $preinvoice) {
                                        $date = date_parse($preinvoice['TransportBill']['date']);
                                        $currentMonth = $date['month'];
                                        for ($i = 1; $i <= 12; $i++) {
                                            switch ($i) {
                                                case 1 :
                                                    $label = __("January");
                                                    break;
                                                case 2 :
                                                    $label = __("February");
                                                    break;
                                                case 3 :
                                                    $label = __("March");
                                                    break;
                                                case 4 :
                                                    $label = __("April");
                                                    break;
                                                case 5 :
                                                    $label = __("May");
                                                    break;
                                                case 6 :
                                                    $label = __("June");
                                                    break;
                                                case 7 :
                                                    $label = __("July");
                                                    break;
                                                case 8 :
                                                    $label = __("August");
                                                    break;
                                                case 9 :
                                                    $label = __("September");
                                                    break;
                                                case 10 :
                                                    $label = __("October");
                                                    break;
                                                case 11 :
                                                    $label = __("November");
                                                    break;
                                                case 12 :
                                                    $label = __("December");
                                                    break;
                                            }
                                            $date = date_parse($preinvoice['TransportBill']['date']);

                                            if ($date['month'] == $i) {
                                                if ($currentMonth != $previousMonth) {
                                                    if ($previousMonth != null) { ?>

                                                        <tr style='width: auto;'>
                                                            <td colspan='14'
                                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total TTC par mois ') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                                        </tr>
                                                        <tr style='width: auto;'>
                                                            <td colspan='14'
                                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Reste à payer par mois ') . "</span>" . number_format($sumAmountRemainingMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                                        </tr>

                                                        <?php
                                                        $sumPriceMonth = 0;
                                                    }
                                                    echo "<tr style='width: auto;'>" .
                                                        "<td colspan='14' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
background-color: rgba(16, 196, 105, 0.15) !important;
color: #10c469 !important;font-weight:bold;'>"
                                                        . $label . "</td></tr>";

                                                    echo "<td>" . $preinvoice['TransportBill']['reference'] . "</td>";

                                                    echo "<td>" . $this->Time->format($preinvoice['TransportBill']['date'], '%d-%m-%Y') . "</td>";


                                                    echo "<td class='right'>" . number_format($preinvoice['TransportBill']['total_ttc'], 2, ",", ".") . "</td>";
                                                    echo "<td class='right'>" . number_format($preinvoice['TransportBill']['amount_remaining'], 2, ",", ".") . "</td></tr>";
                                                    $sumPriceMonth = $sumPriceMonth + $preinvoice['TransportBill']['total_ttc'];
                                                    $sumPrice = $sumPrice + $preinvoice['TransportBill']['total_ttc'];
                                                } else {

                                                    echo "<td>" . $preinvoice['TransportBill']['reference'] . "</td>";

                                                    echo "<td>" . $this->Time->format($preinvoice['TransportBill']['date'], '%d-%m-%Y') . "</td>";

                                                    echo "<td class='right'>" . number_format($preinvoice['TransportBill']['total_ttc'], 2, ",", ".") . "</td>";

                                                    echo "<td class='right'>" . number_format($preinvoice['TransportBill']['amount_remaining'], 2, ",", ".") . "</td></tr>";
                                                    $sumPriceMonth = $sumPriceMonth + $preinvoice['TransportBill']['total_ttc'];
                                                    $sumAmountRemainingMonth = $sumAmountRemainingMonth + $preinvoice['TransportBill']['amount_remaining'];
                                                    $sumPrice = $sumPrice + $preinvoice['TransportBill']['total_ttc'];
                                                    $sumAmountRemaining = $sumAmountRemaining + $preinvoice['TransportBill']['total_ttc'];

                                                }
                                                $previousMonth = $currentMonth;
                                            }
                                        }
                                    }
                                    $reglement = $sumPrice - $sumAmountRemaining;
                                    ?>
                                    <tr style='width: auto;'>
                                        <td colspan='14'
                                            style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total TTC par mois ') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                    </tr>
                                    <tr style='width: auto;'>
                                        <td colspan='14'
                                            style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Reste à payer par mois ') . "</span>" . number_format($sumAmountRemainingMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                    </tr>
                                    <tr style='width: auto;'>
                                        <td colspan='14'
                                            style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total Préfacturés') . "</span>" . number_format($sumPrice, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                    </tr>
                                    <tr style='width: auto;'>
                                        <td colspan='14'
                                            style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Règlement') . "</span>" . number_format($reglement, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                    </tr>
                                    <tr style='width: auto;'>
                                        <td colspan='14'
                                            style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Reste à payer') . "</span>" . number_format($sumAmountRemaining, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                    </tr>


                                    </tbody>
                                </table>


                            </div>
                            <div class="tab-pane " id="tab_3">

                                <table class="table table-striped table-bordered dt-responsive nowrap"
                                       cellspacing="0" width="100%" id='table_consumption'>
                                    <thead style="width: auto">


                                    <th><?= __('Reference') ?></th>

                                    <th
                                    =><?= __('Date'); ?></th>

                                    <th><?= __('Total TTC') ?></th>
                                    <th><?= __('Amount remaining') ?></th>

                                    </thead>
                                    <tbody>
                                    <?php
                                    $previousMonth = null;

                                    $sumPriceMonth = 0;
                                    $sumAmountRemainingMonth = 0;
                                    $sumPrice = 0;
                                    $sumAmountRemaining = 0;
                                    foreach ($invoices as $invoice) {
                                        $date = date_parse($invoice['TransportBill']['date']);
                                        $currentMonth = $date['month'];
                                        for ($i = 1; $i <= 12; $i++) {
                                            switch ($i) {
                                                case 1 :
                                                    $label = __("January");
                                                    break;
                                                case 2 :
                                                    $label = __("February");
                                                    break;
                                                case 3 :
                                                    $label = __("March");
                                                    break;
                                                case 4 :
                                                    $label = __("April");
                                                    break;
                                                case 5 :
                                                    $label = __("May");
                                                    break;
                                                case 6 :
                                                    $label = __("June");
                                                    break;
                                                case 7 :
                                                    $label = __("July");
                                                    break;
                                                case 8 :
                                                    $label = __("August");
                                                    break;
                                                case 9 :
                                                    $label = __("September");
                                                    break;
                                                case 10 :
                                                    $label = __("October");
                                                    break;
                                                case 11 :
                                                    $label = __("November");
                                                    break;
                                                case 12 :
                                                    $label = __("December");
                                                    break;
                                            }
                                            $date = date_parse($invoice['TransportBill']['date']);

                                            if ($date['month'] == $i) {
                                                if ($currentMonth != $previousMonth) {
                                                    if ($previousMonth != null) { ?>

                                                        <tr style='width: auto;'>
                                                            <td colspan='14'
                                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total TTC par mois ') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                                        </tr>
                                                        <tr style='width: auto;'>
                                                            <td colspan='14'
                                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Reste à payer par mois ') . "</span>" . number_format($sumAmountRemainingMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                                        </tr>

                                                        <?php
                                                        $sumPriceMonth = 0;
                                                    }
                                                    echo "<tr style='width: auto;'>" .
                                                        "<td colspan='14' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
background-color: rgba(16, 196, 105, 0.15) !important;
color: #10c469 !important;font-weight:bold;'>"
                                                        . $label . "</td></tr>";

                                                    echo "<td>" . $invoice['TransportBill']['reference'] . "</td>";

                                                    echo "<td>" . $this->Time->format($invoice['TransportBill']['date'], '%d-%m-%Y') . "</td>";


                                                    echo "<td class='right'>" . number_format($invoice['TransportBill']['total_ttc'], 2, ",", ".") . "</td>";
                                                    echo "<td class='right'>" . number_format($invoice['TransportBill']['amount_remaining'], 2, ",", ".") . "</td></tr>";
                                                    $sumPriceMonth = $sumPriceMonth + $invoice['TransportBill']['total_ttc'];
                                                    $sumPrice = $sumPrice + $invoice['TransportBill']['total_ttc'];
                                                } else {

                                                    echo "<td>" . $invoice['TransportBill']['reference'] . "</td>";

                                                    echo "<td>" . $this->Time->format($invoice['TransportBill']['date'], '%d-%m-%Y') . "</td>";

                                                    echo "<td class='right'>" . number_format($invoice['TransportBill']['total_ttc'], 2, ",", ".") . "</td>";

                                                    echo "<td class='right'>" . number_format($invoice['TransportBill']['amount_remaining'], 2, ",", ".") . "</td></tr>";
                                                    $sumPriceMonth = $sumPriceMonth + $invoice['TransportBill']['total_ttc'];
                                                    $sumAmountRemainingMonth = $sumAmountRemainingMonth + $invoice['TransportBill']['amount_remaining'];
                                                    $sumPrice = $sumPrice + $preinvoice['TransportBill']['total_ttc'];
                                                    $sumAmountRemaining = $sumAmountRemaining + $invoice['TransportBill']['total_ttc'];

                                                }
                                                $previousMonth = $currentMonth;
                                            }
                                        }
                                    }
                                    $reglement = $sumPrice - $sumAmountRemaining;
                                    ?>
                                    <tr style='width: auto;'>
                                        <td colspan='14'
                                            style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total TTC par mois ') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                    </tr>
                                    <tr style='width: auto;'>
                                        <td colspan='14'
                                            style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Reste à payer par mois ') . "</span>" . number_format($sumAmountRemainingMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                    </tr>
                                    <tr style='width: auto;'>
                                        <td colspan='14'
                                            style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total Facturés') . "</span>" . number_format($sumPrice, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                    </tr>
                                    <tr style='width: auto;'>
                                        <td colspan='14'
                                            style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Règlement') . "</span>" . number_format($reglement, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                    </tr>
                                    <tr style='width: auto;'>
                                        <td colspan='14'
                                            style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Reste à payer') . "</span>" . number_format($sumAmountRemaining, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                    </tr>


                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>

                <?php } else {
                    if ($supplier['Supplier']['type'] == SupplierTypesEnum::customer) { ?>


                        <div class="nav-tabs-custom pdg_btm">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('Quotation') ?></a></li>
                                <li><a href="#tab_2" data-toggle="tab"><?= __('Orders') ?></a></li>
                                <li><a href="#tab_3" data-toggle="tab"><?= __('Delivery orders') ?></a></li>
                                <li><a href="#tab_4" data-toggle="tab"><?= __('Invoices') ?></a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <table class="table table-striped table-bordered dt-responsive nowrap"
                                           cellspacing="0" width="100%" id='table_consumption'>
                                        <thead style="width: auto">


                                        <th><?= __('Reference') ?></th>

                                        <th><?= __('Date'); ?></th>

                                        <th><?= __('Total TTC') ?></th>
                                        <th><?= __('Amount remaining') ?></th>

                                        </thead>
                                        <tbody>
                                        <?php
                                        $previousMonth = null;

                                        $sumPriceMonth = 0;
                                        $sumAmountRemainingMonth = 0;
                                        $sumPrice = 0;
                                        $sumAmountRemaining = 0;
                                        foreach ($quotes as $quote) {
                                            $date = date_parse($quote['Bill']['date']);
                                            $currentMonth = $date['month'];
                                            for ($i = 1; $i <= 12; $i++) {
                                                switch ($i) {
                                                    case 1 :
                                                        $label = __("January");
                                                        break;
                                                    case 2 :
                                                        $label = __("February");
                                                        break;
                                                    case 3 :
                                                        $label = __("March");
                                                        break;
                                                    case 4 :
                                                        $label = __("April");
                                                        break;
                                                    case 5 :
                                                        $label = __("May");
                                                        break;
                                                    case 6 :
                                                        $label = __("June");
                                                        break;
                                                    case 7 :
                                                        $label = __("July");
                                                        break;
                                                    case 8 :
                                                        $label = __("August");
                                                        break;
                                                    case 9 :
                                                        $label = __("September");
                                                        break;
                                                    case 10 :
                                                        $label = __("October");
                                                        break;
                                                    case 11 :
                                                        $label = __("November");
                                                        break;
                                                    case 12 :
                                                        $label = __("December");
                                                        break;
                                                }
                                                $date = date_parse($quote['Bill']['date']);

                                                if ($date['month'] == $i) {
                                                    if ($currentMonth != $previousMonth) {
                                                        if ($previousMonth != null) { ?>

                                                            <tr style='width: auto;'>
                                                                <td colspan='14'
                                                                    style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total TTC par mois ') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                                            </tr>


                                                            <?php
                                                            $sumPriceMonth = 0;
                                                        }
                                                        echo "<tr style='width: auto;'>" .
                                                            "<td colspan='14' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
													background-color: rgba(16, 196, 105, 0.15) !important;
													color: #10c469 !important;font-weight:bold;'>"
                                                            . $label . "</td></tr>";

                                                        echo "<td>" . $quote['Bill']['reference'] . "</td>";

                                                        echo "<td>" . $this->Time->format($quote['Bill']['date'], '%d-%m-%Y') . "</td>";


                                                        echo "<td class='right'>" . number_format($quote['Bill']['total_ttc'], 2, ",", ".") . "</td>";
                                                        echo "<td class='right'>" . number_format($quote['Bill']['amount_remaining'], 2, ",", ".") . "</td></tr>";
                                                        $sumPriceMonth = $sumPriceMonth + $quote['Bill']['total_ttc'];
                                                        $sumPrice = $sumPrice + $quote['Bill']['total_ttc'];
                                                    } else {

                                                        echo "<td>" . $quote['Bill']['reference'] . "</td>";

                                                        echo "<td>" . $this->Time->format($quote['Bill']['date'], '%d-%m-%Y') . "</td>";

                                                        echo "<td class='right'>" . number_format($quote['Bill']['total_ttc'], 2, ",", ".") . "</td>";

                                                        echo "<td class='right'>" . number_format($quote['Bill']['amount_remaining'], 2, ",", ".") . "</td></tr>";
                                                        $sumPriceMonth = $sumPriceMonth + $quote['Bill']['total_ttc'];
                                                        $sumAmountRemainingMonth = $sumAmountRemainingMonth + $quote['Bill']['amount_remaining'];
                                                        $sumPrice = $sumPrice + $quote['Bill']['total_ttc'];
                                                        $sumAmountRemaining = $sumAmountRemaining + $quote['Bill']['total_ttc'];

                                                    }
                                                    $previousMonth = $currentMonth;
                                                }
                                            }
                                        }
                                        $reglement = $sumPrice - $sumAmountRemaining;
                                        ?>
                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total TTC par mois ') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>

                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total devis') . "</span>" . number_format($sumPrice, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>



                                        </tbody>
                                    </table>


                                </div>
                                <div class="tab-pane " id="tab_2">

                                    <table class="table table-striped table-bordered dt-responsive nowrap"
                                           cellspacing="0" width="100%" id='table_consumption'>
                                        <thead style="width: auto">


                                        <th><?= __('Reference') ?></th>

                                        <th><?= __('Date'); ?></th>

                                        <th><?= __('Total TTC') ?></th>
                                        <th><?= __('Amount remaining') ?></th>

                                        </thead>
                                        <tbody>
                                        <?php
                                        $previousMonth = null;

                                        $sumPriceMonth = 0;
                                        $sumAmountRemainingMonth = 0;
                                        $sumPrice = 0;
                                        $sumAmountRemaining = 0;
                                        foreach ($orders as $order) {
                                            $date = date_parse($order['Bill']['date']);
                                            $currentMonth = $date['month'];
                                            for ($i = 1; $i <= 12; $i++) {
                                                switch ($i) {
                                                    case 1 :
                                                        $label = __("January");
                                                        break;
                                                    case 2 :
                                                        $label = __("February");
                                                        break;
                                                    case 3 :
                                                        $label = __("March");
                                                        break;
                                                    case 4 :
                                                        $label = __("April");
                                                        break;
                                                    case 5 :
                                                        $label = __("May");
                                                        break;
                                                    case 6 :
                                                        $label = __("June");
                                                        break;
                                                    case 7 :
                                                        $label = __("July");
                                                        break;
                                                    case 8 :
                                                        $label = __("August");
                                                        break;
                                                    case 9 :
                                                        $label = __("September");
                                                        break;
                                                    case 10 :
                                                        $label = __("October");
                                                        break;
                                                    case 11 :
                                                        $label = __("November");
                                                        break;
                                                    case 12 :
                                                        $label = __("December");
                                                        break;
                                                }
                                                $date = date_parse($order['Bill']['date']);

                                                if ($date['month'] == $i) {
                                                    if ($currentMonth != $previousMonth) {
                                                        if ($previousMonth != null) { ?>

                                                            <tr style='width: auto;'>
                                                                <td colspan='14'
                                                                    style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total TTC par mois ') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                                            </tr>

                                                            <?php
                                                            $sumPriceMonth = 0;
                                                        }
                                                        echo "<tr style='width: auto;'>" .
                                                            "<td colspan='14' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
													background-color: rgba(16, 196, 105, 0.15) !important;
													color: #10c469 !important;font-weight:bold;'>"
                                                            . $label . "</td></tr>";

                                                        echo "<td>" . $order['Bill']['reference'] . "</td>";

                                                        echo "<td>" . $this->Time->format($order['Bill']['date'], '%d-%m-%Y') . "</td>";


                                                        echo "<td class='right'>" . number_format($order['Bill']['total_ttc'], 2, ",", ".") . "</td>";
                                                        echo "<td class='right'>" . number_format($order['Bill']['amount_remaining'], 2, ",", ".") . "</td></tr>";
                                                        $sumPriceMonth = $sumPriceMonth + $order['Bill']['total_ttc'];
                                                        $sumPrice = $sumPrice + $order['Bill']['total_ttc'];
                                                    } else {

                                                        echo "<td>" . $order['Bill']['reference'] . "</td>";

                                                        echo "<td>" . $this->Time->format($order['Bill']['date'], '%d-%m-%Y') . "</td>";

                                                        echo "<td class='right'>" . number_format($order['Bill']['total_ttc'], 2, ",", ".") . "</td>";

                                                        echo "<td class='right'>" . number_format($order['Bill']['amount_remaining'], 2, ",", ".") . "</td></tr>";
                                                        $sumPriceMonth = $sumPriceMonth + $order['Bill']['total_ttc'];
                                                        $sumAmountRemainingMonth = $sumAmountRemainingMonth + $order['Bill']['amount_remaining'];
                                                        $sumPrice = $sumPrice + $quote['Bill']['total_ttc'];
                                                        $sumAmountRemaining = $sumAmountRemaining + $order['Bill']['total_ttc'];

                                                    }
                                                    $previousMonth = $currentMonth;
                                                }
                                            }
                                        }
                                        $reglement = $sumPrice - $sumAmountRemaining;
                                        ?>
                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total TTC par mois ') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>

                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total commandes') . "</span>" . number_format($sumPrice, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>



                                        </tbody>
                                    </table>


                                </div>
                                <div class="tab-pane " id="tab_3">

                                    <table class="table table-striped table-bordered dt-responsive nowrap"
                                           cellspacing="0" width="100%" id='table_consumption'>
                                        <thead style="width: auto">


                                        <th><?= __('Reference') ?></th>

                                        <th><?= __('Date'); ?></th>

                                        <th><?= __('Total TTC') ?></th>
                                        <th><?= __('Amount remaining') ?></th>

                                        </thead>
                                        <tbody>
                                        <?php
                                        $previousMonth = null;

                                        $sumPriceMonth = 0;
                                        $sumAmountRemainingMonth = 0;
                                        $sumPrice = 0;
                                        $sumAmountRemaining = 0;
                                        foreach ($deliveryOrders as $deliveryOrder) {
                                            $date = date_parse($deliveryOrder['Bill']['date']);
                                            $currentMonth = $date['month'];
                                            for ($i = 1; $i <= 12; $i++) {
                                                switch ($i) {
                                                    case 1 :
                                                        $label = __("January");
                                                        break;
                                                    case 2 :
                                                        $label = __("February");
                                                        break;
                                                    case 3 :
                                                        $label = __("March");
                                                        break;
                                                    case 4 :
                                                        $label = __("April");
                                                        break;
                                                    case 5 :
                                                        $label = __("May");
                                                        break;
                                                    case 6 :
                                                        $label = __("June");
                                                        break;
                                                    case 7 :
                                                        $label = __("July");
                                                        break;
                                                    case 8 :
                                                        $label = __("August");
                                                        break;
                                                    case 9 :
                                                        $label = __("September");
                                                        break;
                                                    case 10 :
                                                        $label = __("October");
                                                        break;
                                                    case 11 :
                                                        $label = __("November");
                                                        break;
                                                    case 12 :
                                                        $label = __("December");
                                                        break;
                                                }
                                                $date = date_parse($deliveryOrder['Bill']['date']);

                                                if ($date['month'] == $i) {
                                                    if ($currentMonth != $previousMonth) {
                                                        if ($previousMonth != null) { ?>

                                                            <tr style='width: auto;'>
                                                                <td colspan='14'
                                                                    style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total TTC par mois ') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                                            </tr>
                                                            <tr style='width: auto;'>
                                                                <td colspan='14'
                                                                    style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Reste à payer par mois ') . "</span>" . number_format($sumAmountRemainingMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                                            </tr>

                                                            <?php
                                                            $sumPriceMonth = 0;
                                                        }
                                                        echo "<tr style='width: auto;'>" .
                                                            "<td colspan='14' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
													background-color: rgba(16, 196, 105, 0.15) !important;
													color: #10c469 !important;font-weight:bold;'>"
                                                            . $label . "</td></tr>";

                                                        echo "<td>" . $deliveryOrder['Bill']['reference'] . "</td>";

                                                        echo "<td>" . $this->Time->format($deliveryOrder['Bill']['date'], '%d-%m-%Y') . "</td>";


                                                        echo "<td class='right'>" . number_format($deliveryOrder['Bill']['total_ttc'], 2, ",", ".") . "</td>";
                                                        echo "<td class='right'>" . number_format($deliveryOrder['Bill']['amount_remaining'], 2, ",", ".") . "</td></tr>";
                                                        $sumPriceMonth = $sumPriceMonth + $deliveryOrder['Bill']['total_ttc'];
                                                        $sumPrice = $sumPrice + $deliveryOrder['Bill']['total_ttc'];
                                                    } else {

                                                        echo "<td>" . $deliveryOrder['Bill']['reference'] . "</td>";

                                                        echo "<td>" . $this->Time->format($deliveryOrder['Bill']['date'], '%d-%m-%Y') . "</td>";

                                                        echo "<td class='right'>" . number_format($deliveryOrder['Bill']['total_ttc'], 2, ",", ".") . "</td>";

                                                        echo "<td class='right'>" . number_format($deliveryOrder['Bill']['amount_remaining'], 2, ",", ".") . "</td></tr>";
                                                        $sumPriceMonth = $sumPriceMonth + $deliveryOrder['Bill']['total_ttc'];
                                                        $sumAmountRemainingMonth = $sumAmountRemainingMonth + $deliveryOrder['Bill']['amount_remaining'];
                                                        $sumPrice = $sumPrice + $deliveryOrder['Bill']['total_ttc'];
                                                        $sumAmountRemaining = $sumAmountRemaining + $deliveryOrder['Bill']['total_ttc'];

                                                    }
                                                    $previousMonth = $currentMonth;
                                                }
                                            }
                                        }
                                        $reglement = $sumPrice - $sumAmountRemaining;
                                        ?>
                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total TTC par mois ') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>
                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Reste à payer par mois ') . "</span>" . number_format($sumAmountRemainingMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>
                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total livrés') . "</span>" . number_format($sumPrice, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>
                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Règlement') . "</span>" . number_format($reglement, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>
                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Reste à payer') . "</span>" . number_format($sumAmountRemaining, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>


                                        </tbody>
                                    </table>


                                </div>
                                <div class="tab-pane " id="tab_4">


                                    <table class="table table-striped table-bordered dt-responsive nowrap"
                                           cellspacing="0" width="100%" id='table_consumption'>
                                        <thead style="width: auto">


                                        <th><?= __('Reference') ?></th>

                                        <th><?= __('Date'); ?></th>

                                        <th><?= __('Total TTC') ?></th>
                                        <th><?= __('Amount remaining') ?></th>

                                        </thead>
                                        <tbody>
                                        <?php
                                        $previousMonth = null;

                                        $sumPriceMonth = 0;
                                        $sumAmountRemainingMonth = 0;
                                        $sumPrice = 0;
                                        $sumAmountRemaining = 0;
                                        foreach ($invoices as $invoice) {
                                            $date = date_parse($invoice['Bill']['date']);
                                            $currentMonth = $date['month'];
                                            for ($i = 1; $i <= 12; $i++) {
                                                switch ($i) {
                                                    case 1 :
                                                        $label = __("January");
                                                        break;
                                                    case 2 :
                                                        $label = __("February");
                                                        break;
                                                    case 3 :
                                                        $label = __("March");
                                                        break;
                                                    case 4 :
                                                        $label = __("April");
                                                        break;
                                                    case 5 :
                                                        $label = __("May");
                                                        break;
                                                    case 6 :
                                                        $label = __("June");
                                                        break;
                                                    case 7 :
                                                        $label = __("July");
                                                        break;
                                                    case 8 :
                                                        $label = __("August");
                                                        break;
                                                    case 9 :
                                                        $label = __("September");
                                                        break;
                                                    case 10 :
                                                        $label = __("October");
                                                        break;
                                                    case 11 :
                                                        $label = __("November");
                                                        break;
                                                    case 12 :
                                                        $label = __("December");
                                                        break;
                                                }
                                                $date = date_parse($invoice['Bill']['date']);

                                                if ($date['month'] == $i) {
                                                    if ($currentMonth != $previousMonth) {
                                                        if ($previousMonth != null) { ?>

                                                            <tr style='width: auto;'>
                                                                <td colspan='14'
                                                                    style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total TTC par mois ') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                                            </tr>
                                                            <tr style='width: auto;'>
                                                                <td colspan='14'
                                                                    style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Reste à payer par mois ') . "</span>" . number_format($sumAmountRemainingMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                                            </tr>

                                                            <?php
                                                            $sumPriceMonth = 0;
                                                        }
                                                        echo "<tr style='width: auto;'>" .
                                                            "<td colspan='14' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
													background-color: rgba(16, 196, 105, 0.15) !important;
													color: #10c469 !important;font-weight:bold;'>"
                                                            . $label . "</td></tr>";

                                                        echo "<td>" . $invoice['Bill']['reference'] . "</td>";

                                                        echo "<td>" . $this->Time->format($invoice['Bill']['date'], '%d-%m-%Y') . "</td>";


                                                        echo "<td class='right'>" . number_format($invoice['Bill']['total_ttc'], 2, ",", ".") . "</td>";
                                                        echo "<td class='right'>" . number_format($invoice['Bill']['amount_remaining'], 2, ",", ".") . "</td></tr>";
                                                        $sumPriceMonth = $sumPriceMonth + $invoice['Bill']['total_ttc'];
                                                        $sumPrice = $sumPrice + $invoice['Bill']['total_ttc'];
                                                    } else {

                                                        echo "<td>" . $invoice['Bill']['reference'] . "</td>";

                                                        echo "<td>" . $this->Time->format($invoice['Bill']['date'], '%d-%m-%Y') . "</td>";

                                                        echo "<td class='right'>" . number_format($invoice['Bill']['total_ttc'], 2, ",", ".") . "</td>";

                                                        echo "<td class='right'>" . number_format($invoice['Bill']['amount_remaining'], 2, ",", ".") . "</td></tr>";
                                                        $sumPriceMonth = $sumPriceMonth + $invoice['Bill']['total_ttc'];
                                                        $sumAmountRemainingMonth = $sumAmountRemainingMonth + $invoice['Bill']['amount_remaining'];
                                                        $sumPrice = $sumPrice + $invoice['Bill']['total_ttc'];
                                                        $sumAmountRemaining = $sumAmountRemaining + $invoice['Bill']['total_ttc'];

                                                    }
                                                    $previousMonth = $currentMonth;
                                                }
                                            }
                                        }
                                        $reglement = $sumPrice - $sumAmountRemaining;
                                        ?>
                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total TTC par mois ') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>
                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Reste à payer par mois ') . "</span>" . number_format($sumAmountRemainingMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>
                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total Facturés') . "</span>" . number_format($sumPrice, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>
                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Règlement') . "</span>" . number_format($reglement, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>
                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Reste à payer') . "</span>" . number_format($sumAmountRemaining, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>


                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>


                        <?php
                    } else { ?>


                        <div class="nav-tabs-custom pdg_btm">
                            <ul class="nav nav-tabs">
                                <li><a href="#tab_1" data-toggle="tab"><?= __('Orders') ?></a></li>
                                <li><a href="#tab_2" data-toggle="tab"><?= __('Receipts') ?></a></li>
                            </ul>
                            <div class="tab-content">

                                <div class="tab-pane " id="tab_1">

                                    <table class="table table-striped table-bordered dt-responsive nowrap"
                                           cellspacing="0" width="100%" id='table_consumption'>
                                        <thead style="width: auto">


                                        <th><?= __('Reference') ?></th>

                                        <th><?= __('Date'); ?></th>

                                        <th><?= __('Total TTC') ?></th>
                                        <th><?= __('Amount remaining') ?></th>

                                        </thead>
                                        <tbody>
                                        <?php
                                        $previousMonth = null;

                                        $sumPriceMonth = 0;
                                        $sumAmountRemainingMonth = 0;
                                        $sumPrice = 0;
                                        $sumAmountRemaining = 0;
                                        foreach ($orders as $order) {
                                            $date = date_parse($order['Bill']['date']);
                                            $currentMonth = $date['month'];
                                            for ($i = 1; $i <= 12; $i++) {
                                                switch ($i) {
                                                    case 1 :
                                                        $label = __("January");
                                                        break;
                                                    case 2 :
                                                        $label = __("February");
                                                        break;
                                                    case 3 :
                                                        $label = __("March");
                                                        break;
                                                    case 4 :
                                                        $label = __("April");
                                                        break;
                                                    case 5 :
                                                        $label = __("May");
                                                        break;
                                                    case 6 :
                                                        $label = __("June");
                                                        break;
                                                    case 7 :
                                                        $label = __("July");
                                                        break;
                                                    case 8 :
                                                        $label = __("August");
                                                        break;
                                                    case 9 :
                                                        $label = __("September");
                                                        break;
                                                    case 10 :
                                                        $label = __("October");
                                                        break;
                                                    case 11 :
                                                        $label = __("November");
                                                        break;
                                                    case 12 :
                                                        $label = __("December");
                                                        break;
                                                }
                                                $date = date_parse($quote['Bill']['date']);

                                                if ($date['month'] == $i) {
                                                    if ($currentMonth != $previousMonth) {
                                                        if ($previousMonth != null) { ?>

                                                            <tr style='width: auto;'>
                                                                <td colspan='14'
                                                                    style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total TTC par mois ') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                                            </tr>


                                                            <?php
                                                            $sumPriceMonth = 0;
                                                        }
                                                        echo "<tr style='width: auto;'>" .
                                                            "<td colspan='14' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
													background-color: rgba(16, 196, 105, 0.15) !important;
													color: #10c469 !important;font-weight:bold;'>"
                                                            . $label . "</td></tr>";

                                                        echo "<td>" . $order['Bill']['reference'] . "</td>";

                                                        echo "<td>" . $this->Time->format($order['Bill']['date'], '%d-%m-%Y') . "</td>";


                                                        echo "<td class='right'>" . number_format($order['Bill']['total_ttc'], 2, ",", ".") . "</td>";
                                                        echo "<td class='right'>" . number_format($order['Bill']['amount_remaining'], 2, ",", ".") . "</td></tr>";
                                                        $sumPriceMonth = $sumPriceMonth + $order['Bill']['total_ttc'];
                                                        $sumPrice = $sumPrice + $order['Bill']['total_ttc'];
                                                    } else {

                                                        echo "<td>" . $order['Bill']['reference'] . "</td>";

                                                        echo "<td>" . $this->Time->format($order['Bill']['date'], '%d-%m-%Y') . "</td>";

                                                        echo "<td class='right'>" . number_format($order['Bill']['total_ttc'], 2, ",", ".") . "</td>";

                                                        echo "<td class='right'>" . number_format($order['Bill']['amount_remaining'], 2, ",", ".") . "</td></tr>";
                                                        $sumPriceMonth = $sumPriceMonth + $order['Bill']['total_ttc'];
                                                        $sumAmountRemainingMonth = $sumAmountRemainingMonth + $order['Bill']['amount_remaining'];
                                                        $sumPrice = $sumPrice + $quote['Bill']['total_ttc'];
                                                        $sumAmountRemaining = $sumAmountRemaining + $order['Bill']['total_ttc'];

                                                    }
                                                    $previousMonth = $currentMonth;
                                                }
                                            }
                                        }
                                        $reglement = $sumPrice - $sumAmountRemaining;
                                        ?>
                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total TTC par mois ') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>

                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total commandes') . "</span>" . number_format($sumPrice, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>



                                        </tbody>
                                    </table>


                                </div>
                                <div class="tab-pane " id="tab_2">

                                    <table class="table table-striped table-bordered dt-responsive nowrap"
                                           cellspacing="0" width="100%" id='table_consumption'>
                                        <thead style="width: auto">


                                        <th><?= __('Reference') ?></th>

                                        <th><?= __('Date'); ?></th>

                                        <th><?= __('Total TTC') ?></th>
                                        <th><?= __('Amount remaining') ?></th>

                                        </thead>
                                        <tbody>
                                        <?php
                                        $previousMonth = null;

                                        $sumPriceMonth = 0;
                                        $sumAmountRemainingMonth = 0;
                                        $sumPrice = 0;
                                        $sumAmountRemaining = 0;
                                        foreach ($receipts as $receipt) {
                                            $date = date_parse($receipt['Bill']['date']);
                                            $currentMonth = $date['month'];
                                            for ($i = 1; $i <= 12; $i++) {
                                                switch ($i) {
                                                    case 1 :
                                                        $label = __("January");
                                                        break;
                                                    case 2 :
                                                        $label = __("February");
                                                        break;
                                                    case 3 :
                                                        $label = __("March");
                                                        break;
                                                    case 4 :
                                                        $label = __("April");
                                                        break;
                                                    case 5 :
                                                        $label = __("May");
                                                        break;
                                                    case 6 :
                                                        $label = __("June");
                                                        break;
                                                    case 7 :
                                                        $label = __("July");
                                                        break;
                                                    case 8 :
                                                        $label = __("August");
                                                        break;
                                                    case 9 :
                                                        $label = __("September");
                                                        break;
                                                    case 10 :
                                                        $label = __("October");
                                                        break;
                                                    case 11 :
                                                        $label = __("November");
                                                        break;
                                                    case 12 :
                                                        $label = __("December");
                                                        break;
                                                }
                                                $date = date_parse($receipt['Bill']['date']);

                                                if ($date['month'] == $i) {
                                                    if ($currentMonth != $previousMonth) {
                                                        if ($previousMonth != null) { ?>

                                                            <tr style='width: auto;'>
                                                                <td colspan='14'
                                                                    style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total TTC par mois ') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                                            </tr>
                                                            <tr style='width: auto;'>
                                                                <td colspan='14'
                                                                    style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Reste à payer par mois ') . "</span>" . number_format($sumAmountRemainingMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                                            </tr>

                                                            <?php
                                                            $sumPriceMonth = 0;
                                                        }
                                                        echo "<tr style='width: auto;'>" .
                                                            "<td colspan='14' style='border: 1px solid rgba(16, 196, 105, 0.1) !important;
													background-color: rgba(16, 196, 105, 0.15) !important;
													color: #10c469 !important;font-weight:bold;'>"
                                                            . $label . "</td></tr>";

                                                        echo "<td>" . $receipt['Bill']['reference'] . "</td>";

                                                        echo "<td>" . $this->Time->format($receipt['Bill']['date'], '%d-%m-%Y') . "</td>";


                                                        echo "<td class='right'>" . number_format($receipt['Bill']['total_ttc'], 2, ",", ".") . "</td>";
                                                        echo "<td class='right'>" . number_format($receipt['Bill']['amount_remaining'], 2, ",", ".") . "</td></tr>";
                                                        $sumPriceMonth = $sumPriceMonth + $receipt['Bill']['total_ttc'];
                                                        $sumPrice = $sumPrice + $receipt['Bill']['total_ttc'];
                                                    } else {

                                                        echo "<td>" . $receipt['Bill']['reference'] . "</td>";

                                                        echo "<td>" . $this->Time->format($receipt['Bill']['date'], '%d-%m-%Y') . "</td>";

                                                        echo "<td class='right'>" . number_format($receipt['Bill']['total_ttc'], 2, ",", ".") . "</td>";

                                                        echo "<td class='right'>" . number_format($receipt['Bill']['amount_remaining'], 2, ",", ".") . "</td></tr>";
                                                        $sumPriceMonth = $sumPriceMonth + $receipt['Bill']['total_ttc'];
                                                        $sumAmountRemainingMonth = $sumAmountRemainingMonth + $receipt['Bill']['amount_remaining'];
                                                        $sumPrice = $sumPrice + $deliveryOrder['Bill']['total_ttc'];
                                                        $sumAmountRemaining = $sumAmountRemaining + $receipt['Bill']['total_ttc'];

                                                    }
                                                    $previousMonth = $currentMonth;
                                                }
                                            }
                                        }
                                        $reglement = $sumPrice - $sumAmountRemaining;
                                        ?>
                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total TTC par mois ') . "</span>" . number_format($sumPriceMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>
                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Reste à payer par mois ') . "</span>" . number_format($sumAmountRemainingMonth, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>
                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Total recus') . "</span>" . number_format($sumPrice, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>
                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Règlement') . "</span>" . number_format($reglement, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>
                                        <tr style='width: auto;'>
                                            <td colspan='14'
                                                style='background-color: #F9F9F9 !important;font-weight:bold;color:#000; text-align:right'> <?php echo "<span style='float:left'>" . __('Reste à payer') . "</span>" . number_format($sumAmountRemaining, 2, ",", ".") . " " . $this->Session->read("currency"); ?></td>
                                        </tr>


                                        </tbody>
                                    </table>


                                </div>

                            </div>
                        </div>


                    <?php }
                } ?>

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

<!-- Bootstrap -->

<!-- FLOT CHARTS -->
<?= $this->Html->script('plugins/flot/jquery.flot.min'); ?>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<?= $this->Html->script('plugins/flot/jquery.flot.resize.min'); ?>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<?= $this->Html->script('plugins/flot/jquery.flot.pie.min'); ?>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<?= $this->Html->script('plugins/flot/jquery.flot.categories.min'); ?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
<!-- Page script -->
<script type="text/javascript">


    $(document).ready(function () {

        jQuery("#startdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#enddate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        jQuery("#min_month").inputmask("m", {"placeholder": "mm"});
        jQuery("#max_month").inputmask("m", {"placeholder": "mm"});
        $(".select2").select2({
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

    });

    function exportDataPdf() {
        var consumption_month = new Array();
        consumption_month[0] = jQuery('#car').val();
        consumption_month[1] = jQuery('#year').val();
        consumption_month[2] = jQuery('#min_month').val();
        consumption_month[3] = jQuery('#max_month').val();

        var url = '<?php echo $this->Html->url(array('action' => 'consumptionbymonth_pdf', 'ext' => 'pdf'))?>';
        var form = jQuery('<form action="' + url + '" method="post" >' +
            '<input type="text" name="consumptionmonth" value="' + consumption_month + '" />' +
            '</form>');
        jQuery('body').append(form);
        form.submit();


    }

    function exportDataExcel() {

        $('#table_consumption').tableExport({

            type: 'excel',
            espace: 'false',
            htmlContent: 'false'
        });

    }


</script>
<?php $this->end(); ?>