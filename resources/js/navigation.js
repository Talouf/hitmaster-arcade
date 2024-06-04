// resources/js/navigation.js

document.getElementById('profileButton').addEventListener('click', function () {
    var profileMenu = document.getElementById('profileMenu');
    profileMenu.classList.toggle('hidden');
});

document.addEventListener('click', function (event) {
    var profileButton = document.getElementById('profileButton');
    var profileMenu = document.getElementById('profileMenu');
    if (!profileButton.contains(event.target) && !profileMenu.contains(event.target)) {
        profileMenu.classList.add('hidden');
    }
});

// resources/js/navigation.js

document.addEventListener("DOMContentLoaded", function () {
    window.addToCart = function (productId) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/cart/add/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                quantity: 1 // or any quantity you want to pass
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                // Update the cart icon count here
                document.getElementById('cart-count').innerText = data.cart_count;
            } else {
                alert('Failed to add to cart');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    window.removeFromCart = function (productId) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/cart/remove/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                // Update the cart icon count here
                document.getElementById('cart-count').innerText = data.cart_count;
            } else {
                alert('Failed to remove from cart');
            }
        })
        .catch(error => console.error('Error:', error));
    }
});
