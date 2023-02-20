<?php
$this->Html->css('slick', null, array('inline' => false));
?>
<div class="box-body main">
    <?php
    ?><h4
        class="page-title"> <?= $car['Car']['code'] . " - " . $car['Mark']['name'] . " " . $car['Carmodel']['name']; ?></h4>
    <?php
    $this->Html->css('colorbox', null, array('inline' => false));  ?>
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box m-b-5">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
                            <?= $this->Html->link(
                                '<i class="fa fa-edit m-r-5 m-r-5"></i>' . __("Edit"),
                                array('action' => 'Edit', $car['Car']['id'], $car['CarCategory']['id']),
                                array('escape' => false, 'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5")
                            );

                            /* $this->Html->link(
                               '<i class="fa fa-save m-r-5"></i>' . __("Save a copy"),
                               array('action' => 'saveCopy', $car['Car']['id']),
                               array('escape' => false, 'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5")
                           ); */

                            ?>

                            <?php if ($balanceCar == 2) { ?>
                                <?= $this->Html->link(
                                    '<i class="fa fa-rotate-right "></i>' . __("Reset balance"),
                                    array('action' => 'resetBalance', $car['Car']['id']),
                                    array('escape' => false, 'class' => 'btn btn-block btn-social btn-linkedin')
                                );
                            }?>

                            <?= $this->Form->postLink(
                                '<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __("Delete"),
                                array('action' => 'Delete', $car['Car']['id']),
                                array('escape' => false, 'class' => "btn btn-inverse btn-bordred waves-effect waves-light m-b-5"),
                                __('Are you sure you want to delete %s?', $car['Carmodel']['name'])); ?>


                            <?php

                            if ($car['Car']['alert'] == 1) {
                                ?>

                                <?= $this->Html->link(
                                    '<i class="fa  fa-bell"></i>' . __("disable alert"),
                                    array('action' => 'disableconsumptionalert', $car['Car']['id']),
                                    array('escape' => false, 'class' => 'btn btn-block btn-social btn-linkedin')); ?>
                            <?php } ?>
                            </a>

                            <div style="clear: both"></div>
                        </div>
                    </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-box">
        <h4 class="page-header"><?php echo __('Current km car : '); ?>  <span
                class='km'><?php if ($car['Car']['km'] > 0) echo h(number_format($car['Car']['km'], 2, ",", ".")); else echo h(number_format($car['Car']['km_initial'], 2, ",", ".")); ?> </span> <?php echo __(' km'); ?>
        </h4>
        <h4 class="page-header"><?php echo __('Global cost : '); ?>  <span
                class='km'><?php echo h(number_format($totalCost, 2, ",", ".")); ?> </span> <?php echo $this->Session->read("currency"); ?>
        </h4>

        <?php if ($balanceCar == 2) { ?>
            <h4 class="page-header"><?php echo __('Balance car : '); ?>  <span
                    class='km'><?php echo h(number_format($car['Car']['balance'], 2, ",", ".")); ?> </span> <?php echo $this->Session->read("currency"); ?>
            </h4>
        <?php } ?>
    </div>
    <div class="left_side card-box">


        <div class=" nav-tabs-custom">
            <ul class="nav nav-tabs">
                <!-- slide-slide-->

                <li id="1" class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                <li id="2"><a href="#tab_2" data-toggle="tab"><?= __('Purchase / Credit') ?></a></li>
                <?php if (!empty($leasings)) { ?>
                    <li id="3"><a href="#tab_3" data-toggle="tab"><?= __('Contrats') . ' ' . __('location') ?></a></li>
                <?php } ?>
                <li id="4"><a href="#tab_4" data-toggle="tab"><?= __('Performance / Consumption') ?></a></li>
                <li id="5"><a href="#tab_5" data-toggle="tab"><?= __('Affectation') . "s" ?></a></li>
                <li id="6"><a href="#tab_6" data-toggle="tab"><?= __('Consumptions') ?> </a></li>
                <li id="7"><a href="#tab_7" data-toggle="tab"><?= __('Assurances') ?> </a></li>
                <li id="8"><a href="#tab_8" data-toggle="tab"><?= __('Technical controls') ?> </a></li>
                <li id="9"><a href="#tab_9" data-toggle="tab"><?= __('Sewage') ?> </a></li>
                <li id="10"><a href="#tab_10" data-toggle="tab"><?= __('Vignettes') ?> </a></li>
                <li id="11"><a href="#tab_11" data-toggle="tab"><?= __('Incidents') ?> </a></li>
                <li id="12"><a href="#tab_12" data-toggle="tab"><?= __('Infractions') ?> </a></li>
                  <?php   if (Configure::read("gestion_commercial") == '1'  &&
                      Configure::read("tresorerie") == '1') { ?>
                <li id="13"><a href="#tab_13" data-toggle="tab"><?= __('Payment ') ?> </a></li>
                 <?php  } ?>
                <li id="14"><a href="#tab_14" data-toggle="tab"><?= __('Km/Month') ?> </a></li>
                <li id="15"><a href="#tab_15" data-toggle="tab"><?= __('Historique statut') ?> </a></li>
                <li id ='open_menu_view'>
                    <a href="#" data-toggle="dropdown" > <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li id='li_1'><a href="#" data-toggle="tab" id='id_1'
                                         onclick='show_menu(this.id)'><?= __('General information') ?></a></li>
                        <li id='li_2'><a href="#" data-toggle="tab" id='id_2'
                                         onclick='show_menu(this.id)'><?= __('Purchase / Credit') ?></a></li>
                        <?php if (!empty($leasings)) { ?>
                            <li id='li_3'><a href="#" data-toggle="tab" id='id_3'
                                             onclick='show_menu(this.id)'><?= __('Contrats') . ' ' . __('location') ?></a>
                            </li>
                        <?php } ?>
                        <li id='li_4'><a href="#" data-toggle="tab" id='id_4'
                                         onclick='show_menu(this.id)'><?= __('Performance / Consumption') ?></a></li>
                        <li id='li_5'><a href="#" data-toggle="tab" id='id_5'
                                         onclick='show_menu(this.id)'><?= __('Affectation') . "s" ?></a></li>
                        <li id='li_6'><a href="#" data-toggle="tab" id='id_6'
                                         onclick='show_menu(this.id)'><?= __('Consumptions') ?></a></li>
                        <li id='li_7'><a href="#" data-toggle="tab" id='id_7'
                                         onclick='show_menu(this.id)'><?= __('Assurances') ?> </a></li>
                        <li id='li_8'><a href="#" data-toggle="tab" id='id_8'
                                         onclick='show_menu(this.id)'><?= __('Technical controls') ?></a></li>
                        <li id='li_9'><a href="#" data-toggle="tab" id='id_9'
                                         onclick='show_menu(this.id)'><?= __('Sewage') ?></a></li>
                        <li id='li_10'><a href="#" data-toggle="tab" id='id_10'
                                          onclick='show_menu(this.id)'><?= __('Vignettes') ?> </a></li>
                        <li id='li_11'><a href="#" data-toggle="tab" id='id_11'
                                          onclick='show_menu(this.id)'><?= __('Incidents') ?></a></li>
                        <li id='li_12'><a href="#" data-toggle="tab" id='id_12'
                                          onclick='show_menu(this.id)'><?= __('Infractions') ?></a></li>

                        <?php  if (Configure::read("gestion_commercial") == '1') { ?>
                        <li id='li_13'><a href="#" data-toggle="tab" id='id_13'
                                          onclick='show_menu(this.id)'><?= __('Payment ') ?></a></li>
                        <?php } ?>
                        <li id='li_14'><a href="#" data-toggle="tab" id='id_14'
                                          onclick='show_menu(this.id)'><?= __('Km/Month') ?></a></li>
                        <li id='li_15'><a href="#" data-toggle="tab" id='id_15'
                                          onclick='show_menu(this.id)'><?= __('Historique statut') ?></a></li>
                    </ul>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <dl>
                        <dt><?php echo __('Code'); ?></dt>
                        <dd>
                            <?php echo h($car['Car']['code']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <?php if (isset($car['Parc']['name']) && !empty($car['Parc']['name'])) { ?>

                            <dt><?php echo __('Parc'); ?></dt>
                            <dd>
                                <?php echo h($car['Parc']['name']); ?>
                                &nbsp;
                            </dd>
                            <br/>
                        <?php } ?>

                        <?php if (isset($car['Department']['name']) && !empty($car['Department']['name'])) { ?>

                            <dt><?php echo __('Department'); ?></dt>
                            <dd>
                                <?php echo h($car['Department']['name']); ?>
                                &nbsp;
                            </dd>
                            <br/>
                        <?php } ?>

                        <dt><?php echo __('Mark'); ?></dt>
                        <dd>
                            <?php echo $car['Mark']['name']; ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt><?php echo __('Model'); ?></dt>
                        <dd>
                            <?php echo h($car['Carmodel']['name']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt><?php echo __('Km initial'); ?></dt>
                        <dd>

                            <?php echo h(number_format($car['Car']['km_initial'], 2, ",", ".")); ?>



                            &nbsp;
                        </dd>
                        <br/>
                        <dt><?php echo __('Km'); ?></dt>
                        <dd>

                            <?php if ($car['Car']['km'] > 0) echo h(number_format($car['Car']['km'], 2, ",", ".")); else echo h(number_format($car['Car']['km_initial'], 2, ",", ".")); ?>



                            &nbsp;
                        </dd>
                        <br/>
                        <dt><?php echo __('Status'); ?></dt>
                        <dd>
                            <?php echo h($car['CarStatus']['name']); ?>
                            &nbsp;
                        </dd>
                        <?php if (isset($car['CarCategory']['name']) && !empty($car['CarCategory']['name'])) { ?>
                            <br/>
                            <dt><?php echo __('Car Category'); ?></dt>
                            <dd>
                                <?php echo $car['CarCategory']['name']; ?>
                                &nbsp;
                            </dd>
                        <?php } ?>

                        <?php if (isset($car['CarType']['name']) && !empty($car['CarType']['name'])) { ?>
                            <br/>
                            <dt><?php echo __('Car Type'); ?></dt>
                            <dd>
                                <?php echo $car['CarType']['name']; ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <br/>
                        <dt><?php echo __('Fuel'); ?></dt>
                        <dd>
                            <?php echo $car['Fuel']['name']; ?>
                            &nbsp;
                        </dd>
                        <?php if (isset($car['Car']['nbplace']) && !empty($car['Car']['nbplace'])) { ?>
                            <br/>
                            <dt><?php echo __('Nb Place'); ?></dt>
                            <dd>
                                <?php echo h($car['Car']['nbplace']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (isset($car['Car']['nbdoor']) && !empty($car['Car']['nbdoor'])) { ?>
                            <br/>
                            <dt><?php echo __('Nb Door'); ?></dt>
                            <dd>
                                <?php echo h($car['Car']['nbdoor']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (isset($car['Car']['immatr_prov']) && !empty($car['Car']['immatr_prov'])) { ?>
                            <br/>
                            <dt><?php echo __('Immatr Prov'); ?></dt>
                            <dd>
                                <?php echo h($car['Car']['immatr_prov']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (isset($car['Car']['immatr_def']) && !empty($car['Car']['immatr_def'])) { ?>
                            <br/>
                            <dt><?php echo __('Immatr Def'); ?></dt>
                            <dd>
                                <?php echo h($car['Car']['immatr_def']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (isset($car['Car']['chassis']) && !empty($car['Car']['chassis'])) { ?>
                            <br/>
                            <dt><?php echo __('Chassis'); ?></dt>
                            <dd>
                                <?php echo h($car['Car']['chassis']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (isset($car['Car']['color2']) && !empty($car['Car']['color2'])) { ?>
                            <br/>
                            <dt><?php echo __('Color'); ?></dt>
                            <dd>
                                <?php echo h($car['Car']['color2']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (isset($car['Car']['circulation_date']) && !empty($car['Car']['circulation_date'])) { ?>
                            <br/>
                            <dt><?php echo __('Circulation Date'); ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($car['Car']['circulation_date'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (isset($car['Car']['date_approval']) && !empty($car['Car']['date_approval'])) { ?>
                            <br/>
                            <dt><?php echo __('Final registration date'); ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($car['Car']['date_approval'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (isset($car['Car']['radio_code']) && !empty($car['Car']['radio_code'])) { ?>
                            <br/>
                            <dt><?php echo __('Radio Code'); ?></dt>
                            <dd>
                                <?php echo h($car['Car']['radio_code']); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (isset($car['Car']['yellow_card']) && !empty($car['Car']['yellow_card'])) { ?>
                            <br/>
                            <dt><?php echo __('Yellow Card'); ?></dt>
                            <dd>
                                <?= $this->Html->Link($car['Car']['yellow_card'],
                                    '/attachments/yellowcards/' . $car['Car']['yellow_card'],
                                    array('class' => 'attachments', 'target' => '_blank')
                                ); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (isset($car['Car']['grey_card']) && !empty($car['Car']['grey_card'])) { ?>
                            <br/>
                            <dt><?php echo __('Grey Card'); ?></dt>
                            <dd>
                                <?= $this->Html->Link($car['Car']['grey_card'],
                                    '/attachments/greycards/' . $car['Car']['grey_card'],
                                    array('class' => 'attachments', 'target' => '_blank')
                                ); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (isset($car['Car']['picture1']) && !empty($car['Car']['picture1'])) { ?>
                    <br/>
                        <dd>

                            <a href="<?php echo $this->Html->url('/attachments/picturescar/size-' . $car['Car']['picture1']); ?>"
                               class="group1">
                                <?php    echo $this->Html->image('/attachments/picturescar/' . h($car['Car']['picture1']), array(
                                    'class' => 'picture_car'

                                )); ?>
                            </a>
                            <?php } ?>

                            <?php if (isset($car['Car']['picture2']) && !empty($car['Car']['picture2'])) { ?>
                                <a href="<?php echo $this->Html->url('/attachments/picturescar/size-' . $car['Car']['picture2']); ?>"
                                   class="group1">
                                    <?php    echo $this->Html->image('/attachments/picturescar/' . h($car['Car']['picture2']), array(
                                        'class' => 'picture_car'

                                    )); ?>
                                </a>
                            <?php } ?>
                            <br/>
                            <?php if (isset($car['Car']['picture3']) && !empty($car['Car']['picture3'])) { ?>
                                <a href="<?php echo $this->Html->url('/attachments/picturescar/size-' . $car['Car']['picture3']); ?>"
                                   class="group1">
                                    <?php    echo $this->Html->image('/attachments/picturescar/' . h($car['Car']['picture3']), array(
                                        'class' => 'picture_car'

                                    )); ?>
                                </a>
                            <?php } ?>
                            <?php if (isset($car['Car']['picture4']) && !empty($car['Car']['picture4'])) { ?>
                                <a href="<?php echo $this->Html->url('/attachments/picturescar/size-' . $car['Car']['picture4']); ?>"
                                   class="group1">
                                    <?php    echo $this->Html->image('/attachments/picturescar/' . h($car['Car']['picture4']), array(
                                        'class' => 'picture_car'

                                    )); ?>
                                </a>
                            <?php } ?>
                        </dd>

                        <?php if (isset($car['Car']['note']) && !empty($car['Car']['note'])) { ?>
                            <br/>
                            <dt><?php echo __('Note'); ?></dt>
                            <dd>
                                <?php echo nl2br(h($car['Car']['note'])); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <br/>
                    </dl>
                </div>
                <div class="tab-pane" id="tab_2">
                    <dl>
                        <?php if (isset($car['Supplier']['name']) && !empty($car['Supplier']['name'])) { ?>
                            <dt><?php echo __('Supplier'); ?></dt>
                            <dd>
                                <?php echo h($car['Supplier']['name']); ?>
                                &nbsp;
                            </dd>
                        <?php
                        }
                        if (isset($car['AcquisitionType']['name']) && !empty($car['AcquisitionType']['name'])) {
                            ?>
                            <br/>
                            <dt><?php echo __('Acquisition type'); ?></dt>
                            <dd>
                                <?php echo h($car['AcquisitionType']['name']); ?>
                                &nbsp;
                            </dd>
                        <?php
                        }
                        if (isset($car['Car']['purchase_date']) && !empty($car['Car']['purchase_date'])) {
                            ?>
                            <br/>
                            <dt><?php echo __('Purchase date'); ?></dt>
                            <dd>
                                <?php echo $this->Time->format($car['Car']['purchase_date'], '%d-%m-%Y'); ?>
                                &nbsp;
                            </dd>
                        <?php
                        }
                        if (isset($car['Car']['purchasing_price']) && !empty($car['Car']['purchasing_price'])) {
                            ?>
                            <br/>
                            <dt><?php echo __('Purchasing price'); ?></dt>
                            <dd>
                                <?php
                                if (!empty($car['Car']['purchasing_price'])) {
                                    echo number_format($car['Car']['purchasing_price'], 2, ",", ".") . " " . $this->Session->read("currency") . "&nbsp;";
                                }?>
                            </dd>
                        <?php
                        }
                        if (isset($car['Car']['current_price']) && !empty($car['Car']['current_price'])) {
                            ?>
                            <br/>
                            <dt><?php echo __('Current price'); ?></dt>
                            <dd>
                                <?php
                                if (!empty($car['Car']['current_price'])) {
                                    echo number_format($car['Car']['current_price'], 2, ",", ".") . " " . $this->Session->read("currency") . "&nbsp;";
                                }?>
                            </dd>
                        <?php
                        }
                        if (isset($car['Car']['reception_date']) && !empty($car['Car']['reception_date'])) {
                            ?>
                            <br/>
                            <dt><?php echo __('Reception date'); ?></dt>
                            <dd>
                                <?php echo $this->Time->format($car['Car']['reception_date'], '%d-%m-%Y'); ?>
                                &nbsp;
                            </dd>
                        <?php
                        }
                        if (isset($car['Car']['credit_date']) && !empty($car['Car']['credit_date'])) {
                            ?>
                            <br/>
                            <dt><?php echo __('Credit date'); ?></dt>
                            <dd>
                                <?php echo $this->Time->format($car['Car']['credit_date'], '%d-%m-%Y'); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (isset($car['Car']['monthly_payment']) && !empty($car['Car']['monthly_payment'])) { ?>
                            <br/>
                            <dt><?php echo __('Monthly payment'); ?></dt>
                            <dd>
                                <?php echo $car['Car']['monthly_payment'] . " " . $this->Session->read("currency"); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (isset($car['Car']['credit_duration']) && !empty($car['Car']['credit_duration'])) { ?>
                            <br/>
                            <dt><?php echo __('Credit duration'); ?></dt>
                            <dd>
                                <?php echo $car['Car']['credit_duration'] . " " . __("Month"); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                        <?php if (isset($eventAssurance['Event']['cost']) && !empty($event1ssurance['Event']['cost'])) { ?>
                            <br/>
                            <dt><?php echo __('Assurance amount'); ?></dt>
                            <dd>
                                <?php echo number_format($eventAssurance['Event']['cost'], 2, ",", ".") . " " . $this->Session->read("currency"); ?>

                                &nbsp;
                            </dd>
                        <?php } ?>



                        <?php if (isset($car['Car']['purchase_date']) && !empty($car['Car']['purchase_date']) && isset($car['Car']['nb_year_amortization']) && !empty($car['Car']['nb_year_amortization']) && isset($car['Car']['amortization_amount']) && !empty($car['Car']['amortization_amount'])) { ?>
                            <br/>
                            <dt><?php echo __('Amortization'); ?></dt>
                            <dd>
                                <?= $amortization; ?>
                                &nbsp;
                            </dd>
                        <?php } ?>





                        <?php if (isset($car['Car']['purchasing_attachment']) && !empty($car['Car']['purchasing_attachment'])) { ?>
                            <br/>
                            <dt><?php echo __('Attachment'); ?></dt>
                            <dd>
                                <?= $this->Html->Link($car['Car']['purchasing_attachment'],
                                    '/attachments/suppliers/' . $car['Car']['purchasing_attachment'],
                                    array('class' => 'attachments', 'target' => '_blank')
                                ); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>
                    </dl>
                </div>
                <div class="tab-pane" id="tab_3">


                    <?php foreach ($leasings as $leasing) { ?>
                        <dl>
                            <dt><?php echo __('Supplier'); ?></dt>
                            <dd><?php echo h($leasing['Supplier']['name']); ?>&nbsp;</dd>
                            <br/>
                            <dt><?php echo __('Acquisition type'); ?></dt>
                            <dd><?php echo h($leasing['AcquisitionType']['name']); ?>&nbsp;</dd>
                            <br/>
                            <dt><?php echo __('Number contract'); ?></dt>
                            <dd><?php echo h($leasing['Leasing']['num_contract']); ?>&nbsp;</dd>
                            <br/>
                            <dt><?php echo __('Reception date'); ?></dt>
                            <dd><?php echo h($this->Time->format($leasing['Leasing']['reception_date'], '%d-%m-%Y')); ?>
                                &nbsp;</dd>
                            <br/>
                            <dt><?php echo __('Planned end date'); ?></dt>
                            <dd><?php
                                if (!empty($leasing['Leasing']['end_date'])) {
                                    echo h($this->Time->format($leasing['Leasing']['end_date'], '%d-%m-%Y'));

                                } else {
                                    $nb_year = (int)$yearContract['Parameter']['val'];
                                    $nb_days = $nb_year * 365;
                                    $date_end = date_create($leasing['Leasing']['reception_date']);
                                    date_add($date_end, date_interval_create_from_date_string($nb_days . 'days'));
                                    echo $this->Time->format($date_end, '%d-%m-%Y');

                                }
                                ?>&nbsp;</dd>
                            <br/>
                            <dt><?php echo __('Real end date'); ?></dt>
                            <dd><?php echo h($this->Time->format($leasing['Leasing']['end_real_date'], '%d-%m-%Y')); ?>
                                &nbsp;</dd>
                            <br/>
                            <dt><?php echo __('Km annual'); ?></dt>
                            <dd><?php echo h($leasing['Leasing']['km_year']); ?>&nbsp;</dd>
                            <br/>
                            <dt><?php echo __('Counter / Km'); ?></dt>
                            <dd><?php echo h($leasing['Leasing']['reception_km']); ?>&nbsp;</dd>
                            <br/>


                            <dt><?php echo __('Contract duration'); ?></dt>
                            <?php
                            $datetime1 = $leasing['Leasing']['reception_date'];

                            if (!empty($leasing['Leasing']['end_date'])) {

                                $datetime2 = $leasing['Leasing']['end_date'];
                            } else {

                                $datetime2 = $date_end->format('Y-m-d');
                            }
                            $datetime1 = new DateTime ($datetime1);
                            $datetime2 = new DateTime ($datetime2);
                            $interval = date_diff($datetime1, $datetime2);
                            if ($interval->d >= 28) {
                                $mois = 1;
                            } else $mois = 0;
                            $total = $interval->y * 12 + $interval->m + $mois;?>
                            <dd> <?php echo $total;
                                echo __('Month') ?>&nbsp;</dd>
                            <br/>
                            <dt><?php echo __('Km Global Contract'); ?></dt>
                            <dd><?php $km_global = $leasing['Leasing']['km_year'] * ($total / 12);
                                echo number_format($km_global, 2, ",", "."); ?>&nbsp;</dd>
                            <br/>

                            <dt><?php echo __('Km Date'); ?></dt>
                            <dd><?php echo h(number_format($car['Car']['km'], 2, ",", ".")); ?> ?>&nbsp;</dd>
                            <br/>
                            <dt><?php echo __('Additional cost. At Km HT'); ?></dt>
                            <dd><?php echo number_format($leasing['Leasing']['cost_km'], 2, ",", "."); ?>&nbsp;</dd>
                            <br/>
                            <dt><?php echo __('Time for date / time in S1'); ?></dt>
                            <?php
                            $datetime1 = $leasing['Leasing']['reception_date'];
                            $datetime2 = date('Y-m-d');
                            $datetime1 = strtotime($datetime1);
                            $datetime2 = strtotime($datetime2);
                            $nbJoursTimestamp = $datetime2 - $datetime1;

                            $duree_s1 = $nbJoursTimestamp / 86400;
                            ?>
                            <dd> <?php echo number_format($duree_s1, 2, ",", "."); ?>&nbsp;</dd>
                            <br/>

                            <dt><?php echo __('Remaining time to time in S1'); ?></dt>

                            <dd> <?php $duree_restante = ($total * 30) - $duree_s1;
                                echo number_format($duree_restante, 2, ",", "."); ?>&nbsp;</dd>
                            <br/>

                            <dt><?php echo __('Past month'); ?></dt>


                            <dd> <?php $mois_ecoulé = $duree_s1 / 30;
                                echo number_format($mois_ecoulé, 2, ",", "."); ?>&nbsp;</dd>
                            <br/>

                            <dt><?php echo __('Rest termination / month'); ?></dt>

                            <dd> <?php $rest_contrat_mois = $duree_restante / 30;
                                echo number_format($rest_contrat_mois, 2, ",", "."); ?>&nbsp;</dd>
                            <br/>


                            <dt><?php echo __('Km/Mois'); ?></dt>
                            <dd><?php $km_mois = $km_global / $total;
                                echo number_format($km_mois, 2, ",", "."); ?>&nbsp;</dd>
                            <br/>

                            <dt><?php echo __('Km Remaining contract'); ?></dt>
                            <dd><?php $km_restant = $km_global - $car['Car']['km'];
                                echo number_format($km_restant, 2, ",", "."); ?>&nbsp;</dd>
                            <br/>


                            <dt><?php echo __('Remaining xx Month / D'); ?></dt>
                            <dd><?php $rest_mois_j = $km_mois * $rest_contrat_mois;
                                echo number_format($rest_mois_j, 2, ",", "."); ?>&nbsp;</dd>
                            <br/>

                            <dt><?php echo __('Contractual km to Date'); ?></dt>
                            <dd><?php $km_contractuel_date = ($km_global / $total) * $mois_ecoulé;
                                echo number_format($km_contractuel_date, 2, ",", "."); ?>&nbsp;</dd>
                            <br/>


                            <dt><?php echo __('Situation to Date'); ?></dt>
                            <dd><?php $situation_date = $car['Car']['km'] - $km_contractuel_date;
                                echo number_format($situation_date, 2, ",", "."); ?>&nbsp;</dd>
                            <br/>


                            <dt><?php echo __('+/- Value of contract dzd / km additional'); ?></dt>
                            <dd><?php if ($situation_date < 0) {
                                    echo 0;
                                } else {
                                    $value = $situation_date * $leasing['Leasing']['cost_km'];
                                    echo number_format($value, 2, ",", ".");
                                } ?>&nbsp;</dd>
                            <br/>


                            <dt><?php echo __('Monthly payment'); ?></dt>
                            <dd><?php echo number_format($leasing['Leasing']['amont_month'], 2, ",", "."); ?>&nbsp;</dd>
                            <br/>


                            <dt><?php echo __('Km estimated contract termination'); ?></dt>
                            <dd><?php $km_estimé = ($car['Car']['km'] / $mois_ecoulé) * $total;
                                echo number_format($km_estimé, 2, ",", "."); ?>&nbsp;</dd>
                            <br/>
                            <dt><?php echo __('Estimated distance KM termination'); ?></dt>
                            <dd><?php $estimation_ecart = $km_estimé - $km_global;
                                echo number_format($estimation_ecart, 2, ",", "."); ?>&nbsp;</dd>
                            <br/>


                        </dl>




                    <?php
                    }


                    ?>


                </div>


                <div class="tab-pane" id="tab_4">
                    <dl>
                        <?php if (isset($car['Car']['max_speed']) && !empty($car['Car']['max_speed'])) { ?>
                            <dt class="dt-car"><?php echo __('Max Speed'); ?></dt>
                            <dd>
                                <?php echo h($car['Car']['max_speed']) . " Km/h"; ?>
                                &nbsp;
                            </dd>
                        <?php
                        }
                        if (isset($car['Car']['reservoir']) && !empty($car['Car']['reservoir'])) {
                            ?>
                            <dt class="dt-car"><?php echo __('Reservoir'); ?></dt>
                            <dd>
                                <?php echo $car['Car']['reservoir'] . " L"; ?>
                                &nbsp;
                            </dd>
                        <?php
                        }
                        if (isset($car['Car']['min_consumption']) && !empty($car['Car']['min_consumption'])) {
                            ?>

                            <dt class="dt-car"><?php echo __('Min consumption'); ?></dt>
                            <dd>
                                <?php echo $car['Car']['min_consumption'] . " L/100Km"; ?>
                                &nbsp;
                            </dd>
                        <?php
                        }
                        if (isset($car['Car']['max_consumption']) && !empty($car['Car']['max_consumption'])) {
                            ?>
                            <dt class="dt-car"><?php echo __('Max consumption'); ?></dt>
                            <dd>
                                <?php echo $car['Car']['max_consumption'] . " L/100Km"; ?>
                                &nbsp;
                            </dd>
                        <?php
                        }

                        $consumptionModel = 'consumption_' . $car['Fuel']['code'];

                        if (!empty($car['Carmodel'][$consumptionModel])) {
                            ?>

                            <dt class="dt-car"><?php echo __('Nb Km for 1 coupon of ') . $car['Fuel']['name']; ?></dt>
                            <dd>
                                <?php echo h($car['Carmodel'][$consumptionModel]) . __(' Km'); ?>
                                &nbsp;
                            </dd>
                        <?php
                        }
                        if (isset($car['Car']['coupon_consumption']) && !empty($car['Car']['coupon_consumption'])) {
                            ?>
                            <dt class="dt-car"><?php echo __('Monthly consumption of coupons'); ?></dt>
                            <dd>
                                <?php echo $car['Car']['coupon_consumption']; ?>
                                &nbsp;
                            </dd>
                        <?php
                        }
                        if (isset($car['Car']['power_car']) && !empty($car['Car']['power_car'])) {
                            ?>
                            <dt class="dt-car"><?php echo __('Power car'); ?></dt>
                            <dd>
                                <?php echo $car['Car']['power_car']; ?>
                                &nbsp;
                            </dd>
                        <?php
                        }
                        ?>
                    </dl>
                </div>
                <div class="tab-pane" id="tab_5">
                    <table class="table table-bordered details">
                        <thead>
                        <tr>
                            <th>
                                <?php
                                echo $this->Paginator->sort('Customer.first_name', __("Conductor"));
                                ?>
                            </th>
                            <th><?php echo $this->Paginator->sort('start', __('Start')); ?></th>
                            <th><?php echo $this->Paginator->sort('end', __('End')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($customerCars as $customerCar): ?>
                            <tr id="row<?= $customerCar['CustomerCar']['id'] ?>">
                                <td>
                                    <?php
                                    if (!empty($customerCar['Customer']['company'])) {
                                        echo $customerCar['Customer']['company'] . " ";
                                    }
                                    echo $customerCar['Customer']['first_name'] . " " . $customerCar['Customer']['last_name']; ?>
                                    &nbsp;
                                </td>
                                <td><?php echo h($this->Time->format($customerCar['CustomerCar']['start'], '%d-%m-%Y %H:%M')); ?>
                                    &nbsp;</td>
                                <td><?php echo h($this->Time->format($customerCar['CustomerCar']['end'], '%d-%m-%Y %H:%M')); ?>
                                    &nbsp;</td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                    <?php
                    if ($this->params['paging']['CustomerCar']['pageCount'] > 1) {
                        ?>
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>    </p>
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php
                                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                echo $this->Paginator->numbers(array(
                                    'tag' => 'li',
                                    'first' => false,
                                    'last' => false,
                                    'separator' => '',
                                    'currentTag' => 'a'));
                                echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>

                <div class="tab-pane" id="tab_6">


                    <?php
                    $ConsumptionSum = 0;
                    $sumcost = 0;
                    if (!empty($consumptions)) {
                        ?>
                        <table class="table table-bordered details" cellspacing="0" width="80%">
                            <thead>
                            <tr>

                                <th><?php echo $this->Paginator->sort('type_consumption_used', __('Consumption type')); ?></th>
                                <th><?php echo $this->Paginator->sort('consumption_date', __('Consumption date')); ?></th>
                                <th><?php echo $this->Paginator->sort('nb_coupon', __('Nb coupon')); ?></th>
                                <th><?php echo $this->Paginator->sort('first_number_coupon', __('First number coupon')); ?></th>
                                <th><?php echo $this->Paginator->sort('last_number_coupon', __('Last number coupon')); ?></th>
                                <th><?php echo $this->Paginator->sort('', __('Serial numbers')); ?></th>
                                <th><?php echo $this->Paginator->sort('species', __('Species')); ?></th>
                                <th><?php echo $this->Paginator->sort('tank_id', __('Tank')); ?></th>
                                <th><?php echo $this->Paginator->sort('consumption_liter', __('Consumption liter')); ?></th>
                                <th><?php echo $this->Paginator->sort('fuel_card_id', __('Cards')); ?></th>
                                <th><?php echo $this->Paginator->sort('species_card', __('Species card')); ?></th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            foreach ($consumptions as $consumption) {
                                if ($consumption['SheetRide']['km_liter'] != null) {
                                    $ConsumptionSum = $ConsumptionSum + $consumption['SheetRide']['km_liter'];
                                }

                                if ($consumption['SheetRide']['cost'] != 0) {
                                    $sumcost = $sumcost + $consumption['SheetRide']['cost'];
                                }
                                ?>
                                <tr>
                                    <?php
                                    switch ($consumption['Consumption']['type_consumption_used']) {
                                        case ConsumptionTypesEnum::coupon :
                                            ?>
                                            <td> <?php echo __('Coupons'); ?></td>
                                            <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M')); ?> </td>
                                            <td><?php echo h($consumption['Consumption']['nb_coupon']); ?> </td>
                                            <td><?php echo h($consumption['Consumption']['first_number_coupon']); ?></td>
                                            <td><?php echo h($consumption['Consumption']['first_number_coupon']); ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <?php break;
                                        case ConsumptionTypesEnum::species:
                                            ?>
                                            <td> <?php echo __('Species'); ?></td>
                                            <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M')); ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo h($consumption['Consumption']['species']); ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <?php break;
                                        case ConsumptionTypesEnum::tank:
                                            ?>
                                            <td> <?php echo __('Tank'); ?></td>
                                            <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M')); ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo h($consumption['Tank']['name']); ?></td>
                                            <td><?php echo h($consumption['Consumption']['consumption_liter']); ?></td>
                                            <td></td>
                                            <td></td>
                                            <?php break;
                                        case ConsumptionTypesEnum::card:
                                            ?>
                                            <td> <?php echo __('Cards'); ?></td>
                                            <td><?php echo h($this->Time->format($consumption['Consumption']['consumption_date'], '%d-%m-%Y %H:%M')); ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo h($consumption['FuelCard']['reference']); ?></td>
                                            <td><?php echo h($consumption['Consumption']['species_card']); ?></td>
                                            <?php break;
                                    }

                                    ?>


                                </tr>

                            <?php } ?>

                            </tbody>
                        </table>
                        <?php

                        if ($this->params['paging']['Consumption']['pageCount'] > 1) {
                            ?>
                            <p>
                                <?php
                                echo $this->Paginator->counter(array(
                                    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                                ));
                                ?>    </p>
                            <div class="box-footer clearfix">
                                <ul class="pagination pagination-sm no-margin pull-left">
                                    <?php
                                    echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                    echo $this->Paginator->numbers(array(
                                        'tag' => 'li',
                                        'first' => false,
                                        'last' => false,
                                        'separator' => '',
                                        'currentTag' => 'a'));
                                    echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                    ?>
                                </ul>
                            </div>
                        <?php } ?>
                    <?php } ?>



                    <br><br>
                    <ul class="list-group m-b-0 user-list">
                        <?php echo "<div class='total'><b>" . __('Transactions sum :  ') . '</b><span class="badge bg-red">' . number_format($sumcost, 2, ",", ".") . " " . $this->Session->read('currency') . "</span></div>"; ?>
                    </ul>
                    <ul class="list-group m-b-0 user-list">
                        <?php     echo "<div class='total'><b>" . __('Consumptions sum :  ') . '</b><span class="badge bg-red">' . number_format($ConsumptionSum, 2, ",", ".");
                        if ($ConsumptionSum > 0) echo " " . __('Liter') . "s</span></div>"; else echo " " . __('Liter') . "</span></div>"; ?>
                    </ul>



                </div>

                <div class="tab-pane" id="tab_7">

                    <?= $this->Html->link(
                        '<i class="fa fa-add m-r-5 m-r-5"></i>' . __("Add"),
                        array('controller' => 'events', 'action' => 'add'),
                        array('escape' => false, 'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5")
                    ); ?>

                    <table class="table table-bordered details">
                        <thead>
                        <tr>

                            <th><?php echo $this->Paginator->sort('date', __('Date')); ?></th>
                            <th><?php echo $this->Paginator->sort('next_date', __('Next date')); ?></th>
                            <th><?php echo $this->Paginator->sort('assurance_number', __('Assurance number')); ?></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sumcost = 0;
                        foreach ($assurances as $assurance): ?>
                            <tr id="row<?= $assurance['Event']['id'] ?>">

                                <td><?php echo h($this->Time->format($assurance['Event']['date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>
                                <td><?php echo h($this->Time->format($assurance['Event']['next_date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>
                                <td><?php echo h($assurance['Event']['assurance_number']); ?>
                                    &nbsp;</td>

                                <?php if ($assurance['Event']['cost'] != 0) {
                                    $sumcost = $sumcost + $assurance['Event']['cost'];
                                } ?>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>
                    <?php


                    if ($this->params['paging']['Event']['pageCount'] > 1) {
                        ?>
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>    </p>
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php
                                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                echo $this->Paginator->numbers(array(
                                    'tag' => 'li',
                                    'first' => false,
                                    'last' => false,
                                    'separator' => '',
                                    'currentTag' => 'a'));
                                echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                ?>
                            </ul>
                        </div>
                    <?php
                    }
                    echo "<div class='total'><b>" . __('Transactions sum :  ') . '</b><span class="badge bg-red">' .
                        number_format($sumcost, 2, ",", ".") . " " . $this->Session->read('currency') . "</span></div>";
                    ?>
                </div>
                <div class="tab-pane" id="tab_8">

                    <?= $this->Html->link(
                        '<i class="fa fa-add m-r-5 m-r-5"></i>' . __("Add"),
                        array('controller' => 'events', 'action' => 'add'),
                        array('escape' => false, 'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5")
                    ); ?>
                    <table class="table table-bordered details">
                        <thead>
                        <tr>

                            <th><?php echo $this->Paginator->sort('date', __('Date')); ?></th>
                            <th><?php echo $this->Paginator->sort('next_date', __('Next date')); ?></th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sumcost = 0;
                        foreach ($technicalControls as $technicalControl): ?>
                            <tr id="row<?= $technicalControl['Event']['id'] ?>">

                                <td><?php echo h($this->Time->format($technicalControl['Event']['date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>
                                <td><?php echo h($this->Time->format($technicalControl['Event']['next_date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>

                                <?php if ($technicalControl['Event']['cost'] != 0) {
                                    $sumcost = $sumcost + $technicalControl['Event']['cost'];
                                } ?>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                    <?php
                    if ($this->params['paging']['Event']['pageCount'] > 1) {
                        ?>
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>    </p>
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php
                                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                echo $this->Paginator->numbers(array(
                                    'tag' => 'li',
                                    'first' => false,
                                    'last' => false,
                                    'separator' => '',
                                    'currentTag' => 'a'));
                                echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                ?>
                            </ul>
                        </div>
                    <?php
                    }
                    echo "<div class='total'><b>" . __('Transactions sum :  ') . '</b><span class="badge bg-red">' .
                        number_format($sumcost, 2, ",", ".") . " " . $this->Session->read('currency') . "</span></div>";

                    ?>
                </div>
                <div class="tab-pane" id="tab_9">

                    <?= $this->Html->link(
                        '<i class="fa fa-add m-r-5 m-r-5"></i>' . __("Add"),
                        array('controller' => 'events', 'action' => 'add'),
                        array('escape' => false, 'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5")
                    ); ?>
                    <table class="table table-bordered details">
                        <thead>
                        <tr>

                            <th><?php echo $this->Paginator->sort('date', __('Date')); ?></th>
                            <th><?php echo $this->Paginator->sort('km', __('Km')); ?></th>
                            <th><?php echo $this->Paginator->sort('next_km', __('Next km')); ?></th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sumcost = 0;
                        foreach ($vidanges as $vidange): ?>
                            <tr id="row<?= $vidange['Event']['id'] ?>">

                                <td><?php echo h($this->Time->format($vidange['Event']['date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>
                                <td><?php echo h($vidange['Event']['km']); ?>&nbsp;</td>
                                <td><?php echo h($vidange['Event']['next_km']); ?>&nbsp;</td>

                                <?php if ($vidange['Event']['cost'] != 0) {
                                    $sumcost = $sumcost + $vidange['Event']['cost'];
                                } ?>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                    <?php
                    if ($this->params['paging']['Event']['pageCount'] > 1) {
                        ?>
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>    </p>
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php
                                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                echo $this->Paginator->numbers(array(
                                    'tag' => 'li',
                                    'first' => false,
                                    'last' => false,
                                    'separator' => '',
                                    'currentTag' => 'a'));
                                echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                ?>
                            </ul>
                        </div>
                    <?php
                    }

                    echo "<div class='total'><b>" . __('Transactions sum :  ') . '</b><span class="badge bg-red">' .
                        number_format($sumcost, 2, ",", ".") . " " . $this->Session->read('currency') . "</span></div>";
                    ?>
                </div>
                <div class="tab-pane" id="tab_10">
                    <?= $this->Html->link(
                        '<i class="fa fa-add m-r-5 m-r-5"></i>' . __("Add"),
                        array('controller' => 'events', 'action' => 'add'),
                        array('escape' => false, 'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5")
                    ); ?>
                    <table class="table table-bordered details">
                        <thead>
                        <tr>

                            <th><?php echo $this->Paginator->sort('date', __('Date')); ?></th>
                            <th><?php echo $this->Paginator->sort('next_date', __('Next date')); ?></th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sumcost = 0;
                        foreach ($vignettes as $vignette): ?>
                            <tr id="row<?= $vignette['Event']['id'] ?>">

                                <td><?php echo h($this->Time->format($vignette['Event']['date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>
                                <td><?php echo h($this->Time->format($vignette['Event']['next_date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>
                                <?php if ($vignette['Event']['cost'] != 0) {
                                    $sumcost = $sumcost + $vignette['Event']['cost'];
                                } ?>

                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                    <?php
                    if ($this->params['paging']['Event']['pageCount'] > 1) {
                        ?>
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>    </p>
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php
                                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                echo $this->Paginator->numbers(array(
                                    'tag' => 'li',
                                    'first' => false,
                                    'last' => false,
                                    'separator' => '',
                                    'currentTag' => 'a'));
                                echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                ?>
                            </ul>
                        </div>
                    <?php
                    }
                    echo "<div class='total'><b>" . __('Transactions sum :  ') . '</b><span class="badge bg-red">' .
                        number_format($sumcost, 2, ",", ".") . " " . $this->Session->read('currency') . "</span></div>";

                    ?>
                </div>

                <div class="tab-pane" id="tab_11">
                    <?= $this->Html->link(
                        '<i class="fa fa-add m-r-5 m-r-5"></i>' . __("Add"),
                        array('controller' => 'events', 'action' => 'add'),
                        array('escape' => false, 'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5")
                    ); ?>
                    <table class="table table-bordered details">
                        <thead>
                        <tr>

                            <th><?php echo $this->Paginator->sort('date', __('Date')); ?></th>
                            <th><?php echo $this->Paginator->sort('next_date', __('Next date')); ?></th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sumcost = 0;
                        foreach ($incidents as $incident): ?>
                            <tr id="row<?= $incident['Event']['id'] ?>">

                                <td><?php echo h($this->Time->format($incident['Event']['date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>
                                <td><?php echo h($this->Time->format($incident['Event']['next_date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>
                                <?php if ($incident['Event']['cost'] != 0) {
                                    $sumcost = $sumcost + $incident['Event']['cost'];
                                } ?>

                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                    <?php
                    if ($this->params['paging']['Event']['pageCount'] > 1) {
                        ?>
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>    </p>
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php
                                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                echo $this->Paginator->numbers(array(
                                    'tag' => 'li',
                                    'first' => false,
                                    'last' => false,
                                    'separator' => '',
                                    'currentTag' => 'a'));
                                echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                ?>
                            </ul>
                        </div>
                    <?php
                    }

                    echo "<div class='total'><b>" . __('Transactions sum :  ') . '</b><span class="badge bg-red">' .
                        number_format($sumcost, 2, ",", ".") . " " . $this->Session->read('currency') . "</span></div>";

                    ?>
                </div>

                <div class="tab-pane" id="tab_12">
                    <?= $this->Html->link(
                        '<i class="fa fa-add m-r-5 m-r-5"></i>' . __("Add"),
                        array('controller' => 'events', 'action' => 'add'),
                        array('escape' => false, 'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5")
                    ); ?>
                    <table class="table table-bordered details">
                        <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('Customer.first_name', __('Customer')); ?></th>
                            <th><?php echo $this->Paginator->sort('date', __('Date')); ?></th>
                            <th><?php echo $this->Paginator->sort('place', __('Place')); ?></th>
                            <th><?php echo $this->Paginator->sort('contravention_type_id', __('Contravention type')); ?></th>
                            <th><?php echo $this->Paginator->sort('driving_licence_withdrawal', __('Driving licence withdrawal')); ?></th>
                            <th><?php echo $this->Paginator->sort('cost', __('Cost')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sumcost = 0;
                        foreach ($contraventions as $contravention): ?>

                            <tr id="row<?= $contravention['Event']['id'] ?>">
                                <td><?php echo h($contravention['Customer']['first_name'] . ' ' . $contravention['Customer']['last_name']); ?>
                                    &nbsp;</td>
                                <td><?php echo h($this->Time->format($contravention['Event']['date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>
                                <td><?php echo $contravention['Event']['place'] ?></td>
                                <td><?php

                                    switch ($contravention['Event']['contravention_type_id']){
                                        case 1:
                                            $contraventionType = 'Arrêt ou stationnement dangereux';
                                            break;

                                        case 2:
                                            $contraventionType = 'Conduite en sens opposé à la circulation';
                                            break;

                                        case 3:
                                            $contraventionType = 'Défaut au gabarit des véhicules, à l’installation des dispositifs d’éclairage et de signalisation des véhicules';
                                            break;

                                        case 4:
                                            $contraventionType = 'Défaut sur le véhicule';
                                            break;

                                        case 5:
                                            $contraventionType = 'Empiètement d’une ligne continue';
                                            break;

                                        case 6:
                                            $contraventionType = 'Franchissement d’une ligne continue';
                                            break;

                                        case 7:
                                            $contraventionType = 'Manœuvres interdites sur autoroutes et routes express';
                                            break;

                                        case 8:
                                            $contraventionType = 'Non port de la ceinture de sécurité';
                                            break;

                                        case 9:
                                            $contraventionType = 'Non respect de la charge maximale par essieu';
                                            break;

                                        case 10:
                                            $contraventionType = 'Non respect de la distance légale entre les véhicules';
                                            break;

                                        case 11:
                                            $contraventionType = 'Non respect de la priorité de passage des piétons au niveau des passages protégés';
                                            break;

                                        case 12:
                                            $contraventionType = 'Non respect des bonnes règles de conduite';
                                            break;

                                        case 13:
                                            $contraventionType = 'Non respect des dispositions relatives aux intersections de routes et à la priorité de passage';
                                            break;

                                        case 14:
                                            $contraventionType = 'Non respect des règles de limitations de vitesse';
                                            break;

                                        case 15:
                                            $contraventionType = 'Non respect des règles d’installation, de spécifications, de fonctionnement et de la maintenance du chrono tachygraphe';
                                            break;

                                        case 16:
                                            $contraventionType = 'Non respect des règles d’installation, de spécifications, de fonctionnement et de la maintenance du chrono tachygraphe';
                                            break;

                                        case 17:
                                            $contraventionType = 'Usage manuel du téléphone portable';
                                            break;
                                    }


                                    echo $contraventionType ; ?></td>
                                <td><?php
                                    switch ($contravention['Event']['driving_licence_withdrawal']){
                                        case 1:
                                            $drivingLicenceWithdrawal = __('Yes');
                                            break;

                                        case 2:
                                            $drivingLicenceWithdrawal = __('No');
                                            break;
                                    }

                                    echo $drivingLicenceWithdrawal ; ?></td>

								<td><?php echo number_format($contravention['Event']['cost'], 2, ",", ".") ?></td>
                                <?php if ($contravention['Event']['cost'] != 0) {
                                    $sumcost = $sumcost + $contravention['Event']['cost'];
                                } ?>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                    <?php
                    if ($this->params['paging']['Event']['pageCount'] > 1) {
                        ?>
                        <p>
                            <?php
                            echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>    </p>
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php
                                echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                echo $this->Paginator->numbers(array(
                                    'tag' => 'li',
                                    'first' => false,
                                    'last' => false,
                                    'separator' => '',
                                    'currentTag' => 'a'));
                                echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
                                ?>
                            </ul>
                        </div>
                    <?php
                    }

                    echo "<div class='total'><b>" . __('Transactions sum :  ') . '</b><span class="badge bg-red">' .
                        number_format($sumcost, 2, ",", ".") . " " . $this->Session->read('currency') . "</span></div>";

                    ?>
                </div>
                <div class="tab-pane" id="tab_13">


                    <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">

                        <thead>
                        <tr>
                            <th><?php echo __('Reference'); ?></th>
                            <th><?php echo __('Payment date'); ?></th>
                            <th><?php echo __('Compte'); ?></th>
                            <th><?php echo __('Payment type'); ?></th>
                            <th><?php echo __('Amount'); ?></th>
                        </tr>
                        </thead>

                        <tbody>


                        <?php
                        $totalAmount = 0;

                        foreach ($payments as $payment) {
                            ?>
                            <tr>
                                <td><?php echo h($payment['Payment']['wording']); ?>&nbsp;</td>
                                <td><?php echo h($this->Time->format($payment['Payment']['receipt_date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>
                                <td><?php echo h($payment['Compte']['num_compte']); ?>&nbsp;</td>
                                <?php
                                $options = array('1' => __('Species'), '2' => __('Transfer'), '3' => __('Bank check'));
                                switch ($payment['Payment']['payment_type']) {
                                    case 1:
                                        $type = __('Species');
                                        break;
                                    case 2:
                                        $type = __('Transfer');
                                        break;
                                    case 3:
                                        $type = __('Bank check');
                                        break;

                                }
                                ?>
                                <td><?php echo h($type); ?></td>
                                <td><?php echo h(number_format($payment['Payment']['amount'], 2, ",", ".")) . "  " . $this->Session->read("currency"); ?></td>
                            </tr>
                            <?php
                            $totalAmount = $totalAmount + $payment['Payment']['amount'];
                        }


                        ?>


                        </tbody>
                    </table>

                    <?php
                    $rest =0;
                    if ($car['Car']['purchasing_price'] > $totalAmount) {
                        $rest = $car['Car']['purchasing_price'] - $totalAmount;
                    }

                    echo "<div class='total'><b>" . __('Total payé :  ') . '</b><span class="badge bg-red">' .
                        number_format($totalAmount, 2, ",", ".") . " " . $this->Session->read('currency') . "</span></div><br/>";

                    echo "<div class='total'><b>" . __('Reste à payer :  ') . '</b><span class="badge bg-red">' .
                        number_format($rest, 2, ",", ".") . " " . $this->Session->read('currency') . "</span></div>";     ?>
                </div>

                <div class="tab-pane" id="tab_14">


                    <table class="table table-striped table-bordered dt-responsive nowrap"
                           cellspacing="0" width="100%">

                        <thead>
                        <tr>
                            <th><?php echo __('Year'); ?></th>
                            <th><?php echo __('Km ') . __("January"); ?></th>
                            <th><?php echo __('Km ') . __("February"); ?></th>
                            <th><?php echo __('Km ') . __("March"); ?></th>
                            <th><?php echo __('Km ') . __("April"); ?></th>
                            <th><?php echo __('Km ') . __("May"); ?></th>
                            <th><?php echo __('Km ') . __("June"); ?></th>
                            <th><?php echo __('Km ') . __("July"); ?></th>
                            <th><?php echo __('Km ') . __("August"); ?></th>
                            <th><?php echo __('Km ') . __("September"); ?></th>
                            <th><?php echo __('Km ') . __("October"); ?></th>
                            <th><?php echo __('Km ') . __("November"); ?></th>
                            <th><?php echo __('Km ') . __("December"); ?></th>
                        </tr>
                        </thead>

                        <tbody>


                        <?php foreach ($monthlyKms as $monthlyKm) { ?>
                            <tr>
                                <td><?php echo h($monthlyKm['Monthlykm']['year']); ?>&nbsp;</td>
                                <td><?php echo h($monthlyKm['Monthlykm']['km_1']); ?>&nbsp;</td>
                                <td><?php echo h($monthlyKm['Monthlykm']['km_2']); ?>&nbsp;</td>
                                <td><?php echo h($monthlyKm['Monthlykm']['km_3']); ?>&nbsp;</td>
                                <td><?php echo h($monthlyKm['Monthlykm']['km_4']); ?>&nbsp;</td>
                                <td><?php echo h($monthlyKm['Monthlykm']['km_5']); ?>&nbsp;</td>
                                <td><?php echo h($monthlyKm['Monthlykm']['km_6']); ?>&nbsp;</td>
                                <td><?php echo h($monthlyKm['Monthlykm']['km_7']); ?>&nbsp;</td>
                                <td><?php echo h($monthlyKm['Monthlykm']['km_8']); ?>&nbsp;</td>
                                <td><?php echo h($monthlyKm['Monthlykm']['km_9']); ?>&nbsp;</td>
                                <td><?php echo h($monthlyKm['Monthlykm']['km_10']); ?>&nbsp;</td>
                                <td><?php echo h($monthlyKm['Monthlykm']['km_11']); ?>&nbsp;</td>
                                <td><?php echo h($monthlyKm['Monthlykm']['km_12']); ?>&nbsp;</td>

                            </tr>
                        <?php
                        }


                        ?>


                        </tbody>
                    </table>


                </div>

                <div class="tab-pane" id="tab_15">


                    <table class="table table-striped table-bordered dt-responsive nowrap"
                           cellspacing="0" width="100%">

                        <thead>
                        <tr>
                            <th><?php echo __('Status'); ?></th>
                            <th><?php echo __('Start date'); ?></th>
                            <th><?php echo __('End date'); ?></th>

                        </tr>
                        </thead>

                        <tbody>


                        <?php foreach ($carCarStatuses as $carCarStatus) { ?>
                            <tr>
                                <td><?php echo h($carCarStatus['CarStatus']['name']); ?>&nbsp;</td>

                                <td><?php echo h($this->Time->format($carCarStatus['CarCarStatus']['start_date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>
                                <td><?php echo h($this->Time->format($carCarStatus['CarCarStatus']['end_date'], '%d-%m-%Y')); ?>
                                    &nbsp;</td>


                            </tr>
                        <?php
                        }


                        ?>


                        </tbody>
                    </table>


                </div>


            </div>
        </div>
    </div>

    <?php if ($hasPermission) { ?>
        <div class="right_side">

            <h6 class="subheader"><?php echo __('Created'); ?></h6>

            <p><?php echo h($this->Time->format($car['Car']['created'], '%d-%m-%Y %H:%M')); ?></p>
            <h6 class="subheader"><?php echo __('By'); ?></h6>

            <p><?php echo h($car['User']['first_name']) . " " . h($car['User']['last_name']); ?></p>

            <?php if (!empty($car['Car']['modified_id'])) {
                ?>
                <h6 class="subheader"><?php echo __('Modified'); ?></h6>
                <p><?php echo h($this->Time->format($car['Car']['modified'], '%d-%m-%Y %H:%M')); ?></p>
                <h6 class="subheader"><?php echo __('By'); ?></h6>
                <p><?php echo h($car['UserModifier']['first_name']) . " " . h($car['UserModifier']['last_name']); ?></p>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<div style='clear:both; padding-top: 10px;'></div>




<?php /* if ($hasPermission && !empty($audits)) { ?>

 <div class="lbl2"><a class="btn  btn-act btn-info" href="#demo" data-toggle="collapse">
                        <i class="  fa fa-eye m-r-5" style="font-size: 1.3em !important;line-height: 30px !important;"></i>
						<i class="more-less glyphicon glyphicon-chevron-down"></i>
                         <?= __("  Voir audits"); ?>
                    </a> </div>
                            

                               
                               
                                    
                                    <?php if (!empty($audits)){?>
					<div id="demo" class="collapse nav-tabs-custom col-md-4">				
									

 <table>
    <?php     foreach($audits as $audit) { ?>
        
    <tr >

        <td ><dt style='padding-right: 10px; margin-left: 10px; padding-bottom: 5px; padding-top: 10px;' ><?php echo __('Modified'); ?></dt></td>
        <td><dd style='padding-right: 10px; padding-bottom: 5px; padding-top: 10px;'><?php echo h($this->Time->format($audit['Audit']['created'], '%d-%m-%Y %H:%M')); ?></dd><td>
        <td ><dt style='padding-right: 10px; padding-bottom: 5px; padding-top: 10px;'><?php echo __('By'); ?></dt></td>
        <td><dd style='padding-right: 10px; padding-bottom: 5px; padding-top: 10px;'><?php echo h($audit['User']['first_name'])." ".h($audit['User']['last_name']); ?></dd><td>



</tr>
        <?php } ?>
        </table>
        </br>
		                <?php
if($this->params['paging']['Audit']['pageCount'] > 1){


?>
<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
<div class="box-footer clearfix">
    <ul class="pagination pagination-sm no-margin pull-left">
	<?php
		echo $this->Paginator->prev('<<', array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
		echo $this->Paginator->numbers(array(
                    'tag' => 'li',
                    'first' => false,
                    'last' => false,
                    'separator' => '',
                    'currentTag' => 'a'));
		echo $this->Paginator->next('>>', array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
	?>
    </ul>
</div>
<?php } ?>
		</div>
        <?php } ?>


                              

<?php }  */
?>























<?php $this->start('script'); ?>

<?= $this->Html->script('jquery.colorbox.js'); ?>
<?= $this->Html->script('slick.min.js'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        //Examples of how to assign the Colorbox event to elements
        $(".group1").colorbox({rel: 'group1'});

        $('#5').hide();
        $('#6').hide();
        $('#7').hide();
        $('#8').hide();
        $('#9').hide();
        $('#10').hide();
        $('#11').hide();
        $('#12').hide();
        $('#13').hide();
        $('#14').hide();
        $('#15').hide();
        $('#li_1').hide();
        $('#li_2').hide();
        $('#li_3').hide();
        $('#li_4').hide();

    });


    function show_menu(id) {
        var num = id.substring(3, id.length);


        for (var l = 1; l <= 15; l++) {
            jQuery("#li_" + '' + l + '' + "").removeClass('active');
        }
        jQuery("#li_" + '' + num + '' + "").addClass('active');

        if (num > 4) {
            var num_hide = num - 4;

            for (var i = 1; i <= 15; i++) {
                jQuery("#" + '' + i + '' + "").removeClass('active');
                jQuery("#tab_" + '' + i + '' + "").removeClass('active');
                $("#" + '' + i + '' + "").hide();
                $("#li_" + '' + i + '' + "").show();
            }
            for (var i = num + 1; i <= 15; i++) {
                jQuery("#" + '' + i + '' + "").removeClass('active');
                jQuery("#tab_" + '' + i + '' + "").removeClass('active');
                $("#" + '' + i + '' + "").hide();
                $("#li_" + '' + i + '' + "").show();
            }
            for (var j = num_hide + 1; j <= num; j++) {
                $("#" + '' + j + '' + "").show();
                jQuery("#" + '' + j + '' + "").removeClass('active');
                jQuery("#tab_" + '' + j + '' + "").removeClass('active');
                $("#li_" + '' + j + '' + "").hide();
            }
        }
        else {
            var num_hide = num + 4;

            for (var i = 1; i <= 4; i++) {
                $("#" + '' + i + '' + "").show();
                jQuery("#" + '' + i + '' + "").removeClass('active');
                jQuery("#tab_" + '' + i + '' + "").removeClass('active');
                $("#li_" + '' + i + '' + "").hide();
            }
            for (var j = 5; j <= 15; j++) {
                jQuery("#" + '' + j + '' + "").removeClass('active');
                jQuery("#tab_" + '' + j + '' + "").removeClass('active');
                $("#" + '' + j + '' + "").hide();
                $("#li_" + '' + j + '' + "").show();
            }


        }


        jQuery("#" + '' + num + '' + "").addClass('active');
        jQuery("#tab_" + '' + num + '' + "").addClass('active');


    }


</script>
<?php $this->end(); ?>
