<?php
require 'login_check.php';
require_once 'db_connection.php';

$user_id = $_SESSION['user_id'];
$email = $_POST['email'];
$address = $_POST['deliveryAddress'];
$password = trim($_POST['password']);

$stmt = $conn->prepare("SELECT user_pic FROM users WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if (!$result || $result->num_rows === 0) {
    die("User not found.");
}
$user = $result->fetch_assoc();
$current_pic = $user['user_pic'];

$pic_filename = $current_pic;

$upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/NickToki/user_pics/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if (!empty($_FILES['file']['name'])) {
    $new_filename = uniqid() . "_" . basename($_FILES['file']['name']);
    $target_path = $upload_dir . $new_filename;

    if (!is_uploaded_file($_FILES['file']['tmp_name'])) {
        die("File upload error.");
    }

    if (!move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
        die("Error uploading file.");
    }

    $pic_filename = $new_filename;
}

if (!empty($password)) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET user_email=?, user_pass=?, user_address=?, user_pic=? WHERE user_id=?");
    $stmt->bind_param("ssssi", $email, $hashed_password, $address, $pic_filename, $user_id);
} else {
    $stmt = $conn->prepare("UPDATE users SET user_email=?, user_address=?, user_pic=? WHERE user_id=?");
    $stmt->bind_param("sssi", $email, $address, $pic_filename, $user_id);
}

if ($stmt->execute()) {
    header("Location: ../profile.php?success=1");
    exit;
} else {
    die("Error saving changes: " . htmlspecialchars($stmt->error));
}
?>
