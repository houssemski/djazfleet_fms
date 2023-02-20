<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));


header('Content-Type: application/vnd.ms-excel');
$filename = 'Ateliers_'.date('d_m_Y');
header("Content-Disposition: attachment; filename=\"$filename.xls\"");

echo "
<html>
<head>
 <meta charset='UTF-8'> 
<style>
.datagrid table { border-collapse: collapse; text-align: left; width: 100%; } 
.datagrid {font: normal 12px/150% Arial, Helvetica, sans-serif; background: #fff; overflow: hidden; border: 1px solid #006699; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; }
.datagrid table td, .datagrid table th { padding: 3px 10px; }
.datagrid table td table td{border: 1px solid #006699; }
.datagrid table thead th {background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #006699), color-stop(1, #00557F) );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#006699', endColorstr='#00557F');background-color:#006699; color:#FFFFFF; font-size: 15px; font-weight: bold;} 
.datagrid table thead th:first-child { border: none; }
.datagrid table tbody tr { border: 1px solid #006699 }
</style>
</head>
<body>
<div class='datagrid'>";


echo "<table class='table table-striped table-bordered' style='table-layout: fixed;' >
             <thead style='width: auto'>
                       <th>Véhicule</th>
                        <th>Mecanicien</th>
                        <th>Atelier</th>
                        <th class='dtm'>Date entrée atelier</th>
                        <th class='dtm'>Date sortie atelier</th>
                        </thead>
                        <tbody>";

if(!empty($results)){
    $allDiffDays = 0;
    $carId = $results[0]['car']['id'];
    $carName = $results[0]['car']['immatr_def'] .' - '. $results[0]['carmodels']['name'];
    foreach ($results as $result){
        if($carId == $result['car']['id']){
            $firstDate  = new DateTime($result['event']['workshop_entry_date']);
            $secondDate = new DateTime($result['event']['workshop_exit_date']);
            $interval = $firstDate->diff($secondDate);
            $diffDays = $interval->days ;
            $allDiffDays = $allDiffDays + $diffDays;
            ?>
            <tr>
                <td><?= $result['car']['immatr_def'] .' - '. $result['carmodels']['name']?></td>
                <td><?= $result['customers']['first_name'] .' - '.$result['customers']['last_name'] ?></td>
                <td><?= $result['workshops']['name']?></td>
                <td><?= $this->Time->format($result['event']['workshop_entry_date'], '%d-%m-%Y')?></td>

                <td><?= $this->Time->format($result['event']['workshop_exit_date'], '%d-%m-%Y')?></td>

            </tr>

        <?php }else {
            echo "<tr style='width: auto;'>" .
                "<td colspan='5' style='border: 1px solid rgba(16, 196, 105, 0.1) !important; background-color: rgba(16, 196, 105, 0.15) !important; color: #10c469 !important;font-weight:bold; text-align: center'>"
                .$carName .' '.  __('total downtime') .' ' . $allDiffDays . ' '.__('Days')."</td></tr>";
            $carId = $result['car']['id'];
            $carName = $result['car']['immatr_def'] .' - '. $result['carmodels']['name'];
            $allDiffDays = 0;

            $firstDate  = new DateTime($result['event']['workshop_entry_date']);
            $secondDate = new DateTime($result['event']['workshop_exit_date']);
            $interval = $firstDate->diff($secondDate);
            $diffDays = $interval->days ;
            $allDiffDays = $allDiffDays + $diffDays;
            ?>
            <tr>
                <td><?= $result['car']['immatr_def'] .' - '. $result['carmodels']['name']?></td>
                <td><?= $result['customers']['first_name'] .' - '.$result['customers']['last_name'] ?></td>
                <td><?= $result['workshops']['name']?></td>
                <td><?= $this->Time->format($result['event']['workshop_entry_date'], '%d-%m-%Y')?></td>

                <td><?= $this->Time->format($result['event']['workshop_exit_date'], '%d-%m-%Y')?></td>

            </tr>


        <?php         }

    }
    echo "<tr style='width: auto;'>" .
        "<td colspan='5' style='border: 1px solid rgba(16, 196, 105, 0.1) !important; background-color: rgba(16, 196, 105, 0.15) !important; color: #10c469 !important;font-weight:bold; text-align: center'>"
        .$carName .' '.  __('total downtime') .' ' . $allDiffDays . ' '.__('Days')."</td></tr>";
}





echo "  </tbody>
        </table>";

echo "</div></body></html>";

$phpExcel = new PHPExcel();
$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
$objWriter->save("php://output");
exit;







