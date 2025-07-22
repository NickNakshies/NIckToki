<?php
require_once 'db_connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $address = trim($_POST['address']); // ← optional, we'll map this to user_address
    $join_date = date("Y-m-d");

    if (empty($full_name) || empty($email) || empty($password)) {
        die("Please fill in all required fields.");
    }

    $check = $conn->prepare("SELECT user_id FROM users WHERE user_email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        die("Email already registered. Please log in instead.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (user_name, user_email, user_pass, user_address, user_joindate, user_pic) VALUES (?, ?, ?, ?, ?, '')");
    $stmt->bind_param("sssss", $full_name, $email, $hashed_password, $address, $join_date);

    if ($stmt->execute()) {
        header("Location: ../signin.php");
        exit();
    } else {
        die("Something went wrong: " . $stmt->error);
    }
}
?>
