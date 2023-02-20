<?php

App::uses('AppModel', 'Model');

/**
 * Fuel Model
 *
 * @property Car $Car
 */
class Tank extends AppModel
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
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
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

        'fuel_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

        'capacity' => array(
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
        'TankOperation' => array(
            'className' => 'TankOperation',
            'foreignKey' => 'tank_id',
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

    public $belongsTo = array(
        'Fuel' => array(
            'className' => 'Fuel',
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
     * Get all tanks
     *
     * @param string $typeSelect
     * @param int|null $recursive
     *
     * @return array $tanks
     */
    public function getTanks($typeSelect, $recursive = null)
    {

        if (isset($recursive) && !empty($recursive)) {
            $tanks = $this->find(
                $typeSelect,
                array(
                    'conditions' => 'Tank.id != 0',
                    'order' => 'Tank.code ASC, Fuel.name ASC',
                    'recursive' => $recursive
                )
            );
        } else {
            $tanks = $this->find(
                $typeSelect,
                array(
                    'conditions' => 'Tank.id != 0',
                    'order' => 'Tank.code ASC, Tank.name ASC',
                    'recursive' => '-1'
                )
            );
        }
        return $tanks;
    }

    /**
     * Get tank by code
     *
     * @param string $tankCode
     *
     * @return array $tank
     */
    public function getTankByCode($tankCode)
    {
        $tank = $this->find(
            'first',
            array(
                'conditions' => array('Tank.code' => $tankCode),
                'recursive' => -1,
                'fields' => array('Tank.id', 'Tank.code', 'Tank.name', 'Tank.capacity', 'Tank.liter')
            )
        );
        return $tank;
    }

    /**
     * Get tank by id
     *
     * @param string $tankId
     *
     * @return array $tank
     */
    public function getTankById($tankId)
    {
        $tank = $this->find(
            'first',
            array(
                'conditions' => array('Tank.id' => $tankId),
                'recursive' => -1,
                'fields' => array('Tank.id', 'Tank.code', 'Tank.name', 'Tank.capacity', 'Tank.liter')
            )
        );
        return $tank;
    }

    public function updateTankLiter($tankId = null)
    {
        $tankOperations = $this->TankOperation->find('all',
            array(
                'conditions' => array('TankOperation.tank_id' => $tankId),
                'recursive' => -1,
                'fields' => array(
                    'sum(TankOperation.liter) as total_liter'
                ),
            ));

        $totalLiter = $tankOperations[0][0]['total_liter'];
        $this->id = $tankId;
        $this->saveField('liter', $totalLiter);

    }

    public function getTanksByConditions($typeSelect= null, $conditions = null, $order = null){
        if($order == null){
            $order = 'name ASC';
            $fields = array('Tank.id','Tank.name');
        }else {
            $fields = array('Tank.id','Tank.name','Tank.liter');
        }

        $tanks = $this->find($typeSelect, array(
                    'order' =>$order,
                    'conditions'=>$conditions,
                    'recursive'=>-1,
                    'fields'=>$fields
                        ));
        return $tanks;
    }
	
	public function decreaseLiterTank($tankId, $consumptionLiter){
			$tank = $this->getTankById($tankId);
			$liter = $tank['Tank']['liter']- $consumptionLiter;
			$this->id = $tankId;
			$this->saveField('liter', $liter);
	}

    public function decreaseLiterTankInEditConsumption($tankId, $consumptionLiter,$oldConsumtion){
        $consumptionLiter = $consumptionLiter - $oldConsumtion;
        $tank = $this->getTankById($tankId);
        $liter = $tank['Tank']['liter']- $consumptionLiter;
        $this->id = $tankId;
        $this->saveField('liter', $liter);
    }
	
	public function increaseLiterTank($tankId, $consumptionLiter){
			$tank = $this->getTankById($tankId);
			$liter = $tank['Tank']['liter']+ $consumptionLiter;
			$this->id = $tankId;
			$this->saveField('liter', $liter);
	}
}
