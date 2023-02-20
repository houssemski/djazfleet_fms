<?php
App::uses('AppModel', 'Model');

/**
 * InterferingType Model
 *
 * @property Interfering $Interfering
 */
class InterferingType extends AppModel
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
                //'message' => 'Your custom message here',
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
        'Interfering' => array(
            'className' => 'Interfering',
            'foreignKey' => 'interfering_type_id',
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
     * Get interfering type list
     *
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $interferingTypes
     */
    public function getInterferingTypes($typeSelect = null, $recursive = null)
    {

        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $interferingTypes = $this->find(
            $typeSelect,
            array(
                'order' => 'InterferingType.code ASC, InterferingType.name ASC',
                'recursive' => $recursive
            )
        );

        return $interferingTypes;
    }

    /**
     * Get interfering types by event type
     *
     * @param int $eventTypeId
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $interferingTypes
     */
    public function getInterferingTypesByEventType($eventTypeId, $typeSelect = null, $recursive = null)
    {

        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $interferingTypes = $this->find(
            $typeSelect,
            array(
                'order' => 'code ASC',
                'conditions' => array('InterferingTypeEventType.event_type_id' => $eventTypeId),
                'recursive' => $recursive,
                'joins' => array(
                    array(
                        'table' => 'interfering_type_event_type',
                        'type' => 'left',
                        'alias' => 'InterferingTypeEventType',
                        'conditions' => array('InterferingTypeEventType.interfering_type_id = InterferingType.id')
                    ),
                )
            ));

        return $interferingTypes;
    }
}
