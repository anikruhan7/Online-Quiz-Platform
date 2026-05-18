DROP DATABASE IF EXISTS quizplatform;
CREATE DATABASE quizplatform;
USE quizplatform;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('student','instructor','ta','admin') NOT NULL,
    profile_pic VARCHAR(255) DEFAULT 'default.png',
    student_id VARCHAR(50) NULL,
    program VARCHAR(100) NULL,
    department VARCHAR(100) NULL,
    bio TEXT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE subjects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    instructor_id INT NOT NULL,
    subject_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    enrollment_type ENUM('open','approval') DEFAULT 'open',
    max_students INT DEFAULT 100,
    status ENUM('draft','active','archived') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE courses ADD FOREIGN KEY (instructor_id) REFERENCES users(id);
ALTER TABLE courses ADD FOREIGN KEY (subject_id) REFERENCES subjects(id);

CREATE TABLE course_tas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    ta_id INT NOT NULL,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE course_tas ADD FOREIGN KEY (course_id) REFERENCES courses(id);
ALTER TABLE course_tas ADD FOREIGN KEY (ta_id) REFERENCES users(id);

CREATE TABLE enrollments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    status ENUM('pending','active','dropped') DEFAULT 'pending',
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE enrollments ADD FOREIGN KEY (student_id) REFERENCES users(id);
ALTER TABLE enrollments ADD FOREIGN KEY (course_id) REFERENCES courses(id);

CREATE TABLE quizzes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    created_by INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    time_limit_minutes INT DEFAULT 30,
    total_marks INT,
    pass_mark INT,
    quiz_type ENUM('graded','practice') DEFAULT 'graded',
    status ENUM('draft','published') DEFAULT 'draft',
    available_from DATETIME,
    available_until DATETIME
);

ALTER TABLE quizzes ADD FOREIGN KEY (course_id) REFERENCES courses(id);
ALTER TABLE quizzes ADD FOREIGN KEY (created_by) REFERENCES users(id);

CREATE TABLE questions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    quiz_id INT NOT NULL,
    question_text TEXT NOT NULL,
    marks INT DEFAULT 1,
    order_index INT,
    created_by INT
);

ALTER TABLE questions ADD FOREIGN KEY (quiz_id) REFERENCES quizzes(id);
ALTER TABLE questions ADD FOREIGN KEY (created_by) REFERENCES users(id);

CREATE TABLE options (
    id INT PRIMARY KEY AUTO_INCREMENT,
    question_id INT NOT NULL,
    option_text VARCHAR(500) NOT NULL,
    is_correct BOOLEAN DEFAULT FALSE
);

ALTER TABLE options ADD FOREIGN KEY (question_id) REFERENCES questions(id);

CREATE TABLE attempts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    quiz_id INT NOT NULL,
    student_id INT NOT NULL,
    score INT,
    started_at DATETIME,
    completed_at DATETIME,
    is_graded BOOLEAN DEFAULT FALSE
);

ALTER TABLE attempts ADD FOREIGN KEY (quiz_id) REFERENCES quizzes(id);
ALTER TABLE attempts ADD FOREIGN KEY (student_id) REFERENCES users(id);

CREATE TABLE answers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    attempt_id INT NOT NULL,
    question_id INT NOT NULL,
    selected_option_id INT
);

ALTER TABLE answers ADD FOREIGN KEY (attempt_id) REFERENCES attempts(id);
ALTER TABLE answers ADD FOREIGN KEY (question_id) REFERENCES questions(id);
ALTER TABLE answers ADD FOREIGN KEY (selected_option_id) REFERENCES options(id);

CREATE TABLE course_materials (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    uploaded_by INT NOT NULL,
    title VARCHAR(200),
    file_path VARCHAR(500),
    material_type ENUM('document','link','video'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE course_materials ADD FOREIGN KEY (course_id) REFERENCES courses(id);
ALTER TABLE course_materials ADD FOREIGN KEY (uploaded_by) REFERENCES users(id);

CREATE TABLE announcements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    author_id INT NOT NULL,
    title VARCHAR(200),
    body TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE announcements ADD FOREIGN KEY (course_id) REFERENCES courses(id);
ALTER TABLE announcements ADD FOREIGN KEY (author_id) REFERENCES users(id);

CREATE TABLE qa_questions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    student_id INT NOT NULL,
    title VARCHAR(200),
    body TEXT,
    is_resolved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE qa_questions ADD FOREIGN KEY (course_id) REFERENCES courses(id);
ALTER TABLE qa_questions ADD FOREIGN KEY (student_id) REFERENCES users(id);

CREATE TABLE qa_answers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    qa_question_id INT NOT NULL,
    author_id INT NOT NULL,
    body TEXT,
    is_endorsed BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE qa_answers ADD FOREIGN KEY (qa_question_id) REFERENCES qa_questions(id);
ALTER TABLE qa_answers ADD FOREIGN KEY (author_id) REFERENCES users(id);

CREATE TABLE doubt_sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    ta_id INT NOT NULL,
    title VARCHAR(200),
    scheduled_at DATETIME,
    duration_minutes INT,
    location_or_link VARCHAR(255),
    max_attendees INT
);

ALTER TABLE doubt_sessions ADD FOREIGN KEY (course_id) REFERENCES courses(id);
ALTER TABLE doubt_sessions ADD FOREIGN KEY (ta_id) REFERENCES users(id);

CREATE TABLE doubt_session_bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    doubt_session_id INT NOT NULL,
    student_id INT NOT NULL,
    booked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE doubt_session_bookings ADD FOREIGN KEY (doubt_session_id) REFERENCES doubt_sessions(id);
ALTER TABLE doubt_session_bookings ADD FOREIGN KEY (student_id) REFERENCES users(id);

CREATE TABLE settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT
);

