<?php
session_start();
include 'connect.php';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    // Only proceed if the user is logged in
    $userId = $_SESSION['userid'];  // Assuming user ID is stored in session

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['note_id'])) {
        $noteId = $_POST['note_id'];

        // Prepare a DELETE statement to prevent SQL injection
        $stmt = $conn->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $noteId, $userId);

        if ($stmt->execute()) {
            echo "Note deleted successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid request method or note ID not set.";
    }
} else {
    echo "User not logged in.";
}

$conn->close();
?>
