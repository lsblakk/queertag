<?php
$title = "Welcome";
$head_extras = "\n".'<script src="http://maps.google.com/maps/api/js?sensor=false"></script>'."\n";
$content = <<<EOT
	<div id="status"><img src="img/loading29.gif"/> loading...</div>
	<div id="map_canvas" style="width:300px; height:400px;border:1px solid #333;"></div>

	<script type="text/javascript">

	    window.onload= function(){
			//alert('load location');
	        if(navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(updateLocation);		
	        }
	    }
		function updateLocation(position) {
			console.log('update location called');
	        var latitude = position.coords.latitude;
	        var longitude = position.coords.longitude;

	        if (!latitude || !longitude) {
	            return;
	        }
			$.ajax({
			       type: "POST",
			       url: "doProximity2.php",
			       data: "lat="+latitude+'&long='+longitude,
			       success: function(msg){
			         //alert( "Data Saved: " + msg );
			         
					var coords = msg.split("\\n");
					//console.log(msg);
					var ppl_word = 'people';
					if (coords.length == 1){ppl_word = 'person';}
					if (coords.length){
						document.getElementById("status").innerHTML = coords.length + ' '+ppl_word+' nearby <a href="proximity-list.html">View &raquo;</a>';
					} else {
						document.getElementById("status").innerHTML = 'No people currently nearby';
					}
					//create map
					var mylatlng = new google.maps.LatLng(latitude,longitude);
					var marker_image = 'http://www.google.com/mapfiles/marker_grey.png';
					//'http://www.google.com/mapfiles/marker_black.png'
					var myOptions = {
			            zoom: 14,
						center:mylatlng,
			            mapTypeId: google.maps.MapTypeId.ROADMAP,
						mapTypeControl: false,
						streetViewControl: false	
			        };
			        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
					//drop marker
					marker = new google.maps.Marker({
			              position: mylatlng, 
			              map: map,
						  icon:marker_image
			          });
					//lavender: #CA88D1
					if (coords.length){
						for (i=0;i<coords.length;i++){
							latlngArray = coords[i].split(',');
							var latlng = new google.maps.LatLng(latlngArray[0],latlngArray[1]);
							circle = new google.maps.Circle({
								center:latlng,
								radius:500, //meters
								fillColor:"#C06",
								strokeColor:"#C06",
								strokeOpacity:0,
								strokeWeight:0,
								map:map
							});
							
						}
					}
					
			       }
			    });
			//send lat/long to geohash, and get proximity
		}
	</script>

EOT;

require_once('page_template2.php');

?>