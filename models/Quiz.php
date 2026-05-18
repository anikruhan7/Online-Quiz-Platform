<?php
class Quiz extends Model
{
    protected $table = 'quizzes';

    public function getPublishedQuizzesForCourse($course_id)
    {
        $stmt = $this->query("SELECT * FROM quizzes WHERE course_id = ? AND status = 'published' 
                AND (available_from IS NULL OR available_from <= NOW()) 
                AND (available_until IS NULL OR available_until >= NOW())", [$course_id]);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getQuizWithQuestions($quiz_id)
    {
        $quiz = $this->find($quiz_id);
        if (!$quiz) return null;
        $stmt = $this->query("SELECT * FROM questions WHERE quiz_id = ? ORDER BY order_index", [$quiz_id]);
        $questions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach ($questions as &$q) {
            $stmt2 = $this->query("SELECT * FROM options WHERE question_id = ?", [$q['id']]);
            $q['options'] = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        $quiz['questions'] = $questions;
        return $quiz;
    }

    public function createQuiz($data)
    {
        $sql = "INSERT INTO quizzes (course_id, created_by, title, description, 
                time_limit_minutes, total_marks, pass_mark, quiz_type, status, 
                available_from, available_until) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->query($sql, [
            $data['course_id'],
            $data['created_by'],
            $data['title'],
            $data['description'],
            $data['time_limit_minutes'],
            $data['total_marks'],
            $data['pass_mark'],
            $data['quiz_type'],
            $data['status'],
            $data['available_from'],
            $data['available_until']
        ]);
        return $this->db->insert_id;
    }

    public function getAllFiltered($courseId = null, $status = '', $type = '')
    {
        $sql = "SELECT q.*, c.title as course_title, u.name as created_by_name
                FROM quizzes q
                JOIN courses c ON q.course_id = c.id
                JOIN users u ON q.created_by = u.id";
        $params = [];
        $types = '';
        $conditions = [];
        if ($courseId) {
            $conditions[] = "q.course_id = ?";
            $params[] = $courseId;
            $types .= 'i';
        }
        if (!empty($status)) {
            $conditions[] = "q.status = ?";
            $params[] = $status;
            $types .= 's';
        }
        if (!empty($type)) {
            $conditions[] = "q.quiz_type = ?";
            $params[] = $type;
            $types .= 's';
        }
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        $sql .= " ORDER BY q.created_at DESC";
        $stmt = $this->query($sql, $params, $types);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
