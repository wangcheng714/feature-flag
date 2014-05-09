<?php


class AfterDateFeature extends Feature{

	private $type = "afterDate";

	public function getFlag(){
		if(isset($this->value)){
			$goalStamp = strtotime($this->value);
			$nowStamp = strtotime("now");
			if($nowStamp > $goalStamp){
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