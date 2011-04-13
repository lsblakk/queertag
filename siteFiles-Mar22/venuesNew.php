<?php
require_once('geohash/geohash.class.php');
//$lat = (float)$_POST['lat']; //37.755190
//$lng = (float)$_POST['long']; //-122.406401
$lat = 37.867756; 
$lng = -122.259345;
//--db------//
$dsn = 'mysql:dbname=coffeemill;host=mysql.robynoverstreet.com';
$user = 'xxxx';
$pw = 'xxxx';
$db = new PDO($dsn,$user,$pw);
//---------//
$allowed_categories = array(
	'Food',
	'Arts & Entertainment',
	'Colleges & Universities',
	'Great Outdoors',
	'Gyms or Fitness Centers',
	'Libraries',
	'Nightlife Spots',
	'Shops'
);
/*

1. get user's geohash
2. make 4-digit version of user's geohash
3. run query for clusters nearby
4. pull average lat/long of cluster
5. send avg to foursquare

*/
//get user's geohash
$geohash=new Geohash(); 
$code = $geohash->encode($lat,$lng);
//make 4-digit version of user's geohash
$char4 = substr($code,0,4); //first 4 characters
//echo $char4;
$query = "SELECT *, LEFT(geohash,6) AS gh6, count(uid) AS ct, GROUP_CONCAT(DISTINCT uid),";
$query .= " AVG(latitude) AS avg_lat ,AVG(longitude) AS avg_long FROM checkin  WHERE active= 1 ";
$query .= " AND LEFT(geohash,4) = ? GROUP BY gh6 HAVING ct > 2  ORDER BY ct DESC, checkintime DESC LIMIT 4";
//echo $query;
$stmt = $db->prepare($query);
if ($stmt->execute(array($char4))){
	$results = $stmt->fetchAll();
	if ($results){
		//var_dump($results);
		foreach ($results as $r){
			$num_ppl = $r['ct'];
			echo "$num_ppl people clustered near:"; 
			$avg_lat = $r['avg_lat'];
			$avg_long = $r['avg_long'];
			$url = 'https://api.foursquare.com/v2/venues/search?&ll='.$avg_lat.','.$avg_long;
			$url .='&client_id=RNT5GYZRD3LHYG0FF1KXM2ZC2VV0QYO2SNEGNHKYOH51FG1Z&client_secret=PQIENH1C02M1UNS5V5XT1DBFKK5DZ5DVJLKVYHSXVBZAKNHA';
			$foursq = file_get_contents($url);
			$json = json_decode($foursq);
			//var_dump($json);
			if ($json->response->groups[1]){
				$nearby = $json->response->groups[1];
			} else {
				$nearby = $json->response->groups[0];
			}
			$venue_count = 0;
			echo "<ul>";
			foreach ($nearby->items as $item){
				if ($venue_count >= 10){break;}
				$venue_categories = $item->categories[0]->parents; //array
				if (is_array($venue_categories)){
					$intersect = array_intersect($allowed_categories,$venue_categories);
					if (count($intersect) > 0){
						if ($item->stats->checkinsCount > 25 && strlen($item->categories[0]->name) > 2){
							echo '<li>';
							if ($item->categories[0]->icon){
								echo '<img src="'.$item->categories[0]->icon.'" /> ';
							}
							echo '<a href="http://foursquare.com/venue/'.$item->id.'">'.$item->name."</a><br/>\n";
							echo $item->location->address."</li>\n\n";
							$venue_count++;
						}
					}
				}

			}
			echo "</ul>";
			
		}
	}else {
		//var_dump($stmt->errorInfo());
		echo "<p>No hotspots found</p>";
	}
}





//var_dump($json);
/*********************
==Relevant Categories==
Food
Arts & Entertainment
Colleges & Universities
Great Outdoors
Gyms or Fitness Centers
Libraries
Nightlife Spots
Shops
**********************/




/* ---item format----
* id: "4b81ea40f964a520e0c330e3"
* name: "Brooklyn Bridge Park - Pier 1"
* contact: { }
* location: {
      o address: "334 Furman Street"
      o city: "Brooklyn"
      o state: "NY"
      o postalCode: "11201"
      o lat: 40.701984159668676
      o lng: -73.9969539642334
      o distance: 338
  }
* categories: [
      o {
            + id: "4bf58dd8d48988d163941735"
            + name: "Parks"
            + icon: "http://foursquare.com/img/categories/parks_outdoors/default.png"
            + parents: [
                  # "Great Outdoors"
              ]
            + primary: true
        }
  ]
* verified: false
* stats: {
      o checkinsCount: 3923
      o usersCount: 2605
  }
* todos: {
      o count: 0
  }
* hereNow: {
      o count: 0
  }


*/
?>