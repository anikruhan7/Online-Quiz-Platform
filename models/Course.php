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

    public function getCoursesByInstructor($instructor_id)
    {
        $stmt = $this->query("SELECT * FROM courses WHERE instructor_id = ? ORDER BY created_at DESC", [$instructor_id]);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function createCourse($data)
    {
        $sql = "INSERT INTO courses (instructor_id, subject_id, title, description, enrollment_type, max_students, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->query($sql, [
            $data['instructor_id'],
            $data['subject_id'],
            $data['title'],
            $data['description'],
            $data['enrollment_type'],
            $data['max_students'],
            $data['status']
        ]);
        return $this->db->insert_id;
    }

    public function getCoursesForTA($ta_id)
    {
        $sql = "SELECT c.* FROM courses c
                JOIN course_tas ct ON c.id = ct.course_id
                WHERE ct.ta_id = ?";
        $stmt = $this->query($sql, [$ta_id]);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function countAll()
    {
        $stmt = $this->query("SELECT COUNT(*) as total FROM courses");
        $row = $stmt->get_result()->fetch_assoc();
        return $row['total'] ?? 0;
    }
    // Other existing methods (find, getAll, etc.) are inherited from Model
}
