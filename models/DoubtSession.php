<?php
class DoubtSession extends Model
{
    protected $table = 'doubt_sessions';

    public function getUpcomingForStudent($student_id)
    {
        $sql = "SELECT ds.*, c.title as course_title, u.name as ta_name
                FROM doubt_sessions ds
                JOIN courses c ON ds.course_id = c.id
                JOIN users u ON ds.ta_id = u.id
                WHERE ds.scheduled_at > NOW()
                ORDER BY ds.scheduled_at";
        $stmt = $this->query($sql);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getSessionsByTA($ta_id)
    {
        $stmt = $this->query("SELECT * FROM doubt_sessions WHERE ta_id = ? ORDER BY scheduled_at DESC", [$ta_id]);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function createSession($course_id, $ta_id, $title, $scheduled_at, $duration, $location, $max_attendees)
    {
        $this->query(
            "INSERT INTO doubt_sessions (course_id, ta_id, title, scheduled_at, duration_minutes, location_or_link, max_attendees) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)",
            [$course_id, $ta_id, $title, $scheduled_at, $duration, $location, $max_attendees]
        );
    }
}

class DoubtSessionBooking extends Model
{
    protected $table = 'doubt_session_bookings';

    public function book($session_id, $student_id)
    {
        $this->query(
            "INSERT INTO doubt_session_bookings (doubt_session_id, student_id) VALUES (?, ?)",
            [$session_id, $student_id]
        );
    }

    public function getBookings($student_id)
    {
        $stmt = $this->query("SELECT ds.*, c.title as course_title 
                              FROM doubt_session_bookings b
                              JOIN doubt_sessions ds ON b.doubt_session_id = ds.id
                              JOIN courses c ON ds.course_id = c.id
                              WHERE b.student_id = ? AND ds.scheduled_at > NOW()", [$student_id]);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
