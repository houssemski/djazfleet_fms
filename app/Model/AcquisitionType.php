<?php

App::uses('AppModel', 'Model');

/**
 * AcquisitionType Model
 *
 * 
 */
class AcquisitionType extends AppModel {

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
            '
' => array(
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
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Car' => array(
            'className' => 'Car',
            'foreignKey' => 'acquisition_type_id',
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
     * Get all acquisition types
     *
     * @param string $typeSelect
     * @param int|null $recursive
     *
     * @return array $acquisitionTypes
     */
    public function getAcquisitionTypes($typeSelect, $recursive = null)
    {

        if (isset($recursive) && !empty($recursive)) {
            $acquisitionTypes = $this->find(
                $typeSelect,
                array(
                    'conditions' => 'AcquisitionType.id != 0',
                    'order' => 'AcquisitionType.code ASC, AcquisitionType.name ASC',
                    'recursive' => $recursive
                )
            );
        } else {
            $acquisitionTypes = $this->find(
                $typeSelect,
                array(
                    'conditions' => 'AcquisitionType.id != 0',
                    'order' => 'AcquisitionType.code ASC, AcquisitionType.name ASC',
                    'recursive' => '-1'
                )
            );
        }
        return $acquisitionTypes;
    }

    /**
     * Get acquisition types by ids
     *
     * @param array $ids
     *
     * @return array $acquisitionTypes
     */
    public function getAcquisitionTypesByIds($ids)
    {

        $acquisitionTypes = $this->find(
            'list',
            array(
                'order' => 'AcquisitionType.code ASC, AcquisitionType.name ASC',
                'conditions' => array('AcquisitionType.id' => $ids),
                'recursive' => -1
            )
        );
        return $acquisitionTypes;
    }

}
