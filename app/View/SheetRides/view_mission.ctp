
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
        @page { margin: 95px 0; }
        @font-face {
            font-family: 'AlHurra';
            src: url('<?= WWW_ROOT ?>/fonts/Al-Hurra-Txtreg-Light.ttf')  format('truetype'); /* Safari, Android, iOS */
        }
        #header { position: fixed; left: 0; top: -110px; right: 0; height: 120px; border-bottom: 1px solid #000;}
        #header table{width:100%;}
        #header td.logo{vertical-align: top;padding-left:25px;padding-top:20px; width:270px;}
        #header td.company { width: 700px;vertical-align: top; font-weight: bold; font-size:
            16px;padding-right:50px; padding-top:20px; text-align: center}

        #header td.company span{padding-left: 25px ;display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}
        #footer { position: fixed; left: 0; bottom: -95px; right: 0; height: 50px; border-top: 1px solid #000;text-align:center; }
        #copyright{font-size:10px; text-align:center; position: fixed; left: 0; height:10px; bottom: -95px; }
        .box-body{padding: 0 25px; margin: 0; width: 100%;}


        .title{font-weight: bold; font-size: 24px;
            text-align: center;
            padding-bottom: 40px;
            /*border-bottom: 1px solid #000;*/
            width: 500px;
            margin: 0 auto 10px;

        }
        .title_ar{font-weight: bold; font-size: 24px;
            text-align: center;
            padding-top: 5px;
            /*border-bottom: 1px solid #000;*/
            width: 500px;
            margin: 0 auto 10px;

        }
        .customer table {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
        }
        .customer tr td:first-child{
            width: 550px !important;
            padding-bottom: 20px;
        }
        .ecriture_ar {
            width: 190px !important;
            text-align: right;
        }

        table.footer{width: 100%; font-size: 12px; margin-top: 20px;padding-top: 10px;border-top: 1px solid #000;}


        table.footer td.first{width: 50%; text-align: left; padding-left:25px;}
        table.footer td.second{width: 50%; text-align: left; padding-left:25px;}

        .obs{
            width:750px;
            padding: 5px;
            margin: 0 auto;
            border: 1px solid #000;
            height:100px;
        }
        .resp{ padding-left:500px;
            padding-top: 30px;
        }
        .date_recep{padding-left:50px; padding-top:10px;}
        .ref{width:500px; display:inline-block;}
    </style>
</head>
<body>
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
                        <strong>Au capitale de <?= $company['Company']['social_capital'] ?></strong>
                    </span>
                </td>

                <td  class="date" ></td>
            </tr>
        </table>
    <?php } ?>
