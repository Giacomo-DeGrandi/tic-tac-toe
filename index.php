<?php

session_start();


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>tic tac toe</title>
</head>
<link rel="stylesheet" type="text/css" href="tris.css">
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<body>
	<header>

	</header>
<main>
	<form method="post">
		<input type="submit" name="reset" value="reset" id="reset">
	</form>
	<form method="post">
		<input type="submit" name="X" value="X" class="choice">		
		<input type="submit" name="O" value="O" class="choice">
	</form>
	<span><br></span>
<?php 

if(isset($_POST['reset'])){
	session_destroy();
	header('Location:index.php');
}


if(isset($_POST['X'])){			// initialise the game____
	$_SESSION['player']='X';
	$_SESSION['turn']=0;
	$_SESSION['start']= true;
	$_SESSION['startstate']= [ 0,0,0,
							   0,0,0,
							   0,0,0  ]; //startstate_____________
} elseif(isset($_POST['O'])){
	$_SESSION['player']='O';
	$_SESSION['turn']=0;
	$_SESSION['start']= true;
	$_SESSION['startstate']= [ 0,0,0,
							   0,0,0,
							   0,0,0  ]; //startstate_____________
} 


//block played cells_________________________


if(isset($_SESSION['moves1']) and isset($_SESSION['moves2'])){
	foreach($_SESSION['moves1'] as $k =>$v){
		echo '<style> .cells'.$v.'{pointer-events: none; } </style>'; // block the cell after player 1 moves
	}
	foreach($_SESSION['moves2'] as $k =>$v){
		echo '<style> .cells'.$v.'{pointer-events: none; } </style>'; // block the cell after player 2 moves
	}
}

//table___________________________________________________

echo '<form method="post">';
if(isset($_SESSION['start']) and !isset($_SESSION['end']) and $_SESSION['turn']<10){ 
	foreach($_SESSION['startstate'] as $pos =>$val){
		if($val===0){
			$val=' ';
		}
		if($pos==2||$pos==5){
			echo '<input type="submit" name="'.$pos.'" value="'.$val.'" class="cells'.$pos.'">';	//__ pos here 4 layout
			echo '<br>';  // assign to inputs a position num and as value the sign of the player
		} else {
			echo '<input type="submit" name="'.$pos.'" value="'.$val.'" class="cells'.$pos.'">';	//__ 
		}							   //idem..______
		if(isset($_POST[$pos])){
			$newstartstate=array($pos=>$_SESSION['player']);
			$_SESSION['startstate']=array_replace($_SESSION['startstate'],$newstartstate); //state for next move
			$_SESSION['moves1'][]=$pos;							// store player 1 game and pos
			$_SESSION['player1state']=$_SESSION['startstate'];	// idem but on the game table
			$_SESSION['turn']++;				//	add 1 to turn
			
		}
	}
	echo '</form>';
} elseif(!isset($_SESSION['end'])) {
	echo '<h3> choose a sign to start the game </h3>';
}

// TURN counting and END print__________________________________________________________


if(isset($_SESSION['turn']) and $_SESSION['turn']> 9 and !isset($_SESSION['end'])){
	session_destroy();
	header('Location:index.php');
} elseif( isset($_SESSION['end']) ){
	if($_SESSION['end']=='win1'){
		echo '</form><div class="wrapit"><big><strong><h3>player</h3><h1>&#160 X </h1>&#160WINS!</strong></big></div><style> input[class^="cells"]{pointer-events: none; } .choice{pointer-events: none;} </style>';
	} elseif ( $_SESSION['end']=='win2' ){
		echo '</form><div class="wrapit"><big><strong><h3>player</h3><h1>&#160 O </h1>&#160WINS!</strong></big></div><style> input[class^="cells"]{pointer-events: none; } .choice{pointer-events: none;} </style>';
	} elseif ( $_SESSION['end']=='draw' ){
		echo '</form><div class="wrapit"><big><strong>! DRAW !</strong></big></div><style> input[class^="cells"]{pointer-events: none; } .choice{pointer-events: none;} </style>';
	}

}

//__SIGNAL moves________________________________________

if(isset($_SESSION['turn']) and !isset($_SESSION['end'])){ 
	echo 'turn n '.$_SESSION['turn'];
	if($_SESSION['turn'] === 0 || $_SESSION['turn']%2 === 0 ){
		if($_SESSION['player'] === 'X'){
		echo '<span class="player1c">X <small>make your move!</small></span> ';			
		} 
		elseif($_SESSION['player'] === 'O'){
		echo '<span class="player1c">X <small>make your move!</small></span> ';			
		}
	} elseif ($_SESSION['turn']=== 1 || $_SESSION['turn']%2 !== 0 ){
		if($_SESSION['player'] === 'X'){
		echo '<span class="player1c">X <small>make your move!</small></span> ';			
		} 
		elseif($_SESSION['player'] === 'O'){
		echo '<span class="player1c">X <small>make your move!</small></span> ';			
		}
	} if ($_SESSION['turn'] > 0){
		echo '<style> .choice{pointer-events: none;} </style>';			// block pointer on sign choice
	}
}

// basic random ia for testing _______________________________________________

