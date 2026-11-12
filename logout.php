<?php
session_start();
session_unset();
session_destroy();
header('location: index.php?logout_msg=Logged out successfully.');
exit();
?>