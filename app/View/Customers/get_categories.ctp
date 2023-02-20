<div class="input select required">
    <label for="CustomerCustomerCategoryId"><?= __('Category') ?></label>
    <select name="data[Customer][customer_category_id]" class="form-control select2" id="CustomerCustomerCategoryId" required="required">
        <option value=""><?= __('Select category') ?></option>

<?php 
foreach ($selectbox as $customerCategory) {
if($selectedid == $customerCategory['CustomerCategory']['id']){
echo '<option value="'.$customerCategory['CustomerCategory']['id'].'" selected>'.$customerCategory['CustomerCategory']['name'].'</option>'."\n";
}else{
echo '<option value="'.$customerCategory['CustomerCategory']['id'].'">'.$customerCategory['CustomerCategory']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>