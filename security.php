<?php
$pageTitle = "Multi-Layer Security Architecture - IoT Smart Home Protection";
include 'header.php';
require_once 'database.php';
require_once 'iot_functions.php';

$db = new IoTDatabase();
$conn = $db->connect();
$iot = new IoTManager($db);

// Get all security events
$events = $conn->query("SELECT * FROM security_events ORDER BY timestamp DESC")->fetchAll(PDO::FETCH_ASSOC);

// Get security stats by layer
$device_layer_events = $conn->query("SELECT COUNT(*) FROM security_events WHERE description LIKE '%device%' OR description LIKE '%sensor%'")->fetchColumn();
$edge_layer_events = $conn->query("SELECT COUNT(*) FROM security_events WHERE description LIKE '%edge%' OR description LIKE '%gateway%' OR description LIKE '%ids%'")->fetchColumn();
$cloud_layer_events = $conn->query("SELECT COUNT(*) FROM security_events WHERE description LIKE '%cloud%' OR description LIKE '%storage%'")->fetchColumn();

// Simulate IDS scan at Edge layer
if(isset($_POST['run_scan'])) {
    $threats = rand(0, 5);
    $db->logSecurityEvent(
        'EDGE_IDS_SCAN',
        $threats > 0 ? 'MEDIUM' : 'INFO',
        "Edge layer IDS scan completed. Found $threats potential threats. Processing at edge gateway.",
        $_SERVER['REMOTE_ADDR']
    );
    
    // Add success message
    $scan_message = "✅ Edge IDS scan complete! Found $threats threats.";
}

// Get stats
$high_count = $conn->query("SELECT COUNT(*) FROM security_events WHERE severity='HIGH'")->fetchColumn();
$total_events = count($events);
?>

