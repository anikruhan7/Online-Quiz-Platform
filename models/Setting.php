<?php
class Setting extends Model
{
    protected $table = 'settings';

    public function getAll()
    {
        $stmt = $this->query("SELECT * FROM settings");
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }

    public function set($key, $value)
    {
        $this->query("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) 
                      ON DUPLICATE KEY UPDATE setting_value = ?", [$key, $value, $value]);
    }
}
