<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style type="text/css">
            @page { margin: 95px 0px; }
            #footer { position: fixed; left: 0px; bottom: -95px; right: 0px; height: 25px;  }
			.copyright{font-size:10px; text-align:center;}
            .box-body{padding: 0px; margin: 0; width: 100%;}
            
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
                padding-right: 60px;
                padding-left:60px;
                
                width:100px;
                height:30px;
            }
               .td_tab {
                padding-right: 60px;
                padding-left:100px;
                
                width:100px;
                height:30px;
            }
            .table-bordered {
                margin-left: 30px;
    border: 1px solid #DDD;
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
    border: 1px solid #DDD;
}
        </style>
    </head>
    <body>
         <div id="header">
           <div class="title">Liste des véhicules par parc et fournisseur</div>
        </div>
     
        <div class="box-body">
            <div style="clear: both"></div>
            

                 <table class="table table-bordered cars">
        <thead>
        <tr>
            
            <th class="titre_tab"><?=  __('Cars'); ?></th>
            <th class="titre_tab"><?=  __('Parcs'); ?></th>
            <th class="titre_tab"><?=  __('Suppliers'); ?></th>
            
            
        </tr>
        </thead>
              



                                    <tbody>
        <?php foreach ($cars as $car): ?>
            <tr id="row<?= $car['car']['id'] ?>">
             
                
                <td class="td_tab"><?php echo  h($car['carmodels']['name']);  ?></td>
                
                <td class="td_tab"><?php echo h($car['parcs']['name']); ?>&nbsp;</td>
                <td class="td_tab"><?php echo h($car['suppliers']['name']); ?>&nbsp;</td>
               
                
                
        
            </tr>
        <?php endforeach; ?>
        </tbody>
       
    </table>
         
          
        </div>
           <div id="footer">
              <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
            </div>
    </body>
</html>