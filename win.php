<?php

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