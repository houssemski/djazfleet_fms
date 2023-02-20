<div class="input select required">
    <label for="SheetRideCarTypeId"><?= __('Type') ?></label>
    <select name="data[SheetRide][car_type_id]" class="form-filter select2" id="SheetRideCarTypeId" required="required">
        <option value=""><?= __('Select type') ?></option>

<?php
foreach ($selectbox as $qsKey => $qsData) {
    if($qsKey == $selectedid){
        echo '<option value="'.$qsKey.'" selected>'.$qsData.'</option>'."\n";
    }else{
        echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
    }

}
?>
    </select>
</div>