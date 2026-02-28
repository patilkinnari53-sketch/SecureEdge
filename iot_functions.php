<?php
// iot_functions.php
class IoTManager {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }

    public function encryptData($data) {
        return base64_encode($data . "_encrypted");
    }

    public function simulateRSAKeyExchange($device_id) {
        return [
            'public' => 'RSA_KEY_' . md5($device_id),
            'private' => 'PRIV_KEY_' . md5($device_id . rand())
        ];
    }

    public function checkForIntrusion($device_data) {
        $threat_score = rand(1, 100);
        if($threat_score > 90) {
            return ['detected' => true, 'score' => $threat_score];
        }
        return ['detected' => false, 'score' => $threat_score];
    }
}
?>