<?php
echo "<div class ='scroll-block'>";
echo "<div class='lbl2'> <a href='#costContractor$i' data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Cost contractor") . "</a></div>";
echo "<div id='costContractor$i' class='collapse'><br>";
if(Configure::read("gestion_programmation_sous_traitance") == '1'){
echo "<div class='select-inline' >" . $this->Form->input('SheetRideDetailRides.' . $i . '.reservation_cost', array(
    'label' => __('Cost contractor'),
    'class' => 'form-filter',
    'required'=>true,
    'value'=>$subcontractorCost,
    'id'=>'reservation_cost'.$i,
    'type'=>'number'
    )) . "</div>";
}else {
echo "<div class='select-inline' >" . $this->Form->input('SheetRideDetailRides.' . $i . '.reservation_cost', array(
    'label' => __('Cost contractor'),
    'class' => 'form-filter',
    'value'=>$subcontractorCost,
    'id'=>'reservation_cost'.$i,
    'type'=>'number'
    )) . "</div>";
}
echo "</div>";
echo "</div>";