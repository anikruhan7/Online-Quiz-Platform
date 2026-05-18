(function () {
    setTimeout(function () {
        var alerts = document.querySelectorAll('.alert');
        for (var i = 0; i < alerts.length; i++) {
            alerts[i].style.transition = 'opacity 0.5s';
            alerts[i].style.opacity = '0';
            setTimeout(function (el) {
                if (el && el.parentNode) el.parentNode.removeChild(el);
            }, 500, alerts[i]);
        }
    }, 5000);

    var protectedPatterns = [
        'student/dashboard', 'student/courses', 'student/enrolled',
        'student/leaderboard', 'student/performance', 'student/doubt-sessions',
        'student/profile', 'student/quiz/take', 'student/qa',
        'instructor/dashboard', 'instructor/create-course', 'instructor/my-courses',
        'instructor/quiz-analytics', 'instructor/profile',
        'ta/dashboard', 'ta/assigned-courses', 'ta/doubt-sessions', 'ta/profile',
        'admin/dashboard', 'admin/manage-users', 'admin/courses',
        'admin/subjects', 'admin/quizzes', 'admin/reports', 'admin/settings', 'admin/profile'
    ];

    function isProtected(url) {
        if (!url) return false;
        for (var i = 0; i < protectedPatterns.length; i++) {
            if (url.indexOf(protectedPatterns[i]) !== -1) return true;
        }
        return false;
    }

    function isLoggedIn() {
        return fetch('index.php?url=api/check-login')
            .then(function (response) { return response.json(); })
            .then(function (data) { return data.loggedIn === true; })
            .catch(function () { return false; });
    }

    document.addEventListener('click', function (e) {
        var link = e.target.closest('a');
        if (!link) return;
        var href = link.getAttribute('href');
        if (!href || href.indexOf('#') === 0 || href.indexOf('javascript:') === 0) return;
        if (isProtected(href)) {
            e.preventDefault();
            isLoggedIn().then(function (loggedIn) {
                if (!loggedIn) {
                    alert('Please login first to access this page.');
                    window.location.href = 'index.php?url=login';
                } else {
                    window.location.href = href;
                }
            });
        }
    });

    window.api = {
        get: function (endpoint, params) {
            params = params || {};
            var query = new URLSearchParams(params).toString();
            var url = 'index.php?url=' + endpoint + (query ? '&' + query : '');
            return fetch(url).then(function (response) { return response.json(); });
        },
        post: function (endpoint, data) {
            var formData = new FormData();
            for (var key in data) {
                if (data.hasOwnProperty(key)) formData.append(key, data[key]);
            }
            return fetch('index.php?url=' + endpoint, {
                method: 'POST',
                body: formData
            }).then(function (response) { return response.json(); });
        }
    };

    window.startTimer = function (durationSeconds, onTick, onExpire) {
        var timeLeft = durationSeconds;
        var interval = setInterval(function () {
            onTick(timeLeft);
            if (timeLeft <= 0) {
                clearInterval(interval);
                if (onExpire) onExpire();
            }
            timeLeft--;
        }, 1000);
        return interval;
    };

    window.confirmAction = function (message, callback) {
        if (confirm(message)) {
            callback();
        }
    };
})();