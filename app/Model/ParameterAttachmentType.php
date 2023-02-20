<?php
App::uses('AppModel', 'Model');
/**
 * Supplier Model
 *
 * @property Car $Car
 */
class ParameterAttachmentType extends AppModel {

    /**
     * Display field
     *
     * @var string
     */


    public $validate = array(

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


        'AttachmentType' => array(
            'className' => 'AttachmentType',
            'foreignKey' => 'attachment_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

    );

    /** recuperer les types d'attachement d'un client

     * @return array|null
     */
    function getParameterAttachmentTypes (){
        $parameterAttachmentTypes = $this->find('all',
            array(
                'recursive'=>-1,
                'fields'=>array('ParameterAttachmentType.attachment_type_id'),
                'order' => 'ParameterAttachmentType.attachment_type_id ASC'
            ));

        return $parameterAttachmentTypes;
    }

}
