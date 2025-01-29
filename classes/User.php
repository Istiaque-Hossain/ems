<?php
class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function register($username, $email, $password)
    {
        try
        {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt = mysqli_prepare($this->db, "INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);

            if (mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_close($stmt);
                return '<div class="row w-100 justify-content-center "> <div class="col-md-6"> <div class="alert alert-success"> Registration successful! </div> </div></div>';
            }
        }
        catch (Exception $e)
        {
            return '<div class="row w-100 justify-content-center "> <div class="col-md-6"> <div class="alert alert-danger"> An unexpected error occurred: ' . $e->getMessage() . ' </div> </div></div>';
        }
    }


    public function login($email, $password)
    {
        $stmt = mysqli_prepare($this->db, "SELECT id, password, role FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result))
        {
            if (password_verify($password, $row['password']))
            {
                $_SESSION['user_id']   = $row['id'];
                $_SESSION['user_role'] = $row['role'];
                return true;
            }
        }
        return false;
    }
}
