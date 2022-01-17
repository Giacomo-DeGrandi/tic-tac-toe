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
		$stateresults=[];
		$scoreresults=[];
		echo 'move!';
		$bestmove=-10;
		$count=0;
			for($i=0;$i<3;$i++){
				for($j=0;$j<3;$j++){	//	check each cell
					if($state[$i][$j]===0){	// if free
						$state[$i][$j]=$sign;  // add a test mark
						$score=minimax($state,$sign,$_SESSION['depth']=0);	// get score for the cell
						$nextmove=min($score,$bestmove);
						$stateresults[]=$state;
						$scoreresults[]=$nextmove;
						$state[$i][$j]=0;
						$count++;
					}
				}	
			}
		var_dump($count);		
		var_dump($stateresults);
		var_dump($scoreresults);
		}

	//var_dump(move($state,$sign));
	return move($state,$sign);
	}

	$_SESSION['state']=ia($board,$sign);
	$_SESSION['turn']++;
}

$_SESSION['score1']=0;
$_SESSION['score2']=0;

//_____MINIMAX______//	
function minimax($state,$sign,$depth){
	echo 'minimax!';	//
if ($_SESSION['depth'] === 9){
	$score=scores($state);
	var_dump($score);
	return $score;
}
	// VALUES AND TURN HUB
	if($_SESSION['depth'] === 0 or $_SESSION['depth'] %2 === 0){	// we simulate turns every time minimax is called
		var_dump(maxi($state,$_SESSION['depth'],$sign));
		//var_dump($scoremaxi); 
	} elseif ($_SESSION['depth'] === 1 or $_SESSION['depth'] %2 !== 0){
		var_dump(mini($state,$_SESSION['depth'],$sign)) ; 
	}
	if ($_SESSION['depth'] === 9 ){
		//var_dump($_SESSION['score1']); 
		//var_dump($_SESSION['score2']); 
		return scores($state);
	}

$bestscore=-10;

	if

}

//_____MAXI______//

$_SESSION['scoremaxi']=0;

function maxi($state,$depth,$sign){
	echo 'maxi!';
if ($_SESSION['depth'] === 9 ){
	$score=scores($state);
	var_dump($score);
	return $score;
}
$bestscore=10;
$stateresults=[];
$scoreresults=[];
$sign=$_SESSION['player'];
	for($i=0;$i<3;$i++){
		for($j=0;$j<3;$j++){	//	check each cell
			if($state[$i][$j]===0){	// if free
				$state[$i][$j]=$sign;  // add human mark cause in play we added ai
				$score=scores($state);	//check now score 
				$_SESSION['scoremaxi'] =$score;
				$score=$bestscore+$_SESSION['scoremaxi'];
				if($score<$bestscore){
					//var_dump($score);
					return $score;
				}
				mini($state,$_SESSION['depth']++,$sign);
				$state[$i][$j]=0;
			}
		}	
	}
}


//_____MINI______//	

$_SESSION['scoremini']=0;

function mini($state,$depth,$sign){
	echo 'mini!';
if ($_SESSION['depth'] === 9 ){
	$score=scores($state);
	var_dump($score);
	return $score;
}
$bestscore=-10;
$sign=$_SESSION['player2'];
	for($i=0;$i<3;$i++){
		for($j=0;$j<3;$j++){	//	check each cell
			if($state[$i][$j]===0){	// if free
				$state[$i][$j]=$sign;  // add ai mark cause in play we added human
				$score=scores($state);	//check now score 
				$_SESSION['scoremaxi'] =$score;
				$score=$bestscore+$_SESSION['scoremaxi'];
				if($score<$bestscore){
					//var_dump($score);
					return $score;
				}
				maxi($state,$_SESSION['depth']++,$sign);
				$state[$i][$j]=0;

			}
		}	
	}
}


//___SCORES___//		SCORES HUB
function scores($state){
	//var_dump($state);
	if(win($state)==1){			// if p1
		return +10;
	} elseif (win($state)==2){	// if p2
		return -10;
	} elseif (win($state)==3){	// if tie 
		return +5;		
	} elseif (win($state)==0){
		return 0;	}
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