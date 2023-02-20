<td>

<div  class="form-group ">
    <div class="input select required ">
        <label for="category"><?php echo __('Ride category')?></label>
        <select name="data[PriceRideCategory][<?php echo $item ?>][ride_category_id]" required="required" id="ride_category"  class="form-control select2">
            <option value=""><?= __('Select category')  ?></option>
            <?php
            foreach ($rideCategories as $qsKey => $qsData) {
                echo '<option value="'.$qsKey.'">'.$qsData.'</option>'."\n";
            }
            ?>
</select>
    </div>
</div>

<?php

echo "<div class='form-group' id='price-div'>" . $this->Form->input('PriceRideCategory.'.$item.'.price_ht', array(
    'label' => __('Price HT').' '.__('Day'),
    'placeholder' => __('Entrer prix HT'),
    'id' => 'price_ht',
    'class' => 'form-control',
    )) . "</div>";
if($paramPriceNight == 1) {
    echo "<div class='form-group' >" . $this->Form->input('PriceRideCategory.' . $item . '.price_ht_night', array(
            'label' => __('Price HT') . ' ' . __('Night'),
            'placeholder' => __('Entrer price HT'),
            // 'onchange' => 'javascript: calculatePriceReturn();',
            'id' => 'price_ht_night',
            'class' => 'form-control',
        )) . "</div>";
}
echo "<div class='form-group' id='price-div'>" . $this->Form->input('PriceRideCategory.'.$item.'.pourcentage_price_return', array(
    'label' => __('Pourcentage price return (%)'),
    'placeholder' => __('Enter pourcentage price return'),
    'onchange' => 'javascript: calculatePriceReturn();',
    'id' => 'pourcentage',
    'class' => 'form-control',
    )) . "</div>";

echo "<div class='form-group' id='price-div'>" . $this->Form->input('PriceRideCategory.'.$item.'.price_return', array(
    'label' => __('Price return'),
    'placeholder' => __('Enter price return'),
    'id' => 'price_return',
    'class' => 'form-control',
    )) . "</div>";

echo "<div class='form-group' >" . $this->Form->input('PriceRideCategory.' . $item . '.theoretical_amount_charges', array(
        'label' => __('Theoretical amount of charges'),
        'placeholder' => __('Enter theoretical amount of charges'),
        'id' => 'theoretical_amount_charges',
        'class' => 'form-control',
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('PriceRideCategory.' . $item . '.start_date', array(
                                    'label' => '',
                                    'placeholder' => 'dd/mm/yyyy',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label>' . __('Start date') . '</label><div class="input-group date" id="circulation_date"><label for="PriceStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'start_date'.$item,
                                )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('PriceRideCategory.' . $item . '.end_date', array(
                                    'label' => '',
                                    'placeholder' => 'dd/mm/yyyy',
                                    'type' => 'text',
                                    'class' => 'form-control datemask',
                                    'before' => '<label>' . __('End date') . '</label><div class="input-group date" id="circulation_date"><label for="PriceEndDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
                                    'after' => '</div>',
                                    'id' => 'end_date'.$item,
                                )) . "</div>";


	
	
	?>
    </td>
<td class="td_tab"><button style="margin-left: 40px;" name="remove" id="<?php echo $item-1;?>" onclick="remove('<?php echo $item-1;?>');" class="btn btn-danger btn_remove">X</button></td>