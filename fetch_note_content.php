<?php
session_start();
include 'connect.php';

function decryptData($encryptedData, $sessionKey) {
    list($data, $iv) = explode('::', base64_decode($encryptedData), 2);
    return openssl_decrypt($data, 'aes-256-cbc', $sessionKey, 0, $iv);
}

// Check if the session key is set and a noteId is provided in the request
if (isset($_SESSION['session_key']) && isset($_POST['note_id'])) {
    $noteId = $_POST['note_id'];
    $userId = $_SESSION['userid']; // Assuming the user's ID is stored in the session

    $stmt = $conn->prepare("SELECT title, content FROM notes WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $noteId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $decryptedContent = decryptData($row['content'], $_SESSION['session_key']);

        // Prepare data to send back as JSON
        $response = array(
            'title' => $row['title'],
            'content' => $decryptedContent
        );
        echo json_encode($response);
    } else {
        echo json_encode(['error' => 'Note not found or access denied.']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid request or session key not set.']);
}

$conn->close();
?>
