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
                  width: 300px;
                  margin: 0 auto;
                  margin-bottom: 30px;
                  font-style: italic;
                  padding-bottom:20px;
            }
            
           
           
           
            
            
            .titre_tab {
                padding-right: 60px;
                padding-left:100px;
                
                width:100px;
                height:30px;
            }
               .td_tab {
                padding-right: 100px;
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
           <div class="title">Co&ucirc;t mensuelle par type d'&eacute;v&egrave;nement</div>
        </div>
     
        <div class="box-body">
            <div style="clear: both"></div>
            

                 <table class="table table-bordered cars" width="92%">
        <thead>
        <tr>
            
            <th class="titre_tab"><?=  __('Month'); ?></th>
            <th class="titre_tab"><?=  __('Cost'); ?></th>
            
            
            
        </tr>
        </thead>
              
 <tbody>
            <?php
            if (empty($type)) {
            foreach ($eventTypes as $key => $value) {
           
             echo "<tr style='width: auto;'>" .
                                    "<td colspan='2' style='background-color: #10c469 !important;font-weight:bold;color:#fff; text-align:center'>"
                                    . $value . "</td></tr>";
                if ($results) {
                    foreach ($results as $result) {
                    
                        if ($result['event_event_types']['event_type_id'] == $key) {
                          
                                    $i=1;
                                    $sum_cost=0;
                              
                                    switch ($result[0]["month"]) {
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
                                    
                                     echo "<tr><td>" . $label . "</td>";
                                     echo "<td class='right'>" . number_format($result[0]["sum_cost"], 0, ",", ".") .
                                            "</td></tr>";                                            
                                }
                        }
                        
                    }




                }

                } else {

                echo "<tr style='width: auto;'>" .
                                    "<td colspan='2' style='background-color: #10c469 !important;font-weight:bold;color:#fff; text-align:center'>"
                                    . $type['EventType']['name'] . "</td></tr>";
                if ($results) {
                    foreach ($results as $result) {
                  
                        if ($result['event_event_types']['event_type_id'] == $type['EventType']['id']) {
                          
                           
                           
                               
                                    $i=1;
                                    $sum_cost=0;
                                
                                    switch ($result[0]["month"]) {
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
                                    
                                     echo "<tr><td>" . $label . "</td>";
                                     echo "<td class='right'>" . number_format($result[0]["sum_cost"], 0, ",", ".") .
                                            "</td></tr>";                                            
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