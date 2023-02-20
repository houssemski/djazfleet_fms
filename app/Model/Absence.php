<?php
App::uses('AppModel', 'Model');

/**
 * EventType Model
 *

 */
class Absence extends AppModel
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
        'absence_reason_id' => array(
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
        'AbsenceReason' => array(
            'className' => 'AbsenceReason',
            'foreignKey' => 'absence_reason_id',
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
     * Get Absences  list
     *
     * @param string|null $typeSelect
     * @param int|null $recursive
     * @param array|null $fields
     * @param array|null $condition
     *
     * @return array $eventTypes
     */
    public function getAbsences($typeSelect = null)
    {

        if (empty($typeSelect)) {
            $typeSelect = "list";
        }

        $absences = $this->find(
            $typeSelect,
            array(
                'order' => 'Absence.code ASC',
                'recursive' => -1,
                'fields' => array('Absence.code'),
            )
        );


        return $absences;
    }

    /**
     * Get Absences by id
     *
     * @param int $AbsenceId
     * @param string|null $typeSelect
     *
     * @return array $eventType
     */
    public function getAbsenceById($absenceId, $typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "first";
        }
        $absence = $this->find(
            $typeSelect,
            array(
                'conditions' => array('id' => $absenceId),
                'fields' => array(
                    'Absence.id',
                    'Absence.code',
                ),
                'recursive' => -1
            )
        );

        return $absence;
    }




}
