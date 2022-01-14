<?php

session_start();

//for()

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
	$player1=$_SESSION['player']='1';
	$humansign='X';
	$aisign='O';
	$turn=$_SESSION['turn']=0;
	$start=$_SESSION['start']= true;
	$state=$_SESSION['state']= [ array(0,0,0),
							   array(0,0,0),
							   array(0,0,0)  ]; //startstate_________

} elseif(isset($_POST['O'])){
	$player2=$_SESSION['player']='2';
	$humansign='O';
	$aisign='X';
	$turn=$_SESSION['turn']=0;
	$start=$_SESSION['start']= true;
	$state=$_SESSION['state']= [ array(0,0,0),
							   array(0,0,0),
							   array(0,0,0)  ]; //startstate_____________
} 

// table ________________________________________________________________

if(isset($start) and !isset($_SESSION['end'])){
	echo '<table>';
	for($i=0;$i<3;$i++){
		echo '<tr>';
		for($j=0;$j<3;$j++){
			
			$cell = 3*$j+$i;	// translate the board into 0,1,2,3,4,5,6,7,8 instead of 0,0,0,3,3,3,6,6,6 ...thanks adrien

			if(empty($state[$i][$j])){
				echo '<td><form method="post"><input type="submit" name="'.$cell.'" value="" class="cells"></form></td>';	//__ pos here 4 layout
				if(isset($_POST[$cell])){
					echo 'post';
					$i = floor($cell / 3);	// get i values compatible with the board, floor() round float to lowest int
					$j = $cell % 3; 		// get j values compatible with the board
					echo $cell;
				}	
			} elseif($state[$i][$j]===0){
				echo '<td><form method="post"><input type="submit" name="'.$cell.'" value="'.$state[$i][$j].'" class="cells"></form></td>';	//__ pos 
			}
		}
		echo '</tr>';
	}
}

if (isset($turn))
	echo $turn;

?>
</main>
	<footer>
	</footer>
</body>
</html>