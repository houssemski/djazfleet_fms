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
class EventTypeProduct extends AppModel
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
        'EventType' => array(
            'className' => 'EventType',
            'foreignKey' => 'event_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

    );
    //The Associations below have been created with all possible keys, those that are not needed can be removed




}
