<!DOCTYPE html>
<html>
<head>
	<title>Auto Complete Api</title>
</head>
<body>

	<form method="post" name="place" id="place">
		<table>
			<tr>
				<td>
					First Place
				</td>
				<td>
					<input type="text" name="firstplace" id="firstplace" required="true">
				</td>
			</tr>
			<tr>
				<td>
					second Place
				</td>
				<td>
					<input type="text" name="secondplace" id="secondplace" required="true">
				</td>
			</tr>
			<tr>
				<td>
					<input type="button" name="submit" id="submit" value="Get Location" onclick="get()">
				</td>
			</tr>
		</table>
	</form>
	<div id="dvDistance">
		
	</div>

	<div id="dvMap" style="width: 500px; height: 500px">
	</div>
	

</body>
</html>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=/*Google Api Key*/"></script>

<script type="text/javascript">
	
	var countryRestrict = {'country': 'in'};

	var source, destination;
	var directionsDisplay;
	var directionsService = new google.maps.DirectionsService();
	google.maps.event.addDomListener(window, 'load', function () {

		var input = document.getElementById('firstplace');
		var autocomplete = new google.maps.places.Autocomplete(input,{
			componentRestrictions: countryRestrict
		});
		google.maps.event.addListener(autocomplete, 'place_changed', function () {
			var place = autocomplete.getPlace();
			document.getElementById('fromLat').value = place.geometry.location.lat();
			document.getElementById('fromLng').value = place.geometry.location.lng();
		});

		var input1 = document.getElementById('secondplace');
		var autocomplete1 = new google.maps.places.Autocomplete(input1,{
			componentRestrictions: countryRestrict});
		google.maps.event.addListener(autocomplete1, 'place_changed', function () {
			var place = autocomplete1.getPlace();
			document.getElementById('toLat').value = place.geometry.location.lat();
			document.getElementById('toLng').value = place.geometry.location.lng();
		});

		directionsDisplay = new google.maps.DirectionsRenderer({ 'draggable': false });
	});

</script>

<script type="text/javascript">

	function get(){
		// var from = document.getElementById('firstplace').value;
		// var to = document.getElementById('secondplace').value;

			var source = document.getElementById("firstplace").value;
            var destination = document.getElementById("secondplace").value;
			
			 document.getElementById("firstplace").innerHTML = source;
			 document.getElementById("secondplace").innerHTML = destination;
			 var mumbai = new google.maps.LatLng(18.9750, 72.8258);
             var mapOptions = {
                 zoom: 7,
                 center: mumbai
             };

             map = new google.maps.Map(document.getElementById('dvMap'), mapOptions);
             directionsDisplay.setMap(map);


             directionsDisplay.setPanel(document.getElementById('dvPanel'));

             var request = {
                 origin: source,
                 destination: destination,
                 travelMode: google.maps.TravelMode.DRIVING
             };

             directionsService.route(request, function (response, status) {
                 if (status == google.maps.DirectionsStatus.OK) {
                     directionsDisplay.setDirections(response);

                 }
             });

             var service = new google.maps.DistanceMatrixService();
            service.getDistanceMatrix({
                origins: [source],
                destinations: [destination],
                travelMode: google.maps.TravelMode.DRIVING,
                unitSystem: google.maps.UnitSystem.METRIC,
                avoidHighways: false,
                avoidTolls: false
            }, function (response, status) {
                if (status == google.maps.DistanceMatrixStatus.OK && response.rows[0].elements[0].status != "ZERO_RESULTS") {
                    var distance = response.rows[0].elements[0].distance.text;
                    var duration = response.rows[0].elements[0].duration.text;
                    var dvDistance = document.getElementById("dvDistance");
                    dvDistance.innerHTML = "";
                    dvDistance.innerHTML += "<span id='km' style='text-transform: uppercase;'>" + distance + "</span><br /><span id='km' style='text-transform: uppercase;'>" + duration + "</span><br />";
					// document.getElementById("dvDistance1").innerHTML = distance;
                    //dvDistance.innerHTML += "Duration:" + duration;
                }
            });

	}

</script>