<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<style type="text/css">
		html { height: 100% }
		body { height: 100%; margin: 0; padding: 0 }
		#map-canvas { height: 100% }
	</style>
	<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyBXS2w40hmb0AKyCIRTj8AaVHSFQ4cnYEQ&sensor=false">
	</script>
	<script type="text/javascript">
		var geocoder;
		var map;
		function initialize() {
			geocoder = new google.maps.Geocoder();
			//var latlng = new google.maps.LatLng(-37.753344,144.980621);
			var mapOptions = {
				zoom: 14,
				//center: latlng
			}
			var infowindow = new google.maps.InfoWindow({
				content: '<b>Address</b><br /><?=$venue['address'] . ' ' . $venue['suburb'];?>'
					+ '<br /><a href="https://maps.google.com/maps?daddr=<?=urlencode($venue['address'] . ' ' . $venue['suburb']);?>" target="_blank">Get Direction To Here</a>'
			});

			var address = "<?=$venue['address'] . ' ' . $venue['suburb'];?>";
			geocoder.geocode( { 'address': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					map.setCenter(results[0].geometry.location);
					var marker = new google.maps.Marker({
						map: map,
						position: results[0].geometry.location
					});
					google.maps.event.addListener(marker, 'click', function() {
						infowindow.open(map,marker);
					});
					
				} else {
					alert("Geocode was not successful for the following reason: " + status);
				}
			});
			map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
		}
		
		google.maps.event.addDomListener(window, 'load', initialize);
		

		
	</script>
</head>
<body>
	<div id="map-canvas"></div>
</body>
</html>