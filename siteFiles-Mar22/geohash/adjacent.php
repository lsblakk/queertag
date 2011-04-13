<?php
//echo calculateAdjacent('DQCJQ','top');
//$n = getNeighbors('9q9p38');
//var_dump($n);
/*$neighbors = getNeighbors('9q9p38');
$in_query = '';
$ct = 1;
foreach ($neighbors as $n){
	$in_query .= "'$n'";
	if ($ct < count($neighbors)){
		$in_query .= ',';
	}
	$ct++;
}
$in_query .= '';
echo $in_query;*/

function getNeighbors($hash){
	$neighbors = array($hash);
	$dirs = array ('top','bottom','left','right');
	foreach ($dirs as $d){
		$box = calculateAdjacent($hash,$d);
		$neighbors[] = $box;
		if ($d == 'top' || $d == 'bottom'){
			$neighbors[] = calculateAdjacent($box,'left');
			$neighbors[] = calculateAdjacent($box,'right');
		}
	}
	return $neighbors;
}

function calculateAdjacent($srcHash, $dir) {
	$base32 = "0123456789bcdefghjkmnpqrstuvwxyz";
	$neighbors['right']['even'] = "bc01fg45238967deuvhjyznpkmstqrwx";
	$neighbors['left']['even'] = "238967debc01fg45kmstqrwxuvhjyznp";
	$neighbors['top']['even'] = "p0r21436x8zb9dcf5h7kjnmqesgutwvy";
	$neighbors['bottom']['even'] = "14365h7k9dcfesgujnmqp0r2twvyx8zb";

	$neighbors['bottom']['odd'] = $neighbors['left']['even'];
	$neighbors['top']['odd'] = $neighbors['right']['even'];
	$neighbors['left']['odd'] = $neighbors['bottom']['even'];
	$neighbors['right']['odd'] = $neighbors['top']['even'];

	$borders['right']['even'] = "bcfguvyz";
	$borders['left']['even'] ="0145hjnp";
	$borders['top']['even'] ="prxz";
	$borders['bottom']['even']= "028b";;

	$borders['bottom']['odd'] = $borders['left']['even'];
	$borders['top']['odd'] = $borders['right']['even'];
	$borders['left']['odd'] = $borders['bottom']['even'];
	$borders['right']['odd'] = $borders['top']['even'];
	
	$srcHash = strtolower($srcHash);
	//var $lastChr = $srcHash.charAt($srcHash.length-1);
	$lastChr = $srcHash[strlen($srcHash)-1];
	$type = (strlen($srcHash) % 2) ? 'odd' : 'even';
	//var $base = $srcHash.substring(0,$srcHash.length-1);
	$base = substr($srcHash,0,strlen($srcHash)-1);
	/*
	if (BORDERS[dir][type].indexOf(lastChr)!=-1)
			base = calculateAdjacent(base, dir);
	*/
	if (strpos($borders[$dir][$type],$lastChr) !== false){
		$base = calculateAdjacent($base, $dir);	
	}
	//return $base + $base32[$neighbors[$dir][$type].indexOf($lastChr)];
	$indexOfLastChar = strpos($neighbors[$dir][$type],$lastChr);
	//echo $base;
	return $base . $base32[$indexOfLastChar];
}
