<?php
class Subject extends Model
{
    protected $table = 'subjects';

    public function getAll()
    {
        $stmt = $this->query("SELECT * FROM subjects ORDER BY name");
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function add($name, $description)
    {
        $this->query("INSERT INTO subjects (name, description) VALUES (?, ?)", [$name, $description]);
    }

    public function update($id, $name, $description)
    {
        $this->query(
            "UPDATE subjects SET name = ?, description = ? WHERE id = ?",
            [$name, $description, $id]
        );
    }

    public function delete($id)
    {
        $this->query("DELETE FROM subjects WHERE id = ?", [$id]);
    }
}
