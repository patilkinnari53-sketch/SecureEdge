<?php
// footer.php - Multi-Layer Architecture Footer
?>
    </main>

    <!-- Footer -->
    <footer class="footer mt-5 py-5" style="background: linear-gradient(180deg, var(--card-bg) 0%, #0a0f1f 100%); border-top: 3px solid var(--primary);">
        <div class="container">
            <!-- Main Footer Content -->
            <div class="row g-4">
                <!-- About Section -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-about">
                        <h4 class="text-cyber mb-4">
                            <i class="fas fa-shield-alt me-2"></i>
                            EdgeSecure<span style="color: var(--primary);">Arch</span>
                        </h4>
                        <p class="text-secondary mb-3">
                            A Secure and Lightweight Multi-Layer Architecture for IoT-Based Smart Home Systems 
                            Using Edge Computing. Three-layer defense with edge intelligence.
                        </p>
                        <div class="architecture-badges mt-3">
                            <span class="badge bg-cyber text-dark me-2 mb-2">
                                <i class="fas fa-microchip me-1"></i>Device Layer
                            </span>
                            <span class="badge bg-cyber text-dark me-2 mb-2">
                                <i class="fas fa-server me-1"></i>Edge Layer
                            </span>
                            <span class="badge bg-cyber text-dark me-2 mb-2">
                                <i class="fas fa-cloud me-1"></i>Cloud Layer
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Links by Layer -->
                <div class="col-lg-2 col-md-6">
                    <h5 class="text-cyber mb-4">By Layer</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2">
                            <a href="architecture.php#device-layer" class="text-secondary text-decoration-none">
                                <i class="fas fa-microchip text-cyber me-2 small"></i>Device Layer
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="architecture.php#edge-layer" class="text-secondary text-decoration-none">
                                <i class="fas fa-server text-cyber me-2 small"></i>Edge Layer
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="architecture.php#cloud-layer" class="text-secondary text-decoration-none">
                                <i class="fas fa-cloud text-cyber me-2 small"></i>Cloud Layer
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="security.php" class="text-secondary text-decoration-none">
                                <i class="fas fa-shield-alt text-cyber me-2 small"></i>Security
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Security Links -->
                <div class="col-lg-2 col-md-6">
                    <h5 class="text-cyber mb-4">Security</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2">
                            <span class="text-secondary">
                                <i class="fas fa-lock text-cyber me-2 small"></i>AES-256
                            </span>
                        </li>
                        <li class="mb-2">
                            <span class="text-secondary">
                                <i class="fas fa-key text-cyber me-2 small"></i>RSA-2048
                            </span>
                        </li>
                        <li class="mb-2">
                            <span class="text-secondary">
                                <i class="fas fa-shield text-cyber me-2 small"></i>TLS 1.3
                            </span>
                        </li>
                        <li class="mb-2">
                            <span class="text-secondary">
                                <i class="fas fa-robot text-cyber me-2 small"></i>IDS at Edge
                            </span>
                        </li>
                    </ul>
                </div>

                <!-- Architecture Stats -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-cyber mb-4">Architecture Stats</h5>
                    <div class="stats-mini">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary">Latency Reduction</span>
                            <span class="text-cyber fw-bold">43%</span>
                        </div>
                        <div class="progress mb-3" style="height: 5px;">
                            <div class="progress-bar bg-cyber" style="width: 43%"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary">Attack Detection</span>
                            <span class="text-cyber fw-bold">98.7%</span>
                        </div>
                        <div class="progress mb-3" style="height: 5px;">
                            <div class="progress-bar bg-cyber" style="width: 98.7%"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary">Edge Processing</span>
                            <span class="text-cyber fw-bold">5ms</span>
                        </div>
                        <div class="progress mb-3" style="height: 5px;">
                            <div class="progress-bar bg-cyber" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <hr class="border-cyber opacity-25 my-4">

            <!-- Middle Footer Row -->
            <div class="row align-items-center g-3">
                <div class="col-md-4">
                    <div class="live-status d-flex align-items-center">
                        <span class="status-dot status-online me-2"></span>
                        <span class="text-secondary small">Edge Gateway: </span>
                        <span class="text-cyber small ms-1">Active</span>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="layer-indicators">
                        <span class="badge bg-cyber text-dark me-1">Device</span>
                        <i class="fas fa-arrow-right text-cyber mx-1 small"></i>
                        <span class="badge bg-cyber text-dark me-1">Edge</span>
                        <i class="fas fa-arrow-right text-cyber mx-1 small"></i>
                        <span class="badge bg-cyber text-dark">Cloud</span>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="text-secondary small">
                        <i class="fas fa-clock text-cyber me-1"></i>
                        <span class="live-time"><?php echo date('H:i:s'); ?></span> UTC
                    </span>
                </div>
            </div>

            <!-- Divider -->
            <hr class="border-cyber opacity-25 my-4">

            <!-- Bottom Footer -->
            <div class="row">
                <div class="col-md-6">
                    <p class="text-secondary small mb-0">
                        © <?php echo date('Y'); ?> EdgeSecure Architecture. All rights reserved.
                        <br>
                        <span class="text-cyber">A Secure and Lightweight Multi-Layer Architecture for IoT-Based Smart Home Systems</span>
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="social-links">
                        <a href="#" class="text-cyber me-3" title="GitHub">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="#" class="text-cyber me-3" title="Research Paper">
                            <i class="fas fa-file-alt"></i>
                        </a>
                        <a href="#" class="text-cyber me-3" title="Documentation">
                            <i class="fas fa-book"></i>
                        </a>
                        <a href="#" class="text-cyber" title="Contact">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Architecture Quote -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="text-center small text-secondary opacity-50">
                        <i class="fas fa-quote-left text-cyber me-2"></i>
                        Secure by design, protected by edge, verified by layers
                        <i class="fas fa-quote-right text-cyber ms-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
        // Live clock update
        function updateFooterClock() {
            const now = new Date();
            const timeString = now.toUTCString().split(' ')[4];
            document.querySelectorAll('.live-time').forEach(el => {
                el.textContent = timeString;
            });
        }
        setInterval(updateFooterClock, 1000);

        // Smooth scroll for footer links
        document.querySelectorAll('.footer-links a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if(target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Add hover effects
        document.querySelectorAll('.footer-links li').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.querySelector('i')?.classList.add('fa-beat');
            });
            item.addEventListener('mouseleave', function() {
                this.querySelector('i')?.classList.remove('fa-beat');
            });
        });
    </script>

    <style>
        /* Footer specific styles */
        .footer {
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            animation: scan 8s linear infinite;
        }

        @keyframes scan {
            0% { left: -100%; }
            50% { left: 100%; }
            100% { left: 100%; }
        }

        .footer-links li {
            transition: transform 0.3s ease;
        }

        .footer-links li:hover {
            transform: translateX(5px);
        }

        .footer-links a {
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary) !important;
        }

        .stats-mini .progress {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .stats-mini .progress-bar {
            border-radius: 10px;
            background: var(--primary);
        }

        .social-links a {
            font-size: 1.2rem;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .social-links a:hover {
            transform: translateY(-3px);
            text-shadow: 0 0 15px var(--primary);
        }

        .badge.bg-cyber {
            background: var(--primary);
            color: var(--dark);
            font-weight: 500;
            padding: 5px 10px;
        }

        .layer-indicators .badge {
            font-size: 0.7rem;
        }

        .status-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .status-online {
            background: var(--success);
            box-shadow: 0 0 10px var(--success);
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(0, 255, 157, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(0, 255, 157, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 255, 157, 0); }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .footer {
                text-align: center;
            }
            
            .footer .text-md-end {
                text-align: center !important;
                margin-top: 15px;
            }
            
            .layer-indicators {
                margin: 15px 0;
            }
        }

        /* Animated gradient border */
        .footer hr.border-cyber {
            opacity: 0.2;
            transition: opacity 0.3s ease;
        }

        .footer:hover hr.border-cyber {
            opacity: 0.4;
        }

        /* Tooltip styles */
        [title] {
            position: relative;
            cursor: help;
        }

        [title]:hover::after {
            content: attr(title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--primary);
            color: var(--dark);
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.7rem;
            white-space: nowrap;
            z-index: 1000;
            margin-bottom: 5px;
        }

        /* Architecture badges hover effect */
        .architecture-badges .badge {
            transition: all 0.3s ease;
            cursor: default;
        }

        .architecture-badges .badge:hover {
            transform: scale(1.1);
            box-shadow: 0 0 15px var(--primary);
        }

        /* Footer links icon animation */
        .fa-beat {
            animation: beat 0.5s ease;
        }

        @keyframes beat {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }
    </style>
</body>
</html>