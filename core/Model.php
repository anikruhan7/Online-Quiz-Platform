<?php
require_once 'config/database.php';
<<<<<<< HEAD

=======
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
class Model
{
    protected $db;
    protected $table;
<<<<<<< HEAD

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    protected function query($sql, $params = [], $types = "")
    {
        $stmt = $this->db->prepare($sql);
        if (!$stmt) die("Prepare failed: " . $this->db->error);
        if (!empty($params)) {
=======
    public function __construct()
    {
        $dbObj = new Database();
        $this->db = $dbObj->getConnection();
    }
    protected function query($sql, $params = [], $types = "")
    {
        $stmt = $this->db->prepare($sql);
        if (!$stmt) die("Prepare error: " . $this->db->error);
        if ($params) {
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
            if (empty($types)) $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt;
    }
<<<<<<< HEAD

=======
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
    public function find($id)
    {
        $stmt = $this->query("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
        return $stmt->get_result()->fetch_assoc();
    }
<<<<<<< HEAD

    public function getAll()
    {
        $stmt = $this->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
=======
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
}
