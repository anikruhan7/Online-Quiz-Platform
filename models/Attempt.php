<?php
class Attempt extends Model
{
    protected $table = 'attempts';

    public function startAttempt($quiz_id, $student_id)
    {
        $now = date('Y-m-d H:i:s');
        $this->query(
            "INSERT INTO attempts (quiz_id, student_id, started_at) VALUES (?, ?, ?)",
            [$quiz_id, $student_id, $now]
        );
        return $this->db->insert_id;
    }

    public function saveAnswer($attempt_id, $question_id, $option_id)
    {
        $this->query(
            "INSERT INTO answers (attempt_id, question_id, selected_option_id) VALUES (?, ?, ?)",
            [$attempt_id, $question_id, $option_id]
        );
    }

    public function completeAttempt($attempt_id, $score, $is_graded)
    {
        $now = date('Y-m-d H:i:s');
        $this->query(
            "UPDATE attempts SET score=?, completed_at=?, is_graded=? WHERE id=?",
            [$score, $now, $is_graded, $attempt_id]
        );
    }

    public function getStudentAttempts($student_id)
    {
        $sql = "SELECT a.*, q.title as quiz_title, q.pass_mark, q.quiz_type, c.title as course_title 
                FROM attempts a 
                JOIN quizzes q ON a.quiz_id = q.id 
                JOIN courses c ON q.course_id = c.id 
                WHERE a.student_id = ? 
                ORDER BY a.completed_at DESC";
        $stmt = $this->query($sql, [$student_id]);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getLeaderboard($quiz_id, $limit = 10)
    {
        $sql = "SELECT u.name, a.score 
                FROM attempts a 
                JOIN users u ON a.student_id = u.id 
                WHERE a.quiz_id = ? AND a.is_graded = 1 AND a.completed_at IS NOT NULL 
                ORDER BY a.score DESC 
                LIMIT ?";
        $stmt = $this->query($sql, [$quiz_id, $limit], 'ii');
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
<<<<<<< HEAD

    public function countAll()
    {
        $stmt = $this->query("SELECT COUNT(*) as total FROM attempts");
        $row = $stmt->get_result()->fetch_assoc();
        return $row['total'] ?? 0;
    }
=======
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
}
