<?php

$i = 1;

if (!empty($serialNumbers)) {
    foreach ($serialNumbers as $serialNumber) {
        if (!empty($serialNumber)) {
            if (isset($serialNumberIds) && !empty($serialNumberIds)) {
                if (isset($serialNumberIds[$i-1]) && !empty($serialNumberIds[$i-1])) {
                    echo $this->Form->hidden(
                        "BillProduct.$lineNumber.SerialNumber.$i.id",
                        array(
                            'label' => false,
                            'hidden' => true,
                            'value' => $serialNumberIds[$i-1],
                            'id' => 'serial-id-' . $lineNumber . '-' . $i,
                        )
                    );
                }
            }
            echo $this->Form->hidden(
                "BillProduct.$lineNumber.SerialNumber.$i.serial_number",
                array(
                    'label' => false,
                    'hidden' => true,
                    'value' => $serialNumber,
                    'id' => 'serial-' . $lineNumber . '-' . $i,
                )
            );
            if (isset($labels) && !empty($labels)) {
                if (isset($labels[$i-1]) && !empty($labels[$i-1])) {
                    echo $this->Form->hidden(
                        "BillProduct.$lineNumber.SerialNumber.$i.label",
                        array(
                            'label' => false,
                            'hidden' => true,
                            'value' => $labels[$i-1],
                            'id' => 'label-serial-' . $lineNumber . '-' . $i,
                        )
                    );
                }
            }

            if (isset($expirationDates) && !empty($expirationDates)) {
                if (isset($expirationDates[$i-1]) && !empty($expirationDates[$i-1])) {
                    echo $this->Form->hidden(
                        "BillProduct.$lineNumber.SerialNumber.$i.expiration_date",
                        array(
                            'label' => false,
                            'hidden' => true,
                            'value' => date('m/d/Y', $expirationDates[$i-1]),
                            'id' => 'expiration-date-' . $lineNumber . '-' . $i,
                        )
                    );
                }
            }
        }
        $i++;
    }
}
echo $this->Form->hidden(
    "nb_serial_numbers",
    array(
        'label' => false,
        'hidden' => true,
        'value' => $i,
        'id' => 'nb-serial-' . $lineNumber,
    )
);
