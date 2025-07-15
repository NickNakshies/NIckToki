
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<form action="upload_receipt.php" method="POST" enctype="multipart/form-data">
    <label for="cart_id">Cart ID:</label>
    <input type="number" name="cart_id" required><br><br>

    <label for="receipt">Upload Receipt:</label>
    <input type="file" name="receipt" accept="image/*" ><br><br>

    <button type="submit" name="upload">Upload Receipt</button>
</form>

<?php
require 'validations/db_connection.php'; // <-- Make sure this file connects to your database

if (isset($_POST['upload'])) {
    $cart_id = $_POST['cart_id'];
    $receipt = $_FILES['receipt'];

    // Folder to save uploaded files
    $target_dir = "receipts/";

    // Generate unique filename
    $file_name = basename($receipt["name"]);
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $new_file_name = 'receipt_' . time() . '_' . rand(1000,9999) . '.' . $file_ext;

    $target_file = $target_dir . $new_file_name;

    // Validate image
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array(strtolower($file_ext), $allowed_types)) {
        die("Only JPG, PNG, and GIF files are allowed.");
    }

    // Move uploaded file
    if (move_uploaded_file($receipt["tmp_name"], $target_file)) {
        // Save file name into database
        $sql = "UPDATE cart SET receipt_image = ? WHERE cart_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_file_name, $cart_id);

        if ($stmt->execute()) {
            echo "Receipt uploaded and saved successfully!";
        } else {
            echo "Database update failed.";
        }
    } else {
        echo "Failed to upload the file.";
    }
}
?>


<script>
    document.querySelector('input[type="file"]').addEventListener('click', (e) => {
  e.preventDefault(); // ❌ This will block file picker
});
</script>

<?php
require 'footer.php';
?>