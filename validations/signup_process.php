<?php
require_once 'db_connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone_number']); // ← optional, we'll map this to user_address
    $join_date = date("Y-m-d");

    // ✅ Basic validation
    if (empty($full_name) || empty($email) || empty($password)) {
        die("Please fill in all required fields.");
    }

    // ✅ Check if email already exists
    $check = $conn->prepare("SELECT user_id FROM users WHERE user_email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        die("Email already registered. Please log in instead.");
    }

    // ✅ Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // ✅ Insert new user (user_pic set to default blank for now)
    $stmt = $conn->prepare("INSERT INTO users (user_name, user_email, user_pass, user_address, user_joindate, user_pic) VALUES (?, ?, ?, ?, ?, '')");
    $stmt->bind_param("sssss", $full_name, $email, $hashed_password, $phone, $join_date);

    if ($stmt->execute()) {
        header("Location: ../signin.php");
        exit();
    } else {
        die("Something went wrong: " . $stmt->error);
    }
}
?>
