<?php

if($relationWithPark ==1){
    echo "<div >" . $this->Form->input('TransportBillDetailRides.'.$num.'.status_id',
            array(
                'id' => 'status'.$num,
                'type' => 'hidden',
                'value' => 1,
            )) . "</div>";
    echo '<span class="label label-danger position-status">';
    echo __('Not validated') . "</span>";

} else {
    $statuses = array('1'=>__('Not validated'),'3'=>__('Validated'));
    echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$num.'.status_id',
            array(
                'options'=>$statuses,
                'class' => 'form-control select-search',
                'id' => 'status'.$num,
                'value' => $statusId,
            )) . "</div>";
}
