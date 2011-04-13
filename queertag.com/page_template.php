<?php
ini_set('display_errors',1);
require_once('functions.php');
//var_dump($_COOKIE);
//check if mobile or desktop
if (!isMobile()){
	//send to desktop version
	//exit;
}
//check if logged in
if (isset($_COOKIE['username'])){
	$username = $_COOKIE['username'];
	$login_time = $_COOKIE['login_time'];
	$user_hash = $_COOKIE['user_hash'];
	//check username + hash with db
	//hash = md5 of username+email+secretcode
	$secret = file_get_contents('/home/robynover/code.txt'); //dreamhost home = /home/robynover/
	
	//get db credentials
	require_once('/home/robynover/coffee_db.php');
	//
	$db = new PDO($dsn,$dbuser,$dbpw);
	//get user's email from db
	$query = "SELECT email FROM user WHERE username = ?";
	$stmt = $db->prepare($query);
	if ($stmt->execute(array($username))){
		$result = $stmt->fetch();
		if ($result['email']){
			$user_email = $result['email'];	
		} else {
			//echo "no email results";
			exit;
		}
	} else {
		//echo "database error.";
		exit;
	}
	$server_hash = '';
	if ($user_email){
		$server_hash = md5($username.$user_email.$secret);
	}
	//$server_hash = ;
	if ($server_hash != $user_hash){
		//redirect to login
		//echo "hashes don't match";
		exit;
	}
} else {
	//redirect to login
	//echo "no cookie set";
	exit;
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="HandheldFriendly" content="true" />
	<meta name="viewport" content="width=device-width, height=device-height, user-scalable=no" />	
  	<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
	<title>Queertag</title>
	
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.5.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.js"></script>
	<style>
	/*custom active state -- replaces blue with lt. gray*/	
	.ui-btn-active2 {
		border: 1px solid 		#999;
		background: 			#eee;
		font-weight: bold;
		color: 					#333;
		cursor: pointer;
		text-shadow: 0 -1px 1px #fff;
		text-decoration: none;
		background-image: -moz-linear-gradient(top, 
								#eee, 
								#999);
		background-image: -webkit-gradient(linear,left top,left bottom,
			color-stop(0, 		#eee),
			color-stop(1, 		#999));
	  	-msfilter: "progid:DXImageTransform.Microsoft.gradient(startColorStr='#eee', EndColorStr='#999')";
	  	outline: none;
	}
	</style>

</head>
<body>
<?php
	
$this_pg = 'home';
$this_section = 'home';
//display header -- customize based on current page ($this_pg)
?>
	<div id="container" data-role="page">
			<div id="topbanner" style="background-color:#c06;width:100%;"><img src="img/logo.gif" alt="Queertag!"/></div>
			<div id="header" data-role="header">
				<div data-role="navbar" data-theme="a">
					<ul>
					<li><a href="proximity2.html" data-theme="a" rel="external">Home</a></li>
					<li><a href="proximity-list2.html" data-theme="a" rel="external">Hookups</a></li>
					<li><a href="nearby-venues2.html" data-theme="a" class="" rel="external">Hotspots</a></li>
					</ul>
				</div><!-- /navbar -->
			</div> <!--/header-->
			
			<!-- ======CONTENT========= -->
			<div id="content" data-role="content">
				<?php
				echo "Welcome, $username";
				?>
			</div> <!--/content-->
			<!-- ====================== -->
			
	</div><!-- /container -->

</body>
</html>



