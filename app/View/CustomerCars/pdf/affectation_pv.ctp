<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <style type="text/css">

        <?php
        if (Configure::read('utranx_ade') != '1'){
            ?>
        @page {
            margin: 95px 0 70px 0;
        }
        #header {
            position: fixed;
            left: 0;
            top: -95px;
            right: 0;
            height: 110px;
            border-bottom: 1px solid #000;
            padding-left: 28px;
            padding-right: 28px;
        }

        <?php
        }else{
        ?>
        @page {
            margin: 0px 0 70px 0;
        }
        <?php
        }
        ?>

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
            margin-top: -20px;
        }
        .padding-img2 {
            padding-left: 169px;
            margin-top: -20px;
        }
        .padding-img3 {
            padding-left: 195px;
            margin-top: -20px;
        }
    </style>
</head>
<body>
<div id="header">
    <?php
    if (Configure::read('utranx_ade')){
        echo $this->element('pdf/ade-header');
    }else {
        ?>
        <table>
            <tr>
                <td class="logo">
                    <img src="<?= WWW_ROOT ?>/logo/<?= isset($company['Company']['logo']) ? $company['Company']['logo'] : '' ?>"
                         width="100px" height="100px">

                </td>
                <td class='name_adr'>
                    <div class='name'><?= Configure::read("nameCompany") ?></div>
                    <div class='adr'><?= isset($company['Company']['adress']) ? $company['Company']['adress'] : '' ?></div>
                </td>
                <td class='phone_fax'>
                    <div>Tél: <?= isset($company['Company']['phone']) ? $company['Company']['phone'] : '' ?></div>
                    <div>Fax: <?= isset($company['Company']['fax']) ? $company['Company']['fax'] : '' ?></div>
                </td>
                <td class='rc'>
                    <div>RC: <?= isset($company['Company']['rc']) ? $company['Company']['rc'] : '' ?></div>
                    <div>AI: <?= isset($company['Company']['ai']) ? $company['Company']['ai'] : '' ?></div>
                    <div>NIF: <?= isset($company['Company']['nif']) ? $company['Company']['nif'] : '' ?></div>
                </td>
            </tr>
        </table>
        <?php
    }
    ?>
