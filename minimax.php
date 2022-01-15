<?php

//main resource https://adrien.poupa.fr/tpe/algorithme-minmax

function ia($board,$sign){	// 

		$state=$board;		// get the current state of the board
		$aisign=$_SESSION['aisign'];
		$humansign=$_SESSION['humansign'];
		$turn=$_SESSION['turn'];

		// here  -->

function play($state,$turn){
	$max=1000;
	for($i=0;$i<3;$i++)
}
/*
function play($state,$turn){
			echo 'play';
   			$max = -10000;		// give a value to moves to compare it with mini
			for($i=0;$i<3;$i++){		// start the loop
				for($j=0;$j<3;$j++){
					if($state[$i][$j] === 0){	//	if free	
						$state[$i][$j] = $aisign;	// add AI SIGN to the actual cell and then test the play
							var_dump($state);
						$cellval = mini($state, $turn +1,$aisign,$humansign);	// evaluate the cell with mini funct simulating
								// opponent's choices, return the evaluated cells
								// send the state of the changed board , num of turn +1 to simulate match
								// send the val of ai and 	var_dump($state);human signs 
						echo $cellval;
		                if($cellval > $max){		// if value is greater than the max
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
	return $playnow;	//echo $playnow;
}

// MINIMiSER function to act as the minimiser player------------------------------
// this means that this player strategy is to play the LOWEST possible value 	||

function mini($state,$turn,$humansign,$aisign){
	echo 'mini';
    	$min = 10000;
    if ($turn == 9 or win($state,$turn,$aisign,$humansign) != 0){	// check for wins or draw								<-- WIN
    	//echo value($state,$turn,$aisign,$humansign);
        return value($state,$turn,$aisign,$humansign);		// else, send the evalued game plan at the end of the simulated match 
    }
    for($i=0;$i<3;$i++){		// foreach cells
        for($j=0;$j<3;$j++){
			if($state[$i][$j] === 0){	//	if free	
                $state[$i][$j] = $humansign;	// add a mark to the actual cell
                $cellval = maxi($state, $turn +1,$aisign,$humansign);	// evaluate the cells sending the MAXI func 		<-- MAXI
                if($cellval < $min) {		// if value is smaller than the min
                    $min = $cellval;        // chose that value
                    $state[$i][$j] = 0;		// reset the cell
                }
            }
        }
    }
    echo $min;
    return $min; 		// return the result of min as an int fo further evaluation 
}

// MAXIMiSER function to act as the maximiser player------------------------------
// this means that this player strategy is to play the GREATEST possible value 	||

function maxi($state,$turn,$aisign,$humansign){	// function for maximiser player
		echo 'maxi';
   		$max = -10000;		// give a value to maximiser player to subtract every turn and to split in values
    if ($turn == 9 || win($state,$turn,$aisign,$humansign) != 0){	// check for wins or draw			<-- WIN
        return value($state,$turn,$aisign,$humansign);		// else, send the evalued game plan			<-- VALUE
    }
    for($i=0;$i<3;$i++){	// for each cell
		for($j=0;$j<3;$j++){
			if($state[$i][$j] === 0){	//	if free	
                $state[$i][$j] = $aisign;	// add a mark to the actual cell
                $cellval = mini($state, $turn +1,$aisign,$humansign);	// evaluate the cell sending the MINI to play on the last turns  <-- MINI
                if($cellval > $max){		// if value is greater the max
                    $max = $cellval;        // chose that value
                    $state[$i][$j] = 0;		// reset the cell
                }
            }
        }
    }
    echo $max;
    return $max; 		// return the result of max as an int fo further evaluation 
}

// function to count the simulation of turns and check winning states

			//	the state , the series passed by reference (0 ,0 check value() for details), the two player signs and 
function series($state,&$seriesp1,&$seriesp2,$humansign,$aisign,$cell=0){	// the num of the cells to count
	echo 'series';
	$seriesp1=0;	//initialise counters SERIES for player 1 		|Each loop repetition move the starter pointer to another cell
	$seriesp2=0;	//initialise counters SERIES for player 1 		|moving in this way the evaluation rows checks
	$checkp1=0;			// reinitialise counters for player 1 every lines
	$checkp2=0;			// reinitialise counters for player 2 every lines
	echo 'diag1';
	for($i=0;$i<3;$i++){		// start to count DIAGONAL 1 __________
		if($state[$i][$i] === $aisign ){	// if the current cell is a 1 ($aisign) NB state [ $i ][ $i ] 
			$checkp1++;		// p1 made a combo
			$checkp2=0;		// reset the counter of p2
			if($state[$i][$i] == $cell){
					$seriesp1++;		// count the cell, add a value to reloop in other dir for next serie
			}
		} elseif ($state[$i][2-$i] === $humansign ){	// if the current cell is a 2 ($humansign) NB state [ $i ][ 2- $i ]	(value -2,0)
			$checkp2++; // p2 made a combo
			$checkp1=0;		// reset the counter of p1
			if($state[$i][2-$i] == $cell){
				$seriesp2++;	// count the cell, add a value to reloop in other dir for next serie
			}
		}
	}
	echo 'diag2';
	echo $seriesp1,$seriesp2,$checkp1,$checkp2;
	$checkp1=0;			// reinitialise counters for player 1 every lines
	$checkp2=0;			// reinitialise counters for player 2 every lines
	for($i=0;$i<3;$i++){		// start to count DIAGONAL 2 ___________
		if($state[$i][$i] === $aisign ){	// if the current cell is a 1 ($aisign)
			$checkp1++;		// p1 made a combo
			$checkp2=0;		// reset the counter of p1
			if($state[$i][$i] == $cell){
					$seriesp1++;		// count the cell, add a value to reloop in other dir for next serie
			}
		} elseif ($state[$i][$i] === $humansign ){
			$checkp2++; // p2 made a combo
			$checkp1=0;		// reset the counter of p1
			if($state[$i][$i] == $cell){
				$seriesp2++;	// count the cell
			}
		}
	}
	echo $seriesp1,$seriesp2,$checkp1,$checkp2;
	for($i=0;$i<3;$i++){		//start the count loop for HORIZONTALS and VERTICALS combos count from 0 to 2 
								// reinitialise the counter for  VERTICALS checks
			$checkp1=0;			//initialise counters for player 1 every lines
			$checkp2=0;			//initialise counters for player 2 every lines
		for($j=0;$j<3;$j++){	// check who occupy the current cell
			if($state[$i][$j] === $aisign ){	// if the current cell is a 1 ($aisign)
				$checkp1++;		// p1 made a combo
				$checkp2=0;		// reset the counter of p2
				if($state[$i][$j] === $cell){	// a num from 0 to 2 based on which cell indicates that a serie has finished 
					$seriesp1++;		// count the cell, add a value to reloop in other dir for next serie
				}
			} elseif ($state[$i][$j] === $humansign ){
				$checkp2++;		// p2 made a combo
				$checkp1=0;		// reset the counter of p1
				if($state[$i][$j] === $cell){
					$seriesp2++;	// count the cell, add a value to reloop in other dir for next serie
				}
			}
		}
		// reinitialise the counter for  VERTICALS checks in the same loop
			$checkp1=0;			// reinitialise counters for player 1 every lines
			$checkp2=0;			// reinitialise counters for player 2 every lines
		for($j=0;$j<3;$j++){		// start to count VERTICALS
			if($state[$i][$j] === $aisign ){	// if the current cell is a 1 ($aisign)
				$checkp1++;		// p1 made a combo
				$checkp2=0;		// reset the counter of p1
				if($state[$i][$j] === $cell){
					$seriesp1++;		// count the cell, add a value to reloop in other dir for next serie
				}
			} elseif ($state[$j][$i] === $humansign ){ // if the current cell is a 2 ($humansign) NB state [ $j(before) ][ $i ]	to swap
				$checkp2++; // p2 made a combo
				$checkp1=0;		// reset the counter of p1
				if($state[$j][$i] === $cell){
					$seriesp2++;	// count the cell, add a value to reloop in other dir for next serie
				}
			}
		}
			echo $seriesp1,$seriesp2,$checkp1,$checkp2;
	}
}

function value($state,$turn,$aisign,$humansign){	 // Value of the state   

	echo 'value';
    $played = 0;    //check played cells__________ (possibilities check)
    for($i=0;$i<3;$i++){
    	for($j = 0;$j<3;$j++){
            if($state[$i][$j] === 0){	//	if free
                $played++;		// if cell is played add 1 to played 
            }
        }
    }
    if (win($state,$turn,$aisign,$humansign) != 0) {	// check winner state___________	<-- WIN
			win($state,$turn,$aisign,$humansign);
        $winner = win($state,$turn,$aisign,$humansign);									//    <-- WIN
        if($winner == $aisign){
            return 100 - $played;
            echo 'case1';
        }	elseif($winner == $humansign) {
            return -100 + $played;
            echo 'case2';
        }	else {	
        	//echo 'case3';
        	return 0;	}
    }
    $p1wins = 0;    // count player 1 wins
    $p2wins = 0;    // count player 2 wins
    series($state, $p1wins, $p2wins,$aisign,$humansign, 2);	// check the series num of the 2 allineated signs  	
    			// fill up this two value with wins record							//    <-- SERIES
    return $p1wins - $p2wins;		// return the difference between the two players count of victories
}

function win($state,$turn,$aisign,$humansign){
	echo 'win';
	$testme=$state;
	$winner=series($state, $p1wins, $p2wins,$aisign,$humansign, 3);	// test for series of same sign 3 times
	if( $winner == 1){
		return 1;
	} elseif( $winner == 2){
		return 2;
	} elseif ($turn == 9){
		return 0;	//draw
	} else {
		return 3;	//continue
	}
}

// now play 
	$board = play($state,$turn);
	echo $board;
	if($aisign === 1){ $sign = 'X';}	// declare and get the aisign and humansign
	if($aisign === 2){ $sign = 'O';}
	$_SESSION['turn']++;				// add a turn
	return array($board => $sign);		// return ai moves and sign

}
*/


?>
