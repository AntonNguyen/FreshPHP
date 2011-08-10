<?php
require_once 'PHPUnit/Framework.php';
require '../arraytoxml.php';

class arraytoxmlTest extends PHPUnit_Framework_TestCase {
	/*
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
*/
	public function test_convert_full_array_to_xml() {
		$expected = '<?xml version="1.0"?>
					<response>
						<invoice>
							<invoice_id>15</invoice_id>
							<client_id>14</client_id>
							<lines>
								<line>
									<line_id>1</line_id>
									<description>cowbows</description>
								</line>
								<line>
									<line_id>2</line_id>
									<description>aliens</description>
								</line>
							</lines>
							<contacts>
								<contact>
									<contact_id>2</contact_id>
								</contact>
								<contact>
									<contact_id>1</contact_id>
								</contact>
								<contact>
									<contact_id>3</contact_id>
								</contact>
							</contacts>
						</invoice>
					</response>';

		$actual = new array2xml("invoice.list", 
			array("invoice" => 
					array(
						"invoice_id" => "15",
						"client_id" => "14",
						"lines" =>
							array("line" => 
								array(
									array(
										"line_id" => "1",
										"description" => "cowbows"
										),
									array(
										"line_id" => "2",
										"description" => "aliens"
										)
									)
								),
						"contacts" =>
							array("contact" =>
								array(
									array(
										"contact_id" => "2"
									),
									array(
										"contact_id" => "1"
									),
									array(
										"contact_id" => "3"
									)
								)
							)
						)
					)
			);

		$actual = $actual->getXML();

		//Remove all whitespace
		$actual = str_replace("\n", "", $actual);
		$expected = str_replace("\n", "", $expected);
		$expected = str_replace("\t", "", $expected);

		$this->assertEquals($expected, $actual);
	}

	// public function test_convert_xml_to_array() {
	// 	$invoice = new APICall("invoice", "https://anton.freshbooks.com", array());
	// 	$this->assertEquals("", $invoice->xml2array(""));
	// }
}
?>