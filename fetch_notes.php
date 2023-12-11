<?php
session_start();
include 'connect.php';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $userId = $_SESSION['userid'];

    $stmt = $conn->prepare("SELECT id, title FROM notes WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='note-title' onclick='loadNoteContent(" . $row['id'] . ")'>" . htmlspecialchars($row['title']) . "</div>";
        }
    } else {
        echo "No notes found.";
    }

    $stmt->close();
} else {
    echo "User not logged in.";
}

$conn->close();
?>
