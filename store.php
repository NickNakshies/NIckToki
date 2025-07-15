<?php
require 'validations/login_check.php';
require_once 'validations/db_connection.php';
require 'header.php';
?>  

<!-- Add SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
<!-- SEPERATE TS -->
<div class="label-name-1">
    <h1 class="fs-1 ">Bundle Sets</h1>
</div>



            
<!-- ITEM BOXES -->
<section class="item-boxes" id="item-boxes">

    <!-- Item 1 -->
    <div class="card" id="item-1">
        <img class="main-image" src="./assets/card1.png" alt="Main Item Box">
        
        <!-- Hidden description for Blue Wave Build -->
        <div class="item-description" style="display: none;">
            <h3>Blue Wave Build</h3>
            <ul>
               <p>Specification </p>               
                <li>AMD Ryzen 5 5600X</li>
                <li>Deepcool AK400 ZERO DARK PLUS (WHITE)</li>
                <li>ASUS Prime B550M-A WiFi II</li>
                <li>AMD Radeon RX 6600 8GB (WHITE)</li>
                <li>T-Force Delta RGB 16GB (2 x 8GB) DDR4 3200MHz CL16 (WHITE)</li>
                <li>Lexar NM620 1TB NVMe SSD</li>
                <li>Cooler Master MWE 600W 80 Plus Bronze</li>
                <li>Montech AIR 100 ARGB (WHITE)</li>
                <li>2-3 additional ARGB fans</li>
            </ul>
        </div>
        
        <div class="card-content">
            <div>
                <h3>Blue Wave Build</h3>
        
            </div>
            <button class="price-button">₱ <span>46,515</span></button>
        </div>
    </div>

    <!-- Item 2 -->
    <div class="card scroll-offset" id="item-2">
        <img class="main-image" src="./assets/card2 (1).png" alt="Main Item Box">
        
        <!-- Hidden description for Mobo Combo -->
        <div class="item-description" style="display: none;">
            <h3>Mobo Combo</h3>
            <ul>
               <p>Specification </p>               
                <li>ASUS ROG Strix </li>
                <li>AMD Ryzen 7 5800X</li>
                <li>NVIDIA GeForce GTX 1080 Ti</li>

            </ul>
        </div>
    
        <div class="card-content">
            <div>
                <h3>Mobo Combo</h3>
                
            </div>
            <button class="price-button">₱ <span>14,500</span></button>
        </div>
    </div>

    <!-- Item 3 -->
    <div class="card" id="item-3">
        <img class="main-image" src="./assets/card3.png" alt="Main Item Box">
        
        <!-- Hidden description for KM Set -->
        <div class="item-description" style="display: none;">
            <h3>KM Set</h3>
            <ul>
              <p>Specification </p>
                <li>Royal Kludge 84 Keyboard</li>
                <li>Logitech G Pro X Superlight (White)</li>
   
            </ul>
        </div>
        
        <div class="card-content">
            <div>
                <h3>KM Set</h3>
               
            </div>
            <button class="price-button">₱ <span>7,459</span></button>
        </div>
    </div>

    <!-- Item 4 -->
    <div class="card" id="item-4">
        <img class="main-image" src="./assets/card4.png" alt="Main Item Box">
        
        <!-- Hidden description for Store It Bundle -->
        <div class="item-description" style="display: none;">
            <h3>Store It Bundle</h3>
            <ul>
                <p>Specification </p>
                <li>Team Group 1TB SSD</li> 
                <li>HyperX Fury 2x16 GB RAM</li>
            </ul>

        </div>
        
        <div class="card-content">
            <div>
                <h3>Store It Bundle</h3>
               
            </div>
            <button class="price-button">₱ <span>8,500</span></button>
        </div>
    </div>

    <!-- Item 5 -->
    <div class="card" id="item-5">
        <img class="main-image" src="./assets/card5.png" alt="Main Item Box">
        
        <!-- Hidden description for The Ultimate -->
        <div class="item-description" style="display: none;">
            <h3>The Ultimate</h3>
            <ul>
               <p>Specification </p>               
            <li>Intel Core i7-14700K</li>
            <li>ASUS ROG Strix Z790-E Gaming WiFi</li>
            <li>Lian Li Galahad AIO 360mm</li>
            <li>Corsair Vengeance RGB DDR5 32GB (2x16GB) 6000MHz</li>
            <li>Nvidia GeForce RTX 4070 Ti SUPER</li>
            <li>Samsung 990 Pro SSD 2TB</li>
            <li>Corsair RMx Shift 850W 80 Plus Gold</li>
            <li>Lian Li O11 Dynamic EVO (White)</li>
            </ul>
        </div>
       
        <div class="card-content">
            <div>
                <h3>The Ultimate</h3>
            </div>
            <button class="price-button">₱ <span>145,892</span></button>
        </div>
    </div>

