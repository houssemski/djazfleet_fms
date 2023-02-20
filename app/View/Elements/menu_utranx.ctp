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

    if ($this->Session->read('Auth.User.profile_id') != 10) {

            if (($this->params['controller'] == "suppliers" &&
                    (isset($this->params['pass']['0']) && $this->params['pass']['0'] == 1)) ||
                $this->params['controller'] == "transportBills"
                || $this->params['controller'] == "transportBillDetailRides"
                || $this->params['controller'] == "prices"
            ) {
                $class = ' has-submenu active';
            } else {
                $class = 'has-submenu';
            } ?>

            <li class="<?= $class; ?>">
                <?php if ($profileId != ProfilesEnum::client) { ?>
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span> <?= __('Sales') ?></span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="submenu megamenu">
                    <?php } ?>

                    <li>        <?= $this->Html->link(
                            __('Request quotation'),
                            array('plugin' => null,'controller' => 'transportBills', 'action' => 'index', 0),
                            array('escape' => false)
                        ); ?>

                    </li>
                    <li>    <?= $this->Html->link(
                            __('Quotation'),
                            array('plugin' => null,'controller' => 'transportBills', 'action' => 'index', 1),
                            array('escape' => false)
                        ); ?></li>

                    <li>    <?= $this->Html->link(
                            __('Orders'),
                            array('plugin' => null,'controller' => 'transportBills', 'action' => 'index', 2),
                            array('escape' => false)
                        ); ?></li>

                      <li>    <?= $this->Html->link(
                        __('Customer orders detail'),
                        array('plugin' => null,'controller' => 'transportBillDetailRides', 'action' => 'index'),
                        array('escape' => false)
                    ); ?></li>

                    <li>    <?= $this->Html->link(
                            __('Preinvoices'),
                            array('plugin' => null,'controller' => 'transportBills', 'action' => 'index', 4),
                            array('escape' => false)
                        ); ?>
                    </li>

                    <li>    <?= $this->Html->link(
                            __('Invoices'),
                            array('plugin' => null,'controller' => 'transportBills', 'action' => 'index', 7),
                            array('escape' => false)
                        ); ?>
                    </li>
                    <li>    <?= $this->Html->link(
                            __('Sale credit notes'),
                            array('plugin' => null,'controller' => 'transportBills', 'action' => 'index', 10),
                            array('escape' => false)
                        ); ?>
                    </li>

                    <?php if ($profileId != ProfilesEnum::client) { ?>
                        <li>
                            <?= $this->Html->link(
                                __("Prices"),
                                array('plugin' => null,'controller' => 'prices', 'action' => 'index'),
                                array('escape' => false)
                            ); ?>
                        </li>
                    <?php } ?>
                    <li>        <?= $this->Html->link(
                            __('Clients'),
                            array('plugin' => null,'controller' => 'suppliers', 'action' => 'index', 1),
                            array('escape' => false)
                        ); ?>

                    </li>
                    <?php if ($profileId != ProfilesEnum::client) { ?>
                </ul>
            <?php } ?>
            </li>
            <?php

    }

    if ($this->Session->read('Auth.User.profile_id') != 10 && $profileId != ProfilesEnum::client) {

            if ((
                    ($this->params['controller'] == "suppliers") &&
                    (isset($this->params['pass']['0']) && $this->params['pass']['0'] == 0) &&
                    ($this->params['action'] != "indexOffShore")
                ) ||
                ($this->params['controller'] == "bills"  && $this->params['action'] == "index" && $this->params['pass']['0'] == 1) ||
                ($this->params['controller'] == "bills"  && $this->params['action'] == "index" && $this->params['pass']['0'] == 14) ||
                ($this->params['controller'] == "bills"  && $this->params['action'] == "add" && $this->params['pass']['0'] == 3) ||
                ($this->params['controller'] == "bills"  && $this->params['action'] == "add" && $this->params['pass']['0'] == 4) ||
                ($this->params['controller'] == "bills"  && $this->params['action'] == "add" && $this->params['pass']['0'] == 5) ||
                ($this->params['controller'] == "bills"  && $this->params['action'] == "add" && $this->params['pass']['0'] == 6)
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
                            array('plugin' => null,'controller' => 'bills', 'action' => 'index', 1),
                            array('escape' => false)
                        ); ?>
                        <div class="li-border"></div>
                    </li>
                    <li>
                        <?= $this->Html->link(
                            __('Invoice'),
                            array('plugin' => null,'controller' => 'bills', 'action' => 'add', 4),
                            array('escape' => false)
                        ); ?>
                    </li>

                    <li>
                        <?= $this->Html->link(
                            __('Credit note'),
                            array('plugin' => null,'controller' => 'bills', 'action' => 'add', 5),
                            array('escape' => false)
                        ); ?>
                    </li>
                    <li>
                        <?= $this->Html->link(
                            __('Newspaper purchases'),
                            array('plugin' => null,'controller' => 'bills', 'action' => 'index',14),
                            array('escape' => false)
                        ); ?>
                        <div class="li-border"></div>
                    </li>

                    <li>
                        <?= $this->Html->link(
                            __('Suppliers'),
                            array('plugin' => null,'controller' => 'suppliers', 'action' => 'index', 0),
                            array('escape' => false)
                        ); ?>
                    </li>

                    <?php if ($profileId != ProfilesEnum::client) { ?>
                </ul>
            <?php } ?>
            </li>
        <?php
    }
    if ($this->Session->read('Auth.User.profile_id') != 10 && $profileId != ProfilesEnum::client) {
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

        if ($this->Session->read('Auth.User.profile_id') != 10) {


            if (Configure::read("planification") == '1') {
                if ($this->params['controller'] == "sheetRides" ||
                    $this->params['controller'] == "sheetRideDetailRides"
                ) {
                    $class = ' has-submenu active';
                } else {
                    $class = 'has-submenu';
                }
                ?>
                <li class="<?= $class; ?>">
                    <?php if ($profileId != ProfilesEnum::client) { ?>
                        <a href="#">
                            <i class="zmdi zmdi-collection-text"></i>
                            <span><?= __('Plannings') ?> </span>
                            <span class="menu-arrow"></span>
                        </a>
                    <?php } ?>
                    <ul class="submenu">

                        <?php   if ($profileId != ProfilesEnum::client) { ?>

                    <?php if( $this->Session->read("permissionOrderNotValidated")) { ?>
                                <li> <?= $this->Html->link(
                                        __('Customer orders not validated'),
                                        array('plugin' => null,'controller' => 'transportBills', 'action' => 'addFromCustomerOrder'),
                                        array('escape' => false)
                                    ); ?>
                                </li>
                                <li> <?= $this->Html->link(
                                        __('Customer orders not validated detail'),
                                        array('plugin' => null,'controller' => 'transportBills', 'action' => 'addFromCustomerOrderDetail'),
                                        array('escape' => false)
                                    ); ?>
                                </li>

                        <?php } ?>



                            <li> <?= $this->Html->link(
                                    $this->Session->read("nameSheetRide"),
                                    array('plugin' => null,'controller' => 'sheetRides', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li> <?= $this->Html->link(
                                    __('Customers by last mission date'),
                                    array('plugin' => null,'controller' => 'customers', 'action' => 'index',25,3,'DESC'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                        <?php } ?>

                        <?php if ($this->Session->read('Auth.User.profile_id') != 10 && $profileId != ProfilesEnum::client) { ?>
                            <li> <?= $this->Html->link(
                                    __("Missions"),
                                    array('plugin' => null,'controller' => 'sheetRideDetailRides', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li> <?= $this->Html->link(
                                    __("Dispatch slip"),
                                    array('plugin' => null,'controller' => 'slips', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>

                            <?php if(Configure::read("trajet") == '0') { ?>
                            <li><?= $this->Html->link(
                                    __("Cities"),
                                    array('plugin' => null,'controller' => 'destinations', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                        <?php } ?>
                            <?php
                    if (Configure::read("reclamation") == '1') {
                        if ($this->Session->read("permissionComplaint")) { ?>
                            <li> <?= $this->Html->link(
                                    __("Complaints"),
                                    array('plugin' => null,'controller' => 'complaints', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                        <?php }
                             }
                            ?>
                       <!--     <li> <?= $this->Html->link(
                                    __('Transits'),
                                    array('plugin' => null,'controller' => 'transits', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li> -->
                        <?php } ?>
                        <!--     <li> <?= $this->Html->link(
                            __("Missions") . ' ' . __("calendar"),
                            array('plugin' => null,'controller' => 'sheetRideDetailRides', 'action' => 'calendar'),
                            array('escape' => false)
                        ); ?>
                            </li> -->
                        <!--  <li> <?= $this->Html->link(
                            __("Newspaper SMS"),
                            array('plugin' => null,'controller' => 'messages', 'action' => 'index'),
                            array('escape' => false)
                        ); ?></li> -->
                        <!--   <li> <?= $this->Html->link(
                            __("conductorsRidesByDate"),
                            array('plugin' => null,'controller' => 'sheetRides', 'action' => 'conductorsRidesByDate'),
                            array('escape' => false)
                        ); ?></li>
                            <li> <?= $this->Html->link(
                            __("conductorsRidesByKm"),
                            array('plugin' => null,'controller' => 'sheetRides', 'action' => 'conductorsRidesByKm'),
                            array('escape' => false)
                        ); ?></li> -->

                    </ul>
                </li>

                <?php
            }

            if (Configure::read("planification") == '1') {
                if ($this->params['controller'] == "consumptions" ||
                    $this->params['controller'] == "FuelLogs" ||
                    $this->params['controller'] == "fuelCards" ||
                    $this->params['controller'] == "fuelCardAffectations" ||
                    $this->params['controller'] == "tanks" ||
                    $this->params['controller'] == "tankOperations"
                ) {
                    $class = ' has-submenu active';
                } else {
                    $class = 'has-submenu';
                }
                ?>
                <li class="<?= $class; ?>">
                    <?php if ($profileId != ProfilesEnum::client) { ?>
                        <a href="#">
                            <i class="zmdi zmdi-gas-station"></i>
                            <span><?= __('Consumptions') ?> </span>
                            <span class="menu-arrow"></span>
                        </a>
                    <?php } ?>
                    <ul class="submenu">


                        <?php if ($this->Session->read('Auth.User.profile_id') != 10 && $profileId != ProfilesEnum::client) { ?>
                            <li> <?= $this->Html->link(
                                    __("SheetRides with consumption"),
                                    array('plugin' => null,'controller' => 'sheetRides', 'action' => 'sheetRidesWithConsumption'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li> <?= $this->Html->link(
                                    __("Consumptions log"),
                                    array('plugin' => null,'controller' => 'consumptions', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __("Fuel logs"),
                                    array('plugin' => null,'controller' => 'FuelLogs', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __("Fuel cards"),
                                    array('plugin' => null,'controller' => 'fuelCards', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>

                            <li>
                                <?= $this->Html->link(
                                    __("Card affectations"),
                                    array('plugin' => null,'controller' => 'fuelCardAffectations', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <?php if( $this->Session->read("permissionTank")) { ?>
                            <li>
                                <?= $this->Html->link(
                                    __("Tanks"),
                                    array('plugin' => null,'controller' => 'tanks', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __("Tank fillings"),
                                    array('plugin' => null,'controller' => 'tankOperations', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>

                        <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
                <?php
            }
            ?>
            <?php
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
                                array('plugin' => null,'controller' => 'suppliers', 'action' => 'indexOffShore', 0),
                                array('escape' => false)
                            ); ?>
                        </li>
                        <li>
                            <?= $this->Html->link(
                                __("Contracts"),
                                array('plugin' => null,'controller' => 'contracts', 'action' => 'index'),
                                array('escape' => false)
                            ); ?>
                        </li>
                        <?php
                        if ($this->Session->read("carSubcontracting")==1){ ?>
                            <li>
                                <?= $this->Html->link(
                                    __("Add car offshore"),
                                    array('plugin' => null,'controller' => 'cars', 'action' => 'add', 2),
                                    array('escape' => false)
                                ); ?>
                            </li>
                        <?php } ?>
                        <li>
                            <?= $this->Html->link(
                                __("Reservations"),
                                array('plugin' => null,'controller' => 'reservations', 'action' => 'index'),
                                array('escape' => false)
                            ); ?>
                        </li>
                    </ul>
                </li>
            <?php } ?>

            <?php
            if(Configure::read("trajet") == '1') {

            if ($this->params['controller'] == "rides"
                || $this->params['controller'] == "rideCategories"
                || $this->params['controller'] == "detailRides"
                || $this->params['controller'] == "destinations"
            ) {
                $class = ' has-submenu active';
            } else {
                $class = 'has-submenu';
            }
            ?>
            <li class="<?= $class; ?>">
                <a href="#">
                    <i class="zmdi zmdi-city"></i>
                    <span> <?= __('Rides') ?> </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="submenu">
                    <li><?= $this->Html->link(
                            __("Cities"),
                            array('plugin' => null,'controller' => 'destinations', 'action' => 'index'),
                            array('escape' => false)
                        ); ?></li>
                    <li> <?= $this->Html->link(
                            __("Rides"),
                            array('plugin' => null,'controller' => 'rides', 'action' => 'index'),
                            array('escape' => false)
                        ); ?></li>
                    <?php if ($this->Session->read("useRideCategory") == '2') { ?>
                        <li>  <?= $this->Html->link(
                                __("Ride categories"),
                                array('plugin' => null,'controller' => 'rideCategories', 'action' => 'index'),
                                array('escape' => false)
                            ); ?></li>
                    <?php } ?>
                    <li><?= $this->Html->link(
                            __("Rides details"),
                            array('plugin' => null,'controller' => 'detailRides', 'action' => 'index'),
                            array('escape' => false)
                        ); ?></li>


                </ul>
            </li>
            <?php } ?>
            <?php
            if(Configure::read("marchandise") == '1') {
                if ($this->params['controller'] == "marchandises" ||
                    $this->params['controller'] == "marchandiseTypes" ||
                    $this->params['controller'] == "marchandiseUnits"
                ) {
                    $class = ' has-submenu active';
                } else {
                    $class = 'has-submenu';
                }
                ?>
                <li class="<?= $class; ?>">
                    <a href="#">
                        <i class="zmdi zmdi-invert-colors"></i>
                        <span> <?= __('Marchandises') ?>  </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="submenu">
                        <li><?= $this->Html->link(
                                __("Marchandises"),
                                array('plugin' => null,'controller' => 'marchandises', 'action' => 'index'),
                                array('escape' => false)
                            ); ?></li>
                        <li>   <?= $this->Html->link(
                                __("Types"),
                                array('plugin' => null,'controller' => 'marchandiseTypes', 'action' => 'index'),
                                array('escape' => false)
                            ); ?></li>
                        <li><?= $this->Html->link(
                                __("Units"),
                                array('plugin' => null,'controller' => 'marchandiseUnits', 'action' => 'index'),
                                array('escape' => false)
                            ); ?></li>

                    </ul>
                </li>
               <?php } ?>


                <?php




            if ($this->params['controller'] == "events") {
                $class = 'has-submenu active';
            } else {
                $class = 'has-submenu';
            }
            ?>
            <li class="<?= $class; ?>">
                <a href="#">
                    <i class="ti-agenda"></i>
                    <span><?= __("Events"); ?> </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="submenu">
                    <li><?= $this->Html->link(
                            __("Newspaper events"),
                            array('plugin' => null,'controller' => 'events', 'action' => 'index'),
                            array('escape' => false)
                        ); ?></li>
                    <li>    <?= $this->Html->link(
                            __("Intervention requests"),
                            array('plugin' => null,'controller' => 'events', 'action' => 'index_request'),
                            array('escape' => false)
                        ); ?></li>
            <?php if( $this->Session->read("permissionWorkshop")) { ?>
                    <li>    <?= $this->Html->link(
                            __("Workshops (Entry - Exit)"),
                            array('plugin' => null,'controller' => 'events', 'action' => 'getEntryExitWorkshops'),
                            array('escape' => false)
                        ); ?>
                    </li>

                <?php } ?>
                </ul>
            </li>

         <?php   if(Configure::read("appro") == '1') { ?>
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
                            array('plugin' => null,'controller' => 'bills', 'action' => 'index', 20),
                            array('escape' => false)
                        ); ?>
                        <div class="li-border"></div>
                    </li>
                    <li>
                        <?= $this->Html->link(
                            __('Purchase requests'),
                            array('plugin' => null,'controller' => 'bills', 'action' => 'index', 21),
                            array('escape' => false)
                        ); ?>
                    </li>

                    <?php if ($profileId != ProfilesEnum::client) { ?>
                </ul>
            <?php } ?>
            </li>

        <?php } ?>

            <?php  if ((
                    ($this->params['controller'] == "products") ||
                    ($this->params['controller'] == "lots") ||
                    ($this->params['controller'] == "bills"  && $this->params['action'] == "add" && $this->params['pass']['0'] == 2) ||
                    ($this->params['controller'] == "bills"  && $this->params['action'] == "add" && $this->params['pass']['0'] == 3) ||
                    ($this->params['controller'] == "bills"  && $this->params['action'] == "add" && $this->params['pass']['0'] == 6) ||
                    ($this->params['controller'] == "bills"  && $this->params['action'] == "add" && $this->params['pass']['0'] == 7) ||
                    ($this->params['controller'] == "bills"  && $this->params['action'] == "add" && $this->params['pass']['0'] == 8) ||
                    ($this->params['controller'] == "bills"  && $this->params['action'] == "add" && $this->params['pass']['0'] == 9) ||
                    ($this->params['controller'] == "bills"  && $this->params['action'] == "add" && $this->params['pass']['0'] == 10) ||
                    ($this->params['controller'] == "bills"  && $this->params['action'] == "add" && $this->params['pass']['0'] == 11) ||
                    ($this->params['controller'] == "bills"  && $this->params['action'] == "index" && $this->params['pass']['0'] == 12) ||
                    ($this->params['controller'] == "bills"  && $this->params['action'] == "index" && $this->params['pass']['0'] == 13)
                )
                ) {
                    $class = "active has-submenu";
                } else {
                    $class = "has-submenu";
                }
                ?>
                <li class="<?= $class; ?>">
                    <a href="#">
                        <i class="zmdi zmdi-store"></i>
                        <span><?= __("Stock"); ?> </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="submenu">

                        <?php if (Configure::read("stock") == '1') { ?>

                            <li>
                                <?= $this->Html->link(
                                    __("Products"),
                                    array('plugin' => null,'controller' => 'products', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                          <?php  if( $this->Session->read("multiWarehouses")==2) { ?>
                            <li>
                                <?= $this->Html->link(
                                    __("Stock by warehouses"),
                                    array('plugin' => null,'controller' => 'productWarehouses', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                    <?php } ?>
                            <?php if ($this->Session->read("usePurchaseBill")==1){ ?>
                                <li>
                                    <?= $this->Html->link(
                                        __("Lots"),
                                        array('plugin' => null,'controller' => 'lots', 'action' => 'index'),
                                        array('escape' => false)
                                    ); ?>
                                </li>
                            <?php }?>
                            <li>
                                <?= $this->Html->link(
                                    __('Receipt'),
                                    array('plugin' => null,'controller' => 'bills', 'action' => 'add', 2),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __("Return supplier"),
                                    array('plugin' => null,'controller' => 'bills', 'action' => 'add', 3),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __('Delivery order'),
                                    array('plugin' => null,'controller' => 'bills', 'action' => 'add', 6),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __("Return customer"),
                                    array('plugin' => null,'controller' => 'bills', 'action' => 'add', 7),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __('Commercial stock journal'),
                                    array('plugin' => null,'controller' => 'bills', 'action' => 'index', 12),
                                    array('escape' => false)
                                ); ?>
                            </li>



                            <li>
                                <?= $this->Html->link(
                                    __("Entry order"),
                                    array('plugin' => null,'controller' => 'bills', 'action' => 'add', 8),
                                    array('escape' => false)
                                ); ?>

                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __("Bon de renvoi"),
                                    array('plugin' => null,'controller' => 'bills', 'action' => 'add', 10),
                                    array('escape' => false)
                                ); ?>

                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __("Exit order"),
                                    array('plugin' => null,'controller' => 'bills', 'action' => 'add', 9),
                                    array('escape' => false)
                                ); ?>

                            </li>

                            <li>
                                <?= $this->Html->link(
                                    __("Reintegration order"),
                                    array('plugin' => null,'controller' => 'bills', 'action' => 'add', 11),
                                    array('escape' => false)
                                ); ?>
                            </li>

                            <li>
                                <?= $this->Html->link(
                                    __("Special stock journal"),
                                    array('plugin' => null,'controller' => 'bills', 'action' => 'index',13),
                                    array('escape' => false)
                                ); ?>
                            </li>
                <?php  if( $this->Session->read("multiWarehouses")==2) { ?>
                            <li>
                                <?= $this->Html->link(
                                    __("Transfer receipt"),
                                    array('controller' => 'bills', 'action' => 'index',22),
                                    array('escape' => false)
                                ); ?>
                            </li>
                    <?php } ?>
                        <?php } ?>
                    </ul>
                </li>



            <?php    if (
                ($this->params['controller'] == "cars" && $this->params['action'] == "add" && isset($this->params['pass']['0']) && $this->params['pass']['0'] == 1) ||
                ($this->params['controller'] == "cars" && $this->params['action'] == "Add" && isset($this->params['pass']['0']) && $this->params['pass']['0'] == 1) ||
                ($this->params['controller'] == "cars" && $this->params['action'] == "index") ||
                ($this->params['controller'] == "cars" && $this->params['action'] == "search") ||
                ($this->params['controller'] == "cars" && $this->params['action'] == "edit") ||
                $this->params['controller'] == "CustomerCars"
            ) {
                $class = 'has-submenu active';
            } else {
                $class = 'has-submenu';
            }

            ?>
            <li class="<?= $class; ?>">
                <a href="#">
                    <i class="fa fa-truck"></i>
                    <span> <?= __('Park') ?>  </span>
                    <span class="menu-arrow"></span>
                </a>

                <ul class="submenu megamenu">
                    <li>
                        <ul>
                            <li><?= $this->Html->link(
                                    __("Cars"),
                                    array('plugin' => null,'controller' => 'cars', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>


                        </ul>
                    </li>
                    <li>
                        <ul>
                            <li>  <?= $this->Html->link(
                                    __('Newspaper affectations'),
                                    array('plugin' => null,'controller' => 'CustomerCars', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li> <?= $this->Html->link(
                                    __('Temporary affectations'),
                                    array('plugin' => null,'controller' => 'CustomerCars', 'action' => 'index_temporary'),
                                    array('escape' => false)
                                ); ?></li>
                            <li><?= $this->Html->link(
                                    __('Affectation requests'),
                                    array('plugin' => null,'controller' => 'CustomerCars', 'action' => 'index_request'),
                                    array('escape' => false)
                                ); ?></li>
                            <li><?= $this->Html->link(
                                    __d('bus_routes','Bus stops'),
                                    array('plugin' => 'BusRoutes','controller' => 'BusRouteStops', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li><?= $this->Html->link(
                                    __('Rotations'),
                                    array('plugin' => 'BusRoutes','controller' => 'CustomRoutes', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>

                        </ul>
                    </li>
                </ul>


            </li>

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
                            array('plugin' => null,'controller' => 'customers', 'action' => 'index'),
                            array('escape' => false)
                        ); ?>
                    </li>
                    <li><?= $this->Html->link(
                            __("Medical visits"),
                            array('plugin' => null,'controller' => 'medicalVisits', 'action' => 'index'),
                            array('escape' => false)
                        ); ?>
                    </li>
                    <li><?= $this->Html->link(
                            __("Warnings"),
                            array('plugin' => null,'controller' => 'warnings', 'action' => 'index'),
                            array('escape' => false)
                        ); ?>
                    </li>
                    <li><?= $this->Html->link(
                            __("Absences"),
                            array('plugin' => null,'controller' => 'absences', 'action' => 'index'),
                            array('escape' => false)
                        ); ?>
                    </li>


                </ul>
            </li>


            <?php

            if ($this->params['controller'] == "CarStatuses" ||
                $this->params['controller'] == "car_statuses" ||
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
                                    array('plugin' => null,'controller' => 'CarCategories', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li>  <?= $this->Html->link(
                                    __("Groups"),
                                    array('plugin' => null,'controller' => 'carGroups', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>

                            <li>  <?= $this->Html->link(
                                    __("Types"),
                                    array('plugin' => null,'controller' => 'CarTypes', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li> <?= $this->Html->link(
                                    __("Statutes"),
                                    array('plugin' => null,'controller' => 'CarStatuses', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li> <?= $this->Html->link(
                                    __("States"),
                                    array('plugin' => null,'controller' => 'CarStates', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li><?= $this->Html->link(
                                    __("Marks"),
                                    array('plugin' => null,'controller' => 'marks', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li><?= $this->Html->link(
                                    __("Models"),
                                    array('plugin' => null,'controller' => 'carmodels', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li><?= $this->Html->link(
                                    __("Fuels"),
                                    array('plugin' => null,'controller' => 'fuels', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li> <?= $this->Html->link(
                                    __("Acquisition types"),
                                    array('plugin' => null,'controller' => 'AcquisitionTypes', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li> <?= $this->Html->link(
                                    __("Parcs"),
                                    array('plugin' => null,'controller' => 'parcs', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li> <?= $this->Html->link(
                                    __("Tonnages"),
                                    array('plugin' => null,'controller' => 'tonnages', 'action' => 'index'),
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
                                    array('plugin' => null,'controller' => 'CustomerCategories', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>

                            <li>  <?= $this->Html->link(
                                    __("Groups"),
                                    array('plugin' => null,'controller' => 'customerGroups', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li>  <?= $this->Html->link(
                                    __("Affiliates"),
                                    array('plugin' => null,'controller' => 'Affiliates', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li><?= $this->Html->link(
                                    __("Departments"),
                                    array('plugin' => null,'controller' => 'departments', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li><?= $this->Html->link(
                                    __("Services"),
                                    array('plugin' => null,'controller' => 'services', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>

                            <li><?= $this->Html->link(
                                    __("Warning types"),
                                    array('plugin' => null,'controller' => 'warningTypes', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>

                            <li><?= $this->Html->link(
                                    __("Absence reasons"),
                                    array('plugin' => null,'controller' => 'absenceReasons', 'action' => 'index'),
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
                                    array('plugin' => null,'controller' => 'carOptions', 'action' => 'index'),
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
                                    array('plugin' => null,'controller' => 'EventTypes', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __("Interfering Types"),
                                    array('plugin' => null,'controller' => 'InterferingTypes', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li> <?= $this->Html->link(
                                    __("Interferings"),
                                    array('plugin' => null,'controller' => 'Interferings', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
            <?php
            if( $this->Session->read("permissionWorkshop")) { ?>
                            <li>    <?= $this->Html->link(
                                    __("Workshops"),
                                    array('plugin' => null,'controller' => 'workshops', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                <?php } ?>

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
                                    array('plugin' => null,'controller' => 'ProductCategories', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>   <?= $this->Html->link(
                                    __("Types"),
                                    array('plugin' => null,'controller' => 'ProductTypes', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __("Marks"),
                                    array('plugin' => null,'controller' => 'ProductMarks', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __("Families"),
                                    array('plugin' => null,'controller' => 'ProductFamilies', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __("TVA"),
                                    array('plugin' => null,'controller' => 'tvas', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
            <?php
            if( $this->Session->read("multiWarehouses")==2) { ?>
                            <li><?= $this->Html->link(
                                    __("Warehouses"),
                                    array('plugin' => null,'controller' => 'warehouses', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                <?php } ?>
                            <li><?= $this->Html->link(
                                    __("Tariffs"),
                                    array('plugin' => null,'controller' => 'priceCategories', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>   <?= $this->Html->link(
                                    __("Units"),
                                    array('plugin' => null,'controller' => 'ProductUnits', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>   <?= $this->Html->link(
                                    __("Factors"),
                                    array('plugin' => null,'controller' => 'Factors', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>   <?= $this->Html->link(
                                    __("Lot types"),
                                    array('plugin' => null,'controller' => 'LotTypes', 'action' => 'index'),
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
                                    array('plugin' => null,'controller' => 'TireMarks', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    __("Positions"),
                                    array('plugin' => null,'controller' => 'positions', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li>  <?= $this->Html->link(
                                    __("Locations"),
                                    array('plugin' => null,'controller' => 'locations', 'action' => 'index'),
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
                                    array('plugin' => null,'controller' => 'SupplierCategories', 'action' => 'index', 1),
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
                                    array('plugin' => null,'controller' => 'wilayas', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li> <?= $this->Html->link(
                                    __("Dairas"),
                                    array('plugin' => null,'controller' => 'dairas', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                            <li>        <?= $this->Html->link(
                                    __("Zones"),
                                    array('plugin' => null,'controller' => 'zones', 'action' => 'index'),
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
                                    array('plugin' => null,'controller' => 'attachmentTypes', 'action' => 'index'),
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
                                    array('plugin' => null,'controller' => 'SupplierCategories', 'action' => 'index', 0),
                                    array('escape' => false)
                                ); ?></li>


                        </ul>
                    </li>

                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <?php echo __('Commercial') ?>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <?= $this->Html->link(
                                    __("Bill categories"),
                                    array('plugin' => null,'controller' => 'transportBillCategories', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li> <?= $this->Html->link(
                                    __("Payment categories"),
                                    array('plugin' => null,'controller' => 'paymentCategories', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>

                            <li> <?= $this->Html->link(
                                    __("Cancel causes"),
                                    array('plugin' => null,'controller' => 'cancelCauses', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>

                            <?php
                     if (Configure::read("reclamation") == '1') {
                         if ($this->Session->read("permissionComplaint")) { ?>
                             <li> <?= $this->Html->link(
                                     __("Complaint causes"),
                                     array('plugin' => null,'controller' => 'complaintCauses', 'action' => 'index'),
                                     array('escape' => false)
                                 ); ?>
                             </li>
                         <?php }
                     }
                            ?>
                            <li> <?= $this->Html->link(
                                    __("Penalties"),
                                    array('plugin' => null,'controller' => 'penalties', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li> <?= $this->Html->link(
                                    __("Treatments"),
                                    array('plugin' => null,'controller' => 'treatments', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>


                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <?php echo __('Sheet rides') ?>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <?= $this->Html->link(
                                    __("Travel reasons"),
                                    array('plugin' => null,'controller' => 'travelReasons', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?></li>
                        </ul>
                    </li>


                    <?php if (($this->Session->read('Auth.User.role_id') == 3) ||
                ($this->Session->read('Auth.User.profile_id') == 1)
            ) {
                ?>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <?php echo __('Parameters') ?>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <?= $this->Html->link(
                                    __("Countries"),
                                    array('plugin' => null,'controller' => 'nationalities', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>
                            <li> <?= $this->Html->link(
                                    __("Currencies"),
                                    array('plugin' => null,'controller' => 'currencies', 'action' => 'index'),
                                    array('escape' => false)
                                ); ?>
                            </li>



                        </ul>
                    </li>
                    <?php }
                    ?>



                </ul>
            </li>

            <?php if ($this->params['controller'] == "statistics") echo "<li class='active'>";
            else echo "<li>";
            ?>

            <?= $this->Html->link(
                '<i class="zmdi zmdi-chart"></i> <span>' . __('Statistics') . '</span>',
                array('plugin' => null,'controller' => 'statistics', 'action' => 'index'),
                array('escape' => false)
            ); ?>
            <?= "</li>" ?>
            <?php
        }
    }
    ?>


</ul>
<!-- End navigation menu  -->
