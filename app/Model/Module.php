<?php
App::uses('AppModel', 'Model');
/**
 * Mark Model
 *
 * @property Action $Action
 */
class Module extends AppModel {


    public $displayField = 'name';

    public $hasMany = array(
        'SubModule' => array(
            'className' => 'SubModule',
            'foreignKey' => 'module_id',
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

}