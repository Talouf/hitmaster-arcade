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
                // Optionally, update the cart icon count here
            } else {
                alert('Failed to add to cart');
            }
        })
        .catch(error => console.error('Error:', error));
    }
});
