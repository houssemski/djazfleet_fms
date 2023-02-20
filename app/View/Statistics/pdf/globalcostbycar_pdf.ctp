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
                margin-left: 100px;
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
           <div class="title">Cout global des vehicules</div>
        </div>
     
        <div class="box-body">
            <div style="clear: both"></div>
            

                 <table class="table table-bordered cars">
        <thead>
        <tr>
            
            <th class="titre_tab"><?=  __('Cars'); ?></th>
            <th class="titre_tab"><?=  __('Cost'); ?></th>
            
            
            
        </tr>
        </thead>
              



         <tbody>

                      <?php 
             if (!empty($car_selected)) {
              foreach($car_selected as $key => $value){
                 echo "<tr style='width: auto'><td class='td_tab'>" .  $value . "</td>";
                     $found = false;
                     foreach ($results as $result){
                         if($result[0] == $key){
                             echo "<td class='td_tab'>" . $result[1] . "</td>";
                             $found = true;
                         }
                     }
                     if(!$found){
                             echo "<td class='td_tab'>0</td>";
                         }
                echo "</tr>";
             }

} else {
             foreach($cars as $key => $value){
                 echo "<tr style='width: auto'><td class='td_tab'>" .  $value . "</td>";
                     $found = false;
                     foreach ($results as $result){
                         if($result[0] == $key){
                             echo "<td  class='td_tab'>" . $result[1] . "</td>";
                             $found = true;
                         }
                     }
                     if(!$found){
                             echo "<td class='td_tab'>0</td>";
                         }
                echo "</tr>";
             }

             }
            ?>
        
            </tr>
      
        </tbody>
       
    </table>
         
          
        </div>
           <div id="footer">
              <p class='copyright'>Logiciel : UtranX | www.cafyb.com</p>
            </div>
    </body>
</html>