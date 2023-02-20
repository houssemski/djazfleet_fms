<?php 

$xml = Xml::fromArray(array('response' => $cars));
echo $xml->asXML();

?>