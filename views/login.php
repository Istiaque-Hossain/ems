<?php
include 'header.php';

session_start();

if (isset($_SESSION['user_id']))
{
    header('Location: dashboard.php');
    exit;
}
?>

<h1 class="text-center bg-primary text-white py-3 rounded shadow-lg">
    Event Management System
</h1>


<div class="container vh-100 d-flex flex-column align-items-center justify-content-center ">

    <?php
    if (isset($_SESSION['login_message']))
    {
        echo '<div class="row w-100 justify-content-center "> <div class="col-md-6"> <div class="alert alert-danger">' . $_SESSION['login_message'] . '</div> </div></div>';
        unset($_SESSION['login_message']);
    }

    if (isset($_SESSION['reg_message']))
    {
        echo $_SESSION['reg_message'];
        unset($_SESSION['reg_message']);
    }
    ?>

    <div class="row w-100 justify-content-center ">
        <div class="col-md-6 shadow-lg p-3 mb-5 bg-body-tertiary rounded">
            <form method="POST" action="../process.php">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input id="email" class="form-control" type="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" class="form-control" type="password" name="password" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary">Submit</button>
            </form>

            <div class="row my-4">
                <div class="col">
                    <a href="register.php">New! Register Here</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>