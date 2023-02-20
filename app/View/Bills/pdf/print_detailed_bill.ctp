<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <style type="text/css">
        <?php if (Configure::read('utranx_ade') != '1'){ ?>
        @page {
            margin: 0px 0px 30px 0px;
        }
        @page :first {margin: 150px 0px 30px 0px; }

        header  {
            position: fixed;
            left: 25px;
            top: -150px;
            right: 25px;
            border-bottom: 3px solid #000;
        }
        <?php }else{ ?>
        @page {
            margin: 0px 0px 30px 0px;
        }

        header  {
            left: 25px;
            right: 25px;
            height: 150px;
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
        footer {
            font-size: 10px;
            text-align: center;
            position : fixed;
            bottom : 30px;
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

        .info_fiscal : first {
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
            margin: 30px 0px 5px 0px;
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

        #footer  {
            position: fixed;
            left: 0;
            bottom: 0px;
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

<header id="header">
    <?php
    if (Configure::read('utranx_ade') != '1'){
    if($entete_pdf=='1') { ?>
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
    <?php }}else{
        echo $this->element('pdf/ade-header');
    } ?>
</header>
<footer>
    <?php if($bill['Bill']['ristourne_val']>0 ) { ?>

        <div class='copyright' style ='padding-top: 55px;'>
            <?php if(Configure::read("gestion_commercial") == '1') { ?>
                <p style='border-top :1px solid #000; margin-top: 0px;  padding-top: 5px;'>Logiciel : UtranX |
                    www.cafyb.com</p>
            <?php } else { ?>
                <p style='border-top :1px solid #000; margin-top: 0px;  padding-top: 5px;'>Logiciel : CAFYB |
                    www.cafyb.com</p>
            <?php  } ?>
        </div>
    <?php } else { ?>
        <div class='copyright' >
            <?php if(Configure::read("gestion_commercial") == '1') { ?>
                <p style='border-top :1px solid #000; margin-top: 20px;  padding-top: 5px;'>Logiciel : UtranX |
                    www.cafyb.com</p>

            <?php } else { ?>
                <p style='border-top :1px solid #000; margin-top: 20px;  padding-top: 5px;'>Logiciel : CAFYB |
                    www.cafyb.com</p>
            <?php  } ?>
        </div>
    <?php }?>
</footer>

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
                <span class='info_client'><?php if(!empty($bill['Supplier']['if'])) {?>IF :<?= $bill['Supplier']['if'] . ' ' ?> <?php } ?>
                    <?php if(!empty($bill['Supplier']['ai'])) {?>     AI :<?= $bill['Supplier']['ai'] . ' ' ?><?php } ?> <?php if(!empty($bill['Supplier']['rc'])) {?> RC :<?= $bill['Supplier']['rc'] . ' ' ?><?php } ?></span>


            </td>
        </tr>
    </table>
    <table class="main-table">
        <thead>
        <tr>
            <th><?php echo 'N&deg;'; ?></th>
            <th><?php echo __('Code'); ?></th>
            <th style ="width: 400px"><?php echo __('Designation'); ?></th>

            <th><?php echo __('Prix U'); ?></th>

            <th><?php echo __('Quantity'); ?></th>

            <th><?php echo __('RIS. %'); ?></th>
            <th><?php echo __('Price HT'); ?></th>
            <th><?php echo __('TVA'); ?></th>



        </tr>
        </thead>
        <tbody>
        <?php $i = 1;
        $uv = 0;
        $nbLigne = 0;
        $nbPage = 1;
        $descriptions = array();
        $divExist = false;
        foreach ($billProducts as $billProduct) { ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $billProduct['Product']['code'] ?></td>
                <td>
                    <?= $billProduct['BillProduct']['designation'] ?>
                    <?php
                    $nbLigne ++;
                    if(!empty($billProduct['BillProduct']['description'])){
                        $descriptionProduct = $billProduct['BillProduct']['description'];
                     } else {
                        $descriptionProduct = $billProduct['Product']['description'];
                    }
                    ?>
                        <div style ='margin-left: 10px ; font-size:10.5px '><?php
                                if(stristr($descriptionProduct,'<br />')==true){
                                    $descriptions =  explode('<br />', $descriptionProduct);
                                }
                                if(stristr($descriptionProduct,'</div>')==true) {
                                    $divExist = true;
                                    $descriptions = explode('</div>', $descriptionProduct);
                                }
                                if(stristr($descriptionProduct,'</p>')==true && $divExist == false) {
                                    $descriptions = explode('</p>', $descriptionProduct);
                                }

                            if(!empty($descriptions)){
                            foreach ($descriptions as $description){
                            echo $description;
                            $nbChar = Strlen($description);
                            $nbLigneDescription = floor($nbChar / 110)+1 ;
                            echo '<br />';
                            $nbLigne = $nbLigne + $nbLigneDescription;
                            if($nbLigne==33 || $nbLigne==(47*$nbPage)){
                            $nbPage ++;
                            ?>
                        </div>
                </td>
                <td><?= number_format($billProduct['BillProduct']['unit_price'], 2, ",", "."); ?></td>
                <td><?= number_format($billProduct['BillProduct']['quantity'], 2, ",", "."); ?></td>
                <td><?= number_format($billProduct['BillProduct']['ristourne_%'], 2, ",", "."); ?></td>
                <td><?= number_format($billProduct['BillProduct']['price_ht'], 2, ",", "."); ?></td>
                <td><?= $billProduct['Tva']['name']; ?></td>

            </tr>
        </tbody>
    </table>
    <span style="page-break-before: always;">
                                  </span>
    <table class="main-table">
        <thead>
        <tr>
            <th><?php echo 'N&deg;'; ?></th>
            <th><?php echo __('Code'); ?></th>
            <th style ="width: 400px"><?php echo __('Designation'); ?></th>

            <th><?php echo __('Prix U'); ?></th>

            <th><?php echo __('Quantity'); ?></th>

            <th><?php echo __('RIS. %'); ?></th>
            <th><?php echo __('Price HT'); ?></th>
            <th><?php echo __('TVA'); ?></th>



        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?= $i ?></td>
            <td><?= $billProduct['Product']['code'] ?></td>

            <td><div style ='margin-left: 10px ; font-size:10.5px '>

                    <?php }

                    }
                            }else {
                    if($nbLigne==23 || $nbLigne==(47*$nbPage)){
                    $nbPage ++;
                    ?>
                </div>
            </td>
            <td><?= number_format($billProduct['BillProduct']['unit_price'], 2, ",", "."); ?></td>
            <td><?= number_format($billProduct['BillProduct']['quantity'], 2, ",", "."); ?></td>
            <td><?= number_format($billProduct['BillProduct']['ristourne_%'], 2, ",", "."); ?></td>
            <td><?= number_format($billProduct['BillProduct']['price_ht'], 2, ",", "."); ?></td>
            <td><?= $billProduct['Tva']['name']; ?></td>

        </tr>
        </tbody>
    </table>
    <span style="page-break-before: always;">
                                  </span>
    <table class="main-table">
        <thead>
        <tr>
            <th><?php echo 'N&deg;'; ?></th>
            <th><?php echo __('Code'); ?></th>
            <th style ="width: 400px"><?php echo __('Designation'); ?></th>

            <th><?php echo __('Prix U'); ?></th>

            <th><?php echo __('Quantity'); ?></th>

            <th><?php echo __('RIS. %'); ?></th>
            <th><?php echo __('Price HT'); ?></th>
            <th><?php echo __('TVA'); ?></th>



        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?= $i ?></td>
            <td><?= $billProduct['Product']['code'] ?></td>

            <td><div style ='margin-left: 10px ; font-size:10.5px '>

                    <?php }

                            }

                            ?></div>
                </td>

                <td><?= number_format($billProduct['BillProduct']['unit_price'], 2, ",", "."); ?></td>


                <td><?= number_format($billProduct['BillProduct']['quantity'], 2, ",", "."); ?></td>

                <td><?= number_format($billProduct['BillProduct']['ristourne_%'], 2, ",", "."); ?></td>
                <td><?= number_format($billProduct['BillProduct']['price_ht'], 2, ",", "."); ?></td>
                <td><?= $billProduct['Tva']['name']; ?></td>
            </tr>
            <?php $i++;
            $descriptions = array();
             $uv = $uv+ $billProduct['BillProduct']['quantity'];
        } ?>
        </tbody>
    </table>
    <p class="uv">NB. UV : <?php echo number_format($uv, 2, ",", "."); ?></p>


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
                    <p style ='padding-left:20px'> <?php echo $text.strtoupper($fmt->format($bill['Bill']['total_ttc']).' '.$this->Session->read("currencyName"));
                        ?></p>
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


    </div>
</div>

</body>


</html>