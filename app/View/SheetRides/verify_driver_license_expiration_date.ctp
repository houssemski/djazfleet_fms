<?php
if (!empty($customer)){
   if(!empty($customer[0]['Customer']['driver_license_expires_date1'])
       && ($customer[0]['Customer']['driver_license_expires_date1'] <=$driverLicenseLimitValue)) { ?>
       <p style='color: #a94442;'>       <?php  echo __("This driver's driver's license category A expires").' '. $this->Time->format($customer[0]['Customer']['driver_license_expires_date1'], '%d-%m-%Y')?> </p>

      <?php }

    if(!empty($customer[0]['Customer']['driver_license_expires_date2'])
        && ($customer[0]['Customer']['driver_license_expires_date2'] <=$driverLicenseLimitValue)
    ) { ?>
       <p style='color: #a94442;'>       <?php  echo __("This driver's driver's license category B expires").' '. $this->Time->format($customer[0]['Customer']['driver_license_expires_date2'], '%d-%m-%Y')?> </p>


      <?php }

      if(!empty($customer[0]['Customer']['driver_license_expires_date3']

    )
        && ($customer[0]['Customer']['driver_license_expires_date3'] <=$driverLicenseLimitValue)
    ) { ?>
       <p style='color: #a94442;'>       <?php  echo __("This driver's driver's license category C expires").' '. $this->Time->format($customer[0]['Customer']['driver_license_expires_date3'], '%d-%m-%Y')?> </p>

      <?php }

      if(!empty($customer[0]['Customer']['driver_license_expires_date4'])
        && ($customer[0]['Customer']['driver_license_expires_date4'] <=$driverLicenseLimitValue)
    ) { ?>
       <p style='color: #a94442;'>       <?php  echo __("This driver's driver's license category D expires").' '. $this->Time->format($customer[0]['Customer']['driver_license_expires_date4'], '%d-%m-%Y')?> </p>

      <?php }

      if(!empty($customer[0]['Customer']['driver_license_expires_date5'])
        && ($customer[0]['Customer']['driver_license_expires_date5'] <=$driverLicenseLimitValue)
    ) { ?>
       <p style='color: #a94442;'>       <?php  echo __("This driver's driver's license category E expires").' '. $this->Time->format($customer[0]['Customer']['driver_license_expires_date5'], '%d-%m-%Y')?> </p>

      <?php }

      if(!empty($customer[0]['Customer']['driver_license_expires_date6'])
        && ($customer[0]['Customer']['driver_license_expires_date6'] <=$driverLicenseLimitValue)
    ) { ?>
       <p style='color: #a94442;'>       <?php  echo __("This driver's driver's license category F expires").' '. $this->Time->format($customer[0]['Customer']['driver_license_expires_date5'], '%d-%m-%Y')?> </p>

      <?php }

}