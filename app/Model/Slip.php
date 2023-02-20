<?php

App::uses('AppModel', 'Model');

/**
 * Complaint Model
 *
 * @property Complaint $Complaint
 */
class Slip extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'reference';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'reference' => array(
            'unique' => array(
                'rule' => 'isUnique',
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),



        'supplier_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

        'date_slip' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
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
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'modified_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

    );

    /**
     * @param null $reference
     * @param null $supplierId
     * @param null $userId
     */
    public function addSlip($reference= null, $supplierId= null, $userId = null){
        $slipId = null;
        $this->create();
        $slip = array();
        $slip['Slip']['reference']= $reference;
        $slip['Slip']['supplier_id']= $supplierId;
        $slip['Slip']['user_id']= $userId;
        $slip['Slip']['date_slip']=  date("Y-m-d");;

        if($this->save($slip)){
            $slipId = $this->getInsertID();
        }
        return $slipId;

    }

    public function getSlipById($id){
        $slip = $this->find('first',array(
            'conditions'=>array('Slip.id'=>$id),
            'fields'=>array('Slip.date_slip','Slip.reference','Supplier.name'),
            'recursive'=>-1,
            'joins' => array(


                array(
                    'table' => 'suppliers',
                    'type' => 'left',
                    'alias' => 'Supplier',
                    'conditions' => array('Supplier.id = Slip.supplier_id')
                ),

            )

        ));
        return $slip;
    }



}
