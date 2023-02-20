<?php
/** @var $selectbox array */
/** @var $selectedid int */
?>
<div class="input select required">
    <label for="supplier"><?= __('Client') ?></label>
    <?php
    if(!isset($idSelect) || $idSelect == null){
        $idSelect = "supplier";
    }
    ?>
    <select name="data[Bill][supplier_id]" class="form-control select-search" id="<?= $idSelect ?>" >
        <option value=""></option>

        <?php
        foreach ($selectbox as $supplier) {
            if($selectedid == $supplier['Supplier']['id']){
                echo '<option value="'.$supplier['Supplier']['id'].'" selected>'.$supplier['Supplier']['name'].'</option>'."\n";
            }else{
                echo '<option value="'.$supplier['Supplier']['id'].'">'.$supplier['Supplier']['name'].'</option>'."\n";
            }
        }
        ?>
    </select>
</div>