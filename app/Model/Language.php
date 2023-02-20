<?php

App::uses('AppModel', 'Model');

/**
 * CarCategory Model
 *
 * @property Car $Car
 */
class Language extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $useTable = 'languages';
    public $displayField = 'name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            'message' => '',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        )
    );

}
