<?php

if($selectbox != null){


    ?>
<div class="input select required">
    <label for="CarCarmodelId"><?= __('Model') ?></label>
    <select name="data[Car][carmodel_id]" class="form-control select2 select-model" id="CarCarmodelId" required="required">
        <option value=""><?= __('Select model') ?></option>

<?php 
foreach ($selectbox as $qsKey => $qsData) {
    if($qsKey == $selectedid){
        echo '<option value="'.$qsKey.'" selected>'.$qsData.'</option>';
    }else{
        echo '<option value="'.$qsKey.'">'.$qsData.'</option>';
    }
  
}
?>
    </select>
</div>
<?php }else{ ?>
    <div class="input select required">
    <label for="CarCarmodelId"><?= __('Model') ?></label>
    <select name="data[Car][carmodel_id]" class="form-control select2 select-model" id="CarCarmodelId" required="required">
        <option value=""></option>
   </select>
</div>
<?php }
?>