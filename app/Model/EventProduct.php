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
class EventProduct extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(


    );

    public $belongsTo = array(
        'Event' => array(
            'className' => 'Event',
            'foreignKey' => 'event_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

    );
    //The Associations below have been created with all possible keys, those that are not needed can be removed




}
