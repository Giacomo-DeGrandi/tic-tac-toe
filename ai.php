<?php

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
	$test=array_rand($played,1);
	$test=explode(',',$played[$test]);
	$board[$test[0]][$test[1]]=$sign;
	$_SESSION['turn']++;
	return $board;
}

?>
