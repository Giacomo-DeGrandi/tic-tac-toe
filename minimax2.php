<?php


function ia($board,$sign){	// 
	global $board,$sign,$turn,$depth;
	function move($state,$sign){
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
			return win($state);
		}
		if($depth==0||$depth%2 === 0){
			maxi($state,$depth);
		} elseif($depth==0||$depth%2 !== 0)
			mini($state,$depth);
		}
	}
	function maxi($state,$depth){
	$bestmove=-1000;
		for($i=0;$i<3;$i++){
			for($j=0;$j<3;$j++){	//	check each cell
				if($state[$i][$j]===0){	// if free
					$state[$i][$j]=$sign;  // add a mark
					$value=minimax($state,$depth+1);	//	call minimax to test
					$state[$i][$j]=0;  // reset the state
					$value=max($value,$bestmove);

				}
			}	
		}
	$board=$move;
	return $board;
	}
	function mini($state,$depth){
	$bestmove=-1000;
		for($i=0;$i<3;$i++){
			for($j=0;$j<3;$j++){	//	check each cell
				if($state[$i][$j]===0){	// if free
					$state[$i][$j]=$sign;  // add a mark
					$value=minimax($state,$depth+1);	//	call minimax to test
					$state[$i][$j]=0;  // reset the state
					$value=min($value,$bestmove);
				}
			}	
		}
	$board=$move;
	return $board;
	}
	function win($state){
	for($i=0;$i<3;$i++){
		for($j=0;$j<3;$j++){	// horizontals
			if( $state[$i][0] ===  1 and $state[$i][1] ===  1 and $state[$i][2] ===  1){
				return 
			}
			if($state[$i][0] ===  2 and $state[$i][1] ===  2 and $state[$i][2] ===  2){
				echo 'win2';
			}
		}
	}
	for($i=)
	var_dump($state);
} 
}

?>
