<div class="input select required">
    <label for="CarFuelId"><?= __('Fuel') ?></label>
    <select name="data[Car][fuel_id]" class="form-control select2" id="CarFuelId" required="required">
        <option value=""><?= __('Select fuel') ?></option>

<?php 
foreach ($selectbox as $Fuel) {
if($selectedid == $Fuel['Fuel']['id']){
echo '<option value="'.$Fuel['Fuel']['id'].'" selected>'.$Fuel['Fuel']['name'].'</option>'."\n";
}else{
echo '<option value="'.$Fuel['Fuel']['id'].'">'.$Fuel['Fuel']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>