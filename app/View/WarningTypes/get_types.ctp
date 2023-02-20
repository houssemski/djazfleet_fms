<div class="input select required">
    <label for="type"><?= __('Warning type') ?></label>
    <select name="data[Warning][warning_type_id]" class="form-filter select2" id="type" required="required">
        <option value=""></option>

        <?php
        foreach ($selectBox as $qsKey => $qsData) {
            if($qsKey == $selectedId){
                echo '<option value="'.$qsKey.'" selected>'.$qsData.'</option>'."\n";
            }else{
                echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
            }

        }
        ?>
    </select>
</div>