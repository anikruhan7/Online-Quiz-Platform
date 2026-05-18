<?php
class Enrollment extends Model
{
    protected $table = 'enrollments';

    public function isEnrolled($student_id, $course_id)
    {
        $stmt = $this->query(
            "SELECT id FROM enrollments WHERE student_id = ? AND course_id = ? AND status != 'dropped'",
            [$student_id, $course_id]
        );
        return $stmt->get_result()->num_rows > 0;
    }

    public function enrollDirect($student_id, $course_id)
    {
        return $this->query(
            "INSERT INTO enrollments (student_id, course_id, status) VALUES (?, ?, 'active')",
            [$student_id, $course_id]
        );
    }

    public function requestApproval($student_id, $course_id)
    {
        return $this->query(
            "INSERT INTO enrollments (student_id, course_id, status) VALUES (?, ?, 'pending')",
            [$student_id, $course_id]
        );
    }

    public function getEnrolledCourses($student_id)
    {
        $sql = "SELECT c.*, u.name as instructor_name 
                FROM enrollments e
                JOIN courses c ON e.course_id = c.id
                JOIN users u ON c.instructor_id = u.id
                WHERE e.student_id = ? AND e.status = 'active'";
        $stmt = $this->query($sql, [$student_id]);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function dropCourse($student_id, $course_id)
    {
        $stmt = $this->query(
            "SELECT id FROM attempts a JOIN quizzes q ON a.quiz_id = q.id 
                              WHERE a.student_id = ? AND q.course_id = ? AND q.quiz_type = 'graded' AND a.completed_at IS NOT NULL",
            [$student_id, $course_id]
        );
        if ($stmt->get_result()->num_rows > 0) return false;
        $this->query("UPDATE enrollments SET status = 'dropped' WHERE student_id = ? AND course_id = ?", [$student_id, $course_id]);
        return true;
    }
}
