<?php
require 'header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="signupdesign.css">
</head>

<body>

    <!-- SIGN UP TITLE -->
    <div>
        <h2 id="signup-title"> 
            Sign Up
        </h2>
    </div>

    <!-- SIGN UP FORM -->
    <div>
        <form>
            <div class="signup-info"> 

                <!-- NAME FORM -->
                <label for="full-name" class="form-label">
                    Full Name*
                </label> 

                <div class="signup-input"> 
                    <input type="text" class="form-input" id="full-name" placeholder=" " required>
                </div>

            </div>

            <!-- EMAIL FORM -->
            <div class="signup-info">
                <label for="email" class="form-label">
                    Email*
                </label>

                <div class="signup-input">
                    <input type="email" class="form-input" id="email" placeholder=" " required>
                    <small id="emailError" class="text-danger d-none"></small>
                </div>
            </div>

            <!-- PASSWORD FORM -->
            <div class="signup-info">
                <label for="password" class="form-label">
                    Password*
                </label>

                <div class="signup-input">
                    <input type="password" class="form-input" id="password" placeholder=" " required>
                </div>
            </div>

            <!-- PHONE NUMBER FORM -->
            <div class="signup-info">
                <label for="phone-number" class="form-label">
                    Phone Number
                </label>

                <div class="signup-input">
                    <input type="tel" class="form-input" id="phone-number" placeholder=" ">
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

</body>
</html>

<?php
require 'footer.php';
?>
