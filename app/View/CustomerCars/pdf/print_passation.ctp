<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <style type="text/css">
        @page {
            margin: 95px 0 70px 0;
        }
        #header {
            position: fixed;
            left: 0;
            top: -95px;
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
            font-size:14px;
            text-align:right;
            position: fixed;
            left: 0;right:20px;
            height:10px;
            bottom: -75px;
            font-weight: bold;
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
            font-size: 20px;
            margin: auto;
            width: 100%;
            text-align: center;
        }
        .other-consignes{
            margin: auto;
            width: 100%;
        }
    </style>
</head>
<body>
<div id="header">
    <br>
    <div class="event-title">
        LABORATOIRE DES TRAVAUX PUBLICS DU  SUD
    </div>
    <div class="event-title">
        PASSATION DE CONDIGNES DE VEHICULE
    </div>
</div>
<div class="box-body">
    <table style="width: 100%;">
        <tr>
            <td class='pv'>
                <div class="ref">PASSATION DE CONSIGNES N&deg; : <?= $customerCar['CustomerCar']['reference'] ?></div>
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
                    <div>L' élément cedant :
                        : <?= $transferingElement[0]['Customer']['last_name'] ?> <?= $transferingElement[0]['Customer']['first_name'] ?>  </div>
                    <div>
                        L' élément récéptionnant :
                        : <?= $receivingElement[0]['Customer']['last_name'] ?> <?= $receivingElement[0]['Customer']['first_name'] ?>
                    </div>
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

                        <?php if ($affectationpvs['Affectationpv']['grey_card_2'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" />'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['grey_card_2'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>

                    <div class='cond'><span class='colonne'>Assurance</span>
                        <?php if ($affectationpvs['Affectationpv']['inssurance'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['inssurance'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>

                    <div class='cond'><span class='colonne'>Carnet d'entretien</span>
                        <?php if ($affectationpvs['Affectationpv']['interview_notebook'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['interview_notebook'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>
                    <div class='cond'>
                        <span class='colonne'>Carnet de Bord</span>
                        <?php if ($affectationpvs['Affectationpv']['dashboard_notebook'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['dashboard_notebook'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>
                    <div class='cond'><span class='colonne'>Vignette</span>
                        <?php if ($affectationpvs['Affectationpv']['thumbnail'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['thumbnail'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>

                    </div>
                    <div class='cond'><span class='colonne'></span>

                    </div>
                    <div class='cond'><span class='colonne'></span>

                    </div>
                    <div class='cond'><span class='colonne'></span>

                    </div>
                </td>
                <td class='espace'></td>
                <td class='lot'>
                    <div class='titre'>LOT DE BORD</div>
                    <div><span class='yes'>NON</span><span class='no'>OUI</span></div>
                    <div class='cond'><span class='colonne'>Poste auto</span>
                        <?php if ($affectationpvs['Affectationpv']['post_auto'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['post_auto'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>

                    <div class='cond'><span class='colonne'>Baffes</span>
                        <?php if ($affectationpvs['Affectationpv']['slaps'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['slaps'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>

                    <div class='cond'><span class='colonne'>Cric</span>
                        <?php if ($affectationpvs['Affectationpv']['jack'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['jack'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>

                    <div class='cond'><span class='colonne'>Clé de roues</span>
                        <?php if ($affectationpvs['Affectationpv']['wheel_wrench'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['wheel_wrench'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>

                    <div class='cond'><span class='colonne'>Enjoliveurs</span>
                        <?php if ($affectationpvs['Affectationpv']['hubcaps'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['hubcaps'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>
                    <div class='cond'><span class='colonne'>Extincteur</span>
                        <?php if ($affectationpvs['Affectationpv']['fire_extinguisher'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['fire_extinguisher'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>
                    <div class='cond'><span class='colonne'>Triangle</span>
                        <?php if ($affectationpvs['Affectationpv']['triangle2'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['triangle2'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>
                    <div class='cond'><span class='colonne'>Gilet</span>
                        <?php if ($affectationpvs['Affectationpv']['gilet'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['gilet'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>



                </td>
                <td class='espace'></td>
                <td class='etat'>
                    <div class='titre'>Véhicule</div>
                    <div><span class='yes'>NON</span><span class='no'>OUI</span></div>
                    <div class='cond'><span class='colonne'>Etat méchanique</span>
                        <?php if ($affectationpvs['Affectationpv']['mechanic_state'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['mechanic_state'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>


                    <div class='cond'><span class='colonne'>Etat éléctrique</span>
                        <?php if ($affectationpvs['Affectationpv']['electric_state'] == 2) { echo '<img src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x">'; } else { echo '<img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px">';}?>
                        <?php if ($affectationpvs['Affectationpv']['electric_state'] == 1) { echo '<div class ="padding-img"><img  src="'. WWW_ROOT . '/img/checked-icon.png" width="14px" height="14x" /></div>'; } else { echo '<div class ="padding-img"><img src="'. WWW_ROOT . '/img/unchecked-icon.png" width="14px" height="14px"></div>';}?>
                    </div>
                    <div class='cond'><span class='colonne'></span>

                    </div>


                    <div class='cond'><span class='colonne'>Consignes éléctriques : </span>
                        <?php
                        if (!empty($affectationpvs['Affectationpv']['obs_electric_state'])){
                            echo $affectationpvs['Affectationpv']['obs_electric_state'];
                        }else{
                            echo '/';
                        }
                        ?>
                    </div>
                    <div class='cond'><span class='colonne'>Consignes mechaniques : </span>
                        <?php
                        if (!empty($affectationpvs['Affectationpv']['obs_mechanic_state'])){
                            echo $affectationpvs['Affectationpv']['obs_mechanic_state'];
                        }else{
                            echo '/';
                        }
                        ?>
                    </div>
                    <div class='cond'><span class='colonne'></span>

                    </div>
                    <div class='cond'><span class='colonne'></span>

                    </div>

                </td>
            </tr>

        </table>
    </div>
    <div class="title">
        <div class="titre2">
            CARBURANT
        </div>
        <table>

                <?php
                if (!empty($affectationpvs['Affectationpv']['notebook_number'])){
                ?>
                    <tr>
                        <td> Carnet n° : <?= $affectationpvs['Affectationpv']['notebook_number'] ?> </td>
                        <td> Souche n° : <?= $affectationpvs['Affectationpv']['strain'] ?> </td>
                        <td> Au n° : <?= $affectationpvs['Affectationpv']['notebook_to'] ?> </td>
                    </tr>
                <?php
                }
                if (!empty($affectationpvs['Affectationpv']['card_number'])){
                ?>
                    <tr>
                        <td> Carte n° : <?= $affectationpvs['Affectationpv']['card_number'] ?> </td>
                        <td> Montant : <?= $affectationpvs['Affectationpv']['card_amount'] ?> </td>
                    </tr>

                <?php
                }
                ?>
                <?php
                if (!empty($affectationpvs['Affectationpv']['convention_notebook'])){
                ?>
                    <tr>
                        <td> Carnet conventionné n° : <?= $affectationpvs['Affectationpv']['convention_notebook'] ?> </td>
                        <td> Souche n° : <?= $affectationpvs['Affectationpv']['convention_strain'] ?> </td>
                        <td> Au n° : <?= $affectationpvs['Affectationpv']['convention_notebook_to'] ?> </td>
                    </tr>
                <?php
                }
                ?>

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
    <div class="other-consignes">
        <?php
        if (!empty($affectationpvs['Affectationpv']['other_consignes']))
        echo '<strong> Autres consignes : </strong> '.$affectationpvs['Affectationpv']['other_consignes'];
        echo '<br><br><br>'
        ?>
    </div>
    <div style='padding:10px 0 0;'>
		<span style='width:50%; display: inline-block;'>
            <?php
            echo "Signature de l' élément cédant"
            ?>
		</span>

        <span style='width:35%; text-align:right; display: inline-block;'>
             <?php
             echo "Signature de l' élément récéptionnant"
             ?>
        </span>
    </div>
</div>
<div id="footer">

    <p class='copyright'>F-7-16-02</p>
</div>
</body>
</html>