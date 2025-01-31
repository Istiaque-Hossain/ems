<?php
include 'header.php';

session_start();
if (isset($_SESSION['user_id']))
{
    header('Location: dashboard.php');
    exit;
}
?>


<div class="container vh-100 d-flex flex-column align-items-center justify-content-center ">
    <div class="row w-100 justify-content-center ">
        <div class="col-md-6 shadow-lg p-3 mb-5 bg-body-tertiary rounded">
            <form method="POST" action="../process.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input id="username" class="form-control" type="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input id="email" class="form-control" type="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" class="form-control" type="password" name="password" required>
                </div>
                <button type="submit" name="register" class="btn btn-primary">Submit</button>
            </form>

            <div class="row my-4">
                <div class="col">
                    <a href="login.php">Already have an account! Login here</a>
                </div>
            </div>

            <a href="attendee.php" name="login" class="btn btn-warning w-100"> <strong>Event Register</strong> </a>

        </div>
    </div>
</div>
<?php include 'footer.php'; ?>