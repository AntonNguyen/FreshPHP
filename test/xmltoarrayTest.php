<?php
require_once 'PHPUnit/Framework.php';
require '../xmltoarray.php';

class xmltoarrayTest extends PHPUnit_Framework_TestCase {

	public function test_convert_full_xml_to_array() {
		$expected = array("invoice" => 
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
						);


		// $expected = array();
		$xml = '<?xml version="1.0"?>
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

		$actual = new xmltoarray($xml);
		$this->assertEquals($expected, $actual->getArray());
	}
}
?>