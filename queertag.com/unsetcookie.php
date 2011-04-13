<?php
//$secret = file_get_contents('/home/robynover/code.txt');
//$hash = md5("robyn".'robynover@gmail.com'.$secret);
$time = time() - 3600;
setcookie('username','',$time);
setcookie('user_hash','',$time);
setcookie('login_time','',$time);
