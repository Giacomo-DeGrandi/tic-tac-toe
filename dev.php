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
	echo '<table>';
	for($i=0;$i<3;$i++){
		echo '<tr>';
		for($j=0;$j<3;$j++){		
			//$cell = 3*$j+$i;	// translate the board into 0,1,2,3,4,5,6,7,8 instead of 0,0,0,3,3,3,6,6,6 ..
			echo '<td>';
			if($_SESSION['state'][$i][$j]===0){
				$cell=$i.','.$j;
				echo '<form method="post"><input type="submit" name="'.$cell.'" value="" class="cells">';
				if(isset($_POST[$cell])){
					$_SESSION['state'][$i][$j]=$_SESSION['player'];	//add a mark to the cell
					$_SESSION['turn']++;
					header('Location:dev.php');	
				}
			echo '</form></td>';
			} elseif($_SESSION['state'][$i][$j]!==0){
				//echo 'b';
				//var_dump($_SESSION['state']);
				if($_SESSION['state'][$i][$j] == $_SESSION['player']){
					echo '<form method="post"><input type="submit" name="'.$_SESSION['state'][$i][$j].'" value="'.$_SESSION['humansign'].'" class="cells"></form></td>';
				}
				if($_SESSION['state'][$i][$j] ==$_SESSION['player2']){
					echo '<form method="post"><input type="submit" name="'.$_SESSION['state'][$i][$j].'" value="'.$_SESSION['aisign'].'" class="cells"></form></td>';	
				}
			} else {
					//echo 'e';
				echo '<form method="post"><input type="submit" name="'.$_SESSION['state'][$i][$j].'" value="" class="cells"></form></td>';
			}
		}
		echo '</tr>';
	}
}

if (isset($_SESSION['turn']) and isset($_SESSION['state'])  and $_SESSION['turn'] === 1 or $_SESSION['turn']%2 !== 0){
	$board=$_SESSION['state'];
	$sign=$_SESSION['player2'];
	function ia($board, $sign){
		for($i=0;$i<3;$i++){
			for($j=0;$j<3;$j++){
				if($_SESSION['state'][$i][$j]===0){
					$free=$i.','.$j;
					$played[]=$free;
					global $played;
				}

			}	
		}
		//var_dump($played);
		$test=array_rand($played,1);
		$test=explode(',',$played[$test]);
		//var_dump($board);
		$board[$test[0]][$test[1]]=$sign;
		return $board;
	}

	// play__

	$_SESSION['state']=ia($board,$sign);


}

/*		FOR LOOP 

		for($i=0;$i<3;$i++){
			for($j=0;$j<3;$j++){
			
			}	
		}

*/

?>
</main>
	<footer>
	</footer>
</body>
</html>