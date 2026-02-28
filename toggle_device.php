<?php
// toggle_device.php - Handle device toggle AJAX
header('Content-Type: application/json');
require_once 'database.php';

try {
    $db = new IoTDatabase();
    $conn = $db->connect();
    
    $device_id = $_POST['device_id'] ?? 0;
    $status = $_POST['status'] ?? 0;
    
    $stmt = $conn->prepare("UPDATE devices SET status = ?, last_seen = NOW() WHERE id = ?");
    $success = $stmt->execute([$status, $device_id]);
    
    // Log event
    if($success) {
        $stmt = $conn->prepare("SELECT device_name FROM devices WHERE id = ?");
        $stmt->execute([$device_id]);
        $device_name = $stmt->fetchColumn();
        
        $db->logSecurityEvent(
            'DEVICE_TOGGLE',
            'INFO',
            "Device '$device_name' turned " . ($status ? 'ON' : 'OFF'),
            $_SERVER['REMOTE_ADDR']
        );
    }
    
    echo json_encode(['success' => $success]);
    
} catch(Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>