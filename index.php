<html>
<head>
<title>Walkscore</title>
    <style type="text/css">
      html, body, #map_canvas {
        margin: 0;
        padding: 0;
        height: 95%;
		width: 100%;
      }
    </style>
    
    
    
    
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
	
	function initialize() {
        var myOptions = {
          zoom: 15,
          center: new google.maps.LatLng(43.66437, -79.3676),
          mapTypeId: google.maps.MapTypeId.TERRAIN
        };

        var map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
		
		var neighbourhood;
		
		var neightbourhoodBoundries = [
        new google.maps.LatLng(43.65617, -79.37009),
		new google.maps.LatLng(43.66706, -79.37465),
		new google.maps.LatLng(43.66816, -79.36954),
		new google.maps.LatLng(43.67162, -79.37096),
		new google.maps.LatLng(43.67174, -79.37095),
		new google.maps.LatLng(43.67191, -79.37086),
		new google.maps.LatLng(43.67201, -79.37077),
		new google.maps.LatLng(43.67219, -79.37044),
		new google.maps.LatLng(43.67258, -79.36985),
		new google.maps.LatLng(43.67252, -79.36963),
		new google.maps.LatLng(43.67243, -79.36939),
		new google.maps.LatLng(43.67228, -79.36907),
		new google.maps.LatLng(43.67217, -79.36889),
		new google.maps.LatLng(43.67200, -79.36861),
		new google.maps.LatLng(43.67187, -79.36840),
		new google.maps.LatLng(43.67180, -79.36816),
		new google.maps.LatLng(43.67173, -79.36787),
		new google.maps.LatLng(43.67171, -79.36763),
		new google.maps.LatLng(43.67170, -79.36626),
		new google.maps.LatLng(43.67170, -79.36609),
		new google.maps.LatLng(43.67166, -79.36588),
		new google.maps.LatLng(43.67164, -79.36583),
		new google.maps.LatLng(43.67031, -79.36190),
		new google.maps.LatLng(43.67017, -79.36158),
		new google.maps.LatLng(43.67010, -79.36125),
		new google.maps.LatLng(43.67004, -79.36092),
		new google.maps.LatLng(43.66993, -79.35979),
		new google.maps.LatLng(43.66924, -79.35890),
		new google.maps.LatLng(43.66856, -79.3583),
		new google.maps.LatLng(43.66831, -79.3581),
		new google.maps.LatLng(43.66758, -79.3579),
		new google.maps.LatLng(43.66503, -79.3571),
		new google.maps.LatLng(43.66437, -79.3568),
		new google.maps.LatLng(43.66373, -79.3592),
		new google.maps.LatLng(43.66286, -79.3629),
		new google.maps.LatLng(43.66197, -79.3670),
		new google.maps.LatLng(43.65695, -79.3650),
		new google.maps.LatLng(43.65636, -79.3677),
		new google.maps.LatLng(43.65631, -79.3694),
        new google.maps.LatLng(43.65617, -79.37009)
];

    // Construct the polygon
    neighbourhood = new google.maps.Polygon({
      paths: neightbourhoodBoundries,
      strokeColor: "#008800",
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: "#33FF00",
      fillOpacity: 0.35
    });

   neighbourhood.setMap(map);
		
		
		
		<?php

	$ll_lat = 43.6566;
	$ll_lon = -79.37;
	$ur_lat = 43.67315;
	$ur_lon = -79.3620;
	$counter = 1;

	function getWalkScore($lat, $lon) {
		$url = "http://api.walkscore.com/score?format=json";
		$url .= "&lat=$lat&lon=$lon&wsapikey=a9edae68f91acf10308ce8e45c2881d8";
		$str = @file_get_contents($url); 
		return $str;
	} 

	$lat = $ll_lat;
	$lon = $ll_lon;
	
	
	//$file_ptr = fopen("file.txt", "w") or die("Couldn't create new file");
	
	while ($lat < $ur_lat) {
		while ($lon < $ur_lon){
			if (($lat < 43.66197 and $lon > -79.3659) or ($lon < -79.369569 and $lat > 43.667066) or ($lat > 43.669864 and $lon > -79.370231)){
					echo "";
			}else{
				$json = getWalkScore($lat,$lon);			
				$obj = json_decode($json);
				$incident_location = $lat . ", " . $lon;
				
				//var linkString = "<a href='"+$obj->{'ws_link'}+"'>View On WalkScore®</a>";
				//echo $incident_location;
				//echo "The walkscore at " .$incident_location ." is " .$obj->{'walkscore'} .". This is ".$obj->{'description'} .".<br>";
				//fwrite($file_ptr, "$lat,$lon,$obj->{'walkscore'},$obj->{'description'}" . "\n");
				echo 'var myLatlng'.$counter.' = new google.maps.LatLng('.$lat.', '.$lon.');
        marker'.$counter.' = new google.maps.Marker({
          position: myLatlng'.$counter.',
          map: map,';
		  if ($obj->{'walkscore'} > 89){
			  echo 'icon:"green.png",';
		  }else if ($obj->{'walkscore'} > 79){
			  echo 'icon:"blue.png",';
		  }else if ($obj->{'walkscore'} > 69){
			  echo 'icon:"white.png",';
		  }else if ($obj->{'walkscore'} > 59){
			  echo 'icon:"yellow.png",';
		  }else{
          	echo 'icon: "red.png",';
		  }
		  echo '
     	  animation: google.maps.Animation.DROP,
        });
        
        var infowindow'.$counter.' = new google.maps.InfoWindow({
	        content: "Score: '.$obj->{'walkscore'}.'. Description: '.$obj->{'description'}.'."
	    });
	    
	    google.maps.event.addListener(marker'.$counter.', "click", function() {';
		  for ($i = 1; $i <= 40; $i++) {
   			 echo "if (infowindow".$i.") infowindow".$i.".close();";														
		  }				
		  echo '
	      infowindow'.$counter.'.open(map,marker'.$counter.');
		  document.getElementById("score").innerHTML = "'.$obj->{'walkscore'}.'";
		  document.getElementById("description").innerHTML = "'.$obj->{'description'}.'";
		  document.getElementById("latlng").innerHTML = "'.$lat.', '.$lon.'";
		  document.getElementById("indexNum").innerHTML = "'.$counter.'";
		  document.getElementById("updated").innerHTML = "'.$obj->{'updated'}.'";
	    });';
				$counter++;
				/*fwrite($file_ptr, $lat . ",");
				fwrite($file_ptr, $lon . ",");
				fwrite($file_ptr, $obj->{'walkscore'} . ",");
				fwrite($file_ptr, $obj->{'description'} . "\n");*/
				
				//sleep(1);
				
			}
			$lon = ($lon + 0.002);
			$lat = ($lat + 0.0002);
		}
		$lat = ($lat + 0.0003);
		$lon = $ll_lon-0.00027*($counter/2);
	};
	
	
	 // fclose($file_ptr);
	
?>
		
		
    }

    function loadScript() {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'http://maps.googleapis.com/maps/api/js?sensor=false&' +
            'callback=initialize';
        document.body.appendChild(script);
     }
	 

     window.onload = loadScript;
	 
</script>
</head>
<body background="bg.jpg">
<div id="map_canvas"></div>
<form>
<table>
<tr>
<td width="90%">
<b>Point: <span id='indexNum'>Point Index</span><br /></b>
Score: <span id='score'>Score</span><br />
Descrption: <span id='description'>Description</span><br />
Location: <span id='latlng'>Latatude, Longitude</span><br />
</form>
</td>
<td>
Last Updated: <span id='updated'>Time Last Updated</span>
</tr>
</table>
</body>

</html>
