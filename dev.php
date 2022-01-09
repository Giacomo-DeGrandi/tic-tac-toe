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
	<title>DEV</title>
</head>
<link rel="stylesheet" type="text/css" href="tris.css">
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<body>
	<header>
		<a href="index.php">index</a>
		<br>
		<h5>you're now on page <big>TEST</big></h5>
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
/*

if(isset($_POST['reset'])){
	session_destroy();
	header('Location:dev.php');
}


// chose a player and start the game________________________

if(isset($_POST['X'])){						// initialise the game and chose the SESSION to start____
	$_SESSION['playersign1']='X';	// store player 1 sign to the end of the game
	$_SESSION['playersign2']='O';	// store player 2 sign
	$_SESSION['turn'][]=true;			// store turns and advance the game by adding one
	$_SESSION['start']= true;		// start value for the game, if condition don't met force a player to chose a sign to begin
	$_SESSION['p1moves'][]=true;		// store POS and SIGN and TURN of player 1
	$_SESSION['p2moves'][]=true;		// store POS and SIGN and TURN of player 2
	$_SESSION['state'][]=true;			// store the states of the game 
	turn($_SESSION['playersign1']);
} elseif(isset($_POST['O'])){
	$_SESSION['playersign1']='O';
	$_SESSION['playersign2']='X';
	$_SESSION['turn'][]=true;			
	$_SESSION['start']= true;		
	$_SESSION['p1moves'][]=true;		
	$_SESSION['p2moves'][]=true;		
	$_SESSION['state'][]=true;	
	turn($_SESSION['playersign2']);		
} 

// condition for beginning and chose player_________________

if(isset($_SESSION['start'])){
	echo 'play';
} else {
	echo '<style> .cells { display:none; } </style>';
	echo '<h3> choose a sign to start the game </h3>';
}


//table___________________________________________________



// to validate plays on turns i made this table, since the player choose a sign it calculate wich turns user can play or not

function turn($sign){
	if ($sign == 'X'){
		for($i=0;$i<=8;$i++){
			if($i === 0 || $i%2 === 0){
				$_SESSION['turn'][$i]=$sign;
			} elseif ($i=== 1 || $i%2 !== 0 ){
				$_SESSION['turn'][$i]= 'O';
			}
		}
	} elseif ($sign == 'O'){
		for($i=0;$i<=8;$i++){
			if($i === 0 || $i%2 === 0){
				$_SESSION['turn'][$i]=$sign;
			} elseif ($i=== 1 || $i%2 !== 0 ){
				$_SESSION['turn'][$i]= 'X';
			}
		}
	}
}

//if(isset($_SESSION['turn'])){echo 'turn'; var_dump($_SESSION['turn']);} //---------------------------

// GAME ENGINE________________________________

for($i=0;$i<=8;$i++){
	if(isset($_POST[$i])){
		$_SESSION['p1moves'][]=$i;
	}
}

//__________basic AI engine__________________

function ia($board, $sign){
	$test=[0,1,2,3,4,5,6,7,8];
	$board=array_diff($test,$board);
	if($_SESSION['turn']=== 1 || $_SESSION['turn']%2 !== 0 ){ // when to play for test
		if($sign='X'){
			$sign= 'O';
		} else {
			$sign = 'X';
		}
		$_SESSION['turn']++;
		$board=array_rand($board,1);
		$_SESSION['player2move'][]=$board;
	}
	$board=array_diff(explode(',' , $board),$_SESSION['player2move']);	//take away played possibilities
	return array($board,$sign);
}

if(isset($_SESSION['p1moves'])){echo 'p1moves'; var_dump($_SESSION['p1moves']);} //----------------------

echo '<table>';
for($i=0;$i<=2;$i++){
	echo '<tr>';
	for($j=0;$j<=2;$j++){
		echo '<td><input type="submit" formmethod="post" name="0" value="" class="cells"/></td>';
	}
	echo '<tr>';
}
echo '</table>';
*/
?>
</main>
	<footer>
	</footer>
</body>
</html>