<div id='consump_card_div'class='select-inline'>
    <?php

    echo "<div class='select-inline' >" . $this->Form->input('SheetRide.species_card', array(

            'label' => __('Species card'),
            'class' => 'form-filter',
            'id' => 'species_card',
            'onchange' => 'javascript:verifyAmountCards(),addRadioBoxChecked(this.id);'
        )) . "</div>"; ?>
</div>
<div id="reference_card_div" class="select-inline">
    <div class="input select " id='select_card'>
        <label for="card_id"><?=__('Cards')?></label>
        <select name="data[SheetRide][card_id]" class="form-filter selectCoupon"  id="card_id"  >
            <option value=""><?=__('Select card')?></option>

            <?php
            foreach ($cards as $qsKey => $qsData) {
                echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
            }
            ?>

        </select>

    </div>
</div>