<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fas fa-shield-alt text-cyber me-3"></i>
                Multi-Layer Security Architecture
            </h1>
            <p class="lead text-secondary">
                Three-layer defense mechanism for IoT smart homes with edge computing security
            </p>
        </div>
    </div>

    <!-- Security Stats by Layer -->
    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <div class="iot-card text-center">
                <i class="fas fa-shield-virus fa-3x text-cyber mb-3"></i>
                <h3 class="text-cyber"><?php echo $total_events; ?></h3>
                <p class="text-secondary mb-1">Total Security Events</p>
                <small>Multi-layer monitoring</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="iot-card text-center">
                <i class="fas fa-exclamation-triangle fa-3x text-cyber mb-3"></i>
                <h3 class="text-cyber"><?php echo $high_count; ?></h3>
                <p class="text-secondary mb-1">High Severity Threats</p>
                <small>Blocked at edge</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="iot-card text-center">
                <i class="fas fa-microchip fa-3x text-cyber mb-3"></i>
                <h3 class="text-cyber">98.7%</h3>
                <p class="text-secondary mb-1">Edge Detection Rate</p>
                <small>IDS at edge layer</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="iot-card text-center">
                <i class="fas fa-clock fa-3x text-cyber mb-3"></i>
                <h3 class="text-cyber">5ms</h3>
                <p class="text-secondary mb-1">Edge Processing</p>
                <small>Real-time threat analysis</small>
            </div>
        </div>
    </div>

    <!-- Three-Layer Security Visualization -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="section-title">Security by Layer</h2>
        </div>
        
        <!-- Device Layer Security -->
        <div class="col-md-4 mb-3">
            <div class="iot-card h-100">
                <div class="d-flex align-items-center mb-3">
                    <div class="layer-icon me-3">
                        <i class="fas fa-microchip fa-2x text-cyber"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">Device Layer</h3>
                        <small class="text-secondary">IoT Sensors & Actuators</small>
                    </div>
                </div>
                <div class="security-badge mb-2">
                    <span class="badge bg-cyber text-dark me-2">AES-256</span>
                    <span class="badge bg-cyber text-dark me-2">Secure Boot</span>
                    <span class="badge bg-cyber text-dark">HSM</span>
                </div>
                <ul class="list-unstyled small mt-3">
                    <li class="mb-2"><i class="fas fa-check-circle text-cyber me-2"></i>Hardware-level encryption</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-cyber me-2"></i>Secure firmware validation</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-cyber me-2"></i>Device authentication</li>
                </ul>
                <div class="mt-2">
                    <small class="text-cyber">Events: <?php echo $device_layer_events; ?></small>
                </div>
            </div>
        </div>
        
        <!-- Edge Layer Security (Core) -->
        <div class="col-md-4 mb-3">
            <div class="iot-card h-100 border-cyber" style="border-width: 2px;">
                <div class="d-flex align-items-center mb-3">
                    <div class="layer-icon me-3" style="background: rgba(0,255,255,0.2);">
                        <i class="fas fa-server fa-2x text-cyber"></i>
                    </div>
                    <div>
                        <h3 class="text-cyber mb-0">Edge Layer</h3>
                        <small class="text-secondary">Gateway & IDS</small>
                    </div>
                </div>
                <div class="security-badge mb-2">
                    <span class="badge bg-cyber text-dark me-2">IDS/IPS</span>
                    <span class="badge bg-cyber text-dark me-2">RSA</span>
                    <span class="badge bg-cyber text-dark me-2">RBAC</span>
                    <span class="badge bg-cyber text-dark">MFA</span>
                </div>
                <ul class="list-unstyled small mt-3">
                    <li class="mb-2"><i class="fas fa-check-circle text-cyber me-2"></i>Real-time intrusion detection</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-cyber me-2"></i>RSA key exchange</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-cyber me-2"></i>Role-based access control</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-cyber me-2"></i>Multi-factor authentication</li>
                </ul>
                <div class="mt-2">
                    <small class="text-cyber">Events: <?php echo $edge_layer_events; ?></small>
                </div>
            </div>
        </div>
        
        <!-- Cloud Layer Security -->
        <div class="col-md-4 mb-3">
            <div class="iot-card h-100">
                <div class="d-flex align-items-center mb-3">
                    <div class="layer-icon me-3">
                        <i class="fas fa-cloud fa-2x text-cyber"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">Cloud Layer</h3>
                        <small class="text-secondary">Analytics & Storage</small>
                    </div>
                </div>
                <div class="security-badge mb-2">
                    <span class="badge bg-cyber text-dark me-2">TLS 1.3</span>
                    <span class="badge bg-cyber text-dark me-2">Encrypted Storage</span>
                    <span class="badge bg-cyber text-dark">Audit Logs</span>
                </div>
                <ul class="list-unstyled small mt-3">
                    <li class="mb-2"><i class="fas fa-check-circle text-cyber me-2"></i>TLS 1.3 encrypted transmission</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-cyber me-2"></i>Encrypted data at rest</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-cyber me-2"></i>Secure firmware updates</li>
                </ul>
                <div class="mt-2">
                    <small class="text-cyber">Events: <?php echo $cloud_layer_events; ?></small>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Controls & Active Measures -->
    <div class="row mb-4">
        <div class="col-md-7">
            <div class="iot-card">
                <h4 class="mb-3">
                    <i class="fas fa-shield-alt text-cyber me-2"></i>
                    Active Security Measures by Layer
                </h4>
                
                <!-- Device Layer Progress -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span><i class="fas fa-microchip text-cyber me-2"></i>Device Layer Security</span>
                        <span class="text-cyber">100%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-cyber" style="width: 100%"></div>
                    </div>
                    <small class="text-secondary">AES-256, Secure Boot, HSM</small>
                </div>
                
                <!-- Edge Layer Progress -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span><i class="fas fa-server text-cyber me-2"></i>Edge Layer Security</span>
                        <span class="text-cyber">100%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-cyber" style="width: 100%"></div>
                    </div>
                    <small class="text-secondary">IDS, RSA, RBAC, MFA</small>
                </div>
                
                <!-- Cloud Layer Progress -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span><i class="fas fa-cloud text-cyber me-2"></i>Cloud Layer Security</span>
                        <span class="text-cyber">100%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-cyber" style="width: 100%"></div>
                    </div>
                    <small class="text-secondary">TLS 1.3, Encrypted Storage, Audit Logs</small>
                </div>
                
                <!-- Live Edge Status -->
                <div class="mt-4 p-3" style="background: rgba(0,255,255,0.05); border-radius: 10px;">
                    <div class="d-flex align-items-center">
                        <span class="status-dot status-online me-2"></span>
                        <span class="text-cyber fw-bold">Edge IDS: Active</span>
                        <span class="ms-auto text-secondary">Monitoring 8 devices</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="iot-card">
                <h4 class="mb-3">
                    <i class="fas fa-cog text-cyber me-2"></i>
                    Security Controls
                </h4>
                
                <!-- Scan Results Message -->
                <?php if(isset($scan_message)): ?>
                <div class="alert alert-cyber mb-3" style="background: rgba(0,255,255,0.1); border: 1px solid var(--primary);">
                    <?php echo $scan_message; ?>
                </div>
                <?php endif; ?>
                
                <form method="POST" class="mb-3">
                    <button type="submit" name="run_scan" class="btn btn-iot w-100 mb-2">
                        <i class="fas fa-search me-2"></i>
                        Run Edge IDS Scan
                    </button>
                </form>
                
                <button class="btn btn-iot w-100 mb-2" onclick="simulateAttack()">
                    <i class="fas fa-bug me-2"></i>
                    Simulate Attack (Test IDS)
                </button>
                
                <button class="btn btn-iot w-100 mb-2" onclick="rotateKeys()">
                    <i class="fas fa-key me-2"></i>
                    Rotate Encryption Keys
                </button>
                
                <button class="btn btn-iot w-100" onclick="testEdge()">
                    <i class="fas fa-microchip me-2"></i>
                    Test Edge Processing
                </button>
                
                <!-- Edge Performance -->
                <div class="mt-4">
                    <h6 class="text-cyber">Edge Processing Performance</h6>
                    <div class="d-flex justify-content-between small">
                        <span>IDS Latency:</span>
                        <span class="text-cyber">5ms</span>
                    </div>
                    <div class="d-flex justify-content-between small">
                        <span>Threats Blocked:</span>
                        <span class="text-cyber">156</span>
                    </div>
                    <div class="d-flex justify-content-between small">
                        <span>Last Attack:</span>
                        <span class="text-cyber">2 min ago</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Events Log with Layer Filter -->
    <div class="row">
        <div class="col-12">
            <div class="iot-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">
                        <i class="fas fa-list text-cyber me-2"></i>
                        Multi-Layer Security Event Log
                    </h4>
                    <div>
                        <span class="badge bg-cyber text-dark me-2">Device Layer</span>
                        <span class="badge bg-cyber text-dark me-2">Edge Layer</span>
                        <span class="badge bg-cyber text-dark">Cloud Layer</span>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Layer</th>
                                <th>Event Type</th>
                                <th>Severity</th>
                                <th>Description</th>
                                <th>Source IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($events)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-cyber">No security events - System secure</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach($events as $event): 
                                    // Determine layer based on description
                                    $layer = 'Edge';
                                    if(strpos($event['description'], 'device') !== false || strpos($event['description'], 'sensor') !== false) {
                                        $layer = 'Device';
                                    } elseif(strpos($event['description'], 'cloud') !== false || strpos($event['description'], 'storage') !== false) {
                                        $layer = 'Cloud';
                                    }
                                ?>
                                <tr>
                                    <td><?php echo $event['timestamp']; ?></td>
                                    <td>
                                        <span class="badge bg-cyber text-dark">
                                            <?php echo $layer; ?> Layer
                                        </span>
                                    </td>
                                    <td><?php echo $event['event_type']; ?></td>
                                    <td>
                                        <span class="badge bg-<?php 
                                            echo $event['severity'] == 'HIGH' ? 'danger' : 
                                                ($event['severity'] == 'MEDIUM' ? 'warning' : 'info'); 
                                        ?>">
                                            <?php echo $event['severity']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $event['description']; ?></td>
                                    <td><?php echo $event['source_ip']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Architecture Summary -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="iot-card p-4" style="background: linear-gradient(145deg, var(--card-bg), #1a2639);">
                <h4 class="text-cyber mb-3">🔐 Multi-Layer Security Architecture Overview</h4>
                <div class="row">
                    <div class="col-md-4">
                        <h5>Device Layer</h5>
                        <ul class="small">
                            <li>AES-256 encryption</li>
                            <li>Secure boot</li>
                            <li>Hardware security module</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5 class="text-cyber">Edge Layer</h5>
                        <ul class="small">
                            <li>Intrusion Detection System (IDS)</li>
                            <li>RSA key exchange</li>
                            <li>RBAC + MFA</li>
                            <li>5ms processing</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5>Cloud Layer</h5>
                        <ul class="small">
                            <li>TLS 1.3</li>
                            <li>Encrypted storage</li>
                            <li>Secure firmware updates</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Additional styles for security page */
