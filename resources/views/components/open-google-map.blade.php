@props(["latitude","longitude"])
<button class="button button--primary rounded"
x-on:click="
    let latitude = {{ $latitude }};
    let longitude = {{ $longitude }};
    let url = `https://www.google.com/maps/search/?api=1&query=${latitude},${longitude}`;
    window.open(url, '_blank');
">
<i class="fa-solid fa-location-dot"></i>
</button>
