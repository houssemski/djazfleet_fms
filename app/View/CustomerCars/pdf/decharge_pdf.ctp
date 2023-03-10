<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
        @page { margin: 95px 0px; }
        #header { position: fixed; left: 0px; top: -95px; right: 0px; height: 100px; padding-left:28px;padding-right:28px;}
        #header td.logo{width: 110px; vertical-align: top;}

        #header td.name_adr{  font-size: 14px; width:220px}
        #header td.phone_fax{  font-size: 14px; width:260px}
        #header td.rc{  font-size: 14px; width:250px}
        .name{font-weight:bold; width:200px }
        .adr{ width:150px }
        .pv {width:400px;}
        .rec {width:150px; padding-top: 25px;}
        .res {width:150px;padding-top: 25px;}
        #footer { position: fixed; left: 0px; bottom: 30px; right: 0px; height: 3px;  }
        .copyright{font-size:10px; text-align:center; margin-top: 75px}
        .box-body{padding-left: 28px; padding-right: 28px; margin: 0; width: 100%;  font-size: 11px; }
        .ref{padding-top: 25px; font-weight:bold; padding-left:230px; text-decoration: underline ;font-style: italic;}
        .date{padding-top: 5px; margin-left:25px;margin-bottom: 10px;}
        .title{
            padding:10px;
            margin-top: 20px;
            margin-left:25px;
            width: 690px;
            border: 1px solid #ddd;
            margin-bottom: 10px;

        }
        .car {
            width: 375px;
            margin-right: 30px;
            margin-left:25px;
        }
        .conduc {
            width: 350px;
        }
        .info{
            margin-top: 20px;
            padding-left:30px;

        }
        .doc{

            width: 210px;
            font-size:13px;
            border: 1px solid #ddd;
            padding: 5px;
        }
        .lot{
            width: 210px;
            font-size:13px;
            border: 1px solid #ddd;
            padding: 5px;
        }
        .etat{
            width: 210px;
            font-size:13px;
            border: 1px solid #ddd;
            padding: 5px;
        }
        .espace {

            width:50px;
            padding:10px;
        }
        .titre {
            text-align: center;
            font-weight: bold;
            margin-bottom:20px;
        }
        .titre2 {
            text-align: center;
            font-weight: bold;
            margin-bottom:10px;
        }
        .colonne{
            width: 140px;
            display: inline-block;
            padding-top:5px;
        }
        .input_radio{
            width:40px;
        }
        .input_radio2{
            width:25px;
        }
        .yes{
            /*width: 170px;*/

            padding-left:140px;
        }
        .no{
            padding-left:10px;
            display: inline-block;

        }
        .o{


            padding-left:145px;
        }
        .m{
            padding-left:15px;


        }
        .tmr{
            padding-left:8px;
            display: inline-block;

        }
        .cond {
            height:15px;

        }
        .customer table {
            border-collapse: collapse;
            width: 100%;
            font-size: 18px;
        }
        .customer tr td:first-child{
            width: 250px !important;
            font-weight: bold;
            padding-bottom: 10px;

        }
        table.bottom{margin-top: 40px; width: 100%; margin-bottom: 40px; font-style: italic;}
        div.resp{font-size: 18px;
            border-bottom: 1px solid #000;
            width: 280px;
            margin-left: 530px;
            font-style: italic;
            font-weight: bold;
        }
        table.bottom td{padding-top: 5px; font-size: 18px;}
        table.footer{width: 100%; font-size: 12px; margin-top: 20px;padding-top: 10px;border-top: 1px solid #690008;}
        table.footer td.first{width: 50%; text-align: left}
        table.footer td.second{width: 50%; text-align: left;}
        table.conditions td{
            border: 1px solid grey;
        }
        table.conditions td{
            vertical-align: top;
            padding-left: 10px;
            padding-right: 5px;
            padding-top: 5px;
            padding-bottom: 5px;
            line-height: 19px;
        }
        table.conditions_bottom td.first{width: 420px}
        table.conditions_bottom td{padding-top: 5px}
        .note span{display: block;text-decoration: underline;padding-bottom: 5px;}
        .pv{
            align-content: center;
        }
        p{line-height:16px}
        .title1 {font-weight: bold; font-size: 14px;}
    </style>
</head>
<body>
<div id="header">
    <table>
        <tr>
            <td class="logo">
                <img src="<?= WWW_ROOT ?>/logo/<?= $company['Company']['logo'] ?>" width="100px" height="100px">

            </td>

            <td class='pv'>
                <div class="ref">DECHARGE </div>
            </td>

        </tr>
    </table>
</div>
<div class="box-body">


    <div class="info">
       <p >Monsieur <strong><?= $customerCar['Customer']['last_name']?> <?= $customerCar['Customer']['first_name']?> </strong>;</p>
        <p>La soci??t?? <strong> <?= Configure::read("nameCompany")?></strong> met ?? votre disposition un V??hicule de service de marque  <strong><?= $customerCar['Car']['Mark']['name'] ?> </strong>Immatricul?? sous num??ro: <strong><?= $customerCar['Car']['immatr_def'] ?> </strong>pour lequel vous ??tes responsable et devez veiller ?? ce qu???il soit toujours en parfait ??tat de marche et bien entretenu.</p>
        <p class="title1">La soci??t?? garantie la prise en charge suivante : </p>
        <p>1/ Tous les documents et proc??dures administratives permettant au v??hicule de circuler : Carte grises, prorogation des d??lais de la carte jaune, assurances et vignettes.</p>
        <p></p>
        <p>
            2/ V??hicule endommag?? :
        </p>
        <p style="padding-left: 35px;">
            a) L???Assurance de la soci??t?? prend en charge toute proc??dure li??e au moindre endommagement du v??hicule.
        </p>
        <p style="padding-left: 35px;">
            b) La r??paration d???un premier accident uniquement ;
        </p>
        <p style="padding-left: 35px;">
            c) Tout accident ou incidents m??canique, ??lectrique et esth??tique lies au v??hicule doivent ??tre imp??rativement signal??s ?? l???Administration, pour la prise en charge imm??diate par Chef de Parc & S??curit??
        </p>
        <p  class="title1">L???utilisateur a ?? sa charge ce qui suit :</p>
        <p style='font-weight: bold; text-decoration: underline'>1/ L???entretien r??gulier :</p>
        <p style="padding-left: 35px;">a/ 02 lavages/mois ext??rieur et int??rieur chaque d??but de semaine.</p>
        <p style="padding-left: 35px;">b/ V??rification des pneus 2 fois par mois.</p>
        <p style="padding-left: 35px;">c/ Un contr??le r??gulier du niveau d???huile du moteur hebdomadaire.</p>
        <p style="padding-left: 35px;">d/ Un contr??le du niveau d???eau du radiateur et du lave glace hebdomadaire.</p>
        <p style="padding-left: 35px;"> e/ Une vidange r??guli??re avec respect des dates de r??visions des v??hicules, tous les 10 000 Km. doivent ??tre effectu??es avec consultation de l???administration (en cas de convention avec concessionnaire,   etc???.). </p>
        <p>2/ <strong>Une mise ?? jour </strong> du <strong>Carnet de bord </strong> et du <strong>registre de maintenance </strong>est exig??e pour v??rification et contr??le en toute circonstance de l???administration.</p>
        <p>3/<strong> Cas d???un second accident </strong>signal?? depuis la remise du v??hicule : L???utilisateur devra assumer les frais de r??paration, s???ils s???av??rent sup??rieurs ?? ceux estim??s par notre assureur.</p>
        <p>4/ Cas d???infractions av??r??es </p>
        <p>5/ Cas de mise en fourri??re : tous les frais sont ?? la charge de l???utilisateur </p>
        <p class="title1">Pour rappel :</p>
        <ul>
        <li style="list-style-type: disc; line-height: 16px">	<strong ><span style="text-decoration: underline">Le v??hicule est ?? usage professionnel</span></strong>, il n???est pas permis de le personnaliser avec un d??cor ou tout autre objet personnel visible.</li>
        <li style="list-style-type: disc; line-height: 16px">	Pour <strong>disposer du v??hicule durant le cong?? </strong>, une demande doit ??tre formul??e en m??me temps que le cong?? et n???est accord??e que sur appr??ciation de la Direction.</li>
        <li style="list-style-type: disc; line-height: 16px">    <strong>Avant d???envisager la moindre intervention </strong>sur le v??hicule, l???utilisateur doit la <strong>signaler ?? l???administration</strong>.</li>
        <li style="list-style-type: disc; line-height: 16px">    Lors de la remise du v??hicule au Parc de la soci??t?? (pour diverses raisons, cong??, mission, week-end, ou autre???), le <strong> r??servoir doit ??tre plein d???essence</strong> et en ??tat de <strong>propret?? irr??prochable </strong>.</li>
        <li style="list-style-type: disc; line-height: 16px">    Pour votre <strong>s??curit??</strong>, il est demand?? de <strong>ne pas d??passer la vitesse limite r??glementaire </strong>et de respecter <strong>strictement le code de la route (ceinture obligatoire, usage du portable???)</strong>.</li>
        <li style="list-style-type: disc; line-height: 16px">   <strong> En cas de panne </strong>un ??quipement de secours est mis ?? disposition dans le coffre du v??hicule (gilet, triangle).</li>
        <ul>
    </div>
    <div>
        <p style="font-size: 13px; padding-left: 20px"><strong> Alger le</strong>, <?= date("d/m/Y") ?> </p>



    </div>


</div>
<div id="footer">

    <p style="font-size: 13px;padding-left: 50px"><strong> La Direction</strong><strong><span style="padding-left: 550px">L???int??ress??</span></strong></p>
    <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
</div>
</body>
</html>