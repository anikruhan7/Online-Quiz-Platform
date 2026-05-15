<?php
require_once 'config/database.php';
class Model
{
    protected $db;
    protected $table;
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
            if (empty($types)) $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt;
    }
    public function find($id)
    {
        $stmt = $this->query("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
        return $stmt->get_result()->fetch_assoc();
    }
}
