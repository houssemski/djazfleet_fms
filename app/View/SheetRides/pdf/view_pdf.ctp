

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style type="text/css">
            <?php
            if (Configure::read('utranx_ade') != '1'){ ?>
            @page { margin: 95px 0; }
            #header { position: fixed; left: 0; top: -95px; right: 0; height: 110px; /*border-bottom: 1px solid #000;*/}
            <?php }else{ ?>
            @page { margin: 0px 0; }
            <?php } ?>
            #header table{width:100%;}
            #header td.logo{vertical-align: top;padding-left:25px;padding-top:15px;}
            #header td.company{vertical-align: top; font-weight: bold; font-size: 16px;text-align: center;padding-right:50px;}
            #header td.company span{display: block; font-size: 22px; padding-bottom: 10px;padding-top: 20px;}
            .date{padding-top: 5px; text-align:right;padding-right:25px;}
            #footer { position: fixed; left: 0; bottom: -95px; right: 0; height: 125px;  }
			.copyright{font-size:10px; text-align:center;}
            .box-body{padding: 0px 30px 0px 30px; margin: 0; width: 100%;}


            .title{font-weight: bold; font-size: 24px; 
                  text-align: center; 
                  padding-bottom: 40px;
                 /* border-bottom: 1px solid #000;*/
                  width: 500px;
                margin: 0 auto 10px;
                
            }


            .customer table {
               / border-collapse: collapse;
                width: 100%;
                font-size: 15px;
				padding-top: 25px;
				margin-left: 50px;
				margin-right: 50px;
            }


