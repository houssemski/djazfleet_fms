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
class EventType extends AppModel
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
        'transact_type_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

        'event_type_categories' => array(
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
        ),
        'EventProduct' => array(
            'className' => 'EventProduct',
            'foreignKey' => 'event_id',
        ),
    );

    public $hasAndBelongsToMany = array(
        'InterferingType' => array(
            'className' => 'InterferingType',
            'joinTable' => 'interfering_type_event_type',
            'foreignKey' => 'interfering_type_id',
            'associationForeignKey' => 'event_type_id',
            'with' => 'InterferingTypeEventType',
        ),
        'EventTypeCategory' => array(
            'className' => 'EventTypeCategory',
            'joinTable' => 'event_type_category_event_type',
            'foreignKey' => 'event_type_category_id',
            'associationForeignKey' => 'event_type_id',
            'with' => 'EventTypeCategoryEventType',
        )
    );

    public function afterSave($created, $options = Array())
    {
        if (!empty($this->data['EventType']['interfering_types'])) {
            $this->InterferingTypeEventType->deleteAll(array('InterferingTypeEventType.event_type_id' => $this->id),
                false);
            if (!empty($this->data['EventType']['interfering_types'][0])) {
                foreach ($this->data['EventType']['interfering_types'] as $type) {
                    $this->InterferingTypeEventType->create();
                    $this->InterferingTypeEventType->save(array(
                        'event_type_id' => $this->id,
                        'interfering_type_id' => $type
                    ));
                }
            }
        }
        if (!empty($this->data['EventType']['event_type_categories'])) {
            $this->EventTypeCategoryEventType->deleteAll(array('EventTypeCategoryEventType.event_type_id' => $this->id),
                false);
            if (!empty($this->data['EventType']['event_type_categories'])) {
              /*  foreach ($this->data['EventType']['event_type_categories'] as $type) {
                    $this->EventTypeCategoryEventType->create();
                    $this->EventTypeCategoryEventType->save(array(
                        'event_type_id' => $this->id,
                        'event_type_category_id' => $type
                    ));
                } */
                $type = $this->data['EventType']['event_type_categories'];
                $this->EventTypeCategoryEventType->create();
                $this->EventTypeCategoryEventType->save(array(
                    'event_type_id' => $this->id,
                    'event_type_category_id' => $type
                ));
            }
        }
        return true;
    }

    /**
     * Get event types list
     *
     * @param string|null $typeSelect
     * @param int|null $recursive
     * @param array|null $fields
     * @param array|null $condition
     *
     * @return array $eventTypes
     */
    public function getEventTypes($typeSelect = null, $recursive = null, $fields = null, $condition = null)
    {

        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        if (empty($fields)) {
            $fields = array('EventType.id', 'EventType.name');
        }
        if (empty($condition)) {
            $condition = array('EventType.id > 0');
            $eventTypes = $this->find(
                $typeSelect,
                array(
                    'order' => 'EventType.code ASC, EventType.name ASC',
                    'recursive' => $recursive,
                    'fields' => $fields,
                    'conditions' => $condition
                )
            );
        }else {
            $conditionGeneral = array('EventType.id > 0');
            $condition = array_merge($conditionGeneral, $condition);
            $eventTypes = $this->find(
                $typeSelect,
                array(
                    'order' => 'EventType.code ASC, EventType.name ASC',
                    'recursive' => $recursive,
                    'fields' => $fields,
                    'conditions' => $condition,
                    'joins'=>array(
                        array(
                            'table' => 'event_type_category_event_type',
                            'type' => 'left',
                            'alias' => 'EventTypeCategoryEventType',
                            'conditions' => array('EventTypeCategoryEventType.event_type_id = EventType.id')
                        ),
                    )
                )
            );
        }

        return $eventTypes;
    }

    /**
     * Get event types by id
     *
     * @param int $typeId
     * @param string|null $typeSelect
     *
     * @return array $eventType
     */
    public function getEventTypeById($typeId, $typeSelect = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "first";
        }
        $eventType = $this->find(
            $typeSelect,
            array(
                'conditions' => array('id' => $typeId),
                'fields' => array(
                    'EventType.id',
                    'EventType.code',
                    'EventType.name',
                    'EventType.transact_type_id',
                    'EventType.many_interferings',
                    'EventType.with_date'
                ),
                'recursive' => -1
            )
        );

        return $eventType;
    }

    /**
     * Get event types by ids
     *
     * @param array $typeIds
     *
     * @return array $eventTypes
     */
    public function getEventTypeByIds($typeIds)
    {
        $eventTypes = $this->find(
            'all',
            array(
                'conditions' => array('id' => $typeIds),
                'recursive' => 2
            )
        );
        return $eventTypes;
    }

    /**
     * Get event types by ids negation
     *
     * @param array $eventTypeIds
     *
     * @return array $eventTypes
     */
    public function getEventTypeByIdsNegation($eventTypeIds)
    {
        $eventTypes = $this->find(
            'list',
            array(
                'conditions' => array('EventType.id !=' => $eventTypeIds),
                'recursive' => -1
            )
        );
        return $eventTypes;
    }

    public function getEventProducts($eventId){
        $eventProducts = $this->find('first',
            array(
                'recursive' => -2,
                'paramType' => 'querystring',
                'conditions' => array('EventType.' . $this->primaryKey => $eventId),
                'joins' => array(
                    array(
                        'table' => 'event_type_products',
                        'type' => 'left',
                        'alias' => 'EventTypeProducts',
                        'conditions' => array('EventTypeProducts.event_type_id = EventType.id')
                    ),
                )
            ));
        return $eventProducts;
    }

}
