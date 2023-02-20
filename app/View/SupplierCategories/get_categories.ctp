<?php
/** @var $selectBox array */
/** @var $selectedId int */
?>
<div class="input select">
    <label for="SupplierSupplierCategoryId"><?= __('Category') ?></label>
    <select name="data[Supplier][supplier_category_id]" class="form-control select2 select2-hidden-accessible"
            id="SupplierSupplierCategoryId" tabindex="-1" aria-hidden="true">
        <option value=""></option>
        <?php
        foreach ($selectBox as $supplierCategory) {
            if($selectedId == $supplierCategory['SupplierCategory']['id']){
                echo '<option value="'.$supplierCategory['SupplierCategory']['id'].'" selected>'.$supplierCategory['SupplierCategory']['name'].'</option>'."\n";
            }else{
                echo '<option value="'.$supplierCategory['SupplierCategory']['id'].'">'.$supplierCategory['SupplierCategory']['name'].'</option>'."\n";
            }
        }
        ?>
    </select>
</div>