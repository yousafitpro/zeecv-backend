
<style>
        /* Time Styling */
    #current-time {
        font-size: 12px; /* Reasonable font size */
        font-weight: 600; /* Slightly bold to highlight it */
        color: #ecf0f1; /* Light color for contrast */
        padding: 5px 10px; /* Padding around the time */
        background-color: #34495e; /* Darker background to make it stand out */
        border-radius: 5px; /* Rounded corners */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for modern look */
        text-align: center; /* Center the text */
        transition: background-color 0.3s, color 0.3s; /* Smooth transition for hover effects */
    }

    /* Hover Effect */
    #current-time:hover {
        background-color: #1abc9c; /* Highlight with a softer teal on hover */
        color: #fff; /* White color on hover */
        cursor: pointer; /* Pointer cursor on hover */
}

/* Responsive Design */
@media (max-width: 768px) {
    #current-time {
        font-size: 14px; /* Slightly smaller on smaller screens */
        padding: 4px 8px; /* Adjust padding */
    }
}

</style>
@php
    $timezone = config('app.timezone');
    $serverTime = \Carbon\Carbon::now($timezone)->toIso8601String();
@endphp
    <script src="https://cdn.jsdelivr.net/npm/luxon@3/build/global/luxon.min.js"></script>
<div id="current-time"></div>
<script>
    const { DateTime } = luxon;

    // Initial time from Laravel
    let serverTime = DateTime.fromISO(@json($serverTime), { zone: @json($timezone) });

    function updateClock() {
        document.getElementById('current-time').textContent = serverTime.toFormat('hh:mm:ss a');
        serverTime = serverTime.plus({ seconds: 1 });
    }

    updateClock();
    setInterval(updateClock, 1000);
</script>
