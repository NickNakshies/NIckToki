<?php
require 'header.php';
require_once 'validations/db_connection.php';
session_start();
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

// Handle form submit and file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['receipt']) && $_FILES['receipt']['error'] === UPLOAD_ERR_OK) {
    $user_id = $_SESSION['user_id'] ?? 0;
    $fileTmpPath = $_FILES['receipt']['tmp_name'];
    $fileName = $_FILES['receipt']['name'];
    $fileSize = $_FILES['receipt']['size'];
    $fileType = $_FILES['receipt']['type'];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $newFileName = uniqid('receipt_', true) . '.' . $fileExtension;
    $uploadDir = 'receipts/';
    $dest_path = $uploadDir . $newFileName;

    // Create receipts folder if not exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (move_uploaded_file($fileTmpPath, $dest_path)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                  icon: 'success',
                  title: 'Order placed! 🎉',
                  text: 'We received your receipt. Wait for our email confirmation.',
                  confirmButtonColor: '#38b6ff'
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href = 'store.php';
                  }
                });
            });
        </script>";
        // Update receipt path for all items in cart
        $stmt = $conn->prepare("UPDATE cart SET receipt_image = ? WHERE user_id = ?");
        $stmt->bind_param("si", $dest_path, $user_id);
        $stmt->execute();
        
        

        // Clear cart after receipt upload and submit
        $truncate = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $truncate->bind_param("i", $user_id);
        $truncate->execute();

        
    }
}
?>

<h2>Checkout</h2>

<form class="checkout-container" method="POST" enctype="multipart/form-data">
  <div class="payment-left">
     <div class="scan-title" style="margin-left: 74%; margin-top: -20px;">
      <span class="pay-scan-label">Pay Scan QR Here</span>
      <img src="assets/starscanqr.png" alt="Star" class="star-icon" style="margin-left: -2%;">
  </div>
    <span class="accepted-text">We only accept:</span>

  <div class="qrph-wrapper">
    <img src="assets/qrph.png" alt="QR Ph" class="qrph-logo" style="width: 100px; height: auto; margin-top:-40%; margin-bottom: 5%;">
  </div>
  <div class="logos" style="margin-top: -20px; margin-bottom: -10px;">
  <img src="assets/gcash.png" alt="GCash" style="height:50px; width:auto;">
  <img src="assets/maya.png" alt="Maya" style="height:50px; width:auto;">
  <img src="assets/bdo.png" alt="BDO" style="height:50px; width:auto;">
</div>
    <img class="qr-code" src="assets/scanqr.png" alt="QR Code" style="height: 330px; width: auto; object-fit: contain;">
  </div>

<!-- RIGHT PART -->
<div class="payment-right">
  <div class="upload-box" style="text-align: center;">
    <div class="image-container">
      <label for="receipt" style="cursor: pointer;">
        <img id="receipt-preview" src="assets/uploadreceipt.png" alt="Upload Receipt">
      </label>
    </div>
    <div style="margin-top: 10px;">
      <label for="receipt" class="upload-label"
             style="display: block; cursor: pointer; color: #fff; margin-top: 30px; text-decoration: underline; font-size:20px;">
        Upload Receipt
      </label>
      <small style="display: block; color: #ccc;">wait for email confirmation</small>
    </div>
    <input type="file" id="receipt" name="receipt" accept="image/*" style="display: none;">
    <p id="file-name" style="color: #ccc; font-size: 0.9em; margin-top: 5px;"></p>
  </div>

  <!-- Submit Button -->
  <button 
    type="submit"
    style="background-color: rgba(56, 182, 255, 0.41); border-radius: 30px; border: none; color: white; padding: 10px 20px; cursor: pointer; margin-top:28px; transition: background-color 0.3s ease, transform 0.2s ease;" 
    onmouseover="this.style.backgroundColor='rgba(56,182,255,0.7)'; this.style.transform='scale(1.05)';" 
    onmouseout="this.style.backgroundColor='rgba(56,182,255,0.41)'; this.style.transform='scale(1)';"
  >
    Place Order
  </button>
</div>
</form>


<script>
  const fileInput = document.getElementById('receipt');
  const previewImg = document.getElementById('receipt-preview');
  const fileNameDisplay = document.getElementById('file-name');

  fileInput.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
      fileNameDisplay.textContent = file.name;
      const reader = new FileReader();
      reader.onload = function (e) {
        previewImg.src = e.target.result;
      };
      reader.readAsDataURL(file);
    } else {
      fileNameDisplay.textContent = '';
    }
  });
</script>

<?php require 'footer.php'; ?>
