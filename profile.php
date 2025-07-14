<?php
require 'header.php';
?>

<!--Profile-->
        <div class="p-4 mt-1 row">
            <h2 class="fw-bold fs-1" style="color: #d9d9d9; text-shadow: 2px 2px 5px #727272;">Profile</h2>
        </div>
        <div class="row p-1 ms-4">
            <div class="col-lg-3 ms-4">
                <form>
                    <label for="file">
                        <div class="profile-pic shadow" id="set-pic" style="background-image: url('https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png')">
                            <span style="margin-top: -20%;"><i class="bi bi-camera fs-1"></i></span>
                        </div>
                    </label>
                    <input type="file" name="file" id="file" accept="image/*" onchange="loadFile(event)">
                </form>
            </div>
            <div class="col-md-5 fw-bold fs-4 mt-3 ms-5 me-3 username-fade">
                <strong class="me-3">User ID:</strong><span id="playerID"></span><br>
            </div>
            <div class="col ms-1">
                <div style="position: relative; display: inline-block;" class="viewOrder">
                    <a href="/pages/Past_Orders/orders.html" class="btn rounded-pill bg-primary text-light fs-5 fw-bold px-4 py-3 mt-3 shadow"> View All Orders</a>
                    <img src="../../assets/Pikachu.png" alt="" style="position: absolute; height: 85%; top: -40%; left: 65%;"></img>
                </div>
                
            </div>
        </div>
        <div class="row p-4 mt-1 ms-4 fw-bold fs-4 pb-5">
            <div class="col col-lg-3 ms-2">
                <a href="#" class="profile-link row" style="margin-bottom: 5%;">Profile Settings</a>
                <a href="/pages/Past_Orders/orders.html" class="profile-link row" style="margin-bottom: 10%;">View Orders</a>
            </div>

            <!--User Info-->
            <div class="col me-5">
                <div class="row">
                    <div class="col">
                        <label style="color: #d9d9d9; text-shadow: 2px 2px 5px #5c5c5c;">User Name</label><br>
                        <input type="text" id="name" class="form-control" placeholder="Name" required style="width: 82%;"><br>
                    </div>
                    <div class="col">
                        <label class="fw-bold" style="color: #d9d9d9; text-shadow: 2px 2px 5px #5c5c5c;">Password</label>
                        <div class="input-group" style="width: 75%;">
                            <input type="password" class="form-control" id="password" placeholder="Password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <form id="formValidate">
                <div class="row">
                    <div class="col">
                        <label style="color: #d9d9d9; text-shadow: 2px 2px 5px #5c5c5c;">Email Address</label><br>
                        <input type="email" class="form-control" id="email" placeholder="Email Address" required style="width: 40%;">
                    </div>
                </div>                    
            </div>

            <!--Log out and Save button-->
            <div class="row" style="margin-top: 5%;">         
                <div class="col mt-3">
                    <a href="/pages/Sign_In_Up/signin.html" id="logout-btn" class="text-danger profile-link" ><i class="bi bi-power me-3"></i>Log Out</a>
                </div>    
                <div class="col offset-lg-6">
                    <button type="submit" class="btn ms-3 rounded-pill bg-primary text-light fs-5 px-4 py-3 fw-bold shadow-lg viewOrder" onclick="saveUserData()"><i class="bi bi-floppy me-2"></i> Save Settings</button>
                </div>       
            </div>
            </form>
        </div>  

<?php
require 'footer.php';
?>