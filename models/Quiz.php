<?php
<<<<<<< HEAD
=======

/**
 * Quiz Model - Handles quizzes, questions, and options
 */
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
class Quiz extends Model
{
    protected $table = 'quizzes';

<<<<<<< HEAD
    public function getPublishedQuizzesForCourse($course_id)
    {
        $sql = "SELECT * FROM quizzes WHERE course_id = ? AND status = 'published' 
                AND (available_from IS NULL OR available_from <= NOW()) 
                AND (available_until IS NULL OR available_until >= NOW())";
=======
    /**
     * Get all published quizzes for a specific course
     */
    public function getPublishedQuizzesForCourse($course_id)
    {
        $sql = "SELECT * FROM quizzes 
                WHERE course_id = ? AND status = 'published' 
                AND (available_from IS NULL OR available_from <= NOW()) 
                AND (available_until IS NULL OR available_until >= NOW())
                ORDER BY available_from ASC";
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
        $stmt = $this->query($sql, [$course_id]);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

<<<<<<< HEAD
=======
    /**
     * Get a quiz with all its questions and options (for taking quiz)
     */
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
    public function getQuizWithQuestions($quiz_id)
    {
        $quiz = $this->find($quiz_id);
        if (!$quiz) return null;
<<<<<<< HEAD
        $stmt = $this->query("SELECT * FROM questions WHERE quiz_id = ? ORDER BY order_index", [$quiz_id]);
        $questions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach ($questions as &$q) {
            $stmt2 = $this->query("SELECT * FROM options WHERE question_id = ?", [$q['id']]);
            $q['options'] = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);
        }
=======

        // Get questions
        $stmt = $this->query(
            "SELECT * FROM questions WHERE quiz_id = ? ORDER BY order_index",
            [$quiz_id]
        );
        $questions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        // For each question, fetch its options
        foreach ($questions as &$q) {
            $stmt2 = $this->query(
                "SELECT * FROM options WHERE question_id = ? ORDER BY id",
                [$q['id']]
            );
            $q['options'] = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);
        }

>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
        $quiz['questions'] = $questions;
        return $quiz;
    }

<<<<<<< HEAD
=======
    /**
     * Get all quizzes created by an instructor
     */
    public function getQuizzesByInstructor($instructor_id)
    {
        $sql = "SELECT q.*, c.title as course_title 
                FROM quizzes q
                JOIN courses c ON q.course_id = c.id
                WHERE q.created_by = ?
                ORDER BY q.created_at DESC";
        $stmt = $this->query($sql, [$instructor_id]);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Create a new quiz
     */
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
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
<<<<<<< HEAD
=======

    /**
     * Update quiz status (draft/published)
     */
    public function updateStatus($quiz_id, $status)
    {
        return $this->query(
            "UPDATE quizzes SET status = ? WHERE id = ?",
            [$status, $quiz_id]
        );
    }
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
}
