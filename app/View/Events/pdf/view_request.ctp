<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
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
            font-size: 20px;
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
        .table-bordered{
            border: solid 1px black;
            width: 100%;
        }
        .chackbox{
            height: 10px;
            width: 30px;
            border: solid 1px black;
            display: inline-block;
            margin-top: 5px;
        }
    </style>

</head>
<body class='body'>
<div class="box-body">
    <table class="bloc-center">
        <div class="event-title">
            LABORATOIRE DES TRAVAUX PUBLICS DU SUD
        </div>
    </table>

    <br>
    <br>

    <table class="bloc-center">
        <div class="event-title">
            DEMANDE D' INTERVENTION
        </div>
    </table>
    <?php
    ?>
    <br>
    <table class="bloc-center">
        <tr>
            <td>
                Réparation : <div class="chackbox"></div>
            </td>
            <td>
                Entretien : <div class="chackbox"></div>
            </td>
            <td>
                Etalonage : <div class="chackbox"></div>
            </td>
        </tr>
    </table>
    <br>
    <table class="table-bordered">
        <tr>
            <td>
                <strong>Structure</strong> : <?= $event[0]['Structures']['name'] ?>
            </td>
            <td>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Equipement</strong> : <?php
                if(isset($event[0]['Event']['intervention_for'])){
                    if ($event[0]['Event']['intervention_for'] == '1'){
                        if(!empty($carModel)){
                            echo $carModel[0]['Mark']['name'].' '.$carModel[0]['Carmodel']['name'];
                        }
                    }else{
                        echo $event[0]['Event']['other'];
                    }
                }else{
                    if(!empty($carModel)){
                        echo $carModel[0]['Mark']['name'].' '.$carModel[0]['Carmodel']['name'];
                    }
                }
                ?>
            </td>
            <td>
               <strong>N°</strong> : <?= $event[0]['Car']['immatr_def'] ?>
            </td>
        </tr>
    </table>

    <br>

    <table class="event-table">
        <thead>
        <tr>
            <th><?php echo __('DEMENDEUR'); ?></th>
            <th><?php echo __("RESPONSABLE"); ?></th>
            <th><?php echo __('DATE EMISSION'); ?></th>
            <th><?php echo __('DELAI SOUHAITE'); ?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="center">
               <?php
               if (!empty($event[0]['Customer'])){
                   echo $event[0]['Customer']['first_name'].' '.$event[0]['Customer']['last_name'];
               }

               ?>
            </td>
            <td class="center">
                <?php
                    if(!empty($boss)){
                        echo $boss['first_name'].' '.$boss['last_name'];
                    }
                ?>
            </td>
            <td rowspan="2" class="center">
                <?= $event[0]['Event']['intervention_request_date'] ?>
            </td>
            <td rowspan="2" class="center">
                <?= $diffInDays > 0 ? $diffInDays.' Jours' : ' ' ?>
            </td>
        </tr>
        <tr>
            <td class="center" style="height: 40px">
                VISA
            </td>
            <td class="center">
                VISA
            </td>
        </tr>
        <tr>
            <td colspan="4" style="height: 80px" >
                Constatations : <br>
                - <?= $eventType[0]['EventType']['name'] ?>

            </td>
        </tr>
        </tbody>
    </table>


    <div id="copyright" >
        F-7-1.02
    </div>


</div>


</body>


</html>