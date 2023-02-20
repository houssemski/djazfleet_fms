<div class="input select required">
    <label for="mark"><?= __('Mark') ?></label>
    <select name="data[Car][mark_id]" class="form-control select2" id="mark" required="required">
        <option value=""><?= __('Select mark') ?></option>

        <?php
        foreach ($selectbox as $mark) {
            if ($selectedid == $mark['Mark']['id']) {
                echo '<option value="' . $mark['Mark']['id'] . '" selected>' . $mark['Mark']['name'] . '</option>' . "\n";
            } else {
                echo '<option value="' . $mark['Mark']['id'] . '">' . $mark['Mark']['name'] . '</option>' . "\n";
            }
        }
        ?>
    </select>
</div>