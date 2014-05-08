<?php

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "Feature.class.php");

class PercentageFeature extends Feature{

	private $type = "percentage";

	public function getFlag(){
		$baiduId = $_COOKIE["BAIDUID"];
		if(isset($this->value) && isset($baiduId)){
			$num = hexdec(substr(str_ireplace(':FG=1', '', $baiduId), -6)) % 100;
			$sample = $this->value * 100;
			return $num < $sample;
		}else{
			return false;
		}
		
	}
}

?>