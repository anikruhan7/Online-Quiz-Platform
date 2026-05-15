<?php
class User extends Model
{
    protected $table = 'users';

    public function findByEmail($email)
    {
        $stmt = $this->query("SELECT * FROM users WHERE email = ?", [$email]);
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data)
    {
        $sql = "INSERT INTO users (name, email, password_hash, student_id, program, role) 
                VALUES (?, ?, ?, ?, ?, 'student')";
        $stmt = $this->query($sql, [
            $data['name'],
            $data['email'],
            $data['password_hash'],
            $data['student_id'] ?? '',
            $data['program'] ?? ''
        ]);
        if ($stmt && $this->db->insert_id) {
            return $this->db->insert_id;
        }
        return false;
    }

    public function updateProfile($id, $name, $phone, $program, $pic = null)
    {
        if ($pic) {
            $this->query(
                "UPDATE users SET name=?, phone=?, program=?, profile_pic=? WHERE id=?",
                [$name, $phone, $program, $pic, $id]
            );
        } else {
            $this->query(
                "UPDATE users SET name=?, phone=?, program=? WHERE id=?",
                [$name, $phone, $program, $id]
            );
        }
    }

    public function changePassword($id, $hash)
    {
        $this->query("UPDATE users SET password_hash=? WHERE id=?", [$hash, $id]);
    }
}
