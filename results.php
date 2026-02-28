<?php
$pageTitle = "Results - Performance & Advantages";
include 'header.php';
?>

<div class="container">
    <div class="row mb-5">
        <div class="col-12">
            <h1 class="section-title" data-aos="fade-up">Results & Advantages</h1>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="row mb-5">
        <?php
        $metrics = [
            ['value' => '43', 'suffix' => '%', 'label' => 'Latency Reduction', 'icon' => 'bi-speedometer2', 'delay' => 100],
            ['value' => '98.7', 'suffix' => '%', 'label' => 'Attack Detection', 'icon' => 'bi-shield', 'delay' => 200],
            ['value' => '99.9', 'suffix' => '%', 'label' => 'Data Protection', 'icon' => 'bi-lock', 'delay' => 300],
            ['value' => '7', 'suffix' => '', 'label' => 'Security Layers', 'icon' => 'bi-diagram-3', 'delay' => 400]
        ];
        
        foreach($metrics as $metric): ?>
        <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="<?php echo $metric['delay']; ?>">
            <div class="cyber-card text-center">
                <i class="bi <?php echo $metric['icon']; ?> fs-1 text-cyber mb-3"></i>
                <h2 class="display-4 fw-bold text-cyber counter" data-target="<?php echo $metric['value']; ?>">0</h2>
                <span class="h4"><?php echo $metric['suffix']; ?></span>
                <p class="mt-2"><?php echo $metric['label']; ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Advantages & Disadvantages -->
    <div class="row mb-5">
        <div class="col-lg-6" data-aos="fade-right">
            <div class="cyber-card h-100">
                <h3 class="text-cyber mb-4"><i class="bi bi-check-circle-fill me-2"></i>Advantages</h3>
                <ul class="list-unstyled">
                    <li class="mb-3"><i class="bi bi-check-lg text-cyber me-2"></i> Reduced latency through edge processing</li>
                    <li class="mb-3"><i class="bi bi-check-lg text-cyber me-2"></i> Improved security with multi-layer defense</li>
                    <li class="mb-3"><i class="bi bi-check-lg text-cyber me-2"></i> Early attack detection at edge</li>
                    <li class="mb-3"><i class="bi bi-check-lg text-cyber me-2"></i> Scalable architecture</li>
                    <li class="mb-3"><i class="bi bi-check-lg text-cyber me-2"></i> Reduced cloud bandwidth usage</li>
                    <li class="mb-3"><i class="bi bi-check-lg text-cyber me-2"></i> Privacy-preserving local processing</li>
                </ul>
            </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
            <div class="cyber-card h-100">
                <h3 class="text-cyber mb-4"><i class="bi bi-exclamation-triangle-fill me-2"></i>Disadvantages</h3>
                <ul class="list-unstyled">
                    <li class="mb-3"><i class="bi bi-dash-circle text-secondary me-2"></i> Higher initial hardware cost</li>
                    <li class="mb-3"><i class="bi bi-dash-circle text-secondary me-2"></i> Key management complexity</li>
                    <li class="mb-3"><i class="bi bi-dash-circle text-secondary me-2"></i> Computational overhead at edge</li>
                    <li class="mb-3"><i class="bi bi-dash-circle text-secondary me-2"></i> Requires specialized edge hardware</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Performance Graph -->
    <div class="row">
        <div class="col-12">
            <div class="cyber-card" data-aos="fade-up">
                <h3 class="text-cyber mb-4">Performance Comparison</h3>
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="progress mb-4" style="height: 30px;">
                            <div class="progress-bar bg-danger" style="width: 100%">Traditional: 250ms</div>
                        </div>
                        <div class="progress mb-4" style="height: 30px;">
                            <div class="progress-bar bg-cyber" style="width: 43%">EdgeSecure: 107ms</div>
                        </div>
                        <div class="progress mb-4" style="height: 30px;">
                            <div class="progress-bar bg-info" style="width: 100%">Cloud-Only: 380ms</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h2 class="text-cyber">43%</h2>
                        <p>Latency Reduction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>