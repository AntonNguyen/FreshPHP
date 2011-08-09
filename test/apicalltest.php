<?php
require_once 'PHPUnit/Framework.php';
require '../client.php';

class APICallTest extends PHPUnit_Framework_TestCase {
	public function testCall() {
		$this->assertTrue(true);
	}

	public function test_convert_empty_array_to_xml() {
		$invoice = new APICall("invoice", "https://anton.freshbooks.com", array());

		$expected = '<?xml version="1.0"?><root/>';
		$actual = $invoice->array2xml("<root/>", array());
		$actual = str_replace("\n", "", $actual);

		$this->assertEquals($expected, $actual);
	}

	public function test_convert_full_array_to_xml() {
		$invoice = new APICall("invoice", "https://anton.freshbooks.com", array());

		$expected = '<?xml version="1.0"?><root><invoice><invoice_id>15</invoice_id><client_id>14</client_id></invoice></root>';
		$actual = $invoice->array2xml("<root/>", 
			array("invoice" => 
				array(
					"invoice_id" => "15",
					"client_id" => "14"
				)
			));

		$actual = str_replace("\n", "", $actual);

		$this->assertEquals($expected, $actual);
	}

	public function test_convert_xml_to_array() {
		$invoice = new APICall("invoice", "https://anton.freshbooks.com", array());
		$this->assertEquals("", $invoice->xml2array(""));
	}
}
?>