INSERT INTO users (name, email, password_hash, role, is_active) VALUES 
('ANIK RUHAN', 'anik@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1),
('Prof. John Smith', 'instructor@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'instructor', 1),
('Jane TA', 'ta@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ta', 1);

INSERT INTO subjects (name, description) VALUES 
('Computer Science', 'Programming, web development, databases'),
('Mathematics', 'Algebra, calculus, statistics'),
('English', 'Grammar, literature, writing skills');

INSERT INTO courses (instructor_id, subject_id, title, description, enrollment_type, status) VALUES 
(2, 1, 'Web Development with PHP', 'Learn PHP, MySQL, MVC, AJAX', 'open', 'active'),
(2, 1, 'JavaScript Fundamentals', 'Master JS, DOM, and ES6', 'open', 'active'),
(2, 1, 'Data Science', 'Learn data analysis, visualization, and machine learning basics', 'open', 'active'),
(2, 1, 'Machine Learning', 'Supervised and unsupervised learning, neural networks', 'open', 'active'),
(2, 1, 'Cyber Security', 'Network security, cryptography, ethical hacking', 'open', 'active');

INSERT INTO course_tas (course_id, ta_id) VALUES (1,3), (2,3), (3,3), (4,3), (5,3);

INSERT INTO quizzes (course_id, created_by, title, description, time_limit_minutes, total_marks, pass_mark, quiz_type, status, available_from, available_until) VALUES 
(1, 2, 'PHP Basics Quiz', 'Test your PHP knowledge', 30, 20, 10, 'graded', 'published', NOW(), DATE_ADD(NOW(), INTERVAL 90 DAY));

INSERT INTO questions (quiz_id, question_text, marks, order_index, created_by) VALUES 
(1, 'What does PHP stand for?', 2, 1, 2),
(1, 'Which symbol is used for a variable in PHP?', 2, 2, 2),
(1, 'What function starts a session in PHP?', 2, 3, 2),
(1, 'Which superglobal is used for POST data?', 2, 4, 2),
(1, 'What does SQL stand for?', 2, 5, 2);

SET @q1 = (SELECT id FROM questions WHERE order_index=1);
INSERT INTO options (question_id, option_text, is_correct) VALUES 
(@q1, 'Personal Home Page', 0), (@q1, 'PHP: Hypertext Preprocessor', 1), (@q1, 'Preprocessed Hypertext Page', 0), (@q1, 'Private Hosting Protocol', 0);

SET @q2 = (SELECT id FROM questions WHERE order_index=2);
INSERT INTO options (question_id, option_text, is_correct) VALUES 
(@q2, '!', 0), (@q2, '#', 0), (@q2, '$', 1), (@q2, '&', 0);

SET @q3 = (SELECT id FROM questions WHERE order_index=3);
INSERT INTO options (question_id, option_text, is_correct) VALUES 
(@q3, 'session_start()', 1), (@q3, 'start_session()', 0), (@q3, 'begin_session()', 0), (@q3, 'init_session()', 0);

SET @q4 = (SELECT id FROM questions WHERE order_index=4);
INSERT INTO options (question_id, option_text, is_correct) VALUES 
(@q4, '$_GET', 0), (@q4, '$_POST', 1), (@q4, '$_REQUEST', 0), (@q4, '$_SERVER', 0);

SET @q5 = (SELECT id FROM questions WHERE order_index=5);
INSERT INTO options (question_id, option_text, is_correct) VALUES 
(@q5, 'Structured Query Language', 1), (@q5, 'Simple Query Language', 0), (@q5, 'Standard Query Language', 0), (@q5, 'Style Query Language', 0);

INSERT INTO settings (setting_key, setting_value) VALUES 
('max_quiz_duration', '60'),
('default_max_students', '100');