

<div class="input select required">
    <label for="product"></label>
    <select name="data[Lot][product_id]" class="form-control select-search"  id="product" required="required">

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


