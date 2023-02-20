<?php

App::uses('AppModel', 'Model');

/**
 * Wilaya Model
 *
 * @property Wilaya $Wilaya
 */
class Wilaya extends AppModel {

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
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'name' => array(
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
    public $hasMany = array(


        'Daira' => array(
            'className' => 'Daira',
            'foreignKey' => 'wilaya_id',
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
        'Destination' => array(
            'className' => 'Destination',
            'foreignKey' => 'wilaya_id',
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

        'Zone' => array(
            'className' => 'Zone',
            'foreignKey' => 'zone_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

    );

    /**
     * Get wilayas
     *
     * @param array|null $fields
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $wilayas
     */
    public function getWilayaList($fields = null, $typeSelect = null, $recursive = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($fields)) {
            $fields = array('Wilaya.id', 'Wilaya.name');
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $wilayas = $this->find(
            $typeSelect,
            array(
                'fields' => $fields,
                'order' => 'Wilaya.code ASC, Wilaya.name ASC',
                'recursive' => $recursive
            )
        );
        return $wilayas;
    }

    /**
     * Get wilaya by id
     *
     * @param int $wilayaId
     *
     * @return array $wilaya
     */
    public function getWilayaById($wilayaId)
    {
        $this->virtualFields = array(
            'cnames' => "CONCAT(Wilaya.code, ' - ', Wilaya.name)"
        );
        $wilaya = $this->find(
            'list',
            array(
                'conditions' => array('Wilaya.id' => $wilayaId),
                'fields' => 'cnames',
                'recursive' => -1
            )
        );
        return $wilaya;
    }

}
