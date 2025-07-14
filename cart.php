<?php
require 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Checkout - NickToki</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap">
  <link rel="stylesheet" href="checkout.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="checkout-container">

  <!-- Product List -->
  <div class="product-list">
    <h2>Checkout</h2>
    <div id="cart-items">
      <!-- Items -->
      <p id="empty-cart">Your cart is empty.</p>
    </div>

    <div class="total" id="cart-total" style="display:none;">
      <strong>Total</strong>
      <strong id="total-amount">₱0</strong>
    </div>
  </div>

  <!-- Payment Box -->
  <div class="payment-box">
    <h2>Payment Method</h2>

    <div class="qr-section">
      <p>Click here to Scan QR</p>
      <img src="../../assets/qrph-icon.png" alt="QR Ph">
      <p class="accepted-payments">We only accept<br><strong style="color: #f5ea0a;">● QR Ph</strong></p>
    </div>

    <div class="upload-section">
      <p>Upload Receipt<br><small>Wait for email confirmation</small></p>
      <label for="receipt" class="upload-label">📤 Upload Receipt</label>
      <input type="file" id="receipt" name="receipt">
    </div>
  </div>

</div>

<div class="footer-note">
  No copyright infringement intended.<br>
  For educational purposes only.
</div>

<script>
  let total = 0;

  function addToCart(name, price) {
    const cartItems = document.getElementById("cart-items");
    const emptyNotice = document.getElementById("empty-cart");
    const totalBox = document.getElementById("cart-total");
    const totalAmount = document.getElementById("total-amount");

    if (emptyNotice) emptyNotice.remove();
    totalBox.style.display = "flex";

    const item = document.createElement("div");
    item.classList.add("product-item");
    item.innerHTML = `
      <span>${name}</span>
      <span>₱${price}</span>
    `;

    cartItems.appendChild(item);

    total += price;
    totalAmount.textContent = `₱${total}`;
  }

</script>

</body>
</html>

<?php
require 'footer.php';
?>
