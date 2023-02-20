<div class="input select required">
    <label for="DestinationWilayaId"><?= __('Name').' '.__('Wilaya') ?></label>
    <select name="data[Destination][wilaya_id]" class="form-control select2" id="DestinationWilayaId" required="required">
        <option value=""><?= __('Select wilaya') ?></option>

<?php 
foreach ($selectbox as $Wilaya) {
if($selectedid == $Wilaya['Wilaya']['id']){
echo '<option value="'.$Wilaya['Wilaya']['id'].'" selected>'.$Wilaya['Wilaya']['name'].'</option>'."\n";
}else{
echo '<option value="'.$Wilaya['Wilaya']['id'].'">'.$Wilaya['Wilaya']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>