</div>
<div class="box-body">
    <table style="width: 100%;">
        <tr>
            <td class='pv'>
                <div class="ref">PROCES VERBAL N&deg; : <?= $customerCar['CustomerCar']['reference'] ?></div>
            </td>
            <td class='rec'>
                <?php if ($affectationpvs['Affectationpv']['reception'] == 0) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14px">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"  >';}?>
                <label for="cbox1">Reception</label>
            </td>
            <td class='res'>
                <?php if ($affectationpvs['Affectationpv']['reception'] == 1) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14px">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                <label for="cbox2">Restitution</label>
            </td>
        </tr>
    </table>

    <div class="date">DATE : <?= date("d/m/Y") ?> - HEURE : <?= date("H:i") ?> </div>
    <div style="clear: both"></div>
    <div class="title">
        <table style="width: 100%;">
            <tr>

                <td class='car'>
                    <div>Immatriculation : <?= $customerCar['Car']['immatr_def'] ?></div>
                    <div>Chassis : <?= $customerCar['Car']['chassis'] ?></div>
                    <div>Marque & Modele : <?= $customerCar['Car']['Mark']['name'] ?>
                        -<?= $customerCar['Car']['Carmodel']['name'] ?> </div>
                    <div>Lieu du PV : <?php
                        if (!$affectationpvs['Affectationpv']['reception']) {
                            echo $customerCar['CustomerCar']['departure_location'];
                        } else {
                            echo $customerCar['CustomerCar']['return_location'];
                        }?></div>
                </td>
                <td class='conduc'>
                    <div>Nom & Prenom
                        : <?= $customerCar['Customer']['last_name'] ?> <?= $customerCar['Customer']['first_name'] ?>  </div>
                    <div></div>
                    <div></div>

                </td>
            </tr>

        </table>


    </div>
    <div class="info">
        <table>
            <tr>
                <td class='doc'>
                    <div class='titre'>DOCUMENTS DE BORD</div>
                    <div><span class='yes'>NON</span><span class='no'>OUI</span></div>
                    <div class='cond'><span class='colonne'>Carte Grise </span>

                        <?php if ($affectationpvs['Affectationpv']['grey_card'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['grey_card'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>

                    <div class='cond'><span class='colonne'>Assurance</span>
                        <?php if ($affectationpvs['Affectationpv']['assurance'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['assurance'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>
                    <div class='cond'>
                        <span class='colonne'>Controle technique</span>
                        <?php if ($affectationpvs['Affectationpv']['controle_technique'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['controle_technique'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>
                    <div class='cond'><span class='colonne'>Carnet d'entretien</span>
                        <?php if ($affectationpvs['Affectationpv']['carnet_entretien'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['carnet_entretien'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>
                    <div class='cond'>
                        <span class='colonne'>Carnet de Bord</span>
                        <?php if ($affectationpvs['Affectationpv']['carnet_bord'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['carnet_bord'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>
                    <div class='cond'><span class='colonne'>Vignette</span>
                        <?php if ($affectationpvs['Affectationpv']['vignette'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['vignette'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>

                    </div>
                    <div class='cond'><span class='colonne'>Vignette CT</span>
                        <?php if ($affectationpvs['Affectationpv']['vignette_ct'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['vignette_ct'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>

                    </div>
                    <div class='cond'><span class='colonne'>Procuration</span>
                        <?php if ($affectationpvs['Affectationpv']['procuration'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['procuration'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>

                    </div>
                </td>
                <td class='espace'></td>
                <td class='lot'>
                    <div class='titre'>LOT DE BORD</div>
                    <div><span class='yes'>NON</span><span class='no'>OUI</span></div>
                    <div class='cond'><span class='colonne'>Roue de secours</span>
                        <?php if ($affectationpvs['Affectationpv']['roue_secours'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['roue_secours'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>

                    <div class='cond'><span class='colonne'>Cric</span>
                        <?php if ($affectationpvs['Affectationpv']['cric'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['cric'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>

                    <div class='cond'><span class='colonne'>Tapis</span>
                        <?php if ($affectationpvs['Affectationpv']['tapis'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['tapis'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>

                    <div class='cond'><span class='colonne'>Manivelle</span>
                        <?php if ($affectationpvs['Affectationpv']['manivelle'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['manivelle'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>

                    <div class='cond'><span class='colonne'>Boite Pharmacie</span>
                        <?php if ($affectationpvs['Affectationpv']['boite_pharmacie'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['boite_pharmacie'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>
                    <div class='cond'><span class='colonne'>Triangle</span>
                        <?php if ($affectationpvs['Affectationpv']['triangle'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['triangle'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>
                    <div class='cond'><span class='colonne'>Gilet</span>
                        <?php if ($affectationpvs['Affectationpv']['gilet'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['gilet'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>
                    <div class='cond'><span class='colonne'>Double Cle</span>
                        <?php if ($affectationpvs['Affectationpv']['double_cle'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['double_cle'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>


                </td>
                <td class='espace'></td>
                <td class='etat'>
                    <div class='titre'>ETAT INTERIEUR</div>
                    <div>O : Ok</div>
                    <div>M: Moyen</div>
                    <div style='padding-bottom:10px;'>TME : Tres Mauvaise Etat</div>
                    <div><span class='o'>O</span><span class='m'>M</span><span class='tmr'>TME</span></div>
                    <div class='cond'><span class='colonne'>Sieges</span>
                        <?php if ($affectationpvs['Affectationpv']['sieges'] == 3) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['sieges'] == 1) { echo '<div class ="padding-img2"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img2"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                        <?php if ($affectationpvs['Affectationpv']['sieges'] == 2) { echo '<div class ="padding-img3"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img3"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>
                    <div class='cond'><span class='colonne'>Tableau de Bord</span>
                        <?php if ($affectationpvs['Affectationpv']['dashboard'] == 3) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['dashboard'] == 1) { echo '<div class ="padding-img2"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img2"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                        <?php if ($affectationpvs['Affectationpv']['dashboard'] == 2) { echo '<div class ="padding-img3"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img3"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>
                    <div class='cond'><span class='colonne'>Moquette</span>
                        <?php if ($affectationpvs['Affectationpv']['moquette'] == 3) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['moquette'] == 1) { echo '<div class ="padding-img2"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img2"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                        <?php if ($affectationpvs['Affectationpv']['moquette'] == 2) { echo '<div class ="padding-img3"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img3"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>
                    <div class='cond'><span class='colonne'>Tapis</span>
                        <?php if ($affectationpvs['Affectationpv']['tapis_interieur'] == 3) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['tapis_interieur'] == 1) { echo '<div class ="padding-img2"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img2"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                        <?php if ($affectationpvs['Affectationpv']['tapis_interieur'] == 2) { echo '<div class ="padding-img3"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img3"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>

                </td>
            </tr>

        </table>
    </div>
    <div class="title">
        <div class='titre2'>ETAT EXTERIEURS</div>
        <table>
            <tr>
                <td style='width:160px;'>
                    R = Remplacement
                </td>
                <td style='width:160px;'>
                    ---- Eraflure
                </td>
                <td style='width:160px;'>
                    X = Coup
                </td>
                <td style='width:160px;'>
                    ////// = Eraflure

                </td>
            </tr>
        </table>
    </div>
    <div style="padding-bottom: 5px;">
        Km :
            <?php
            if (!$affectationpvs['Affectationpv']['reception']) {
                echo $customerCar['CustomerCar']['km'];
            } else {
                echo $customerCar['CustomerCar']['next_km'];
            }
            ?>

    </div>
    <?php
    $dir = WWW_ROOT . "img/pv/" . $customerCar['Car']['car_type_id'];
    if (!is_dir($dir)) {
        $dir = WWW_ROOT . "img/pv/1";
    }
    ?>
    <div style='padding-top:0px; padding-bottom:0px; width: 100%'>
        <span style='width:50%; height:10px; display: inline-block; padding: 0; margin: 0;'>
            <img src="<?= $dir ?>/1.jpg">
        </span>
        <span style='text-align:right; display: inline-block; width:50%; padding: 0; margin: 0;'>
            <img src="<?= $dir ?>/2.jpg">
        </span>
    </div>
    <div style='padding-bottom:0px;'>
		<span style='width:50%; height:10px; display: inline-block;'>
			<img src="<?= $dir ?>/3.jpg">
		</span>

        <span style='width:50%; text-align:right; display: inline-block;'>
            <img src="<?= $dir ?>/4.jpg">
        </span>
    </div>
    <br/>

    <p>
        <?php
        if(!empty($affectationpvs['Affectationpv']['obs_customer']))
        {
            if (!empty($observation1)) {
                echo "Observation ".$observation1;
            } else {
                echo 'Observation conducteur  : ';
            }
            echo $affectationpvs['Affectationpv']['obs_customer'];
        }
        ?>
    </p>

    <p>
        <?php
        if(!empty($affectationpvs['Affectationpv']['obs_chef']))
        {
            if (!empty($observation2)) {
                echo "Observation ".$observation2;
            } else {
                echo 'Observation chef de parc : ';
            }
            echo $affectationpvs['Affectationpv']['obs_chef'];
        }

        ?>
    </p>

    <p>
        <?php
        if(!empty($affectationpvs['Affectationpv']['obs_hse']))
        {

            echo 'Observation responsable HSE : ';

            echo $affectationpvs['Affectationpv']['obs_hse'];
        }

        ?>
    </p>
    <div style='padding:10px 0 0;'>
		<span style='width:50%; display: inline-block;'>
            <?php
            if (!empty($observation1)) {
                echo "Signature ".$observation1;
            } else {
                echo 'Signature Conducteur';
            }
            ?>
		</span>

        <span style='width:35%; text-align:right; display: inline-block;'>
             <?php
             if (!empty($observation2)) {
                 echo "Signature ".$observation2;
             } else {
                 echo 'Signature Chef de parc';
             }
             ?>
        </span>
    </div>
</div>
<div id="footer">

    <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
</div>
</body>
</html>