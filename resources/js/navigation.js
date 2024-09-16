document.addEventListener('DOMContentLoaded', function () {
    // Profile menu toggling
    setupProfileMenu('profileButton', 'profileMenu');
    setupProfileMenu('mobileProfileButton', 'mobileProfileMenu');

    // Mobile menu toggling
    document.getElementById('menuButton').addEventListener('click', function () {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    });

    // Search functionality
    setupSearch();

    // Cart functionality
    setupCart();

    // Fetch initial cart count
    fetchCartCount();
});

function setupProfileMenu(buttonId, menuId) {
    const button = document.getElementById(buttonId);
    const menu = document.getElementById(menuId);

    button.addEventListener('click', () => menu.classList.toggle('hidden'));

    document.addEventListener('click', (event) => {
        if (!button.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });
}

function setupSearch() {
    const searchInput = document.getElementById('searchInput');
    const searchIcon = document.getElementById('searchIcon');
    const searchButton = document.getElementById('searchButton');

    searchInput.addEventListener('focus', () => searchInput.classList.add('w-64'));
    searchInput.addEventListener('blur', () => searchInput.classList.remove('w-64'));

    searchIcon.addEventListener('click', () => {
        searchInput.classList.toggle('w-0');
        searchInput.classList.toggle('w-48');
        searchButton.classList.toggle('hidden');
        searchInput.focus();
    });
}

function setupCart() {
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

    window.removeFromCart = function (productId, quantityToRemove) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/cart/remove/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ quantity: parseInt(quantityToRemove) })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartDisplay(productId, data.remainingQuantity);
                    updateCartCount(data.cartCount);
                    updateTotalProducts(data.totalProducts);
                    updateDropdownCart(data.cartItems);
                    checkEmptyCart(data.cartCount);
                } else {
                    showNotification('Failed to remove from cart', 'error');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Setup quantity change listeners
    document.querySelectorAll('select[id^="quantity-"]').forEach(function (selectElement) {
        selectElement.addEventListener('change', function () {
            const productId = this.id.split('-')[1];
            const newQuantity = parseInt(this.value);
            updateCartDisplay(productId, newQuantity);
        });
    });
}

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

        // Update quantity dropdown
        const quantityDropdown = document.getElementById(`quantity-${productId}`);
        if (quantityDropdown) {
            quantityDropdown.innerHTML = Array.from({ length: newQuantity }, (_, i) =>
                `<option value="${i + 1}">${i + 1}</option>`
            ).join('');
        }
    } else {
        cartItemRow.remove();
    }

    updateTotalProductsFromDOM();
}

function updateTotalProductsFromDOM() {
    const totalProductsElement = document.getElementById('total-products');
    if (totalProductsElement) {
        const newTotal = Array.from(document.querySelectorAll('.quantity'))
            .reduce((acc, el) => acc + parseInt(el.textContent), 0);
        totalProductsElement.textContent = newTotal;
    }
}

function checkEmptyCart(cartCount) {
    if (cartCount === 0) {
        const cartTable = document.querySelector('.table-auto');
        if (cartTable) {
            const emptyCartMessage = document.createElement('p');
            emptyCartMessage.textContent = 'Votre panier est vide.';
            emptyCartMessage.className = 'text-lg';
            cartTable.replaceWith(emptyCartMessage);
        }
    }
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerText = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.add('fade-out');
        setTimeout(() => notification.remove(), 500);
    }, 3000);
}