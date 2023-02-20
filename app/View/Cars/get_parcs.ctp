<div class="input select required">
    <label for="CarParcId"><?= __('Parc') ?></label>
    <select name="data[Car][parc_id]" class="form-control select2" id="CarParcId" required="required">
        <option value=""><?= __('Select parc') ?></option>

        <?php
        foreach ($selectbox as $Parc) {
            if ($selectedid == $Parc['Parc']['id']) {
                echo '<option value="' . $Parc['Parc']['id'] . '" selected>' . $Parc['Parc']['name'] . '</option>' . "\n";
            } else {
                echo '<option value="' . $Parc['Parc']['id'] . '">' . $Parc['Parc']['name'] . '</option>' . "\n";
            }
        }
        ?>
    </select>
</div>