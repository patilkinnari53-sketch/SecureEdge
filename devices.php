<?php
$pageTitle = "IoT Devices - Multi-Layer Architecture Device Management";
include 'header.php';
require_once 'database.php';
require_once 'iot_functions.php';

$db = new IoTDatabase();
$conn = $db->connect();
$iot = new IoTManager($db);

// Handle device addition
if(isset($_POST['add_device'])) {
    $name = $_POST['device_name'];
    $type = $_POST['device_type'];
    $room = $_POST['room'];
    $layer = $_POST['device_layer']; // New: Device layer selection
    $ip = "192.168.1." . rand(100, 200);
    $mac = implode(':', str_split(str_pad(dechex(rand(0, 16777215)), 6, '0', STR_PAD_LEFT), 2));
    
    $stmt = $conn->prepare("INSERT INTO devices (device_name, device_type, status, room, ip_address, mac_address) VALUES (?, ?, 0, ?, ?, ?)");
    $stmt->execute([$name, $type, $room, $ip, $mac]);
    
    $db->logSecurityEvent(
        'DEVICE_ADDED', 
        'INFO', 
        "New $layer layer device added: $name in $room",
        $_SERVER['REMOTE_ADDR']
    );
    
    $success_message = "✅ Device added successfully to $layer layer!";
}

// Handle device deletion
if(isset($_POST['delete_device'])) {
    $id = $_POST['device_id'];
    
    // Get device info before deletion for logging
    $stmt = $conn->prepare("SELECT device_name, room FROM devices WHERE id = ?");
    $stmt->execute([$id]);
    $device = $stmt->fetch();
    
    $stmt = $conn->prepare("DELETE FROM devices WHERE id = ?");
    $stmt->execute([$id]);
    
    $db->logSecurityEvent(
        'DEVICE_REMOVED', 
        'INFO', 
        "Device removed: " . $device['device_name'] . " from " . $device['room'],
        $_SERVER['REMOTE_ADDR']
    );
}

