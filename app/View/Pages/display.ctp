<?php

$this->start('css');
echo $this->Html->css('c3');
$this->end();
?>
<h4 class="page-title"> <?= __('Dashboard'); ?></h4>
<!-- Small boxes (Stat box) -->
<?php if (Configure::read("gestion_commercial") == '1' ||
Configure::read("gestion_commercial_standard") == '1'
) { ?>
<?php if (!$hidden_information['Parameter']['totaux_dashbord']) { ?>

<div class="row">

    <?php
    if(Configure::read("gestion_commercial") == '1') {
        if ($resultCommercial) { ?>
            <div class="col-lg-3">
                <div class="panel panel-color panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo __('Commercial') ?></h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        if (Configure::read("gestion_commercial") == '1') {
                            echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __('Demandes de devis non transformés : ') . '</strong> ' .
                                number_format($sumDemandeDevisNotTransformed, 0, ",", ".") . "</p>";

                            echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __('Devis non transformés : ') . '</strong> ' .
                                number_format($sumDevisNotTransformed, 0, ",", ".") . "</p>";


                            echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __('Commandes non transmises : ') . '</strong> ' .
                                number_format($sumCustomerOrderNotTransmitted, 0, ",", ".") . "</p>";

                            echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __('Commandes non validées : ') . '</strong> ' .
                                number_format($sumCustomerOrderNotValidated, 0, ",", ".") . "</p>";

                            echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __('Factures non payées : ') . '</strong> ' .
                                number_format($sumInvoiceNotPayed, 0, ",", ".") . "</p>";


                        } else {

                            echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __('Devis non transformés : ') . '</strong> ' .
                                number_format($sumDevisNotTransformed, 0, ",", ".") . "</p>";

                            echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __('Commandes non validées : ') . '</strong> ' .
                                number_format($sumCustomerOrderNotValidated, 0, ",", ".") . "</p>";

                            echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __('BL non payés : ') . '</strong> ' .
                                number_format($sumDeliveryOrderNotPayed, 0, ",", ".") . "</p>";

                            echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __('Factures non payées : ') . '</strong> ' .
                                number_format($sumInvoiceNotPayed, 0, ",", ".") . "</p>";

                            echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __('Échéances dépassées : ') . '</strong> ' .
                                number_format($sumDeadlineNotPayed, 0, ",", ".") . "</p>";


                        }
                        ?>

                    </div>
                </div>
            </div>
            <!-- end col -->
        <?php }
    }
    ?>

    <?php if ($resultPlanning) { ?>

    <?php if(Configure::read("gestion_commercial") == '1') { ?>
    <div class="col-lg-3">
        <?php } else {?>
        <div class="col-lg-4">
            <?php }?>

            <div class="panel panel-color panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo __('Planification') ?> </h3>
                </div>
                <div class="panel-body">
                    <?php   echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __('Missions planifiées : ') . '</strong> ' .
                        number_format($sumMissionsPlanned, 0, ",", ".") . "</p>";
                    ?>

                    <?php   echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __('Missions en cours : ') . '</strong> ' .
                        number_format($sumMissionsInProgress, 0, ",", ".") . "</p>";
                    ?>
                    <?php   echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __('Missions cloturées : ') . '</strong> ' .
                        number_format($sumMissionsClosed, 0, ",", ".") . "</p>";
                    ?>
                    <?php   echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __('Missions préfacturées approuvées : ') . '</strong> ' .
                        number_format($sumMissionsApproved, 0, ",", ".") . "</p>";
                    ?>
                    <?php   echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __('Missions préfacturées non approuvées : ') . '</strong> ' .
                        number_format($sumMissionsNotApproved, 0, ",", ".") . "</p>";
                    ?>

                </div>
            </div>
        </div>
        <!-- end col -->
        <?php } ?>

        <?php
        if(Configure::read("gestion_commercial") == '1') {
            if ($resultFinance) { ?>
                <div class="col-lg-3">
                    <div class="panel panel-color panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo __("Finance") ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php
                            if (Configure::read("gestion_commercial") == '1') {
                                echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Chiffres d'affaires préfacturés :  ") . '</strong> ' .
                                    number_format($sumPreinvoicedTurnover, 2, ",",
                                        ".") . " " . $this->Session->read("currency") . "</p>";
                                echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Chiffres d'affaires facturés :  ") . '</strong> ' .
                                    number_format($sumInvoicedTurnover, 2, ",",
                                        ".") . " " . $this->Session->read("currency") . "</p>";

                                echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Chiffres d'affaires payés :  ") . '</strong> ' .
                                    number_format($sumPayedTurnover, 2, ",",
                                        ".") . " " . $this->Session->read("currency") . "</p>";

                                echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Chiffres d'affaires non payés :  ") . '</strong> ' .
                                    number_format($sumNotPayedTurnover, 2, ",",
                                        ".") . " " . $this->Session->read("currency") . "</p>";

                                echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Consommations / frais de mission :  ") . '</strong> ' .
                                    number_format($sumCostMission, 2, ",", ".") . " " . $this->Session->read("currency") . "</p>";

                            } else {
                                echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Chiffres d'affaires facturés :  ") . '</strong> ' .
                                    number_format($sumInvoicedTurnover, 2, ",",
                                        ".") . " " . $this->Session->read("currency") . "</p>";

                                echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Factures payés :  ") . '</strong> ' .
                                    number_format($sumPayedTurnover, 2, ",",
                                        ".") . " " . $this->Session->read("currency") . "</p>";

                                echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Factures non payés :  ") . '</strong> ' .
                                    number_format($sumNotPayedTurnover, 2, ",",
                                        ".") . " " . $this->Session->read("currency") . "</p>";
                            } ?>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            <?php }

        }else {
            if ($resultFinance) { ?>
                <div class="col-lg-4">
                    <div class="panel panel-color panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo __("Dépenses") ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php
                            if (Configure::read("gestion_commercial") == '1') {
                                echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Chiffres d'affaires préfacturés :  ") . '</strong> ' .
                                    number_format($sumPreinvoicedTurnover, 2, ",",
                                        ".") . " " . $this->Session->read("currency") . "</p>";
                                echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Chiffres d'affaires facturés :  ") . '</strong> ' .
                                    number_format($sumInvoicedTurnover, 2, ",",
                                        ".") . " " . $this->Session->read("currency") . "</p>";

                                echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Chiffres d'affaires payés :  ") . '</strong> ' .
                                    number_format($sumPayedTurnover, 2, ",",
                                        ".") . " " . $this->Session->read("currency") . "</p>";

                                echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Chiffres d'affaires non payés :  ") . '</strong> ' .
                                    number_format($sumNotPayedTurnover, 2, ",",
                                        ".") . " " . $this->Session->read("currency") . "</p>";

                                echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Consommations / frais de mission :  ") . '</strong> ' .
                                    number_format($sumCostConsumptionMission, 2, ",", ".") . " " . $this->Session->read("currency") . "</p>";

                            } else {
                                echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Consommation carburant :  ") . '</strong> ' .
                                    number_format($sumCostConsumption, 2, ",",
                                        ".") . " " . $this->Session->read("currency") . "</p>";

                                echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Pièces  :  ") . '</strong> ' .
                                    number_format($sumCostPiece, 2, ",",
                                        ".") . " " . $this->Session->read("currency") . "</p>";

                                echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Maintenance :  ") . '</strong> ' .
                                    number_format($sumCostMaintenance, 2, ",",
                                        ".") . " " . $this->Session->read("currency") . "</p>";
                                echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Frais de mission :  ") . '</strong> ' .
                                    number_format($sumCostMission, 2, ",", ".") . " " . $this->Session->read("currency") . "</p>";

                            } ?>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            <?php }
        }

        ?>

        <?php if ($resultParc) { ?>
    <?php if(Configure::read("gestion_commercial") == '1') { ?>
        <div class="col-lg-3">
            <?php } else {?>
            <div class="col-lg-4">
                <?php }?>
                <div class="panel panel-color panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo __("Parc") ?></h3>
                    </div>
                    <div class="panel-body">
                        <?php   echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Véhicules en mission :  ") . '</strong> ' .
                            number_format($nbCarsInMission, 0, ",", ".") ."</p>"; ?>
                        <?php   echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Véhicules au parc :  ") . '</strong> ' .
                            number_format($nbCarsInParc, 0, ",", ".").' '.__('V').' / '. number_format($nbRemorquesInParc, 0, ",", ".") .' '.__('R') . "</p>"; ?>

                        <?php   echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Véhicules en panne :  ") . '</strong> ' .
                            number_format($nbCarsInPanne, 0, ",", ".") .' '.__('V').' / '. number_format($nbRemorquesInPanne, 0, ",", ".") .' '.__('R'). "</p>"; ?>

                        <?php   echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Véhicules en réparation :  ") . '</strong> ' .
                            number_format($nbCarsInReparation, 0, ",", ".") .' '.__('V').' / '. number_format($nbRemorquesInReparation, 0, ",", ".") .' '.__('R'). "</p>"; ?>

                        <?php   echo "<p class='text-muted'><i class='fa fa-caret-right'></i><strong>" . ' ' . __("Conducteurs :  ") . '</strong> ' .
                            number_format($nbCustomers, 0, ",", ".") . "</p>"; ?>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <?php } ?>

        </div><!-- /.row -->

        <?php } ?>

        <?php } ?>
        <div class="row">
            <div class="col-lg-1">
            </div>
            <div class="col-lg-10">
                <div class="inside-ds">
                    <div class="panel panel-color panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?= __('Coûts par trimestre') ?></h3>
                        </div>
                        <div class="panel-body">
                            <div id="chart4"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-1">
            </div>
        </div>

        <div class="row">

            <?php if ($resultAlerts) { ?>
            <div class="col-lg-4">


                <div class="panel panel-color panel-inverse panel-height">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= __('All alerts') ?></h3>
                    </div>
                    <div class="panel-body">
                        <p>

                            <div class="goleft">
                        <p class="alert alert2 <?= ($nbAssuranceAlerts == 0) ? "alert-success" : "alert-danger" ?>">
                            <?= __('Assurances') . " : " ?><?= ($nbAssuranceAlerts == 0) ? __("OK") : $nbAssuranceAlerts ?></p>

                        <p class="alert alert2 <?= ($nbControlAlerts == 0) ? "alert-success" : "alert-danger" ?>">
                            <?= __('Technical controls') . " : " ?><?= ($nbControlAlerts == 0) ? __("OK") : $nbControlAlerts ?></p>

                        <p class="alert alert2 <?= ($nbVignetteAlerts == 0) ? "alert-success" : "alert-danger" ?>">
                            <?= __('Vignettes') . " : " ?><?= ($nbVignetteAlerts == 0) ? __("OK") : $nbVignetteAlerts ?></p>

                        <p class="alert alert2 <?= ($nbVidangeAlerts == 0) ? "alert-success" : "alert-danger" ?>">
                            <?= __('Sewage') . " : " ?><?= ($nbVidangeAlerts == 0) ? __("OK") : $nbVidangeAlerts ?></p>

                        <p class="alert alert2 <?= ($nbVidangeHourAlerts == 0) ? "alert-success" : "alert-danger" ?>">
                            <?= __('Sewage hour') . " : " ?><?= ($nbVidangeHourAlerts == 0) ? __("OK") : $nbVidangeHourAlerts ?></p>

                        <p class="alert alert2 <?= ($nbDriverLicenseAlerts == 0) ? "alert-success" : "alert-danger" ?>">
                            <?= __('Driver license') . " : " ?><?= ($nbDriverLicenseAlerts == 0) ? __("OK") : $nbDriverLicenseAlerts ?></p>

                        <p class="alert alert2 <?= ($nbDateAlerts == 0) ? "alert-success" : "alert-danger" ?>">
                            <?= __('Events with dates') . " : " ?><?= ($nbDateAlerts == 0) ? __("OK") : $nbDateAlerts ?></p>

                        <p class="alert alert2 <?= ($nbKmAlerts == 0) ? "alert-success" : "alert-danger" ?>">
                            <?= __('Events with kms') . " : " ?><?= ($nbKmAlerts == 0) ? __("OK") : $nbKmAlerts ?></p>

                        <p class="alert alert2 <?= ($nbConsumptionAlerts == 0) ? "alert-success" : "alert-danger" ?>">
                            <?= __('Monthly consumption') . " : " ?><?= ($nbConsumptionAlerts == 0) ? __("OK") : $nbConsumptionAlerts ?></p>

                        <p class="alert alert2 <?= ($nbCouponConsumptionAlerts == 0) ? "alert-success" : "alert-danger" ?>">
                            <?= __('Coupon consumption') . " : " ?><?= ($nbCouponConsumptionAlerts == 0) ? __("OK") : $nbCouponConsumptionAlerts ?></p>

                        <p class="alert alert2 <?= ($minCouponAlerts == 0) ? "alert-success" : "alert-danger" ?>">
                            <?= __('Stock coupon') . " : " ?><?= ($minCouponAlerts == 0) ? __("OK") : __("Alert") ?></p>

                        <p class="alert alert2 <?= ($nbAmortissementAlerts == 0) ? "alert-success" : "alert-danger" ?>">
                            <?= __('Amortissements') . " : " ?><?= ($nbAmortissementAlerts == 0) ? __("OK") : $nbAmortissementAlerts ?></p>

                        <p class="alert alert2 <?= ($nbKmContractAlerts == 0) ? "alert-success" : "alert-danger" ?>">
                            <?= __('Km contract') . " : " ?><?= ($nbKmContractAlerts == 0) ? __("OK") : $nbKmContractAlerts ?></p>

                        <p class="alert alert2 <?= ($nbDateContractAlerts == 0) ? "alert-success" : "alert-danger" ?>">
                            <?= __('Date contract') . " : " ?><?= ($nbDateContractAlerts == 0) ? __("OK") : $nbDateContractAlerts ?></p>
                    </div>
                    </p>
                </div>
            </div>
        </div>
        <!-- end col -->
    <?php } ?>

        <?php if ($resultQuickLink) { ?>
            <div class="col-lg-4">
                <div class="panel panel-color panel-warning panel-height">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= __('Quick links') ?></h3>
                    </div>
                    <div class="panel-body">
                        <p>
                        <ul class="quick-links">
                            <li>
                                <div>
                                    <i class="fa fa-unlock-alt"></i>

                                    <form method='POST' target='_blanck' action="http://test-i2b.geoflotte.com/geotrack/access">
                                        <?php
                                        $username = $this->Session->read('Auth.User.username');?>
                                        <input type="hidden" name="en" value="i2b">
                                        <input type="hidden" name="lo" value=<?php echo $username; ?>>
                                        <input type="hidden" name="pw" value=<?php echo $password; ?>>

                                        <?php if ($client_i2b == 1) { ?>
                                            <button disabled="disabled"
                                                    style="color: #3c8dbc;background-color: transparent;border: transparent;margin: 0px;padding: 0px;font-size: 12px;line-height: 19px;margin-left: -1px;">
                                                <i class='fa fa-caret-right'
                                                   style="font-size: 10px;width: 10px;padding-top: 4px;font-weight: normal;color: #f9c851;"></i>
                                                <span><?= __("Connect to geolocation") ?></span>
                                            </button>
                                        <?php } else { ?>

                                            <button disabled="disabled"
                                                    style="color: #797979; background-color: transparent;border: transparent;margin: 0px;padding: 0px;font-size: 12px;line-height: 19px;margin-left: -1px;">
                                                <i class='fa fa-caret-right'
                                                   style="font-size: 10px;width: 10px;padding-top: 4px;font-weight: normal;color: #f9c851;"></i>
                                                <span><?= __("Connect to JasFleet") ?></span>
                                            </button>
                                        <?php } ?>
                                    </form>

                                    <?php if ($this->Session->read('Auth.User.role_id') == 3) { ?>
                                        <?= $this->Html->Link("<i class='fa fa-caret-right'></i>" . __("Route calculation"),
                                            array(
                                                'controller' => 'pages',
                                                'action' => 'maps'
                                            ),
                                            array('escape' => false)); ?>
                                    <?php } ?>
                                </div>
                            </li>
                            <li><i class="fa fa-truck"></i>

                                <div>
                                    <?php echo $this->Html->Link("<i class='fa fa-caret-right'></i>" . __("Car's list"), array(
                                        'controller' => 'cars',
                                        'action' => 'index'
                                    ), array('escape' => false)); ?>
                                    <?= $this->Html->Link("<i class='fa fa-caret-right'></i>" . __("Add a car"), array(
                                        'controller' => 'cars',
                                        'action' => 'add'
                                    ), array('escape' => false)); ?>
                                </div>
                            </li>
                            <li><i class="fa fa-user"></i>

                                <div>
                                    <?= $this->Html->Link("<i class='fa fa-caret-right'></i>" .
                                        __("Employees"), array(
                                        'controller' => 'customers',
                                        'action' => 'index'
                                    ), array('escape' => false)); ?>
                                    <?= $this->Html->Link("<i class='fa fa-caret-right'></i>" . __("Add a ") . " " .
                                        lcfirst(__("employee")), array(
                                        'controller' => 'customers',
                                        'action' => 'add'
                                    ), array('escape' => false)); ?>
                                </div>
                            </li>
                            <li><i class="fa fa-calendar-o"></i>

                                <div>
                                    <?= $this->Html->Link("<i class='fa fa-caret-right'></i>" .
                                        __("Affectation") . "s", array(
                                        'controller' => 'customerCars',
                                        'action' => 'index'
                                    ), array('escape' => false)); ?>
                                    <?= $this->Html->Link("<i class='fa fa-caret-right'></i>" . __("Add an ") . " " .
                                        lcfirst(__("Affectation")), array(
                                        'controller' => 'customerCars',
                                        'action' => 'add'
                                    ), array('escape' => false)); ?>
                                </div>
                            </li>
                            <li><i class="fa fa-tasks"></i>

                                <div>
                                    <?= $this->Html->Link("<i class='fa fa-caret-right'></i>" . __("Event's list"), array(
                                        'controller' => 'events',
                                        'action' => 'index'
                                    ), array('escape' => false)); ?>
                                    <?= $this->Html->Link("<i class='fa fa-caret-right'></i>" . __("Add an event"), array(
                                        'controller' => 'events',
                                        'action' => 'add'
                                    ), array('escape' => false)); ?>
                                </div>
                            </li>
                            <li><i class="zmdi zmdi-collection-text"></i>

                                <div>
                                    <?= $this->Html->Link("<i class='fa fa-caret-right'></i>" . __("Sheet rides (travels)"),
                                        array(
                                            'controller' => 'sheetRides',
                                            'action' => 'index'
                                        ), array('escape' => false)); ?>
                                    <?= $this->Html->Link("<i class='fa fa-caret-right'></i>" . __("Add sheet ride (travel)"),
                                        array(
                                            'controller' => 'sheetRides',
                                            'action' => 'add'
                                        ), array('escape' => false)); ?>
                                </div>
                            </li>
                            <li><i class="zmdi zmdi-store"></i>

                                <div>
                                    <?= $this->Html->Link("<i class='fa fa-caret-right'></i>" . __("Products"), array(
                                        'controller' => 'products',
                                        'action' => 'index'
                                    ), array('escape' => false)); ?>
                                    <?= $this->Html->Link("<i class='fa fa-caret-right'></i>" . __("Add Product"), array(
                                        'controller' => 'products',
                                        'action' => 'add'
                                    ), array('escape' => false)); ?>
                                </div>
                            </li>
                            <li><i class="zmdi zmdi-accounts"></i>

                                <div>
                                    <?= $this->Html->Link("<i class='fa fa-caret-right'></i>" . __("Suppliers"), array(
                                        'controller' => 'suppliers',
                                        'action' => 'index',
                                        0
                                    ), array('escape' => false)); ?>
                                    <?= $this->Html->Link("<i class='fa fa-caret-right'></i>" . __("Add Supplier"),
                                        array(
                                            'controller' => 'suppliers',
                                            'action' => 'add',
                                            0
                                        ), array('escape' => false)); ?>
                                </div>
                            </li>
                            <li><i class="zmdi zmdi-accounts-outline"></i>

                                <div>
                                    <?= $this->Html->Link("<i class='fa fa-caret-right'></i>" . __("Clients"), array(
                                        'controller' => 'suppliers',
                                        'action' => 'index',
                                        1
                                    ), array('escape' => false)); ?>
                                    <?= $this->Html->Link("<i class='fa fa-caret-right'></i>" . __("Add client"),
                                        array(
                                            'controller' => 'suppliers',
                                            'action' => 'add',
                                            1
                                        ), array('escape' => false)); ?>
                                </div>
                            </li>
                        </ul>


                        </p>
                    </div>
                </div>
            </div>
            <!-- end col -->
        <?php } ?>

        <div class="col-lg-4 ds ">
            <div class="inside-ds">
                <div class="panel panel-color panel-info panel-height">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= __('Sheet rides') ?></h3>
                    </div>
                    <div class="panel-body">
                        <p>
                            <?php foreach ($sheetRides as $sheetRide){ ?>

                            <div class="desc">
                                <div class="thumb">
                                    <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                                </div>
                                <div class="details">
                        <p>
                            <?php
                            switch ($sheetRide['SheetRide']['status_id']){
                                case 1:
                                    $status = '<span  class="label label-warning">' . __('Planned') . '</span>';

                                    break;
                                case 2:
                                    $status = '<span  class="label label-danger">' . __('In progress') . '</span>';
                                    break;
                                case 3:
                                    $status = '<span  class="label label-primary">' . __('Return to park') . '</span>';

                                    break;
                                case 4:
                                    $status = '<span  class="label label-success">' . __('Closed') . '</span>';
                                    break;

                                case 9:
                                    $status = '<span  class="label label-inverse">' . __('Canceled') . '</span>' . " ( " . $row['CancelCause']['name'] . " )";

                                    break;
                                default:
                                    $status = '<span></span>' ;

                                    break;
                            }
                            if (!empty($sheetRide['SheetRide']['real_start_date'])) { ?>
                                <muted><?= h($this->Time->format($sheetRide['SheetRide']['real_start_date'], '%d-%m-%Y')).' '.$status ?></muted>

                            <?php }else { ?>
                                <muted><?= h($this->Time->format($sheetRide['SheetRide']['start_date'], '%d-%m-%Y')).' '.$status  ?></muted>


                            <?php } ?>
                            <br>
                            <?= $this->Html->link(h($sheetRide['SheetRide']['reference']) . " : ",
                                array("controller" => "sheetRides", "action" => "view", $sheetRide['SheetRide']['id'])
                            ); ?>
                            <?= h($sheetRide['Carmodel']['name']) . " " . h($sheetRide['Car']['code']). " / " . h($sheetRide['Customer']['first_name']) . " " . h($sheetRide['Customer']['last_name'])?>
                            <br>
                        </p>
                    </div>
                </div>
                <?php } ?>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- end col -->

