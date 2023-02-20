<?php
App::uses('AppModel', 'Model');

/**
 * EventType Model
 *

 */
class Transit extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'reference';

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
        'supplier_id' => array(
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

        'Supplier' => array(
            'className' => 'Supplier',
            'foreignKey' => 'supplier_id',
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
     * Get Transits  list
     *
     * @param string|null $typeSelect
     * @param int|null $recursive
     * @param array|null $fields
     * @param array|null $condition
     *
     * @return array $eventTypes
     */
    public function getTransits($typeSelect = null)
    {

        if (empty($typeSelect)) {
            $typeSelect = "list";
        }

        $transits = $this->find(
            $typeSelect,
            array(
                'order' => 'Transit.reference ASC',
                'recursive' => -1,
                'fields' => array('Transit.reference'),
            )
        );


        return $transits;
    }

    /**
     * Get transits by id
     *
     */
    public function getAbsenceById($transitId, $typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "first";
        }
        $transit = $this->find(
            $typeSelect,
            array(
                'conditions' => array('id' => $transitId),
                'fields' => array(
                    'Transit.id',
                    'Transit.reference',
                ),
                'recursive' => -1
            )
        );

        return $transit;
    }




}