.layer-icon {
    width: 50px;
    height: 50px;
    line-height: 50px;
    text-align: center;
    border-radius: 50%;
    background: rgba(0, 255, 255, 0.1);
}

.security-badge .badge {
    font-size: 0.75rem;
    padding: 5px 10px;
    margin-right: 5px;
}

.progress {
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
}

.status-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

.status-online {
    background: var(--success);
    box-shadow: 0 0 10px var(--success);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(0, 255, 157, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(0, 255, 157, 0); }
    100% { box-shadow: 0 0 0 0 rgba(0, 255, 157, 0); }
}

.badge.bg-cyber {
    background: var(--primary);
    color: var(--dark);
}

.alert-cyber {
    color: var(--primary);
    border-color: var(--primary);
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
}
</style>

<script>
function simulateAttack() {
    // Simulate different types of attacks for each layer
    const attacks = [
        { layer: 'Device', type: 'BRUTE_FORCE', desc: 'Brute force attack on smart lock' },
        { layer: 'Edge', type: 'IDS_ALERT', desc: 'Suspicious traffic pattern detected at edge gateway' },
        { layer: 'Cloud', type: 'UNAUTHORIZED_ACCESS', desc: 'Unauthorized cloud API access attempt' }
    ];
    
    const attack = attacks[Math.floor(Math.random() * attacks.length)];
    
    fetch('security_api.php?action=simulate_attack&layer=' + attack.layer)
        .then(response => response.json())
        .then(data => {
            alert(`⚠️ ${attack.layer} Layer Attack Simulated!\n${attack.desc}\nCheck security log.`);
            location.reload();
        });
}

function rotateKeys() {
    if(confirm('Rotate encryption keys? This will generate new RSA keys at the edge layer.')) {
        alert('✅ Encryption keys rotated successfully at edge layer!');
        // Log the key rotation
        fetch('security_api.php?action=log_event&type=KEY_ROTATION&desc=Encryption+keys+rotated+at+edge')
            .then(() => location.reload());
    }
}

function testEdge() {
    alert('⚡ Edge Processing Test\nIDS Latency: 5ms\nThreat Detection: Active\nProcessing at edge gateway...');
    
    // Add to stream if you have one
    const stream = document.querySelector('.data-stream');
    if(stream) {
        const timestamp = new Date().toLocaleTimeString();
        stream.innerHTML = `<div class="small mb-1"><span class="text-cyber">[${timestamp}]</span> ⚡ Edge processing test: 5ms latency</div>` + stream.innerHTML;
    }
}
</script>

<?php include 'footer.php'; ?>