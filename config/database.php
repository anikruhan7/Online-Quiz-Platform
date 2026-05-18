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
<<<<<<< HEAD
        if ($this->conn->connect_error) die("Connection failed: " . $this->conn->connect_error);
=======
        if ($this->conn->connect_error) die("DB connection failed: " . $this->conn->connect_error);
>>>>>>> 22feb9917b75bd316a893fbaa97bfdb8d2e49a84
        return $this->conn;
    }
}
