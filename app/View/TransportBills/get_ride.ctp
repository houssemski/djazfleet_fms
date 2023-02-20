<?php

?>
<td>
    <?php
    if (isset($TransportBillDetailRides[$i]['reference'])) {
        echo $TransportBillDetailRides[$i]['reference'];
        echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.reference', array(
                'id' => 'transport_bill_detail_ride' . $i,
                'type' => 'hidden',
                'value' => $TransportBillDetailRides[$i]['reference'],
                'class' => 'form-control',
            )) . "</div>";
    } else {
        echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.reference', array(
                'id' => 'transport_bill_detail_ride' . $i,
                'type' => 'hidden',

                'class' => 'form-control',
            )) . "</div>";

    } ?>
</td>

<?php if($TransportBillDetailRides[$i]['type']==4 || $TransportBillDetailRides[$i]['type']==7){?>
    <td>
        <?php
        if (isset($TransportBillDetailRides[$i]['reference_mission'])){
        echo $TransportBillDetailRides[$i]['reference_mission'];
        echo "<div>" . $this->Form->input('SheetRideDetailRides.' . $i . '.reference', array(

                'type' => 'hidden',

                'value' =>$TransportBillDetailRides[$i]['reference_mission'],

                'class' => 'form-control',
            )) . "</div>";
        }else {
            echo "<div>" . $this->Form->input('SheetRideDetailRides.' . $i . '.reference', array(

                    'type' => 'hidden',



                    'class' => 'form-control',
                )) . "</div>";
        }
        ?>

    </td>
<?php } ?>
<td>
    <?php
    echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.mode', array(
            'id' => 'num',
            'type' => 'hidden',
            'id' => 'mode' . $i,
            'value' => $mode,
        )) . "</div>";

    if (!empty($TransportBillDetailRides[$i]['detail_ride_id'])) {
        $detail_ride_id = $TransportBillDetailRides[$i]['detail_ride_id'];
        echo $detailRides[$detail_ride_id];
    }
    if (isset($TransportBillDetailRides[$i]['id'])) {

        echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.id', array(
                'id' => 'transport_bill_detail_ride' . $i,
                'type' => 'hidden',
                'value' => $TransportBillDetailRides[$i]['id'],
                'class' => 'form-control',
            )) . "</div>";

    } else {
        echo "<div>" . $this->Form->input('TransportBillDetailRides.' . $i . '.id', array(
                'id' => 'transport_bill_detail_ride' . $i,
                'type' => 'hidden',
                'class' => 'form-control',
            )) . "</div>";


    }
    echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
            'label' => __('Ride'),
            'type' => 'hidden',
            'empty' => '',
            'id' => 'detail_ride' . $i,
            'value' => $TransportBillDetailRides[$i]['detail_ride_id'],

            'class' => 'form-control',
        )) . "</div>"; ?>

</td>
<?php if($useRideCategory == 2) {?>
<td>
    <?php

    if (isset($TransportBillDetailRides[$i]['ride_category_id'])&& !empty($TransportBillDetailRides[$i]['ride_category_id'])) {
        $ride_category_id = $TransportBillDetailRides[$i]['ride_category_id'];
        echo $rideCategories[$ride_category_id];

        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ride_category_id', array(
                'label' => __('Ride'),
                'type' => 'hidden',
                'empty' => '',
                'id' => 'ride_category' . $i,
                'value' => $TransportBillDetailRides[$i]['ride_category_id'],

                'class' => 'form-control',
            )) . "</div>";
    }else{
        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ride_category_id', array(
                'label' => __('Ride'),
                'type' => 'hidden',
                'empty' => '',
                'id' => 'ride_category' . $i,


                'class' => 'form-control',
            )) . "</div>";

    } ?>
