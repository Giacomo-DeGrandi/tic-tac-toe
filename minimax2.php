<?php


function ia($board,$sign){	 
	$state=$board;
	global $board,$state,$sign,$turn,$depth;

	//_____MOVE______//
	function move($state,$sign){														
	$bestmove=-1000;
		for($i=0;$i<3;$i++){
			for($j=0;$j<3;$j++){	//	check each cell
				if($state[$i][$j]===0){	// if free
					var_dump($state[$i][$j]);
					$state[$i][$j]=$sign;  // add a test mark
					$value=minimax($state,$depth=0);	//	call minimax to test
					$state[$i][$j]=0;  // reset the state
					$newmove=max($value,$bestmove);
					echo $newmove;
				}
			}	
		}
	}

	move($state,$sign);

	//_____MINIMAX______//
	function minimax($state,$sign,$depth){
	echo 'minimax';
	return 300;
	/*
	$bestmove=-1000;
		if(winner($state) != 0){
			$score=scores(winner($state));
			$score=$bestmove-$score;
			echo $score;
		} elseif($depth===0||$depth%2===0){
			maxi($state,$depth);
		} elseif($depth===1||$depth%2!==0){
			mini($state,$depth);
		}*/
	}

	//___SCORES___//
	function scores($state){
		echo 'scores';
		if(winner($state)==1){			// if p1
			return -100;
		} elseif (winner($state)==2){	// if p2
			return 100;
		} elseif (winner($state)==3){	// if tie 
			return 0;		
		}
	}

	//_____MAXI______//
	function maxi($state,$depth){
		echo 'maxi';/*
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
	return $value;*/
	}		

	//_____MINI______//
	function mini($state,$depth){
	echo 'mini';/*
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
	return $value;*/
	}

	//_____WINNER______//
	function winner($state){
				echo 'winner';
		$win1=0;
		$win2=0;
		for($i=0;$i<3;$i++){	
				if  ($state[$i][0]===1 and $state[$i][1]===1 and $state[$i][2]===1){	return 1; $win1++; // horizontals
			} elseif($state[$i][0]===2 and $state[$i][1]===2 and $state[$i][2]===2){	return 2; $win2++; // horizontals
			} elseif($state[0][$i]===1 and $state[1][$i]===1 and $state[2][$i]===1){	return 1; $win1++; // verticals
			} elseif($state[0][$i]===2 and $state[1][$i]===2 and $state[2][$i]===2){	return 2; $win2++; // vertical
			} elseif($state[0][0]===1 and $state[1][1]===1 and $state[2][2]===1){ 	return 1;	$win1++; // diag
			} elseif($state[0][0]===2 and $state[1][1]===2 and $state[2][2]===2){ 	return 2;	$win2++; // diag
			} elseif($state[2][0]===1 and $state[1][1]===1 and $state[0][2]===1){	return 1;	$win1++; // diag2
			} elseif($state[2][0]===2 and $state[1][1]===2 and $state[0][2]===2){	return 2; 	$win2++; // diag2
			}
		}
		$checkdraw=0;
		for($i=0;$i<3;$i++){
			for($j=0;$j<3;$j++){
				if($state[$i][$j]===0){	// count free cells, the match it's not finished
					$checkdraw++;
				}
			}
		}
		if($checkdraw>0 and $win1==0 and $win2==0){	// if the match is not finish and we don't have winner return 'play'(0)
			return 0;
		}
		if($checkdraw===0 and $win1==0 and $win2==0){	// if the match is not finish and we don't have winner return 'tie'(3)
			return 3;
		}
	}

	$_SESSION['turn']++;
}

?>
