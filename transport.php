<?php
include("arraytoxml.php");

class Transport {
	protected $name, $domain, $curl_options;

	function __construct($name, $domain, $curl_options) {
		$this->name = $name;
		$this->domain = $domain;
		$this->curl_options = $curl_options;
	}

	// TO DO: REFACTOR!!!!!
	function __call($method, $args) {

		$defaults = array(
			CURLOPT_HEADER => false,
			CURLOPT_NOBODY => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_TIMEOUT => 4,
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_SSL_VERIFYHOST => FALSE,
			CURLOPT_USERAGENT => "FreshPHP",
		);

		// Convert from an array to xml

		
		$root->addAttribute("method", $this->name . "." . $method);
		$xml = $this->array2xml($root, $args);

		// // 2) Make the call to our api
		// $ch = curl_init($this->domain);
		// curl_setopt_array($ch, ($this->curl_options + $defaults));
		// curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
		// 
		// $result = curl_exec($ch);
		// if (!$result) {
		// 	trigger_error(curl_error($ch));
		// } 
		// 
		// 	    curl_close($ch);0
		// 
		// // Examine the xml element
		// $xml = parse($result);
		// if ($xml && isset($xml['status'])) {
		// 	if ($xml['status'] != "ok") {
		// 		return "Error: " . (string)$xml->error;
		// 	}
		// 
		// 	// Convert to array and return
		// 	return $this->parse($result);
		// 
		// } else {
		// 	// Error
		// }
		// return $result;
		return "";
	}

}

?>