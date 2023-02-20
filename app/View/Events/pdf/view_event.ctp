<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <style type="text/css">
        @page { margin: 95px 0; }
        @font-face {
            font-family: 'AlHurra';
            src: url('<?= WWW_ROOT ?>/fonts/Al-Hurra-Txtreg-Light.ttf')  format('truetype'); /* Safari, Android, iOS */
        }
        #header {
            position: fixed; left: 0; top: -90px; right: 0; height: 165px; border-bottom: 1px solid #000;

        }
        #header table{width:100%;}
        #header td.logo{vertical-align: top;padding-left:25px;padding-top:20px; width:270px;}
        #header td.company{ width: 500px;vertical-align: top; font-weight: bold; font-size: 16px;padding-right:50px; padding-top:20px;}
        #header td.company span{padding-left: 25px ;display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}






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
            padding-top: 35px;
            font-size: 16px ;
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
        / / border: 1 px solid #000000;
        }

        .main-table td {
            vertical-align: center;
            border: 1px solid #000000;
            border-collapse: collapse;

        }

        .footer-table td {
            vertical-align: top;
            border-collapse: collapse;
            border: 1px solid #FFF;
        }

        .main-table th {
            border-right: 1px solid black;
            border-bottom: 1px solid black;
            padding-left: 5px;
            text-align: left;
            border-collapse: collapse;
            font-size: 11px;
            height: 20px;
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
            font-size: 11px;
            height : 20px;
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
        .center{
            text-align: center;
        }
        .event-table{
            border: 1px solid #000000;
            width: 100%;
            border-collapse: collapse;
        }
        .event-table td {
            border: 1px solid black !important;
            height: 20px;
            vertical-align: top;
        }
        .event-table th {
            height: 20px;
            border: 1px solid black !important;
        }
        .event-title{
            font-weight: bold;
            font-size: 24px;
            margin: auto;
            width: 100%;
            text-align: center;
        }
        .event-signature{
            font-weight: bold;
            font-size: 14px;
            margin: auto;
            width: 100%;
            text-align: center;
        }
        #copyright{
            font-size:14px;
            text-align:right;
            position: fixed;
            left: 0;right:20px;
            height:10px;
            bottom: -75px;
            font-weight: bold;
        }
    </style>

</head>
<body class='body'>
<div id="header">
    <?php
    if (Configure::read('utranx_ade')){
    echo $this->element('pdf/ade-header');
    }else{
    ?>
    <table>
        <tr>
            <td class="logo">
                <img src="<?= WWW_ROOT ?>/logo/<?= isset($company['Company']['logo']) ? $company['Company']['logo'] : '' ?>" width="100px" height="100px">

            </td>
            <td class='name_adr'>
                <div class='name'><?= Configure::read("nameCompany") ?></div>
                <div class='adr'><?=  isset($company['Company']['adress']) ? $company['Company']['adress'] : '' ?></div>
            </td>
            <td class='phone_fax'>
                <div>Tél: <?= isset($company['Company']['phone']) ? $company['Company']['phone'] : '' ?></div>
                <div>Fax: <?= isset($company['Company']['fax']) ? $company['Company']['fax'] : ''  ?></div>
            </td>
            <td class='rc'>
                <div>RC: <?= isset($company['Company']['rc']) ? $company['Company']['rc'] : '' ?></div>
                <div>AI: <?= isset($company['Company']['ai']) ? $company['Company']['ai'] : '' ?></div>
                <div>NIF: <?= isset($company['Company']['nif']) ? $company['Company']['nif'] : '' ?></div>
            </td>
        </tr>
    </table>
    <?php
    }
    ?>
