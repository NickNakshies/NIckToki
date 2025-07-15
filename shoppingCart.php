<?php
require 'header.php';
?>


<div class="checkout-container">
    <div class="checkout-header">
        <h1>Checkout</h1>
    </div>
    
    <div class="checkout-content">
        <div class="cart-table">
            <div class="table-header">
                <div class="header-item product-col">Product</div>
                <div class="header-item quantity-col">Quantity</div>
                <div class="header-item price-col">Price</div>
                <div class="header-item total-col">Total</div>
            </div>
            
            <!-- Cart items will be loaded here by JavaScript -->
            <div id="checkout-cart-container">
                <div class="empty-cart-msg">Your cart is empty.</div>
            </div>
            
            <div class="cart-footer">
                <div class="total-section">
                    <span class="total-label">Total</span>
                    <span class="total-amount" id="checkout-total">₱0</span>
                </div>
                <button class="checkout-btn" onclick="proceedToPayment()">
                    Proceed to Checkout
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Include SweetAlert2 for better UX -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    loadCheckoutCart();
});

// Helper function to parse price string and convert to number
function parsePrice(priceString) {
    if (typeof priceString === 'number') {
        return priceString;
    }
    
    // Remove commas and convert to number
    const cleanPrice = priceString.toString().replace(/,/g, '');
    const numericPrice = parseFloat(cleanPrice);
    
    return isNaN(numericPrice) ? 0 : numericPrice;
}

function loadCheckoutCart() {
    const products = JSON.parse(localStorage.getItem("cart")) || [];
    const container = document.getElementById('checkout-cart-container');
    
    if (products.length === 0) {
        container.innerHTML = '<div class="empty-cart-msg">Your cart is empty.</div>';
        document.getElementById('checkout-total').textContent = '₱0';
        return;
    }
    
    let productHTML = '';
    let grandTotal = 0;
    
    products.forEach((item, index) => {
        // Parse the price to ensure it's a number
        const itemPrice = parsePrice(item.price);
        const itemQuantity = parseInt(item.quantity) || 1;
        const itemTotal = itemPrice * itemQuantity;
        
        grandTotal += itemTotal;
        
        productHTML += `
            <div class="checkout-item" data-index="${index}">
                <div class="product-info">
                    <img src="${item.image}" alt="${item.name}" class="product-image">
                    <div class="product-details">
                        <h4 class="product-name">${item.name}</h4>
                        <button class="remove-link" onclick="removeFromCart(${index})">remove</button>
                    </div>
                </div>
                <div class="quantity-section">
                    <button class="qty-btn minus" onclick="updateQuantity(${index}, -1)">-</button>
                    <span class="quantity">${itemQuantity}</span>
                    <button class="qty-btn plus" onclick="updateQuantity(${index}, 1)">+</button>
                </div>
                <div class="price-section">₱${itemPrice.toLocaleString()}</div>
                <div class="total-section">₱${itemTotal.toLocaleString()}</div>
            </div>
        `;
    });
    
    container.innerHTML = productHTML;
    document.getElementById('checkout-total').textContent = `₱${grandTotal.toLocaleString()}`;
}

function updateQuantity(index, change) {
    let products = JSON.parse(localStorage.getItem("cart")) || [];
    
    if (products[index]) {
        const currentQuantity = parseInt(products[index].quantity) || 1;
        const newQuantity = currentQuantity + change;
        
        if (newQuantity <= 0) {
            products.splice(index, 1);
        } else {
            products[index].quantity = newQuantity;
        }
        
        localStorage.setItem("cart", JSON.stringify(products));
        loadCheckoutCart();
        
        // Show success message
        if (change > 0) {
            showToast('Quantity increased!', 'success');
        } else if (newQuantity > 0) {
            showToast('Quantity decreased!', 'info');
        }
    }
}

