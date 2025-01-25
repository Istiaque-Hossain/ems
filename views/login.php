<?php include 'header.php'; ?>

<?php
session_start(); // Start session at the top of your script

if (isset($_SESSION['error_message']))
{
    echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']); // Clear the message after displaying it
}

?>
<div class="container vh-100 d-flex flex-column align-items-center justify-content-center ">
    <div class="row w-100 justify-content-center ">
        <div class="col-md-6 shadow-lg p-3 mb-5 bg-body-tertiary rounded">
            <form method="POST" action="../process.php">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input id="email" class="form-control" type="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" class="form-control" type="password" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>