// Handle device status update (if direct toggle)
if(isset($_POST['toggle_status'])) {
    $id = $_POST['device_id'];
    $status = $_POST['status'];
    
    $stmt = $conn->prepare("UPDATE devices SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
    
    // Get device info
    $stmt = $conn->prepare("SELECT device_name FROM devices WHERE id = ?");
    $stmt->execute([$id]);
    $device_name = $stmt->fetchColumn();
    
    $db->logSecurityEvent(
        'DEVICE_TOGGLE',
        'INFO',
        "Device $device_name turned " . ($status ? 'ON' : 'OFF'),
        $_SERVER['REMOTE_ADDR']
    );
    
    echo json_encode(['success' => true]);
    exit;
}

// Get all devices
$devices = $conn->query("SELECT * FROM devices ORDER BY room, device_name")->fetchAll(PDO::FETCH_ASSOC);

// Get device counts by layer (based on device type for demo)
$device_layer_counts = [
    'device' => 0,
    'edge' => 0,
    'cloud' => 0
];

foreach($devices as $d) {
    if(in_array($d['device_type'], ['sensor', 'light', 'lock'])) {
        $device_layer_counts['device']++;
    } elseif(in_array($d['device_type'], ['camera', 'thermostat'])) {
        $device_layer_counts['edge']++;
    } else {
        $device_layer_counts['cloud']++;
    }
}
?>

<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fas fa-microchip text-cyber me-3"></i>
                Multi-Layer IoT Device Management
            </h1>
            <p class="lead text-secondary">
                Manage devices across Device Layer, Edge Layer, and Cloud Layer
            </p>
        </div>
    </div>

    <!-- Layer Distribution Overview -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="iot-card text-center">
                <i class="fas fa-microchip fa-3x text-cyber mb-3"></i>
                <h3>Device Layer</h3>
                <p class="display-6 text-cyber"><?php echo $device_layer_counts['device']; ?></p>
                <p class="text-secondary">Sensors, Lights, Locks</p>
                <div class="progress">
                    <div class="progress-bar bg-cyber" style="width: <?php echo $device_layer_counts['device'] > 0 ? ($device_layer_counts['device']/count($devices))*100 : 0; ?>%"></div>
                </div>
                <small class="text-cyber">AES-256 Encrypted</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="iot-card text-center border-cyber">
                <i class="fas fa-server fa-3x text-cyber mb-3"></i>
                <h3 class="text-cyber">Edge Layer</h3>
                <p class="display-6 text-cyber"><?php echo $device_layer_counts['edge']; ?></p>
                <p class="text-secondary">Cameras, Thermostats</p>
                <div class="progress">
                    <div class="progress-bar bg-cyber" style="width: <?php echo $device_layer_counts['edge'] > 0 ? ($device_layer_counts['edge']/count($devices))*100 : 0; ?>%"></div>
                </div>
                <small class="text-cyber">IDS + RBAC Protected</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="iot-card text-center">
                <i class="fas fa-cloud fa-3x text-cyber mb-3"></i>
                <h3>Cloud Layer</h3>
                <p class="display-6 text-cyber"><?php echo $device_layer_counts['cloud']; ?></p>
                <p class="text-secondary">Smart Plugs, Gateways</p>
                <div class="progress">
                    <div class="progress-bar bg-cyber" style="width: <?php echo $device_layer_counts['cloud'] > 0 ? ($device_layer_counts['cloud']/count($devices))*100 : 0; ?>%"></div>
                </div>
                <small class="text-cyber">TLS 1.3 Secured</small>
            </div>
        </div>
    </div>

    <!-- Add Device Form - Enhanced -->
    <div class="row mb-4">
        <div class="col-md-7">
            <div class="iot-card">
                <h4 class="mb-3">
                    <i class="fas fa-plus-circle text-cyber me-2"></i>
                    Add New Device to Architecture
                </h4>
                
                <?php if(isset($success_message)): ?>
                <div class="alert alert-success mb-3" style="background: rgba(0,255,0,0.1); border: 1px solid #00ff9d; color: #00ff9d;">
                    <?php echo $success_message; ?>
                </div>
                <?php endif; ?>
                
                <form method="POST" id="addDeviceForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-cyber">Device Name</label>
                            <input type="text" name="device_name" class="form-control bg-dark text-white border-cyber" required placeholder="e.g., Living Room Light">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-cyber">Room/Location</label>
                            <input type="text" name="room" class="form-control bg-dark text-white border-cyber" required placeholder="e.g., Living Room">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-cyber">Device Type</label>
                            <select name="device_type" class="form-control bg-dark text-white border-cyber" id="deviceTypeSelect">
                                <option value="sensor">Sensor (Device Layer)</option>
                                <option value="light">Smart Light (Device Layer)</option>
                                <option value="lock">Smart Lock (Device Layer)</option>
                                <option value="camera">Security Camera (Edge Layer)</option>
                                <option value="thermostat">Thermostat (Edge Layer)</option>
                                <option value="gateway">Edge Gateway (Edge Layer)</option>
                                <option value="plug">Smart Plug (Cloud Layer)</option>
                                <option value="hub">Smart Hub (Cloud Layer)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-cyber">Security Layer</label>
                            <input type="text" class="form-control bg-dark text-white border-cyber" id="securityLayer" readonly placeholder="Auto-detected">
                        </div>
                    </div>
                    
                    <!-- Security Features Preview -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div id="securityFeatures" class="p-3" style="background: rgba(0,255,255,0.05); border-radius: 10px;">
                                <small class="text-cyber">Security features will appear here</small>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" name="add_device" class="btn btn-iot">
                        <i class="fas fa-plus me-2"></i>Add to Architecture
                    </button>
                </form>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="iot-card">
                <h4 class="mb-3">
                    <i class="fas fa-chart-pie text-cyber me-2"></i>
                    Architecture Distribution
                </h4>
                <canvas id="layerChart" style="max-height: 200px;"></canvas>
                
                <!-- Layer Security Summary -->
                <div class="mt-4">
                    <h6 class="text-cyber">Active Security by Layer:</h6>
                    <div class="small">
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-microchip text-cyber me-2"></i>Device Layer</span>
                            <span class="text-cyber">AES-256</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-server text-cyber me-2"></i>Edge Layer</span>
                            <span class="text-cyber">IDS + RSA + RBAC</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-cloud text-cyber me-2"></i>Cloud Layer</span>
                            <span class="text-cyber">TLS 1.3</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Device List Grouped by Layer -->
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="section-title">Devices by Layer</h2>
        </div>
        
        <!-- Device Layer Devices -->
        <div class="col-md-4">
            <div class="iot-card">
                <h4 class="text-cyber mb-3">
                    <i class="fas fa-microchip me-2"></i>
                    Device Layer
                </h4>
                <p class="small text-secondary mb-3">AES-256 Encrypted • Secure Boot • HSM</p>
                
                <?php 
                $device_layer_devices = array_filter($devices, function($d) {
                    return in_array($d['device_type'], ['sensor', 'light', 'lock']);
                });
                
                if(empty($device_layer_devices)): ?>
                    <p class="text-secondary">No device layer devices</p>
                <?php else: ?>
                    <?php foreach($device_layer_devices as $device): ?>
                    <div class="device-item mb-2 p-2" style="border-left: 3px solid var(--primary);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?php echo htmlspecialchars($device['device_name']); ?></strong>
                                <br>
                                <small class="text-secondary">
                                    <i class="fas fa-map-marker-alt me-1"></i><?php echo $device['room']; ?>
                                </small>
                            </div>
                            <span class="status-dot <?php echo $device['status'] ? 'status-online' : 'status-offline'; ?>"></span>
                        </div>
                        <div class="mt-1 small">
                            <span class="badge bg-cyber text-dark">AES-256</span>
                            <span class="badge bg-secondary"><?php echo ucfirst($device['device_type']); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Edge Layer Devices (Core) -->
        <div class="col-md-4">
            <div class="iot-card border-cyber">
                <h4 class="text-cyber mb-3">
                    <i class="fas fa-server me-2"></i>
                    Edge Layer
                </h4>
                <p class="small text-secondary mb-3">IDS • RSA Key Exchange • RBAC • MFA • 5ms</p>
                
                <?php 
                $edge_layer_devices = array_filter($devices, function($d) {
                    return in_array($d['device_type'], ['camera', 'thermostat', 'gateway']);
                });
                
                if(empty($edge_layer_devices)): ?>
                    <p class="text-secondary">No edge layer devices</p>
                <?php else: ?>
                    <?php foreach($edge_layer_devices as $device): ?>
                    <div class="device-item mb-2 p-2" style="border-left: 3px solid var(--primary); background: rgba(0,255,255,0.05);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong class="text-cyber"><?php echo htmlspecialchars($device['device_name']); ?></strong>
                                <br>
                                <small class="text-secondary">
                                    <i class="fas fa-map-marker-alt me-1"></i><?php echo $device['room']; ?>
                                </small>
                            </div>
                            <span class="status-dot <?php echo $device['status'] ? 'status-online' : 'status-offline'; ?>"></span>
                        </div>
                        <div class="mt-1 small">
                            <span class="badge bg-cyber text-dark">IDS</span>
                            <span class="badge bg-cyber text-dark">RSA</span>
                            <span class="badge bg-secondary"><?php echo ucfirst($device['device_type']); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Cloud Layer Devices -->
        <div class="col-md-4">
            <div class="iot-card">
                <h4 class="text-cyber mb-3">
                    <i class="fas fa-cloud me-2"></i>
                    Cloud Layer
                </h4>
                <p class="small text-secondary mb-3">TLS 1.3 • Encrypted Storage • Audit Logs</p>
                
                <?php 
                $cloud_layer_devices = array_filter($devices, function($d) {
                    return in_array($d['device_type'], ['plug', 'hub']);
                });
                
                if(empty($cloud_layer_devices)): ?>
                    <p class="text-secondary">No cloud layer devices</p>
                <?php else: ?>
                    <?php foreach($cloud_layer_devices as $device): ?>
                    <div class="device-item mb-2 p-2" style="border-left: 3px solid var(--primary);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?php echo htmlspecialchars($device['device_name']); ?></strong>
                                <br>
                                <small class="text-secondary">
                                    <i class="fas fa-map-marker-alt me-1"></i><?php echo $device['room']; ?>
                                </small>
                            </div>
                            <span class="status-dot <?php echo $device['status'] ? 'status-online' : 'status-offline'; ?>"></span>
                        </div>
                        <div class="mt-1 small">
                            <span class="badge bg-cyber text-dark">TLS 1.3</span>
                            <span class="badge bg-secondary"><?php echo ucfirst($device['device_type']); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Detailed Device List -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="iot-card">
                <h4 class="mb-3">
                    <i class="fas fa-list text-cyber me-2"></i>
                    All Devices - Multi-Layer View
                </h4>
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>Device</th>
                                <th>Type</th>
                                <th>Room</th>
                                <th>Layer</th>
                                <th>Security</th>
                                <th>Status</th>
                                <th>IP Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($devices as $device): 
                                // Determine layer
                                if(in_array($device['device_type'], ['sensor', 'light', 'lock'])) {
                                    $layer = 'Device';
                                    $security = 'AES-256';
                                    $layer_color = 'primary';
                                } elseif(in_array($device['device_type'], ['camera', 'thermostat', 'gateway'])) {
                                    $layer = 'Edge';
                                    $security = 'IDS + RSA';
                                    $layer_color = 'cyber';
                                } else {
                                    $layer = 'Cloud';
                                    $security = 'TLS 1.3';
                                    $layer_color = 'info';
                                }
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($device['device_name']); ?></td>
                                <td><?php echo ucfirst($device['device_type']); ?></td>
                                <td><?php echo htmlspecialchars($device['room']); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $layer_color; ?> text-dark">
                                        <?php echo $layer; ?> Layer
                                    </span>
                                </td>
                                <td><small class="text-cyber"><?php echo $security; ?></small></td>
                                <td>
                                    <span class="status-dot <?php echo $device['status'] ? 'status-online' : 'status-offline'; ?>"></span>
                                    <?php echo $device['status'] ? 'Online' : 'Offline'; ?>
                                </td>
                                <td><?php echo $device['ip_address']; ?></td>
                                <td>
                                    <form method="POST" onsubmit="return confirm('Delete this device?');" style="display: inline;">
                                        <input type="hidden" name="device_id" value="<?php echo $device['id']; ?>">
                                        <button type="submit" name="delete_device" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Update security features based on device type
document.getElementById('deviceTypeSelect').addEventListener('change', function() {
    const type = this.value;
    const securityDiv = document.getElementById('securityFeatures');
    const layerInput = document.getElementById('securityLayer');
    
    let layer = '';
    let features = '';
    
    if(['sensor', 'light', 'lock'].includes(type)) {
        layer = 'Device Layer';
        features = `
            <small class="text-cyber">🔐 Device Layer Security:</small><br>
            <span class="badge bg-cyber text-dark me-1">AES-256 Encryption</span>
            <span class="badge bg-cyber text-dark me-1">Secure Boot</span>
            <span class="badge bg-cyber text-dark">Hardware Security</span>
        `;
    } else if(['camera', 'thermostat', 'gateway'].includes(type)) {
        layer = 'Edge Layer';
        features = `
            <small class="text-cyber">⚡ Edge Layer Security:</small><br>
            <span class="badge bg-cyber text-dark me-1">IDS Monitoring</span>
            <span class="badge bg-cyber text-dark me-1">RSA Key Exchange</span>
            <span class="badge bg-cyber text-dark me-1">RBAC</span>
            <span class="badge bg-cyber text-dark">MFA</span>
        `;
    } else {
        layer = 'Cloud Layer';
        features = `
            <small class="text-cyber">☁️ Cloud Layer Security:</small><br>
            <span class="badge bg-cyber text-dark me-1">TLS 1.3</span>
            <span class="badge bg-cyber text-dark me-1">Encrypted Storage</span>
            <span class="badge bg-cyber text-dark">Audit Logs</span>
        `;
    }
    
    layerInput.value = layer;
    securityDiv.innerHTML = features;
});

// Trigger on load
document.getElementById('deviceTypeSelect').dispatchEvent(new Event('change'));

// Chart for layer distribution
const layerCtx = document.getElementById('layerChart').getContext('2d');
new Chart(layerCtx, {
    type: 'doughnut',
    data: {
        labels: ['Device Layer', 'Edge Layer', 'Cloud Layer'],
        datasets: [{
            data: [
                <?php echo $device_layer_counts['device']; ?>,
                <?php echo $device_layer_counts['edge']; ?>,
                <?php echo $device_layer_counts['cloud']; ?>
            ],
            backgroundColor: ['#00ffff', '#4169e1', '#ffd700']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: { color: '#fff', font: { size: 10 } }
            }
        }
    }
});
</script>

<style>
/* Additional styles */
.device-item {
    transition: 0.3s;
    border-radius: 5px;
}

.device-item:hover {
    transform: translateX(5px);
    background: rgba(0,255,255,0.1) !important;
}

.badge.bg-cyber {
    background: var(--primary);
    color: var(--dark);
}

.badge.bg-info {
    background: #4169e1 !important;
    color: white;
}

.status-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 5px;
}

.status-online {
    background: var(--success);
    box-shadow: 0 0 10px var(--success);
}

.status-offline {
    background: var(--danger);
}

.progress {
    height: 5px;
    background: rgba(255,255,255,0.1);
}

.progress-bar {
    background: var(--primary);
}

.section-title {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 20px;
    position: relative;
    display: inline-block;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 60%;
    height: 3px;
    background: var(--primary);
}

.border-cyber {
    border-color: var(--primary) !important;
    border-width: 2px !important;
}
</style>

<?php include 'footer.php'; ?>