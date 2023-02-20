<?php
App::uses('AppModel', 'Model');

/**
 * EventEventType Model
 *
 * @property EventEventType $EventEventType
 */
class EventEventType extends AppModel
{


    public $displayField = 'name';

    public $belongsTo = array(
        'Event' => array(
            'className' => 'Event',
            'foreignKey' => 'event_id',
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
     * Get event type ids list by event id
     *
     * @param int $eventId
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $eventTypeIds
     */
    public function getEventTypeIds($eventId, $typeSelect = null, $recursive = null)
    {

        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $eventTypeIds = $this->find(
            $typeSelect,
            array(
                'fields' => 'EventEventType.event_type_id',
                'recursive' => $recursive,
                'conditions' => array('EventEventType.event_id' => $eventId)
            )
        );

        return $eventTypeIds;
    }
    /**
     * Get event ids list by event type id
     *
     * @param int $eventTypeId
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $eventIds
     */
    public function getEventIds($eventTypeId, $typeSelect = null, $recursive = null)
    {

        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $eventIds = $this->find(
            $typeSelect,
            array(
                'recursive' => $recursive,
                'conditions' => array('EventEventType.event_type_id' => $eventTypeId)
            )
        );

        return $eventIds;
    }
    /**
     * Get events by conditions
     *
     * @param array|null $conditions
     *
     * @return array $events
     */
    public function getEventsByCond($conditions)
    {
        $events = $this->find('all', array(
            'conditions' => $conditions,
            'paramType' => 'querystring',
            'recursive' => -1, // should be used with joins

            'order' => array('Event.id' => 'DESC'),
            'fields' => array(
                'Event.code',
                'Event.id',
                'Event.date',
                'Event.next_date',
                'Event.km',
                'Event.next_km',
                'Event.cost',
                'Customer.id',
                'Customer.first_name',
                'Customer.last_name',
                'Customer.company',
                'Interfering.name',
                'Car.code',
                'Car.immatr_prov',
                'Car.immatr_def',
                'Carmodel.name',
                'EventType.name'
            ),
            'joins' => array(
                array(
                    'table' => 'event',
                    'type' => 'left',
                    'alias' => 'Event',
                    'conditions' => array('EventEventType.event_id = Event.id')
                ),
                array(
                    'table' => 'event_types',
                    'type' => 'left',
                    'alias' => 'EventType',
                    'conditions' => array('EventEventType.event_type_id = EventType.id')
                ),
                array(
                    'table' => 'car',
                    'type' => 'left',
                    'alias' => 'Car',
                    'conditions' => array('Event.car_id = Car.id')
                ),
                array(
                    'table' => 'customers',
                    'type' => 'left',
                    'alias' => 'Customer',
                    'conditions' => array('Event.customer_id = Customer.id')
                ),
                array(
                    'table' => 'interferings',
                    'type' => 'left',
                    'alias' => 'Interfering',
                    'conditions' => array('Event.interfering_id = Interfering.id')
                ),
                array(
                    'table' => 'carmodels',
                    'type' => 'left',
                    'alias' => 'Carmodel',
                    'conditions' => array('Car.carmodel_id = Carmodel.id')
                )
            )
        ));

        return $events;
    }

}