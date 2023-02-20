

<?php
/** @var $profileId integer */
/** @var $type integer */
/** @var $paramCarName integer */
/** @var $sheetRideDetailRides array */
/** @var $observations array */
/** @var $destinations array */
/** @var $transportBill array */

App::import('Model', 'Observation');
$this->Observation = new Observation();

App::import('Model', 'TransportBillDetailRides');
$this->TransportBillDetailRides = new TransportBillDetailRides();

if ($type == TransportBillTypesEnum::order) { ?>

    <div class="row">
        <!-- BASIC WIZARD -->
        <div class="col-lg-12">
            <div class="card-box p-b-0">
                <div class="row" style="clear:both">
                    <div class="btn-group pull-left">
                        <div class="header_actions">
                            <?php if ($permissionCancel == 1) { ?>

                                       <div class="btn-group">
                                    <?= $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Cancel'),
                                        'javascript:;',
                                        array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>
                                    <button type="button" id="export_allmark"
                                            class="btn dropdown-toggle btn-inverse  btn-bordred" data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <?= $this->Html->link( __('Cancel'),
                                                'javascript:cancelCustomerOrders("Observation");',
                                                array(  'id' => 'cancel')); ?>
                                        </li>
                                        <li>
                                            <?= $this->Html->link(__('Remove cancellation'), 'javascript:removeCancellation("Observation");') ?>
                                        </li>


                                    </ul>
                                </div>
                         <?php } ?>
                            <?php if ($permissionOrder == 1) {
                                echo $this->Html->link('<i class="glyphicon glyphicon-export m-r-5"></i>' . __('Transmit'),
                                    "javascript:validateCustomerOrder('Observation');",
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5', 'id' => 'validate'));

                            } ?>
                            <?php
                 if (Configure::read("reclamation") == '1') {
                            if ($permissionComplaint == 1) { ?>


                                <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Complaint'),
                                    'javascript:addComplaint();',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>

                            <?php    } }
                            ?>
                        </div>
                    </div>
                    <div style='clear:both; padding-top: 10px;'></div>
                </div>
            </div>
        </div>
    </div>

    <table  id="table-detail" class=" table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" id ='table-detail'>
        <thead>
        <tr>
            <?php if ($profileId != ProfilesEnum::client) { ?>
                <th style="width: 10px">
                    <button type="button" id='checkbox' class="approvAll btn btn-default btn-sm checkbox-toggle"><i
                                class="fa fa-square-o"></i></button>
                </th>
                <th><?php echo __('Reference') . ' ' . __('mission'); ?></th>
                <th><?php echo __('Reference') . ' ' . __('order'); ?></th>
            <?php } ?>
            <th><?php echo __('Ride') . ' / ' . __('Product'); ?></th>
            <th><?php echo __('Final customer'); ?></th>
            <th><?php echo __('Car'); ?></th>
            <th><?php echo __("Customer"); ?></th>
            <th><?php echo __("Phone"); ?></th>
            <th><?php echo __('Avancement'); ?></th>
            <th><?php echo __('Position'); ?></th>
            <th><?php echo __('Status'); ?></th>
            <th><?php echo __('Customer observation'); ?></th>
            <th><?php echo __('Planification observation'); ?></th>
            <?php if (Configure::read("reclamation") == '1') { ?>
            <th><?php echo __('Nb').' '.__('complaints').' '.__('orders'); ?></th>
            <th><?php echo __('Nb').' '.__('complaints').' '.__('missions'); ?></th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>

<?php
$i =0;
foreach ($sheetRideDetailRides as $sheetRideDetailRide) {

    ?>
            <tr>
                <?php if ($profileId != ProfilesEnum::client) { ?>

                    <td>
                    </td>
                    <td><?php echo $sheetRideDetailRide['SheetRideDetailRides']['reference'] ?></td>
                    <td><?php echo $sheetRideDetailRide['TransportBillDetailRides']['reference'] ?></td>
                <?php } ?>

                <?php if ($sheetRideDetailRide['SheetRideDetailRides']['type_ride'] == 2) { ?>
                    <td><?= $sheetRideDetailRide['Departure']['name'] . '-' . $sheetRideDetailRide['Arrival']['name'] . '-' . $sheetRideDetailRide['CarType']['name']; ?></td>
                <?php } else { ?>
                    <td><?= $sheetRideDetailRide['DepartureDestination']['name'] . '-' . $sheetRideDetailRide['ArrivalDestination']['name'] . '-' . $sheetRideDetailRide['CarType']['name']; ?></td>

                <?php } ?>
                <td><?php echo $sheetRideDetailRide['SupplierFinal']['name'] ?></td>
                <td> <?php
                    if ($sheetRideDetailRide['SheetRide']['car_subcontracting'] == 2) {
                        if ($paramCarName == 1) {
                            echo $sheetRideDetailRide['Car']['code'] . " - " . $sheetRideDetailRide['Carmodel']['name'];
                        } else if ($paramCarName == 2) {
                            echo $sheetRideDetailRide['Car']['immatr_def'] . " - " . $sheetRideDetailRide['Carmodel']['name'];
                        }
                    } else {
                        echo $sheetRideDetailRide['SheetRide']['car_name'];
                    }

                    ?>

                </td>
                <td>
                    <?php
                    if ($sheetRideDetailRide['SheetRide']['car_subcontracting'] == 2) {
                        echo $sheetRideDetailRide['Customer']['first_name'] . " " . $sheetRideDetailRide['Customer']['last_name'];
                    } else {
                        echo $sheetRideDetailRide['SheetRide']['customer_name'];
                    }

                    ?>
                    &nbsp;
                </td>
                <td><?= $sheetRideDetailRide['Customer']['mobile'] ?></td>
                <td><?php ?></td>
                <td><?php if ($sheetRideDetailRide['SheetRideDetailRides']['status_id'] == StatusEnum::mission_ongoing) { ?>
                        <?= $this->Html->link(
                            '<i class="fa fa-map-marker"></i>',
                            array('controller' => 'cars', 'action' => 'viewPosition', $sheetRideDetailRide['SheetRide']['car_id']),
                            array('escape' => false, 'target' => '_blank', 'style' => 'display :block; text-align: center;')
                        ); ?>
                    <?php } ?>
                </td>
                <td>
                    <?php switch ($sheetRideDetailRide['SheetRideDetailRides']['status_id']) {
                        /*
                        1: mission planifi�e
                        2: mission en cours
                        3: mission clotur�e
                        4: mission pr�factur�e
                        5: mission approuv�e
                        6: mission non approuv�e
                        7: mission factur�e
                        */
                        case 1:
                            echo '<span class="label label-warning">';
                            echo __('Planned') . "</span>";
                            break;
                        case 2:
                            echo '<span class="label label-danger">';
                            echo __('In progress') . "</span>";
                            break;
                        case 3:
                            echo '<span class="label label-success">';
                            echo h(__('Closed')) . "</span>";
                            break;
                            break;
                        case 4:
                            echo '<span class="label label-primary">';
                            echo h(__('Preinvoiced')) . "</span>";
                            break;
                        case 5:
                            echo '<span class="label label-pink">';
                            echo h(__('Approved')) . "</span>";
                            break;
                        case 6:
                            echo '<span class="label label-purple">';
                            echo h(__('Not approved')) . "</span>";
                            break;
                        case 7:
                            echo '<span class="label btn-inverse">';
                            echo h(__('Invoiced')) . "</span>";
                            break;
                    } ?>
                </td>
                <td><?php
                    echo $sheetRideDetailRide['Observation']['customer_observation']
                    ?></td>
                <td>
                    <?php
                    echo $sheetRideDetailRide['SheetRideDetailRides']['note']
                    ?>
                </td>
               <?php  if (Configure::read("reclamation") == '1') { ?>
                <td style="text-align: center;">
                    <?php

                    if($countComplaintObservations[$i][0]['complaint_count_order']>0) { ?>
                        <?= $this->Html->link($countComplaintObservations[$i][0]['complaint_count_order'],
                            array('controller' =>'complaints','action' => 'viewOrderComplaints',$countComplaintObservations[$i]['Observation']['id']),
                            array('escape' => false, 'class' => 'btn btn-warning')
                        ); ?>
                    <?php } else { ?>
                        <?= $this->Html->link($countComplaintObservations[$i][0]['complaint_count_order'],
                            array('controller' =>'complaints','action' => 'viewOrderComplaints',$countComplaintObservations[$i]['Observation']['id']),
                            array('escape' => false, 'class' => 'btn btn-success')
                        ); ?>
                    <?php }?>

                </td>
                <td style="text-align: center;">
                    <?php if($sheetRideDetailRide[0]['complaint_count_mission']>0) {?>
                        <?= $this->Html->link($sheetRideDetailRide[0]['complaint_count_mission'],
                            array('controller' =>'complaints','action' => 'viewMissionComplaints',$sheetRideDetailRide['SheetRideDetailRides']['id']),
                            array('escape' => false, 'class' => 'btn btn-warning')
                        ); ?>
                   <?php } else { ?>
                        <?= $this->Html->link($sheetRideDetailRide[0]['complaint_count_mission'],
                            array('controller' =>'complaints','action' => 'viewMissionComplaints',$sheetRideDetailRide['SheetRideDetailRides']['id']),
                            array('escape' => false, 'class' => 'btn btn-success')
                        ); ?>
                   <?php }?>

                </td>
                <?php } ?>


            </tr>
            <?php
    $i ++;
        }

foreach ($observations as $observation) {
            ?>
<?php if(empty($observation['Observation']['cancel_cause_id'])) { ?>
                <tr>
                    <?php if ($profileId != ProfilesEnum::client) { ?>
                        <td><input id="idCheck" type="checkbox" class='approve id'
                                   value=<?php echo $observation['Observation']['id'] ?>></td>
                        <td></td>
                        <td><?php echo $observation['TransportBillDetailRides']['reference'] ?></td>
                    <?php } ?>
                    <?php if ($observation['TransportBillDetailRides']['type_ride'] == 2) { ?>
                        <td>
                            <?php
                            echo "<div class='form-group clear-none p-l-0 width-32'>" . $this->Form->input('departure_destination_id', array(
                                    'label' => '',
                                    'name' => $this->TransportBillDetailRides->encrypt("transportBillDetailRides|" . $observation['TransportBillDetailRides']['id']),
                                    'value' => $observation['Departure']['id'],
                                    'options' => $destinations,
                                    'empty' => '',
                                    'class' => 'form-control table-input1 departure select-search-destination',
                                    'id' => 'departure_destination'
                                )) . "</div>";
                            ?>


                            <?php echo "<div class='form-group clear-none p-l-0 width-32'>" . $this->Form->input('arrival_destination_id', array(
                                    'label' => '',
                                    'value' => $observation['Arrival']['id'],
                                    'name' => $this->TransportBillDetailRides->encrypt("transportBillDetailRides|" . $observation['TransportBillDetailRides']['id']),
                                    'options' => $destinations,
                                    'empty' => '',
                                    'class' => 'form-control table-input2 arrival select-search-destination',
                                    'id' => 'arrival_destination'
                                )) . "</div>"; ?>


                            <?php


                            echo "<div class='form-group clear-none p-l-0 width-32'>" . $this->Form->input('car_type_id', array(
                                    'label' => '',
                                    'value' => $observation['Type']['id'],
                                    'name' => $this->TransportBillDetailRides->encrypt("transportBillDetailRides|" . $observation['TransportBillDetailRides']['id']),
                                    'class' => 'form-control table-input3 type select-search',
                                    'empty' => '',
                                    'id' => 'car_type'
                                )) . "</div>"; ?>

                        </td>

                    <?php } else { ?>
                        <td><?= $observation['DepartureDestination']['name'] . '-' . $observation['ArrivalDestination']['name'] . '-' . $observation['CarType']['name']; ?></td>

                    <?php } ?>
                    <td><?php echo $observation['SupplierFinal']['name'] ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td>
                        <?php
                        if($observation['TransportBillDetailRides']['status_id']== TransportBillDetailRideStatusesEnum::not_transmitted){
                            echo '<span class="label label-primary">';
                            echo __('Not transmitted') . "</span>";
                        }else {
                            echo '<span class="label label-danger">';
                            echo __('No validated') . "</span>";
                        }


                        ?>
                    </td>
                    <td>
                        <div class="table-content editable">
                        <span>

                        </span>
                            <input
                                    name="<?= $this->Observation->encrypt("observation|" . $observation['Observation']['id']); ?>"
                                    placeholder="<?= __('Enter observation') ?>"
                                    value="<?= $observation['Observation']['customer_observation'] ?>"
                                    class="form-control table-input observation" type="text">
                        </div>

                    </td>
                    <td></td>
                   <?php  if (Configure::read("reclamation") == '1') { ?>
                    <td style="text-align: center;">
                        <?php if($observation[0]['complaint_count_order']>0){ ?>
                            <?= $this->Html->link($observation[0]['complaint_count_order'],
                                array('controller' =>'complaints','action' => 'viewOrderComplaints',$observation['Observation']['id']),
                                array('escape' => false, 'class' => 'btn btn-warning')
                            ); ?>
                       <?php }else { ?>
                            <?= $this->Html->link($observation[0]['complaint_count_order'],
                                array('controller' =>'complaints','action' => 'viewOrderComplaints',$observation['Observation']['id']),
                                array('escape' => false, 'class' => 'btn btn-success')
                            ); ?>
                       <?php } ?>

                    </td>


                    <td style="text-align: center;">
                        <?= $this->Html->link(0,
                            array(),
                            array('escape' => false, 'class' => 'btn btn-success')
                        ); ?>
                    </td>
                   <?php } ?>
                </tr>
<?php } else { ?>

                <tr>
                    <?php if ($profileId != ProfilesEnum::client) { ?>
                        <td><input id="idCheck" type="checkbox" class='approve id'
                                   value=<?php echo $observation['Observation']['id'] ?>></td>
                        <td></td>
                        <td><?php echo $observation['TransportBillDetailRides']['reference'] ?></td>
                    <?php } ?>
                    <?php if ($observation['TransportBillDetailRides']['type_ride'] == 2) { ?>
                        <td>
                            <?php
                            echo $observation['Departure']['name'] .'-'.$observation['Arrival']['name'].'-'. $observation['Type']['name'];

                            ?>



                        </td>

                    <?php } else { ?>
                        <td><?= $observation['DepartureDestination']['name'] . '-' . $observation['ArrivalDestination']['name'] . '-' . $observation['CarType']['name']; ?></td>

                    <?php } ?>
                    <td><?php echo $observation['SupplierFinal']['name'] ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td>
                        <?php
                        echo '<span class="label label-inverse">';
                        echo __('Canceled') . "</span>" ." ( ". $observation['CancelCause']['name'] ." )";

                        ?>
                    </td>
                    <td>
                        <?php echo $observation['Observation']['customer_observation'] ; ?>

                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>


        <?php    }?>

            <?php
        }

        if (!empty($transportBillLots)) {
            foreach ($transportBillLots as $transportBillLot) { ?>
                <tr>
                    <?php if ($profileId != ProfilesEnum::client) { ?>
                        <td></td>
                        <td></td>
                        <td><?php echo $transportBillLot['TransportBillDetailRides']['reference'] ?></td>
                    <?php } ?>

                    <td><?= $transportBillLot['Product']['name']; ?>
                    <?php if($transportBillLot['ProductType']['id']==3){ ?>
                            <?= ' - '. $transportBillLot['CarType']['name'].' - '. $transportBillLot['Car']['immatr_def'].' - '. $transportBillLot['Carmodel']['name']; ?>
                    <?php } ?>
                    </td>

                    <td><?php echo $transportBillLot['SupplierFinal']['name'] ?></td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>

                    </td>
                    <td>
                    </td>
                    <td>
                    </td>  <td>
                    </td>  <td>
                    </td>
                </tr>
            <?php }
        }


        ?>


        </tbody>

    </table>

<?php } else {
    if ($type == TransportBillTypesEnum::pre_invoice ||
        $type == TransportBillTypesEnum::invoice ||
        $type == TransportBillTypesEnum::credit_note
    ) {

$query = $this->Session->read('query');
extract($query);

echo $this->Form->input('transport_bill_id', array(
            'type' => 'hidden',
            'id' => 'transport_bill_id',
            'value'=>$transportBillId,
            'empty' => ''
));


$tableId = strtolower('approve-mission') . '-grid';


/** @var array $columns */
/** @var string $tableName */
?>
        <!--    Content section    -->
        <?= $this->element('index-body-content', array(
            "tableId" => $tableId,
            "tableName" => $tableName,
            "columns" => $columns,
        ));
?>
        <!--    End content section    -->

        <?= $this->element('data-tables-script', array(
            "tableId" => $tableId,
            "tableName" => $tableName,
            "columns" => $columns,
            "defaultLimit" => $defaultLimit,
        ));
?>
        <!--    End dataTables Script    -->

   <?php } else { ?>

        <table id="table-detail" class="table table-striped table-bordered dt-responsive nowrap">
            <thead>
            <tr>

                <th><?php echo __('Reference'); ?></th>
                <th><?php echo __('Ride') . ' / ' . __('Product'); ?></th>
                <th><?php echo __('Final customer'); ?></th>

                <th><?php echo __('Unit price'); ?></th>
                <th><?php echo __('Quantity'); ?></th>

                <th><?php echo __('Price HT'); ?></th>
                <th><?php echo __('Price TTC'); ?></th>

                <?php if ($transportBill['TransportBill']['type'] == TransportBillTypesEnum::pre_invoice
                    || $transportBill['TransportBill']['type'] == TransportBillTypesEnum::invoice
                ) {
                    ?>
                    <th><?php echo __('Reference mission'); ?></th>
                    <th><?php echo __('Reference') . ' ' . __('sheet ride'); ?></th>
                    <th><?php echo __('Car'); ?></th>
                    <th><?php echo __("Customer"); ?></th>
                    <th class="dtm"><?php echo __('Real Departure date'); ?></th>
                    <th><?php echo __('Real Arrival date'); ?></th>
                    <th><?php echo __('Order date'); ?></th>
                <?php } ?>
                <?php if ($transportBill['TransportBill']['type'] == TransportBillTypesEnum::pre_invoice) { ?>
                    <th><?= __('Approved') ?>
                        <button type="button" id='checkbox' class=" approvAll btn btn-default btn-sm checkbox-toggle">
                            <i class="fa fa-square-o"></i></button>
                    </th>

                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($rides)) {
                $nbMissions = 1;
                ?>
                <?php foreach ($rides as $ride) { ?>
                    <tr id="row<?= $ride['TransportBillDetailRides']['id'] ?>">
                        <td><?php echo h($ride['TransportBillDetailRides']['reference']); ?>&nbsp;</td>


                        <?php
                        if ($ride['TransportBillDetailRides']['lot_id'] == 1) {
                            if ($ride['TransportBillDetailRides']['type_ride'] == 2) { ?>
                                <td><?= $ride['Departure']['name'] . '-' . $ride['Arrival']['name'] . '-' . $ride['Type']['name']; ?></td>
                            <?php } else { ?>
                                <td><?= $ride['DepartureDestination']['name'] . '-' . $ride['ArrivalDestination']['name'] . '-' . $ride['CarType']['name']; ?></td>
                            <?php }
                        } else { ?>
                            <td> <?= $ride['Product']['name']; ?>
                            </td>
                        <?php } ?>

                        <td><?php echo $ride['SupplierFinal']['name']; ?></td>

                        <td><?= number_format($ride['TransportBillDetailRides']['unit_price'], 2, ",", ".") . ' ' . $this->Session->read("currency"); ?></td>
                          <td><?= $ride['TransportBillDetailRides']['nb_trucks']; ?></td>

                        <td><?= number_format($ride['TransportBillDetailRides']['price_ht'], 2, ",", ".") . ' ' . $this->Session->read("currency"); ?></td>
                        <td><?= number_format($ride['TransportBillDetailRides']['price_ttc'], 2, ",", ".") . ' ' . $this->Session->read("currency"); ?></td>

                        <?php if ($transportBill['TransportBill']['type'] == TransportBillTypesEnum::pre_invoice
                            || $transportBill['TransportBill']['type'] == TransportBillTypesEnum::invoice
                        ) {
                            ?>
                            <td><?php echo h($ride['SheetRideDetailRides']['reference']); ?>&nbsp;</td>
                            <td><?php echo h($ride['SheetRide']['reference']); ?>&nbsp;</td>


                            <td> <?php

                                if ($ride['SheetRide']['car_subcontracting'] == 2) {
                                    if ($paramCarName == 1) {
                                        echo $ride['Car']['code'] . " - " . $ride['Carmodel']['name'];
                                    } else if ($paramCarName == 2) {
                                        echo $ride['Car']['immatr_def'] . " - " . $ride['Carmodel']['name'];
                                    }
                                } else {
                                    echo $ride['SheetRide']['car_name'];
                                }
                                ?>

                            </td>
                            <td><?php
                                if ($ride['SheetRide']['car_subcontracting'] == 2) {
                                    echo h($ride['Customer']['first_name'] . ' - ' . $ride['Customer']['last_name']);
                                } else {
                                    echo $ride['SheetRide']['customer_name'];
                                }
                                ?>

                            </td>

                            <td><?php echo h($this->Time->format($ride['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y %H:%M')); ?>
                                &nbsp;
                            </td>

                            <td><?php echo h($this->Time->format($ride['SheetRideDetailRides']['real_end_date'], '%d-%m-%Y %H:%M')); ?>
                            <td><?php echo h($this->Time->format($ride['TransportBill']['date'], '%d-%m-%Y')); ?>
                                &nbsp;
                            </td>
                        <?php } ?>
                        <?php if ($transportBill['TransportBill']['type'] == TransportBillTypesEnum::pre_invoice) { ?>
                            <td>
                                <?php
                                echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $nbMissions . '.id',
                                        array(
                                            'type' => 'hidden',
                                            'id' => 'missionId' . $nbMissions,
                                            'label' => false,
                                            'value' => $ride['TransportBillDetailRides']['id']
                                        )) . "</div>";

                                if (($ride['TransportBillDetailRides']['approved'] == 4)
                                    || ($ride['TransportBillDetailRides']['approved'] == 0)) {
                                    echo "<div class='appro'>" . $this->Form->input('TransportBillDetailRides.' . $nbMissions . '.approved',
                                            array(
                                                'type' => 'checkbox',
                                                'label' => false,
                                                'class' => 'approve',
                                                'value' => $ride['TransportBillDetailRides']['id'],
                                                'checked' => false
                                            )) . "</div>";
                                } else {
                                    echo "<div class='appro'>" . $this->Form->input('TransportBillDetailRides.' . $nbMissions . '.approved',
                                            array(
                                                'type' => 'checkbox',
                                                'label' => false,
                                                'class' => 'approve',
                                                'value' => $ride['TransportBillDetailRides']['id'],
                                                'checked' => true
                                            )) . "</div>";
                                }

                                ?>
                            </td>
                        <?php } ?>
                    </tr>
                    <?php
                    $nbMissions++;
                }
            } ?>
            </tbody>
        </table>

   <?php }

     } ?>





<?php

    if ($transportBill['TransportBill']['type'] == TransportBillTypesEnum::pre_invoice) {

        ?>
        <button style="float: right;" type='button' name='add' id='add' class='btn btn-success'
                onclick='approveMissions()'><?= __('Approve mission') ?></button>
        <br/>
    <?php }




		
		
                                

         