if(isset($_SESSION['player']) and isset($_SESSION['moves1'])){
	$board=$_SESSION['moves1'];			// value of the move for the ai
	$sign=$_SESSION['player'];			// sign of the player for the ai
}


include 'ai.php';			// INCLUDE AI FOR PLAY_________________________________

// START the ai and pass to next turn____________________

if(isset($_SESSION['turn']) and ($_SESSION['turn']=== 1 || $_SESSION['turn']%2 !== 0) ){	//when to play
	$newstartstate=ia($board,$sign);														// START THE AI__________*****
	$_SESSION['startstate']=array_replace($_SESSION['startstate'],$newstartstate); 			//state for next move
	$_SESSION['player2state']= $_SESSION['startstate'];
	header('Location:index.php');
}

// GET the state of the board for each player separate______________________________

if(isset($_SESSION['player2state']) and isset($_SESSION['player1state'])){
	for($m=1;$m<=isset($_SESSION['player2state'][$m]);$m++){
		if($_SESSION['player2state'][$m] == 'X'){
			$_SESSION['player2state'][$m] = 0;
		}
		foreach($_SESSION['player2state'] as $k => $v){
			if($v == 'X'){
				$v = array($k => 0);
				$_SESSION['player2state'] =array_replace($_SESSION['player2state'],$v);	//state of the board ONLY 4 P 2 !!
			}
		}
	}
	for($n=1;$n<=isset($_SESSION['player1state'][$n]);$n++){
		if($_SESSION['player1state'][$n] == 'O'){
			$_SESSION['player1state'][$n] = 0;
		}
		foreach($_SESSION['player1state'] as $k => $v){
			if($v == 'O'){
				$v = array($k => 0);
				$_SESSION['player1state'] =array_replace($_SESSION['player1state'],$v);	//state of the board ONLY 4 P 2 !!
			}
		}
	} 
}
	
// WINNING and ENDS conds_______________________

if(isset($_SESSION['player1state']) and isset($_SESSION['player2state'])){
	$win_a=[0,0,0,0,0,0,0,0,0];	
	$win_b=$win_a;
	$checkx=$_SESSION['player1state'];
	$win_a=array_replace($win_a,$checkx);
	if( ($win_a[0] === 'X' and $win_a[1] === 'X' and $win_a[2] === 'X' or 	//___HORIZONTALS___
			$win_a[3] === 'X' and $win_a[4] === 'X' and $win_a[5] === 'X' or
			$win_a[6] === 'X' and $win_a[7] === 'X' and $win_a[8] === 'X' or
			$win_a[0] === 'X' and $win_a[3] === 'X' and $win_a[6] === 'X' or	//___VERTICALS_____
			$win_a[1] === 'X' and $win_a[4] === 'X' and $win_a[7] === 'X' or
			$win_a[2] === 'X' and $win_a[5] === 'X' and $win_a[8] === 'X' or
			$win_a[0] === 'X' and $win_a[4] === 'X' and $win_a[8] === 'X' or	//___DIAGONALS_____
			$win_a[2] === 'X' and $win_a[4] === 'X' and $win_a[6] === 'X' or $_SESSION['player'] === ('X' or 'O'))
			and !isset($_SESSION['end'])	){
			$_SESSION['end'] = 'win1';
	} 
	$checkx2=$_SESSION['player2state'];
	$win_b=array_replace($win_b,$checkx2);
	if (	($win_b[0] === 'O' and $win_b[1] === 'O' and $win_b[2] === 'O' or 	//___HORIZONTALS___
				$win_b[3] === 'O' and $win_b[4] === 'O' and $win_b[5] === 'O' or
				$win_b[6] === 'O' and $win_b[7] === 'O' and $win_b[8] === 'O' or
				$win_b[0] === 'O' and $win_b[3] === 'O' and $win_b[6] === 'O' or	//___VERTICALS_____
				$win_b[1] === 'O' and $win_b[4] === 'O' and $win_b[7] === 'O' or
				$win_b[2] === 'O' and $win_b[5] === 'O' and $win_b[8] === 'O' or
				$win_b[0] === 'O' and $win_b[4] === 'O' and $win_b[8] === 'O' or	//___DIAGONALS_____
				$win_b[2] === 'O' and $win_b[4] === 'O' and $win_b[6] === 'O' or $_SESSION['player'] === ('X' or 'O'))
			and !isset($_SESSION['end'])	 ){
			$_SESSION['end'] = 'win2';
	}
	if ( isset($_SESSION['turn']) and $_SESSION['turn'] == 10 and !isset($_SESSION['end'])) {	// compare  to check if DRAW
			$_SESSION['end']='draw';
	}
}



?>
</main>
	<footer>
<?php

if(isset($_SESSION['player']) and $_SESSION['player'] === 'X'){
	echo '<span class="player1c">player 1 <small>sign:</small> <big> X </big></span>';	
	echo '<span class="player2c">player 2 <small>sign:</small> <big> O </big></span>'; 
} elseif (isset($_SESSION['player']) and $_SESSION['player'] === 'O'){
	echo '<span class="player2c">player 1 <small>sign:</small> <big> O </big></span>';	
	echo '<span class="player1c">player 2 <small>sign:</small> <big> X </big></span>'; 
}

?>
	</footer>
</body>
</html>