</div>
<div class="box-body">

    <br>
    <br>
    <br>
    <table class="bloc-center">
        <div class="event-title">
            FICHE D' INTERVENTION
        </div>
    </table>
    <?php
    ?>

    <table class="event-table">
        <thead>
        <tr>
            <th><?php echo 'N&deg; IDENTIF'; ?></th>
            <th><?php echo __('APPAREIL'); ?></th>
            <th><?php echo __("DATE D'ARRIVE"); ?></th>
            <th><?php echo __('DATE RECEPTION'); ?></th>
            <th><?php echo __('DATE INTERVENTION'); ?></th>
            <th><?php echo __('DATE SORTIE'); ?></th>
        </tr>
        </thead>
        <?php
        ?>
        <tbody>
        <tr>
            <td >
                <?= $event[0]['Event']['code'] ?>
            </td>
            <td class="center">
                    <?php
                    if(!empty($carModel)){
                        echo $carModel[0]['Mark']['name'].' '.$carModel[0]['Carmodel']['name'] .' '.$event[0]['Car']['immatr_def'];
                    }
                     ?>
            </td>
            <td class="center">
                <?= $event[0]['Event']['workshop_entry_date'] ?>
            </td>
            <td >
                <?= $event[0]['Event']['reception_date'] ?>
            </td>
            <td >
                <?= $event[0]['Event']['intervention_date'] ?>
            </td>
            <td >
                <?= $event[0]['Event']['workshop_exit_date'] ?>
            </td>
        </tr>
        <tr >
            <td colspan="3" rowspan="2">
                <strong>Dignostic:</strong><br>
                <?=
                '- '.$event[0]['Event']['diagnostic']
                ?>
            </td>
            <td colspan="3" >
                <strong>LIEU DE DEPANNAGE :</strong>
                <br>
                <?php
                $internal = true;
                if ($event[0]['Event']['internal_external'] == '2'){
                    $count = 0;
                    $internal = false;
                    echo '-'.$event[0]['Event']['external_repair_supplier'];
                }else{
                    $count = count($products) + 2;
                    if (!empty($workshop)){
                        echo $workshop[0]['Workshop']['name'];
                    }
                }
                ?>
                <br>
            </td>
        </tr>
        <tr>
            <td colspan="3" >
                <strong>DUREE DE LA REPARATION :</strong>
                <br>
                <?=
                $event[0]['Event']['event_time']
                ?>
                <br>
            </td>
        </tr>
        <tr>
            <?php
            /*var_dump($eventProducts);
            die();*/
            ?>
            <td colspan="2" rowspan="<?= $count ?>"><strong>CAUSE DE LA PANNE :</strong><br>
                <?=
                '- '.$eventType[0]['EventType']['name'];
                ?>

                <?php
                if ($internal){
                    ?>
            </td>
            <td><strong>DESIGNATION</strong></td>
            <td><strong>QTE</strong></td>
            <td><strong>P.UNITAIRE</strong></td>
            <td><strong>TOTAL</strong></td>
            <?php
            $i=0;
            $totalPrice = 0;
            foreach ($products as $product){
            ?>
        <tr>
            <td>
                <?= $product['Product']['name'] ?>
            </td>
            <td>
                <?= $eventProducts[$i]['EventProduct']['quantity'] ?>
            </td>
            <td>
                <?= floatval($eventProducts[$i]['EventProduct']['price']) / floatval($eventProducts[$i]['EventProduct']['quantity']) ?>
            </td>
            <td>
                <?= $eventProducts[$i]['EventProduct']['price'] ?>
            </td>
        </tr>
            <?php
            $totalPrice = $totalPrice + floatval($eventProducts[$i]['EventProduct']['price']);
            $i++;
            }
            ?>
        <tr>
            <td colspan="4">
                <strong>COUT GLOBAL: </strong> <?= $totalPrice ?>
            </td>
        </tr>
        <?php }else{
            ?>
        <td colspan="4">
            <strong>COUT GLOBAL: </strong> <?php
            if (!empty($eventProducts)){
                $eventProducts[0]['Event']['cost'];
            }else{
                echo 0;
            }
            ?>
        </td>
        <?php } ?>
        </tr>
        <tr>
            <td colspan="2">
                <strong> DEPANNAGE ET PIECE DE RECHANGE:</strong>
                <?php
                foreach ($products as $product) {
                    ?>
                    <br>
                    <?= '- '.$product['Product']['name'] ?>
                    <?php
                }
                ?>
            </td>
            <td colspan="4"><strong>OBSERVATIONS:</strong> <br>
                <?= $event[0]['Event']['obs'] ?>
            </td>

        </tr>


        </tbody>
    </table>
    <br>
    <br>
    <div class="event-signature">
        Visa chef de service
    </div>
    <div id="copyright" >
        F-7-2.02
    </div>


</div>


</body>


</html>