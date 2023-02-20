<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <style type="text/css">
        @page {
            margin: 95px 0 0 0;
        }
        #header {
            position: fixed;
            left: 0;
            top: -40px;
            right: 0;
            height: 110px;
            padding-left: 28px;
            padding-right: 28px;
        }

        #header td.logo {
            width: 110px;
            vertical-align: top;
        }

        #header td.name_adr {
            font-size: 14px;
            width: 220px
        }

        #header td.phone_fax {
            font-size: 14px;
            width: 260px
        }

        #header td.rc {
            font-size: 14px;
            width: 250px
        }

        .name {
            font-weight: bold;
            width: 200px
        }

        .adr {
            width: 150px
        }

        .pv {
            width: 400px;
            text-align: left;
            padding-left: 0;
            margin-left: 0;
        }

        .rec {
            width: 150px;
            padding-top: 15px;
        }

        .rec img {
            padding-top: 5px;
        }

        .res img {
            padding-top: 5px;
        }

        .res {
            width: 150px;
            padding-top: 15px;
        }

        #footer {
            position: fixed;
            left: 0;
            bottom: -40px;
            right: 0;
            height: 5px;
        }

        .copyright {
            font-size: 10px;
            text-align: center;
        }

        .box-body {
            padding-left: 25px;
            padding-right: 25px;
            margin: 0;
            width: 100%;
        }

        .ref {
            padding-top: 15px;
            font-weight: bold;
            padding-left: 0;
        }

        .date {
            padding-top: 0;
            margin-left: 0;
            margin-bottom: 5px;
        }

        .title {
            padding: 5px;
            margin-top: 5px;
            margin-left: 0;
            width: 100%;
            border: 1px solid #ddd;
            margin-bottom: 5px;
        }

        .car {
            width: 50%;
            margin-right: 30px;
            margin-left: 0;
        }
        .conduc {
            width: 50%;
        }
        .info {
            margin-left: 0;

        }
        .doc {

            width: 210px;
            font-size: 13px;
            border: 1px solid #ddd;
            padding: 5px;
        }

        .lot {
            width: 210px;
            font-size: 13px;
            border: 1px solid #ddd;
            padding: 5px;
        }

        .etat {
            width: 210px;
            font-size: 13px;
            border: 1px solid #ddd;
            padding: 5px;
        }

        .espace {
            width: 50px;
            padding: 10px;
        }

        .titre {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .titre2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .colonne {
            width: 140px;
            display: inline-block;
            padding-top: 5px;
        }

        .input_radio {
            width: 40px;
        }

        .input_radio2 {
            width: 25px;
        }

        .yes {
            padding-left: 140px;
        }

        .no {
            padding-left: 10px;
            display: inline-block;

        }

        .o {

            padding-left: 145px;
        }

        .m {
            padding-left: 15px;

        }

        .tmr {
            padding-left: 8px;
            display: inline-block;

        }

        .cond {
            height: 15px;

        }

        .customer table {
            border-collapse: collapse;
            width: 100%;
            font-size: 18px;
        }

        .customer tr td:first-child {
            width: 250px !important;
            font-weight: bold;
            padding-bottom: 10px;

        }


        table.bottom td {
            padding-top: 5px;
            font-size: 18px;
        }


        table.conditions td {
            border: 1px solid grey;
        }

        table.conditions td {
            vertical-align: top;
            padding: 5px 5px 5px 10px;
            line-height: 19px;
        }

        table.conditions_bottom td {
            padding-top: 5px
        }

        .note span {
            display: block;
            text-decoration: underline;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border: 0;
            padding: 0;
            margin: 0;
        }

        .padding-img {
            padding-left: 182px;
            padding-top: -20px;
        }
        .padding-img2 {
            padding-left: 169px;
            padding-top: -20px;
        }
        .padding-img3 {
            padding-left: 195px;
            padding-top: -20px;
        }
        .event-title{
            font-weight: bold;
            font-size: 18px;
            margin: auto;
            width: 100%;
            text-align: center;
        }

        body{
            padding: 40px;
            font-size: 14px;
        }
        .event-table{
            border: 1px solid #000000;
            width: 100%;
            border-collapse: collapse;
        }
        .event-table td {
            border: 1px solid black !important;
            height: 10px;
            vertical-align: top;
        }
        .event-table th {
            border: 1px solid black !important;
            vertical-align: top;
            background-color: #CDCDCD;
        }
        .center{
            text-align: center;
            vertical-align: center;
        }
        .last-tr{
            border-bottom: solid 1px black;
        }

        #copyright{
            font-size:14px;
            text-align:right;
            position: absolute;
            left: 0;
            right:-40px;
            height:10px;
            bottom: -50px;
            font-weight: bold;
        }
    </style>
