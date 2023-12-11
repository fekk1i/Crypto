document.addEventListener('DOMContentLoaded', function() {
    loadNoteTitles();
});

function loadNoteTitles() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_notes.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            document.getElementById('notes-sidebar').innerHTML = this.responseText;
        } else {
            console.error("Failed to load notes: Status", this.status);
        }
    };
    xhr.onerror = function() {
        console.error("Request to load notes failed");
    };
    xhr.send();
}

function createNewNote() {
    document.getElementById('edit-note-id').value = '';
    document.getElementById('edit-note-title').value = '';
    document.getElementById('edit-note-content').value = '';
    document.getElementById('edit-note-title').focus();
}

function loadNoteContent(noteId) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'fetch_note_content.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status === 200) {
            try {
                const note = JSON.parse(this.responseText);
                document.getElementById('edit-note-id').value = noteId;
                document.getElementById('edit-note-title').value = note.title || '';
                document.getElementById('edit-note-content').value = note.content || '';
            } catch (e) {
                console.error("Error parsing JSON: ", e);
                console.error("Response received: ", this.responseText);
            }
        } else {
            console.error("Failed to load note content: Status", this.status);
        }
    };
    xhr.onerror = function() {
        console.error("Request to load note content failed");
    };
    xhr.send('note_id=' + encodeURIComponent(noteId));
}

function saveNoteChanges() {
    const noteId = document.getElementById('edit-note-id').value;
    const title = document.getElementById('edit-note-title').value.trim();
    const content = document.getElementById('edit-note-content').value.trim();

    if (title === '' || content === '') {
        alert('Please enter a title and content for the note.');
        return;
    }

    const xhr = new XMLHttpRequest();
    const params = 'note_id=' + encodeURIComponent(noteId) + '&title=' + encodeURIComponent(title) + '&content=' + encodeURIComponent(content);
    xhr.open('POST', noteId ? 'update_note.php' : 'create_note.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status === 200) {
            loadNoteTitles();
            if (!noteId) {
                createNewNote();
            }
        } else {
            console.error("Failed to save note: Status", this.status);
        }
    };
    xhr.onerror = function() {
        console.error("Request to save note failed");
    };
    xhr.send(params);
}

function deleteNote() {
    const noteId = document.getElementById('edit-note-id').value;
    if (noteId && confirm('Are you sure you want to delete this note?')) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_note.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status === 200) {
                loadNoteTitles();
                createNewNote(); // Reset the note editor
            } else {
                console.error("Failed to delete note: Status", this.status);
            }
        };
        xhr.onerror = function() {
            console.error("Request to delete note failed");
        };
        xhr.send('note_id=' + encodeURIComponent(noteId));
    }
}

function logout() {
    window.location.href = 'logout.php';
}
