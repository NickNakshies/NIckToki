<?php
require 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout - NickToki</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap">
  <link rel="stylesheet" href="checkout.css">
</head>
<body>

<div class="checkout-container">

  <!-- LEFT: Product Section -->
  <div class="product-list">
    <h2>Checkout</h2>

    <div class="product-item">
      <div class="product-label">
        <img src="../../assets/bluewave.png" alt="Blue Wave Build">
        <span>Blue Wave Build</span>
      </div>
      <span class="price">₱34,515</span>
    </div>

    <div class="product-item">
      <div class="product-label">
        <img src="../../assets/kmset.png" alt="KM Set">
        <span>KM Set</span>
      </div>
      <span class="price">₱7,459</span>
    </div>

    <div class="total-line"></div>

    <div class="product-item total">
      <span>Total</span>
      <span class="price">₱41,974</span>
    </div>
  </div>

  <!-- RIGHT: Payment Section -->
  <div class="payment-box">
    <h2>Payment Method</h2>

    <p class="scan-label">Click here to Scan QR</p>
    <img src="../../assets/starscanqr.png" alt="Scan QR" class="scanqr">

    <p class="accept-text">We only accept:</p>
    <div class="logos">
      <img src="../../assets/qrph.png" alt="QR Ph">
      <img src="../../assets/gcash.png" alt="GCash">
      <img src="../../assets/maya.png" alt="Maya">
      <img src="../../assets/bdo.png" alt="BDO">
    </div>

    <div class="upload-section">
      <p>Upload Receipt</p>
      <small>Wait for email confirmation</small>
      <label for="receipt" class="upload-btn">📤 Upload Receipt</label>
      <input type="file" id="receipt" name="receipt">
    </div>
  </div>

</div>

<!-- Footer -->
<div class="footer-note">
  No copyright infringement intended. <br>
  For educational purposes only.
</div>

</body>
</html>

<?php
require 'footer.php';
?>
