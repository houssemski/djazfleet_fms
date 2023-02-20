<td> <?php
    echo "<div class='form-group'>".$this->Form->input('ContractCarType.' . $i . '.detail_ride_id', array(
            'label' => '',
            'class' => 'form-control select-search-detail-ride',
            'empty'=>'',
            'id'=>'detail_ride'.$i,
        ))."</div>";

    ?></td>

<td><?php
    echo "<div class='form-group'>".$this->Form->input('ContractCarType.' . $i . '.price_ht', array(
            'label' =>'',
            'class' => 'form-control',
            'placeholder'=>__('Enter price ht'),
            'id'=>'price_ht'.$i,
        ))."</div>";

    ?></td>
<td><?php
    echo "<div class='form-group'>" . $this->Form->input('ContractCarType.' . $i . '.pourcentage_price_return', array(
            'label' => '',
            'placeholder' => __('Enter pourcentage price return'),
            'onchange' => 'javascript: calculatePriceReturn();',
            'id' => 'pourcentage'.$i,
            'class' => 'form-control',
        )) . "</div>";

    ?></td>

<td><?php
    echo "<div class='form-group'>".$this->Form->input('ContractCarType.' . $i . '.price_return', array(
            'label' => '',
            'class' => 'form-control',
            'placeholder'=>__('Enter price return'),
            'id'=>'price_return'.$i,
        ))."</div>";
    ?></td>

<td><?php
    echo "<div class='form-group'>" . $this->Form->input('ContractCarType.' . $i . '.date_start', array(
            'label' => '',
            'placeholder' => 'dd/mm/yyyy',
            'type' => 'text',
            'class' => 'form-control datemask',
            'before' => '<label></label><div class="input-group date"><label for="StartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
            'after' => '</div>',
            'id' => 'start_date'.$i
        )) . "</div>";
    ?></td>
<td>
    <?php
    echo "<div class='form-group'>" . $this->Form->input('ContractCarType.' . $i . '.date_end', array(
            'label' => '',
            'placeholder' => 'dd/mm/yyyy',
            'type' => 'text',

            'class' => 'form-control datemask',
            'before' => '<label></label><div class="input-group date"><label for="StartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
            'after' => '</div>',
            'id' => 'end_date'.$i
        )) . "</div>";
    ?>
</td>
<td  style="width: 20px;">
    <button  name="remove" id="<?php echo $i ?>" onclick="removeRide('<?php echo $i ?>');" class="btn btn-danger btn_remove" style="margin-top: 10px;">X</button>
</td>




