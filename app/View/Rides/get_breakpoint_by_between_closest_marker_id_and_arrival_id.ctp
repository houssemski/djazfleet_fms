<div class="info-global">
    <?php
    if(!empty($sheetRideDetailRideDeparture) && !empty($sheetRideDetailRideArrival)){
    $h_dep = $this->Time->format($sheetRideDetailRideDeparture['SheetRideDetailRides']['planned_start_date'], '%H:%M');
    $h_arri = $this->Time->format($sheetRideDetailRideArrival['SheetRideDetailRides']['planned_end_date'], '%H:%M');

    $h1=strtotime( $h_dep);
    $h2=strtotime($h_arri);


    ?>
    <p class ='p-info-global'><?php echo $this->Time->format($sheetRideDetailRideDeparture['SheetRideDetailRides']['planned_start_date'], '%H:%M').'  -  ' . $this->Time->format($sheetRideDetailRideArrival['SheetRideDetailRides']['planned_end_date'], '%H:%M') ; ?>
        <span class="duree"><?php echo '  ('. date('H',$h2-$h1) .' h '. date('i',$h2-$h1).' min )'?></span>
    </p>
    <?php

    echo $this->Html->image('bus2.png' ,
        array(
            'class' => "img-bus",
        )); ?>
    <div class="ref"> <?php echo $sheetRideDetailRideDeparture['SheetRide']['reference'] ; ?></div>
</div>
<p style =' font-size: 15px;color: #188038;font-weight: bold; padding-bottom: 10px;'>
<?php
$h_dep = $this->Time->format($sheetRideDetailRideDeparture['SheetRideDetailRides']['planned_start_date'], '%H:%M');
$h_arri = $this->Time->format($sheetRideDetailRides[0]['SheetRideDetailRides']['planned_start_date'], '%H:%M');

$h1=strtotime( $h_dep);
$h2=strtotime($h_arri);
?>
<div class="div-hour"  style ='color: #188038;font-weight: bold;'><?php echo $this->Time->format($sheetRideDetailRideDeparture['SheetRideDetailRides']['planned_start_date'], '%H:%M')?></div>
<i class="fa fa-map-marker" aria-hidden="true" style ='color: #188038;font-weight: bold;'></i>
<div class="div-dep" style ='color: #188038;font-weight: bold;'><?php echo $sheetRideDetailRideDeparture['Destination']['name'] ?></div>
<span class="duree-inter"><?php echo '  '. date('H',$h2-$h1) .' h '. date('i',$h2-$h1).' min '?></span>
<?php }?>
</p>
<?php
 $i =0;
 if(!empty($sheetRideDetailRides)){

foreach ($sheetRideDetailRides as $sheetRideDetailRide){

    $h_dep = $this->Time->format($sheetRideDetailRide['SheetRideDetailRides']['planned_start_date'], '%H:%M');
    $h_arri = $this->Time->format($sheetRideDetailRide['SheetRideDetailRides']['planned_end_date'], '%H:%M');

    $h1=strtotime( $h_dep);
    $h2=strtotime($h_arri);


    ?>
    <p style ='border-bottom: 1px solid #e6e6e6; padding-left: 30px;font-size: 13px;padding-bottom: 10px;color: rgba(0, 0, 0, 0.87);'>
    <div class="div-hour"><?php echo $this->Time->format($sheetRideDetailRide['SheetRideDetailRides']['planned_start_date'], '%H:%M')?></div>

    <?php
        echo $this->Html->image('waypoint-non-last-2x-v3.png' ,
        array(
            'class' => "img-circle",
        )); ?>
        <div class="div-dep"><?php echo $sheetRideDetailRide['Destination']['name'] ?></div>
    <span class="duree-inter"><?php echo '  '. date('H',$h2-$h1) .' h '. date('i',$h2-$h1).' min '?></span>

    </p>
   <?php
    $i ++ ;
}
 }
?>
<?php if(!empty($sheetRideDetailRides) && !empty($sheetRideDetailRideArrival)) {?>
<p style ='border-bottom: 1px solid #e6e6e6; font-size: 15px;color: #C5221F;font-weight: bold; padding-bottom: 10px;'>
    <?php
    $h_dep = $this->Time->format($sheetRideDetailRides[$i-1]['SheetRideDetailRides']['planned_start_date'], '%H:%M');
    $h_arri = $this->Time->format($sheetRideDetailRideArrival['SheetRideDetailRides']['planned_end_date'], '%H:%M');

    $h1=strtotime( $h_dep);
    $h2=strtotime($h_arri);
    ?>
<div class="div-hour"  style ='color: #C5221F;font-weight: bold;'><?php echo $this->Time->format($sheetRideDetailRideArrival['SheetRideDetailRides']['planned_end_date'], '%H:%M')?></div>

<i class="fa fa-map-marker" aria-hidden="true" style ='color: #C5221F;font-weight: bold;'></i>
    <div class="div-dep" style ='color: #C5221F;font-weight: bold;'> <?php echo $sheetRideDetailRideArrival['Destination']['name'] ?></div>

</p>
<?php } ?>