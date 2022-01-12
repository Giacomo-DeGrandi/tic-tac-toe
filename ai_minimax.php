<?php


function ia($board,$sign){
		$humansign=$sign;					// get the human player sign 
		$state=$_SESSION['startstate'];		// get the current state of the board
		$test=[0,1,2,3,4,5,6,7,8];			// test for empty
		$played=array_diff($test,$state);	// get the played spots
				/*
		$free=array_search(0,$state);		// get the played spots
		var_dump($free);
		$turn=$_SESSION['turn'];				// get the current turn
		*/
		for($i=0;$i<=isset($state[$i]);$i++){
			if($state[$i]==0){
				$state[$i]=$i;
			}
			$current[]=$played;				// store current board to test WIN state
			$index[]=$state[$i];			// store the index to check 
			$current[$played[$i]]=$humansign;			// replace value with mark
		}
		var_dump($state);
		var_dump($current);



		/*

					$current[]=$played;				// store current board to test WIN state
			$index[]=$state[$i];			// store the index to check 
			$current[$played[$i]]=$humansign;			// replace value with mark
			if($played[$i] == false){				// if empty
				 continue;
			}

										// check for terminal state
		$testarr[]=true;				// store the possible choices

				$test=[0,1,2,3,4,5,6,7,8];
		$signtest=$sign;

		$boardstate=$board;		// my table state
		$played=array_diff($test,$boardstate);	// check played cells
		$played1=$boardstate;
		$played1=array_replace($played1,array_values($played)); // reset indexes of played cells create alias to loop
		$played1=array_diff($boardstate,$played1);
		var_dump($played);
		var_dump($played1);
		$j=0;
		for($i=0;$i<=$played[$i];$i++){
			if($i == $played1[$j]){
				continue;
			}
			$current[]=$played;					// store current board to test WIN state
			$index[]=$played[$i];					// store the index to check 
			$played[$i]=$signtest;					// replace value with mark
			$j++;
			var_dump($played);
			
		}
		var_dump($played1);

		for($i=0;$i<=isset($played[$i]);$i++){
			$played[]=$signtest;
			var_dump($played);
		}

		foreach($played as $k => $v){ 		// test loop
			$played[$r]=$signtest;
			$r++;
			$played=array_diff($played1,$played);
			$signtest=array($k=>$signtest);
			$played=array_replace($played,$signtest);
			//$played=array_diff($played1,$played);
			//$current[$i][]=$played;					// store current board to test WIN state
			$index[]=$k;							// store the index to check 
			//$current[$played[$i]]=$signtest;		// place the sign to test
			var_dump($played);

		}
		*/
	


	//normal ai_________________________________________________________________________________________________

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
