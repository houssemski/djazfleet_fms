<?php

App::uses('AppModel', 'Model');

/**
 *
 *
 * @property Car $Car
 */
class Price extends AppModel
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

        'detail_ride_id' => array(
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

    public $validatePricingTonnage = array(

        'tonnage_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

        'km_from' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

        'km_to' => array(
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
    public $belongsTo = array(

        'DetailRide' => array(
            'className' => 'DetailRide',
            'foreignKey' => 'detail_ride_id'
        ),
        'Supplier' => array(
            'className' => 'Supplier',
            'foreignKey' => 'supplier_id'
        ),
        'SupplierCategory' => array(
            'className' => 'SupplierCategory',
            'foreignKey' => 'supplier_category_id'
        ),
    );


    public $hasMany = array(
        'PriceRideCategory' => array(
            'className' => 'PriceRideCategory',
            'foreignKey' => 'price_id',
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
     * @param $detailRideId
     * @param null $clientId
     * @param null $rideCategoryId
     * @param null $supplierCategoryId
     * @param int $typePricing
     * @param int $distance
     * @param null $tonnageId
     * @param null $serviceId
     * @return array|null
     */
    public function getPriceByParams($detailRideId, $clientId=null, 
	$rideCategoryId=null, $supplierCategoryId = null, $typePricing = 1,
    $distance = 0 ,$tonnageId = null, $serviceId=null)
    {


		date_default_timezone_set("Africa/Algiers");
        $currentDate = date("Y-m-d");
        if($typePricing==1){
            $conditions =  array('Price.detail_ride_id' => $detailRideId,
                'OR'=>array(
                    array(
                        'PriceRideCategory.start_date <= '=>$currentDate,
                        'PriceRideCategory.end_date >= '=>$currentDate,
                    ),
                    array(
                        'PriceRideCategory.start_date <= '=>$currentDate,
                        'PriceRideCategory.end_date is NULL ',
                    ),
                    array(
                        'PriceRideCategory.start_date is NULL ',
                        'PriceRideCategory.end_date >= '=>$currentDate,
                    ),
                    array(
                        'PriceRideCategory.start_date is NULL ',
                        'PriceRideCategory.end_date IS null ',
                    )
                ),
            );
        }else {
            $conditions =  array('Price.tonnage_id' => $tonnageId, 'Price.km_from <='=>$distance ,'Price.km_to  >='=>$distance ,
                'OR'=>array(
                    array(
                        'PriceRideCategory.start_date <= '=>$currentDate,
                        'PriceRideCategory.end_date >= '=>$currentDate,
                    ),
                    array(
                        'PriceRideCategory.start_date <= '=>$currentDate,
                        'PriceRideCategory.end_date is NULL ',
                    ),
                    array(
                        'PriceRideCategory.start_date is NULL ',
                        'PriceRideCategory.end_date >= '=>$currentDate,
                    ),
                    array(
                        'PriceRideCategory.start_date is NULL ',
                        'PriceRideCategory.end_date IS null ',
                    )
                ),
            );
        }


        if(!empty($clientId)){
            $conditions['Price.supplier_id'] = $clientId;
        }


            $conditions['Price.service_id'] = $serviceId;

		if(!empty($supplierCategoryId)){
            $conditions ['Price.supplier_category_id'] = $supplierCategoryId;
        }
        if(!empty($rideCategoryId)){
            $conditions['PriceRideCategory.ride_category_id'] = $rideCategoryId;
        }
        $price = $this->find('first',
            array(
                'conditions' => $conditions,
                'joins' => array(
                    array(
                        'table' => 'price_ride_categories',
                        'type' => 'left',
                        'alias' => 'PriceRideCategory',
                        'conditions' => array('PriceRideCategory.price_id = Price.id')
                    ),
                ),
                'recursive' => -1,
                'fields' => array(
                    'PriceRideCategory.price_ht',
                    'PriceRideCategory.price_ht_night',
                    'PriceRideCategory.id',
                    'PriceRideCategory.start_date',
                    'PriceRideCategory.end_date',
                    'Price.id',
                    'PriceRideCategory.price_return',
					'PriceRideCategory.pourcentage_price_return'
                )
            ));
        return $price;

    }


}