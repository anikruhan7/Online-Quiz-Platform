<?php
class QaQuestion extends Model
{
    protected $table = 'qa_questions';

    public function getForCourse($course_id)
    {
        $sql = "SELECT q.*, u.name as student_name,
                (SELECT COUNT(*) FROM qa_answers WHERE qa_question_id = q.id) as answer_count
                FROM qa_questions q
                JOIN users u ON q.student_id = u.id
                WHERE q.course_id = ?
                ORDER BY q.created_at DESC";
        $stmt = $this->query($sql, [$course_id]);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function create($course_id, $student_id, $title, $body)
    {
        $this->query(
            "INSERT INTO qa_questions (course_id, student_id, title, body) VALUES (?, ?, ?, ?)",
            [$course_id, $student_id, $title, $body]
        );
    }

    public function resolve($id, $student_id)
    {
<<<<<<< HEAD
=======
        // Only the question owner can resolve
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
        $this->query(
            "UPDATE qa_questions SET is_resolved = 1 WHERE id = ? AND student_id = ?",
            [$id, $student_id]
        );
    }
}
