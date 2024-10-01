import { showNotification } from './utils';

document.addEventListener('DOMContentLoaded', function () {
    setupCart();
    fetchCartCount();
});

function setupCart() {
    // Add event listener for the remove buttons
    document.querySelectorAll('.remove-btn').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');
            removeFromCart(productId);
        });
    });
}

window.addToCart = function (productId) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ quantity: 1 })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            updateCartCount(data.cartCount);
            updateTotalProducts(data.totalProducts);
            updateDropdownCart(data.cartItems);
        } else {
            showNotification('Failed to add to cart', 'error');
        }
    })
    .catch(error => console.error('Error:', error));
}

window.removeFromCart = function (productId) {
    const quantityDropdown = document.getElementById(`quantity-${productId}`);
    const quantityToRemove = quantityDropdown ? parseInt(quantityDropdown.value) : 1; // Get the selected quantity
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/cart/remove/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ quantity: quantityToRemove }) // Send the selected quantity to the server
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartDisplay(productId, data.remainingQuantity);
            updateCartCount(data.cartCount);
            updateTotalProducts(data.totalProducts);
            updateDropdownCart(data.cartItems);
            updateCartTotal(data.cartTotal);
            checkEmptyCart(data.cartCount);
        } else {
            showNotification('Failed to remove from cart', 'error');
        }
    })
    .catch(error => console.error('Error:', error));
};

function fetchCartCount() {
    fetch('/cart/count', {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartCount(data.cartCount);
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateCartCount(count) {
    const cartCountElement = document.getElementById('cart-count');
    if (cartCountElement) {
        cartCountElement.innerText = count;
    }
}

function updateTotalProducts(totalProducts) {
    const totalProductsElement = document.getElementById('total-products');
    if (totalProductsElement) {
        totalProductsElement.innerText = totalProducts;
    }
}

function updateDropdownCart(cartItems) {
    const dropdownCart = document.getElementById('dropdownCart');
    if (!dropdownCart) return;

    dropdownCart.innerHTML = '';
    cartItems.forEach(item => {
        const cartItem = document.createElement('div');
        cartItem.className = 'cart-item';
        cartItem.innerHTML = `
            <div>${item.product.name}</div>
            <div>${item.quantity} x ${item.product.price}</div>
        `;
        dropdownCart.appendChild(cartItem);
    });

    const total = cartItems.reduce((sum, item) => sum + item.quantity * item.product.price, 0);
    const totalElement = document.createElement('div');
    totalElement.className = 'cart-total';
    totalElement.innerHTML = `Total: ${total}`;
    dropdownCart.appendChild(totalElement);
}

function updateCartDisplay(productId, newQuantity) {
    const cartItemRow = document.getElementById(`cart-item-${productId}`);
    if (!cartItemRow) return;

    if (newQuantity > 0) {
        const quantityCell = cartItemRow.querySelector('.quantity');
        const priceCell = cartItemRow.querySelector('td:nth-child(3)');
        const totalCell = cartItemRow.querySelector('td:nth-child(4)');

        if (quantityCell) quantityCell.textContent = newQuantity;
        if (priceCell && totalCell) {
            const price = parseFloat(priceCell.textContent);
            totalCell.textContent = (newQuantity * price).toFixed(2);
        }
    } else {
        cartItemRow.remove();
    }

    updateTotalProductsFromDOM();
}

function updateTotalProductsFromDOM() {
    const totalProductsElement = document.getElementById('total-products');
    const cartTotalElement = document.getElementById('cart-total');

    if (totalProductsElement && cartTotalElement) {
        const quantityElements = document.querySelectorAll('.quantity');
        let newTotalProducts = 0;
        let newCartTotal = 0;

        quantityElements.forEach(quantityElement => {
            const quantity = parseInt(quantityElement.textContent);
            const cartItemRow = quantityElement.closest('tr');
            const priceCell = cartItemRow.querySelector('td:nth-child(3)');
            const price = parseFloat(priceCell.textContent);

            newTotalProducts += quantity;
            newCartTotal += quantity * price;
        });

        totalProductsElement.textContent = newTotalProducts;
        cartTotalElement.textContent = newCartTotal.toFixed(2);
    }
}

function checkEmptyCart(cartCount) {
    if (Number(cartCount) === 0) {
        const cartTable = document.querySelector('.table-auto');
        if (cartTable) {
            const emptyCartMessage = document.createElement('p');
            emptyCartMessage.textContent = 'Votre panier est vide.';
            emptyCartMessage.className = 'text-lg';
            cartTable.parentNode.replaceChild(emptyCartMessage, cartTable);
        }

        // Remove total amount
        const cartTotalContainer = document.getElementById('cart-total-container');
        if (cartTotalContainer) {
            cartTotalContainer.remove();
        }

        // Remove checkout button
        const checkoutForm = document.getElementById('checkout-form');
        if (checkoutForm) {
            checkoutForm.remove();
        }
    }
}

function updateCartTotal(total) {
    const cartTotalElement = document.getElementById('cart-total');
    if (cartTotalElement) {
        cartTotalElement.textContent = total.toFixed(2);
    }
}