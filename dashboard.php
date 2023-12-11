<?php
session_start();
include 'connect.php';  // Assuming you have a connection setup file

// Redirect to login page if the user is not logged in or session key is not set
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['session_key'])) {
    header("Location: login.php");
    exit;
}

// Now we can safely assume that the session key exists
$sessionKey = $_SESSION['session_key'];

// Other PHP logic goes here, e.g., fetching user data, handling form submissions, etc.

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Noted</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<body>
    <div id="dashboard-container">
        <div id="notes-sidebar">
            <!-- Add New Note Button -->
            <button id="add-new-note-btn" onclick="createNewNote()">Add New Note</button>
            <!-- Titles of notes will be loaded here -->
        </div>
        <div id="note-editor">
            <input type="hidden" id="edit-note-id">
            <input type="text" id="edit-note-title" placeholder="Note Title" required>
            <textarea id="edit-note-content" placeholder="Write your note here..." required></textarea>
            <!-- Save Changes Button -->
            <button onclick="createNewNote()">Create New Note</button>
            <!-- Save Changes Button -->
            <button onclick="saveNoteChanges()">Save Changes</button>
            <!-- Delete Note Button -->
            <button onclick="deleteNote()">Delete Note</button>
            <!-- Logout Button -->
            <button onclick="logout()">Logout</button>
        </div>
    </div>

    <div id="sessionKeyDisplay" style="display: block;">
        Your Session Key: <span id="sessionKeyValue"><?php echo htmlspecialchars($sessionKey); ?></span>
    </div>
    
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="script.js"></script>
</body>
</html>


