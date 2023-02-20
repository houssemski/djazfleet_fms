<?php
App::uses('AppModel', 'Model');

/**
 * EventType Model
 *
 * @property EventType $EventType
 * @property Event $Event
 * @property InterferingTypeEventType $InterferingTypeEventType
 * @property EventTypeCategoryEventType $EventTypeCategoryEventType
 */
class MedicalVisit extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'visit_number';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'visit_number' => array(
            'unique' => array(
                'rule' => 'isUnique',
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
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
        'internal_external' => array(
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

        'EventEventType' => array(
            'className' => 'EventEventType',
            'foreignKey' => 'event_type_id',
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
     * Get medical visits  list
     *
     * @param string|null $typeSelect
     * @param int|null $recursive
     * @param array|null $fields
     * @param array|null $condition
     *
     * @return array $eventTypes
     */
    public function getMedicalVisits($typeSelect = null)
    {

        if (empty($typeSelect)) {
            $typeSelect = "list";
        }

            $medicalVisits = $this->find(
                $typeSelect,
                array(
                    'order' => 'MedicalVisit.visit_number ASC',
                    'recursive' => -1,
                    'fields' => array('MedicalVisit.visit_number'),
                )
            );


        return $medicalVisits;
    }

    /**
     * Get medical visits by id
     *
     * @param int $visitId
     * @param string|null $typeSelect
     *
     * @return array $eventType
     */
    public function getMedicalVisitById($visitId, $typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "first";
        }
        $medicalVisit = $this->find(
            $typeSelect,
            array(
                'conditions' => array('id' => $visitId),
                'fields' => array(
                    'MedicalVisit.id',
                    'MedicalVisit.visit_number',
                ),
                'recursive' => -1
            )
        );

        return $medicalVisit;
    }




}
