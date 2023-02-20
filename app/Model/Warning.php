<?php
App::uses('AppModel', 'Model');

/**
 * EventType Model
 *

 */
class Warning extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'code';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
     /*   'code' => array(
            'unique' => array(
                'rule' => 'isUnique',
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),*/
        'customer_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'warning_type_id' => array(
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

        'Customer' => array(
            'className' => 'Customer',
            'foreignKey' => 'customer_id',
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
        'WarningType' => array(
            'className' => 'WarningType',
            'foreignKey' => 'warning_type_id',
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
     * Get warnings  list
     *
     * @param string|null $typeSelect
     * @param int|null $recursive
     * @param array|null $fields
     * @param array|null $condition
     *
     * @return array $eventTypes
     */
    public function getWarnings($typeSelect = null)
    {

        if (empty($typeSelect)) {
            $typeSelect = "list";
        }

        $warnings = $this->find(
            $typeSelect,
            array(
                'order' => 'Warning.code ASC',
                'recursive' => -1,
                'fields' => array('Warning.code'),
            )
        );


        return $warnings;
    }

    /**
     * Get warnings by id
     *
     * @param int $warningId
     * @param string|null $typeSelect
     *
     * @return array $eventType
     */
    public function getWarningById($warningId, $typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "first";
        }
        $warning = $this->find(
            $typeSelect,
            array(
                'conditions' => array('id' => $warningId),
                'fields' => array(
                    'Warning.id',
                    'Warning.code',
                ),
                'recursive' => -1
            )
        );

        return $warning;
    }




}
