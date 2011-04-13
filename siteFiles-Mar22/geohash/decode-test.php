<?php
require('geohash.class.php');
$gh = new Geohash();
$ll = $gh->decode('9q9p1d');

var_dump($ll);