<?php
$lat = (float)$_POST['lat']; //37.755190
$lng = (float)$_POST['long']; //-122.406401
//$lat = 37.755190; 
//$lng = -122.406401;
$url = 'https://api.foursquare.com/v2/venues/search?ll='.$lat.','.$lng;
//$url .='&oauth_token=ESAFTKDLTU4ACOAHFMVS3FFPGFHJDBSIFINX045ZHH05UC53';
$url .='&client_id=RNT5GYZRD3LHYG0FF1KXM2ZC2VV0QYO2SNEGNHKYOH51FG1Z&client_secret=PQIENH1C02M1UNS5V5XT1DBFKK5DZ5DVJLKVYHSXVBZAKNHA';
//echo $url;
$foursq = file_get_contents($url);
$json = json_decode($foursq);
if ($json->response->groups[1]){
	$nearby = $json->response->groups[1];
} else {
	$nearby = $json->response->groups[0];
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

echo "<ol>";
foreach ($nearby->items as $item){
	$venue_categories = $item->categories[0]->parents; //array
	if (is_array($venue_categories)){
		$intersect = array_intersect($allowed_categories,$venue_categories);
		if (count($intersect) > 0){
			if ($item->stats->checkinsCount > 25 && strlen($item->categories[0]->name) > 2){
				echo '<li>';
				if ($item->categories[0]->icon){
					echo '<img src="'.$item->categories[0]->icon.'" /> ';
				}
				echo '<a href="http://foursquare.com/venue/'.$item->id.'">'.$item->name."</a>, category: ".$item->categories[0]->name."<br/>\n";
				echo "Address: ".$item->location->address.". Checkins: ".$item->stats->checkinsCount."</li>\n\n";
			}
		}
	}
		
}
echo "</ol>";

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