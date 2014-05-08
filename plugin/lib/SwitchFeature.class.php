<?php

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "Feature.class.php");

class SwitchFeature extends Feature{

	private $type = "switch";

	public function getFlag(){
		if(isset($this->value)){
			if(strtolower($this->value) == "on"){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}

?>