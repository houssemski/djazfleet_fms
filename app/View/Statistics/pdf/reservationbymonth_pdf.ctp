<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style type="text/css">
            @page { margin: 95px 0px  ; }
            #footer { position: fixed; left: 0px; bottom: -85px; right: 0px; height: 25px;  }
			.copyright{font-size:10px; text-align:center;border-top: 1.5px solid #000; padding-top:5px; padding-bottom:5px;}
            .box-body{padding: 0px; margin-top: 100px; width: 100%;}
            #header { position: fixed; left: 0px; top: -120px; right: 0px; height: 0px; text-align: center; 
					
			}
            .title{font-weight: bold; font-size: 24px; 
                  text-align: center; 
                  padding-top: 10px;
                  border-bottom: 1px solid #000;
                  width: 230px;
                  margin: 0 auto;
                  margin-bottom: 30px;
                  font-style: italic;
                  padding-bottom:20px;
            }
            
           
           
           
            
            
            .titre_tab {
                padding-right: 5px;
                padding-left:5px;
                font-size: 11px;
                width:80px;
                height:30px;
            }
               .td_tab {
                padding-right: 0px;
                padding-left:5px;
                font-size: 11.5px;
                width:80px;
                height:40px;
            }
            .table-bordered {
                margin-left: 50px;
                margin-right: 5px;
               
}
            .table {
    font-size: 14px;
}
            table {
                padding-top:20px;
    border-spacing: 0px;
    border-collapse: collapse;
}
            .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
   
}
        </style>
    </head>
    <body>
         <div id="header">
         <table style='border-bottom: 3px solid #000;'>
		<tr>
            <td style='width:450px; margin-left:50px;'>
                <div  style=' margin-left:50px;  font-size: 15px; width:200px; font-weight:bold; margin-bottom: 20px; margin-top: 20px;' ><?= Configure::read("nameCompany") ?></div>
               
                        
                        <div style=' margin-left:50px;  font-size: 15px; width:200px; font-size: 11px;'>
                             <?= $company['Company']['adress'] ?>
                        </div>
                        <div style=' margin-left:50px;  font-size: 15px; width:200px; font-size: 11px;'>
                            Tél. : <?= $company['Company']['phone'] ?>
                        </div>
                        <div style=' margin-left:50px;  font-size: 15px; width:200px; font-size: 11px; margin-bottom: 5px;'>
                            Fax : <?= $company['Company']['fax'] ?>
                        </div>
                   
                </td>
			<td style='width:360px; text-align: right; font-size: 11.5px;'>  

                        <div style='  margin-right:20px; font-size: 15px;  font-size:11px; margin-top:55px;'>
                         RC :  <?= $company['Company']['rc'] ?>
                        </div>

                        <div style=' margin-right:20px;  font-size: 15px;  font-size: 11px;'>
                            AI : <?= $company['Company']['ai'] ?> - IF : <?= $company['Company']['nif'] ?>
                        </div>

                        <div style=' margin-right:20px;  font-size: 15px;  font-size: 11px; margin-bottom: 5px;'>
                            CB : <?= $company['Company']['cb'] ?> RIB : <?= $company['Company']['rib'] ?>
                        </div>
                 </td>
			
		</tr>
		</table>
		
		
			<table  style='margin-top:-20px; margin-bottom:20px;'>
		<tr>
            <td style='height: 20px; width:450px; margin-left:50px;'>
  
                        <div style=' margin-left:50px;  font-size: 15px; font-size: 15px; width:200px; font-weight:bold; '>
                            Facture: 
                        </div>
                   
                </td>
			<td style='width:360px; text-align: right; font-size: 11.5px; font-weight:bold;'>  
                        <div style=' margin-right:20px;  font-size: 15px;  font-size: 11px; '>
                            Le : <?= date("d/m/Y") ?>
                        </div>
                 </td>
			
		</tr>
		</table>
		<div style="clear: both"></div>
			
		
			<?php if (!empty($group_name)) {?> 
			
            <div  style="font-size: 13px; margin-left:450px;   font-weight:bold; margin-bottom:40px; margin-top:15px;"><?=__('DOIT:')?> <?= $group_name['Group']['name'] ?></div>
          <?php } else if (!empty($customer_name)) { ?>

          <div  style="font-size: 13px; margin-left:450px;   font-weight:bold; "><?=__('DOIT:')?> <?= $customer_name['Customer']['first_name'].' '. $customer_name['Customer']['last_name']?></div>
        <?php } ?>

