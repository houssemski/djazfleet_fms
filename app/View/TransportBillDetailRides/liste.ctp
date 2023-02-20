<table id='datatable-responsive' class="table table-striped table-bordered dt-responsive nowrap " cellspacing="0"
       width="100%">
    <tbody>
    <?php
    if (!empty($transportBillDetailRides)) {
        foreach ($transportBillDetailRides as $transportBillDetailRide) {
            ?>
            <tr id= <?php echo $transportBillDetailRide['TransportBillDetailRides']['id'] ?>>
                <td><input id="idCheck" type="checkbox" class='id'
                           value=<?php echo $transportBillDetailRide['TransportBillDetailRides']['id'] ?>>
                </td>
                <td>
                    <?= $transportBillDetailRide['TransportBillDetailRides']['reference'] ?>
                </td>
                <td><?php echo h($this->Time->format($transportBillDetailRide['TransportBill']['date'], '%d-%m-%Y')); ?>
                    &nbsp;</td>
                <td><?php echo $transportBillDetailRide['Supplier']['code'] ?></td>
                <td><?= $transportBillDetailRide['Supplier']['name'] ?></td>
                <td><?= $transportBillDetailRide['DepartureDestination']['name'] ?></td>
                <td><?php echo $transportBillDetailRide['SupplierFinal']['code'] ?></td>
                <td><?= $transportBillDetailRide['SupplierFinal']['name'] ?></td>
                <td><?= $transportBillDetailRide['ArrivalDestination']['name'] ?></td>
                <td><?= $transportBillDetailRide['TransportBillDetailRides']['nb_trucks'] ?></td>
                <td><?= $transportBillDetailRide['TransportBillDetailRides']['nb_trucks_validated'] ?></td>
                <?php $nbTrucksInstance = $transportBillDetailRide['TransportBillDetailRides']['nb_trucks'] - $transportBillDetailRide['TransportBillDetailRides']['nb_trucks_validated'] ?>
                <td><?php echo $nbTrucksInstance; ?></td>

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
                                <?= $this->Html->link(
                                    '<i class="  fa fa-eye m-r-5" title=""' . __('View detail') . '"></i>',
                                    'javascript:viewDetail(' . $transportBillDetailRide["TransportBillDetailRides"]["id"] . ',' . $transportBillDetailRide['TransportBillDetailRides']['nb_trucks'] . ');',
                                    array('escape' => false, 'class' => 'btn btn-success')
                                ); ?>
                            </li>


                        </ul>
                    </div>



                    <?php /*echo $this->Html->link(
                                '<i class="  fa ti-money" title=""' . __('View Price') . '"></i>',
                                'javascript:viewPrice('.$transportBillDetailRide["TransportBillDetailRides"]["id"].');',
                                // array('action' => 'viewDetail', $transportBillDetailRide['TransportBillDetailRides']['id']),
                                array('escape' => false)
                            ); */
                    ?>


                </td>


            </tr>

        <?php
        }

    }
    ?>

    </tbody>

</table>

<div id ='pageCount' class="hidden">
    <?php
    if ($this->params['paging']['TransportBillDetailRides']['pageCount'] > 1) {
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