<?php if($suppliers != null){ ?>
<div class="form-group">
    <div class="input select">
        <label for="PriceSupplierId"><?= __("Client") ?></label>
        <select name="data[Price][supplier_id]" class="form-control" id="supplier" onchange="javascript:getPrice();">
            <option value=""><?= __('Select client')  ?></option>
            <?php
            foreach ($suppliers as $qsKey => $qsData) {
               
                    echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
                

            }
            ?>
        </select>
    </div>
</div>
<?php }else{ ?>
<div class="form-group">
    <div class="input select">
        <label for="PriceSupplierId"><?= __("Client") ?></label>
        <select name="data[Price][supplier_id]" class="form-control select-search-client-initial" id="supplier">
            <option value=""><?= __('Select client') ?></option>
        </select>
    </div>
</div>
<?php }
?>