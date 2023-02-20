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


?>

<div class="box-body">

    <table class="bloc-center">

        <tr>
            <td class="document_reference" style="vertical-align:top;">
                <div class="facture">
                    <?= $printName ?> N° <?= $facture['TransportBill']['reference']; ?></div>
                <br/>
                <div class="date">Date : <?= $this->Time->format($facture['TransportBill']['date'],  '%d-%m-%Y') ?></div>
                <div class="mode-payment">
                    <?php if (isset($paymentMethod) && !empty($paymentMethod)) { ?>
                        <span>Mode de paiement : </span> <?= $paymentMethod ?>
                    <?php } ?>
                </div>
            </td>
            <td class="doit" style="vertical-align:top;">
                <span><strong>Doit</strong> <?= $facture['Supplier']['code'] ?></span><br>
                <span class="client"><?= $facture['Supplier']['name'] ?></span><br>
                <span class='info_client'>
                    <?php if (!empty($facture['Supplier']['adress'])) {
                        echo 'Adresse : ' . $facture['Supplier']['adress'];
                    } ?><br>
                    <?php if (!empty($facture['Supplier']['tel'])) {
                        echo 'Téléphone : ' . $facture['Supplier']['name'] . '<br>';
                    } ?>
                    <?php
                    if (!empty($facture['Supplier']['if']) && !empty($facture['Supplier']['ai']) &&
                        !empty($facture['Supplier']['rc'])) {
                        echo 'RC : ' . $facture['Supplier']['rc'] . '<br/>';
                        echo 'AI : ' . trim($facture['Supplier']['ai']) . ' NIF : ' . trim($facture['Supplier']['if']);
                    } else {
                        if (!empty($facture['Supplier']['rc'])) echo 'RC : ' . $facture['Supplier']['rc'] . ' ';
                        if (!empty($facture['Supplier']['ai'])) echo 'AI : ' . $facture['Supplier']['ai'] . ' ';
                        if (!empty($facture['Supplier']['if'])) echo 'NIF : ' . $facture['Supplier']['if'] . ' ';
                    }
                    ?>
                </span>
            </td>
        </tr>
    </table>


    <br/>


    <table class="items" width="100%" style="font-size: 9pt;
    border-collapse: collapse; " cellpadding="8">
        <thead>
        <tr>
            <th><?php echo 'N&deg;'; ?></th>
            <th><?php echo __('Code'); ?></th>
            <th><?php echo __('Designation'); ?></th>
            <?php if ($type == TransportBillTypesEnum::pre_invoice) { ?>
                <th><?php echo __('Departure date'); ?></th>
                <th><?php echo __('Arrival date'); ?></th>
            <?php } ?>
            <?php if ( !empty($factors)){ ?>
                <?php foreach($factors as $factor){ ?>
                    <th><?php echo $factor['Factor']['name'] ; ?></th>
                <?php } ?>
            <?php } ?>
            <?php if ($type == TransportBillTypesEnum::invoice ||
                $type == TransportBillTypesEnum::quote ||
                $type == TransportBillTypesEnum::order ||
                $type == TransportBillTypesEnum::credit_note
            ) {
                ?>
                <th><?php echo __('Unit price'); ?></th>
            <?php } ?>
            <th><?php echo __('Quantity'); ?></th>

            <?php if ($type == TransportBillTypesEnum::invoice ||
                $type == TransportBillTypesEnum::quote ||
                $type == TransportBillTypesEnum::order ||
                $type == TransportBillTypesEnum::credit_note
            ) {
                ?>
                <th><?php echo __('Price HT'); ?></th>
                <th><?php echo __('Price TTC'); ?></th>
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
                        <td align="center"><?= $i ?></td>
                        <td align="center"><?= $ride['Product']['code'] ?></td>
                        <?php if ($ride['Product']['id'] == 1) { ?>
                            <td align="left"><?= $ride['Product']['name'] . '(' . $ride['TransportBillDetailRides']['designation'] . ')' ?></td>
                        <?php } else { ?>
                            <td align="left">
                                <?= $ride['TransportBillDetailRides']['designation'] ?>
                            </td>
                        <?php } ?>
                        <?php if ($type == TransportBillTypesEnum::pre_invoice) { ?>
                            <td align="center"><?php echo h($this->Time->format($ride['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y %H:%M')); ?>
                                &nbsp;
                            </td>
                            <td align="center"><?php echo h($this->Time->format($ride['SheetRideDetailRides']['real_end_date'], '%d-%m-%Y %H:%M')); ?>
                                &nbsp;
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
                            $type == TransportBillTypesEnum::order  ||
                            $type == TransportBillTypesEnum::credit_note
                        ) {
                            ?>
                            <td align="right"><?= number_format($ride['TransportBillDetailRides']['unit_price'], 2, ",", "."); ?></td>
                        <?php } ?>
                        <?php $uv = $uv + $ride['TransportBillDetailRides']['nb_trucks']; ?>
                        <td align="center"><?= $ride['TransportBillDetailRides']['nb_trucks']; ?></td>
                        <?php if ($type == TransportBillTypesEnum::invoice ||
                            $type == TransportBillTypesEnum::quote ||
                            $type == TransportBillTypesEnum::order ||
                            $type == TransportBillTypesEnum::credit_note
                        ) {
                            ?>
                            <td align="right"><?= number_format($ride['TransportBillDetailRides']['price_ht'], 2, ",", "."); ?></td>
                            <td align="right"><?= number_format($ride['TransportBillDetailRides']['price_ttc'], 2, ",", "."); ?></td>

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
        $rowSpan = '6';
    } elseif (!empty($facture['TransportBill']['ristourne_val'])) {
        $rowSpan = '5';
    } elseif (!empty($facture['TransportBill']['stamp'])) {
        $rowSpan = '4';
    }else{
        $rowSpan = '3';
    }
    if ($type == TransportBillTypesEnum::invoice){
        $colspan = 7;
    }else{
        $colspan = 5;
    }
    ?>
    <tr>
        <td class="blanktotal" colspan="<?= $colspan ?>" rowspan="<?= $rowSpan ?>">
               <span class="left toletters"><strong><?= $ttcToLettersLabel ?> :</strong> <?= strtoupper($fmt->format($facture['TransportBill']['total_ttc']) . ' ' . $this->Session->read("currencyName")) ?></span>
        </td>
        <?php
        if(!empty($penalties)) {
            $total = $facture['TransportBill']['total_ht'] + $totalPenaltyAmount;
        }else {
            $total =  $facture['TransportBill']['total_ht'];
        }
        ?>
        <td class="totals"><strong><?= __('Total HT'); ?></strong></td>
        <td class="totals cost">
            <?= number_format($total, 2, ",", ".") ?> <?= 'DA' ?>
        </td>
    </tr>
    <?php
    if (!empty($facture['TransportBill']['ristourne_val'])) { ?>
        <tr>
            <td class="totals"><strong><?= __('Discount'); ?></strong></td>
            <td class="totals cost">
                <?php
                echo number_format($facture['TransportBill']['ristourne_val'], 2, ",", ".") . $this->Session->read("currencyName") ;
                ?>
            </td>
        </tr>
        <tr>
            <td class="totals"><strong><?= __('Percentage discount'); ?></strong></td>
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
    <?php } ?>

    <tr>
        <td class="totals"><strong><?= __('TVA'); ?></strong></td>
        <td class="totals cost">
            <?php if(!empty($facture['TransportBill']['total_tva'])) {
                echo number_format($facture['TransportBill']['total_tva'], 2, ",", ".").'DA';
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
                echo number_format($facture['TransportBill']['stamp'], 2, ",", ".") ?>. <?=  'DA' ?>;
                ?>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td class="totals"><strong><?= __('Net a payer'); ?></strong></td>
        <td class="totals cost">
            <?= number_format($facture['TransportBill']['total_ttc'], 2, ",", ".") ?>. <?= 'DA' ?>
        </td>
    </tr>


        </tbody>



    </table>

    <?php
        $stampToDisplay = $company['Company']['stamp_image'];
        if (
            isset($stampToDisplay) && !empty($stampToDisplay) &&
            file_exists(WWW_ROOT . "/cachet/{$stampToDisplay}")
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