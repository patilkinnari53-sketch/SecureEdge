<?php
// database.php - Fixed connection
class IoTDatabase {
    private $host = 'localhost';
    private $db_name = 'iot_smart_home';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function connect() {
        if ($this->conn) {
            return $this->conn;
        }

        try {
            // First connect to MySQL server
            $temp_conn = new PDO("mysql:host=" . $this->host, $this->username, $this->password);
            $temp_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create database if not exists
            $temp_conn->exec("CREATE DATABASE IF NOT EXISTS " . $this->db_name);
            $temp_conn->exec("USE " . $this->db_name);
            
            // Create connection to the database
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
            
            // Create tables
            $this->setupTables();
            
            return $this->conn;
            
        } catch(PDOException $e) {
            die("
                <div style='background: #ff4444; color: white; padding: 20px; margin: 20px; border-radius: 10px;'>
                    <h2>⚠️ Database Error</h2>
                    <p>Please make sure MySQL is running in XAMPP</p>
                    <p><strong>Error:</strong> " . $e->getMessage() . "</p>
                    <button onclick='window.location.href=\"setup.php\"' style='padding:10px 20px; background:#00ffff; color:black; border:none; border-radius:5px; cursor:pointer;'>
                        Run Setup Wizard
                    </button>
                </div>
            ");
        }
    }

    private function setupTables() {
        try {
            // Devices table
            $sql1 = "CREATE TABLE IF NOT EXISTS devices (
                id INT AUTO_INCREMENT PRIMARY KEY,
                device_name VARCHAR(100),
                device_type VARCHAR(50),
                status BOOLEAN DEFAULT 0,
                value FLOAT DEFAULT 0,
                room VARCHAR(50),
                ip_address VARCHAR(20),
                mac_address VARCHAR(17),
                last_seen TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
            
            // Security events table
            $sql2 = "CREATE TABLE IF NOT EXISTS security_events (
                id INT AUTO_INCREMENT PRIMARY KEY,
                event_type VARCHAR(50),
                severity VARCHAR(20),
                description TEXT,
                source_ip VARCHAR(20),
                timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            
            // Watch connections table
            $sql3 = "CREATE TABLE IF NOT EXISTS watch_connections (
                id INT AUTO_INCREMENT PRIMARY KEY,
                watch_id VARCHAR(100),
                watch_name VARCHAR(100),
                user_id VARCHAR(50),
                connected BOOLEAN DEFAULT 0,
                last_sync TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            
            $this->conn->exec($sql1);
            $this->conn->exec($sql2);
            $this->conn->exec($sql3);
            
            // Insert sample data if empty
            $this->insertSampleData();
            
        } catch(PDOException $e) {
            error_log("Table creation error: " . $e->getMessage());
        }
    }

    private function insertSampleData() {
        // Check if devices exist
        $stmt = $this->conn->query("SELECT COUNT(*) FROM devices");
        if($stmt->fetchColumn() == 0) {
            $devices = [
                ['Living Room Light', 'light', 1, 0, 'Living Room', '192.168.1.101', 'AA:BB:CC:DD:EE:01'],
                ['Smart Thermostat', 'thermostat', 1, 22.5, 'Living Room', '192.168.1.102', 'AA:BB:CC:DD:EE:02'],
                ['Front Door Camera', 'camera', 1, 0, 'Entrance', '192.168.1.103', 'AA:BB:CC:DD:EE:03'],
                ['Main Door Lock', 'lock', 1, 1, 'Main Door', '192.168.1.104', 'AA:BB:CC:DD:EE:04'],
                ['Hallway Motion Sensor', 'sensor', 1, 0, 'Hallway', '192.168.1.105', 'AA:BB:CC:DD:EE:05'],
                ['Kitchen Smoke Detector', 'sensor', 1, 0, 'Kitchen', '192.168.1.106', 'AA:BB:CC:DD:EE:06'],
                ['Bedroom Smart Plug', 'plug', 0, 0, 'Bedroom', '192.168.1.107', 'AA:BB:CC:DD:EE:07'],
                ['Temperature Sensor', 'sensor', 1, 23.5, 'Bedroom', '192.168.1.108', 'AA:BB:CC:DD:EE:08']
            ];
            
            $stmt = $this->conn->prepare("INSERT INTO devices (device_name, device_type, status, value, room, ip_address, mac_address) VALUES (?, ?, ?, ?, ?, ?, ?)");
            foreach($devices as $device) {
                $stmt->execute($device);
            }
        }
    }

    public function logSecurityEvent($type, $severity, $description, $ip) {
        $stmt = $this->conn->prepare("INSERT INTO security_events (event_type, severity, description, source_ip) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$type, $severity, $description, $ip]);
    }

    public function updateDeviceStatus($device_id, $status) {
        $stmt = $this->conn->prepare("UPDATE devices SET status = ?, last_seen = NOW() WHERE id = ?");
        return $stmt->execute([$status, $device_id]);
    }
}
?>