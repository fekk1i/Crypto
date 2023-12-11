<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'connect.php';

// Function to check if the username already exists in the database
function userExists($conn, $username) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->num_rows > 0;
}

// Function to generate a 256-bit (32-byte) symmetric key
function generateSymmetricKey() {
    return bin2hex(openssl_random_pseudo_bytes(32));
}

// Function to generate a key pair (public key and private key)
function generateKeyPair() {
    $config = array(
        "digest_alg" => "sha256",
        "private_key_bits" => 2048,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );

    // Generate a new key pair
    $keypair = openssl_pkey_new($config);

    // Extract the private key and convert it to PEM format (for future use)
    openssl_pkey_export($keypair, $privateKeyPEM);

    // Extract the public key in PEM format
    $publicKeyPEM = openssl_pkey_get_details($keypair)["key"];

    // Generate a unique identifier (e.g., timestamp)
    $uniqueIdentifier = uniqid();

    // Append the unique identifier to the public key
    $publicKeyPEMWithTimestamp = $publicKeyPEM . "\nTimestamp: " . $uniqueIdentifier;

    return array($privateKeyPEM, $publicKeyPEMWithTimestamp);
}

function registerUser($conn, $username, $password) {
    if (userExists($conn, $username)) {
        return "Username already taken. Please choose a different username.";
    }

    // Generate a new user's public key
    list(, $publicKeyPEM) = generateKeyPair();

    $symmetricKey = generateSymmetricKey();
    if ($symmetricKey === false) {
        return "Error generating symmetric key. Please try again.";
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database with their public key
    $stmt = $conn->prepare("INSERT INTO users (username, password, symmetric_key, public_key) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $hashed_password, $symmetricKey, $publicKeyPEM);
    if ($stmt->execute()) {
        $stmt->close();
        return "User registered successfully.";
    } else {
        $error = $stmt->error;
        $stmt->close();
        return "Error: " . $error;
    }
}
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Input validation/sanitation here (recommended)

    // Attempt to register the user
    $registrationResult = registerUser($conn, $username, $password);
    echo $registrationResult;
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
