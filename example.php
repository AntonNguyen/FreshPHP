<?php
include("client.php");

$fb = new TokenClient("https://[subdomain].freshbooks.com/api/2.1/xml-in", "[apikey]");
var_dump($fb->invoice->list());

?>