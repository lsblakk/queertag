<?php
ini_set('display_errors',1);
require_once('functions.php');

//var_dump($_COOKIE);
//check if mobile or desktop
if (!isMobile()){
	//send to desktop version
	//exit;
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="HandheldFriendly" content="true" />
	<meta name="viewport" content="width=device-width, height=device-height, user-scalable=no" />	
  	<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
	<title>Queertag | <?php echo $title; ?></title>
	
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.5.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.js"></script>
	<?php echo $head_extras; ?>
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
				echo $content;
				?>
			</div> <!--/content-->
			<!-- ====================== -->
			
	</div><!-- /container -->

</body>
</html>



