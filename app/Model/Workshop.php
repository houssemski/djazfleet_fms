<?php
App::uses('AppModel', 'Model');

/**
 * EventType Model
 *

 */
class Workshop extends AppModel
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
    public $belongsTo = array(


      /*  'AbsenceReason' => array(
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
        )*/
    );





    /**
     * Get Workshops  list
     *
     * @param string|null $typeSelect
     *
     * @return array $eventTypes
     */
    public function getWorkshops($typeSelect = null)
    {

        if (empty($typeSelect)) {
            $typeSelect = "list";
        }

        $workshops = $this->find(
            $typeSelect,
            array(
                'order' => 'Workshop.code ASC , Workshop.name ASC',
                'recursive' => -1,
                'fields' => array('Workshop.name'),
            )
        );


        return $workshops;
    }

    /**
     * Get workshop by id
     *
     * @param int $workshopId
     * @param string|null $typeSelect
     *
     * @return array $workshop
     */
    public function getWorkshopById($workshopId, $typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "first";
        }
        $workshop = $this->find(
            $typeSelect,
            array(
                'conditions' => array('id' => $workshopId),
                'fields' => array(
                    'Absence.id',
                    'Absence.code',
                ),
                'recursive' => -1
            )
        );

        return $workshop;
    }




}
