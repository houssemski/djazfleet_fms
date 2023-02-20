<style>

    .select label {

        display: block;
    }
</style>

<?php

$this->start('css');
echo $this->Html->css('select2/select2.min');

$this->end();

echo $this->Form->create('TransportBillDetailRides');
echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.num', array(
        'id' => 'num',
        'type' => 'hidden',
        'value' => $i,
        'style' => 'color: #222;font-size: 14px;'
    )) . "</div>";

echo "<div >" . $this->Form->input('TransportBillDetailRides.' . $i . '.type', array(
        'id' => 'type',
        'type' => 'hidden',
        'value' => $type,
    )) . "</div>";

switch ($type) {
    case TransportBillTypesEnum::quote :
        $status_id = 0;
        break;
    case TransportBillTypesEnum::order :
        $status_id = 1;
        break;

    case TransportBillTypesEnum::pre_invoice :
        $status_id = 4;
        break;

    case TransportBillTypesEnum::invoice :
        $status_id = 7;
        break;
}
echo "<div class='hidden'>" . $this->Form->input('TransportBillDetailRides.' . $i . '.status_id', array(
        'id' => 'status',
        'type' => 'number',
        'value' => $status_id,
    )) . "</div>";

$i = $i + 1;

echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.detail_ride_id', array(
        'label' => __('Ride') . ' ' . $i,
        'empty' =>'',
        'id' => 'detail_ride',
        'onchange' => 'javascript:getPriceRide(this.id);',
        'style' => 'color: #222;font-size: 14px;',
        'class' => 'form-control',
    )) . "</div>";
echo "<br>";
if($useRideCategory == 2) {
    echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.ride_category_id', array(
            'label' => __('Ride category'),
            'empty' => '',
            'id' => 'ride_category',
            'onchange' => 'javascript:getPriceRide(this.id);',
            'class' => 'form-control select2',
        )) . "</div>";
    echo "<br>";
}


$options = array('1' => __('Simple delivery'), '2' => __('Simple return'), '3' => __('Delivery / Return'));
echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.delivery_with_return', array(
        'label' => __('Delivery with return'),
        'empty' => '',
        'id' => 'delivery_with_return',
        'onchange' => 'javascript:getPriceRide(this.id);',
        'value' => 2,
        'options'=> $options,
        'class' => 'form-control',
    )) . "</div>";

echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.nb_trucks', array(
        'label' => __('Number of trucks'),
        'placeholder' => __('Enter number of trucks'),
        'id' => 'nb_trucks',
        'onchange' => 'javascript:calculPriceRide(this.id);',
        'value' => 1,
        'class' => 'form-control',
    )) . "</div>";

$options=array('1'=>__('Day'),'2'=>__('Night'));
echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.type_price', array(
        'label' => __('Price'),
        'empty' => '',
        'id' => 'type_price',
        'onchange' => 'javascript:getPriceRide(this.id);',
        'value' => 1,
        'options'=> $options,
        'class' => 'form-control',
    )) . "</div>";

?>
<div id='div_unit_price'>

    <?php
    echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.unit_price', array(
            'label' => __('Unit price'),
            'readonly' => true,
            'id' => 'unit_price',
            'onchange' => 'javascript:calculPriceRide(this.id);',
            'style' => 'color: #222;font-size: 14px;',
            'class' => 'form-control',
        )) . "</div>"; ?>

</div>
<?php

echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_val', array(
        'label' => __('Ristourne'),
        'onchange' => 'javascript:calculRistourne();',
        'id' => 'ristourne_val',
        'class' => 'form-control',
        'style' => 'color: #222;font-size: 14px;'
    )) . "</div>";


echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.ristourne_%', array(
        'label' => __('Ristourne') . __('%'),
        'onchange' => 'javascript:calculRistourneVal();',
        'id' => 'ristourne',
        'class' => 'form-control',
        'style' => 'color: #222;font-size: 14px;'
    )) . "</div>";


echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ht', array(
        'label' => __('Price HT'),
        'readonly' => true,
        'id' => 'price_ht',
        'style' => 'color: #222;font-size: 14px;',
        'class' => 'form-control',
    )) . "</div>";


echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.tva_id', array(
        'label' => __('TVA'),
        'type' => 'select',
        'class' => 'form-control',
        'id' => 'tva',
        'options' => $tvas,
        'onchange' => 'javascript:calculPriceRide(this.id);',
        'style' => 'color: #222;font-size: 14px;'
    )) . "</div>";


