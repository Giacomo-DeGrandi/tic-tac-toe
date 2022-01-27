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
if(isset($_POST['medium'])){
	$_SESSION['level']=2;
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
	$_SESSION['level']=1;
	echo '	<form method="post">
			<h3>difficulty level</h3>
			<input type="submit" name="easy" value="easy" class="diff">
			<input type="submit" name="medium" value="medium" class="diff">
			</form>
			<span><br></span>';

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
	$_SESSION['level']=1;
	echo '	<form method="post">
			<h3>difficulty level</h3>
			<input type="submit" name="easy" value="easy" class="diff">
			<input type="submit" name="medium" value="medium" class="diff">
			</form>
			<span><br></span>';
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
					header('Location:dev.php'); //________________________ header
				}
			echo '</form></td>';
			} elseif($_SESSION['state'][$i][$j]!==0){
				if($_SESSION['state'][$i][$j]===$_SESSION['player']){
					echo '<form method="post"><input type="submit" name="'.$_SESSION['state'][$i][$j].'" value="'.$_SESSION['humansign'].'" class="cells'.$i.'_'.$j.'"  ><style>.cells'.$i.'_'.$j.'{ pointer-events: none; }</style></form></td>';
				}
				if($_SESSION['state'][$i][$j]===$_SESSION['player2']){
					echo '<form method="post"><input type="submit" name="'.$_SESSION['state'][$i][$j].'" value="'.$_SESSION['aisign'].'" class="cells'.$i.'_'.$j.'"  ><style>.cells'.$i.'_'.$j.'{ pointer-events: none; }</style></form></td>';
				}
			} else {
				echo '<form method="post"><input type="submit" name="'.$_SESSION['state'][$i][$j].'" value="" class="cells"></form></td>';
			}
		}
		echo '</tr>';
	}
}


if(isset($_SESSION['turn']) and $_SESSION['turn']=== 9){
	session_destroy();
	header('Location:dev.php');
}

//_______IA_____________//

if(isset($_SESSION['level']) and $_SESSION['level']==2){
	echo 'minimax';
	include 'minimax2.php';	
} else { 
	if (isset($_SESSION['turn']) and isset($_SESSION['state'])  and $_SESSION['turn'] === 1 or $_SESSION['turn']%2 !== 0){
		$board=$_SESSION['state'];
		$sign=$_SESSION['player2'];
		include 'ai2.php';
		$_SESSION['state']=random($board,$sign);
	}
}


function win($state){
	for($i=0;$i<3;$i++){	
			if  ($state[$i][0]===1 and $state[$i][1]===1 and $state[$i][2]===1){	return 1; // horizontals
		} elseif($state[$i][0]===2 and $state[$i][1]===2 and $state[$i][2]===2){	return 2; // horizontals
		} elseif($state[0][$i]===1 and $state[1][$i]===1 and $state[2][$i]===1){	return 1; // verticals
		} elseif($state[0][$i]===2 and $state[1][$i]===2 and $state[2][$i]===2){	return 2; // verticals
		} elseif($state[0][0]===1 and $state[1][1]===1 and $state[2][2]===1){ 	return 1; // diag
		} elseif($state[0][0]===2 and $state[1][1]===2 and $state[2][2]===2){ 	return 2; // diag
		} elseif($state[2][0]===1 and $state[1][1]===1 and $state[0][2]===1){	return 1; // diag2
		} elseif($state[2][0]===2 and $state[1][1]===2 and $state[0][2]===2){	return 2; // diag2
		}
	}
	$checkdraw=0;
	for($i=0;$i<3;$i++){
		for($j=0;$j<3;$j++){
			if($state[$i][$j]!==0){	// count free cells, the match it's not finished
				$checkdraw++;
			}
		}
	}
	if($checkdraw<=9 ){	// if the match is not finish and we don't have winner return 'play'(0)
		return 0;
	}
	if($checkdraw=9 ){	// if the match is finish and we don't have winner return 'tie'(3)
		return 3;
	}
}


if(isset($_SESSION['state'])){
	$win=win($_SESSION['state']);
	if($win === 1){
		echo '<h1> player 1 wins</h1>';
		$_SESSION['end']=true;
	} elseif ($win=== 2){
		echo '<h1> player 2 wins</h1>';
		$_SESSION['end']=true;
	} elseif ($win===3 and !isset($_SESSION['end'])){
		echo '<h1> TIE ! </h1>';
		$_SESSION['end']=true;
	}
}

if(isset($_SESSION['turn']) and $_SESSION['turn']=== 9){
	session_destroy();
	header('Location:dev.php');
}


?>
</main>
	<footer>
	</footer>
</body>
</html>