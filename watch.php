<?php
$pageTitle = "Smart Watch Integration";
include 'header.php';
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="fas fa-clock text-cyber me-2"></i>
                Smart Watch Integration
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="iot-card">
                <h4 class="mb-3">Connect Your Smart Watch</h4>
                
                <div class="text-center mb-4">
                    <i class="fas fa-clock fa-5x text-cyber mb-3"></i>
                    <h3 id="watchName">No Watch Connected</h3>
                </div>
                
                <div class="d-grid gap-2">
                    <button class="btn btn-iot" onclick="connectWatch()">
                        <i class="fas fa-bluetooth me-2"></i>
                        Connect via Bluetooth
                    </button>
                    
                    <button class="btn btn-iot" onclick="simulateWatchConnection()">
                        <i class="fas fa-sim-card me-2"></i>
                        Simulation Mode
                    </button>
                </div>
                
                <div class="mt-4">
                    <h5>Supported Watches:</h5>
                    <ul class="text-secondary">
                        <li>Apple Watch (Series 3+)</li>
                        <li>Samsung Galaxy Watch</li>
                        <li>Fitbit Sense/Versa</li>
                        <li>Garmin Venu/Forerunner</li>
                        <li>Any BLE-enabled Smart Watch</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="iot-card">
                <h4 class="mb-3">Real-time Watch Data</h4>
                
                <div id="watchData" class="data-stream" style="height: 300px;">
                    <p class="text-secondary">Waiting for watch connection...</p>
                </div>
                
                <div class="mt-3">
                    <h5>Last Sync: <span id="lastSync">Never</span></h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Watch Control Panel -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="iot-card text-center">
                <i class="fas fa-heartbeat fa-3x text-cyber mb-3"></i>
                <h3 id="heartRate">--</h3>
                <p>Heart Rate (BPM)</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="iot-card text-center">
                <i class="fas fa-shoe-prints fa-3x text-cyber mb-3"></i>
                <h3 id="steps">--</h3>
                <p>Steps Today</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="iot-card text-center">
                <i class="fas fa-battery-three-quarters fa-3x text-cyber mb-3"></i>
                <h3 id="battery">--</h3>
                <p>Battery Level</p>
            </div>
        </div>
    </div>
</div>

<script>
let watchInterval;

function connectWatch() {
    if ('bluetooth' in navigator) {
        navigator.bluetooth.requestDevice({
            acceptAllDevices: true,
            optionalServices: ['heart_rate', 'battery_service']
        })
        .then(device => {
            document.getElementById('watchName').textContent = device.name || 'Smart Watch';
            showToast(`✅ Connected to ${device.name || 'Smart Watch'}`);
            sessionStorage.setItem('watchConnected', 'true');
            startWatchSimulation();
        })
        .catch(error => {
            showToast('❌ Connection failed', 'error');
        });
    } else {
        showToast('❌ Bluetooth not supported', 'error');
    }
}

function simulateWatchConnection() {
    document.getElementById('watchName').textContent = 'Simulated Watch (Demo)';
    showToast('✅ Simulation mode activated');
    sessionStorage.setItem('watchConnected', 'true');
    startWatchSimulation();
}

function startWatchSimulation() {
    // Clear existing interval
    if (watchInterval) clearInterval(watchInterval);
    
    // Update every 2 seconds
    watchInterval = setInterval(() => {
        const heartRate = Math.floor(Math.random() * (95 - 65) + 65);
        const steps = Math.floor(Math.random() * 5000);
        const battery = Math.floor(Math.random() * (100 - 60) + 60);
        
        document.getElementById('heartRate').textContent = heartRate;
        document.getElementById('steps').textContent = steps;
        document.getElementById('battery').textContent = battery + '%';
        document.getElementById('lastSync').textContent = new Date().toLocaleTimeString();
        
        // Add to data stream
        const dataDiv = document.getElementById('watchData');
        const timestamp = new Date().toLocaleTimeString();
        dataDiv.innerHTML = `<div>🕐 ${timestamp} - HR: ${heartRate} BPM, Steps: ${steps}, Battery: ${battery}%</div>` + dataDiv.innerHTML;
        
        if (dataDiv.children.length > 10) {
            dataDiv.removeChild(dataDiv.lastChild);
        }
        
        // Send to server
        $.ajax({
            url: 'watch_api.php',
            method: 'POST',
            data: {
                heart_rate: heartRate,
                steps: steps,
                battery: battery
            }
        });
    }, 2000);
}

// Auto-start if previously connected
if (sessionStorage.getItem('watchConnected') === 'true') {
    simulateWatchConnection();
}
</script>

<?php include 'footer.php'; ?>