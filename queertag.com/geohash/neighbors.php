<pre><?php
require_once('adjacent.php');

$dsn = 'mysql:dbname=coffeemill;host=mysql.robynoverstreet.com';
$user = 'xxxxx';
$pw = 'xxxx';
$db = new PDO($dsn,$user,$pw);

$neighbors = getNeighbors('9q9p38');
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
var_dump($neighbors);

$stmt = $db->prepare("SELECT * FROM checkin WHERE LEFT(geohash,6) IN (?,?,?,?,?,?,?,?,?) AND active=1 GROUP BY uid");
if ($stmt->execute($neighbors)){
	$result = $stmt->fetchAll();
	
	if ($result){
		echo $stmt->rowCount() ." people near you \n";
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