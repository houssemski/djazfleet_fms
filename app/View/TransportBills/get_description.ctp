<?php


echo "<div class='hidden' >" . $this->Tinymce->input('TransportBillDetailRides.'.$i.'.description',
        array(
            'value'=>$description,
            'id' => 'description'.$i,
        )) . "</div>";