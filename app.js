/* =========================================================
   INCLUDE LOADER
   Fetches header.html / footer.html and injects them into
   any element that has a [data-include] attribute.
   ========================================================= */
document.addEventListener('DOMContentLoaded', function () {
    const includes = document.querySelectorAll('[data-include]');
    if (includes.length === 0) return;

    let pending = includes.length;

    includes.forEach(function (el) {
        const file = el.getAttribute('data-include');
        fetch(file)
            .then(function (r) {
                if (!r.ok) throw new Error(file + ' → HTTP ' + r.status);
                return r.text();
            })
            .then(function (html) {
                el.outerHTML = html;
                pending--;
                if (pending === 0) initSharedScripts();
            })
            .catch(function (err) {
                console.error('Include failed:', err);
                el.innerHTML = '<div style="color:#ff4444;padding:20px;background:#1a0000;border:1px solid #ff4444;border-radius:8px;">' +
                    '<strong>Include error:</strong> ' + err.message + '<br>' +
                    'Make sure <code>' + file + '</code> exists in the same folder as this page.' +
                    '</div>';
                pending--;
                if (pending === 0) initSharedScripts();
            });
    });
});

/* =========================================================
   SHARED SCRIPTS — run after includes are injected
   ========================================================= */
function initSharedScripts() {
    // Live UTC clock in footer
    function updateClock() {
        const t = new Date().toUTCString().split(' ')[4];
        document.querySelectorAll('.live-time').forEach(function (el) {
            el.textContent = t;
        });
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Footer year
    const yearEl = document.getElementById('footerYear');
    if (yearEl) yearEl.textContent = new Date().getFullYear();

    // Active nav link based on current filename
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    document.querySelectorAll('#mainNav .nav-link').forEach(function (link) {
        if (link.getAttribute('href') === currentPage) {
            link.classList.add('active');
        }
    });

    // Footer link hover beat
    document.querySelectorAll('.footer-links li').forEach(function (item) {
        item.addEventListener('mouseenter', function () {
            const icon = this.querySelector('i');
            if (icon) icon.classList.add('fa-beat');
        });
        item.addEventListener('mouseleave', function () {
            const icon = this.querySelector('i');
            if (icon) icon.classList.remove('fa-beat');
        });
    });

    // Smooth-scroll for footer anchor links
    document.querySelectorAll('.footer-links a[href^="#"]').forEach(function (a) {
        a.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
}

/* =========================================================
   GLOBAL HELPERS
   ========================================================= */
function connectWatch() {
    const status = document.getElementById('watchStatus');
    if (!status) return;

    if (status.textContent.indexOf('Disconnected') !== -1) {
        status.textContent = 'Smart Watch: Connected';
        status.classList.remove('text-secondary');
        status.classList.add('text-cyber');
        showToast('✅ Smart Watch connected!');
    } else {
        status.textContent = 'Smart Watch: Disconnected';
        status.classList.remove('text-cyber');
        status.classList.add('text-secondary');
        showToast('🔌 Smart Watch disconnected');
    }
}

function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(function () { toast.remove(); }, 3000);
}
