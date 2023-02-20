<?php
switch ($commercialDocumentModel){
    case 1 :
        echo  $this->element('pdf/print_facture_1');
        break;
    case 2 :
        echo  $this->element('pdf/print_facture_2');
        break ;
    case 3 :
        echo  $this->element('pdf/print_facture_3');
        break ;
    default :
        echo  $this->element('pdf/print_facture_1');
}


