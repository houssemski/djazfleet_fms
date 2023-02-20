<?php

App::uses('AppModel', 'Model');

/**
 * CarType Model
 *
 * @property Car $Car
 */
class CarType extends AppModel
{
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
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Car' => array(
            'className' => 'Car',
            'foreignKey' => 'car_type_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'CarTypeCarCategory' => array(
            'className' => 'CarTypeCarCategory',
            'foreignKey' => 'car_type_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),


    );

    /**
     * Get all car types
     *
     * @param int|null $recursive
     * @param string $typeSelect
     *
     * @return array $carTypes
     */
    public function getCarTypes($recursive = null, $typeSelect=null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }

        if (isset($recursive) && !empty($recursive)) {
            $carTypes = $this->find(
                $typeSelect,
                array('order' => 'CarType.code ASC, CarType.name ASC', 'recursive' => $recursive,
                    'fields'=>array('CarType.id', 'CarType.name')
                )

            );
        } else {
            $carTypes = $this->find(
                $typeSelect,
                array('order' => 'CarType.code ASC, CarType.name ASC', 'recursive' => '-1',
                    'fields'=>array('CarType.id', 'CarType.name')
                )

            );
        }

        return $carTypes;
    }

    /**
     * Get car type by id
     *
     * @param int $carTypeId
     *
     * @return array $carType
     */
    public function getCarTypeById($carTypeId)
    {
        $carType = $this->find(
            'first',
            array(
                'conditions' => array('CarType.id' => $carTypeId),
                'recursive' => -1,
                'fields' => array('CarType.id', 'CarType.code', 'CarType.name', 'CarType.average_speed')
            )
        );
        return $carType;
    }

    public function getCarTypeByConditions($conditions){
        $types = $this->find(
            'list',
            array(
                'conditions' => $conditions,
                'fields' => array('CarType.id', 'CarType.name'),
                'order' => 'CarType.name ASC',
                'joins' => array(
                    array(
                        'table' => 'car_type_car_categories',
                        'type' => 'left',
                        'alias' => 'CarTypeCarCategory',
                        'conditions' => array('CarTypeCarCategory.car_type_id = CarType.id')
                    )
                )
            ));
        return $types;
    }

}
