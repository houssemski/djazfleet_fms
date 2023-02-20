<div class="input select">
    <label for="CustomerGroupId"><?= __('Group') ?></label>
    <select name="data[Customer][customer_group_id]" class="form-control select2" id="CustomerGroupId">
        <option value=""><?= __('Select group') ?></option>

<?php 
foreach ($selectbox as $Group) {
if($selectedid == $Group['CustomerGroup']['id']){
echo '<option value="'.$Group['CustomerGroup']['id'].'" selected>'.$Group['CustomerGroup']['name'].'</option>'."\n";
}else{
echo '<option value="'.$Group['CustomerGroup']['id'].'">'.$Group['CustomerGroup']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>