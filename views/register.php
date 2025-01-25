<?php include 'header.php'; ?>
<!-- <form method="POST" action="process.php">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="register">Register</button>
</form> -->







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
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>