<?php
require 'validations/login_check.php';
require_once 'validations/db_connection.php';
require 'header.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<div class="p-4 mt-5 row ms-4 mb-3 profile-container">
    <h2 class="profile-text" style="color: #fff; transform: scale(1.2); margin-left: 12%;">Profile</h2>
</div>

<div class="container mt-5 overflow-scroll profile-window">
<form id="formValidate" action="save_profile.php" method="POST" enctype="multipart/form-data">
    <div class="row p-1 ms-1">
        <div class="col-lg-3 ms-4 mt-5">
            <label for="file">
                <div class="profile-pic shadow" id="set-pic" 
                style="background-image: url('user_pics/<?php echo htmlspecialchars($user['user_pic']); ?>')">
                    <span><i class="bi bi-camera fs-1"></i></span>
                </div>
            </label>
            <input type="file" name="file" id="file" accept="image/*" onchange="loadFile(event)">
        </div>
        <div class="col-md-5 fs-4 mt-5 ms-2 me-5 pt-5 username-fade">
            <strong class="me-3">Full Name:</strong><span><?php echo htmlspecialchars($user['user_name']); ?></span><br>
            <strong class="me-3">Date Joined:</strong><span><?php echo htmlspecialchars($user['user_joindate']); ?></span>
        </div>
    </div>
    <div class="row p-4 mt-4 ms-4 fw-bold fs-5 pb-5">
        <div class="col col-lg-3 ms-2">
            <a href="#" class="profile-link row mb-3">Profile Settings</a>
            <a href="/pages/Past_Orders/orders.html" class="profile-link row mb-4">View Orders</a>
        </div>
        <div class="col me-5">
            <div class="row">
                <div class="col">
                    <label for="email" style="color: #d9d9d9;">Email</label><br>
                    <input type="email" name="email" class="form-control" id="email" value="<?php echo htmlspecialchars($user['user_email']); ?>" required style="width: 82%;"><br>

                    <label for="password" class="fw-bold" style="color: #d9d9d9;">Password</label>
                    <div class="input-group" style="width: 82%;">
                        <input type="password" name="password" class="form-control" id="password" value="" placeholder="Enter new password if changing">
                        <button class="btn btn-outline-light" type="button" id="togglePassword"><i class="bi bi-eye"></i></button>
                    </div>
                </div>
                <div class="col">
                    <label for="deliveryAddress" class="fw-bold" style="color: #d9d9d9;">Delivery Address</label>
                    <div class="input-group" style="width: 78%;">
                        <input type="text" name="deliveryAddress" class="form-control" id="deliveryAddress" value="<?php echo htmlspecialchars($user['user_address']); ?>" required>
                        <button class="btn btn-outline-light" type="button">Edit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-auto mt-4 ms-5">
            <a href="validations/logout.php" id="logout-btn" class="profile-link fs-3 fw-bold" style="color: #0cc0df;">
                <i class="bi bi-power me-3"></i>Log Out
            </a>
        </div>
        <div class="col"></div>
        <div class="col-auto mt-3 me-5">
            <button type="submit" class="btn rounded-pill text-light fs-5 px-4 py-3 fw-bold shadow-lg viewOrder"
                style="background-color: rgba(217, 141, 252, 0.5);">
                <i class="bi bi-floppy me-2"></i> Save Settings
            </button>
        </div>
    </div>
</form>
</div>

<script>
function loadFile(event) {
    event.preventDefault();
    let reader = new FileReader();
    reader.onload = function () {
        document.getElementById("set-pic").style.backgroundImage = `url('${reader.result}')`;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

<?php require 'footer.php'; ?>
