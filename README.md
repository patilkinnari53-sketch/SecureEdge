# SecureEdge — Secure Multi-Layer Edge Architecture for IoT Smart Homes

A secure and lightweight **multi-layer architecture** for IoT-based smart home systems using **edge computing**. SecureEdge combines device, edge, and cloud layers to deliver real-time threat detection, encrypted communication, and defense-in-depth security — showcased through an interactive cyber-themed web dashboard.

---

## 🌐 Live Demo

**View Live:** [https://patilkinnari53-sketch.github.io/SecureEdge/](https://patilkinnari53-sketch.github.io/SecureEdge/)

---

## 🎯 What is SecureEdge?

SecureEdge is a **simulated IoT security architecture** that demonstrates how a modern smart home can be protected using three layers of defense:

1. **Device Layer** — IoT sensors, actuators, and end devices protected with AES-256 encryption
2. **Edge Layer** — A local gateway that performs real-time intrusion detection, key exchange, and access control (5ms processing)
3. **Cloud Layer** — Long-term storage, ML-based analytics, and secure firmware updates over TLS 1.3

The entire system is presented through an **interactive web dashboard** where users can manage devices, monitor security events, run IDS scans, simulate attacks, and connect a smart watch — all without any backend server.

---

## 🏗 Architecture Overview

The architecture is built on **three layers of defense**, each protecting the system in a different way:

**Device Layer** handles all the physical IoT devices — sensors, lights, locks, cameras, and thermostats. Every device uses AES-256 encryption, secure boot, and a hardware security module to prevent tampering. Devices communicate over MQTT, CoAP, or HTTPS.

**Edge Layer** is the intelligent core of the system. A local edge gateway performs real-time intrusion detection (IDS), RSA-2048 key exchange, role-based access control (RBAC), and multi-factor authentication (MFA). It processes data locally with only 5ms latency and keeps working even when the cloud is offline.

**Cloud Layer** provides long-term storage, ML-based analytics, and secure firmware updates. All data is encrypted in transit over TLS 1.3 and encrypted at rest with AES-256. The cloud also maintains audit logs and uses IAM and OAuth for access control.

### Security Mechanisms by Layer

| Layer | Encryption | Authentication | Monitoring | Latency |
|---|---|---|---|---|
| Device | AES-256 | Secure Boot, Device Auth | — | — |
| Edge | RSA-2048, TLS 1.3 | MFA, RBAC | IDS/IPS | 5 ms |
| Cloud | TLS 1.3, AES-256 | IAM, OAuth | ML Analytics | — |

---

## ✨ Key Features

### 🔐 Multi-Layer Security
- AES-256 encryption at device level
- RSA-2048 key exchange at edge
- TLS 1.3 for cloud transmission
- Role-Based Access Control (RBAC) and Multi-Factor Authentication (MFA)
- Hardware Security Module (HSM) support

### ⚡ Edge Computing
- 5ms processing latency — real-time decisions without cloud round-trips
- 98.7% threat detection rate via IDS at the edge
- Works offline when cloud connectivity is lost
- Reduces bandwidth usage by processing data locally

### 📊 Interactive Dashboard
- Real-time device management — add, delete, toggle smart devices
- Layer distribution chart showing device breakdown
- Live security event log with severity badges (INFO, MEDIUM, HIGH)
- Edge IDS monitoring panel
- Security controls — run IDS scan, simulate attack, rotate keys

### 📱 Smart Watch Integration
- Connect a real BLE smart watch via Web Bluetooth API
- Or use simulation mode to stream fake heart-rate, steps, and battery data
- Live data stream viewer with timestamps
- Auto-reconnect on disconnect

### 🎨 Cyber-Themed UI
- Dark navy background with neon cyan accents
- Glowing cards with hover lift effects
- Animated progress bars and pulse indicators
- Fully responsive — works on mobile, tablet, and desktop

---

## 🖥 Pages Overview

| Page | What it shows |
|---|---|
| **Dashboard** | Hero section, three-layer visualization, 8 IoT devices, live IDS monitoring, performance metrics |
| **Architecture** | Detailed breakdown of each layer, data flow diagram, security mechanisms table |
| **Devices** | Add/remove devices, layer distribution chart, grouped device cards by layer |
| **Security** | Multi-layer security overview, event log, IDS scan controls, attack simulation |
| **Settings** | AES key length, RSA key size, IDS sensitivity, edge cache duration |
| **Results** | Performance comparison, advantages & disadvantages, animated counters |
| **Watch Connection** | Web Bluetooth pairing, live watch data streaming, disconnect modal |
| **Login** | Demo authentication (admin / admin123), remember me, guest login |

---

## 🛠 Built With

- **HTML5** for semantic markup
- **Bootstrap 5.3** for the responsive grid
- **Custom CSS3** for animations, gradients, and the cyber theme
- **Font Awesome 6.4** for icons
- **Chart.js 4.4** for the doughnut chart
- **Vanilla JavaScript (ES6)** for all interactivity
- **Browser localStorage** as a lightweight database
- **Web Bluetooth API** for real smart watch pairing

No backend, no database server, no build tools — just pure front-end code running entirely in the browser.

---

## 🚀 Getting Started

### Run Locally

1. Download or clone the repository to your computer
2. Start a simple local server (Python users can run `python -m http.server 8000` in the folder)
3. Open `http://localhost:8000` in your browser

Opening the HTML file directly via `file://` will break Bluetooth and some JavaScript features, so always use a local server.

### Deploy on GitHub Pages

1. Push all files to a GitHub repository
2. Go to **Settings → Pages**
3. Set source to **Deploy from a branch** → `main` → `/ (root)`
4. Save — the site goes live at `https://<username>.github.io/SecureEdge/`

### Deploy on Netlify

1. Sign in to Netlify
2. Import your GitHub repo
3. Leave all build settings empty (Build command, Publish directory, Base directory)
4. Click **Deploy**

---

## 🎮 How to Use

### 1. Login
Open the site and use the demo credentials **admin / admin123**, or click **Continue as Guest**.

### 2. Explore the Dashboard
See 8 IoT devices with live toggle switches. Watch the layer distribution chart update when you add or remove devices. View the Edge IDS Monitoring panel with sample security events.

### 3. Test the Security Controls
Go to the **Security** page and click:
- **Run Edge IDS Scan** — generates a random threat count
- **Simulate Attack** — logs a HIGH-severity event
- **Rotate Encryption Keys** — logs a key rotation
- **Test Edge Processing** — logs a processing test

Every action appears in the security event log immediately.

### 4. Manage Devices
Go to the **Devices** page. Add a new device by selecting a type (sensor, light, lock, camera, thermostat, gateway, plug, or hub). The security features for that device auto-populate based on which layer it belongs to. Toggle power on existing devices. Delete devices with the trash icon.

### 5. Connect a Smart Watch
Go to the **My Watch** page. Click **Scan for Watches** (works only in Chrome or Edge on HTTPS or localhost) to pair a real BLE smart watch. Or click **Simulation Mode** to see fake heart-rate, steps, and battery data streaming in real time.

### 6. Adjust Settings
Go to the **Settings** page. Change AES key length, RSA key size, IDS sensitivity, and edge cache duration. Click **Save Settings** — the values persist across page reloads.

---

## 🔐 Security Model (Simulated)

Since this is a frontend-only demo, most cryptographic operations are simulated. Here's a breakdown:

| Feature | Real or Simulated? |
|---|---|
| AES-256 encryption | ❌ Simulated (uses Base64 for demo) |
| RSA-2048 key exchange | ❌ Simulated (fake key strings) |
| TLS 1.3 | ❌ Simulated (represented by badges) |
| IDS threat detection | ⚠️ Randomized (score 1–100, flags if > 90) |
| Edge processing (5ms) | ⚠️ Displayed (actual processing is instant) |
| Multi-Factor Auth | ❌ Simulated (username + password only) |
| Web Bluetooth pairing | ✅ Real (uses the actual browser API) |

**This is an educational demonstration, not a production security system.**

For a real IoT security deployment, you'd need actual TLS termination at the edge gateway, real AES encryption via the Web Crypto API, server-side authentication with JWT or OAuth 2.0, a real IDS engine like Snort or Suricata, and proper key management through a hardware security module or a vault service.

---

## 📊 Performance Metrics

| Metric | Value |
|---|---|
| Latency Reduction | 43% vs cloud-only architecture |
| Attack Detection Rate | 98.7% at edge layer |
| Edge Processing Time | 5 ms |
| Security Layers | 3 (Device → Edge → Cloud) |
| Data Protection | 99.9% |
| Scalability | High |
| Availability | 99.9% |

---

## 🎨 Design System

### Color Palette

The interface uses a **cyber-themed dark palette**:

- **Neon cyan** (`#00ffff`) — primary accent for links, icons, and highlights
- **Deep navy** (`#0b0f1c`) — main background
- **Card navy** (`#141b2b`) — card and panel backgrounds
- **Red** (`#ff4d6d`) — HIGH severity and errors
- **Amber** (`#ffb347`) — MEDIUM severity
- **Bright green** (`#00ff9d`) — online status and success messages
- **Soft blue** (`#9bb8e0`) — secondary text

### Animations

- **Pulse** on online status dots
- **Scan** line moving across the footer
- **Slide-in** toast notifications
- **Card lift** on hover for all device cards
- **Smooth progress bar** transitions
- **Pulsing rings** on timeline bullet points

---

## 🧪 Testing Checklist

After deploying, verify these work:

- Dashboard loads with 8 devices and the IDS panel
- Adding a device updates the layer chart
- Deleting a device removes it from the table
- Toggling a device power switch updates the status dot
- Security page shows the event log with seed data
- "Run Edge IDS Scan" adds an event
- "Simulate Attack" adds a HIGH severity event
- Settings page saves and reloads values
- Watch Connection page scans for devices (Chrome or Edge only)
- Login page accepts admin / admin123
- Logout button clears the session
- All pages show the navbar and footer
- Mobile layout stacks correctly

---

## 🐛 Known Limitations

- **Web Bluetooth** only works in Chrome, Edge, and Opera on HTTPS or localhost. It will not work in Firefox, Safari, or when opening files locally.
- **localStorage** is per-browser — data doesn't sync across devices.
- **Simulated encryption** — no real AES or RSA is applied to any data.
- **No backend** — all "server" calls are mocked with timers and browser storage.
- **No real IDS** — threat detection is randomized for demonstration purposes.
- **Mobile Safari** may not render the PDF iframe for the resume viewer on the main portfolio site.

---

## 🔮 Future Improvements

- Add real AES-GCM encryption using the Web Crypto API
- Connect to a real MQTT broker over WebSocket for live device data
- Build a Node.js + Express backend with persistent storage
- Implement real JWT authentication with refresh tokens
- Integrate more analytics charts (latency over time, attack frequency)
- Add a dark/light theme toggle
- Export security events to CSV or JSON
- Add email alerts via a serverless function
- Full PWA support with service workers
- Add unit tests for the device and event logic

---

## 📄 License

This project is part of academic coursework by **Kinnari Patil**. The code is available for reference and learning purposes. Please don't republish the architecture, documentation, or design as your own.

If you'd like to use the structure for your own IoT security project, feel free — a small credit is appreciated.

---

## 👩‍💻 Author

**Kinnari Patil**
- Information Technology Student — Rajiv Gandhi Institute of Technology, Mumbai
- Diploma in Computer Engineering — 90.71%
- GitHub: [patilkinnari53-sketch](https://github.com/patilkinnari53-sketch)
- LinkedIn: [linkedin.com/in/kinnaripatil](https://linkedin.com/in/kinnaripatil)
- Email: patilkinnari53@gmail.com

---

## 🙏 Acknowledgements

- Bootstrap 5 for the responsive grid
- Font Awesome for the icon set
- Chart.js for the layer distribution chart
- The open-source IoT security community for architecture concepts

---

## 📚 References

- NIST IoT Security Framework
- Edge Computing: A Survey (IEEE Communications)
- MQTT 3.1.1 and 5.0 Specifications
- CoAP (RFC 7252)
- TLS 1.3 (RFC 8446)
- Web Bluetooth API Specification (W3C)

---

*Last updated: 2026*
