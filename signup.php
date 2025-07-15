<?php
require 'header.php';
?>

<!-- SIGN UP TITLE -->
<div>
    <h2 id="signup-title"> 
        Sign Up
    </h2>
</div>

<!-- SIGN UP FORM -->
<div>
    <form action="signin.php" method="POST" id="signupForm">
        <div class="signup-info"> 
            <!-- NAME FORM -->
            <label for="full-name" class="form-label">
                Full Name<span class="asterisk">*</span>
            </label>
            <div class="signup-input"> 
                <input type="text" name="full_name" class="form-input" id="full-name" placeholder=" " required>
            </div>
        </div>

        <!-- EMAIL FORM -->
        <div class="signup-info">
            <label for="email" class="form-label">
                Email<span class="asterisk">*</span>
            </label>
            <div class="signup-input">
                <input type="email" name="email" class="form-input" id="email" placeholder=" " required>
                <small id="emailError" class="text-danger d-none"></small>
            </div>
        </div>

        <!-- PASSWORD FORM -->
        <div class="signup-info">
            <label for="password" class="form-label">
                Password<span class="asterisk">*</span>
            </label>
            <div class="signup-input">
                <input type="password" name="password" class="form-input" id="password" placeholder=" " required>
            </div>
        </div>

        <!-- PHONE NUMBER FORM -->
        <div class="signup-info">
            <label for="phone-number" class="form-label">
                Phone Number
            </label>
            <div class="signup-input">
                <input type="tel" name="phone_number" class="form-input" id="phone-number" placeholder=" ">
            </div>
        </div>

        <!-- FORM SUBMIT BUTTON -->
        <div class="submit-button"> 
            <button type="submit" id="form-submit">
                Create Account
            </button>
        </div>
    </form>
</div>

<script>
    // Client-side validation before submitting form
    document.getElementById('signupForm').addEventListener('submit', function(e) {
        const fullName = document.getElementById('full-name').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const phone = document.getElementById('phone-number').value.trim();

        // Basic full name validation
        if (fullName.length < 2) {
            alert('Please enter your full name.');
            e.preventDefault();
            return;
        }

        // Simple email format check
        if (!email || !email.includes('@')) {
            alert('Please enter a valid email address.');
            e.preventDefault();
            return;
        }

        // Password length check
        if (!password || password.length < 6) {
            alert('Password must be at least 6 characters.');
            e.preventDefault();
            return;
        }

        // Optional: phone number format validation (basic)
        if (phone && !/^\+?[0-9\s\-]{7,15}$/.test(phone)) {
            alert('Please enter a valid phone number.');
            e.preventDefault();
            return;
        }
    });
</script>

<?php
require 'footer.php';
?>
