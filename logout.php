<?php
session_start();

// Clear the session
session_unset();
session_destroy();

// Redirect back to the login page
header("Location: index.php");
exit;
?>
