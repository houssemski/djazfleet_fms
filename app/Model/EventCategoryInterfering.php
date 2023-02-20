<?php

App::uses('AppModel', 'Model');

/**
 * OptionReservation Model
 *
 */
class EventCategoryInterfering extends AppModel
{

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'event_category_interfering';

    public $belongsTo = array(

        'Event' => array(
            'className' => 'Event',
            'foreignKey' => 'event_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'EventTypeCategory' => array(
            'className' => 'EventTypeCategory',
            'foreignKey' => 'event_type_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Interfering' => array(
            'className' => 'Interfering',
            'foreignKey' => 'interfering_id0',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Interfering2' => array(
            'className' => 'Interfering',
            'foreignKey' => 'interfering_id1',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Interfering3' => array(
            'className' => 'Interfering',
            'foreignKey' => 'interfering_id2',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * Get items by interfering
     *
     * @param int $interferingId
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $eventCategoryInterferings
     */
    public function getItemsByInterfering($interferingId, $typeSelect = null, $recursive = null)
    {

        if (empty($typeSelect)) {
            $typeSelect = "first";
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $eventCategoryInterferings = $this->find(
            $typeSelect,
            array(
                'recursive' => $recursive,
                'conditions' => array(
                    'OR' => array(
                        "EventCategoryInterfering.interfering_id0 =" => $interferingId,
                        "EventCategoryInterfering.interfering_id2 =" => $interferingId,
                        "EventCategoryInterfering.interfering_id1 =" => $interferingId
                    )
                )
            ));

        return $eventCategoryInterferings;
    }
}