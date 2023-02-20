<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style type="text/css">
            @page { margin: 95px 0; }
            #header { position: fixed; left: 0; top: -95px; right: 0; height: 125px; border-bottom: 1px solid #000;}
            #header table{width:100%;}
            #header td.logo{vertical-align: top;padding-left:25px;padding-top:15px; width:270px;}
            #header td.company{vertical-align: top; font-weight: bold; font-size: 16px;padding-right:50px;}
            #header td.company span{display: block; font-size: 22px; padding-bottom: 10px;padding-top: 20px;}
            #footer { position: fixed; left: 0; bottom: -95px; right: 0; height: 110px;  }
			#copyright{font-size:10px; text-align:center; position: fixed; left: 0; height:10px; bottom: -95px;}
            .box-body{padding: 0 25px; margin: 0; width: 100%;}
            .ref{padding-top: 25px}
            .date{padding-top: 15px; text-align:right;padding-right:25px;}
           .title{font-weight: bold; font-size: 24px; 
                  text-align: center;
					padding-top: 20px;				  
                  padding-bottom: 40px;
                  /*border-bottom: 1px solid #000;*/
                  width: 500px;
                margin: 0 auto 10px;
                
            }
            .customer table {
                border-collapse: collapse;
                width: 100%;
                font-size: 18px;
            }
            .customer tr td:first-child{ 
                width: 400px !important; 
                padding-bottom: 20px;   
            }
          
            table.footer{width: 100%; font-size: 12px; margin-top: 20px;padding-top: 10px;border-top: 1px solid #000;}
            table.footer td.first{width: 50%; text-align: left; padding-left:25px;}
            table.footer td.second{width: 50%; text-align: left; padding-left:25px;}
			
            .obs{
			width:750px;
			padding: 5px;
			margin: 0 auto;
			border: 1px solid #000;
			height:100px;
			}
			.resp{ padding-left:400px; }
			.date_recep{padding-left:50px; padding-top:10px;}
			.ref{width:500px; display:inline-block;}
        </style>
    </head>
    <body>
        <div id="header">
        <?php if($entete_pdf=='1') {?>
            <table>
                <tr>
                    <td class="logo">
                        <img src="<?= WWW_ROOT ?>/logo/<?= $company['Company']['logo'] ?>" width="100px" height="100px">
                    </td>
                    <td class="company">
                         <span><?= Configure::read("nameCompany") ?></span>
                        <?php if(!empty($company['Company']['social_capital'])){ ?>
                       <?= $company['LegalForm']['name'] ?>
                au Capital de <?= number_format($company['Company']['social_capital'],2,",",".") ?>
                        <?php } ?>
                    </td>
                    <td  class="date" ></td>
                </tr>
            </table>
            <?php }?>
        </div>
        <div class="box-body">
            <div class="date" ><span class='ref' style="text-align:left;"><strong>N&deg; : <?= $customerCar['CustomerCar']['reference'].'/'.date("Y") ?></strong> </span><span style="text-align:right;"><strong>Le : </strong><?= date("d-m-Y") ?></span> </div>
			
            <div style="clear: both"></div>
            <div class="title">Ordre de mission</div>
            <div class="customer">
                <table>
                    <tr >
                        <td style="padding-top: 30px"><strong>&nbsp;Nom  et pr&eacute;nom :</strong> &nbsp;<?= $customerCar['Customer']['first_name'].' '.$customerCar['Customer']['last_name']?> </td>
						<td></td>
                        <td rowspan=3>
						<?php if(!empty($customerCar['Customer']['image'])) {?>
                        <img style="padding-left: 50px" src="<?= WWW_ROOT ?>/img/customers/<?= $customerCar['Customer']['image'] ?>" width="100px" height="140px">
						<?php }?>
						</td>
                    </tr>
                    <tr>
                        <td><strong>&nbsp;Profession :</strong> &nbsp;<?= $customerCar['Customer']['CustomerCategory']['name']?> </td>
                        <td><strong>&nbsp;Tel : </strong>&nbsp;<?= $customerCar['Customer']['tel']?></td>
						
                    </tr>
                   
                   
                    <tr>
                        <td><strong> &nbsp;Client :</strong> &nbsp;<?php if(isset($customerCar['Supplier']['name'])) { echo $customerCar['Supplier']['name'];}?></td>
                        <td> </td>
						
                    </tr>
                    
                    
                    <tr>
                        <td><strong>&nbsp;Moyen de transport : </strong>&nbsp;<?= $customerCar['Car']['Carmodel']['name'] ?> </td>
                        <td><strong>&nbsp;Matricule :</strong> &nbsp;<?= $customerCar['Car']['immatr_def'] ?></td>
						
                    </tr>
					<tr>
                        <td><strong>&nbsp;Remorque :</strong><?php if(!empty($remorque)){ echo $remorque['Carmodel']['name'];}?>   </td>
                        <td><strong>&nbsp;Matricule : </strong><?php if(!empty($remorque)){ echo $remorque['Car']['immatr_def'];}?></td>
						<td></td>
                    </tr>
                    <tr>
                        <td><strong>&nbsp;Accompagne :</strong><?php if(!empty($customer_help)){ echo $customer_help['Customer']['first_name'].' '.$customer_help['Customer']['last_name'];}?></td>
                        <td> </td>
						<td></td>
                    </tr>
                    
                    <tr>
                        <td><strong>&nbsp;Motif de mission :</strong></td>
                        <td> </td>
						<td></td>
                    </tr>
                    <tr>
                        <td><strong>&nbsp;Date de d&eacute;part :</strong><?= $this->Time->format($customerCar['CustomerCar']['start'], '%d-%m-%Y')?></td>
                        <td> </td>
						<td></td>
                    </tr>
                    <tr>
                        <td><strong>&nbsp;Date de retour :</strong><?= $this->Time->format($customerCar['CustomerCar']['end'], '%d-%m-%Y')?></td>
                        <td> </td>
						<td></td>
                    </tr>
                
                    
                </table>
            </div>
            <div class='obs'>
			<strong>Observation:</strong>
			</div>
            
			<table >
			<tr>
			<td class='date_recep'><strong>Re&ccedil;u le : </strong></td>
			<td class="resp"><strong><?php if(!empty($signature_mission_order)) {echo $signature_mission_order; } else {echo 'Le responsable logistique';}?>  </strong></td>
			</tr>
			</table>
        </div>
        <div id="footer">
                 <?php if($entete_pdf=='1') {?>
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
                            Compte : <?= $company['Company']['cb'] ?> RIB : <?= $company['Company']['rib'] ?>
                        </td>
                        <td class="second">
                            Mobile : <?= $company['Company']['mobile'] ?>
                        </td>
                    </tr>
                </table>
                <?php }?>
				
            </div>
			<p id='copyright'>Logiciel : UtranX | www.cafyb.com</p>
    </body>
</html>