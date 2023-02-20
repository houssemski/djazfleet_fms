<?php
if (isset($amount)) {  ?>
    <div id='consump_card_div' class='select-inline consumption'>
        <?php   echo "<div class='select-inline' >" . $this->Form->input('Consumption.species_card', array(
                'value' => $amount,
                'label' => __('Species card'),
                'class' => 'form-filter',
                'id' => 'species_card',
                'onchange' => 'javascript:verifyAmountCards();'
            )) . "</div>";
        echo "<div style='clear:both; padding-top: 10px;'></div>"; ?>

        <span id='con_card'> <p
                style="color: #a94442;">       <?php echo __('The amount of cards is below ');
                echo number_format($price, 2, ",", ".") . " " . $this->Session->read("currency"); ?></p></span>
    </div>
    <div id="reference_card_div" class="select-inline consumption">
        <div class="input select " >
            <label for="card"><?= __('Cards') ?></label>
            <select name="data[Consumption][fuel_card_id]" class="form-filter select3"
            <?php if($amount> 0) {?> required="required" <?php  } ?>
                    id="card">
                <option value=""><?= __('Select card') ?></option>

                <?php
                if (!empty($cards)) {
                    foreach ($cards as $qsKey => $qsData) {
                        echo '<option value="' . $qsKey . '">' . $qsData . '</option>' . "\n";
                    }
                }
                ?>

            </select>

        </div>
    </div>

<?php } else { ?>
    <div id='consump_card_div' class='select-inline consumption'>
        <?php  echo "<div class='select-inline' >" . $this->Form->input('Consumption.species_card', array(

                'label' => __('Species card'),
                'class' => 'form-filter',
                'id' => 'species_card',
                'value' => $price,
                'onchange' => 'javascript:verifyAmountCards();'
            )) . "</div>"; ?>

        <span id='con_card'> </span>
    </div>
    <div id="reference_card_div" class="select-inline consumption">
        <div class="input select " id='select_card'>
            <label for="card"><?= __('Cards') ?></label>
            <select name="data[Consumption][fuel_card_id]" class="form-filter select3"
                <?php if($price> 0) {?> required="required" <?php  } ?>
                    id="card">
                <option value=""><?= __('Select card') ?></option>

                <?php
                if (!empty($cards)) {

                    foreach ($cards as $qsKey => $qsData) {
                        echo '<option value="' . $qsKey . '">' . $qsData . '</option>' . "\n";
                    }
                }
                ?>

            </select>

        </div>
    </div>

<?php }