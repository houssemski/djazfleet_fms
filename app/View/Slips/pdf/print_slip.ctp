
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <style type="text/css">
            @page {
                margin: 10px 25px 75px 25px;
            }
            .copyright{font-size:10px; text-align:center;}
            .title{
                font-weight: bold;
                font-size: 18px;
                text-align: center;
                padding-top: 5px;
                width: 300px;
                margin: 0 auto 10px;
            }
            .div-title{
               border: solid 5px;
                width: 300px;
                text-align: center;
                display: block;
                margin-left: 230px;
                margin-bottom: 50px;
            }
            .date_slip {
                padding-top: 15px;
                text-align: right;
                padding-right: 25px;
                font-weight: bold;
            }
            .ref_slip {
                padding-top: 15px;
                text-align: left;
                padding-left: 25px;
                font-weight: bold;
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
                width:90%;
                margin: 0px auto;
                border-collapse: collapse;
                position:relative;
            }
            .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th,
            .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
                border: 1px solid #000;
                font-size:11px;
            }
            .table-bordered th {
                font-weight:normal;
                padding:5px 13.4px 5px 13.4px;
                font-size:11px;
            }
            .tab_cons th{
                padding:5px 31px 5px 31px;
            }
            .tab_total th{
                padding:5px 19.4px 5px 19.4px;

            }

            .table-bordered td {
                text-align:center;
                font-size:13px;
            }
            .customer tr td:first-child{
                width: 250px !important;
                padding-bottom: 2px;
            }
            table.bottom td{padding-top: 5px; font-size: 18px;}
            table.footer td.first{width: 50%; text-align: left}
            table.footer td.second{width: 50%; text-align: left;}
            table.conditions td{
                border: 1px solid grey;
            }
            table.conditions td{
                vertical-align: top;
                padding: 5px 5px 5px 10px;
                line-height: 19px;
            }
            table.conditions_bottom td.first{width: 420px}
            table.conditions_bottom td{padding-top: 5px}
            .note span{display: block;text-decoration: underline;padding-bottom: 5px;}

            .total span{padding:10px 10px;line-height:10px;font-size:13px;}

            .box-body{padding: 0; margin: 0; width: 100%; position: relative !important;}


            .tab_{
                margin-bottom:40px;
                margin-top:20px;
            }
            .tab_ thead{
                padding:5px;
                background:#c0c0c0;
            }
            .tab_ tbody td{
                padding:5px;
            }
        </style>
        <link type="text/css" href="<?= WWW_ROOT ?>/css/pdf/invoice_style.css" rel="stylesheet" />
        <link type="text/css" href="<?= WWW_ROOT ?>/css/font-awesome.min.css" rel="stylesheet" />
    </head>
    <body style="page-break-inside:avoid;">
    <div id="header">
        <?php

