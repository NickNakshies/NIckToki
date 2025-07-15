<?php
session_start();
require_once 'db_connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

if (isset($_POST['item_id'])) {
    $item_id = intval($_POST['item_id']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND item_id = ?");
    $stmt->bind_param("ii", $user_id, $item_id);
    $stmt->execute();

    echo json_encode(['status' => 'success']);
    exit;
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing item_id']);
    exit;
}
?>