</div><!-- /.row -->
<?php $this->start('script'); ?>
<!-- InputMask -->
<?= $this->Html->script('d3.min'); ?>
<?= $this->Html->script('c3'); ?>
<?= $this->Html->script('plugins/charts/loader'); ?>
<?= $this->Html->script('plugins/echarts/echarts-all'); ?>


<script type="text/javascript">
    $(document ).ready(function(){
        var date=new Date();
        var tabMonth=new Array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11,12);
        var month = tabMonth[date.getMonth()];
        if(month ==1){
            var precedentMonth= 12;
        }else {
            var precedentMonth = month-1;
        }

        switch (month){
            case 1:
                var precedentMonth2 =11;
                break;
            case 2:
                var precedentMonth2 =10;
                break;
            case 3:
                var precedentMonth2 =9;
                break;
            case 4:
                var precedentMonth2 =8;
                break;
            default:
                var precedentMonth2= month-2;
                break;
        }

        var chart = c3.generate({
            bindto: '#chart4',
            data: {
                x: 'x',
                columns: [
                    ['x', precedentMonth2, precedentMonth, month],
                    ['Maintenance',<?php echo $costMaintenancesPrecedentMonth2 ?>,<?php echo $costMaintenancesPrecedentMonth ?>, <?php echo $costMaintenances ?>],
                    ['Carburant',<?php echo $costFuelsPrecedentMonth2 ?>,<?php echo $costFuelsPrecedentMonth ?> ,<?php echo $costFuels ?>],

                    ['Administratif',<?php echo $costAdministratifsPrecedentMonth2 ?>,<?php echo $costAdministratifsPrecedentMonth ?>, <?php echo $costAdministratifs ?>],
                ],
                type: 'bar',
                labels: true,

                types: {
                    data1: 'area',
                    data2: 'area',
                }
            },
            axis: {
                x: {
                    label: {
                        text: 'Mois',
                        position: 'outer-right'
                        // inner-right : default
                        // inner-center
                        // inner-left
                        // outer-right
                        // outer-center
                        // outer-left
                    }
                },
                y: {
                    label: {
                        text: 'Couts',
                        position: 'outer-right'
                    }
                }
            }
        });

        var chart2 = c3.generate({
            bindto: '#chart5',
            data: {
                x: 'x',
                columns: [
                    ['x', 1, 2],
                    ['Carburant', 1, 2],
                    ['Maintenance', 2, 3],
                ],
                type: 'bar',
                labels: true,
                colors: {
                    data1: '#ed100f',
                    data2: '#1f77b4'
                },
                types: {
                    data1: 'area',
                    data2: 'area',
                }
            },
            axis: {
                x: {
                    label: {
                        text: 'Semaines',
                        position: 'outer-right'
                        // inner-right : default
                        // inner-center
                        // inner-left
                        // outer-right
                        // outer-center
                        // outer-left
                    }
                },
                y: {
                    label: {
                        text: 'Couts',
                        position: 'outer-right'
                    }
                }
            }
        });





    });
</script>
<?php $this->end(); ?>


