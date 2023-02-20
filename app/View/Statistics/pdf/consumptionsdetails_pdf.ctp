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
                padding-right: auto;
                padding-left:5px;
                
                width:100px;
                height:30px;
            }
               .td_tab {
                padding-right: auto;
                padding-left:5px;
                
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
           <div class="title">Detail consommation </div>
        </div>
     
        <div class="box-body">
            <div style="clear: both"></div>
            

                 <table class="table table-bordered cars" width="92%">
        <thead>
        <tr>
            <th class="titre_tab"><?= __('N�') ?></th>
            <th class="titre_tab"><?= __('SERIAL N�') ?></th>
            <th class="titre_tab"><?= __('RELEASE DATE') ?></th>
            <th class="titre_tab"><?= __('INDICATION KM') ?></th>
            <th class="titre_tab"><?= __('DRIVER') ?></th>
            <th class="titre_tab"><?= __('COUPONS NUMBER') ?></th>
            
            
        </tr>
        </thead>
              



         <tbody>

              <?php
            if(!empty($results)){
                $indKm = 0;
                $couponNbr = 0;
                $serialNumbers = array();
                $releaseDates = array();
                $customers = array();
                $i=0;
                $j=0;
                $currentCar = $results[0]['car']['id'];
                foreach ($results as $result) {
                    $i++;
                    if($result['car']['id'] == $currentCar)
                    {
                        $car_name = $result['carmodels']['name'] . " " . $result['car']['immatr_def'];
                        if($result['sheet_rides']['km_departure'] > 0){
                            $indKm += $result['sheet_rides']['km_arrival'] - $result['sheet_rides']['km_departure'];
                        }
                        $couponNbr += $result['consumptions']['nb_coupon'];
                        $numbers = explode(";", $result['coupons']['serial_number']);
                        for($n=0; $n<count($numbers); $n++){
                            if(!empty($numbers)) {
                                $serialNumbers[] = trim($numbers[$n]);
                                $releaseDates[] = $result['sheet_rides']['real_start_date'];
                            }else{
                                $serialNumbers[] = "";
                                $releaseDates[] = "";
                            }

                        }
                        $customers[] = $result['customers']['first_name']." ".$result['customers']['last_name'];
                    }else
                    {
                        $j++;
                        echo "<tr style='width: auto;'>" .
                            "<td colspan='6' style='background-color: #10c469 !important; color: #fff;font-size:13px;height:20px;padding-left:5px;font-weight:bold;'>"
                            . $car_name . "</td></tr>";
                        echo "<tr><td class='td_tab'>" . $j . "</td>";
                        echo "<td><table>";
                        foreach($serialNumbers as $serialNumber){
                            echo "<tr><td class='td_tab'>".$serialNumber."</td></tr>";
                        }
                        echo "</table></td>";
                        echo "<td><table>";
                        foreach($releaseDates as $releaseDate){
                            echo "<tr><td class='td_tab'>".$this->Time->format($releaseDate, '%d-%m-%Y %H:%M')."</td></tr>";
                        }
                        echo "</table></td>";
                        echo "<td class='td_tab'>" . number_format($indKm,0,",",".")  . "</td>";
                        echo "<td ><table>";
                        $currentCustomer = null;
                        foreach($customers as $customer){
                            if($customer != $currentCustomer){
                                echo "<tr><td class='td_tab'>".$customer."</td></tr>";
                            }
                            $currentCustomer = $customer;
                        }
                        echo "</table></td>";
                        echo "<td class='td_tab'>" . number_format($couponNbr,0,",",".") . "</td></tr>";
                        // Next item
                        $couponNbr = 0;
                        $indKm = 0;
                        $serialNumbers = array();
                        $releaseDates = array();
                        $customers = array();
                        $car_name = $result['carmodels']['name'] . " " . $result['car']['immatr_def'];
                        if($result['sheet_rides']['km_departure'] > 0){
                            $indKm += $result['sheet_rides']['km_arrival'] - $result['sheet_rides']['km_departure'];
                        }
                        $couponNbr += $result['consumptions']['nb_coupon'];
                        $numbers = explode(";", $result['coupons']['serial_number']);
                        for($n=0; $n<count($numbers); $n++){
                            if(!empty($numbers)) {
                                $serialNumbers[] = trim($numbers[$n]);
                                $releaseDates[] = $result['sheet_rides']['real_start_date'];
                            }else{
                                $serialNumbers[] = "";
                                $releaseDates[] = "";
                            }

                        }
                        $customers[] = $result['customers']['first_name']." ".$result['customers']['last_name'];
                        $currentCar = $result['car']['id'];
                    }
                    if($i == count($results))
                    {
                        $j++;
                        echo "<tr style='width: auto;'>" .
                            "<td colspan='6' style='background-color: #10c469 !important; color: #fff;font-size:13px;height:20px;padding-left:5px;font-weight: bold;'>"
                            . $result['carmodels']['name'] . " " . $result['car']['immatr_def'] . "</td></tr>";
                        echo "<tr><td class='td_tab'>" . $j . "</td>";
                       
                        echo "<td><table>";
                        foreach($serialNumbers as $serialNumber){
                            echo "<tr><td class='td_tab'>".$serialNumber."</td></tr>";
                        }
                        echo "</table></td>";
                        echo "<td><table>";
                        foreach($releaseDates as $releaseDate){
                            echo "<tr><td class='td_tab'>".$this->Time->format($releaseDate, '%d-%m-%Y %H:%M')."</td></tr>";
                        }
                        echo "</table></td>";
                        echo "<td class='td_tab'>" . number_format($indKm,0,",",".")  . "</td>";
                        echo "<td><table>";
                        $currentCustomer = "";
                        foreach($customers as $customer){
                            if($customer != $currentCustomer){
                                echo "<tr><td class='td_tab'>".$customer."</td></tr>";
                            }
                            $currentCustomer = $customer;
                        }
                        echo "</table></td>";
                        echo "<td class='td_tab'>" . number_format($couponNbr,0,",",".") . "</td></tr>";
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