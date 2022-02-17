<?php

if (isset($_SESSION['turn']) and isset($_SESSION['state'])){
	$board=$_SESSION['state'];
	$state=$board;
	$sign=$_SESSION['player2'];

	//____IA______//
	function ia($state,$sign){	 

		//_____MOVE______//
		function move($state,$sign){
			//echo 'move!';
			
			
			//play the center if free... here's the cheat
			for($i=0;$i<3;$i++){
					for($j=0;$j<3;$j++){	//	check each cell
						if($state[1][1]===0 and $state[1][1]!==$_SESSION['player']){
							$state[1][1]=$_SESSION['player2'];
							return $state;
						}
					}
			}

			$bestmove=-1000;
			$scorestate=[];
				for($i=0;$i<3;$i++){
					for($j=0;$j<3;$j++){	//	check each cell
						if($state[$i][$j]===0){	// if free
							$state[$i][$j]=$sign;  // add a test mark
							//var_dump($sign);
							$score=minimax($state,false,$depth=true);	// get score for the cell;
							//var_dump($score);
							$scorestate[]=$state;
							if($score>$bestmove){
								$bestmove=$score;
								$newstate=$state;
							}
							$state[$i][$j]=0;  // reset the cell
						}
					}
				}
				if(isset($newstate)){
					return $newstate;
				}
		}	//move
		$move=move($state,$sign);
		//var_dump($move);
		return $move;
	}	//ia


	//___when to play___//
	$p1=0;
	$p2=0;
	for($i=0;$i<3;$i++){
		for($j=0;$j<3;$j++){
			if($state[$i][$j]==$_SESSION['player']){
				$p1++;
			}
			if($state[$i][$j]==$_SESSION['player2']){
				$p2++;
			}
		}
	}
	$moves=$p1+$p2;
	if($p2<$p1 and ($p1+$p2<=9)){
		//__call ia______//
		$_SESSION['state']=ia($board,$_SESSION['player2']);
		$_SESSION['turn']++;	
	}
}

function minimax($state,$max,$depth){
	$score=winner($state);
	//var_dump($score);
	if ($score!==1){
		return $score;
	}
		if($max){	// maxi 2
			//echo 'max';
			$maxi=-1000;
				for($i=0;$i<3;$i++){
					for($j=0;$j<3;$j++){	//	check each cell
						if($state[$i][$j]===0){	// if free
							$state[$i][$j]=$_SESSION['player2'];
							//var_dump($depth);
							$maxi=max($maxi,minimax($state,$depth++,!$max));	
							$state[$i][$j]=0;
						}
					}	
				}
			return $maxi;
		} else {	// mini 1
			//echo 'min';
			$mini=1000;
				for($i=0;$i<3;$i++){
					for($j=0;$j<3;$j++){	//	check each cell
						if($state[$i][$j]===0){	// if free
							$state[$i][$j]=$_SESSION['player'];
							$mini=min($mini,minimax($state,$depth++,!$max));
							$state[$i][$j]=0;
						}
					}	
				} 
			return $mini;
		}
}


//_____winner
function winner($state){

	$p1=0;
	$p2=0;
	for($i=0;$i<3;$i++){
		for($j=0;$j<3;$j++){
			if($state[$i][$j]==$_SESSION['player']){
				$p1++;
			}
			if($state[$i][$j]==$_SESSION['player2']){
				$p2++;
			}
		}
	}
	$moves=$p1+$p2;
	if($moves===9){
		return 0;
	}
	if($state[0][0] !== 0){
		if( $state[0][0]===$state[0][1] and 
			$state[0][1]===$state[0][2]){		//h first row
			$sign=$state[0][0];
			if($sign===$_SESSION['player']){ return -10;} elseif($sign===$_SESSION['player2']){ return 10;}
		}
		if( $state[0][0]===$state[1][0] and
			$state[1][0]===$state[2][0]){		//v first col
			$sign=$state[0][0];
			if($sign===$_SESSION['player']){ return -10;} elseif($sign===$_SESSION['player2']){ return 10;}
		}
		if( $state[0][0]===$state[1][1] and 
			$state[1][1]===$state[2][2]){		//d first diag
			$sign=$state[0][0];
			if($sign===$_SESSION['player']){ return -10;} elseif($sign===$_SESSION['player2']){ return 10;}
		}

	}

	if($state[1][1] !== 0){
		if( $state[1][0]===$state[1][1] and 
			$state[1][1]===$state[1][2]){		//h middle row
			$sign=$state[1][1];
			if($sign===$_SESSION['player']){ return -10;} elseif($sign===$_SESSION['player2']){ return 10;}
		}
		if( $state[0][1]===$state[1][1] and
			$state[1][1]===$state[2][1]){		//v middle col
			$sign=$state[1][1];
			if($sign===$_SESSION['player']){ return -10;} elseif($sign===$_SESSION['player2']){ return 10;}
		}
		if( $state[0][2]===$state[1][1] and 
			$state[1][1]===$state[2][0]){		//d second diag
			$sign=$state[1][1];
			if($sign===$_SESSION['player']){ return -10;} elseif($sign===$_SESSION['player2']){ return 10;}
		}

	}
	if($state[2][2] !== 0){	
		if( $state[2][0]===$state[2][1] and 
			$state[2][1]===$state[2][2]){		//h last row
			$sign=$state[2][2];
			if($sign===$_SESSION['player']){ return -10;} elseif($sign===$_SESSION['player2']){ return 10;}
		}
		if( $state[0][2]===$state[1][2] and
			$state[1][2]===$state[2][2]){		//h last row
			$sign=$state[2][2];
			if($sign===$_SESSION['player']){ return -10;} elseif($sign===$_SESSION['player2']){ return 10;}
		}		
	}
	return 1;
}



?>
