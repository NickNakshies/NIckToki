<?php
require 'header.php';
?>

<!-- SIGN IN TITLE -->
<div>
    <h2 id="signup-title"> 
        Log In
    </h2>
</div>

<!-- SIGN IN FORM -->
<div class="signin-form">
  <form action="store.php" method="POST" id="signinForm">
    <div class="signin-info">
      <label for="email" class="form-label">Email</label>
      <div class="signup-input">
        <input type="email" class="form-input2" id="email" name="email" placeholder=" " required>
        <small id="emailError" class="text-danger d-none"></small>
      </div>
    </div>

    <div class="signin-info">
      <label for="password" class="form-label">Password</label>
      <div class="signup-input">
        <input type="password" class="form-input2" id="password" name="password" placeholder=" " required>
      </div>
    </div>

    <div class="submit-button2">
      <button type="submit" id="form-submit2">SIGN IN</button>
    </div>

    <div class="create-account">
      <p>Don't have an account?</p>
      <p><a href="signup.php">Create Account</a></p>
    </div>
  </form>
</div>

<script>
document.getElementById('signinForm').addEventListener('submit', function(event) {
  event.preventDefault();

  const email = document.getElementById('email').value.trim();
  const password = document.getElementById('password').value.trim();
  const emailError = document.getElementById('emailError');

  emailError.classList.add('d-none');
  emailError.textContent = '';

  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  let valid = true;

  if (!emailPattern.test(email)) {
    emailError.textContent = 'Please enter a valid email address.';
    emailError.classList.remove('d-none');
    valid = false;
  }
  if (password.length === 0) {
    alert('Please enter your password.');
    valid = false;
  }

  if (valid) {
    this.submit();
  }
});
</script>

<?php
require 'footer.php';
?>