</td>
<?php } ?>
<td>
    <?php

    if (isset($TransportBillDetailRides[$i]['delivery_with_return'])&& !empty($TransportBillDetailRides[$i]['delivery_with_return'])) {

         if($TransportBillDetailRides[$i]['delivery_with_return']==1) { echo __('Yes'); } else  {echo __('No'); }

        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.delivery_with_return', array(
                'label' => __('Ride'),
                'type' => 'hidden',
                'empty' => '',
                'id' => 'delivery_with_return' . $i,
                'value' => $TransportBillDetailRides[$i]['delivery_with_return'],
                'class' => 'form-control',
            )) . "</div>";
    } else {
        echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.delivery_with_return', array(
                'label' => __('Ride'),
                'type' => 'hidden',
                'empty' => '',
                'id' => 'delivery_with_return' . $i,
                'class' => 'form-control',
            )) . "</div>";

    } ?>

</td>
<td>
    <?php
    if (!empty($TransportBillDetailRides[$i]['unit_price'])) {
        echo number_format($TransportBillDetailRides[$i]['unit_price'], 2, ",", ".");
    }
    echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
            'label' => __('Unit price'),
            'readonly' => true,
            'type' => 'hidden',
            'id' => 'unit_price' . $i,
            'value' => $TransportBillDetailRides[$i]['unit_price'],

            'class' => 'form-control',
        )) . "</div>"; ?>

</td>
<td>
    <?php
    if (!empty($TransportBillDetailRides[$i]['ristourne_%'])) {
        echo $TransportBillDetailRides[$i]['ristourne_%'] . '%';
    }
    echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_%', array(
            'label' => __('Ristourne '),
            'readonly' => true,
            'type' => 'hidden',
            'id' => 'ristourne_%' . $i,
            'value' => $TransportBillDetailRides[$i]['ristourne_%'],

            'class' => 'form-control',
        )) . "</div>";
    echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_val', array(
            'label' => __('Ristourne'),
            'readonly' => true,
            'type' => 'hidden',
            'id' => 'ristourne_val' . $i,
            'value' => $TransportBillDetailRides[$i]['ristourne_val'],

            'class' => 'form-control',
        )) . "</div>";
    ?>
</td>

<?php

if (($TransportBillDetailRides[$i]['type'] != 4) && ( $TransportBillDetailRides[$i]['type'] != 7)) { ?>
<td>
    <?php

    echo $TransportBillDetailRides[$i]['nb_trucks']; ?>

</td>
<?php } ?>
<td>

 <?php    echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(

        'id' => 'nb_trucks' . $i,
        'type' => 'hidden',
        'onchange' => 'javascript:calculPriceRide(this.id);',
        'value' => $TransportBillDetailRides[$i]['nb_trucks'],
        'class' => 'form-control',
        )) . "</div>";?>
    <?php
    if (!empty($TransportBillDetailRides[$i]['price_ht'])) {
        echo number_format($TransportBillDetailRides[$i]['price_ht'], 2, ",", ".");
    }
    echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ht', array(
            'label' => __('Price HT'),
            'readonly' => true,
            'type' => 'hidden',
            'id' => 'price_ht' . $i,
            'class' => 'form-control',
            'value' => $TransportBillDetailRides[$i]['price_ht'],
        )) . "</div>";   ?>
</td>


<td>
    <?php

    $tva_id = $TransportBillDetailRides[$i]['tva_id'];
    echo $tvas[$tva_id];
    echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.tva_id', array(
            'label' => __('TVA'),
            'type' => 'select',
            'type' => 'hidden',
            'class' => 'form-control',
            'value' => $TransportBillDetailRides[$i]['tva_id'],
            'id' => 'tva' . $i,
            'options' => $tvas,


        )) . "</div>"; ?>
</td>
<td>
    <?php

    if (!empty($TransportBillDetailRides[$i]['price_ttc'])) {
        echo number_format($TransportBillDetailRides[$i]['price_ttc'], 2, ",", ".");
    }
    echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ttc', array(
            'label' => __('Price TTC'),
            'readonly' => true,
            'type' => 'hidden',
            'id' => 'price_ttc' . $i,
            'value' => $TransportBillDetailRides[$i]['price_ttc'],
            'class' => 'form-control',
        )) . "</div>"; ?>
</td>

