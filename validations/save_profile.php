<?php
require 'login_check.php';
require_once 'db_connection.php';

$user_id = $_SESSION['user_id'];
$email = $_POST['email'];
$address = $_POST['deliveryAddress'];
$password = trim($_POST['password']);

$pic_filename = null;

if (!empty($_FILES['file']['name'])) {
    $target_dir = "user_pics/";
    $pic_filename = uniqid() . "_" . basename($_FILES['file']['name']);
    $target_file = $target_dir . $pic_filename;
    if (!move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        die("Error uploading file.");
    }
}

if (!empty($password)) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    if ($pic_filename) {
        $stmt = $conn->prepare("UPDATE users SET user_email=?, user_pass=?, user_address=?, user_pic=? WHERE user_id=?");
        $stmt->bind_param("ssssi", $email, $hashed_password, $address, $pic_filename, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET user_email=?, user_pass=?, user_address=? WHERE user_id=?");
        $stmt->bind_param("sssi", $email, $hashed_password, $address, $user_id);
    }
} else {
    if ($pic_filename) {
        $stmt = $conn->prepare("UPDATE users SET user_email=?, user_address=?, user_pic=? WHERE user_id=?");
        $stmt->bind_param("sssi", $email, $address, $pic_filename, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET user_email=?, user_address=? WHERE user_id=?");
        $stmt->bind_param("ssi", $email, $address, $user_id);
    }
}

if ($stmt->execute()) {
    header("Location: profile.php?success=1");
    exit;
} else {
    die("Error saving changes.");
}
?>
