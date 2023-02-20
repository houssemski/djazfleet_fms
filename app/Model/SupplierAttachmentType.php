<?php
App::uses('AppModel', 'Model');
/**
 * Supplier Model
 *
 * @property Car $Car
 */
class SupplierAttachmentType extends AppModel {

    /**
     * Display field
     *
     * @var string
     */


    public $validate = array(
        'supplier_id' => array(
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
        'Supplier' => array(
            'className' => 'Supplier',
            'foreignKey' => 'supplier_id',
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

    /** recuperer les types d'attachement d'un client supplierId
     * @param $supplierId
     * @return array|null
     */
    function getSupplierAttachmentTypesBySupplierId ($supplierId){
        $supplierAttachmentTypes = $this->find('all',
            array(
                'recursive'=>-1,
                'fields'=>array('SupplierAttachmentType.attachment_type_id'),
                'conditions' => array('SupplierAttachmentType.supplier_id' => $supplierId),
                'order' => 'SupplierAttachmentType.attachment_type_id ASC'
            ));

        return $supplierAttachmentTypes;
    }

}
