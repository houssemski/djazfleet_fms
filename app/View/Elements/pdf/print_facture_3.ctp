<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <style type="text/css">
        @page {
            margin: 10px 25px 75px 25px;
        }

    </style>
    <link type="text/css" href="<?= WWW_ROOT ?>/css/pdf/invoice_style.css" rel="stylesheet" />
    <link type="text/css" href="<?= WWW_ROOT ?>/css/font-awesome.min.css" rel="stylesheet" />
</head>
<body>
<?php
/** @var array $company */
if(!empty($company['logo'])){
    $infoCompanyWidth = '50%';
}else{
    $infoCompanyWidth = '80%';
}
?>
<div id="header">
    <?php if($entete_pdf=='1') { ?>
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
                if (isset($company['Company']['social_capital']) && !empty($company['Company']['social_capital'])) {
                    echo "<br><br><span><strong>Capital  :</strong> ".number_format($company["Company"]["social_capital"], 2, ',', '.')."</span>";
                }
                if (isset($company['Company']['adress']) && !empty($company['Company']['adress'])) {
                    echo "<br><span class='adr'> {$company['Company']['adress']}</span>";
                }

                if (isset($company['Company']['phone']) && !empty($company['Company']['phone'])) {
                    echo "<br><span><strong>Tél. : </strong>{$company['Company']['phone']}</span>";
                }
                if (isset($company['Company']['fax']) && !empty($company['Company']['fax'])) {
                    echo " / <span><strong>Fax  : </strong>{$company['Company']['fax']}</span>";
                }
                if (isset($company['Company']['email']) && !empty($company['Company']['email'])) {
                    echo "<br><span><strong>E-mail  : </strong>{$company['Company']['email']}</span>";
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
                <?php
                if (isset($company['Company']['rc']) && !empty($company['Company']['rc'])) {
                    echo "<br><span><strong>RC : </strong>{$company['Company']['rc']} </span>";
                }
                if (isset($company['Company']['ai']) && !empty($company['Company']['ai'])) {
                    echo "<span><strong>AI : </strong>{$company['Company']['ai']} </span>";
                }
                if (isset($company['Company']['nif']) && !empty($company['Company']['nif'])) {
                    echo "<span><strong>NIF : </strong>{$company['Company']['nif']} </span><br>";
                }
                ?>

            </td>

            <?php
            if(!empty($company['Company']['logo']) &&
                file_exists(WWW_ROOT . "/logo/{$company['Company']['logo']}")){
                echo '<td valign="top" align="right">';
                echo '<img src="'.WWW_ROOT . "logo\\"."{$company['Company']['logo']}".'" alt="Logo" class= "logo-print" >';
                /*echo $this->Html->image("../app/webroot/logo/" .
                    $company['Company']['logo'], array(
                    'alt' => 'Logo',
                    'class' => 'logo-print',
                    'fullBase' => true
                ));*/
                echo '</td>';
            }

            ?>
        </tr>
    </table>
    <?php } ?>

</div>
<?php
$quantity = 0;
$printedProductsHeight = 0;
$remainingHeightForTable = 0;
$remainingPrintableHeight = 0;
$currentPage = 1;

switch ($type) {
    case TransportBillTypesEnum::quote :

        $printName ='Devis' ;
        break;
    case TransportBillTypesEnum::order :
        $printName =' Bon de commande';
        break;
    case TransportBillTypesEnum::pre_invoice :
        $printName ='Pr&eacute;facture';
        break;
    case TransportBillTypesEnum::invoice :

        $printName ='Facture';
        break;
    case TransportBillTypesEnum::credit_note :

        $printName ='Avoir de vente';
        break;
}

switch ($facture['TransportBill']['payment_method']) {
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
$transportBillDetailRideRistourne = false;
foreach ($rides as $ride){
    if (!empty($ride['TransportBillDetailRides']['ristourne_%'])){
        $transportBillDetailRideRistourne = true;
        break;
    }
}


?>

<div class="box-body">

    <table class="items" width="100%" style="border-collapse: collapse;">

        <tr >
            <td class=" bloc-info" >
                <table class="border-colapse" width="100%">
                    <tr>
                        <td id="print-name" class="facture facture-center" colspan="2">
                            <?= $printName ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="bold padding">
                            N° :
                        </td>
                        <td class="padding">
                            <?= $facture['TransportBill']['reference']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="bold padding">
                            <?php if($type == TransportBillTypesEnum::credit_note){  ?>
                                Date : <br/>Code client : <br/> N° Facture :
                            <?php  }else { ?>
                                Date : <br/>Code client :
                            <?php } ?>
                        </td>
                        <td class="padding">
                            <?= $this->Time->format($facture['TransportBill']['date'],  '%d/%m/%Y') ?>
                            <br/>
                            <?= $facture['Supplier']['code'] ?>

                            <?php if($type == TransportBillTypesEnum::credit_note &&
                                !empty($invoice)
                            ){  ?>
                                <br/>
                                <?= $invoice['TransportBill']['reference'] ?>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td class=" bloc-client" style="vertical-align:top;">
                <span class="client" style="text-align: center; margin-bottom: 0px!important;"><?= $facture['Supplier']['name'] ?></span><br>
                <span class='adr-client' >
                    <?php if (!empty($facture['Supplier']['adress'])) {
                        echo  $facture['Supplier']['adress'];
                    } ?></span><br>
                <div class='info_client'>
                    <?php
                    if (!empty($facture['Supplier']['if']) && !empty($facture['Supplier']['ai']) &&
                        !empty($facture['Supplier']['rc'])) {
                        echo '<span style="margin-left: 200px">'.'N° RC : ' . $facture['Supplier']['rc'] . '</span><br/>';
                        echo '<span style="margin-left: 200px">'.'N° Article : ' . trim($facture['Supplier']['ai']) . '</span><br/>';
                        echo '<span style="margin-left: 200px">'.' N°IF : ' . trim($facture['Supplier']['if']).'</span>';
                    } else {
                        if (!empty($facture['Supplier']['rc'])) echo 'RC : ' . $facture['Supplier']['rc'] . ' ';
                        if (!empty($facture['Supplier']['ai'])) echo 'AI : ' . $facture['Supplier']['ai'] . ' ';
                        if (!empty($facture['Supplier']['if'])) echo 'NIF : ' . $facture['Supplier']['if'] . ' ';
                    }
                    ?>
                </div>
            </td>
        </tr>
    </table>
    <br/>
    <table class="items" width="100%" style="font-size: 9pt;
    border-collapse: collapse; " cellpadding="8">
        <thead>
        <tr>
            <?php if ($type != TransportBillTypesEnum::quote) { ?>
            <th><?php echo __('Date'); ?></th>
            <?php } ?>
            <th><?php
                if ($type == TransportBillTypesEnum::credit_note){
                    echo __('Designation');
                }else{
                    echo __('Destination');
                }
                 ?></th>
            <?php if($type !=TransportBillTypesEnum::credit_note ||
            $facture['TransportBill']['credit_note_type']!=2){ ?>
            <th><?php echo __('Car type'); ?></th>
                <th><?php echo __('Mission Type'); ?></th>
            <?php } ?>
            <?php if ( !empty($factors)){ ?>
                <?php foreach($factors as $factor){ ?>
                    <th><?php echo $factor['Factor']['name'] ; ?></th>
                <?php } ?>
            <?php } ?>
            <th><?php echo __('Quantity'); ?></th>
            <?php if ($type == TransportBillTypesEnum::invoice ||
                $type == TransportBillTypesEnum::quote ||
                $type == TransportBillTypesEnum::order ||
                $type == TransportBillTypesEnum::pre_invoice ||
                $type == TransportBillTypesEnum::credit_note
            ) {
                ?>
                <th><?php echo __('PU HT'); ?></th>
            <?php } ?>

            <?php if ($transportBillDetailRideRistourne) {
                ?>
                <th><?php echo __('Ristourne %'); ?></th>
                <th><?php echo __('Ristourne value'); ?></th>
            <?php } ?>

            <?php if ($type == TransportBillTypesEnum::invoice ||
                $type == TransportBillTypesEnum::quote ||
                $type == TransportBillTypesEnum::order ||
                $type == TransportBillTypesEnum::credit_note
            ) {
                ?>
                <th><?php echo __('Price HT'); ?></th>
            <?php } ?>


        </tr>
        </thead>
        <tbody class="items" >
        <?php
        /** @var ride $ride */
        $i = 1;
        $uv = 0;
        foreach ($rides as $ride) { ?>
            <tr style="margin-top: -10px !important;">
                <?php if ($type != TransportBillTypesEnum::quote) { ?>
                  <td align="center"><?php echo h($this->Time->format($ride['TransportBillDetailRides']['programming_date'], '%d-%m-%Y')); ?>
                </td>
               <?php }?>
                <?php

                if ($ride['Product']['id'] == 1 ) {
                    if($type ==TransportBillTypesEnum::credit_note || $type == TransportBillTypesEnum::invoice  ){
                        $destination = $ride['TransportBillDetailRides']['designation'];
                    }else {
                        if($ride['TransportBillDetailRides']['type_ride']==2){
                            $destination = $ride['Departure']['name'].' - '.$ride['Arrival']['name'];
                        } else {
                            $destination = $ride['DepartureDestination']['name'].' - '.$ride['ArrivalDestination']['name'];
                        }
                    }

                    ?>
                    <td align="left"><?= $destination ?></td>
                <?php } else { ?>
                    <td align="left">
                        <?= $ride['TransportBillDetailRides']['designation'] ?>
                    </td>
                <?php } ?>
                <?php if($type !=TransportBillTypesEnum::credit_note ||
                $facture['TransportBill']['credit_note_type']!=2){ ?>
                <td>
                    <?php if($ride['TransportBillDetailRides']['type_ride']==2){
                        echo $ride['Type']['name'];
                    }else {
                        echo $ride['CarType']['name'];
                    }?>
                </td>
                    <td>
                        <?php
                        switch ($ride['TransportBillDetailRides']['delivery_with_return']) {
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
                <?php } ?>
                <?php
                if(!empty($factors)){
                    $factorValues = $rideFactors[$ride['TransportBillDetailRides']['id']] ;

                    foreach ($factors as $factor){
                        if(isset($factorValues[$factor['Factor']['id']])){ ?>
                            <td align="center"><?php echo h($factorValues[$factor['Factor']['id']]) ?></td>

                        <?php }else {?>
                            <td></td>
                        <?php  }
                    }
                } ?>
                <?php if ($type == TransportBillTypesEnum::invoice ||
                    $type == TransportBillTypesEnum::quote ||
                    $type == TransportBillTypesEnum::order ||
                    $type == TransportBillTypesEnum::pre_invoice ||
                    $type == TransportBillTypesEnum::credit_note
                ) {
                    $unitName = !empty($ride['MarchandiseUnits']['name']) ? $ride['MarchandiseUnits']['name'] : '';
                    ?>
                    <td align="center"><?=
                        $ride['TransportBillDetailRides']['nb_trucks'] .' '.$unitName
                        ; ?></td>

                    <td align="right"><?= number_format($ride['TransportBillDetailRides']['unit_price'], 2, ",", "."); ?></td>
                <?php } ?>
                <?php $uv = $uv + $ride['TransportBillDetailRides']['nb_trucks']; ?>

                <?php if ($transportBillDetailRideRistourne) {
                    ?>
                    <td align="right"><?= $ride['TransportBillDetailRides']['ristourne_%']; ?></td>
                    <td align="right"><?= number_format($ride['TransportBillDetailRides']['ristourne_val'], 2, ",", "."); ?></td>
                <?php } ?>
                 <?php if ($type == TransportBillTypesEnum::invoice ||
                    $type == TransportBillTypesEnum::quote ||
                    $type == TransportBillTypesEnum::order ||
                    $type == TransportBillTypesEnum::credit_note
                ) {
                    ?>
                    <td align="right"><?= number_format($ride['TransportBillDetailRides']['price_ht'], 2, ",", "."); ?></td>

                    <?php

                } ?>
            </tr>



            <?php  $i++; } ?>
        <?php
        $fmt = new NumberFormatter('fr', NumberFormatter::SPELLOUT);
        switch ($type) {
            case  TransportBillTypesEnum::quote:
                $ttcToLettersLabel = 'Arrêtée le présent devis à la somme de : ';
                break;
            case  TransportBillTypesEnum::order:
                $ttcToLettersLabel = 'Arrêtée la présente commande à la somme de : ';
                break;
            case
            TransportBillTypesEnum::pre_invoice:
                $ttcToLettersLabel = 'Arrêtée la présente préfacture à la somme de : ';
                break;

            case
            TransportBillTypesEnum::invoice:
                $ttcToLettersLabel = 'Arrêtée la présente facture à la somme de : ';
                break;

            case
            TransportBillTypesEnum::credit_note:
                $ttcToLettersLabel = "Arrêtée la présente facture d'avoir à la somme de : ";
                break;
        }


        if (!empty($facture['TransportBill']['ristourne_val']) && !empty($facture['TransportBill']['stamp'])) {
            $rowSpan = '8';
        } elseif (!empty($facture['TransportBill']['ristourne_val'])) {
            $rowSpan = '7';
        } elseif (!empty($facture['TransportBill']['stamp'])) {
            $rowSpan = '5';
        }else{
            $rowSpan = '4';
        }
        if($type==TransportBillTypesEnum::quote ||
            $facture['TransportBill']['credit_note_type']==2
                ){
            if ($transportBillDetailRideRistourne){
                $colSpan = '6';
            }else{
                $colSpan = '4';
            }
        }else {
            if($type==TransportBillTypesEnum::pre_invoice){
                if ($transportBillDetailRideRistourne){
                    $colSpan ='6';
                }else{
                    $colSpan ='4';
                }
            }else {
                if ($transportBillDetailRideRistourne){
                    $colSpan ='7';
                }else{
                    $colSpan ='5';
                }
            }
        }

                    $f = new NumberFormatter("fr", NumberFormatter::SPELLOUT);
                    $temporaryTtc = explode('.', number_format($facture['TransportBill']['total_ttc'], 2, '.', ' '));
                    if (isset($temporaryTtc[1]) && $temporaryTtc[1] > 0) {
                        $ttcToLetters =
                            $f->format(str_replace(' ', '', $temporaryTtc[0])) . ' ' . 'Dinars ' . ' ' .
                            __('and') . ' ' . ucwords($f->format(str_replace(' ', '', $temporaryTtc[1]))) .
                            ' ' . __('cents');
                    } else {
                        $ttcToLetters = $f->format(str_replace(' ', '', $temporaryTtc[0])) . ' ' . 'Dinars ';
                    }


        ?>
        <tr>
            <td valign=bottom class="blanktotal" colspan="<?= $colSpan ?>" rowspan="<?= $rowSpan ?>">
                <span class="left toletters"><strong><?= $ttcToLettersLabel.' '.$ttcToLetters ?> </strong> </span>
            </td>
            <?php
            if(!empty($penalties)) {
                $total = $facture['TransportBill']['total_ht'] + $totalPenaltyAmount;
            }else {
                $total =  $facture['TransportBill']['total_ht'];
            }
            if(!empty($facture['TransportBill']['ristourne_val'])){
                $total = $total +$facture['TransportBill']['ristourne_val'];
            }
            ?>

            <td class="totals"><strong><?= __('Total HT'); ?></strong></td>
            <td class="totals cost">
                <?= number_format($total, 2, ",", ".") ?>
            </td>
        </tr>
        <?php
        if (!empty($facture['TransportBill']['ristourne_val'])) { ?>
            <tr>
                <td class="totals"><strong><?= __('Discount'); ?></strong></td>
                <td class="totals cost">
                    <?php
                    if($facture['TransportBill']['total_ht'] != 0){
                        echo $facture['TransportBill']['ristourne_percentage']. " %";
                    }else{
                        echo 0 . "%";
                    }

                    ?>
                </td>
            </tr>
            <tr>
                <td class="totals"><strong><?= __('Discount amount'); ?></strong></td>
                <td class="totals cost">
                    <?php
                    echo number_format($facture['TransportBill']['ristourne_val'], 2, ",", ".") ;
                    ?>
                </td>
            </tr>
            <tr>
                <td class="totals"><strong><?= __('Total HT Net'); ?></strong></td>
                <td class="totals cost">
                    <?php
                    echo number_format($facture['TransportBill']['total_ht'], 2, ",", ".") ;
                    ?>
                </td>
            </tr>

        <?php } ?>

        <tr>
            <td class="totals"><strong><?= __('TVA'); ?></strong></td>
            <td class="totals cost">
                <?php if(!empty($facture['TransportBill']['total_tva'])) {
                    echo number_format($facture['TransportBill']['total_tva'], 2, ",", ".");
                }else {
                    echo 'EXO';
                }
                ?>
            </td>
        </tr>
        <?php
        if(!empty($penalties)) {

            foreach ($penalties as $penalty) {?>
                <tr>
                    <td class="totals"><strong><?php echo $penalty['TransportBillPenalty']['penalty_value']; ?></strong></td>
                    <td class="totals cost"> <?= number_format($penalty['TransportBillPenalty']['penalty_amount'], 2, ",", "."); ?></td>
                </tr>
            <?php }  ?>
            <tr>
                <td class="totals"><strong><?php echo __('Total Géneral  '); ?></strong></td>
                <td class="totals cost"><?= number_format($facture['TransportBill']['total_ht'], 2, ",", "."); ?></td>
            </tr>

        <?php    }
        if (!empty($facture['TransportBill']['stamp'])) { ?>
            <tr>
                <td class="totals"><strong><?= __('Stamp'); ?></strong></td>
                <td class="totals cost">
                    <?php
                    echo number_format($facture['TransportBill']['stamp'], 2, ",", ".") ?>

                </td>
            </tr>
        <?php } ?>
        <tr>
            <td class="totals"><strong><?= __('Total TTC'); ?></strong></td>
            <td class="totals cost">
                <?= number_format($facture['TransportBill']['total_ttc'], 2, ",", ".") ?>
            </td>
        </tr>
        <tr>
            <td class="totals"><strong><?= __('Net a payer'); ?></strong></td>
            <td class="totals cost">
               <strong> <?= number_format($facture['TransportBill']['total_ttc'], 2, ",", ".") ?></strong>
            </td>
        </tr>



        </tbody>



    </table>
    <br>

    <?php
    $stampToDisplay = $company['Company']['stamp_image'];

    if (
        isset($stampToDisplay) && !empty($stampToDisplay) &&
        file_exists(WWW_ROOT . "cachet/{$stampToDisplay}")
    ) {
        echo '<div valign="top" align="right">'; ?>
        <img class="stamp-print" alt="Stamp" src="<?= WWW_ROOT ?>/cachet/<?=rawurlencode($stampToDisplay)?>">
<?php
        echo '</div>';
    }
    ?>

    <table id="footer" style='border-top: 1px solid #000;' width='100%'>
        <tr>
            <td width='33%'><?php echo date("d-m-Y")  ?></td>
            <td width='33%' align='center'></td>
            <td width='33%' style='text-align: right'>UTRANX</td>
        </tr>
    </table>
</body>
</html>