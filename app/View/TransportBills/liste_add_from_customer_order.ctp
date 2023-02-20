<?php if (isset($_GET['page'])) { ?>
    <?= $this->Form->input('page', array(
        'id' => 'page',
        'value' =>  $_GET['page'],
        'type' => 'hidden'
    )); ?>
    <?php
    $page = $_GET['page'];
} else { ?>
    <?= $this->Form->input('page', array(
        'id' => 'page',
        'type' => 'hidden'
    )); ?>
    <?php
    $page = 1;
}
$uriParts = explode('?', $_SERVER['REQUEST_URI'], 2);
$url = base64_encode(serialize($uriParts[0]));
$controller = $this->request->params['controller'];
?>
<?= $this->Form->input('url', array(
    'id' => 'url',
    'value' => base64_encode(serialize($uriParts[0])),
    'type' => 'hidden'
)); ?>
<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"                            cellspacing="0" width="100%">

    <tbody id="listeDiv" >

    <?php foreach ($transportBillDetailRides as $transportBillDetailRide): ?>
        <tr id="row<?= $transportBillDetailRide['TransportBillDetailRides']['id'] ?>">

            <td onclick='viewTransportBillDetailRideObservations(<?php  echo $transportBillDetailRide['TransportBillDetailRides']['id'] ?> ,
                    "<?php echo $controller ?>" , "<?php echo $url ?>", "<?php echo $page ?>" )'>

                <input id="idCheck" type="checkbox" class='id'
                       value=<?php echo $transportBillDetailRide['TransportBillDetailRides']['id'] ?>>
            </td>

            <td onclick='viewTransportBillDetailRideObservations(<?php  echo $transportBillDetailRide['TransportBillDetailRides']['id'] ?> ,
                    "<?php echo $controller ?>" , "<?php echo $url ?>", "<?php echo $page ?>" )'>
                <?php echo h($transportBillDetailRide['TransportBillDetailRides']['reference']); ?>   </td>
            <?php if ($transportBillDetailRide['TransportBillDetailRides']['type_ride'] == 2) { ?>
                <td onclick='viewTransportBillDetailRideObservations(<?php  echo $transportBillDetailRide['TransportBillDetailRides']['id'] ?> ,
                        "<?php echo $controller ?>" , "<?php echo $url ?>", "<?php echo $page ?>" )'>
                    <?php echo h($transportBillDetailRide['Departure']['name'] . ' - ' . $transportBillDetailRide['Arrival']['name']); ?>
                    &nbsp;</td>

            <?php } else { ?>
                <td onclick='viewTransportBillDetailRideObservations(<?php  echo $transportBillDetailRide['TransportBillDetailRides']['id'] ?> ,
                        "<?php echo $controller ?>" , "<?php echo $url ?>", "<?php echo $page ?>" )'><?php echo h($transportBillDetailRide['DepartureDestination']['name'] . ' - ' . $transportBillDetailRide['ArrivalDestination']['name']); ?>
                    &nbsp;</td>
            <?php } ?>
            <?php if ($transportBillDetailRide['TransportBillDetailRides']['type_ride'] == 2) { ?>
                <td onclick='viewTransportBillDetailRideObservations(<?php  echo $transportBillDetailRide['TransportBillDetailRides']['id'] ?> ,
                        "<?php echo $controller ?>" , "<?php echo $url ?>", "<?php echo $page ?>" )'><?php echo h($transportBillDetailRide['Type']['name']) ?></td>

            <?php } else { ?>
                <td onclick='viewTransportBillDetailRideObservations(<?php  echo $transportBillDetailRide['TransportBillDetailRides']['id'] ?> ,
                        "<?php echo $controller ?>" , "<?php echo $url ?>", "<?php echo $page ?>" )'><?php echo h($transportBillDetailRide['CarType']['name']) ?></td>

            <?php } ?>
            <?php if ($useRideCategory == '2') { ?>
                <td onclick='viewTransportBillDetailRideObservations(<?php  echo $transportBillDetailRide['TransportBillDetailRides']['id'] ?> ,
                        "<?php echo $controller ?>" , "<?php echo $url ?>", "<?php echo $page ?>" )'>
                    <?php echo h($transportBillDetailRide['RideCategory']['name'])?></td>
            <?php } ?>
            <td onclick='viewTransportBillDetailRideObservations(<?php  echo $transportBillDetailRide['TransportBillDetailRides']['id'] ?> ,
                    "<?php echo $controller ?>" , "<?php echo $url ?>", "<?php echo $page ?>" )'>
                <?php echo h($this->Time->format($transportBillDetailRide['TransportBill']['date'], '%d-%m-%Y')); ?>&nbsp;</td>
            <td onclick='viewTransportBillDetailRideObservations(<?php  echo $transportBillDetailRide['TransportBillDetailRides']['id'] ?> ,
                    "<?php echo $controller ?>" , "<?php echo $url ?>", "<?php echo $page ?>" )'><?php echo h($transportBillDetailRide['Supplier']['name']); ?>&nbsp;</td>
            <td onclick='viewTransportBillDetailRideObservations(<?php  echo $transportBillDetailRide['TransportBillDetailRides']['id'] ?> ,
                    "<?php echo $controller ?>" , "<?php echo $url ?>", "<?php echo $page ?>" )'><?php echo h($transportBillDetailRide['Service']['name']); ?>&nbsp;</td>


            <td onclick='viewTransportBillDetailRideObservations(<?php  echo $transportBillDetailRide['TransportBillDetailRides']['id'] ?> ,
                    "<?php echo $controller ?>" , "<?php echo $url ?>", "<?php echo $page ?>" )'><?php echo h($transportBillDetailRide['SupplierFinal']['name']); ?>&nbsp;</td>
            <td class="right" onclick='viewTransportBillDetailRideObservations(<?php  echo $transportBillDetailRide['TransportBillDetailRides']['id'] ?> ,
                    "<?php echo $controller ?>" , "<?php echo $url ?>", "<?php echo $page ?>" )'><?php echo h($transportBillDetailRide['TransportBillDetailRides']['nb_trucks']); ?></td>
            <td class="right" onclick='viewTransportBillDetailRideObservations(<?php  echo $transportBillDetailRide['TransportBillDetailRides']['id'] ?> ,
                    "<?php echo $controller ?>" , "<?php echo $url ?>", "<?php echo $page ?>" )'><?php echo h($transportBillDetailRide['TransportBillDetailRides']['nb_trucks_validated']); ?></td>

            <td onclick='viewTransportBillDetailRideObservations(<?php  echo $transportBillDetailRide['TransportBillDetailRides']['id'] ?> ,
                    "<?php echo $controller ?>" , "<?php echo $url ?>", "<?php echo $page ?>" )'><?php switch ($transportBillDetailRide['TransportBillDetailRides']['status_id']) {
                    /*
                    1: commandes non validée
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

        </tr>
    <?php endforeach; ?>

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