</section>

<?php
require 'footer.php';
?>


<script>
let scrollY = 0; // Store scroll position globally

document.addEventListener("DOMContentLoaded", function () {
    const cards = document.querySelectorAll(".card");

    cards.forEach(card => {
        card.addEventListener("click", function (event) {
            event.preventDefault();
            event.stopPropagation();

            const imageSrc = this.querySelector(".main-image")?.src || "";
            const itemName = this.querySelector("h3")?.textContent || "Unnamed Item";
            const itemDescription = this.querySelector("p")?.textContent || "No description available.";
            const itemPrice = this.querySelector(".price-button span")?.textContent || "0.00";
            const itemId = this.id;

            // Get the item description
            const descriptionElement = this.querySelector(".item-description");
            const descriptionHTML = descriptionElement ? descriptionElement.innerHTML : "<p>No specifications available.</p>";

            console.log("Item Clicked:", {imageSrc, itemName, itemDescription, itemPrice, itemId });

            if (!imageSrc || !itemName) {
                console.error("Missing item details! Check your HTML structure.");
                return; 
            }

            // Store current scroll position
            scrollY = window.pageYOffset || document.documentElement.scrollTop;
            console.log("Stored Scroll Position:", scrollY);

            // Prevent body scroll while modal is open
            document.body.style.position = 'fixed';
            document.body.style.top = `-${scrollY}px`;
            document.body.style.width = '100%';

            // Get small images and related data
            const smallImages = this.querySelectorAll(".small-images img");
            const quantities = this.querySelectorAll(".small-images span");
            const smallImageNames = this.querySelectorAll(".small-images .hidden-name"); 
            const extraNameElement = this.querySelector(".hiddens-name"); 
            const extraName = extraNameElement ? extraNameElement.textContent.trim() : "";

            let smallImagesHTML = `<ul style="list-style: none; padding: 0; margin: 0; display: flex; gap: 20px; flex-wrap: wrap; justify-content: center;">`; 

            smallImages.forEach((img, index) => {
                const quantity = quantities[index] ? quantities[index].textContent : "1";
                const name = smallImageNames[index] ? smallImageNames[index].textContent.trim() : `Item ${index + 1}`;

                smallImagesHTML += `
                    <li style="display: flex; flex-direction: column; align-items: center; text-align: center; width: 80px;">
                        <img src="${img.src}" alt="${name}" style="width: 50px; height: 50px; border-radius: 5px; flex-shrink: 0;">
                        <p style="margin: 0px; font-weight: bold; font-size: 15px; white-space: normal; word-wrap: break-word; text-align: center;">${name}</p>
                        <p style="margin: 0; font-weight: bold; font-size: 15px; color: gray;">x${quantity}</p>
                    </li>
                `;
            });

            smallImagesHTML += `</ul>`; 

            // Extra name for specific items
            let extraNameHTML = "";
            if (["coin-1", "coin-2", "coin-3", "coin-4", "coin-5", "coin-6", "mystery-box-1"].includes(itemId) && extraName) {
                extraNameHTML = `<p style="display: block; color: blue; font-weight: bold; text-align: center; margin-bottom: 30px; margin-top:20px;">${extraName}</p>`;
            }

            // Show SweetAlert modal with exact styling from image
            Swal.fire({
                title: itemName,
                html: `
                    <div style="display: flex; gap: 30px; align-items: flex-start; margin-bottom: 30px;">
                        <div style="flex: 1; text-align: center;">
                            <img src="${imageSrc}" alt="${itemName}" style="width: 200px; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 20px;">
                        </div>
                        <div style="flex: 2; text-align: left;">
                            <h2 style="color: white; font-size: 48px; font-weight: bold; margin: 0 0 20px 0; line-height: 1.1;">${itemName}</h2>
                            <h3 style="color: white; font-size: 32px; font-weight: bold; margin: 0 0 30px 0;">₱${itemPrice}</h3>
                            <div style="color: white; font-size: 16px; line-height: 1.5;">
                                ${descriptionHTML}
                            </div>
                        </div>
                    </div>
                    ${extraNameHTML}
                    <div style="display: flex; justify-content: center; flex-wrap: wrap; margin-bottom: 30px;">${smallImagesHTML}</div>
                    <div style="display: flex; gap: 20px; justify-content: center;">
                        <button id="add-to-cart-btn" 
                            style="background: #24709f; color: white; border: none; border-radius: 25px; padding: 15px 30px; font-size: 16px; font-weight: bold; cursor: pointer; transition: all 0.3s ease;">
                            Add to Cart
                        </button>
                        <button id="purchase-now-btn" 
                            style="background: #84579c; color: white; border: none; border-radius: 25px; padding: 15px 30px; font-size: 16px; font-weight: bold; cursor: pointer; transition: all 0.3s ease;">
                            Purchase Now
                        </button>
                    </div>
                `,
                showConfirmButton: false,
                showCloseButton: true,
                position: "center",
                backdrop: true,
                width: '800px',
                customClass: { 
                    popup: "custom-swal-popup-exact"
                },
                didOpen: () => {
                    // Add to Cart button functionality
                    document.querySelector("#add-to-cart-btn").addEventListener("click", function () {
                        addToCart(itemName, imageSrc, itemPrice);
                        Swal.close();

                        setTimeout(() => {
                            Swal.fire({
                                title: "Item Added to Cart!",
                                text: `${itemName} has been added to your cart.`,
                                icon: "success",
                                confirmButtonText: "OK",
                                confirmButtonColor: "#0003c1ff"
                            }).then(() => {
                                restoreScroll();
                            });
                        }, 200);
                    });

                    // Purchase Now button functionality
                    document.querySelector("#purchase-now-btn").addEventListener("click", function () {
                        // Add your purchase logic here
                        Swal.close();
                        
                        setTimeout(() => {
                            Swal.fire({
                                title: "Redirecting to Checkout...",
                                text: `Processing purchase for ${itemName}`,
                                icon: "info",
                                confirmButtonText: "OK",
                                confirmButtonColor: "#8b5cf6"
                            }).then(() => {
                                restoreScroll();
                                // Add redirect to checkout page here
                                // window.location.href = '/checkout';
                            });
                        }, 200);
                    });

                    // Hover effects for buttons
                    const addToCartBtn = document.querySelector("#add-to-cart-btn");
                    const purchaseBtn = document.querySelector("#purchase-now-btn");
                    
                    addToCartBtn.addEventListener("mouseenter", function() {
                        this.style.background = "#4f46e5";
                        this.style.transform = "scale(1.05)";
                    });
                    
                    addToCartBtn.addEventListener("mouseleave", function() {
                        this.style.background = "#6366f1";
                        this.style.transform = "scale(1)";
                    });
                    
                    purchaseBtn.addEventListener("mouseenter", function() {
                        this.style.background = "#7c3aed";
                        this.style.transform = "scale(1.05)";
                    });
                    
                    purchaseBtn.addEventListener("mouseleave", function() {
                        this.style.background = "#8b5cf6";
                        this.style.transform = "scale(1)";
                    });
                },
                willClose: () => {
                    restoreScroll();
                }
            });
        });
    });
});

function restoreScroll() {
    console.log("Restoring Scroll Position:", scrollY);
    
    // Restore body scroll
    document.body.style.position = '';
    document.body.style.top = '';
    document.body.style.width = '';
    
    // Restore scroll position
    window.scrollTo(0, scrollY);
    
    console.log("Scroll Restored!");
}

function addToCart(itemName, imageSrc, itemPrice) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Check if item already exists in cart
    let existingItem = cart.find(item => item.name === itemName);

    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            name: itemName,
            image: imageSrc,
            price: itemPrice,
            quantity: 1
        });
    }
    
    localStorage.setItem("cart", JSON.stringify(cart));
    
    if (typeof renderCart === "function") {
        renderCart();
    }
}
</script>