</head>
<body>


<div id="header">
    <div class="event-title">
        LABORATOIRE DES TRAVAUX PUBLICS DU SUD
    </div>
    <div class="event-title">
        Etat des lieux du véhicule
    </div>
</div>

<table>
    <tr>
        <td>
            <strong> Date </strong> : <?= $customerCar['CustomerCar']['date_open'] ?>
        </td>
        <td>
            <strong> Réalisé par : </strong> <?= $user['first_name'].' '.$user['last_name'] ?>
        </td>
    </tr>
    <tr>
        <td>
           <strong> Véhicule : </strong> <?= $customerCar['Car']['Mark']['name'].' '.$customerCar['Car']['Carmodel']['name'] ?>
        </td>
        <td>
            <strong>Conducteur : </strong> <?= $customerCar['Customer']['first_name'].' '.$customerCar['Customer']['last_name'] ?>
        </td>
    </tr>
    <tr>
        <td>
            <strong>Immatriculation :</strong> <?= $customerCar['Car']['immatr_def'] ?>
        </td>
        <td>
            <strong>Nbr de Km du véhicule :</strong> <?= $customerCar['CustomerCar']['km'] ?>
        </td>
    </tr>
</table>

<br>

<table class="event-table">
    <tr>
        <td width="25%">

        </td>
        <td colspan="3">
            Départ
        </td>
        <td colspan="3">
            Arrivé
        </td>
    </tr>
    <tr>
        <th> Documents du véhicule</th>
        <th> Conforme </th>
        <th> N. conforme </th>
        <th> Commentaire </th>
        <th> Conforme </th>
        <th> N.conforme </th>
        <th> Commentaire </th>
    </tr>
    <tr>
        <td>
            Crte grise, assurance, C.tech, carnet de bord, carnet d'entretien
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['grey_card'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['grey_card'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['grey_card'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['grey_card'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>

    </tr>

    <tr>
        <th> Etat du moteur </th>
        <th> Conforme </th>
        <th> N.conforme </th>
        <th> Commentaire </th>
        <th> Conforme </th>
        <th> N.conforme </th>
        <th> Commentaire </th>
    </tr>
    <tr>
        <td>
            Niveau d'huile et liquides
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['oil_level'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['oil_level'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['oil_level'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['oil_level'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>

    </tr>

    <tr>
        <td>
            Bruit du moteur
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['engin_noise'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['engin_noise'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['engin_noise'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['engin_noise'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>

    </tr>

    <tr>
        <th> Aspect intérieur </th>
        <th> Conforme </th>
        <th> N.conforme </th>
        <th> Commentaire </th>
        <th> Conforme </th>
        <th> N.conforme </th>
        <th> Commentaire </th>
    </tr>

    <tr>
        <td>
            Freins (à pied et à main)
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['breaks'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['breaks'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['breaks'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['breaks'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>

    </tr>

    <tr>
        <td>
            Pédals
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['pedals'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['pedals'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['pedals'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['pedals'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>

    </tr>

    <tr>
        <td>
            Rétroviseurs
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['wing_mirrors'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['wing_mirrors'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['wing_mirrors'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['wing_mirrors'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>

    </tr>

    <tr>
        <td>
            Compteurs kilométriques
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['odometer'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['odometer'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['odometer'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['odometer'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>

    </tr>

    <tr>
        <td>
            Aspect des portiéres
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['doors_state'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['doors_state'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['doors_state'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['doors_state'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>

    </tr>

    <tr>
        <td>
            Fonctionnement des portiéres
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['doors_operation'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['doors_operation'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['doors_operation'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['doors_operation'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>

    </tr>

    <tr>
        <td>
            Siéges
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['seats'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['seats'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['seats'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['seats'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>

    </tr>

    <tr>
        <th> Feux et essuie-glace </th>
        <th> Conforme </th>
        <th> N.conforme </th>
        <th> Commentaire </th>
        <th> Conforme </th>
        <th> N.conforme </th>
        <th> Commentaire </th>
    </tr>

    <tr>
        <td>
            Feux (avant - arrière)
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['front_lights'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['front_lights'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['front_lights'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['front_lights'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>

    </tr>

    <tr>
        <td>
            essuie-glace
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['wipper'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['wipper'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['wipper'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['wipper'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>

    </tr>

    <tr>
        <th> Aspect des pneumatique </th>
        <th> Conforme </th>
        <th> N.conforme </th>
        <th> Commentaire </th>
        <th> Conforme </th>
        <th> N.conforme </th>
        <th> Commentaire </th>
    </tr>

    <tr>
        <td>
            Paire de pneus (avant - arrière)
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['front_tires'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['front_tires'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['front_tires'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['front_tires'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>

    </tr>


    <tr>
        <td>
            Etat de la roue de secour
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['spare_wheel'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['spare_wheel'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['spare_wheel'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['spare_wheel'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>

    </tr>

    <tr>
        <th> Etat de proptrté </th>
        <th> Conforme </th>
        <th> N.conforme </th>
        <th> Commentaire </th>
        <th> Conforme </th>
        <th> N.conforme </th>
        <th> Commentaire </th>
    </tr>

    <tr>
        <td>
            Propreté externe
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['external_cleanliness'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['external_cleanliness'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['external_cleanliness'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['external_cleanliness'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>

    </tr>

    <tr>
        <td>
            Propreté interne
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['internal_cleanliness'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['internal_cleanliness'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['external_cleanliness'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['external_cleanliness'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>

    </tr>

    <tr>
        <th> Accessoires </th>
        <th> Conforme </th>
        <th> N.conforme </th>
        <th> Commentaire </th>
        <th> Conforme </th>
        <th> N.conforme </th>
        <th> Commentaire </th>
    </tr>

    <tr>
        <td>
            Poste auto, baffes, cric, clés de roue, enjoliveurs, extincteurs, triangle, boite pharmacie, gilet, cable remorquage
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['accessories'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsRes['Affectationpv']['accessories'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['accessories'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td class="center">
            <?php if ($affectationpvsR['Affectationpv']['accessories'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
        </td>
        <td>

        </td>

    </tr>
    <tr class="last-tr">
        <th class="last-tr"> Aspect exterieur </th>
        <th class="last-tr" colspan="2"> R = Remplacement </th>
        <th class="last-tr" colspan="2"> X = Coup </th>
        <th class="last-tr" colspan="2"> /// = Eraflure </th>
    </tr>
    <br>
    <tr>
        <table width="100%">
            <?php
            $dir = WWW_ROOT . "img/pv/1";
            ?>
            <tr>
                <td colspan="4"> <br></td>
            </tr>
            <tr>
                <td>
                    <img src="<?= $dir ?>/1.jpg">
                </td>
                <td>
                    <img src="<?= $dir ?>/2.jpg">
                </td>
                <td>
                    <img src="<?= $dir ?>/3.jpg">
                </td>
                <td>
                    <img src="<?= $dir ?>/4.jpg">
                </td>
            </tr>
            <tr>
                <table class="event-table">

                        <thead>
                        <tr>
                            <th colspan="2">
                                Départ
                            </th>
                            <th colspan="2">
                                Arrivé
                            </th>
                        </tr>

                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                Signature cédant
                            </td>
                            <td>
                                Signature récéptionnant
                            </td>
                            <td>
                                Signature cédant
                            </td>
                            <td>
                                Signature récéptionnant
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <br>
                                <br>
                                <br>
                            </td>
                            <td>
                                <br>
                                <br>
                                <br>
                            </td>
                            <td>
                                <br>
                                <br>
                                <br>
                            </td>
                            <td>
                                <br>
                                <br>
                                <br>
                            </td>
                        </tr>
                        </tbody>
                </table>
            </tr>

        </table>
    </tr>





</table>

<div id="copyright" >
    F-7²-6.00
</div>

</body>
</html>