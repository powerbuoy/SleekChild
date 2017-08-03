(function () {
	'use strict';

	var $ = require('jquery');

	if (typeof gmInit == 'undefined') {
		return;
	}

	var createMap = function (mapEl, lat, lng) {
		var map = new google.maps.Map(mapEl, {
			center: {
				lat: lat,
				lng: lng
			},
			zoom: 13,
			scrollwheel: false,
			mapTypeControl: false,
			streetViewControl: false,

			// https://snazzymaps.com/style/134/light-dream
			styles: [{"featureType":"landscape","stylers":[{"hue":"#FFBB00"},{"saturation":43.400000000000006},{"lightness":37.599999999999994},{"gamma":1}]},{"featureType":"road.highway","stylers":[{"hue":"#FFC200"},{"saturation":-61.8},{"lightness":45.599999999999994},{"gamma":1}]},{"featureType":"road.arterial","stylers":[{"hue":"#FF0300"},{"saturation":-100},{"lightness":51.19999999999999},{"gamma":1}]},{"featureType":"road.local","stylers":[{"hue":"#FF0300"},{"saturation":-100},{"lightness":52},{"gamma":1}]},{"featureType":"water","stylers":[{"hue":"#0078FF"},{"saturation":-13.200000000000003},{"lightness":2.4000000000000057},{"gamma":1}]},{"featureType":"poi","stylers":[{"hue":"#00FF6A"},{"saturation":-1.0989010989011234},{"lightness":11.200000000000017},{"gamma":1}]}]
		});

		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(lat, lng),
			map: map
		});

		return {
			map: map,
			marker: marker
		};
	};

	gmInit(function () {
		$('[data-google-map]').each(function () {
			var mapEl = $(this);
			var lat = mapEl.attr('data-lat');
			var lng = mapEl.attr('data-lng');
			var address = mapEl.attr('data-google-map');

			if (address) {
				address = JSON.parse(address);

				if (address) {
					address = address.address + ', ' + address.city + ', ' + address.postalcode;
				}
			}

			if (address) {
				$.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + address + '&key' + config.GOOGLE_MAPS_API_KEY, function (data) {
					if (data && data.results && data.results.length && data.results[0].geometry && data.results[0].geometry.location) {
						createMap(mapEl[0], data.results[0].geometry.location.lat, data.results[0].geometry.location.lng);
					}
					else {
					//	console.dir(data);
					}
				});
			}
			else {
				createMap(mapEl[0], lat, lng);
			}
		});
	});
})();