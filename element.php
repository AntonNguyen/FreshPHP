<?php

class Element {
	function __construct($name) {
	}

	function __call($method, $args) {
		print "$method\n";
		var_dump($args);
	}
}

?>