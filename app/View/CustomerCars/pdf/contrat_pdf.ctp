<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style type="text/css">
            @page { margin: 95px 0px; }
            .header { position: fixed; left: 0px; top: -100px; right: 0px; height: 0px; text-align: center; font-family: "Calibri",sans-serif;}
            #footer { position: fixed; left: 0px; bottom: -95px; right: 0px; height: 110px; font-family: "Calibri",sans-serif; line-height: 11px;color: #000080;}
			#footer2 { position: fixed; left: 0px; bottom: -85px; right: 0px; height: 25px;  }
			.copyright{font-size:10px; text-align:center; color:#000;border-top: 1.5px solid #000; padding-top:5px; padding-bottom:5px; font-family: "Calibri",sans-serif; }
			.body-cond {font-size: 11px; color: #000080; margin-left: 10px; font-family: "Calibri",sans-serif;line-height: 14px}
            .box-body{padding: 0px; margin: 10px; width: 100%; font-family: "Calibri",sans-serif; font-size: 12px;height:95%;line-height: 25px}
			.body-cond-genl{position: relative;padding: 0px; margin-left: 20px;margin-right: 20px; width: 100%; font-family: "Calibri",sans-serif; height:100%;top: -28px; }
            .ref{float: left;padding-top: 10px; font-family: "Calibri",sans-serif;}
            .conditions_ref{float: left;padding-top: 10px; font-family: "Calibri",sans-serif;}
            .date{float: left;padding-top: 0px; padding-left: 650px;text-decoration: underline; font-family: "Calibri",sans-serif;}
            .title{font-weight: bold; font-size: 18px; text-align: center; padding-top: 40px;font-family: "Calibri",sans-serif;}
            .conditions_title{font-weight: bold; font-size: 18px; text-align: center ; text-decoration: underline;font-family: "Calibri",sans-serif;}
            .pres{padding-top: 20px;font-family: "Calibri",sans-serif;}
            .customer .title{font-size: 16px; text-decoration: underline; padding-top: 30px;padding-bottom: 10px;font-family: "Calibri",sans-serif;}
            .grand_titre{ font-size: 15px; font-weight : bold;}
			.petit_titre{ font-size: 12.5px; font-weight : bold;}
			
			.customer table {
                border-collapse: collapse;
                width: 100%;
            }
            .customer table, .customer td {
                border: 1px solid grey;
            }
            .car .title{font-size: 16px; text-decoration: underline; padding-top: 0px;padding-bottom: 10px;font-family: "Calibri",sans-serif;}
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
            table.footer{width: 100%; font-size: 12px; margin-top: 0px;padding-top: 10px;margin-left:20px;}
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
   
		<div id="body">
		  <div class="header" style="position: fixed; left: 0px; top: -100px; right: 0px; height: 0px; text-align: center; font-family: 'Calibri',sans-serif;">
		<table>
		<tr>
			<td style='width:350px; text-align: center; font-size: 26px; color: #000080; font-weight : bold;'>Contrat </td>
			<td style='width:450px; text-align: right;'><img src="<?= WWW_ROOT ?>/logo/<?= $company['Company']['logo'] ?>" width="100px" height="100px"></td>
            
		</tr>
		</table>
            
        </div>
        <div class="box-body">
           <table >
				<tr>
					<td style='vertical-align: top;width:400px'> 
					<div><span class=' grand_titre'>Entre les soussign&eacute;s :</span> <br/> <span style=' font-size: 13px; font-weight : normal;'><span style='font-weight : bold;'>CVL  Sise :</span> Coop&eacute;rative Immobili&egrave;re Haut site Hydra 
					<br/><span style='margin-left:70px'>Lot Moutchachou locale n&deg;19 Hydra </span><br/>Repr&eacute;sent&eacute;e par son G&eacute;rant:<br/><span style='font-weight : bold;'>Mr MECHEROUH Mohamed Tahar </span><br/>Et:</span></div>
					<div><span class=' grand_titre'> Locataire:</span><?= $customerCar['Customer']['company'] ?></div>
					<div><span class=' petit_titre'>Adresse : </span><?= $customerCar['Customer']['adress']?></div>
					<div><span class=' grand_titre'>Conducteur : </span><?= $customerCar['Customer']['first_name'].' '.$customerCar['Customer']['last_name']    ?></div>
					<div><span class=' petit_titre'>Date et Lieu de naissance:</span><?= $this->Time->format($customerCar['Customer']['birthday'],'%d/%m/%Y').' '.$customerCar['Customer']['birthplace']  ?></div>
					<div><span class=' petit_titre'>Permis de Conduire N&deg;:</span> <span style='width:110px; display:inline-block'><?=$customerCar['Customer']['driver_license_nu']?></span> <span class=' petit_titre'> Emis le :</span> <?=$this->Time->format($customerCar['Customer']['driver_license_date'], '%d/%m/%Y')?></div>
					<div><span class='petit_titre'>&agrave;:</span> <?= $customerCar['Customer']['driver_license_by'] ?></div>
					<div><span class='petit_titre'>C.N.I ou Passeport: </span><span style='width:110px; display:inline-block'><?= $customerCar['Customer']['passport_nu']?></span><span class='petit_titre'> Emis le : </span><?=$this->Time->format($customerCar['Customer']['passport_date'], '%d/%m/%Y')?> </div>
					<div><span class='petit_titre'>&agrave;: </span><?= $customerCar['Customer']['passport_by']?></div>
					<div><span class='petit_titre'>Adresse permanente:  </span></div>
					<div><span class='petit_titre'>Autre Conducteur : </span></div>
					<div><span class='petit_titre'>Date  et Lieu de naissance:</span></div>
					<div><span class='petit_titre'>Permis de Conduire N&deg;:</span><span style='width:110px; display:inline-block'></span>  <span class='petit_titre'>Emis le :</span> </div>
					<div><span class='petit_titre'>Observation:</span> <?= $customerCar['CustomerCar']['obs']?></div>
					</td>
					<td> 
						<div style='text-align: center; font-size: 17px; color: #000080; font-weight : bold;'>V&eacute;hicule:</div>
					<div><span class=' petit_titre'>Marque :</span><?= $customerCar['Car']['Mark']['name'].' '.$customerCar['Car']['Carmodel']['name'] ?></div>
					<div><span class=' petit_titre'>IMMATRICULE :</span><?= $customerCar['Car']['immatr_def']?> S&eacute;rie du Type N&deg;  : </div>
					<div><span class=' petit_titre'>Energie :</span> <?= $customerCar['Car']['Fuel']['name']  ?></div>
					<div><span class=' grand_titre'>Kilom&eacute;trage</span></div>
					<div><span class=' petit_titre'>Km d&eacute;part: </span><span style='width:110px; display:inline-block'><?=$customerCar['CustomerCar']['km']?> </span><span class=' petit_titre' > Km arriv&eacute;e: </span><?=$customerCar['CustomerCar']['next_km'] ?></div>
					<?php 
					$km_parcouru=$customerCar['CustomerCar']['next_km']- $customerCar['CustomerCar']['km']
					
					?>
					<div><span class=' petit_titre' >Km parcouru <?= $km_parcouru ?></span></div>
					<div style='color: #000080; font-style: italic; font-size:11px'>NB: La Location comprend un forfait de 300 Km par jour <br/>
					et tout d&eacute;passement sera factur&eacute; au client a raison de 10 DA TTC <br/>
					par Km suppl&eacute;mentaire de m&ecirc;me que tout retard de plus de deux heures <br/>
					dans la restitution du v&eacute;hicules apr	&egrave;s l'horaire pr&eacute;vue sera factur&eacute; <br/> 
					au prix d'une journ&eacute;e de location</div>
					<div><span class=' grand_titre'>D&eacute;part/ Arriv&eacute;e</span></div>
					<div><span class=' petit_titre'>Date et heure de d&eacute;part:  </span><?=$this->Time->format($customerCar['CustomerCar']['start'], '%d/%m/%Y %H:%M')?> </div>
					<div><span class=' petit_titre'>Date et heure d'arriv&eacute;e: </span><?=$this->Time->format($customerCar['CustomerCar']['end'], '%d/%m/%Y %H:%M')?>  </div>
					<?php  
					$nb_jour = $customerCar['CustomerCar']['end']-$customerCar['CustomerCar']['start'];
					?>
					<div><span class=' petit_titre'>Nbr Jours: </span><?=  $nb_jour ?></div>
					<div><span class=' petit_titre'>Livraison &agrave; : </span></div>
					<div><span class=' petit_titre'>Reprise &agrave; : </span> </div>
					<div><span class=' grand_titre'> Prolongation </span></div>
					<div><span class=' petit_titre'>Du :</span> <span style='width:110px; display:inline-block'></span>       <span class=' petit_titre'>heure D&eacute;part : </span></div>
					<div><span class=' petit_titre'>Du : </span>  <span style='width:110px; display:inline-block'></span>     <span class=' petit_titre'>heure Arriv&eacute;e : </span></div>
					<div></div>
					</td>
				</tr>
		   
			</table>
		<br/>	
		<br/>
		<br/>		
        <div style='color: #000080; border: dotted; margin-left:15px;margin-right:15px; padding:5px; font-size:14px'> Le  V&eacute;hicule mis 	&agrave; votre disposition  propre et v&eacute;rifi&eacute;, devra &ecirc;tre restitu&eacute; dans les m�me condition sous peine de facturation de 1000 DA ( pour son n&eacute;ttoyage )
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
                            Tél. : <?= $company['Company']['phone'] ?>
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
				
			<div style='font-size: 12px;margin-left:20px; font-size:11px'><span style='font-weight:bold;'>	Annexe CVL Blida: </span> Hotel Ville des Roses    Boulevard Mohamed Boudiaf    (bvd 20m�tres)   Blida        Mob:+213(0) 558 481 852      E-mail:cvl_villedesroses@yahoo.fr </div>
			<p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
            </div>       
		
		
    </div>    
        
		</div>		
     
		
            
            <div style="clear: both"></div>
			
			<div class='body-cond-genl'>
           
<div class='body-cond'>
<br/>
<div class="conditions_title">Condition g&eacute;n&eacute;rale de location</div> 
<p>ARTICLE 1 : </p>
<p>Le v&eacute;hicule objet du pr&eacute;sent contrat de location ne peut en aucun cas �tre conduit par une autre personne que celle dont le nom figure sur le contrat. </p>
<p>ARTICLE 2 :</p> 
<p>a)ETAT DU VEHICULE: Le locataire reconna�t avoir re�ue le v�hicule d�sign� au contrat en parfait �tat de propret� et s'engage � ne jamais toucher au compteur kilom�trique et ne doit pas proc�der � aucune pr�sentation, �change de pi�ce m�canique, sans l'autorisation du propri�taire.</p> 
<p>b) Pneumatique: Le v�hicule est �quip� de cinq pneus en bon �tat et sans coupure. En cas de d�t�rioration de l'un d'entre eux , pour une cause autre  que l'usure normale, le locataire s'engage a le remplacer imm�diatement par un pneu de m�me marque et de m�me dimension.</p>
<p>c) MECANIQUE: L'usure m�canique normale est � la charge de C.V.L. toutes les r�parations provenant soit d'une usure anormale, d'une n�gligence ou d'une cause accidentelle seront � la charge du client mais effectuer par le garage agr�e. Dans le cas ou le v�hicule serait immobilis� par suite d'une usure normale ou d'une cause accidentelle, les r�parations pourront �tre ex�cut� (apr�s l'accord de C.V.L ) et devront faire l'objet d'une facture acquitt�e tr�s d�tailler les pi�ces d�fectueuse remplac�es devront �tre pr�sent�es dans la facture r�guli�rement acquitt�e En aucun cas, le locataire ne pourra pr�tendre � une indemnit� quelconque par suit d'un retard, soit de la remise du v�hicule ou l'annulation de la location  soit par suit de r�parations n�cessit�es par l'usure normale et effectu�es au cours de la location. Le locataire s'engage � restituer le v�hicule avec tous ses accessoires, outils et �quipement � la date et lieu fix�s au pr�sent contrat.</p>
<p>ARTICLE 3<p>  
<p>a) Assurances: Le locataire d�clare avoir pris connaissance des conditions g�n�rales du certificat automobile dont copie est � sa disposition dans les bureaux de location de C.V.L Cette police couvre les risques ci-apr�s :</p> 
<ul>
	<li>responsabilit�s civiles du locataire et de conducteur autoris� par lui a raison des accidents caus�s aux tiers, sans limitation de somme.</li>
	<li>Dommages au v�hicule C.V.L sous d�duction d'une franchise de 10.000 DA -Incendie et vol v�hicule avec constat des services de police ou de gendarmerie - Bris des glaces.Les pertes ou dommages caus�e a tous bien et valeurs quelconque transport�es dans le v�hicule  ne sont pas garantie ni par le locataire ni par une autre personne pendant la dur�e de la location ou apr�s la restitution du v�hicule.</li>	
