<?php

/**

 * @author kahina
 */
class Coupon extends AppModel
{

    public $displayField = 'serial_number';

      public $belongsTo = array(

        'FuelLog' => array(
            'className' => 'FuelLog',
            'foreignKey' => 'fuel_log_id'
        ),

    );

      public function getMinCouponAlert($minCoupon = null) {
      
    $query = "select COUNT(serial_number) as nb_coupons, (select count(used) from coupons where used=1) as coupons_used"
                    . " From coupons as Coupon "
                    . " having (nb_coupons-coupons_used) <= " .(int)$minCoupon ;
             
                 
        return $this->query($query);
      }

    /**
     * @param null $ids
     * @return mixed
     */
    public function getCouponsByIds($ids = null){
        $coupons = $this->find('all', array(
            'conditions' => array(
                "Coupon.id" => $ids
            )
        ));
        return $coupons;
    } /**
     * @param null $consumptionId
     * @return mixed
     */
    public function getCouponsByConsumptionId($consumptionId = null){
        $coupons = $this->find('all', array(
            'conditions' => array(
                "Coupon.consumption_id" => $consumptionId
            )
        ));
        return $coupons;
    }

    /**
     * @param null $ids
     * @param null $consumptionId
     * @param int $used
     */
    public function saveFields($ids = null, $consumptionId = null, $used = null){
		
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $this->id = $id;
                $this->saveField('consumption_id', $consumptionId);
                $this->saveField('used', $used);
            }
        }
    }


    public function updateCouponsConsumption($usedCouponsNumbers = null, $consumptionId = null)
    {

        $this->initializeCouponsConsumption($consumptionId);
        if (!empty($usedCouponsNumbers)) {
            $this->saveFields($usedCouponsNumbers, $consumptionId, 1);
        }

    }

    public function initializeCouponsConsumption($consumptionId = null)
    {
        $coupons = $this->getCouponsByConsumptionId($consumptionId);
        $ids = array();
        if (!empty($coupons)) {
            foreach ($coupons as $coupon) {
                $ids[] = $coupon['Coupon']['id'];
            }
            if (!empty($ids)) {
                $this->saveFields($ids, null, 0);
            }
        }
    }


    
}