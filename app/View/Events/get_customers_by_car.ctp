

<?php 
echo "<div class='form-group'>" . $this->Form->input('Car.vidange_hour', array(
                    'type' => 'hidden',
                    'value' => $vidange_hour,
                    'checked'=>$vidange_hour,
                    'id' => 'vidange_hour'
                )) . "</div>";


if($customers != null){ ?>
<div class="form-group">
    <div class="input select">
        <label for="customers"><?= __("Conductor") ?></label>
        <select name="data[Event][customer_id]" class="form-control select2" id="customers">
            <option value=""><?= __('Select ') . " " . __("Conductor") ?></option>
            <?php
            foreach ($customers as $qsKey => $qsData) {
                if($qsKey == $selected_id){
                    echo '<option value="'.$qsKey.'" selected>'.$qsData.'</option>'."\n";
                }else{
                    echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
                }
            }
            ?>
        </select>
    </div>
</div>
<?php }else{ 
echo "<div class='form-group'>" . $this->Form->input('Car.vidange_hour', array(
                    'type' => 'hidden',
                    'value' => $vidange_hour,
                    'checked'=>$vidange_hour,
                    'id' => 'vidange_hour'
                )) . "</div>";


?>
<div class="form-group">
    <div class="input select">
        <label for="customers"><?= __("Conductor") ?></label>
        <select name="data[Event][customer_id]" class="form-control select2" id="customers">
            <option value=""><?= __('Select ') . " " . __("Conductor") ?></option>
        </select>
    </div>
</div>
<?php }
?>