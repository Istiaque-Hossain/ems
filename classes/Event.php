<?php
class Event
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($name, $description, $start_date, $end_date, $max_capacity, $created_by)
    {
        $stmt = mysqli_prepare($this->db, "INSERT INTO events (name, description, start_date, end_date, max_capacity, created_by) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssii", $name, $description, $start_date, $end_date, $max_capacity, $created_by);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    public function getAll()
    {
        $result = mysqli_query($this->db, "SELECT * FROM events ORDER BY start_date DESC");
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
