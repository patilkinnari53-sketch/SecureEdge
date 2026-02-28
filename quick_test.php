<?php
// quick_test.php - Test Web Bluetooth support
?>
<!DOCTYPE html>
<html>
<head>
    <title>Web Bluetooth Test</title>
    <style>
        body { background: #0a0f1f; color: white; font-family: Arial; padding: 50px; }
        .success { color: #00ff9d; }
        .error { color: #ff4444; }
        .card { background: #151f2f; padding: 20px; border-radius: 10px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>📱 Web Bluetooth Test</h1>
    
    <div class="card">
        <h3>Browser Support:</h3>
        <p id="support">Checking...</p>
    </div>
    
    <div class="card">
        <h3>Available Devices:</h3>
        <button onclick="scanDevices()" style="padding:10px; background:#00ffff; border:none; border-radius:5px; cursor:pointer;">
            Scan for Devices
        </button>
        <div id="devices" style="margin-top:20px;"></div>
    </div>
    
    <script>
        // Check support
        if (navigator.bluetooth) {
            document.getElementById('support').innerHTML = '✅ Web Bluetooth SUPPORTED';
            document.getElementById('support').className = 'success';
        } else {
            document.getElementById('support').innerHTML = '❌ Web Bluetooth NOT supported. Use Chrome, Edge, or Opera.';
            document.getElementById('support').className = 'error';
        }
        
        async function scanDevices() {
            try {
                const device = await navigator.bluetooth.requestDevice({
                    acceptAllDevices: true,
                    optionalServices: ['heart_rate', 'battery_service']
                });
                
                document.getElementById('devices').innerHTML += `
                    <div style="border-left:3px solid #00ffff; padding:10px; margin:5px;">
                        <strong>✅ Found:</strong> ${device.name || 'Unknown Device'}<br>
                        <small>ID: ${device.id}</small>
                    </div>
                `;
                
            } catch(error) {
                alert('Error: ' + error.message);
            }
        }
    </script>
</body>
</html>