</ul>
<p>
Le locataire d�clare, en outre, que le v�hicule Sen a la promenade, au tourisme ou l'exercice d'une profession. Mais qu'en aucun cas m�me a titre exceptionnel, il ne peut �tre utilis� pour le transport de passager a titre on�reux II n'y pas assurance pour le v�hicule dont  le conducteur participe comme concurrent a des rallyes, a des comp�titions organis�es ou a leur essais.
 </p>
<p> b) En cas d'accident : Le locataire doit:<p>
<ul>
<li>Sauf en cas de fortuit ou de force majeur, d�clarer par �crit � C.V.L les sinistres dans les cinq jours et les vols dans les 24 heures apr�s d�p�t de plainte aupr�s des services de police ou gendarmerie.</li> 
<li>Noter les noms et adresses des parties en cause et des t�moins.</li> 
<li>Ne jamais reconna�tre sa responsabilit�, ni transiger avec les tiers.</li> 
<li>Aviser la police ou la gendarmerie si la faute d'un tiers doit �tre �tablie ou s'il y a des bless�s.</li>
</ul>
<p>ARTICLE 4 : LOCATION- CAUTION -PROLONGATION </p>  
<p>Le montant de la location est payable d'avantage. La caution est obligatoire, elle ne pourra servir pour une prolongation sans l'accord pr�alable de C.V.L Afin d'�viter toute contestation dans le cas d'une prolongation,  le locataire devra apr�s avoir obtenue l'accord de C.V.L. faire parvenir le montant de la location suppl�mentaire, quarante-huit heures avant l'expiration de la location en cour, sous peine de s'exposer a des poursuites judiciaires pour d�tournement du v�hicule ou abus  de confiance. </p>
<p>ARTICLE 5 : </p>
<p>DOCUMENTS DE LA VOITURE Le locataire s'engage d�s la fin de location a restituer tous les documents n�cessaires a la conduite du v�hicule, a d�faut ces pi�ces �tant indispensables a des nouvelles location, C.V.L se verra dans l'obligation de facturer au locataire, les journ�es de retard d'apr�s le tarif.</p>
<p>ARTICLE 6 : DELIT ET CONTRAVENTIONS </p>
<p>En cas de vol, le locataire et tenue de d�clarer imm�diatement dans les 12 heures qui suivent la consultation aupr�s du service de police, ou de gendarmerie d�p�t de plainte, ainsi qu'a l'agence de d�part, l'ensemble des documents ainsi que les cl�s du v�hicule sont a restituer a l'agence dans l'imm�diat, sous peines d'endosser personnellement la responsabilit� de la disparition, et de pr�server les documents  du v�hicule ainsi que les clefs. </p>

</div> 
<div id="footer2">
			<p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
  </div> 
<div style="clear: both"></div>  
         
   </div>
		
    
    </body>
	
	
</html>