<script>
    $(document).ready(function () {
        const $addressElement = $('.delivery-text.address');
        const googleMapsApiKey = "{{ env('GOOGLE_MAPS_API_KEY') }}";
        const maxRetries = 3;

        const getAddress = (lat, lng, retries = 0) => {
            const url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=${googleMapsApiKey}`;
            $.getJSON(url, (data) => {
                if (data.results?.length) {
                    const location = data.results[0].formatted_address;
                    $addressElement.text(location);
                    localStorage.setItem('lastLocation', location);
                } else if (retries < maxRetries) retryFetch(lat, lng, retries);
                else showFallback("Unable to fetch location details.");
            }).fail(() => retries < maxRetries ? retryFetch(lat, lng, retries) : showFallback("Error fetching location."));
        };

        const retryFetch = (lat, lng, retries) => setTimeout(() => getAddress(lat, lng, retries + 1), 1000);

        const showFallback = (message) => $addressElement.text(localStorage.getItem('lastLocation') || message);

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (pos) => getAddress(pos.coords.latitude, pos.coords.longitude),
                () => showFallback("Location access denied."),
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 30000 }
            );
        } else {
            showFallback("Geolocation is not supported by your browser.");
        }
    });

</script>
