<?php
/**
* basic class for converting xml to an array.
*
*/
class xmltoarray {

	public $array;

	/**
	* basic constructor
	*
	* @param array $array
	*/
	public  function __construct($xml){
		$doc = new DOMDocument('1.0');
		
		//Remove all whitespace
		$xml = preg_replace("/>\s+</", "><", $xml);
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
						// Create an array of these subselements
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