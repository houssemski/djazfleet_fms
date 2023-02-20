<?php

App::uses('AppModel', 'Model');
/**
 * Model Model
 *
 * @property Mark $Mark
 */
class Carmodel extends AppModel {

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
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Mark' => array(
            'className' => 'Mark',
            'foreignKey' => 'mark_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
        /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Car' => array(
            'className' => 'Car',
            'foreignKey' => 'carmodel_id',
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

    /**
     * Get all car models
     *
     * @param int|null $recursive
     *
     * @return array $carmodels
     */
    public function getCarModels($recursive = null)
    {
        if (isset($recursive) && !empty($recursive)) {
            $carmodels = $this->find(
                'list',
                array('order' => 'Carmodel.code ASC, Carmodel.name ASC', 'recursive' => $recursive)
            );
        } else {
            $carmodels = $this->find(
                'list',
                array('order' => 'Carmodel.code ASC, Carmodel.name ASC', 'recursive' => '-1')
            );
        }
        return $carmodels;
    }

    /**
     * Get all car models by marks
     *
     * @param int $markId
     * @param int|null $recursive
     *
     * @return array $carmodels
     */
    public function getCarModelsByMark($markId, $recursive = null)
    {
        if (isset($recursive) && !empty($recursive)) {
            $carmodels = $this->find(
                'list',
                array(
                    'conditions' => array('mark_id' => $markId),
                    'order' => 'Carmodel.code ASC, Carmodel.name ASC',
                    'recursive' => $recursive
                )
            );
        } else {
            $carmodels = $this->find(
                'list',
                array(
                    'conditions' => array('mark_id' => $markId),
                    'order' => 'Carmodel.code ASC, Carmodel.name ASC',
                    'recursive' => '-1'
                )
            );
        }
        return $carmodels;
    }

}
