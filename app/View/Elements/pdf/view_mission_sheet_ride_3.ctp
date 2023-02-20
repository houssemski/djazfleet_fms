
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
        @page { margin: 120px 0px 65px 20px; }
        @font-face {
            font-family: 'AlHurra';
            src: url('<?= WWW_ROOT ?>/fonts/Al-Hurra-Txtreg-Light.ttf')  format('truetype'); /* Safari, Android, iOS */
        }
        #header { position: fixed; left: 0; top: -120px; right: 0; height: 120px;}
        #header table{width:100%;}
        #header td.company { width: 80%;vertical-align: top; font-weight: bold; font-size:
            16px; padding-top:20px; text-align: center}

        #header td.company span{display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}
        #footer { position: fixed; left: 0; bottom: -35px; right: 0; height: 5px; border-top: 1px solid #000;text-align:center; }
        #copyright{font-size:10px; text-align:center; }
        .box-body{padding: 0 20px; margin: 0; width: 100%;}


        .title_ar{
            font-weight: bold; font-size: 30px;
            text-align: right;
            padding-top: 5px;
        }

        .customer table {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
        }
        .customer tr td:first-child {
            width: 50% !important;
            padding-left: 10px;
            padding-bottom: 8px;
            line-height : 25px
        }
        .ecriture_ar {
            text-align: right;
            line-height : 25px;
            width: 50% !important;
            margin-right: 0!important;
            padding-right: 0!important;
        }




        .resp{ padding-left:500px;
            padding-top: 30px;
        }

    </style>
</head>
<body>
<div id="header">
    <?php if($entete_pdf=='1') {?>
        <table>
            <tr >

                <td class="company">
                    <span style =' direction: rtl; font-family:  DejaVu Sans, sans-serif; letter-spacing: -1px;'><?= Configure::read("nameCompanyAr") ?></span>



                            <span style ="direction: rtl; font-family:  DejaVu Sans, sans-serif; letter-spacing: -2px; font-size: 13px !important; font-weight: normal">
                                <strong>
                  شركة دات اسهم الراسمال الاجتماعي      <?= $company['Company']['social_capital'] ?> دج
                    </strong></span>

                    <span style="font-size: 12px !important; font-weight: normal; text-align: center">
                        <strong><?= $company['Company']['adress'] ?></strong> </span>
                </td>

            </tr>
        </table>
    <?php } ?>
</div>
<div class="box-body">
    <?php $carSubcontracting = $sheetRide['SheetRide']['car_subcontracting']; ?>
    <div style="clear: both"></div>
    <table style ='width: 92%'>
        <tr>
            <td class="title_ar">
                <strong style="direction: rtl; font-family:  DejaVu Sans, sans-serif; letter-spacing: -5px;" >أمر بمهمة</strong>
            </td>
            <td class="ecriture_ar" style ='margin-right: -6px !important; margin-top: 30px !important;'>
                <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -3px;">
                    وحدة :
                </strong> </td>
        </tr>
        <tr>
            <td class="ecriture_ar" style ='margin-right: 6px !important; margin-right: 30px'>
                <strong>&nbsp;<?= $sheetRide['SheetRide']['reference'] ?></strong>
                <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -3px;">
                     رقم :

                </strong>
            </td>

            <td class="ecriture_ar" style ='margin-right: -30px !important;'>
                <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -3px;">
                    مصلحة او مفوضة :

                </strong>
            </td>
        </tr>

    </table>

    <div style="clear: both"></div>
    <div class="customer">
        <table class="table-body" style ='width: 95%; margin-top: 30px'>
            <tr style="text-transform: uppercase">
                <td> </td>
                <td class="ecriture_ar" >
                    <strong>
                    <?php if($carSubcontracting == 2) { ?>
                    &nbsp;<?= $sheetRide['Customer']['first_name'].' '.$sheetRide['Customer']['last_name']?>
                <?php } else {?>
                     &nbsp;<?= $sheetRide['SheetRide']['customer_name'] ?>
                <?php  }?>
                    </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -3px;">الاسم و اللقب :  </strong>
                </td>
            </tr>




            <tr style="text-transform: uppercase">
                <td> </td>
                <td class="ecriture_ar" style ='margin-right: -6px !important;'><strong><?= $sheetRide['CustomerCategory']['name']?></strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -3px;">الوظيفة :</strong></td>

            </tr>
            <tr style="text-transform: uppercase">
                <td> </td>
                <td class="ecriture_ar" style ='margin-right: 6px !important;'>
                    <strong><?= $sheetRide['Destination']['name'] ;?></strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -3px;">  الاتجاه :  </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td> </td>
                <td class="ecriture_ar" style ='margin-right: 6px !important;'>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -3px;">
                        طريق الذهاب :

                    </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td> </td>
                <td class="ecriture_ar" >
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -3px;">
                        طريق الاياب :
                    </strong>
                </td>
            </tr>

            <tr style="text-transform: uppercase">
                <td> </td>
                <td class="ecriture_ar" >
                    <strong><?= $sheetRide['TravelReason']['name']?></strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -3px;">
                        سبب المهمة :
                    </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td> </td>
                <td class="ecriture_ar" style ='margin-right: -12px !important;'>
                    <strong>&nbsp;
                        <?php if($carSubcontracting == 2) { ?>
                            &nbsp;<?= $sheetRide['Car']['immatr_def'] ?>
                        <?php }else { ?>
                            &nbsp;<?= $sheetRide['SheetRide']['car_name'] ?>
                        <?php } ?>
                    </strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -3px;">
                        وسيلة النقل :
                    </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td> </td>
                <td class="ecriture_ar" style ='margin-right: -14px !important;'>
                    <strong><?= $this->Time->format($sheetRide['SheetRide']['real_start_date'], '%d-%m-%Y  %H:%M')?></strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;">
                        تاريخ و ساعة الانطلاق :
                    </strong>
                </td>
            </tr>
            <tr style="text-transform: uppercase">
                <td> </td>
                <td class="ecriture_ar" style ='margin-right: -6px !important;'>
                    <strong><?= $this->Time->format($sheetRide['SheetRide']['real_end_date'], '%d-%m-%Y  %H:%M')?></strong>
                    <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;">
                        تاريخ العودة :
                    </strong>
                </td>
            </tr>







        </table>
    </div>


    <table style="margin-top: 10px">
        <tr >
            <td class="ecriture_ar" >
                <strong style=" text-align:right ;"><?= $wilayaName ?></strong>
                <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;">في </strong>
                <strong style="  text-align:right ; ;"><?= date("d-m-Y") ?> </strong>
                <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;"> ب </strong>

            </td>
        </tr>
    </table>
    <table style="margin-top: 5px">
        <tr >
            <td class="ecriture_ar" style="padding-left: 50px;">
                <strong style="direction: rtl; font-family: 'DejaVu Sans'; text-align:right ; letter-spacing: -2px;"> توقيع و خاتم</strong>

            </td>
        </tr>
    </table>

</div>
<div id="footer">


    <p id='copyright'>Logiciel : UtranX | www.cafyb.com</p>
</div>

</body>
</html>