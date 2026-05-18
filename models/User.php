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
        $sql = "INSERT INTO users (name, email, password_hash, role, student_id, program, department, bio) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $sql = "INSERT INTO users (name, email, password_hash, student_id, program, role) 
                VALUES (?, ?, ?, ?, ?, 'student')";
        $stmt = $this->query($sql, [
            $data['name'],
            $data['email'],
            $data['password_hash'],
            $data['role'],
            $data['student_id'] ?? null,
            $data['program'] ?? null,
            $data['department'] ?? null,
            $data['bio'] ?? null
        ]);
        return $this->db->insert_id;
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

    public function updateProfileInstructor($id, $name, $phone, $department, $bio, $pic = null)
    {
        if ($pic) {
            $this->query(
                "UPDATE users SET name=?, phone=?, department=?, bio=?, profile_pic=? WHERE id=?",
                [$name, $phone, $department, $bio, $pic, $id]
            );
        } else {
            $this->query(
                "UPDATE users SET name=?, phone=?, department=?, bio=? WHERE id=?",
                [$name, $phone, $department, $bio, $id]
            );
        }
    }

    public function updateProfileTA($id, $name, $phone, $department, $pic = null)
    {
        if ($pic) {
            $this->query(
                "UPDATE users SET name=?, phone=?, department=?, profile_pic=? WHERE id=?",
                [$name, $phone, $department, $pic, $id]
            );
        } else {
            $this->query(
                "UPDATE users SET name=?, phone=?, department=? WHERE id=?",
                [$name, $phone, $department, $id]
            );
        }
    }

    public function updateProfileAdmin($id, $name, $phone, $pic = null)
    {
        if ($pic) {
            $this->query(
                "UPDATE users SET name=?, phone=?, profile_pic=? WHERE id=?",
                [$name, $phone, $pic, $id]
            );
        } else {
            $this->query(
                "UPDATE users SET name=?, phone=? WHERE id=?",
                [$name, $phone, $id]
            );
        }
    }

    public function changePassword($id, $hash)
    {
        $this->query("UPDATE users SET password_hash=? WHERE id=?", [$hash, $id]);
    }

    public function updateRoleAndStatus($id, $role, $is_active)
    {
        $this->query("UPDATE users SET role=?, is_active=? WHERE id=?", [$role, $is_active, $id]);
    }

    public function countAll()
    {
        $stmt = $this->query("SELECT COUNT(*) as total FROM users");
        $row = $stmt->get_result()->fetch_assoc();
        return $row['total'] ?? 0;
    }

    public function getAll()
    {
        $stmt = $this->query("SELECT * FROM users ORDER BY created_at DESC");
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
