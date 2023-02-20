<?php


echo "<div class='hidden' >" . $this->Tinymce->input('BillProduct.'.$i.'.description',
        array(
            'value'=>$description,
            'id' => 'description'.$i,
        )) . "</div>";