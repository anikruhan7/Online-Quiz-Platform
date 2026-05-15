// Main JavaScript file for Quiz Platform
// You can add global functions here

// Example: confirm before dropping a course
document.addEventListener('DOMContentLoaded', function () {
    const dropButtons = document.querySelectorAll('form[action="/quizplatform/student/drop-course"] button');
    dropButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            if (!confirm('Are you sure you want to drop this course?')) {
                e.preventDefault();
            }
        });
    });
});