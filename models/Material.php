<?php
class Material extends Model
{
    protected $table = 'course_materials';

    public function getForCourse($course_id)
    {
        $stmt = $this->query("SELECT * FROM course_materials WHERE course_id = ? ORDER BY created_at DESC", [$course_id]);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
