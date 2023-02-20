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
                padding-right: 40px;
                padding-left:40px;
                
                width:100px;
                height:30px;
            }
               .td_tab {
                padding-right: 40px;
                padding-left:80px;
                
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
           <div class="title">Consommation carburant par parc</div>
        </div>
     
        <div class="box-body">
            <div style="clear: both"></div>
            

                 <table class="table table-bordered cars">
        <thead>
        <tr>
            
            <th class="titre_tab"><?= __('Month') ?></th>
            <th class="titre_tab"><?= __('Cars Nbr') ?></th>
           
            <th class="titre_tab"><?= __('Km travled') ?></th>
            
            
        </tr>
        </thead>
              



         <tbody>
       <?php
            foreach ($parcs as $key => $value) {
                if ($results) {
                    foreach ($results as $result) {
                        if ($result['parcs'] == $key) {
                            echo "<tr style='width: auto;'>" .
                            "<td colspan='10' style='background-color: #10c469 !important;font-weight:bold;font-size:13px;height:20px;padding-left:5px;color:#fff'>"
                            . $value . "</td></tr>";
                            $totalcostTank=0;
                            for ($i = 1; $i <= 6; $i++) {
                              
                                if (isset($result[$i]['fuelid']) && $result[$i]['fuelid'] == $i) {
                                   
                                    $totalcostTank=$totalcostTank+$result[$i]['costTank'];
                                    
                                    echo "<tr><td class='td_tab'>" . $result[$i]['fuels'] . "</td>";
                                    
                                    echo "<td class='td_tab'>" . number_format($result[$i]['sumTank'], 2, ",", ".") ."</td>";
                                    echo "<td class='td_tab'>" . number_format($result[$i]['costTank'], 2, ",", ".") . "</td></tr>";
                                }
                            } ?>
                           <tr style='width: auto;'> <td class='td_tab' colspan='2' style='background-color: #F9F9F9 !important;font-weight:bold;font-size:13px;height:20px;padding-left:5px;color:#000;float:left; '> <?php echo "<span style='text-align:left'>".__('Total Cost tank  ')."</span></td>" ."<td class='td_tab'><span>".$totalcostTank."</span></td>"; ?></tr>
                          <?php  
                           
                        }
                    }
                }
            }
            ?>
        </tbody>
       
    </table>
         
          
        </div>
           <div id="footer">
              <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
            </div>
    </body>
</html>