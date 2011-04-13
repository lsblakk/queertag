<?php
require_once('geohash/geohash.class.php');



$lat = (float)$_POST['lat'];
$long = (float)$_POST['long'];

echo "Got lat/long: $lat,$long";

$dsn = 'mysql:dbname=coffeemill;host=mysql.robynoverstreet.com';
$user = 'xxxxx';
$pw = 'xxxx';
$db = new PDO($dsn,$user,$pw);
//encode geohash
$geohash=new Geohash; 
$code = $geohash->encode($lat,$long);
echo "<p>Geohash code: $code</p>";

$stmt = $db->prepare("INSERT INTO checkin (uid,latitude,longitude,geohash,checkintime) VALUES (?,?,?,?,?)");
if ($stmt->execute(array(1,$lat,$long,$code,time()))){
	echo "<p>You are checked in!</p>";
	
} else {
	echo "<p>Could not save to DB</p>";
}
?>