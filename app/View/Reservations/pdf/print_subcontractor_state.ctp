<?php


App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'autoload.inc.php'));

use Dompdf\Dompdf;

ob_start();
?>


<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <style type="text/css">
        <?php if (Configure::read('utranx_ade') != '1'){ ?>
        @page {
            margin: 90px 0;
        }

        #header {
            position: fixed;
            left: 0;
            top: -80px;
            right: 0;
            height: 90px;
            /*border-bottom: 1px solid #000;*/
        }
        <?php }else{ ?>
        @page {
            margin: 0px 0;
        }

        #header {
            left: 0;
            top: -80px;
            right: 0;
            height: 150px;
            /*border-bottom: 1px solid #000;*/
        }
        <?php } ?>
        #header td.company span {
            display: block;
            font-size: 22px;
            padding-bottom: 10px;
            padding-top: 20px;
        }

        #footer {
            position: fixed;
            left: 0;
            bottom: -95px;
            right: 0;
            height: 200px;
        }

        .copyright {
            font-size: 10px;
            text-align: center;
        }

        .title {
            font-weight: bold;
            font-size: 22px;
            text-align: center;
            padding-top: 5px;
            width: 500px;
            margin: 0 auto 10px;
        }

        .customer table {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
            padding-top: 5px;
            margin-left: 40px;
            margin-right: 40px;
        }

        .table-bordered {
            width: 90%;
            margin: 0px auto;
            border-collapse: collapse;
            position: relative;
        }

        .table-bordered>thead>tr>th,
        .table-bordered>tbody>tr>th,
        .table-bordered>tfoot>tr>th,
        .table-bordered>thead>tr>td,
        .table-bordered>tbody>tr>td,
        .table-bordered>tfoot>tr>td {
            border: 1px solid #000;
            font-size: 11px;
        }

        .table-bordered th {
            font-weight: normal;
            padding: 5px 13.4px 5px 13.4px;
            font-size: 11px;
        }

        .tab_cons th {
            padding: 5px 31px 5px 31px;
        }

        .tab_total th {
            padding: 5px 19.4px 5px 19.4px;

        }

        .bon {
            margin-bottom: 10px;
            margin-top: 80px
        }

        .table-bordered td {
            text-align: center;
            font-size: 13px;
        }

        .customer tr td:first-child {
            width: 250px !important;

            padding-bottom: 2px;

        }

        table.bottom td {
            padding-top: 5px;
            font-size: 18px;
        }

        table.footer td.first {
            width: 50%;
            text-align: left
        }

        table.footer td.second {
            width: 50%;
            text-align: left;
        }

        table.conditions td {
            border: 1px solid grey;
        }

        table.conditions td {
            vertical-align: top;
            padding: 5px 5px 5px 10px;
            line-height: 19px;
        }

        table.conditions_bottom td.first {
            width: 420px
        }

        table.conditions_bottom td {
            padding-top: 5px
        }

        .note span {
            display: block;
            text-decoration: underline;
            padding-bottom: 5px;
        }

        .total span {
            padding: 10px 10px;
            line-height: 10px;
            font-size: 13px;
        }

        #footer {
            position: fixed;
            left: 0;
            bottom: -95px;
            right: 0;
            height: 50px;
        }

        .box-body {
            padding: 0;
            margin: 0;
            width: 100%;
            position: relative !important;
        }

        #header table,
        #informations table {
            padding: 0px 50px;
        }

        .separator_section {
            border-top: 2px solid:#000;
            margin: 10px auto 10px;
            width: 80%;

        }

        .tab_ {
            margin-bottom: 40px;
            margin-top: 20px;
        }

        .tab_ thead {
            padding: 5px;
            background: #c0c0c0;
        }

        .tab_ tbody td {
            padding: 5px;
        }
    </style>
</head>

<body style="page-break-inside:avoid;">

