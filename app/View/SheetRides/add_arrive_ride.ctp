<?php
if(Configure::read("transport_personnel") == '1'){
    echo  $this->element('add_arrive_ride_personal_transport');
}else {
    if (Configure::read("gestion_commercial") == '1') {
        echo $this->element('add_arrive_ride_utranx');
    } else {

        echo $this->element('add_arrive_ride_fms');
    }
}
?>

