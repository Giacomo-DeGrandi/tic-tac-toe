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

if(isset($_SESSION['end']) and (!isset($_POST['X'])||isset($_POST['O']))){
	echo $_SESSION['end'];
}

if(isset($_POST['X'])){			// initialise the game____
	$_SESSION['player']='X';
	//$_SESSION['moves1'][]=true;	// store player1 moves
	//$_SESSION['moves2'][]=true;	// store player2 moves
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
if(isset($_SESSION['start'])){ 
	foreach($_SESSION['startstate'] as $pos =>$val){
		if($val===0){
			$val=' ';
		}
		if($pos==2||$pos==5){
			echo '<input type="submit" name="'.$pos.'" value="'.$val.'" class="cells'.$pos.'">';	//__ layout
			echo '<br>';
		} else {
			echo '<input type="submit" name="'.$pos.'" value="'.$val.'" class="cells'.$pos.'">';	//__ 
		}
		if(isset($_POST[$pos])){
			$newstartstate=array($pos=>$_SESSION['player']);
			$_SESSION['startstate']=array_replace($_SESSION['startstate'],$newstartstate); //state for next move
			$_SESSION['moves1'][]=$pos;			// store player 1 game and pos
			$_SESSION['turn']++;				//	add 1 to turn
			header('Location:index.php');		// reload page after have started ai & set changes
		}
	}
	echo '</form>';
} else {
	echo '<h3> choose a sign to start the game </h3>';
}
/*
if(isset($_SESSION['moves1']) and isset($_SESSION['moves2'])){
	var_dump($_SESSION['moves1']);
	var_dump($_SESSION['moves2']);
}
*/
// my turns and end game 


if(isset($_SESSION['turn']) and $_SESSION['turn']==9){
	session_destroy();
	header('Location:index.php');
}

if(isset($_SESSION['turn'])){ 
	echo 'turn n '.$_SESSION['turn'];
	if($_SESSION['turn'] === 0 || $_SESSION['turn']%2 === 0 ){
		echo '<span class="player1c">X <small>make your move!</small></span> ';
	} elseif ($_SESSION['turn']=== 1 || $_SESSION['turn']%2 !== 0 ){
		echo '<span class="player2c"> O <small>make your move!</small></span>';
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
	if($_SESSION['turn']=== 1 || $_SESSION['turn']%2 !== 0 ){ // when to play for sign
		if($sign='X'){									
			$sign= 'O';
		} else {
			$sign = 'X';
		}
		$board=array_diff($board,$_SESSION['moves1']);	// subtract away player 1 game 
		if(empty($_SESSION['moves2'])){					// if player 2 game is empty 
			$_SESSION['moves2']=$_SESSION['moves1'];	// player 2 game = player 1 game 
		}
		$board=array_diff($board,$_SESSION['moves2']);	// subtract away player 2 game
		//var_dump($board);		
		$board=array_rand($board,1);				// choose one random element from arr
		$_SESSION['moves2'][]=$board;				// store the move of player 2
		$_SESSION['turn']++;						// add a turn
		return array($board => $sign);				// return ai moves and sign
	}
}

// SEND it DART!___________________________-

if(isset($_SESSION['turn']) and ($_SESSION['turn']=== 1 || $_SESSION['turn']%2 !== 0) ){		//when to play
	$newstartstate=ia($board,$sign);
	$_SESSION['startstate']=array_replace($_SESSION['startstate'],$newstartstate); //state for next move
	header('Location:index.php');
}
	
// var_dump($_SESSION['startstate']);

// compare to check who's winning_______________________

$win=['0,1,2','3,4,5','6,7,8','0,3,6','1,4,7','2,5,8','0,4,8','2,4,6'];	//___ NB ASC order_________--->

if(isset($_SESSION['moves1']) and isset($_SESSION['moves2']) and isset($_SESSION['turn']) ){
	$win1= $_SESSION['moves1'];	
	$win2= $_SESSION['moves2'];
	sort($win1);					//___ sort the values in ASC order to match $win values _______<---
	sort($win2);
	$win1=implode(',',$win1);
	$win2=implode(',',$win2);
	if( in_array($win1, $win) == true){
		$_SESSION['end']='<big><strong>! WIN PLAYER 1!</strong></big><style> .cells{pointer-events: none; } .choice{pointer-events: none;} </style>';
	} elseif(   $win2===$win[0]||$win2===$win[1]||$win2===$win[2]||
				$win2===$win[3]||$win2===$win[4]||$win2===$win[5]||
				$win2===$win[6]||$win2===$win[7]){
		$_SESSION['end']='<big><strong>! WIN PLAYER 2!</strong></big><style> .cells{pointer-events: none; } .choice{pointer-events: none;} </style>';
	} elseif ( isset($_SESSION['turn']) and $_SESSION['turn'] == 9) {
		$_SESSION['end']='<big><strong>! DRAW !</strong></big><style> .cells{pointer-events: none; } .choice{pointer-events: none;} </style>';
	}
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