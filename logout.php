<?php
session_start();

// Unset all session variables
$_SESSION = array();

// If it's desired to regenerate the session ID upon logout
// session_regenerate_id(true);

// Destroy the session
session_destroy();

// Delete the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Redirect to login page or home page
header("Location: index.html");
exit();
?>
