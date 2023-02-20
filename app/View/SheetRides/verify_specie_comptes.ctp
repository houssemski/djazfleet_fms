<?php

if (isset($amount)) {
    ?>
    <div id='consump_compte_div<?php echo $i ?>' class='select-inline consumption'>
        <?php   echo "<div class='select-inline' >" . $this->Form->input('Consumption.' . $i . '.species', array(
                'value' => $amount,
                'label' => __('Species'),
                'class' => 'form-filter',
                'id' => 'species' . $i,
                'onchange' => 'javascript:verifySpecieComptes(this.id);'
            )) . "</div>";
        echo "<div style='clear:both; padding-top: 10px;'></div>"; ?>

        <span id='con_compte<?php echo $i ?>'> <p
                style="color: #a94442;">       <?php echo __('The amount of account is below ');
                echo number_format($price, 2, ",", ".") . " " . $this->Session->read("currency"); ?></p></span>
    </div>
    <?php if (Configure::read("gestion_commercial") == '1'  &&
    Configure::read("tresorerie") == '1') { ?>
    <div id="reference_compte_div<?php echo $i ?>" class="select-inline consumption">
        <div class="input select " >
            <label for="compte<?php echo $i ?>"><?= __('Comptes') ?></label>
            <select name="data[Consumption][<?php echo $i ?>][compte_id]" class="form-filter select3"
                <?php if($amount> 0) {?> required="required" <?php  } ?>
                    id="compte<?php echo $i ?>">
                <option value=""><?= __('Select compte') ?></option>

                <?php
                if (!empty($comptes)) {
                    foreach ($comptes as $qsKey => $qsData) {
                        echo '<option value="' . $qsKey . '">' . $qsData . '</option>' . "\n";
                    }
                }
                ?>

            </select>

        </div>
    </div>
        <?php } ?>

<?php } else { ?>
    <div id='consump_compte_div<?php echo $i ?>' class='select-inline consumption'>
        <?php  echo "<div class='select-inline' >" . $this->Form->input('Consumption.' . $i . '.species', array(

                'label' => __('Species'),
                'class' => 'form-filter',
                'id' => 'species' . $i,
                'value' => $price,
                'onchange' => 'javascript:verifySpecieComptes(this.id);'
            )) . "</div>"; ?>

        <span id='con_compte'> </span>
    </div>
   <?php  if (Configure::read("gestion_commercial") == '1'  &&
    Configure::read("tresorerie") == '1') { ?>
    <div id="reference_ccompte_div<?php echo $i ?>" class="select-inline consumption">
        <div class="input select " id='select_compte'>
            <label for="compte<?php echo $i ?>"><?= __('Comptes') ?></label>
            <select name="data[Consumption][<?php echo $i ?>][compte_id]" class="form-filter select3"
                <?php if($price> 0) {?> required="required" <?php  } ?>
                    id="compte<?php echo $i ?>">
                <option value=""><?= __('Select compte') ?></option>

                <?php
                if (!empty($comptes)) {

                    foreach ($comptes as $qsKey => $qsData) {
                        echo '<option value="' . $qsKey . '">' . $qsData . '</option>' . "\n";
                    }
                }
                ?>
            </select>
        </div>
    </div>

<?php } }