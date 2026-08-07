
  <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('43ad8f1b2204066386e2', {
      cluster: 'ap3'
    });

    var channel = pusher.subscribe('app.alerts');
    channel.bind('alert.created', function(data) {
     const event = new CustomEvent('globalAlert', { detail: data });
     window.dispatchEvent(event);
    });
  </script>


