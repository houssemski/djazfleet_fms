<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
       width="100%">
    <tbody>
    <?php
    foreach ($sheetRideDetailRides as $sheetRideDetailRide) {
        ?>
        <tr>
            <td>
                <input id="idCheck" type="checkbox" class='id'
                       value=<?php echo $sheetRideDetailRide['SheetRideDetailRides']['id'] ?>>
            </td>
            <td><?php echo $sheetRideDetailRide['SheetRideDetailRides']['reference'] ?></td>
            <?php if ($sheetRideDetailRide['SheetRideDetailRides']['from_customer_order'] == 3) { ?>
                <td><?= $sheetRideDetailRide['Departure']['name'] . '-' . $sheetRideDetailRide['Arrival']['name']; ?></td>
            <?php } else { ?>
                <td><?= $sheetRideDetailRide['DepartureDestination']['name'] . '-' . $sheetRideDetailRide['ArrivalDestination']['name'] . '-' . $sheetRideDetailRide['CarType']['name']; ?></td>
            <?php } ?>
            <td> <?php if ($param == 1) {
                    echo $sheetRideDetailRide['Car']['code'] . " - " . $sheetRideDetailRide['Carmodel']['name'];
                } else if ($param == 2) {
                    echo $sheetRideDetailRide['Car']['immatr_def'] . " - " . $sheetRideDetailRide['Carmodel']['name'];
                } ?>

            </td>
            <td>
                <?php

                echo $sheetRideDetailRide['Customer']['first_name'] . " " . $sheetRideDetailRide['Customer']['last_name']; ?>
                &nbsp;
            </td>
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

                } ?>


            </td>
            <td class="actions">

                <div class="btn-group ">
                    <a data-toggle="dropdown" class="btn btn-info" style="height: 31px;">
                        <i class="fa fa-list fa-inverse"></i>
                    </a>
                    <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                        <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu" style="min-width: 70px;">
                        <li>
                            <?php if ($client_i2b == 1) { ?>
                                <?= $this->Html->link(
                                    '<i class="  fa fa-map-marker "></i>',
                                    array('action' => 'ViewPosition', $sheetRideDetailRide['SheetRideDetailRides']['id']),
                                    array('escape' => false, 'class' => 'btn btn-inverse')
                                ); ?>
                            <?php } ?>
                        </li>

                        <li>
                            <?= $this->Html->link(
                                '<i class=" fa fa-print"></i>',
                                array('action' => 'view_mission', 'ext' => 'pdf', $sheetRideDetailRide['SheetRideDetailRides']['id']),
                                array('target' => '_blank', 'escape' => false, 'class' => 'btn btn-warning')
                            ); ?>
                        </li>
                        <li>
                            <?= $this->Html->link(
                                '<i class=" fa fa-refresh " title="' . __('Synchronize') . '"></i>',
                                array('action' => 'synchronisationMission', $sheetRideDetailRide['SheetRideDetailRides']['id']),
                                array('escape' => false, 'class' => 'btn btn-primary')
                            ); ?>
                        </li>




                        <?php
                        /*   if(!empty($sheetRideDetailRide['Message']['status_id'])) {
                               switch($sheetRideDetailRide['Message']['status_id']){
                                   case 2: ?>
                                       <?= $this->Html->link(
                                           '<i class=" fa fa-refresh"></i>',
                                           array('action' => 'sendSms', $sheetRideDetailRide['SheetRideDetailRides']['id']),
                                           array('escape' => false, 'class'=>'btn btn-warning')
                                       ); ?>
                                       <?php        break;
                                   case 3: ?>
                                       <?= $this->Html->link(
                                           '<i class=" fa fa-stop "></i>',
                                           array('action' => 'sendSms', $sheetRideDetailRide['SheetRideDetailRides']['id']),
                                           array('escape' => false , 'class'=>'btn btn-danger')
                                       ); ?>
                                       <?php        break;
                               }
                               ?>

                           <?php } else {?>
                               <?= $this->Html->link(
                                   '<i class=" fa fa-play "></i>',
                                   array('action' => 'sendSms', $sheetRideDetailRide['SheetRideDetailRides']['id']),
                                   array('escape' => false , 'class'=>'btn btn-success')
                               ); ?>
                           <?php } */
                        ?>


                    </ul>
                </div>


            </td>
        </tr>
    <?php } ?>

    </tbody>

</table>
<div id='pageCount' class="hidden">
    <?php
    if ($this->params['paging']['SheetRideDetailRides']['pageCount'] > 1) {
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