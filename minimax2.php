<?php



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
		$_SESSION['scoremax']=0;
		$_SESSION['scoremin']=0;
			for($i=0;$i<3;$i++){
				for($j=0;$j<3;$j++){	//	check each cell
					if($state[$i][$j]===0){	// if free
						$state[$i][$j]=$sign;  // add a test mark
						$score=minimax($state,$sign,$_SESSION['depth']=0);	// get score for the cell;
						//$scoreseries=series($state,$_SESSION['player']);
						//$score=$scoreseries+$score;
						$scorelist[]=$score;
						$stateorder[]=$state;
						$state[$i][$j]=0;  // reset the cell
					}
				}
			}
			var_dump($scorelist);
			$index = array_search(min($scorelist), $scorelist);
			var_dump($index);
			var_dump($stateorder);

			return $stateorder[$index];

		}

	// CALL MOVE
	$move=move($state,$sign);
	//var_dump($move);
	return $move;
	}

	// CALL IA
	$_SESSION['state']=ia($board,$sign);
}




//_____MINIMAX______//	__________________________________________________________________
function minimax($state,$sign,$depth){

	//echo '-miniMax';
		// VALUES AND TURNS HUB
	$_SESSION['score']=0;
	$_SESSION['score2']=0;
	if($sign===$_SESSION['player'] ){	// we simulate turns every time minimax is called
		$_SESSION['score']=maxi($state,$_SESSION['depth'],$sign,$_SESSION['score'])+$_SESSION['score'];	
	} elseif ($sign===$_SESSION['player2'] ){
		$_SESSION['score2']=mini($state,$_SESSION['depth'],$sign,$_SESSION['score2'])+$_SESSION['score2'];
	}
	$score=$_SESSION['score']-$_SESSION['score2'];
	return $score;

}


//_____MAXI______//
function maxi($state,$depth,$sign,$score){
//echo '-maxi';
$score=scores($state);	// we are now scoring move
//var_dump($state);
//var_dump($score);
if($score!==0){
	return $score;
}
$bestmove=10;
	for($i=0;$i<3;$i++){
		for($j=0;$j<3;$j++){	//	check each cell
			if($state[$i][$j]===0){	// if free
				$state[$i][$j]=$sign;  // add human mark cause in play we added ai
				$score=mini($state,$_SESSION['depth']++,$_SESSION['player2'],$_SESSION['score']);
				$scoreseries=series($state,$_SESSION['player']);
				$score=$score+$scoreseries;
				if($score>$bestmove){
				$_SESSION['score']=$score+$_SESSION['score'];
				$bestmove=$_SESSION['score']+1;
				} else {
					$score=$score+1;	// turn value
				}
				$state[$i][$j]=0;
			}
		}	
	}
	//var_dump($_SESSION['score']);
	return $score;
}

//_____MINI______//	

function mini($state,$depth,$sign,$score){
//echo '-mini';
$score=scores($state);
//var_dump($state);
//var_dump($score);
if($score!==0){
	return $score;
}
$bestmove=-10;
	for($i=0;$i<3;$i++){
		for($j=0;$j<3;$j++){	//	check each cell
			if($state[$i][$j]===0){	// if free
				$state[$i][$j]=$sign;  // add ai mark cause in play we added human
				$score=maxi($state,$_SESSION['depth']++,$_SESSION['player'],$_SESSION['score2']);
				$scoreseries=series($state,$_SESSION['player2']);
				$score=$score+$scoreseries;
				if($score<$bestmove){
					$_SESSION['score2']=$score+$_SESSION['score2'];
					$bestmove=$_SESSION['score2']+1;
				} else {
					$score= $score+1;	// turn value
				}
				$state[$i][$j]=0;
			}
		}	
	}
	//var_dump($_SESSION['score2']);
	return $score;
}


//___SCORES___//		SCORES HUB
function scores($state){
	//echo '-score';
	$win=win1($state);
	if($win==1){	// if p1
		return +10;
	} elseif ($win==2){	// if p2
		return -10;
	} elseif ($win==3){	// if tie 
		return 0;		
	} elseif ($win==0){	// if still playing 
		return 0;	
	}
}

//_____SERIES_____//    count series of 2 pawns

function series($state,$player){
	$scoreserie=0;
	for($i=0;$i<3;$i++){
		if( $state[$i][0]==$player and $state[$i][1]==$player || 
			$state[$i][1]==$player and $state[$i][2]==$player){		//_horizontals
			$scoreserie++;
		}
		if(	$state[0][$i]==$player and $state[1][$i]==$player ||
			$state[1][$i]==$player and $state[2][$i]==$player){		//_verticals
			$scoreserie++;
		}
		if( $state[0][0]==$player and $state[1][1]==$player||
			$state[1][1]==$player and $state[2][2]==$player){
			$scoreserie++;		
		}
		if( $state[2][0]==$player and $state[1][1]==$player ||
			$state[1][1]==$player and $state[0][2]==$player){
			$scoreserie++;		
		}
	}
	return $scoreserie+2;

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
	if($checkdraw<0 ){	// if the match is not finish and we don't have winner return 'play'(0)
		return 0;
	}
	if($checkdraw>=0 ){	// if the match is finish and we don't have winner return 'tie'(3)
		return 3;
	}
}



?>
