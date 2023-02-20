<?php

App::uses('AppModel', 'Model');

/**
 * Zone Model
 *
 * @property Car $Car
 */
class Daira extends AppModel {

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
        'wilaya_id' => array(
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


        'Destination' => array(
            'className' => 'Destination',
            'foreignKey' => 'daira_id',
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
        'Wilaya' => array(
            'className' => 'Wilaya',
            'foreignKey' => 'wilaya_id',
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
    );

    /**
     * Get dairas by wilaya id
     *
     * @param int $wilayaId
     * @param string|null $typeSelect
     *
     * @return array $dairas
     */
    public function getDairaByWilayaId($wilayaId, $typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }

        $dairas = $this->find(
            $typeSelect,
            array(
                "conditions" => array("Daira.wilaya_id =" => $wilayaId),
                'recursive' => -1,
                'order'=>'code ASC, name ASC'
            )
        );
        return $dairas;
    }

    /**
     * Get daira by id
     *
     * @param int $dairaId
     *
     * @return array $daira
     */
    public function getDairaById($dairaId)
    {
        $this->virtualFields = array(
            'cnames' => "CONCAT(Daira.code, ' - ', Daira.name)"
        );
        $daira = $this->find(
            'list',
            array(
                'conditions' => array('Daira.id' => $dairaId),
                'fields' => 'cnames',
                'recursive' => -1
            )
        );
        return $daira;
    }

}
