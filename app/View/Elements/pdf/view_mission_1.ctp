
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
        @page { margin: 95px 0; }
        @font-face {
            font-family: 'AlHurra';
            src: url('<?= WWW_ROOT ?>/fonts/Al-Hurra-Txtreg-Light.ttf')  format('truetype'); /* Safari, Android, iOS */
        }
        #header { position: fixed; left: 0; top: -110px; right: 0; height: 165px; border-bottom: 1px solid #000;}
        #header table{width:100%;}
        #header td.logo{vertical-align: top;padding-left:25px;padding-top:20px; width:270px;}
        #header td.company{ width: 500px;vertical-align: top; font-weight: bold; font-size: 16px;padding-right:50px; padding-top:20px;}
        #header td.company span{padding-left: 25px ;display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}
        #footer { position: fixed; left: 0; bottom: -95px; right: 0; height: 110px;  }
        #copyright{font-size:10px; text-align:center; position: fixed; left: 0; height:10px; bottom: -95px;}
        .box-body{ margin: 0; width: 100%;}

        .date{padding-top: 55px; text-align:right;padding-right:25px;}
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
           /* width: 550px !important;*/
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
        .resp{ padding-left:400px; }
        .date_recep{padding-left:50px; padding-top:10px;}
        .ref{width:500px; display:inline-block;}
    </style>
</head>
<body>

<div id="header">
    <?php
    if($entete_pdf=='1') {?>
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
                    <?php } else { ?>
                        <img  width="180px" height="120px">
                    <?php } ?>


                </td>
                <td  class="date" ></td>
            </tr>
        </table>
    <?php }?>

