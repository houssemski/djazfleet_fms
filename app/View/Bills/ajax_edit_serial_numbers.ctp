<div class="card pre-scrollable">


    <input name="lineNumber" id="lineNumber" value="<?php echo $lineNumber ?>" type="hidden">
    <?php
    $i = 1;

    if (!empty($newSerialNumbers)) {

        $countSerialNumbers =  count($newSerialNumbers);
        foreach ($newSerialNumbers as $serialNumber) {
    ?>
            <input name="[SerialNumber][<?= $lineNumber ?>][id][<?= $i ?>]" id="serial-id-<?= $lineNumber ?>-<?= $i ?>" value="<?php if(isset($serialNumberIds[$i-1])) {echo $serialNumberIds[$i-1];}?>" type="hidden">
            <?php
            echo $this->Form->input("[SerialNumber][$lineNumber][serial_number][$i]", array(
                'label' => __('Serial number') . ' ' . $i.__('  '),
                'value' => $serialNumber,
                'id' => 'serial-' . $lineNumber . '-' . $i,
                'onFocusOut' => 'checkIfSerialNumberExist(' . $lineNumber . ',' . $i . ');',
                'class' => 'form-control',
                'type'=>'text'
            ));
                if(isset($newSerialNumberLabels[$i - 1])){
                    echo '<br/>';
                    echo $this->Form->input("[SerialNumber][$lineNumber][label][$i]", array(
                        'label' => __('Label') . ' ' . $i.__('  '),
                        'value' => $newSerialNumberLabels[$i - 1],
                        'id' => 'label-serial-' . $lineNumber . '-' . $i,
                        'onFocusOut' => 'checkIfLabelSerialNumberExist(' . $lineNumber . ',' . $i . ');',
                        'class' => 'form-control',
                        'type'=>'text'
                    ));
                }else {
                    echo '<br/>';
                    echo $this->Form->input("[SerialNumber][$lineNumber][label][$i]", array(
                        'label' => __('Label') . ' ' . $i.__('  '),
                        'id' => 'label-serial-' . $lineNumber . '-' . $i,
                        'onFocusOut' => 'checkIfLabelSerialNumberExist(' . $lineNumber . ',' . $i . ');',
                        'class' => 'form-control',
                        'type'=>'text'
                    ));
                }

                if(isset($newExpirationDates[$i - 1])){
                    echo '<br/>';
                    echo $this->Form->input("[SerialNumber][$lineNumber][expiration_date][$i]", array(
                        'label' => __('Expiration date') . ' ' . $i.__('  '),
                        'placeholder' => 'dd/mm/yyyy',
                        'value' =>  date('m/d/Y',$newExpirationDates[$i - 1]),
                        'id' => 'expiration-date-' . $lineNumber . '-' . $i,
                        'class' => 'form-control',
                        'type'=>'text'
                    ));
                }else {
                    echo '<br/>';
                    echo $this->Form->input("[SerialNumber][$lineNumber][expiration_date][$i]", array(
                        'label' => __('Expiration date') . ' ' . $i.__('  '),
                        'placeholder' => 'dd/mm/yyyy',
                        'id' => 'expiration-date-' . $lineNumber . '-' . $i,
                        'class' => 'form-control',
                        'type'=>'text'
                    ));
                }
            $i++;
        }
    } else {
        $i = 1;

        if (!empty($serialNumbers)) {
            $countSerialNumbers =  count($serialNumbers);
            foreach ($serialNumbers as $serialNumber) {
            ?>
                <input name="[SerialNumber][<?= $lineNumber ?>][id][<?= $i ?>]" id="serial-id-<?= $lineNumber ?>-<?= $i ?>" value="<?= $serialNumber['SerialNumber']['id'] ?>" type="hidden">
            <?php
                echo $this->Form->input("data[SerialNumber][$lineNumber][serial_number][$i]", array(
                    'label' => __('Serial number') . ' ' . $i.__('  '),
                    'value' => $serialNumber['SerialNumber']['serial_number'],
                    'id' => 'serial-' . $lineNumber . '-' . $i,
                    'onFocusOut' => 'checkIfSerialNumberExist(' . $lineNumber . ',' . $i . ');',
                    'class' => 'form-control',
                                        'type'=>'text'
                ));
                echo '<br/>';
                echo $this->Form->input("[SerialNumber][$lineNumber][label][$i]", array(
                    'label' => __('Label') . ' ' . $i.__('  '),
                    'value' => $serialNumber['SerialNumber']['label'],
                    'id' => 'label-serial-' . $lineNumber . '-' . $i,
                    'onFocusOut' => 'checkIfLabelSerialNumberExist(' . $lineNumber . ',' . $i . ');',
                    'class' => 'form-control',
                    'type'=>'text'
                    ));

                echo '<br/>';
                echo $this->Form->input("[SerialNumber][$lineNumber][expiration_date][$i]", array(
                    'label' => __('Expiration date') . ' ' . $i.__('  '),
                    'value' => $serialNumber['SerialNumber']['expiration_date'],
                    'placeholder' => 'dd/mm/yyyy',
                    'id' => 'expiration-date-' . $lineNumber . '-' . $i,
                    'class' => 'form-control',
                    'type'=>'text'
                    ));
                $i++;
            }
        } else {
            $countSerialNumbers = 0;
        }
    }
    if ($countSerialNumbers < $productQuantity) {
        for ($i = $countSerialNumbers + 1; $i <= $productQuantity; $i++) { ?>
            <input name="data[SerialNumber][<?= $lineNumber ?>][id][<?= $i ?>]" id="serial-id-<?= $lineNumber ?>-<?= $i ?>" type="hidden">
    <?php

            echo $this->Form->input("data[SerialNumber][$lineNumber][serial_number][$i]", array(
                'label' =>  __('Serial number') . ' ' . $i.__('  '),
                'id' => 'serial-' . $lineNumber . '-' . $i,
                'onFocusOut' => 'checkIfSerialNumberExist(' . $lineNumber . ',' . $i . ');',
                'class' => 'form-control',
                 'type'=>'text'
            ));
            echo '<br/>';
                echo $this->Form->input("data[SerialNumber][$lineNumber][label][$i]", array(
                    'label' =>  __('Label') . ' ' . $i.__('  '),
                    'id' => 'label-serial-' . $lineNumber . '-' . $i,
                    'onFocusOut' => 'checkIfLabelSerialNumberExist(' . $lineNumber . ',' . $i . ');',
                    'class' => 'form-control',
                    'type'=>'text'
                ));

                echo '<br/>';
                echo $this->Form->input("data[SerialNumber][$lineNumber][expiration_date][$i]", array(
                    'label' =>  __('Expiration date') . ' ' . $i.__('  '),
                    'placeholder' => 'dd/mm/yyyy',
                    'id' => 'expiration-date-' . $lineNumber . '-' . $i,
                    'class' => 'form-control',
                    'type'=>'text'
                ));
        }
    }
     echo $this->Form->hidden("nb_serial_numbers",
        array(
            'label'=>false,
            'hidden'=>true,
            'value'=>$i-1,
            'id'=>'nb-serial-'.$lineNumber,
        ));
    ?>
</div>
<script>
    jQuery('[id*="serial-"]').keypress(function(event) {
        if (event.which == '10' || event.which == '13') {
            event.preventDefault();
        }
    });
</script>
