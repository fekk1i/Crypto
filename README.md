Secure Notes Web Application
Introduction
Secure Notes is a web application designed for secure note-taking and management. Utilizing advanced cryptographic techniques, it ensures the confidentiality and integrity of user data. This application is ideal for users who require a robust and reliable platform for secure notetaking.

Features
User Authentication: Secure login system with password hashing.
Note Encryption: Uses AES-256 encryption in CBC mode for note content.
Public and Private Key Cryptography: For enhanced security in user data encryption and decryption.
Secure Session Management: PHP sessions are used to manage user sessions securely.
Installation
Clone the repository: git clone https://github.com/your-username/secure-notes.git
Navigate to the project directory: cd secure-notes
Install dependencies (if any).
Import the SQL file into your database
Configure your database in connect.php.
Run the application on your preferred server.
Usage
Register a new account with a username and password.
Log in to create, view, edit, or delete secure notes.
Each note is encrypted using a session-based symmetric key.
