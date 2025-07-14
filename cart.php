<?php
require 'header.php';
?>

<title>Shopping Cart</title>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    if (localStorage.getItem("isLoggedIn") !== "true") {
        window.location.href = "/pages/Sign_In_Up/signin.html";
    }

    updateTotals();

    document.querySelector(".clear-cart-btn").addEventListener("click", clearCart);

    document.querySelector(".apply-btn").addEventListener("click", () => {
        const promo = document.getElementById("promo").value.trim();
        if (promo.toLowerCase() === "save10") {
            Swal.fire("Promo applied!", "₱10 off", "success");
            discount = 10;
        } else {
            Swal.fire("Invalid code", "", "error");
            discount = 0;
        }
        updateTotals();
    });

    document.getElementById("checkout-btn").addEventListener("click", () => {
        if (document.querySelectorAll(".product").length === 0) {
            Swal.fire("Your cart is empty!", "", "warning");
            return;
        }
        Swal.fire("Checkout successful!", "Paid via QR Ph", "success");
    });
});

let discount = 0;

function updateTotals() {
    let total = 0;
    const products = document.querySelectorAll(".product");

    products.forEach(product => {
        const qty = parseInt(product.querySelector("input").value);
        const price = parseFloat(product.querySelector(".product-price p").textContent.replace(/[₱\s]/g, ''));
        const productTotal = qty * price;
        product.querySelector(".product-total p").textContent = `₱ ${productTotal}`;
        total += productTotal;
    });

    total -= discount;

    document.getElementById("cart-header-items").textContent = `Items ${products.length}`;
    document.getElementById("cart-header-total").textContent = `₱ ${total}`;
    document.querySelector(".total-cost").value = `₱ ${total}`;
}

function clearCart() {
    Swal.fire({
        title: 'Clear your cart?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        icon: 'warning'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("cart-items").innerHTML = '';
            updateTotals();
        }
    });
}

function addToCart(name, price, imageSrc) {
    const cartItems = document.getElementById("cart-items");

    const product = document.createElement("div");
    product.className = "product";
    product.innerHTML = `
        <div class="product-image">
            <img src="${imageSrc}" alt="${name}">
        </div>
        <div class="product-details">
            <h5>${name}</h5>
            <h6><a href="#" class="remove-link">Remove</a></h6>
        </div>
        <div class="product-quantity">
            <button class="qty-minus"><i class='bx bx-minus'></i></button>
            <input type="text" value="1" readonly>
            <button class="qty-plus"><i class='bx bx-plus'></i></button>
        </div>
        <div class="product-price">
            <p>₱ ${price}</p>
        </div>
        <div class="product-total">
            <p>₱ ${price}</p>
        </div>
    `;

    cartItems.appendChild(product);

    // Add functionality to new buttons
    product.querySelector(".qty-plus").addEventListener("click", () => {
        const input = product.querySelector("input");
        input.value = parseInt(input.value) + 1;
        updateTotals();
    });

    product.querySelector(".qty-minus").addEventListener("click", () => {
        const input = product.querySelector("input");
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            updateTotals();
        }
    });

    product.querySelector(".remove-link").addEventListener("click", (e) => {
        e.preventDefault();
        product.remove();
        updateTotals();
    });

    updateTotals();
}
</script>

<!-- SHOPPING CART -->
<div class="container-2">
    <div class="poke-cart">
        <div class="poke-cart-nav">
            <div><p>Product Details</p></div>
            <p class="quantity-label">Quantity</p>
            <p>Price</p>
            <p>Total</p>
        </div>

        <div class="line"><hr></div>
        <div id="cart-items"></div>

        <div class="remove-btn">
            <button class="clear-cart-btn">Clear Cart</button>
        </div>
    </div>

    <div class="cart-summary">
        <div class="cart-header">
            <div><p id="cart-header-items">Items 0</p></div> 
            <p id="cart-header-total">₱ 0</p> 
        </div>

        <!-- Fixed QR Ph Payment Display -->
        <div class="cart-section">
            <p><strong>Payment Method:</strong> QR Ph</p>
        </div>

        <div class="cart-section">
            <label for="promo"><p>Promo Code</p></label>
            <input type="text" id="promo" placeholder="Enter your code">
            <button class="apply-btn">Apply</button>
        </div>

        <div class="cart-section">
            <input type="text" class="total-cost" placeholder="TOTAL COST" disabled>
        </div>

        <button id="checkout-btn" class="checkout-btn">Checkout</button>
    </div>
</div>

<?php
require 'footer.php';
?>
