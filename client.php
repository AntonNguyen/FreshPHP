<?php
include("transport.php");

abstract class Client {
	abstract protected function __construct();
	protected $curl_options, $domain;

	function __get($method) {
		return new Transport($method, $this->domain, $this->curl_options);
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
		// $header[] = 'Content-Type: application/x-www-form-urlencoded';
		// 
		// $curl_options = array(
		// 	CURLOPT_HTTPHEADER => $header,
		// 	CURLOPT_POST => true,
		// 	CURLOPT_POSTFIELDS => urlencode(
		// 		"oauth_consumer_key=example.com&
		// 		oauth_signature_method=RSA-SHA1&
		// 		oauth_signature=wOJIO9A2W5mFwDgiDvZbTSMK%2FPY%3D&
		// 		oauth_timestamp=137131200&
		// 		oauth_nonce=4572616e48616d6d65724c61686176&
		// 		oauth_version=1.0"
		// 	)
		// );
	}
}


?>