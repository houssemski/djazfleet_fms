<?php
switch ($productTypeId){
    case 2 :
        echo "<br/>";
        echo '<div class="lbl1 required" style="display: inline-block; width: 150px;"><label>' . __("Car required");
        echo "</div></label>";
        $options = array('1' => __('Yes'), '2' => __('No'));
        $attributes = array('legend' => false, 'value' => 2);
        echo $this->Form->radio('Product.car_required', $options, $attributes) . "</div>";
        echo "<br/>";
        echo "<br/>";
        break;

    case 3 :
        echo "<br/>";
        echo '<div class="lbl1 required" style="display: inline-block; width: 150px;"><label>' . __("Nb hours required");
        echo "</div></label>";
        $options = array('1' => __('Yes'), '2' => __('No'));
        $attributes = array('legend' => false, 'value' => 2,'class'=>'rButton');
        echo $this->Form->radio('Product.nb_hours_required', $options, $attributes) . "</div>";
        echo "<br/>";
        echo "<br/>";

        echo "<div class='form-group' id='nb-hours-div' style='display: none'>" . $this->Form->input('Product.nb_hours', array(
                'label' => __('Nb hours'),
                'class' => 'form-control ',
            )) . "</div>";
        echo "<br/>";
        echo '<div class="lbl1 required" style="display: inline-block; width: 150px;"><label>' . __("Car required");
        echo "</div></label>";
        $options = array('1' => __('Yes'), '2' => __('No'));
        $attributes = array('legend' => false, 'value' => 2);
        echo $this->Form->radio('Product.car_required', $options, $attributes) . "</div>";
        echo "<br/>";
        echo "<br/>";
        break;

}
