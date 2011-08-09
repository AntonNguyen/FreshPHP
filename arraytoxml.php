<?php
/**
* basic class for converting an array to xml.
* @author Matt Wiseman (trollboy at shoggoth.net)
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
			throw new Exception('array2xml requires an array', 1);
			unset($this);
		}

		$this->data = new DOMDocument('1.0');

		$this->dom_tree = $this->data->createElement('response');

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
		foreach($data as $key=>$value){
			if(is_array($value)){
				$sub_obj[$i] = $this->data->createElement($key);
				$obj->appendChild($sub_obj[$i]);

				// If array has no keys
				if (!$this->is_associative($value)) {
					// Go through each sub_value in the array and add it
					foreach($value as $sub_value) {
						$this->recurse_node($sub_value, $sub_obj[$i]);
					}
				} else {
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