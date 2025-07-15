<?php
session_start();
require_once 'db_connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "
    SELECT c.item_id, c.quantity, i.item_name, i.item_price, i.item_image
    FROM cart c
    JOIN items i ON c.item_id = i.item_id
    WHERE c.user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode($items);
?>