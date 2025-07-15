<?php
require_once 'db_connection.php'; // Reuse your DB connection
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $address = trim($_POST['delivery_address']);

    // Basic validation
    if (empty($full_name) || empty($email) || empty($password)) {
        die("All fields are required.");
    }

    // Check if email already exists
    $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        die("This email is already registered.");
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password_hash, delivery_address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $full_name, $email, $hashed_password, $address);

}
?>
