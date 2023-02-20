<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
$phpExcel = new PHPExcel();
$phpExcel->getActiveSheet()->setTitle('Journal');
$phpExcel->setActiveSheetIndex(0);

$phpExcel->getActiveSheet()->setCellValue('A1', 'Reference');
$phpExcel->getActiveSheet()->setCellValue('B1', 'Date');
$phpExcel->getActiveSheet()->setCellValue('C1', 'Type');
$phpExcel->getActiveSheet()->setCellValue('D1', 'Tiers');
$phpExcel->getActiveSheet()->setCellValue('E1', 'Total HT');
$phpExcel->getActiveSheet()->setCellValue('F1', 'Total TVA');
$phpExcel->getActiveSheet()->setCellValue('G1', 'Total TTC');
$phpExcel->getActiveSheet()->setCellValue('H1', 'Montant impayé');
$i=2;
foreach ($models as $model):
    switch ($model['Bill']['type']) {
        case BillTypesEnum::supplier_order :

            $type = __('Supplier orders');
            break;
        case BillTypesEnum::receipt :

            $type = __("Receipts");

            break;

        case BillTypesEnum::return_supplier :

            $type = __("Return supplier");
            break;
        case BillTypesEnum::purchase_invoice :

            $type = __("Purchase invoice");
            break;

        case BillTypesEnum::credit_note :

            $type = __("Credit note");
            break;

        case BillTypesEnum::delivery_order :

            $type =__("Delivery orders");
            break;

        case BillTypesEnum::return_customer :

            $type = __("Return customer");

            break;

        case BillTypesEnum::entry_order :

            $type = __("Entry order");

            break;

        case BillTypesEnum::exit_order :

            $type = __("Exit order");

            break;

        case BillTypesEnum::renvoi_order :

            $type =__("Renvoi order");

            break;

        case BillTypesEnum::reintegration_order :

            $type = __("Reintegration order");
            break;

        case BillTypesEnum::quote :

            $type = __("Quotation");
            break;

        case BillTypesEnum::customer_order :

            $type = __("Customer order");
            break;

        case BillTypesEnum::sales_invoice :

            $type = __("Invoice");
            break;

        case BillTypesEnum::sale_credit_note :

            $type = __("Sale credit note");
            break;
        default :
            $type = __("Journal");

            break;
    }

    if (!empty($model['Bill']['supplier_id'])) {
                                 $supplier =     $model['Supplier']['name'];
                                 } else {

                                     if ($carNameStructure == 1) {
                                         $supplier = $model['EventType']['name'] . " - " . $model['Car']['code'] . " - " . $model['Carmodel']['name'];
                                        } else if ($carNameStructure == 2) {
                                         $supplier = $model['EventType']['name'] . " - " . $model['Car']['immatr_def'] . " - " . $model['Carmodel']['name'];
                                        }

                                }
    $phpExcel->getActiveSheet()->setCellValue('A'.$i, $model['Bill']['reference']);
    $phpExcel->getActiveSheet()->setCellValue('B'.$i, $this->Time->format($model['Bill']['date'], '%d-%m-%Y'));
    $phpExcel->getActiveSheet()->setCellValue('C'.$i, $type );
    $phpExcel->getActiveSheet()->setCellValue('D'.$i, $supplier );
    $phpExcel->getActiveSheet()->setCellValue('E'.$i, $model['Bill']['total_ht']);
    $phpExcel->getActiveSheet()->setCellValue('F'.$i, $model['Bill']['total_tva']);
    $phpExcel->getActiveSheet()->setCellValue('G'.$i, $model['Bill']['total_ttc']);
    $phpExcel->getActiveSheet()->setCellValue('H'.$i, $model['Bill']['amount_remaining']);
    $i++;
endforeach;

header("Content-Type: application/vnd.ms-excel");
$filename = 'Bons_'.date('Y_m_d');
header("Content-Disposition: attachment; filename=\"$filename.xls\"");


$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
$objWriter->save("php://output");
exit;

