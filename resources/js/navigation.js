document.addEventListener('click', function (event) {
    var profileButton = document.getElementById('profileButton');
    var profileMenu = document.getElementById('profileMenu');
    if (!profileButton.contains(event.target) && !profileMenu.contains(event.target)) {
        profileMenu.classList.add('hidden');
    }

    var mobileProfileButton = document.getElementById('mobileProfileButton');
    var mobileProfileMenu = document.getElementById('mobileProfileMenu');
    if (!mobileProfileButton.contains(event.target) && !mobileProfileMenu.contains(event.target)) {
        mobileProfileMenu.classList.add('hidden');
    }
});

document.getElementById('profileButton').addEventListener('click', function () {
    var profileMenu = document.getElementById('profileMenu');
    profileMenu.classList.toggle('hidden');
});

document.getElementById('mobileProfileButton').addEventListener('click', function () {
    var mobileProfileMenu = document.getElementById('mobileProfileMenu');
    mobileProfileMenu.classList.toggle('hidden');
});

document.getElementById('menuButton').addEventListener('click', function () {
    var mobileMenu = document.getElementById('mobileMenu');
    mobileMenu.classList.toggle('hidden');
});

document.addEventListener("DOMContentLoaded", function () {
    fetchCartCount(); // Fetch the initial cart count when the page loads

    window.addToCart = function (productId) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/cart/add/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                quantity: 1
            })
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
                    const itemRow = document.getElementById(`cart-item-${productId}`);
                    const quantityCell = itemRow.querySelector('.quantity');
                    const newQuantity = data.remainingQuantity;
    
                    if (newQuantity > 0) {
                        quantityCell.innerText = newQuantity;
                    } else {
                        itemRow.remove();
                    }
    
                    updateCartCount(data.cartCount);
                    updateTotalProducts(data.totalProducts);
                    updateDropdownCart(data.cartItems); 
                } else {
                    alert('Failed to remove from cart');
                }
            })
            .catch(error => console.error('Error:', error));
    }
    function fetchCartCount() {
        fetch('/cart/count', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(data.cartCount);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function updateTotalProducts(totalProducts) {
        const totalProductsElement = document.getElementById('total-products');
        if (totalProductsElement) {
            totalProductsElement.innerText = totalProducts;
        } else {
            console.warn('Element with ID "total-products" not found.');
        }
    }

    function updateCartCount(count) {
        const cartCountElement = document.getElementById('cart-count');
        if (cartCountElement) {
            cartCountElement.innerText = count;
        }
    }

    function updateDropdownCart(cartItems) {
        const dropdownCart = document.getElementById('dropdownCart');
        if (!dropdownCart) return;

        dropdownCart.innerHTML = ''; // Clear the current content

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

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerText = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.add('fade-out');
            setTimeout(() => {
                notification.remove();
            }, 2000);
        }, 2000);
    }
});