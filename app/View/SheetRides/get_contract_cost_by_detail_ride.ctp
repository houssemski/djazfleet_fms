
<?php
echo "<div class ='scroll-block'>";
echo "<div class='lbl2'> <a href='#costContractor$i' data-toggle='collapse'><i class='fa fa-angle-double-right' style='padding-right: 10px;'></i>" . __("Cost contractor") . "</a></div>";
echo "<div id='costContractor$i' class='collapse'><br>";
if(isset($contract) && empty($contract)){

if(Configure::read("gestion_programmation_sous_traitance") == '1'){
    echo "<div class='select-inline' >" . $this->Form->input('SheetRideDetailRides.' . $i . '.reservation_cost', array(
            'label' => __('Cost contractor'),
            'class' => 'form-filter',
            'required'=>true,
            'id'=>'reservation_cost'.$i,
            'value'=>$contract['ContractCarType']['price_ht'],
            'type'=>'number'
        )) . "</div>";
}else {
    echo "<div class='select-inline' >" . $this->Form->input('SheetRideDetailRides.' . $i . '.reservation_cost', array(
            'label' => __('Cost contractor'),
            'class' => 'form-filter',
            'id'=>'reservation_cost'.$i,
            'value'=>$contract['ContractCarType']['price_ht'],
            'type'=>'number'
        )) . "</div>";
}



}else {
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

}
 ?>
         <div class="input-radio" style="margin: 0 20px;">
                <p class="p-radio"><?php echo __('Price recovered') ?></p>

<input id='price_recovered1<?php echo $i ?>' class="input-radio"
       type="radio" name="data[SheetRideDetailRides][<?php echo $i ?>][price_recovered]"
       value="1" >
<span class="label-radio"><?php echo __('Yes') ?></span>
<input id='price_recovered2<?php echo $i ?>'
       class="input-radio" type="radio" checked='checked'
       name="data[SheetRideDetailRides][<?php echo $i ?>][price_recovered]" value="2">
<span class="label-radio"> <?php echo __('No') ?></span>
</div>
<?php
echo "</div>";
echo "</div>";
?>


