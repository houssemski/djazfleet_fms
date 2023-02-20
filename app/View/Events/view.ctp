<?php
//include("ctp/index.ctp");
?>

<div class="box-body main">
    <?php

    ?><h4 class="page-title"> <?=$event['EventType']['name'] . " " . $event['Carmodel']['name'] . " " . $event['Car']['immatr_def']; ?></h4>
    <div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
    <div class="card-box p-b-0">
    <div class="row" style="clear:both">
    <div class="btn-group pull-left">
        <div class="header_actions" id="hdr-actn-01">
        <?php if ($event['Event']['request'] == 0) { ?>
            <?= $this->Html->link(
                '<i class=" fa fa-edit m-r-5 m-r-5"></i>' . __("Edit"),
                array('action' => 'Edit', $event['Event']['id']),
                array('escape' => false, 'class'=>"btn btn-primary btn-bordred waves-effect waves-light m-b-5")
            ); ?>
        <?php } else { ?>
            <?= $this->Html->link(
                '<i class="fa fa-edit m-r-5 m-r-5"></i>' . __("Edit"),
                array('action' => 'edit_request', $event['Event']['id']),
                array('escape' => false, 'class'=>"btn btn-primary btn-bordred waves-effect waves-light m-b-5")
            ); ?>
        <?php } ?>
        <?= $this->Form->postLink(
            '<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __("Delete"),
            array('action' => 'Delete', $event['Event']['id']),
            array('escape' => false, 'class'=>"btn btn-inverse btn-bordred waves-effect waves-light m-b-5"),
            __('Are you sure you want to delete this event?')); ?>

            <?php
            if (($event['Event']['request'] == 1) && ($event['Event']['validated'] == 0)){
            echo $this->Form->postLink(
                '<i class="fa fa-check-circle-o m-r-5 m-r-5"></i>' . __("Valider"),
                array('action' => 'transformIntervention', $event['Event']['id']),
                array('escape' => false, 'class'=>"btn btn-inverse btn-bordred waves-effect waves-light m-b-5"));
            }?>

        <?php

        if ($event['Event']['alert'] == 1) {
            ?>


            <?= $this->Html->link(
                '<i class="fa  fa-bell"></i>' . __("disable alert"),
                array('action' => 'disablealert', $event['Event']['id']),
                array('escape' => false, 'class' => 'btn btn-block btn-social btn-linkedin')); ?>
        <?php } ?>

            <?php $this->Html->link(
                '<i class="fa  fa-bell"></i>' . __("Disable notification"),
                array('controller'=>'notifications','action' => 'disableNotifications', $event['Event']['id'],'event'),
                array('escape' => false, 'class' => 'btn btn-block btn-social btn-linkedin')); ?>


        <?php

        if (($event['Event']['request'] == 1) && ($event['Event']['validated'] == 1) && ($event['Event']['transferred'] == 0)) {
            ?>


            <?= $this->Html->link(
                '<i class="fa  fa-external-link-square"></i>' . __("Transfer to event"),
                array('action' => 'transfer_request_event', $event['Event']['id']),
                array('escape' => false, 'class' => 'btn btn-block btn-social btn-foursquare')); ?>

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
    <div class="left_side card-box p-b-0">

        <div class="nav-tabs-custom pdg_btm">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                <?php if (Configure::read("gestion_commercial") == '1'  &&
                Configure::read("tresorerie") == '1') { ?>
                <li><a href="#tab_2" data-toggle="tab"><?= __('Payment ') ?></a></li>
                <?php } ?>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <dl>
                        <dt><?php echo __('Event Type'); ?></dt>
                        <dd>
                            <?php echo $event['EventType']['name']; ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt><?php echo __('Car'); ?></dt>
                        <dd>
                            <?php
                              if ($param==1){
                                    echo $event['Car']['code']." - ".$event['Carmodel']['name'];
                              } else if ($param==2) {
                                            echo $event['Car']['immatr_def']." - ".$event['Carmodel']['name'];
                              }

                            ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt><?php echo __("Conductor"); ?></dt>
                        <dd>
                            <?php

                            echo $event['Customer']['first_name'] . " " . $event['Customer']['last_name'];
                            ?>
                            &nbsp;
                        </dd>
                        <?php

                        if (!empty($eventcategoryinterferings)) {

                            foreach ($eventcategoryinterferings as $eventcategoryinterfering) {
                                ?>


                                <?php
                                if (!empty($eventcategoryinterfering['EventCategoryInterfering']['interfering_id0'])) {
                                    ?>
                                    <br/>
                                    <?php if ($eventcategoryinterfering['EventTypeCategory']['name'] == 'Autre') $name = ''; else $name = $eventcategoryinterfering['EventTypeCategory']['name']; ?>
                                    <dt><?php echo __('Interfering') . ' ' . $name; ?></dt>
                                    <dd>
                                        <?php echo $eventcategoryinterfering['Interfering']['name']; ?>
                                        &nbsp;
                                    </dd>
                                    <br/>
                                    <dt><?php echo __('Cost') . ' ' . $name; ?></dt>
                                    <dd>

                                        <?php echo h(number_format($eventcategoryinterfering['EventCategoryInterfering']['cost'], 2, ",", ".")) . " " . $this->Session->read("currency"); ?>
                                        &nbsp;
                                    </dd>




                                <?php
                                }


                                if (!empty($eventcategoryinterfering['EventCategoryInterfering']['interfering_id1'])) {
                                    ?>
                                    <br/>
                                    <?php if ($eventcategoryinterfering['EventTypeCategory']['name'] == 'Autre') $name = ''; else $name = $eventcategoryinterfering['EventTypeCategory']['name']; ?>
                                    <dt><?php echo __('Interfering') . ' ' . $name; ?></dt>
                                    <dd>
                                        <?php echo $eventcategoryinterfering['Interfering']['name']; ?>
                                        &nbsp;
                                    </dd>
                                    <br/>
                                    <dt><?php echo __('Cost') . ' ' . $name; ?></dt>
                                    <dd>

                                        <?php echo h(number_format($eventcategoryinterfering['EventCategoryInterfering']['cost'], 2, ",", ".")) . " " . $this->Session->read("currency"); ?>
                                        &nbsp;
                                    </dd>




                                <?php
                                }


                                if (!empty($eventcategoryinterfering['EventCategoryInterfering']['interfering_id2'])) {
                                    ?>
                                    <br/>
                                    <?php if ($eventcategoryinterfering['EventTypeCategory']['name'] == 'Autre') $name = ''; else $name = $eventcategoryinterfering['EventTypeCategory']['name']; ?>
                                    <dt><?php echo __('Interfering') . ' ' . $name; ?></dt>
                                    <dd>
                                        <?php echo $eventcategoryinterfering['Interfering']['name']; ?>
                                        &nbsp;
                                    </dd>
                                    <br/>
                                    <dt><?php echo __('Cost') . ' ' . $name; ?></dt>
                                    <dd>

                                        <?php echo h(number_format($eventcategoryinterfering['EventCategoryInterfering']['cost'], 2, ",", ".")) . " " . $this->Session->read("currency"); ?>
                                        &nbsp;
                                    </dd>




                                <?php
                                }


                            }
                        } ?>



                        <?php if (isset($event['Event']['date']) && !empty($event['Event']['date'])) { ?>
                </br>
                <dt><?php echo __('Date'); ?></dt>
                <dd>
                    <?php echo h($this->Time->format($event['Event']['date'], '%d-%m-%Y')); ?>
                    &nbsp;
                </dd>
                <?php } ?>
                        <?php if (isset($event['Event']['next_date']) && !empty($event['Event']['next_date'])) { ?>
                            <br/>
                            <dt><?php echo __('Next Date'); ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($event['Event']['next_date'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </dd>
                        <?php } ?>


                        <?php if (isset($event['Event']['date3']) && !empty($event['Event']['date3'])) { ?>
                            <br/>
                            <dt><?php echo __('Date 3'); ?></dt>
                            <dd>
                                <?php echo h($this->Time->format($event['Event']['date3'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </dd>


                        <?php
                        }
                        if (isset($event['Event']['assurance_number']) && !empty($event['Event']['assurance_number'])) {
                            ?>
                            <br/>
                            <dt><?php echo __('Assurance number'); ?></dt>
                            <dd>
                                <?php echo h($event['Event']['assurance_number']); ?>
                                &nbsp;
                            </dd>


                        <?php } ?>

                        <?php


                        if (isset($event['Event']['km']) && !empty($event['Event']['km'])) {
                            ?>
                            <br>
                            <dt><?php if ($event['Car']['vidange_hour'] == 1) {
                                    echo __('Hours consumed');
                                } else {
                                    echo __('Km');
                                } ?></dt>
                            <dd>
                                <?php echo h(number_format($event['Event']['km'], 0, ",", ".")); ?>
                                &nbsp;
                            </dd>
                            <br/>
                            <dt><?php if ($event['Car']['vidange_hour'] == 1) {
                                    echo __('Next oil change');
                                } else {
                                    echo __('Next Km');
                                } ?></dt>
                            <dd>
                                <?php echo h(number_format($event['Event']['next_km'], 0, ",", ".")); ?>
                                &nbsp;
                            </dd>
                            <br/>
                            <?php if ($event['Car']['vidange_hour'] == 1) { ?>
                                <dt><?php echo __('Actual hour'); ?></dt>
                                <dd>
                                    <?php echo h(number_format($event['Car']['hours'], 0, ",", ".")); ?>
                                    &nbsp;
                                </dd>
                            <?php } else { ?>

                                <dt><?php echo __('Actual Km'); ?></dt>
                                <dd>
                                    <?php echo h(number_format($event['Car']['km'], 0, ",", ".")); ?>
                                    &nbsp;
                                </dd>

                            <?php } ?>
                        <?php } ?>

                        <?php

                        if ($event['EventEventType']['event_type_id'] == 11) {
                            ?>
                            <?php if (!empty($event['Event']['refund_amount'])) { ?>
                                <br/>
                                <dt><?php echo __('Refund amount'); ?></dt>
                                <dd>
                                    <?php echo h(number_format($event['Event']['refund_amount'], 0, ",", ".")); ?>
                                    &nbsp;
                                </dd>
                            <?php } ?>
                            <?php if (!empty($event['Event']['severity_incident'])) { ?>
                                <br/>
                                <dt><?php echo __('Severity incident'); ?></dt>
                                <dd>
                                    <?php
                                    switch ($event['Event']['severity_incident']) {
                                        case 1:
                                            $severity_incident = __('Low');
                                            break;
                                        case 2:
                                            $severity_incident = __('Medium');
                                            break;
                                        case 3:
                                            $severity_incident = __('Serious');
                                            break;
                                        case 4:
                                            $severity_incident = __('Very serious');
                                            break;

                                    }

                                    echo h($severity_incident); ?>
                                    &nbsp;
                                </dd>
                            <?php } ?>

                        <?php } ?>
                        <?php if (isset($event['Event']['cost']) && $event['Event']['cost'] != 0) { ?>
                    </br>
                    <dt><?php echo __('Global cost'); ?></dt>
                <dd>
                    <?php echo h(number_format($event['Event']['cost'], 2, ",", ".")) . " " . $this->Session->read("currency"); ?>
                    &nbsp;
                </dd>
                <br/>
            <?php } ?>
                        <?php if (isset($event['Event']['obs']) && !empty($event['Event']['obs'])) { ?>
                            <br/>
                            <dt><?php echo __('Obs'); ?></dt>
                            <dd>
                                <?php echo nl2br(h($event['Event']['obs'])); ?>
                                &nbsp;
                            </dd>

                        <?php } ?>

                        <?php if (isset($event['Event']['attachment1']) && !empty($event['Event']['attachment1'])) { ?>
                            <br/>
                            <dt><?php echo __('Attachment 1'); ?></dt>
                            <dd>
                                <?= $this->Html->Link($event['Event']['attachment1'],
                                    '/attachments/events/' . $event['Event']['attachment1'],
                                    array('class' => 'attachments', 'target' => '_blank')
                                ); ?>
                                &nbsp;
                            </dd>

                        <?php } ?>
                        <?php if (isset($event['Event']['attachment2']) && !empty($event['Event']['attachment2'])) { ?>
                            <br/>
                            <dt><?php echo __('Attachment 2'); ?></dt>
                            <dd>
                                <?= $this->Html->Link($event['Event']['attachment2'],
                                    '/attachments/events/' . $event['Event']['attachment2'],
                                    array('class' => 'attachments', 'target' => '_blank')
                                ); ?>
                                &nbsp;
                            </dd>

                        <?php } ?>
                        <?php if (isset($event['Event']['attachment3']) && !empty($event['Event']['attachment3'])) { ?>
                            <br/>
                            <dt><?php echo __('Attachment 3'); ?></dt>
                            <dd>
                                <?= $this->Html->Link($event['Event']['attachment3'],
                                    '/attachments/events/' . $event['Event']['attachment3'],
                                    array('class' => 'attachments', 'target' => '_blank')
                                ); ?>
                                &nbsp;
                            </dd>

                        <?php } ?>
                        <?php if (isset($event['Event']['attachment4']) && !empty($event['Event']['attachment4'])) { ?>
                            <br/>
                            <dt><?php echo __('Attachment 4'); ?></dt>
                            <dd>
                                <?= $this->Html->Link($event['Event']['attachment4'],
                                    '/attachments/events/' . $event['Event']['attachment4'],
                                    array('class' => 'attachments', 'target' => '_blank')
                                ); ?>
                                &nbsp;
                            </dd>

                        <?php } ?>
                        <?php if (isset($event['Event']['attachment5']) && !empty($event['Event']['attachment5'])) { ?>
                            <br/>
                            <dt><?php echo __('Attachment 5'); ?></dt>
                            <dd>
                                <?= $this->Html->Link($event['Event']['attachment5'],
                                    '/attachments/events/' . $event['Event']['attachment5'],
                                    array('class' => 'attachments', 'target' => '_blank')
                                ); ?>
                                &nbsp;
                            </dd>

                        <?php } ?>
                    </dl>




                    <?php if (!empty($billProducts)) { ?>
                    <div class="row">
                        <!-- BASIC WIZARD -->
                        <div class="col-lg-12">
                            <div class="card-box p-b-0">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"                            cellspacing="0" width="100%">

                            <thead>
                            <tr>


                                <th><?php echo __('Product'); ?></th>
                                <th><?php echo __('Quantity'); ?></th>
                                <th><?php echo __('Price HT'); ?></th>
                                <th><?php echo __('Price TTC'); ?></th>


                            </tr>
                            </thead>

                            <tbody>


                            <?php foreach ($billProducts as $billProduct) { ?>
                                <tr>
                                    <td><?php echo h($billProduct['Product']['name']); ?>&nbsp;</td>
                                    <td><?php echo h($billProduct['BillProduct']['quantity']); ?>&nbsp;</td>

                                    <td><?php echo h(number_format($billProduct['BillProduct']['price_ht'], 2, ",", ".")) . "  " . $this->Session->read("currency"); ?></td>
                                    <td><?php echo h(number_format($billProduct['BillProduct']['price_ttc'], 2, ",", ".")) . "  " . $this->Session->read("currency"); ?></td>


                                </tr>
                            <?php
                            }


                            ?>


                            </tbody>
                        </table>
                            </div>
                            </div>
                            </div>


                        <dt><?php echo __('Total HT'); ?></dt>
                        <dd>
                            <?php echo h(number_format($bill['Bill']['total_ht'], 2, ",", ".")) . "  " . $this->Session->read("currency"); ?>
                            &nbsp;
                        </dd>

                        <br/>
                        <dt><?php echo __('Total TTC'); ?></dt>
                        <dd>
                            <?php echo h(number_format($bill['Bill']['total_ttc'], 2, ",", ".")) . "  " . $this->Session->read("currency"); ?>
                            &nbsp;
                        </dd>

                        <br/>
                        <dt><?php echo __('Total TVA'); ?></dt>
                        <dd>
                            <?php echo h(number_format($bill['Bill']['total_tva'], 2, ",", ".")) . "  " . $this->Session->read("currency"); ?>
                            &nbsp;
                        </dd>

                        <br/>

                    <?php } ?>


                </div>
                <div class="tab-pane " id="tab_2">


                    <?php if (!empty($payments)) { ?>
                    <div class="row">
                        <!-- BASIC WIZARD -->
                        <div class="col-lg-12">

                        <table  class="table table-striped table-bordered dt-responsive nowrap"cellspacing="0" width="100%">

                            <thead>
                            <tr>


                                <th><?php echo __('Reference'); ?></th>
                                <th><?php echo __('Payment date'); ?></th>
                                <th><?php echo __('Payment type'); ?></th>
                                <th><?php echo __('Transaction'); ?></th>
                                <th><?php echo __('Amount'); ?></th>


                            </tr>
                            </thead>

                            <tbody>


                            <?php foreach ($payments as $payment) { ?>
                                <tr>
                                    <td><?php echo h($payment['Payment']['reference']); ?>&nbsp;</td>
                                    <td><?php echo h($this->Time->format($payment['Payment']['receipt_date'], '%d-%m-%Y')); ?>
                                        &nbsp;</td>
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
                                    <td><?php if ($payment['Payment']['transact_type_id'] == 1) echo __('Encasement');
                                        else  echo __('Disbursement');

                                        ?></td>
                                    <td><?php echo h(number_format($payment['Payment']['amount'], 2, ",", ".")) . "  " . $this->Session->read("currency"); ?></td>


                                </tr>
                            <?php
                            }


                            ?>


                            </tbody>
                        </table>

                            </div>
                            </div>


                    <?php } ?>


                </div>
            </div>

        </div>
    </div>
    <?php if ($haspermission) { ?>
   <!--     <div class="right_side">
            <h6 class="subheader"><?php echo __('Created'); ?></h6>

            <p><?php echo h($this->Time->format($event['Event']['created'], '%d-%m-%Y %H:%M')); ?></p>
            <h6 class="subheader"><?php echo __('By'); ?></h6>

            <p><?php echo h($event['User']['first_name']) . " " . h($event['User']['last_name']); ?></p>
            <?php if (!empty($event['Event']['modified_id'])) { ?>
                <h6 class="subheader"><?php echo __('Modified'); ?></h6>
                <p><?php echo h($this->Time->format($event['Event']['modified'], '%d-%m-%Y %H:%M')); ?></p>
                <h6 class="subheader"><?php echo __('By'); ?></h6>
                <p><?php echo h($event['UserModifier']['first_name']) . " " . h($event['UserModifier']['last_name']); ?></p>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<div style='clear:both; padding-top: 10px;'></div>
<?php if ($haspermission && !empty($audits)) { ?>


    <div class="lbl2"><a class="btn  btn-act btn-info" href="#demo" data-toggle="collapse">
            <i class="  fa fa-eye m-r-5" style="font-size: 1.3em !important;line-height: 30px !important;"></i>
            <i class="more-less glyphicon glyphicon-chevron-down"></i>
            <?= __("  Voir audits"); ?>
        </a></div>



    <?php if (!empty($audits)) { ?>
        <div id="demo" class="collapse nav-tabs-custom col-md-4">


            <table>
                <?php foreach ($audits as $audit) { ?>

                    <tr>

                        <td>
                            <dt style='padding-right: 10px; margin-left: 10px; padding-bottom: 5px; padding-top: 10px;'><?php echo __('Modified'); ?></dt>
                        </td>
                        <td>
                            <dd style='padding-right: 10px; padding-bottom: 5px; padding-top: 10px;'><?php echo h($this->Time->format($audit['Audit']['created'], '%d-%m-%Y %H:%M')); ?></dd>
                        <td>
                        <td>
                            <dt style='padding-right: 10px; padding-bottom: 5px; padding-top: 10px;'><?php echo __('By'); ?></dt>
                        </td>
                        <td>
                            <dd style='padding-right: 10px; padding-bottom: 5px; padding-top: 10px;'><?php echo h($audit['User']['first_name']) . " " . h($audit['User']['last_name']); ?></dd>
                        <td>


                    </tr>
                <?php } ?>
            </table>
            </br>
            <?php
            if ($this->params['paging']['Audit']['pageCount'] > 1) {


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
    <?php } ?>




<?php } ?>