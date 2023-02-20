<?php
App::uses('AppModel', 'Model');

/**
 * AttachmentType Model
 *
 * @property AttachmentType $AttachmentType
 */
class AttachmentType extends AppModel
{

    public $displayField = 'name';

    public $validate = array(
        'code' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
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
                'rule' => array('notBlank')
            ),
        ),
        'rubric_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank')
            ),
        ),
    );


    public $hasMany = array(
        'Attachment' => array(
            'className' => 'Attachment',
            'foreignKey' => 'attachment_type_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )

    );

    public $belongsTo = array(
        'Section' => array(
            'className' => 'Section',
            'foreignKey' => 'section_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    /**
     * Get attachment types by section id
     *
     * @param int $sectionId
     * @param string|null $typeSelect
     *
     * @return array $attachmentTypes
     */
    public function getAttachmentTypeBySectionId($sectionId, $typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }

        $attachmentTypes = $this->find(
            $typeSelect,
            array(
                "conditions" => array("AttachmentType.section_id =" => $sectionId),
                'recursive' => -1,
                'order'=>'AttachmentType.id ASC'
            )
        );
        return $attachmentTypes;
    }

    /**
     * Get attachment types by supplier id
     *
     * @param int $supplierId
     * @param string|null $typeSelect
     *
     * @return array $attachmentTypes
     */
    public function getAttachmentTypeBySupplierId($supplierId, $typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }

        $attachmentTypes = $this->find(
            $typeSelect,
            array(
                'recursive' => -1,
                'order' => 'AttachmentType.id ASC',
                'conditions' => array('SupplierAttachmentType.supplier_id' => $supplierId),
                'joins' => array(
                    array(
                        'table' => 'supplier_attachment_types',
                        'type' => 'left',
                        'alias' => 'SupplierAttachmentType',
                        'conditions' => array('AttachmentType.id = SupplierAttachmentType.attachment_type_id')
                    ),
                )
            )
        );
        return $attachmentTypes;
    }

    /**
     * Get attachment types by supplier category id
     *
     * @param int $supplierCategoryId
     * @param string|null $typeSelect
     *
     * @return array $attachmentTypes
     */
    public function getAttachmentTypeBySupplierCategoryId($supplierCategoryId=null, $typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }

        $attachmentTypes = $this->find(
            $typeSelect,
            array(
                'recursive' => -1,
                'order' => 'AttachmentType.id ASC',
                'conditions' => array('SupplierCategoryAttachmentType.supplier_category_id' => $supplierCategoryId),
                'joins' => array(
                    array(
                        'table' => 'supplier_category_attachment_types',
                        'type' => 'left',
                        'alias' => 'SupplierCategoryAttachmentType',
                        'conditions' => array('AttachmentType.id = SupplierCategoryAttachmentType.attachment_type_id')
                    ),
                )
            )
        );
        return $attachmentTypes;
    }


    public function getAttachmentTypeByParameter($clientId){

        $ParameterModel = ClassRegistry::init('Parameter');
        $attachmentDisplaySheetRide = $ParameterModel->getCodesParameterVal('attachment_display_sheet_ride');
        if($attachmentDisplaySheetRide==1){
            $attachmentTypes = $this->getAttachmentTypeBySupplierId($clientId, 'all');
            if(empty($attachmentTypes)){
                $SupplierModel = ClassRegistry::init('Supplier');
                $client =$SupplierModel->getSuppliersById($clientId,'first');
                $supplierCategoryId = $client['Supplier']['supplier_category_id'];
                if(!empty($supplierCategoryId)){
                    $attachmentTypes = $this->getAttachmentTypeBySupplierCategoryId($supplierCategoryId, 'all');
                }
            }
        } else {
            $ParameterAttachmentTypeModel = ClassRegistry::init('ParameterAttachmentType');
            $attachmentTypes = $ParameterAttachmentTypeModel->getParameterAttachmentTypes();
        }
        return $attachmentTypes;
    }


}