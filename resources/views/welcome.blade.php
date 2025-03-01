<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IoT Dashboard</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .dashboard {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 50px;
            color: #fff;
            font-weight: bold;
            margin-top: 20px;
        }
        .badge.safe {
            background-color: #10b981;
        }
        .badge.danger {
            background-color: #ef4444;
        }
        .metric {
            margin: 20px 0;
        }
        .metric h2 {
            font-size: 2rem;
            margin: 0;
        }
        .metric p {
            font-size: 1rem;
            color: #6b7280;
        }
        .person-name {
            font-size: 1.5rem;
            color: #374151;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="dashboard">
    <div class="person-name">Krax Jarvis</div>
    <div class="metric">
        <h2>Temperature</h2>
        <p id="temperature">25°C</p>
    </div>
    <div class="metric">
        <h2>Air Quality</h2>
        <p id="air-quality">12.56</p>
    </div>
    <div id="status-badge" class="badge safe">Safe</div>
    <!-- Change the class to 'badge danger' for danger status -->
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function updateDashboard() {
        $.ajax({
            url: '/api/actual-data', // Update with your API endpoint
            method: 'GET',
            success: function(data) {
                $('#temperature').text(data.temperature + '°C');
                $('#air-quality').text(data.air);

                if (data.temperature > 37 || data.air > 55.5) {
                    $('#status-badge').removeClass('safe').addClass('danger').text('Danger');
                } else {
                    $('#status-badge').removeClass('danger').addClass('safe').text('Safe');
                }
            },
            error: function() {
                console.error('Failed to fetch dashboard data');
            }
        });
    }

    // Update the dashboard every 5 seconds
    setInterval(updateDashboard, 5000);

    // Initial call to populate the dashboard
    updateDashboard();
</script>
</body>
</html>