</div>
     
        <div class="box-body">
            <div style="clear: both"></div>
			
		
			
			
            
           

                 <table class="table table-bordered" >
        <thead >
        <tr style='border: 1px solid #000;' >
            
            
            <th class="titre_tab" style='border: 1px solid #000; border-right: 1px solid #ddd;'><?= __("Conductor") ?></th>
            <th class="titre_tab" style='border: 1px solid #ddd; border-top: 1px solid #000;border-bottom: 1px solid #000;'><?= __('Car') ?></th>
            <th class="titre_tab" style='border: 1px solid #ddd; border-top: 1px solid #000;border-bottom: 1px solid #000;'><?= __('Immatriculation') ?></th>
            <th class="titre_tab" style='border: 1px solid #ddd; border-top: 1px solid #000;border-bottom: 1px solid #000;'><?= __('Duration') ?></th>
            
            <th class="titre_tab" style='border: 1px solid #ddd; border-top: 1px solid #000;border-bottom: 1px solid #000;'><?= __('Number days') ?></th>
            <th class="titre_tab" style='border: 1px solid #ddd; border-top: 1px solid #000;border-bottom: 1px solid #000;'><?= __('PU/JR') ?></th>
            <th class="titre_tab" style='border: 1px solid #000; border-left: 1px solid #ddd;'><?= __('Amount') ?></th>
            
            
        </tr>
        </thead>
              



        <tbody style="min-height: 100px;">
           <?php
           $sumCost=0;
            foreach ($results as $result ) {?>
            <tr>
                
                   

                    <td class="td_tab" style='border: 1px solid #000; border-right: 1px solid #ddd; border-bottom: 1px solid #000;'><?php echo h($result['customers']['first_name'].' '.$result['customers']['last_name']); ?>&nbsp;</td>
                    <td class="td_tab" style='border: 1px solid #ddd; border-bottom: 1px solid #000;'><?php echo h($result['marks']['name'].' '.$result['carmodels']['name']); ?>&nbsp;</td>
                    <td class="td_tab" style='border: 1px solid #ddd; border-bottom: 1px solid #000;'><?php echo h($result['car']['immatr_def']); ?>&nbsp;</td>
                    <td class="td_tab" style='border: 1px solid #ddd; border-bottom: 1px solid #000;'> <?php echo h($this->Time->format($result['customer_car']['start'], '%d-%m-%Y'))?>&nbsp;<br/>
                     <?php echo h($this->Time->format($result['customer_car']['end'], '%d-%m-%Y'))?>&nbsp;</td>
                    <td class="td_tab" style='border: 1px solid #ddd; border-bottom: 1px solid #000;'><?php echo h($result[0]['diff_date']); ?>&nbsp;</td>
                    <td class="td_tab" style='border: 1px solid #ddd; border-bottom: 1px solid #000;'><?php echo h($result['customer_car']['cost_day']); ?>&nbsp;</td>
                    <td class="td_tab" style='border: 1px solid #000; border-left: 1px solid #ddd; border-bottom: 1px solid #000;'><?php echo h($result['customer_car']['cost']); ?>&nbsp;</td>
                   <?php  $sumCost=$sumCost+$result['customer_car']['cost']; ?>
            </tr>


         <?php   }

            ?>


      
        </tbody>
       
    </table>
         
         	<table  >
		<tr>
            <td style='height: 20px; width:300px; '>
  
                        <div style='  margin-left:550px; font-size: 15px; font-size: 15px;  font-weight:bold; '>
                            Net a payer: <span style='align-text:right;'><?php echo number_format($sumCost, 2, ",", "."); ?> </span>
                        </div>
                         
                   
                </td>
			 
                       
                
			
		</tr>
		</table>
        </div>
           <div id="footer">
              <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
            </div>
    </body>
</html>