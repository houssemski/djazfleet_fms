<div class="input select">
    <label for="CustomerZoneId"><?= __('Zone') ?></label>
    <select name="data[Customer][zone_id]" class="form-control select2" id="CustomerZoneId">
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