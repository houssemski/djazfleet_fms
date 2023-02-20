<div class="input select">
    <label for="CarCarmodelId"><?= __('Model') ?></label><select name="data[Cars][carmodel_id]" class="form-filter select2" id="CarCarmodelId">
        <option value=""><?= __('Select model') ?></option>

<?php 
foreach ($selectbox as $qsKey => $qsData) {
  echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
}
?>
    </select>
</div>