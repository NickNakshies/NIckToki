<?php
require_once 'db_connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        die("Please fill in all required fields.");
    }

    // Check if user exists
    $stmt = $conn->prepare("SELECT user_id, user_pass, user_name FROM users WHERE user_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // If user not found
    if ($stmt->num_rows == 0) {
        die("Account not found.");
    }

    // Fetch data
    $stmt->bind_result($user_id, $hashed_password, $user_name);
    $stmt->fetch();

    // Verify password
    if (password_verify($password, $hashed_password)) {
        // Set session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $user_name;
        header("Location: ../store.php");
        exit();
    } else {
        die("Incorrect password.");
    }
}
?>