<?php if (Configure::read('utranx_ade') == '1' ){ ?>
<div id="header" >
    <?php echo $this->element('pdf/ade-header'); ?>
</div>
    <?php } ?>

    <?php $ii = 0;
    foreach ($allReservations as $supplierName => $reservations) {
    ?>


        <div class="title"><?php echo __('Etat sous-traitant') ?></div>
        <div class="title"><?php
                            if (!empty($reservations)) {
                                echo $supplierName;
                            }
                            ?></div>

        <hr class="separator_section" />
        <div class="box-body">
            <table class='bon table-bordered tab_'>
                <thead>
                    <tr>
                        <th><strong><?php echo __('Date'); ?></strong></th>
                        <th><strong><?php echo __('Client'); ?></strong></th>
                        <th><strong><?php echo  __('Destination'); ?></strong></th>
                        <th><strong><?php echo  __('Mission type'); ?></strong></th>
                        <th><strong><?php echo  __('Tonnage'); ?></strong></th>
                        <th><strong><?php echo  __('Montant'); ?></strong></th>
                        <th><strong><?php echo  __('Recovered amount'); ?></strong></th>
                        <th><strong><?php echo  __('Amount remaining'); ?></strong></th>
                        <th><strong><?php echo  __('Advanced amount'); ?></strong></th>
                        <th><strong><?php echo  __('Paid amount'); ?></strong></th>
                        <th><strong><?php echo  __('Payment date'); ?></strong></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalAmount = 0;
                    $totalAmountToPay = 0;
                    $totalAdvance = 0;
                    $totalAmountRemaining = 0;
                    $totalAdvancedAmount = 0;
                    $totalAmountPayed = 0;
                    foreach ($reservations as $reservation) { ?>
                        <tr>
                            <td><?php echo h($this->Time->format($reservation['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y')); ?>&nbsp;</td>
                            <td><?php echo h($reservation['Supplier']['code'] . ' ' . $reservation['Supplier']['name']); ?>&nbsp;</td>
                            <td><?php echo h($reservation['TransportBillDetailedRides']['designation']); ?>&nbsp;</td>
                            <td>
                                <?php
                                switch ($reservation['TransportBillDetailRides']['delivery_with_return']) {
                                    case 1:
                                        echo __('Simple delivery');
                                        break;
                                    case 2:
                                        echo __('Simple return');
                                        break;
                                    case 3:
                                        echo __('Delivery / Return');
                                        break;
                                    default;
                                }
                                ?>
                            </td>
                            <td><?php echo h($reservation['CarType']['name']); ?>&nbsp;</td>
                            <td><?php
                                $totalAmount = $totalAmount + $reservation['Reservation']['cost'];
                                echo h(number_format($reservation['Reservation']['cost'], 2, ",", $separatorAmount)); ?>&nbsp;
                            </td>
                            <td><?php
                                if (/*$reservation['TransportBill']['order_type']== 2 &&*/
                                    $reservation['SheetRideDetailRides']['price_recovered'] == 1
                                ) {
                                    if ($reservation['TransportBill']['payment_method'] == '6') {
                                        $advance =    ($reservation['TransportBillDetailedRides']['price_ttc'] * 1.01);
                                    } else {
                                        $advance =   $reservation['TransportBillDetailedRides']['price_ttc'];
                                    }
                                } else {
                                    $advance = 0;
                                }
                                $totalAdvance = $totalAdvance + $advance;
                                echo h(number_format($advance, 2, ",", $separatorAmount)); ?>&nbsp;
                            </td>
                            <td><?php
                                $totalAmountRemaining = $totalAmountRemaining + $reservation['Reservation']['amount_remaining'];
                                echo h(number_format($reservation['Reservation']['amount_remaining'], 2, ",", $separatorAmount)); ?>&nbsp;
                            </td>
                            <td><?php
                                $totalAdvancedAmount = $totalAdvancedAmount + $reservation['Reservation']['advanced_amount'];
                                echo h(number_format($reservation['Reservation']['advanced_amount'], 2, ",", $separatorAmount)); ?>&nbsp;

                            </td>
                            <td><?php
                                $totalAmountPayed = $totalAmountPayed + $reservation['DetailPayments']['payroll_amount'];
                                echo h(number_format($reservation['DetailPayments']['payroll_amount'], 2, ",", $separatorAmount));
                                ?>&nbsp;
                            </td>
                            <td><?php echo h($this->Time->format($reservation['Payments']['receipt_date'], '%d-%m-%Y')); ?>&nbsp;</td>

                        </tr>
                    <?php }
                    $totalAmountToPay =  $totalAmountRemaining - $totalAdvancedAmount;
                    ?>
                    <tr>
                        <td colspan=6> <?php echo __('Montant global à régler : '); ?></td>
                        <td><?php echo h(number_format($totalAdvance, 2, ",", $separatorAmount)); ?></td>
                        <td><?php echo h(number_format($totalAmountRemaining, 2, ",", $separatorAmount)); ?></td>
                        <td><?php echo h(number_format($totalAdvancedAmount, 2, ",", $separatorAmount)); ?></td>
                        <td><?php echo h(number_format($totalAmountPayed, 2, ",", $separatorAmount)); ?></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <div style="clear:both;"></div>
            <table class='bon table-bordered tab_'>
                <tr>
                    <td>
                        <?php echo __('Montant global à régler : ');
                        echo number_format($totalAmountToPay, 2, ",", ".") ?>
   <!--  -->                 </td>
                </tr>
            </table>
        </div>
        <?php if ($ii < (count($allReservations) - 1)) { ?>
            <div class="page_break" style="page-break-before: always;"></div>
        <?php } ?>




    <?php
        $ii++;
    } ?>



    <div id="footer">
        <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
    </div>
</body>

</html>
<?php
$html = ob_get_clean();

$this->dompdf = new Dompdf(array('chroot' => WWW_ROOT));
$papersize = "A4";
$orientation = 'portrait';
$this->dompdf->load_html($html);
$this->dompdf->set_paper($papersize, $orientation);
$this->dompdf->render('browser');

$output = $this->dompdf->output();
$name = 'Journal.pdf';
file_put_contents('./document_transport/' . $name, $output);
$urlf = './document_transport/' . $name;
if (file_exists($urlf)) {

    header('Content-Type: application/pdf');

    header('Content-disposition: inline; filename=' . $name);
    header('Pragma: no-cache');
    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    header('Expires: 0');
    readfile($urlf);
    exit();
}
