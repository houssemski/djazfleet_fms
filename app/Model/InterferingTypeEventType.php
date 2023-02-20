<?php

App::uses('AppModel', 'Model');

/**
 * InterferingTypeEventType Model
 *
 */
class InterferingTypeEventType extends AppModel
{

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'interfering_type_event_type';

    public $belongsTo = array(
        'InterferingType' => array(
            'className' => 'InterferingType',
            'foreignKey' => 'interfering_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'EventType' => array(
            'className' => 'EventType',
            'foreignKey' => 'event_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * Get interfering types by event type id
     *
     * @param $eventTypeId
     *
     * @return array $interferingTypes
     */
    public function getInterferingTypeByEventType($eventTypeId)
    {
        $interferingTypes = $this->find('list', array(
            'recursive' => -1,
            'fields' => array('interfering_type_id'),
            'conditions' => array('InterferingTypeEventType.event_type_id' => $eventTypeId)
        ));

        return $interferingTypes;
    }

}
