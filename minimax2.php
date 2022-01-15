<?php


function ia($board,$sign){	// 
	global $board,$sign,$turn,$depth;
	function evaluate($state,$sign){
	$bestmove=-1000;
		for($i=0;$i<3;$i++){
			for($j=0;$j<3;$j++){	//	check each cell
				if($state[$i][$j]===0){	// if free
					$state[$i][$j]=$sign;  // add a mark
					$value=minimax($state,$depth=0);	//	call minimax to test
					$state[$i][$j]=0;  // reset the state
					$value=max($value,$bestmove);	
				}
			}	
		}
	$board=$move;
	return $board;
	}
	function minimax($state,$sign,$depth){
	$bestmove=-1000;
		if(win($state) != 0){
			if(maxi($state,$sign,$depth+1)==true){
				return maxi($state,$sign,$depth+1);
			} elseif (mini($state,$sign,$depth+1)){
				return mini($state,$sign,$depth+1);
			}
		}
	}
}

?>
