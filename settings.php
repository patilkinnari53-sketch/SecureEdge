<?php
$pageTitle = "Settings - System Configuration";
include 'header.php';
require_once 'database.php';

$db = new IoTDatabase();
$conn = $db->connect();

// Handle settings update
if(isset($_POST['save_settings'])) {
    // Save settings logic here
    $db->logSecurityEvent('SETTINGS_CHANGE', 'INFO', 'System settings updated', $_SERVER['REMOTE_ADDR']);
}
?>

<div class="container">
    <h1 class="mb-4" data-aos="fade-up">
        <i class="fas fa-cog text-cyber me-2"></i>
        System Settings
    </h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="iot-card">
                <h4 class="mb-4">Security Configuration</h4>
                
                <form method="POST">
                    <!-- Encryption Settings -->
                    <div class="mb-4">
                        <h5 class="text-cyber mb-3">Encryption</h5>
                        <div class="mb-3">
                            <label class="form-label">AES Key Length</label>
                            <select class="form-control bg-dark text-white border-cyber">
                                <option selected>AES-256</option>
                                <option>AES-192</option>
                                <option>AES-128</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">RSA Key Size</label>
                            <select class="form-control bg-dark text-white border-cyber">
                                <option selected>2048 bits</option>
                                <option>4096 bits</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- IDS Settings -->
                    <div class="mb-4">
                        <h5 class="text-cyber mb-3">Intrusion Detection</h5>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" checked>
                            <label class="form-check-label">Enable Real-time Monitoring</label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" checked>
                            <label class="form-check-label">Auto-block Suspicious IPs</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sensitivity Level</label>
                            <input type="range" class="form-range" min="1" max="10" value="7">
                        </div>
                    </div>
                    
                    <!-- Edge Computing -->
                    <div class="mb-4">
                        <h5 class="text-cyber mb-3">Edge Computing</h5>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" checked>
                            <label class="form-check-label">Process Data at Edge</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Edge Cache Duration (seconds)</label>
                            <input type="number" class="form-control bg-dark text-white border-cyber" value="300">
                        </div>
                    </div>
                    
                    <button type="submit" name="save_settings" class="btn btn-iot">
                        <i class="fas fa-save me-2"></i>Save Settings
                    </button>
                </form>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="iot-card">
                <h4 class="mb-3">System Info</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-shield text-cyber me-2"></i>Security Level: High</li>
                    <li class="mb-2"><i class="fas fa-clock text-cyber me-2"></i>Uptime: 15 days</li>
                    <li class="mb-2"><i class="fas fa-microchip text-cyber me-2"></i>Edge Nodes: 3 active</li>
                    <li class="mb-2"><i class="fas fa-database text-cyber me-2"></i>Storage: 45% used</li>
                </ul>
                
                <hr class="border-cyber">
                
                <h5 class="text-cyber mb-3">Network Status</h5>
                <div class="mb-2">
                    <span class="status-dot status-online"></span> MQTT Broker
                </div>
                <div class="mb-2">
                    <span class="status-dot status-online"></span> Edge Gateway
                </div>
                <div class="mb-2">
                    <span class="status-dot status-online"></span> Cloud Sync
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>