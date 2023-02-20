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
        <p>La société <strong> <?= Configure::read("nameCompany")?></strong> met à votre disposition un Véhicule de service de marque  <strong><?= $customerCar['Car']['Mark']['name'] ?> </strong>Immatriculé sous numéro: <strong><?= $customerCar['Car']['immatr_def'] ?> </strong>pour lequel vous êtes responsable et devez veiller à ce qu’il soit toujours en parfait état de marche et bien entretenu.</p>
        <p class="title1">La société garantie la prise en charge suivante : </p>
        <p>1/ Tous les documents et procédures administratives permettant au véhicule de circuler : Carte grises, prorogation des délais de la carte jaune, assurances et vignettes.</p>
        <p></p>
        <p>
            2/ Véhicule endommagé :
        </p>
        <p style="padding-left: 35px;">
            a) L’Assurance de la société prend en charge toute procédure liée au moindre endommagement du véhicule.
        </p>
        <p style="padding-left: 35px;">
            b) La réparation d’un premier accident uniquement ;
        </p>
        <p style="padding-left: 35px;">
            c) Tout accident ou incidents mécanique, électrique et esthétique lies au véhicule doivent être impérativement signalés à l’Administration, pour la prise en charge immédiate par Chef de Parc & Sécurité
        </p>
        <p  class="title1">L’utilisateur a à sa charge ce qui suit :</p>
        <p style='font-weight: bold; text-decoration: underline'>1/ L’entretien régulier :</p>
        <p style="padding-left: 35px;">a/ 02 lavages/mois extérieur et intérieur chaque début de semaine.</p>
        <p style="padding-left: 35px;">b/ Vérification des pneus 2 fois par mois.</p>
        <p style="padding-left: 35px;">c/ Un contrôle régulier du niveau d’huile du moteur hebdomadaire.</p>
        <p style="padding-left: 35px;">d/ Un contrôle du niveau d’eau du radiateur et du lave glace hebdomadaire.</p>
        <p style="padding-left: 35px;"> e/ Une vidange régulière avec respect des dates de révisions des véhicules, tous les 10 000 Km. doivent être effectuées avec consultation de l’administration (en cas de convention avec concessionnaire,   etc….). </p>
        <p>2/ <strong>Une mise à jour </strong> du <strong>Carnet de bord </strong> et du <strong>registre de maintenance </strong>est exigée pour vérification et contrôle en toute circonstance de l’administration.</p>
        <p>3/<strong> Cas d’un second accident </strong>signalé depuis la remise du véhicule : L’utilisateur devra assumer les frais de réparation, s’ils s’avèrent supérieurs à ceux estimés par notre assureur.</p>
        <p>4/ Cas d’infractions avérées </p>
        <p>5/ Cas de mise en fourrière : tous les frais sont à la charge de l’utilisateur </p>
        <p class="title1">Pour rappel :</p>
        <ul>
        <li style="list-style-type: disc; line-height: 16px">	<strong ><span style="text-decoration: underline">Le véhicule est à usage professionnel</span></strong>, il n’est pas permis de le personnaliser avec un décor ou tout autre objet personnel visible.</li>
        <li style="list-style-type: disc; line-height: 16px">	Pour <strong>disposer du véhicule durant le congé </strong>, une demande doit être formulée en même temps que le congé et n’est accordée que sur appréciation de la Direction.</li>
        <li style="list-style-type: disc; line-height: 16px">    <strong>Avant d’envisager la moindre intervention </strong>sur le véhicule, l’utilisateur doit la <strong>signaler à l’administration</strong>.</li>
        <li style="list-style-type: disc; line-height: 16px">    Lors de la remise du véhicule au Parc de la société (pour diverses raisons, congé, mission, week-end, ou autre…), le <strong> réservoir doit être plein d’essence</strong> et en état de <strong>propreté irréprochable </strong>.</li>
        <li style="list-style-type: disc; line-height: 16px">    Pour votre <strong>sécurité</strong>, il est demandé de <strong>ne pas dépasser la vitesse limite réglementaire </strong>et de respecter <strong>strictement le code de la route (ceinture obligatoire, usage du portable…)</strong>.</li>
        <li style="list-style-type: disc; line-height: 16px">   <strong> En cas de panne </strong>un équipement de secours est mis à disposition dans le coffre du véhicule (gilet, triangle).</li>
        <ul>
    </div>
    <div>
        <p style="font-size: 13px; padding-left: 20px"><strong> Alger le</strong>, <?= date("d/m/Y") ?> </p>



    </div>


</div>
<div id="footer">

    <p style="font-size: 13px;padding-left: 50px"><strong> La Direction</strong><strong><span style="padding-left: 550px">L’intéressé</span></strong></p>
    <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
</div>
</body>
</html>