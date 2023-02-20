<div class="input select">
    <label for="CustomerCarZoneId"><?= __('Zone') ?></label>
    <select name="data[CustomerCar][zone_id]" class="form-control select2" id="CustomerCarZoneId">
        <option value=""><?= __('Select zone') ?></option>

<?php 
foreach ($selectbox as $zone) {
if($selectedid == $zone['Zone']['id']){
echo '<option value="'.$zone['Zone']['id'].'" selected>'.$zone['Zone']['name'].'</option>'."\n";
}else{
echo '<option value="'.$zone['Zone']['id'].'">'.$zone['Zone']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>