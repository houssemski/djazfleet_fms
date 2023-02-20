<?php


if (isset($literExisted)) {


    ?>
    <div id='consump_tank_div' class='col-sm-2 consumption'>
        <?php
        echo "<div class='col-sm-3' >" . $this->Form->input('Consumption.consumption_liter', array(
                'value'=>$literExisted,
                'label' => __('Consumption liter'),
                'class' => 'form-control',
                'id' => 'consumption_liter',
                'onchange' => 'javascript:verifyLiterTanks();'
            )) . "</div>"; ?>
    </div>

    <div id="code_tank_div" class="col-sm-3 consumption">
        <div class="input select " >
            <label for="tank"><?= __('Tanks') ?></label>
            <select name="data[Consumption][tank_id]" class="form-filter select3"
                    id="tank">
                <option value=""><?= __('Select tank') ?></option>

                <?php
                if (!empty($tank)) {
                    foreach ($tank as $tank) {
                        echo '<option value="' . $tank['tank']['id'] . '">' . $tank['tank']['name'] . '</option>' . "\n";
                    }
                }
                ?>

            </select>

        </div>
    </div>

<?php
 } else { ?>
    <div id='consump_tank_div' class='col-sm-2 consumption'>
        <?php
        echo "<div class='col-sm-3' >" . $this->Form->input('Consumption.consumption_liter', array(
                'value'=>$liter,
                'label' => __('Consumption liter'),
                'class' => 'form-control',
                'id' => 'consumption_liter',
                'onchange' => 'javascript:verifyLiterTanks();'
            )) . "</div>"; ?>
    </div>
    <?php   echo "<div   class='col-sm-3 consumption' id='code_tank_div'>" . $this->Form->input('Consumption.tank_id', array(
            'label' => __('Tanks'),
            'type' => 'select',
            'options' => $tanks,
            'class' => 'form-filter select3',
            'empty' => '',
            'id' => 'tank',
        )) . "</div>";


}

 ?>