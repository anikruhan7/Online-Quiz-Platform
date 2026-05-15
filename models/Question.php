<?php
class Question extends Model
{
    protected $table = 'questions';

    public function isOptionCorrect($option_id)
    {
        $stmt = $this->query("SELECT is_correct FROM options WHERE id = ?", [$option_id]);
        $row = $stmt->get_result()->fetch_assoc();
        return $row ? (bool)$row['is_correct'] : false;
    }

    public function getMarks($question_id)
    {
        $stmt = $this->query("SELECT marks FROM questions WHERE id = ?", [$question_id]);
        $row = $stmt->get_result()->fetch_assoc();
        return $row ? (int)$row['marks'] : 0;
    }
}
