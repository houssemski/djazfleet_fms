<?php

App::uses('AppModel', 'Model');

/**
 * Mark Model
 *
 * @property Car $Car
 */
class Mark extends AppModel {

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
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Car' => array(
            'className' => 'Car',
            'foreignKey' => 'mark_id',
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
     * Get all car marks
     *
     * @param int|null $recursive
     * @param int|null $typeSelect
     *
     * @return array $marks
     */
    public function getCarMarks($recursive = null, $typeSelect = null)
    {
        if(empty($recursive)){
            $recursive = '-1';
        }
        if(empty($typeSelect)){
            $typeSelect = 'list';
        }

        $marks = $this->find(
            $typeSelect,
            array(
                'order' => 'Mark.code ASC, Mark.name ASC',
                'recursive' => $recursive
            )
        );

        return $marks;
    }

    /**
     * Get all car marks by ids
     *
     * @param array $ids
     * @param int|null $recursive
     * @param int|null $typeSelect
     *
     * @return array $marks
     */
    public function getCarMarksByIds($ids, $recursive = null, $typeSelect = null)
    {
        if(empty($recursive)){
            $recursive = '-1';
        }
        if(empty($typeSelect)){
            $typeSelect = 'list';
        }

        $marks = $this->find(
            $typeSelect,
            array(
                'conditions' => array("Mark.id" => $ids),
                'order' => 'Mark.code ASC, Mark.name ASC',
                'recursive' => $recursive
            )
        );

        return $marks;
    }

    /**
     * Get car marks by ids negation
     *
     * @param array $marksIds
     *
     * @return array $Marks
     */
    public function getCarMarksByIdsNegation($marksIds)
    {
        $Marks = $this->find(
            'list',
            array(
                'order' => 'code ASC, name ASC',
                'conditions' => array('Mark.id !=' => $marksIds),
                'recursive' => -1
            )
        );
        return $Marks;
    }

}
