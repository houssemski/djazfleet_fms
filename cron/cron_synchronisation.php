<?php
$login = 'admin';
$password = 'intellix';
$urls = array(
    'http://localhost/utranx/cars/SynchronisationKmCron',

);
foreach ($urls as $url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
    $result = curl_exec($ch);
    curl_close($ch);
    echo($result);
}
sleep(10);
