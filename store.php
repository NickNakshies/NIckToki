<?php
require 'header.php';
?>  

<!-- Add SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
<!-- SEPERATE TS -->
<div class="label-name-1">
    <h1>Item Boxes</h1>
</div>
            
<!-- ITEM BOXES -->
<section class="item-boxes" id="item-boxes">

    <!-- Item 1 -->
    <div class="card" id="item-1">
        <img class="main-image" src="./assets/card1.png" alt="Main Item Box">
        
        <div class="card-content">
            <div>
                <h3>Blue Wave Build</h3>
                <p>Can only be purchased 1 time</p>
            </div>
            <button class="price-button">₱ <span>34, 515</span></button>
        </div>
    </div>

    <!-- Item 2 -->
    <div class="card scroll-offset" id="item-2">
        <img class="main-image" src="./assets/card2.png" alt="Main Item Box">
    
        <div class="card-content">
            <div>
                <h3>Mobo Combo</h3>
                <p>Can only be purchased 1 time</p>
            </div>
            <button class="price-button">₱ <span>14, 500</span></button>
        </div>
    </div>

    <!-- Item 3 -->
    <div class="card" id="item-3">
        <img class="main-image" src="./assets/card3.png" alt="Main Item Box">
        
        <div class="card-content">
            <div>
                <h3>KM Set</h3>
                <p>Can only be purchased 3 times</p>
            </div>
            <button class="price-button">₱ <span>7, 459</span></button>
        </div>
    </div>

    <!-- Item 4 -->
    <div class="card" id="item-4">
        <img class="main-image" src="./assets/card4.png" alt="Main Item Box">
        
        <div class="card-content">
            <div>
                <h3>Store It Bundle</h3>
                <p>Can only be purchased 3 times</p>
            </div>
            <button class="price-button">₱ <span>8, 500</span></button>
        </div>
    </div>

    <!-- Item 5 -->
    <div class="card" id="item-5">
        <img class="main-image" src="./assets/card5.png" alt="Main Item Box">
       
        <div class="card-content">
            <div>
                <h3>The Ultimate</h3>
                <p><br></p>
                <br>
            </div>
            <button class="price-button">₱ <span>145, 892</span></button>
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

            // Show SweetAlert modal
            Swal.fire({
                title: itemName,
                html: `
                    <img src="${imageSrc}" alt="${itemName}" style="width: 100%; max-width: 250px; border-radius: 10px; margin-bottom: 120px;">
                    <h3 style="color: #fdffd6; font-weight:bold">₱ ${itemPrice}</h3>
                    ${extraNameHTML}
                    <div style="display: flex; justify-content: center; flex-wrap: wrap;">${smallImagesHTML}</div>
                    <button id="add-to-cart-btn" class="swal2-confirm swal2-styled" 
                        style="background: #d30e0e; border-radius: 30px; padding: 10px 20px; font-size: 16px; margin-top: 15px;">
                        Add to Cart
                    </button>
                `,
                showConfirmButton: false,
                showCloseButton: true,
                position: "center",
                backdrop: true,
                customClass: { popup: "custom-swal-popup" },
                didOpen: () => {
                    document.querySelector("#add-to-cart-btn").addEventListener("click", function () {
                        addToCart(itemName, imageSrc, itemPrice);
                        Swal.close();

                        setTimeout(() => {
                            Swal.fire({
                                title: "Item Added to Cart!",
                                text: `${itemName} has been added to your cart.`,
                                icon: "success",
                                confirmButtonText: "OK",
                                confirmButtonColor: "#d30e0e"
                            }).then(() => {
                                restoreScroll();
                            });
                        }, 200);
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