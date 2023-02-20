<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <style type="text/css">
        <?php if (Configure::read('utranx_ade') != '1') { ?>
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
        <?php }else{ ?>
        @page {
            margin: 0px 0px 150px 0px;
        }

        #header {
            left: 25px;
            top: -150px;
            right: 25px;
            border-bottom: 3px solid #000;
        }
        <?php } ?>

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
            text-decoration: underline;

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
            padding: 0px 25px;
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
        / / border: 1 px solid #000;
        }

        .main-table td {
            vertical-align: top;
            border-left: 0;
            border-right: 1px solid #C0C0C0;
            border-collapse: collapse;
            border-top: 0;
            border-bottom: 0;
        }

        .reglement-table td {
            vertical-align: top;
            border-left: 0;
            border-collapse: collapse;
            border-top: 0;
            border-bottom: 0;
        }

        .footer-table td {
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
        .reglement-table th {
            border-bottom: 1px solid black;
            padding-left: 5px;
            text-align: left;
            border-collapse: collapse;
            font-size: 11px
        }

        .footer-table th {
            border-right: 1px solid #FFF;
            border-bottom: 1px solid #FFF;
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
        .reglement-table {

            width: 55%;
            border-collapse: collapse;
            margin: 10px 20px;
        }

        .footer-table {

            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            border: 1px solid #FFF !important;
        }

        .total {
            width: 200px;
            height: 40px;
            float: right;
            line-height: 10px;

        }

        .total-div span {
            padding: 5px 5px;
            line-height: 10px;
            font-size: 10px;
        }

        .main-table td {
            text-align: left;
            padding: 3px 5px;;
            font-size: 11px
        }
        .reglement-table td {
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
            height: 390px;
        }

        .left {
            width: 70px;
            height: 8px;
            text-align: left;
            display: inline-block;
            padding-left: 5px;
            font-size: 10px;
            line-height: 10px;
        }

        .right {
            width: 120px;
            height: 8px;
            text-align: right;
            display: inline-block;
            font-size: 10px;
            line-height: 10px;
        }

        .client {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            display: inline;
        / / padding-top: 10 px;
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
    <?php
    if (Configure::read('utranx_ade') != '1'){
    if ($entete_pdf == '1') { ?>
        <table>
            <tr>

                <td class='info_company'>
                    <span class="company"><?= Configure::read("nameCompany") ?></span><br>
                    <span class='adr'><?= $company['Company']['adress'] ?></span><br>
                    <span><strong>Tél. :</strong><?= $company['Company']['phone'] ?></span><br>
                    <span><strong>Fax :</strong><?= $company['Company']['fax'] ?></span><br>
                    <span><strong>Mobile :</strong><?= $company['Company']['mobile'] ?></span><br>
                    <span><strong>Compte :</strong><?= $company['Company']['cb'] ?></span>

                </td>
                <td class="info_fiscal">
                    <span><strong>RC :</strong><?= $company['Company']['rc'] ?></span><br>
                    <span><strong>AI :</strong><?= $company['Company']['ai'] ?></span><br>
                    <span><strong>NIF :</strong><?= $company['Company']['nif'] ?></span><br>

                </td>
                <td style='width: 10px'>
                </td>

            </tr>
        </table>
    <?php }}else{
        echo $this->element('pdf/ade-header');
    } ?>
</div>
<div class="box-body">
    <table class="bloc-center">
        <tr>
            <td>
                <?php switch ($bill['Bill']['type']) {
                    case BillTypesEnum::supplier_order :
                        ?>
                        <span class="facture">Bon de commande <?= $bill['Bill']['reference']; ?></span>
                        <?php
                        break;
                    case BillTypesEnum::receipt :
                        ?>
                        <span class="facture">Bon de réception <?= $bill['Bill']['reference']; ?></span>
                        <?php
                        break;
                    case BillTypesEnum::return_supplier :
                        ?>
                        <span class="facture">Bon de retour <?= $bill['Bill']['reference']; ?></span>
                        <?php
                        break;
                    case BillTypesEnum::purchase_invoice :
                        ?>
                        <span class="facture">Facture <?= $bill['Bill']['reference']; ?></span>
                        <?php
                        break;
                    case BillTypesEnum::credit_note :
                        ?>
                        <span class="facture">Avoir <?= $bill['Bill']['reference']; ?></span>
                        <?php
                        break;
                    case BillTypesEnum::delivery_order :
                        ?>
                        <span class="facture">Bon de livraison <?= $bill['Bill']['reference']; ?></span>
                        <?php
                        break;
                    case BillTypesEnum::return_customer :
                        ?>
                        <span class="facture">Bon de retour <?= $bill['Bill']['reference']; ?></span>
                        <?php
                        break;
                    case BillTypesEnum::entry_order :
                        ?>
                        <span class="facture">Bon de'entrée <?= $bill['Bill']['reference']; ?></span>
                        <?php
                        break;
                    case BillTypesEnum::exit_order :
                        ?>
                        <span class="facture">Bon de sortie <?= $bill['Bill']['reference']; ?></span>
                        <?php
                        break;
                    case BillTypesEnum::renvoi_order :
                        ?>
                        <span class="facture">Bon de renvoi <?= $bill['Bill']['reference']; ?></span>
                        <?php
                        break;
                    case BillTypesEnum::reintegration_order :
                        ?>
                        <span class="facture">Bon de réintegration <?= $bill['Bill']['reference']; ?></span>
                        <?php
                        break;
                    case BillTypesEnum::quote :
                        ?>
                        <span class="facture">Devis <?= $bill['Bill']['reference']; ?></span>
                        <?php
                        break;
                    case BillTypesEnum::customer_order :
                        ?>
                        <span class="facture">Bon de commande <?= $bill['Bill']['reference']; ?></span>
                        <?php
                        break;
                    case BillTypesEnum::sales_invoice :
                        ?>
                        <span class="facture">Facture <?= $bill['Bill']['reference']; ?></span>
                        <?php
                        break;
                    case BillTypesEnum::sale_credit_note :
                        ?>
                        <span class="facture">Avoir <?= $bill['Bill']['reference']; ?></span>
                        <?php
                        break;
                    case BillTypesEnum::product_request :
                        ?>
                        <span class="facture">Demande produit <?= $bill['Bill']['reference']; ?></span>
                        <?php
                        break;
                    case BillTypesEnum::purchase_request :
                        ?>
                        <span class="facture">Demande achat <?= $bill['Bill']['reference']; ?></span>
                        <?php
                        break;

                }
                ?>



            </td>
            <td class="date">
				<span>Le : <?=
                    $this->Time->format($bill['Bill']['date'], '%d-%m-%Y')
                    ?></span>
            </td>
        </tr>
        <tr>
            <td class="modepayment">
                <?php
                switch ($bill['Bill']['payment_method']) {
                    case 1 :
                        $paymentMethod = __('A terme');
                        break;
                    case 2 :
                        $paymentMethod = __('Chèque');
                        break;
                    case 3 :
                        $paymentMethod = __('Chèque-banque');
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
                        $paymentMethod = __('Traite');
                        break;
                    case 8 :
                        $paymentMethod = __('Fictif');
                        break;
                    default :

                        $paymentMethod = __('');

                }
                ?>
                <span>Mode de paiement : <?php echo $paymentMethod ?> </span>
            </td>


            <td class="droit">
                <span><strong>Doit</strong> <?= $bill['Supplier']['code'] ?></span><br>

                <span class="client"><?= $bill['Supplier']['name'] ?></span><br>
                <span class="address_client"><?= $bill['Supplier']['adress'] ?></span><br>
                <span class='info_client'><?php if (!empty($bill['Supplier']['if'])) { ?>IF :<?= $bill['Supplier']['if'] . ' ' ?><?php } ?>
                    <?php if (!empty($bill['Supplier']['ai'])) { ?>     AI :<?= $bill['Supplier']['ai'] . ' ' ?><?php } ?> <?php if (!empty($bill['Supplier']['rc'])) { ?> RC :<?= $bill['Supplier']['rc'] . ' ' ?><?php } ?></span>


            </td>
        </tr>
    </table>
    <table class="main-table">
        <thead>
        <tr>
            <th><?php echo 'N&deg;'; ?></th>
            <th><?php echo __('Code'); ?></th>
            <th><?php echo __('Designation'); ?></th>
            <th><?php echo __('Quantity'); ?></th>
            <th><?php echo __('Unit price'); ?></th>
            <th><?php echo __('Price HT'); ?></th>
            <th><?php echo __('Price TTC'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        $uv = 0;
        foreach ($billProducts as $billProduct) { ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $billProduct['Product']['code']; ?></td>
                <td><?= $billProduct['BillProduct']['designation']; ?></td>
                <td><?= number_format($billProduct['BillProduct']['quantity'], 2, ",", "."); ?></td>
                <?php $uv = $uv + $billProduct['BillProduct']['quantity']; ?>
                <td><?= number_format($billProduct['BillProduct']['unit_price'], 2, ",", "."); ?></td>
                <td><?= number_format($billProduct['BillProduct']['price_ht'], 2, ",", "."); ?></td>
                <td><?= number_format($billProduct['BillProduct']['price_ttc'], 2, ",", "."); ?></td>
            </tr>
        <?php }
        $i++;
        ?>
        </tbody>
    </table>

    <p class="uv">NB. UV : <?php echo number_format($uv, 2, ",", "."); ?></p>

</div>
<div class="note"><?= $bill['Bill']['note']; ?></div>
<div id="footer">
    <table class="footer-table">
        <tr>

            <td class='nombre-lettre'>
                <?php
                $fmt = new NumberFormatter('fr', NumberFormatter::SPELLOUT);
                switch ($bill['Bill']['type']) {
                    case BillTypesEnum::supplier_order :
                        $text = 'Arrêtée la présente commande à la somme de : ';
                        break;
                    case BillTypesEnum::receipt :
                        $text = 'Arrêtée le présent bon à la somme de : ';
                        break;
                    case BillTypesEnum::return_supplier :
                        $text = 'Arrêtée le présent bon à la somme de : ';
                        break;
                    case BillTypesEnum::purchase_invoice :
                        $text = 'Arrêtée la présente facture à la somme de : ';
                        break;
                    case BillTypesEnum::credit_note :
                        $text = 'Arrêtée le présent avoir à la somme de : ';
                        break;
                    case BillTypesEnum::delivery_order :
                        $text = 'Arrêtée le présent bon à la somme de : ';
                        break;
                    case BillTypesEnum::return_customer :
                        $text = 'Arrêtée le présent bon à la somme de : ';
                        break;
                    case BillTypesEnum::entry_order :
                        $text = 'Arrêtée le présent bon à la somme de : ';
                        break;
                    case BillTypesEnum::exit_order :
                        $text = 'Arrêtée le présent bon à la somme de : ';
                        break;
                    case BillTypesEnum::renvoi_order :
                        $text = 'Arrêtée le présent bon à la somme de : ';
                        break;
                    case BillTypesEnum::reintegration_order :
                        $text = 'Arrêtée le présent bon à la somme de : ';
                        break;
                    case BillTypesEnum::quote :
                        $text = 'Arrêtée le présent devis à la somme de : ';
                        break;
                    case BillTypesEnum::customer_order :
                        $text = 'Arrêtée la présente commande à la somme de : ';
                        break;
                    case BillTypesEnum::sales_invoice :
                        $text = 'Arrêtée la présente facture à la somme de : ';
                        break;
                    case BillTypesEnum::sale_credit_note :
                        $text = 'Arrêtée le présent avoir à la somme de : ';
                        break;
                    case BillTypesEnum::product_request :
                        $text = 'Arrêtée la présente demande de produit à la somme de : ';
                        break;
                    case BillTypesEnum::purchase_request :
                        $text = 'Arrêtée la présente demande achat à la somme de : ';
                        break;

                } ?>
                <p style='padding-left:20px'> <?php echo $text . strtoupper($fmt->format($bill['Bill']['total_ttc']) . ' ' . $this->Session->read("currencyName")); ?> </p>

            </td>
            <td style='width:20px;'>
            </td>
            <?php if($bill['Bill']['ristourne_val']>0 ) { ?>
                <td class="total">
                    <div class='total-div'
                         style=' border:2px solid #000;border-radius: 10px;padding:5px 5px;font-size:10px; height: 107px;'>
                        <?php $totalHt = $bill['Bill']['total_ht'] + $bill['Bill']['ristourne_val'] ; ?>
                        <span class="left"><strong><?php echo __('Total HT '); ?></strong></span> <span
                            class="right"> <?= number_format($totalHt, 2, ",", "."); ?></span><br>
                        <span class="left"><strong><?php echo __('Remise '); ?></strong></span> <span
                            class="right"> <?= number_format($bill['Bill']['ristourne_val'], 2, ",", "."); ?></span><br>

                        <span class="left"><strong><?php echo __('Net HT '); ?></strong></span> <span
                            class="right"> <?= number_format($bill['Bill']['total_ht'], 2, ",", "."); ?></span><br>

                        <span class="left"><strong><?php echo __('TVA '); ?></strong></span> <span
                            class="right"> <?= number_format($bill['Bill']['total_tva'], 2, ",", "."); ?></span><br>
                        <span class="left"><strong><?php echo __('TIMBRE '); ?></strong></span> <span
                            class="right"> <?= number_format($bill['Bill']['stamp'], 2, ",", "."); ?></span><br>
                        <span class="left "><strong><?php echo __('NET A PAYER '); ?></strong></span> <span
                            class="right "> <?= number_format($bill['Bill']['total_ttc'], 2, ",", "."); ?></span><br>
                    </div>
                </td>


            <?php } else {?>
                <td class="total">
                    <div class='total-div'
                         style=' border:2px solid #000;border-radius: 10px;padding:5px 5px;font-size:10px; height: 72px;'>
                        <span class="left"><strong><?php echo __('Total HT '); ?></strong></span> <span
                            class="right"> <?= number_format($bill['Bill']['total_ht'], 2, ",", "."); ?></span><br>

                        <span class="left"><strong><?php echo __('TVA '); ?></strong></span> <span
                            class="right"> <?= number_format($bill['Bill']['total_tva'], 2, ",", "."); ?></span><br>
                        <span class="left"><strong><?php echo __('TIMBRE '); ?></strong></span> <span
                            class="right"> <?= number_format($bill['Bill']['stamp'], 2, ",", "."); ?></span><br>
                        <span class="left "><strong><?php echo __('NET A PAYER '); ?></strong></span> <span
                            class="right "> <?= number_format($bill['Bill']['total_ttc'], 2, ",", "."); ?></span><br>
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
    <p style='border-top :2px solid #000; margin-top: 40px;  margin-left: 25px; margin-right: 25px;'></p>
    <table class="reglement-table">
        <thead>
        <tr>
            <th><?php echo __('Date'); ?></th>
            <th><?php echo __('Chèque ou pièce N°'); ?></th>
            <th><?php echo __('Mode'); ?></th>
            <th style="text-align: right"><?php echo __('Amount'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
       $regulatedAmount = 0;
       $rest = 0;
       $nbPayments = 0;
        if(!empty($payments)){

        foreach ($payments as $payment) {
            $nbPayments ++;
            ?>
            <tr>
                <td><?= $this->Time->format($payment['Payment']['receipt_date'], '%d-%m-%Y') ?></td>
                <td><?= $payment['Payment']['number_payment']; ?></td>
                <td><?php switch ($payment['Payment']['payment_type']) {

                        case 1:
                            echo __('Espèce');
                            break;
                        case 2:
                            echo __('Virement');
                            break;
                        case 3:
                            echo __('Chèque de banque');
                            break;

                        case 4:
                            echo __('Chèque');
                            break;

                        case 5:
                            echo __('Traite');
                            break;

                        case 6:
                            echo __('Fictif');
                            break;

                    } ?>&nbsp;

                </td>
                <td style="text-align: right"><?= number_format($payment['DetailPayment']['payroll_amount'], 2, ",", "."); ?></td>
                </tr>
        <?php
            $regulatedAmount = $regulatedAmount + $payment['DetailPayment']['payroll_amount'];

        }?>

         <?php   $rest = $bill['Bill']['total_ttc'] - $regulatedAmount;

        } else {
            $rest = $bill['Bill']['total_ttc'] ;
        }


        ?>
        </tbody>
    </table>
   <div style ='font-size:11px; margin-left: 160px '><span class="left"><?php echo __('Montant réglé'); ?> </span><span style="width: 181px" class="right"><?= number_format($regulatedAmount, 2, ",", "."); ?></span></div>
    <p style="border-bottom: :1px solid #000;">  </p>
    <div style ='font-size:11px; margin-left: 160px'><span class="left"><strong><?php echo __('Reste à régler'); ?></strong></span><span style="width: 181px" class="right"><?= number_format($rest, 2, ",", "."); ; ?></span></div>
    <?php if($bill['Bill']['ristourne_val']>0 ) { ?>
   <?php switch ($nbPayments){
    case 0: ?>
    <div class='copyright'  style ='padding-top: 90px;'>
        <?php   break;

             case 1: ?>
        <div class='copyright'  style ='padding-top: 70px;'>
            <?php   break;

             case 2: ?>
            <div class='copyright'  style ='padding-top: 55px;'>
                <?php   break;

             case 3: ?>
                <div class='copyright'  style ='padding-top: 40px;'>
                    <?php   break;

            case 4: ?>
                    <div class='copyright'  style ='padding-top: 25px;'>
                        <?php    break;

            case 5: ?>
                        <div class='copyright'  style ='padding-top: 15px;'>
                            <?php    break;
        }?>
            <?php if(Configure::read("gestion_commercial") == '1') { ?>
                <p style='border-top :1px solid #000; margin-top: 0px;  padding-top: 5px;'>Logiciel : UtranX |
                    www.cafyb.com</p>
            <?php } else { ?>
                <p style='border-top :1px solid #000; margin-top: 0px;  padding-top: 5px;'>Logiciel : CAFYB |
                    www.cafyb.com</p>
            <?php  } ?>
        </div>
    <?php } else { ?>
        <?php
        switch ($nbPayments){
            case 0: ?>
            <div class='copyright'  style ='padding-top: 100px;'>
             <?php   break;

             case 1: ?>
            <div class='copyright'  style ='padding-top: 80px;'>
             <?php   break;

             case 2: ?>
         <div class='copyright'  style ='padding-top: 60px;'>
             <?php   break;

             case 3: ?>
        <div class='copyright'  style ='padding-top: 40px;'>
             <?php   break;

            case 4: ?>
        <div class='copyright'  style ='padding-top: 20px;'>
            <?php    break;

            case 5: ?>
             <div class='copyright' >
            <?php    break;
        }

        ?>
            <?php if(Configure::read("gestion_commercial") == '1') { ?>
                <p style='border-top :1px solid #000; margin-top: 20px;  padding-top: 5px;'>Logiciel : UtranX |
                    www.cafyb.com</p>
            <?php } else { ?>
                <p style='border-top :1px solid #000; margin-top: 20px;  padding-top: 5px;'>Logiciel : CAFYB |
                    www.cafyb.com</p>
            <?php  } ?>
        </div>
    <?php }?>

</div>

</body>


</html>