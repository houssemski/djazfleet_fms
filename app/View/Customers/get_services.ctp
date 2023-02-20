<div class="input select ">
    <label for="CustomerServiceId"><?= __('Service') ?></label>
    <select name="data[Customer][service_id]" class="form-control select2" id="CustomerServiceId" >
        <option value=""><?= __('Select affiliate') ?></option>

<?php 
foreach ($selectbox as $Service) {
if($selectedid == $Service['Service']['id']){
echo '<option value="'.$Service['Service']['id'].'" selected>'.$Service['Service']['name'].'</option>'."\n";
}else{
echo '<option value="'.$Service['Service']['id'].'">'.$Service['Service']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>

