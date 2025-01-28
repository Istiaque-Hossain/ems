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

    // public function getAll()
    // {
    //     $user_id = $_SESSION['user_id'];
    //     $user_role = $_SESSION['user_role']; // Assuming the role is stored in the session (e.g., 'admin' or 'user')

    //     if ($user_role == 'admin')
    //     {
    //         $stmt = mysqli_prepare($this->db, "SELECT * FROM events ORDER BY date DESC");
    //         // mysqli_stmt_bind_param($stmt, "i", $user_id); // Bind the user ID parameter
    //         mysqli_stmt_execute($stmt); // Execute the query
    //         $result = mysqli_stmt_get_result($stmt); // Get the result
    //     }
    //     else
    //     {
    //         $stmt = mysqli_prepare($this->db, "SELECT * FROM events WHERE created_by = ? ORDER BY date DESC");
    //         mysqli_stmt_bind_param($stmt, "i", $user_id); // Bind the user ID parameter
    //         mysqli_stmt_execute($stmt); // Execute the query
    //         $result = mysqli_stmt_get_result($stmt); // Get the result
    //     }

    //     return mysqli_fetch_all($result, MYSQLI_ASSOC);
    // }

    public function getAll($page = 1, $itemsPerPage = 10)
    {
        $offset    = ($page - 1) * $itemsPerPage;
        $user_id   = $_SESSION['user_id'];
        $user_role = $_SESSION['user_role'];

        // var_dump($offset);
        // die();

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



        // if ($user_role == 'admin')
        // {
        // }




        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);


        // var_dump($itemsPerPage, $offset, $result, mysqli_fetch_all($result, MYSQLI_ASSOC));
        // die();

        // $query      = "SELECT * FROM events ORDER BY date DESC LIMIT ? OFFSET lal";
        // $finalQuery = str_replace(['?', 'lal'], [$itemsPerPage, $offset], $query);
        // var_dump(mysqli_fetch_all($result, MYSQLI_ASSOC));
        // die();

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
        // if (is_null($query))
        // {
        //     header('Location:views/dashboard.php');
        // }

        $user_id   = $_SESSION['user_id'];
        $user_role = $_SESSION['user_role'];

        if ($user_role == 'admin')
        {
            $stmt = mysqli_prepare($this->db, "SELECT * FROM events WHERE (name LIKE ? OR description LIKE ?) ORDER BY date DESC ");
            $searchQuery = "%" . $query . "%"; // Prepare search query with wildcards for LIKE
            mysqli_stmt_bind_param($stmt, "ss", $searchQuery, $searchQuery);
        }
        else
        {
            $stmt = mysqli_prepare($this->db, "SELECT * FROM events WHERE (name LIKE ? OR description LIKE ?) AND created_by = ? ORDER BY date DESC ");
            $searchQuery = "%" . $query . "%"; // Prepare search query with wildcards for LIKE
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

    // public function regEvent($event_id, $name, $email)
    // {
    //     // var_dump($event_id, $name, $email);

    //     // $stmt = mysqli_prepare($this->db, "INSERT INTO attendees (event_id, name, email) VALUES (?,?,?)");
    //     // mysqli_stmt_bind_param($stmt, "iss", $event_id, $name, $email);
    //     // // mysqli_stmt_execute($stmt);

    //     // if (mysqli_stmt_execute($stmt))
    //     // {
    //     //     mysqli_stmt_close($stmt);
    //     //     return '<div class="row w-100 justify-content-center "> <div class="col-md-12"> <div class="alert alert-success"> Registration successful! </div> </div></div>';
    //     // }
    //     $stmt = mysqli_prepare($this->db, "SELECT id FROM events WHERE id = ?");
    //     mysqli_stmt_bind_param($stmt, "i", $event_id);
    //     mysqli_stmt_execute($stmt);
    //     mysqli_stmt_store_result($stmt);

    //     if (mysqli_stmt_num_rows($stmt) == 0)
    //     {
    //         throw new Exception("The event ID does not exist.");
    //     }

    //     mysqli_stmt_close($stmt);

    //     // Proceed with registration
    //     $stmt = mysqli_prepare($this->db, "INSERT INTO attendees (event_id, name, email) VALUES (?, ?, ?)");
    //     mysqli_stmt_bind_param($stmt, "iss", $event_id, $name, $email);
    //     // mysqli_stmt_execute($stmt);
    //     // mysqli_stmt_close($stmt);
    //     if (mysqli_stmt_execute($stmt))
    //     {
    //         mysqli_stmt_close($stmt);
    //         return '<div class="row w-100 justify-content-center "> <div class="col-md-12"> <div class="alert alert-success"> Registration successful! </div> </div></div>';
    //     }
    // }

    public function regEvent($event_id, $name, $email)
    {
        try
        {
            // Check if the event ID exists
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

            // Insert the attendee record
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
                // Check for duplicate email error (MySQL error code 1062)
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
            // Return error message
            return '<div class="row w-100 justify-content-center">
                    <div class="col-md-12">
                        <div class="alert alert-danger"> ' . htmlspecialchars($e->getMessage()) . ' </div>
                    </div>
                </div>';
        }
    }
}
