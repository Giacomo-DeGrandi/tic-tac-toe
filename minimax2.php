<?php

$_SESSION['score']=0;
$_SESSION['score2']=0;

if (isset($_SESSION['turn']) and isset($_SESSION['state'])  and $_SESSION['turn'] === 1 or $_SESSION['turn']%2 !== 0){
	$board=$_SESSION['state'];
	$sign=$_SESSION['player2'];

	function ia($board,$sign){	 
		$sign=$_SESSION['player2'];
		$state=$_SESSION['state'];


		//_____MOVE______//
		function move($state,$sign){
		//echo 'move!';
		$scorelist=[];
		$stateorder=[];
		$bestmove=-1000;
			for($i=0;$i<3;$i++){
				for($j=0;$j<3;$j++){	//	check each cell
					if($state[$i][$j]===0){	// if free
						$state[$i][$j]=$sign;  // add a test mark
						$score=mini($state,$sign,$depth=0);	// get score for the cell;
						var_dump($score);
						if($score>$bestmove){
							$bestmove=$score;
							$newstate=$state;
						}
						$state[$i][$j]=0;  // reset the cell
					}
				}
			}
			var_dump($newstate);
			return $newstate;

		}

	// CALL MOVE

	$move=move($state,$sign);
	return $move;

	}

	// CALL IA

	$_SESSION['state']=ia($board,$sign);

}



//_____MAXI______//
function maxi($state,$depth,$sign){
//echo '-maxi';
$score=evaluate($state,$sign);
if($score==1){
	$score=$score+series($state,$sign);	
	return $score;
} elseif ($score!=0 and $score!=1) {
	return $score;
} else { 
	$bestmove=-1000;
	$pawns=0;
		for($i=0;$i<3;$i++){
			for($j=0;$j<3;$j++){	//	check each cell
				if($state[$i][$j]==$sign){
					$pawns++;
				}
				if($state[$i][$j]===0){	// if free
					$state[$i][$j]=$sign;  // add human mark cause in play we added ai
					$score=mini($state,$depth++,$sign);
					if($score>$bestmove){
					$bestmove=$score;
					}
					$state[$i][$j]=0;
				}
			}	
		}
		return $bestmove-$pawns;
	}
}

//_____MINI______//	

function mini($state,$depth,$sign){
//echo '-mini';
$score=evaluate($state,$sign);
if($score==1){
	$score=$score+series($state,$sign);	
	return $score;
} elseif ($score!=0 and $score!=1) {
	return $score;
} else {
	$bestmove=1000;
	$pawns=0;
		for($i=0;$i<3;$i++){
			for($j=0;$j<3;$j++){	//	check each cell
				if($state[$i][$j]==$sign){
					$pawns++;
				}
				if($state[$i][$j]===0){	// if free
					$state[$i][$j]=$sign;  // add ai mark cause in play we added human
					$score=maxi($state,$depth++,$_SESSION['player']);
					if($score<$bestmove){
						$bestmove=$score;
					}
					$state[$i][$j]=0;
				}
			}	
		}
	return $bestmove+$pawns;
	}
}

	//_____series  count series of 2 pawns
		function series($state,$player){
			$scoreserie=0;
			$scoreserie1=0;
			$scoreserie2=0;
			for($i=0;$i<3;$i++){
				if( $state[$i][0]==$player and $state[$i][1]==$player || 
					$state[$i][1]==$player and $state[$i][2]==$player){		//_horizontals
					if($player==1){
						$scoreserie1++;
					}
					if($player==2){
						$scoreserie2++;
					}
				}
				if(	$state[0][$i]==$player and $state[1][$i]==$player ||
					$state[1][$i]==$player and $state[2][$i]==$player){		//_verticals
					if($player==1){
						$scoreserie1++;
					}
					if($player==2){
						$scoreserie2++;
					}
				}
				if( $state[0][0]==$player and $state[1][1]==$player||
					$state[1][1]==$player and $state[2][2]==$player){
					if($player==1){
						$scoreserie1++;
					}
					if($player==2){
						$scoreserie2++;
					}		
				}
				if( $state[2][0]==$player and $state[1][1]==$player ||
					$state[1][1]==$player and $state[0][2]==$player){
					if($player==1){
						$scoreserie1++;
					}
					if($player==2){
						$scoreserie2++;
					}		
				}
			}
			$scoreserie=$scoreserie2-$scoreserie1;
			return $scoreserie*10;
		}


//___EVALUATE___//		SCORES HUB
function evaluate($state,$player){
	
	$win=win1($state);
	if($win==1){	// if p1
		return -100;
	} elseif ($win==2){	// if p2
		return +100;
	} elseif ($win==3){	// if tie 
		return 1;		
	} elseif ($win==0){	// if still playing 
		return 0;
	}	//elseif
}



function win1($state){
	for($i=0;$i<3;$i++){	
			if  ($state[$i][0]===1 and $state[$i][1]===1 and $state[$i][2]===1){	return 1; // horizontals
		} elseif($state[$i][0]===2 and $state[$i][1]===2 and $state[$i][2]===2){	return 2; // horizontals
		} elseif($state[0][$i]===1 and $state[1][$i]===1 and $state[2][$i]===1){	return 1; // verticals
		} elseif($state[0][$i]===2 and $state[1][$i]===2 and $state[2][$i]===2){	return 2; // verticals
		} elseif($state[0][0]===1 and $state[1][1]===1 and $state[2][2]===1){ 	return 1; // diag
		} elseif($state[0][0]===2 and $state[1][1]===2 and $state[2][2]===2){ 	return 2; // diag
		} elseif($state[2][0]===1 and $state[1][1]===1 and $state[0][2]===1){	return 1; // diag2
		} elseif($state[2][0]===2 and $state[1][1]===2 and $state[0][2]===2){	return 2; // diag2
		}
	}
	$checkdraw=-9;
	for($i=0;$i<3;$i++){
		for($j=0;$j<3;$j++){
			if($state[$i][$j]===0){	// count free cells, the match it's not finished
				$checkdraw++;
			}
		}
	}
	if($checkdraw<0 ){	// if the match is not finish and we don't have winner yet return 'play'(0)
		return 0;
	}
	if($checkdraw>=0 ){	// if the match is finish and we don't have winner return 'tie'(3)
		return 3;
	}
}



?>
