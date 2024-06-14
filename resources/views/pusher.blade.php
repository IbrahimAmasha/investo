<!DOCTYPE html>
<html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script>
    // Enable Pusher logging - don't include this in production
    Pusher.logToConsole = true;

    // Initialize Pusher with your key and cluster
    var pusher = new Pusher('fe50929e44c74c50e9f8', {
      cluster: 'eu'
    });

    // Subscribe to the channel
    var channel = pusher.subscribe('my-channel');

    // Bind to the event and alert the data when the event is triggered
    channel.bind('form-submitted', function(data) {
      alert(JSON.stringify(data));
    });
  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>form-submitted</code>.
  </p>
</body>
</html>
