<?php
App::uses('AppModel', 'Model');
/**
 * Mark Model
 *
 * @property Action $Action
 */
class SubModule extends AppModel {


    public $displayField = 'name';

    public $hasMany = array(
        'Interface' => array(
            'className' => 'Interface',
            'foreignKey' => 'sub_module_id',
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