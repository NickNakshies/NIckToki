<?php require 'header.php'; ?>

<h2>Checkout</h2>

<div class="checkout-container">
  <div class="payment-left">
     <div class="scan-title" style="margin-left: 55%; margin-top: -20px;">
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

   <!-- Wrap this around the image -->
    <div class="image-container">
      <label for="receipt" style="cursor: pointer;">
        <img id="receipt-preview" src="assets/uploadreceipt.png" alt="Upload Receipt">
      </label>
    </div>
    <!-- Label + Instructions -->
    <div style="margin-top: 10px;">
      <label for="receipt" class="upload-label" 
             style="display: block; cursor: pointer; color: #fff; margin-top: 30px; text-decoration: underline; font-size:20px;">
        Upload Receipt
      </label>
      <small style="display: block; color: #ccc;">wait for email confirmation</small>
    </div>

    <!-- Hidden file input -->
    <input type="file" id="receipt" name="receipt" accept="image/*" style="display: none;">

    <!-- File name display -->
    <p id="file-name" style="color: #ccc; font-size: 0.9em; margin-top: 5px;"></p>
  </div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Button -->
<button 
  style="background-color: rgba(56, 182, 255, 0.41); border-radius: 30px; border: none; color: white; padding: 10px 20px; cursor: pointer; margin-top:28px;"
  onclick="placeOrder()"
>
  Place Order
</button>

<!-- Script -->
<script>
  function placeOrder() {
    Swal.fire({ 
      icon: 'success',
      title: 'Thank you for your order!',
      html: 'Your order has been successfully processed.<br>Please wait for an email confirmation for your order receipt.<br> ',
      confirmButtonText: 'OK',
      confirmButtonColor: '#38b6ff'
    });
  }

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