<?php
session_start();

// 1. Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('location: login.php');
    exit();
}

include('dbcon.php');

// 2. Process deletion if ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Optional safety: sanitize/escape the ID to prevent SQL injection
    $id = mysqli_real_escape_string($connection, $id);

    $query = "DELETE FROM students WHERE id = '$id'";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Query Failed: " . mysqli_error($connection));
    } else {
        header('location: index.php?delete_msg=Data deleted successfully!');
        exit();
    }
} else {
    // Redirect back to index if no ID was passed in URL
    header('location: index.php');
    exit();
}
?>