</div>
<div class="box-body">
    <br>
    <div class="date" ><span  class='' style="float: left; padding-left: 25px; text-align:left;"><strong>N&deg; : <?= $sheetRideDetailRide['SheetRideDetailRides']['reference'] ?></strong> </span><span style="text-align:right;"><?= $wilayaName;?> Le : <?= date("d-m-Y") ?></span> </div>

    <?php $carSubcontracting = $sheetRideDetailRide['SheetRide']['car_subcontracting']; ?>
    <div style="clear: both"></div>
    <div  style="direction: rtl; font-family:  DejaVu Sans, sans-serif;" class="title_ar">أمر مهمة</div>
    <div class="title" style="text-transform: uppercase">Ordre de mission</div>
    <div style="clear: both"></div>
    <div class="customer">
        <table>
            <tr style="text-transform: uppercase">
                <td style =""><strong>&nbsp;Nom  et pr&eacute;nom :</strong>

                    <?php if($carSubcontracting == 2) { ?>
                    &nbsp;<?= $sheetRideDetailRide['Customer']['first_name'].' '.$sheetRideDetailRide['Customer']['last_name']?></td>

                <?php }else {?>
                    &nbsp;<?= $sheetRideDetailRide['SheetRide']['customer_name'] ?></td>

                <?php  }?>

                <td class="ecriture_ar" >
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;"> اللقب : </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; "> و </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;">الإسم</strong>
                </td>

            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Profession :</strong> &nbsp;<?= $sheetRideDetailRide['CustomerCategory']['name']?> </td>
                <td class="ecriture_ar"><strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; "> المهنة :</strong></td>

            </tr>


            <tr style="text-transform: uppercase">
                <td><strong> &nbsp;Client :</strong> &nbsp;<?= $sheetRideDetailRide['Supplier']['name']?></td>
                <td class="ecriture_ar">
                    <strong style="direction: rtl; text-align: right; font-family: 'DejaVu Sans';"> الزبون : </strong>
                </td>

            </tr>
            <tr style="text-transform: uppercase">
                <?php if ($sheetRideDetailRide['SheetRideDetailRides']['type_ride'] == 2) { ?>
                    <td><strong> &nbsp;Destination :</strong> &nbsp;<?= $sheetRideDetailRide['Departure']['name'] . '-' . $sheetRideDetailRide['Arrival']['name'];?></td>

                <?php } else { ?>
                    <td><strong> &nbsp;Destination :</strong> &nbsp;<?= $sheetRideDetailRide['DepartureDestination']['name'] . '-' . $sheetRideDetailRide['ArrivalDestination']['name'] ;;?></td>

                <?php } ?>
                <td class="ecriture_ar">
                    <strong style=" direction: rtl; text-align: right;   font-family: 'DejaVu Sans'; "> الوجهة : </strong>
                </td>

            </tr>


            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Matricule :</strong>
                    <?php if($carSubcontracting == 2) { ?>
                        &nbsp;<?= $sheetRideDetailRide['Car']['immatr_def'] ?>
                    <?php }else { ?>
                        &nbsp;<?= $sheetRideDetailRide['SheetRide']['car_name'] ?>
                    <?php } ?>

                </td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; "> التسجيل : </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ">رقم </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Moyen de transport : </strong>
                    <?php if($carSubcontracting == 2) { ?>
                        &nbsp <?= $sheetRideDetailRide['Carmodel']['name'] ?>
                    <?php } else { ?>
                        &nbsp;<?= $sheetRideDetailRide['SheetRide']['car_name'] ?>
                    <?php } ?>

                </td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; "> النقل : </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;">وسيلة </strong>
                </td>

            </tr>
            <tr style="text-transform: uppercase">
                <?php if ($sheetRideDetailRide['CarTypeRemorque']['display_model_mission_order']==1) { ?>
                    <td><strong><?= $sheetRideDetailRide['CarTypeRemorque']['name'] ?> &nbsp; :</strong> &nbsp;
                        <?php if($carSubcontracting == 2) { ?>
                            <?= $sheetRideDetailRide['CarmodelRemorque']['name'].' '.$sheetRideDetailRide['Remorque']['immatr_def']?>
                        <?php } else { ?>
                            <?= $sheetRideDetailRide['SheetRide']['remorque_name'] ?>
                        <?php } ?>


                    </td>

                <?php } else {?>
                    <td><strong><?= $sheetRideDetailRide['CarTypeRemorque']['name'] ?> &nbsp; :</strong>
                        <?php if($carSubcontracting == 2) { ?>
                            <?= $sheetRideDetailRide['Remorque']['immatr_def']?>
                        <?php } else { ?>
                            <?= $sheetRideDetailRide['SheetRide']['remorque_name'] ?>
                        <?php } ?>
                    </td>

                <?php } ?>

                <td class="ecriture_ar">
                    <strong style="direction: rtl; text-align: right; font-family: 'DejaVu Sans';">المقطورة : </strong>
                </td>

            </tr>


            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Motif de mission :</strong><?= $sheetRideDetailRide['SheetRideDetailRides']['note']?></td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;"> المهمة : </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">سبب </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Date de d&eacute;part :</strong><?= $this->Time->format($sheetRideDetailRide['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y')?></td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; "> الذهاب : </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">تاريخ </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Date de retour :</strong> Fin de mission</td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; "> العودة : </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">تاريخ </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td><strong>&nbsp;Accompagné par :</strong>
                    <?php
                    if(!empty($conveyors)){
                        foreach ($conveyors as $conveyor){
                            echo $conveyor['Customer']['first_name'].' '.$conveyor['Customer']['last_name'].' , ';
                        }
                    }
                    ?>
                </td>
                <td class="ecriture_ar" style="">
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;"> المرافقة : </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ;">الاشخاص </strong>
                </td>
            </tr>


        </table>
    </div>
    <div class='obs' style="text-transform: uppercase">
        <span style ="width: 685px ; display: inline-block"><strong>Observation:</strong></span>
        <span ><strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; ">الملاحظة </strong></.span>

    </div>

    <table >
        <tr>
            <td class='date_recep'><strong>Re&ccedilu le : </strong></td>
            <td class="resp"><strong><?php if(!empty($signature_mission_order)) {echo $signature_mission_order; } else {echo 'Le responsable logistique';}?>  </strong></td>
        </tr>
    </table>
</div>

<p id='copyright'>Logiciel : UtranX | www.cafyb.com</p>
</body>
</html>