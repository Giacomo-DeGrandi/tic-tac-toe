<?php


function ia($board, $sign){
	$test=[0,1,2,3,4,5,6,7,8];			// test table 
	$board=array_diff($test,$board);	// check played cases
	//var_dump($board);
	if($_SESSION['turn']=== 1 || $_SESSION['turn']%2 !== 0 ){ // play 1st and every cell that % 2 is diff than 0 (every second turn)
		if ($sign=='X') {	$sign = 'O'; }    		// condition for player signs
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


?>
