<div class="input select required">
    <label for="reason"><?= __('Absence reason') ?></label>
    <select name="data[Absence][absence_reason_id]" class="form-filter select2" id="reason" required="required">
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