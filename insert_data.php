<?php
session_start();
include 'dbcon.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('location: login.php');
    exit();
}

if (isset($_POST['add_students'])) {
    $fname = $_POST['f_name'];
    $lname = $_POST['l_name'];
    $age = $_POST['age'];

    if ($fname == "" || empty($fname)) {
        header('location:index.php?message=You need to fill in the first name!');
        exit();
    } else {
        $query = "INSERT INTO students (firstName, lastName, age) VALUES ('$fname', '$lname', '$age')";
        $result = mysqli_query($connection, $query);

        if (!$result) {
            die("Query Failed: " . mysqli_error($connection));
        } else {
            // Send Notification Email to the Admin
            if (isset($_SESSION['admin_email'])) {
                $to = $_SESSION['admin_email'];
                $subject = "New Student Added Report";
                $message = "Hello Admin,\n\nA new student has been added successfully:\nName: $fname $lname\nAge: $age";
                $headers = "From: no-reply@yourdomain.com";

                @mail($to, $subject, $message, $headers); // '@' suppresses warning if local mail server isn't configured yet
            }

            header('location:index.php?insert_msg=Student added and notification sent!');
            exit();
        }
    }
}
?>