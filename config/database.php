<?php
class Database
{
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'quizplatform';
    private $conn;

    public function getConnection()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->conn->connect_error) die("DB connection failed: " . $this->conn->connect_error);
        return $this->conn;
    }
}
