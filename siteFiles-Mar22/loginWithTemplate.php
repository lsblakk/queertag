<?php
$title ="Login";
$content = <<<EOT
<div id = "status"></div>
<form method="post">
<p>Username<br/><input type="text" name="username" id="username"/></p>
<p>Password<br/><input type="password" name="password" id="pw"/></p>
<input type="submit" alt="Login" name="submit" value="Go" id="login_btn"/>
</p>
EOT;
//process form
if (isset($_POST['submit']) && $_POST['submit'] == 'Go'){
	$username = 0;
	$hash = 0;
	if (ctype_alnum($_POST['username'])){
		$username = $_POST['username'];
	}
	if (ctype_alnum($_POST['password'])){
		$hash = md5($_POST['password']);
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
				$email = $result['email'];
				$db_username = $result['username'];	
				$secret = file_get_contents('/home/robynover/code.txt');
				$hash = md5($db_username.$email.$secret);
				setcookie('username',$db_username);
				setcookie('user_hash',$hash);
				setcookie('login_time',time());
				//setcookie('checked_in',1,time()+3600);
				//redirect to welcome screen
				header('Location:welcome.php?login_success=1');
				exit;
			} else {
				$content = "<p>invalid username and password combination</p>".$content;
				//var_dump($result);
				//echo "<P>".$hash;
				//echo "<p> user = $user";
			}
		} else {
			$content =  "<p>database error.</p>".$content;
		}
	} else {
		$content = "<p>invalid input</p>".$content;
	}
}




require_once('page_template_noLogin.php');




/*
---------------------------
--for ajax login--
---------------------------

<script src="js/h5utils.js"></script>
<script>
addEvent(document.querySelector('#login_btn'), 'click', function () {
	//go to db and verify pw/username combo
	//send md5 to db?
	//alert('clicked');
	var pw =document.getElementById('pw').value;
	var username = document.getElementById('username').value;

	$.ajax({
       type: "POST",
       url: "doLoginNew.php",
       data: "u="+username+'&pw='+pw,
       success: function(msg){
         //alert( "Data Saved: " + msg );
		var msg_parts = msg.split(',');
		if (msg_parts[0] == 'valid'){
			document.getElementById('status').innerHTML = 'You are logged in.';
		} else {
			document.getElementById('status').innerHTML = msg;
		}
	  }
	});
});


</script>*/
?>