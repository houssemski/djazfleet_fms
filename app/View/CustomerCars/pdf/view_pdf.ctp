<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style type="text/css">
            @page { margin: 95px 0px; }
            #header { position: fixed; left: 0px; top: -95px; right: 0px; height: 95px; text-align: center; }
            #footer { position: fixed; left: 0px; bottom: -95px; right: 0px; height: 100px;  }
			
            .box-body{padding: 0px; margin: 0; width: 100%;}
            .ref{float: left;padding-top: 10px}
            .conditions_ref{float: left;padding-top: 10px}
            .date{float: left;padding-top: 0px; padding-left: 650px;text-decoration: underline;}
            .title{font-weight: bold; font-size: 18px; text-align: center; padding-top: 40px;}
            .conditions_title{font-weight: bold; font-size: 18px; text-align: center; padding-top: 10px;padding-bottom: 10px; text-decoration: underline;}
            .pres{padding-top: 20px;}
            .customer .title{font-size: 16px; text-decoration: underline; padding-top: 30px;padding-bottom: 10px;}
            .customer table {
                border-collapse: collapse;
                width: 100%;
            }
            .customer table, .customer td {
                border: 1px solid grey;
            }
            .car .title{font-size: 16px; text-decoration: underline; padding-top: 0px;padding-bottom: 10px;}
            .car .cond{padding: 10px 0;}
            .car table {
                border-collapse: collapse;
                width: 100%;
            }
            .car table, .car td {
                border: 1px dashed grey;
            }
            .car table td.bottom1 {
                border-right: 1px dashed white; 
            }
            .car table td.bottom2 {
                border-left: 1px dashed white; 
                border-right: 1px dashed white; 
            }
            .car table.second{margin-top: 20px}
            .car table.third{margin-top: 10px}
            table.bottom{margin-top: 40px; width: 100%; margin-bottom: 40px}
            table.bottom td.first{width: 420px}
            table.bottom td{padding-top: 5px}
            table.footer{width: 100%; font-size: 12px; margin-top: 20px;padding-top: 10px;border-top: 1px solid #690008;}
            table.footer td.first{width: 50%; text-align: left}
            table.footer td.second{width: 50%; text-align: left;}
            table.conditions {
                border: 1px solid grey;
                width: 100%;
                border-collapse: collapse;
            }
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
            table.conditions_bottom{margin-top: 0; width: 100%; margin-bottom: 0px}
            table.conditions_bottom td.first{width: 420px}
            table.conditions_bottom td{padding-top: 5px}
            .note{font-weight: bold;padding-top: 5px;font-size: 12px;padding-bottom: 15px;}
            .note span{display: block;text-decoration: underline;padding-bottom: 5px;}
        </style>
    </head>
    <body>
        <div id="header">
            <img src="<?= WWW_ROOT ?>/img/reports/header.jpg">
        </div>
        <div class="box-body">
            <div class="ref">Contrat R??f : <?= $customerCar['CustomerCar']['reference'] ?></div>
            <div class="date">ALGER Le : <?= date("d-m-Y") ?></div>
            <div style="clear: both"></div>
            <div class="title">CONTRAT DE LOCATION DE VEHICULE</div>
            <div class="pres">
                L'Agence <b>TODO Alg??rie</b> domicili??e ?? villa N??30, Lot R.T.T, Bois des Cars 2, Delly Ibrahim, Alger, Alg??rie.
                repr??sent??e par Monsieur <b>ALKAMA Massinissa.</b>
            </div>
            <div class="customer">
                <div class="title">Identit?? du preneur</div>
                <table>
                    <tr>
                        <td>&nbsp;Nom et pr??nom : <?= $customerCar['Customer']['first_name']." ".$customerCar['Customer']['last_name']?></td>
                    </tr>
                    <tr>
                        <td> &nbsp;Adresse : <?= $customerCar['Customer']['adress']?></td>
                    </tr>
                    <tr>
                        <td> &nbsp;N??e le : <?= $this->Time->format($customerCar['Customer']['birthday'], '%d-%m-%Y')?> ?? 
                    <?= $customerCar['Customer']['birthplace']?>
                        </td>
                    </tr>
                    <tr>
                        <td> &nbsp;Nationalit?? : <?php if(isset($customerCar['Customer']['nationality'])) echo $customerCar['Customer']['nationality']; ?></td>
                    </tr>
                    <tr>
                        <td> &nbsp;N?? de permis de conduite : <?= $customerCar['Customer']['driver_license_nu']?></td>
                    </tr>
                    <tr>
                        <td> &nbsp;D??livr?? par : <?= $customerCar['Customer']['driver_license_by']?></td>
                    </tr>
                    <tr>
                        <td> &nbsp;Etabli le : <?= $this->Time->format($customerCar['Customer']['driver_license_date'], '%d-%m-%Y')?></td>
                    </tr>
                </table>
            </div>
            <div class="car">
                <div class="cond">
                    Les parties ont convenu les conditions de la location d'un v??hicule de tourisme dont les caract??ristiques et tarifs
                    sont ??num??r??s ci-apr??s :
                </div><div class="title">Caract??ristiques de la location</div>

                <table>
                    <tr>
                        <td class="top"> &nbsp;Marque : <?= $customerCar['Car']['Mark']['name']?></td>
                        <td class="top"> &nbsp;Genre : <?= $customerCar['Car']['Carmodel']['name']?></td>
                        <td class="top"> &nbsp;Couleur : <?= $customerCar['Car']['color2']?></td>
                    </tr>
                    <tr>
                        <td> &nbsp;Immatriculation : <?= $customerCar['Car']['immatr_def']?></td>
                        <td> &nbsp;Energie : <?= $customerCar['Car']['Fuel']['name']?></td>
                        <td> &nbsp;Option : <?php if(isset($customerCar['CarOption'][0]['name'])) echo $customerCar['CarOption'][0]['name']; ?></td>
                    </tr>
                    <tr>
                        <td class="bottom1"> &nbsp;Num??ro de s??rie : <?= $customerCar['Car']['chassis']?></td>
                        <td class="bottom2"></td>
                        <td class="bottom3"></td>
                    </tr>
                </table>
<?php 
$start = new DateTime($customerCar['CustomerCar']['start']);
$end = new DateTime($customerCar['CustomerCar']['end']);
$interval = $end->diff($start);
        ?>
                <table class="second">
                    <tr>
                        <td class="top"> &nbsp;Dur??e : <?= $interval->format('%a jours')?></td>
                        <td class="top"> &nbsp;Du : <?= $this->Time->format($customerCar['CustomerCar']['start'], '%d-%m-%Y %H:%M')?></td>
                        <td class="top"> &nbsp;Au : <?= $this->Time->format($customerCar['CustomerCar']['end'], '%d-%m-%Y %H:%M')?></td>
                    </tr>
                    <tr>
                        <td> &nbsp;Kilom??trage de d??part : <?= number_format($customerCar['CustomerCar']['km'],0,",",".")?></td>
                        <td colspan="2"> &nbsp;Kilom??trage d'arriver : <?= number_format($customerCar['CustomerCar']['next_km'],0,",",".")?></td>
</tr>
                </table>

                <table class="third">
                    <tr>
                        <td class="top"> &nbsp;Prix/jour HT </td>
                        <td class="top"> &nbsp;Date de paiement </td>
                        <td class="top"> &nbsp;Caution DZD </td>
                        <td class="top"> &nbsp;Etat de V??hicule </td>
                    </tr>
                    <tr>
                        <td> &nbsp;
                            <?= number_format($customerCar['CustomerCar']['cost_day'],2,",",".")." ".$this->Session->read('currency') ?>
                        </td>
                        <td> &nbsp; <?= $this->Time->format($customerCar['CustomerCar']['date_payment'], '%d-%m-%Y') ?></td>
                        <td> &nbsp; <?= number_format($customerCar['CustomerCar']['caution'],2,",",".")." ".$this->Session->read('currency')
                            ?></td>
                        <td> &nbsp; <?= $customerCar['CustomerCar']['state']?></td>
                    </tr>
                </table>
            </div>
            <table class="bottom">
                <tr>
                    <td class="first"><b>TODO ALGERIE</b></td>
                    <td><?= $customerCar['Customer']['first_name']." ".$customerCar['Customer']['last_name']?></td>
                </tr>
                <tr>
                    <td>Signature :</td>
                    <td>Signature :</td>
                </tr>
                <tr>
                    <td>Cachet :</td>
                    <td>Merci d'apposer l'empreinte de votre index gauche :</td>
                </tr>
            </table>
        </div>
        <div id="footer">
                <table class="footer">
                    <tr>
                        <td class="first">
                            <?= $company['LegalForm']['name'] ?>
                            <?php if(!empty($company['Company']['social_capital'])){ ?>
                                au Capital de <?=
                                number_format($company['Company']['social_capital'],2,",",".")." ".$this->Session->read('currency')
                                ?>
                            <?php }else{?>
                                <?= Configure::read("nameCompany") ?>
                            <?php } ?>
                            - RC : <?= $company['Company']['rc'] ?>
                        </td>
                        <td class="second">
                <?= $company['Company']['adress'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="first">
                            AI : <?= $company['Company']['ai'] ?> - IF : <?= $company['Company']['nif'] ?>
                        </td>
                        <td class="second">
                            T??l. : <?= $company['Company']['phone'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="first">
                            Compte : <?= $company['Company']['cb'] ?> RIB : <?= $company['Company']['rib'] ?>
                        </td>
                        <td class="second">
                            Mobile : <?= $company['Company']['mobile'] ?>
                        </td>
                    </tr>
                </table>
            </div>
        
        
        
        
        <div id="header">
            <img src="<?= WWW_ROOT ?>/img/reports/header.jpg">
        </div>
        <div class="box-body">
            <div class="conditions_ref">Contrat R??f : <?= $customerCar['CustomerCar']['reference'] ?></div>
            <div style="clear: both"></div>
            <div class="conditions_title">Condition g??n??rale de location de v??hicule</div>
            <table class="conditions">
                <tr>
                    <td>
                        <span><b>1- Age minimum :</b> 25 ans ou 5 ans de permis.</span><br/>
                        <span><b>3- Caution:</b> de 30 000 da ?? 200 000 da selon la cat??gorie du
v??hicule.</span><br/>
<span><b>5- Horaires :</b> Le client doit respecter les horaires fournies sur la
fiche de r??servation. Tout changement doit ??tre signal?? a
l'avance, ?? l'arriv??e comme au retour.<br/>
Toute prolongation de la location sans l'accord express du
loueur 72h ?? l'avance entra??nera une p??nalit?? (facturation de
chaque jour suppl??mentaire jusqu'?? 3 fois le montant de base,
et perte de l'int??gralit?? de la caution ?? partir de 48h de retard).</span><br/>

<span><b>7- Panne m??canique :</b> En cas de panne m??canique relevant de la
responsabilit?? du client (ex: casse carter d'huile, triangle
inf??rieur, serrure ou autres etc.), la prise en charge du
d??pannage et de la r??paration sont ?? la charge totale du client.</span><br/>
<span><b>9- D??passement du d??lai :</b> si le client rend le v??hicule avant
expiration du d??lai de location, celui-ci ne peut en aucun cas
exiger le remboursement des sommes dues au titre de la
location restante.</span><br/>
<span><b>11- P??nalit??s de retard :</b>
une heure de retard est tol??r??e de part et d'autre (client et
livreur). Pass?? ce d??lai, la partie retardataire (client ou livreur)
devra verser 1 000da par heure de retard.</span><br/>
<span><b>13- Propret?? :</b>
Le v??hicule est livr?? propre et doit ??tre restitu?? dans le m??me
??tat, faute de quoi il sera factur?? 1000 dinars de d??graissage.</span><br/>
<span><b>15- Conditions :</b>
le client d??clare avoir pris connaissance et accepter sans r??serve
les pr??sentes conditions de location.</span><br/>
                    </td>
                    <td>
                        <span><b>2- Franchise :</b> maximum ??gale au montant de la caution.</span><br/>
                        <span><b>4- Carburant :</b> v??hicule est fourni avec le plein de carburant et
doit ??tre restitu?? avec le plein. A d??faut, le carburant manquant
sera factur??.</span><br/>
<span><b>6- Sinistre responsable : </b>
Tout sinistre responsable ou dont le tiers est inconnu (vol,
accident, incendie, etc) inf??rieur au montant de la caution sera a
la charge du client.<br/>
Toutefois en cas d'assurance tous risques (option) le client
r??cup??rera sa caution en cas d'accident responsable sur
pr??sentation du constat. Le vol du v??hicule ou de ses accessoires
est exclu de l'assurance tous risques.<br/>
Tout sinistre responsable ou dont le tiers est inconnu (vol,
accident, incendie, etc) sup??rieur au montant de la caution
entrainera la perte de celle-ci.</span><br/>
<span><b>8- Annulation :</b>
Pour toute location annul??e au del?? de 36 heures avant la date de
livraison du v??hicule, il sera retenu 15% du montant de la
location pour frais de gestion.pour tout autre delai soit de 0h a
36 h , il sera retenu 30% du montant pour dommage.</span><br/>
<span><b>10- Ch??que de caution :</b>
un ch??que de caution ?? l'ordre de SARL TODO est ?? remettre ??
la r??ception du v??hicule.</span><br/>
<span><b>12- Assurance dommage collision :</b>
L'assurance dommage collision ??vite la perte de la caution en cas
de sinistre responsable seulement sur pr??sentation du constat
amiable. Toutefois, elle ne couvre pas le vol d'accessoires,
l'incendie, et la d??gradation du v??hicule dont le tiers est inconnu.</span><br/>
<span><b>14- Assurance :</b>
seuls les conducteurs mentionn??s sur le contrat b??n??ficient de
l'assurance. Le pr??t et la sous-location du v??hicule sont
strictement interdits. L'int??gralit?? des dommages survenus dans
ces circonstances est ?? la charge du client.</span><br/>
                    </td>
                </tr>
            </table>
            <div class="note">
                <span>Attention :</span>
Tout d??passement du d??lai de la location (01 jours) sera sanctionn?? par une plainte aupr??s des autorit??s juridiques comp??tentes.
Le d??passement horaire sera factur?? ?? 1000 DA l???heure et toute distance parcourue qui d??passe les 300 Km par jour fera l???objet de
paiement suppl??mentaire de 15 DA htt par Km. Chaque prolongation de la dur??e de location doit ??tre d??clar??e 48 heures avant la
fin du contrat.
            </div>
            <table class="conditions_bottom">
                <tr>
                    <td class="first"><b>TODO ALGERIE</b></td>
                    <td><?= $customerCar['Customer']['first_name']." ".$customerCar['Customer']['last_name']?></td>
                </tr>
                <tr>
                    <td>Signature :</td>
                    <td>Signature :</td>
                </tr>
                <tr>
                    <td>Cachet :</td>
                    <td>Merci d'apposer l'empreinte de votre index gauche :</td>
                </tr>
            </table>
        </div>
        
        <div id="footer">
                <table class="footer">
                    <tr>
                        <td class="first">
                            <?= $company['LegalForm']['name'] ?>
                            <?php if(!empty($company['Company']['social_capital'])){ ?>
                                au Capital de <?=
                                number_format($company['Company']['social_capital'],2,",",".")." ".$this->Session->read('currency')
                                ?>
                            <?php }else{?>
                                <?= Configure::read("nameCompany") ?>
                            <?php } ?>
                            - RC : <?= $company['Company']['rc'] ?>
                        </td>
                        <td class="second">
                <?= $company['Company']['adress'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="first">
                            N??AI : <?= $company['Company']['ai'] ?> - N??IF : <?= $company['Company']['nif'] ?>
                        </td>
                        <td class="second">
                            T??l??phone : <?= $company['Company']['phone'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="first">
                            CB : <?= $company['Company']['cb'] ?> RIB : <?= $company['Company']['rib'] ?>
                        </td>
                        <td class="second">
                            Mobile : <?= $company['Company']['mobile'] ?>
                        </td>
                    </tr>
                </table>
            </div>
    </body>
</html>