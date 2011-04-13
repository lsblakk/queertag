<?php
$secret = file_get_contents('/home/robynover/code.txt');
$hash = "robyn".'robynover@gmail.com'.$secret;
setcookie('uname','robyn');
setcookie('user_hash',$hash);
setcookie('login_time',time());
