@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">{{ $product->name }}</h1>
    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="mb-4 w-full max-w-md mx-auto">
    <p class="text-xl mb-2">Prix: {{ $product->price }}€</p>
    <p class="mb-4 text-sm">{{ $product->description }}</p>

    @if($inStock)
        <p class="text-green-600 mb-4 text-sm">En stock: {{ $product->stock_quantity }} unités disponibles</p>
        <button onclick="addToCart({{ $product->id }})"
            class="bg-blue-500 text-white px-4 py-2 rounded w-full max-w-md mx-auto block">Ajouter au panier</button>
    @else
        <p class="text-red-600 mb-4 text-sm">Rupture de stock</p>
    @endif
</div>

<div class="mt-8 px-4 max-w-4xl mx-auto">
    <h3 class="text-xl font-bold mb-4 text-white">Reviews</h3>
    <div id="reviews-container" class="space-y-4">
        @foreach ($product->reviews->take(3) as $review)
            <div class="bg-gray-800 p-3 rounded shadow">
                <p class="mb-2 text-sm text-gray-300">{{ Str::limit($review->content, 150) }}</p>
                <div class="flex justify-between items-center text-xs text-gray-400">
                    <span>{{ $review->user->name }}</span>
                    <span>Rating: {{ $review->rating }}/5</span>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4 flex justify-center space-x-4">
        @if ($product->reviews->count() > 3)
            <button id="load-more-reviews" class="bg-gray-700 text-white px-4 py-2 rounded text-sm">Show More
                Reviews</button>
        @endif
        <button id="show-less-reviews" class="bg-gray-700 text-white px-4 py-2 rounded text-sm hidden">Show
            Less</button>
    </div>
</div>

@auth
    @if(
                Auth::user()->orders()->whereHas('orderItems', function ($query) use ($product) {
                    $query->where('product_id', $product->id);
                })->exists()
            )
        <div class="mt-8 px-4 max-w-4xl mx-auto">
            <h3 class="text-xl font-bold mb-4 text-white">Write a Review</h3>
            <form id="review-form" class="bg-gray-800 p-4 rounded">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="mb-4">
                    <label for="rating" class="block mb-2 text-sm text-gray-300">Rating</label>
                    <select name="rating" id="rating" class="w-full p-2 border rounded bg-gray-700 text-white text-sm">
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="mb-4">
                    <label for="content" class="block mb-2 text-sm text-gray-300">Review</label>
                    <textarea name="content" id="content" rows="4"
                        class="w-full p-2 border rounded bg-gray-700 text-white text-sm"></textarea>
                </div>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded text-sm w-full">Submit Review</button>
            </form>
            <div id="review-message" class="mt-4 text-center"></div>
        </div>
    @endif
@endauth
</div>

<script>
    function addToCart(productId) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/cart/add/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ quantity: 1 })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Product added to cart');
                    const cartCountElement = document.getElementById('cart-count');
                    if (cartCountElement) {
                        cartCountElement.textContent = data.cartCount;
                    }
                } else {
                    alert('Error adding product to cart: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error adding product to cart');
            });
    }

    // Load more reviews functionality
    document.addEventListener('DOMContentLoaded', function () {
        const loadMoreButton = document.getElementById('load-more-reviews');
        const showLessButton = document.getElementById('show-less-reviews');
        const reviewsContainer = document.getElementById('reviews-container');
        let offset = 3;
        const limit = 3;
        const initialReviewCount = {{ $product->reviews->count() }};

        function createReviewElement(review) {
            const reviewElement = document.createElement('div');
            reviewElement.className = 'bg-gray-800 p-3 rounded shadow';
            reviewElement.innerHTML = `
            <p class="mb-2 text-sm text-gray-300">${review.content.length > 150 ? review.content.substring(0, 150) + '...' : review.content}</p>
            <div class="flex justify-between items-center text-xs text-gray-400">
                <span>${review.user.name}</span>
                <span>Rating: ${review.rating}/5</span>
            </div>
        `;
            return reviewElement;
        }

        if (loadMoreButton) {
            loadMoreButton.addEventListener('click', function () {
                fetch(`/products/{{ $product->id }}/reviews?offset=${offset}&limit=${limit}`)
                    .then(response => response.json())
                    .then(data => {
                        data.reviews.forEach(review => {
                            reviewsContainer.appendChild(createReviewElement(review));
                        });

                        offset += limit;
                        if (offset >= initialReviewCount) {
                            loadMoreButton.style.display = 'none';
                        }
                        showLessButton.classList.remove('hidden');
                    })
                    .catch(error => console.error('Error:', error));
            });
        }

        if (showLessButton) {
            showLessButton.addEventListener('click', function () {
                const reviews = reviewsContainer.children;
                for (let i = reviews.length - 1; i >= 3; i--) {
                    reviews[i].remove();
                }
                offset = 3;
                loadMoreButton.style.display = 'inline-block';
                showLessButton.classList.add('hidden');
            });
        }
    });
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('review-form');
        const messageDiv = document.getElementById('review-message');

        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(form);

                fetch('{{ route('reviews.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            messageDiv.textContent = data.message;
                            messageDiv.className = 'mt-4 text-center text-green-500';
                            form.reset();
                        } else if (data.error) {
                            messageDiv.textContent = data.error;
                            messageDiv.className = 'mt-4 text-center text-red-500';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        messageDiv.textContent = 'An error occurred. Please try again.';
                        messageDiv.className = 'mt-4 text-center text-red-500';
                    });
            });
        }
    });
</script>
@endsection