<?php

App::uses('AppModel', 'Model');

/**
 * SupplierCategory Model
 *
 * @property Car $Car
 */
class SupplierAddress extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'code' => array(

            'unique' => array(
                'rule' => 'isUnique',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
            ),
        ),

    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Supplier' => array(
            'className' => 'Supplier',
            'foreignKey' => 'supplier_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),


    );

    /**
     * Get adress by supplier
     *
     * @param int $supplierId
     *
     * @return array $adress
     */
    public function getAddressBySupplier($supplierId){
        $adress = $this->find('all',
            array(
                'conditions' => array('SupplierAddress.supplier_id' => $supplierId),
                'order' => 'SupplierAddress.id ASC'
            ));

        return $adress;

    }

}
