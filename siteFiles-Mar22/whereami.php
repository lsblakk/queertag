<pre><?php
$url = 'https://api.foursquare.com/v2/venues/search?ll=37.755190,-122.406401&intent=match';
$url .='&oauth_token=ESAFTKDLTU4ACOAHFMVS3FFPGFHJDBSIFINX045ZHH05UC53';
$foursq = file_get_contents($url);
$json = json_decode($foursq);

$nearby = $json->response->groups[1];
var_dump($json);
/*echo "<ol>";
foreach ($nearby->items as $item){
	if ($item->stats->checkinsCount > 25){
		echo "<li>".$item->name.", category:".$item->categories[0]->name."\n";
		echo $item->location->address."  checkins: ".$item->stats->checkinsCount."</li>\n\n";
	}
	
}
echo "</ol>";*/
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