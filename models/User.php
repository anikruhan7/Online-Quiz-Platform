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

    public function getAll($search = '')
    {
        if (!empty($search)) {
            $searchParam = "%$search%";
            $stmt = $this->query(
                "SELECT * FROM users WHERE name LIKE ? OR email LIKE ? ORDER BY created_at DESC",
                [$searchParam, $searchParam],
                'ss'
            );
        } else {
            $stmt = $this->query("SELECT * FROM users ORDER BY created_at DESC");
        }
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function countByRole($role)
    {
        $stmt = $this->query("SELECT COUNT(*) as total FROM users WHERE role = ?", [$role]);
        return $stmt->get_result()->fetch_assoc()['total'] ?? 0;
    }

    public function countPendingInstructors()
    {
        $stmt = $this->query("SELECT COUNT(*) as total FROM users WHERE role = 'instructor' AND is_active = 0");
        return $stmt->get_result()->fetch_assoc()['total'] ?? 0;
    }

    public function getInstructors()
    {
        $stmt = $this->query("SELECT id, name FROM users WHERE role = 'instructor' ORDER BY name");
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAtRiskStudentsForTA($ta_id)
    {
        $sql = "SELECT u.id, u.name, u.email, AVG(a.score / q.total_marks * 100) as avg_percent
                FROM users u
                JOIN attempts a ON u.id = a.student_id
                JOIN quizzes q ON a.quiz_id = q.id
                JOIN courses c ON q.course_id = c.id
                JOIN course_tas ct ON c.id = ct.course_id
                WHERE ct.ta_id = ? AND a.is_graded = 1
                GROUP BY u.id
                HAVING avg_percent < 50";
        $stmt = $this->query($sql, [$ta_id]);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
