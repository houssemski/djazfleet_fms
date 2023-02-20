<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <style type="text/css">
        @page {
            margin: 95px 0;
        }

        #header {
            position: fixed;
            left: 25px;
            top: -95px;
            right: 25px;
            height: auto;
            border-bottom: 3px solid #000;
        }

        #header table {
            width: 100%;
        }

        #header td.logo {
            vertical-align: top;
            padding-left: 25px;
            padding-top: 15px;
        }

        .company {
            vertical-align: top;
            font-weight: bold;
            font-size: 16px;
            display: block;
            font-size: 22px;
            padding-top: 20px;
        }

        .copyright {
            font-size: 10px;
            text-align: center;
        }

        .info_company {
            width: 500px;
            font-size: 12px;
            line-height: 18px;
        }

        .info_fiscal {
            width: 500px;
            font-size: 12px;
            padding-top: 60px;
            line-height: 18px;
            padding-right: 5px;
            float: right;
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
            padding: 50px 25px 0;
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

        .main-table {
            border: 1px solid black;
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }

        .main-table > thead > tr > th, .main-table > tbody > tr > th, .main-table > tfoot > tr > th, .main-table > thead > tr > td, .main-table > tbody > tr > td, .main-table > tfoot > tr > td {
            border: 1px solid #000;
        }

        .main-table th {
            border: 1px solid black;
            padding-left: 5px;
            text-align: left;;
            font-size: 11px
        }

        .main-table td {
            text-align: left;
            padding: 3px 5px;;
            font-size: 11px
        }

        .total {
            width: 250px;
            position: absolute;
            bottom: 150px;
            float: right;
            right: 25px;
            border: 2px solid #000;
            border-radius: 10px;
        }

        .nombre-lettre {
            width: 450px;
            position: absolute;
            bottom: 200px;
            float: left;
            left: 20px;
            font-size: 10px;
            line-height: 20px;
        }

        .total span {
            padding: 10px 10px;
            line-height: 10px;
            font-size: 13px;
            font-size: 11px;
        }

        #footer {
            position: fixed;
            left: 0;
            bottom: -95px;
            right: 0;
            height: 50px;
        }

        .total .left {
            width: 40%;
            text-align: left;
            display: inline-block;
        }

        .total .right {
            width: 40%;
            text-align: right;
            display: inline-block;
        }

        .ttc {
            border-top: 1px solid #000;
        }

        .client {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 30px;
            display: block;
            padding-top: 10px;
        }

        .info_client {
            font-size: 11px;
        }
    </style>
</head>
<body class='body'>
<div id="header">
    <?php if($entete_pdf=='1') {?>
    <table>
        <tr>

            <td class='info_company'>
                <span class="company"><?= Configure::read("nameCompany") ?></span><br>
                <span class='adr'><?= $company['Company']['adress'] ?></span><br>
                <span><strong>Tél. :</strong><?= $company['Company']['phone'] ?></span><br>
                <span><strong>Fax :</strong><?= $company['Company']['fax'] ?></span><br>
                <span><strong>Mobile :</strong><?= $company['Company']['mobile'] ?></span>

            </td>
            <td class="info_fiscal">
                <span><strong>RC :</strong><?= $company['Company']['rc'] ?></span><br>
                <span><strong>AI :</strong><?= $company['Company']['ai'] ?></span><br>
                <span><strong>NIF :</strong><?= $company['Company']['nif'] ?></span><br>
                <span><strong>Compte :</strong><?= $company['Company']['cb'] ?></span>
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
                <?php if ($type == TransportBillTypesEnum::invoice) { ?>
                    <span>Mode de paiement</span>
                <?php } ?>
            </td>

            <td class="droit">
                <span><strong>Doit</strong> <?= $facture['Supplier']['code'] ?></span><br>
                <span class="client"><?= $facture['Supplier']['name'] ?></span><br>
                <span class='info_client'>IF :<?= $facture['Supplier']['if'] . ' ' ?>
                    AI :<?= $facture['Supplier']['ai'] . ' ' ?> RC :<?= $facture['Supplier']['rc'] . ' ' ?></span>
            </td>
        </tr>
    </table>
    <table class="main-table">
        <thead>
        <tr>
            <th><?php echo 'N&deg;'; ?></th>
            <th><?php echo __('Ride'); ?></th>
            <th><?php echo __('Transportation'); ?></th>
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
            <th><?php echo __('Number of trucks'); ?></th>

            <?php if ($type == TransportBillTypesEnum::invoice ||
                $type == TransportBillTypesEnum::quote ||
                $type == TransportBillTypesEnum::order
            ) {
                ?>
                <th><?php echo __('Price HT'); ?></th>
                <th><?php echo __('Price TTC'); ?></th>
            <?php } ?>


        </tr>
        </thead>
        <tbody>
        <?php $i = 1;
        foreach ($rides as $ride) { ?>
            <tr>
                <td><?= $i ?></td>

                <td><?= $ride['DepartureDestination']['name'] . '-' . $ride['ArrivalDestination']['name'] ?></td>
                <td> <?= $ride['CarType']['name']; ?></td>
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
                <td><?= $ride['TransportBillDetailRides']['nb_trucks']; ?></td>
                <?php if ($type == TransportBillTypesEnum::invoice ||
                    $type == TransportBillTypesEnum::quote ||
                    $type == TransportBillTypesEnum::order
                ) {
                    ?>
                    <td><?= number_format($ride['TransportBillDetailRides']['price_ht'], 2, ",", "."); ?></td>
                    <td><?= number_format($ride['TransportBillDetailRides']['price_ttc'], 2, ",", "."); ?></td>

                <?php } ?>
            </tr>
            <?php $i++;
        } ?>
        </tbody>
    </table>
    <?php if ($type == TransportBillTypesEnum::invoice ||
        $type == TransportBillTypesEnum::quote ||
        $type == TransportBillTypesEnum::order
    ) {
        ?>
        <div class="nombre-lettre">
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

                TransportBillTypesEnum::invoice:
                    $text = 'Arrêtée la présente facture à la somme de : ';
                    break;
            }
            echo $text.strtoupper($fmt->format($facture['TransportBill']['total_ttc']).' '.$this->Session->read("currency"));
            ?>
        </div>
        <div class="total">
            <span class="left"><?php echo __('Total HT'); ?></span> <span
                class="right"> <?= number_format($facture['TransportBill']['total_ht'], 2, ",", ".") . ' ' . $this->Session->read("currency"); ?></span><br>
            <span class="left">TVA</span> <span
                class="right"> <?= number_format($facture['TransportBill']['total_tva'], 2, ",", ".") . ' ' . $this->Session->read("currency"); ?></span><br>
            <span class="ttc left"><strong>NET A PAYER</strong></span> <span
                class="ttc right"> <strong><?= number_format($facture['TransportBill']['total_ttc'], 2, ",", ".") . ' ' . $this->Session->read("currency"); ?></strong></span>
        </div>
    <?php } ?>
</div>
<div id="footer">

    <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
</div>

</body>


</html>