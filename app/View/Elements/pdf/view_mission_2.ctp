
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
        .box-body{ margin: 0; width: 100%;}


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
        .customer{
            padding: 0 25px 0 25px;
        }
        .customer table {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
        }
        .customer tr td{
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
    <?php }?>

</div>
<div class="box-body">

    <?php $carSubcontracting = $sheetRideDetailRide['SheetRide']['car_subcontracting']; ?>
    <div style="clear: both"></div>
    <br>
    <div  style="direction: rtl; font-family:  DejaVu Sans, sans-serif;" class="title_ar">أمرالقيام بمهمة</div>
    <div class="title" style="text-transform: uppercase">Ordre de mission</div>
    <div style="clear: both"></div>
    <div class="customer">
        <table>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;N&deg; :</strong>

                    <?=  $sheetRideDetailRide['SheetRideDetailRides']['reference'] ?></td>



                <td class="ecriture_ar" style="">

                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;">رقم القيد</strong>

                </td>

            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Nom  et pr&eacute;nom :</strong>

                    <?php if($carSubcontracting == 2) { ?>
                    &nbsp;<?= $sheetRideDetailRide['Customer']['first_name'].' '.$sheetRideDetailRide['Customer']['last_name']?></td>

                <?php }else {?>
                    &nbsp;<?= $sheetRideDetailRide['SheetRide']['customer_name'] ?></td>

                <?php  }?>

                <td class="ecriture_ar" >
                     <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">السيد</strong>
                </td>

            </tr>



            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Fonction :</strong> &nbsp;<?= $sheetRideDetailRide['CustomerCategory']['name']?> </td>
                <td class="ecriture_ar" style=""><strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; "> المهنة :</strong></td>

            </tr>

            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Résidence Administrative :</strong><?=$wilayaName?></td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">   الاداري </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">المقر </strong>
                </td>
            </tr>


            <tr style="text-transform: uppercase">
                    <td><strong> &nbsp;Lieu :</strong> </td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right;"> المكان : </strong>
                </td>

            </tr>
            <tr style="text-transform: uppercase">
                <?php if ($sheetRideDetailRide['SheetRideDetailRides']['type_ride'] == 2) { ?>
                    <td><strong> &nbsp;Destination :</strong> &nbsp;<?= $sheetRideDetailRide['Departure']['name'] . '-' . $sheetRideDetailRide['Arrival']['name'];?></td>

                <?php } else { ?>
                    <td><strong> &nbsp;Destination :</strong> &nbsp;<?= $sheetRideDetailRide['DepartureDestination']['name'] . '-' . $sheetRideDetailRide['ArrivalDestination']['name'] ;;?></td>

                <?php } ?>
                <td class="ecriture_ar" style="">
                    <strong style=" direction: rtl; font-family: 'DejaVu Sans';  text-align:right;"> الوجهة : </strong>
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
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">بصحبة </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Motif de mission :</strong><?= $sheetRideDetailRide['SheetRideDetailRides']['note']?></td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;"> التنقل </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">سبب </strong>
                </td>
            </tr>

            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Date de d&eacute;part :</strong><?= $this->Time->format($sheetRideDetailRide['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y')?></td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">  بالمهمة </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; "> القيام  </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">تاريخ </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Date de retour :</strong> <?= $this->Time->format($sheetRideDetailRide['SheetRideDetailRides']['real_end_date'], '%d-%m-%Y')?></td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; "> الرجوع </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">تاريخ </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Durée prévue :</strong> </td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;"> المحددة </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">المدة </strong>
                </td>
            </tr>


            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Véhicule Utilisé N :</strong>
                    <?php if($carSubcontracting == 2) { ?>
                        &nbsp;<?= $sheetRideDetailRide['Car']['immatr_def'] ?>
                    <?php }else { ?>
                        &nbsp;<?= $sheetRideDetailRide['SheetRide']['car_name'] ?>
                    <?php } ?>

                </td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;"> المستعملة : </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;"> النقل  </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">وسيلة </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Heure de d&eacute;part :</strong><?= $this->Time->format($sheetRideDetailRide['SheetRideDetailRides']['real_start_date'], '%H:%M')?></td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;">  للمهمة </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;"> الانطلاق  </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;">وقت </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Date de retour :</strong> <?= $this->Time->format($sheetRideDetailRide['SheetRideDetailRides']['real_end_date'], '%H:%M')?></td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;"> من المهمة </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; "> الرجوع  </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">وقت </strong>

                </td>
            </tr>








        </table>
    </div>


    <table style="margin-top: 70px">
        <tr >
            <td style ='padding-left: 50px;'><strong>&nbsp;Fait a <?= $wilayaName ?>  Le : <?= $this->Time->format($sheetRideDetailRide['SheetRide']['created'], '%d-%m-%Y') ?></strong></td>
            <td class="ecriture_ar" style="">
                <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;">حرر </strong>

            </td>
            <td class="" style="padding-left: 30px;"><strong><?php if(!empty($signature_mission_order)) {echo $signature_mission_order; } else {echo 'Le responsable logistique';}?>  </strong></td>
             </tr>
    </table>

</div>
<div id="footer">

                        <p style="text-align: center; font-size: 12px; font-weight: bold"><?= $company['Company']['adress'] ?></p>

</div>
<p id='copyright'>Logiciel : UtranX | www.cafyb.com</p>
</body>
</html>