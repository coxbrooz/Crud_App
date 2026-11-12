<?php
session_start();

// 1. Ensure only logged-in admins can access this page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('location: login.php');
    exit();
}

include('header.php');
include('dbcon.php');

// 2. Fetch the existing record to pre-populate the form
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connection, $_GET['id']);

    $query = "SELECT * FROM students WHERE id = '$id'";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Query Failed: " . mysqli_error($connection));
    } else {
        $row = mysqli_fetch_assoc($result);
    }
}

// 3. Handle the update submission
if (isset($_POST['update_student'])) {
    if (isset($_GET['id_new'])) {
        $idnew = mysqli_real_escape_string($connection, $_GET['id_new']);
        $fname = mysqli_real_escape_string($connection, $_POST['f_name']);
        $lname = mysqli_real_escape_string($connection, $_POST['l_name']);
        $age = mysqli_real_escape_string($connection, $_POST['age']);

        $query = "UPDATE students SET firstName = '$fname', lastName = '$lname', age = '$age' WHERE id = '$idnew'";
        $result = mysqli_query($connection, $query);

        if (!$result) {
            die("Query Failed: " . mysqli_error($connection));
        } else {
            header('location: index.php?update_msg=Data updated successfully!');
            exit();
        }
    }
}
?>

<div class="container" style="margin-top: 50px;">
    <h2>Update Student Information</h2>
    <form action="update_page.php?id_new=<?php echo $row['id']; ?>" method="post">
        <div class="form-group mb-3">
            <label for="f_name">First Name</label>
            <input type="text" name="f_name" class="form-control" value="<?php echo isset($row['firstName']) ? $row['firstName'] : ''; ?>">
        </div>
        <div class="form-group mb-3">
            <label for="l_name">Last Name</label>
            <input type="text" name="l_name" class="form-control" value="<?php echo isset($row['lastName']) ? $row['lastName'] : ''; ?>">
        </div>
        <div class="form-group mb-3">
            <label for="age">Age</label>
            <input type="number" name="age" class="form-control" value="<?php echo isset($row['age']) ? $row['age'] : ''; ?>">
        </div>
        <input type="submit" class="btn btn-success" name="update_student" value="UPDATE">
    </form>
</div>

<?php include('footer.php'); ?>