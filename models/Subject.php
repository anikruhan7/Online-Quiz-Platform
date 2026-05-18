<?php
class Subject extends Model
{
    protected $table = 'subjects';

    public function getAll()
    {
        $stmt = $this->query("SELECT * FROM subjects ORDER BY name");
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
