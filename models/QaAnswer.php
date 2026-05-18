<?php
class QaAnswer extends Model
{
    protected $table = 'qa_answers';

    public function getForQuestion($question_id)
    {
        $stmt = $this->query("SELECT a.*, u.name as author_name, u.role 
                              FROM qa_answers a 
                              JOIN users u ON a.author_id = u.id 
                              WHERE a.qa_question_id = ? 
                              ORDER BY a.created_at", [$question_id]);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