<td><?php

    switch ($TransportBillDetailRides[$i]['status_id']) {

        /*
		0: devis
        1: commandes en cours
        2: commandes partiellement validées
        3: commandes validées
		4: commandes préfacturées.
		7: commandes facturées.
        */
        case 0:
            echo '<span class="label label-info">';
            echo __('Quotation') . "</span>";
            break;
        case 1:
            echo '<span class="label label-danger">';
            echo __('Not validated') . "</span>";
            break;
        case 2:
            echo '<span class="label label-warning">';
            echo __('Partially validated') . "</span>";
            break;
        case 3:
            echo '<span class="label label-success">';
            echo __('Validated') . "</span>";
            break;
        case 4:
            echo '<span class="label label-primary">';
            echo __('Preinvoiced') . "</span>";
            break;
        case 7:
            echo '<span class="label btn-inverse">';
            echo __('Invoiced') . "</span>";
            break;

    } ?>&nbsp;
</td>
<?php if ($TransportBillDetailRides[$i]['type'] == 4) { ?>
    <td>
      <?php  echo "<div class='appro'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.approved', array(
            'type' => 'checkbox',
            'label' => false,
            'class' => 'id approve'
            )) . "</div>"; ?>
    </td>
<?php } ?>
<td class="actions">
    <?= $this->Html->link(
        '<i class="  fa fa-edit m-r-5" title="' . __('Edit') . '"></i>',
        'javascript:;',
        array('escape' => false, 'id' => 'edit' . $i, 'onclick' => 'javascript:editRideTransportBill(this.id);')); ?>
    <?php
    echo $this->Html->link(
        '<i class=" fa fa-trash-o m-r-5" title="' . __('Delete') . '"></i>',
        'javascript:;',
        array('escape' => false, 'id' => 'delete' . $i, 'onclick' => 'javascript:deleteRideTransportBill(this.id);')); ?>

    <?php echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.array_ride', array(
            'type' => 'hidden',

            'id' => 'array_ride' . $i,
            'value' => base64_encode(serialize($TransportBillDetailRides[$i])),

            'class' => 'form-control',
        )) . "</div>";  ?>
</td>


<script type="text/javascript">
    $(document).ready(function () {

       $(' input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'


        });
        var num = jQuery('#numm').val();

        calculTotalPrice();

        function calculTotalPrice() {

            mode = jQuery("#mode" + '' + num + '').val();

            var total_ht = 0;
            var total_tva = 0;
            var total_ttc = 0;
            var nb_ride = parseInt(jQuery('#nb_ride').val());

            if (mode == '1') {
                nb_ride = nb_ride - 1;
            }

            for (var i = 0; i <= parseInt(nb_ride); i++) {

                if (jQuery("#price_ht" + '' + i + '').val() != 0) {
                    total_ht = total_ht + parseFloat(jQuery("#price_ht" + '' + i + '').val());
                    total_ttc = total_ttc + parseFloat(jQuery("#price_ttc" + '' + i + '').val());

                }

            }
            total_tva = total_ttc - total_ht;
            total_ht = total_ht.toFixed(2);
            total_tva = total_tva.toFixed(2);
            total_ttc = total_ttc.toFixed(2);
            jQuery("#total_ht").val(total_ht);
            jQuery("#total_tva").val(total_tva);
            jQuery("#total_ttc").val(total_ttc);
            if (mode == '0') {
                jQuery('#nb_ride').val(nb_ride + 1);
            }
            var type = jQuery('#type').val();
            if (type == 7){
                calculateStampValue();
            }

        }

        function calculateStampValue(){
            var paymentMethod = jQuery("#payment_method").val();
            if (paymentMethod == 6){
                var totalTtc = jQuery('#total_ttc').val();
                var stamp = parseFloat(totalTtc)/100;
                if(parseFloat(stamp)>=2500){
                    stamp =2500;
                }
                totalTtc = parseFloat(totalTtc) + parseFloat(stamp);
                jQuery('#stamp').val(stamp);
                jQuery('#total_ttc').val(totalTtc);
            }else {
                var totalHt = jQuery('#total_ht').val();
                var totalTva = jQuery('#total_tva').val();
                var totalTtc = parseFloat(totalHt) + parseFloat(totalTva);
                jQuery('#stamp').val(0);
                jQuery('#total_ttc').val(totalTtc);
            }
        }


    });


</script>
