<?php

if($selectbox != null){ ?>
<div class="input select required">
    <label for="DestinationDairaId"><?= __('Name').' '.__('Daira') ?></label>
    <select name="data[Destination][daira_id]" class="form-control select2" id="DestinationDairaId" required="required">
        <option value=""><?= __('Select daira') ?></option>

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
<?php }else{ ?>
    <div class="input select required">
    <label for="DestinationDairaId"><?= __('Name').' '.__('Daira')  ?></label>
    <select name="data[Destination][daira_id]" class="form-control" id="DestinationDairaId" required="required">
        <option value=""></option>
   </select>
</div>
<?php }
?>