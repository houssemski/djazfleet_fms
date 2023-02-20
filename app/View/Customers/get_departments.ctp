<div class="input select ">
    <label for="CustomerDepartmentId"><?= __('Department') ?></label>
    <select name="data[Customer][department_id]" class="form-control select2" id="CustomerDepartmentId" >
        <option value=""><?= __('Select department') ?></option>

<?php 
foreach ($selectbox as $Department) {
if($selectedid == $Department['Department']['id']){
echo '<option value="'.$Department['Department']['id'].'" selected>'.$Department['Department']['name'].'</option>'."\n";
}else{
echo '<option value="'.$Department['Department']['id'].'">'.$Department['Department']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>