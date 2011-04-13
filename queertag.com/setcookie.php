<?php
$secret = file_get_contents('/home/robynover/code.txt');
$hash = md5("robyn".'robynover@gmail.com'.$secret);
setcookie('username','robyn');
setcookie('user_hash',$hash);
setcookie('login_time',time());
