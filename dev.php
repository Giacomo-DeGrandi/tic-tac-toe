<?php

session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DEV</title>
</head>
<link rel="stylesheet" type="text/css" href="tris.css">
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<body>
	<header>
		<a href="index.php">index</a>
		<br>
		<h5>you're now on page <big>DEV</big></h5>
	</header>
<main>
	<form method="post">
		<input type="submit" name="reset" value="reset" id="reset">
	</form>
	<form method="post" >
		<input type="submit" name="X" value="X" class="choice">		
		<input type="submit" name="O" value="O" class="choice">
	</form>
	<span><br></span>
<?php 

if(isset($_POST['reset'])){
	session_destroy();
	header('Location:dev.php');
}


if(isset($_POST['X'])){			// initialise the game____
	$_SESSION['player']=1;
	$_SESSION['player2']=2;
	$_SESSION['humansign']='X';
	$_SESSION['aisign']='O';
	$_SESSION['turn']=0;
	$_SESSION['start']= true;
	$_SESSION['state']= [ array(0,0,0),
						array(0,0,0),
						array(0,0,0)  ]; //startstate_________

} elseif(isset($_POST['O'])){
	$_SESSION['player']=2;
	$_SESSION['player2']=1;
	$_SESSION['humansign']='O';
	$_SESSION['aisign']='X';
	$_SESSION['turn']=0;
	$_SESSION['start']= true;
	$_SESSION['state']= [ array(0,0,0),
						array(0,0,0),
						array(0,0,0)  ]; //startstate_____________
} else {
	$_SESSION['turn']=0;
}

// table ________________________________________________________________

if(isset($_SESSION['start']) and !isset($_SESSION['end'])){
	echo '<style>.choice{pointer-events: none;} </style>';
	echo '<table>';
	for($i=0;$i<3;$i++){
		echo '<tr>';
		for($j=0;$j<3;$j++){		
			echo '<td>';
			if($_SESSION['state'][$i][$j]===0){
				$cell=$i.','.$j;
				echo '<form method="post" ><input type="submit" name="'.$cell.'" value="" class="cells">';
				if(isset($_POST[$cell])){
					$_SESSION['state'][$i][$j]=$_SESSION['player'];	//add a mark to the cell
					$_SESSION['turn']++;
					//header('Location:dev.php');
				}
			echo '</form></td>';
			} elseif($_SESSION['state'][$i][$j]!==0){
				if($_SESSION['state'][$i][$j] == $_SESSION['player']){
					echo '<form method="post"><input type="submit" name="'.$_SESSION['state'][$i][$j].'" value="'.$_SESSION['humansign'].'" class="cells'.$i.'_'.$j.'"  ><style>.cells'.$i.'_'.$j.'{ pointer-events: none; }</style></form></td>';
				}
				if($_SESSION['state'][$i][$j] ==$_SESSION['player2']){
					echo '<form method="post"><input type="submit" name="'.$_SESSION['state'][$i][$j].'" value="'.$_SESSION['aisign'].'" class="cells'.$i.'_'.$j.'"  ><style>.cells'.$i.'_'.$j.'{ pointer-events: none; }</style></form></td>';
				}
			} else {
				echo '<form method="post"><input type="submit" name="'.$_SESSION['state'][$i][$j].'" value="" class="cells"></form></td>';
			}
		}
		echo '</tr>';
	}
}



if (isset($_SESSION['turn']) and isset($_SESSION['state'])  and $_SESSION['turn'] === 1 or $_SESSION['turn']%2 !== 0){
	$board=$_SESSION['state'];
	$sign=$_SESSION['player2'];
	$_SESSION['value']=true;
	$value=$_SESSION['value'];

	function ia($board,$sign){	 
		$state=$_SESSION['state'];
		$sign=$_SESSION['player2'];

		//_____MOVE______//
		function move($state,$sign){
		$bestmove=-10;
		echo 'move';														
			for($i=0;$i<3;$i++){
				for($j=0;$j<3;$j++){	//	check each cell
					if($state[$i][$j]===0){	// if free
						$state[$i][$j]=$sign;  // add a test mark
						$value=minimax($state,$sign,$depth=0);	//call minimax to test	---> state sent state[$i][$j]=our sign
						$state[$i][$j]=0;  // reset the state
						if($value<$bestmove){
							$i_ind=$i;
							$j_ind=$j;
							$state=$state[$i_ind][$j_ind];	// cause this value is the new bestmove
							return $state;
						}
						return $state;
					}
				}	
			}
		}

	//var_dump(move($state,$sign));
	return move($state,$sign);
	}

	$_SESSION['state']=ia($board,$sign);
	$_SESSION['turn']++;
}


//___SCORES___//		VALUES HUB
function scores($state){
	//var_dump($state);
	if(win($state)==1){			// if p1
		return -10;
	} elseif (win($state)==2){	// if p2
		return +10;
	} elseif (win($state)==3){	// if tie 
		return 0;		
	}
}

//_____MINIMAX______//		RECURSION CHECK & STOP
function minimax($state,$sign,$depth){
	echo 'minimax';	//has to send a value 10,-10
	$best=-10;		// value for minimax as -10 cause we are the minimising player
	$score=scores($state);	// we check the scores of this state
	echo $score;
	if($score > $best){
		return $score;
	} else {
		maxi($state,$sign,$depth+1);	// we send the state 
	}
}


//_____MAXI______//		RECURSION LOOP A, SEND TO --------------->
function maxi($state,$depth,$sign){
	echo 'maxi';
$sign=$_SESSION['player'];
$best=+10;
$score=scores($state);
echo $score;
if($score > $best || $depth===9 ){
	return $score;
}
	for($i=0;$i<3;$i++){
		for($j=0;$j<3;$j++){	//	check each cell
			if($state[$i][$j]===0){	// if free
				$state[$i][$j]=$sign;  // add human mark cause in play we added ai
				mini($state,$depth+1,$sign);
				$state[$i][$j]=0;  // reset
			}
		}	
	}
}

//_____MINI______//		RECURSION LOOP B, RECEIVE FROM <---------------
function mini($state,$depth,$sign){
	echo 'mini';
$sign=$_SESSION['player2'];
$best=-10;
$score=scores($state);
if($score < $best || $depth===9){
	return $score;
}
	for($i=0;$i<3;$i++){
		for($j=0;$j<3;$j++){	//	check each cell
			if($state[$i][$j]===0){	// if free
				$state[$i][$j]=$sign;  // add ai mark cause in play we added human
				minimax($state,$depth+1,$sign);
				$state[$i][$j]=0;  // reset
			}
		}	
	}
}


function win($state){
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

if(isset($_SESSION['state'])){echo win($_SESSION['state']);}

if(isset($_SESSION['turn']) and $_SESSION['turn']=== 10){
	session_destroy();
	header('Location:dev.php');
}



?>
</main>
	<footer>
	</footer>
</body>
</html>