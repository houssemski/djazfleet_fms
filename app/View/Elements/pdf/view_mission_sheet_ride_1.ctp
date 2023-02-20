
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
        @page { margin: 120px 30px 0px 30px; }
        @font-face {
            font-family: 'AlHurra';
            src: url('<?= WWW_ROOT ?>/fonts/Al-Hurra-Txtreg-Light.ttf')  format('truetype'); /* Safari, Android, iOS */
        }
        #header { position: fixed; left: 0; top: -120px; right: 0; height: 120px; border-bottom: 1px solid #000;}
        #header table{width:100%;}
        #header td.logo{vertical-align: top;padding-left:25px;padding-top:20px; width:270px;}
        #header td.company { width: 700px;vertical-align: top; font-weight: bold; font-size:
            16px;padding-right:50px; padding-top:20px; text-align: center}

        #header td.company span{padding-left: 25px ;display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}
        #footer { position: fixed; left: 0; bottom: -65px; right: 0; height: 65px; border-top: 1px solid #000;text-align:center; }
        #copyright{font-size:10px; text-align:center; }
        .box-body{padding: 0 0px; margin: 0; width: 100%;}

        .title{
            font-weight: bold; font-size: 24px;
            text-align: center;
            padding-bottom: 40px;
            /*border-bottom: 1px solid #000;*/
            width: 500px;
            margin: 0 auto 10px;
        }
        .title_ar{
            font-weight: bold; font-size: 24px;
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
        .customer tr td:first-child {
            width: 60% !important;
            padding-bottom: 8px;
            line-height : 25px
        }
        .ecriture_ar {
            width: 40% !important;
            text-align: right;
            padding-top: -8px;
            line-height : 25px
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
        .audit {
            font-size: 10px;
            line-height : 5px;
        }

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
    <div  style="direction: rtl; font-family:  DejaVu Sans, sans-serif; " class="title_ar">أمرالقيام بمهمة</div>
    <div class="title" style="text-transform: uppercase">Ordre de mission</div>
    <div style="clear: both"></div>
    <div class="customer">
        <table class="table-body">
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;N&deg; :
                   <span style="padding-left: 25px;"> <?=  $sheetRide['SheetRide']['reference'] ?></span></strong></td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">رقم القيد :</strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Nom  et pr&eacute;nom :
                    <?php if($carSubcontracting == 2) { ?>
                    <span style="padding-left: 25px;">&nbsp;<?= $sheetRide['Customer']['first_name'].' '.$sheetRide['Customer']['last_name']?></span></strong></td>
                <?php } else {?>
                <span style="padding-left: 25px;"> &nbsp;<?= $sheetRide['SheetRide']['customer_name'] ?></span></strong></td>
                <?php  }?>

                <td class="ecriture_ar" >
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">السيد :</strong>
                </td>

            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Fonction : &nbsp;<span style=""><?= $sheetRide['CustomerCategory']['name']?></span></strong> </td>
                <td class="ecriture_ar" style="padding-right: 7px;"><strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;"> المهنة :</strong></td>

            </tr>

            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Résidence Administrative :<span style="padding-left: 25px;"><?=$wilayaName?></span></strong></td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">   الاداري :</strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; "> المقر </strong>
                </td>
            </tr>


            <tr style="text-transform: uppercase">
                <td><strong> &nbsp;Lieu :</strong> </td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; "> المكان : </strong>
                </td>

            </tr>
            <tr style="text-transform: uppercase">

                <td><strong> &nbsp;Destination : &nbsp;<span style="padding-left: 25px;"><?= $sheetRide['Destination']['name'] ;?></span></strong></td>


                <td class="ecriture_ar" style="">
                    <strong style=" direction: rtl; font-family: 'DejaVu Sans';  "> الوجهة : </strong>
                </td>

            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Sera Accompagné :
                    <span style="padding-left: 25px;">  <?php
                    if(!empty($conveyors)){
                        foreach ($conveyors as $conveyor){
                            echo $conveyor['Customer']['first_name'].' '.$conveyor['Customer']['last_name'].' , ';
                        }
                    }
                    ?></strong></span>
                </td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;  ">بصحبة :</strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Motif de mission :<span style="padding-left: 25px;"><?= $sheetRide['TravelReason']['name']?></span></strong></td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;   "> التنقل :</strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; "> سبب </strong>
                </td>
            </tr>

            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Date de d&eacute;part :<span style="padding-left: 25px;"><?= $this->Time->format($sheetRide['SheetRide']['real_start_date'], '%d-%m-%Y')?></span></strong></td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;   ">   بالمهمة :</strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;   ">  القيام  </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">تاريخ  </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Date de retour : <span style="padding-left: 25px;"><?= $this->Time->format($sheetRide['SheetRide']['real_end_date'], '%d-%m-%Y')?></span></strong></td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; "> الرجوع :</strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">تاريخ </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Durée prévue :</strong> </td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; "> المحددة :</strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">المدة </strong>
                </td>
            </tr>


            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Véhicule Utilisé N :
                    <?php if($carSubcontracting == 2) { ?>
                    <span style="padding-left: 25px;">&nbsp;<?= $sheetRide['Car']['immatr_def'] ?></span></strong>
                    <?php }else { ?>
                        &nbsp;<span style="padding-left: 25px;"><?= $sheetRide['SheetRide']['car_name'] ?></span></strong>
                    <?php } ?>

                </td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;  "> المستعملة : </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;  "> النقل  </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">وسيلة </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Heure de d&eacute;part :</strong></td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;  ">  للمهمة :</strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;  "> الانطلاق  </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">وقت </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Date de retour :</strong> </td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;  "> من المهمة :</strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;   "> الرجوع  </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">وقت </strong>

                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Consommation carburant :</strong>

                </td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;   "> المستهلك  :</strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;  ">الوقود </strong>

                </td>
            </tr>
            <tr>
                <td style="padding-left: 250px">
                    <?php
                    $i = 0;
                    $coupons = array();
                    echo "<div style ='margin-top: -32px'>";
                    foreach ($consumptions as $consumption) {
                        $i++;
                        if ($i < count($consumptions)) {

                            if ($consumptions[$i]['Consumption']['id'] == $consumption['Consumption']['id']) {
                                $coupons[] = $consumption['Coupon']['serial_number'];
                            } else {
                                $coupons[] = $consumption['Coupon']['serial_number'];

                                switch($consumption['Consumption']['type_consumption_used']){
                                    case ConsumptionTypesEnum::coupon :
                                        if ($paramConsumption['0'] == 1) {
                                            echo '<strong>';
                                            echo __('Coupons').' : ';
                                            echo h($consumption['Consumption']['nb_coupon']);
                                            echo h($consumption['Consumption']['first_number_coupon']);
                                            echo h($consumption['Consumption']['first_number_coupon']);
                                            echo '</strong>';
                                            $nbCoupons = count($coupons);
                                            $j = 1;
                                            echo '<strong>';
                                            foreach ($coupons as $coupon) {
                                                if ($j == $nbCoupons) {

                                                    echo $coupon;
                                                } else {
                                                    echo $coupon . ' , ';
                                                }
                                                $j++;
                                            }
                                            echo '</strong>';
                                        }

                                        break;
                                    case ConsumptionTypesEnum::species:
                                        echo '<strong>';
                                        echo __('Species').' : ';


                                        echo h($consumption['Consumption']['species']);
                                        echo '</strong>';
                                        break;
                                    case ConsumptionTypesEnum::tank:
                                        echo __('Tank').' : ';
                                        echo '<strong>';

                                        echo h($consumption['Tank']['name']).' : ';
                                        echo h($consumption['Consumption']['consumption_liter']);
                                        echo '</strong>';

                                        break;
                                    case ConsumptionTypesEnum::card:
                                        echo '<strong>';
                                        echo __('Cards').' : ';

                                        echo h($consumption['FuelCard']['reference']);
                                        echo '</strong>';

                                        break;
                                }
                                echo '<br>';
                                $consumptionId = $consumption['Consumption']['id'];
                                $coupons = array();
                            }
                        } else {

                            $coupons[] = $consumption['Coupon']['serial_number'];

                            switch($consumption['Consumption']['type_consumption_used']){
                                case ConsumptionTypesEnum::coupon :
                                    echo '<strong>';
                                    echo __('Coupons').' : ';

                                    echo h($consumption['Consumption']['nb_coupon']);
                                    echo h($consumption['Consumption']['first_number_coupon']);
                                    echo h($consumption['Consumption']['first_number_coupon']);
                                    echo '</strong>';
                                    $nbCoupons = count($coupons);
                                    $j = 1;
                                    foreach ($coupons as $coupon) {
                                        if ($j == $nbCoupons) {
                                            echo $coupon;
                                        } else {
                                            echo $coupon . ' , ';
                                        }
                                        $j++;
                                    }
                                    break;
                                case ConsumptionTypesEnum::species:
                                    echo '<strong>';
                                    echo __('Species').' : ';

                                    echo h($consumption['Consumption']['species']);
                                    echo '</strong>';
                                    break;
                                case ConsumptionTypesEnum::tank:
                                    echo '<strong>';
                                    echo __('Tank').' : ';

                                    echo h($consumption['Tank']['name']) .' : ';
                                    echo h($consumption['Consumption']['consumption_liter']);
                                    echo '</strong>';

                                    break;
                                case ConsumptionTypesEnum::card:
                                    echo '<strong>';
                                    echo __('Cards').' : ';


                                    echo h($consumption['FuelCard']['reference']);
                                    echo '</strong>';
                                    break;
                            }
                            echo '<br>';
                        }
                    }

                    echo "</div>";
                    ?>
                </td>
            </tr>
        </table>
    </div>
    <table style="margin-top: 100px">
        <tr >
            <td>
                <?php foreach ($audits as $audit) { ?>
                    <p class="audit"><?= $audit['Action']['name'] ?> : <?= $audit['User']['first_name'] ?> <?= $audit['User']['last_name'] ?> à <?= $this->Time->format($audit['Audit']['created'], '%d-%m-%Y %H:%M') ?></p>
                <?php  } ?>
            </td>
        </tr>
        <tr>
            <td style ='padding-left: 50px;'><strong>&nbsp;Fait a <?= $wilayaName ?>  Le : <?= $this->Time->format($sheetRide['SheetRide']['created'], '%d-%m-%Y') ?></strong></td>
            <td class="ecriture_ar" style="">
                <strong style="position: relative; left : 350px;direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">حرر :</strong>

            </td>
        </tr>
    </table>



    <table >
        <tr>

            <td class="resp"><strong><?php if(!empty($signature_mission_order)) {echo $signature_mission_order; } else {echo 'Le responsable ';}?>  </strong></td>
        </tr>
    </table>
</div>
<div id="footer">

    <p style="text-align: center; font-size: 12px; font-weight: bold"><?= $company['Company']['adress'] ?></p>
    <p id='copyright'>Logiciel : UtranX | www.cafyb.com</p>
</div>

</body>
</html>