<?php
// setup.php - One-click database setup
?>
<!DOCTYPE html>
<html>
<head>
    <title>IoT System Setup</title>
    <style>
        body {
            background: #0a0f1f;
            color: white;
            font-family: Arial, sans-serif;
            padding: 50px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #151f2f;
            padding: 30px;
            border-radius: 15px;
            border: 2px solid #00ffff;
        }
        h1 { color: #00ffff; }
        .success { color: #00ff9d; }
        .btn {
            background: #00ffff;
            color: #0a0f1f;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 10px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        .btn:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 IoT System Setup Wizard</h1>
        
        <?php
        if(isset($_POST['setup'])) {
            try {
                $pdo = new PDO("mysql:host=localhost", "root", "");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Create database
                $pdo->exec("DROP DATABASE IF EXISTS iot_smart_home");
                $pdo->exec("CREATE DATABASE iot_smart_home");
                $pdo->exec("USE iot_smart_home");
                
                echo "<p class='success'>✅ Database created</p>";
                
                // Create tables
                $sql = "
                CREATE TABLE devices (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    device_name VARCHAR(100),
                    device_type VARCHAR(50),
                    status BOOLEAN DEFAULT 0,
                    value FLOAT DEFAULT 0,
                    room VARCHAR(50),
                    ip_address VARCHAR(20),
                    mac_address VARCHAR(17),
                    last_seen TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                );
                
                CREATE TABLE security_events (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    event_type VARCHAR(50),
                    severity VARCHAR(20),
                    description TEXT,
                    source_ip VARCHAR(20),
                    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                );
                
                CREATE TABLE sensor_data (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    device_id INT,
                    temperature FLOAT,
                    humidity FLOAT,
                    motion BOOLEAN,
                    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                );
                ";
                
                $pdo->exec($sql);
                echo "<p class='success'>✅ Tables created</p>";
                
                // Insert sample devices
                $devices = [
                    ['Living Room Light', 'light', 1, 0, 'Living Room', '192.168.1.101', 'AA:BB:CC:DD:EE:01'],
                    ['Smart Thermostat', 'thermostat', 1, 22.5, 'Living Room', '192.168.1.102', 'AA:BB:CC:DD:EE:02'],
                    ['Front Door Camera', 'camera', 1, 0, 'Entrance', '192.168.1.103', 'AA:BB:CC:DD:EE:03'],
                    ['Main Door Lock', 'lock', 1, 1, 'Main Door', '192.168.1.104', 'AA:BB:CC:DD:EE:04']
                ];
                
                $stmt = $pdo->prepare("INSERT INTO devices (device_name, device_type, status, value, room, ip_address, mac_address) VALUES (?, ?, ?, ?, ?, ?, ?)");
                foreach($devices as $d) {
                    $stmt->execute($d);
                }
                echo "<p class='success'>✅ Sample devices added</p>";
                
                echo "<h3 class='success'>✅ Setup Complete!</h3>";
                echo "<a href='index.php' class='btn'>Go to Dashboard</a>";
                
            } catch(PDOException $e) {
                echo "<p style='color:#ff4444;'>❌ Error: " . $e->getMessage() . "</p>";
            }
        } else {
        ?>
        
        <p>This will set up your IoT system automatically:</p>
        <ul>
            <li>Create database: iot_smart_home</li>
            <li>Create all required tables</li>
            <li>Add sample devices</li>
        </ul>
        
        <form method="POST">
            <input type="hidden" name="setup" value="1">
            <button type="submit" class="btn">🚀 Run Setup Now</button>
            <a href="index.php" class="btn">Skip to Dashboard</a>
        </form>
        
        <?php } ?>
    </div>
</body>
</html>