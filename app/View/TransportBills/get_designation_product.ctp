<?php
if($productId !=1){
    echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.designation',
            array(
                'label' => '',
                'value' => $product['Product']['name'],
                'id' => 'designation'.$i,
                'class' => 'form-control',
            )) . "</div>";
}else {
if($typeRide == 1){

    if(!empty($detailRide)){
        echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.designation',
                array(
                    'label' => '',
                    'value' => $detailRide['DepartureDestination']['name'] .' - '.$detailRide['ArrivalDestination']['name'].' - '.$detailRide['CarType']['name'],
                    'id' => 'designation'.$i,
                    'class' => 'form-control',
                )) . "</div>";
    }else {
        echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.designation',
                array(
                    'label' => '',
                    'id' => 'designation'.$i,
                    'class' => 'form-control',
                )) . "</div>";
    }

}else {
    if(!empty($departure) && !empty($arrival) && !empty($carType)) {
    echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.designation',
            array(
                'label' => '',
                'value' => $departure['Destination']['name'] .' - '.$arrival['Destination']['name'].' - '.$carType['CarType']['name'],
                'id' => 'designation'.$i,
                'class' => 'form-control',
            )) . "</div>";
    }else {
        echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$i.'.designation',
                array(
                    'label' => '',
                    'id' => 'designation'.$i,
                    'class' => 'form-control',
                )) . "</div>";
    }
}
}
