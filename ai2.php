<?php


function ia($board, $sign){	
	var_dump($board);
	$board2=$board;
	$p1c=$p2c=0;	// check played
	for($i=0;$i<3;$i++){
		for($j=0;$j<3;$j++){
			if($board2[$i][$j] !==0 ){
				$i_ind=$i;
				$j_ind=$j;
				$_SESSION['played'][]=array($i,$j);	// subtract away player 2 game;
				var_dump($_SESSION['played']);
			}	
		}
	}
		//var_dump($board);		
		$board=array_rand($board,1);				// choose one random element from arr
		$_SESSION['moves2'][]=$board;				// store the move of player 2
		$_SESSION['turn']++;						// add a turn
		return array($board => $sign);				// return ai moves and sign
}


?>
