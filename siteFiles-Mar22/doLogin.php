<?php
session_start();
$username = 0;
$hash = 0;
if (ctype_alnum($_POST['u'])){
	$username = $_POST['u'];
}
if (ctype_alnum($_POST['pw'])){
	$hash = md5($_POST['pw']);
}

if ($username && $hash){
	$dsn = 'mysql:dbname=coffeemill;host=mysql.robynoverstreet.com';
	$user = 'xxxx';
	$pw = 'xxxx';
	$db = new PDO($dsn,$user,$pw);
	$query = "SELECT uid FROM user WHERE username = ? AND passwordhash = ?";
	$stmt = $db->prepare($query);
	if ($stmt->execute(array($username,$hash))){
		$result = $stmt->fetch();
		if ($result['uid']){
			echo "valid,".$result['uid'];
			$_SESSION['uid'] = (int)$result['uid'];
			exit;
		} else {
			echo "invalid username and password combination";
			//var_dump($result);
			//echo "<P>".$hash;
			//echo "<p> user = $user";
		}
	} else {
		echo "database error.";
	}
} else {
	echo "invalid input";
}
?>

