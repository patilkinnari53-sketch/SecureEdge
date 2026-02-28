<?php
// security_api.php - Handle AJAX security requests
require_once 'database.php';

$db = new IoTDatabase();
$conn = $db->connect();

$action = $_GET['action'] ?? '';

switch($action) {
    case 'simulate_attack':
        // Simulate different types of attacks
        $attacks = [
            ['BRUTE_FORCE', 'HIGH', 'Multiple failed login attempts detected', '45.33.22.11'],
            ['DDOS_ATTEMPT', 'HIGH', 'Unusual traffic pattern detected', '78.99.44.55'],
            ['PORT_SCAN', 'MEDIUM', 'Port scanning activity detected', '112.33.44.66'],
            ['SQL_INJECTION', 'HIGH', 'SQL injection attempt blocked', '203.45.67.89'],
            ['MITM_ATTEMPT', 'CRITICAL', 'Man-in-the-middle attack detected', '156.78.90.12']
        ];
        
        $attack = $attacks[array_rand($attacks)];
        
        $stmt = $conn->prepare("INSERT INTO security_events (event_type, severity, description, source_ip) VALUES (?, ?, ?, ?)");
        $stmt->execute($attack);
        
        echo json_encode(['success' => true, 'attack' => $attack]);
        break;
        
    case 'get_stats':
        $high = $conn->query("SELECT COUNT(*) FROM security_events WHERE severity='HIGH'")->fetchColumn();
        $medium = $conn->query("SELECT COUNT(*) FROM security_events WHERE severity='MEDIUM'")->fetchColumn();
        $low = $conn->query("SELECT COUNT(*) FROM security_events WHERE severity='LOW'")->fetchColumn();
        
        echo json_encode(['high' => $high, 'medium' => $medium, 'low' => $low]);
        break;
        
    default:
        echo json_encode(['error' => 'Invalid action']);
}
?>