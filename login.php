<?php
session_start();
include('dbcon.php');

$error = "";

if (isset($_POST['login_btn'])) {
    $username = mysqli_real_escape_string($connection, trim($_POST['username']));
    $password = trim($_POST['password']);

    $query = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $row['username'];
        $_SESSION['admin_email'] = $row['email']; // Store email for notifications
        
        header('location: index.php?login_msg=Successfully logged in!');
        exit();
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>

<?php include('header.php'); ?>

<div class="container" style="max-width: 400px; margin-top: 80px;">
    <div class="card shadow p-4">
        <h3 class="text-center mb-4">Admin Login</h3>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="login.php" method="post">
            <div class="form-group mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login_btn" class="btn btn-primary w-100">Login</button>
        </form>
        <div class="text-center mt-3">
            <a href="index.php">Back to Home</a>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>