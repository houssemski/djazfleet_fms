
<table   id='dynamic_field<?php echo $num?>' style='width: 100%;'>
    <?php
    $i = 1;
    if($fieldMarchandiseRequired ==1){

        if (!empty($selectedMarchandises)){
            echo "<div class='select-inline'>" . $this->Form->input('nb_marchandise', array(
                    'label' => __(''),
                    'type' => 'hidden',
                    'class' => 'form-filter',
                    'id' => 'nb_marchandise'.$num,
                    'value'=>$nbMarchandise
                )) . "</div>";
            foreach ($selectedMarchandises as $selectedMarchandise){?>

                <tr id="row<?php echo $num?><?php echo $i?>" style="height: 70px;">
                    <td id='marchandise-quantity<?php echo $i ?>'  style="width: 50%;">
                        <?php

                        echo "<div class='select-inline' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.id', array(
                                'label' => __(''),
                                'id' => 'sheetRideDetailRideMarchandiseId'.$num.$i,
                                'value'=>$selectedMarchandise['SheetRideDetailRideMarchandise']['id'],
                                'class' => 'form-filter'
                            )) . "</div>";
                        echo "<div class='select-inline small-select' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.marchandise_id', array(
                                'label' => __(''),
                                'empty' => '',
                                'id' => 'marchandise'.$num.$i,
                                'options' => $marchandises,
                                'required'=>true,
                                'onchange'=>'javascript : getWeightByMarchandise(this.id,'.$num.','.$i.');',
                                'value'=>$selectedMarchandise['SheetRideDetailRideMarchandise']['marchandise_id'],
                                'class' => 'form-filter select3'
                            )) . "</div>";

                        echo "<div class='select-inline' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.quantity', array(
                                'label' => __(''),
                                'placeholder' => __('Enter quantity'),
                                'id' => 'quantity'.$num.$i,
                                'required'=>true,
                                'onchange'=>'javascript : verifyQuantity(this.id,'.$num.','.$i.');',
                                'value'=>$selectedMarchandise['SheetRideDetailRideMarchandise']['quantity'],
                                'class' => 'form-filter'
                            )) . "</div>";
                        ?>
                        <div id='weight-div<?php echo $num?><?php echo $i?>'>
                            <?php
                            echo "<div class='select-inline' style='width: 24%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.weight_palette', array(
                                    'label' => __(''),
                                    'placeholder' => __('Enter weight truck'),
                                    'id' => 'weight_palette'.$num.$i,
                                    'value'=>$selectedMarchandise['Marchandise']['weight_palette'],
                                    'type'=>'hidden',
                                    'class' => 'form-filter'
                                )) . "</div>";

                            echo "<div class='select-inline' style='width: 24%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.weight', array(
                                    'label' => __(''),
                                    'placeholder' => __('Enter weight truck'),
                                    'id' => 'weight'.$num.$i,
                                    'value'=>$selectedMarchandise['Marchandise']['weight'],
                                    'type'=>'hidden',
                                    'class' => 'form-filter'
                                )) . "</div>";
                            ?>
                        </div>
                    </td>

                    <?php if($i==1) {?>
                        <td class="td_tab">
                            <button style="margin-left: 0px;" type='button' name='add' id='add<?php echo $i?>' onclick="addOtherMarchandises(<?php echo $i?>, <?php echo $num?>)" class='btn btn-success add_marchandise'><?=__('Add more')?></button>
                        </td>
                    <?php } ?>

                </tr>
                <?php
                $i++;
            }
        } else {
            echo "<div class='select-inline'>" . $this->Form->input('nb_marchandise', array(
                    'label' => __(''),
                    'type' => 'hidden',
                    'class' => 'form-filter',
                    'id' => 'nb_marchandise'.$num,
                    'value'=>1
                )) . "</div>";

            ?>

            <table   id='dynamic_field<?php echo $num?>' style='width: 100%;'>
                <tr id="row<?php echo $num?><?php echo $i?>" style="height: 70px;">
                    <td id='marchandise-quantity<?php echo $i ?>'  style="width: 50%;">
                        <?php
                        echo "<div class='select-inline small-select' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.marchandise_id', array(
                                'label' => __(''),
                                'empty' => '',
                                'id' => 'marchandise'.$num.$i,
                                'options' => $marchandises,
                                'required'=>true,
                                'onchange'=>'javascript : getWeightByMarchandise(this.id,'.$num.','.$i.');',
                                'class' => 'form-filter select3'
                            )) . "</div>";

                        echo "<div class='select-inline' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.quantity', array(
                                'label' => __(''),
                                'placeholder' => __('Enter quantity'),
                                'id' => 'quantity'.$num.$i,
                                'required'=>true,
                                'onchange'=>'javascript : verifyQuantity(this.id,'.$num.','.$i.');',
                                'class' => 'form-filter'
                            )) . "</div>";
                        ?>
                        <div id='weight-div<?php echo $num?><?php echo $i?>'>
                        </div>
                    </td>


                    <td class="td_tab">
                        <button  style="margin-left: 0px;" type='button' name='add' id='add<?php echo $i?>' onclick="addOtherMarchandises(<?php echo $i?>, <?php echo $num?>)" class='btn btn-success add_marchandise'><?=__('Add more')?></button>
                    </td>

                </tr>
            </table>

        <?php   }
    }else {
    if (!empty($selectedMarchandises)){
        echo "<div class='select-inline'>" . $this->Form->input('nb_marchandise', array(
                'label' => __(''),
                'type' => 'hidden',
                'class' => 'form-filter',
                'id' => 'nb_marchandise'.$num,
                'value'=>$nbMarchandise
            )) . "</div>";
        foreach ($selectedMarchandises as $selectedMarchandise){?>

            <tr id="row<?php echo $num?><?php echo $i?>" style="height: 70px;">
                <td id='marchandise-quantity<?php echo $i ?>'  style="width: 50%;">
                    <?php

                    echo "<div class='select-inline' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.id', array(
                            'label' => __(''),
                            'id' => 'sheetRideDetailRideMarchandiseId'.$num.$i,
                            'value'=>$selectedMarchandise['SheetRideDetailRideMarchandise']['id'],
                            'class' => 'form-filter'
                        )) . "</div>";
                    echo "<div class='select-inline small-select' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.marchandise_id', array(
                            'label' => __(''),
                            'empty' => '',
                            'id' => 'marchandise'.$num.$i,
                            'options' => $marchandises,
                            'onchange'=>'javascript : getWeightByMarchandise(this.id,'.$num.','.$i.');',
                            'value'=>$selectedMarchandise['SheetRideDetailRideMarchandise']['marchandise_id'],
                            'class' => 'form-filter select3'
                        )) . "</div>";

                    echo "<div class='select-inline' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.quantity', array(
                            'label' => __(''),
                            'placeholder' => __('Enter quantity'),
                            'id' => 'quantity'.$num.$i,
                            'onchange'=>'javascript : verifyQuantity(this.id,'.$num.','.$i.');',
                            'value'=>$selectedMarchandise['SheetRideDetailRideMarchandise']['quantity'],
                            'class' => 'form-filter'
                        )) . "</div>";
                    ?>
                    <div id='weight-div<?php echo $num?><?php echo $i?>'>
                        <?php
                        echo "<div class='select-inline' style='width: 24%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.weight_palette', array(
                                'label' => __(''),
                                'placeholder' => __('Enter weight truck'),
                                'id' => 'weight_palette'.$num.$i,
                                'value'=>$selectedMarchandise['Marchandise']['weight_palette'],
                                'type'=>'hidden',
                                'class' => 'form-filter'
                            )) . "</div>";

                        echo "<div class='select-inline' style='width: 24%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.weight', array(
                                'label' => __(''),
                                'placeholder' => __('Enter weight truck'),
                                'id' => 'weight'.$num.$i,
                                'value'=>$selectedMarchandise['Marchandise']['weight'],
                                'type'=>'hidden',
                                'class' => 'form-filter'
                            )) . "</div>";
                        ?>
                    </div>
                </td>

                <?php if($i==1) {?>
                    <td class="td_tab">
                        <button style="margin-left: 0px;" type='button' name='add' id='add<?php echo $i?>' onclick="addOtherMarchandises(<?php echo $i?>, <?php echo $num?>)" class='btn btn-success add_marchandise'><?=__('Add more')?></button>
                    </td>
                <?php } ?>

            </tr>
            <?php
            $i++;
        }
    } else {
        echo "<div class='select-inline'>" . $this->Form->input('nb_marchandise', array(
                'label' => __(''),
                'type' => 'hidden',
                'class' => 'form-filter',
                'id' => 'nb_marchandise'.$num,
                'value'=>1
            )) . "</div>";

        ?>

        <table   id='dynamic_field<?php echo $num?>' style='width: 100%;'>
            <tr id="row<?php echo $num?><?php echo $i?>" style="height: 70px;">
                <td id='marchandise-quantity<?php echo $i ?>'  style="width: 50%;">
                    <?php
                    echo "<div class='select-inline' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.marchandise_id', array(
                            'label' => __(''),
                            'empty' => '',
                            'id' => 'marchandise'.$num.$i,
                            'options' => $marchandises,
                            'onchange'=>'javascript : getWeightByMarchandise(this.id,'.$num.','.$i.');',
                            'class' => 'form-filter select3'
                        )) . "</div>";

                    echo "<div class='select-inline' style='width: 37%;'>" . $this->Form->input('SheetRideDetailRides.'.$num.'.SheetRideDetailRideMarchandise.'.$i.'.quantity', array(
                            'label' => __(''),
                            'placeholder' => __('Enter quantity'),
                            'id' => 'quantity'.$num.$i,
                            'onchange'=>'javascript : verifyQuantity(this.id,'.$num.','.$i.');',
                            'class' => 'form-filter'
                        )) . "</div>";
                    ?>
                    <div id='weight-div<?php echo $num?><?php echo $i?>'>
                    </div>
                </td>


                <td class="td_tab">
                    <button  style="margin-left: 0px;" type='button' name='add' id='add<?php echo $i?>' onclick="addOtherMarchandises(<?php echo $i?>, <?php echo $num?>)" class='btn btn-success add_marchandise'><?=__('Add more')?></button>
                </td>

            </tr>
        </table>

    <?php   }
    } ?>




</table>


