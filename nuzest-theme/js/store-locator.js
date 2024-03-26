var AcfStoreLocator = (function($, document, google, AcfStoreLocatorInitObject) {

	var maxDistance = 1000 * 1000; // max meters distance to include stores in zoom
	var maxLocalStores = 3; //max number of local stores to include in zoom

	// values from php
	var stores = AcfStoreLocatorInitObject.stores;
	var loadingMessage = AcfStoreLocatorInitObject.loadingMessage;
	var markerIcons = AcfStoreLocatorInitObject.markerIcons;

	// all dom objects we will access
	var mapCanvas = $('#acf-map-canvas');
	var storeList = $('.store-list');
	var errorDisplay = $('#acf-error');
	var searchButton = $('#acf-search-store');
	var searchInput = $('#acf-address');

	// general vars
	var geocoder;
	var map;
	var mapOptions = getMapOptions();
	// console.log(mapOptions);
	var markers = [];
	var positionMarker;
	var defaultPosition;
	var storeInfoWindow;
	var storeCount = 0;
	var page = 1;
	var perPage = 8;

	// init component when maps is ready
	google.maps.event.addDomListener(window, 'load', function() {
		AcfStoreLocator.initialize();
	});

	//// public functions

	return {
		initialize: initialize,
		onSearchInputKeypress: onSearchInputKeypress,
		onSearchButtonClick: onSearchButtonClick,
		nextPage: nextPage
	};

	//// private functions

	function initialize() {
		// Todo : this needs to be flexible and set via cms somehow?
		defaultPosition = new google.maps.LatLng(geoData.lat,geoData.lng);

		storeCount = stores.length;

		geocoder = new google.maps.Geocoder();
		map = new google.maps.Map(mapCanvas[0], mapOptions);
		storeInfoWindow = new google.maps.InfoWindow({
			content: loadingMessage
		});
		positionMarker = new google.maps.Marker({
				icon: markerIcons.alt
		});

		initMarkers();
		//setPosition(defaultPosition);
		geolocateUser();

		storeList.find('li:first .map:first').trigger('click');

        infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            /*infoWindow.setContent('Location found.');
            infoWindow.open(map);*/
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }
	

	// initialise markers based on stores models and add to map
	function initMarkers() {
		_.each(stores, function(store, index) {
			var storeLoc = new google.maps.LatLng(store.lat, store.lng);
			var marker = new google.maps.Marker({
					idx: index,
					position: storeLoc,
					map: map,
					title: store.title,
					icon: markerIcons.store
			});
			markers.push(marker);

			//save ref data to store model
			store.idx = index;
			store.loc = storeLoc;

			google.maps.event.addListener(marker, 'click', onMarkerClick);
		});
	}

	// update shown list of stockist
	function updateList() {
		storeList.empty();
		page = 1;
		_.each(stores, function(store, index) {
			var html = $(document.createElement('li'));
			html.data('idx', store.idx);
			html.append(store.infoWindow);
			// console.log(store.infoWindow);

			// add Store Meta
			var storeMeta = $(document.createElement('span'));
			storeMeta.addClass('storeMeta');
			html.children('div').prepend(storeMeta);

			// add distance
			if (store.dist) {
				var dist = $(document.createElement('span'));
				dist.addClass('distance');
				dist.append((store.dist/1000).toFixed(1) + 'km');
				storeMeta.prepend(dist);
			}

			// add map link
			var map = $(document.createElement('span'));
			map.html('<i class="fa fa-map-marker"></i> Map');
			map.addClass('map');
			storeMeta.append(map);
			//setTimeout(function(){
				storeList.append(html);
			//}, 3000);
			
		});

		storeList.find('li h3').on('click', onListItemExpand);
		storeList.find('li .map').on('click', onListItemMap);

		updatePagination();
	}

	function updatePagination() {
		var storeListItems = storeList.find('li');
		storeListItems.hide();
		var paginate = perPage * page;
		_.all(storeListItems, function(item, idx) {
			if (idx < paginate) {
				$(item).show();
				return true;
			} else {
				return false;
			}
		});
		if (paginate >= storeCount) {
			$('.btn-next-page').hide();
		}

		if (storeList.find('li:first .default-location').length)
			storeList.find('li:first').hide();

	}

	function nextPage() {
		page++;
		updatePagination();
	}

	// try to geolocate the user and set map to their location
	function geolocateUser() {
		if(navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				setPosition(pos);

			}, function() {
				setPosition(defaultPosition);
			});
		} else {
			setPosition(defaultPosition);
		}
	}

	//set the position marker and update stores and map around it
	function setPosition(pos) {
		positionMarker.setPosition(pos);
		positionMarker.setMap(map);
		sortStoresByDistance(pos);
	}

	// submit search form on enter
	function onSearchInputKeypress(e) {
		if (typeof e == 'undefined' && window.event) { e = window.event; }
		if (e.keyCode == 13) {
			searchButton.click();
		}
	}

	//perform a search request
	function onSearchButtonClick() {
		var address = searchInput.val();
		if (address) {
			searchForAddress(address);
		}
	}

	// search for an address with maps api and add marker if found
	function searchForAddress(address) {
		if (!address) return;
		if(!isNaN(address)){
			address = "postcode" + address;
		}
		geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				storeInfoWindow.close();
				//get nearest result
				_.each(results, function(result) {
					result.dist = google.maps.geometry.spherical.computeDistanceBetween(map.center, result.geometry.location);
				});
				results = _.sortBy(results, function(result) {
					return result.dist;
				});
				setPosition(results[0].geometry.location);
				errorDisplay.hide();
			} else {
				errorDisplay.show();
			}
		});
	}

	// sort stores by distance from given location point
	function sortStoresByDistance(centerLoc) {
		var storeBackup = [];
		_.each(stores, function(store) {
			store.dist = google.maps.geometry.spherical.computeDistanceBetween(centerLoc, store.loc);
		});
		storeBackup.push(stores[0]);
		stores.shift();
		stores = _.sortBy(stores, function(store) {
			return store.dist;
		});
		stores.unshift(storeBackup.pop());
		updateList();
		//zoomToShowLocalStores();
	}

	// zoom the map to include found position and any local stores
	function zoomToShowLocalStores() {
		var bounds = new google.maps.LatLngBounds();
		var count = 0;
		_.each(stores, function(store) {
			if (count < maxLocalStores && store.dist < maxDistance) {
				bounds.extend(store.loc);
				count++;
			}
		});
		if (count) {
			//if local stores found, extend map to show
			bounds.extend(positionMarker.getPosition());
			map.fitBounds(bounds);
		} else {
			//no local stores
			map.setCenter(positionMarker.getPosition());
			map.setZoom(mapOptions.zoom);
		}
	}

	// handle map marker clicks
	function onMarkerClick() {
		showStoreInfoWindow(this.idx);
	}

	//handle list item clicks
	function onListItemExpand() {
		var listItem = $(this).parents('li'),
				idx = listItem.data('idx');

		listItem.toggleClass('active');
		listItem.siblings('li').removeClass('active');
	}

	//handle list item map clicks
	function onListItemMap() {
		var listItem = $(this).parents('li'),
				idx = listItem.data('idx');

		showStoreInfoWindow(idx);

		// scroll up to the map
		/*var el = $('#acf-map-canvas');
		var scrollPos = $(el).offset().top - $('#mobileNav:visible').outerHeight() - $('#topNav:visible').outerHeight() - 20;

		$('html,body').animate({
			scrollTop: scrollPos
		}, 300);*/
	}

	// show the map info window
	function showStoreInfoWindow(idx) {
		store = _.findWhere(stores, {idx: idx});
		marker = _.findWhere(markers, {idx: idx});
		storeInfoWindow.setContent(store.infoWindow);
		storeInfoWindow.open(map, marker);
		map.setCenter( marker.position );
	}

	// get map styling options
	function getMapOptions() {
		return {
			zoom: 13,
			mapTypeControlOptions: {
				mapTypeIds: []
			},
			disableDefaultUI: true, // a way to quickly hide all controls
			mapTypeControl: true,
			zoomControl: true,
			streetViewControl: true,
			zoomControlOptions: {
				style: google.maps.ZoomControlStyle.SMALL,
				position: google.maps.ControlPosition.RIGHT_BOTTOM
			},
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			styles: [
				{
					"featureType": "water",
					"elementType": "geometry.fill",
					"stylers": [
						{
							"color": "#d3d3d3"
						}
					]
				},
				{
					"featureType": "transit",
					"stylers": [
						{
							"color": "#808080"
						},
						{
							"visibility": "off"
						}
					]
				},
				{
					"featureType": "road.highway",
					"elementType": "geometry.stroke",
					"stylers": [
						{
							"visibility": "on"
						},
						{
							"color": "#b3b3b3"
						}
					]
				},
				{
					"featureType": "road.highway",
					"elementType": "geometry.fill",
					"stylers": [
							{
							"color": "#ffffff"
						}
					]
				},
				{
					"featureType": "road.local",
					"elementType": "geometry.fill",
					"stylers": [
						{
							"visibility": "on"
						},
						{
							"color": "#ffffff"
						},
						{
							"weight": 2
						}
					]
				},
				{
					"featureType": "road.local",
					"elementType": "geometry.stroke",
					"stylers": [
						{
							"color": "#d7d7d7"
						}
					]
				},
				{
					"featureType": "poi",
					"elementType": "geometry.fill",
					"stylers": [
						{
							"visibility": "on"
						},
						{
							"color": "#ebebeb"
						}
					]
				},
				{
					"featureType": "administrative",
					"elementType": "geometry",
					"stylers": [
						{
							"color": "#a7a7a7"
						}
					]
				},
				{
					"featureType": "road.arterial",
					"elementType": "geometry.fill",
					"stylers": [
						{
							"color": "#ffffff"
						}
					]
				},
				{
					"featureType": "road.arterial",
					"elementType": "geometry.fill",
					"stylers": [
						{
							"color": "#ffffff"
						}
					]
				},
				{
					"featureType": "landscape",
					"elementType": "geometry.fill",
					"stylers": [
						{
							"visibility": "on"
						},
						{
							"color": "#efefef"
						}
					]
				},
				{
					"featureType": "road",
					"elementType": "labels.text.fill",
					"stylers": [
						{
							"color": "#696969"
						}
					]
				},
				{
					"featureType": "administrative",
					"elementType": "labels.text.fill",
					"stylers": [
						{
							"visibility": "on"
						},
						{
							"color": "#737373"
						}
					]
				},
				{
					"featureType": "poi",
					"elementType": "labels.icon",
					"stylers": [
						{
							"visibility": "off"
						}
					]
				},
				{
					"featureType": "poi",
					"elementType": "labels",
					"stylers": [
						{
							"visibility": "off"
						}
					]
				},
				{
					"featureType": "road.arterial",
					"elementType": "geometry.stroke",
					"stylers": [
						{
							"color": "#d6d6d6"
						}
					]
				},
				{
					"featureType": "road",
					"elementType": "labels.icon",
					"stylers": [
						{
							"visibility": "off"
						}
					]
				},
				{},
				{
					"featureType": "poi",
					"elementType": "geometry.fill",
					"stylers": [
						{
								"color": "#dadada"
						}
					]
				}
			]
		};
	}

})(jQuery, document, google, AcfStoreLocatorInitObject);
