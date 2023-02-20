<?php
namespace App\Controller\Component;

use App\Model\Entity\DocumentsProduct;
use App\Model\Table\DocumentsProductsTable;
use App\Model\Table\DocumentsTable;
use App\Model\Table\EnumsTable;
use App\Model\Table\ParameterOptionsTable;
use App\Model\Table\ProductsTable;
use App\Model\Table\BatchesTable;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use DateTime;

/**
 * TraceabilityManagement component
 * * @property EnumsTable $EnumsTable
 * * @property DocumentsTable $DocumentsTable
 * * @property BatchesTable $BatchesTable
 * * @property ProductsTable $ProductsTable
 * * @property DocumentsProductsTable $DocumentsProductsTable
 * * @property DocumentsProductsSerialNumbersTable $DocumentsProductsSerialNumbersTable
 */
class TraceabilityManagementComponent extends Component
{
    public $components = array(
        'SerialNumbersManagement'
    );

    /**
     * Default configuration.
     */
    protected $_defaultConfig = [];

    public $DocumentsTable;
    public $BatchesTable;
    public $DocumentsProductsSerialNumbersTable;
    public $ProductsTable;
    public $DocumentsProductsTable;
    public $EnumsTable;
    public $TraceabilityTypesEnum;
    public $DocumentTypesEnum;
    public $Controller;

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->EnumsTable = TableRegistry::getTableLocator()->get('enums');
        $this->DocumentsTable = TableRegistry::getTableLocator()->get('documents');
        $this->BatchesTable = TableRegistry::getTableLocator()->get('batches');
        $this->ProductsTable = TableRegistry::getTableLocator()->get('products');
        $this->DocumentsProductsTable = TableRegistry::getTableLocator()->get('documents_products');
        $this->DocumentsProductsSerialNumbersTable = TableRegistry::getTableLocator()->get('DocumentsProductsSerialNumbers');
        $this->Controller = $this->_registry->getController();
        $this->DocumentTypesEnum = $this->EnumsTable->enum('document_types');
        $this->TraceabilityTypesEnum = $this->EnumsTable->enum('traceability_types');
    }
    /**
     * @param DocumentsProduct $documentProduct
     * @param int $documentTypeId
     * @param array $productsPosted
     * @param array $newPostedDocumentProducts
     * @param bool $isActionEdit
     * @param DocumentsProduct|null $documentProductContainingSerialNumbers
     */
    public function handleProductsTraceability($documentProduct, $documentTypeId, $productsPosted, $isActionEdit = false, $newPostedDocumentProducts = array(), $documentProductContainingSerialNumbers = null){
        switch ($documentTypeId) {
            case $this->DocumentTypesEnum['RECEPTION_NOTE']['id'] :
            case $this->DocumentTypesEnum['ENTRY_RECEIPT']['id'] :
            $this->handleStockEntryDocumentsProductsTraceability($documentProduct, $documentTypeId, $productsPosted, $isActionEdit, $newPostedDocumentProducts,$documentProductContainingSerialNumbers);
                break;
            case $this->DocumentTypesEnum['DELIVERY_NOTE']['id'] :
            case $this->DocumentTypesEnum['RETURN_CUSTOMER_NOTE']['id'] :
            $this->handleStockExitDocumentsProductsTraceability($documentProduct, $productsPosted, $isActionEdit, $documentTypeId, $documentProductContainingSerialNumbers);
                break;

        }
    }

    /**
     * @param DocumentsProduct $oldDocumentProduct
     * @param int $documentTypeId
     * @param false $isActionEdit
     * @param array $documentProductContainingSerialNumbers
     */
    public function handleStockEntryDocumentsProductsTraceability($oldDocumentProduct, $documentTypeId, $isActionEdit = false, $documentProductContainingSerialNumbers = null){

                if($isActionEdit && !empty($documentProductContainingSerialNumbers)){
                    $this->handleEditDocumentProductSerialNumberTraceability( $documentTypeId, $documentProductContainingSerialNumbers);
                }else{
                    $this->handleDocumentProductSerialNumberTraceability($oldDocumentProduct, $documentTypeId);
                }

    }
    public function handleStockExitDocumentsProductsTraceability($documentProduct, $isActionEdit = false, $documentTypeId , $documentProductContainingSerialNumbers = null  ){

                if($isActionEdit && !empty($documentProductContainingSerialNumbers)){
                    $this->handleEditDocumentProductSerialNumberTraceability( $documentTypeId, $documentProductContainingSerialNumbers);
                }else{
                    $this->handleDocumentProductSerialNumberTraceability($documentProduct, $documentTypeId);
                }

    }



    public function handleEditDocumentProductSerialNumberTraceability( $documentTypeId, $documentProductContainingSerialNumbers){




        if (isset($documentProductContainingSerialNumbers['serial_numbers'])
            && !empty($documentProductContainingSerialNumbers['serial_numbers'])) {

            if($documentTypeId == $this->DocumentTypesEnum['DELIVERY_NOTE']['id'] ||
                $documentTypeId == $this->DocumentTypesEnum['EXIT_RECEIPT']['id']){
                $isUsed = 1;
                $this->SerialNumbersManagement->editSerialNumbers(
                    $documentProductContainingSerialNumbers->old_serial_numbers,
                    $documentProductContainingSerialNumbers->serial_numbers,
                    $documentProductContainingSerialNumbers->id,
                    $isUsed
                );



            }else {
                $isUsed = 0;
                $authenticatedUserId =  $this->Controller->Authentication->getIdentity()->getIdentifier();

                $this->SerialNumbersManagement->addSerialNumbers(
                    $documentProductContainingSerialNumbers['serial_numbers'],
                    $documentProductContainingSerialNumbers['product_id'],
                    $documentProductContainingSerialNumbers->id,
                    $authenticatedUserId,
                    $isUsed
                );
            }

        }else {
            if(isset($documentProductContainingSerialNumbers->document_product_serial_numbers) &&
                !empty($documentProductContainingSerialNumbers->document_product_serial_numbers)
            ){
                if($documentTypeId == $this->DocumentTypesEnum['RECEPTION_NOTE']['id'] ||
                    $documentTypeId == $this->DocumentTypesEnum['ENTRY_RECEIPT']['id']) {
                    $serialNumbers = $documentProductContainingSerialNumbers->old_serial_numbers;
                    $serialNumbersTable = TableRegistry::getTableLocator()->get('SerialNumbers');
                    foreach ($serialNumbers as $serialNumber){
                        $serialNumber->isNew(true);
                    }
                    $serialNumbersTable->saveMany($serialNumbers);
                }
                $documentsProductsSerialNumbers  = $documentProductContainingSerialNumbers->document_product_serial_numbers;

                $documentsProductsSerialNumbersTable = TableRegistry::getTableLocator()->get('DocumentsProductsSerialNumbers');
                foreach ($documentsProductsSerialNumbers as $documentsProductsSerialNumber){
                    $documentsProductsSerialNumber->isNew(true);
                }

                $documentsProductsSerialNumbersTable->saveMany($documentsProductsSerialNumbers);

            }
        }




    }


    /**
     * @param $documentProduct
     * @param $documentTypeId
     */
    public function handleDocumentProductSerialNumberTraceability($documentProduct, $documentTypeId){

    if (
            $documentTypeId == $this->DocumentTypesEnum['RECEPTION_NOTE']['id'] ||
            $documentTypeId == $this->DocumentTypesEnum['ENTRY_RECEIPT']['id'] ||
            $documentTypeId == $this->DocumentTypesEnum['DELIVERY_NOTE']['id'] ||
            $documentTypeId == $this->DocumentTypesEnum['EXIT_RECEIPT']['id']
        ) {

                                    if (
                                        isset($documentProduct['serial_numbers'])
                                        && !empty($documentProduct['serial_numbers'])
                                    ) {
                                        $authenticatedUserId = $this->Controller->Authentication->getIdentity()->getIdentifier();
                                        if (
                                            $documentTypeId == $this->DocumentTypesEnum['DELIVERY_NOTE']['id'] ||
                                            $documentTypeId == $this->DocumentTypesEnum['EXIT_RECEIPT']['id']
                                        ) {
                                            $isUsed = 1;
                                        } else {
                                            $isUsed = 0;
                                        }

                                        $this->SerialNumbersManagement->addSerialNumbers(
                                            $documentProduct['serial_numbers'],
                                            $documentProduct['product_id'],
                                            $documentProduct->id,
                                            $authenticatedUserId,
                                            $isUsed
                                        );

                                    }
                                }
    }



}
