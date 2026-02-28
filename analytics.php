<?php
$pageTitle = "Analytics - IoT Data Insights";
include 'header.php';
require_once 'database.php';

$db = new IoTDatabase();
$conn = $db->connect();

// Get historical data for charts
$sensor_data = $conn->query("
    SELECT DATE(timestamp) as date, COUNT(*) as events 
    FROM security_events 
    GROUP BY DATE(timestamp) 
    ORDER BY date DESC 
    LIMIT 7
")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1 class="mb-4" data-aos="fade-up">
        <i class="fas fa-chart-line text-cyber me-2"></i>
        IoT Analytics Dashboard
    </h1>
    
    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="iot-card">
                <h4 class="mb-3">Security Events Trend</h4>
                <canvas id="trendChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="iot-card">
                <h4 class="mb-3">Device Activity</h4>
                <canvas id="activityChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Performance Metrics -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="iot-card">
                <h4>Edge Computing</h4>
                <canvas id="edgeChart"></canvas>
            </div>
        </div>
        <div class="col-md-8">
            <div class="iot-card">
                <h4>Live Data Stream</h4>
                <div class="data-stream" style="height: 200px; overflow-y: auto;" id="liveStream">
                    <!-- Live data will appear here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize charts with real data
const ctx1 = document.getElementById('trendChart').getContext('2d');
new Chart(ctx1, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(array_column($sensor_data, 'date')); ?>,
        datasets: [{
            label: 'Security Events',
            data: <?php echo json_encode(array_column($sensor_data, 'events')); ?>,
            borderColor: '#00ffff',
            backgroundColor: 'rgba(0, 255, 255, 0.1)'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { labels: { color: '#fff' } }
        },
        scales: {
            y: { grid: { color: 'rgba(255,255,255,0.1)' }, ticks: { color: '#fff' } },
            x: { grid: { color: 'rgba(255,255,255,0.1)' }, ticks: { color: '#fff' } }
        }
    }
});

// Simulate live data stream
setInterval(function() {
    const types = ['Temperature', 'Motion', 'Security', 'Status'];
    const rooms = ['Living Room', 'Bedroom', 'Kitchen', 'Hallway'];
    
    const data = `${new Date().toLocaleTimeString()} - ${rooms[Math.floor(Math.random()*4)]}: ${types[Math.floor(Math.random()*4)]} data received`;
    
    $('#liveStream').prepend('<div>' + data + '</div>');
    if($('#liveStream div').length > 10) {
        $('#liveStream div:last').remove();
    }
}, 2000);
</script>

<?php include 'footer.php'; ?>