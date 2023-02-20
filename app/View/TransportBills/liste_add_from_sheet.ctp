<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
       width="100%">
    <tbody>
    <?php
    foreach ($sheetRideDetailRides as $sheetRideDetailRide){ ?>
        <tr id="row<?= $sheetRideDetailRide['SheetRideDetailRides']['id'] ?>">
            <td>

                <input id="idCheck"type="checkbox" class = 'id' value=<?php echo $sheetRideDetailRide['SheetRideDetailRides']['id'] ?> >
            </td>
            <td><?=  $sheetRideDetailRide['SheetRideDetailRides']['reference']?></td>
            <td><?php
                if ($param == 1) {
                    echo $sheetRideDetailRide['Car']['code'] . " - " . $sheetRideDetailRide['Carmodel']['name'];
                } else if ($param == 2) {
                    echo $sheetRideDetailRide['Car']['immatr_def'] . " - " . $sheetRideDetailRide['Carmodel']['name'];
                }
                ?></td>
            <td><?=   $sheetRideDetailRide['Customer']['first_name'] . " - " . $sheetRideDetailRide['Customer']['last_name'];?></td>
            <?php if($sheetRideDetailRide['SheetRideDetailRides']['type_ride']==1) { ?>
                <td><?=  $sheetRideDetailRide['DepartureDestination']['name'].'-'.$sheetRideDetailRide['ArrivalDestination']['name'].'-'.$sheetRideDetailRide['CarType']['name'];?></td>

            <?php }else {?>
                <td><?=  $sheetRideDetailRide['Departure']['name'].'-'.$sheetRideDetailRide['Arrival']['name'].'-'.$sheetRideDetailRide['CarType']['name'];?></td>

            <?php } ?>
            <td><?=  $sheetRideDetailRide['Supplier']['name']?></td>
            <td><?php echo h($sheetRideDetailRide['Service']['name']); ?>&nbsp;</td>
            <td><?php echo h($this->Time->format($sheetRideDetailRide['SheetRideDetailRides']['real_start_date'], '%d-%m-%Y %H:%M')); ?>&nbsp;</td>

            <td><?=  $sheetRideDetailRide['SupplierFinal']['name']?></td>
            <td><?php echo h($this->Time->format($sheetRideDetailRide['SheetRide']['real_start_date'], '%d-%m-%Y %H:%M')); ?>&nbsp;</td>
            <td><?php echo h($this->Time->format($sheetRideDetailRide['TransportBill']['date'], '%d-%m-%Y')); ?>&nbsp;</td>

            <td>
                <?php switch ($sheetRideDetailRide['SheetRideDetailRides']['status_id']) {

                    /*
                    1: mission planifi�e
                    2: mission en cours
                    3: mission clotur�e
                    4: mission pr�factur�e
                    5: mission approuv�e
                    */					case 1:
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
                    case 4:
                        echo '<span class="label label-primary">';
                        echo h(__('Preinvoiced')) . "</span>";
                        break;
                    case 5:
                        echo '<span class="label bg-olive">';
                        echo h(__('Approved')) . "</span>";
                        break;

                }
                ?>
            </td>
        </tr>
    <?php } ?>

    </tbody>

</table>

<div id ='pageCount' class="hidden">
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