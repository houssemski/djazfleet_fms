<?php

App::uses('AppModel', 'Model');

/**
 * Affiliate Model
 *
 * 
 */
class Affiliate extends AppModel {

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
        'Customer' => array(
            'className' => 'Customer',
            'foreignKey' => 'affiliate_id',
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
     * Get employee affiliates
     *
     * @param string $typeSelect
     *
     * @return array $affiliates
     */
    public function getEmployeeAffiliates($typeSelect = null) {
        if(empty($typeSelect)){
            $typeSelect = 'list';
        }

        $employeeAffiliates = $this->find(
            $typeSelect,
            array(
                'order' => array('Affiliate.code ASC, Affiliate.name ASC'),
                'recursive' => -1
            )
        );
        return $employeeAffiliates;
    }
	
	
	    /**
     * Get all parcs
     *
     * @param string $typeSelect
     * @param int|null $recursive
     *
     * @return array $parcs
     */
    public function getAffiliates($typeSelect, $recursive = null)
    {

        if (isset($recursive) && !empty($recursive)) {
            $affiliates = $this->find(
                $typeSelect,
                array(
                    'conditions' => 'Affiliate.id != 0',
                    'order' => 'Affiliate.code ASC, Affiliate.name ASC',
                    'recursive' => $recursive
                )
            );
        } else {
            $affiliates = $this->find(
                $typeSelect,
                array(
                    'conditions' => 'Affiliate.id != 0',
                    'order' => 'Affiliate.code ASC, Affiliate.name ASC',
                    'recursive' => '-1'
                )
            );
        }
        return $affiliates;
    }


}