/** @var array $company */
if(!empty($company['logo'])){
    $infoCompanyWidth = '50%';
}else{
    $infoCompanyWidth = '80%';
}

        if($entete_pdf=='1') { ?>
            <table>
                <tr>
                    <td class='info_company' valign="top" style="width: <?= $infoCompanyWidth ?>;">
                        <span class="company"><?= Configure::read("nameCompany")  ?></span>
                        <?php
                        $nameCompany =$company['Company']['name'];
                        if(!empty($nameCompany)){ ?>

                            <span id="slogan"><?= Configure::read("nameCompany")  ?></span>
                            <br>
                            <?php
                        }
                        if (isset($company['Company']['address']) && !empty($company['Company']['adress'])) {
                            echo "<br><br><span class='adr'> {$company['Company']['adress']}</span>";
                        }
                        if (isset($company['Company']['phone']) && !empty($company['Company']['phone'])) {
                            echo "<br><span><strong>Tél. : </strong>{$company['Company']['phone']}</span>";
                        }
                        if (isset($company['Company']['fax']) && !empty($company['Company']['fax'])) {
                            echo " / <span><strong>Fax  : </strong>{$company['Company']['fax']}</span>";
                        }
                        if (isset($company['Company']['mobile']) && !empty($company['Company']['mobile'])) {
                            echo "<br><span><strong>Mobile : </strong>{$company['Company']['mobile']}</span>";
                        }
                        if (isset($company['Company']['rib']) && !empty($company['Company']['rib'])) {
                            echo "<br><span><strong>RIB : </strong>{$company['Company']['rib']}</span>";
                        }elseif (isset($company['Company']['cb']) && !empty($company['Company']['cb'])) {
                            echo "<br><span><strong>CB : </strong>{$company['Company']['cb']}</span>";
                        }
                        ?>

                    </td>
                    <td class="info_fiscal" valign="top">
                        <div>
                            <?php
                            if (isset($company['rc']) && !empty($company['rc'])) {
                                echo "<span><strong>RC : </strong>{$company['rc']}</span><br>";
                            }
                            if (isset($company['ai']) && !empty($company['ai'])) {
                                echo "<span><strong>AI : </strong>{$company['ai']}</span><br>";
                            }
                            if (isset($company['nif']) && !empty($company['nif'])) {
                                echo "<span><strong>NIF : </strong>{$company['nif']}</span><br>";
                            }
                            ?>
                        </div>
                    </td>
                    <?php
                    if(!empty($company['logo']) &&
                        file_exists(WWW_ROOT . "/logo/{$company['logo']}")){
                        echo '<td valign="top" align="right">';
                        echo $this->Html->image("../logo/" .
                            rawurlencode($company['logo']), array(
                            'alt' => 'Logo',
                            'class' => 'logo-print',
                        ));
                        echo '</td>';
                    }

                    ?>
                </tr>
            </table>
        <?php } ?>

    </div>

    <div class="box-body">
        <div class="date_slip" style="font-size: 14px !important; "><?php echo $company['Company']['adress'].' LE '.$this->Time->format($slip['Slip']['date_slip'], '%d/%m/%Y') ?></div>
        <div class="ref_slip"><?php echo 'Réf : '.' '.$slip['Slip']['reference']; ?></div>
    </div>
    <div class="div-title">
        <div class="title"><?php echo __('Dispatch slip') ?></div>
        <div class="title"><?php echo $slip['Supplier']['name']; ?></div>
    </div>

    <div class="box-body">
        <table class='bon table-bordered tab_' >
            <thead >
            <tr>
                <th ><strong><?php echo __('Date'); ?></strong></th>
                <th ><strong><?php echo __('Client'); ?></strong></th>
                <th ><strong><?php echo  __('Destination'); ?></strong></th>
                <th ><strong><?php echo  __('N° BL'); ?></strong></th>
                <th ><strong><?php echo  __('N° Facture'); ?></strong></th>
                <th ><strong><?php echo  __('Obs'); ?></strong></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($missions as $mission){ ?>
                <tr>
                    <td><?php echo h($this->Time->format($mission['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y')); ?>&nbsp;</td>
                    <td><?php echo h($mission['SheetRideDetailRides']['final_customer']); ?>&nbsp;</td>
                    <td><?php
                        if($mission['SheetRideDetailRides']['type_ride']==2){
                        echo h($mission['Departure']['name'].' - '.$mission['Arrival']['name']);
                    }else {
                        echo h($mission['DepartureDestination']['name'].' - '.$mission['ArrivalDestination']['name']);
                        }
                        ?>&nbsp;</td>
                    <td><?php echo h($mission['SheetRideDetailRides']['number_delivery_note']); ?>&nbsp;</td>
                    <td><?php echo h($mission['SheetRideDetailRides']['number_invoice']); ?>&nbsp;</td>
                    <td><?php echo h($mission['SheetRideDetailRides']['note']); ?>&nbsp;</td>



                </tr>
            <?php }
            ?>

            </tbody>
        </table>
        <div style="clear:both;"></div>
        <table class='tab-admin '>
            <tr >
                <td style="padding-left: 50px; font-size: 13px">
                    <?php echo  'Veuillez nous accuser réception' ?>
                </td>
                <td style="padding-left: 350px; font-size: 13px">
                    <?php echo  'Sce/ administrative  ' ?>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 50px; font-size: 13px; padding-top: 20px">
                    <?php echo  'Reçu le ' ?>
                </td>

            </tr>
        </table>
    </div>

    <div id="footer">
        <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
    </div>
    </body>
    </html>





