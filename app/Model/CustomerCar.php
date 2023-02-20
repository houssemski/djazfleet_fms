<?php
App::uses('AppModel', 'Model');

/**
 * CustomerCar Model
 *
 * @property Car $Car
 * @property CarOptionsCustomerCar $CarOptionsCustomerCar
 * @property Customer $Customer
 */
class CustomerCar extends AppModel
{

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'customer_car';


    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $validate = array(
        'car_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'customer_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        // 'start' => array(
        //   'notEmpty' => array(
        //  'rule' => array('notEmpty'),
        //'message' => 'Your custom message here',
        // 'allowEmpty' => false,
        // 'required' => true,
        //'last' => false, // Stop validation after this rule
        //'on' => 'create', // Limit validation to 'create' or 'update' operations
        // ),
        //  ),
        //  'end' => array(
        //  'notEmpty' => array(
        //  'rule' => array('notEmpty'),
        // 'message' => 'veuillez saisir ce champs',
        //'allowEmpty' => false,
        //  'required' => true,
        //'last' => false, // Stop validation after this rule
        //'on' => 'create', // Limit validation to 'create' or 'update' operations
        //  ),
        // ),

    );

    public $validate_add_request = array(
        'car_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'customer_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'start' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //  'message' => 'Your custom message here',
                // 'allowEmpty' => false,
                //'required' => true,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'end' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                // 'message' => 'veuillez saisir ce champs',
                //'allowEmpty' => false,
                //'required' => true,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

    );

    public $validate_add_request_client = array(
        'car_type_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //  'message' => 'Your custom message here',
                // 'allowEmpty' => false,
                //'required' => true,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'customer_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'start' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //  'message' => 'Your custom message here',
                // 'allowEmpty' => false,
                //'required' => true,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'end' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                // 'message' => 'veuillez saisir ce champs',
                //'allowEmpty' => false,
                //'required' => true,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

    );
    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'CarOption' => array(
            'className' => 'CarOption',
            'joinTable' => 'car_options_customer_car',
            'foreignKey' => 'customer_car_id',
            'associationForeignKey' => 'car_option_id',
            'with' => 'CarOptionsCustomerCar',
        )
    );
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Car' => array(
            'className' => 'Car',
            'foreignKey' => 'car_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'CarType' => array(
            'className' => 'CarType',
            'foreignKey' => 'car_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Customer' => array(
            'className' => 'Customer',
            'foreignKey' => 'customer_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'CustomerGroup' => array(
            'className' => 'CustomerGroup',
            'foreignKey' => 'customer_group_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Zone' => array(
            'className' => 'Zone',
            'foreignKey' => 'zone_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'UserModifier' => array(
            'className' => 'User',
            'foreignKey' => 'modified_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    public function afterSave($created, $options = Array())
    {
        if (!empty($this->data['CustomerCar']['options'])) {
            $this->CarOptionsCustomerCar->deleteAll(array('CarOptionsCustomerCar.customer_car_id' => $this->id), false);
            if (!empty($this->data['CustomerCar']['options'][0])) {
                foreach ($this->data['CustomerCar']['options'] as $option) {
                    $this->CarOptionsCustomerCar->create();
                    $this->CarOptionsCustomerCar->save(array(
                        'customer_car_id' => $this->id,
                        'car_option_id' => $option
                    ));
                }
            }
        }
        return true;
    }


    public function getAllOpenedCustomerCars()
    {
        $customerCars = $this->find('all', array(
            'recursive' => -1,
            'conditions' => array('is_open' => 1),
            'fields' => array('id')
        ));
        return $customerCars;
    }

    /**
     * Get customer car by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array $customerCar
     */
    public function getCustomerCarByForeignKey($id, $modelField)
    {
        $customerCar = $this->find(
            'first',
            array(
                'conditions'=>array($modelField => $id),
                'fields' => array('CustomerCar.id'),
                'recursive'=>-1
            ));
        return $customerCar;
    }

}
