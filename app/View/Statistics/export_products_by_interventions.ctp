<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));


header('Content-Type: application/vnd.ms-excel');
$filename = 'interventions_'.date('d_m_Y');
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
                        <th> Reference</th>
                        <th>Type de réparation</th>
                        <th>Date de réparation</th>
                        <th>Véhicule</th>
                        <th>Demandeur</th>
                        <th>Structure</th>
                        <th>Fournisseur</th>
                        <th>Produit</th>
                        <th>Prix unitaire</th>
                        <th> Quantité</th>
                        <th> Prix </th>
                        </thead>
                        <tbody>";

                        if(!empty($results)){
                            foreach ($results as $result){ ?>
                                <tr>
                                <td><?= $result['event']['code'];?></td>
                                <td><?= $result['event_types']['name']?></td>
                                <td><?= $this->Time->format($result['event']['intervention_date'], '%d-%m-%Y')?></td>
                                <td><?= $result['car']['immatr_def'] .' - '. $result['carmodels']['name']?></td>
                                <td><?= $result['customers']['first_name'] .' - '.$result['customers']['last_name'] ?></td>
                                <td><?= $result['structures']['name']?></td>
                                <td><?= $result['suppliers']['name']?></td>
                                <td><?= $result['products']['name']?></td>
                                <td><?= number_format($result['event_products']['price']/2, 0, ",", ".")?></td>
                                <td><?= $result['event_products']['quantity'] ?></td>
                                <td><?= number_format($result['event_products']['price'], 0, ",", ".")?></td>
                                </tr>

                           <?php }
                        }





echo "  </tbody>
        </table>";

echo "</div></body></html>";

$phpExcel = new PHPExcel();
$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
$objWriter->save("php://output");
exit;







