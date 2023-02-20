<div class="input select required">
    <label for="category"><?= __('Category') ?></label>
    <select name="data[Car][car_category_id]" class="form-control select2" id="category" required="required">
        <option value=""><?= __('Select category') ?></option>

<?php 
foreach ($selectbox as $carCategory) {
if($selectedid == $carCategory['CarCategory']['id']){
echo '<option value="'.$carCategory['CarCategory']['id'].'" selected>'.$carCategory['CarCategory']['name'].'</option>'."\n";
}else{
echo '<option value="'.$carCategory['CarCategory']['id'].'">'.$carCategory['CarCategory']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>