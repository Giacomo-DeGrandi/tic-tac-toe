<?php

session_start();

// table

//each case has a min value & max value
//each TURN is a depth level
//each case can have 3 different values o, x , n 

// 8 depth level to check moves in a game
// each case is an input 

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
		<a href="dev.php">dev</a>
		<br>
		<h5>you're now on page <big>index</big></h5>
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
if(isset($_SESSION['start']) and !isset($_SESSION['end'])){ 
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
			$_SESSION['moves1'][]=$pos;			// store player 1 game and pos
			$_SESSION['player1state']=$_SESSION['startstate'];
			$_SESSION['turn']++;				//	add 1 to turn
			header('Location:index.php');		// reload page after have started ai & set changes
		}
	}
	echo '</form>';
} elseif(!isset($_SESSION['end'])) {
	echo '<h3> choose a sign to start the game </h3>';
}
/*
if(isset($_SESSION['moves1']) and isset($_SESSION['moves2'])){
	var_dump($_SESSION['moves1']);
	var_dump($_SESSION['moves2']);
}
*/
// my turns and end game 


if(isset($_SESSION['turn']) and $_SESSION['turn']>10 and !isset($_SESSION['end'])){
	session_destroy();
	header('Location:index.php');
} elseif( isset($_SESSION['end']) ){
	if($_SESSION['end']=='win1'){
		echo '</form><big><strong>! YOU WIN !</strong></big><style> input[class^="cells"]{pointer-events: none; } .choice{pointer-events: none;} </style>';
	} elseif ( $_SESSION['end']=='win2' ){
		echo '</form><big><strong>! YOUR OPPONENT WON  !</strong></big><style> input[class^="cells"]{pointer-events: none; } .choice{pointer-events: none;} </style>';
	} elseif ( $_SESSION['end']=='draw' ){
		echo '</form><big><strong>! DRAW !</strong></big><style> input[class^="cells"]{pointer-events: none; } .choice{pointer-events: none;} </style>';
	}

}

if(isset($_SESSION['turn']) and !isset($_SESSION['end'])){ 
	echo 'turn n '.$_SESSION['turn'];
	if($_SESSION['turn'] === 0 || $_SESSION['turn']%2 === 0 ){
		if($_SESSION['player'] == 'X'){
		echo '<span class="player1c">X <small>make your move!</small></span> ';			
		} 
		elseif($_SESSION['player'] == 'O'){
		echo '<span class="player1c">X <small>make your move!</small></span> ';			
		}
	} elseif ($_SESSION['turn']=== 1 || $_SESSION['turn']%2 !== 0 ){
		if($_SESSION['player'] == 'X'){
		echo '<span class="player1c">X <small>make your move!</small></span> ';			
		} 
		elseif($_SESSION['player'] == 'O'){
		echo '<span class="player1c">X <small>make your move!</small></span> ';			
		}
	} if ($_SESSION['turn'] > 0){
		echo '<style> .choice{pointer-events: none;} </style>';
	}
}

// basic random ia for testing _______________________________________________

if(isset($_SESSION['player']) and isset($_SESSION['moves1'])){
	$board=$_SESSION['moves1'];			// value of the move for the ai
	$sign=$_SESSION['player'];			// sign of the player for the ai
}


function ia($board, $sign){
	$test=[0,1,2,3,4,5,6,7,8];			// test table 
	$board=array_diff($test,$board);	// check played cases
	//var_dump($board);
	if($_SESSION['turn']=== 1 || $_SESSION['turn']%2 !== 0 ){ // play 1st and every cell that % 2 is diff than 0 
		if ($sign=='X') {	$sign= 'O'; }    		// condition for player signs
		elseif ($sign=='O') {   $sign = 'X'; }					
		$board=array_diff($board,$_SESSION['moves1']);	// subtract away player 1 game 
		if(empty($_SESSION['moves2'])){					// if player 2 game is empty => so we're in TURN 0 or 1
			$_SESSION['moves2']=$_SESSION['moves1'];	// player 2 game = player 1 game not to have errors
		}
		$board=array_diff($board,$_SESSION['moves2']);	// subtract away player 2 game
		//var_dump($board);		
		$board=array_rand($board,1);				// choose one random element from arr
		$_SESSION['moves2'][]=$board;				// store the move of player 2
		$_SESSION['turn']++;						// add a turn
		return array($board => $sign);				// return ai moves and sign
	}
}

