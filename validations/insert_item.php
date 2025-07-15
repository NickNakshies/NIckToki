<?php
require 'db_connection.php';

$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];

$sql = "INSERT INTO items (name, description, price) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    // Log or show the error
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssd", $name, $description, $price); // Adjust types as needed
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Item inserted successfully!";
} else {
    echo "Insertion failed.";
}

$stmt->close();
$conn->close();
?>
