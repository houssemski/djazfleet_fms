<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <style type="text/css">
        @page {
            margin: 90px 10px 0px 10px;
        }

        #header { position: fixed; left: 0; top: -100px; right: 0; height: 165px;  }
        #header table{width:100%;}
        #header td.logo{vertical-align: top;padding-left:25px;padding-top:60px; width:270px;}

        #header td.company{ width: 400px;vertical-align: top; font-weight: bold; font-size: 16px;padding-right:20px;padding-left:30px; padding-top:20px;}
        #header td.company span{display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}
        #header td.logo span{display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}

        .header {margin-top: 20px ; }
        .header table{width:100%;}
        .header td.logo{vertical-align: top;padding-left:25px;padding-top:60px; width:270px;}

        .header td.company{ width: 400px;vertical-align: top; font-weight: bold; font-size: 16px;padding-right:20px; padding-top:20px;}
        .header td.company span{display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}
        .header td.logo span{display: block; font-size: 22px; padding-bottom: 2px;padding-top: 2px;}
        .bon{
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            width: 800px;
            margin-left: 80px;

        }
        .date {
            padding-top: 15px;
            text-align: right;
            padding-right: 25px;
        }



        .bloc-center {
            margin-top: 65px;
            width: 100%;
        }
        .bloc-center2 {
            margin-top: 25px;
            margin-left: 20px;
            width: 100%;
        }
        .bloc-center3 {
            width: 100%;
        }


        .date {
            font-size: 16px;
            font-weight: bold;
            text-align: right;
        }
        .body {
            margin-left: 30px;
            margin-right: 20px;
        }


        .main-table > thead > tr > th,
        .main-table > tbody > tr > th,
        .main-table > tfoot > tr > th,
        .main-table > thead > tr > td,
        .main-table > tfoot > tr > td {
        / / border: 1 px solid #000;
        }

        .main-table td {
            vertical-align: top;
            border-left: 0;
            border-right: 1px solid #C0C0C0;
            border-collapse: collapse;
            border-top: 0;
            border-bottom: 0;
        }

        .footer-table td {
            vertical-align: top;
            border-left: 0;
            border-right: 1px solid #FFF;
            border-collapse: collapse;
            border-top: 0;
            border-bottom: 0;
        }

        .main-table th {
            border-right: 1px solid black;
            border-bottom: 1px solid black;
            padding-left: 5px;
            text-align: left;
            border-collapse: collapse;
            font-size: 11px
        }

        .footer-table th {
            border-right: 1px solid white;
            border-bottom: 1px solid white;
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



        .total-div span {
            padding: 5px 5px;
            line-height: 10px;
            font-size: 10px;
        }

        .main-table td {
            text-align: left;
            padding: 3px 5px;;
            font-size: 11px
        }

        .footer-table td {
            text-align: left;
            padding: 3px 5px;;
            font-size: 10px
        }
        .text-crossed{
            text-decoration:line-through;
        }
        .audit {
            font-size: 10px;
            line-height : 5px;
        }

    </style>


</head>
<body class='body'>

<div id="header">
    <?php
    if (Configure::read('utranx_ade') == '1'){
        echo $this->element('pdf/ade-header');
    }else{
    ?>
    <?php if($entete_pdf=='1') {?>
        <table>
            <tr >

                <td class="company">
                    <span><?= Configure::read("nameCompany") ?></span>

                    <span style="font-size: 12px !important; font-weight: normal">
                        <strong>Adresse : </strong>
                        <?= isset($company['Company']['adress']) ? $company['Company']['adress'] : ''?> 
                    </span>
                    <span style="font-size: 12px !important; font-weight: normal">
                        <strong>Tel. :</strong>
                        <?= isset($company['Company']['phone']) ? $company['Company']['phone'] : ''  ?>
                    </span>
                    <span style="font-size: 12px !important; font-weight: normal">
                            <strong>N DE RC : </strong>
                            <?= isset($company['Company']['rc']) ? $company['Company']['rc'] : ''  ?>
                    </span>
                    <span style="font-size: 12px !important; font-weight: normal">
                            <strong>Identification Fiscal N :</strong>
                        <?= isset($company['Company']['nif']) ? $company['Company']['nif'] : '' ?>
                    </span>
                    <span style="font-size: 12px !important; font-weight: normal">
                            <strong>N D'Article :</strong>
                            <?= isset($company['Company']['ai']) ? $company['Company']['ai'] : '' ?>
                    </span>


                    <span style="font-size: 12px !important; font-weight: normal">
                            <strong>N De Compte Bancaire :</strong>
                            <?= isset($company['Company']['cb']) ? $company['Company']['cb'] : ''  ?>
                        </span>

                </td>
                <td class="logo">
                    <span class="mail" style="font-size: 12px !important; font-weight: normal">
                          <strong>Email :</strong>
                        <?= isset($company['Company']['email']) ? $company['Company']['email'] : '' ?>
                    </span>


                </td>

                <td  class="date" ></td>
            </tr>
        </table>
    <?php
    }
    }
    ?>

</div>
<table class="bloc-center">
    <tr>
        <td>

                    <span class="bon" style =' padding-top: 50px;'>BON DE PRESTATIONS EXTERNES <?=  isset($event['Event']['code']) ?  $event['Event']['code'] : '' ?></span>

        </td>

    </tr>

</table>
<table class="bloc-center2">
    <tr>
        <td>

            <div style="font-size: 12px !important; font-weight: normal"><strong>Nom ou raison social de fournisseur : </strong></div>
            <div style="font-size: 12px !important; font-weight: normal"><strong><?= isset($event['Interfering']['name']) ?  $event['Interfering']['name'] : '' ?></strong></div>

        </td>
        <td>
            <div style="font-size: 12px !important; font-weight: normal"><strong>Adresse :</strong></div>
            <div style="font-size: 12px !important; font-weight: normal"><strong> <?= isset($event['Interfering']['adress']) ?  $event['Interfering']['adress'] : '' ?></strong></div>


        </td>
        <td>
            <div style="font-size: 12px !important; font-weight: normal"><strong>Date demande d'intervention :</strong></div>
            <div style="font-size: 12px !important; font-weight: normal"><strong> <?= $event['Event']['date'];?></strong></div>
        </td>

    </tr>

</table>


<table class="main-table">
    <thead>
    <tr>
        <th><?php echo 'N&deg;'; ?></th>
        <th><?php echo __('Designation of work'); ?></th>
        <th><?php echo __('Immatriculation'); ?></th>
        <th><?php echo __('Km'); ?></th>
        <th><?php echo __('Amount'); ?></th>
        <th><?php echo __('Observation'); ?></th>



    </tr>
    </thead>
    <tbody>
        <tr <?php if($event['Event']['canceled'] ) {?> class="text-crossed"  <?php }?>>
            <td><?= 1 ?></td>
            <td><?= isset($event['EventType']['name']) ? $event['EventType']['name'] : '' ?></td>
            <td><?=  $event['Car']['immatr_def'] . ' - '. $event['Carmodel']['name'] ?></td>
            <td><?= $event['Event']['km'] ?></td>
            <td><?= $event['Event']['cost'] ?></td>
            <td><?= $event['Event']['obs'] ?></td>

        </tr>

    </tbody>
</table>
<table class="bloc-center3">
    <tr>
            <td>
            <?php foreach ($audits as $audit) { ?>
                <p class="audit"><?= $audit['Action']['name'] ?> : <?= $audit['User']['first_name'] ?> <?= $audit['User']['last_name'] ?> à <?= $this->Time->format($audit['Audit']['created'], '%d-%m-%Y %H:%M') ?></p>
            <?php  } ?>
           </td>
        <td>
            <div style="font-size: 12px !important; font-weight: normal ; text-align: right; padding-right: 150px"><strong>A <?=  $wilayaName;?> LE : <?=  date("d/m/Y"); ?></strong></div>
            <div  style="font-size: 12px !important; font-weight: normal ; text-align: right; padding-right: 100px; margin-top: 10px; margin-bottom: 100px"><strong>LE DIRECTEUR GENERAL </strong></div>
        </td>

    </tr>

</table>

<div style="margin-top:70px; border-bottom: double #000; "></div>


<div class="header">
    <?php if($entete_pdf=='1') {?>
        <table>
            <tr >

                <td class="company">
                    <span><?= Configure::read("nameCompany") ?></span>

                    <span style="font-size: 12px !important; font-weight: normal">
                        <strong>Adresse : </strong>
                        <?= isset($company['Company']['adress']) ? $company['Company']['adress'] : '' ?>
                    </span>
                    <span style="font-size: 12px !important; font-weight: normal">
                        <strong>Tel. :</strong>
                        <?= isset($company['Company']['phone']) ? $company['Company']['phone'] : '' ?>
                    </span>
                    <span style="font-size: 12px !important; font-weight: normal">
                            <strong>N DE RC : </strong>
                            <?= isset($company['Company']['rc']) ? $company['Company']['rc'] : '' ?>
                    </span>
                    <span style="font-size: 12px !important; font-weight: normal">
                            <strong>Identification Fiscal N :</strong>
                            <?= isset($company['Company']['nif']) ? $company['Company']['nif'] : '' ?>
                    </span>
                    <span style="font-size: 12px !important; font-weight: normal">
                            <strong>N D'Article :</strong>
                            <?= isset($company['Company']['ai']) ? $company['Company']['ai'] : '' ?>
                    </span>


                    <span style="font-size: 12px !important; font-weight: normal">
                            <strong>N De Compte Bancaire :</strong>
                            <?= isset($company['Company']['cb']) ? $company['Company']['cb'] : '' ?>
                        </span>

                </td>
                <td class="logo">
                    <span class="mail" style="font-size: 12px !important; font-weight: normal">
                          <strong>Email :</strong>
                          <?= isset($company['Company']['email']) ? $company['Company']['email'] : '' ?>
                    </span>
                    <span class="date" style="font-size: 12px !important; font-weight: normal;">
                          <strong>Date :<?=  date("d/m/Y"); ?></strong>

                    </span>


                </td>

                <td  class="date" ></td>
            </tr>
        </table>
    <?php }?>

</div>
<table class="bloc-center3">
    <tr>
        <td>

            <span class="bon" >BON DE PRESTATIONS EXTERNES <?= isset($event['Event']['code']) ? $event['Event']['code'] : ''?></span>

        </td>

    </tr>

</table>
<table class="bloc-center2">
    <tr>
        <td>

            <div style="font-size: 12px !important; font-weight: normal"><strong>Nom ou raison social de fournisseur : </strong></div>
            <div style="font-size: 12px !important; font-weight: normal"><strong><?= isset($event['Interfering']['name']) ?  $event['Interfering']['name'] : '' ?></strong></div>

        </td>
        <td>
            <div style="font-size: 12px !important; font-weight: normal"><strong>Adresse :</strong></div>
            <div style="font-size: 12px !important; font-weight: normal"><strong> <?= isset($event['Interfering']['adress']) ?  $event['Interfering']['adress'] : '' ?></strong></div>


        </td>
        <td>
            <div style="font-size: 12px !important; font-weight: normal"><strong>Date demande d'intervention :</strong></div>
            <div style="font-size: 12px !important; font-weight: normal"><strong> <?= $event['Event']['date'];?></strong></div>
        </td>

    </tr>

</table>
<table class="main-table">
    <thead>
    <tr>
        <th><?php echo 'N&deg;'; ?></th>
        <th><?php echo __('Designation of work'); ?></th>
        <th><?php echo __('Immatriculation'); ?></th>
        <th><?php echo __('Km'); ?></th>
        <th><?php echo __('Amount'); ?></th>
        <th><?php echo __('Observation'); ?></th>



    </tr>
    </thead>
    <tbody>

    <tr <?php if(isset($event['Event']['canceled']) && $event['Event']['canceled']) {?> class="text-crossed"  <?php }?>>
        <td><?= 1 ?></td>
        <td><?= $event['EventType']['name'] ?></td>
        <td><?= $event['Car']['immatr_def'].' - '.$event['Carmodel']['name'] ?></td>
        <td><?= $event['Event']['km'] ?></td>
        <td><?= $event['Event']['cost'] ?></td>
        <td><?= $event['Event']['obs'] ?></td>

    </tr>

    </tbody>
</table>
<table class="bloc-center3">
    <tr>
        <td>
            <?php foreach ($audits as $audit) { ?>
                <p class="audit"><?= $audit['Action']['name'] ?> : <?= $audit['User']['first_name'] ?> <?= $audit['User']['last_name'] ?> à <?= $this->Time->format($audit['Audit']['created'], '%d-%m-%Y %H:%M')  ?></p>
            <?php  } ?>

        </td>
        <td>
            <div style="font-size: 12px !important; font-weight: normal ; text-align: right; padding-right: 150px"><strong>A <?=  $wilayaName;?> LE : <?=  date("d/m/Y");  ?></strong></div>
            <div  style="font-size: 12px !important; font-weight: normal ; text-align: right; padding-right: 100px; margin-top: 10px; margin-bottom: 70px"><strong>LE DIRECTEUR GENERAL </strong></div>
        </td>

    </tr>

</table>


</body>
</html>