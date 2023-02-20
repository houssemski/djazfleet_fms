
<?php
switch ($commercialDocumentModel){
    case 1 :
        echo  $this->element('pdf/view_bill_1');
        break;
    case 2 :
        echo  $this->element('pdf/view_bill_2');
        break ;
    default :
        echo  $this->element('pdf/view_bill_1');
}  ?>







