<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style type="text/css">
            @page { margin: 95px 0; }
            #header { position: fixed; left: 0; top: -120px; right: 0; height: 110px; border-bottom: 1px solid #000;}
            #header td.logo{width: 300px; vertical-align: top;}
            #header td.company{width: 300px;vertical-align: top; font-weight: bold; font-size: 16px;text-align: left;}
            #header td.company span{display: block; font-size: 22px; padding-bottom: 10px;padding-top: 50px;}
			.info_fiscal{width:300px;font-size:12px;padding-top: 30px;line-height:18px;}
            #footer { position: fixed; left: 0; bottom: -95px; right: 0; height: 175px;  }
			#copyright{font-size:10px; text-align:center; position: fixed; left: 0; height:10px; bottom: -95px;}
            .box-body{padding: 0 25px; margin: 0; width: 100%;}
            .ref{padding-top: 0px}
            .date{padding-top: 5px; text-align:right;padding-right:25px;}
           .title{font-weight: bold; font-size: 24px; 
                  text-align: center;
					padding-top: 20px;				  
                  padding-bottom: 20px;
                  /*border-bottom: 1px solid #000;*/
                  width: 500px;
                margin: 0 auto 10px;
                
            }
            .customer table {
                border-collapse: collapse;
                width: 100%;
                font-size: 18px;
            }
            .customer tr td{ 
                width: 400px !important; 
                padding-bottom: 10px;   
            }
          
            table.footer{width: 100%; font-size: 12px; margin-top: 20px;padding-top: 10px;border-top: 1px solid #000;}
            table.footer td.first{width: 50%; text-align: left; padding-left:25px;}
            table.footer td.second{width: 50%; text-align: left; padding-left:25px;}
			
   
			.resp{ padding-left:400px; }
			.date_recep{padding-left:50px; padding-top:10px;height:50px;}
			.ref{width:500px; display:inline-block;}
			.div-date{
			width:250px;
			height:100px;
			border: 1px solid #000;
			}
			
        </style>
    </head>
    <body>
        <div id="header">
        <?php if($entete_pdf=='1') {?>
            <table>
                <tr>
                    <td class="logo">
                        <?php if(!empty($company['Company']['logo']) && file_exists( WWW_ROOT .'/logo/'. $company['Company']['logo'])) {?>
                            <img src="<?= WWW_ROOT ?>/logo/<?= $company['Company']['logo'] ?>" width="180px" height="120px">
                        <?php }else { ?>
                            <img  width="180px" height="120px">
                        <?php } ?>
                    </td>
                    <td class="company">
                         <span><?= Configure::read("nameCompany") ?></span>
                       
                    </td>
					<td class="info_fiscal">
							<span><strong>RC :</strong><?= $company['Company']['rc'] ?></span><br>
							<span><strong>AI :</strong><?= $company['Company']['ai']?></span><br>
							<span><strong>NIF :</strong><?= $company['Company']['nif']?></span><br>
                        <span><strong>Compte :</strong><?= $company['Company']['cb']?></span>
                    </td>
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
                       
                    </tr>
                    <tr>
                        <td><strong>&nbsp;Grade ou fonction :</strong> &nbsp;<?= $customerCar['Customer']['CustomerCategory']['name']?> </td>
                        <td><strong>&nbsp;Tel : </strong>&nbsp;<?= $customerCar['Customer']['tel']?></td>
						
                    </tr>
                   
                   
                    <tr>
                        <td><strong> &nbsp;Se rendre &agrave; :</strong> &nbsp;<?php if(isset($customerCar['Supplier']['name'])) { echo $customerCar['Supplier']['name'];}?></td>
                        <td> </td>
						
                    </tr>
                    
                    
                    <tr>
                        <td><strong>&nbsp;Moyen de transport : </strong>&nbsp;<?= $customerCar['Car']['Carmodel']['name'] ?> </td>
                        <td><strong>&nbsp;Matricule :</strong> &nbsp;<?= $customerCar['Car']['immatr_def'] ?></td>
						
                    </tr>
					
                  
                    
                    <tr>
                        <td><strong>&nbsp;Motif :</strong></td>
                        <td> </td>
						<td></td>
                    </tr>
                  
                   
                
                    
                </table>
            </div>
			<div class='all_date'>
				<?php 
				$year=date("Y");
				$month=date("m");
				
				$nb_jour = date('t',mktime(0, 0, 0, $month, 1, $year));
                $k=1;
				?>
					<table >
					<?php for($i=1; $i<=4; $i++){?>
					<tr>					
						<?php for($j=1; $j<=3; $j++){
						if ($k <= $nb_jour){  ?>
				
				<td style='width:230px; padding:40px 10px; border: 1px solid #000;'><?php  echo sprintf("%02d", $k).'/'.$month.'/'.$year; $k++;?></td>
				
				
				<?php 
				
				}
				}?>
				
				</tr>
				<?php }?>
				</table>
				
				
				<div id="footer">
			<table >
			<tr>
			<td class='date_recep'></td>
			<td class="resp"></td>
			</tr>
			</table>
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
							Telephone : <?= $company['Company']['phone'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="first">
                           <?= $company['Company']['adress'] ?>   
                        </td>
                        <td class="second">
                           Mobile : <?= $company['Company']['mobile'] ?> 
                        </td>
                    </tr>
                  
                </table>
                <?php }?>
				
            </div>
			<p id='copyright'>Logiciel : UtranX | www.cafyb.com</p>
				
				
				<table >
					<?php for($i=5; $i<=11; $i++){?>
					<tr>					
						<?php for($j=1; $j<=3; $j++){
						if ($k <= $nb_jour){  ?>
				
				<td style='width:230px; padding:40px 10px; border: 1px solid #000;'><?php  echo sprintf("%02d", $k).'/'.$month.'/'.$year; $k++;?></td>
				
				
				<?php 
				
				}
				}?>
				
				</tr>
				<?php }?>
				</table>
				
				
				<div id="footer">
			<table >
			<tr>
			<td class='date_recep'><strong>Re&ccedil;u le : </strong></td>
			<td class="resp"><strong><?php if(!empty($signature_mission_order)) {echo $signature_mission_order; } else {echo 'Le responsable logistique';}?>  </strong></td>
			</tr>
			</table>
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
							Telephone : <?= $company['Company']['phone'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="first">
                           <?= $company['Company']['adress'] ?>   
                        </td>
                        <td class="second">
                           Mobile : <?= $company['Company']['mobile'] ?> 
                        </td>
                    </tr>
                  
                </table>
                <?php }?>
				
            </div>
			<p id='copyright'>Logiciel : UtranX | www.cafyb.com</p>
				
			</div>
            
            
			
        </div>
        
    </body>
</html>