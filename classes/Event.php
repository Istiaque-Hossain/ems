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

    public function getAll($page = 1, $itemsPerPage = 10)
    {
        $offset    = ($page - 1) * $itemsPerPage;
        $user_id   = $_SESSION['user_id'];
        $user_role = $_SESSION['user_role'];

        if ($user_role == 'admin')
        {
            $stmt = mysqli_prepare($this->db, "SELECT * FROM events ORDER BY date DESC LIMIT ? OFFSET ?");
            mysqli_stmt_bind_param($stmt, "ii", $itemsPerPage, $offset);
        }
        else
        {
            $stmt = mysqli_prepare($this->db, "SELECT * FROM events WHERE created_by = ? ORDER BY date DESC LIMIT ? OFFSET ?");
            mysqli_stmt_bind_param($stmt, "iii", $user_id, $itemsPerPage, $offset);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getTotalCount()
    {
        $user_id = $_SESSION['user_id'];
        $user_role = $_SESSION['user_role'];

        if ($user_role == 'admin')
        {
            $query = "SELECT COUNT(*) as total FROM events";
            $stmt = mysqli_prepare($this->db, $query);
        }
        else
        {
            $query = "SELECT COUNT(*) as total FROM events WHERE created_by = ?";
            $stmt = mysqli_prepare($this->db, $query);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        return $row['total'];
    }

    public function search($query)
    {
        $user_id   = $_SESSION['user_id'];
        $user_role = $_SESSION['user_role'];

        if ($user_role == 'admin')
        {
            $stmt = mysqli_prepare($this->db, "SELECT * FROM events WHERE (name LIKE ? OR description LIKE ?) ORDER BY date DESC ");
            $searchQuery = "%" . $query . "%";
            mysqli_stmt_bind_param($stmt, "ss", $searchQuery, $searchQuery);
        }
        else
        {
            $stmt = mysqli_prepare($this->db, "SELECT * FROM events WHERE (name LIKE ? OR description LIKE ?) AND created_by = ? ORDER BY date DESC ");
            $searchQuery = "%" . $query . "%";
            mysqli_stmt_bind_param($stmt, "ssi", $searchQuery, $searchQuery, $user_id);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getRegEvent()
    {

        $stmt = mysqli_prepare($this->db, "SELECT * FROM events ORDER BY date DESC");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function regEvent($event_id, $name, $email)
    {
        try
        {
            $stmt = mysqli_prepare($this->db, "SELECT id FROM events WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $event_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 0)
            {
                mysqli_stmt_close($stmt);
                throw new Exception("The event ID does not exist.");
            }

            mysqli_stmt_close($stmt);

            $stmt = mysqli_prepare($this->db, "INSERT INTO attendees (event_id, name, email) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "iss", $event_id, $name, $email);

            if (mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_close($stmt);
                return '<div class="row w-100 justify-content-center">
                        <div class="col-md-12">
                            <div class="alert alert-success"> Registration successful! </div>
                        </div>
                    </div>';
            }
            else
            {
                if (mysqli_errno($this->db) == 1062)
                {
                    throw new Exception("This email is already registered for the event.");
                }
                else
                {
                    throw new Exception("An error occurred during registration.");
                }
            }
        }
        catch (Exception $e)
        {
            return '<div class="row w-100 justify-content-center">
                    <div class="col-md-12">
                        <div class="alert alert-danger"> ' . htmlspecialchars($e->getMessage()) . ' </div>
                    </div>
                </div>';
        }
    }

    public function downloadCSV($event_id)
    {
        try
        {
            $stmt = mysqli_prepare($this->db, "SELECT name, email FROM attendees WHERE event_id = ?");
            mysqli_stmt_bind_param($stmt, "i", $event_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $stmt = mysqli_prepare($this->db, "SELECT name FROM events WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $event_id);
            mysqli_stmt_execute($stmt);
            $result2 = mysqli_stmt_get_result($stmt);

            $event = mysqli_fetch_assoc($result2);
            $eventName = $event['name'];


            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $eventName . '_attendees.csv"');

            $output = fopen('php://output', 'w');

            fputcsv($output, ['Name', 'Email']);

            while ($row = mysqli_fetch_assoc($result))
            {
                fputcsv($output, $row);
            }

            fclose($output);
            mysqli_stmt_close($stmt);

            exit();
        }
        catch (Exception $e)
        {
            return '<div class="row w-100 justify-content-center">
                <div class="col-md-12">
                    <div class="alert alert-danger"> ' . htmlspecialchars($e->getMessage()) . ' </div>
                </div>
            </div>';
        }
    }
}
