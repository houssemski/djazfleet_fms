<div class="input select ">
    <label for="ProductProductCategoryId"><?= __('Category') ?></label>
    <select name="data[Product][product_category_id]" class="form-control select2" id="ProductProductCategoryId" >
        <option value=""><?= __('Select category') ?></option>
<?php 
foreach ($selectbox as $productCategory) {
if($selectedid == $productCategory['ProductCategory']['id']) {
echo '<option value="'.$productCategory['ProductCategory']['id'].'" selected>'.$productCategory['ProductCategory']['name'].'</option>'."\n";
} else {
echo '<option value="'.$productCategory['ProductCategory']['id'].'">'.$productCategory['ProductCategory']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>