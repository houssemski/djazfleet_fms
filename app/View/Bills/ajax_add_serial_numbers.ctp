<div class="card pre-scrollable">
    <input name="lineNumber" id="lineNumber" value="<?php echo $lineNumber ?>" type="hidden">
    <?php
    $i = 1;

    if (!empty($serialNumbers)) {
        $countSerialNumbers = count($serialNumbers);
        foreach ($serialNumbers as $serialNumber) {
            echo '<br/>';
            ?>
            <input name="data[serialNumber][<?= $lineNumber ?>][id][<?= $i ?>]" id="serial-id-<?= $lineNumber ?>-<?= $i ?>" value="<?php if(isset($serialNumberIds[$i-1])) {echo $serialNumberIds[$i-1];} ?>" type="hidden">
      <?php
            echo $this->Form->input("serialNumber.$lineNumber.serial_number.$i", array(
                'label' => __('Serial number') . ' ' . $i.__('  '),
                'value' => $serialNumber,
                'id' => 'serial-' . $lineNumber . '-' . $i,
                'onFocusOut' => 'checkIfSerialNumberExist(' . $lineNumber . ',' . $i . ');',
                'class' => 'form-control',
                 'type'=>'text'
            ));
                if(isset($serialNumberLabels[$i-1])){
                    echo '<br/>';
                    echo $this->Form->input("serialNumber.$lineNumber.label.$i", array(
                        'label' => __('Label') . ' ' . $i.__('  '),
                        'value' => $serialNumberLabels[$i-1],
                        'id' => 'label-serial-' . $lineNumber . '-' . $i,
                        'onFocusOut' => 'checkIfLabelSerialNumberExist(' . $lineNumber . ',' . $i . ');',
                        'class' => 'form-control',
                    ));
                }else {
                    echo '<br/>';
                    echo $this->Form->input("serialNumber.$lineNumber.label.$i", array(
                        'label' => __('Label') . ' ' . $i.__('  '),
                        'id' => 'label-serial-' . $lineNumber . '-' . $i,
                        'onFocusOut' => 'checkIfLabelSerialNumberExist(' . $lineNumber . ',' . $i . ');',
                        'class' => 'form-control',
                        'type'=>'text'
                    ));
                }

                if(isset($expirationDates[$i-1])){
                    echo '<br/>';
                    echo $this->Form->input("serialNumber.$lineNumber.expiration_date.$i", array(
                        'label' => __('Expiration date') . ' ' . $i.__('  '),
                        'placeholder' => 'dd/mm/yyyy',
                        'value' =>  date('m/d/Y',$expirationDates[$i-1]),
                        'class' => 'form-control',
                    ));
                }else {
                    echo '<br/>';
                    echo $this->Form->input("serialNumber.$lineNumber.expiration_date.$i", array(
                        'label' => __('expiration date') . ' ' . $i.__('  '),
                        'placeholder' => 'dd/mm/yyyy',
                        'id' => 'expiration-date-' . $lineNumber . '-' . $i,
                        'class' => 'form-control',
                        'type'=>'text'
                    ));
                }
            $i++;
        }
    } else {
        $countSerialNumbers = 0;
    }
    for ($i = $countSerialNumbers + 1; $i <= $productQuantity; $i++) { ?>
        <input name="data[serialNumber][<?= $lineNumber ?>][id][<?= $i ?>]" id="serial-id-<?= $lineNumber ?>-<?= $i ?>" type="hidden" />
    <?php
        echo '<br/>';
        echo $this->Form->input("serialNumber.$lineNumber.serial_number.$i", array(
            'label' =>  __('Serial number') . ' ' . $i.__('  '),
            'id' => 'serial-' . $lineNumber . '-' . $i,
            'onChange' => 'checkIfSerialNumberExist(' . $lineNumber . ',' . $i . ');',
            'class' => 'form-control',
            'type'=>'text'
        ));
        echo '<br/>';
        echo $this->Form->input("serialNumber.$lineNumber.label.$i", array(
            'label' =>  __('Label') . ' ' . $i.__('  '),
            'id' => 'label-serial-' . $lineNumber . '-' . $i,
            'onChange' => 'checkIfLabelSerialNumberExist(' . $lineNumber . ',' . $i . ');',
            'class' => 'form-control',
            'type'=>'text'
        ));
        echo '<br/>';
        echo $this->Form->input("serialNumber.$lineNumber.expiration_date.$i", array(
            'label' =>  __('Expiration date') . ' ' . $i.__('  '),
            'placeholder' => 'dd/mm/yyyy',
            'id' => 'expiration-date-' . $lineNumber . '-' . $i,
            'class' => 'form-control',
            'type'=>'text'
        ));
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
