<?php


class DateFeature extends Feature{

	private $type = "date";

	public function getFlag(){
		if(isset($this->value)){
			$times = explode("|", $this->value);
			if($times[0] == "*"){
                $startStamp = 0;
			}else{
                $startStamp = strtotime($times[0]);
			}
            if($times[1] == "*"){
                $endStamp = 2145953471 * 10;
            }else{
                $endStamp = strtotime($times[1]);
            }
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