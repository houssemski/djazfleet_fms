<?php if($bill['Bill']['type'] == BillTypesEnum::product_request) { ?>

    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <style type="text/css">
            @page {
                margin: 90px 10px 0px 10px;
            }

            #header { position: fixed; left: 0; top: -100px; right: 0; height: 165px; border-bottom: 1px solid #000; }
            #header table{width:100%;}
            #header td.logo{vertical-align: top;padding-left:25px;padding-top:60px; width:270px;}

            #header td.company{ width: 400px;vertical-align: top; font-weight: bold; font-size: 16px;padding-right:20px;padding-left:30px; padding-top:20px;}
            #header td.company span{display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}
            #header td.logo span{display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}

            .header table{width:100%;}
            .header td.logo{vertical-align: top;padding-left:25px;padding-top:60px; width:270px;}

            .header td.company{ width: 400px;vertical-align: top; font-weight: bold; font-size: 16px;padding-right:20px; padding-top:20px;}
            .header td.company span{display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}
            .header td.logo span{display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}




            .date {
                padding-top: 15px;
                text-align: right;
                padding-right: 25px;
                font-size: 16px;
                font-weight: bold;
                text-align: right;
            }



            .bloc-center {
                margin-top: 65px;
                width: 100%;
            }

            .body {
                margin-left: 30px;
                margin-right: 20px;
            }
            .main-table{
                margin-top: 55px;
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
                margin: 90px 0;
                border: 1px solid black !important;
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

            .footer-table td {
                text-align: left;
                padding: 3px 5px;;
                font-size: 10px
            }


        </style>


    </head>
    <body class='body'>

    <div id="header">
        <?php if($entete_pdf=='1') {?>
            <table>
                <tr >

                    <td class="company">
                        <span style ='margin-left: 40px; text-align: center; margin-bottom: 20px'><?= Configure::read("nameCompany") ?></span>

                        <span  style="font-size: 12px !important; font-weight: normal; margin-left: 100px">
                            DEMANDE FOURNITURE
                        </strong>
                    </span>
                        <span style="font-size: 12px !important; font-weight: normal; margin-left: 40px; ">(BUREAU - PIECES DETACHEES - MATERIEL LABO ETC ...)</span>



                    </td>
                    <td class="logo">

                        <span class="date" style="font-size: 12px !important; font-weight: normal;">
                          <strong>B/S N :<?=  $bill['Bill']['reference']; ?></strong>

                    </span>


                    </td>

                    <td  class="date" ></td>
                </tr>
            </table>
            <div style ='border-bottom: 1px solid #000; margin-top:10px; margin-bottom: 5px'></div>
            <table>
                <tr >
                    <td style ='font-size: 12px; padding-left:20px'>S.Demandeur :
                        <?php if(!empty($billServices)) {
                            foreach ($billServices as $billService){
                                echo $billService['Service']['name'];
                            }
                        } ?></td>
                    <td style ='font-size: 12px'>Date : <?= $this->Time->format($bill['Bill']['date'], '%d-%m-%Y') ?></td>
                    <td style ='font-size: 12px'>Visa Service : </td>
                </tr>
                <tr>
                    <td style ='font-size: 12px; padding-left:20px'>Visa Directeur :</td>
                </tr>
            </table>
        <?php }?>

    </div>


    <table class="main-table">
        <thead>
        <tr>
            <th><?php echo __('Designation'); ?></th>
            <th><?php echo __('Quantité demandée'); ?></th>
            <th><?php echo __('Quantité fournie'); ?></th>
            <th><?php echo __('Observation'); ?></th>



        </tr>
        </thead>
        <tbody>
        <?php if(!empty($billProducts)){
            foreach ($billProducts as $billProduct){
            ?>
        <tr >
            <td><?= $billProduct['Product']['name'];?></td>
            <td><?= number_format($billProduct['BillProduct']['quantity'], 2, ",", "."); ?></td>
            <td></td>
            <td></td>

        </tr>
        <?php }}?>
        </tbody>
    </table>








    </body>
    </html>



 <?php   }elseif($bill['Bill']['type'] == BillTypesEnum::purchase_request){ ?>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <style type="text/css">
            @page {
                margin: 90px 10px 0px 10px;
            }

            #header { position: fixed; left: 0; top: -100px; right: 0; height: 125px; border-bottom: 1px solid #000; }
            #header table{width:100%;}
            #header td.logo{vertical-align: top;padding-left:25px;padding-top:60px; width:270px;}

            #header td.company{ width: 400px;vertical-align: top; font-weight: bold; font-size: 16px;padding-right:20px;padding-left:30px; padding-top:20px;}
            #header td.company span{display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}
            #header td.logo span{display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}

            .header table{width:100%;}
            .header td.logo{vertical-align: top;padding-left:25px;padding-top:60px; width:270px;}

            .header td.company{ width: 400px;vertical-align: top; font-weight: bold; font-size: 16px;padding-right:20px; padding-top:20px;}
            .header td.company span{display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}
            .header td.logo span{display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}




            .date {
                padding-top: 15px;
                text-align: left;
                padding-right: 25px;
                font-size: 16px;
                font-weight: bold;
            }



            .bloc-center {
                margin-top: 65px;
                width: 100%;
            }

            .body {
                margin-left: 30px;
                margin-right: 20px;
            }
            .main-table{
                margin-top: 55px;
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
                margin: 90px 0;
                border: 1px solid black !important;
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

            .footer-table td {
                text-align: left;
                padding: 3px 5px;;
                font-size: 10px
            }


        </style>


    </head>
    <body class='body'>

    <div id="header">
        <?php if($entete_pdf=='1') {?>
            <table>
                <tr >

                    <td class="company">
                        <span style ='margin-left: 40px; text-align: center; margin-bottom: 20px; text-decoration: underline'><?= Configure::read("nameCompany") ?></span>

                        <span  style="font-size: 16px !important; font-weight: normal; margin-left: 100px">
                            Demande <br>d'Achat
                            </strong>
                    </span>



                    </td>
                    <td class="logo">

                        <span class="date" style="font-size: 12px !important; font-weight: normal;">
                        (Service) <br>
                        (Investissement) <br>
                        (Consommable y compris réactifs) <br>

                    </span>


                    </td>

                    <td  class="date" ></td>
                </tr>
            </table>


        <?php }?>

    </div>


   <table style ='margin-top: 100px; margin-bottom: 50px'>
       <tr>
           <td style="padding-bottom: 20px; font-size: 14px">Structure : </td>
       </tr>
       <tr>
           <td style="padding-bottom: 20px ; font-size: 14px">Service demandeur :
               <?php if(!empty($billServices)) {
                   foreach ($billServices as $billService){
                       echo $billService['Service']['name'];
                   }
               } ?>
           </td>
       </tr>
       <tr>
           <td style="padding-bottom: 20px; font-size: 14px">Objet de l'achat : </td>
       </tr>
       <tr>
           <td style="padding-bottom: 20px; font-size: 14px">Justification de l'achat : </td>
       </tr>
       <tr>
           <td style="padding-bottom: 20px; font-size: 14px">Demande d'activité (Service ): </td>
       </tr>
       <tr>
           <td style="padding-bottom: 20px; font-size: 14px">Demande d'activité (Service ): </td>
       </tr>
       <tr>
           <td style="padding-bottom: 20px; font-size: 14px">Exigences (préciser la norme) (Service ): </td>
       </tr>
   </table>

    <table style ='margin-bottom: 150px; width: 100%; font-size: 13px'>
        <tr>
            <td>VISA SERVICE <br>DEMANDEUR
            </td>
            <td>VISA DE <br>L'ORDONNATEUR</td>
            <td>VISA DU DIRECTEUR<br>D'UNITE</td>
            <td>VISA DU <br>P.D.G</td>
        </tr>
    </table>
    <div style =' font-size: 13px'>Le visa peut être requis par fax</div>




    </body>
    </html>




<?php }else { ?>

    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <style type="text/css">
            @page { margin: 95px 10px 60px 10px }
            @font-face {
                font-family: 'AlHurra';
                src: url('<?= WWW_ROOT ?>/fonts/Al-Hurra-Txtreg-Light.ttf')  format('truetype'); /* Safari, Android, iOS */
            }
            #header { position: fixed; left: 0; top: -100px; right: 0; height: 150px; border-bottom: 1px solid #000;}
            #header table{width:100%;}
            #header td.logo{vertical-align: top;padding-left:25px;padding-top:20px; width:270px;}
            #header td.company{ width: 500px;vertical-align: top; font-weight: bold; font-size: 16px;padding-right:50px; padding-top:20px;}
            #header td.company span{padding-left: 25px ;display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}

            #copyright{font-size:10px; text-align:center; position: fixed; left: 0; height:10px; bottom: -20px;}


            .uv {
                font-size: 10px;
            }

            .signature {
                font-size: 13px;
                margin-left: 600px;
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

                text-align: right;
                padding-right: 25px;
                font-size: 16px;
                font-weight: bold;
            }

            .box-body {
                padding: 0px 25px;
                position: relative;
            }

            .bloc-center {
                padding-top: 55px;
                width: 100%;
            }

            .facture {
                font-size: 18px;
                font-weight: bold;
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
            .footer-table td {
                text-align: left;
                padding: 3px 5px;;
                font-size: 10px
            }
            .nombre-lettre {
                width: 400px;
                float: left;
                margin-left: 50px;
                font-size: 10px;
                line-height: 20px;
            }
            #footer {
                position: fixed;
                left: 0;
                bottom: -85px;
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
        <?php if($entete_pdf=='1') {?>
            <table>
                <tr >

                    <td class="company">
                        <span><?= Configure::read("nameCompany") ?></span>
                        <span style="font-size: 12px !important; font-weight: normal">
                        <strong><?= $company['Company']['category_company'] ?></strong>
                    </span>
                        <span style="font-size: 12px !important; font-weight: normal">
                        <strong><?= $company['Company']['adress'] ?></strong>
                    </span>
                        <span style="font-size: 12px !important; font-weight: normal">
                        <strong>Tel. :<?= $company['Company']['phone'] ?></strong>
                    </span>
                        <span style="font-size: 12px !important; font-weight: normal">
                            <strong>Fax :<?= $company['Company']['fax'] ?></strong>
                    </span>

                        <span style="font-size: 12px !important; font-weight: normal">
                            <strong>Email :<?= $company['Company']['email'] ?></strong>
                        </span>
                        <span style="font-size: 12px !important; font-weight: normal">
                            <strong>Site Web :<?= $company['Company']['site_web'] ?></strong>
                        </span>
                    </td>
                    <td class="logo">
                        <?php

                        if(!empty($company['Company']['logo']) && file_exists( WWW_ROOT .'/logo/'. $company['Company']['logo'])) {?>
                            <img src="<?= WWW_ROOT ?>/logo/<?= $company['Company']['logo'] ?>" width="180px" height="120px">
                        <?php }else { ?>
                            <img  width="180px" height="120px">
                        <?php } ?>


                    </td>
                    <td  class="date" ></td>
                </tr>
            </table>
        <?php }?>
    </div>
    <div class="box-body">
        <table class="bloc-center">
            <tr>
                <td >
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
				<span><?= $wilayaName;?> Le : <?=
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
                    <td style="direction: rtl; font-family:  DejaVu Sans; letter-spacing: -1px;"><?= $billProduct['BillProduct']['designation']; ?></td>
                    <td><?= number_format($billProduct['BillProduct']['quantity'], 2, ",", "."); ?></td>
                    <?php $uv = $uv + $billProduct['BillProduct']['quantity']; ?>
                    <td><?= number_format($billProduct['BillProduct']['unit_price'], 2, ",", "."); ?></td>
                    <td><?= number_format($billProduct['BillProduct']['price_ht'], 2, ",", "."); ?></td>
                    <td><?= number_format($billProduct['BillProduct']['price_ttc'], 2, ",", "."); ?></td>
                </tr>
                <?php
                $i++;
            }

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
                    <p style='padding-left:20px; text-decoration: underline;'> <?php echo $text . strtoupper($fmt->format($bill['Bill']['total_ttc']) . ' ' . $this->Session->read("currencyName")); ?> </p>

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
                    <?php if (
                    $bill['Bill']['type']== BillTypesEnum::supplier_order ||
                    $bill['Bill']['type']== BillTypesEnum::customer_order
                    ) { ?>
                    <?php }else { ?>
                    <span class="signature">Directeur Général<span>
                <?php } ?>
                            <span class="signature">Service Commercial<span>
                </td>
            </tr>
        </table>
        <?php if($bill['Bill']['ristourne_val']>0 ) { ?>
            <div id='copyright' style ='bottom: -80px;'>
                <?php if(Configure::read("gestion_commercial") == '1') { ?>
                    <p style='border-top :1px solid #000; margin-top: 0px;  padding-top: 5px;'>Logiciel : UtranX |
                        www.cafyb.com</p>
                <?php } else { ?>
                    <p style='border-top :1px solid #000; margin-top: 0px;  padding-top: 5px;'>Logiciel : CAFYB |
                        www.cafyb.com</p>
                <?php  } ?>
            </div>
        <?php } else { ?>
            <div id='copyright' >
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






<?php
}
?>


