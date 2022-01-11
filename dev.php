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

if($x == 'X'){
	$_SESSION['end']='win1';
} elseif($x == 'O'){
	$_SESSION['end']='win2';	
} elseif ( isset($_SESSION['turn']) and $_SESSION['turn'] == 10 and !isset($_SESSION['end'])) {	// compare  to check if DRAW
	$_SESSION['end']='draw';
}


// FIRST END TRY

if(isset($_SESSION['moves1']) and isset($_SESSION['moves2']) and isset($_SESSION['turn']) ){
	$win=['0,1,2','3,4,5','6,7,8','0,3,6','1,4,7','2,5,8','0,4,8','2,4,6'];	//___ NB ASC order_________--->
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

	$win_b=[0,1,2,$x,$x,$x,6,7,8];
	$win_c=[0,1,2,3,4,5,$x,$x,$x];
	$win_d=[$x,1,2,$x,4,5,$x,7,8];		// VERTICAL
	$win_e=[0,$x,2,3,$x,5,6,$x,8];
	$win_f=[0,1,$x,3,4,$x,6,7,$x];
	$win_g=[$x,1,2,3,$x,5,6,7,$x];		// DIAGONAL
	$win_h=[0,1,$x,3,$x,5,$x,7,8];
/*

$square= [8,1,6,3,5,7,4,9,2];

$win=array_diff($_SESSION['startstate'],$square);


array_replace(array, array1)



$_SESSION['startstate'] = $start;

if($start[0] and $start[1] and $start[2]) == 'X' ){			//condition 1   HORIZONTALS__

} elseif (($start[0] and $start[1] and $start[2]) == 'O' ){

}
if($start[3] and $start[4] and $start[5]) == 'X' ){		//condition 2

} elseif (($start[3] and $start[4] and $start[5]) == 'O' ){

}
if($start[6] and $start[7] and $start[8]) == 'X' ){			//condition 3

} elseif (($start[6] and $start[7] and $start[8]) == 'O' ){

}
if($start[0] and $start[1] and $start[2]) == 'X' ){		//condition 4	VERTICALS__

} elseif (($start[0] and $start[1] and $start[2]) == 'O' ){

}


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