echo "<div class='form-group '>" . $this->Form->input('TransportBillDetailRides.' . $i . '.price_ttc', array(
        'label' => __('Price TTC'),
        'readonly' => true,
        'id' => 'price_ttc',
        'class' => 'form-control',
        'style' => 'color: #222;font-size: 14px;'
    )) . "</div>";


echo "<br>";
echo $this->Js->submit(__('Save'), array(  //create 'ajax' save button
    'update' => '#contentWrapRide',  //id of DOM element to update with selector
    'class' => 'btn btn-primary',


));


if (false != $saved) { //will only be true if saved OK in controller from ajax save above

    $url = '/transportBills/getRide/' . base64_encode(serialize($TransportBillDetailRides)) . '/' . $i . '/' . '0';

    echo "<script>
        jQuery('#dialogModalRide').dialog('close');  //close containing dialog
        jQuery('#ride" . $i . "').load('" . $this->Html->url($url) . "');
    </script>";
}
echo $this->Form->end();
echo $this->Js->writeBuffer(); //assuming this view is rendered without the default layout, make sure you write out the JS buffer at the bottom of the page

?>
<?= $this->Html->script('plugins/select2/select2.full.min.js'); ?>
<script type="text/javascript">

    $(document).ready(function() {

    });

    function getPriceRide() {

        var client_id = jQuery("#client").val();
        if(client_id==''){
            client_id=null;
        }
        var num = jQuery("#num").val();
        var ride_id = jQuery("#detail_ride").val();
        if(jQuery("#ride_category").val()){
            var ride_category_id= jQuery("#ride_category").val();
             }else {
            var ride_category_id= null;
        }
        var delivery_with_return= jQuery("#delivery_with_return").val();
        var typePrice = jQuery("#type_price").val();


        jQuery("#div_unit_price").load('<?php echo $this->Html->url('/transportBills/getPriceRide/')?>' + ride_id + '/' + num + '/' + client_id + '/' +delivery_with_return + '/'+typePrice + '/' + ride_category_id, function () {

            unit_price = jQuery("#unit_price").val();

            calculPriceRide();
        });
    }
    function calculRistourne() {

        if (jQuery("#ristourne_val").val() > 0) {
            var price_ht = jQuery("#price_ht").val();
            var ristourne = ( jQuery("#ristourne_val").val() / price_ht) * 100;
            ristourne = ristourne.toFixed(2);
            jQuery("#ristourne").val(ristourne);
        }
        calculPriceRide();
    }

    function calculRistourneVal() {

        if (jQuery("#ristourne").val() > 0) {
            var price_ht = jQuery("#price_ht").val();
            var ristourne_val = ( jQuery("#ristourne").val() * price_ht) / 100;
            ristourne_val = ristourne_val.toFixed(2);
            jQuery("#ristourne_val").val(ristourne_val);

        }
        calculPriceRide();
    }
    function calculPriceRide() {

        var num = jQuery("#num").val();

        jQuery("#numm").val(num);

        nb_trucks = jQuery("#nb_trucks").val();
        unit_price = jQuery("#unit_price").val();

        if (unit_price > 0 && nb_trucks > 0) {
            price_ht = nb_trucks * unit_price;

            if (jQuery("#ristourne_val").val() > 0) {
                var ristourne_val = ( jQuery("#ristourne").val() * price_ht) / 100;
                ristourne_val = ristourne_val.toFixed(2);
                jQuery("#ristourne_val").val(ristourne_val);
                price_ht = price_ht - jQuery("#ristourne_val").val();
            }

            price_ht = price_ht.toFixed(2);
            jQuery("#price_ht").val(price_ht);
            tva = jQuery("#tva").val();
            switch (tva) {
                case '1':
                    tva = 0.19;
                    break;
                case '2':
                    tva = 0.09;
                    break;
                case '3':
                    tva = 0.00;
                    break;
                case '4':
                    tva = 0.00;
                    break;

            }


            price_ttc = parseFloat(price_ht) + (parseFloat(price_ht) * parseFloat(tva));
            price_ttc = price_ttc.toFixed(2);
            jQuery("#price_ttc").val(price_ttc);


        }


    }

</script>
<?php die();?>