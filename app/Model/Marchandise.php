<?php
App::uses('AppModel', 'Model');
/**
 * Mark Model
 *
 *
 */
class Marchandise extends AppModel {
public $displayField = 'name';

 	public $validate = array(
	

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
       'weight' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'weight_palette' => array(
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

        



    );
	
	   public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
       
        'MarchandiseType' => array(
            'className' => 'MarchandiseType',
            'foreignKey' => 'marchandise_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'MarchandiseUnit' => array(
            'className' => 'MarchandiseUnit',
            'foreignKey' => 'marchandise_unit_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

        'Supplier' => array(
            'className' => 'Supplier',
            'foreignKey' => 'supplier_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

    );


    /**
     * Get marchandises
     *
     * @param string $typeSelect
     *
     * @return array $marchandises
     */
    public function getMarchandises($typeSelect = null) {
        if(empty($typeSelect)){
            $typeSelect = 'list';
        }

        $marchandises = $this->find(
            $typeSelect,
            array(
                'order' => array('Marchandise.wording ASC, Marchandise.name ASC'),
                'recursive' => -1
            )
        );
        return $marchandises;
    }
          

}
