<?php
class Announcement extends Model
{
    protected $table = 'announcements';

    public function getForCourse($course_id)
    {
        $stmt = $this->query("SELECT a.*, u.name as author_name 
                              FROM announcements a 
                              JOIN users u ON a.author_id = u.id 
                              WHERE a.course_id = ? 
                              ORDER BY a.created_at DESC", [$course_id]);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
