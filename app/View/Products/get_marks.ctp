<div class="input select ">
    <label for="ProductProductMarkId"><?= __('Mark') ?></label>
    <select name="data[Product][product_mark_id]" class="form-control select2" id="ProductProductMarkId" >
        <option value=""><?= __('Select mark') ?></option>

<?php 


foreach ($selectbox as $productMark) {
if($selectedid == $productMark['ProductMark']['id']){
echo '<option value="'.$productMark['ProductMark']['id'].'" selected>'.$productMark['ProductMark']['name'].'</option>'."\n";
}else{
echo '<option value="'.$productMark['ProductMark']['id'].'">'.$productMark['ProductMark']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>