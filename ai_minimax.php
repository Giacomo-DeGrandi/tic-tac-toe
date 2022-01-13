<?php




function ia($board,$sign){	// <---- has to be kept for test purpose

		$state=$_SESSION['startstate'];		// get the current state of the board
		$turn=$_SESSION['turn'];				// get the current turn
		$humansign=$sign;				// get the human player sign
		$aisign=0;					// declare and get the aisign
		if($sign === 'X'){ $aisign = 'O';}
		if($sign === 'O'){ $aisign = 'X';}
		$state=array_chunk($state, 3);	// divide the array in 3 chunks to square it

function play($state,$aisign,$turn,$humansign){
   			$max = -100;		// give a value to moves to compare it with mini		
			$temp=$state; 		// get the state to reuse 
			for($i=0;$i<3;$i++){	// start the loop
				for($j=0;$j<3;$j++){
					if($state[$i][$j]!== 0){	//	if free	
						$aisign2= $aisign; // alias sign fo reuse 
						$aisign2=1;	// translate aisign for program purpose
						$state[$i][$j]= $aisign2;	// add a mark to the actual cell
						echo $state[$i][$j].' ';
						$cellval = mini($state, $turn +1,$aisign,$humansign);	// evaluate the cell with mini funct simulating opponent's choices, return the evaluated cells
						//$cellval = rand(1,10);	// test
						echo $cellval;
		                if($cellval > $max){		// if value is greater the max
		                    $max = $cellval;        // chose that value cause best move
		                    $index_i=$i;		// store the i index 
		                    $index_j=$j;		// store the j index
		                    $nextstate=$state[$index_i][$index_j];	//store the state
		                    $playnow=$nextstate;	
		                }
		            	$state[$i][$j]=0;	// reset the cell value
					}	
				}
			}
			echo $playnow;

}

// MINIMiSER function to act as the minimiser player------------------------------
// this means that this player strategy is to play the smallest value possible	||

function mini($state,$turn,$humansign,$aisign){
    	$min = 100;
    if ($turn == 9 or win($state) != 0){	// check for wins or draw								<-- WIN
        return value($state,$aisign,$humansign);		// else, send the evalued game plan at the end of the simulated match
    }
    for($i=0;$i<3;$i++){		// foreach cells
        for($j=0;$j<3;$j++){
			if($state[$i][$j]	!== 0){	//	if free	
				$humansign2= $humansign; // alias sign fo reuse 
				$humansign2=1;	// translate aisign for program purpose
                $state[$i][$j] = $humansign;	// add a mark to the actual cell
                $cellval = maxi($state, $turn +1,$aisign,$humansign);	// evaluate the cells sending the MAXI func 		<-- MAXI 
                if($cellval < $min) {		// if value is smaller than the min
                    $min = $cellval;        // chose that value
                    $state[$i][$j] = 0;		// reset the cells
                }
            }
        }
    }
    return $min; 		// return the result of min as an int fo further evaluation 
}

// MAXIMiSER function to act as the maximiser player------------------------------
// this means that this player strategy is to play the greatest value possible	||

function maxi($state,$turn,$aisign,$humansign){	// function for maximiser player
   		$max = -100;		// give a value to maximiser player to subtract every turn and to split in values
    if ($turn == 9 || win($state) != 0){	// check for wins or draw									<-- WIN
        return value($state,$aisign,$humansign);		// else, send the evalued game plan								<-- VALUE
    }
    for($i=0;$i<3;$i++){	// for each cell
		for($j=0;$j<3;$j++){
			if($state[$i][$j]	!== 0){	//	if free	
                $state[$i][$j] = $aisign;	// add a mark to the actual cell
                $cellval = mini($state, $turn +1,$aisign,$humansign);	// evaluate the cell sending the MINI to play on the last turns  <-- MINI
                if($cellval > $max){		// if value is greater the max
                    $max = $cellval;        // chose that value
                    $state[$i][$j] = 0;		// reset the cells
                }
            }
        }
    }
    return $max; 		// return the result of max as an int fo further evaluation 
}


function value($state,$aisign,$humansign){	 // Value of the state   
    $played = 0;    //check played cells__________
    for($i=0;$i<3;$i++){
    	for($j = 0;$j<3;$j++){
            if($state[$i][$j] !== 0){	//	if free
                $played++;			// if cell is played add 1 to played 
            }
        }
    }
    if (win($state) != 0) {	// check winner state___________						<-- WIN
        $winner = win($state);											//    <-- WIN
        if($winner === $aisign){
            return 10 - $played;
        }	elseif($winner === $humansign) {
            return -10 + $played;
        }	else {
            return 0;
        }
    }
    $p1wins = 0;    // count player 1 wins
    $p2wins = 0;    // count player 2 wins
    
    series($state, $p1wins, $p2wins, 2);			//    <-- SERIES
    return $p1wins - $p2wins;	// return the difference between the two players count of victories
} 

// function to count the simulation of turns and check winning states

function series($state){
	for($i=0;$i<3;$i++){
		for($j=0;$j<3;$j++){

		}
	}

}

function win($testme){
	for($j=0;$j<3;$j++){

	}
}


play($state,$turn,$humansign,$aisign);


	//	---->  RANDOM ai_________________________________________________

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

				/*

for($i=0;$i<3;$i++){
	for($j=0;$j<3;$j++){

	}
}


			$temp=$state; 	// get the state to reuse 
			$depth=9;
			$bestmove=-100;
			for($j=0;$j<=isset($state[$j]);$j++){	// for each cell
				if($state[$j] !== 'X' and $state[$j] !== 'O'){		//	if free
					for($i=0;$i<=isset($index[$i]);$i++){
						$state2[$i]= $humansign;	// add a mark to the actual cell
						$current[] = $state;	//	store the state of the board
						$index[] = $j;			// store the index
						$state2=$state;
						$state2=$temp;		// back to state
					}
						//minimax ($state,$aisign);

						$state=$temp;		// back to state		
				}

			}


					for($d=0;$d<=$depth;$d++){
						if($d == 1 || $d %2 !== 0){
						}		
					}	

			$current[$j][]=$state[$j];	// store current board to test WIN state
				$current[$j][$state[$j]]=$humansign;	// replace value with mark
				$index[]=$state[$j];			// store the index to check 

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
		


}



?>
