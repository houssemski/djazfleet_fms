<?php
App::uses('AppModel', 'Model');

/**
 * Mark Model
 *
 * @property Action $Action
 */
class Affectationpv extends AppModel
{

    public $belongsTo = array(

        'CustomerCar' => array(
            'className' => 'CustomerCar',
            'foreignKey' => 'customer_car_id'
        ),

    );


    /**
     * Get affectation pv
     *
     * @param int $customerCarId
     * @param int $reception
     *
     * @return array $affectationpv
     */
    public function getAffectationPv($customerCarId, $reception)
    {
        $affectationpv = $this->find(
            'first',
            array(
                'conditions' => array(
                    'Affectationpv.customer_car_id' => $customerCarId,
                    'Affectationpv.reception' => $reception
                ),
                'recursive' => -1
            )
        );
        return $affectationpv;
    }

}