<?php

App::uses('AppModel', 'Model');

/**
 * EventTypeCategoryEventType Model
 *
 */
class EventTypeCategoryEventType extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'event_type_category_event_type';

    public $belongsTo = array(
        'EventTypeCategory' => array(
            'className' => 'EventTypeCategory',
            'foreignKey' => 'event_type_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * Get event categories by eventTypeId without administrative event category
     *
     * @param int $eventTypeId
     *
     * @return array $eventCategories
     */
    public function getEventCategoriesByEventType($eventTypeId)
    {
        $eventCategories = $this->find(
            'all',
            array(
                'conditions' => array(
                    'EventTypeCategoryEventType.event_type_id' => $eventTypeId,
                    'EventTypeCategoryEventType.event_type_category_id !=' => 8
                ),
                'fields' => array('EventTypeCategoryEventType.event_type_category_id'),
                'recursive' => -1
            )
        );
        return $eventCategories;
    }

    /**
     * Get event type category by event type id
     *
     * @param $eventTypeId
     *
     * @return array $eventTypeCategories
     */
    public function getEventTypeCategoryByEventType($eventTypeId)
    {
        $eventTypeCategories = $this->find('all', array(
            'recursive' => -1,
            'fields' => array('EventTypeCategory.id','EventTypeCategory.name'),
            'conditions' => array('EventTypeCategoryEventType.event_type_id' => $eventTypeId),
            'joins'=>array(
                array(
                    'table' => 'event_type_categories',
                    'type' => 'left',
                    'alias' => 'EventTypeCategory',
                    'conditions' => array('EventTypeCategory.id = EventTypeCategoryEventType.event_type_category_id')
                ),
            ),
            'Group' => array('EventTypeCategory.id'),

        ));

        return $eventTypeCategories;
    }

}