.table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
    border: 0px solid #000;
}
	.table-bordered{
	width:100%;
	border-color:#000;
	border:1px solid #000;
	border-collapse: collapse;
	}	
	.table-bordered td{
	border-left:1px solid #000 !important;
	border-top:1px solid #000 !important;
	}
	.table-bordered th{
	border-left:1px solid #000 !important;
	border-top:1px solid #000 !important;
	}	



            .customer tr td:first-child{ 
                width: 250px !important; 
                
                padding-bottom: 5px;
                
            }


            table.bottom td{padding-top: 5px; font-size: 18px;}
           table.footer{width: 100%; font-size: 12px; margin-top: 20px;padding-top: 10px;border-top: 1px solid #000; }
            table.footer td.first{width: 50%; text-align: left; padding-left:25px; }
            table.footer td.second{width: 50%; text-align: left; padding-left:25px;}
            table.conditions td{
                border: 1px solid grey;
            }
            table.conditions td{
                vertical-align: top;
                padding: 5px 5px 5px 10px;
                line-height: 19px;
            }
            table.conditions_bottom td.first{width: 420px}
            table.conditions_bottom td{padding-top: 5px}
            .note span{display: block;text-decoration: underline;padding-bottom: 5px;}




			.ride{
			width:45%;
			display:inline-block;
			
			}
			.client{
			width:51%;
			display:inline-block;
			margin-left:3%;
			}
			.client1{
			width:99%;
			display:inline-block;
			//margin-left:3%;
			}
			.bill {	
position: relative;
border: 1px solid #000;
padding-top: 15px;
padding-left: 10px;
padding-right: 10px;
}

.bill h3 {
position: absolute;
top: -28px;
margin: 0;
padding: 0 10px;
background: #fff;	
	
	
}
        </style>
    </head>
    <body>
        <div id="header">
            <?php
            if (Configure::read('utranx_ade')){
                echo $this->element('pdf/ade-header');
            }else{ if($entete_pdf=='1') {?>
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
                    <td style="text-align:right;" class="date"><?= date("d/m/Y") ?></td>
                </tr>
            </table>
            <?php }} ?>
        </div>
        <div class="box-body">
            
            <div class="date"> </div>
            <div style="clear: both"></div>
            <div class="title">Fiche trajet : <?= $sheetRide['SheetRide']['reference']?>

            </div>
            <div  class="title">
                <?php echo $this->Html->image("barcode/".$data_to_encode.".png"); ?>
                </div>

			         <div>
     

        <div style="clear:both;"></div>
            </div>
            
              <div style="margin-top: 45px;">
        <div class="ride">
        <div class="bill">
        <h3><?= __('Car') ?> </h3>
        <p><?= __('Immatricule') ?>  :  <?=  $sheetRide['Car']['immatr_def'] ?></p>
        <p><?= __('Mark') ?>  :  <?=  $sheetRide['Mark']['name']  ?></p>
        
        
        </div>
        </div>
        <div class="client">
        <div class="bill">
        
        <h3><?= __('Conducteur') ?> </h3>
        <p><?= __('Name') ?>  :  <?=  $sheetRide['Customer']['last_name'] .' '. $sheetRide['Customer']['first_name']?></p>
        
        <p><?= __('Tel.') ?>  :  <?=  $sheetRide['Customer']['tel'] ?></p>
        
        </div>
        </div>
        <div style="clear:both;"></div>
            </div>
        <br/>
		<?php if(!empty($marchandises)){?>
        <div >
        <h3><?= __('Marchandises') ?> </h3>
        <table class="table table-bordered" border="1">
            <thead>
	            <tr>
            
             
             <th><?php echo __('Name'); ?></th>
			<th><?php echo  __('Type'); ?></th>
			<th><?php echo  __('Unit'); ?></th>
			<th><?php echo  __('Quantity'); ?></th>
				</tr>
			</thead>
	<tbody>
    <?php  foreach($marchandises as $marchandise) { ;?>
    <tr>
    <td style='text-align:center;'><?=  $marchandise['Marchandise']['name'] ?></td>
    <td style='text-align:center;'><?php if(!empty ($marchandise['Marchandise']['marchandise_type_id'])) { echo $marchandise['Marchandise']['MarchandiseType']['name'];} ?></td>
    <td style='text-align:center;'><?php if(!empty ($marchandise['Marchandise']['marchandise_unit_id'])) { echo $marchandise['Marchandise']['MarchandiseUnit']['name']; }?></td>
    <td style='text-align:center;'><?=  $marchandise['MarchandisesSheetRide']['quantity'] ?></td>
    
    </tr>
    <?php } ?>
    </tbody>
        </table>
        </div>
		<?php }?>
        <br/>
		<?php if(!empty($rides)){?>
		
		   <div >
        <h3><?= __('Rides') ?> </h3>
        <table class="table table-bordered" >
            <thead>
	            <tr>
            
             
             <th><?php echo __('Ride'); ?></th>
			 <th><?php echo __('Transportation'); ?></th>
			<th><?php echo  __('Departure date'); ?></th>
			<th><?php echo  __('Arrival date'); ?></th>
			
				</tr>
			</thead>
	<tbody>
    <?php  foreach($rides as $ride) { ;?>
    <tr>
        <?php if($ride['SheetRideDetailRides']['type_ride'] == 1) {  ?>
            <td style='text-align:center;'><?=  $ride['DepartureDestination']['name'].'-'.$ride['ArrivalDestination']['name'] ?></td>
        <?php }else { ?>
            <td style='text-align:center;'><?=  $ride['Departure']['name'].'-'.$ride['Arrival']['name'] ?></td>
        <?php } ?>

	<td style='text-align:center;'><?=  $ride['CarType']['name'] ?></td>
	<td style='text-align:center;'><?php echo h($this->Time->format($ride['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y')); ?>&nbsp;</td>
    <td style='text-align:center;'><?php echo h($this->Time->format($ride['SheetRideDetailRides']['real_end_date'], '%d-%m-%Y')); ?>&nbsp;</td>
	
    
    </tr>
    <?php } ?>
    </tbody>
        </table>
        </div>
			
		
		<?php }?>
           
			
				
			
				
		
				
			
          	
			
            
        </div>
        <div id="footer">
                <table class="footer">
                    <tr>
                        <td class="first">
                <?= $company['LegalForm']['name'] ?>
                            <?php if(!empty($company['Company']['social_capital'])){ ?>
                            au Capital de <?=
                                number_format($company['Company']['social_capital'],2,",",".")." ".$this->Session->read("currency")
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
				<p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
            </div>
    </body>
</html>


