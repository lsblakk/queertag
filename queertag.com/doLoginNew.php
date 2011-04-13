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
	//get db credentials
	require_once('/home/robynover/coffee_db.php');
	$db = new PDO($dsn,$dbuser,$dbpw);
	$query = "SELECT uid,email,username FROM user WHERE username = ? AND passwordhash = ?";
	$stmt = $db->prepare($query);
	if ($stmt->execute(array($username,$hash))){
		$result = $stmt->fetch();
		if ($result['uid']){
			echo "valid,".$result['uid'];
			//$_SESSION['uid'] = (int)$result['uid'];
			$email = $result['email'];
			$db_username = $result['username'];	
			$secret = file_get_contents('/home/robynover/code.txt');
			$hash = md5($db_username.$email.$secret);
			setcookie('username',$db_username);
			setcookie('user_hash',$hash);
			setcookie('login_time',time());
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

