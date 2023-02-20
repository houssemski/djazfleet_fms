<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
       width="100%">
    <thead>
    <tr>

        <th><?php echo $this->Paginator->sort('reference', __('Reference')); ?></th>
        <th><?php echo $this->Paginator->sort('TransportBill.order_type', __('Order type')); ?></th>
        <th><?php echo $this->Paginator->sort('detail_ride_id', __('Ride')); ?></th>
        <?php if ($useRideCategory == '2') { ?>
            <th><?php echo $this->Paginator->sort('RideCategory.name', __('Ride category')); ?></th>
        <?php } ?>
        <th><?php echo $this->Paginator->sort('date', __('Date')); ?></th>
        <th><?php echo $this->Paginator->sort('User.first_name', __('Creator')); ?></th>
        <th><?php echo $this->Paginator->sort('', __('Date / Time')); ?></th>
        <th><?php echo $this->Paginator->sort('', __('Observation')); ?></th>
        <th><?php echo $this->Paginator->sort('supplier_id', __('Initial customer')); ?></th>
        <th><?php echo $this->Paginator->sort('supplier_final_id', __('Final customer')); ?></th>
        <th><?php echo $this->Paginator->sort('customer_observation', __('Observation client')); ?></th>
        <th class="actions"><?php echo __('Actions'); ?></th>

    </tr>
    </thead>
    <tbody id="listeDiv">

    <?php foreach ($transportBillDetailRides as $transportBillDetailRide): ?>
        <tr id="row<?= $transportBillDetailRide['TransportBillDetailRides']['id'] ?>">

            <td><?php echo h($transportBillDetailRide['TransportBillDetailRides']['reference']); ?>   </td>
            <td><?php
                $options = array('1'=>__('Order with invoice'), '2'=>__('Order payment cash'));
                switch ($transportBillDetailRide['TransportBill']['order_type']){
                    case 1:
                        echo __('Order with invoice');
                        break;
                    case 2:
                        echo __('Order payment cash');
                        break;
                        default;

                } ?>   </td>
            <?php if($transportBillDetailRide['TransportBillDetailRides']['type_ride']==2){

                $productName =  $transportBillDetailRide['Product']['name'] ;
                $productInputFactors ='';
                $productSelectFactors ='';
                $totalName = $productName;
                if(!empty($transportBillDetailRideInputFactors)){
                    foreach ($transportBillDetailRideInputFactors as $transportBillDetailRideFactor){
                        $productInputFactors =  $transportBillDetailRideFactor['Factor']['name'] . ' : ' .$transportBillDetailRideFactor['TransportBillDetailRideFactor']['factor_value']. ' - ';
                    }
                }
                if(!empty($transportBillDetailRideSelectFactors)){
                    foreach ($transportBillDetailRideSelectFactors as $transportBillDetailRideFactor){
                        $productSelectFactors =  $transportBillDetailRideFactor['Factor']['name'] . ' : ' .$transportBillDetailRideFactor['Factor']['options']. ' - ';
                    }
                }
                if(!empty($productInputFactors)){
                    $totalName = $totalName .' - '.$productInputFactors;
                }
                if(!empty($productSelectFactors)){
                    $totalName = $totalName .' - '.$productSelectFactors;
                }
                if(!empty($transportBillDetailRide['Departure']['name'])){
                    $totalName = $totalName .' - '.$transportBillDetailRide['Departure']['name'];
                }
                if(!empty($transportBillDetailRide['Arrival']['name'])){
                    $totalName = $totalName .' - '.$transportBillDetailRide['Arrival']['name'];
                }
                if($transportBillDetailRide['ProductType']['id']==3){
                    if(!empty($transportBillDetailRide['TransportBillDetailRides']['start_date'])){

                        $totalName = $totalName.' - '.date_format(date_create($transportBillDetailRide['TransportBillDetailRides']['start_date']),"d/m/Y H:i:s");
                    }
                    if(!empty($transportBillDetailRide['TransportBillDetailRides']['nb_hours'])){
                        $totalName = $totalName.' - '.$transportBillDetailRide['TransportBillDetailRides']['nb_hours'].' H ';
                    }

                }
                if($transportBillDetailRide['TransportBillDetailRides']['type_ride']==2){
                    $totalName = $totalName .' - '.$transportBillDetailRide['Type']['name'];
                }else {
                    $totalName = $totalName .' - '.$transportBillDetailRide['CarType']['name'];
                    }
                $data = $totalName;

                ?>
                <td><?php echo h($data); ?>
                    &nbsp;</td>
            <?php } else { ?>
                <td><?php

                    $productName = $transportBillDetailRide['Product']['name'];
                    $productInputFactors ='';
                    $productSelectFactors ='';
                    if(!empty($transportBillDetailRideInputFactors)){
                        foreach ($transportBillDetailRideInputFactors as $transportBillDetailRideFactor){
                            $productInputFactors =  $transportBillDetailRideFactor['Factor']['name'] . ' : ' .$transportBillDetailRideFactor['TransportBillDetailRideFactor']['factor_value']. ' - ';
                        }
                    }
                    if(!empty($transportBillDetailRideSelectFactors)){
                        foreach ($transportBillDetailRideSelectFactors as $transportBillDetailRideFactor){
                            $productSelectFactors =  $transportBillDetailRideFactor['Factor']['name'] . ' : ' .$transportBillDetailRideFactor['Factor']['options']. ' - ';
                        }
                    }
                    if(!empty($productInputFactors)){
                        $totalName = $totalName .' - '.$productInputFactors;
                    }
                    if(!empty($productSelectFactors)){
                        $totalName = $totalName .' - '.$productSelectFactors;
                    }
                    if(!empty($transportBillDetailRide['DepartureDestination']['name'])){
                        $totalName = $totalName .' - '.$transportBillDetailRide['DepartureDestination']['name'];
                    }
                    if(!empty($transportBillDetailRide['ArrivalDestination']['name'])){
                        $totalName = $totalName .' - '.$transportBillDetailRide['ArrivalDestination']['name'];
                    }
                    if($transportBillDetailRide['TransportBillDetailRides']['type_ride']==2){
                        $totalName = $totalName .' - '.$transportBillDetailRide['Type']['name'];
                    }else {
                        $totalName = $totalName .' - '.$transportBillDetailRide['CarType']['name'];
                    }
                    $data = $totalName;
                    echo h($data ); ?>
                    &nbsp;</td>
            <?php }?>


            <?php if ($useRideCategory == '2') { ?>
                <td><?php echo h($transportBillDetailRide['RideCategory']['name']) ?></td>
            <?php } ?>
            <td><?php echo h($this->Time->format($transportBillDetailRide['TransportBill']['date'], '%d-%m-%Y')); ?>
                &nbsp;</td>
            <td><?php echo $transportBillDetailRide['User']['first_name'].' '.$transportBillDetailRide['User']['last_name']; ?>
                &nbsp;</td>
            <td><?php
                    echo __('Programming date').' '. h($this->Time->format($transportBillDetailRide['TransportBillDetailRides']['programming_date'], '%d-%m-%Y'))."<br>".
                 __('Charging hour').' '. h($this->Time->format($transportBillDetailRide['TransportBillDetailRides']['charging_time'], '%H:%M'))."<br>".
                __('Unloading hour').' '. h($this->Time->format($transportBillDetailRide['TransportBillDetailRides']['unloading_date'], '%d-%m-%Y %H:%M'))."<br>";  ?>
                &nbsp;</td>
            <td><?php echo h($transportBillDetailRide['TransportBillDetailRides']['observation_order']); ?>&nbsp;</td>
            <td><?php echo h($transportBillDetailRide['Supplier']['name']); ?>&nbsp;</td>
            <td><?php echo h($transportBillDetailRide['SupplierFinal']['name']); ?>&nbsp;</td>
            <td><?php echo h($transportBillDetailRide['Observation']['customer_observation']); ?>&nbsp;</td>
            <td class="actions">
                <?php if(!empty($transportBillDetailRide['Observation']['cancel_cause_id'])) { ?>
                <?php     echo '<span class="label label-inverse">';
                                                echo __('Canceled') . "</span><br>"  ." ( ". $transportBillDetailRide['CancelCause']['name'] ." )"; ?>
               <?php  } else { ?>
                    <?= $this->Html->link(
                        '<i class=" fa fa-exchange m-r-5" title="' . __('Transform') . '"></i>',
                        array('controller' => 'SheetRides', 'action' => 'add', $transportBillDetailRide['TransportBillDetailRides']['id'],$transportBillDetailRide['Observation']['id'] ,
                            $controller, $url, $page),
                        array('escape' => false)
                    ); ?>

                    <?= $this->Html->link(
                        '<i class=" fa fa-edit m-r-5" title="' . __('Transform') . '"></i>',
                        array('controller' => 'SheetRides', 'action' => 'getSheetsToEdit', $transportBillDetailRide['TransportBillDetailRides']['id'],$transportBillDetailRide['Observation']['id']),
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
    <?php endforeach; ?>

    </tbody>
</table>

