<?php
// watch_data_api.php - Updated with disconnect logging
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'database.php';

try {
    $db = new IoTDatabase();
    $conn = $db->connect();
    
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (isset($input['action'])) {
        if ($input['action'] == 'log_connection') {
            // Log watch connection
            $stmt = $conn->prepare("INSERT INTO security_events (event_type, severity, description, source_ip) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                'WATCH_CONNECTED',
                'INFO',
                "Smart watch connected: " . ($input['device_name'] ?? 'Unknown'),
                $_SERVER['REMOTE_ADDR']
            ]);
            
            echo json_encode(['success' => true, 'message' => 'Connection logged']);
            
        } else if ($input['action'] == 'log_disconnection') {
            // Log watch disconnection
            $stmt = $conn->prepare("INSERT INTO security_events (event_type, severity, description, source_ip) VALUES (?, ?, ?, ?)");
            
            $duration = isset($input['connection_duration']) ? " Duration: " . $input['connection_duration'] : "";
            $description = "Smart watch disconnected: " . ($input['device_name'] ?? 'Unknown') . $duration;
            
            $stmt->execute([
                'WATCH_DISCONNECTED',
                'INFO',
                $description,
                $_SERVER['REMOTE_ADDR']
            ]);
            
            // Update watch_connections table
            $stmt = $conn->prepare("UPDATE watch_connections SET connected = 0, last_sync = NOW() WHERE watch_id = ?");
            $stmt->execute([$input['device_id'] ?? 'unknown']);
            
            echo json_encode(['success' => true, 'message' => 'Disconnection logged']);
        }
    } else {
        // Save watch data
        $type = $input['type'] ?? '';
        $value = $input['value'] ?? 0;
        $device_id = $input['device_id'] ?? 'unknown';
        
        // Store in sensor_data table
        $stmt = $conn->prepare("INSERT INTO sensor_data (device_id, temperature, motion) VALUES (99, ?, ?)");
        $value_num = is_numeric($value) ? $value : 0;
        $motion = ($type == 'steps') ? $value_num : 0;
        $stmt->execute([$value_num, $motion > 0 ? 1 : 0]);
        
        echo json_encode(['success' => true, 'message' => 'Data saved']);
    }
    
} catch(Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>