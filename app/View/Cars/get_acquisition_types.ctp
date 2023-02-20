<div class="input select required">
    <label for="CarAcquisitionTypeId"><?= __('Acquisition type') ?></label>
    <select name="data[Car][acquisition_type_id]" class="form-control select2" id="CarAcquisitionTypeId" >
        <option value=""><?= __('Select type') ?></option>

<?php 
foreach ($selectbox as $acquisitionType) {
if($selectedid == $acquisitionType['AcquisitionType']['id']){
echo '<option value="'.$acquisitionType['AcquisitionType']['id'].'" selected>'.$acquisitionType['AcquisitionType']['name'].'</option>'."\n";
}else{
echo '<option value="'.$acquisitionType['AcquisitionType']['id'].'">'.$acquisitionType['AcquisitionType']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>