<?php
/**
 * Created by PhpStorm.
 * User: kahina
 * Date: 29/12/2015
 * Time: 15:15
 */
App::uses('AppModel', 'Model');
class Treatment extends AppModel {
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
        )
    );
    public $hasMany = array(

        'ComplaintResponse' => array(
            'className' => 'ComplaintResponse',
            'foreignKey' => 'treatment_id',
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


    /**
     * Get service by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array $service
     */
    public function getTreatmentByForeignKey($id, $modelField)
    {
        $treatment = $this->find(
            'first',
            array(
                'conditions'=>array($modelField => $id),
                'fields' => array('Treatment.id'),
                'recursive'=>-1
            ));
        return $treatment;
    }

    /** recuperer les treatments
     * @param null $typeSelect
     */
    public function getTreatments ($typeSelect = null){

        $treatments = $this->find($typeSelect,
            array(

                'fields' => array('Treatment.id', 'Treatment.name'),
                'recursive' => -1
            ));
        return $treatments;
    }

}