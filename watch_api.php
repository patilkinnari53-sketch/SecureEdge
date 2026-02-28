<?php
// watch_api.php - Handle watch data
header('Content-Type: application/json');
require_once 'database.php';

try {
    $db = new IoTDatabase();
    $conn = $db->connect();
    
    $heart_rate = $_POST['heart_rate'] ?? 0;
    $steps = $_POST['steps'] ?? 0;
    $battery = $_POST['battery'] ?? 0;
    
    // Log watch data
    $stmt = $conn->prepare("INSERT INTO sensor_data (device_id, temperature, motion) VALUES (?, ?, ?)");
    $stmt->execute([99, $heart_rate, $steps > 0 ? 1 : 0]); // Using device_id 99 for watch
    
    echo json_encode(['success' => true, 'message' => 'Watch data received']);
    
} catch(Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>