<div class="input select ">
    <label for="CarGroupId"><?= __('Group') ?></label>
    <select name="data[Car][car_group_id]" class="form-control select2" id="CarGroupId" >
        <option value=""><?= __('Select group') ?></option>

<?php 
foreach ($selectbox as $group) {
if($selectedid == $group['CarGroup']['id']){
echo '<option value="'.$group['CarGroup']['id'].'" selected>'.$group['CarGroup']['name'].'</option>'."\n";
}else{
echo '<option value="'.$group['CarGroup']['id'].'">'.$group['CarGroup']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>