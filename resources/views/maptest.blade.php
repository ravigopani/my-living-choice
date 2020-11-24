<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		#map {
	  		height: 400px;
	  		width: 100%;
	  		background-color: grey;
		}
	</style>
</head>
<body>
	<div id="map"></div>
	<script type="text/javascript">
		function initMap() {
			  var center = {lat: 34.052235, lng: -118.243683};
			  var locations = [
			    ['test address 1', 34.046438, -118.259653],
			    ['test address 2', 34.017951, -118.493567],
			    ['test address 3', 34.143073, -118.132040],
			    ['test address 4', 33.655199, -117.998640],
			    ['test address 5', 34.142823, -118.254569]
			  ];
			var map = new google.maps.Map(document.getElementById('map'), {
			    zoom: 9,
			    center: center
			  });
			var infowindow =  new google.maps.InfoWindow({});
			var marker, count;
			for (count = 0; count < locations.length; count++) {
			    marker = new google.maps.Marker({
			      position: new google.maps.LatLng(locations[count][1], locations[count][2]),
			      map: map,
			      title: locations[count][0]
			    });
			google.maps.event.addListener(marker, 'click', (function (marker, count) {
			      return function () {
			        infowindow.setContent(locations[count][0]);
			        infowindow.open(map, marker);
			      }
			    })(marker, count));
			  }
		}
	</script>
	<script async defer
	    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB21RnJFbEed0ypqsqUSsQHukp_0LxgQuI&callback=initMap">
	</script>
</body>
</html>