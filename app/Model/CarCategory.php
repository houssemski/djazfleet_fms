<?php

App::uses('AppModel', 'Model');

/**
 * CarCategory Model
 *
 * @property Car $Car
 */
class CarCategory extends AppModel
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
        'price' => array(
            'decimal' => array(
                'rule' => array('decimal'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                'required' => false,
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
            'foreignKey' => 'car_category_id',
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
            'foreignKey' => 'car_category_id',
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
     * Get all car categories
     *
     * @param int|null $recursive
     * @param string $typeSelect
     *
     * @return array $carCategories
     */
    public function getCarCategories($recursive = null, $typeSelect= null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (isset($recursive) && !empty($recursive)) {
            $carCategories = $this->find(
                $typeSelect,

                array('order' => 'CarCategory.code ASC, CarCategory.name ASC',
                    'recursive' => $recursive,
                    'fields'=>array('CarCategory.id', 'CarCategory.name')
                )
            );
        } else {
            $carCategories = $this->find(
                $typeSelect,
                array('order' => 'CarCategory.code ASC, CarCategory.name ASC',
                    'recursive' => '-1',
                    'fields'=>array('CarCategory.id', 'CarCategory.name')
                )
            );
        }
        return $carCategories;
    }

    /**
     * Get car category by id
     *
     * @param int $carCategoryId
     *
     * @return array $carCategory
     */
    public function getCarCategoryById($carCategoryId)
    {
        $carCategory = $this->find('first', array(
            'conditions' => array('CarCategory.id' => $carCategoryId),
            'recursive' => -1,
            'fields' => array('CarCategory.id', 'CarCategory.code', 'CarCategory.name')
        ));
        return $carCategory;
    }

    /**
     * Get car categories by ids negation
     *
     * @param array $carCategoryIds
     *
     * @return array $carCategories
     */
    public function getCarCategoriesByIdsNegation($carCategoryIds)
    {
        $carCategories = $this->find(
            'list',
            array(
                'order' => 'code ASC, name ASC',
                'conditions' => array('CarCategory.id !=' => $carCategoryIds),
                'recursive' => -1
            )
        );
        return $carCategories;
    }
    /**
     * Get car category id by name
     *
     * @param array $carCategoryIds
     *
     * @return array $carCategories
     */
    public function getOrCreateCarCategoryIdByName($carCategoryName, $userId)
    {   
        $carCategory = $this->find(
            'list',
            array(
                'conditions' => array('CarCategory.name' => $carCategoryName),
            )
        );
        if(empty($carCategory)){
            return $this->createCarCategoryByName($carCategoryName, $userId);
        }
        return !empty($carCategory) && !empty(array_keys($carCategory)) && isset(array_keys($carCategory)[0]) ? array_keys($carCategory)[0] : null;
    }

    public function createCarCategoryByName($carCategoryName, $userId)
    {
        if(!empty($carCategoryName)){
            $this->create();
            $result = $this->save(array(
                'code' => $carCategoryName,
                'name' => $carCategoryName,
                'user_id' => $userId,
            ));
            if($result && isset($result['CarCategory']) && isset($result['CarCategory']['id'])){
                return $result['CarCategory']['id'];
            }else{
                return null;
            }
        }
        return null;
    }

}
