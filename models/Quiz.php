<?php
class Quiz extends Model
{
    protected $table = 'quizzes';

    public function getPublishedQuizzesForCourse($course_id)
    {
        $sql = "SELECT * FROM quizzes WHERE course_id = ? AND status = 'published' 
                AND (available_from IS NULL OR available_from <= NOW()) 
                AND (available_until IS NULL OR available_until >= NOW())";
        $stmt = $this->query($sql, [$course_id]);
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
}
