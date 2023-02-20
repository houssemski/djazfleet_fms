<div class="info-global">
    <?php
    $i =0;
    if(!empty($sheetRides)) {
    foreach ($sheetRides as $sheetRide){

        $h_dep = $this->Time->format($sheetRide['SheetRideDetailRideDepartures']['planned_start_date'], '%H:%M');
        $h_arri = $this->Time->format($sheetRide['SheetRideDetailRideArrivals']['planned_end_date'], '%H:%M');

        $h1=strtotime( $h_dep);
        $h2=strtotime($h_arri);


        ?>
<div style="border-bottom: 1px solid #e6e6e6;  padding-bottom: 10px;color: rgba(0, 0, 0, 0.87);">
        <div class ='p-info-global2' >
            <?php
            echo $this->Html->image('transit_black.png' ,
                array(
                        'class'=>'img-transit'
                )); ?>
            <?php echo $this->Time->format($sheetRide['SheetRideDetailRideDepartures']['planned_start_date'], '%H:%M').'  -  ' . $this->Time->format($sheetRide['SheetRideDetailRideArrivals']['planned_end_date'], '%H:%M') ; ?>


            <span class="duree-inter2"><?php echo '  '. date('H',$h2-$h1) .' h '. date('i',$h2-$h1).' min '?></span>
        </div>
    <div class="img-ref">
        <?php

        echo $this->Html->image('bus2.png' ,
            array(
                'class' => "img-bus",
            )); ?>
    <div class="ref"><?php echo $sheetRide['SheetRide']['reference'] ; ?></div>
</div>
        <div onclick="getSheetRideDetails(id)" id ='<?php echo $sheetRide['SheetRide']['id']?>' class ='blue-button-text'>Details</div>
</div>
        <?php
        $i ++ ;
    }
        }
        else { ?>
    <div style="border-bottom: 1px solid #e6e6e6;  padding-bottom: 10px;color: rgba(0, 0, 0, 0.87);">
        <p class="p-info">Il n'en a plus de lignes pour aujourd'hui</p>

    </div>
  <?php  }
    ?>
</div>