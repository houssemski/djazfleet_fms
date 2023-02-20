<div class="input select ">
    <label for="ProductWarehouseId"><?= __('Warehouse') ?></label>
    <select name="data[Product][warehouse_id]" class="form-control select2" id="ProductWarehouseId" >
        <option value=""><?= __('Select parc') ?></option>

<?php 
foreach ($selectbox as $warehouse) {
if($selectedid == $Depot['Warehouse']['id']){
echo '<option value="'.$warehouse['Warehouse']['id'].'" selected>'.$warehouse['Warehouse']['name'].'</option>'."\n";
}else{
echo '<option value="'.$warehouse['Warehouse']['id'].'">'.$warehouse['Warehouse']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>