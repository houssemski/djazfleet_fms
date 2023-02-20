<?php
echo "<div class='form-group'>" . $this->Form->input('Promotion.' . $j . '.promotion_pourcentage', array(
        'label' => __('Promotion %'),
        'placeholder' => __('Enter value'),
        'class' => 'form-control',
        'type' => 'number',
        'id' => 'promotion_pourcentage' . $j,
        'onchange' => 'javascript :getPromotionVal(' . $j . '); ',
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('Promotion.' . $j . '.promotion_val', array(
        'label' => __('Promotion valeur'),
        'placeholder' => __('Enter value'),
        'class' => 'form-control',
        'type' => 'number',
        'step'=>'any',
        'id' => 'promotion_val' . $j,
        'onchange' => 'javascript :getPromotionVal(' . $j . '); ',
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('Promotion.' . $j . '.promotion_return', array(
        'label' => __('Promotion retour'),
        'placeholder' => __('Enter value'),
        'class' => 'form-control',
        'type' => 'number',
        'step'=>'any',
        'id' => 'promotion_return' . $j,
        'onchange' => 'javascript :getPromotionVal(' . $j . '); ',
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('Promotion.' . $j . '.start_date', array(
        'label' => '',
        'placeholder' => 'dd/mm/yyyy',
        'type' => 'text',
        'class' => 'form-control datemask',
        'before' => '<label>' . __('Start date') . '</label><div class="input-group date" ><label for="PromotionStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
        'after' => '</div>',
        'id' => 'start_date_promotion' . $j,
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('Promotion.' . $j . '.end_date', array(
        'label' => '',
        'placeholder' => 'dd/mm/yyyy',
        'type' => 'text',
        'class' => 'form-control datemask',
        'before' => '<label>' . __('End date') . '</label><div class="input-group date" ><label for="PromotionStartDate"></label><div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>',
        'after' => '</div>',
        'id' => 'end_date_promotion' . $j,
    )) . "</div>";
?>