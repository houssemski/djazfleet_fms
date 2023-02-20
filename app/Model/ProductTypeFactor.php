<?php

class ProductTypeFactor extends AppModel {

    public $displayField = 'name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(


    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */


    public $belongsTo = array(
        'ProductType' => array(
            'className' => 'ProductType',
            'foreignKey' => 'product_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

        'Factor' => array(
            'className' => 'Factor',
            'foreignKey' => 'factor_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),




    );

    /**
    $productTypeId
     */
    public function getInputFactorsByProductTypeId($productTypeId = null)
    {


        $factors = $this->find(
            'all',
            array(
                'recursive'=>-1,
                'order'=>array('Factor.id'),
                'fields'=> array('Factor.id','Factor.name','Factor.name_id'),
                'conditions' =>array('ProductTypeFactor.product_type_id'=>$productTypeId,
                    'Factor.factor_type = 1') ,
                'joins' => array(

                    array(
                        'table' => 'factors',
                        'type' => 'left',
                        'alias' => 'Factor',
                        'conditions' => array('ProductTypeFactor.factor_id = Factor.id')
                    ),

            ))
        );

        return $factors;
    }
    public function getSelectFactorsByProductTypeId($productTypeId = null)
    {


        $factors = $this->find(
            'all',
            array(
                'recursive'=>-1,
                'order'=>array('Factor.id'),
                'fields'=> array('Factor.id','Factor.name','Factor.name_id'),
                'conditions' =>array('ProductTypeFactor.product_type_id'=>$productTypeId,
                    'Factor.factor_type = 2') ,
                'joins' => array(

                    array(
                        'table' => 'factors',
                        'type' => 'left',
                        'alias' => 'Factor',
                        'conditions' => array('ProductTypeFactor.factor_id = Factor.id')
                    ),

            ))
        );

        return $factors;
    }

}