// START the ai and pass to next turn____________________

if(isset($_SESSION['turn']) and ($_SESSION['turn']=== 1 || $_SESSION['turn']%2 !== 0) ){	//when to play
	$newstartstate=ia($board,$sign);														// START THE AI__________*****
	$_SESSION['startstate']=array_replace($_SESSION['startstate'],$newstartstate); 			//state for next move
	$_SESSION['player2state']= $_SESSION['startstate'];
	header('Location:index.php');
}

// GET the state of the board for each player separate______________________________

if(isset($_SESSION['player2state']) and isset($_SESSION['player1state'])){
	var_dump($_SESSION['player1state']);
	//$_SESSION['player2state']=array_diff($_SESSION['startstate'],$_SESSION['player1state']);
	for($m=1;$m<=isset($_SESSION['player2state'][$m]);$m++){
		if($_SESSION['player2state'][$m] == 'X'){
			$_SESSION['player2state'][$m] = 0;
		}
		foreach($_SESSION['player2state'] as $k => $v){
			if($v == 'X'){
				$v = array(0 => 0);
				$_SESSION['player2state'] =array_replace($_SESSION['player2state'],$v);	//state of the board ONLY 4 P 2 !!
			}
		}
	}
	//$_SESSION['player2state']=array_replace($_SESSION['startstate'],$_SESSION['player2state']);
	var_dump($_SESSION['player2state']);
}
	
// WINNING and ENDS conds_______________________

$win=['0,1,2','3,4,5','6,7,8','0,3,6','1,4,7','2,5,8','0,4,8','2,4,6'];	//___ NB ASC order_________--->

if(isset($_SESSION['moves1']) and isset($_SESSION['moves2']) and isset($_SESSION['turn']) ){
	$win1= $_SESSION['moves1'];	
	$win2= $_SESSION['moves2'];
	//var_dump($win1);
	//var_dump($win2);
	if( $_SESSION['turn']>=0){
		array_shift($win2); 		// take away the first element on turn > than 0
	}
	sort($win1);					//___ sort the values in ASC order to match $win values _______<---
	sort($win2);
	$win1=implode(',',$win1);
	$win2=implode(',',$win2);
	foreach($win as $k=>$v){
		if(  strpos($win1, $v)){
			$_SESSION['end']='win1';
		} elseif(  strpos($win2, $v)){							// compare  to check if 2 WIN
			$_SESSION['end']='win2';
		} elseif ( isset($_SESSION['turn']) and $_SESSION['turn'] == 10 and !isset($_SESSION['end'])) {	// compare  to check if DRAW
			$_SESSION['end']='draw';
		}
	}
}

if(isset($_SESSION['moves1'])){
 	var_dump($_SESSION['startstate']);
 	var_dump($_SESSION['moves1']);
 	var_dump($_SESSION['moves2']);
 	if( $_SESSION['turn']>=0){
		array_shift($_SESSION['moves2']); 		// take away the first element on turn > than 0
	}
	$square= [0=>8,1=>1,2=>6,3=>3,4=>5,5=>7,6=>4,7=>9,8=>2];
	$state= $_SESSION['startstate'];
	for($i=0;$i<=isset($state[$i]);$i++){
		if($state[$i] == true){
			$state[$i] = empty($state[$i]);
		}
	}
	$winX=array_replace($square,$state);
	$winX2=$winX;
	foreach($winX2 as $k =>$v){
			if( $v === 0){
			$v2=array_replace_recursive($square,$winX2);
			$v=$v2;
			}
	}
	$_SESSION['winX']=$winX2;
	var_dump($winX2);
	var_dump($square);
}


?>
</main>
	<footer>
<?php

if(isset($_SESSION['player'])){
	echo '<span class="player1c">player 1 <small>sign:</small> <big> X </big></span>';	
	echo '<span class="player2c">player 2 <small>sign:</small> <big> O </big></span>'; 
}

?>
	</footer>
</body>
</html>