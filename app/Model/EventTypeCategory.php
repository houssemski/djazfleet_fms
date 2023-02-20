<?php

App::uses('AppModel', 'Model');

/**
 * CarCategory Model
 *
 * @property Car $Car
 */
class EventTypeCategory extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $useTable = 'event_type_categories';
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
        
        'EventCategoryInterfering' => array(
            'className' => 'EventCategoryInterfering',
            'foreignKey' => 'event_type_category_id',
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
     * Get event type categories list
     *
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $eventTypeCategories
     */
    public function getEventTypeCategories($typeSelect = null, $recursive = null)
    {

        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $eventTypeCategories = $this->find(
            $typeSelect,
            array(
                'order' => 'EventTypeCategory.code ASC, EventTypeCategory.name ASC',
                'recursive' => $recursive
            )
        );

        return $eventTypeCategories;
    }

}
