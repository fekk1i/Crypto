<?php
session_start();
include 'connect.php';

// Function to encrypt the note content using the session key
function encryptData($data, $sessionKey) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $sessionKey, 0, $iv);
    return base64_encode($encryptedData . '::' . $iv);
}

// Function to encrypt the session key using user's public key
function encryptSessionKey($sessionKey, $publicKey) {
    if (!openssl_public_encrypt($sessionKey, $encryptedSessionKey, $publicKey)) {
        return false;
    }
    return base64_encode($encryptedSessionKey);
}

// Check if the user is logged in and the session key is set
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['session_key'])) {
    $userId = $_SESSION['userid'];
    $noteTitle = $_POST['title'];
    $noteContent = $_POST['content'];

    // Fetch the user's public key
    $stmt = $conn->prepare("SELECT public_key FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $publicKey = $row['public_key'];

        // Encrypt the session key with the user's public key
        $encryptedSessionKey = encryptSessionKey($_SESSION['session_key'], $publicKey);
        if ($encryptedSessionKey === false) {
            echo "Error encrypting session key.";
            exit;
        }

        // Encrypt the note content with the session key
        $encryptedContent = encryptData($noteContent, $_SESSION['session_key']);

        // Prepare the INSERT statement
        $stmt = $conn->prepare("INSERT INTO notes (user_id, title, content, encrypted_session_key) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $userId, $noteTitle, $encryptedContent, $encryptedSessionKey);
        
        if ($stmt->execute()) {
            echo "Note created successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "User's public key not found.";
    }
    $stmt->close();
} else {
    echo "User not logged in or session key not set.";
}

$conn->close();
?>
