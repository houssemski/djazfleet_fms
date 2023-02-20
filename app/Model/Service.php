<?php
/**
 * Created by PhpStorm.
 * User: kahina
 * Date: 29/12/2015
 * Time: 15:15
 */
App::uses('AppModel', 'Model');
class Service extends AppModel {
    public $displayField = 'name';

    public $validate = array(
        'name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

        'department_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );
    public $hasMany = array(


        'Customer' => array(
            'className' => 'Customer',
            'foreignKey' => 'service_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )    ,
        'Supplier' => array(
            'className' => 'Supplier',
            'foreignKey' => 'service_id',
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
        'Event' => array(
            'className' => 'Supplier',
            'foreignKey' => 'service_id',
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
        'Department' => array(
            'className' => 'Department',
            'foreignKey' => 'department_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

    );

    /**
     * Get service by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array $service
     */
    public function getServiceByForeignKey($id, $modelField)
    {
        $service = $this->find(
            'first',
            array(
                'conditions'=>array($modelField => $id),
                'fields' => array('Service.id'),
                'recursive'=>-1
            ));
        return $service;
    }

    /** recuperer les services
     * @param null $typeSelect
     */
    public function getServices ($typeSelect = null){

        $services = $this->find($typeSelect,
            array(

                'fields' => array('Service.id', 'Service.name'),
                'recursive' => -1
            ));
        return $services;
}

    /**
     * @param null $typeSelect
     * @param null $supplierId
     * @return array|null
     */
public function getServicesBySupplierId ($typeSelect = null, $supplierId = null){

        $services = $this->find($typeSelect,
            array(

                'fields' => array('Service.id', 'Service.name'),
                'recursive' => -1,
                'conditions'=>array('Service.supplier_id'=>$supplierId)
            ));
        return $services;
}

}