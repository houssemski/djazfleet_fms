<?php

App::uses('AppModel', 'Model');

/**
 * Fuel Model
 *
 * @property Car $Car
 */
class Fuel extends AppModel
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
            'foreignKey' => 'fuel_id',
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
     * Get all fuels
     *
     * @param string $typeSelect
     * @param int|null $recursive
     *
     * @return array $fuels
     */
    public function getFuels($typeSelect, $recursive = null)
    {

        if (isset($recursive) && !empty($recursive)) {
            $fuels = $this->find(
                $typeSelect,
                array(
                    'conditions' => 'Fuel.id != 0',
                    'order' => 'Fuel.code ASC, Fuel.name ASC',
                    'recursive' => $recursive
                )
            );
        } else {
            $fuels = $this->find(
                $typeSelect,
                array(
                    'conditions' => 'Fuel.id != 0',
                    'order' => 'Fuel.code ASC, Fuel.name ASC',
                    'recursive' => '-1'
                )
            );
        }
        return $fuels;
    }
    /**
     * Get fuel by code
     *
     * @param string $fuelCode
     *
     * @return array $fuel
     */
    public function getFuelByCode($fuelCode)
    {
        $fuel = $this->find(
            'first',
            array(
                'conditions' => array('Fuel.code' => $fuelCode),
                'recursive' => -1,
                'fields' => array('Fuel.id', 'Fuel.code', 'Fuel.name', 'Fuel.price')
            )
        );
        return $fuel;
    }

    public function getFuelById($fuelId)
    {
        $fuel = $this->find(
            'first',
            array(
                'conditions' => array('Fuel.id' => $fuelId),
                'recursive' => -1,
                'fields' => array('Fuel.id', 'Fuel.code', 'Fuel.name', 'Fuel.price')
            )
        );
        return $fuel;
    }

    public function getOrCreateCarFuelIdByName($fuelName, $userId)
    {
        $fuel = $this->find(
            'list',
            array(
                'conditions' => array('Fuel.name' => $fuelName),
            )
        );
        if(empty($fuel)){
            return $this->createFuelByName($fuelName, $userId);
        }
        return !empty($fuel) && !empty(array_keys($fuel)) && isset(array_keys($fuel)[0]) ? array_keys($fuel)[0] : null;
    }


    public function createFuelByName($fuelName, $userId)
    {
        if(!empty($fuelName)){
            $this->create();
            $result = $this->save(array(
                'code' => $fuelName,
                'name' => $fuelName,
                'user_id' => $userId,
            ));
            if($result && isset($result['Fuel']) && isset($result['Fuel']['id'])){
                return $result['Fuel']['id'];
            }else{
                return null;
            }
        }
        return null;
    }

}
