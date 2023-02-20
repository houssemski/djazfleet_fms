<div class="input select required">
    <label for="CarCarTypeId"><?= __('Type') ?></label>
    <select name="data[Car][car_type_id]" class="form-control" id="CarCarTypeId" required="required">
        <option value=""><?= __('Select type') ?></option>

<?php 
foreach ($selectbox as $carType) {
if($selectedid == $carType['CarType']['id']){
echo '<option value="'.$carType['CarType']['id'].'" selected>'.$carType['CarType']['name'].'</option>'."\n";
}else{
echo '<option value="'.$carType['CarType']['id'].'">'.$carType['CarType']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>