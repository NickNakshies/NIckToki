<?php
session_start();
require 'db_connection.php';

header('Content-Type: application/json'); // JSON response

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

if (isset($_POST['item_id'])) {
    $item_id = intval($_POST['item_id']);
    $user_id = $_SESSION['user_id'];

    // Check if item already exists in cart
    $check = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND item_id = ?");
    $check->bind_param("ii", $user_id, $item_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Increase quantity
        $update = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND item_id = ?");
        $update->bind_param("ii", $user_id, $item_id);
        $update->execute();
    } else {
        // Insert new item
        $insert = $conn->prepare("INSERT INTO cart (user_id, item_id, quantity) VALUES (?, ?, 1)");
        $insert->bind_param("ii", $user_id, $item_id);
        $insert->execute();
    }

    echo json_encode(['status' => 'success', 'message' => 'Item added to cart!']);
    exit;
} else {
    echo json_encode(['status' => 'error', 'message' => 'No item specified']);
    exit;
}
?>
