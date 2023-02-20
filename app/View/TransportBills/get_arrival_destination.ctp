<?php
switch ($productTypeId){
    case 1 :
        if($typeRide == 2){

            echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.arrival_destination_id', array(
                    'empty' =>__('Arrival city'),
                    'class' => 'form-control select-search-destination',
                    'label'=>'',
                    'onchange' => 'javascript:getPriceRide(this.id);',
                    'id'=>'arrival_destination'.$i,
                ))."</div>";
        }
        break;
    case 3 :
        echo "<div class='form-group'>" . $this->Form->input('TransportBillDetailRides.'.$i.'.end_date', array(
                'label' => false,
                'placeholder' => 'dd/mm/yyyy hh:mm',
                'type' => 'text',
                'class' => 'form-control datemask',
                'onchange' => 'javascript:calculateStartDate(this.id);',
                'before' => '<label>' . __('End date') . '</label><div class="input-group datetime">
                    <label for="StartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                'after' => '</div>',
                'id' => 'end_date'.$i,
                'allowEmpty' => true,
            )) . "</div>";
        echo "<div class='form-group'>".$this->Form->input('TransportBillDetailRides.'.$i.'.arrival_destination_id', array(
                'empty' =>__('Arrival city'),
                'class' => 'form-control select-search-destination',
                'label'=>'',
                'onchange' => 'javascript:getPriceRide(this.id);',
                'id'=>'arrival_destination'.$i,
            ))."</div>";
        break;
    default:
        break;
}
if($productId == 1){

}
