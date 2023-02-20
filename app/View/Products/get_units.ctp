<div class="input select ">
    <label for="ProductProductUnitId"><?= __('Unit') ?></label>
    <select name="data[Product][product_unit_id]" class="form-control select3" id="ProductProductUnitId" >
        <option value=""><?= '' ?></option>

<?php 


foreach ($selectBox as $productUnit) {
if($selectedId == $productUnit['ProductUnit']['id']){
echo '<option value="'.$productUnit['ProductUnit']['id'].'" selected>'.$productUnit['ProductUnit']['name'].'</option>'."\n";
}else{
echo '<option value="'.$productUnit['ProductUnit']['id'].'">'.$productUnit['ProductUnit']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>