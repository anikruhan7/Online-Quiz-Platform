/**
 * Online Quiz Platform - Main JavaScript
 * Handles protected link interception, AJAX helpers, and UI enhancements
 */

// ============================================
// 1. Protected link interceptor
// ============================================
(function () {
    // List of URL patterns that require authentication
    const protectedPatterns = [
        'student/dashboard', 'student/courses', 'student/enrolled',
        'student/leaderboard', 'student/performance', 'student/doubt-sessions',
        'student/profile', 'student/quiz/take', 'student/qa',
        'instructor/dashboard', 'instructor/create-course', 'instructor/my-courses',
        'instructor/quiz-analytics', 'instructor/profile',
        'ta/dashboard', 'ta/assigned-courses', 'ta/doubt-sessions', 'ta/profile',
        'admin/dashboard', 'admin/manage-users', 'admin/courses',
        'admin/reports', 'admin/settings', 'admin/profile'
    ];

    // Check if a URL is protected
    function isProtected(url) {
        if (!url) return false;
        return protectedPatterns.some(pattern => url.includes(pattern));
    }

    // Async function to check login status
    async function isLoggedIn() {
        try {
            const response = await fetch('index.php?url=api/check-login');
            const data = await response.json();
            return data.loggedIn === true;
        } catch (e) {
            console.error('Login check failed:', e);
            return false;
        }
    }

    // Intercept clicks on all navigation links
    document.addEventListener('click', async function (e) {
        const link = e.target.closest('a');
        if (!link) return;

        const href = link.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;

        // Check if the link points to a protected page
        if (isProtected(href)) {
            const loggedIn = await isLoggedIn();
            if (!loggedIn) {
                e.preventDefault();
                alert('Please login first to access this page.');
                window.location.href = 'index.php?url=login';
            }
        }
    });
})();

// ============================================
// 2. Generic AJAX helper
// ============================================
window.api = {
    async get(endpoint, params = {}) {
        const query = new URLSearchParams(params).toString();
        const url = `index.php?url=${endpoint}${query ? '&' + query : ''}`;
        const response = await fetch(url);
        return response.json();
    },
    async post(endpoint, data = {}) {
        const formData = new FormData();
        for (let key in data) {
            formData.append(key, data[key]);
        }
        const response = await fetch(`index.php?url=${endpoint}`, {
            method: 'POST',
            body: formData
        });
        return response.json();
    }
};

// ============================================
// 3. Timer helper (can be used globally)
// ============================================
window.startTimer = function (durationSeconds, onTick, onExpire) {
    let timeLeft = durationSeconds;
    const interval = setInterval(() => {
        onTick(timeLeft);
        if (timeLeft <= 0) {
            clearInterval(interval);
            if (onExpire) onExpire();
        }
        timeLeft--;
    }, 1000);
    return interval;
};

// ============================================
// 4. Confirmation dialog helper
// ============================================
window.confirmAction = function (message, callback) {
    if (confirm(message)) {
        callback();
    }
};

// ============================================
// 5. Auto-hide alerts after 5 seconds
// ============================================
document.addEventListener('DOMContentLoaded', function () {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
});