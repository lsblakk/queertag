<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>HTML5</title>

<script type="text/javascript" src="js/jquery-1.5.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>

<body onload="loadDemo()">
	
<div id="locbox">your location is...</div>
<div id="status" style="border:1px solid #333;"></div>

<script type="text/javascript">

    function loadDemo() {
        if(navigator.geolocation) {
         
			navigator.geolocation.getCurrentPosition(updateLocation);
		
        }
    }

	function updateLocation(position) {
		//console.log('update location called');
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        if (!latitude || !longitude) {
            //document.getElementById("status").innerHTML = "HTML5 Geolocation is supported in your browser, but location is currently not available.";
            return;
        }
		
		geocoder = new google.maps.Geocoder();
		var latlng = new google.maps.LatLng(latitude,longitude);
	    
		//geocode -- get name of place
		geocoder.geocode({'latLng': latlng}, function(results, status) {
		      if (status == google.maps.GeocoderStatus.OK) {
		        if (results[1]) {
					//show location name
					document.getElementById("locbox").innerHTML = results[1].formatted_address;
					//send checkin
					$.ajax({
					       type: "POST",
					       url: "doCheckin.php",
					       data: "lat="+latitude+'&long='+longitude+'&uid=1',
					       success: function(msg){
					         //alert( "Data Saved: " + msg );
					         document.getElementById("status").innerHTML = msg;
					       }
					    });
					
		        }
		      } else {
		        alert("Geocoder failed due to: " + status);
		      }
		    });
        /*document.getElementById("latitude").innerHTML = latitude;
        document.getElementById("longitude").innerHTML = longitude;*/
    }


</script>
</body>
</html>