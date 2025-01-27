<?php
session_start();
class Event
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($name, $description, $date, $time, $max_capacity)
    {
        $stmt = mysqli_prepare($this->db, "INSERT INTO events (name, description, date, time, max_capacity, created_by) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssii", $name, $description, $date, $time, $max_capacity, $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    public function update($name, $description, $date, $time, $max_capacity, $id)
    {
        $stmt = mysqli_prepare($this->db, "UPDATE events SET name = ? , description = ? , date = ? , time = ? , max_capacity = ?   WHERE id = ? AND created_by = ?");
        mysqli_stmt_bind_param($stmt, "ssssiii", $name, $description, $date, $time, $max_capacity, $id, $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    public function getAll()
    {
        $user_id = $_SESSION['user_id'];
        $user_role = $_SESSION['user_role']; // Assuming the role is stored in the session (e.g., 'admin' or 'user')

        if ($user_role == 'admin')
        {
            $stmt = mysqli_prepare($this->db, "SELECT * FROM events WHERE ORDER BY date DESC");
            mysqli_stmt_bind_param($stmt, "i", $user_id); // Bind the user ID parameter
            mysqli_stmt_execute($stmt); // Execute the query
            $result = mysqli_stmt_get_result($stmt); // Get the result
        }
        else
        {
            $stmt = mysqli_prepare($this->db, "SELECT * FROM events WHERE created_by = ? ORDER BY date DESC");
            mysqli_stmt_bind_param($stmt, "i", $user_id); // Bind the user ID parameter
            mysqli_stmt_execute($stmt); // Execute the query
            $result = mysqli_stmt_get_result($stmt); // Get the result
        }

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
