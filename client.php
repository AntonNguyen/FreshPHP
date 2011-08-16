<?php
include("element.php");
include("adapters.php");

abstract class Client {
	abstract protected function __construct();
	protected $curl_options, $domain, $element;

	function __get($element) {
		$this->element = new Element($element);
		return $this;
	}

	function __call($method, $args) {
		$xml = $this->element->$method($args);
		return $this->make_api_call($xml);
	}

	private function make_api_call($xml) {
		$defaults = array(
			CURLOPT_HEADER => FALSE,
			CURLOPT_NOBODY => FALSE,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_TIMEOUT => 4,
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_SSL_VERIFYHOST => FALSE,
			CURLOPT_USERAGENT => "FreshPHP",
		);

		$ch = curl_init($this->domain);
		curl_setopt_array($ch, ($this->curl_options + $defaults));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

		$result = curl_exec($ch);
		if (!$result) {
			throw new Exception(curl_error($ch));
		}

		curl_close($ch);

		$parser = new XML2Array($result);
		$array_result = $parser->getArray();

		// Examine the result

		return $array_result;
	}

}

class TokenClient extends Client {
	function __construct($domain, $token) {
		$this->domain = $domain;
		$this->curl_options = array(
			CURLOPT_USERPWD => $token
		);
	}
}

class OAuthClient extends Client {
	function __construct() {
	}
}

?>