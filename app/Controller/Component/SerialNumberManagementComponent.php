<?php



/**
 * Class SerialNumberManagementComponent
 * @package App\Controller\Component
 */
class SerialNumberManagementComponent extends Component
{


    /**
     * @param $billProductId
     * @param $productId
     * @param $billTypeId
     * @param bool $isActionEdit
     * @param null $serialNumbers
     */
    public function handleProductsTraceability($billProductId, $productId, $billTypeId, $isActionEdit = false, $serialNumbers ){

        switch ($billTypeId) {
            case BillTypesEnum::receipt :
            case BillTypesEnum::entry_order :
                $this->handleStockEntryBillsProductsTraceability($billProductId, $productId, $billTypeId, $isActionEdit,$serialNumbers);
                break;
            case BillTypesEnum::delivery_order :
            case BillTypesEnum::return_customer :
                $this->handleStockExitBillsProductsTraceability($billProductId,$productId, $isActionEdit, $billTypeId, $serialNumbers);
                break;

        }
    }

    /**
     * @param $billProductId
     * @param $productId
     * @param $billTypeId
     * @param bool $isActionEdit
     * @param null $serialNumbers
     */
    public function handleStockEntryBillsProductsTraceability($billProductId, $productId, $billTypeId, $isActionEdit = false, $serialNumbers = null){


        if($isActionEdit && !empty($serialNumbers)){
            $this->handleEditBillProductSerialNumberTraceability( $billTypeId, $productId,
                $billProductId, $serialNumbers);
        }else{
            $this->handleBillProductSerialNumberTraceability($billProductId, $productId, $billTypeId, $serialNumbers);
        }

    }
    public function handleStockExitBillsProductsTraceability($billProductId, $productId, $isActionEdit = false, $billTypeId , $serialNumbers   ){

        if($isActionEdit && !empty($serialNumbers)){
            $this->handleEditBillProductSerialNumberTraceability( $billTypeId, $productId,
                $billProductId, $serialNumbers);
        }else{
            $this->handleBillProductSerialNumberTraceability($billProductId, $productId, $billTypeId, $serialNumbers);
        }

    }



    public function handleEditBillProductSerialNumberTraceability( $billTypeId, $productId,
                                                                   $billProductId,  $serialNumbers){




        if (isset($serialNumbers)
            && !empty($serialNumbers)) {

            if($billTypeId == BillTypesEnum::delivery_order ||
                $billTypeId == BillTypesEnum::exit_order){
                $isUsed = 1;
               /* $this->editSerialNumbers(
                    $billProductContainingSerialNumbers->old_serial_numbers,
                    $billProductContainingSerialNumbers->serial_numbers,
                    $billProductContainingSerialNumbers->id,
                    $isUsed
                );*/



            }else {
                $isUsed = 0;


            }
            $this->updateSerialNumbers(
                $serialNumbers,
                $productId,
                $billProductId,
                $isUsed
            );

        }

       /* else {
            if(isset($billProductContainingSerialNumbers->bill_product_serial_numbers) &&
                !empty($billProductContainingSerialNumbers->bill_product_serial_numbers)
            ){
                if($billTypeId == BillTypesEnum::receipt ||
                    $billTypeId == BillTypesEnum::entry_order) {
                    $serialNumbers = $billProductContainingSerialNumbers->old_serial_numbers;
                    $serialNumber = ClassRegistry::init('SerialNumber');
                    foreach ($serialNumbers as $serialNumber){
                        $serialNumber->isNew(true);
                    }
                    $serialNumber->saveMany($serialNumbers);
                }
                $billsProductsSerialNumbers  = $billProductContainingSerialNumbers->bill_product_serial_numbers;

                $billProductSerialNumber = ClassRegistry::init('BillProductSerialNumber');
                foreach ($billsProductsSerialNumbers as $billsProductsSerialNumber){
                    $billsProductsSerialNumber->isNew(true);
                }

                $billProductSerialNumber->saveMany($billsProductsSerialNumbers);

            }
        }*/




    }


    /**
     * @param $billProductId
     * @param $productId
     * @param $billTypeId
     * @param $serialNumbers
     */
    public function handleBillProductSerialNumberTraceability($billProductId, $productId, $billTypeId, $serialNumbers){

        if (
            $billTypeId == BillTypesEnum::receipt ||
            $billTypeId == BillTypesEnum::entry_order  ||
            $billTypeId == BillTypesEnum::delivery_order ||
            $billTypeId == BillTypesEnum::exit_order
        ) {

            if (
                isset($serialNumbers)
                && !empty($serialNumbers)
            ) {
                if (
                    $billTypeId == BillTypesEnum::delivery_order ||
                    $billTypeId == BillTypesEnum::exit_order
                ) {
                    $isUsed = 1;
                } else {
                    $isUsed = 0;
                }

                $this->addSerialNumbers(
                    $serialNumbers,
                    $productId,
                    $billProductId,
                    $isUsed
                );

            }
        }
    }







