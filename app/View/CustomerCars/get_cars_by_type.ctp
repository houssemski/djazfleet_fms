<?php if($selectbox != null){ ?>
<div class="input select required">
    <label for="cars"><?= __('Car') ?></label>
    <select name="data[CuctomerCar][car_id]" class="form-control" id="cars" required="required">
        <option value=""><?= __('Select car') ?></option>

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
    <label for="cars"><?= __('Car') ?></label>
    <select name="data[CuctomerCar][car_id]" class="form-control" id="cars" required="required">
        <option value=""><?= __('Select car') ?></option>
   </select>
</div>
<?php }
?>