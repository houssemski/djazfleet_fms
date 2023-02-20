<div class="input select ">
    <label for="ProductProductFamilyId"><?= __('Family') ?></label>
    <select name="data[Product][product_family_id]" class="form-control select2" id="ProductProductFamilyId" >
        <option value=""><?= __('Select family') ?></option>

<?php 


foreach ($selectbox as $productFamily) {
if($selectedid == $productFamily['ProductFamily']['id']){
echo '<option value="'.$productFamily['ProductFamily']['id'].'" selected>'.$productFamily['ProductFamily']['name'].'</option>'."\n";
}else{
echo '<option value="'.$productFamily['ProductFamily']['id'].'">'.$productFamily['ProductFamily']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>