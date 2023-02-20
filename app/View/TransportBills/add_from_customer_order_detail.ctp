

<h4 class="page-title"> <?= __('Add sheet ride (travel)'); ?></h4>
<div class="row">
    <!-- BASIC WIZARD -->
    <div class="col-lg-12">
        <div class="card-box p-b-20">
            <?php echo $this->Form->create('TransportBill', array(
                'url' => array(
                    'action' => 'addFromCustomerOrderDetail'
                ),
                'novalidate' => true,
                'id' => 'searchKeyword'
            )); ?>
            <label style="float: right;">
                <input id='keyword' type="text" name="keyword" id="keyword" class="form-control"
                       placeholder= <?= __("Search"); ?>>
            </label>
            <?php echo $this->Form->end(); ?>
<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
       width="100%">
    <thead>
    <tr>
        <th><?= $this->Paginator->sort('User.first_name', __('Creator')) ?></th>
        <th><?= $this->Paginator->sort('date', __('Date')) ?></th>
        <th><?= $this->Paginator->sort('Supplier.name',  __('Initial customer')) ?></th>
        <th><?= $this->Paginator->sort('TransportBill.order_type',  __('Order type')) ?></th>
        <th><?= $this->Paginator->sort('DepartureDestination.name', __('Rides')) ?></th>
        <th><?= $this->Paginator->sort('delivery_with_return', __('Type mission')) ?></th>
        <th><?= $this->Paginator->sort('designation', __('Designation')) ?></th>

        <th><?= $this->Paginator->sort('unit_price', __('Unit price')) ?></th>
        <th><?= $this->Paginator->sort('programming_date',__('Charging date').' / '.__('Unloading date')) ?></th>
        <th><?= $this->Paginator->sort('observation', __('Observation')) ?></th>

        <th class="actions"><?php echo __('Actions'); ?></th>

    </tr>
    </thead>
    <tbody id="listeDiv">

    <?php
    foreach ($transportBillDetailRides as $transportBillDetailRide){ ?>
        <tr id="row<?= $transportBillDetailRide['TransportBillDetailRides']['id'] ?>">
            <td><?= $transportBillDetailRide['User']['first_name'].' '.$transportBillDetailRide['User']['last_name'] ?></td>

            <td><?php echo h($this->Time->format($transportBillDetailRide['TransportBill']['date'], '%d-%m-%Y')); ?>&nbsp;</td>
            <td><?= $transportBillDetailRide['Supplier']['name'] ?></td>
            <td><?php
                switch ($transportBillDetailRide['TransportBill']['order_type']){
                    case 1:
                        echo __('Order with invoice');
                        break;
                    case 2:
                        echo __('Order payment cash');
                        break;
                    default;

                } ?>   </td>
            <?php if($transportBillDetailRide['TransportBillDetailedRides']['type_ride'] ==1){ ?>
                <td><?= $transportBillDetailRide['DepartureDestination']['name'] .'-'.$transportBillDetailRide['ArrivalDestination']['name'].'-'.$transportBillDetailRide['CarType']['name']
                    ?></td>
            <?php } else { ?>
                <td><?= $transportBillDetailRide['Departure']['name'].'-'.$transportBillDetailRide['Arrival']['name'].'-'.$transportBillDetailRide['Type']['name'] ?></td>
            <?php } ?>
            <td><?php
                $options = array('1' => __('Simple delivery'), '2' => __('Simple return'), '3' => __('Delivery / Return'));
                switch ($transportBillDetailRide['TransportBillDetailedRides']['delivery_with_return']){
                    case 1:
                        echo __('Simple delivery');
                        break;
                    case 2:
                        echo __('Simple return');
                        break;
                    case 3:
                        echo __('Delivery / Return');
                        break;
                    default;

                } ?>   </td>
            <td><?= $transportBillDetailRide['TransportBillDetailedRides']['designation'] ?></td>
            <td><?= $transportBillDetailRide['TransportBillDetailedRides']['unit_price'] ?></td>
            <td><?php echo h($this->Time->format($transportBillDetailRide['TransportBillDetailedRides']['programming_date'], '%d-%m-%Y') .' '
                        .$this->Time->format($transportBillDetailRide['TransportBillDetailedRides']['charging_time'], '%H:%M')).'</br>';
                echo h($this->Time->format($transportBillDetailRide['TransportBillDetailedRides']['unloading_date'], '%d-%m-%Y %H:%M'));
                ?>
            </td>

            <td><?= $transportBillDetailRide['TransportBillDetailedRides']['observation_order'] ?></td>

            <td class="actions">
                <?php if(!empty($transportBillDetailRide['Observation']['cancel_cause_id'])) { ?>
                    <?php     echo '<span class="label label-inverse">';
                    echo __('Canceled') . "</span><br>"  ." ( ". $transportBillDetailRide['CancelCause']['name'] ." )"; ?>
                <?php  } else { ?>
                    <?= $this->Html->link(
                        '<i class=" fa fa-exchange m-r-5" title="' . __('Transform') . '"></i>',
                        array('controller' => 'SheetRides', 'action' => 'add', $transportBillDetailRide['TransportBillDetailRides']['id'],!empty($transportBillDetailRide['Observation']['id']) ? $transportBillDetailRide['Observation']['id'] : 'null' ,
                            'null' ,'null','null',$transportBillDetailRide['TransportBillDetailedRides']['id']),
                        array('escape' => false)
                    ); ?>


                    <?= $this->Html->link(
                        '<i class=" fa fa-search m-r-5" title="' . __('Search') . '"></i>',
                        array('controller' => 'SheetRides', 'action' => 'searchCarMoreNear', $transportBillDetailRide['TransportBillDetailRides']['id']),
                        array('escape' => false)
                    ); ?>
                <?php   }?>

            </td>
        </tr>
    <?php } ?>

    </tbody>
</table>
        </div>
    </div>
</div>

<?php $this->start('script'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>
<?= $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js'); ?>
<?= $this->Html->script('plugins/datetimepicker/moment-with-locales.min.js'); ?>
<?= $this->Html->script('plugins/datetimepicker/bootstrap-datetimepicker.min.js'); ?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>


<script type="text/javascript">
    $(document).ready(function () {
        $("#keyword").keypress(function (e) {
            if (e.which == 13) {

                $('#searchKeyword').submit();
            }
        });
    });


</script>
<?php $this->end(); ?>
