<?php
App::uses('AppModel', 'Model');
/**
 * Supplier Model
 *
 * @property Car $Car
 */
class SupplierCategoryAttachmentType extends AppModel {

    /**
     * Display field
     *
     * @var string
     */


    public $validate = array(
        'supplier_category_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            ),
        ),
        'attachment_type_id' => array(
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



    );

    public $belongsTo = array(
        'SupplierCategory' => array(
            'className' => 'SupplierCategory',
            'foreignKey' => 'supplier_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

        'AttachmentType' => array(
            'className' => 'AttachmentType',
            'foreignKey' => 'attachment_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

    );

    /** recuperer les types d'attachement d'un client supplierCategoryId
     * @param $supplierCategoryId
     * @return array|null
     */
    function getSupplierCategoryAttachmentTypesBySupplierId ($supplierCategoryId){
        $supplierCategoryAttachmentTypes = $this->find('all',
            array(
                'recursive'=>-1,
                'fields'=>array('SupplierCategoryAttachmentType.attachment_type_id'),
                'conditions' => array('SupplierCategoryAttachmentType.supplier_category_id' => $supplierCategoryId),
                'order' => 'SupplierCategoryAttachmentType.attachment_type_id ASC'
            ));

        return $supplierCategoryAttachmentTypes;
    }

}
