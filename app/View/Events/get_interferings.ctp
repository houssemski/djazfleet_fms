<div class="input select ">
  <?php     if($typeEvent==2) { ?> <label for="type"><?= __('Agency'); ?> </label> <?php } else { ?> <label for="type"><?= __('Interfering'); ?> </label> <?php } ?>
    <select name="data[EventCategoryInterfering][<?php echo $id_int?>][interfering_id<?php echo $i?>]" class="form-control" id="EventCategoryInterferingId">
        <?php  if($typeEvent==2) { ?> <option value=""><?=__('Select agency') ?></option> <?php } else { ?> <option value=""><?=__('Select interfering') ?></option> <?php }
 
foreach ($selectbox as $interfering) {
if($selectedid == $interfering['Interfering']['id']){
echo '<option value="'.$interfering['Interfering']['id'].'" selected>'.$interfering['Interfering']['name'].'</option>'."\n";
}else{
echo '<option value="'.$interfering['Interfering']['id'].'">'.$interfering['Interfering']['name'].'</option>'."\n";
}
}
?>
    </select>
</div>


