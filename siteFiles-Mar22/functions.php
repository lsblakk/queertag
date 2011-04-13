<?php
function isMobile(){
	$ua = $_SERVER['HTTP_USER_AGENT'];
	if (strpos($ua,'Mobile') !== false || strpos($ua,'iPhone') !== false || strpos($ua,'iPad') !== false || strpos($ua,'Android') !== false || strpos($ua,'BlackBerry') !== false){
		return true;
	}
	return false;
}