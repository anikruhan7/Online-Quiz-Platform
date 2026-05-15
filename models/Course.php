<?php
class Course extends Model
{
    protected $table = 'courses';

    public function getActiveCourses($search = '', $subject_id = null)
    {
        $sql = "SELECT c.*, u.name as instructor_name, s.name as subject_name,
                (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id AND status='active') as enrolled_count
                FROM courses c
                JOIN users u ON c.instructor_id = u.id
                JOIN subjects s ON c.subject_id = s.id
                WHERE c.status = 'active'";
        $params = [];
        $types = '';

        if (!empty($search)) {
            $sql .= " AND (c.title LIKE ? OR c.description LIKE ?)";
            $searchParam = "%$search%";
            $params[] = $searchParam;
            $params[] = $searchParam;
            $types .= 'ss';
        }
        if ($subject_id) {
            $sql .= " AND c.subject_id = ?";
            $params[] = $subject_id;
            $types .= 'i';
        }
        $sql .= " ORDER BY c.title";

        $stmt = $this->query($sql, $params, $types);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getCourseDetail($id)
    {
        $stmt = $this->query("SELECT c.*, u.name as instructor_name FROM courses c JOIN users u ON c.instructor_id = u.id WHERE c.id = ?", [$id]);
        return $stmt->get_result()->fetch_assoc();
    }

    public function getTAsForCourse($course_id)
    {
        $stmt = $this->query("SELECT u.id, u.name, u.email FROM course_tas ct JOIN users u ON ct.ta_id = u.id WHERE ct.course_id = ?", [$course_id]);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Other existing methods (find, getAll, etc.) are inherited from Model
}
