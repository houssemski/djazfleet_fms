<?php
App::uses('AppModel', 'Model');

/**
 * Supplier Model
 *
 * @property Car $Car
 */
class Supplier extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    public $validate = array(
        'code' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
            ),
        ),
        'name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
        ),
    );
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Car' => array(
            'className' => 'Car',
            'foreignKey' => 'supplier_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Tire' => array(
            'className' => 'Tire',
            'foreignKey' => 'supplier_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Bill' => array(
            'className' => 'Bill',
            'foreignKey' => 'supplier_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Extinguisher' => array(
            'className' => 'Extinguisher',
            'foreignKey' => 'supplier_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'SheetRideDetailRides' => array(
            'className' => 'SheetRideDetailRides',
            'foreignKey' => 'supplier_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'TransportBill' => array(
            'className' => 'TransportBill',
            'foreignKey' => 'supplier_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Price' => array(
            'className' => 'Price',
            'foreignKey' => 'supplier_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Marchandise' => array(
            'className' => 'Marchandise',
            'foreignKey' => 'supplier_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'SupplierAttachmentType' => array(
            'className' => 'SupplierAttachmentType',
            'foreignKey' => 'supplier_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Contract' => array(
            'className' => 'Contract',
            'foreignKey' => 'supplier_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'SupplierContact' => array(
            'className' => 'SupplierContact',
            'foreignKey' => 'supplier_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'SupplierAddress' => array(
            'className' => 'SupplierAddress',
            'foreignKey' => 'supplier_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
    );

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Service' => array(
            'className' => 'Service',
            'foreignKey' => 'service_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'SupplierCategory' => array(
            'className' => 'SupplierCategory',
            'foreignKey' => 'supplier_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

    );

    public function getCustomerOrderValidationMethod($customerId)
    {

        $supplier = $this->find('first', array(
            'recursive' => -1,
            'conditions' => array('Supplier.id' => $customerId),
            'fields' => array('Supplier.automatic_order_validation')
        ));
        $automaticOrderValidation = $supplier['Supplier']['automatic_order_validation'];
        return $automaticOrderValidation;

    }

    /**
     * Get suppliers by supplier category id
     *
     * @param int $supplierCategoryId
     *
     * @return array $suppliers
     */
    public function getSuppliersByCategoryId($supplierCategoryId)
    {
        $suppliers = $this->find(
            'list',
            array(
                'order' => array('Supplier.code ASC, Supplier.name ASC'),
                'conditions' => array('Supplier.supplier_category_id' => $supplierCategoryId),
                'recursive' => -1
            )
        );
        return $suppliers;
    }

    /**
     * Get suppliers by supplier params
     *
     * @param int $supplierType (0 : supplier | 1 : customer)
     * @param int $isActive
     * @param array $supplierCategoryIds
     * @param array $finalCustomers
     * @param string $typeSelect
     * @param string $supplierId
     * @param string $conditionSupplier
     * @param string $isSpecial
     *
     * @return array $suppliers
     */
    public function getSuppliersByParams(
        $supplierType = null,
        $isActive = null,
        $supplierCategoryIds = null,
        $finalCustomers = null,
        $typeSelect = null,
        $supplierId = null,
        $conditionSupplier = null,
        $isSpecial = null
    )
    {
        if (empty($typeSelect)) {
            $typeSelect = 'list';
        }
        if (empty($isActive)) {
            $isActive = array(0, 1);
        }
        if (empty($isSpecial)) {
            $isSpecial = array(1, 3);
        }
        $conditions = array('Supplier.type' => $supplierType, 'Supplier.active' => $isActive, 'Supplier.is_special' => $isSpecial);
        if (!empty($supplierCategoryIds)) {

            $conditions = array_merge($conditions, array('Supplier.supplier_category_id' => $supplierCategoryIds));
        }
        if (!empty($finalCustomers)) {
            $conditions = array_merge($conditions, array('Supplier.final_customer' => $finalCustomers));
        }
        if (!empty($supplierId)) {
            $conditions = array_merge($conditions, array('Supplier.id' => $supplierId));
        }
        if (!empty($conditionSupplier)) {
            $conditions = array_merge($conditions, $conditionSupplier);
        }

        $suppliers = $this->find(
            $typeSelect,
            array(
                'order' => array('Supplier.code ASC, Supplier.name ASC'),
                'conditions' => $conditions,
                'recursive' => -1,
                'fields' => array(
                    'Supplier.id',
                    'Supplier.name',
                    'Supplier.code',
                    'Supplier.adress',
                    'Category.name',
                    'Supplier.balance',
                ),
                'joins' => array(

                    array(
                        'table' => 'supplier_categories',
                        'type' => 'left',
                        'alias' => 'Category',
                        'conditions' => array('Supplier.supplier_category_id = Category.id')
                    ),
                )
            )
        );
        return $suppliers;
    }

    /**
     * Get final suppliers by initial supplier
     *
     * @param int $initialSupplierId
     * @param int $finalSupplierId
     * @param array $conds
     * @param int $typeSelect
     * @return array $finalSuppliers
     */
    public function getFinalSuppliersByInitialSupplier($initialSupplierId, $finalSupplierId = null, $conds = null, $typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = 'list';
        }
        $isFinalCustomer = $this->find('first',array('conditions'=>array('Supplier.id'=>$initialSupplierId), 'recursive'=>-1, 'fields'=>array('Supplier.final_customer')));
        if($isFinalCustomer['Supplier']['final_customer'] == 3){
            $conditions = array(
                'type' => 1,
                'active' => 1,
                array(
                'OR' => array(
                    array('Supplier.id'=>$initialSupplierId),
                    array('FinalSupplierInitialSupplier.initial_supplier_id' => $initialSupplierId, 'Supplier.final_customer' => array(1, 3)))
                )
            );
        } else {
            $conditions = array(
                'type' => 1,
                'active' => 1,
                'Supplier.final_customer' => array(1, 3),
                'FinalSupplierInitialSupplier.initial_supplier_id' => $initialSupplierId
            );
        }
        if (!empty($conds)) {
            $conditions = array_merge($conditions, $conds);
        }
        if (!empty($finalSupplierId)) {
            $conditions = array_merge($conditions, array('Supplier.id' => $finalSupplierId));
        }


        $finalSuppliers = $this->find(
            $typeSelect,
            array(
                'order' => 'name ASC',
                'recursive' => -1,
                'fields' => array(
                    'Supplier.id',
                    'Supplier.name'),
                'conditions' => $conditions,

                'joins' =>
                    array(
                        array(
                            'table' => 'final_supplier_initial_suppliers',
                            'type' => 'left',
                            'alias' => 'FinalSupplierInitialSupplier',
                            'conditions' => array('FinalSupplierInitialSupplier.final_supplier_id = Supplier.id')
                        ),
                    )
            )
        );

        return $finalSuppliers;
    }

    /**
     * Get activated suppliers
     *
     * @param string|null $typeSelect
     * @return array $suppliers
     */
    public function getActiveSuppliers($typeSelect = null)
    {
        if ($typeSelect == null) {
            $typeSelect = 'list';
        }
        $suppliers = $this->find(
            $typeSelect,
            array(
                'order' => array('Supplier.code ASC, Supplier.name ASC'),
                'conditions' => array('Supplier.active' => 1),
                'recursive' => -1
            )
        );
        return $suppliers;
    }

    /**
     * Get supplier by supplier id
     *
     * @param int $supplierId
     * @param string $typeSelect
     *
     * @return array $supplier
     */
    public function getSuppliersById($supplierId = null, $typeSelect = null)
    {
        if ($typeSelect == null) {
            $typeSelect = 'first';
        }
        $supplier = $this->find(
            $typeSelect,
            array(
                'order' => array('Supplier.code ASC, Supplier.name ASC'),
                'conditions' => array('Supplier.id' => $supplierId),
                'fields' => array(
                    'Supplier.id',
                    'Supplier.name',
                    'Supplier.name',
                    'Supplier.supplier_category_id',
                    'Supplier.balance'
                ),
                'recursive' => -1
            )
        );
        return $supplier;
    }

    public function updateBalanceSupplier($supplierId = null, $amount = null, $balanceSupplier = null)
    {
        $supplier = $this->getSuppliersById($supplierId);
        $existBalance = $supplier['Supplier']['balance'];
        $newBalance = $existBalance- $balanceSupplier + $amount;
        $this->id = $supplierId;
        $this->saveField('balance', $newBalance);


    }

    /**
     * @param null $clientId
     * @param null $amount
     * @param null $balanceClient
     *
     */
    public function updateBalanceClient($clientId = null, $amount = null, $balanceClient = null)
    {
        $client = $this->getSuppliersById($clientId);
        $existBalance = $client['Supplier']['balance'];

        $newBalance = $existBalance + $balanceClient - $amount;
        $this->id = $clientId;
        $this->saveField('balance', $newBalance);


    }

    public function isVariousSupplier($supplierId =null){
        $supplier = $this->find('first',array(
            'recursive'=>-1,
            'conditions'=>array('Supplier.id'=>$supplierId),
            'fields'=>array('Supplier.supplier_category_id')
        ));
        if(!empty($supplier)){
            $supplierCategoryId = $supplier['Supplier']['supplier_category_id'];

            if($supplierCategoryId==2){
                return true;
            }else {
                return false;
            }
        }else {
            return false;
        }
    }

}
