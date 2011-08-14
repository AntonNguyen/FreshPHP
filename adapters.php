<?php
/**
* Class for converting 
*
*/
class array2xml {

	public $data;
	public $dom_tree;

	/**
	* basic constructor
	*
	* @param array $array
	*/
	public  function __construct($method, $array){
		if(!is_array($array)){
			throw new Exception('An array must be provided', 1);
			unset($this);
		}

		$this->data = new DOMDocument('1.0');

		$this->dom_tree = $this->data->createElement('request');
		$this->dom_tree->setAttribute("method", $method);

		$this->data->appendChild($this->dom_tree);
		$this->recurse_node($array, $this->dom_tree);
	}

	/**
	*
	* @param array $data
	* @param dom element $obj
	*/
	private function recurse_node($data, $obj){
		$i = 0;

		if ($this->is_associative($data)) {
			foreach($data as $key=>$value){
				if(is_array($value)){

					// If array has no keys
					if (!$this->is_associative($value)) {
						// Go through each sub_value in the array and add it
						foreach($value as $sub_value) {
							$sub_obj[$i] = $this->data->createElement($key);
							$obj->appendChild($sub_obj[$i]);
							$this->recurse_node($sub_value, $sub_obj[$i]);
						}
					} else {
						$sub_obj[$i] = $this->data->createElement($key);
						$obj->appendChild($sub_obj[$i]);
						$this->recurse_node($value, $sub_obj[$i]);
					}
				} else {
					//straight up data, no weirdness
					$sub_obj[$i] = $this->data->createElement($key, $value);
					$obj->appendChild($sub_obj[$i]);
				}

				$i++;
			}
		}
	}

	/**
	* Checks if the array has keys or not
	*
	* @return string
	*/
	private function is_associative($array) {
	    return array_keys($array) !== range(0, count($array) - 1);
	}

	/**
	* get the finished xml
	*
	* @return string
	*/
	public function getXML(){
		return $this->data->saveXML();
	}
}

/**
* basic class for converting xml to an array.
*
*/
class xmltoarray {

	protected $array;

	/**
	* basic constructor
	*
	* @param array $array
	*/
	public  function __construct($xml){

		//Remove all whitespace
		$xml = preg_replace("/>\s+</", "><", $xml);

		$doc = new DOMDocument('1.0');
		$doc->loadXml($xml);

		$this->array = $this->recurse_node($doc);
	}

	/**
	*
	* @param array $data
	* @param dom element $obj
	*/
	private function recurse_node($xml){
		$children = array();
		if ($xml->hasChildNodes()) {

			foreach ($xml->childNodes as $childNode) {
				switch($childNode->nodeType) {
					case XML_ELEMENT_NODE:
						$nodeName = (string)$childNode->nodeName;

						if (isset($children[$childNode->nodeName])) {
							if ($this->is_associative($children[$childNode->nodeName])) {
								$temp = $children[$childNode->nodeName];
								$children[$childNode->nodeName] = array();
								$children[$childNode->nodeName][] = $temp;
							}

							$children[$nodeName][] = $this->recurse_node($childNode);
						} else {
							$children[$nodeName] = $this->recurse_node($childNode);
						}
						break;
					case XML_ATTRIBUTE_NODE:
						break;
					case XML_TEXT_NODE:
						return $childNode->nodeValue;
				}
			}
		} else {
			return "";
		}

		return $children;
	}

	/**
	* Checks if the array has keys or not
	*
	* @return string
	*/
	private function is_associative($array) {
	    return array_keys($array) !== range(0, count($array) - 1);
	}

	/**
	* get the finished xml
	*
	* @return string
	*/
	public function getArray(){
		return $this->array['response'];
	}
}