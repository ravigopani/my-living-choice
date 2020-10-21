{{-- <!DOCTYPE html>
<html>
    <head>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyB21RnJFbEed0ypqsqUSsQHukp_0LxgQuI"></script>
        <!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyB21RnJFbEed0ypqsqUSsQHukp_0LxgQuI&libraries=places&callback=initAutocomplete"
        defer></script> -->
        <script type="text/javascript">
        function initialize() {
        var address = (document.getElementById('my-address'));
        var autocomplete = new google.maps.places.Autocomplete(address);
        autocomplete.setTypes(['geocode']);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

        var address = '';
            if (place.address_components) 
            {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
            }
        });
}
function codeAddress() {
    geocoder = new google.maps.Geocoder();
    var address = document.getElementById("my-address").value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {

      alert("Latitude: "+results[0].geometry.location.lat());
      alert("Longitude: "+results[0].geometry.location.lng());
      } 

      else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
google.maps.event.addDomListener(window, 'load', initialize);

        </script>
    </head>
    <body>
        <input type="text" id="my-address">
        <button id="getCords" onClick="codeAddress();">getLat&Long</button>
    </body>
</html> --}}

<!DOCTYPE html>
<html>
  <head>
    <title>Removing Markers</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB21RnJFbEed0ypqsqUSsQHukp_0LxgQuI&callback=initMap&libraries=&v=weekly"
      defer
    ></script>
    <style type="text/css">
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }

      /* Optional: Makes the sample page fill the window. */
      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
      }

      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: "Roboto", "sans-serif";
        line-height: 30px;
        padding-left: 10px;
      }
    </style>
    <script>
      "use strict";

      // In the following example, markers appear when the user clicks on the map.
      // The markers are stored in an array.
      // The user can then click an option to hide, show or delete the markers.
      let map;
      let markers = [];

      function initMap() {
        const haightAshbury = {
          lat: 37.769,
          lng: -122.446
        };
        map = new google.maps.Map(document.getElementById("map"), {
          zoom: 12,
          center: haightAshbury,
          mapTypeId: "terrain"
        }); // This event listener will call addMarker() when the map is clicked.

        map.addListener("click", event => {
          addMarker(event.latLng);
        }); // Adds a marker at the center of the map.

        addMarker(haightAshbury);
      } // Adds a marker to the map and push to the array.

      function addMarker(location) {
        const marker = new google.maps.Marker({
          position: location,
          map: map
        });
        markers.push(marker);
      } // Sets the map on all markers in the array.

      function setMapOnAll(map) {
        for (let i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      } // Removes the markers from the map, but keeps them in the array.

      function clearMarkers() {
        setMapOnAll(null);
      } // Shows any markers currently in the array.

      function showMarkers() {
        setMapOnAll(map);
      } // Deletes all markers in the array by removing references to them.

      function deleteMarkers() {
        clearMarkers();
        markers = [];
      }
    </script>
  </head>
  <body>
    <div id="floating-panel">
      <input onclick="clearMarkers();" type="button" value="Hide Markers" />
      <input onclick="showMarkers();" type="button" value="Show All Markers" />
      <input onclick="deleteMarkers();" type="button" value="Delete Markers" />
    </div>
    <div id="map" style="height: 300px; width: 500px;"></div>
    <p>Click on the map to add markers.</p>
  </body>
</html>