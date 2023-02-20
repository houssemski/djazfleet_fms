<?php
App::uses('AppModel', 'Model');
/**
 * Parc Model
 *
 */
class Warehouse extends AppModel {

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
                'allowEmpty' => true,
                'required' => false,
                'last' => true, // Stop validation after this rule
            ),
        ),
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

    public $hasMany = array(
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'warehouse_id',
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
     * Get Warehous list
     *
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $warehouses
     */
    public function getWarehouses($typeSelect = null, $recursive = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $warehouses = $this->find(
            $typeSelect,
            array(
                'order' => 'Warehouse.code ASC, Warehouse.name ASC',
                'recursive' => $recursive
            )
        );
        return $warehouses;
    }

}
