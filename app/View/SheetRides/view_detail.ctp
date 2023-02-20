
<div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
        <div class="card-box p-b-0">
            <div class="row" style="clear:both">
                <div class="btn-group pull-left">
                    <div class="header_actions">



                        <?php if ($permissionCancel == 1 && Configure::read("transport_personnel") == '0') { ?>


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
                                    'javascript:cancelSheetRides("SheetRideDetailRides");',
                                    array(  'id' => 'cancel')); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(__('Remove cancellation'), 'javascript:removeCancellation("SheetRideDetailRides");') ?>
                            </li>
                        </ul>
                    </div>
                        <?php    }


                        ?>

                        <?php
                        if (Configure::read("reclamation") == '1') {
                            if ($permissionComplaint == 1) { ?>

                                <?= $this->Html->link('<i class="fa fa-plus m-r-5"></i>' . __('Complaint'),
                                    'javascript:addComplaint();',
                                    array('escape' => false, 'class' => 'btn btn-inverse btn-bordred waves-effect waves-light m-b-5')) ?>

                            <?php }
                        }
                        ?>


                    </div>
                </div>
                <div style='clear:both; padding-top: 10px;'></div>
            </div>
        </div>
    </div>
</div>

<?php if(Configure::read("transport_personnel") == '1') { ?>
    <table id="table-detail" class="table table-striped table-bordered dt-responsive nowrap"
           cellspacing="0" width="100%">
        <thead>
        <tr>
            <th style="width: 10px">
                <button type="button" id='checkbox' class="approvAll btn btn-default btn-sm checkbox-toggle"><i
                            class="fa fa-square-o"></i></button>
            </th>
            <th><?php echo __('Reference'); ?></th>
            <th><?php echo __('Itinerary'); ?></th>


            <th><?php echo __('Planned Departure date'); ?></th>
            <th><?php echo __('Real Departure date'); ?></th>


            <th><?php echo  __('Planned Arrival date'); ?></th>
            <th><?php echo  __('Real Arrival date'); ?></th>

            <th><?php echo __('Status'); ?></th>
            <th><?php echo __('Nb').' '. __('complaints').' '. __('internal'); ?></th>
            <th><?php echo __('Nb').' '. __('complaints').' '. __('external'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>

        </tr>
        </thead>

        <tbody id="listeDiv">

        <?php

        $i = 0;
        foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
            ?>
            <tr>
                <td><input id="idCheck" type="checkbox" class='approve id'
                           value=<?php echo $sheetRideDetailRide['SheetRideDetailRides']['id'] ?>></td>
                <td><?php echo $sheetRideDetailRide['SheetRideDetailRides']['reference'] ?></td>

                    <td><?= $sheetRideDetailRide['Departure']['name'] . '-' . $sheetRideDetailRide['Arrival']['name']; ?></td>



                <td><?php echo h($this->Time->format($sheetRideDetailRide['SheetRideDetailRides']['planned_start_date'], '%d-%m-%Y %H:%M')); ?></td>
                <td><?php echo h($this->Time->format($sheetRideDetailRide['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y %H:%M')); ?></td>



                <td><?php echo h($this->Time->format($sheetRideDetailRide['SheetRideDetailRides']['planned_end_date'], '%d-%m-%Y %H:%M')); ?></td>
                <td><?php echo h($this->Time->format($sheetRideDetailRide['SheetRideDetailRides']['real_end_date'], '%d-%m-%Y %H:%M')); ?></td>


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

                        case 9:
                            echo '<span class="label label-inverse">';
                            echo __('Canceled') . "</span>"  ." ( ". $sheetRideDetailRide['CancelCause']['name'] ." )";
                            break;

                    } ?>



                <td style="text-align: center;">
                    <?php
                    if($sheetRideDetailRide[0]['complaint_count_mission']>0) { ?>
                        <?= $this->Html->link($sheetRideDetailRide[0]['complaint_count_mission'],
                            array('controller' =>'complaints','action' => 'viewMissionComplaints',$sheetRideDetailRide['SheetRideDetailRides']['id']),
                            array('escape' => false, 'class' => 'btn btn-warning')
                        ); ?>
                    <?php } else {

                        ?>
                        <?= $this->Html->link($sheetRideDetailRide[0]['complaint_count_mission'],
                            array('controller' =>'complaints','action' => 'viewMissionComplaints',$sheetRideDetailRide['SheetRideDetailRides']['id']),
                            array('escape' => false, 'class' => 'btn btn-success')
                        ); ?>
                   <?php }?>

                </td>
                <td style="text-align: center;">
                    <?php if(!empty($countComplaintObservations[$i][0]['complaint_count_order'])) { ?>
                        <?= $this->Html->link($countComplaintObservations[$i][0]['complaint_count_order'],
                            array('controller' =>'complaints','action' => 'viewOrderComplaints',$countComplaintObservations[$i]['Observation']['id']),
                            array('escape' => false, 'class' => 'btn btn-warning')
                        ); ?>
                    <?php } else { ?>
                        <?= $this->Html->link(0,
                            array('controller' =>'#','action' => '#'),
                            array('escape' => false, 'class' => 'btn btn-success')
                        ); ?>
                    <?php } ?>

                </td>
                <td class="actions">

                    <?= $this->Html->link(
                        '<i class="fa fa-edit m-r-5"></i>',
                        array('controller'=>'sheetRideDetailRides','action' => 'Edit', $sheetRideDetailRide['SheetRideDetailRides']['id']),
                        array('escape' => false)
                    ); ?>
                    <?php echo $this->Form->postLink(
                        '<i class="fa fa-trash-o m-r-5"></i>',
                        array('controller'=>'sheetRideDetailRides','action' => 'Delete', $sheetRideDetailRide['SheetRideDetailRides']['id']),
                        array('escape' => false),
                        __('Are you sure you want to delete %s?', $sheetRideDetailRide['SheetRideDetailRides']['reference'])); ?>
                </td>



            </tr>
            <?php
            $i ++;
        } ?>

        </tbody>

    </table>
<?php } else { ?>
    <table id="table-detail" class="table table-striped table-bordered dt-responsive nowrap"
           cellspacing="0" width="100%">
        <thead>
        <tr>
            <th style="width: 10px">
                <button type="button" id='checkbox' class="approvAll btn btn-default btn-sm checkbox-toggle"><i
                            class="fa fa-square-o"></i></button>
            </th>
            <th><?php echo __('Reference'); ?></th>
            <th><?php echo  __('Reference').' '. __('customer order'); ?></th>
            <th><?php echo __('Mission'); ?></th>

            <th><?php echo  __('Initial customer'); ?></th>

            <th><?php echo __('Real Departure date'); ?></th>

            <th><?php echo  __('Final customer'); ?></th>

            <th><?php echo  __('Real Arrival date'); ?></th>

            <th><?php echo __('Status'); ?></th>
            <th><?php echo __('Nb').' '. __('complaints').' '. __('missions'); ?></th>
            <th><?php echo __('Nb').' '. __('complaints').' '. __('orders'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>

        </tr>
        </thead>

        <tbody id="listeDiv">

        <?php

        $i = 0;
        foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
            ?>
            <tr>
                <td><input id="idCheck" type="checkbox" class='approve id'
                           value=<?php echo $sheetRideDetailRide['SheetRideDetailRides']['id'] ?>></td>
                <td><?php echo $sheetRideDetailRide['SheetRideDetailRides']['reference'] ?></td>
                <td><?php echo $sheetRideDetailRide['TransportBillDetailRides']['reference'] ?></td>
                <?php

                if ($sheetRideDetailRide['SheetRideDetailRides']['type_ride'] == 2) {
                    ?>
                    <td><?= $sheetRideDetailRide['Departure']['name'] . '-' . $sheetRideDetailRide['Arrival']['name'] . '-' . $sheetRideDetailRide['CarType']['name']; ?></td>
                <?php } else { ?>
                    <td><?= $sheetRideDetailRide['DepartureDestination']['name'] . '-' . $sheetRideDetailRide['ArrivalDestination']['name'] . '-' . $sheetRideDetailRide['CarType']['name']; ?></td>
                <?php } ?>


                <td><?= $sheetRideDetailRide['Supplier']['name'] ?></td>

                <td><?php echo h($this->Time->format($sheetRideDetailRide['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y %H:%M')); ?>
                    &nbsp;</td>

                <td><?= $sheetRideDetailRide['SupplierFinal']['name'] ?></td>

                <td><?php echo h($this->Time->format($sheetRideDetailRide['SheetRideDetailRides']['real_end_date'], '%d-%m-%Y %H:%M')); ?>
                    &nbsp;</td>


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

                        case 9:
                            echo '<span class="label label-inverse">';
                            echo __('Canceled') . "</span>"  ." ( ". $sheetRideDetailRide['CancelCause']['name'] ." )";
                            break;

                    } ?>



                <td style="text-align: center;">
                    <?php if($sheetRideDetailRide['SheetRideDetailRides']['nb_complaints']>0){ ?>
                        <?= $this->Html->link($sheetRideDetailRide['SheetRideDetailRides']['nb_complaints'],
                            array('controller' =>'complaints','action' => 'viewMissionComplaints',$sheetRideDetailRide['SheetRideDetailRides']['id']),
                            array('escape' => false, 'class' => 'btn btn-warning')
                        ); ?>
                    <?php } else { ?>
                        <?= $this->Html->link(0,
                            array('controller' =>'#','action' => '#'),
                            array('escape' => false, 'class' => 'btn btn-success')
                        ); ?>
                    <?php } ?>
                </td>
                <td style="text-align: center;">
                    <?php if(!empty($sheetRideDetailRide['Observation']['nb_complaints'])) { ?>
                        <?= $this->Html->link($sheetRideDetailRide['Observation']['nb_complaints'],
                            array('controller' =>'complaints','action' => 'viewOrderComplaints',$sheetRideDetailRide[$i]['SheetRideDetailRides']['observation_id']),
                            array('escape' => false, 'class' => 'btn btn-warning')
                        ); ?>
                    <?php } else { ?>
                        <?= $this->Html->link(0,
                            array('controller' =>'#','action' => '#'),
                            array('escape' => false, 'class' => 'btn btn-success')
                        ); ?>
                    <?php } ?>

                </td>
                <td class="actions">

                    <?= $this->Html->link(
                        '<i class="fa fa-edit m-r-5"></i>',
                        array('controller'=>'sheetRideDetailRides','action' => 'Edit', $sheetRideDetailRide['SheetRideDetailRides']['id']),
                        array('escape' => false)
                    ); ?>
                    <?php echo $this->Form->postLink(
                        '<i class="fa fa-trash-o m-r-5"></i>',
                        array('controller'=>'sheetRideDetailRides','action' => 'Delete', $sheetRideDetailRide['SheetRideDetailRides']['id']),
                        array('escape' => false),
                        __('Are you sure you want to delete %s?', $sheetRideDetailRide['SheetRideDetailRides']['reference'])); ?>
                </td>



            </tr>
            <?php
            $i ++;
        } ?>

        </tbody>

    </table>

<?php } ?>

