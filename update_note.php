<?php
session_start();
include 'connect.php';

function encryptData($data, $sessionKey) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $sessionKey, 0, $iv);
    return base64_encode($encryptedData . '::' . $iv);
}

function send_error_message($message) {
    echo json_encode(array("error" => $message));
    exit;
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['session_key'])) {
    $userId = $_SESSION['userid'];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['note_id'], $_POST['title'], $_POST['content'])) {
        $noteId = $_POST['note_id'];
        $newTitle = $conn->real_escape_string($_POST['title']);
        $newContent = $_POST['content'];

        $encryptedContent = encryptData($newContent, $_SESSION['session_key']);

        $stmt = $conn->prepare("UPDATE notes SET title = ?, content = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssii", $newTitle, $encryptedContent, $noteId, $userId);

        if ($stmt->execute()) {
            echo json_encode(array("success" => "Note updated successfully."));
        } else {
            send_error_message("Error updating note: " . $stmt->error);
        }

        $stmt->close();
    } else {
        send_error_message("Invalid request or missing parameters.");
    }
} else {
    send_error_message("User not logged in or session key not set.");
}

$conn->close();
?>
