<div class="side-bar right-bar">
    <a onclick="closeRightBar()" class="right-bar-toggle">
        <i class="zmdi zmdi-close-circle-o"></i>
    </a>
    <h4 class=""><?php echo __('Alerts') ?></h4>

    <div class="notification-list nicescroll">
        <ul class="list-group list-no-border user-list">

            <?php

            $cpt = 0;
            if (!empty($minCouponAlerts)) {
                if ($cpt <= 10) {

                    ?>
                    <li class="list-group-item"><!-- Task item -->

                    <?php echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>" . __('Number of coupons is less than') . "</span>
<span class='desc'>" . $minCouponAlert["mincoupons"][1] . "</span><span class='time'>" . $minCouponAlert["mincoupons"][2] . "%" . "</span></div>"
                        ,
                        array('controller' => 'events', 'action' => 'View',
                            $minCouponAlert["mincoupons"][0]),
                        array('escape' => false, 'class' => "user-list-item")
                    );
                    $cpt++;
                }
                ?>

                </li><!-- end task item -->
            <?php
            }

           /* if (!empty($assuranceAlerts)) {

                foreach ($assuranceAlerts as $assuranceAlert) {
                    if ($cpt <= 10) {
                        ?>
                        <li class="list-group-item active"><!-- Task item -->

                        <?php echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>" . __('Assurance') . "</span>
<span class='desc'>" . $assuranceAlert["Car"]['code'] . ' ' . $assuranceAlert["Carmodel"]['name'] . "</span></div>"
                            ,
                            array('controller' => 'events', 'action' => 'View',
                                $assuranceAlert["Event"]['id']),
                            array('escape' => false, 'class' => "user-list-item")
                        );
                        $cpt++;
                    }
                }
                ?>

                </li><!-- end task item -->
            <?php
            }


            if (!empty($controlAlerts)) {


                foreach ($controlAlerts as $controlAlert) {
                    if ($cpt <= 10) {

                        ?>
                        <li class="list-group-item"><!-- Task item -->

                        <?php echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>" . __('Controle') . "</span>
<span class='desc'>" . $controlAlert["Car"]['code'] . ' ' . $controlAlert["Carmodel"]['name'] . "</span></div>"
                            ,
                            array('controller' => 'events', 'action' => 'View',
                                $controlAlert["Event"]['id']),
                            array('escape' => false, 'class' => "user-list-item")
                        );
                        $cpt++;
                    }
                }
                ?>

                </li><!-- end task item -->
            <?php
            }


            if (!empty($vignetteAlerts)) {


                foreach ($vignetteAlerts as $vignetteAlert) {
                    if ($cpt <= 10) {

                        ?>
                        <li class="list-group-item active"><!-- Task item -->

                        <?php echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>" . __('Vignette') . "</span>
<span class='desc'>" . $vignetteAlert["Car"]['code'] . ' ' . $vignetteAlert["Carmodel"]['name'] . "</span></div>"
                            ,
                            array('controller' => 'events', 'action' => 'View',
                                $vignetteAlert["Event"]['id']),
                            array('escape' => false, 'class' => "user-list-item")
                        );
                        $cpt++;
                    }
                }
                ?>

                </li><!-- end task item -->
            <?php
            }


            if (!empty($vidangeAlerts)) {

                foreach ($vidangeAlerts as $vidangeAlert) {
                    if ($cpt <= 10) {

                        ?>
                        <li class="list-group-item"><!-- Task item -->

                        <?php echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>" . __('Vidange') . "</span>
<span class='desc'>" . $vidangeAlert["Car"]['code'] . ' ' . $vidangeAlert["Carmodel"]['name'] . "</span></div>"
                            ,
                            array('controller' => 'events', 'action' => 'View',
                                $vidangeAlert["Event"]["id"]),
                            array('escape' => false, 'class' => "user-list-item")
                        );
                        $cpt++;
                    }
                }
                ?>

                </li><!-- end task item -->
            <?php
            }
            if (!empty($vidangeHourAlerts)) {

                foreach ($vidangeHourAlerts as $vidangeHourAlert) {
                    if ($cpt <= 10) {

                        ?>
                        <li class="list-group-item"><!-- Task item -->

                        <?php echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>" . __('Vidange Heure') . "</span>
<span class='desc'>" . $vidangeAlert["Car"]['code'] . ' ' . $vidangeAlert["Carmodel"]['name'] . "</span></div>"
                            ,
                            array('controller' => 'events', 'action' => 'View',
                                $vidangeHourAlert["Event"]['id']),
                            array('escape' => false, 'class' => "user-list-item")
                        );
                        $cpt++;
                    }
                }
                ?>

                </li><!-- end task item -->
            <?php
            }

            if (!empty($dateAlerts)) {

                foreach ($dateAlerts as $dateAlert) {
                    if ($cpt <= 10) {

                        ?>
                        <li class="list-group-item active"><!-- Task item -->

                        <?php echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>" . __('Dates') . "</span>
<span class='desc'>" . $dateAlert["Car"]['code'] . ' ' . $dateAlert["Carmodel"]['name'] . "</span></div>"
                            ,
                            array('controller' => 'events', 'action' => 'View',
                                $dateAlert["Event"]['id']),
                            array('escape' => false, 'class' => "user-list-item")
                        );
                        $cpt++;
                    }
                }
                ?>

                </li><!-- end task item -->
            <?php
            }
            if (!empty($kmAlerts)) {

                foreach ($kmAlerts as $kmAlert) {
                    if ($cpt <= 10) {

                        ?>
                        <li class="list-group-item"><!-- Task item -->

                        <?php echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>" . __('Kms') . "</span>
<span class='desc'>" . $kmAlert["Car"]['code'] . ' ' . $kmAlert["Carmodel"]['name'] . "</span></div>"
                            ,
                            array('controller' => 'events', 'action' => 'View',
                                $kmAlert["Event"]['id']),
                            array('escape' => false, 'class' => "user-list-item")
                        );
                        $cpt++;
                    }
                }
                ?>

                </li><!-- end task item -->
            <?php
            }



           */

            if (!empty($administrativeAlerts)) {

                foreach ($administrativeAlerts as $administrativeAlert) {
                    if ($cpt <= 10) {

                        ?>
                        <li class="list-group-item"><!-- Task item -->

                        <?php echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>" . $administrativeAlert['EventType']['name'] . "</span>
<span class='desc'>" . $administrativeAlert["Car"]['immatr_def'] . ' ' . $administrativeAlert["Carmodel"]['name'] . "</span></div>"
                            ,
                            array('controller' => 'events', 'action' => 'View',
                                $administrativeAlert["Event"]['id']),
                            array('escape' => false, 'class' => "user-list-item")
                        );
                        $cpt++;
                    }
                }
                ?>

                </li><!-- end task item -->
                <?php
            }


            if (!empty($maintenanceAlerts)) {

                foreach ($maintenanceAlerts as $maintenanceAlert) {
                    if ($cpt <= 10) {

                        ?>
                        <li class="list-group-item"><!-- Task item -->

                        <?php echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>" . $maintenanceAlert['EventType']['name'] . "</span>
<span class='desc'>" . $maintenanceAlert["Car"]['immatr_def'] . ' ' . $maintenanceAlert["Carmodel"]['name'] . "</span></div>"
                            ,
                            array('controller' => 'events', 'action' => 'View',
                                $maintenanceAlert["Event"]['id']),
                            array('escape' => false, 'class' => "user-list-item")
                        );
                        $cpt++;
                    }
                }
                ?>

                </li><!-- end task item -->
                <?php
            }


            if (!empty($driverLicenseAlerts)) {

                foreach ($driverLicenseAlerts as $driverLicenseAlert) {
                    if ($cpt <= 10) {

                        ?>
                        <li class="list-group-item active"><!-- Task item -->
                       <?php
                        if (!empty($driverLicenseAlert['Customer']['driver_license_category'])) { ?>
                                <?php
                                $category=explode(',',$driverLicenseAlert['Customer']['driver_license_category']);
                                $nb_category=count($category);
                                $i=0;
                                $categoryDriverLicense = '';
                                foreach($category as $category) {
                                    switch ($category) {
                                        case 1 :
                                            $category_name = __("Category A");
                                            break;
                                        case 2 :
                                            $category_name = __("Category B");
                                            break;
                                        case 3 :
                                            $category_name = __("Category C");
                                            break;
                                        case 4 :
                                            $category_name = __("Category D");
                                            break;
                                        case 5 :
                                            $category_name = __("Category E");
                                            break;
                                        case 6 :
                                            $category_name = __("Category F");
                                            break;
                                        default :
                                            $category_name ='';
                                    }
                                    if($i==0) {
                                        $categoryDriverLicense =$categoryDriverLicense. $category_name.'';
                                    }else{
                                        if($category_name!=''){
                                            $categoryDriverLicense =$categoryDriverLicense. ', '.$category_name;
                                        }


                                    }
                                    $i++;
                                }
                            }else {
                            $categoryDriverLicense = '';
                                }


                        echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>" . __('Driver license') .' ' . $categoryDriverLicense. "</span>
<span class='desc'>" . $driverLicenseAlert["Customer"]['first_name'] . ' ' . $driverLicenseAlert["Customer"]['last_name'] . "</span></div>"
                            ,
                            array('controller' => 'customers', 'action' => 'View',
                                $driverLicenseAlert["Customer"]['id']),
                            array('escape' => false, 'class' => "user-list-item")
                        );
                        $cpt++;
                    }
                }
                ?>

                </li><!-- end task item -->
            <?php
            }

            if (!empty($amortissementAlerts)) {

                foreach ($amortissementAlerts as $amortissementAlert) {
                    if ($cpt <= 10) {

                        ?>
                        <li class="list-group-item active"><!-- Task item -->

                        <?php


                        echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>" . __('Amortissement') . "</span>
<span class='desc'>" . $amortissementAlert["Car"]['immatr_def'] . ' ' . $amortissementAlert["Carmodel"]['name'] . "</span></div>"
                            ,
                            array('controller' => 'cars', 'action' => 'View',
                                $amortissementAlert["Car"]['id']),
                            array('escape' => false, 'class' => "user-list-item")
                        );
                        $cpt++;
                    }
                }
                ?>

                </li><!-- end task item -->
            <?php
            }



            if (!empty($consumptionAlerts)) {


                foreach ($consumptionAlerts as $consumptionAlert) {
                    if ($cpt <= 10) {

                        ?>
                        <li class="list-group-item active"><!-- Task item -->

                        <?php echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>" . __('Limite monthly consumption') . "</span>
<span class='desc'>" . $consumptionAlert["Car"]['immatr_def'] . ' ' . $consumptionAlert["Carmodel"]['name'] . "</span></div>"
                            ,
                            array('controller' => 'cars', 'action' => 'View',
                                $consumptionAlert["Car"]['id']),
                            array('escape' => false, 'class' => "user-list-item")
                        );
                        $cpt++;
                    }
                }
                ?>

                </li><!-- end task item -->
            <?php
            }


            if (!empty($couponAlerts)) {

                foreach ($couponAlerts as $couponAlert) {
                    if ($cpt <= 10) {

                        ?>
                        <li class="list-group-item"><!-- Task item -->

                        <?php echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>" . __('Coupon consumption') . "</span>
<span class='desc'>" . $consumptionAlert["Car"]['immatr_def'] . ' ' . $consumptionAlert["Carmodel"]['name'] . "</span></div>"
                            ,
                            array('controller' => 'cars', 'action' => 'View',
                                $couponAlert["Car"]['id']),
                            array('escape' => false, 'class' => "user-list-item")
                        );
                        $cpt++;
                    }
                }
                ?>

                </li><!-- end task item -->
            <?php
            }


            if (!empty($deadlineAlerts)) {

                foreach ($deadlineAlerts as $deadlineAlert) {
                    if ($cpt <= 10) {

                        ?>
                        <li class="list-group-item"><!-- Task item -->

                        <?php echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>" . __('Deadline') . "</span>
<span class='desc'>" . $deadlineAlert["TransportBill"]['reference'] . "</span></div>"
                            ,
                            array('controller' => 'transport_bills', 'action' => 'View',
                                $deadlineAlert["TransportBill"]['type'], $deadlineAlert["TransportBill"]['id']),
                            array('escape' => false, 'class' => "user-list-item")
                        );
                        $cpt++;
                    }
                }
                ?>

                </li><!-- end task item -->
            <?php
            }
            if (!empty($productMaxAlerts)) {

                            foreach ($productMaxAlerts as $productMaxAlert) {
                                if ($cpt <= 10) {

                                    ?>
                                    <li class="list-group-item">

                                    <?php echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>" . __('Maxmimum quantity reached') . "</span>
            <span class='desc'>" . $productMaxAlert["Product"]['name'] . "</span></div>"
                                        ,
                                        array('controller' => 'products', 'action' => 'View',
                                            $productMaxAlert["Product"]['id']),
                                        array('escape' => false, 'class' => "user-list-item")
                                    );
                                    $cpt++;
                                }
                            }
                            ?>

                            </li><!-- end task item -->
                        <?php
                        }

            if (!empty($productMinAlerts)) {

                                        foreach ($productMinAlerts as $productMinAlert) {
                                            if ($cpt <= 10) {

                                                ?>
                                                <li class="list-group-item">

                                                <?php echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>" . __('Minimum quantity reached') . "</span>
                        <span class='desc'>" . $productMinAlert["Product"]['name'] . "</span></div>"
                                                    ,
                                                    array('controller' => 'products', 'action' => 'View',
                                                        $productMinAlert["Product"]['id']),
                                                    array('escape' => false, 'class' => "user-list-item")
                                                );
                                                $cpt++;
                                            }
                                        }
                                        ?>

                                        </li><!-- end task item -->
                                    <?php
                                    }

                     if (!empty($expirationDateAlerts)) {
                                        foreach ($expirationDateAlerts as $expirationDateAlert) {
                                            if ($cpt <= 10) {
                                                ?>
                                                <li class="list-group-item">
                                                <?php echo $this->Html->link("<div class='icon bg-info'><i class='zmdi zmdi-account'></i></div> <div class='user-desc'><span class='name'>" . __('Serial number') . "</span>
                                                <span class='desc'>" . $expirationDateAlert["SerialNumber"]['serial_number'] . "</span></div>",
                                                    array(),
                                                    array('escape' => false, 'class' => "user-list-item")
                                                );
                                                $cpt++;
                                            }
                                        }
                                        ?>

                                        </li><!-- end task item -->
                                    <?php
                                    } ?>

            <li class="list-group-item">
                <?= $this->Html->Link(__('View event alerts'), array(
                    'controller' => 'events',
                    'action' => 'alerts'
                )); ?>
                <br>
                <?= $this->Html->Link(__('View driver license alerts'), array(
                    'controller' => 'customers',
                    'action' => 'permisalert'
                )); ?>
                <br>
                <?php /*echo  $this->Html->Link(__('View consumption alerts'), array(
                            'controller' => 'sheetRides',
                            'action' => 'consumptionalert'
                        )); */
                ?>
            </li>

        </ul>

    </div>
</div>

