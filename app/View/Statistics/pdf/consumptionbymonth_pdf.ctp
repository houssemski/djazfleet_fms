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
                padding-right:auto;
                padding-left:auto;
                
                width:78px;
                height:30px;
            }
               .td_tab {
                padding-right: auto;
                padding-left:5px;
                
                width:78px;
                height:30px;
            }
            .table-bordered {
                margin-left: 10px;
                margin-right: 10px;
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
           <div class="title">Liste des v�hicules par parc et fournisseur</div>
        </div>
     
        <div class="box-body">
            <div style="clear: both"></div>
            

                 <table class="table table-bordered cars">
        <thead>
        <tr>
            
            
            <th class="titre_tab"><?= __('Month') ?></th>
            <th class="titre_tab"><?= __('Coupons Nbr') ?></th>
            <th class="titre_tab"><?= __('Liter/Coupon') ?></th>
            <th class="titre_tab"><?= __('Total') ?></th>
            <th class="titre_tab"><?= __('Coupon price') ?></th>
            <th class="titre_tab"><?= __('Total') ?></th>
            <th class="titre_tab"><?= __('Departure km') ?></th>
            <th class="titre_tab"><?= __('Arrival km') ?></th>
            <th class="titre_tab"><?= __('Kms / Month') ?></th>
            <th class="titre_tab"><?= __('Cons / 100kms') ?></th>
            
        </tr>
        </thead>
              



        <tbody>
         <?php
            foreach ($cars as $key => $value) {
                if ($results) {
                    foreach ($results as $result) {
                         
                    
                        if ($result['car'] == $key) {
                        
                            echo "<tr style='width: auto;'>" .
                                "<td colspan='10' style='background-color: #10c469 !important;font-weight:bold;font-size:13px;height:20px;padding-left:5px;color:#fff'>"
                                . $value . "</td></tr>";
                             
                            for ($i = 1; $i <= 12; $i++) {
                            
                                switch ($i) {
                                    case 1 :
                                        $label = __("January");
                                        break;
                                    case 2 :
                                        $label = __("February");
                                        break;
                                    case 3 :
                                        $label = __("March");
                                        break;
                                    case 4 :
                                        $label = __("April");
                                        break;
                                    case 5 :
                                        $label = __("May");
                                        break;
                                    case 6 :
                                        $label = __("June");
                                        break;
                                    case 7 :
                                        $label = __("July");
                                        break;
                                    case 8 :
                                        $label = __("August");
                                        break;
                                    case 9 :
                                        $label = __("September");
                                        break;
                                    case 10 :
                                        $label = __("October");
                                        break;
                                    case 11 :
                                        $label = __("November");
                                        break;
                                    case 12 :
                                        $label = __("December");
                                        break;
                                }
                                if (isset($result[$i]['month']) && $result[$i]['month'] == $i) {
                                    $litersByCoupon = $coupon_price / $result[$i]['price'];
                                    $totalLiters = $result[$i]['coupons_number'] * $litersByCoupon;
                                    $totalPrice = $coupon_price * $result[$i]['coupons_number'];
                                    $diffKm = $result[$i]['arrivalKm'] - $result[$i]['departureKm'];
                                    if($diffKm <= 0) {
                                        $diffKm = 0;
                                        $consumptionPer100km = 0;
                                    }else{
                                        $consumptionPer100km = ($totalLiters * 100) / $diffKm;
                                    }
                                   
                                    echo "<tr><td class='td_tab'>" . $label . "</td>";
                                    echo "<td class='td_tab'>" . $result[$i]['coupons_number'] . "</td>";
                                    echo "<td class='td_tab'>" . number_format($litersByCoupon, 2, ",", ".") . "</td>";
                                    echo "<td class='td_tab'>" . number_format($totalLiters, 2, ",", ".") . "</td>";
                                    echo "<td class='td_tab'>" . number_format($coupon_price, 2, ",", ".") . "</td>";
                                    echo "<td class='td_tab'>" . number_format($totalPrice, 2, ",", ".") . "</td>";
                                    echo "<td class='td_tab'>" . number_format($result[$i]['departureKm'], 0, ",", ".") ."</td>";
                                    echo "<td class='td_tab'>" . number_format($result[$i]['arrivalKm'], 0, ",", ".") . "</td>";
                                    echo "<td class='td_tab'>" . number_format($diffKm, 0, ",", ".") . "</td>";
                                    echo "<td class='td_tab'>" . number_format($consumptionPer100km, 2, ",", ".") . "</td></tr>";
                                    
                                }
                                
                            }
                          
                        }
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