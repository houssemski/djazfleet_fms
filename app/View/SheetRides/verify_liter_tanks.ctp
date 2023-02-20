<?php


if (isset($literExisted)) {


    ?>
    <div id='consump_tank_div<?php echo $i ?>' class='select-inline consumption'>
        <?php
        echo "<div class='select-inline' >" . $this->Form->input('Consumption.' . $i . '.consumption_liter', array(
                'value'=>$literExisted,
                'label' => __('Consumption liter'),
                'class' => 'form-filter',
                'id' => 'consumption_liter'.$i,
                'onchange' => 'javascript:verifyLiterTanks(this.id);'
            )) . "</div>"; ?>
    </div>

    <div id="code_tank_div<?php echo $i ?>" class="select-inline consumption">
        <div class="input select " >
            <label for="tank<?php echo $i ?>"><?= __('Tanks') ?></label>
            <select name="data[Consumption][<?php echo $i ?>][tank_id]" class="form-filter select3"
                    id="tank<?php echo $i ?>">
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
    <div id='consump_tank_div<?php echo $i ?>' class='select-inline consumption'>
        <?php
        echo "<div class='select-inline' >" . $this->Form->input('Consumption.' . $i . '.consumption_liter', array(
                'value'=>$liter,
                'label' => __('Consumption liter'),
                'class' => 'form-filter',
                'id' => 'consumption_liter'.$i,
                'onchange' => 'javascript:verifyLiterTanks(this.id);'
            )) . "</div>"; ?>
    </div>
    <?php   echo "<div   class='select-inline consumption' id='code_tank_div$i '>" . $this->Form->input('Consumption.' . $i . '.tank_id', array(
            'label' => __('Tanks'),
            'type' => 'select',
            'options' => $tanks,
            'class' => 'form-filter select3',
            'empty' => '',
            'id' => 'tank'.$i,
        )) . "</div>";


}

 ?>