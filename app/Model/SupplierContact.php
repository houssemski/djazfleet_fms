<?php

App::uses('AppModel', 'Model');

/**
 * SupplierCategory Model
 *
 * @property Car $Car
 */
class SupplierContact extends AppModel {

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
        'contact' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
        ),
        'tel' => array(
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
     * Get contacts by supplier
     *
     * @param int $supplierId
     *
     * @return array $contacts
     */
    public function getContactsBySupplier($supplierId){
        $contacts = $this->find('all',
            array(
                'conditions' => array('SupplierContact.supplier_id' => $supplierId),
                'order' => 'SupplierContact.id ASC'
            ));

        return $contacts;

    }

}
