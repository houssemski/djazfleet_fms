<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <style type="text/css">
        @page {
            margin: 160px 0px 150px 0px;
        }
        #header {
            position: fixed;
            left: 25px;
            top: -150px;
            right: 25px;
            border-bottom: 3px solid #000;
        }
        #header table {
            width: 90%;
        }
        .company {
            vertical-align: top;
            font-weight: bold;
            display: block;
            font-size: 20px;
            padding-top: 10px;
        }
        .copyright {
            font-size: 10px;
            text-align: center;
            padding-top: 65px;
        }
        .uv {
            font-size: 10px;
        }
        .signature {
            font-size: 13px;
            margin-left: 600px;
            margin-top: 50px;
            font-weight: bold;
            width: 1000px;
            height: 100px;
            text-decoration: underline ;

        }

        .info_company {
            width: 600px;
            font-size: 12px;
            line-height: 18px;
        }

        .info_fiscal {
            width: 200px;
            font-size: 12px;
            padding-top: 60px;
            line-height: 18px;
            padding-right: 35px;
        }

        .adr {
            font-weight: normal;
            font-size: 12px;
        }

        .date {
            padding-top: 5px;
            text-align: right;
            padding-right: 25px;
        }

        .box-body {
            padding: 0px 25px ;
            position: relative;
        }

        .bloc-center {
            width: 100%;
        }

        .facture {
            font-size: 18px;
            font-weight: bold;
        }

        .date {
            font-size: 16px;
            font-weight: bold;
            text-align: right;
        }

        .modepayment, .droit {
            padding-top: 30px;
        }

        .modepayment {
            font-size: 12px;
            width: 350px;
        }



        .main-table > thead > tr > th,
        .main-table > tbody > tr > th,
        .main-table > tfoot > tr > th,
        .main-table > thead > tr > td,
        .main-table > tfoot > tr > td {
        // border: 1px solid #000;
        }


        .main-table td{
            vertical-align: top;
            border-left: 0;
            border-right: 1px solid #C0C0C0;
            border-collapse: collapse;
            border-top: 0;
            border-bottom: 0;
        }

        .footer-table td{
            vertical-align: top;
            border-left: 0;
            border-right: 1px solid #FFF;
            border-collapse: collapse;
            border-top: 0;
            border-bottom: 0;
        }

        .main-table th {
            border-right: 1px solid black;
            border-bottom: 1px solid black;
            padding-left: 5px;
            text-align: left;
            border-collapse: collapse;
            font-size: 11px
        }

        .footer-table th {
            border-right: 1px solid white;
            border-bottom: 1px solid white;
            padding-left: 5px;
            text-align: left;
            border-collapse: collapse;
            font-size: 11px
        }
        .main-table {

            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            border: 1px solid black !important;
        }

        .footer-table {

            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            border: 1px solid white !important;
        }
        .total{
            width: 200px;
            height : 40px;
            float:right;
            line-height:10px;

        }
        .total-div span{padding:5px 5px;line-height:10px;font-size:10px;}

        .main-table td {
            text-align: left;
            padding: 3px 5px;;
            font-size: 11px
        }

        .footer-table td {
            text-align: left;
            padding: 3px 5px;;
            font-size: 10px
        }

        .nombre-lettre {
            width: 400px;
            height: 60px;
            float: left;
            margin-left: 50px;
            font-size: 10px;
            line-height: 20px;
        }

        #footer {
            position: fixed;
            left: 0;
            bottom: -100px;
            right: 0;
            height: 250px;
        }

        .left {
            width: 70px;
            height: 8px;
            text-align: left;
            display: inline-block;
            padding-left: 5px;
            font-size: 10px;
            line-height:10px;
        }

        .right {
            width: 120px;
            height: 8px;
            text-align: right;
            display: inline-block;
            font-size: 10px;
            line-height:10px;
        }

        .client {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            display: inline;
        //padding-top: 10px;
        }

        .info_client {
            font-size: 11px;
        }

        .address_client {
            font-size: 11px;
            display: block;
            margin-bottom: 15px;
        }
        .line {
            border-top: 2px solid #000;
        }
    </style>
