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
    <form>
        <div class="signin-info">
            <label for="email" class="form-label">Email</label>
            <div class="signup-input">
                <input type="email" class="form-input2" id="email" placeholder=" " required>
                <small id="emailError" class="text-danger d-none"></small>
            </div>
        </div>

        <div class="signin-info">
            <label for="password" class="form-label">Password</label>
            <div class="signup-input">
                <input type="password" class="form-input2" id="password" placeholder=" " required>
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

<?php
require 'footer.php';
?>
