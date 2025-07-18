<?php
require 'validations/login_check.php';
require_once 'validations/db_connection.php';
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    loadCheckoutCart();
});

function loadCheckoutCart() {
    fetch('validations/fetchcartitems.php')
    .then(response => response.json())
    .then(cartItems => {
        const container = document.getElementById('checkout-cart-container');
        if (!cartItems.length) {
            container.innerHTML = '<div class="empty-cart-msg">Your cart is empty.</div>';
            document.getElementById('checkout-total').textContent = '₱0';
            return;
        }

        let productHTML = '';
        let grandTotal = 0;

        cartItems.forEach((item, index) => {
            const itemPrice = parseFloat(item.item_price);
            const itemQuantity = parseInt(item.quantity);
            const itemTotal = itemPrice * itemQuantity;
            grandTotal += itemTotal;

            productHTML += `
                <div class="checkout-item" data-item-id="${item.item_id}">
                    <div class="product-info">
                        <img src="${item.item_image}" alt="${item.item_name}" class="product-image">
                        <div class="product-details">
                            <h4 class="product-name">${item.item_name}</h4>
                            <button class="remove-link" onclick="removeFromCart(${item.item_id})">remove</button>
                        </div>
                    </div>
                    <div class="quantity-section">
                        <button class="qty-btn minus" onclick="updateQuantity(${item.item_id}, -1)">-</button>
                        <span class="quantity">${itemQuantity}</span>
                        <button class="qty-btn plus" onclick="updateQuantity(${item.item_id}, 1)">+</button>
                    </div>
                    <div class="price-section">₱${itemPrice.toLocaleString()}</div>
                    <div class="total-section">₱${itemTotal.toLocaleString()}</div>
                </div>
            `;
        });

        container.innerHTML = productHTML;
        document.getElementById('checkout-total').textContent = `₱${grandTotal.toLocaleString()}`;
    });
}

function updateQuantity(itemId, change) {
    fetch('validations/updatecartquantity.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `item_id=${itemId}&change=${change}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            loadCheckoutCart();
        }
    });
}

function removeFromCart(itemId) {
    Swal.fire({
        title: 'Remove Item?',
        text: 'Are you sure you want to remove this item from your cart?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#8B5CF6',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Yes, remove it!'
    }).then(result => {
        if (result.isConfirmed) {
            fetch('validations/removecartitem.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `item_id=${itemId}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    loadCheckoutCart();
                    Swal.fire('Removed!', 'Item has been removed.', 'success');
                }
            });
        }
    });
}

function proceedToPayment() {
    Swal.fire({
        title: 'Proceed to Payment',
        text: 'You will be redirected to the payment page.',
        icon: 'success',
        confirmButtonText: 'Continue',
        confirmButtonColor: '#8B5CF6'
    }).then(result => {
        if (result.isConfirmed) {
            window.location.href = 'checkout.php';
        }
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
    width: 100%;
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