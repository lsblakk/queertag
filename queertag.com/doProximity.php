<?php
require_once('geohash/geohash.class.php');
require_once('geohash/adjacent.php');

/*
1 deg lat = 69.172mi
1 deg long = cos(lat in mi) * 69.172mi
*/

$lat = (float)$_POST['lat'];
$long = (float)$_POST['long'];
$is_list = (int)$_POST['list'];

//echo "Got lat/long: $lat,$long";

$dsn = 'mysql:dbname=coffeemill;host=mysql.robynoverstreet.com';
$user = 'xxx';
$pw = 'xxxxx';
$db = new PDO($dsn,$user,$pw);

//encode geohash
$geohash=new Geohash(); 
$code = $geohash->encode($lat,$long);
$char4 = substr($code,0,5); //first 5 characters
$neighbors = getNeighbors(substr($code,0,6));
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

//find proximity based on geohash
//SELECT * FROM `checkin` WHERE LEFT(geohash,4) = '9q9p' 

if ($is_list){
	//find user names
	//SELECT * FROM `checkin` LEFT JOIN user on user.uid = checkin.uid WHERE LEFT(geohash,4) = '9q9p'
	//$query = "SELECT DISTINCT user.uid,username FROM checkin LEFT JOIN user on user.uid = checkin.uid WHERE LEFT(geohash,4) = ?";
	$query = "SELECT * FROM user WHERE uid IN (SELECT DISTINCT uid FROM `checkin` WHERE LEFT(geohash,6) IN (?,?,?,?,?,?,?,?,?) AND active=1) ";
	$stmt = $db->prepare($query);
	if ($stmt->execute($neighbors)){
		$result = $stmt->fetchAll();
		if ($result){
			$ppl_word = 'people';
			if ($stmt->rowCount() == 1){$ppl_word = 'person';}
			echo '<p>'.$stmt->rowCount() ." $ppl_word near you</p>\n";
			echo '<ul>';
			foreach ($result as $r){
				//<img src="img/avatars/punk.jpg"/>
				//title="'.$r['username']
				echo '<li><img src="img/avatars/';
				echo $r['avatar'];
				echo '" title="'.$r['username'].'"/>';
				echo '<a class="uname" href="profile.php?u='.$r['uid'].'">';
				echo $r['username'];
				echo '</a></li>';	
			}
			echo '</ul>';
		} else {
			echo "<p>No people currently nearby</p>";
		}
	} else {
		echo "<p>Problem with DB</p>";
	}
	exit;
}

$stmt = $db->prepare("SELECT * FROM checkin WHERE LEFT(geohash,6) IN (?,?,?,?,?,?,?,?,?) AND active=1 GROUP BY uid");
if ($stmt->execute($neighbors)){
	$result = $stmt->fetchAll();
	
	if ($result){
		//echo $stmt->rowCount() ." people near you \n";
		$coords = array();
		$count = 1;
		foreach ($result as $r){
			//echo "<li>check-in id: ".$r['ckid']."</li>\n";
			echo $r['latitude'].','.$r['longitude'];
			if ($count != $stmt->rowCount()){
				echo "\n";
			}
			
			$count++;
		}
		//echo json_encode($coords);
	}
	
} else {
	echo "<p>Problem with DB</p>";
}
?>