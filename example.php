<?php
include("client.php");

$fb = new TokenClient("https://anton.freshbooks.com/api/2.1/xml-in", "909227272c43ac27702c6b2dca7aeeb0");

$result = $fb->item->list();
var_dump($result);
// foreach ($invoices['invoices']['invoice'] as $invoice) {
// 	var_dump($invoice['invoice_id']);
// }

?>