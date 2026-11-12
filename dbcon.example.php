<?php
define("HOSTNAME", "localhost");
define("USERNAME", "your_db_username");
define("PASSWORD", "your_db_password");
define("DATABASE", "your_database_name");

$connection = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);
if (!$connection) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>