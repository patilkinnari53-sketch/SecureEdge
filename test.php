<?php
// test.php - Test page
?>
<!DOCTYPE html>
<html>
<head>
    <title>IoT System Test</title>
    <style>
        body { background: #0a0f1f; color: white; font-family: monospace; padding: 50px; }
        .success { color: #00ff9d; }
        .error { color: #ff4444; }
        .test-card {
            background: #151f2f;
            border: 2px solid #00ffff;
            border-radius: 10px;
            padding: 20px;
            margin: 10px 0;
        }
        .btn {
            background: #00ffff;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
        .btn:hover { transform: scale(1.05); }
    </style>
</head>
<body>
    <h1>🔧 IoT System Test Page</h1>
    
    <div class="test-card">
        <h2>1. Database Test</h2>
        <?php
        try {
            $pdo = new PDO("mysql:host=localhost", "root", "");
            echo "<p class='success'>✅ MySQL Connected</p>";
            
            // Test database creation
            $pdo->exec("CREATE DATABASE IF NOT EXISTS test_iot");
            echo "<p class='success'>✅ Can create databases</p>";
            $pdo->exec("DROP DATABASE test_iot");
            
        } catch(Exception $e) {
            echo "<p class='error'>❌ MySQL Error: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>
    
    <div class="test-card">
        <h2>2. PHP Version</h2>
        <p>PHP Version: <?php echo phpversion(); ?></p>
    </div>
    
    <div class="test-card">
        <h2>3. Button Test</h2>
        <button class="btn" onclick="testClick()">Click Me</button>
        <p id="clickTest">Not clicked yet</p>
    </div>
    
    <div class="test-card">
        <h2>4. AJAX Test</h2>
        <button class="btn" onclick="testAjax()">Test AJAX</button>
        <p id="ajaxTest">Not tested</p>
    </div>
    
    <div class="test-card">
        <h2>5. Quick Setup</h2>
        <a href="setup.php" class="btn">Run Full Setup</a>
    </div>
    
    <script>
    function testClick() {
        document.getElementById('clickTest').innerHTML = '✅ Button clicked!';
        document.getElementById('clickTest').style.color = '#00ff9d';
    }
    
    function testAjax() {
        fetch('toggle_device.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'device_id=1&status=1'
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('ajaxTest').innerHTML = '✅ AJAX working: ' + JSON.stringify(data);
        })
        .catch(error => {
            document.getElementById('ajaxTest').innerHTML = '❌ AJAX error: ' + error;
        });
    }
    </script>
</body>
</html>