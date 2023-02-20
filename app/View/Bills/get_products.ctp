<?php if ($type == BillTypesEnum::exit_order ||
$type == BillTypesEnum::delivery_order ||
$type == BillTypesEnum::return_supplier ||
$type == BillTypesEnum::reintegration_order
) {
if($usePurchaseBill ==1) { ?>

    <div class="input select required">
    <label for="product<?php echo $i; ?>"></label>
    <select name="data[BillProduct][<?php echo $i; ?>][product_id]" class="form-control select-search"
            id="product<?php echo $i; ?>" onchange="javascript: getLotsByProduct(this.id);setCurrentProductQty(this.id);" required="required">

<?php
foreach ($selectBox as $qsKey => $qsData) {
    if($qsKey == $selectedId){
        echo '<option value="'.$qsKey.'" selected>'.$qsData.'</option>'."\n";
    }else{
        echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
    }
 }
?>
    </select>
</div>


<?php
}else { ?>

<div class="input select required">
    <label for="product<?php echo $i; ?>"></label>
    <select name="data[BillProduct][<?php echo $i; ?>][product_id]" class="form-control select-search"
            id="product<?php echo $i; ?>" onchange="javascript:getLotsByProduct(this.id); getQuantityMaxByProduct(this.id);setCurrentProductQty(this.id);" required="required">

<?php
foreach ($selectBox as $qsKey => $qsData) {
    if($qsKey == $selectedId){
        echo '<option value="'.$qsKey.'" selected>'.$qsData.'</option>'."\n";
    }else{
        echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
    }
}
?>
    </select>
</div>



<?php    }
}else {
    if($usePurchaseBill ==1){ ?>

        <div class="input select required">
            <label for="product<?php echo $i; ?>"></label>
            <select name="data[BillProduct][<?php echo $i; ?>][product_id]" class="form-control select-search"
                    id="product<?php echo $i; ?>" onchange="javascript:getLotsByProduct(this.id);setCurrentProductQty(this.id);" required="required">

                <?php
                foreach ($selectBox as $qsKey => $qsData) {
                    if($qsKey == $selectedId){
                        echo '<option value="'.$qsKey.'" selected>'.$qsData.'</option>'."\n";
                    }else{
                        echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
                    }
                }
                ?>
            </select>
        </div>
 <?php
    }else { ?>
        <div class="input select required">
            <label for="product<?php echo $i; ?>"></label>
            <select name="data[BillProduct][<?php echo $i; ?>][product_id]" class="form-control select-search"
                    id="product<?php echo $i; ?>" onchange="javascript:getLotsByProduct(this.id); calculPrice(this.id);setCurrentProductQty(this.id);" required="required">

                <?php
                foreach ($selectBox as $qsKey => $qsData) {
                    if($qsKey == $selectedId){
                        echo '<option value="'.$qsKey.'" selected>'.$qsData.'</option>'."\n";
                    }else{
                        echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
                    }
                }
                ?>
            </select>
        </div>

<?php } }?>



