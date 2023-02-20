<div class="box-body main">
    <?php
    switch ($transportBill['TransportBill']['type']) {

        case 0:
            ?><h4
            class="page-title"> <?= __("Request quotation") . " " . $transportBill['TransportBill']['reference']; ?></h4>
            <?php break;
        case 1:
            ?><h4 class="page-title"> <?= __("Quotation") . " " . $transportBill['TransportBill']['reference']; ?></h4>
            <?php break;
        case 2:
            ?><h4
            class="page-title"> <?= __("Customer order") . " " . $transportBill['TransportBill']['reference']; ?></h4>
            <?php break;
        case 4:
            ?><h4 class="page-title"> <?= __("Preinvoice") . " " . $transportBill['TransportBill']['reference']; ?></h4>
            <?php break;
        case 5:
            ?><h4 class="page-title"> <?= __("Invoice") . " " . $transportBill['TransportBill']['reference']; ?></h4>
            <?php break;
    }
    $type = $transportBill['TransportBill']['type'];

    echo $this->Form->input('type', array(
        'label' => '',
        'value' => $type,
        'type' => 'hidden'

    ));

    echo $this->Form->input('id', array(
        'label' => '',
        'id' => 'transport_bill_id',
        'value' => $transportBill['TransportBill']['id'],
        'type' => 'hidden'

    ));
    ?>
    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
                            <?php

                            if ($transportBill['TransportBill']['type'] == 0) { ?>
                                <?= $this->Html->link(
                                    '<i class="fa fa-edit m-r-5 m-r-5"></i>' . __("Edit"),
                                    array('action' => 'editRequestQuotation', $transportBill['TransportBill']['id']),
                                    array('escape' => false, 'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5")
                                ); ?>
                                <?php if (($profileId != ProfilesEnum::client)) {
                                    if ($permissionQuoteRequest == 1) {
                                        ?>
                                        <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transform to') . ' ' . __('Quotation'),
                                            'javascript:transformFromQuotationRequestToOrder(1);',
                                            array('escape' => false,
                                                'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',
                                                'id' => 'transform')) ?>
                                    <?php
                                    }
                                    ?>
                                <?php } else { ?>
                                    <?php if ($permissionQuoteRequest == 1) { ?>
                                        <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transform to') . ' ' . __('Quotation'),
                                            'javascript:transformFromQuotationRequestToOrder(1);',
                                            array('escape' => false,
                                                'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',
                                                'id' => 'transform')) ?>

                                    <?php } ?>


                                <?php } ?>
                            <?php
                            } else {
                             if (($transportBill['TransportBill']['status'] == TransportBillDetailRideStatusesEnum:: not_validated) ||
                                 ($transportBill['TransportBill']['status'] == TransportBillDetailRideStatusesEnum:: not_transmitted)
                            ) {
                                 ?>
                                 <?= $this->Html->link(
                                     '<i class="fa fa-edit m-r-5 m-r-5"></i>' . __("Edit"),
                                     array('action' => 'Edit', $type, $transportBill['TransportBill']['id']),
                                     array('escape' => false, 'class' => "btn btn-primary btn-bordred waves-effect waves-light m-b-5")
                                 );
                             }

                                ?>
                                <?php if (($profileId != ProfilesEnum::client)) {

                                    switch ($type) {

                                        case TransportBillTypesEnum::quote :

                                            if ($permissionQuote == 1) {
                                                ?>
                                                <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transform to') . ' ' . __('Customer order'),
                                                    'javascript:transformFromQuotationRequestToOrder(2);',
                                                    array('escape' => false,
                                                        'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',
                                                        'id' => 'transform')) ?>

                                                <?php    break;
                                            }

                                        case TransportBillTypesEnum::order :

                                            if ($permissionOrder == 1) {
                                                echo $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transmit'),
                                                    'javascript:validateCustomerOrder();',
                                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'validate'));
                                            }
                                            if ($permissionCancel == 1) {
                                                echo $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Cancel'),
                                                    'javascript:cancelCustomerOrder();',
                                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'cancel'));

                                                break;
                                            }

                                        case TransportBillTypesEnum::pre_invoice :
                                            ?>
                                            <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transform to') . '' . __('Invoice'),
                                            'javascript:transformPreinvoiceToInvoice(7);',
                                            array('escape' => false,
                                                'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',
                                                'id' => 'transform',
                                                'disabled' => 'true')) ?>

                                            <?php break;
                                    }
                                    ?>


                                <?php } else { ?>

                                    <?php
                                    switch ($type) {

                                        case TransportBillTypesEnum::quote :
                                            if ($permissionQuote == 1) {
                                                ?>

                                                <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transform to') . '' . __('Customer order'),
                                                    'javascript:transformFromQuotationRequestToOrder(2);',
                                                    array('escape' => false,
                                                        'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5',
                                                        'id' => 'transform',
                                                        'disabled' => 'true')) ?>


                                                <?php    break;
                                            }
                                        case TransportBillTypesEnum::order :

                                            if ($permissionCancel == 1) {
                                                echo $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Cancel'),
                                                    'javascript:cancelCustomerOrder();',
                                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'disabled' => 'true', 'id' => 'cancel'));
                                                break;
                                            } ?>

                                            <?php    break;

                                    }
                                    ?>


                                <?php } ?>
                            <?php } ?>

                            <?= $this->Form->postLink(
                                '<i class="fa fa-trash-o m-r-5 m-r-5"></i>' . __("Delete"),
                                array('action' => 'Delete', $transportBill['TransportBill']['type'], $transportBill['TransportBill']['id']),
                                array('escape' => false, 'class' => "btn btn-inverse btn-bordred waves-effect waves-light m-b-5"),
                                __('Are you sure you want to delete ?')); ?>

                            <div style="clear: both"></div>
                        </div>
                    </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                </div>
            </div>
        </div>
    </div>
    <div id="dialogModalConditionTransformation">
        <!-- the external content is loaded inside this tag -->
    </div>
    <?php if ($transportBill['TransportBill']['type'] == 0) { ?>
        <div class="left_side card-box p-b-0">
            <div class="nav-tabs-custom pdg_btm">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <dt><?php echo __('Reference'); ?></dt>
                        <dd>
                            <?php echo $transportBill['TransportBill']['reference']; ?>

                        </dd>
                        <br/>
                        <dt><?php echo __('Client'); ?></dt>
                        <dd>
                            <?php echo $transportBill['Supplier']['name']; ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt><?php echo __('Ride'); ?></dt>
                        <dd>
                            <?php echo $transportBill['DepartureDestination']['name'] . '-' . $transportBill['ArrivalDestination']['name']; ?>
                        </dd>
                        <br/>

                        <dt><?php echo __('Transportation'); ?></dt>
                        <dd>
                            <?php echo $transportBill['CarType']['name']; ?>
                        </dd>
                        <br/>


                        <dt><?php echo __('Number of trucks'); ?></dt>
                        <dd>
                            <?php echo $transportBill['TransportBill']['nb_trucks']; ?>
                        </dd>
                        <br/>

                        <dt><?php echo __('Total weight'); ?></dt>
                        <dd>
                            <?php echo $transportBill['TransportBill']['total_weight']; ?>
                        </dd>
                        <br/>
                        <?php if (isset($newTransportBill) && !empty($newTransportBill)) { ?>
                            <dt><?php echo __('New reference'); ?></dt>
                            <dd>
                                <?php echo $newTransportBill['TransportBill']['reference']; ?>
                            </dd>
                            <br/>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>
    <?php } else { ?>


        <div class="left_side card-box p-b-0">
            <div class="nav-tabs-custom pdg_btm">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?= __('General information') ?></a></li>
                    <li><a href="#tab_2" data-toggle="tab"><?= __('Ride information') ?></a></li>
                    <li><a href="#tab_3" data-toggle="tab"><?= __('Client information') ?></a></li>
                    <?php if ($transportBill['TransportBill']['type'] == TransportBillTypesEnum::invoice) { ?>
                        <li><a href="#tab_4" data-toggle="tab"><?= __('Réglement') ?></a></li>
                    <?php } ?>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">

                        <dt class="width_100"><?php echo __('Reference'); ?></dt>
                        <dd>
                            <?php echo $transportBill['TransportBill']['reference']; ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt class="width_100"><?php echo __('Date'); ?></dt>
                        <dd>
                            <?php echo h($this->Time->format($transportBill['TransportBill']['date'], '%d-%m-%Y')); ?>

                        </dd>
                        <br/>


                        <dt class="width_100"><?php echo __('Initial customer'); ?></dt>
                        <dd>
                            <?php echo $transportBill['Supplier']['name']; ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt class="width_100"><?php echo __('Final customer'); ?></dt>
                        <dd>
                            <?php echo $transportBill['SupplierFinal']['name']; ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt class="width_100"><?php echo __('Total HT'); ?></dt>
                        <dd>

                            <?php echo number_format($transportBill['TransportBill']['total_ht'], 2, ",", ".") . ' ' . $this->Session->read("currency") ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt class="width_100"><?php echo __('Total TVA'); ?></dt>
                        <dd>

                            <?php echo number_format($transportBill['TransportBill']['total_tva'], 2, ",", ".") . ' ' . $this->Session->read("currency") ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt class="width_100"><?php echo __('Total TTC'); ?></dt>
                        <dd>

                            <?php echo number_format($transportBill['TransportBill']['total_ttc'], 2, ",", ".") . ' ' . $this->Session->read("currency") ?>
                            &nbsp;
                        </dd>
                        <br/>

                        <dt class="width_100"><?php echo __('Creator'); ?></dt>
                        <dd>
                            <?php echo h($transportBill['User']['first_name'] . ' ' . $transportBill['User']['last_name']); ?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt class="width_100"><?php echo __('Created'); ?></dt>
                        <dd>
                            <?php echo  h($this->Time->format($transportBill['TransportBill']['created'], '%d-%m-%Y'));?>
                            &nbsp;
                        </dd>
                        <br/>
                        <dt class="width_100"><?php echo __('Modifier'); ?></dt>
                        <dd>
                            <?php echo h($transportBill['Modifier']['first_name'] . ' ' . $transportBill['Modifier']['last_name']); ?>&nbsp;
                        </dd>
                        <br/>
                        <dt class="width_100"><?php echo __('Modified'); ?></dt>
                        <dd>
                            <?php echo  h($this->Time->format($transportBill['TransportBill']['modified'], '%d-%m-%Y'));?>
                            &nbsp;
                        </dd>
                        <br/>
                        <?php if (isset($originTransportBill) && !empty($originTransportBill)) { ?>
                            <dt class="width_100"><?php echo __('Origin reference'); ?></dt>
                            <dd>
                                <?php echo $originTransportBill['TransportBill']['reference']; ?>
                            </dd>
                            <br/>
                        <?php } ?>
                        <?php if (isset($newTransportBill) && !empty($newTransportBill)) { ?>
                            <dt class="width_100"><?php echo __('New reference'); ?></dt>
                            <dd>
                                <?php echo $newTransportBill['TransportBill']['reference']; ?>
                            </dd>
                            <br/>
                        <?php } ?>
                        <br/>

                    </div>
                    <div class="tab-pane" id="tab_2">
                        <div class="row">
                            <!-- BASIC WIZARD -->
                            <div class="col-lg-12">
                                <div class="card-box p-b-0">

                                    <table class="table table-striped table-bordered dt-responsive nowrap">
                                        <thead>
                                        <tr>

                                            <th><?php echo __('Reference'); ?></th>
                                            <th><?php echo __('Product').' / '.__('Ride'); ?></th>
                                            <th><?php echo __('Unit price'); ?></th>
                                            <?php if ($transportBill['TransportBill']['type'] != 4 && $transportBill['TransportBill']['type'] != 5) { ?>
                                                <th><?php echo __('Number of trucks'); ?></th>
                                            <?php } ?>
                                            <th><?php echo __('Price HT'); ?></th>
                                            <th><?php echo __('Price TTC'); ?></th>
                                            <?php if ($transportBill['TransportBill']['type'] == 2) { ?>
                                                <th><?php echo __('Status'); ?></th>
                                            <?php } ?>
                                            <?php if ($transportBill['TransportBill']['type'] == 4 || $transportBill['TransportBill']['type'] == 5) { ?>
                                                <th><?php echo __('Reference mission'); ?></th>
                                                <th><?php echo __('Reference') . ' ' . __('sheet ride'); ?></th>
                                                <th><?php echo __('Car'); ?></th>
                                                <th><?php echo __("Customer"); ?></th>


                                                <th class="dtm"><?php echo __('Real Departure date'); ?></th>

                                                <th><?php echo __('Real Arrival date'); ?></th>
                                            <?php } ?>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <?php if (!empty($rides)) { ?>
                                            <?php foreach ($rides as $ride) {  ?>
                                            <td><?php echo h($ride['TransportBillDetailRides']['reference']); ?>
                                                &nbsp;</td>
                                            <?php
                                            if($ride['TransportBillDetailRides']['lot_id']== 1 ) {

                                                if ($ride['TransportBillDetailRides']['type_ride'] == 2) { ?>
                                                    <td><?= $ride['Departure']['name'] . '-' . $ride['Arrival']['name'] . '-' . $ride['Type']['name']; ?></td>

                                                <?php } else { ?>
                                                    <td><?= $ride['DepartureDestination']['name'] . '-' . $ride['ArrivalDestination']['name'] . '-' . $ride['CarType']['name']; ?></td>

                                                <?php }
                                              }else {  ?>
                                                    <td><?= $ride['Product']['name'] ?></td>
                                           <?php } ?>


                                            <td><?= number_format($ride['TransportBillDetailRides']['unit_price'], 2, ",", ".") . ' ' . $this->Session->read("currency"); ?></td>
                                            <?php if ($transportBill['TransportBill']['type'] != 4 && $transportBill['TransportBill']['type'] != 5) { ?>
                                                <td><?= $ride['TransportBillDetailRides']['nb_trucks']; ?></td>
                                            <?php } ?>
                                            <td><?= number_format($ride['TransportBillDetailRides']['price_ht'], 2, ",", ".") . ' ' . $this->Session->read("currency"); ?></td>
                                            <td><?= number_format($ride['TransportBillDetailRides']['price_ttc'], 2, ",", ".") . ' ' . $this->Session->read("currency"); ?></td>
                                            <?php if ($transportBill['TransportBill']['type'] == 2) { ?>
                                                <td><?php switch ($ride['TransportBillDetailRides']['status_id']) {

                                                        /*
                                                        1: commandes en cours
                                                        2: commandes partiellement valid�es
                                                        3: commandes valid�es
                                                        */
                                                        case 1:
                                                            echo '<span class="label label-danger">';
                                                            echo __('Not validated') . "</span>";
                                                            break;
                                                        case 2:
                                                            echo '<span class="label label-warning">';
                                                            echo __('Partially validated') . "</span>";
                                                            break;
                                                        case 3:
                                                            echo '<span class="label label-success">';
                                                            echo __('Validated') . "</span>";
                                                            break;

                                                    } ?>&nbsp;
                                                </td>
                                            <?php } ?>

                                            <?php if ($transportBill['TransportBill']['type'] == 4 || $transportBill['TransportBill']['type'] == 5) { ?>
                                                <td><?php echo h($ride['SheetRideDetailRides']['reference']); ?>
                                                    &nbsp;</td>
                                                <td><?php echo h($ride['SheetRide']['reference']); ?>&nbsp;</td>


                                                <td> <?php if ($param == 1) {
                                                        echo $ride['Car']['code'] . " - " . $ride['Carmodel']['name'];
                                                    } else if ($param == 2) {
                                                        echo $ride['Car']['immatr_def'] . " - " . $ride['Carmodel']['name'];
                                                    } ?>

                                                </td>
                                                <td><?php echo h($ride['Customer']['first_name'] . ' - ' . $ride['Customer']['last_name']); ?>
                                                    &nbsp;</td>


                                                <td><?php echo h($this->Time->format($ride['SheetRide']['real_start_date'], '%d-%m-%Y %H:%M')); ?>
                                                    &nbsp;</td>

                                                <td><?php echo h($this->Time->format($ride['SheetRide']['real_end_date'], '%d-%m-%Y %H:%M')); ?>
                                                    &nbsp;</td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                        }
                                        } ?>
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="tab-pane" id="tab_3">

                        <dt><?= __('Name') ?>  </dt>
                        <dd><?= $transportBill['Supplier']['name'] ?></dd>
                        <br/>
                        <dt><?= __('Adress') ?>  </dt>
                        <dd><?= $transportBill['Supplier']['adress'] ?></dd>
                        <br/>
                        <dt><?= __('Tel.') ?>  </dt>
                        <dd>
                        <?= $transportBill['Supplier']['tel'] ?></dt>
                    </div>
                    <?php if ($transportBill['TransportBill']['type'] == TransportBillTypesEnum::invoice) { ?>
                        <div class="tab-pane" id="tab_4">
                            <div class="row">
                                <!-- BASIC WIZARD -->
                                <div class="col-lg-12">
                                    <div class="card-box p-b-0">

                                        <table class="table table-striped table-bordered dt-responsive nowrap">
                                            <thead>
                                            <tr>

                                                <th><?php echo __('Date'); ?></th>
                                                <th><?php echo __('Payroll amount'); ?></th>
                                                <th><?php echo __('Payment type'); ?></th>
                                                <th><?php echo __('Number payment'); ?></th>

                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php if (!empty($detailPayments)) { ?>
                                                <?php foreach ($detailPayments as $detailPayment) {
                                                    ; ?>
                                                    <tr>
                                                        <td><?php echo h($this->Time->format($detailPayment['Payment']['receipt_date'], '%d-%m-%Y')) ?>
                                                            &nbsp;</td>
                                                        <td><?= number_format($detailPayment['DetailPayment']['payroll_amount'], 2, ",", ".") . ' ' . $this->Session->read("currency"); ?></td>

                                                        <td><?php switch ($detailPayment['Payment']['payment_type']) {
                                                                case 1:
                                                                    echo __('Species');
                                                                    break;
                                                                case 2:
                                                                    echo __('Transfer');
                                                                    break;
                                                                case 3:
                                                                    echo __('Bank check');
                                                                    break;

                                                            } ?></td>

                                                        <td><?= $detailPayment['Payment']['number_payment']; ?></td>


                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>

</div>
<?php $this->start('script'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions'); ?>
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min'); ?>
<?= $this->Html->script('plugins/datetimepicker/moment-with-locales.min.js'); ?>
<?= $this->Html->script('plugins/datetimepicker/bootstrap-datetimepicker.min.js'); ?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
<?= $this->Html->script('plugins/iCheck/icheck.min'); ?>
<script type="text/javascript">

    $(document).ready(function () {
        jQuery("#dialogModalConditionTransformation").dialog({
            autoOpen: false,
            height: 450,
            width: 450,
            show: {
                effect: "blind",
                duration: 400
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            modal: true
        });

    });

    function transformFromQuotationRequestToOrder(type_transform) {
        var type_doc = jQuery('#type').val();
        var myCheckboxes = jQuery('#transport_bill_id').val();

        jQuery('#dialogModalConditionTransformation').dialog('option', 'title', 'Option de la transformation');
        jQuery('#dialogModalConditionTransformation').dialog('open');
        jQuery('#dialogModalConditionTransformation').load('<?php echo $this->Html->url('/transportBills/transformFromQuotationRequestToOrder/')?>' + myCheckboxes + '/' + type_transform + '/' + type_doc);

    }

</script>
<?php $this->end(); ?>