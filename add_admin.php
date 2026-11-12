<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('location: login.php');
    exit();
}

include('dbcon.php');
$msg = "";

if (isset($_POST['register_admin'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);

    $query = "INSERT INTO admins (username, password, email) VALUES ('$username', '$password', '$email')";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        $msg = "Error: " . mysqli_error($connection);
    } else {
        $msg = "New admin added successfully!";
    }
}
?>

<?php include('header.php'); ?>

<div class="container" style="max-width: 500px; margin-top: 50px;">
    <h2>Add New Admin & Notification Email</h2>
    
    <?php if (!empty($msg)): ?>
        <div class="alert alert-info"><?php echo $msg; ?></div>
    <?php endif; ?>

    <form action="add_admin.php" method="post">
        <div class="form-group mb-3">
            <label>Admin Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label>Notification Email Address</label>
            <input type="email" name="email" class="form-control" required placeholder="where you want to receive alerts">
        </div>
        <button type="submit" name="register_admin" class="btn btn-primary">Add Admin</button>
        <a href="index.php" class="btn btn-secondary">Back to Home</a>
    </form>
</div>

<?php include('footer.php'); ?>