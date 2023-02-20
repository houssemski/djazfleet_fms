<?php
if(!empty($invoice)){
    if (($type == TransportBillTypesEnum::order)
        && ($profileId == ProfilesEnum::client)
    ) {
        echo "<div  class='  col-sm-4'>" . $this->Form->input('TransportBill.total_ht', array(
                'label' => __('Total HT'),
                'readonly' => true,
                'value'=>$invoice['TransportBill']['total_ht'],
                'class' => 'form-control',
                'type' => 'hidden',
                'id' => 'total_ht',

            )) . "</div>";

        echo "<div  class='  col-sm-4'>" . $this->Form->input('TransportBill.total_tva', array(
                'label' => __('Total TVA'),
                'readonly' => true,
                'class' => 'form-control',
                'type' => 'hidden',
                'value'=>$invoice['TransportBill']['total_tva'],
                'id' => 'total_tva',
            )) . "</div>";

        echo "<div  class='col-sm-4'>" . $this->Form->input('TransportBill.total_ttc', array(
                'label' => __('Total TTC'),
                'readonly' => true,
                'class' => 'form-control',
                'type' => 'hidden',
                'value'=>$invoice['TransportBill']['total_ttc'],
                'id' => 'total_ttc',
            )) . "</div>";

    } else {
        echo "<div  class='m-t-20  col-sm-4'>" . $this->Form->input('TransportBill.total_ht', array(
                'label' => __('Total HT'),
                'readonly' => true,
                'class' => 'form-control',
                'value'=>$invoice['TransportBill']['total_ht'],
                'id' => 'total_ht',
            )) . "</div>";


        echo "<div  class='m-t-20  col-sm-4'>" . $this->Form->input('TransportBill.ristourne_val', array(
                'label' => __('Ristourne'),
                'class' => 'form-control',
                'id' => 'ristourne_val',
                'value'=>$invoice['TransportBill']['ristourne_val'],
                'onchange' => 'javascript : calculateGlobalRistourne();'
            )) . "</div>";

        echo "<div  class='m-t-20  col-sm-4'>" . $this->Form->input('TransportBill.ristourne_percentage', array(
                'label' => __('Ristourne') . ' ' . ('%'),
                'class' => 'form-control',
                'id' => 'ristourne_percentage',
                'value'=>$invoice['TransportBill']['ristourne_percentage'],
                'onchange' => 'javascript : calculateGlobalRistourneVal();'
            )) . "</div>";
        echo "<div  class='form-group m-t-20  col-sm-4'>" . $this->Form->input('TransportBill.total_tva', array(
                'label' => __('Total TVA'),
                'readonly' => true,
                'class' => 'form-control',
                'value'=>$invoice['TransportBill']['total_tva'],
                'id' => 'total_tva',
            )) . "</div>";

        echo "<div  class='m-t-20 col-sm-4'>" . $this->Form->input('TransportBill.total_ttc', array(
                'label' => __('Total TTC'),
                'readonly' => true,
                'class' => 'form-control',
                'value'=>$invoice['TransportBill']['total_ttc'],
                'id' => 'total_ttc',
            )) . "</div>";
    }
}else {
    if (($type == TransportBillTypesEnum::order)
        && ($profileId == ProfilesEnum::client)
    ) {
        echo "<div  class='  col-sm-4'>" . $this->Form->input('TransportBill.total_ht', array(
                'label' => __('Total HT'),
                'readonly' => true,
                'class' => 'form-control',
                'type' => 'hidden',
                'id' => 'total_ht',

            )) . "</div>";

        echo "<div  class='  col-sm-4'>" . $this->Form->input('TransportBill.total_tva', array(
                'label' => __('Total TVA'),
                'readonly' => true,
                'class' => 'form-control',
                'type' => 'hidden',
                'id' => 'total_tva',
            )) . "</div>";

        echo "<div  class='col-sm-4'>" . $this->Form->input('TransportBill.total_ttc', array(
                'label' => __('Total TTC'),
                'readonly' => true,
                'class' => 'form-control',
                'type' => 'hidden',
                'id' => 'total_ttc',
            )) . "</div>";

    } else {
        echo "<div  class='m-t-20  col-sm-4'>" . $this->Form->input('TransportBill.total_ht', array(
                'label' => __('Total HT'),
                'readonly' => true,
                'class' => 'form-control',
                'id' => 'total_ht',
            )) . "</div>";


        echo "<div  class='m-t-20  col-sm-4'>" . $this->Form->input('TransportBill.ristourne_val', array(
                'label' => __('Ristourne'),
                'class' => 'form-control',
                'id' => 'ristourne_val',
                'onchange' => 'javascript : calculateGlobalRistourne();'
            )) . "</div>";

        echo "<div  class='m-t-20  col-sm-4'>" . $this->Form->input('TransportBill.ristourne_percentage', array(
                'label' => __('Ristourne') . ' ' . ('%'),
                'class' => 'form-control',
                'id' => 'ristourne_percentage',
                'onchange' => 'javascript : calculateGlobalRistourneVal();'
            )) . "</div>";
        echo "<div  class='form-group m-t-20  col-sm-4'>" . $this->Form->input('TransportBill.total_tva', array(
                'label' => __('Total TVA'),
                'readonly' => true,
                'class' => 'form-control',
                'id' => 'total_tva',
            )) . "</div>";

        echo "<div  class='m-t-20 col-sm-4'>" . $this->Form->input('TransportBill.total_ttc', array(
                'label' => __('Total TTC'),
                'readonly' => true,
                'class' => 'form-control',
                'id' => 'total_ttc',
            )) . "</div>";
    }
}
