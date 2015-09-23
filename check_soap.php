<?php
$client = new SoapClient("system/AvaTax4PHP/classes/wsdl/Tax.wsdl", array('exceptions' => 0));
echo "<p>GetTax Types: </p>";
print_r($client->__getTypes());
echo "<p>Get Tax Funcions: </p>";
print_r($client->__getFunctions());  
?>
