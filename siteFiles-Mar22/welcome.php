<?php
$title = "Welcome";
$username = strip_tags($_COOKIE['username']);
$content = "Welcome, $username";
if ($_GET['login_success'] == 1){
	$content .= "<p>You are logged in</p>";	
}
$content .= "<p>There are <em>x</em> people nearby.</p>";
$content .= "<p>You are visible. You can go invisible, but you won't but you won't be able to see profiles or chat.</p>";
$content .= "<p><strong>This page needs a footer with options to checkin, go invisible, etc</strong></p>";

require_once('page_template2.php');

?>