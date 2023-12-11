<?php
session_start();
include 'connect.php';

function generateSessionKey() {
    return bin2hex(random_bytes(32)); // Generate a new 256-bit session key
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Authentication logic here
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Correct password
            $_SESSION['loggedin'] = true;
            $_SESSION['userid'] = $user['id'];
            
            // Regenerate session key
            $_SESSION['session_key'] = generateSessionKey();

            // Redirect to dashboard or send success response
            header("Location: dashboard.php");
            exit;
        } else {
            // Incorrect password
            header("Location: Invalid_pass.html");
            exit;
        }
    } else {
        // Username not found
        header("Location: Invalid_pass.html");
        exit;
    }
    $stmt->close();
} else {
    // Not a POST request
    echo "Invalid request method.";
}

$conn->close();
?>
