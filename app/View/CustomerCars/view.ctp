<?php
/** @var $customerCar array */
/**    @var $affectationpv0s array */
/**    @var $affectationpv1s array */
/**    @var $autorisations array */
/**    @var $haspermission array */
/**    @var array $customersGroup */
?>
<div class="box-body main">
    <?php
    ?><h4 class="page-title"> <?= __("Affectation") . " N° " . $customerCar['CustomerCar']['reference']; ?></h4>
    <?php
    $this->Html->css('colorbox', null, array('inline' => false));  ?>
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
                            <?php
                            if ($customerCar ['CustomerCar']['request'] == 1) {
                                echo $this->Html->link(
                                    '<i class="  fa fa-edit m-r-5 m-r-5"></i>' . __("Edit"),
                                    array('action' => 'edit_request', $customerCar['CustomerCar']['id']),
                                    array(
                                        'escape' => false,
                                        'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5"
                                    )
                                );
                            } elseif ($customerCar ['CustomerCar']['temporary'] == 1) {
                                echo $this->Html->link(
                                    '<i class="  fa fa-edit m-r-5 m-r-5"></i>' . __("Edit" . " " . lcfirst(__("Affectation"))),
                                    array('action' => 'edit_temporary', $customerCar['CustomerCar']['id']),
                                    array(
                                        'escape' => false,
                                        'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5"
                                    )
                                );
                            } else {
                                echo $this->Html->link(
                                    '<i class="  fa fa-edit m-r-5 m-r-5"></i>' . __("Edit" . " " . lcfirst(__("Affectation"))),
                                    array('action' => 'edit', $customerCar['CustomerCar']['id']),
                                    array(
                                        'escape' => false,
                                        'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5"
                                    )
                                );
                            }


                            if ($customerCar ['CustomerCar']['request'] != 1 && $customerCar ['CustomerCar']['temporary'] != 1) {
                                echo $this->Html->link(
                                    '<i class=" fa fa-print m-r-5 m-r-5"></i>' . __("PV de reception"),
                                    array(
                                        'action' => 'affectation_pv',
                                        'ext' => 'pdf',
                                        $customerCar['CustomerCar']['id'],
                                        0
                                    ),
                                    array(
                                        'escape' => false,
                                        'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5 m-r-5",
                                        'target' => '_blank'
                                    )
                                );
                                echo $this->Html->link(
                                    '<i class=" fa fa-print m-r-5 m-r-5"></i>' . __("PV de restitution"),
                                    array(
                                        'action' => 'affectation_pv',
                                        'ext' => 'pdf',
                                        $customerCar['CustomerCar']['id'],
                                        1
                                    ),
                                    array(
                                        'escape' => false,
                                        'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5 m-r-5",
                                        'target' => '_blank'
                                    )
                                );
                            }
                            if ($customerCar ['CustomerCar']['request'] != 1) {
                                echo $this->Html->link(
                                    '<i class=" fa fa-print m-r-5 m-r-5"></i>' . __("Décharge"),
                                    array('action' => 'dechargePdf', 'ext' => 'pdf', $customerCar['CustomerCar']['id']),
                                    array(
                                        'escape' => false,
                                        'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5 m-r-5",
                                        'target' => '_blank'
                                    )
                                );
                            }
                            ?>
                            <?= $this->Form->postLink(
                                '<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __("Delete"),
                                array('action' => 'Delete', $customerCar['CustomerCar']['id']),
                                array(
                                    'escape' => false,
                                    'class' => "btn btn-inverse btn-bordred waves-effect waves-light m-b-5"
                                ),
                                __('Are you sure you want to delete this element ?')); ?>

                            <div style="clear: both"></div>
                        </div>
                    </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                </div>
            </div>
        </div>
    </div>
    <div class="left_side card-box p-b-0">

        <div class="nav-tabs-custom pdg_btm">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                <li><a href="#tab_2" data-toggle="tab"><?= __('Departure') ?></a></li>
                <li><a href="#tab_3" data-toggle="tab"><?= __('Arrival') ?></a></li>
                <?php if ($customerCar ['CustomerCar']['request'] != 1 && $customerCar ['CustomerCar']['temporary'] != 1) { ?>
                    <li><a href="#tab_4" data-toggle="tab"><?= __('Etat vehicule') ?></a></li>

                <li><a href="#tab_5" data-toggle="tab"><?= __('Autorisation') ?></a></li>
                <?php } ?>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <dl>
                        <?php
                        if ($customerCar ['CustomerCar']['request'] == 1) {
                            ?>
                            <dt><?php echo __('Type'); ?></dt>
                            <dd>
                                <?php echo $customerCar['CarType']['name']; ?>
                                &nbsp;
                            </dd>
                            <br/>
                        <?php
                        }
                        ?>
                        <dt><?php echo __('Car'); ?></dt>
                        <dd>
                            <?php echo $customerCar['Car']['code'] . " - " . $customerCar['Carmodel']['name']; ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <?php if(!empty($customerCar['CustomerCar']['remorque_id']))?>
                        <dt><?php echo __('Remorque'); ?></dt>
                        <dd>
                            <?php echo $customerCar['Remorque']['code'] . " - " . $customerCar['Remorquemodel']['name']; ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt><?= __("Conductor"); ?></dt>
                        <dd>
                            <?php

                            if(!empty($customerCar['Customer']['first_name'])){
                                echo $customerCar['Customer']['first_name'] . " " . $customerCar['Customer']['last_name'];
                            }else{
                                foreach ($customersGroup as $item){
                                    if (next($customersGroup)){
                                        echo $item['Customer']['first_name'].' '.$item['Customer']['last_name'].' ,';
                                    }else{
                                        echo $item['Customer']['first_name'].' '.$item['Customer']['last_name'].' .';
                                    }
                                }
                            }

                            ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <?php if (!empty($customerCar['CustomerCar']['zone_id'])) { ?>
                            <dt><?php echo __('Zone'); ?></dt>
                            <dd>
                                <?php echo h($customerCar['Zone']['name']); ?>
                                &nbsp;
                            </dd>
                            <br/>
                        <?php } ?>
                        <?php if (!empty($customerCar['CustomerCar']['accompanist'])) { ?>
                            <dt><?php echo __('Accompanist'); ?></dt>
                            <dd>
                                <?php echo h($customerCar['CustomerCar']['accompanist']); ?>
                                &nbsp;
                            </dd>
                            <br/>
                        <?php } ?>


                        <?php if (!empty($customerCar['CustomerCar']['date_payment'])) { ?>
                            <dt><?php echo __('Payment date'); ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($customerCar['CustomerCar']['date_payment'],
                                        '%d-%m-%Y %H:%M')); ?>
                                &nbsp;
                            </dd>
                            <br/>
                        <?php } ?>
                        <?php if (!empty($customerCar['CustomerCar']['caution'])) { ?>
                            <dt><?php echo __('Caution'); ?></dt>
                            <dd>
                                <?php echo h(number_format($customerCar['CustomerCar']['caution'], 2, ",",
                                            ".")) . " " . $this->Session->read("currency"); ?>
                                &nbsp;
                            </dd>
                            <br/>
                        <?php } ?>

                        <?php if (isset($customerCar['CustomerCar']['obs']) && !empty($customerCar['CustomerCar']['obs'])) { ?>
                            <dt><?php echo __('Observation'); ?></dt>
                            <dd>
                                <?php echo h($customerCar['CustomerCar']['obs']); ?>
                                &nbsp;
                            </dd>
                            <br/>
                        <?php } ?>
                        <?php /* if (count($customerCar['CarOption']) > 0) { ?>
                            <dt><?php echo __('Options'); ?></dt>
                            <dd>
                                <?php echo h($customerCar['CarOption'][0]['name']);
                                for ($i = 1; $i < count($customerCar['CarOption']); $i++) {
                                    echo " | " . h($customerCar['CarOption'][$i]['name']);
                                }
                                ?>
                            </dd>
                            <br/>
                        <?php } */?>
                    </dl>
                </div>
                <div class="tab-pane " id="tab_2">
                    <?php if (!empty($customerCar['CustomerCar']['departure_location'])) { ?>
                        <dt><?php echo __('Departure location'); ?></dt>
                        <dd>
                            <?php echo h($customerCar['CustomerCar']['departure_location']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>
                    <?php if (isset($customerCar['CustomerCar']['start']) && !empty($customerCar['CustomerCar']['start'])) { ?>
                        <dt><?php echo __('Departure date'); ?></dt>
                        <dd>
                            <?php echo h($this->Time->format($customerCar['CustomerCar']['start'],
                                    '%d-%m-%Y %H:%M')); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>
                    <?php if (isset($customerCar['CustomerCar']['km']) && !empty($customerCar['CustomerCar']['km'])) { ?>
                        <dt><?php echo __('Departure km'); ?></dt>
                        <dd>
                            <?php echo h(number_format($customerCar['CustomerCar']['km'], 0, ",", ".")); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>
                    <?php if (isset($customerCar['CustomerCar']['initiale_state']) && !empty($customerCar['CustomerCar']['initiale_state'])) { ?>
                        <dt><?php echo __('Initiale state'); ?></dt>
                        <dd>
                            <?php

                            echo h($customerCar['CustomerCar']['initiale_state']);


                            ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>


                    <?php
                    if (isset($customerCar['CustomerCar']['pictureinit1']) && !empty($customerCar['CustomerCar']['pictureinit1']) ||
                        isset($customerCar['CustomerCar']['pictureinit2']) && !empty($customerCar['CustomerCar']['pictureinit2']) ||
                        isset($customerCar['CustomerCar']['pictureinit3']) && !empty($customerCar['CustomerCar']['pictureinit3']) ||
                        isset($customerCar['CustomerCar']['pictureinit4']) && !empty($customerCar['CustomerCar']['pictureinit4'])
                    ) {
                        ?>
                        <dt> <?php echo __('Pictures initiale') ?></dt>
                        <br/>
                        <dd>
                            <?php if (isset($customerCar['CustomerCar']['pictureinit1']) && !empty($customerCar['CustomerCar']['pictureinit1'])) { ?>
                                <a href="<?php echo $this->Html->url('/attachments/picturesaffectation/initialetat/size-' . $customerCar['CustomerCar']['pictureinit1']); ?>"
                                   class="group1">
                                    <?php    echo $this->Html->image('/attachments/picturesaffectation/initialetat/' . h($customerCar['CustomerCar']['pictureinit1']),
                                    array(
                                        'class' => 'picture_car'
                                    )); ?>
                                </a>
                            <?php } ?>
                            <?php
                            if (isset($customerCar['CustomerCar']['pictureinit2']) && !empty($customerCar['CustomerCar']['pictureinit2'])) {
                                ?>
                                <a href="<?php echo $this->Html->url('/attachments/picturesaffectation/initialetat/size-' . $customerCar['CustomerCar']['pictureinit2']); ?>"
                                   class="group1">
                                    <?php    echo $this->Html->image('/attachments/picturesaffectation/initialetat/' . h($customerCar['CustomerCar']['pictureinit2']),
                                    array(
                                        'class' => 'picture_car'
                                    )); ?>
                                </a>
                            <?php } ?>
                            <br/>
                            <?php if (isset($customerCar['CustomerCar']['pictureinit3']) && !empty($customerCar['CustomerCar']['pictureinit3'])) { ?>
                                <a href="<?php echo $this->Html->url('/attachments/picturesaffectation/initialetat/size-' . $customerCar['CustomerCar']['pictureinit3']); ?>"
                                   class="group1">
                                    <?php    echo $this->Html->image('/attachments/picturesaffectation/initialetat/' . h($customerCar['CustomerCar']['pictureinit3']),
                                    array(
                                        'class' => 'picture_car'
                                    )); ?>
                                </a>
                            <?php } ?>
                            <?php if (isset($customerCar['CustomerCar']['pictureinit4']) && !empty($customerCar['CustomerCar']['pictureinit4'])) { ?>
                                <a href="<?php echo $this->Html->url('/attachments/picturesaffectation/initialetat/size-' . $customerCar['CustomerCar']['pictureinit4']); ?>"
                                   class="group1">
                                    <?php    echo $this->Html->image('/attachments/picturesaffectation/initialetat/' . h($customerCar['CustomerCar']['pictureinit4']),
                                    array(
                                        'class' => 'picture_car'
                                    )); ?>
                                </a>
                            <?php } ?>
                        </dd>
                        <br/>
                    <?php }; ?>


                </div>
                <div class="tab-pane " id="tab_3">
                    <?php if (!empty($customerCar['CustomerCar']['return_location'])) { ?>
                        <dt><?php echo __('Return location'); ?></dt>
                        <dd>
                            <?php echo h($customerCar['CustomerCar']['return_location']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>
                    <?php if (isset($customerCar['CustomerCar']['end']) && !empty($customerCar['CustomerCar']['end'])) { ?>
                        <dt><?php echo __('Planned Arrival date '); ?></dt>
                        <dd>
                            <?php echo h($this->Time->format($customerCar['CustomerCar']['end'], '%d-%m-%Y %H:%M')); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>
                    <?php if (isset($customerCar['CustomerCar']['end_real']) && !empty($customerCar['CustomerCar']['end_real'])) { ?>
                        <dt><?php echo __('Real Arrival date'); ?></dt>
                        <dd>
                            <?php echo h($this->Time->format($customerCar['CustomerCar']['end_real'],
                                    '%d-%m-%Y %H:%M')); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>

                    <?php if (isset($customerCar['CustomerCar']['next_km']) && !empty($customerCar['CustomerCar']['next_km'])) { ?>
                        <dt><?php echo __('Arrival km'); ?></dt>
                        <dd>
                            <?php echo h(number_format($customerCar['CustomerCar']['next_km'], 0, ",", ".")); ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>
                    <?php if (isset($customerCar['CustomerCar']['finale_state']) && !empty($customerCar['CustomerCar']['finale_state'])) { ?>
                        <dt><?php echo __('Finale state'); ?></dt>
                        <dd>
                            <?php

                            echo h($customerCar['CustomerCar']['finale_state']);


                            ?>
                            &nbsp;
                        </dd>
                        <br/>
                    <?php } ?>

                    <?php if (isset($customerCar['CustomerCar']['picturefinal1']) && !empty($customerCar['CustomerCar']['picturefinal1']) ||
                        isset($customerCar['CustomerCar']['picturefinal2']) && !empty($customerCar['CustomerCar']['picturefinal2']) ||
                        isset($customerCar['CustomerCar']['picturefinal3']) && !empty($customerCar['CustomerCar']['picturefinal3']) ||
                        isset($customerCar['CustomerCar']['picturefinal4']) && !empty($customerCar['CustomerCar']['picturefinal4'])
                    ) {
                        ?>
                        <dt> <?php echo __('Pictures finale') ?></dt>
                        <br/>
                        <dd>
                            <?php if (isset($customerCar['CustomerCar']['picturefinal1']) && !empty($customerCar['CustomerCar']['picturefinal1'])) { ?>
                                <a href="<?php echo $this->Html->url('/attachments/picturesaffectation/finaletat/size-' . $customerCar['CustomerCar']['picturefinal1']); ?>"
                                   class="group1">
                                    <?php    echo $this->Html->image('/attachments/picturesaffectation/finaletat/' . h($customerCar['CustomerCar']['picturefinal1']),
                                    array(
                                        'class' => 'picture_car'
                                    )); ?>
                                </a>
                            <?php } ?>
                            <?php if (isset($customerCar['CustomerCar']['picturefinal2']) && !empty($customerCar['CustomerCar']['picturefinal2'])) { ?>
                                <a href="<?php echo $this->Html->url('/attachments/picturesaffectation/finaletat/size-' . $customerCar['CustomerCar']['picturefinal2']); ?>"
                                   class="group1">
                                    <?php    echo $this->Html->image('/attachments/picturesaffectation/finaletat/' . h($customerCar['CustomerCar']['picturefinal2']),
                                    array(
                                        'class' => 'picture_car'
                                    )); ?>
                                </a>
                            <?php } ?>
                            <?php if (isset($customerCar['CustomerCar']['picturefinal3']) && !empty($customerCar['CustomerCar']['picturefinal3'])) { ?>
                                <a href="<?php echo $this->Html->url('/attachments/picturesaffectation/finaletat/size-' . $customerCar['CustomerCar']['picturefinal3']); ?>"
                                   class="group1">
                                    <?php    echo $this->Html->image('/attachments/picturesaffectation/finaletat/' . h($customerCar['CustomerCar']['picturefinal3']),
                                    array(
                                        'class' => 'picture_car'
                                    )); ?>
                                </a>
                            <?php } ?>
                            <?php if (isset($customerCar['CustomerCar']['picturefinal4']) && !empty($customerCar['CustomerCar']['picturefinal4'])) { ?>
                                <a href="<?php echo $this->Html->url('/attachments/picturesaffectation/finaletat/size-' . $customerCar['CustomerCar']['picturefinal4']); ?>"
                                   class="group1">
                                    <?php    echo $this->Html->image('/attachments/picturesaffectation/finaletat/' . h($customerCar['CustomerCar']['picturefinal4']),
                                    array(
                                        'class' => 'picture_car'
                                    )); ?>
                                </a>
                            <?php } ?>
                        </dd>
                        <br/>
                    <?php }; ?>
                </div>
                <?php if ($customerCar ['CustomerCar']['request'] != 1 && $customerCar ['CustomerCar']['temporary'] != 1) { ?>
                    <div class="tab-pane " id="tab_4">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"
                                           class='a_accordion'><?= __('Documents du vehicule') ?></a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in">
                                    <div class="panel-body">

                                        <table class="table table-bordered cars">
                                            <thead>
                                            <tr>
                                                <th><?php echo __('Reception'); ?></th>
                                                <th><?php echo __('Restitution'); ?></th>

                                            </tr>
                                            </thead>

                                            <tbody>
                                            <tr>
                                                <td>
                                                    <?php


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Carte grise");
                                                    echo "</div>";


                                                    switch ($affectationpv0s['Affectationpv']['grey_card']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Assurance");
                                                    echo "</div>";
                                                    switch ($affectationpv0s['Affectationpv']['assurance']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Controle technique");
                                                    echo "</div>";
                                                    switch ($affectationpv0s['Affectationpv']['controle_technique']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Carnet entretien");
                                                    echo "</div>";
                                                    switch ($affectationpv0s['Affectationpv']['carnet_entretien']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Carnet de bord");
                                                    echo "</div>";
                                                    switch ($affectationpv0s['Affectationpv']['carnet_bord']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Vignette");
                                                    echo "</div>";
                                                    switch ($affectationpv0s['Affectationpv']['vignette']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Vignette ct");
                                                    echo "</div>";
                                                    switch ($affectationpv0s['Affectationpv']['vignette_ct']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Procuration");
                                                    echo "</div>";
                                                    switch ($affectationpv0s['Affectationpv']['procuration']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    ?>
                                                </td>

                                                <td>
                                                    <?php


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Carte grise");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['grey_card']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Assurance");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['assurance']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Controle technique");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['controle_technique']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Carnet entretien");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['carnet_entretien']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Carnet de bord");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['carnet_bord']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Vignette");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['vignette']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Vignette ct");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['vignette_ct']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Procuration");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['procuration']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";
                                                    ?>
                                                </td>
                                            </tr>
                                            </tbody>


                                        </table>

                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"
                                           class='a_accordion'><?= __('Lot de bord') ?></a>
                                    </h4>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <table class="table table-bordered cars">
                                            <thead>
                                            <tr>
                                                <th><?php echo __('Reception'); ?></th>
                                                <th><?php echo __('Restitution'); ?></th>

                                            </tr>
                                            </thead>

                                            <tbody>
                                            <tr>
                                                <td>
                                                    <?php
                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Roue de secours");
                                                    echo "</div>";
                                                    switch ($affectationpv0s['Affectationpv']['roue_secours']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Cric");
                                                    echo "</div>";
                                                    switch ($affectationpv0s['Affectationpv']['cric']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Tapis");
                                                    echo "</div>";
                                                    switch ($affectationpv0s['Affectationpv']['tapis']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Manivelle");
                                                    echo "</div>";
                                                    switch ($affectationpv0s['Affectationpv']['manivelle']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Boite a pharmacie");
                                                    echo "</div>";
                                                    switch ($affectationpv0s['Affectationpv']['boite_pharmacie']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Triangle");
                                                    echo "</div>";
                                                    switch ($affectationpv0s['Affectationpv']['triangle']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Gilet");
                                                    echo "</div>";
                                                    switch ($affectationpv0s['Affectationpv']['gilet']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Double cle");
                                                    echo "</div>";
                                                    switch ($affectationpv0s['Affectationpv']['double_cle']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Roue de secours");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['roue_secours']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Cric");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['cric']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Tapis");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['tapis']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Manivelle");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['manivelle']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";


                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Boite a pharmacie");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['boite_pharmacie']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Triangle");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['triangle']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Gilet");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['gilet']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Double cle");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['double_cle']) {
                                                        case '0':
                                                            echo __('/');
                                                            break;
                                                        case '1':
                                                            echo __('Yes');
                                                            break;
                                                        case '2':
                                                            echo __('No');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    ?>
                                                </td>
                                            </tr>
                                            </tbody>


                                        </table>

                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"
                                           class='a_accordion'><?= __('State') ?></a>
                                    </h4>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse">
                                    <div class="panel-body">

                                        <p>Abreviation</p>

                                        <p> O : Ok </p>

                                        <p>M: Moyen</p>

                                        <p>TMR : Tres Mauvaise Etat</p><br/>

                                        <table class="table table-bordered cars">
                                            <thead>
                                            <tr>
                                                <th><?php echo __('Reception'); ?></th>
                                                <th><?php echo __('Restitution'); ?></th>

                                            </tr>
                                            </thead>

                                            <tbody>
                                            <tr>
                                                <td>
                                                    <?php
                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Sieges");
                                                    echo "</div>";

                                                    switch ($affectationpv0s['Affectationpv']['sieges']) {
                                                        case '3':
                                                            echo __('O');
                                                            break;
                                                        case '1':
                                                            echo __('M');
                                                            break;
                                                        case '2':
                                                            echo __('TMR');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };


                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Tableau de bord");
                                                    echo "</div>";
                                                    switch ($affectationpv0s['Affectationpv']['dashboard']) {
                                                        case 3:
                                                            echo __('O');
                                                            break;
                                                        case 1:
                                                            echo __('M');
                                                            break;
                                                        case 2:
                                                            echo __('TMR');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };
                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Moquette");
                                                    echo "</div>";
                                                    switch ($affectationpv0s['Affectationpv']['moquette']) {
                                                        case 3:
                                                            echo __('O');
                                                            break;
                                                        case 1:
                                                            echo __('M');
                                                            break;
                                                        case 2:
                                                            echo __('TMR');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Tapis interieur");
                                                    echo "</div>";
                                                    switch ($affectationpv0s['Affectationpv']['tapis_interieur']) {
                                                        case 3:
                                                            echo __('O');
                                                            break;
                                                        case 1:
                                                            echo __('M');
                                                            break;
                                                        case 2:
                                                            echo __('TMR');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";


                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Sieges");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['sieges']) {
                                                        case 3:
                                                            echo __('O');
                                                            break;
                                                        case 1:
                                                            echo __('M');
                                                            break;
                                                        case 2:
                                                            echo __('TMR');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Tableau de bord");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['dashboard']) {
                                                        case 3:
                                                            echo __('O');
                                                            break;
                                                        case 1:
                                                            echo __('M');
                                                            break;
                                                        case 2:
                                                            echo __('TMR');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Moquette");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['moquette']) {
                                                        case 3:
                                                            echo __('O');
                                                            break;
                                                        case 1:
                                                            echo __('M');
                                                            break;
                                                        case 2:
                                                            echo __('TMR');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";

                                                    echo "<div id='interval2'>";
                                                    echo '<div class="lbl4">' . __("Tapis interieur");
                                                    echo "</div>";
                                                    switch ($affectationpv1s['Affectationpv']['tapis_interieur']) {
                                                        case 3:
                                                            echo __('O');
                                                            break;
                                                        case 1:
                                                            echo __('M');
                                                            break;
                                                        case 2:
                                                            echo __('TMR');
                                                            break;
                                                        default :
                                                            echo __('/');
                                                    };

                                                    echo "</div><br/>";


                                                    ?>
                                                </td>
                                            </tr>
                                            </tbody>


                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                <div class="tab-pane" id="tab_5">
                    <table class="table table-bordered details">
                        <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('User.first_name', __('User')); ?></th>
                            <th><?php echo $this->Paginator->sort('Autorisation.authorization_from',
                                    __('authorization date from')); ?></th>
                            <th><?php echo $this->Paginator->sort('Autorisation.authorization_to',
                                    __('to date')); ?></th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sumCost = 0;
                        foreach ($autorisations as $autorisation): ?>

                            <tr id="row<?= $autorisation['Autorisation']['id'] ?>">
                                <td><?php echo h($autorisation['User']['first_name'] . ' ' . $autorisation['User']['last_name']); ?>
                                    &nbsp;</td>
                                <td><?php echo h($this->Time->format($autorisation['Autorisation']['authorization_from'],
                                            '%d-%m-%Y %H:%M')); ?>
                                    &nbsp;</td>
                                <td><?php echo h($this->Time->format($autorisation['Autorisation']['authorization_to'],
                                            '%d-%m-%Y %H:%M')); ?>
                                    &nbsp;</td>

                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php if ($haspermission) { ?>
        <div class="right_side">
            <h6 class="subheader"><?php echo __('Created'); ?></h6>

            <p><?php echo h($this->Time->format($customerCar['CustomerCar']['created'], '%d-%m-%Y %H:%M')); ?></p>
            <h6 class="subheader"><?php echo __('By'); ?></h6>

            <p><?php echo h($customerCar['User']['first_name']) . " " . h($customerCar['User']['last_name']); ?></p>
            <?php if (!empty($customerCar['CustomerCar']['modified_id'])) { ?>
                <h6 class="subheader"><?php echo __('Modified'); ?></h6>
                <p><?php echo h($this->Time->format($customerCar['CustomerCar']['modified'], '%d-%m-%Y %H:%M')); ?></p>
                <h6 class="subheader"><?php echo __('By'); ?></h6>
                <p><?php echo h($customerCar['UserModifier']['first_name']) . " " . h($customerCar['UserModifier']['last_name']); ?></p>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<div style='clear:both;'></div>