</head>
<body class='body'>
<div id="header">
    <?php if($entete_pdf=='1') { ?>
        <table>
            <tr>

                <td class='info_company'>
                    <span class="company"><?= $company['LegalForm']['name'].' '.Configure::read("nameCompany") ?></span><br>
                    <span class='adr'><?= $company['Company']['adress'] ?></span><br>
                    <span><strong>Tél. :</strong><?= $company['Company']['phone'] ?></span><br>
                    <span><strong>Fax :</strong><?= $company['Company']['fax'] ?></span><br>
                    <span><strong>Mobile :</strong><?= $company['Company']['mobile'] ?></span><br>
                    <span><strong>Compte :</strong><?= $company['Company']['cb'] ?></span>
                </td>
                <td class="info_fiscal">
                    <span><strong>RC :</strong><?= $company['Company']['rc'] ?></span><br>
                    <span><strong>AI :</strong><?= $company['Company']['ai'] ?></span><br>
                    <span><strong>IF :</strong><?= $company['Company']['nif'] ?></span><br>

                </td>
                <td style='width: 10px'>
                </td>
            </tr>
        </table>
    <?php } ?>
</div>
<div class="box-body">
    <table class="bloc-center">
        <tr>
            <td>
                <?php switch ($type) {
                    case TransportBillTypesEnum::quote :
                        ?>
                        <span class="facture">Devis <?= $facture['TransportBill']['reference']; ?></span>
                        <?php    break;
                    case TransportBillTypesEnum::order :
                        ?>
                        <span class="facture">Bon de commande <?= $facture['TransportBill']['reference'] ?></span>
                        <?php    break;
                    case TransportBillTypesEnum::pre_invoice :
                        ?>
                        <span class="facture">Pr&eacute;facture <?= $facture['TransportBill']['reference'] ?></span>
                        <?php    break;
                    case TransportBillTypesEnum::invoice :
                        ?>
                        <span class="facture">Facture <?= $facture['TransportBill']['reference'] ?></span>
                        <?php    break;

                }
                ?>


            </td>
            <td class="date">
				<span>Le : <?=
                    $this->Time->format($facture['TransportBill']['date'], '%d-%m-%Y')
                    ?></span>
            </td>
        </tr>
        <tr>

            <td class="modepayment">
                <?php if ($type == TransportBillTypesEnum::invoice) {

                    switch($facture['TransportBill']['payment_method']){
                        case 1 :
                            $paymentMethod = __('A terme');
                            break;
                        case 2 :
                            $paymentMethod = __('Chèque');
                            break;
                        case 3 :
                            $paymentMethod =__('Chèque-banque');
                            break;
                        case 4 :
                            $paymentMethod = __('Virement');
                            break;
                        case 5 :
                            $paymentMethod = __('Avoir');
                            break;
                        case 6 :
                            $paymentMethod = __('Espèce');
                            break;
                        case 7 :
                            $paymentMethod =  __('Traite');
                            break;
                        case 8 :
                            $paymentMethod = __('Fictif');
                            break;
                        default :

                            $paymentMethod = __('');


                    }


                    ?>
                    <span>Mode de paiement : <?php echo $paymentMethod?> </span>
                <?php } ?>
            </td>

            <td class="droit">
                <span><strong>Doit</strong> <?= $facture['Supplier']['code'] ?></span><br>

                <span class="client"><?= $facture['Supplier']['name'] ?></span><br>
                <span class="address_client"><?= $facture['Supplier']['adress'] ?></span><br>
                <span class='info_client'><?php if(!empty($facture['Supplier']['if'])) {?>IF :<?= $facture['Supplier']['if'] . ' ' ?> <?php } ?>
                    <?php if(!empty($facture['Supplier']['ai'])) {?>     AI :<?= $facture['Supplier']['ai'] . ' ' ?><?php } ?> <?php if(!empty($facture['Supplier']['rc'])) {?> RC :<?= $facture['Supplier']['rc'] . ' ' ?><?php } ?></span>


            </td>
        </tr>
    </table>
    <table class="main-table">
        <thead>
        <tr>
            <th><?php echo 'N&deg;'; ?></th>
            <th><?php echo __('Code'); ?></th>
            <th><?php echo __('Designation'); ?></th>
            <?php if ($type == TransportBillTypesEnum::pre_invoice) { ?>
                <th><?php echo __('Departure date'); ?></th>
                <th><?php echo __('Arrival date'); ?></th>
            <?php } ?>
            <?php if ($type == TransportBillTypesEnum::invoice ||
                $type == TransportBillTypesEnum::quote ||
                $type == TransportBillTypesEnum::order
            ) {
                ?>
                <th><?php echo __('Unit price'); ?></th>
            <?php } ?>
            <th><?php echo __('Quantity'); ?></th>

            <?php if ($type == TransportBillTypesEnum::invoice ||
                $type == TransportBillTypesEnum::quote ||
                $type == TransportBillTypesEnum::order
            ) {
                ?>
                <th><?php echo __('RIS. %'); ?></th>
                <th><?php echo __('Price HT'); ?></th>
                <th><?php echo __('TVA'); ?></th>
            <?php } ?>


        </tr>
        </thead>
        <tbody>
        <?php $i = 1;
        $uv = 0;
        foreach ($rides as $ride) { ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $ride['Product']['code'] ?></td>
                <?php if ($ride['Product']['id'] ==1) { ?>
                    <td><?= $ride['Product']['name'].'('. $ride['TransportBillDetailRides']['designation'] .')' ?></td>

                <?php } else { ?>
                    <td>
                        <?= $ride['TransportBillDetailRides']['designation'] ?>
                        <div style ='margin-left: 10px'><?= $ride['Product']['description'] ?></div>
                    </td>
                <?php } ?>


                <?php if ($type == TransportBillTypesEnum::pre_invoice) { ?>
                    <td><?php echo h($this->Time->format($ride['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y %H:%M')); ?>
                        &nbsp;</td>
                    <td><?php echo h($this->Time->format($ride['SheetRideDetailRides']['real_end_date'], '%d-%m-%Y %H:%M')); ?>
                        &nbsp;</td>
                <?php } ?>
                <?php if ($type == TransportBillTypesEnum::invoice ||
                    $type == TransportBillTypesEnum::quote ||
                    $type == TransportBillTypesEnum::order
                ) {
                    ?>
                    <td><?= number_format($ride['TransportBillDetailRides']['unit_price'], 2, ",", "."); ?></td>
                <?php } ?>
                <?php $uv = $uv+ $ride['TransportBillDetailRides']['nb_trucks']; ?>
                <td><?= number_format($ride['TransportBillDetailRides']['nb_trucks'], 2, ",", "."); ?></td>
                <?php if ($type == TransportBillTypesEnum::invoice ||
                    $type == TransportBillTypesEnum::quote ||
                    $type == TransportBillTypesEnum::order
                ) {
                    ?>
                    <td><?= number_format($ride['TransportBillDetailRides']['ristourne_%'], 2, ",", "."); ?></td>
                    <td><?= number_format($ride['TransportBillDetailRides']['price_ht'], 2, ",", "."); ?></td>
                    <td><?= $ride['Tva']['name']; ?></td>

                <?php } ?>
            </tr>
            <?php $i++;
        } ?>
        </tbody>
    </table>
    <p class="uv">NB. UV : <?php echo number_format($uv, 2, ",", "."); ?></p>
</div>
<div id="footer">
        <table class="footer-table">
            <tr>

                <td class='nombre-lettre'>
                    <?php
                    $fmt = new NumberFormatter('fr', NumberFormatter::SPELLOUT);
                    switch ($type) {
                        case  TransportBillTypesEnum::quote:
                            $text = 'Arrêtée le présent devis à la somme de : ';
                            break;
                        case  TransportBillTypesEnum::order:
                            $text = 'Arrêtée la présente commande à la somme de : ';
                            break;

                        case
                        TransportBillTypesEnum::pre_invoice:
                            $text = 'Arrêtée la présente préfacture à la somme de : ';
                            break;

                        case

                        TransportBillTypesEnum::invoice:
                            $text = 'Arrêtée la présente facture à la somme de : ';
                            break;
                    } ?>
                    <p style ='padding-left:20px'> <?php echo $text.strtoupper($fmt->format($facture['TransportBill']['total_ttc']).' '.$this->Session->read("currencyName"));
                        ?></p>
                </td>
                <td style='width:20px;'>
                </td>
                <?php if($facture['TransportBill']['ristourne_val']>0 ) { ?>
                    <td class="total">
                        <div class='total-div'
                             style=' border:2px solid #000;border-radius: 10px;padding:5px 5px;font-size:10px; height: 107px;'>
                            <?php $totalHt = $facture['TransportBill']['total_ht'] + $facture['TransportBill']['ristourne_val'] ; ?>
                            <span class="left"><strong><?php echo __('Total HT '); ?></strong></span> <span
                                    class="right"> <?= number_format($totalHt, 2, ",", "."); ?></span><br>
                            <span class="left"><strong><?php echo __('Remise '); ?></strong></span> <span
                                    class="right"> <?= number_format($facture['TransportBill']['ristourne_val'], 2, ",", "."); ?></span><br>

                            <span class="left"><strong><?php echo __('Net HT '); ?></strong></span> <span
                                    class="right"> <?= number_format($facture['TransportBill']['total_ht'], 2, ",", "."); ?></span><br>

                            <span class="left"><strong><?php echo __('TVA '); ?></strong></span> <span
                                    class="right"> <?= number_format($facture['TransportBill']['total_tva'], 2, ",", "."); ?></span><br>
                            <span class="left"><strong><?php echo __('TIMBRE '); ?></strong></span> <span
                                    class="right"> <?= number_format($facture['TransportBill']['stamp'], 2, ",", "."); ?></span><br>
                            <span class="left "><strong><?php echo __('NET A PAYER '); ?></strong></span> <span
                                    class="right "> <?= number_format($facture['TransportBill']['total_ttc'], 2, ",", "."); ?></span><br>
                        </div>
                    </td>


                <?php } else {?>
                    <td class="total">
                        <div class='total-div'
                             style=' border:2px solid #000;border-radius: 10px;padding:5px 5px;font-size:10px; height: 72px;'>
                            <span class="left"><strong><?php echo __('Total HT '); ?></strong></span> <span
                                    class="right"> <?= number_format($facture['TransportBill']['total_ht'], 2, ",", "."); ?></span><br>

                            <span class="left"><strong><?php echo __('TVA '); ?></strong></span> <span
                                    class="right"> <?= number_format($facture['TransportBill']['total_tva'], 2, ",", "."); ?></span><br>
                            <span class="left"><strong><?php echo __('TIMBRE '); ?></strong></span> <span
                                    class="right"> <?= number_format($facture['TransportBill']['stamp'], 2, ",", "."); ?></span><br>
                            <span class="left "><strong><?php echo __('NET A PAYER '); ?></strong></span> <span
                                    class="right "> <?= number_format($facture['TransportBill']['total_ttc'], 2, ",", "."); ?></span><br>
                        </div>
                    </td>
                <?php } ?>
                <td style='width:20px;'>
                </td>

            </tr>
        </table>
    <table>
        <tr>
            <td>
                <span class="signature">Service Commercial<span>
            </td>
        </tr>
    </table>

    <div class='copyright'>
        <p style='border-top :1px solid #000; margin-top: 20px;  padding-top: 5px;'>Logiciel : UtranX |
            www.cafyb.com</p>
    </div>
</div>

</body>


</html>