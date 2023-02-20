<?php



/**
 * Class BillManagementComponent
 * @package App\Controller\Component
 */
class BillManagementComponent extends Component
{
function getOrganizedSerialNumbersArray($billProduct){
    if (isset($billProduct["SerialNumber"]) && !empty($billProduct["SerialNumber"])) {
        $serialNumbers = $billProduct["SerialNumber"];
        $i = 0;
        foreach ($serialNumbers as $serialNumber) {
            $serialNumberArray[$i]['serial_number'] = $serialNumber['serial_number'];
            if (isset($serialNumber['id'])) {
                $serialNumberArray[$i]['id'] = $serialNumber['id'];
            }
            if (isset($serialNumber['label'])) {
                $serialNumberArray[$i]['label'] = $serialNumber['label'];
            }
            $i++;
        }
    }
}
}



