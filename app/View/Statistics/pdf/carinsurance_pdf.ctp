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
                padding-right: 30px;
                padding-left:30px;
                
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
           <div class="title">Assurance vehicule</div>
        </div>
     
        <div class="box-body">
            <div style="clear: both"></div>
            

                 <table class="table table-bordered cars">
        <thead>
        <tr>
            
            <th class="titre_tab"><?= __('Assurance number') ?></th>
            <th class="titre_tab"><?= __('Star date') ?></th>
            <th class="titre_tab"><?= __('End date') ?></th>
            <th class="titre_tab"><?= __('Cost') ?></th>
            
            
        </tr>
        </thead>
              



        <tbody>
        <?php
         if(!empty($results)){
                
                $nbAssurance = array ();
                $starDates = array();
                $endDates = array();
                $cost = array();
                $i=0; 
                $j=0;
                $currentCar = $results[0]['car']['id'];
                foreach ($results as $result) {
                    $i++;
                    if($result['car']['id'] == $currentCar)
                    {
                        $car_name = $result['carmodels']['name'] ;
                        
                       if (isset($result['event']['assurance_number']) && !empty($result['event']['assurance_number'])){
                       $nbAssurance[] = $result['event']['assurance_number'];
                       
                        }else $nbAssurance[] ='/';
                        
                        if (isset($result['event']['date']) && !empty($result['event']['date'])){
                        $starDates[] = $result['event']['date'];
                        }else $starDates[] ='/';

                        if (isset($result['event']['next_date']) && !empty($result['event']['next_date'])){
                        $endDates[] = $result['event']['next_date'];
                        }else $endDates[] ='/';
                        if (isset($result['event']['cost']) && !empty($result['event']['cost'])){
                        $cost[] = $result['event']['cost'];
                        } else $cost[] ='/';




                      
                    } else
                    {
                        $j++;
                       // echo "<tr >";
                        echo "<tr style='width: 500px; '>" .
                        "<td colspan='6' style='background-color: #10c469 !important; color: #fff;font-weight:bold;font-size:13px;height:20px;padding-left:5px;'>"
                        . $car_name . "</td></tr>";
                       // echo "</tr>";
                        echo"<tr>";
                       echo "<td><table>";
                        foreach($nbAssurance as $nbAssurance){
                            echo "<tr><td >".$nbAssurance."</td></tr>";
                        }
                        echo "</table></td>";
                        
                        echo "<td><table>";
                        foreach($starDates as $stardate){
                            echo "<tr><td>".$this->Time->format($stardate, '%d-%m-%Y ')."</td></tr>";
                        }
                        echo "</table></td>";
                        echo "<td><table>";
                        foreach($endDates as $enddate){
                            echo "<tr><td>".$this->Time->format($enddate, '%d-%m-%Y ')."</td></tr>";
                        }
                        echo "</table></td>";
                       
                        echo "<td><table>";
                        foreach($cost as $cost){
                            echo "<tr><td>".$cost."</td></tr>";
                        }
                        echo "</table></td>";
                        echo"</tr>";
                        // Next item
                        
                        
                        $nbAssurance = array ();
                        $starDates = array();
                        $endDates = array();
                        $cost = array();
                        
                        $car_name = $result['carmodels']['name'] ;
                        
                        
                        if (isset($result['event']['assurance_number']) && !empty($result['event']['assurance_number'])){
                       $nbAssurance[] = $result['event']['assurance_number'];
                        }else $nbAssurance[] ='/';
                        
                        if (isset($result['event']['date']) && !empty($result['event']['date'])){
                        $starDates[] = $result['event']['date'];
                        }else $starDates[] ='/';

                        if (isset($result['event']['next_date']) && !empty($result['event']['next_date'])){
                        $endDates[] = $result['event']['next_date'];
                        }else $endDates[] ='/';
                        if (isset($result['event']['cost']) && !empty($result['event']['cost'])){
                        $cost[] = $result['event']['cost'];
                        }else $cost[] ='/';
                        $currentCar = $result['car']['id']; 









                    }
                    if($i == count($results))
                    {
                        $j++;
                       // echo "<tr>";
                         echo "<tr style='width: 500px; margin-top: 100px;'>" .
                        "<td colspan='6' style='background-color: #10c469 !important; color: #fff;font-weight:bold;font-size:13px;height:20px;padding-left:5px;'>"
                        . $result['carmodels']['name'] . "</td></tr>";
                    // echo "</tr>";
                        echo "<tr>";
                        echo "<td><table>";
                        foreach($nbAssurance as $nbAssurance){
                            echo "<tr><td>".$nbAssurance."</td></tr>";
                        }
                        echo "</table></td>";
                        
                        echo "<td><table>";
                        foreach($starDates as $stardate){
                            echo "<tr><td>".$this->Time->format($stardate, '%d-%m-%Y ')."</td></tr>";
                        }
                        echo "</table></td>";
                        echo "<td><table>";
                        foreach($endDates as $enddate){
                            echo "<tr><td>".$this->Time->format($enddate, '%d-%m-%Y ')."</td></tr>";
                        }
                        echo "</table></td>";

                        echo "<td><table>";
                        foreach($cost as $cost){
                            echo "<tr><td>".$cost."</td></tr>";
                        }
                        echo "</td></table>";
                        echo "</tr>";


                        
                      
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