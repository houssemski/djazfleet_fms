<!-- Navigation Menu-->
<ul class="navigation-menu">

    <?php

    $profileId = $this->Session->read("profileId");
    if ($profileId != ProfilesEnum::client &&
        $this->Session->read('Auth.User.profile_id') != 10
    ) {
        if ($this->params['controller'] == "pages" && $this->params['action'] == "display") {
            $class = 'active';
        } else {
            $class = '';
        } ?>
        <li class="<?= $class; ?>">
            <?= $this->Html->link(
                '<i class="zmdi zmdi-view-dashboard"></i> <span>' . __('Dashboard') . '</span>',
                array('controller' => 'pages', 'action' => 'display'),
                array('escape' => false)
            ); ?>
        </li>

        <?php
    }



    if ($this->Session->read('Auth.User.profile_id') != 10 && $profileId != ProfilesEnum::client) {
        if (Configure::read("achat") == '1') {
        if ((
                ($this->params['controller'] == "suppliers") &&
                (isset($this->params['pass']['0']) && $this->params['pass']['0'] == 0) &&
                ($this->params['action'] != "indexOffShore")
            ) ||
            ($this->params['controller'] == "bills" && $this->params['action'] == "index" && $this->params['pass']['0'] == 1) ||
            ($this->params['controller'] == "bills" && $this->params['action'] == "index" && $this->params['pass']['0'] == 14) ||
            ($this->params['controller'] == "bills" && $this->params['action'] == "add" && $this->params['pass']['0'] == 3) ||
            ($this->params['controller'] == "bills" && $this->params['action'] == "add" && $this->params['pass']['0'] == 4) ||
            ($this->params['controller'] == "bills" && $this->params['action'] == "add" && $this->params['pass']['0'] == 5) ||
            ($this->params['controller'] == "bills" && $this->params['action'] == "add" && $this->params['pass']['0'] == 6)
        ) {
            $class = ' has-submenu active';
        } else {
            $class = 'has-submenu';
        } ?>

    <li class="<?= $class; ?>">
        <?php if ($profileId != ProfilesEnum::client) { ?>
        <a href="#">
            <i class="ti-shopping-cart-full"></i>
            <span> <?= __('Purchases') ?></span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="submenu megamenu">
            <?php } ?>

            <li>
                <?= $this->Html->link(
                    __('Orders'),
                    array('controller' => 'bills', 'action' => 'index', 1),
                    array('escape' => false)
                ); ?>
                <div class="li-border"></div>
            </li>


            <li>
                <?= $this->Html->link(
                    __('Suppliers'),
                    array('controller' => 'suppliers', 'action' => 'index', 0),
                    array('escape' => false)
                ); ?>
            </li>

            <?php if ($profileId != ProfilesEnum::client) { ?>
        </ul>
    <?php } ?>
    </li>
    <?php

    }

    }
    if ($this->Session->read('Auth.User.profile_id') != 10 && $profileId != ProfilesEnum::client) {


    if(Configure::read("appro") == '1') { ?>


      <li class="<?= $class; ?>">
                        <?php if ($profileId != ProfilesEnum::client) { ?>
    <a href="#">
        <i class="ti-shopping-cart-full"></i>
        <span> <?= __('Procurements') ?></span>
        <span class="menu-arrow"></span>
    </a>
    <ul class="submenu megamenu">
        <?php } ?>

        <li>
            <?= $this->Html->link(
                __('Product requests'),
                array('controller' => 'bills', 'action' => 'index', 20),
                array('escape' => false)
            ); ?>
            <div class="li-border"></div>
        </li>
        <li>
            <?= $this->Html->link(
                __('Purchase requests'),
                array('controller' => 'bills', 'action' => 'index', 21),
                array('escape' => false)
            ); ?>
        </li>

        <?php if ($profileId != ProfilesEnum::client) { ?>
    </ul>
    <?php } ?>
    </li>

      <?php
        }
        if (Configure::read("tresorerie") == '1') {
            if ($this->params['controller'] == "payments" || $this->params['controller'] == "comptes") {
                $class = "active has-submenu";
            } else {
                $class = "has-submenu";
            }
            ?>
            <li class="<?= $class; ?>">
                <a href="#">
                    <i class="ti-money"></i>
                    <span><?= __("Treasury"); ?></span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="submenu">
                    <li><?= $this->Html->link(
                            __("Cashing").'s',
                            'javascript:addCashing();',

                            array('escape' => false)
                        ); ?></li>

                    <li><?= $this->Html->link(
                            __("Disbursement").'s',
                            'javascript:addDisbursement();',
                            array('escape' => false)
                        ); ?></li>

                    <li><?= $this->Html->link(
                            __("Money transfer"),
                            'javascript:moneyTransfer();',
                            array('escape' => false)
                        ); ?></li>

                    <li><?= $this->Html->link(
                            __("Revenue / expenditure"),
                            array('controller' => 'payments', 'action' => 'index'),
                            array('escape' => false)
                        ); ?></li>
                    <li><?= $this->Html->link(
                            __("Comptes"),
                            array('controller' => 'comptes', 'action' => 'index'),
                            array('escape' => false)
                        ); ?></li>
                    <li>    <?= $this->Html->link(
                            __("Mission cost payments"),
                            array('controller' => 'payments', 'action' => 'searchMissionCosts'),
                            array('escape' => false)
                        ); ?></li>
                </ul>
            </li>
        <?php }


 ?>
            <?php

        if (Configure::read("stock") == '1') {
            if ((
                ($this->params['controller'] == "products") ||
                ($this->params['controller'] == "lots") ||
                ($this->params['controller'] == "bills"  && $this->params['action'] == "add" && $this->params['pass']['0'] == 8) ||
                ($this->params['controller'] == "bills"  && $this->params['action'] == "add" && $this->params['pass']['0'] == 9) ||
                ($this->params['controller'] == "bills"  && $this->params['action'] == "index" && $this->params['pass']['0'] == 13)
            )
            ) {
                $class = "active has-submenu";
            } else {
                $class = "has-submenu";
            }
            ?>
            <li class="<?= $class; ?> various">
                <a href="#">
                    <i class="zmdi zmdi-layers"></i>
                    <span><?= __("Stock"); ?> </span>
                    <span class="menu-arrow"></span>
                </a>


                <ul class="submenu">
                    <li>
                        <?= $this->Html->link(
                            __("Products"),
                            array('controller' => 'products', 'action' => 'index'),
                            array('escape' => false)
                        ); ?>
                    </li>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <?php echo __('Tires') ?>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <?= $this->Html->link(
                                    __("Tires"),
                                    array('controller' => 'Tires', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li>  <?= $this->Html->link(
                                    __("Shiftings"),
                                    array('controller' => 'Shiftings', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                        </ul>
                    </li>
                    <?php if ($this->Session->read("usePurchaseBill")==1){ ?>
                        <li>
                            <?= $this->Html->link(
                                __("Lots"),
                                array('controller' => 'lots', 'action' => 'index'),
                                array('escape' => false)
                            ); ?>
                        </li>
                    <?php }?>
                    <li>
                        <?= $this->Html->link(
                            __("Entry order"),
                            array('controller' => 'bills', 'action' => 'add', 8),
                            array('escape' => false)
                        ); ?>

                    </li>
                    <li>
                        <?= $this->Html->link(
                            __("Exit order"),
                            array('controller' => 'bills', 'action' => 'add', 9),
                            array('escape' => false)
                        ); ?>

                    </li>
                    <li>
                        <?= $this->Html->link(
                            __("Journal stock"),
                            array('controller' => 'bills', 'action' => 'index',13),
                            array('escape' => false)
                        ); ?>
                    </li>

                </ul>
            </li>




        <?php } ?>
        <?php







        if ($this->Session->read('Auth.User.profile_id') != 10) {

            if (Configure::read("sous_traitance") == '1') {
                if ($this->params['action'] == "indexOffShore" || $this->params['action'] == "addOffShore"
                    || $this->params['action'] == "editOffShore"
                    || ($this->params['controller'] == "cars" && $this->params['action'] == "add" && $this->params['pass']['0'] == 2)
                    || $this->params['controller'] == "contracts"
                    || $this->params['controller'] == "reservations"
                ) {
                    $class = 'has-submenu active';
                } else {
                    $class = 'has-submenu';
                }
                ?>
                <li class="<?= $class; ?>">
                    <a href="#">
                        <i class="ti-layout-tab-window"></i>
                        <span><?= __("Offshore"); ?> </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <?= $this->Html->link(
                                __("Subcontractor").'s',
                                array('controller' => 'suppliers', 'action' => 'indexOffShore', 0),
                                array('escape' => false)
                            ); ?>
                        </li>
                        <li>
                            <?= $this->Html->link(
                                __("Contracts"),
                                array('controller' => 'contracts', 'action' => 'index'),
                                array('escape' => false)
                            ); ?>
                        </li>
                        <?php
                        if ($this->Session->read("carSubcontracting")==1){ ?>
                            <li>
                                <?= $this->Html->link(
                                    __("Add car offshore"),
                                    array('controller' => 'cars', 'action' => 'add', 2),
                                    array('escape' => false)
                                ); ?>
                            </li>
                        <?php } ?>
                        <li>
                            <?= $this->Html->link(
                                __("Reservations"),
                                array('controller' => 'reservations', 'action' => 'index'),
                                array('escape' => false)
                            ); ?>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <?php
            if ($this->params['controller'] == "cars" ||
                $this->params['controller'] == "CustomerCars" ||
                $this->params['controller'] == "sheetRides" ||
                $this->params['controller'] == "sheetRideDetailRides" ||
                $this->params['controller'] == "consumptions" ||
                $this->params['controller'] == "FuelLogs" ||
                $this->params['controller'] == "fuelCards" ||
                $this->params['controller'] == "fuelCardAffectations" ||
                $this->params['controller'] == "tanks" ||
                $this->params['controller'] == "tankOperations" ||
                ($this->params['controller'] == "events" && Configure::read('logistia') != '1') ||
                $this->params['controller'] == "rides" ||
                $this->params['controller'] == "rideCategories" ||
                $this->params['controller'] == "detailRides" ||
                $this->params['controller'] == "destinations"
            ) {
                $class = 'has-submenu active';
            } else {
                $class = 'has-submenu';
            } ?>

            <li class="<?= $class; ?> various">
                <a href="#">
                    <i class="zmdi zmdi-layers"></i>
                    <span><?= __("Park"); ?> </span>
                    <span class="menu-arrow"></span>
                </a>


                <ul class="submenu">
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <?php echo __('Cars') ?>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><?= $this->Html->link(
                                    __("Cars"),
                                    array('controller' => 'cars', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li>  <?= $this->Html->link(
                                    __('Newspaper affectations'),
                                    array('controller' => 'CustomerCars', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li> <?= $this->Html->link(
                                    __('Temporary affectations'),
                                    array('controller' => 'CustomerCars', 'action' => 'index_temporary'),
                                    array('escape' => false)
                                ); ?></li>
                            <li><?= $this->Html->link(
                                    __('Affectation requests'),
                                    array('controller' => 'CustomerCars', 'action' => 'index_request'),
                                    array('escape' => false)
                                ); ?></li>

                        </ul>
                    </li>


                    <?php if (Configure::read("planification") == '1') { ?>
                        <li class="dropdown-submenu">
                            <a tabindex="-1" href="#">
                                <?php echo __('Sheet rides') ?>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php   if ($profileId != ProfilesEnum::client) { ?>

                                    <li> <?= $this->Html->link(
                                            __('Add sheet'),
                                            array('controller' => 'sheetRides', 'action' => 'add'),
                                            array('escape' => false)
                                        ); ?>
                                    </li>
                                    <li> <?= $this->Html->link(
                                            __('Sheet rides'),
                                            array('controller' => 'sheetRides', 'action' => 'index'),
                                            array('escape' => false)
                                        ); ?>
                                        <div class="li-border"></div>
                                    </li>
                                <?php } ?>
                                <?php if ($this->Session->read('Auth.User.profile_id') != 10
                                    && $profileId != ProfilesEnum::client) { ?>
                                    <li> <?= $this->Html->link(
                                            __("Missions"),
                                            array('controller' => 'sheetRideDetailRides', 'action' => 'index'),
                                            array('escape' => false)
                                        ); ?>
                                    </li>
                                    <li> <?= $this->Html->link(
                                            __('Clients'),
                                            array('controller' => 'suppliers', 'action' => 'index', 1),
                                            array('escape' => false)
                                        ); ?>
                                        <div class="li-border"></div>
                                    </li>
                                <?php } ?>

                                <!--     <li> <?= $this->Html->link(
                                    __("Missions") . ' ' . __("calendar"),
                                    array('controller' => 'sheetRideDetailRides', 'action' => 'calendar'),
                                    array('escape' => false)
                                ); ?>
                            </li> -->
                                <!--  <li> <?= $this->Html->link(
                                    __("Newspaper SMS"),
                                    array('controller' => 'messages', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li> -->
                                <!--   <li> <?= $this->Html->link(
                                    __("conductorsRidesByDate"),
                                    array('controller' => 'sheetRides', 'action' => 'conductorsRidesByDate'),
                                    array('escape' => false)
                                ); ?></li>
                            <li> <?= $this->Html->link(
                                    __("conductorsRidesByKm"),
                                    array('controller' => 'sheetRides', 'action' => 'conductorsRidesByKm'),
                                    array('escape' => false)
                                ); ?></li> -->

                            </ul>
                        </li>


                        <li class="dropdown-submenu">
                            <a tabindex="-1" href="#">
                                <?php echo __('Consumptions') ?>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($this->Session->read('Auth.User.profile_id') != 10 && $profileId != ProfilesEnum::client) { ?>
                                    <li> <?= $this->Html->link(
                                            __("Consumptions log"),
                                            array('controller' => 'consumptions', 'action' => 'index'),
                                            array('escape' => false)
                                        ); ?>
                                    </li>
                                    <li>
                                        <?= $this->Html->link(
                                            __("Fuel logs"),
                                            array('controller' => 'FuelLogs', 'action' => 'index'),
                                            array('escape' => false)
                                        ); ?>
                                    </li>
                                    <li>
                                        <?= $this->Html->link(
                                            __("Fuel cards"),
                                            array('controller' => 'fuelCards', 'action' => 'index'),
                                            array('escape' => false)
                                        ); ?>
                                    </li>

                                    <li>
                                        <?= $this->Html->link(
                                            __("Card affectations"),
                                            array('controller' => 'fuelCardAffectations', 'action' => 'index'),
                                            array('escape' => false)
                                        ); ?>
                                    </li>
                                    <li>
                                        <?= $this->Html->link(
                                            __("Tanks"),
                                            array('controller' => 'tanks', 'action' => 'index'),
                                            array('escape' => false)
                                        ); ?>
                                    </li>
                                    <li>
                                        <?= $this->Html->link(
                                            __("Tank fillings"),
                                            array('controller' => 'tankOperations', 'action' => 'index'),
                                            array('escape' => false)
                                        ); ?>
                                    </li>


                                <?php } ?>


                            </ul>
                        </li>

                    <?php } ?>

                    <?php
                    if (Configure::read('logistia') != '1'){
                    ?>
                        <li class="dropdown-submenu">
                            <a tabindex="-1" href="#">
                                <?php
                                echo __('Events')

                                ?>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="dropdown-menu">

                                <li><?= $this->Html->link(
                                        __("Newspaper events"),
                                        array('controller' => 'events', 'action' => 'index'),
                                        array('escape' => false)
                                    ); ?></li>
                                <li>    <?= $this->Html->link(
                                        __("Intervention requests"),
                                        array('controller' => 'events', 'action' => 'index_request'),
                                        array('escape' => false)
                                    ); ?>
                                </li>
                                <li>    <?= $this->Html->link(
                                        __("Workshops (Entry - Exit)"),
                                        array('controller' => 'events', 'action' => 'getEntryExitWorkshops'),
                                        array('escape' => false)
                                    ); ?>
                                </li>

                            </ul>
                        </li>
                        <?php
                    }

                        ?>

                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <?php echo __('Rides') ?>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="dropdown-menu">

                            <li><?= $this->Html->link(
                                    __("Cities"),
                                    array('controller' => 'destinations', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li> <?= $this->Html->link(
                                    __("Rides"),
                                    array('controller' => 'rides', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <?php if ($this->Session->read("useRideCategory") == '2') { ?>
                                <li>  <?= $this->Html->link(
                                        __("Ride categories"),
                                        array('controller' => 'rideCategories', 'action' => 'index'),
                                        array('escape' => false)
                                    ); ?></li>
                            <?php } ?>
                            <li><?= $this->Html->link(
                                    __("Rides details"),
                                    array('controller' => 'detailRides', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>

                        </ul>
                    </li>





                </ul>
            </li>

            <?php
            if ($this->params['controller'] == "events" && Configure::read('logistia') == '1')
            {
                $class = "active has-submenu";
            } else {
                $class = "has-submenu";
            }
            ?>
            <?php
            if (Configure::read('logistia') == '1'){
            ?>
                <li class="<?= $class ?>">
                    <a href="#">
                        <i class="fa fa-cogs"></i>
                        <span><?= __("Repairs"); ?></span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul class="submenu">
                        <li><?= $this->Html->link(
                                __("Ajouter réparation"),
                                array('controller' => 'events', 'action' => 'add'),
                                array('escape' => false)
                            ); ?></li>
                        <li><?= $this->Html->link(
                                __("Newspaper repairs"),
                                array('controller' => 'events', 'action' => 'index'),
                                array('escape' => false)
                            ); ?></li>
                        <li>    <?= $this->Html->link(
                                __("Intervention requests"),
                                array('controller' => 'events', 'action' => 'index_request'),
                                array('escape' => false)
                            ); ?>
                        </li>
                        <li>    <?= $this->Html->link(
                                __("Workshops (Entry - Exit)"),
                                array('controller' => 'events', 'action' => 'getEntryExitWorkshops'),
                                array('escape' => false)
                            ); ?>
                        </li>

                    </ul>

                </li>
                <?php
            }
                ?>


            <?php
            if ($this->params['controller'] == "customers" || $this->params['controller'] == "medicalVisits"
                || $this->params['controller'] == "warnings" || $this->params['controller'] == "absences" )
            {
                $class = "active has-submenu";
            } else {
                $class = "has-submenu";
            }
            ?>
            <li class="<?= $class; ?>">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span><?= __("RH"); ?></span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="submenu">
                    <li><?= $this->Html->link(
                            __("Employees"),
                            array('controller' => 'customers', 'action' => 'index'),
                            array('escape' => false)
                        ); ?>
                    </li>
                    <li><?= $this->Html->link(
                            __("Medical visits"),
                            array('controller' => 'medicalVisits', 'action' => 'index'),
                            array('escape' => false)
                        ); ?>
                    </li>
                    <li><?= $this->Html->link(
                            __("Warnings"),
                            array('controller' => 'warnings', 'action' => 'index'),
                            array('escape' => false)
                        ); ?>
                    </li>
                    <li><?= $this->Html->link(
                            __("Absences"),
                            array('controller' => 'absences', 'action' => 'index'),
                            array('escape' => false)
                        ); ?>
                    </li>


                </ul>
            </li>




            <?php

            if ($this->params['controller'] == "CarStatuses" ||
                $this->params['controller'] == "car_statuses" ||
                $this->params['controller'] == "CarStates" ||
                $this->params['controller'] == "car_states" ||
                $this->params['controller'] == "CarTypes" ||
                $this->params['controller'] == "car_types" ||
                $this->params['controller'] == "fuels" || $this->params['controller'] == "marks" ||
                $this->params['controller'] == "CustomerCategories" ||
                ($this->params['controller'] == "departments") || ($this->params['controller'] == "services") ||
                $this->params['controller'] == "customer_categories" ||
                $this->params['controller'] == "EventTypes" ||
                $this->params['controller'] == "event_types" ||
                $this->params['controller'] == "InterferingTypes" ||
                $this->params['controller'] == "interfering_types" ||
                $this->params['controller'] == "CarCategories" ||
                $this->params['controller'] == "carGroups" ||
                $this->params['controller'] == "car_groups" ||
                $this->params['controller'] == "car_categories" ||
                $this->params['controller'] == "Interferings" ||
                $this->params['controller'] == "interferings" ||
                $this->params['controller'] == "carmodels" ||
                $this->params['controller'] == "carOptions" ||
                $this->params['controller'] == "car_options" ||
                $this->params['controller'] == "parcs" ||
                $this->params['controller'] == "warehouses" ||
                $this->params['controller'] == "zones" ||
                $this->params['controller'] == "customerGroups" ||
                $this->params['controller'] == "customer_groups" ||
                $this->params['controller'] == "tvas" ||
                $this->params['controller'] == "ProductCategories" ||
                $this->params['controller'] == "ProductUnits" ||
                $this->params['controller'] == "ProductFamilies" ||
                $this->params['controller'] == "product_types" ||
                $this->params['controller'] == "ProductMarks" ||
                $this->params['controller'] == "product_marks" ||
                $this->params['controller'] == "priceCategories" ||
                $this->params['controller'] == "price_categories" ||
                $this->params['controller'] == "TireMarks" ||
                $this->params['controller'] == "tire_marks" ||
                $this->params['controller'] == "locations" ||
                $this->params['controller'] == "positions" ||
                $this->params['controller'] == "SupplierCategories" ||
                $this->params['controller'] == "supplier_categories" ||
                $this->params['controller'] == "AcquisitionTypes" ||
                $this->params['controller'] == "acquisition_types" ||
                $this->params['controller'] == "wilayas" ||
                $this->params['controller'] == "dairas" ||
                $this->params['controller'] == "transportBillCategories" ||
                $this->params['controller'] == "transport_bill_categories" ||
                $this->params['controller'] == "Affiliates" ||
                $this->params['controller'] == "warningTypes" ||
                $this->params['controller'] == "absenceReasons"

            ) {
                $class = 'has-submenu active';
            } else {
                $class = 'has-submenu';
            }

            ?>
            <li class="<?= $class; ?> various">
                <a href="#">
                    <i class="zmdi zmdi-layers"></i>
                    <span><?= __("Various"); ?> </span>
                    <span class="menu-arrow"></span>
                </a>


                <ul class="submenu">
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <?php echo __('Cars') ?>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <?= $this->Html->link(
                                    __("Categories"),
                                    array('controller' => 'CarCategories', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li>  <?= $this->Html->link(
                                    __("Groups"),
                                    array('controller' => 'carGroups', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>

                            <li>  <?= $this->Html->link(
                                    __("Types"),
                                    array('controller' => 'CarTypes', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li> <?= $this->Html->link(
                                    __("Statutes"),
                                    array('controller' => 'CarStatuses', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li> <?= $this->Html->link(
                                    __("States"),
                                    array('controller' => 'CarStates', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li><?= $this->Html->link(
                                    __("Marks"),
                                    array('controller' => 'marks', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li><?= $this->Html->link(
                                    __("Models"),
                                    array('controller' => 'carmodels', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li><?= $this->Html->link(
                                    __("Fuels"),
                                    array('controller' => 'fuels', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li> <?= $this->Html->link(
                                    __("Acquisition types"),
                                    array('controller' => 'AcquisitionTypes', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li> <?= $this->Html->link(
                                    __("Parcs"),
                                    array('controller' => 'parcs', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li> <?= $this->Html->link(
                                    __("Tonnages"),
                                    array('controller' => 'tonnages', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <?php echo __('Employees') ?>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <?= $this->Html->link(
                                    __("Categories"),
                                    array('controller' => 'CustomerCategories', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>

                            <li>  <?= $this->Html->link(
                                    __("Groups"),
                                    array('controller' => 'customerGroups', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li>  <?= $this->Html->link(
                                    __("Affiliates"),
                                    array('controller' => 'Affiliates', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li><?= $this->Html->link(
                                    __("Departments"),
                                    array('controller' => 'departments', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li><?= $this->Html->link(
                                    __("Services"),
                                    array('controller' => 'services', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>

                            <?php
                            if(Configure::read('logistia') == '1'){
                            ?>
                                <li><?= $this->Html->link(
                                        __("Structures"),
                                        array('controller' => 'structures', 'action' => 'index'),
                                        array('escape' => false)
                                    ); ?></li>

                                <?php } ?>
                            <li><?= $this->Html->link(
                                    __("Warning types"),
                                    array('controller' => 'warningTypes', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>

                            <li><?= $this->Html->link(
                                    __("Absence reasons"),
                                    array('controller' => 'absenceReasons', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <?php echo __('Affectations') ?>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <?= $this->Html->link(
                                    __("Options"),
                                    array('controller' => 'carOptions', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>


                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <?php echo __('Events') ?>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>  <?= $this->Html->link(
                                    __("Types"),
                                    array('controller' => 'EventTypes', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __("Interfering Types"),
                                    array('controller' => 'InterferingTypes', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li> <?= $this->Html->link(
                                    __("Interferings"),
                                    array('controller' => 'Interferings', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>    <?= $this->Html->link(
                                    __("Workshops"),
                                    array('controller' => 'workshops', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>

                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <?php echo __('Products') ?>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>   <?= $this->Html->link(
                                    __("Categories"),
                                    array('controller' => 'ProductCategories', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __("Marks"),
                                    array('controller' => 'ProductMarks', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __("Families"),
                                    array('controller' => 'ProductFamilies', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __("TVA"),
                                    array('controller' => 'tvas', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li><?= $this->Html->link(
                                    __("Warehouses"),
                                    array('controller' => 'warehouses', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li><?= $this->Html->link(
                                    __("Tariffs"),
                                    array('controller' => 'priceCategories', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>   <?= $this->Html->link(
                                    __("Units"),
                                    array('controller' => 'ProductUnits', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>   <?= $this->Html->link(
                                    __("Lot types"),
                                    array('controller' => 'LotTypes', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>

                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <?php echo __('Tires') ?>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>   <?= $this->Html->link(
                                    __("Marks"),
                                    array('controller' => 'TireMarks', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __("Positions"),
                                    array('controller' => 'positions', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>  <?= $this->Html->link(
                                    __("Locations"),
                                    array('controller' => 'locations', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>

                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <?php echo __('Clients') ?>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <?= $this->Html->link(
                                    __("Clients categories"),
                                    array('controller' => 'SupplierCategories', 'action' => 'index', 1),
                                    array('escape' => false)
                                ); ?></li>


                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <?php echo __('Cities') ?>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <?= $this->Html->link(
                                    __("Wilayas"),
                                    array('controller' => 'wilayas', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li> <?= $this->Html->link(
                                    __("Dairas"),
                                    array('controller' => 'dairas', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li>        <?= $this->Html->link(
                                    __("Zones"),
                                    array('controller' => 'zones', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <?php echo __('Attachments') ?>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <?= $this->Html->link(
                                    __("Types"),
                                    array('controller' => 'attachmentTypes', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>


                        </ul>
                    </li>

                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <?php echo __('Suppliers') ?>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <?= $this->Html->link(
                                    __("Supplier categories"),
                                    array('controller' => 'SupplierCategories', 'action' => 'index', 0),
                                    array('escape' => false)
                                ); ?></li>


                        </ul>
                    </li>

                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <?php echo __('Payment') ?>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="dropdown-menu">

                            <li> <?= $this->Html->link(
                                    __("Payment categories"),
                                    array('controller' => 'paymentCategories', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>




                        </ul>
                    </li>



                </ul>
            </li>



            <?php if ($this->params['controller'] == "statistics") echo "<li class='active'>";
            else echo "<li>";
            ?>

            <?= $this->Html->link(
                '<i class="zmdi zmdi-chart"></i> <span>' . __('Statistics') . '</span>',
                array('controller' => 'statistics', 'action' => 'index'),
                array('escape' => false)
            ); ?>
            <?= "</li>" ?>

                  <?php if (Configure::read("cafyb") == '1') {
                $link_cafyb = Configure::read('link_cafyb');
            echo "<li>";
                ?>

    <?= $this->Html->link(
        '<i class="fa fa-money"></i> <span>' . __('Sales management') . '</span>',
        $link_cafyb,
        array('escape' => false)
    ); ?>
    <?= "</li>" ?>
    <?php }
        }
    }
    ?>


</ul>
<!-- End navigation menu  -->
