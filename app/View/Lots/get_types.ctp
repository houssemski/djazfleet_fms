<div class="input select ">
    <label for="LotLotTypeId"><?= __('Type') ?></label>
    <select name="data[Lot][lot_type_id]" class="form-control select2" id="LotLotTypeId" >
        <option value=""><?= '' ?></option>
<?php 
foreach ($selectBox as $type) {
if($selectedId == $type['LotType']['id']) {
echo '<option value="'.$type['LotType']['id'].'" selected>'.$type['LotType']['name'].'</option>'."\n";
} else {
echo '<option value="'.$type['LotType']['id'].'">'.$type['LotType']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>