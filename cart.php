<?php
require 'header.php';
?>

<h2>Checkout</h2>

<div class="checkout-container">

  <!-- LEFT: Product Section -->

  <div class="product-list">
  
  <div class="product-header">
    <span class="product-title">Product</span>
    <span class="product-title">Price</span>
  </div>

  <?php
  $products = []; 

  $total = 0;

  if (empty($products)) {
    echo '<p class="empty-cart-msg">Your cart is empty.</p>';
  } else {
    foreach ($products as $a) {
      echo '
      <div class="product-item">
        <div class="product-label">
          <img src="assets/' . htmlspecialchars($a["img"]) . '" alt="' . htmlspecialchars($a["name"]) . '">
          <span>' . htmlspecialchars($a["name"]) . '</span>
        </div>
        <span class="price">₱' . number_format($a["price"], 0) . '</span>
      </div>';
      $total += $a["price"];
    }

    echo '
    <div class="total-line"></div>
    <div class="product-item total">
      <span>Total</span>
      <span class="price">₱' . number_format($total, 0) . '</span>
    </div>';
  }
  ?>
</div>

  <!-- RIGHT: Payment Section -->
  <div class="payment-box">
    <h3 class="h3">Payment Method</h3>
    <div class="scan-accept-row">
        
 <!-- Your existing HTML content -->
<div class="scan-column">
  <p class="scan-label">Click here to Scan QR</p>
  <img src="assets/starscanqr.png" alt="Scan QR" class="scanqr" id="scanQrImg">
</div>

<div class="accept-column">
  <p class="accept-text">We only accept:</p>
  <img src="assets/qrph.png" alt="QR Ph" class="qrph-logo">
  <div class="logos">
    <img src="assets/gcash.png" alt="GCash">
    <img src="assets/maya.png" alt="Maya">
    <img src="assets/bdo.png" alt="BDO">
  </div>
</div>
</div>

<div class="upload-section">
  <img src="assets/uploadreceipt.png" alt="Upload Receipt Icon" class="upload-icon">
  <label for="receipt" class="upload-label">
    <p>Upload Receipt</p>
  </label>
  <small>Wait for email confirmation</small>
  <input type="file" id="receipt" name="receipt" style="display: none;">
</div>
</div>
<!-- SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('scanQrImg').addEventListener('click', function () {
      Swal.fire({
        html: `
          <img src="assets/paymentaccept.png" alt="Payment Accepted" style="width: 100%; max-width: 400px; margin-bottom: 10px;">
          <p style="font-weight: bold; margin: 5px 0; color: white;">Scan Here</p>
          <img src="assets/scanqr.png" alt="Scan QR" style="width: 100%; max-width: 400px;">
        `,
        showConfirmButton: false,
        background: 'rgba(0, 0, 0, 0.85)',
        width: '400px',
        padding: '30px',
        customClass: {
          popup: 'qrph-popup'
        }
      });
    });
  });
</script>
<?php
require 'footer.php';
?>