    public function addSerialNumbers($serialNumbers, $productId, $billProductId, $isUsed)
    {
        $serialNumber = ClassRegistry::init('SerialNumber');
        $serialNumberIds = $serialNumber->saveSerialNumbers(
            $serialNumbers,
            $productId,
            $isUsed
        );

        if (!empty($serialNumberIds)) {
            $billProductSerialNumber = ClassRegistry::init('BillProductSerialNumber');
            $billProductSerialNumber->addBillProductSerialNumbers($serialNumberIds, $billProductId);
        }

    }
    public function updateSerialNumbers($serialNumbers, $productId, $billProductId, $isUsed)
    {
        $serialNumber = ClassRegistry::init('SerialNumber');
        $serialNumberIds = $serialNumber->saveSerialNumbers(
            $serialNumbers,
            $productId,
            $isUsed
        );

        if (!empty($serialNumberIds)) {
            $billProductSerialNumber = ClassRegistry::init('BillProductSerialNumber');
            $billProductSerialNumber->editBillProductSerialNumbers($serialNumberIds, $billProductId);
        }

    }
    public function deleteSerialNumbers($billProductId , $billTypeId)
    {
        $billProductSerialNumberModel = ClassRegistry::init('BillProductSerialNumber');
        $serialNumbers = $billProductSerialNumberModel->getSerialNumbersByBillProductId( $billProductId);
        $billProductSerialNumberModel->deleteAll(array('BillProductSerialNumber.bill_product_id' => $billProductId), false);
        $serialNumberModel = ClassRegistry::init('SerialNumber');
        if (
            $billTypeId == BillTypesEnum::receipt ||
            $billTypeId == BillTypesEnum::entry_order  ){

            foreach ($serialNumbers as $serialNumber){
                if(!$serialNumber['SerialNumber']['is_used']){
                    $serialNumberModel->deleteSerialNumber($serialNumber['SerialNumber']['id']);

                }
            }
         }else {
            $serialNumberIds = array();
            foreach ($serialNumbers as $serialNumber){
                $serialNumberIds[]= $serialNumber['SerialNumber']['id'];
            }
            $isUsed = 0;
            $serialNumberModel->updateIsUsedValue($serialNumberIds,$isUsed);
         }


    }

    public function getSerialNumbersArray($serialNumbers)
    {
        $serialNumbersArray = array();
        $i = 0;
        foreach ($serialNumbers as $serialNumber) {
            $serialNumbersArray[$i]['serial_number'] = $serialNumber['serial_number'];
            if (isset($serialNumber['id'])) {
                $serialNumbersArray[$i]['id'] = $serialNumber['id'];
            }
            if (isset($serialNumber['label'])) {
                $serialNumbersArray[$i]['label'] = $serialNumber['label'];
            }
            $i++;
        }

        return $serialNumbersArray;
    }

    /**
     * @param $oldSerialNumbers
     * @param $newSerialNumbers
     * @param $billProductId
     * @param $isUsed
     */
    public function editSerialNumbers($oldSerialNumbers, $newSerialNumbers, $billProductId,$isUsed)
    {

        $oldSerialNumberIds = array();
        if(!empty($oldSerialNumbers)){
            foreach ($oldSerialNumbers as $oldSerialNumber) {
                $oldSerialNumberIds[] = $oldSerialNumber->id;
            }
        }
        $newSerialNumberIds = array();
        if(!empty($newSerialNumbers)){
            foreach ($newSerialNumbers as $newSerialNumber) {
                $newSerialNumberIds[] = $newSerialNumber['id'];
            }
        }

        $diffSerialNumberIds = array();
        if (!empty($oldSerialNumberIds) && !empty($newSerialNumberIds)) {
            $diffSerialNumberIds = array_diff($oldSerialNumberIds, $newSerialNumberIds);
        }
        if (!empty($diffSerialNumberIds)) {
            $serialNumber = ClassRegistry::init('SerialNumber');
            $serialNumber->updateIsUsedValue($diffSerialNumberIds, $isUsed);
        }

        $billProductSerialNumber = ClassRegistry::init('BillProductSerialNumber');
        $billProductSerialNumber->addBillProductSerialNumbers($newSerialNumberIds, $billProductId);
        if (isset($diffSerialNumberIds) && !empty($diffSerialNumberIds)) {
            $billProductSerialNumber->deleteDocumentsProductsSerialNumbers($diffSerialNumberIds, $billProductId);
        }
    }
}
