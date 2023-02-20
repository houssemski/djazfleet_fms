<?php

App::uses('AppModel', 'Model');

/**
 * Interfering Model
 *
 * @property InterferingType $InterferingType
 * @property Event $Event
 */
class Interfering extends AppModel
{

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
        'interfering_type_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => '',
            ),
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                'allowEmpty' => false,
                'required' => true,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'InterferingType' => array(
            'className' => 'InterferingType',
            'foreignKey' => 'interfering_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),


    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(

        'Event' => array(
            'className' => 'Event',
            'foreignKey' => 'interfering_id',
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

    /**
     * Get interfering list
     *
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $interferings
     */
    public function getInterferingList($typeSelect = null, $recursive = null)
    {

        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $interferings = $this->find(
            $typeSelect,
            array(
                'order' => 'Interfering.code ASC, Interfering.name ASC',
                'recursive' => $recursive
            )
        );

        return $interferings;
    }

    /**
     * Get interferings by type
     *
     * @param array $InterferingTypes
     *
     * @return array $interferings
     */
    public function getInterferingsByTypes($InterferingTypes)
    {

        $interferings = $this->find(
            'all',
            array(
                'conditions' => array(
                    'OR' => array('Interfering.interfering_type_id' => $InterferingTypes)
                ),
                'order' => 'Interfering.code ASC, Interfering.name ASC',
                'recursive' => -1
            )
        );

        return $interferings;
    }


    public function getThirdPartyIdByInterferingId($interferingId = null){
        $interfering = $this->find('first', array(
            'conditions' => array('Interfering.id' => $interferingId),
            'recursive' => -1,
            'fields' => array('Interfering.id', 'Interfering.third_party_id')
        ));
        $thirdPartyId = $interfering['Interfering']['third_party_id'];
        return $thirdPartyId;
    }

}