</div>
<div class="box-body">
    <?php $carSubcontracting = $sheetRide['SheetRide']['car_subcontracting']; ?>
    <div style="clear: both"></div>
    <div  style="direction: rtl; font-family:  DejaVu Sans, sans-serif; letter-spacing: -5px;" class="title_ar">أمرالقيام بمهمة</div>
    <div class="title" style="text-transform: uppercase">Ordre de mission</div>
    <div style="clear: both"></div>
    <div class="customer">
        <table>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;N&deg; :</strong>
                    <?=  $sheetRide['SheetRide']['reference'] ?></td>
                <td class="ecriture_ar" style="padding-right: 3px;">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -3px;">رقم القيد</strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Nom  et pr&eacute;nom :</strong>
                    <?php if($carSubcontracting == 2) { ?>
                    &nbsp;<?= $sheetRide['Customer']['first_name'].' '.$sheetRide['Customer']['last_name']?></td>
                <?php } else {?>
                    &nbsp;<?= $sheetRide['SheetRide']['customer_name'] ?></td>
                <?php  }?>

                <td class="ecriture_ar" >
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -3px;">السيد</strong>
                </td>

            </tr>



            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Fonction :</strong> &nbsp;<?= $sheetRide['CustomerCategory']['name']?> </td>
                <td class="ecriture_ar" style="padding-right: 7px;"><strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2.5px;"> المهنة :</strong></td>

            </tr>

            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Résidence Administrative :</strong><?=$wilayaName?></td>
                <td class="ecriture_ar" style="padding-right: 7px;">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -3px;">   الاداري </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2.5px;">المقر </strong>
                </td>
            </tr>


            <tr style="text-transform: uppercase">
                <td><strong> &nbsp;Lieu :</strong> </td>
                <td class="ecriture_ar" style="padding-right: 7px;">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; letter-spacing: -2px;"> المكان : </strong>
                </td>

            </tr>
            <tr style="text-transform: uppercase">

                <td><strong> &nbsp;Destination :</strong> &nbsp;<?= $sheetRide['Destination']['name'] ;?></td>


                <td class="ecriture_ar" style="padding-right: 7px;">
                    <strong style="padding-right:10px; direction: rtl; font-family: 'DejaVu Sans';  letter-spacing: -2.5px;"> الوجهة : </strong>
                </td>

            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Sera Accompagné :</strong>
                    <?php
                    if(!empty($conveyors)){
                        foreach ($conveyors as $conveyor){
                            echo $conveyor['Customer']['first_name'].' '.$conveyor['Customer']['last_name'].' , ';
                        }
                    }
                    ?>
                </td>
                <td class="ecriture_ar" style="padding-right: 0px;">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2.5px; padding-left: -5px">بصحبة </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Motif de mission :</strong><?= $sheetRide['TravelReason']['name']?></td>
                <td class="ecriture_ar" style="padding-right: 8px;">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px; margin-right: -25px "> التنقل </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -4px;">سبب </strong>
                </td>
            </tr>

            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Date de d&eacute;part :</strong><?= $this->Time->format($sheetRide['SheetRide']['real_start_date'], '%d-%m-%Y')?></td>
                <td class="ecriture_ar" style="padding-right: 0px;">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;  margin-right: -15px">  بالمهمة </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;  margin-right: -15px"> القيام  </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;">تاريخ </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Date de retour :</strong> <?= $this->Time->format($sheetRide['SheetRide']['real_end_date'], '%d-%m-%Y')?></td>
                <td class="ecriture_ar" style="padding-right: 0px;">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;"> الرجوع </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;">تاريخ </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Durée prévue :</strong> </td>
                <td class="ecriture_ar" style="padding-right: 7px;">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;"> المحددة </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;">المدة </strong>
                </td>
            </tr>


            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Véhicule Utilisé N :</strong>
                    <?php if($carSubcontracting == 2) { ?>
                        &nbsp;<?= $sheetRide['Car']['immatr_def'] ?>
                    <?php }else { ?>
                        &nbsp;<?= $sheetRide['SheetRide']['car_name'] ?>
                    <?php } ?>

                </td>
                <td class="ecriture_ar" style="padding-right: 2px;">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2.5px; margin-right : -20px"> المستعملة : </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px; padding-right: 10px;"> النقل  </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -4px; padding-left: -20px">وسيلة </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Heure de d&eacute;part :</strong></td>
                <td class="ecriture_ar" style="padding-right: 10px;">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;  margin-right: -10px">  للمهمة </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;  margin-right: -15px"> الانطلاق  </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;">وقت </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Date de retour :</strong> </td>
                <td class="ecriture_ar" style="padding-right: 10px;">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;  margin-right: -5px"> من المهمة </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;  margin-right: -5px"> الرجوع  </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;">وقت </strong>

                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Consommation carburant :</strong> </td>

                <table  >


                    <tbody>
                    <?php
                    $i = 0;
                    $coupons = array();
                    foreach ($consumptions as $consumption) {
                        $i++;
                        if ($i < count($consumptions)) {

                            if ($consumptions[$i]['Consumption']['id'] == $consumption['Consumption']['id']) {
                                $coupons[] = $consumption['Coupon']['serial_number'];
                            } else {
                                $coupons[] = $consumption['Coupon']['serial_number'];
                                ?>
                                <tr >




                                    <?php
                                    switch($consumption['Consumption']['type_consumption_used']){
                                        case ConsumptionTypesEnum::coupon : ?>
                                            <?php  if ($paramConsumption['0'] == 1) { ?>
                                                <td> <?php echo __('Coupons'); ?></td>
                                                <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M'));?> </td>
                                                <td><?php echo h($consumption['Consumption']['nb_coupon']);?> </td>
                                                <td><?php echo h($consumption['Consumption']['first_number_coupon']);?></td>
                                                <td><?php echo h($consumption['Consumption']['first_number_coupon']);?></td>
                                                <td>
                                                    <?php
                                                    $nbCoupons = count($coupons);
                                                    $j = 1;
                                                    foreach ($coupons as $coupon) {
                                                        if ($j == $nbCoupons) {
                                                            echo $coupon;
                                                        } else {
                                                            echo $coupon . ' , ';
                                                        }
                                                        $j++;
                                                    } ?>
                                                </td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['1'] == 1) { ?>
                                                <td></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['2'] == 1) { ?>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['3'] == 1) { ?>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <?php break;
                                        case ConsumptionTypesEnum::species: ?>
                                            <td> <?php echo __('Species');?></td>
                                            <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M'));?></td>
                                            <?php  if ($paramConsumption['0'] == 1) { ?>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['1'] == 1) { ?>
                                                <td><?php echo h($consumption['Consumption']['species']);?></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['2'] == 1) { ?>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['3'] == 1) { ?>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <?php break;
                                        case ConsumptionTypesEnum::tank: ?>
                                            <td> <?php echo __('Tank');?></td>
                                            <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M'));?></td>
                                            <?php  if ($paramConsumption['0'] == 1) { ?>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['1'] == 1) { ?>
                                                <td></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['2'] == 1) { ?>
                                                <td><?php echo h($consumption['Tank']['name']);?></td>
                                                <td><?php echo h($consumption['Consumption']['consumption_liter']);?></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['3'] == 1) { ?>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <?php break;
                                        case ConsumptionTypesEnum::card: ?>
                                            <td> <?php echo __('Cards');?></td>
                                            <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M'));?></td>
                                            <?php  if ($paramConsumption['0'] == 1) { ?>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['1'] == 1) { ?>
                                                <td></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['2'] == 1) { ?>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <?php  if ($paramConsumption['3'] == 1) { ?>
                                                <td><?php echo h($consumption['FuelCard']['reference']);?></td>
                                                <td><?php echo number_format($consumption['Consumption']['species_card'], 2, ",", ".");?></td>
                                            <?php } ?>
                                            <?php break;
                                    } ?>


                                    </td>

                                </tr>

                                <?php  $consumptionId = $consumption['Consumption']['id'];
                                $coupons = array();
                            }


                        } else {

                            $coupons[] = $consumption['Coupon']['serial_number'];


                            ?>


                            <tr >

                                <?php
                                switch($consumption['Consumption']['type_consumption_used']){
                                    case ConsumptionTypesEnum::coupon : ?>
                                        <td> <?php echo __('Coupons'); ?></td>
                                        <?php  if ($paramConsumption['0'] == 1) { ?>
                                            <td><?php echo h($consumption['Consumption']['nb_coupon']);?> </td>
                                            <td><?php echo h($consumption['Consumption']['first_number_coupon']);?></td>
                                            <td><?php echo h($consumption['Consumption']['first_number_coupon']);?></td>
                                            <td>
                                                <?php
                                                $nbCoupons = count($coupons);
                                                $j = 1;
                                                foreach ($coupons as $coupon) {
                                                    if ($j == $nbCoupons) {
                                                        echo $coupon;
                                                    } else {
                                                        echo $coupon . ' , ';
                                                    }
                                                    $j++;
                                                } ?>
                                            </td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['1'] == 1) { ?>
                                            <td></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['2'] == 1) { ?>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['3'] == 1) { ?>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php break;
                                    case ConsumptionTypesEnum::species: ?>
                                        <td> <?php echo __('Species');?></td>
                                        <?php  if ($paramConsumption['0'] == 1) { ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['1'] == 1) { ?>
                                            <td><?php echo h($consumption['Consumption']['species']);?></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['2'] == 1) { ?>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['3'] == 1) { ?>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php break;
                                    case ConsumptionTypesEnum::tank: ?>
                                        <td> <?php echo __('Tank');?></td>
                                        <?php  if ($paramConsumption['0'] == 1) { ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['1'] == 1) { ?>
                                            <td></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['2'] == 1) { ?>
                                            <td><?php echo h($consumption['Tank']['name']);?></td>
                                            <td><?php echo h($consumption['Consumption']['consumption_liter']);?></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['3'] == 1) { ?>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php break;
                                    case ConsumptionTypesEnum::card: ?>
                                        <td> <?php echo __('Cards');?></td>
                                        <?php  if ($paramConsumption['0'] == 1) { ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['1'] == 1) { ?>
                                            <td></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['2'] == 1) { ?>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                        <?php  if ($paramConsumption['3'] == 1) { ?>
                                            <td><?php echo h($consumption['FuelCard']['reference']);?></td>
                                            <td><?php echo number_format($consumption['Consumption']['species_card'], 2, ",", ".");?></td>
                                        <?php } ?>
                                        <?php break;
                                }

                                ?>


                            </tr>

                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>



                <td class="ecriture_ar" style="padding-right: 10px;">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;  margin-right: -25px"> المستهلك  </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px; margin-right: -6px">الوقود </strong>

                </td>
            </tr>








        </table>
    </div>


    <table style="margin-top: 100px">
        <tr >
            <td style ='padding-left: 50px;'><strong>&nbsp;Fait a <?= $wilayaName ?>  Le : <?= date("d-m-Y") ?></strong></td>
            <td class="ecriture_ar" style="padding-right: 10px;">
                <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;">حرر </strong>

            </td>
        </tr>
    </table>
    <table >
        <tr>

            <td class="resp"><strong><?php if(!empty($signature_mission_order)) {echo $signature_mission_order; } else {echo 'Le responsable logistique';}?>  </strong></td>
        </tr>
    </table>
</div>
<div id="footer">

    <p style="text-align: center; font-size: 12px; font-weight: bold"><?= $company['Company']['adress'] ?></p>

</div>
<p id='copyright'>Logiciel : UtranX | www.cafyb.com</p>
</body>
</html>