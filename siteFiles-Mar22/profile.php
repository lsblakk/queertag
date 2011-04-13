<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Profile</title>
<style>
#people_box{
	border:1px solid #333;
	width:290px; 
	height:390px;
	padding:5px;
}
</style>
</head>
<body>
<div id="people_box" data-role="page">
<?php
$uid = (int)$_GET['u'];

if ($uid){
	$dsn = 'mysql:dbname=coffeemill;host=mysql.robynoverstreet.com';
	$user = 'xxxx';
	$pw = 'xxxx';
	$db = new PDO($dsn,$user,$pw);
	$query = "SELECT * FROM user WHERE uid = ? LIMIT 1 ";
	$stmt = $db->prepare($query);
	if ($stmt->execute(array($uid))){
		$result = $stmt->fetch();	
		if ($result){
			echo '<img src="img/avatars/'.$result['avatar'].'" />';
			echo '<h3>'.$result['username'].'</h3>';
			echo "<p>profile coming soon</p>";
		} else {
			echo "no result";
		}
			
	} else {
		echo "DB problem";
		//print_r($stmt->errorInfo());
	}
}

?>
</div>
</body>
</html>