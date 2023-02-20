<?php
echo "<div class='form-group'>" . $this->Form->input('Car.car_parc', array(
        'type' => 'hidden',
        'value' => $carContractor,
        'class' => 'form-control',
        'id' => 'carParc'
    )) . "</div>";


if($balanceCar==2){
    echo "<div class='form-group'>" . $this->Form->input('Car.balance', array(
            'type' => 'hidden',
            'label'=>__('Balance car'),
            'value' => $balance,
            'class' => 'form-control',
            'id' => 'balance'
        )) . "</div>";

}else {
    echo "<div class='form-group'>" . $this->Form->input('Car.balance', array(
            'type' => 'hidden',
            'label'=>__('Balance car'),
            'value' => 0,
            'class' => 'form-control',
            'id' => 'balance'
        )) . "</div>";

}
echo "<div class='form-group'>" . $this->Form->input('Car.fuel_gpl', array(
        'type' => 'hidden',
        'value' => $fuelGpl,
        'checked'=>$fuelGpl,
        'id' => 'fuel_gpl'
    )) . "</div>";
echo "<div class='form-group'>" . $this->Form->input('Car.min_consumption', array(
        'type' => 'hidden',
        'value' => $minConsumption,
        'id' => 'min_consumption'
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('Car.max_consumption', array(
        'type' => 'hidden',
        'value' => $maxConsumption,
        'id' => 'max_consumption'
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('Car.reservoir', array(
        'type' => 'hidden',
        'value' => $reservoir,
        'id' => 'reservoir'
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('Car.average_speed', array(
        'type' => 'hidden',
        'value' => $averageSpeed,
        'id' => 'average_speed'
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('Car.charge_utile', array(
        'type' => 'hidden',
        'value' => $chargeUtile,
        'id' => 'charge_utile'
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('Car.volume_palette', array(
        'type' => 'hidden',
        'value' => $volumePalette,
        'id' => 'volume_palette'
    )) . "</div>";


echo "<div class='form-group'>" . $this->Form->input('Car.nb_palette', array(
        'type' => 'hidden',
        'value' => $nbPalette,
        'id' => 'nb_palette'
    )) . "</div>";

echo "<div class='form-group'>" . $this->Form->input('Car.Fuel.name', array(
        'type' => 'hidden',
        'value' =>$fuelName,
        'id' => 'fuel_name'
    )) . "</div>";
echo "<div class='form-group'>" . $this->Form->input('Car.Fuel.price', array(
        'type' => 'hidden',
        'value' =>$fuelPrice,
        'id' => 'fuel_price'
    )) . "</div>";
echo "<div class='form-group'>" . $this->Form->input('Carmodel.'.$consumptionPrice, array(
        'type' => 'hidden',
        'id' => 'consumption_model',
        'value' =>$consumptionModel,
    )) . "</div>";
if($fuelGpl) {
    echo "<div class='form-group'>" . $this->Form->input('Car.min_consumption_gpl', array(
            'type' => 'hidden',
            'value' => $minConsumptionGpl,
            'id' => 'min_consumption_gpl'
        )) . "</div>";
    echo "<div class='form-group'>" . $this->Form->input('Car.max_consumption_gpl', array(
            'type' => 'hidden',
            'value' => $maxConsumptionGpl,
            'id' => 'max_consumption_gpl'
        )) . "</div>";
    echo "<div class='form-group'>" . $this->Form->input('Car.reservoir_gpl', array(
            'type' => 'hidden',
            'value' => $reservoirGpl,
            'id' => 'reservoir_gpl'
        )) . "</div>";
    echo "<div class='form-group'>" . $this->Form->input('Carmodel.consumption_05', array(
            'type' => 'hidden',
            'id' => 'consumption_model_gpl',
            'value' =>$consumptionModelGpl,
        )) . "</div>";
    echo "<div class='form-group'>" . $this->Form->input('Car.price_gpl', array(
            'type' => 'hidden',
            'value' =>$priceGpl,
            'id' => 'price_gpl'
        )) . "</div>";
}




if ((empty ($minConsumption)||empty ($maxConsumption) || empty($reservoir)) &&  (empty($consumptionModel) || empty($reservoir))){ ?>

    <p style='color: #a94442;'>       <?php  echo __('For estimating consumption, you must insert value of min consumption, max consumption, reservoir from car fields or the value of Nb Km for 1coupon in the fields of car model');  ?></p>


<?php }

?>

<script type="text/javascript">


    $(document).ready(function() {

        if (jQuery('#fuel_gpl').val()==1) {
            jQuery('#gpl').css( "display", "block" );




        } else {
            jQuery('#gpl').css( "display", "none" );


        }

    });




</script>

