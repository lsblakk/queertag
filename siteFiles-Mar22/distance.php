<?php
/*
1 deg lat = 69.172mi
1 deg long = cos(lat in mi) * 69.172mi

how many degrees in 1 mile? 1/69?

*/

$lat = 37.804372;
$long = -122.270802;

$lat_miles_in_1deg = $lat * 69.172;
$long_miles_in_1deg = cos($lat_miles_in_1deg) * 69.172; //25.134mi?

echo $long_miles_in_1deg;


?>
