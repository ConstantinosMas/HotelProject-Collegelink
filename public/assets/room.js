$(document).ready(function () {
    const ratingStars = [...document.getElementsByClassName("rating-star")];

    function executeRating(stars) {
    const starClassActive = "bi rating-star bi-star-fill";
    const starClassInactive = "bi rating-star bi-star";
    const starsLength = stars.length;
    let i;
    stars.map((star) => {
        star.onclick = () => {
        i = stars.indexOf(star);
        let star_count = parseInt(i);
        $('.stars-count').val(star_count + 1); 

        if (star.className===starClassInactive) {
            for (i; i >= 0; --i) stars[i].className = starClassActive;
        } else {
            for (i; i < starsLength; ++i) stars[i].className = starClassInactive;
        }
        };
    });
    }
    executeRating(ratingStars);

    $('#review-text').on('input', function() {
        if ($('#review-text').val().length == 800) {
            $('#review-text').css('border', '2px solid red');
            $('.char-limit').removeClass('hidden');
        }  else if ($('#review-text').val().length < 800) {
            $('#review-text').css('border', '1px solid #e0e0e0');
            $('.char-limit').addClass('hidden');
        };
    });

    // Map code //
    let room_lat = $('#map').attr('data-lat');
    let room_long = $('#map').attr('data-long');

    mapboxgl.accessToken = 'pk.eyJ1IjoibWFzLWNvc3RhcyIsImEiOiJjbGV5MGVwaHMwMGJtM3JwMzdyd3ZzdDg2In0.NMkLB9JcKzJKP5C7DQXdfg';
    const map = new mapboxgl.Map({
        container: 'map', // container ID
        style: 'mapbox://styles/mapbox/streets-v12', // style URL
        center: [room_long, room_lat], // starting position [lng, lat]
        zoom: 15 // starting zoom
    });
    map.addControl(new mapboxgl.NavigationControl());

    const geojson = {
        type: 'FeatureCollection',
        features: [
          {
            type: 'Feature',
            geometry: {
              type: 'Point',
              coordinates: [room_long, room_lat]
            },
            properties: {
              title: 'Mapbox',
              description: $('#map').attr('data-hotel')
            }
          },
        ]
      };

    for (const feature of geojson.features) {
        // create a HTML element for each feature
        const el = document.createElement('div');
        el.className = 'marker';
      
        // make a marker for each feature and add to the map!!!! Did not get this to work. Needs to be addressed.
        new mapboxgl.Marker(el).setLngLat(feature.geometry.coordinates).addTo(map);
    }

})