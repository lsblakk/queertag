<?php
ini_set('browscap','/home/robynover/creativegeekery.com/geo/lite_php_browscap.ini');
$ua = $_SERVER['HTTP_USER_AGENT'];
/*echo "<h1>$ua</h1>";

if (strpos($ua,'Mobile') !== false || strpos($ua,'iPhone') !== false || strpos($ua,'Android') !== false || strpos($ua,'BlackBerry') !== false){
	echo "<h2>Mobile!</h2>";
}*/
echo get_browser();

