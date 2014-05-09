<?php


class BetweenDateFeature extends Feature{

	private $type = "betweenDate";

	public function getFlag(){
		if(isset($this->value)){
			$times = explode("|", $this->value);
			$startStamp = strtotime($times[0]);
			$endStamp = strtotime($times[1]);
			$nowStamp = strtotime("now");
			if($startStamp < $nowStamp && $nowStamp < $endStamp){
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