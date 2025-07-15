<?php
session_start();
require_once 'db_connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

if (isset($_POST['item_id'], $_POST['change'])) {
    $item_id = intval($_POST['item_id']);
    $change = intval($_POST['change']);
    $user_id = $_SESSION['user_id'];

    // Check current quantity
    $check = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND item_id = ?");
    $check->bind_param("ii", $user_id, $item_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $newQuantity = $row['quantity'] + $change;

        if ($newQuantity <= 0) {
            $delete = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND item_id = ?");
            $delete->bind_param("ii", $user_id, $item_id);
            $delete->execute();
        } else {
            $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND item_id = ?");
            $update->bind_param("iii", $newQuantity, $user_id, $item_id);
            $update->execute();
        }

        echo json_encode(['status' => 'success']);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Item not found in cart']);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    exit;
}
?>