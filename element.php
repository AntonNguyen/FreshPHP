<?php

class Element {
	protected $name;

	function __construct($name) {
		$this->name = $name;
	}

	function __call($method, $args) {
		$parser = new array2xml($this->name . "." . $method, $args);
		return $parser->getXML();
	}
}


?>