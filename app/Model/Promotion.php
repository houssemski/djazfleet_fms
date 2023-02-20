<?php

App::uses('AppModel', 'Model');

/**
 *
 *
 * @property Promotion $Promotion
 */
class Promotion extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */


    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(

      /*  'price_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
		
		'promotion_val' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),	
		
		'promotion_pourcentage' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),	
		
		'start_date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),	
		
		'end_date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
*/

    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $belongsTo = array(

        'Price' => array(
            'className' => 'Price',
            'foreignKey' => 'price_id'
        ),
        
      
    );


    public $hasMany = array(
   

    );

    /**
     * Get price by params
     *
     * @params int $detailRideId
     * @params int|null $clientId
     * @params int|null $rideCategoryId
     *
     * @return array|null $price
     */
    public function getCurrentPromotionWithPriceId($priceId)
    {
        date_default_timezone_set("Africa/Algiers");
        $currentDate = date("Y-m-d");
		$conditions =  array('Promotion.price_id' => $priceId, 
							'Promotion.start_date <= '=>$currentDate,
							'Promotion.end_date >= '=>$currentDate,
			);
        $promotion = $this->find('first',
            array(
                'conditions' => $conditions,
              
                'recursive' => -1,
                'fields' => array(
                    'Promotion.promotion_val',
                    'Promotion.promotion_return',
                    'Promotion.promotion_pourcentage',
                    'Promotion.id'
                )
            ));

        return $promotion;

    }
	
	public function getPromotionsByPriceId($priceId = null) {
		$promotions = $this->find('all',
            array(
                'conditions' => array('Promotion.price_id'=>$priceId),
              
                'recursive' => -1,
                'fields' => array(
                    'Promotion.promotion_val',
                    'Promotion.promotion_pourcentage',
                    'Promotion.start_date',
                    'Promotion.end_date',
                    'Promotion.price_id',
                    'Promotion.id'
                )
            ));

        return $promotions;
	}


}