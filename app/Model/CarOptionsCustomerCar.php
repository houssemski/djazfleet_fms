<?php

App::uses('AppModel', 'Model');

/**
 * CarOptionsCustomerCar Model
 *
 */
class CarOptionsCustomerCar extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'car_options_customer_car';

    /**
     * Get items by foreign key
     *
     * @param int $id
     * @param string $modelField
     *
     * @return array $carOptionsCustomerCar
     */
    public function getItemByForeignKey($id, $modelField)
    {
        $carOptionsCustomerCar = $this->find(
            'first',
            array(
                'conditions'=>array($modelField => $id),
                'fields' => array('CarOptionsCustomerCar.id'),
                'recursive'=>-1
            ));
        return $carOptionsCustomerCar;
    }

}