function removeFromCart(index) {
    let products = JSON.parse(localStorage.getItem("cart")) || [];
    
    if (products[index]) {
        const itemName = products[index].name;
        
        Swal.fire({
            title: 'Remove Item?',
            text: `Are you sure you want to remove "${itemName}" from your cart?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#8B5CF6',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Yes, remove it!',
            background: '#1F2937',
            color: '#F3F4F6'
        }).then((result) => {
            if (result.isConfirmed) {
                products.splice(index, 1);
                localStorage.setItem("cart", JSON.stringify(products));
                loadCheckoutCart();
                
                Swal.fire({
                    title: 'Removed!',
                    text: `${itemName} has been removed from your cart.`,
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false,
                    background: '#1F2937',
                    color: '#F3F4F6'
                });
            }
        });
    }
}

function proceedToPayment() {
    const products = JSON.parse(localStorage.getItem("cart")) || [];
    
    if (products.length === 0) {
        Swal.fire({
            title: 'Cart Empty',
            text: 'Please add some products to your cart before proceeding to payment.',
            icon: 'warning',
            background: '#1F2937',
            color: '#F3F4F6',
            confirmButtonColor: '#8B5CF6'
        });
        return;
    }
    
    // Redirect to payment page or show success message
    Swal.fire({
        title: 'Proceed to Payment',
        text: 'You will be redirected to the payment page.',
        icon: 'success',
        background: '#1F2937',
        color: '#F3F4F6',
        confirmButtonColor: '#8B5CF6',
        confirmButtonText: 'Continue'
    }).then((result) => {
        if (result.isConfirmed) {
            // You can redirect to payment page here
            // window.location.href = 'payment.php';
            console.log('Redirecting to payment...');
        }
    });
}

function showToast(message, type) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        background: '#1F2937',
        color: '#F3F4F6',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    
    Toast.fire({
        icon: type,
        title: message
    });
}
</script>

<style>


.checkout-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    display: flex;
    flex-direction: column;
   

}

.checkout-header {
    text-align: center;
    margin-bottom: 40px;
    display: flex;
    justify-content: start;
      margin-left: -7rem;
   
}

.checkout-header h1 {
    font-size: 4rem;
    font-weight: 300;
    margin: 0;
    color: #F3F4F6;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.checkout-content {
  
    background: rgba(0, 0, 0, 0.62);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.3);
    border: 1px solid rgba(255,255,255,0.1);
}

.cart-table {
    width: 100%;
}

.table-header {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 20px;
    padding: 20px 0;
    border-bottom: 1px solid rgba(255,255,255,0.2);
    margin-bottom: 20px;
}

.header-item {
    font-weight: 500;
    color: #CBD5E1;
    text-transform: uppercase;
    font-size: 0.9rem;
    letter-spacing: 0.5px;
}

.product-col {
    text-align: left;
}

.quantity-col,
.price-col,
.total-col {
    text-align: center;
}

.checkout-item {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 20px;
    align-items: center;
    padding: 25px 0;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    transition: all 0.3s ease;
}

.checkout-item:hover {
    background: rgba(255,255,255,0.05);
    border-radius: 10px;
    padding: 25px 15px;
}

.product-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.product-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 12px;
    border: 2px solid rgba(255,255,255,0.1);
}

.product-details {
    flex: 1;
}

.product-name {
    font-size: 1.1rem;
    font-weight: 500;
    margin: 0 0 8px 0;
    color: #F3F4F6;
}

.remove-link {
    background: none;
    border: none;
    color: #10B981;
    cursor: pointer;
    font-size: 0.9rem;
    text-decoration: underline;
    padding: 0;
    font-family: inherit;
    transition: color 0.3s ease;
    text-decoration: none;
}

.remove-link:hover {
    color: #059669;
}

.quantity-section {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
}

.qty-btn {
    width: 35px;
    height: 35px;
    border: 1px solid rgba(255,255,255,0.3);
    background: rgba(255,255,255,0.1);
    color: #F3F4F6;
    cursor: pointer;
    border-radius: 8px;
    font-weight: bold;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.qty-btn:hover {
    background: rgba(255,255,255,0.2);
    transform: scale(1.05);
}

.qty-btn.minus:hover {
    background: rgba(239, 68, 68, 0.3);
    border-color: #EF4444;
}

.qty-btn.plus:hover {
    background: rgba(34, 197, 94, 0.3);
    border-color: #22C55E;
}

.quantity {
    min-width: 40px;
    text-align: center;
    font-weight: 600;
    font-size: 1.1rem;
    color: #F3F4F6;
}

.price-section,
.total-section {
    text-align: center;
    font-weight: 600;
    font-size: 1.1rem;
    color: #F3F4F6;
}

.cart-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 30px 0 0 0;
    border-top: 2px solid rgba(255,255,255,0.2);
    margin-top: 30px;
}

.cart-footer .total-section {
    display: flex;
    align-items: center;
    gap: 20px;
}

.total-label {
    font-size: 1.3rem;
    font-weight: 500;
    color: #CBD5E1;
}

.total-amount {
    font-size: 1.5rem;
    font-weight: 700;
    color: #F3F4F6;
}

.checkout-btn {
    background: linear-gradient(135deg, #8B5CF6 0%, #A855F7 100%);
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
}

.checkout-btn:hover {
    background: linear-gradient(135deg, #7C3AED 0%, #9333EA 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(139, 92, 246, 0.6);
}

.empty-cart-msg {
    text-align: center;
    padding: 60px 20px;
    color: #9CA3AF;
    font-size: 1.2rem;
    font-weight: 500;
}

/* Responsive Design */
@media (max-width: 768px) {
    .checkout-header h1 {
        font-size: 2rem;
    }
    
    .checkout-content {
        padding: 20px;
        border-radius: 15px;
    }
    
    .table-header {
        display: none;
    }
    
    .checkout-item {
        display: block;
        padding: 20px;
        background: rgba(255,255,255,0.05);
        border-radius: 12px;
        margin-bottom: 15px;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .product-info {
        margin-bottom: 15px;
    }
    
    .quantity-section,
    .price-section,
    .total-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .quantity-section::before {
        content: "Quantity:";
        color: #CBD5E1;
    }
    
    .price-section::before {
        content: "Price:";
        color: #CBD5E1;
    }
    
    .total-section::before {
        content: "Total:";
        color: #CBD5E1;
    }
    
    .cart-footer {
        flex-direction: column;
        gap: 20px;
        text-align: center;
    }
    
    .checkout-btn {
        width: 100%;
        padding: 18px;
    }
}
</style>

<?php
require 'footer.php';
?>